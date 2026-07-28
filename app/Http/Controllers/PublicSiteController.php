<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;
use App\Models\Event;
use App\Models\ExploratoryWorkshop;
use App\Models\InstitutionalDocument;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Models\SiteSetting;
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

        $latestNews = NewsArticle::with('category')
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('public.home-page', [
            'page' => $page,
            'upcomingEvents' => $upcomingEvents,
            'latestNews' => $latestNews,
            'specialtyCount' => Specialty::publiclyVisible()->count(),
            'workshopCount' => ExploratoryWorkshop::publiclyVisible()->count(),
        ]);
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

    public function admission(): View
    {
        return view('public.admission', [
            'page' => $this->publishedPage('admission'),
            'events' => Event::with('category')
                ->publiclyVisible()
                ->where('slug', 'like', 'ctprgv-admision-2027-%')
                ->orderBy('starts_at')
                ->get(),
            'documents' => InstitutionalDocument::with('category')
                ->published()
                ->whereIn('slug', [
                    'circular-prematricula-setimo-2027',
                    'circular-reglamento-admision-2027',
                    'reglamento-admision-matricula-2027',
                ])
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function specialties(): View
    {
        return view('specialties.index', [
            'specialties' => Specialty::publiclyVisible()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function specialty(Specialty $specialty): View
    {
        abort_unless(Specialty::publiclyVisible()->whereKey($specialty)->exists(), 404);
        $specialty->load('curricularDocuments');

        return view('specialties.show', compact('specialty'));
    }

    public function workshops(): View
    {
        $workshops = ExploratoryWorkshop::with('curricularDocuments')->publiclyVisible()->orderBy('sort_order')->orderBy('name')->get();

        return view('workshops.index', [
            'workshopGroups' => collect([
                '7.º' => $workshops->where('grade_level', '7.º'),
                '8.º' => $workshops->where('grade_level', '8.º'),
                '9.º' => $workshops->where('grade_level', '9.º'),
                '7.º, 8.º y 9.º' => $workshops->where('grade_level', '7.º, 8.º y 9.º'),
            ])->filter->isNotEmpty(),
        ]);
    }

    public function workshop(ExploratoryWorkshop $workshop): View
    {
        abort_unless(ExploratoryWorkshop::publiclyVisible()->whereKey($workshop)->exists(), 404);
        $workshop->load('curricularDocuments');

        return view('workshops.show', compact('workshop'));
    }

    public function board(): View
    {
        return $this->managed('board');
    }

    public function contact(): View
    {
        return view('public.contact-page', [
            'page' => $this->publishedPage('contact'),
            'contact' => SiteSetting::where('group', 'contacto')->pluck('value', 'key'),
        ]);
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
