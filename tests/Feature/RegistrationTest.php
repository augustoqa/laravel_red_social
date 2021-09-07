<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_register()
    {
        $userData = [
            'name' => 'CesarAugusto',
            'first_name' => 'Cesar',
            'last_name' => 'Acual',
            'email' => 'checha@email.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'name' => 'CesarAugusto',
            'first_name' => 'Cesar',
            'last_name' => 'Acual',
            'email' => 'checha@email.com',
        ]);

        $this->assertTrue(
            Hash::check('secret', User::first()->password),
            'The password needs to be hashed'
        );
    }
}
