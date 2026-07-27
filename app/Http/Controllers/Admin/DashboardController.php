<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardTransparencyRecord;
use App\Models\ContactMessage;
use App\Models\ContentPage;
use App\Models\Event;
use App\Models\ExploratoryWorkshop;
use App\Models\InstitutionalDocument;
use App\Models\InstitutionalService;
use App\Models\NewsArticle;
use App\Models\ProfessionalExperience;
use App\Models\Role;
use App\Models\SiteSection;
use App\Models\SiteSetting;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $modules = collect([
            $this->module('Noticias', 'fa-newspaper', NewsArticle::published()->count(), NewsArticle::where('status', 'draft')->count(), 'admin.news.index', 'news.view', '#2878a5'),
            $this->module('Servicios', 'fa-hand-holding-heart', InstitutionalService::published()->count(), InstitutionalService::where('status', 'draft')->count(), 'admin.services.index', 'services.view', '#4b941f'),
            $this->module('Especialidades', 'fa-screwdriver-wrench', Specialty::published()->count(), Specialty::where('status', 'draft')->count(), 'admin.specialties.index', 'specialties.view', '#005b91'),
            $this->module('Talleres', 'fa-compass-drafting', ExploratoryWorkshop::published()->count(), ExploratoryWorkshop::where('status', 'draft')->count(), 'admin.workshops.index', 'workshops.view', '#a57f00'),
            $this->module('Documentos', 'fa-folder-open', InstitutionalDocument::published()->count(), InstitutionalDocument::where('status', 'draft')->count(), 'admin.documents.index', 'documents.view', '#7a55a3'),
            $this->module('Actividades', 'fa-calendar-days', Event::publiclyVisible()->count(), Event::where('status', 'draft')->count(), 'admin.events.index', 'events.view', '#c0602b'),
            $this->module('Práctica', 'fa-building-user', ProfessionalExperience::published()->count(), ProfessionalExperience::where('status', 'draft')->count(), 'admin.experiences.index', 'experiences.view', '#26766d'),
            $this->module('Junta', 'fa-scale-balanced', BoardTransparencyRecord::published()->count(), BoardTransparencyRecord::where('status', 'draft')->count(), 'admin.board-records.index', 'board.view', '#7c6653'),
        ]);
        $drafts = $modules->sum('drafts') + ContentPage::where('status', 'draft')->count();
        $newMessages = ContactMessage::where('status', 'new')->count();

        return view('admin.dashboard', [
            'overview' => [
                'maintenance' => SiteSetting::where('key', 'maintenance_enabled')->value('value') === '1',
                'active_sections' => SiteSection::where('is_active', true)->count(),
                'total_sections' => SiteSection::count(),
                'published' => $modules->sum('published') + ContentPage::published()->count(),
                'drafts' => $drafts,
                'new_messages' => $newMessages,
                'users' => User::count(),
                'roles' => Role::count(),
            ],
            'modules' => $modules,
            'upcomingEvents' => Event::with('category')->publiclyVisible()->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at')->limit(5)->get(),
            'recentMessages' => ContactMessage::latest()->limit(4)->get(),
        ]);
    }

    private function module(string $label, string $icon, int $published, int $drafts, string $route, string $permission, string $color): array
    {
        return compact('label', 'icon', 'published', 'drafts', 'route', 'permission', 'color');
    }
}
