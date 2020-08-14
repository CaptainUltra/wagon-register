<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
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
                'date' => $this->date->format('d.m.Y'),
                'comment' => $this->comment,
                'station' => new Station($this->station),
                'train' => new Train($this->train),
                'wagon' => [
                    'id' => $this->wagon->id,
                    'number' => $this->wagon->getStylizedNumber()
                ],
                'last_updated' => $this->updated_at->format('d.m.Y h:i:s')
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
