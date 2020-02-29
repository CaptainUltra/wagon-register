<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Wagon extends JsonResource
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
                'stylized_number' => $this->getStylizedNumber(),
                'type' => new WagonType($this->wagonType),
                'letter_index' => $this->letter_index,
                'v_max' => $this->v_max,
                'seats' => $this->seats,
                'depot' => new Depot($this->depot),
                'revisory_point' => new RevisoryPoint($this->revisoryPoint),
                'revision_date' => isset($this->revision_date) ? $this->revision_date->format('d.m.Y') : null,
                'revision_expiration_date' => isset($this->revision_exp_date) ? $this->revision_exp_date->format('d.m.Y') : null,
                'events' => Event::collection($this->whenLoaded('events')),
                'last_updated' => $this->updated_at->format('d.m.Y h:i:s')
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
