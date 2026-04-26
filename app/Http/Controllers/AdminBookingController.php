<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::query()
            ->with(['menu.service'])
            ->orderByDesc('starts_at')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }
}
