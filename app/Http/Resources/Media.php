<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Media extends JsonResource
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
            'collection_name' => $this->collection_name,
            'name' => $this->name,
            'url' => $this->getFullUrl(),
            'mime_type' => $this->mime_type,
            'disk' => $this->disk,
            'size' => $this->size,
        ];
    }
}
