<?php

namespace App\Http\Middleware;

use App\Models\SiteSection;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteSectionActive
{
    public function handle(Request $request, Closure $next, string $section): Response
    {
        abort_unless(SiteSection::enabled($section), 404);

        return $next($request);
    }
}
