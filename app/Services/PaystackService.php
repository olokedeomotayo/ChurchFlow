<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaystackService
{
    /**
     * Paystack API base URL.
     */
    protected string $baseUrl = 'https://api.paystack.co';

    /**
     * Get Paystack secret key.
     */
    protected function secretKey(): string
    {
        $key = Setting::query()
            ->where('key', 'paystack_secret_key')
            ->value('value');

        if (!$key) {
            throw new RuntimeException(
                'Paystack secret key has not been configured.'
            );
        }

        return $key;
    }

    /**
     * Create an authenticated Paystack HTTP client.
     */
    protected function client()
    {
        return Http::withToken($this->secretKey())
            ->acceptJson()
            ->baseUrl($this->baseUrl);
    }

    /**
     * Initialize a Paystack transaction.
     */
    public function initializeTransaction(
        string $email,
        int $amount,
        string $reference,
        string $callbackUrl,
        array $metadata = []
    ): array {
        $response = $this->client()->post('/transaction/initialize', [
            'email' => $email,

            /*
             * Paystack expects amount in the smallest
             * currency unit.
             *
             * Example:
             * ₦50,000 = 5,000,000 kobo
             */
            'amount' => $amount,

            'reference' => $reference,

            'callback_url' => $callbackUrl,

            'metadata' => $metadata,
        ]);

        if ($response->failed()) {
            throw new RuntimeException(
                $response->json('message')
                    ?? 'Unable to initialize Paystack transaction.'
            );
        }

        if (!$response->json('status')) {
            throw new RuntimeException(
                $response->json('message')
                    ?? 'Paystack transaction initialization failed.'
            );
        }

        return $response->json('data');
    }

    /**
     * Verify a Paystack transaction.
     */
    public function verifyTransaction(string $reference): array
    {
        $response = $this->client()->get(
            "/transaction/verify/{$reference}"
        );

        if ($response->failed()) {
            throw new RuntimeException(
                $response->json('message')
                    ?? 'Unable to verify Paystack transaction.'
            );
        }

        if (!$response->json('status')) {
            throw new RuntimeException(
                $response->json('message')
                    ?? 'Paystack transaction verification failed.'
            );
        }

        return $response->json('data');
    }
}