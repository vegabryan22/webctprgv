<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Services\HtmlContentSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::with(['category', 'author'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderByDesc('starts_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.form', ['event' => new Event, 'categories' => EventCategory::orderBy('name')->get()]);
    }

    public function store(Request $request, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request);
        $this->ensureCanPublish($request, $data['status']);
        $data = $this->prepare($request, $data, $sanitizer);
        $data['author_id'] = $request->user()->id;
        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Actividad creada correctamente.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.form', ['event' => $event, 'categories' => EventCategory::orderBy('name')->get()]);
    }

    public function update(Request $request, Event $event, HtmlContentSanitizer $sanitizer): RedirectResponse
    {
        $data = $this->validated($request, $event);
        $this->ensureCanPublish($request, $data['status']);
        $event->update($this->prepare($request, $data, $sanitizer, $event));

        return redirect()->route('admin.events.index')->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        foreach ([$event->image_path, $event->attachment_path] as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Actividad eliminada correctamente.');
    }

    private function validated(Request $request, ?Event $event = null): array
    {
        return $request->validate([
            'event_category_id' => ['required', 'integer', 'exists:event_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('events')->ignore($event)],
            'summary' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'all_day' => ['nullable', 'boolean'],
            'location' => ['nullable', 'string', 'max:255'],
            'audience' => ['required', Rule::in(['general', 'students', 'families', 'staff', 'community'])],
            'status' => ['required', Rule::in(['draft', 'published', 'cancelled'])],
            'registration_url' => ['nullable', 'url:http,https', 'max:2048'],
            'image' => ['nullable', 'image', 'max:4096'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
        ]);
    }

    private function prepare(Request $request, array $data, HtmlContentSanitizer $sanitizer, ?Event $event = null): array
    {
        unset($data['image'], $data['attachment']);
        $data['slug'] = Str::slug($data['slug']);
        $data['description'] = $sanitizer->sanitize($data['description'] ?? '');
        $data['all_day'] = $request->boolean('all_day');
        $data['published_at'] = in_array($data['status'], ['published', 'cancelled'], true) ? ($event?->published_at ?? now()) : null;

        foreach (['image', 'attachment'] as $field) {
            if (! $request->hasFile($field)) {
                continue;
            }
            $oldPath = $field === 'image' ? $event?->image_path : $event?->attachment_path;
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            $data[$field.'_path'] = $request->file($field)->store('events/'.$field, 'public');
        }

        return $data;
    }

    private function ensureCanPublish(Request $request, string $status): void
    {
        abort_if(in_array($status, ['published', 'cancelled'], true) && ! $request->user()->hasPermission('events.publish'), 403);
    }
}
