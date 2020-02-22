<?php

namespace App\Http\Controllers;

use App\Train;
use App\Http\Resources\Train as TrainResource;
use App\WagonType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Train::class);

        return TrainResource::collection(Train::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Train::class);

        $train = Train::create($this->validateRequest());
        $wagonTypes = $this->validateRequest()['wagontypes'];
        $i = 1;
        foreach($wagonTypes as $wagonType)
        {
            $wagonTypeInstance = WagonType::all()->find($wagonType);
            $train->wagonTypes()->save($wagonTypeInstance, ['position' => $i]);
            $i++;
        }
        
        return (new TrainResource($train))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function show(Train $train)
    {
        $this->authorize('view', $train);

        return new TrainResource($train);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Train $train)
    {
        $this->authorize('update', $train);

        $wagonTypes = $this->validateRequest()['wagontypes'];
        $i = 1;
        foreach($wagonTypes as $wagonType)
        {
            $wagonTypeInstance = WagonType::all()->find($wagonType);
            $train->wagonTypes()->save($wagonTypeInstance, ['position' => $i]);
            $i++;
        }

        $train->update($this->validateRequest());

        return (new TrainResource($train))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Train  $train
     * @return \Illuminate\Http\Response
     */
    public function destroy(Train $train)
    {
        $this->authorize('delete', $train);
        
        $train->delete();
        
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
            'route' => 'required',
            'description' => '',
            'wagontypes'=>''
        ]);
    }
}
