<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shipping;
use App\Services\CartPricing;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return redirect()->route('checkout');
    }

    public function singleView($slug)
    {
        return redirect()->route('product.show', $slug);

    }

    public function cart()
    {
        $cart = session('cart', []);

        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $zone = session('shipping_zone', 'inside_dhaka');
        $shippingRow = Shipping::where('zone', $zone)->first();
        $shipping = $shippingRow ? $shippingRow->shipping_cost : 0;
        $grandTotal = $subtotal + $shipping;

        return view('frontend.checkout.cart', compact(
            'cart',
            'subtotal',
            'shipping',
            'grandTotal'
        ));
    }

    public function cartAdd(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1|max:10000',
            'color_id' => 'nullable|integer', 'size_id' => 'nullable|integer',
            'custom_attributes' => 'nullable|array|max:30',
            'custom_attributes.*' => 'required|string|max:255',
            'dimensions' => 'nullable|array',
        ]);
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1|max:10000',
            'color_id' => 'nullable|integer', 'size_id' => 'nullable|integer',
            'custom_attributes' => 'nullable|array|max:30',
            'custom_attributes.*' => 'required|string|max:255',
            'dimensions' => 'nullable|array',
        ]);
        $cart = session('cart', []);
        $productId = $request->product_id;
        $qty = (int) $request->qty;
        $colorId = $request->color_id;
        $sizeId = $request->size_id;

        $customAttributes = $request->custom_attributes ?? [];
        $dimensions = $request->dimensions ?? null;

        $product = Product::find($productId);
        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ]);
        }

        $quote = app(CartPricing::class)->quote($product, [
            'color_id' => $colorId, 'size_id' => $sizeId,
            'dimensions' => $dimensions, 'custom_attributes' => $customAttributes,
        ]);
        ksort($customAttributes);
        $attrHash = '_'.md5(json_encode([$customAttributes, $dimensions]));
        $cartKey = $productId.'_'.($colorId ?? 0).'_'.($sizeId ?? 0).$attrHash;
        $requestedTotalQty = ($cart[$cartKey]['quantity'] ?? 0) + $qty;
        $productQuantity = $qty;
        $variantQuantity = $qty;
        foreach ($cart as $line) {
            if ((int) $line['product_id'] !== (int) $productId) {
                continue;
            }
            $productQuantity += $line['quantity'];
            if (($line['color_id'] ?? null) == $colorId && ($line['size_id'] ?? null) == $sizeId) {
                $variantQuantity += $line['quantity'];
            }
        }
        $variant = $quote['variant'];
        if ($productQuantity > $product->stock || ($variant && $variantQuantity > $variant->stock)) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available.'], 422);
        }
        $finalPrice = $quote['price'];
        $colorName = $variant?->color?->name;
        $sizeName = $variant?->size?->name;

        $cart[$cartKey] = [
            'product_id' => $productId,
            'name' => $product->name,
            'image' => $product->image,
            'price' => $finalPrice,
            'quantity' => $requestedTotalQty,
            'color_id' => $colorId,
            'size_id' => $sizeId,
            'color' => $colorName,
            'size' => $sizeName,
            'attributes' => $quote['attributes'],
            'custom_attributes' => $customAttributes,
            'dimensions' => $dimensions,
        ];

        session(['cart' => $cart]);
        session()->save();

        $cartCount = count($cart);
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $zone = session('shipping_zone', 'inside_dhaka');
        $shippingRow = Shipping::where('zone', $zone)->first();
        $shipping = $shippingRow ? $shippingRow->shipping_cost : 0;
        session()->put('shipping_cost', $shipping);

        $total = $subtotal + $shipping;

        $html = view('frontend.cart.partials.header-cart', [
            'cart' => $cart,
            'shipping' => $shipping,
            'cart_count' => count(session('cart')),
        ])->render();

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => count(session('cart')),
            'shipping' => $shipping,
            'subtotal' => $subtotal,
            'cart_total' => $total,
            'html' => $html,
        ]);
    }

    public function cartContent()
    {
        $cart = session('cart', []);

        return view('frontend.cart.partials.header-cart', compact('cart'))->render();
    }

    public function cartUpdate(Request $request)
    {
        $request->validate(['quantities' => 'required|array', 'quantities.*' => 'required|integer|min:1|max:10000']);
        $request->validate(['quantities' => 'required|array', 'quantities.*' => 'required|integer|min:1|max:10000']);
        $cart = session()->get('cart', []);
        foreach ($request->quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = (int) $qty;
            }
        }
        $productTotals = [];
        $variantTotals = [];
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($item['product_id']);
            $quote = app(CartPricing::class)->quote($product, $item);
            $productTotals[$product->id] = ($productTotals[$product->id] ?? 0) + $item['quantity'];
            $variant = $quote['variant'];
            if ($variant) {
                $variantTotals[$variant->id] = ($variantTotals[$variant->id] ?? 0) + $item['quantity'];
            }
            if ($productTotals[$product->id] > $product->stock || ($variant && $variantTotals[$variant->id] > $variant->stock)) {
                return response()->json(['status' => 'error', 'message' => 'Not enough stock available.'], 422);
            }
            $cart[$id]['price'] = $quote['price'];
            $cart[$id]['attributes'] = $quote['attributes'];
        }

        session()->put('cart', $cart);
        session()->save();

        $html = view('frontend.cart.partials.header-cart', ['cart' => $cart])->render();
        $table = view('frontend.cart.partials.cart-table', ['cart' => $cart])->render();

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $shipping = session('shipping_cost', 60);

        return response()->json([
            'status' => 'success',
            'table' => $table,
            'html' => $html,
            'cart_count' => count($cart),
            'subtotal' => $total,
            'shipping' => $shipping,
            'cart_total' => $total + $shipping,
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->save();
        }

        $html = view('frontend.cart.partials.header-cart', [
            'cart' => session('cart'),
        ])->render();

        $table = view('frontend.cart.partials.cart-table', [
            'cart' => session('cart'),
        ])->render();
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $shipping = count($cart) > 0 ? session('shipping_cost', 0) : 0;
        $total = $subtotal + $shipping;

        return response()->json([
            'status' => 'success',
            'table' => $table,
            'html' => $html,
            'cart_count' => count($cart),
            'cart_total' => $total,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
        ]);
    }

    public function updateShippingZone(Request $request)
    {
        $zone = $request->zone;
        $shipping = Shipping::where('zone', $zone)->first();
        if (! $shipping) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping zone not found',
            ]);
        }
        session([
            'shipping_zone' => $zone,
            'shipping_cost' => $shipping->shipping_cost,
        ]);
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
        $total = $subtotal + $shipping->shipping_cost;

        return response()->json([
            'success' => true,
            'shipping' => $shipping->shipping_cost,
            'total' => $total,
        ]);
    }

    public function orderStore(Request $request)
    {
        return app(FontOrderController::class)->placeOrder($request);
    }

    public function getDistricts(Request $request)
    {
        $request->validate(['division_id' => 'required|integer']);

        return app(FontOrderController::class)->getDistricts($request->division_id);
    }

    public function getUpazilas(Request $request)
    {
        $request->validate(['district_id' => 'required|integer']);

        return app(FontOrderController::class)->getUpazilas($request->district_id);
    }
}
