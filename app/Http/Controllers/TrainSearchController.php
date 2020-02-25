<?php

namespace App\Http\Controllers;

use App\Train;
use App\Http\Resources\Train as TrainResource;
use Illuminate\Http\Request;

class TrainSearchController extends Controller
{
    public function index()
    {
        $data = request()->validate([
            'searchTerm' => 'required'
        ]);

        $trains = Train::search($data['searchTerm'])->get()->take(4);
        return TrainResource::collection($trains);
    }
}
