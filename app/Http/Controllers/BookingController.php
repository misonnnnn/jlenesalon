<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceMenu;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $services = Service::query()
            ->where('is_active', true)
            ->with([
                'menus' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
            ])
            ->orderBy('sort_order')
            ->get();

        $preselectedService = $request->query('service');
        $preselectedMenu = $request->query('menu');

        $oldMenuId = (int) $request->old('service_menu_id', 0);
        if ($oldMenuId > 0) {
            $oldMenu = ServiceMenu::query()->with('service')->find($oldMenuId);
            if ($oldMenu && $oldMenu->service && $oldMenu->service->is_active) {
                $preselectedService = $oldMenu->service->slug;
            }
        }

        return view('booking', compact('services', 'preselectedService', 'preselectedMenu'));
    }

    public function store(StoreBookingRequest $request)
    {
        Booking::create($request->validated() + ['status' => 'pending']);

        return redirect()
            ->route('bookings.create')
            ->with('status', 'booking_submitted');
    }
}
