<?php

namespace App\Http\Controllers;

use App\Models\Room;

class DashboardController extends Controller
{
    public function rooms()
    {
        $rooms = Room::all();

        return response()->json($rooms);
    }
}
