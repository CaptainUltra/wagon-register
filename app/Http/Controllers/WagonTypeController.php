<?php

namespace App\Http\Controllers;

use App\WagonType;
use App\Http\Resources\WagonType as WagonTypeResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WagonTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', WagonType::class);

        if (request()->has('pagination') && !request('pagination')) {
            $wagonTypes = WagonType::all();
        }
        else
        {
            $wagonTypes = WagonType::paginate(15);
        }

        return WagonTypeResource::collection($wagonTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', WagonType::class);

        $wagonType = WagonType::create($this->validateRequest());

        return (new WagonTypeResource($wagonType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WagonType  $wagontype
     * @return \Illuminate\Http\Response
     */
    public function show(WagonType $wagontype)
    {
        $this->authorize('view', $wagontype);

        return new WagonTypeResource($wagontype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WagonType  $wagontype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WagonType $wagontype)
    {
        $this->authorize('update', $wagontype);

        $wagontype->update($this->validateRequest());

        return (new WagonTypeResource($wagontype))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WagonType  $wagontype
     * @return \Illuminate\Http\Response
     */
    public function destroy(WagonType $wagontype)
    {
        $this->authorize('delete', $wagontype);
        
        $wagontype->delete();

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
            'name' => 'required',
            'conditioned' => 'required|bool',
            'revision_valid_for' => 'required|int',
            'interior_type_id' => 'required|exists:interior_types,id',
            'index_image_id' =>'int'
        ]);
    }
}
