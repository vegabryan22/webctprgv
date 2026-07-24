<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExploratoryWorkshop;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ExploratoryWorkshopController extends Controller
{
    public function index(): View
    {
        return view('admin.workshops.index', ['workshops' => ExploratoryWorkshop::orderBy('grade_level')->orderBy('sort_order')->get()]);
    }

    public function create(): View
    {
        return view('admin.workshops.form', ['workshop' => new ExploratoryWorkshop]);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data = $this->prepare($data, $sanitizer);
        $data['author_id'] = $request->user()->id;
        ExploratoryWorkshop::create($data);

        return redirect()->route('admin.workshops.index')->with('success', 'Taller creado correctamente.');
    }

    public function edit(ExploratoryWorkshop $workshop): View
    {
        return view('admin.workshops.form', compact('workshop'));
    }

    public function update(Request $request, ExploratoryWorkshop $workshop, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $workshop);
        $this->ensureCanPublish($request, $data['status']);
        $workshop->update($this->prepare($data, $sanitizer, $workshop));

        return redirect()->route('admin.workshops.index')->with('success', 'Taller actualizado correctamente.');
    }

    public function destroy(ExploratoryWorkshop $workshop): RedirectResponse
    {
        $workshop->delete();

        return redirect()->route('admin.workshops.index')->with('success', 'Taller eliminado correctamente.');
    }

    private function validated(Request $request, ?ExploratoryWorkshop $workshop = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('exploratory_workshops')->ignore($workshop)],
            'grade_level' => ['required', Rule::in(['7.º', '8.º', '9.º'])],
            'summary' => ['required', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'responsible' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function prepare(array $data, HtmlContentSanitizer $sanitizer, ?ExploratoryWorkshop $workshop = null): array
    {
        $data['slug'] = Str::slug($data['slug']);
        $data['description'] = $sanitizer->sanitize($data['description'] ?? '');
        $data['published_at'] = $data['status'] === 'published' ? ($workshop?->published_at ?? now()) : null;

        return $data;
    }

    private function ensureCanPublish(Request $request, string $status): void
    {
        abort_if($status === 'published' && ! $request->user()->hasPermission('workshops.publish'), 403);
    }
}
