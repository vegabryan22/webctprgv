<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalExperience;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfessionalExperienceController extends Controller
{
    public function index(Request $request): View
    {
        $experiences = ProfessionalExperience::with('specialties')->published()
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')))
            ->orderBy('sort_order')->orderBy('title')->get();

        return view('experiences.index', compact('experiences'));
    }

    public function show(ProfessionalExperience $experience): View
    {
        abort_unless(ProfessionalExperience::published()->whereKey($experience)->exists(), 404);
        $experience->load(['specialties', 'documents' => fn ($query) => $query->published()->orderBy('title')]);

        return view('experiences.show', compact('experience'));
    }
}
