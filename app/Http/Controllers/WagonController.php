<?php

namespace App\Http\Controllers;

use App\Wagon;
use Illuminate\Http\Request;

class WagonController extends Controller
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
        Wagon::create($this->validateRequest());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wagon  $wagon
     * @return \Illuminate\Http\Response
     */
    public function show(Wagon $wagon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wagon  $wagon
     * @return \Illuminate\Http\Response
     */
    public function edit(Wagon $wagon)
    {
        //
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
    }
    private function validateRequest()
    {
        return request()->validate([
            'number' => 'required|unique:wagons',
            'type_id' => '',
            'letter_index'=> '',
            'v_max'=> 'int',
            'seats'=> 'int',
            'depot_id' => 'int',
            'revision_point_id' => 'int',
            'revision_date' => 'date',
            //'index_image_id'=> ''
        ]);
    }
}
