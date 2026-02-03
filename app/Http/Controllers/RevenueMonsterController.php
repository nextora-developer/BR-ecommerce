<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RevenueMonsterController extends Controller
{
    /**
     * Create Hosted Payment Checkout
     * POST https://(sb-)open.revenuemonster.my/v3/payment/online
     */
    public function pay(Order $order)
    {
        abort_unless(auth()->check(), 403);

        if (!empty($order->user_id)) {
            abort_unless((int) $order->user_id === (int) auth()->id(), 403);
        }

        if (strtolower((string) $order->status) !== 'pending') {
            return redirect()
                ->route('account.orders.show', $order)
                ->with('error', 'This order is not payable.');
        }

        // ✅ Amount (cents)
        $amountCents = (int) round(((float) ($order->total ?? 0)) * 100);

        Log::info('RM amount debug', [
            'order_no'         => $order->order_no,
            'total_raw'        => $order->total,
            'total_float'      => (float) $order->total,
            'amount_cents'     => $amountCents,
        ]);

        if ($amountCents <= 0) {
            Log::error('RM amount invalid', [
                'order_no' => $order->order_no,
                'total'    => $order->total,
            ]);
            return back()->with('error', 'Order amount invalid. Please contact support.');
        }

        // ✅ RM requires order.id to be 24 chars
        if (empty($order->rm_order_id_24)) {
            $order->rm_order_id_24 = $this->generateRmOrderId24();
            $order->save();
        }

        $rmOrderId = $order->rm_order_id_24; // exactly 24 chars

        // ✅ Config
        $storeId    = (string) config('services.rm.store_id');
        $apiBase    = (string) config('services.rm.api_base');
        $returnUrl  = (string) config('services.rm.return_url');
        $webhookUrl = (string) config('services.rm.webhook_url');

        // ✅ OAuth token
        $accessToken = $this->rmAccessToken();

        Log::info('RM config snapshot', [
            'store_id'       => $storeId,
            'api_base'       => $apiBase,
            'return_url'     => $returnUrl,
            'webhook_url'    => $webhookUrl,
            'order_no'       => $order->order_no,
            'rm_order_id_24' => $rmOrderId,
            'amount_cents'   => $amountCents,
        ]);

        // ✅ Payload
        $payload = [
            'storeId'       => $storeId,
            'redirectUrl' => $returnUrl . '?order_no=' . urlencode($order->order_no),
            'notifyUrl'     => $webhookUrl,
            'layoutVersion' => 'v4',
            'type'          => 'WEB_PAYMENT',
            'order' => [
                'id'             => $rmOrderId,
                'title'          => Str::limit('Order ' . $order->order_no, 32, ''),
                'currencyType'   => 'MYR',
                'amount'         => $amountCents,
                'detail'         => null,
                'additionalData' => (string) $order->order_no,
            ],
            'customer' => [
                'email'       => $order->customer_email ?? $order->email ?? null,
                'countryCode' => '60',
                'phoneNumber' => $order->customer_phone ?? $order->phone ?? null,
            ],
        ];

        $endpoint  = rtrim($apiBase, '/') . '/v3/payment/online';
        $nonceStr  = Str::random(32);
        $timestamp = (string) time();
        $signType  = 'sha256';

        Log::info('RM signing request', [
            'endpoint'    => $endpoint,
            'nonce_len'   => strlen($nonceStr),
            'timestamp'   => $timestamp,
            'sign_type'   => $signType,
            'payload_md5' => md5(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)),
        ]);

        // ✅ Signature body (base64), header must include "sha256 " prefix
        $signatureBody = $this->signRequest(
            payload: $payload,
            method: 'post',
            nonceStr: $nonceStr,
            timestamp: $timestamp,
            signType: $signType,
            requestUrl: $endpoint // ✅ full URL as RM doc
        );

        Log::info('RM signature generated', [
            'signature_len'   => strlen($signatureBody),
            'signature_head8' => substr($signatureBody, 0, 8),
            'signature_tail8' => substr($signatureBody, -8),
        ]);

        $headers = [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
            'X-Nonce-Str'   => $nonceStr,
            'X-Timestamp'   => $timestamp,
            'X-Sign-Type'   => $signType,
            'X-Signature'   => strtolower($signType) . ' ' . $signatureBody,
        ];

        Log::info('RM request headers snapshot', [
            'has_auth'  => !empty($accessToken),
            'endpoint'  => $endpoint,
            'nonce'     => $nonceStr,
            'timestamp' => $timestamp,
        ]);

        $res  = Http::withHeaders($headers)->post($endpoint, $payload);
        $data = $res->json();

        Log::info('RM response snapshot', [
            'http'     => $res->status(),
            'ok'       => $res->ok(),
            'json'     => $data,
            'body'     => $res->body(),
            'order_no' => $order->order_no,
        ]);

        if (!$res->ok() || data_get($data, 'code') !== 'SUCCESS') {
            Log::error('RM create checkout failed', [
                'http'     => $res->status(),
                'json'     => $data,
                'order_no' => $order->order_no,
                'store_id' => $storeId,
            ]);

            return back()->with('error', data_get($data, 'error.message') ?? 'Unable to start payment.');
        }

        $redirectUrl = data_get($data, 'item.url');
        if (!$redirectUrl) {
            Log::error('RM missing item.url', ['json' => $data]);
            return back()->with('error', 'Unable to start payment.');
        }

        return redirect()->away($redirectUrl);
    }

    //Version 1
    // public function handleReturn(Request $request)
    // {
    //     $orderNo = $request->query('order_no');

    //     if (!$orderNo) {
    //         return redirect()
    //             ->route('account.orders.index')
    //             ->with('error', 'Missing order reference.');
    //     }

    //     $order = Order::where('order_no', $orderNo)->first();

    //     if (!$order) {
    //         return redirect()
    //             ->route('account.orders.index')
    //             ->with('error', 'Order not found.');
    //     }

    //     // ✅ 已经 paid（webhook 已来） -> success
    //     if (strtolower((string) $order->status) === 'paid') {
    //         return redirect()->route('checkout.success', $order);
    //     }

    //     // ✅ 没有 paid（用户退出来/没付） -> 直接 failed
    //     if (strtolower((string) $order->status) === 'pending') {
    //         $order->update(['status' => 'failed']);
    //     }

    //     return redirect()
    //         ->route('account.orders.index')
    //         ->with('error', 'Payment not completed. Order marked as failed.');
    // }


    //Version 2
    public function handleReturn(Request $request)
    {
        Log::info('RM RETURN HIT', [
            'order_no' => $request->query('order_no'),
            'ip'       => $request->ip(),
            'query'    => $request->query(),
        ]);

        $orderNo = $request->query('order_no');
        if (!$orderNo) {
            return redirect()->route('account.orders.index')
                ->with('error', 'Missing order reference.');
        }

        $order = Order::where('order_no', $orderNo)->first();
        if (!$order) {
            return redirect()->route('account.orders.index')
                ->with('error', 'Order not found.');
        }

        $localStatus    = strtolower((string) $order->status);
        $rmReturnStatus = strtoupper((string) $request->query('status', ''));

        Log::info('RM RETURN status snapshot', [
            'order_no' => $order->order_no,
            'local'    => $localStatus,
            'rm'       => $rmReturnStatus,
        ]);


        if ($rmReturnStatus !== '') {
            $order->forceFill([
                'rm_status' => $rmReturnStatus,
            ])->save();

            Log::info('RM RETURN stored rm_status', [
                'order_no'  => $order->order_no,
                'rm_status' => $rmReturnStatus,
            ]);
        }

        // ✅ 已经 paid（webhook 已处理）
        if ($localStatus === 'paid') {
            return redirect()->route('checkout.success', $order);
        }

        // ✅ 2) 只有 pending 才允许被 return 改成 failed（避免误伤）
        if ($localStatus === 'pending' && in_array($rmReturnStatus, ['FAILED', 'CANCELLED', 'EXPIRED'], true)) {
            $order->update(['status' => 'failed']);

            Log::warning('RM RETURN marked order failed (by rm status)', [
                'order_no' => $order->order_no,
                'rm'       => $rmReturnStatus,
            ]);

            return redirect()->route('account.orders.index')
                ->with('error', 'Payment not completed. Order marked as failed.');
        }

        return redirect()->route('account.orders.show', $order)
            ->with('info', 'Payment status is updating. Please refresh in a moment.');
    }



    public function handleWebhook(Request $request)
    {
        Log::info('RM webhook ARRIVED (raw)', [
            'ip'        => $request->ip(),
            'method'    => $request->method(),
            'headers'   => [
                'x-signature' => $request->header('x-signature'),
                'x-nonce-str' => $request->header('x-nonce-str'),
                'x-timestamp' => $request->header('x-timestamp'),
            ],
            'body_md5'  => md5($request->getContent()),
            'body_size' => strlen($request->getContent()),
        ]);

        Log::info('RM webhook headers', $request->headers->all());

        $rawBody = $request->getContent();
        $headers = $request->headers->all();
        $payload = $request->all();

        $skipVerify = (bool) config('services.rm.webhook_skip_verify', false);

        if (!$skipVerify) {
            if (!$this->verifySignatureCallback($rawBody, $headers)) {
                Log::warning('RM webhook signature invalid', ['payload' => $payload]);
                return response()->json(['message' => 'invalid signature'], 401);
            }
        } else {
            Log::warning('RM webhook signature verification SKIPPED (TEST ONLY)', [
                'ip' => $request->ip(),
            ]);
        }

        $storeIdExpected = (string) config('services.rm.store_id');
        $storeIdGot = (string) (data_get($payload, 'data.storeId') ?? data_get($payload, 'storeId') ?? '');
        if ($storeIdExpected !== '' && $storeIdGot !== '' && $storeIdGot !== $storeIdExpected) {
            Log::warning('RM webhook storeId mismatch', [
                'expected' => $storeIdExpected,
                'got'      => $storeIdGot,
            ]);
            return response()->json(['ok' => true]);
        }

        $order = null;

        $orderNo = (string) data_get($payload, 'data.order.additionalData', '');
        if ($orderNo !== '') {
            $order = Order::where('order_no', $orderNo)->first();
        }

        if (!$order) {
            $rmOrderId = (string) data_get($payload, 'data.order.id', '');
            if ($rmOrderId !== '') {
                $order = Order::where('rm_order_id_24', $rmOrderId)->first();
            }
        }

        if (!$order) {

            Log::warning('RM webhook ORDER NOT FOUND (summary)', [
                // 🔎 RM status
                'rm_status' => data_get($payload, 'data.status'),

                // 🔎 RM order identifiers
                'rm_order_id'   => data_get($payload, 'data.order.id'),
                'additional'    => data_get($payload, 'data.order.additionalData'),

                // 🔎 transaction info
                'transactionId' => data_get($payload, 'data.transactionId'),
                'referenceId'   => data_get($payload, 'data.referenceId'),
                'finalAmount'   => data_get($payload, 'data.finalAmount'),
                'currency'      => data_get($payload, 'data.currencyType'),

                // 🔎 payload structure（非常重要）
                'payload_keys'  => array_keys($payload),
                'data_keys'     => is_array(data_get($payload, 'data'))
                    ? array_keys($payload['data'])
                    : null,

                // 🔎 快速对照用
                'raw_md5' => md5($request->getContent()),
            ]);

            return response()->json(['ok' => true]);
        }


        if (strtolower((string) $order->status) === 'paid') {
            return response()->json(['ok' => true]);
        }

        // ✅ Only allow pending -> paid/failed
        if (!in_array(strtolower((string) $order->status), ['pending'], true)) {
            Log::info('RM webhook ignored (status not pending)', [
                'order_no' => $order->order_no,
                'status'   => $order->status,
            ]);
            return response()->json(['ok' => true]);
        }

        // ✅ Extract important RM fields (Notify payload spec)
        $rmStatus        = strtoupper((string) data_get($payload, 'data.status', ''));
        $rmTransactionId = (string) data_get($payload, 'data.transactionId', '');
        $rmReferenceId   = (string) data_get($payload, 'data.referenceId', '');
        $rmFinalAmount   = (int) data_get($payload, 'data.finalAmount', 0); // cents
        $rmCurrency      = (string) data_get($payload, 'data.currencyType', '');
        $rmTransactionAt = data_get($payload, 'data.transactionAt'); // RFC3339, only when SUCCESS

        // ✅ Idempotent by transactionId (avoid duplicated callbacks)
        if ($rmTransactionId && Order::where('rm_transaction_id', $rmTransactionId)->where('id', '!=', $order->id)->exists()) {
            Log::warning('RM webhook duplicate transactionId', ['transactionId' => $rmTransactionId]);
            return response()->json(['ok' => true]);
        }

        // ✅ Save RM info into order
        $order->forceFill([
            'rm_status'         => $rmStatus ?: null,
            'rm_transaction_id' => $rmTransactionId ?: null,
            'rm_reference_id'   => $rmReferenceId ?: null,
            'rm_final_amount'   => $rmFinalAmount > 0 ? $rmFinalAmount : null,
            'rm_currency'       => $rmCurrency ?: null,
            'rm_transaction_at' => $rmTransactionAt ? \Carbon\Carbon::parse($rmTransactionAt) : null,

            // optional
            'rm_raw_payload'    => $payload,
        ])->save();


        // ✅ 4) Status & amount validation
        $status      = strtoupper((string) (data_get($payload, 'data.status') ?? data_get($payload, 'status') ?? ''));
        $finalAmount = (int) (data_get($payload, 'data.finalAmount') ?? data_get($payload, 'finalAmount') ?? 0); // cents
        $expected    = (int) round(((float) ($order->total ?? 0)) * 100);

        if ($finalAmount > 0 && $finalAmount !== $expected) {
            Log::warning('RM finalAmount mismatch', [
                'order_no' => $order->order_no,
                'expected' => $expected,
                'got'      => $finalAmount,
                'status'   => $status,
            ]);
            return response()->json(['ok' => true]);
        }

        $success = ['SUCCESS'];
        $failed  = ['FAILED', 'CANCELLED', 'EXPIRED'];

        if (in_array($status, $success, true)) {
            $order->update([
                'status' => 'paid',
            ]);

            Log::info('RM order marked paid', [
                'order_no' => $order->order_no,
                'status'   => $status,
                'amount'   => $finalAmount,
            ]);

            $this->sendOrderEmailsSafely($order);
            return response()->json(['ok' => true]);
        }

        if (in_array($status, $failed, true)) {
            $order->update(['status' => 'failed']);

            Log::info('RM order marked failed', [
                'order_no' => $order->order_no,
                'status'   => $status,
                'amount'   => $finalAmount,
            ]);

            return response()->json(['ok' => true]);
        }

        Log::info('RM webhook ignored (unknown status)', [
            'order_no' => $order->order_no,
            'status'   => $status,
        ]);

        return response()->json(['ok' => true]);
    }

    private function generateRmOrderId24(): string
    {
        // RM + 22 random alphanumeric chars = 24 chars total
        return 'RM' . strtoupper(Str::random(22));
    }

    /**
     * OAuth: client_credentials -> accessToken (cached)
     */
    private function rmAccessToken(): string
    {
        return cache()->remember('rm_access_token', now()->addDays(25), function () {
            $clientId     = (string) config('services.rm.client_id');
            $clientSecret = (string) config('services.rm.client_secret');
            $oauthBase    = (string) config('services.rm.oauth_base');

            if (!$clientId || !$clientSecret) {
                throw new \RuntimeException('RM client_id / client_secret missing.');
            }

            $basic    = base64_encode($clientId . ':' . $clientSecret);
            $tokenUrl = rtrim($oauthBase, '/') . '/v1/token';

            $res = Http::asJson()
                ->withHeaders([
                    'Authorization' => 'Basic ' . $basic,
                ])
                ->post($tokenUrl, [
                    'grantType' => 'client_credentials',
                ]);

            $json = $res->json();

            if (!$res->ok() || empty($json['accessToken'])) {
                Log::error('RM OAuth token failed', [
                    'http' => $res->status(),
                    'json' => $json,
                    'body' => $res->body(),
                ]);
                throw new \RuntimeException('RM OAuth token failed.');
            }

            Log::info('RM OAuth token obtained', [
                'expiresIn' => $json['expiresIn'] ?? null,
            ]);

            return (string) $json['accessToken'];
        });
    }

    /**
     * Sign request (RSA SHA256) following RM convention
     */
    private function signRequest(
        array $payload,
        string $method,
        string $nonceStr,
        string $timestamp,
        string $signType,
        string $requestUrl // ✅ full URL
    ): string {
        $sorted = $this->ksortRecursive($payload);

        $compact = json_encode($sorted, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($compact === false) {
            throw new \RuntimeException('RM json_encode failed.');
        }

        // RM doc: replace special chars
        $compact = str_replace(
            ['<', '>', '&'],
            ['\u003c', '\u003e', '\u0026'],
            $compact
        );

        $dataB64 = base64_encode($compact);

        // IMPORTANT: param order
        $plain = 'data=' . $dataB64
            . '&method=' . strtolower($method)
            . '&nonceStr=' . $nonceStr
            . '&requestUrl=' . $requestUrl
            . '&signType=' . strtolower($signType)
            . '&timestamp=' . $timestamp;

        $privKey = $this->loadPrivateKeyForRm();

        $sig = '';
        $ok = openssl_sign($plain, $sig, $privKey, OPENSSL_ALGO_SHA256);

        if (!$ok || $sig === '') {
            throw new \RuntimeException('RM openssl_sign failed.');
        }

        return base64_encode($sig);
    }


    /**
     * Load private key safely from env/config
     */
    private function loadPrivateKeyForRm(): \OpenSSLAsymmetricKey
    {
        $k = (string) config('services.rm.private_key');
        if ($k === '') {
            throw new \RuntimeException('RM private key missing.');
        }

        $k = str_replace(["\r\n", "\r"], "\n", $k);
        $k = str_replace("\\n", "\n", $k);
        $k = trim($k, " \t\n\r\0\x0B\"'");

        $res = openssl_pkey_get_private($k);
        if ($res !== false) {
            return $res;
        }

        while ($m = openssl_error_string()) {
            Log::error('OpenSSL: ' . $m);
        }

        throw new \RuntimeException('RM private key invalid.');
    }

    private function loadPublicKeyForRm(): \OpenSSLAsymmetricKey
    {
        $k = (string) config('services.rm.public_key');
        if ($k === '') {
            throw new \RuntimeException('RM public key missing.');
        }

        // 统一换行 / 处理 env 里的 \n
        $k = str_replace(["\r\n", "\r"], "\n", $k);
        $k = str_replace("\\n", "\n", $k);
        $k = trim($k, " \t\n\r\0\x0B\"'");

        // ✅ 必须转成 OpenSSL key resource
        $res = openssl_pkey_get_public($k);
        if ($res !== false) return $res;

        while ($m = openssl_error_string()) {
            Log::error('OpenSSL(pub): ' . $m);
        }

        throw new \RuntimeException('RM public key invalid.');
    }


    private function sendOrderEmailsSafely(Order $order): void
    {
        // Customer
        if (!empty($order->customer_email)) {
            try {
                Mail::to($order->customer_email)->send(new OrderPlacedMail($order));
            } catch (\Throwable $e) {
                Log::error('RM: customer email failed', [
                    'order' => $order->order_no,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Admin
        $admin = (string) config('mail.admin_address');
        if (!empty($admin)) {
            try {
                Mail::to($admin)->send(new AdminOrderNotificationMail($order));
            } catch (\Throwable $e) {
                Log::error('RM: admin email failed', [
                    'order' => $order->order_no,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Verify RM webhook callback signature
     * - Follow RM doc param order
     * - Try both: whole body and body.data (RM versions differ)
     */
    private function verifySignatureCallback(string $rawBody, array $headers): bool
    {
        $nonceStr  = $this->headerValue($headers, 'x-nonce-str');
        $timestamp = $this->headerValue($headers, 'x-timestamp');
        $sigHeader = $this->headerValue($headers, 'x-signature');

        if (!$nonceStr || !$timestamp || !$sigHeader) return false;

        $sigHeader = trim($sigHeader);

        // x-signature: "sha256 <base64>" OR "<base64>"
        $signType = 'sha256';
        $signatureBody = $sigHeader;

        if (str_contains($sigHeader, ' ')) {
            [$maybeType, $b64] = explode(' ', $sigHeader, 2);
            $maybeType = strtolower(trim($maybeType));
            if ($maybeType !== '') $signType = $maybeType;
            $signatureBody = trim($b64);
        }

        $sigBin = base64_decode($signatureBody, true);
        if ($sigBin === false) return false;

        $decoded = json_decode($rawBody, true);
        if (!is_array($decoded)) return false;

        // ✅ 两种 JSON 编码：RM 端可能用默认（会把 / 变成 \/），也可能不转义 /
        $jsonFlagsList = [
            JSON_UNESCAPED_UNICODE, // 默认 slash 转义（最常见）
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES, // 不转义 slash
        ];

        $makeDataB64Variants = function (array $arr) use ($jsonFlagsList): array {
            $sorted = $this->ksortRecursive($arr);
            $out = [];

            foreach ($jsonFlagsList as $flags) {
                $compact = json_encode($sorted, $flags);
                if ($compact === false) continue;

                // RM doc: replace <>&
                $compact = str_replace(['<', '>', '&'], ['\u003c', '\u003e', '\u0026'], $compact);

                $out[] = base64_encode($compact);
            }

            return array_values(array_unique($out));
        };

        // RM 可能签 whole body 或只签 data
        $candidateBodies = [$decoded];
        if (isset($decoded['data']) && is_array($decoded['data'])) {
            $candidateBodies[] = $decoded['data'];
        }

        // callback 文档说 requestUrl 可以 skip，但有些实现会带（用你的 notifyUrl）
        $webhookUrl = 'https://brif.my/api/payment/rm/webhook';

        try {
            $pubKey = $this->loadPublicKeyForRm();
        } catch (\Throwable $e) {
            Log::error('RM public key load failed', ['err' => $e->getMessage()]);
            return false;
        }

        foreach ($candidateBodies as $bodyArr) {
            foreach ($makeDataB64Variants($bodyArr) as $dataB64) {

                // ✅ 文档顺序（带 signType）
                $plainA = 'data=' . $dataB64
                    . '&method=post'
                    . '&nonceStr=' . $nonceStr
                    . '&signType=' . strtolower($signType)
                    . '&timestamp=' . $timestamp;

                // ✅ 文档顺序（不带 signType）
                $plainB = 'data=' . $dataB64
                    . '&method=post'
                    . '&nonceStr=' . $nonceStr
                    . '&timestamp=' . $timestamp;

                // ✅ 少数情况 callback 也带 requestUrl（用你的 webhook url）
                $plainC = 'data=' . $dataB64
                    . '&method=post'
                    . '&nonceStr=' . $nonceStr
                    . '&signType=' . strtolower($signType)
                    . '&timestamp=' . $timestamp
                    . '&requestUrl=' . $webhookUrl;

                if (openssl_verify($plainA, $sigBin, $pubKey, OPENSSL_ALGO_SHA256) === 1) return true;
                if (openssl_verify($plainB, $sigBin, $pubKey, OPENSSL_ALGO_SHA256) === 1) return true;
                if (openssl_verify($plainC, $sigBin, $pubKey, OPENSSL_ALGO_SHA256) === 1) return true;
            }
        }

        Log::warning('RM verify failed meta', [
            'nonce' => $nonceStr,
            'ts' => $timestamp,
            'sig_prefix' => substr($signatureBody, 0, 12),
            'raw_md5' => md5($rawBody),
        ]);

        return false;
    }



    private function headerValue(array $headers, string $key): ?string
    {
        $keyLower = strtolower($key);

        foreach ($headers as $k => $vals) {
            if (strtolower($k) === $keyLower) {
                return is_array($vals) ? (string) ($vals[0] ?? null) : (string) $vals;
            }
        }

        return null;
    }

    private function ksortRecursive(array $data): array
    {
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $data[$k] = $this->ksortRecursive($v);
            }
        }

        ksort($data);

        return $data;
    }
}
