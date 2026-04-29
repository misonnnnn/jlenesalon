<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
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

        $data = [
            'services' => $services,
            'pageTitle' => 'Jlene Salon',
            'pageDescription' => [
                'en' => 'Jlene Salon is a professional salon and skin care service provider that believes beauty starts with care. Our team is designed to relax and refresh your body and mind, bringing out your best self.',
                'ja' => 'Jlene Salonでは、美しさはケアから始まると考えています。私たちの専門チームは、リラックスしながら心身をリフレッシュし、最高のあなたを引き出すために設計されたプロフェッショナルなサロンおよびスキンケアサービスをご提供しています。',
            ],
            'pageWelcomeMessage' => [
                'en' => 'Welcome to <span class="title_font fs-4 ms-2">Jlene Salon </span>',
                'ja' => '<span class="title_font fs-4 ms-2">Jlene Salon </span>へようこそ',
            ],
            'pageBookNowButtonText' => [
                'en' => 'Book Now',
                'ja' => '予約する',
            ],
            'pageSeeServicesButtonText' => [
                'en' => 'See Services',
                'ja' => 'サービスを見る',
            ],
        ];

        return view('home', $data);
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
        if (!SiteSetting::isLanguageSelectorEnabled()) {
            $request->session()->put('site_locale', 'en');

            return redirect()->back();
        }

        if (!in_array($locale, self::ALLOWED_LOCALES, true)) {
            $locale = 'ja';
        }

        $request->session()->put('site_locale', $locale);

        return redirect()->back();
    }
}
