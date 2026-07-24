<?php

use App\Http\Controllers\Admin\ContentAuditController;
use App\Http\Controllers\Admin\ContentPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DirectoryController as AdminDirectoryController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ExploratoryWorkshopController;
use App\Http\Controllers\Admin\GitOpsController;
use App\Http\Controllers\Admin\NavigationItemController;
use App\Http\Controllers\Admin\NewsArticleController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\ProfessionalExperienceController as AdminProfessionalExperienceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\DocumentLibraryController;
use App\Http\Controllers\ProfessionalExperienceController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\ServiceCatalogController;
use Illuminate\Support\Facades\Route;

Route::controller(PublicSiteController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/noticias', 'news')->name('news');
    Route::get('/noticias/{article:slug}', 'newsArticle')->name('news.show');
    Route::get('/informacion', 'information')->name('information');
    Route::get('/especialidades', 'specialties')->name('specialties');
    Route::get('/especialidades/{specialty:slug}', 'specialty')->name('specialties.show');
    Route::get('/talleres-exploratorios', 'workshops')->name('workshops');
    Route::get('/junta-administrativa', 'board')->name('board');
    Route::get('/contacto', 'contact')->name('contact');
    Route::get('/50-aniversario', 'anniversary')->name('anniversary');
    Route::get('/paginas/{page:slug}', 'page')->name('pages.show');
});

Route::controller(CalendarController::class)->prefix('calendario')->name('calendar.')->group(function (): void {
    Route::get('/', 'index')->name('index');
    Route::get('/actividades', 'listing')->name('list');
    Route::get('/{event:slug}', 'show')->name('show');
    Route::get('/{event:slug}/agregar', 'ical')->name('ical');
});

Route::controller(ServiceCatalogController::class)->prefix('servicios')->name('services.')->group(function (): void {
    Route::get('/', 'index')->name('index');
    Route::get('/{service:slug}', 'show')->name('show');
});
Route::get('/directorio', DirectoryController::class)->name('directory');
Route::get('/documentos', DocumentLibraryController::class)->name('documents');
Route::controller(ProfessionalExperienceController::class)->prefix('practica-profesional')->name('experiences.')->group(function (): void {
    Route::get('/', 'index')->name('index');
    Route::get('/{experience:slug}', 'show')->name('show');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/administracion/ingresar', [AuthController::class, 'create'])->name('login');
    Route::post('/administracion/ingresar', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/administracion/salir', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('administracion')->name('admin.')->middleware(['auth', 'permission:admin.access'])->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/usuarios', [UserController::class, 'index'])->middleware('permission:users.view')->name('users.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->middleware('permission:users.create')->name('users.create');
    Route::post('/usuarios', [UserController::class, 'store'])->middleware('permission:users.create')->name('users.store');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->middleware('permission:users.update')->name('users.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->middleware('permission:users.update')->name('users.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->middleware('permission:users.delete')->name('users.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:roles.view')->name('roles.index');
    Route::get('/roles/crear', [RoleController::class, 'create'])->middleware('permission:roles.manage')->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:roles.manage')->name('roles.store');
    Route::get('/roles/{role}/editar', [RoleController::class, 'edit'])->middleware('permission:roles.manage')->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:roles.manage')->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:roles.manage')->name('roles.destroy');

    Route::get('/paginas', [ContentPageController::class, 'index'])->middleware('permission:pages.view')->name('pages.index');
    Route::get('/paginas/crear', [ContentPageController::class, 'create'])->middleware('permission:pages.manage')->name('pages.create');
    Route::post('/paginas', [ContentPageController::class, 'store'])->middleware('permission:pages.manage')->name('pages.store');
    Route::get('/paginas/{page}/editar', [ContentPageController::class, 'edit'])->middleware('permission:pages.manage')->name('pages.edit');
    Route::put('/paginas/{page}', [ContentPageController::class, 'update'])->middleware('permission:pages.manage')->name('pages.update');
    Route::delete('/paginas/{page}', [ContentPageController::class, 'destroy'])->middleware('permission:pages.manage')->name('pages.destroy');
    Route::get('/revision-editorial', ContentAuditController::class)->middleware('permission:pages.view')->name('content-audit.index');

    Route::get('/noticias', [NewsArticleController::class, 'index'])->middleware('permission:news.view')->name('news.index');
    Route::get('/noticias/crear', [NewsArticleController::class, 'create'])->middleware('permission:news.manage')->name('news.create');
    Route::post('/noticias', [NewsArticleController::class, 'store'])->middleware('permission:news.manage')->name('news.store');
    Route::get('/noticias/{article}/editar', [NewsArticleController::class, 'edit'])->middleware('permission:news.manage')->name('news.edit');
    Route::put('/noticias/{article}', [NewsArticleController::class, 'update'])->middleware('permission:news.manage')->name('news.update');
    Route::delete('/noticias/{article}', [NewsArticleController::class, 'destroy'])->middleware('permission:news.manage')->name('news.destroy');
    Route::get('/categorias-de-noticias', [NewsCategoryController::class, 'index'])->middleware('permission:news.manage')->name('news-categories.index');
    Route::post('/categorias-de-noticias', [NewsCategoryController::class, 'store'])->middleware('permission:news.manage')->name('news-categories.store');
    Route::put('/categorias-de-noticias/{newsCategory}', [NewsCategoryController::class, 'update'])->middleware('permission:news.manage')->name('news-categories.update');
    Route::delete('/categorias-de-noticias/{newsCategory}', [NewsCategoryController::class, 'destroy'])->middleware('permission:news.manage')->name('news-categories.destroy');

    Route::get('/servicios', [ServiceController::class, 'index'])->middleware('permission:services.view')->name('services.index');
    Route::get('/servicios/crear', [ServiceController::class, 'create'])->middleware('permission:services.manage')->name('services.create');
    Route::post('/servicios', [ServiceController::class, 'store'])->middleware('permission:services.manage')->name('services.store');
    Route::get('/servicios/{service}/editar', [ServiceController::class, 'edit'])->middleware('permission:services.manage')->name('services.edit');
    Route::put('/servicios/{service}', [ServiceController::class, 'update'])->middleware('permission:services.manage')->name('services.update');
    Route::delete('/servicios/{service}', [ServiceController::class, 'destroy'])->middleware('permission:services.manage')->name('services.destroy');
    Route::get('/categorias-de-servicios', [ServiceCategoryController::class, 'index'])->middleware('permission:services.manage')->name('service-categories.index');
    Route::post('/categorias-de-servicios', [ServiceCategoryController::class, 'store'])->middleware('permission:services.manage')->name('service-categories.store');
    Route::put('/categorias-de-servicios/{serviceCategory}', [ServiceCategoryController::class, 'update'])->middleware('permission:services.manage')->name('service-categories.update');
    Route::delete('/categorias-de-servicios/{serviceCategory}', [ServiceCategoryController::class, 'destroy'])->middleware('permission:services.manage')->name('service-categories.destroy');

    Route::get('/especialidades', [SpecialtyController::class, 'index'])->middleware('permission:specialties.view')->name('specialties.index');
    Route::get('/especialidades/crear', [SpecialtyController::class, 'create'])->middleware('permission:specialties.manage')->name('specialties.create');
    Route::post('/especialidades', [SpecialtyController::class, 'store'])->middleware('permission:specialties.manage')->name('specialties.store');
    Route::get('/especialidades/{specialty}/editar', [SpecialtyController::class, 'edit'])->middleware('permission:specialties.manage')->name('specialties.edit');
    Route::put('/especialidades/{specialty}', [SpecialtyController::class, 'update'])->middleware('permission:specialties.manage')->name('specialties.update');
    Route::delete('/especialidades/{specialty}', [SpecialtyController::class, 'destroy'])->middleware('permission:specialties.manage')->name('specialties.destroy');
    Route::get('/talleres-exploratorios', [ExploratoryWorkshopController::class, 'index'])->middleware('permission:workshops.view')->name('workshops.index');
    Route::get('/talleres-exploratorios/crear', [ExploratoryWorkshopController::class, 'create'])->middleware('permission:workshops.manage')->name('workshops.create');
    Route::post('/talleres-exploratorios', [ExploratoryWorkshopController::class, 'store'])->middleware('permission:workshops.manage')->name('workshops.store');
    Route::get('/talleres-exploratorios/{workshop}/editar', [ExploratoryWorkshopController::class, 'edit'])->middleware('permission:workshops.manage')->name('workshops.edit');
    Route::put('/talleres-exploratorios/{workshop}', [ExploratoryWorkshopController::class, 'update'])->middleware('permission:workshops.manage')->name('workshops.update');
    Route::delete('/talleres-exploratorios/{workshop}', [ExploratoryWorkshopController::class, 'destroy'])->middleware('permission:workshops.manage')->name('workshops.destroy');

    Route::get('/directorio', [AdminDirectoryController::class, 'index'])->middleware('permission:directory.view')->name('directory.index');
    Route::get('/directorio/crear', [AdminDirectoryController::class, 'create'])->middleware('permission:directory.manage')->name('directory.create');
    Route::post('/directorio', [AdminDirectoryController::class, 'store'])->middleware('permission:directory.manage')->name('directory.store');
    Route::get('/directorio/{entry}/editar', [AdminDirectoryController::class, 'edit'])->middleware('permission:directory.manage')->name('directory.edit');
    Route::put('/directorio/{entry}', [AdminDirectoryController::class, 'update'])->middleware('permission:directory.manage')->name('directory.update');
    Route::delete('/directorio/{entry}', [AdminDirectoryController::class, 'destroy'])->middleware('permission:directory.manage')->name('directory.destroy');
    Route::get('/documentos', [DocumentController::class, 'index'])->middleware('permission:documents.view')->name('documents.index');
    Route::get('/documentos/crear', [DocumentController::class, 'create'])->middleware('permission:documents.manage')->name('documents.create');
    Route::post('/documentos', [DocumentController::class, 'store'])->middleware('permission:documents.manage')->name('documents.store');
    Route::get('/documentos/{document}/editar', [DocumentController::class, 'edit'])->middleware('permission:documents.manage')->name('documents.edit');
    Route::put('/documentos/{document}', [DocumentController::class, 'update'])->middleware('permission:documents.manage')->name('documents.update');
    Route::delete('/documentos/{document}', [DocumentController::class, 'destroy'])->middleware('permission:documents.manage')->name('documents.destroy');
    Route::get('/categorias-de-documentos', [DocumentCategoryController::class, 'index'])->middleware('permission:documents.manage')->name('document-categories.index');
    Route::post('/categorias-de-documentos', [DocumentCategoryController::class, 'store'])->middleware('permission:documents.manage')->name('document-categories.store');
    Route::put('/categorias-de-documentos/{documentCategory}', [DocumentCategoryController::class, 'update'])->middleware('permission:documents.manage')->name('document-categories.update');
    Route::delete('/categorias-de-documentos/{documentCategory}', [DocumentCategoryController::class, 'destroy'])->middleware('permission:documents.manage')->name('document-categories.destroy');
    Route::get('/vinculacion-y-practica', [AdminProfessionalExperienceController::class, 'index'])->middleware('permission:experiences.view')->name('experiences.index');
    Route::get('/vinculacion-y-practica/crear', [AdminProfessionalExperienceController::class, 'create'])->middleware('permission:experiences.manage')->name('experiences.create');
    Route::post('/vinculacion-y-practica', [AdminProfessionalExperienceController::class, 'store'])->middleware('permission:experiences.manage')->name('experiences.store');
    Route::get('/vinculacion-y-practica/{experience}/editar', [AdminProfessionalExperienceController::class, 'edit'])->middleware('permission:experiences.manage')->name('experiences.edit');
    Route::put('/vinculacion-y-practica/{experience}', [AdminProfessionalExperienceController::class, 'update'])->middleware('permission:experiences.manage')->name('experiences.update');
    Route::delete('/vinculacion-y-practica/{experience}', [AdminProfessionalExperienceController::class, 'destroy'])->middleware('permission:experiences.manage')->name('experiences.destroy');

    Route::get('/menu', [NavigationItemController::class, 'index'])->middleware('permission:menu.view')->name('navigation.index');
    Route::post('/menu', [NavigationItemController::class, 'store'])->middleware('permission:menu.manage')->name('navigation.store');
    Route::put('/menu/{navigationItem}', [NavigationItemController::class, 'update'])->middleware('permission:menu.manage')->name('navigation.update');
    Route::delete('/menu/{navigationItem}', [NavigationItemController::class, 'destroy'])->middleware('permission:menu.manage')->name('navigation.destroy');

    Route::get('/actividades', [EventController::class, 'index'])->middleware('permission:events.view')->name('events.index');
    Route::get('/actividades/crear', [EventController::class, 'create'])->middleware('permission:events.manage')->name('events.create');
    Route::post('/actividades', [EventController::class, 'store'])->middleware('permission:events.manage')->name('events.store');
    Route::get('/actividades/{event}/editar', [EventController::class, 'edit'])->middleware('permission:events.manage')->name('events.edit');
    Route::put('/actividades/{event}', [EventController::class, 'update'])->middleware('permission:events.manage')->name('events.update');
    Route::delete('/actividades/{event}', [EventController::class, 'destroy'])->middleware('permission:events.manage')->name('events.destroy');

    Route::get('/categorias-de-actividades', [EventCategoryController::class, 'index'])->middleware('permission:events.manage')->name('event-categories.index');
    Route::post('/categorias-de-actividades', [EventCategoryController::class, 'store'])->middleware('permission:events.manage')->name('event-categories.store');
    Route::put('/categorias-de-actividades/{eventCategory}', [EventCategoryController::class, 'update'])->middleware('permission:events.manage')->name('event-categories.update');
    Route::delete('/categorias-de-actividades/{eventCategory}', [EventCategoryController::class, 'destroy'])->middleware('permission:events.manage')->name('event-categories.destroy');

    Route::get('/configuracion', [SiteSettingController::class, 'edit'])->middleware('permission:settings.manage')->name('settings.edit');
    Route::put('/configuracion', [SiteSettingController::class, 'update'])->middleware('permission:settings.manage')->name('settings.update');

    Route::get('/gitops', [GitOpsController::class, 'index'])->middleware('permission:gitops.view')->name('gitops.index');
    Route::put('/gitops/configuracion', [GitOpsController::class, 'updateSettings'])->middleware('permission:settings.manage')->name('gitops.settings.update');
    Route::post('/gitops/desplegar', [GitOpsController::class, 'dispatch'])->middleware('permission:gitops.deploy')->name('gitops.dispatch');
    Route::post('/gitops/validar', [GitOpsController::class, 'validateProduction'])->middleware('permission:gitops.view')->name('gitops.validate');
    Route::post('/gitops/cancelar/{runId}', [GitOpsController::class, 'cancel'])->middleware('permission:gitops.deploy')->whereNumber('runId')->name('gitops.cancel');
    Route::post('/gitops/revertir', [GitOpsController::class, 'rollback'])->middleware('permission:gitops.rollback')->name('gitops.rollback');
});
