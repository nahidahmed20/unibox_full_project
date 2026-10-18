<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SteadfastService
{
    protected string $baseUrl = 'https://portal.steadfast.com.bd/api/v1';

    public function createOrder(Order $order): array
    {
        $apiKey = setting('steadfast_api_key');
        $secretKey = setting('steadfast_secret_key');

        if (!$apiKey || !$secretKey) {
            return [
                'success' => false,
                'message' => 'Steadfast API Key or Secret Key is not configured in Settings.'
            ];
        }

        $codAmount = $order->payment_status === 'paid' ? 0 : (float) $order->total;

        try {
            $response = Http::withHeaders([
                'Api-Key' => $apiKey,
                'Secret-Key' => $secretKey,
                'Content-Type' => 'application/json'
            ])->timeout(20)->post("{$this->baseUrl}/create_order", [
                'invoice' => $order->order_number,
                'recipient_name' => $order->full_name,
                'recipient_phone' => $order->phone,
                'recipient_address' => $order->address,
                'cod_amount' => $codAmount,
                'note' => $order->order_note ?? 'Handle with care',
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] == 200) {
                $consignment = $result['consignment'] ?? [];
                $trackingCode = $consignment['tracking_code'] ?? ($consignment['consignment_id'] ?? null);

                return [
                    'success' => true,
                    'consignment_id' => $consignment['consignment_id'] ?? null,
                    'tracking_code' => $trackingCode,
                    'message' => 'Parcel booked on Steadfast successfully!'
                ];
            }

            Log::error('Steadfast order creation error', ['response' => $result]);
            return [
                'success' => false,
                'message' => $result['message'] ?? ($result['errors'][0] ?? 'Failed to create order on Steadfast.')
            ];

        } catch (\Throwable $e) {
            Log::error('Steadfast connection exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Could not connect to Steadfast Courier server: ' . $e->getMessage()
            ];
        }
    }

    public function checkDeliveryStatus(string $consignmentId): array
    {
        $apiKey = setting('steadfast_api_key');
        $secretKey = setting('steadfast_secret_key');

        if (!$apiKey || !$secretKey) {
            return ['success' => false, 'message' => 'Steadfast credentials missing.'];
        }

        try {
            $response = Http::withHeaders([
                'Api-Key' => $apiKey,
                'Secret-Key' => $secretKey,
            ])->timeout(15)->get("{$this->baseUrl}/status_by_cid/{$consignmentId}");

            return $response->json() ?? ['success' => false];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

