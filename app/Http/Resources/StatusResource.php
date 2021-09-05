<?php

namespace App\Http\Resources;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'body'        => $this->body,
            'user_name'   => $this->user->name,
            'user_avatar' => $this->user->avatar(),
            'user_link'   => $this->user->link(),
            'ago'         => $this->created_at->diffForHumans(),
            'is_liked'    => $this->isLiked(),
            'likes_count' => $this->likesCount(),
            'comments'    => CommentResource::collection($this->comments),
        ];
    }
}
