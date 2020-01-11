<?php

namespace App\Http\Controllers;

use App\Depot;
use Illuminate\Http\Request;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Depot::all();
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
        Depot::create($this->validateRequest());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function show(Depot $depot)
    {
        return $depot;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function edit(Depot $depot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Depot $depot)
    {
        $depot->update($this->validateRequest());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Depot  $depot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Depot $depot)
    {
        $depot->delete();
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
