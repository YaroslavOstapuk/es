<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'message' => $this->message,
            'question_id' => $this->question_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'photos' => Media::collection($this->whenLoaded('media')),
        ];
    }
}
