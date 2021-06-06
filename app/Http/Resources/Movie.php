<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Movie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'genres'       => Genre::collection($this->whenLoaded('genres')),
            'release_date' => $this->release_date->toDateString(),
            'watched_at'   => $this->watched_at ? $this->watched_at->toDateTimeString() : null,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        );
    }
}
