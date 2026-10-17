<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Shipping;
use App\Models\User;
use App\Services\CartPricing;
use App\Services\CheckoutService;
use Illuminate\Validation\ValidationException;

function commerceProduct(array $extra = []): Product
{
    return Product::create($extra + ['name' => 'Test product', 'slug' => 'test-product', 'sku' => uniqid('sku'), 'category_id' => 1, 'selling_price' => 100, 'stock' => 5, 'product_type' => 'single', 'status' => 1]);
}

function commerceData(): array
{
    return ['name' => 'Customer', 'phone' => '01712345678', 'address' => 'Dhaka', 'payment_method' => 'cod'];
}

function commerceCart(Product $product, int $quantity = 2): array
{
    return [['product_id' => $product->id, 'name' => $product->name, 'price' => 1, 'quantity' => $quantity, 'color_id' => null, 'size_id' => null]];
}

test('public diagnostic endpoints are removed', function () {
    $this->get('/test-google')->assertNotFound();
    $this->get('/clear-cache')->assertNotFound();
});

test('customer and inactive staff cannot access administration', function () {
    $this->actingAs(User::factory()->create(['type' => 'customer']))->get('/admin/home')->assertForbidden();
    $this->actingAs(User::factory()->create(['type' => 'admin', 'status' => 0]))->get('/admin/home')->assertForbidden();
});

test('cart rejects nonpositive and fractional quantities', function () {
    $product = commerceProduct();
    foreach ([0, -2, 1.5] as $quantity) {
        $this->postJson('/cart/add', ['product_id' => $product->id, 'qty' => $quantity])->assertUnprocessable()->assertJsonValidationErrors('qty');
    }
    $this->postJson('/cart/update', ['quantities' => ['item' => -1]])->assertUnprocessable();
});

test('checkout uses current prices and configured shipping', function () {
    $product = commerceProduct();
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    $order = app(CheckoutService::class)->place(commerceData() + ['total' => 1], commerceCart($product), 'inside_dhaka', null);
    expect((float) $order->total)->toBe(260.0)
        ->and((float) $order->items->first()->price)->toBe(100.0)
        ->and($product->fresh()->stock)->toBe(3);
});

test('checkout rolls back all inventory when a later item has insufficient stock', function () {
    $first = commerceProduct();
    $second = commerceProduct(['stock' => 0]);
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    try {
        app(CheckoutService::class)->place(commerceData(), [...commerceCart($first), ...commerceCart($second)], 'inside_dhaka', null);
        $this->fail('Checkout should reject insufficient stock.');
    } catch (ValidationException $e) {
        expect($first->fresh()->stock)->toBe(5)->and(Order::count())->toBe(0);
    }
});

test('both checkout endpoints ignore submitted totals and scope guest receipts', function () {
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    foreach (['/checkout/place-order', '/cart/order/store'] as $url) {
        $product = commerceProduct();
        $this->withSession(['cart' => commerceCart($product), 'shipping_cost' => -100])
            ->post($url, commerceData() + ['subtotal' => 1, 'shipping' => 0, 'total' => 1])
            ->assertSessionHasNoErrors()->assertRedirect();
        $order = Order::latest('id')->firstOrFail();
        expect((float) $order->total)->toBe(260.0)->and($order->user_id)->toBeNull();
    }
    $this->flushSession();
    $this->get('/order-success/'.$order->order_number)->assertNotFound();
    $this->get('/thank-you/'.$order->order_number)->assertNotFound();
});

test('unsupported online payments are rejected', function () {
    $this->postJson('/checkout/place-order', array_replace(commerceData(), ['payment_method' => 'online']))
        ->assertUnprocessable()->assertJsonValidationErrors('payment_method');
});

test('calculator price uses dimensions instead of client supplied square feet', function () {
    $product = commerceProduct(['is_calculator' => 1, 'price_per_sqft' => 50]);
    $quote = app(CartPricing::class)->quote($product, [
        'dimensions' => ['w_ft' => 2, 'w_in' => 0, 'h_ft' => 3, 'h_in' => 0, 'sqft' => 0.01],
    ]);
    expect($quote['price'])->toBe(300.0);
});

test('checkout only decrements the selected variation', function () {
    $product = commerceProduct(['product_type' => 'multiple', 'stock' => 10]);
    $selected = ProductVariant::create(['product_id' => $product->id, 'color_id' => 1, 'size_id' => 1, 'sku' => 'selected', 'stock' => 5, 'selling_price' => 120]);
    $other = ProductVariant::create(['product_id' => $product->id, 'color_id' => 1, 'size_id' => 2, 'sku' => 'other', 'stock' => 5, 'selling_price' => 120]);
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    $cart = commerceCart($product);
    $cart[0]['color_id'] = 1;
    $cart[0]['size_id'] = 1;
    $order = app(CheckoutService::class)->place(commerceData(), $cart, 'inside_dhaka', null);
    expect($selected->fresh()->stock)->toBe(3)->and($other->fresh()->stock)->toBe(5)->and((float) $order->total)->toBe(300.0);
});

test('repeated cancellation restores inventory only once', function () {
    $product = commerceProduct();
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    $order = app(CheckoutService::class)->place(commerceData(), commerceCart($product), 'inside_dhaka', null);
    $this->actingAs(User::factory()->create(['type' => 'admin']));
    for ($i = 0; $i < 2; $i++) {
        $this->postJson('/admin/single-status-update/'.$order->id, ['status' => 'cancelled'])->assertOk();
    }
    expect($product->fresh()->stock)->toBe(5);
    $this->postJson('/admin/single-status-update/'.$order->id, ['status' => 'pending'])->assertOk();
    expect($product->fresh()->stock)->toBe(3);
});

test('order edits reconcile status and quantity together', function () {
    $product = commerceProduct();
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    $order = app(CheckoutService::class)->place(commerceData(), commerceCart($product), 'inside_dhaka', null);
    $item = $order->items->first();
    $data = ['customer_name' => 'Customer', 'customer_phone' => '01712345678', 'customer_address' => 'Dhaka', 'shipping' => 60, 'payment_status' => 'unpaid', 'status' => 'cancelled', 'items' => [$item->id => ['quantity' => 3, 'price' => 100]]];
    $this->actingAs(User::factory()->create(['type' => 'admin']))->put('/admin/orders/'.$order->id, $data)->assertSessionHasNoErrors()->assertRedirect();
    expect($product->fresh()->stock)->toBe(5)->and((float) $order->fresh()->total)->toBe(360.0);
    $data['status'] = 'pending';
    $this->put('/admin/orders/'.$order->id, $data)->assertSessionHasNoErrors()->assertRedirect();
    expect($product->fresh()->stock)->toBe(2);
});

test('a valid cart can be added and updated', function () {
    $product = commerceProduct();
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    $this->postJson('/cart/add', ['product_id' => $product->id, 'qty' => 1])->assertOk()->assertJsonPath('success', true);
    $key = array_key_first(session('cart'));
    $this->postJson('/cart/update', ['quantities' => [$key => 2]])->assertOk()->assertJsonPath('status', 'success');
    $this->deleteJson('/cart/remove/'.$key)->assertOk()->assertJsonPath('cart_count', 0);
});
