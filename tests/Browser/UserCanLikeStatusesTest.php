<?php

namespace Tests\Browser;

use App\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    function users_can_like_and_unlike_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->waitForText('TE GUSTA')
                ->assertSee('TE GUSTA')
                ->press('@unlike-btn')
                ->waitForText('ME GUSTA')
                ->assertSee('ME GUSTA');
        });
    }
}