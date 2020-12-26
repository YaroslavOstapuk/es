<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'descriptions' => $this->descriptions,
            'status' => $this->status,
            'user' => new UserResource($this->whenLoaded('user')),
            'photos' => Media::collection($this->whenLoaded('media'))
        ];
    }
}
