<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['settings' => SiteSetting::orderBy('group')->orderBy('label')->get()->groupBy('group')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $values = $request->validate(['settings' => ['array']])['settings'] ?? [];
        foreach (SiteSetting::all() as $setting) {
            $setting->update(['value' => $values[$setting->key] ?? null]);
        }

        return back()->with('success', 'Configuración actualizada correctamente.');
    }
}
