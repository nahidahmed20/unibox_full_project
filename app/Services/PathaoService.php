<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PathaoService
{
    protected string $baseUrl = 'https://api-hermes.pathao.com';

    /**
     * Get or generate Pathao Bearer Access Token using client credentials
     */
    public function getAccessToken(): ?string
    {
        $clientId = setting('pathao_client_id');
        $clientSecret = setting('pathao_client_secret');

        if (!$clientId || !$clientSecret) {
            return null;
        }

        $cachedToken = cache()->get('pathao_access_token');
        if ($cachedToken) {
            return $cachedToken;
        }

        try {
            $response = Http::timeout(15)->post("{$this->baseUrl}/aladdin/api/v1/issue-token", [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'client_credentials',
            ]);

            $data = $response->json();

            if ($response->successful() && !empty($data['access_token'])) {
                $expiresIn = ($data['expires_in'] ?? 3600) - 300;
                cache()->put('pathao_access_token', $data['access_token'], max($expiresIn, 60));
                return $data['access_token'];
            }

            Log::error('Pathao token issue error', ['response' => $data]);
            return null;
        } catch (\Throwable $e) {
            Log::error('Pathao token request failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create parcel booking on Pathao Courier
     */
    public function createOrder(Order $order): array
    {
        $clientId = setting('pathao_client_id');
        $clientSecret = setting('pathao_client_secret');
        $storeId = (int) setting('pathao_store_id');

        if (!$clientId || !$clientSecret || !$storeId) {
            return [
                'success' => false,
                'message' => 'Pathao credentials (Client ID, Client Secret, or Store ID) are missing in Global Settings.'
            ];
        }

        $token = $this->getAccessToken();
        if (!$token) {
            return [
                'success' => false,
                'message' => 'Failed to authenticate with Pathao API. Please check your Client ID and Client Secret.'
            ];
        }

        $codAmount = $order->payment_status === 'paid' ? 0 : (float) $order->total;

        try {
            $payload = [
                'store_id' => $storeId,
                'merchant_order_id' => $order->order_number,
                'recipient_name' => $order->full_name,
                'recipient_phone' => $order->phone,
                'recipient_address' => $order->address,
                'recipient_city' => 1, // Default Dhaka City if unspecified
                'recipient_zone' => 1,
                'delivery_type' => 48, // Normal 48-hour delivery
                'item_type' => 2, // Parcel / standard box
                'special_instruction' => $order->order_note ?? 'Handle with care',
                'item_quantity' => $order->items->sum('quantity') ?: 1,
                'item_weight' => 0.5,
                'amount_to_collect' => (int) round($codAmount),
                'item_description' => 'Unibox Order #' . $order->order_number
            ];

            $response = Http::withToken($token)
                ->timeout(20)
                ->post("{$this->baseUrl}/aladdin/api/v1/orders", $payload);

            $result = $response->json();

            if ($response->successful() && isset($result['type']) && $result['type'] === 'success') {
                $consignmentId = $result['data']['consignment_id'] ?? null;

                return [
                    'success' => true,
                    'consignment_id' => $consignmentId,
                    'tracking_code' => $consignmentId,
                    'message' => 'Parcel booked on Pathao successfully! Consignment: ' . $consignmentId
                ];
            }

            Log::error('Pathao order creation failure', ['response' => $result]);
            return [
                'success' => false,
                'message' => $result['message'] ?? 'Failed to book order on Pathao.'
            ];
        } catch (\Throwable $e) {
            Log::error('Pathao exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Connection error while communicating with Pathao: ' . $e->getMessage()
            ];
        }
    }
}

