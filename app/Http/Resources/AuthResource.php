<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'message' => $this['message'],
            'data' => [
                'user' => [
                    'id' => $this['user']->id,
                    'email' => $this['user']->email,
                    'name' => $this['user']->name,
                ],
                'authorization' => $this['authorization'],
            ],
        ];
    }
}
