<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.service-categories.index', ['categories' => ServiceCategory::withCount('services')->orderBy('sort_order')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        ServiceCategory::create($data);

        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, ServiceCategory $serviceCategory): RedirectResponse
    {
        $data = $this->validated($request, $serviceCategory);
        $data['slug'] = Str::slug($data['name']);
        $serviceCategory->update($data);

        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(ServiceCategory $serviceCategory): RedirectResponse
    {
        abort_if($serviceCategory->services()->exists(), 422, 'No se puede eliminar una categoría con servicios.');
        $serviceCategory->delete();

        return back()->with('success', 'Categoría eliminada correctamente.');
    }

    private function validated(Request $request, ?ServiceCategory $category = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('service_categories')->ignore($category)],
            'icon' => ['required', 'regex:/^fa-[a-z0-9-]+$/'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
