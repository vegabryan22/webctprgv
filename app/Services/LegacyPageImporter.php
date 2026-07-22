<?php

namespace App\Services;

use App\Models\ContentPage;
use App\Models\NavigationItem;

class LegacyPageImporter
{
    private const PAGES = [
        ['route' => 'home', 'view' => 'home', 'title' => 'Inicio', 'slug' => 'inicio', 'label' => 'INICIO'],
        ['route' => 'news', 'view' => 'news', 'title' => 'Noticias', 'slug' => 'noticias', 'label' => 'NOTICIAS'],
        ['route' => 'information', 'view' => 'information', 'title' => 'Información', 'slug' => 'informacion', 'label' => 'INFORMACIÓN'],
        ['route' => 'specialties', 'view' => 'specialties', 'title' => 'Especialidades', 'slug' => 'especialidades', 'label' => 'ESPECIALIDADES'],
        ['route' => 'board', 'view' => 'board', 'title' => 'Junta Administrativa', 'slug' => 'junta-administrativa', 'label' => 'JUNTA'],
        ['route' => 'contact', 'view' => 'contact', 'title' => 'Contacto', 'slug' => 'contacto', 'label' => 'CONTACTO'],
        ['route' => 'anniversary', 'view' => 'anniversary', 'title' => '50 Aniversario', 'slug' => '50-aniversario', 'label' => null],
    ];

    public function import(): void
    {
        foreach (self::PAGES as $position => $definition) {
            $source = file_get_contents(resource_path('views/public/'.$definition['view'].'.blade.php'));
            preg_match("/@section\('content'\)\s*(.*?)\s*@endsection/s", $source, $contentMatch);
            preg_match("/@push\('scripts'\)\s*<script>\s*(.*?)\s*<\/script>\s*@endpush/s", $source, $scriptMatch);

            $page = ContentPage::firstOrCreate(
                ['route_name' => $definition['route']],
                [
                    'title' => $definition['title'],
                    'slug' => $definition['slug'],
                    'is_system' => true,
                    'content' => $this->replaceBladeLinks($contentMatch[1] ?? ''),
                    'script' => $scriptMatch[1] ?? null,
                    'status' => 'published',
                    'published_at' => now(),
                ],
            );

            if ($definition['label']) {
                NavigationItem::firstOrCreate(
                    ['route_name' => $definition['route']],
                    ['label' => $definition['label'], 'sort_order' => ($position + 1) * 10, 'is_active' => true],
                );
            }

            if (! $page->is_system) {
                $page->update(['is_system' => true]);
            }
        }
    }

    private function replaceBladeLinks(string $content): string
    {
        return str_replace(
            [
                "{{ asset('images/escudo.png') }}",
                "{{ route('anniversary') }}",
                "{{ route('contact') }}",
            ],
            ['/images/escudo.png', '/50-aniversario', '/contacto'],
            $content,
        );
    }
}
