<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWagonRequest;
use App\Http\Requests\UpdateWagonRequest;
use App\Wagon;
use Illuminate\Http\Request;
use App\Http\Resources\Wagon as WagonResource;
use Symfony\Component\HttpFoundation\Response;

class WagonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Wagon::class);

        $wagons = Wagon::allWagons();

        return WagonResource::collection($wagons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWagonRequest $request)
    {
        $wagon = Wagon::create($request->validated());

        return (new WagonResource($wagon))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wagon  $wagon
     * @return \Illuminate\Http\Response
     */
    public function show(Wagon $wagon)
    {
        $this->authorize('view', $wagon);

        if (request()->has('show-events') && request('show-events')) {
            $wagonId = $wagon->id;
            $wagon = Wagon::with(['events' => function ($query) {
                $query->orderBy('date', 'desc')->paginate(3);
            }])->find($wagonId);
        }

        return new WagonResource($wagon);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wagon  $wagon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWagonRequest $request, Wagon $wagon)
    {
        $wagon->update($request->validated());

        return (new WagonResource($wagon))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wagon  $wagon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wagon $wagon)
    {
        $this->authorize('delete', $wagon);

        $wagon->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
