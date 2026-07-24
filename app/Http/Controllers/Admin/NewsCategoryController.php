<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.news-categories.index', ['categories' => NewsCategory::withCount('articles')->orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        NewsCategory::create($data);

        return back()->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, NewsCategory $newsCategory): RedirectResponse
    {
        $data = $this->validated($request, $newsCategory);
        $data['slug'] = Str::slug($data['name']);
        $newsCategory->update($data);

        return back()->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(NewsCategory $newsCategory): RedirectResponse
    {
        abort_if($newsCategory->articles()->exists(), 422, 'No se puede eliminar una categoría con noticias.');
        $newsCategory->delete();

        return back()->with('success', 'Categoría eliminada correctamente.');
    }

    private function validated(Request $request, ?NewsCategory $category = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('news_categories')->ignore($category)],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);
    }
}
