<?php

namespace App\Http\Controllers;

use App\InteriorType;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Int_;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\InteriorType as InteriorTypeResource;

class InteriorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', InteriorType::class);

        return InteriorTypeResource::collection(InteriorType::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', InteriorType::class);

        $interiorType  = InteriorType::create($this->validateRequest());

        return (new InteriorTypeResource($interiorType))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InteriorType  $interiortype
     * @return \Illuminate\Http\Response
     */
    public function show(InteriorType $interiortype)
    {
        $this->authorize('view', $interiortype);

        return new InteriorTypeResource($interiortype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InteriorType  $interiortype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InteriorType $interiortype)
    {
        $this->authorize('update', $interiortype);

        $interiortype->update($this->validateRequest());

        return (new InteriorTypeResource($interiortype))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InteriorType  $interiortype
     * @return \Illuminate\Http\Response
     */
    public function destroy(InteriorType $interiortype)
    {
        $this->authorize('delete', $interiortype);
        
        $interiortype->delete();

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
            'name' => 'required'
        ]);
    }
}
