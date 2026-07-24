<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DirectoryEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DirectoryController extends Controller
{
    public function index(): View
    {
        return view('admin.directory.index', ['entries' => DirectoryEntry::orderBy('sort_order')->orderBy('department')->get()]);
    }

    public function create(): View
    {
        return view('admin.directory.form', ['entry' => new DirectoryEntry]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $this->authorizePublish($request, $data);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        DirectoryEntry::create($data);

        return redirect()->route('admin.directory.index')->with('success', 'Contacto creado.');
    }

    public function edit(DirectoryEntry $entry): View
    {
        return view('admin.directory.form', compact('entry'));
    }

    public function update(Request $request, DirectoryEntry $entry): RedirectResponse
    {
        $data = $this->validated($request);
        $this->authorizePublish($request, $data);
        $data['published_at'] = $data['status'] === 'published' ? ($entry->published_at ?? now()) : null;
        $entry->update($data);

        return redirect()->route('admin.directory.index')->with('success', 'Contacto actualizado.');
    }

    public function destroy(DirectoryEntry $entry): RedirectResponse
    {
        $entry->delete();

        return back()->with('success', 'Contacto eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate(['department' => ['required', 'string', 'max:255'], 'position' => ['nullable', 'string', 'max:255'], 'person_name' => ['nullable', 'string', 'max:255'], 'phone' => ['nullable', 'string', 'max:100', 'required_without:email'], 'extension' => ['nullable', 'string', 'max:30'], 'email' => ['nullable', 'email', 'max:255', 'required_without:phone'], 'schedule' => ['nullable', 'string', 'max:255'], 'notes' => ['nullable', 'string', 'max:1000'], 'status' => ['required', Rule::in(['draft', 'published'])], 'verified_at' => ['nullable', 'date', 'required_if:status,published'], 'sort_order' => ['required', 'integer', 'min:0']]);
    }

    private function authorizePublish(Request $request, array $data): void
    {
        abort_if($data['status'] === 'published' && ! $request->user()->hasPermission('directory.publish'), 403);
    }
}
