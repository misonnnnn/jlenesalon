<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::query()
            ->with(['menu.service'])
            ->orderByDesc('starts_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function events(Request $request): JsonResponse
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = Booking::query()->with(['menu.service'])->orderBy('starts_at');

        if ($start && $end) {
            $query->whereBetween('starts_at', [$start, $end]);
        }

        $events = $query->get()->map(function (Booking $booking) {
            $menu = $booking->menu;
            $service = $menu?->service;
            $startAt = $booking->starts_at instanceof Carbon
                ? $booking->starts_at->copy()
                : Carbon::parse($booking->starts_at);

            $durationMinutes = $this->parseDurationToMinutes($menu?->duration);
            $endAt = $startAt->copy()->addMinutes($durationMinutes);

            return [
                'id' => $booking->id,
                'title' => sprintf(
                    '%s - %s (%s)',
                    $service?->name_en ?? 'Service',
                    $menu?->title_en ?? $menu?->title ?? 'Menu',
                    $booking->customer_name
                ),
                'start' => $startAt->format('Y-m-d H:i:s'),
                'end' => $endAt->format('Y-m-d H:i:s'),
                'backgroundColor' => '#635bff',
                'borderColor' => '#4f46e5',
                'textColor' => '#ffffff',
            ];
        })->values();

        return response()->json($events);
    }

    private function parseDurationToMinutes(?string $duration): int
    {
        if (!$duration) {
            return 60;
        }

        if (preg_match('/(\d+)/', $duration, $matches)) {
            return max((int) $matches[1], 15);
        }

        return 60;
    }
}
