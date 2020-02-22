<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Train extends JsonResource
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
                'number' => $this->number,
                'route' => $this->route,
                'description' => $this->description,
                'wagontypes' => WagonType::collection($this->wagonTypes),
                'last_updated' => $this->updated_at->format('d.m.Y h:i:s')
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
