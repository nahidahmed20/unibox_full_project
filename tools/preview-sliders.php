<?php

// Seed banner examples only in the isolated local design preview database.
require __DIR__.'/preview-storefront.php';
foreach (App\Models\Product::whereNotNull('image')->take(2)->get() as $index => $product) {
    App\Models\Slider::firstOrCreate(['title' => $index ? 'A personal touch. A lasting impression.' : 'Your ideas, beautifully made.'], [
        'short_description' => 'Discover custom details for your business, your space, and every special occasion.',
        'image' => $product->image, 'mobile_image' => $product->image,
        'status' => '1', 'link' => '/product/'.$product->slug,
    ]);
}
echo "Demo banners prepared in isolated preview database.\n";
