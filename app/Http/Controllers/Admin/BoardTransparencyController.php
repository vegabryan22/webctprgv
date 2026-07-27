<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardTransparencyRecord;
use App\Models\InstitutionalDocument;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BoardTransparencyController extends Controller
{
    public function index(): View
    {
        return view('admin.board-records.index', [
            'records' => BoardTransparencyRecord::withCount('documents')->orderByDesc('record_date')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return $this->form(new BoardTransparencyRecord);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data);
        [$attributes, $documents] = $this->prepare($data, $sanitizer);
        $attributes['author_id'] = $request->user()->id;
        $record = BoardTransparencyRecord::create($attributes);
        $record->documents()->sync($documents);

        return redirect()->route('admin.board-records.index')->with('success', 'Publicación registrada correctamente.');
    }

    public function edit(BoardTransparencyRecord $record): View
    {
        return $this->form($record);
    }

    public function update(Request $request, BoardTransparencyRecord $record, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $record);
        $this->ensureCanPublish($request, $data);
        [$attributes, $documents] = $this->prepare($data, $sanitizer, $record);
        $record->update($attributes);
        $record->documents()->sync($documents);

        return redirect()->route('admin.board-records.index')->with('success', 'Publicación actualizada correctamente.');
    }

    public function destroy(BoardTransparencyRecord $record): RedirectResponse
    {
        $record->delete();

        return back()->with('success', 'Publicación eliminada correctamente.');
    }

    private function form(BoardTransparencyRecord $record): View
    {
        $record->load('documents');

        return view('admin.board-records.form', [
            'record' => $record,
            'documents' => InstitutionalDocument::orderBy('title')->get(),
        ]);
    }

    private function validated(Request $request, ?BoardTransparencyRecord $record = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('board_transparency_records')->ignore($record)],
            'type' => ['required', Rule::in(['project', 'procurement', 'uniform', 'material', 'report', 'notice'])],
            'summary' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'price_note' => ['nullable', 'string', 'max:255'],
            'responsible' => ['required', 'string', 'max:255'],
            'source' => ['required', 'string', 'max:500'],
            'record_date' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
            'document_ids' => ['nullable', 'array'],
            'document_ids.*' => ['integer', 'exists:institutional_documents,id'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date', 'required_if:status,published'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function prepare(array $data, HtmlContentSanitizer $sanitizer, ?BoardTransparencyRecord $record = null): array
    {
        $documents = $data['document_ids'] ?? [];
        unset($data['document_ids']);
        $data['slug'] = Str::slug($data['slug']);
        $data['content'] = $sanitizer->sanitize($data['content'] ?? '');
        $data['published_at'] = $data['status'] === 'published' ? ($record?->published_at ?? now()) : null;

        return [$data, $documents];
    }

    private function ensureCanPublish(Request $request, array $data): void
    {
        abort_if($data['status'] === 'published' && ! $request->user()->hasPermission('board.publish'), 403);
    }
}
