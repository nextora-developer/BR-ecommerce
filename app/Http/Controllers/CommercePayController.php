<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommercePayController extends Controller
{
    /**
     * 1) 用户下单后进这里
     * 2) 调 CommercePay RequestPayment
     * 3) redirect 去 hosted payment page
     */
    public function pay(Order $order)
    {
        abort_unless(auth()->check(), 403);
        abort_if($order->user_id !== auth()->id(), 403);

        if ($order->payment_method_code !== 'commercepay') {
            return redirect()
                ->route('checkout.success', $order)
                ->with('error', 'This order is not using CommercePay.');
        }

        // 已付款就别再初始化
        if (($order->payment_status ?? null) === 'paid') {
            return redirect()->route('checkout.success', $order);
        }

        try {
            $baseUrl  = rtrim(config('services.commercepay.base_url'), '/');
            $username = config('services.commercepay.username');
            $password = config('services.commercepay.password');
            $tenantId = config('services.commercepay.tenant_id');
            $secret   = config('services.commercepay.secret_key');
            $currency = config('services.commercepay.currency', 'MYR');

            if (!$baseUrl || !$username || !$password || !$tenantId || !$secret) {
                return redirect()
                    ->route('checkout.success', $order)
                    ->with('error', 'CommercePay configuration is incomplete.');
            }

            /**
             * Step 1: Authenticate
             *
             * CommercePay docs list tenant/account credentials and separate test/live accounts.
             * Base URLs shown in their API docs are staging:
             * https://staging-payments.commerce.asia
             * production:
             * https://payments.commerce.asia
             */
            $authResponse = Http::acceptJson()->post(
                $baseUrl . '/api/TokenAuth/Authenticate',
                [
                    'userNameOrEmailAddress' => $username,
                    'password' => $password,
                    'rememberClient' => true,
                ]
            );

            if (!$authResponse->successful()) {
                Log::error('CommercePay auth failed', [
                    'order_no' => $order->order_no,
                    'status'   => $authResponse->status(),
                    'body'     => $authResponse->body(),
                ]);

                return redirect()
                    ->route('checkout.success', $order)
                    ->with('error', 'Unable to connect to payment gateway.');
            }

            $accessToken = data_get($authResponse->json(), 'result.accessToken')
                ?? data_get($authResponse->json(), 'accessToken');

            if (!$accessToken) {
                Log::error('CommercePay accessToken missing', [
                    'order_no' => $order->order_no,
                    'body'     => $authResponse->json(),
                ]);

                return redirect()
                    ->route('checkout.success', $order)
                    ->with('error', 'Payment gateway token missing.');
            }

            /**
             * Step 2: Build RequestPayment payload
             *
             * RequestPayment supports returnUrl, callbackUrl, amount, currencyCode,
             * referenceCode, description and customer info.
             */
            $payload = [
                // Hosted Web 可不传 channelId，后面在 hosted page 选
                'currencyCode' => $currency,
                'amount' => (int) round(((float) $order->total) * 100), // 最小单位，按 docs 常见示例处理
                'referenceCode' => $order->order_no,
                'description' => 'Order ' . $order->order_no,
                'ipAddress' => request()->ip(),
                'userAgent' => (string) request()->userAgent(),
                'returnUrl' => route('commercepay.return', $order),
                'callbackUrl' => route('commercepay.callback'),
                'savePayment' => false,
                'customer' => [
                    'email' => $order->customer_email,
                    'mobileNo' => $order->customer_phone,
                    'name' => $order->customer_name,
                    'username' => (string) $order->user_id,
                ],
                'timestamp' => now()->timestamp,
            ];

            /**
             * cap-signature
             *
             * CommercePay docs require cap-signature header.
             * This implementation uses a simple HMAC placeholder based on JSON body.
             * If your merchant onboarding docs specify a different canonical string,
             * replace this method with the exact required signing algorithm.
             */
            $signature = $this->signRequestPayload($payload, $secret);

            $paymentResponse = Http::acceptJson()
                ->withToken($accessToken)
                ->withHeaders([
                    'Abp-TenantId' => $tenantId,
                    'cap-signature' => $signature,
                    'Content-Type' => 'application/json',
                ])
                ->post(
                    $baseUrl . '/api/services/app/PaymentGateway/RequestPayment',
                    $payload
                );

            if (!$paymentResponse->successful()) {
                Log::error('CommercePay RequestPayment failed', [
                    'order_no' => $order->order_no,
                    'status'   => $paymentResponse->status(),
                    'body'     => $paymentResponse->body(),
                ]);

                return redirect()
                    ->route('checkout.success', $order)
                    ->with('error', 'Unable to initialize CommercePay payment.');
            }

            $data = $paymentResponse->json();
            $result = $data['result'] ?? $data;

            $redirectUrl = $result['redirectUrl'] ?? null;
            $transactionNumber = $result['transactionNumber'] ?? null;

            // 建议 orders 表先有这些字段
            $order->gateway_reference = $transactionNumber;
            $order->gateway_response = $result;
            $order->payment_status = $order->payment_status ?: 'pending';
            $order->save();

            if ($redirectUrl) {
                return redirect()->away($redirectUrl);
            }

            Log::error('CommercePay redirectUrl missing', [
                'order_no' => $order->order_no,
                'result'   => $result,
            ]);

            return redirect()
                ->route('checkout.success', $order)
                ->with('error', 'Payment URL was not returned by CommercePay.');
        } catch (\Throwable $e) {
            Log::error('CommercePay pay exception', [
                'order_no' => $order->order_no,
                'message'  => $e->getMessage(),
            ]);

            return redirect()
                ->route('checkout.success', $order)
                ->with('error', 'Unable to start CommercePay payment.');
        }
    }

    /**
     * Browser returnUrl
     * 不在这里直接定 paid，先导去 pending 页面等状态确认
     */
    public function return(Order $order)
    {
        abort_unless(auth()->check(), 403);
        abort_if($order->user_id !== auth()->id(), 403);

        if (($order->payment_status ?? null) === 'paid') {
            return redirect()->route('checkout.success', $order);
        }

        return redirect()->route('payment.pending', $order);
    }

    /**
     * 给前端轮询状态
     */
    public function status(Order $order)
    {
        abort_unless(auth()->check(), 403);
        abort_if($order->user_id !== auth()->id(), 403);

        return response()->json([
            'order_no' => $order->order_no,
            'status' => $order->status,
            'payment_status' => $order->payment_status ?? 'pending',
            'redirect' => ($order->payment_status ?? null) === 'paid'
                ? route('checkout.success', $order)
                : null,
        ]);
    }

    /**
     * 简单 pending 页面
     */
    public function pending(Order $order)
    {
        abort_unless(auth()->check(), 403);
        abort_if($order->user_id !== auth()->id(), 403);

        if (($order->payment_status ?? null) === 'paid') {
            return redirect()->route('checkout.success', $order);
        }

        return view('payment.pending', compact('order'));
    }

    /**
     * CommercePay host-to-host callback
     * 真正更新订单状态的地方
     */
    public function callback(Request $request)
    {
        $payload = $request->all();
        $signature = (string) $request->header('cap-signature', '');

        Log::info('CommercePay callback received', [
            'payload' => $payload,
            'signature' => $signature,
        ]);

        $referenceCode = $payload['referenceCode'] ?? null;
        $transactionNumber = $payload['transactionNumber'] ?? null;
        $status = $payload['status'] ?? null;

        if (!$referenceCode) {
            return response()->json(['message' => 'referenceCode missing'], 422);
        }

        $order = Order::where('order_no', $referenceCode)->first();

        if (!$order) {
            return response()->json(['message' => 'order not found'], 404);
        }

        // 验签
        if (!$this->verifyCallbackSignature($request, $payload, $signature)) {
            Log::warning('CommercePay callback signature invalid', [
                'order_no' => $referenceCode,
                'payload'  => $payload,
            ]);

            return response()->json(['message' => 'invalid signature'], 401);
        }

        // 幂等：已付过就直接 OK
        if (($order->payment_status ?? null) === 'paid') {
            return response()->json(['message' => 'already processed']);
        }

        /**
         * CommercePay callback docs sample shows status as integer.
         * Commonly success = 1.
         * 你也可以按你拿到的实际文档改成更精确的映射。
         */
        $isSuccess = (string) $status === '1' || strtolower((string) $status) === 'success';

        $order->gateway_reference = $transactionNumber ?: $order->gateway_reference;
        $order->gateway_callback = $payload;

        if ($isSuccess) {
            $order->payment_status = 'paid';
            $order->status = 'processing';
            $order->paid_at = now();
            $order->save();

            // 成功后再发邮件
            $this->sendOrderEmails($order);

            return response()->json(['message' => 'ok']);
        }

        $order->payment_status = 'failed';
        $order->save();

        return response()->json(['message' => 'failed']);
    }

    /**
     * RequestPayment 签名
     * 这里只是占位实现，正式上线请按你 CommercePay merchant docs 的 canonical rule 替换
     */
    protected function signRequestPayload(array $payload, string $secret): string
    {
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return hash_hmac('sha256', $json, $secret);
    }

    /**
     * Callback 验签
     *
     * CommercePay callback docs show example of building signature from:
     * callbackUrl + normalized json body, then HMACSHA256 with secret key.
     * 这里按该思路实现一个常用版本；如果你的正式商户文档 canonical 规则不同，请替换。
     */
    protected function verifyCallbackSignature(Request $request, array $payload, string $headerSignature): bool
    {
        $secret = (string) config('services.commercepay.secret_key');
        if (!$secret || !$headerSignature) {
            return false;
        }

        $callbackUrl = route('commercepay.callback');

        $normalized = [
            'amount' => isset($payload['amount']) ? (int) $payload['amount'] : null,
            'channelid' => isset($payload['channelId']) ? (int) $payload['channelId'] : null,
            'currencycode' => isset($payload['currencyCode']) ? strtolower((string) $payload['currencyCode']) : null,
            'providerTransactionNumber' => $payload['providerTransactionNumber'] ?? null,
            'referencecode' => isset($payload['referenceCode']) ? strtolower((string) $payload['referenceCode']) : null,
            'status' => isset($payload['status']) ? (int) $payload['status'] : null,
            'transactionnumber' => isset($payload['transactionNumber']) ? strtolower((string) $payload['transactionNumber']) : null,
        ];

        $normalized = array_filter($normalized, fn ($v) => $v !== null);

        $json = json_encode($normalized, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $base = $callbackUrl . $json;
        $calculated = hash_hmac('sha256', $base, $secret);

        return hash_equals(strtolower($headerSignature), strtolower($calculated));
    }

    protected function sendOrderEmails(Order $order): void
    {
        if ($order->customer_email) {
            try {
                Mail::to($order->customer_email)->send(new OrderPlacedMail($order));
            } catch (\Throwable $e) {
                Log::error('CommercePay customer mail failed', [
                    'order_no' => $order->order_no,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        $admin = config('mail.admin_address');
        if ($admin) {
            try {
                Mail::to($admin)->send(new AdminOrderNotificationMail($order));
            } catch (\Throwable $e) {
                Log::error('CommercePay admin mail failed', [
                    'order_no' => $order->order_no,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }
}