<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSectionController extends Controller
{
    public function index(): View
    {
        return view('admin.site-sections.index', [
            'sections' => SiteSection::orderBy('sort_order')->get(),
            'maintenance' => SiteSetting::where('group', 'mantenimiento')->pluck('value', 'key'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'active' => ['nullable', 'array'],
            'active.*' => ['string'],
            'maintenance_enabled' => ['nullable', 'boolean'],
            'maintenance_title' => ['required', 'string', 'max:120'],
            'maintenance_message' => ['required', 'string', 'max:500'],
        ]);
        $active = $data['active'] ?? [];

        SiteSection::query()->each(fn (SiteSection $section) => $section->update([
            'is_active' => in_array($section->key, $active, true),
        ]));

        foreach ([
            'maintenance_enabled' => $request->boolean('maintenance_enabled') ? '1' : '0',
            'maintenance_title' => $data['maintenance_title'],
            'maintenance_message' => $data['maintenance_message'],
        ] as $key => $value) {
            SiteSetting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Estado público del sitio actualizado.');
    }
}
