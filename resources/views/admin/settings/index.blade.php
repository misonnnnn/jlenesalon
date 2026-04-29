@extends('admin.layouts.app')

@section('title', 'System Settings')

@section('admin-content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-page-title">System Settings</h3>
            <p class="admin-muted mb-0 mt-1">Configure global frontend behavior.</p>
        </div>
        <div class="p-4">
            <form method="post" action="{{ route('admin.settings.language-selector') }}" class="admin-card p-3">
                @csrf
                <h5 class="mb-1">Frontend Language Selector</h5>
                <p class="admin-muted mb-3">Enable or disable the language switcher shown in the frontend header.</p>
                <div class="form-check form-switch">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="language_selector_enabled"
                        name="language_selector_enabled"
                        value="1"
                        @checked($languageSelectorEnabled)
                    >
                    <label class="form-check-label" for="language_selector_enabled">
                        Enable language selector
                    </label>
                </div>
                <p class="text-muted small mt-2 mb-3">When disabled, frontend language is fixed to English.</p>
                <button type="submit" class="btn btn-admin-primary btn-sm">Save setting</button>
            </form>
        </div>
    </div>
@endsection
