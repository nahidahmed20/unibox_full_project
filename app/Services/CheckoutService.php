<?php

namespace App\Services;

use App\Models\BlockedPhone;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function place(array $data, array $cart, string $zone, ?int $customerId): Order
    {
        if (! $cart) {
            throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
        }
        if (BlockedPhone::where('phone', $data['phone'])->exists()) {
            throw ValidationException::withMessages(['phone' => 'Orders cannot be accepted for this phone number.']);
        }

        return DB::transaction(function () use ($data, $cart, $zone, $customerId) {
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
            $order = Order::create([
                'order_number' => 'ORD-'.strtoupper((string) Str::ulid()),
                'user_id' => $customerId, 'full_name' => $data['name'],
                'phone' => $data['phone'], 'email' => $data['email'] ?? null,
                'address' => $data['address'], 'city' => $data['district_id'] ?? $data['city'] ?? null,
                'province' => $data['division_id'] ?? $data['province'] ?? null,
                'country' => 'Bangladesh', 'payment_method' => 'cod', 'payment_status' => 'unpaid',
                'subtotal' => $subtotal, 'shipping' => $shipping->shipping_cost,
                'total' => round($subtotal + $shipping->shipping_cost, 2),
                'order_note' => $data['message'] ?? $data['order_note'] ?? null,
                'status' => 'pending',
            ]);
            $order->items()->createMany($lines);

            return $order;
        }, 3);
    }
}
