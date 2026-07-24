<?php

namespace App\Http\Controllers;

use App\Models\InstitutionalService;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $services = InstitutionalService::with('category')->published()
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('category'))))
            ->orderBy('sort_order')->orderBy('name')->paginate(12)->withQueryString();

        return view('services.index', [
            'services' => $services,
            'categories' => ServiceCategory::whereHas('services', fn ($query) => $query->published())->orderBy('sort_order')->get(),
        ]);
    }

    public function show(InstitutionalService $service): View
    {
        abort_unless(InstitutionalService::published()->whereKey($service)->exists(), 404);

        return view('services.show', compact('service'));
    }
}
