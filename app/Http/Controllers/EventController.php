<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {

        $this->validate($request, [
            'data' => 'required'
        ]);

        die();

//        $event = Event::create($request->all());
//        return response()->json($event, 201);
    }
}
