<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Support\Facades\Route;

test('public storefront pages render with a fresh database', function (string $url) {
    $this->get($url)->assertOk();
})->with(['/', '/cart', '/privacy-policy', '/terms-conditions', '/track-order', '/return-policy', '/shipping-policy', '/contact-us', '/about-us', '/faq', '/our/blogs', '/search?q=test', '/best-selling-products', '/user-login']);

test('legacy cart URL redirects to the working cart', function () {
    $this->get('/cart/index')->assertRedirect(route('checkout'));
});

test('all registered controller actions exist', function () {
    foreach (Route::getRoutes() as $route) {
        $action = $route->getActionName();
        if (! str_contains($action, '@')) {
            continue;
        }
        [$class, $method] = explode('@', $action);
        expect(method_exists($class, $method), $route->uri())->toBeTrue();
    }
});

test('product detail category quick view and checkout render with catalog data', function () {
    $category = Category::create(['name' => 'Catalog', 'slug' => 'catalog', 'status' => '1']);
    $product = Product::create(['name' => 'Sample Product', 'slug' => 'sample', 'sku' => 'sample', 'category_id' => $category->id, 'selling_price' => 100, 'stock' => 5, 'status' => 1, 'product_type' => 'single', 'is_bestseller' => 1]);
    Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    $this->get('/product/sample')->assertOk();
    $this->get('/category/catalog')->assertOk();
    $this->get('/product/quick-view/'.$product->id)->assertOk();
    $this->get('/best-selling-products')->assertOk();
    $this->postJson('/cart/add', ['product_id' => $product->id, 'qty' => 1])->assertOk();
    $this->get('/checkout')->assertOk();
    $response = $this->post('/checkout/place-order', ['name' => 'Customer', 'phone' => '01712345678', 'address' => 'Dhaka', 'payment_method' => 'cod'])->assertSessionHasNoErrors();
    $this->get($response->headers->get('Location'))->assertOk();
});
