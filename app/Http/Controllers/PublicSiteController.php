<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        return $this->managed('home');
    }

    public function news(): View
    {
        return $this->managed('news');
    }

    public function information(): View
    {
        return $this->managed('information');
    }

    public function specialties(): View
    {
        return $this->managed('specialties');
    }

    public function board(): View
    {
        return $this->managed('board');
    }

    public function contact(): View
    {
        return $this->managed('contact');
    }

    public function anniversary(): View
    {
        return $this->managed('anniversary');
    }

    public function page(ContentPage $page): View
    {
        abort_unless($page->status === 'published' && $page->published_at?->isPast(), 404);

        return view('public.managed-page', compact('page'));
    }

    private function managed(string $routeName): View
    {
        $page = ContentPage::where('route_name', $routeName)->firstOrFail();
        abort_unless($page->status === 'published' && $page->published_at?->isPast(), 404);

        return view('public.managed-page', compact('page'));
    }
}
