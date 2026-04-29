<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class AdminBookingController extends Controller
{
    private const ALLOWED_STATUSES = [
        'pending',
        'confirmed',
        'done',
        'cancelled',
        'no_show',
    ];

    public function index()
    {
        $bookings = Booking::query()
            ->with(['menu.service'])
            ->orderByDesc('starts_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['menu.service']);

        return view('admin.bookings.show', [
            'booking' => $booking,
            'allowedStatuses' => self::ALLOWED_STATUSES,
        ]);
    }

    public function update(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::ALLOWED_STATUSES)],
            'starts_at' => ['required', 'date'],
        ]);

        $startsAt = Carbon::parse((string) $validated['starts_at'])->seconds(0);
        $booking->loadMissing('menu');
        $menu = $booking->menu;

        if ($menu) {
            $conflict = Booking::query()
                ->where('id', '!=', $booking->id)
                ->where('service_menu_id', $menu->id)
                ->where('starts_at', $startsAt->format('Y-m-d H:i:s'))
                ->where('status', '!=', 'cancelled')
                ->exists();

            if ($conflict) {
                return redirect()
                    ->back()
                    ->withErrors([
                        'starts_at' => 'This date and time is already booked for this menu.',
                    ])->withInput();
            }
        }

        $booking->update([
            'status' => $validated['status'],
            'starts_at' => $startsAt,
        ]);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('status', 'Booking updated successfully.');
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
                'backgroundColor' => $booking->status === 'cancelled' ? '#9ca3af' : '#635bff',
                'borderColor' => $booking->status === 'cancelled' ? '#6b7280' : '#4f46e5',
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
