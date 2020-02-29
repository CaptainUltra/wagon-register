<?php

namespace App\Http\Controllers;

use App\Station;
use App\Http\Resources\Station as StationResource;
use Illuminate\Http\Request;

class StationSearchController extends Controller
{
    public function index()
    {
        $data = request()->validate([
            'searchTerm' => 'required'
        ]);

        $stations = Station::search($data['searchTerm'])->get()->take(4);
        return StationResource::collection($stations);
    }
}
