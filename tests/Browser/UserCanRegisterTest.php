<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'CesarAcual')
                    ->type('first_name', 'Cesar')
                    ->type('last_name', 'Acual')
                    ->type('email', 'checha@gmail.com')
                    ->type('password', 'secret')
                    ->type('password_confirmation', 'secret')
                    ->press('@register-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }

    /** @test */
    function user_cannot_register_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('register'))
                    ->type('name', '')
                    ->press('@register-btn')
                    ->assertPathIs('/register')
                    ->assertPresent('@validation-errors');
        });
    }
}
