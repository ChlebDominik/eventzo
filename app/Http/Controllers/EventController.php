<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Neskôr sem pridáme načítanie eventov z DB
        return view('events.index');
    }
}
