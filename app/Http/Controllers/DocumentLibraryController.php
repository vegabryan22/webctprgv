<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use App\Models\InstitutionalDocument;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentLibraryController extends Controller
{
    public function __invoke(Request $request): View
    {
        $search = trim($request->string('q'));
        $documents = InstitutionalDocument::with('category')->published()->when($search !== '', fn ($q) => $q->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")->orWhere('responsible', 'like', "%{$search}%")))->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($q) => $q->where('slug', $request->string('category'))))->latest('issued_at')->paginate(15)->withQueryString();

        return view('documents.index', ['documents' => $documents, 'categories' => DocumentCategory::whereHas('documents', fn ($q) => $q->published())->orderBy('sort_order')->get(), 'search' => $search]);
    }
}
