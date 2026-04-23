<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', compact('services'));
    }

    public function showService(Service $service)
    {
        abort_unless($service->is_active, 404);

        $service->load([
            'menus' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
        ]);

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('service-show', compact('service', 'services'));
    }
}
