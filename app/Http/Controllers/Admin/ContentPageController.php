<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContentPageController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.index', ['pages' => ContentPage::with('author')->latest('updated_at')->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.pages.form', ['page' => new ContentPage]);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data['slug'] = Str::slug($data['slug']);
        $data['content'] = $sanitizer->sanitize($data['content'] ?? '');
        $data['author_id'] = $request->user()->id;
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        ContentPage::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Página creada correctamente.');
    }

    public function edit(ContentPage $page): View
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, ContentPage $page, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $page);
        $this->ensureCanPublish($request, $data['status']);
        $data['slug'] = $page->is_system ? $page->slug : Str::slug($data['slug']);
        $data['content'] = $sanitizer->sanitize($data['content'] ?? '');
        $data['published_at'] = $data['status'] === 'published' ? ($page->published_at ?? now()) : null;
        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Página actualizada correctamente.');
    }

    public function destroy(ContentPage $page): RedirectResponse
    {
        abort_if($page->is_system, 422, 'Las páginas institucionales no se pueden eliminar.');
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Página eliminada correctamente.');
    }

    private function validated(Request $request, ?ContentPage $page = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('content_pages')->ignore($page)],
            'summary' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ]);
    }

    private function ensureCanPublish(Request $request, string $status): void
    {
        abort_if($status === 'published' && ! $request->user()->hasPermission('pages.publish'), 403);
    }
}
