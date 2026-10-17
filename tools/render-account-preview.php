<?php

// Render a demo account using the isolated preview DB; no login route or business data changes.
$app = require __DIR__.'/preview-storefront.php';
$customer = App\Models\User::firstOrCreate(['email' => 'preview-customer@example.test'], [
    'name' => 'Alex Morgan', 'phone' => '01700000000', 'type' => 'customer', 'status' => 1,
    'password' => Illuminate\Support\Facades\Hash::make(Illuminate\Support\Str::random(40)),
]);
auth('customer')->setUser($customer);
$request = Illuminate\Http\Request::create('http://127.0.0.1:8097/account');
$request->setRouteResolver(fn () => app('router')->getRoutes()->match($request));
$app->instance('request', $request);
file_put_contents(storage_path('app/private/preview/dashboard.html'), app(App\Http\Controllers\frontend\UserController::class)->dashboard()->render());
echo "Isolated account preview rendered.\n";
