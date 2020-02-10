<?php

namespace App\Http\Controllers;

use App\RevisoryPoint;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\RevisoryPoint as RevisoryPointResource;

class RevisoryPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', RevisoryPoint::class);

        return RevisoryPointResource::collection(RevisoryPoint::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', RevisoryPoint::class);

        $revisoryPoint = RevisoryPoint::create($this->validateRequest());

        return (new RevisoryPointResource($revisoryPoint))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RevisoryPoint  $revisorypoint
     * @return \Illuminate\Http\Response
     */
    public function show(RevisoryPoint $revisorypoint)
    {
        $this->authorize('view', $revisorypoint);

        return new RevisoryPointResource($revisorypoint);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RevisoryPoint  $revisorypoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RevisoryPoint $revisorypoint)
    {
        $this->authorize('update', $revisorypoint);

        $revisorypoint->update($this->validateRequest());

        return (new RevisoryPointResource($revisorypoint))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RevisoryPoint  $revisorypoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisoryPoint $revisorypoint)
    {
        $this->authorize('delete', $revisorypoint);

        $revisorypoint->delete();

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
            'abbreviation' => 'required'
        ]);
    }
}
