<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Models\Event;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        $page = $this->publishedPage('home');
        $upcomingEvents = Event::with('category')
            ->publiclyVisible()
            ->where('starts_at', '>=', now()->startOfDay())
            ->orderBy('starts_at')
            ->orderByDesc('source_priority')
            ->limit(4)
            ->get();

        return view('public.home-page', compact('page', 'upcomingEvents'));
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
        $page = $this->publishedPage($routeName);

        return view('public.managed-page', compact('page'));
    }

    private function publishedPage(string $routeName): ContentPage
    {
        $page = ContentPage::where('route_name', $routeName)->firstOrFail();
        abort_unless($page->status === 'published' && $page->published_at?->isPast(), 404);

        return $page;
    }
}
