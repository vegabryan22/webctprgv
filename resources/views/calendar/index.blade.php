@extends('layouts.public')
@section('title', 'Calendario de actividades - CTP Roberto Gamboa Valverde')
@push('styles')<link rel="stylesheet" href="{{ asset('css/calendar.css') }}?v={{ config('version.number') }}">@endpush
@section('content')
<main class="calendar-page school-calendar"><div class="calendar-shell">
<header class="calendar-hero"><div><h1>Calendario de actividades</h1><p>Consulte las próximas fechas académicas, técnicas, culturales e institucionales.</p></div><div class="calendar-actions"><a class="calendar-button" href="{{ route('calendar.list') }}"><i class="fas fa-list"></i> Ver como lista</a></div></header>
<div class="calendar-source-notice"><i class="fas fa-circle-info"></i><div><strong>Fuentes y vigencia de las fechas</strong><p>Las fechas del MEP son tentativas. Las comunicadas por el CTPRGV tienen prioridad institucional, pero pueden cambiar por disposiciones ministeriales o situaciones fortuitas.</p></div></div>
<section><div class="month-nav"><a href="{{ route('calendar.index', ['month' => $month->copy()->subMonth()->format('Y-m')]) }}" aria-label="Mes anterior"><i class="fas fa-chevron-left"></i></a><h2>{{ $month->translatedFormat('F Y') }}</h2><a href="{{ route('calendar.index', ['month' => $month->copy()->addMonth()->format('Y-m')]) }}" aria-label="Mes siguiente"><i class="fas fa-chevron-right"></i></a></div>
<div class="calendar-grid"><div class="weekday">Dom</div><div class="weekday">Lun</div><div class="weekday">Mar</div><div class="weekday">Mié</div><div class="weekday">Jue</div><div class="weekday">Vie</div><div class="weekday">Sáb</div>
@for($day = $calendarStart->copy(); $day->lte($calendarEnd); $day->addDay())
    <div class="calendar-day {{ !$day->isSameMonth($month) ? 'outside' : '' }} {{ $day->isToday() ? 'today' : '' }}"><span class="day-number">{{ $day->day }}</span>
    @foreach($eventsByDate->get($day->format('Y-m-d'), collect()) as $event)<a class="calendar-event {{ $event->status === 'cancelled' ? 'cancelled' : '' }} {{ $event->source }}" style="--event-color:{{ $event->category->color }}" href="{{ route('calendar.show', $event) }}" title="{{ $event->source === 'mep' ? 'MEP: fecha tentativa' : 'CTPRGV: fecha institucional sujeta a cambios' }}"><strong>{{ $event->source === 'mep' ? 'MEP' : 'CTP' }}</strong> {{ $event->title }}</a>@endforeach
    </div>
@endfor
</div></section>
<section class="upcoming-section"><h2 class="section-title">Próximas actividades</h2><div class="event-cards">@forelse($upcoming as $event)<article class="event-card-public"><div class="event-date-box" style="background:{{ $event->category->color }}"><strong>{{ $event->starts_at->format('d') }}</strong><span>{{ $event->starts_at->translatedFormat('M') }}</span></div><div><h3><a href="{{ route('calendar.show', $event) }}">{{ $event->title }}</a></h3><div class="event-meta"><span><i class="far fa-clock"></i> {{ $event->all_day ? 'Todo el día' : $event->starts_at->format('H:i') }}</span>@if($event->location)<span><i class="fas fa-location-dot"></i> {{ $event->location }}</span>@endif</div></div></article>@empty<p>No hay actividades próximas publicadas.</p>@endforelse</div></section>
</div></main>
@endsection
