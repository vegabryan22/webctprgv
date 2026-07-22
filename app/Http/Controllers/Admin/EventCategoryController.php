<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EventCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.event-categories.index', ['categories' => EventCategory::withCount('events')->orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        EventCategory::create($data);

        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, EventCategory $eventCategory): RedirectResponse
    {
        $data = $this->validated($request, $eventCategory);
        $data['slug'] = Str::slug($data['name']);
        $eventCategory->update($data);

        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(EventCategory $eventCategory): RedirectResponse
    {
        abort_if($eventCategory->events()->exists(), 422, 'No se puede eliminar una categoría que contiene actividades.');
        $eventCategory->delete();

        return back()->with('success', 'Categoría eliminada correctamente.');
    }

    private function validated(Request $request, ?EventCategory $category = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('event_categories')->ignore($category)],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);
    }
}
