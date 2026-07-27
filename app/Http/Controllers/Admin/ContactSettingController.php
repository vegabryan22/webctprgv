<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactSettingController extends Controller
{
    private const KEYS = [
        'contact_heading',
        'contact_intro',
        'contact_phone',
        'contact_phone_secondary',
        'contact_email',
        'contact_notification_email',
        'contact_hours',
        'contact_address',
        'contact_map_url',
        'contact_verified_at',
        'contact_source',
    ];

    public function edit(): View
    {
        return view('admin.contact.edit', [
            'settings' => SiteSetting::whereIn('key', self::KEYS)->pluck('value', 'key'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $values = $request->validate([
            'contact_heading' => ['required', 'string', 'max:120'],
            'contact_intro' => ['nullable', 'string', 'max:500'],
            'contact_phone' => ['nullable', 'string', 'max:40'],
            'contact_phone_secondary' => ['nullable', 'string', 'max:40'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_notification_email' => ['nullable', 'email', 'max:255'],
            'contact_hours' => ['nullable', 'string', 'max:255'],
            'contact_address' => ['nullable', 'string', 'max:500'],
            'contact_map_url' => ['nullable', 'url', 'max:1000'],
            'contact_verified_at' => ['nullable', 'date'],
            'contact_source' => ['nullable', 'string', 'max:255'],
        ]);

        foreach (self::KEYS as $key) {
            SiteSetting::where('key', $key)->update(['value' => $values[$key] ?? null]);
        }

        return back()->with('success', 'Información de contacto actualizada.');
    }
}
