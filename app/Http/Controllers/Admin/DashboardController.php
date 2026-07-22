<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'metrics' => [
                'Usuarios' => User::count(),
                'Roles' => Role::count(),
                'Páginas' => ContentPage::count(),
                'Publicadas' => ContentPage::where('status', 'published')->count(),
            ],
        ]);
    }
}
