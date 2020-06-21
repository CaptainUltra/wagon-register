<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $this->authorize('create', Wagon::class);

        $wagon = Wagon::create($this->validateRequest());
        
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

        if(request()->has('show-events') && request('show-events')){
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
    public function update(Request $request, Wagon $wagon)
    {
        $this->authorize('update', $wagon);

        $wagon->update($this->validateRequest());

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
    /**
     * Validate data from request.
     * 
     * @return mixed
     */
    private function validateRequest()
    {
        return request()->validate([
            'number' => 'required',
            'letter_index'=> '',
            'v_max'=> '',
            'seats'=> '',
            'depot_id' => '',
            'revisory_point_id' => '',
            'revision_date' => '',
            'status_id' => '',
            //'index_image_id'=> ''
        ]);
    }
}
