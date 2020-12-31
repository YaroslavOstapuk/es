<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class QuestionSimpleResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'descriptions' => Str::limit($this->descriptions, 80),
            'status' => $this->status,
            'user' => new UserResource($this->whenLoaded('user')),
            'photos' => Media::collection($this->whenLoaded('media'))
        ];
    }
}
