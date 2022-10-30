<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\UserDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentRepliesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'comment_id' => $this->id,
            'replies' => CommentDataResource::collection($this->replies)
        ];
    }
}
