<?php

namespace App\Http\Controllers;

use App\InteriorType;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Int_;

class InteriorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InteriorType::all();
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
        InteriorType::create($this->validateRequest());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InteriorType  $interiortype
     * @return \Illuminate\Http\Response
     */
    public function show(InteriorType $interiortype)
    {
        return $interiortype;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InteriorType  $interiortype
     * @return \Illuminate\Http\Response
     */
    public function edit(InteriorType $interiortype)
    {
        //
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
        $interiortype->update($this->validateRequest());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InteriorType  $interiortype
     * @return \Illuminate\Http\Response
     */
    public function destroy(InteriorType $interiortype)
    {
        $interiortype->delete();
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
