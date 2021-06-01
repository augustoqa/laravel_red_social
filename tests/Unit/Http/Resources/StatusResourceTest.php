<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatusResourceTest extends TestCase
{
    /** @test */
    public function a_status_resources_must_have_the_necessary_fields()
    {
        $status = factory(Status::class)->create();

        $statusResource = StatusResource::make($status)->resolve();

        $this->assertEquals(
            $status->body, 
            $statusResource['body']
        );
        
        $this->assertEquals(
            $status->user->name, 
            $statusResource['user_name']
        );
        
        $this->assertEquals(
            'avatar.png', 
            $statusResource['user_avatar']
        );
        
        $this->assertEquals(
            $status->created_at->diffForHumans(), 
            $statusResource['ago']
        );
        
    }
}
