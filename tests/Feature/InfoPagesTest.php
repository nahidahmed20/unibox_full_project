<?php

use App\Models\AboutUs;

test('about page keeps the configured story and has a useful empty state', function () {
    $this->get('/about-us')->assertOk()->assertSee('Good things begin with a personal touch.');
    AboutUs::create(['title' => 'Our original story', 'description' => 'The details of our business.', 'image1' => 'uploads/story.jpg']);
    \App\Models\OurService::create(['title' => 'Custom printing', 'slug' => 'custom-printing', 'description' => 'Print your idea.', 'status' => 1]);
    \App\Models\Team::create(['name' => 'Team member', 'status' => 1]);
    \App\Models\Testimonial::create(['name' => 'Customer', 'review' => 'Our customer feedback.', 'rating' => 5, 'status' => 1]);
    \App\Models\Client::create(['name' => 'Client name', 'logo' => 'uploads/client.png', 'status' => 1]);
    $this->get('/about-us')->assertOk()->assertSee('Our original story')->assertSee('The details of our business.')->assertSee('uploads/story.jpg')
        ->assertSee('Custom printing')->assertSee('Team member')->assertSee('Our customer feedback.')->assertSee('Client name');
});

test('contact message validates and persists with a success response', function () {
    $this->from('/contact-us')->post(route('contact.store'), ['name' => 'Example', 'email' => 'invalid', 'subject' => '', 'message' => ''])
        ->assertRedirect('/contact-us')->assertSessionHasErrors(['email', 'subject', 'message']);
    $this->get('/contact-us')->assertOk()->assertSee('value="Example"', false)->assertSee('Please check the highlighted fields below.');
    $this->from('/contact-us')->post(route('contact.store'), ['name' => 'Example', 'email' => 'example@example.test', 'phone' => '01712345678', 'subject' => 'Custom order', 'message' => 'Please help with a custom order.'])
        ->assertRedirect('/contact-us')->assertSessionHas('success');
    $this->assertDatabaseHas('contacts', ['email' => 'example@example.test', 'subject' => 'Custom order', 'phone' => '01712345678']);
});
