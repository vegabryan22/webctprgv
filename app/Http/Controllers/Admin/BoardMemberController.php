<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BoardMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.board-members.index', ['members' => BoardMember::orderBy('sort_order')->orderBy('position')->get()]);
    }

    public function create(): View
    {
        return view('admin.board-members.form', ['member' => new BoardMember]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data);
        $data['author_id'] = $request->user()->id;
        $data['published_at'] = $data['status'] === 'published' ? now() : null;
        BoardMember::create($data);

        return redirect()->route('admin.board-members.index')->with('success', 'Integrante registrado correctamente.');
    }

    public function edit(BoardMember $member): View
    {
        return view('admin.board-members.form', compact('member'));
    }

    public function update(Request $request, BoardMember $member): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data);
        $data['published_at'] = $data['status'] === 'published' ? ($member->published_at ?? now()) : null;
        $member->update($data);

        return redirect()->route('admin.board-members.index')->with('success', 'Integrante actualizado correctamente.');
    }

    public function destroy(BoardMember $member): RedirectResponse
    {
        $member->delete();

        return back()->with('success', 'Integrante eliminado correctamente.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'term_starts_at' => ['nullable', 'date'],
            'term_ends_at' => ['nullable', 'date', 'after_or_equal:term_starts_at'],
            'source' => ['required', 'string', 'max:500'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'verified_at' => ['nullable', 'date', 'required_if:status,published'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function ensureCanPublish(Request $request, array $data): void
    {
        abort_if($data['status'] === 'published' && ! $request->user()->hasPermission('board.publish'), 403);
    }
}
