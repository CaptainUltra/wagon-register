<?php

namespace App\Http\Controllers;

use App\WagonType;
use Illuminate\Http\Request;

class WagonTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        WagonType::create($this->validateRequest());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WagonType  $wagontype
     * @return \Illuminate\Http\Response
     */
    public function show(WagonType $wagontype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WagonType  $wagontype
     * @return \Illuminate\Http\Response
     */
    public function edit(WagonType $wagontype)
    {
        //
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
        $wagontype->update($this->validateRequest());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WagonType  $wagontype
     * @return \Illuminate\Http\Response
     */
    public function destroy(WagonType $wagontype)
    {
        $wagontype->delete();
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
            'interior_type_id' => 'required',
            'index_image_id' =>'int'
        ]);
    }
}
