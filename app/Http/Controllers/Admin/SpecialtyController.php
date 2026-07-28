<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use App\Services\CurricularDocumentService;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SpecialtyController extends Controller
{
    public function index(): View
    {
        return view('admin.specialties.index', ['specialties' => Specialty::orderBy('sort_order')->orderBy('name')->get()]);
    }

    public function create(): View
    {
        return view('admin.specialties.form', ['specialty' => new Specialty]);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer, CurricularDocumentService $documents): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data = $this->prepare($request, $data, $sanitizer);
        $data['author_id'] = $request->user()->id;
        $specialty = Specialty::create($data);
        $documents->sync($request, $specialty);

        return redirect()->route('admin.specialties.index')->with('success', 'Especialidad creada correctamente.');
    }

    public function edit(Specialty $specialty): View
    {
        return view('admin.specialties.form', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty, HtmlContentSanitizer $sanitizer, CurricularDocumentService $documents): RedirectResponse
    {
        $data = $this->validated($request, $specialty);
        $this->ensureCanPublish($request, $data['status']);
        $specialty->update($this->prepare($request, $data, $sanitizer, $specialty));
        $documents->sync($request, $specialty);

        return redirect()->route('admin.specialties.index')->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy(Specialty $specialty, CurricularDocumentService $documents): RedirectResponse
    {
        $documents->deleteAll($specialty);
        if ($specialty->image_path) {
            Storage::disk('public')->delete($specialty->image_path);
        }
        $specialty->delete();

        return redirect()->route('admin.specialties.index')->with('success', 'Especialidad eliminada correctamente.');
    }

    public function toggle(Request $request, Specialty $specialty): RedirectResponse
    {
        if ($specialty->status !== 'published') {
            return back()->with('error', 'Primero debe publicar la especialidad para gestionar su visibilidad.');
        }

        $specialty->update(['is_active' => ! $specialty->is_active]);

        return back()->with('success', $specialty->is_active
            ? 'La especialidad vuelve a estar visible en el sitio.'
            : 'La especialidad se ocultó sin cambiar su estado de publicación.');
    }

    private function validated(Request $request, ?Specialty $specialty = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('specialties')->ignore($specialty)],
            'summary' => ['nullable', 'string', 'max:1000'],
            'grade_levels' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'student_profile' => ['nullable', 'string'],
            'curriculum' => ['nullable', 'string'],
            'career_opportunities' => ['nullable', 'string'],
            'official_program_url' => ['nullable', 'url:http,https', 'max:2048'],
            'coordinator' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
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
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function prepare(Request $request, array $data, HtmlContentSanitizer $sanitizer, ?Specialty $specialty = null): array
    {
        unset($data['image'], $data['plan_files'], $data['plan_grades'], $data['plan_languages'], $data['plan_titles'], $data['delete_plan_ids']);
        $data['slug'] = Str::slug($data['slug']);
        foreach (['description', 'student_profile', 'curriculum', 'career_opportunities'] as $field) {
            $data[$field] = $sanitizer->sanitize($data[$field] ?? '');
        }
        $data['published_at'] = $data['status'] === 'published' ? ($specialty?->published_at ?? now()) : null;
        if ($request->hasFile('image')) {
            if ($specialty?->image_path) {
                Storage::disk('public')->delete($specialty->image_path);
            }
            $data['image_path'] = $request->file('image')->store('specialties', 'public');
        }

        return $data;
    }

    private function ensureCanPublish(Request $request, string $status): void
    {
        abort_if($status === 'published' && ! $request->user()->hasPermission('specialties.publish'), 403);
    }
}
