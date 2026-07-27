<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSectionController extends Controller
{
    public function index(): View
    {
        return view('admin.site-sections.index', [
            'sections' => SiteSection::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $active = $request->validate(['active' => ['nullable', 'array'], 'active.*' => ['string']])['active'] ?? [];

        SiteSection::query()->each(fn (SiteSection $section) => $section->update([
            'is_active' => in_array($section->key, $active, true),
        ]));

        return back()->with('success', 'Estado público del sitio actualizado.');
    }
}
