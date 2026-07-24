<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionalDocument;
use App\Models\ProfessionalExperience;
use App\Models\Specialty;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfessionalExperienceController extends Controller
{
    public function index(): View
    {
        return view('admin.experiences.index', [
            'experiences' => ProfessionalExperience::withCount(['specialties', 'documents'])->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return $this->form(new ProfessionalExperience);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data);
        [$attributes, $specialties, $documents] = $this->prepare($data, $sanitizer);
        $attributes['author_id'] = $request->user()->id;
        $experience = ProfessionalExperience::create($attributes);
        $experience->specialties()->sync($specialties);
        $experience->documents()->sync($documents);

        return redirect()->route('admin.experiences.index')->with('success', 'Modalidad creada correctamente.');
    }

    public function edit(ProfessionalExperience $experience): View
    {
        return $this->form($experience);
    }

    public function update(Request $request, ProfessionalExperience $experience, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $experience);
        $this->ensureCanPublish($request, $data);
        [$attributes, $specialties, $documents] = $this->prepare($data, $sanitizer, $experience);
        $experience->update($attributes);
        $experience->specialties()->sync($specialties);
        $experience->documents()->sync($documents);

        return redirect()->route('admin.experiences.index')->with('success', 'Modalidad actualizada correctamente.');
    }

    public function destroy(ProfessionalExperience $experience): RedirectResponse
    {
        $experience->delete();

        return back()->with('success', 'Modalidad eliminada correctamente.');
    }

    private function form(ProfessionalExperience $experience): View
    {
        $experience->load(['specialties', 'documents']);

        return view('admin.experiences.form', [
            'experience' => $experience,
            'specialties' => Specialty::orderBy('name')->get(),
            'documents' => InstitutionalDocument::orderBy('title')->get(),
        ]);
    }

    private function validated(Request $request, ?ProfessionalExperience $experience = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('professional_experiences')->ignore($experience)],
            'type' => ['required', Rule::in(['professional_practice', 'internship', 'technical_visit'])],
            'summary' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'process_stages' => ['nullable', 'string'],
            'responsible' => ['required', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'company_contact_email' => ['nullable', 'email', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'specialty_ids' => ['nullable', 'array'],
            'specialty_ids.*' => ['integer', 'exists:specialties,id'],
            'document_ids' => ['nullable', 'array'],
            'document_ids.*' => ['integer', 'exists:institutional_documents,id'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date', 'required_if:status,published'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function prepare(array $data, HtmlContentSanitizer $sanitizer, ?ProfessionalExperience $experience = null): array
    {
        $specialties = $data['specialty_ids'] ?? [];
        $documents = $data['document_ids'] ?? [];
        unset($data['specialty_ids'], $data['document_ids']);
        $data['slug'] = Str::slug($data['slug']);
        foreach (['description', 'requirements', 'process_stages'] as $field) {
            $data[$field] = $sanitizer->sanitize($data[$field] ?? '');
        }
        $data['published_at'] = $data['status'] === 'published' ? ($experience?->published_at ?? now()) : null;

        return [$data, $specialties, $documents];
    }

    private function ensureCanPublish(Request $request, array $data): void
    {
        abort_if($data['status'] === 'published' && ! $request->user()->hasPermission('experiences.publish'), 403);
    }
}
