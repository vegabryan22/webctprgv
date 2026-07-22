<?php

namespace App\Services;

use App\Models\Event;

class ICalendarService
{
    public function render(Event $event): string
    {
        $start = $event->all_day ? 'DTSTART;VALUE=DATE:'.$event->starts_at->format('Ymd') : 'DTSTART:'.$event->starts_at->utc()->format('Ymd\THis\Z');
        $endDate = $event->ends_at ?? $event->starts_at;
        $end = $event->all_day ? 'DTEND;VALUE=DATE:'.$endDate->copy()->addDay()->format('Ymd') : 'DTEND:'.$endDate->utc()->format('Ymd\THis\Z');

        return implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//CTP Roberto Gamboa Valverde//Calendario//ES',
            'CALSCALE:GREGORIAN',
            'BEGIN:VEVENT',
            'UID:event-'.$event->id.'@ctprgv',
            'DTSTAMP:'.now()->utc()->format('Ymd\THis\Z'),
            $start,
            $end,
            'SUMMARY:'.$this->escape($event->title),
            'DESCRIPTION:'.$this->escape(strip_tags((string) $event->description)),
            'LOCATION:'.$this->escape((string) $event->location),
            'URL:'.route('calendar.show', $event),
            'STATUS:'.($event->status === 'cancelled' ? 'CANCELLED' : 'CONFIRMED'),
            'END:VEVENT',
            'END:VCALENDAR',
            '',
        ]);
    }

    private function escape(string $value): string
    {
        return str_replace(['\\', ';', ',', "\r\n", "\n"], ['\\\\', '\\;', '\\,', '\\n', '\\n'], $value);
    }
}
