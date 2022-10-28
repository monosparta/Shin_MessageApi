<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\UserDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentDataResource extends JsonResource
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
            'id' => $this->id,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'parent' => new CommentDataResource($this->parent),
            'user' => new AuthorDataResource($this->user)
        ];
    }
}
