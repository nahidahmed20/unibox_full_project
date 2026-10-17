<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

test('listing pages batch product relationships and use complete category rows', function () {
    $category = Category::create(['name' => 'Performance', 'slug' => 'performance', 'status' => '1']);
    for ($i = 0; $i < 18; $i++) {
        Product::create(['name' => 'Product '.$i, 'slug' => 'performance-'.$i, 'sku' => 'performance-'.$i,
            'category_id' => $category->id, 'selling_price' => 100, 'stock' => 5, 'status' => 1,
            'product_type' => 'single', 'is_bestseller' => 1]);
    }

    foreach (['/category/performance', '/search', '/best-selling-products'] as $url) {
        DB::enableQueryLog();
        DB::flushQueryLog();
        $response = $this->get($url)->assertOk();
        $queries = collect(DB::getQueryLog())->pluck('query');
        DB::disableQueryLog();

        expect($queries->filter(fn ($sql) => str_contains($sql, 'from "product_variants"'))->count())->toBe(1);
        // One eager-loaded category query and at most one navigation/slug query each.
        expect($queries->filter(fn ($sql) => str_contains($sql, 'from "categories"'))->count())->toBeLessThanOrEqual(3);
        if ($url === '/category/performance') {
            $response->assertViewHas('products', fn ($products) => $products->count() === 16 && $products->total() === 18);
        }
    }
});

test('storefront loads optional libraries only where used', function () {
    $this->get('/')->assertOk()->assertDontSee('vendor/swiper.min.js', false)->assertDontSee('select2.min.js', false);
    $this->get('/about-us')->assertOk()->assertDontSee('vendor/swiper.min.js', false);
});
