<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

test('confirm password screen can be shown', function () {
    $user = User::factory()->create();

    $res = $this->actingAs($user)->get('/user/confirm-password');

    $res->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = User::factory()->create();

    $res = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'password',
    ]);

    $res->assertRedirect();
    $res->assertSessionHasNoErrors();
});

test('wrong password cannot be confirmed', function () {
    $user = User::factory()->create();

    $res = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $res->assertSessionHasErrors();
});
