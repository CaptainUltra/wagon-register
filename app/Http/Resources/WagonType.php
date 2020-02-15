<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WagonType extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'conditioned' => $this->conditioned,
                'revision_valid_for' => $this->revision_valid_for,
                'interior_type' => new InteriorType($this->interiorType),
                'last_updated' => $this->updated_at->format('d.m.Y h:i:s')
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
