@extends('layouts.public')

@section('title', $page->title . ($page->route_name === 'home' ? '' : ' - CTP Roberto Gamboa Valverde'))

@section('content')
{!! $page->content !!}
@endsection

@if($page->script)
    @push('scripts')
        <script>{!! $page->script !!}</script>
    @endpush
@endif
