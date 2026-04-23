<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private const ALLOWED_LOCALES = ['en', 'ja'];

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

    public function setLanguage(Request $request, string $locale)
    {
        if (!in_array($locale, self::ALLOWED_LOCALES, true)) {
            $locale = 'ja';
        }

        $request->session()->put('site_locale', $locale);

        return redirect()->back();
    }
}
