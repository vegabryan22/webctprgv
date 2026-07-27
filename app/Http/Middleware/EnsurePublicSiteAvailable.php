<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class EnsurePublicSiteAvailable
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('administracion', 'administracion/*') || $request->user()) {
            return $next($request);
        }

        if (! Schema::hasTable('site_settings')) {
            return $next($request);
        }

        $settings = SiteSetting::whereIn('key', [
            'maintenance_enabled',
            'maintenance_title',
            'maintenance_message',
        ])->pluck('value', 'key');

        if ($settings->get('maintenance_enabled') !== '1') {
            return $next($request);
        }

        return response()->view('maintenance', [
            'title' => $settings->get('maintenance_title') ?: 'Estamos preparando el sitio',
            'message' => $settings->get('maintenance_message') ?: 'El contenido se encuentra temporalmente en revisión.',
            'returnTo' => $request->getRequestUri(),
        ], 503)->header('Retry-After', '3600');
    }
}
