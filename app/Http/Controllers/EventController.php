<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Event as EventResource;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Event::class);

        $events = Event::paginate(15);
        if(request()->has('date'))
        {
            $events = Event::where('created_at', request('date'))->paginate(15);
        }
        if(request()->has('wagon_id'))
        {
            $events = Event::where('wagon_id', request('wagon_id'))->paginate(15);
        }
        if(request()->has('user_id'))
        {
            $events = Event::where('user_id', request('user_id'))->paginate(15);
        }
        if(request()->has('show-wagon') && request('show-wagon')){
            $events = Event::with('wagon')->paginate(15);
        }
        return EventResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $data = array_merge($this->validateRequest(), ['user_id' => Auth::user()->id]);

        $event = Event::create($data);
        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        if(request()->has('show-wagon') && request('show-wagon')){
            $eventId = $event->id;
            $event = Event::with('wagon')->find($eventId);
        }

        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($this->validateRequest());

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
    /**
     * Validate data from request.
     * 
     * @return mixed
     */
    private function validateRequest()
    {
        return request()->validate([
            'date' => 'required',
            'wagon_id' => 'required|exists:wagons,id',
            'station_id' => 'required_without:train_id',
            'train_id'=> 'required_without:station_id',
            'comment' => ''
        ]);
    }
}
