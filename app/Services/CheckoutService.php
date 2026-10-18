<?php

namespace App\Services;

use App\Models\BlockedPhone;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function place(array $data, array $cart, string $zone, ?int $customerId, ?array $couponData = null): Order
    {
        if (! $cart) {
            throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
        }
        if (BlockedPhone::where('phone', $data['phone'])->exists()) {
            throw ValidationException::withMessages(['phone' => 'Orders cannot be accepted for this phone number.']);
        }

        $order = DB::transaction(function () use ($data, $cart, $zone, $customerId, $couponData) {
            $shipping = Shipping::where('zone', $zone)->first();
            if (! $shipping || $shipping->shipping_cost < 0) {
                throw ValidationException::withMessages(['shipping' => 'Please select an available delivery zone.']);
            }
            $lines = [];
            $subtotal = 0;
            // Stable ordering reduces deadlocks when carts contain overlapping products.
            uasort($cart, fn ($a, $b) => $a['product_id'] <=> $b['product_id']);
            foreach ($cart as $item) {
                validator($item, ['product_id' => 'required|integer', 'quantity' => 'required|integer|min:1|max:10000'])->validate();
                $product = Product::whereKey($item['product_id'])->lockForUpdate()->first();
                if (! $product) {
                    throw ValidationException::withMessages(['cart' => 'A product was removed. Please update your cart.']);
                }
                $quote = app(CartPricing::class)->quote($product, $item + ['color_id' => null, 'size_id' => null], true);
                $quantity = (int) $item['quantity'];
                $variant = $quote['variant'];
                if ($product->stock < $quantity || ($variant && $variant->stock < $quantity)) {
                    throw ValidationException::withMessages(['cart' => "Not enough stock for {$product->name}."]);
                }
                $product->decrement('stock', $quantity);
                $variant?->decrement('stock', $quantity);
                $lineTotal = round($quote['price'] * $quantity, 2);
                $subtotal += $lineTotal;
                $lines[] = [
                    'product_id' => $product->id, 'product_name' => $product->name,
                    'color_id' => $variant?->color_id, 'size_id' => $variant?->size_id,
                    'price' => $quote['price'], 'quantity' => $quantity,
                    'total' => $lineTotal, 'attributes' => $quote['attributes'],
                ];
            }

            // Free Shipping Threshold Check
            $shippingCost = (float) $shipping->shipping_cost;
            $freeThreshold = (float) setting('free_shipping_threshold', 0);
            if ($freeThreshold > 0 && $subtotal >= $freeThreshold) {
                $shippingCost = 0.00;
            }

            // Coupon Discount Check
            $discount = 0.00;
            $couponCode = null;
            if ($couponData && !empty($couponData['code'])) {
                $coupon = Coupon::where('code', $couponData['code'])->first();
                if ($coupon) {
                    $check = $coupon->isValidForAmount($subtotal);
                    if ($check['valid']) {
                        $discount = $coupon->calculateDiscount($subtotal);
                        $couponCode = $coupon->code;
                        $coupon->increment('used_count');
                    }
                }
            }

            $grandTotal = max(0, round(($subtotal - $discount) + $shippingCost, 2));

            $order = Order::create([
                'order_number' => 'ORD-'.strtoupper((string) Str::ulid()),
                'user_id' => $customerId, 'full_name' => $data['name'],
                'phone' => $data['phone'], 'email' => $data['email'] ?? null,
                'address' => $data['address'], 'city' => $data['district_id'] ?? $data['city'] ?? null,
                'province' => $data['division_id'] ?? $data['province'] ?? null,
                'country' => 'Bangladesh', 'payment_method' => 'cod', 'payment_status' => 'unpaid',
                'subtotal' => $subtotal, 'coupon_code' => $couponCode, 'discount' => $discount,
                'shipping' => $shippingCost,
                'total' => $grandTotal,
                'order_note' => $data['message'] ?? $data['order_note'] ?? null,
                'status' => 'pending',
            ]);
            $order->items()->createMany($lines);

            return $order;
        }, 3);

        // Automated Order Placement SMS
        if (setting('order_sms_enabled', '1') == '1' && !empty($order->phone)) {
            try {
                $storeName = setting('company_name') ?: 'Unibox';
                $smsText = "Dear {$order->full_name}, your order #{$order->order_number} has been placed successfully at {$storeName}. Total: BDT {$order->total}. Thank you!";
                SmsService::send($order->phone, $smsText);
            } catch (\Throwable $t) {
                Log::error('Order placement SMS failed: ' . $t->getMessage());
            }
        }

        return $order;
    }
}
