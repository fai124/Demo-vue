<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function booking_room($id)
    {
        $room = Room::find($id);

        return ['room' => $room];
    }

    public function booking_addform(BookingRequest $request)
    {
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->room_id = $request->room_id;
        $booking->date = $request->date;
        $booking->payment = $request->payment;
        $booking->status = 'new';
        $booking->save();

        return ['id' => $booking->id];
    }

    public function booking_admin()
    {
        $bookings = Booking::with('user', 'room')->get();

        return $bookings;
    }

    public function booking_update_status(Request $request, Booking $booking)
    {

        $booking->status = $request->status;
        $booking->save();

        return ['message' => 'ok'];
    }

    public function booking_list()
    {
        $bookings = Booking::where('user_id', Auth::id())->with('room')->get();

        return $bookings;
    }

    public function booking_review(Request $request, Booking $booking)
    {
        $booking->comment = $request->comment;
        $booking->save();

        return ['message' => 'ok'];
    }

    public function create()
    {
        //
    }

    public function edit(Booking $booking)
    {
        //
    }
}
