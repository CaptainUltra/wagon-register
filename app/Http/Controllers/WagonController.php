<?php

namespace App\Http\Controllers;

use App\Wagon;
use App\Http\Resources\Wagon as WagonResource;
use Illuminate\Http\Request;
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
        return WagonResource::collection(Wagon::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
            'number' => 'required|unique:wagons',
            'letter_index'=> 'string',
            'v_max'=> 'integer',
            'seats'=> 'integer',
            'depot_id' => 'integer|exists:depots,id',
            'revisory_point_id' => 'integer|exists:revisory_points,id',
            'revision_date' => 'date',
            //'index_image_id'=> ''
        ]);
    }
}
