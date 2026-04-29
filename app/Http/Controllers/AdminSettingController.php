<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'languageSelectorEnabled' => SiteSetting::isLanguageSelectorEnabled(),
        ]);
    }

    public function updateLanguageSelector(Request $request): RedirectResponse
    {
        SiteSetting::setLanguageSelectorEnabled($request->boolean('language_selector_enabled'));

        return redirect()
            ->route('admin.settings.index')
            ->with('status', 'Language selector setting updated successfully.');
    }
}
