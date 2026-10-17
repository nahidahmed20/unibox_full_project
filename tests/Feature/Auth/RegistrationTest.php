<?php

test('public staff registration is disabled', function () {
    $this->get('/register')->assertNotFound();
    $this->post('/register', ['name' => 'Attacker', 'email' => 'attacker@example.com', 'password' => 'password', 'password_confirmation' => 'password'])->assertNotFound();
    $this->assertDatabaseMissing('users', ['email' => 'attacker@example.com']);
});
