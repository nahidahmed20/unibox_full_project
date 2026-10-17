<?php

use App\Models\User;

test('canonical account routes render and legacy URLs remain available', function () {
    $this->get('/account/login')->assertOk()->assertSee('Send verification code');
    $this->get('/user-login')->assertOk();
    $this->get('/account')->assertRedirect(route('account.login'));
    $customer = User::factory()->create(['type' => 'customer', 'status' => 1]);
    $this->actingAs($customer, 'customer');
    foreach (['/account', '/account/orders', '/account/profile', '/account/password', '/customer/dashboard'] as $url) {
        $this->get($url)->assertOk()->assertSee('aria-label="Your account"', false)->assertSee('id="main-content"', false);
    }
    $this->get('/account')->assertSee($customer->name)->assertSee('Your next favourite is waiting.');
    $this->post('/account/logout')->assertRedirect('/');
    $this->assertGuest('customer');
});

test('OTP view validates four digits without automatic submission', function () {
    $this->withSession(['otp_login' => '01712345678', 'otp_code' => '1234', 'otp_field' => 'phone', 'otp_expires_at' => now()->addMinutes(2)->timestamp])
        ->get('/account/login')->assertOk()->assertSee('Check your phone')->assertSee('maxlength="4"', false);
    $this->post('/account/otp/verify', ['otp' => '12'])->assertSessionHasErrors('otp');
});
