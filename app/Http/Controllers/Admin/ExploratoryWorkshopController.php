<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExploratoryWorkshop;
use App\Services\CurricularDocumentService;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function store(Request $request, HtmlContentSanitizer $sanitizer, CurricularDocumentService $documents): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data = $this->prepare($data, $sanitizer);
        $data['author_id'] = $request->user()->id;
        $workshop = ExploratoryWorkshop::create($data);
        $documents->sync($request, $workshop);

        return redirect()->route('admin.workshops.index')->with('success', 'Taller creado correctamente.');
    }

    public function edit(ExploratoryWorkshop $workshop): View
    {
        return view('admin.workshops.form', compact('workshop'));
    }

    public function update(Request $request, ExploratoryWorkshop $workshop, HtmlContentSanitizer $sanitizer, CurricularDocumentService $documents): RedirectResponse
    {
        $data = $this->validated($request, $workshop);
        $this->ensureCanPublish($request, $data['status']);
        $workshop->update($this->prepare($data, $sanitizer, $workshop));
        $documents->sync($request, $workshop);

        return redirect()->route('admin.workshops.index')->with('success', 'Taller actualizado correctamente.');
    }

    public function destroy(ExploratoryWorkshop $workshop, CurricularDocumentService $documents): RedirectResponse
    {
        $documents->deleteAll($workshop);
        if ($workshop->image_path) {
            Storage::disk('public')->delete($workshop->image_path);
        }
        $workshop->delete();

        return redirect()->route('admin.workshops.index')->with('success', 'Taller eliminado correctamente.');
    }

    public function toggle(Request $request, ExploratoryWorkshop $workshop): RedirectResponse
    {
        if ($workshop->status !== 'published') {
            return back()->with('error', 'Primero debe publicar el taller para gestionar su visibilidad.');
        }

        $workshop->update(['is_active' => ! $workshop->is_active]);

        return back()->with('success', $workshop->is_active
            ? 'El taller vuelve a estar visible en el sitio.'
            : 'El taller se ocultó sin cambiar su estado de publicación.');
    }

    private function validated(Request $request, ?ExploratoryWorkshop $workshop = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('exploratory_workshops')->ignore($workshop)],
            'grade_level' => ['required', Rule::in(['7.º', '8.º', '9.º', '7.º, 8.º y 9.º'])],
            'summary' => ['required', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'plan_files' => ['nullable', 'array', 'max:5'],
            'plan_files.*' => ['nullable', 'file', 'mimes:pdf', 'max:15360'],
            'plan_grades' => ['nullable', 'array'],
            'plan_grades.*' => ['nullable', 'required_with:plan_files.*', Rule::in(['7.º', '8.º', '9.º', '10.º', '11.º', '12.º', '7.º, 8.º y 9.º'])],
            'plan_languages' => ['nullable', 'array'],
            'plan_languages.*' => ['nullable', 'required_with:plan_files.*', Rule::in(['es', 'en'])],
            'plan_titles' => ['nullable', 'array'],
            'plan_titles.*' => ['nullable', 'string', 'max:255'],
            'delete_plan_ids' => ['nullable', 'array'],
            'delete_plan_ids.*' => ['integer', 'exists:curricular_documents,id'],
            'responsible' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function prepare(array $data, HtmlContentSanitizer $sanitizer, ?ExploratoryWorkshop $workshop = null): array
    {
        $image = $data['image'] ?? null;
        unset($data['image'], $data['plan_files'], $data['plan_grades'], $data['plan_languages'], $data['plan_titles'], $data['delete_plan_ids']);
        $data['slug'] = Str::slug($data['slug']);
        $data['description'] = $sanitizer->sanitize($data['description'] ?? '');
        $data['published_at'] = $data['status'] === 'published' ? ($workshop?->published_at ?? now()) : null;
        if ($image) {
            if ($workshop?->image_path) {
                Storage::disk('public')->delete($workshop->image_path);
            }
            $data['image_path'] = $image->store('workshops', 'public');
        }

        return $data;
    }

    private function ensureCanPublish(Request $request, string $status): void
    {
        abort_if($status === 'published' && ! $request->user()->hasPermission('workshops.publish'), 403);
    }
}
