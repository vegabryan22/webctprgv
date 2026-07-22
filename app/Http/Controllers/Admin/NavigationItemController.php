<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\NavigationItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NavigationItemController extends Controller
{
    public function index(): View
    {
        $destinations = ContentPage::whereNotNull('route_name')->orderBy('title')->get(['title', 'route_name']);
        $destinations->push((object) ['title' => 'Calendario de actividades', 'route_name' => 'calendar.index']);

        return view('admin.navigation.index', [
            'items' => NavigationItem::orderBy('sort_order')->orderBy('id')->get(),
            'pages' => $destinations->sortBy('title'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        NavigationItem::create($this->validated($request));

        return back()->with('success', 'Elemento del menú creado correctamente.');
    }

    public function update(Request $request, NavigationItem $navigationItem): RedirectResponse
    {
        $navigationItem->update($this->validated($request));

        return back()->with('success', 'Elemento del menú actualizado correctamente.');
    }

    public function destroy(NavigationItem $navigationItem): RedirectResponse
    {
        $navigationItem->delete();

        return back()->with('success', 'Elemento eliminado del menú. La página asociada no fue eliminada.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:60'],
            'route_name' => ['nullable', 'string', Rule::in($this->allowedRoutes())],
            'url' => ['nullable', 'url:http,https', 'max:2048', 'required_without:route_name'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
            'open_in_new_tab' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['open_in_new_tab'] = $request->boolean('open_in_new_tab');
        $data['url'] = filled($data['route_name'] ?? null) ? null : ($data['url'] ?? null);

        return $data;
    }

    private function allowedRoutes(): array
    {
        return ContentPage::whereNotNull('route_name')->pluck('route_name')->push('calendar.index')->all();
    }
}
