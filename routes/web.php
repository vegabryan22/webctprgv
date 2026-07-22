<?php

use App\Http\Controllers\Admin\ContentPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GitOpsController;
use App\Http\Controllers\Admin\NavigationItemController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::controller(PublicSiteController::class)->group(function (): void {
    Route::get('/', 'home')->name('home');
    Route::get('/noticias', 'news')->name('news');
    Route::get('/informacion', 'information')->name('information');
    Route::get('/especialidades', 'specialties')->name('specialties');
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
    Route::post('/gitops/desplegar', [GitOpsController::class, 'dispatch'])->middleware('permission:gitops.deploy')->name('gitops.dispatch');
});
