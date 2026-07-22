<?php

use App\Http\Controllers\Admin\ContentPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
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

    Route::get('/configuracion', [SiteSettingController::class, 'edit'])->middleware('permission:settings.manage')->name('settings.edit');
    Route::put('/configuracion', [SiteSettingController::class, 'update'])->middleware('permission:settings.manage')->name('settings.update');
});
