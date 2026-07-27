<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $messages = ContactMessage::query()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        if ($contactMessage->status === 'new') {
            $contactMessage->update(['status' => 'read', 'read_at' => now()]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function update(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', 'in:new,read,handled,archived']]);
        $contactMessage->update([
            'status' => $data['status'],
            'read_at' => $data['status'] === 'new' ? null : ($contactMessage->read_at ?? now()),
            'handled_at' => $data['status'] === 'handled' ? now() : $contactMessage->handled_at,
        ]);

        return back()->with('success', 'Estado de la consulta actualizado.');
    }
}
