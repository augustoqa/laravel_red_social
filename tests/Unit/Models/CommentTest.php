<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use Tests\TestCase;
use App\User;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_comment_belongs_to_a_user()
    {
        $comment = factory(Comment::class)->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }

    /** @test */
    function a_comment_has_morph_many_likes()
    {
        $comment = factory(Comment::class)->create();

        factory(Like::class)->create([
            'likeable_id' => $comment->id,
            'likeable_type' => get_class($comment),
        ]);

        $this->assertInstanceOf(Like::class, $comment->likes->first());
    }
}
