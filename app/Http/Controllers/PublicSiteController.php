<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\Specialty;
use Illuminate\Http\Request;
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

    public function news(Request $request): View
    {
        $articles = NewsArticle::with('category')->published()
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('category'))))
            ->orderByDesc('is_featured')->latest('published_at')->paginate(9)->withQueryString();

        return view('public.news-index', [
            'articles' => $articles,
            'categories' => NewsCategory::whereHas('articles', fn ($query) => $query->published())->orderBy('name')->get(),
        ]);
    }

    public function newsArticle(NewsArticle $article): View
    {
        abort_unless(NewsArticle::published()->whereKey($article)->exists(), 404);

        return view('public.news-show', compact('article'));
    }

    public function information(): View
    {
        return $this->managed('information');
    }

    public function specialties(): View
    {
        return view('specialties.index', [
            'specialties' => Specialty::published()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function specialty(Specialty $specialty): View
    {
        abort_unless(Specialty::published()->whereKey($specialty)->exists(), 404);

        return view('specialties.show', compact('specialty'));
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
