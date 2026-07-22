<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Services\ICalendarService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(Request $request): View
    {
        $month = $this->month($request->string('month')->toString());
        $calendarStart = $month->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $calendarEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SATURDAY);
        $events = Event::with('category')->publiclyVisible()
            ->whereBetween('starts_at', [$calendarStart, $calendarEnd->endOfDay()])
            ->orderBy('starts_at')->orderByDesc('source_priority')->get();

        return view('calendar.index', [
            'month' => $month,
            'calendarStart' => $calendarStart,
            'calendarEnd' => $calendarEnd,
            'eventsByDate' => $events->groupBy(fn (Event $event) => $event->starts_at->format('Y-m-d')),
            'upcoming' => Event::with('category')->publiclyVisible()->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at')->orderByDesc('source_priority')->limit(6)->get(),
        ]);
    }

    public function listing(Request $request): View
    {
        $events = Event::with('category')->publiclyVisible()
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('category'))))
            ->when($request->filled('audience'), fn ($query) => $query->where('audience', $request->string('audience')))
            ->where('starts_at', '>=', now()->startOfDay())
            ->orderBy('starts_at')->orderByDesc('source_priority')->paginate(15)->withQueryString();

        return view('calendar.list', ['events' => $events, 'categories' => EventCategory::orderBy('name')->get()]);
    }

    public function show(Event $event): View
    {
        $this->ensureVisible($event);

        return view('calendar.show', compact('event'));
    }

    public function ical(Event $event, ICalendarService $calendar): Response
    {
        $this->ensureVisible($event);

        return response($calendar->render($event), 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="'.$event->slug.'.ics"',
        ]);
    }

    private function month(string $value): Carbon
    {
        if (preg_match('/^\d{4}-\d{2}$/', $value)) {
            try {
                return Carbon::createFromFormat('!Y-m', $value)->startOfMonth();
            } catch (\Throwable) {
            }
        }

        return now()->startOfMonth();
    }

    private function ensureVisible(Event $event): void
    {
        abort_unless(in_array($event->status, ['published', 'cancelled'], true) && $event->published_at?->isPast(), 404);
    }
}
