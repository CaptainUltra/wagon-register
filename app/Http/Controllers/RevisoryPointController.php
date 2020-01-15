<?php

namespace App\Http\Controllers;

use App\RevisoryPoint;
use Illuminate\Http\Request;

class RevisoryPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RevisoryPoint::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        RevisoryPoint::create($this->validateRequest());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RevisoryPoint  $revisorypoint
     * @return \Illuminate\Http\Response
     */
    public function show(RevisoryPoint $revisorypoint)
    {
        return $revisorypoint;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RevisoryPoint  $revisorypoint
     * @return \Illuminate\Http\Response
     */
    public function edit(RevisoryPoint $revisorypoint)
    {
        //
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
        $revisorypoint->update($this->validateRequest());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RevisoryPoint  $revisorypoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisoryPoint $revisorypoint)
    {
        $revisorypoint->delete();
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
