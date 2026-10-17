<?php

// Isolated local demo database. This script never migrates the configured business database.
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$preview = storage_path('app/private/preview');
if (!is_dir($preview)) mkdir($preview, 0777, true);
if (!is_dir($preview.'/sessions')) mkdir($preview.'/sessions', 0777, true);
$database = $preview.'/storefront.sqlite';
config([
    'app.env' => 'local', 'app.debug' => false, 'app.url' => 'http://127.0.0.1:8097',
    'database.default' => 'sqlite', 'database.connections.sqlite.database' => $database,
    'session.driver' => 'file', 'session.files' => $preview.'/sessions', 'session.domain' => null,
    'session.secure' => false, 'session.cookie' => 'unibox_design_preview',
    'cache.default' => 'array', 'mail.default' => 'array', 'queue.default' => 'sync',
    'services.sms.url' => null, 'services.sms.key' => null,
]);
Illuminate\Support\Facades\DB::purge('sqlite');
Illuminate\Support\Facades\URL::forceRootUrl('http://127.0.0.1:8097');

if (PHP_SAPI === 'cli' && ($argv[1] ?? '') === 'seed') {
    if (file_exists($database)) { echo "Preview database already exists.\n"; exit; }
    touch($database);
    Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    $names = ['Custom signage', 'Bags & accessories', 'Print essentials', 'Office & everyday', 'Gifts & keepsakes', 'Made for your brand'];
    $images = glob(public_path('uploads/products/*.webp'));
    if (!$images) $images = glob(public_path('uploads/products/*.jpg'));
    $images = array_slice($images, -8);
    foreach ($names as $i => $name) {
        App\Models\Category::create(['name' => $name, 'slug' => Illuminate\Support\Str::slug($name), 'status' => '1', 'image' => isset($images[$i]) ? 'uploads/products/'.basename($images[$i]) : null]);
    }
    $titles = ['Personalised desk sign', 'Signature business display', 'Everyday essentials', 'Your brand, in print', 'A thoughtful finishing touch', 'Custom name plate', 'Creative studio collection', 'Something made for you'];
    foreach ($titles as $i => $title) {
        App\Models\Product::create(['name' => $title, 'slug' => Illuminate\Support\Str::slug($title), 'sku' => 'PREVIEW-'.$i, 'category_id' => ($i % 6)+1, 'status' => 1, 'stock' => 20, 'selling_price' => 350 + $i * 150, 'main_price' => $i % 2 === 0 ? 450 + $i * 150 : null, 'image' => isset($images[$i]) ? 'uploads/products/'.basename($images[$i]) : null, 'is_bestseller' => $i < 4, 'product_type' => 'single', 'short_description' => 'Preview product for checking the storefront layout.']);
    }
    App\Models\Shipping::create(['zone' => 'inside_dhaka', 'shipping_cost' => 60]);
    echo "Isolated preview catalog created. No business data changed.\n";
    exit;
}

return $app;
