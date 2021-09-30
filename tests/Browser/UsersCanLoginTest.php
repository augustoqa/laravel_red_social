<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function registered_users_can_login()
    {
        \factory(User::class)->create(['email' => 'jorge@email.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'jorge@email.com')
                    ->type('password', 'secret')
                    ->press('@login-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }

    /** @test */
    function user_cannot_login_with_invalid_information()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                    ->type('email', '')
                    ->press('@login-btn')
                    ->assertPathIs('/login')
                    ->assertPresent('@validation-errors');
        });
    }
}
