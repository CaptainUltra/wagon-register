<?php

namespace App\Http\Controllers;

use App\Http\Resources\Wagon as WagonResource;
use App\Wagon;
use Illuminate\Http\Request;

class WagonSearchController extends Controller
{
    public function index()
    {
        $data = request()->validate([
            'searchTerm' => 'required'
        ]);

        $wagons = Wagon::search($data['searchTerm'])->get()->take(4);

        return WagonResource::collection($wagons);
    }
}
