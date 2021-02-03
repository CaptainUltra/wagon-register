<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function homepage()
    {
        return view('homepage');
    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function gallery()
    {
        return view('gallery');
    }
}
