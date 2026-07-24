<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use App\Models\BoardTransparencyRecord;
use App\Models\ContentPage;
use Illuminate\View\View;

class BoardController extends Controller
{
    public function __invoke(): View
    {
        return view('board.index', [
            'page' => ContentPage::where('route_name', 'board')->published()->first(),
            'members' => BoardMember::published()->orderBy('sort_order')->orderBy('position')->get(),
            'records' => BoardTransparencyRecord::with(['documents' => fn ($query) => $query->published()->orderBy('title')])
                ->published()->orderByDesc('record_date')->orderBy('sort_order')->get()->groupBy('type'),
        ]);
    }
}
