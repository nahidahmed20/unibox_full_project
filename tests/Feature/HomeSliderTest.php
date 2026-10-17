<?php

use App\Models\Slider;

test('homepage displays only active banners and uses mobile artwork and safe links', function () {
    Slider::create(['title' => 'Active collection banner', 'image' => 'uploads/desktop.jpg', 'mobile_image' => 'uploads/mobile.jpg', 'status' => '1', 'link' => '/search']);
    Slider::create(['title' => 'Hidden banner', 'image' => 'uploads/hidden.jpg', 'status' => '0']);
    Slider::create(['title' => 'Second collection banner', 'image' => 'uploads/second.jpg', 'status' => '1', 'link' => 'javascript:alert(1)']);
    $this->get('/')->assertOk()->assertSee('Active collection banner')->assertSee('Second collection banner')
        ->assertDontSee('Hidden banner')->assertDontSee('javascript:alert')->assertSee('uploads/mobile.jpg')
        ->assertSee('data-slide-controls', false);
    expect((new Slider(['link' => '//example.com']))->action_url)->toBe(route('search'));
});

test('empty slider catalog has a useful static hero without carousel controls', function () {
    $this->get('/')->assertOk()->assertSee('Made for you. Made to stand out.')->assertDontSee('data-slide-controls', false);
});
