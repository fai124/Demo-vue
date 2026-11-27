<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function room_addform(RoomRequest $request)
    {
        $room = new Room();
        $room->name = $request->name;
        $room->description = $request->description;
        if ($request->hasFile('image')) {
            $room->image = Storage::disk('public')->putFile('rooms', $request->file('image'));
        }
        $room->save();

        return ['id' => $room->id];
    }

    public function room_delete(Room $room)
    {
        $room->name = 'зал удален';
        $room->save();

        return ['message' => 'ok'];
    }

    public function room_edit(Room $room)
    {
        return $room;
    }

    public function room_editform(RoomRequest $request, Room $room)
    {
        $room->name = $request->name;
        $room->description = $request->description;
        if ($request->hasFile('image')) {
            $room->image = Storage::disk('public')->putFile('rooms', $request->file('image'));
        } elseif ($request->input('old_image')) {
            $room->image = $request->input('old_image');
        }
        $room->save();

        return ['id' => $room->id];
    }

    public function create()
    {
        //
    }

    public function edit(Room $room)
    {
        //
    }
}
