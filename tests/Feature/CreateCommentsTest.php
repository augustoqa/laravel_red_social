<?php

namespace Tests\Feature;

use App\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_users_cannot_create_comments()
    {
        $status  = factory(Status::class)->create(); 
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->postJson(route('statuses.comments.store', $status), $comment);       

        $response->assertStatus(401);
    }


    /** @test */
    function authenticated_users_can_comment_statuses()
    {
        $status  = factory(Status::class)->create();
        $user    = factory(User::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->actingAs($user)
            ->postJson(route('statuses.comments.store', $status), $comment);

        $response->assertJson([
            'data' => ['body' => $comment['body']],
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id'   => $user->id,
            'status_id' => $status->id,
            'body'      => $comment['body'],
        ]);
    }


    /** @test */
    function a_comment_requires_a_body()
    {
        $status  = factory(Status::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.comments.store', $status), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
