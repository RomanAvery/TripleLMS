<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

test('registration screen can be shown', function () {
    if (! Features::enabled(Features::registration())) {
        return $this->markTestSkipped('Registration support is not enabled.');
    }

    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('registration screen cannot be shown if disabled', function () {
    if (Features::enabled(Features::registration())) {
        return $this->markTestSkipped('Registration support is enabled.');
    }

    $response = $this->get('/register');

    $response->assertStatus(404);
});

test('new users can register', function () {
    if (! Features::enabled(Features::registration())) {
        return $this->markTestSkipped('Registration support is not enabled.');
    }

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});
