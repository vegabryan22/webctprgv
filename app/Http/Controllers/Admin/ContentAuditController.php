<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentAuditService;
use Illuminate\View\View;

class ContentAuditController extends Controller
{
    public function __invoke(ContentAuditService $audit): View
    {
        $pages = $audit->audit();

        return view('admin.content-audit.index', [
            'pages' => $pages,
            'totalFindings' => $pages->sum(fn (array $result) => $result['findings']->count()),
            'highFindings' => $pages->sum(fn (array $result) => $result['findings']->where('severity', 'high')->count()),
        ]);
    }
}
