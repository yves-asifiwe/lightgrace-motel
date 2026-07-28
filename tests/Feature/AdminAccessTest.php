<?php

use App\Models\User;

test('admins can create new admin accounts', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this
        ->actingAs($admin)
        ->from('/admin/settings')
        ->post('/admin/settings/admin', [
            'name' => 'New Admin',
            'email' => 'new-admin@example.com',
            'role' => 'recipient',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/admin/settings');

    $this->assertDatabaseHas('users', [
        'email' => 'new-admin@example.com',
        'role' => 'recipient',
    ]);
});

test('recipients cannot access admin creation routes', function () {
    $recipient = User::factory()->create(['role' => 'recipient']);

    $response = $this
        ->actingAs($recipient)
        ->post('/admin/settings/admin', [
            'name' => 'Blocked User',
            'email' => 'blocked@example.com',
            'role' => 'admin',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

    $response->assertForbidden();
});
