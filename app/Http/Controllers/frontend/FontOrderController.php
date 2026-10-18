<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Size;
use App\Services\CartPricing;
use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FontOrderController extends Controller
{
    public function cartCheckout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        foreach ($cart as $key => $item) {
            $product = Product::find($item['product_id']);

            if (! $product) {
                unset($cart[$key]);

                continue;
            }
            try {
                $quote = app(CartPricing::class)->quote($product, $item);
                $cart[$key]['price'] = $quote['price'];
                $cart[$key]['attributes'] = $quote['attributes'];
            } catch (ValidationException $e) {
                return redirect()->route('checkout')->with('error', 'A cart item is no longer available. Remove it and select the product options again.');
            }

            if (! empty($item['color_id'])) {
                $cart[$key]['color'] = Color::find($item['color_id'])?->name;
            }
            if (! empty($item['size_id'])) {
                $cart[$key]['size'] = Size::find($item['size_id'])?->name;
            }
        }

        session(['cart' => $cart]);
        if (! $cart) {
            return redirect()->route('checkout')->with('error', 'Your cart is empty.');
        }

        $divisions = Location::where('type', 'division')->get();
        $subtotal = collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);

        // Shipping Calculation with Free Shipping Threshold
        $shippingCost = (float) (Shipping::where('zone', session('shipping_zone', 'inside_dhaka'))->value('shipping_cost') ?? 0);
        $freeThreshold = (float) setting('free_shipping_threshold', 0);
        if ($freeThreshold > 0 && $subtotal >= $freeThreshold) {
            $shippingCost = 0.00;
        }
        session(['shipping_cost' => $shippingCost]);

        // Coupon calculation
        $discount = 0.00;
        $appliedCoupon = session('coupon');
        if ($appliedCoupon && !empty($appliedCoupon['code'])) {
            $coupon = Coupon::where('code', $appliedCoupon['code'])->where('status', 1)->first();
            if ($coupon) {
                $check = $coupon->isValidForAmount($subtotal);
                if ($check['valid']) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    session(['coupon' => ['code' => $coupon->code, 'discount' => $discount, 'id' => $coupon->id]]);
                } else {
                    session()->forget('coupon');
                    $appliedCoupon = null;
                }
            } else {
                session()->forget('coupon');
                $appliedCoupon = null;
            }
        }

        $total = max(0, round(($subtotal - $discount) + $shippingCost, 2));

        return view(
            'frontend.checkout.place-order',
            compact('cart', 'subtotal', 'shippingCost', 'discount', 'appliedCoupon', 'total', 'divisions')
        );
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->coupon_code));
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }

        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']);

        $check = $coupon->isValidForAmount($subtotal);
        if (! $check['valid']) {
            return back()->with('error', $check['message']);
        }

        $discount = $coupon->calculateDiscount($subtotal);
        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discount
        ]]);

        return back()->with('success', "Coupon '{$coupon->code}' applied successfully! You saved ৳" . number_format($discount, 2));
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed successfully.');
    }

    public function getDistricts($division_id)
    {
        $districts = Location::where('parent_id', $division_id)
            ->where('type', 'district')
            ->get();

        return response()->json($districts);
    }

    public function getUpazilas($district_id)
    {
        $upazilas = Location::where('parent_id', $district_id)
            ->where('type', 'upazila')
            ->get();

        return response()->json($upazilas);
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^01[3-9][0-9]{8}$/'],
            'address' => 'required|string|max:1000',
            'email' => 'nullable|email|max:255',
            'payment_method' => 'required|in:cod',
            'division_id' => 'nullable|integer|exists:locations,id',
            'district_id' => 'nullable|integer|exists:locations,id',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
            'order_note' => 'nullable|string|max:2000',
        ]);
        try {
            $order = app(CheckoutService::class)->place(
                $data,
                session('cart', []),
                session('shipping_zone', 'inside_dhaka'),
                auth('customer')->id(),
                session('coupon')
            );
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Unable to place the order. Please try again.');
        }
        session()->put('placed_orders.'.$order->order_number, true);
        session()->forget(['cart', 'shipping_cost', 'coupon']);

        return redirect()->route('order.success', $order->order_number)->with('success', 'Order placed successfully.');
    }

    public function orderSuccess($order_number)
    {
        $order = Order::with(['items.product', 'items.color', 'items.size'])
            ->where('order_number', $order_number)
            ->firstOrFail();

        abort_unless(session('placed_orders.'.$order->order_number) || (auth('customer')->check() && (int) $order->user_id === (int) auth('customer')->id()), 404);

        return view('frontend.checkout.success', compact('order'));
    }

    public function faq()
    {
        return view('frontend.home.faq');
    }
}
