<?php

namespace App\Http\Controllers;

use App\Models\DirectoryEntry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectoryController extends Controller
{
    public function __invoke(Request $request): View
    {
        $search = trim($request->string('q')->toString());
        $entries = DirectoryEntry::published()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                $query->where('department', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('person_name', 'like', "%{$search}%");
            }))
            ->orderBy('sort_order')->orderBy('department')->get();

        return view('directory.index', [
            'groups' => $entries->groupBy('department'),
            'search' => $search,
        ]);
    }
}
