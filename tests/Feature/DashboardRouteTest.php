<?php

use App\Models\User;

test('authenticated users see the admin dashboard on the dashboard route', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response
        ->assertOk()
        ->assertSee('Dashboard Overview')
        ->assertDontSee("You're logged in!");
});
