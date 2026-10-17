<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

test('staff profile page is displayed', function () {
    $this->actingAs(User::factory()->create(['type' => 'admin']))->get('/admin/profile/edit')->assertOk();
});

test('staff profile changes invalidate email verification', function () {
    $user = User::factory()->create(['type' => 'admin']);
    $this->actingAs($user)->from('/admin/profile/edit')->post('/admin/profile/update', [
        'name' => 'Updated Staff', 'email' => 'updated@example.com',
    ])->assertSessionHasNoErrors()->assertRedirect('/admin/profile/edit');
    expect($user->fresh()->name)->toBe('Updated Staff')->and($user->fresh()->email_verified_at)->toBeNull();
});

test('unchanged staff email keeps verification', function () {
    $user = User::factory()->create(['type' => 'admin']);
    $this->actingAs($user)->post('/admin/profile/update', ['name' => $user->name, 'email' => $user->email])->assertSessionHasNoErrors();
    expect($user->fresh()->email_verified_at)->not->toBeNull();
});

test('profile rejects executable uploads and duplicate email', function () {
    $user = User::factory()->create(['type' => 'admin']);
    $other = User::factory()->create();
    $this->actingAs($user)->post('/admin/profile/update', [
        'name' => $user->name, 'email' => $other->email,
        'image' => UploadedFile::fake()->create('shell.php', 1, 'application/x-php'),
    ])->assertSessionHasErrors(['image', 'email']);
});

test('customer cannot update staff profile', function () {
    $this->actingAs(User::factory()->create(['type' => 'customer']))->post('/admin/profile/update', [
        'name' => 'Changed', 'email' => 'changed@example.com',
    ])->assertForbidden();
});
