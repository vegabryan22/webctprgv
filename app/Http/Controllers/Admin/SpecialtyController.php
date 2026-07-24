<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
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

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data = $this->prepare($request, $data, $sanitizer);
        $data['author_id'] = $request->user()->id;
        Specialty::create($data);

        return redirect()->route('admin.specialties.index')->with('success', 'Especialidad creada correctamente.');
    }

    public function edit(Specialty $specialty): View
    {
        return view('admin.specialties.form', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $specialty);
        $this->ensureCanPublish($request, $data['status']);
        $specialty->update($this->prepare($request, $data, $sanitizer, $specialty));

        return redirect()->route('admin.specialties.index')->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy(Specialty $specialty): RedirectResponse
    {
        if ($specialty->image_path) {
            Storage::disk('public')->delete($specialty->image_path);
        }
        $specialty->delete();

        return redirect()->route('admin.specialties.index')->with('success', 'Especialidad eliminada correctamente.');
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
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function prepare(Request $request, array $data, HtmlContentSanitizer $sanitizer, ?Specialty $specialty = null): array
    {
        unset($data['image']);
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
