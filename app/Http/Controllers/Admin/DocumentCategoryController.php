<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DocumentCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.document-categories.index', ['categories' => DocumentCategory::withCount('documents')->orderBy('sort_order')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);
        DocumentCategory::create($data);

        return back()->with('success', 'Categoría creada.');
    }

    public function update(Request $request, DocumentCategory $documentCategory): RedirectResponse
    {
        $data = $this->validated($request, $documentCategory);
        $data['slug'] = Str::slug($data['name']);
        $documentCategory->update($data);

        return back()->with('success', 'Categoría actualizada.');
    }

    public function destroy(DocumentCategory $documentCategory): RedirectResponse
    {
        abort_if($documentCategory->documents()->exists(), 422, 'La categoría contiene documentos.');
        $documentCategory->delete();

        return back()->with('success', 'Categoría eliminada.');
    }

    private function validated(Request $request, ?DocumentCategory $category = null): array
    {
        return $request->validate(['name' => ['required', 'string', 'max:100', Rule::unique('document_categories')->ignore($category)], 'icon' => ['required', 'regex:/^fa-[a-z0-9-]+$/'], 'sort_order' => ['required', 'integer', 'min:0']]);
    }
}
