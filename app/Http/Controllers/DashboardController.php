<?php

namespace App\Http\Controllers;

use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::all();

        return response()->json(['rooms' => $rooms]);
    }

    public function rooms()
    {
        $rooms = Room::all();

        return $rooms;
    }
}
