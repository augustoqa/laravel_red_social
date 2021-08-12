<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_users_can_not_like_comments()
    {
        $comment = factory(Comment::class)->create();
        $response = $this->postJson(route('comments.likes.store', $comment));

        $response->assertStatus(401);
    }
}
