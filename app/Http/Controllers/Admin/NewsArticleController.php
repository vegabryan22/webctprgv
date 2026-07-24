<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NewsArticleController extends Controller
{
    public function index(Request $request): View
    {
        $articles = NewsArticle::with(['category', 'author'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('published_at')->latest('id')->paginate(20)->withQueryString();

        return view('admin.news.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.news.form', ['article' => new NewsArticle, 'categories' => NewsCategory::orderBy('name')->get()]);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data = $this->prepare($request, $data, $sanitizer);
        $data['author_id'] = $request->user()->id;
        NewsArticle::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Noticia creada correctamente.');
    }

    public function edit(NewsArticle $article): View
    {
        return view('admin.news.form', ['article' => $article, 'categories' => NewsCategory::orderBy('name')->get()]);
    }

    public function update(Request $request, NewsArticle $article, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $article);
        $this->ensureCanPublish($request, $data['status']);
        $article->update($this->prepare($request, $data, $sanitizer, $article));

        return redirect()->route('admin.news.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(NewsArticle $article): RedirectResponse
    {
        foreach ([$article->image_path, $article->attachment_path] as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }
        $article->delete();

        return redirect()->route('admin.news.index')->with('success', 'Noticia eliminada correctamente.');
    }

    private function validated(Request $request, ?NewsArticle $article = null): array
    {
        return $request->validate([
            'news_category_id' => ['required', 'integer', 'exists:news_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('news_articles')->ignore($article)],
            'summary' => ['required', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:published_at'],
            'image' => ['nullable', 'image', 'max:4096'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
        ]);
    }

    private function prepare(Request $request, array $data, HtmlContentSanitizer $sanitizer, ?NewsArticle $article = null): array
    {
        unset($data['image'], $data['attachment']);
        $data['slug'] = Str::slug($data['slug']);
        $data['content'] = $sanitizer->sanitize($data['content']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['published_at'] = $data['status'] === 'published' ? ($data['published_at'] ?? $article?->published_at ?? now()) : null;

        foreach (['image', 'attachment'] as $field) {
            if (! $request->hasFile($field)) {
                continue;
            }
            $oldPath = $field === 'image' ? $article?->image_path : $article?->attachment_path;
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            $data[$field.'_path'] = $request->file($field)->store('news/'.$field, 'public');
        }

        return $data;
    }

    private function ensureCanPublish(Request $request, string $status): void
    {
        abort_if($status === 'published' && ! $request->user()->hasPermission('news.publish'), 403);
    }
}
