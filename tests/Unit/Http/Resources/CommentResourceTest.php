<?php

namespace Tests\Unit\Http\Resources;

use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Resources\CommentResource;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_comment_resources_must_have_the_necessary_fields()
    {
        $comment = factory(Status::class)->create();

        $commentResource = CommentResource::make($comment)->resolve();

        $this->assertEquals(
            $comment->body, 
            $commentResource['body']
        );

        $this->assertEquals(
            $comment->user->name, 
            $commentResource['user_name']
        );

        $this->assertEquals(
            'avatar.png', 
            $commentResource['user_avatar']
        );
    }
}
