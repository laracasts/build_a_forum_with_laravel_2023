<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->user),
            'post' => PostResource::make($this->post),
            'body' => $this->body,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
