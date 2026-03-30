<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class CommercePayService
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;
    protected string $tenantId;
    protected string $secretKey;
    protected string $currency;

    public function __construct()
    {
        $this->baseUrl   = rtrim(config('services.commercepay.base_url'), '/');
        $this->username  = config('services.commercepay.username');
        $this->password  = config('services.commercepay.password');
        $this->tenantId  = config('services.commercepay.tenant_id');
        $this->secretKey = config('services.commercepay.secret_key');
        $this->currency  = config('services.commercepay.currency', 'MYR');
    }

    public function authenticate(): string
    {
        $url = $this->baseUrl . '/api/TokenAuth/Authenticate';

        $response = Http::acceptJson()
            ->post($url, [
                'userNameOrEmailAddress' => $this->username,
                'password' => $this->password,
                'rememberClient' => true,
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('CommercePay auth failed: ' . $response->body());
        }

        $token = data_get($response->json(), 'result.accessToken')
            ?? data_get($response->json(), 'accessToken');

        if (!$token) {
            throw new RuntimeException('CommercePay access token missing.');
        }

        return $token;
    }

    protected function makeSignature(array $payload): string
    {
        // 这里先用最通用写法；你需要按 CommercePay 文档的正式签名算法调整
        $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return hash_hmac('sha256', $json, $this->secretKey);
    }

    public function requestPayment(array $payload): array
    {
        $token = $this->authenticate();
        $signature = $this->makeSignature($payload);

        $url = $this->baseUrl . '/api/services/app/PaymentGateway/RequestPayment';

        $response = Http::acceptJson()
            ->withToken($token)
            ->withHeaders([
                'Abp-TenantId'   => $this->tenantId,
                'cap-signature' => $signature,
                'Content-Type'  => 'application/json',
            ])
            ->post($url, $payload);

        if (!$response->successful()) {
            throw new RuntimeException('CommercePay request payment failed: ' . $response->body());
        }

        return $response->json();
    }

    public function buildPaymentPayload($order): array
    {
        return [
            // Hosted Web 可先不传 channelId
            'currencyCode' => $this->currency,
            'amount' => (int) round($order->grand_total * 100), // 文档示例显示金额通常用最小单位
            'referenceCode' => $order->order_no,
            'description' => 'Order #' . $order->order_no,
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent(),
            'returnUrl' => route('commercepay.return'),
            'callbackUrl' => route('commercepay.callback'),
            'savePayment' => false,
            'customer' => [
                'email' => $order->email,
                'mobileNo' => $order->phone,
                'name' => $order->name,
                'username' => $order->email,
            ],
            'timestamp' => now()->timestamp,
        ];
    }
}
