<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceMenu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    public function unavailableSlots(Request $request): JsonResponse
    {
        $start = $request->query('start')
            ? Carbon::parse((string) $request->query('start'))
            : now()->startOfDay();
        $end = $request->query('end')
            ? Carbon::parse((string) $request->query('end'))
            : now()->addMonths(3)->endOfDay();

        $slots = Booking::query()
            ->whereBetween('starts_at', [$start, $end])
            ->where('status', '!=', 'cancelled')
            ->orderBy('starts_at')
            ->pluck('starts_at')
            ->map(function ($value) {
                $date = $value instanceof Carbon ? $value : Carbon::parse($value);

                return $date->format('Y-m-d H:i');
            })
            ->values();

        return response()->json([
            'slots' => $slots,
        ]);
    }
}
