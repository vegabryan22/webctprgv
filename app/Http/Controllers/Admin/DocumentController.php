<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use App\Models\InstitutionalDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.documents.index', ['documents' => InstitutionalDocument::with('category')->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))->latest('issued_at')->paginate(20)->withQueryString()]);
    }

    public function create(): View
    {
        return $this->form(new InstitutionalDocument);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $this->canPublish($request, $data);
        $data = $this->prepare($request, $data);
        $data['author_id'] = $request->user()->id;
        InstitutionalDocument::create($data);

        return redirect()->route('admin.documents.index')->with('success', 'Documento creado.');
    }

    public function edit(InstitutionalDocument $document): View
    {
        return $this->form($document);
    }

    public function update(Request $request, InstitutionalDocument $document): RedirectResponse
    {
        $data = $this->validated($request, $document);
        $this->canPublish($request, $data);
        $document->update($this->prepare($request, $data, $document));

        return redirect()->route('admin.documents.index')->with('success', 'Documento actualizado.');
    }

    public function destroy(InstitutionalDocument $document): RedirectResponse
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Documento eliminado.');
    }

    private function form(InstitutionalDocument $document): View
    {
        $replacements = InstitutionalDocument::query()
            ->when($document->exists, fn ($query) => $query->whereKeyNot($document->id))
            ->orderBy('title')
            ->get();

        return view('admin.documents.form', [
            'document' => $document,
            'categories' => DocumentCategory::orderBy('sort_order')->get(),
            'replacements' => $replacements,
        ]);
    }

    private function validated(Request $request, ?InstitutionalDocument $document = null): array
    {
        return $request->validate(['document_category_id' => ['required', 'exists:document_categories,id'], 'title' => ['required', 'string', 'max:255'], 'slug' => ['required', 'string', 'max:255', Rule::unique('institutional_documents')->ignore($document)], 'description' => ['nullable', 'string', 'max:2000'], 'file' => [$document ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:15360'], 'version' => ['nullable', 'string', 'max:50'], 'responsible' => ['required', 'string', 'max:255'], 'audience' => ['required', Rule::in(['general', 'students', 'families', 'staff', 'community'])], 'issued_at' => ['nullable', 'date'], 'expires_at' => ['nullable', 'date', 'after_or_equal:issued_at'], 'replaced_by_id' => ['nullable', 'exists:institutional_documents,id', Rule::notIn([$document?->id])], 'status' => ['required', Rule::in(['draft', 'published'])], 'verified_at' => ['nullable', 'date', 'required_if:status,published'], 'sort_order' => ['required', 'integer', 'min:0']]);
    }

    private function prepare(Request $request, array $data, ?InstitutionalDocument $document = null): array
    {
        unset($data['file']);
        $data['slug'] = Str::slug($data['slug']);
        $data['published_at'] = $data['status'] === 'published' ? ($document?->published_at ?? now()) : null;
        if ($request->hasFile('file')) {
            if ($document?->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $data['original_filename'] = $request->file('file')->getClientOriginalName();
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        return $data;
    }

    private function canPublish(Request $request, array $data): void
    {
        abort_if($data['status'] === 'published' && ! $request->user()->hasPermission('documents.publish'), 403);
    }
}
