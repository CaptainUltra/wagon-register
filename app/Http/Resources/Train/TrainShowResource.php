<?php

namespace App\Http\Resources\Train;

use App\Event as AppEvent;
use App\Http\Resources\Event;
use App\Http\Resources\WagonType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TrainShowResource extends JsonResource
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
                'wagontypes' => WagonType::collection($this->wagonTypes()->orderBy('position')->get()),
                'events' => $this->when(Auth::user()->can('viewAny', AppEvent::class), Event::collection($this->events()->orderByDesc('id')->get()->take(5))),
                'last_updated' => $this->updated_at->format('d.m.Y h:i:s')
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
