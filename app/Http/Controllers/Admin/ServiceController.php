<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionalService;
use App\Models\ServiceCategory;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $services = InstitutionalService::with('category')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.form', ['service' => new InstitutionalService, 'categories' => ServiceCategory::orderBy('sort_order')->get()]);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data = $this->prepare($request, $data, $sanitizer);
        $data['author_id'] = $request->user()->id;
        InstitutionalService::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Servicio creado correctamente.');
    }

    public function edit(InstitutionalService $service): View
    {
        return view('admin.services.form', ['service' => $service, 'categories' => ServiceCategory::orderBy('sort_order')->get()]);
    }

    public function update(Request $request, InstitutionalService $service, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $service);
        $this->ensureCanPublish($request, $data['status']);
        $service->update($this->prepare($request, $data, $sanitizer, $service));

        return redirect()->route('admin.services.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(InstitutionalService $service): RedirectResponse
    {
        if ($service->attachment_path) {
            Storage::disk('public')->delete($service->attachment_path);
        }
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Servicio eliminado correctamente.');
    }

    private function validated(Request $request, ?InstitutionalService $service = null): array
    {
        return $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('institutional_services')->ignore($service)],
            'summary' => ['required', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'audience' => ['required', Rule::in(['general', 'students', 'families', 'staff', 'community'])],
            'responsible' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'external_url' => ['nullable', 'url:http,https', 'max:2048'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function prepare(Request $request, array $data, HtmlContentSanitizer $sanitizer, ?InstitutionalService $service = null): array
    {
        unset($data['attachment']);
        $data['slug'] = Str::slug($data['slug']);
        $data['description'] = $sanitizer->sanitize($data['description'] ?? '');
        $data['requirements'] = $sanitizer->sanitize($data['requirements'] ?? '');
        $data['published_at'] = $data['status'] === 'published' ? ($service?->published_at ?? now()) : null;
        if ($request->hasFile('attachment')) {
            if ($service?->attachment_path) {
                Storage::disk('public')->delete($service->attachment_path);
            }
            $data['attachment_path'] = $request->file('attachment')->store('services/documents', 'public');
        }

        return $data;
    }

    private function ensureCanPublish(Request $request, string $status): void
    {
        abort_if($status === 'published' && ! $request->user()->hasPermission('services.publish'), 403);
    }
}
