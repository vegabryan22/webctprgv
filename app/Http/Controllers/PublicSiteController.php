<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        return view('public.home');
    }

    public function news(): View
    {
        return view('public.news');
    }

    public function information(): View
    {
        return view('public.information');
    }

    public function specialties(): View
    {
        return view('public.specialties');
    }

    public function board(): View
    {
        return view('public.board');
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function anniversary(): View
    {
        return view('public.anniversary');
    }

    public function page(ContentPage $page): View
    {
        abort_unless($page->status === 'published' && $page->published_at?->isPast(), 404);

        return view('public.page', compact('page'));
    }
}
