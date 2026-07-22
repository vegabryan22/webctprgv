<span class="event-source {{ $event->source === 'mep' ? 'mep' : 'ctprgv' }}">
    <i class="fas {{ $event->source === 'mep' ? 'fa-landmark' : 'fa-school' }}"></i>
    {{ $event->source === 'mep' ? 'MEP · Fecha tentativa' : 'CTPRGV · Fecha institucional sujeta a cambios' }}
</span>
