<?php

namespace App\Services;

use App\Models\ContentPage;
use Illuminate\Support\Collection;

class ContentAuditService
{
    public function audit(): Collection
    {
        return ContentPage::where('route_name', '!=', 'news')->orderBy('title')->get()->map(function (ContentPage $page): array {
            $content = $page->content ?? '';
            $script = $page->script ?? '';
            $findings = collect();

            $this->match($findings, $content, '/href\s*=\s*["\']#["\']/i', 'Enlace sin destino', 'Hay enlaces con “#” que no llevan a información real.', 'high');
            $this->match($findings, $content.$script, '/solo para demostraci[oó]n|contenido de demostraci[oó]n/i', 'Contenido demostrativo', 'El contenido se identifica como demostración y no debe presentarse como oficial.', 'high');
            $this->match($findings, $content, '/<form\b(?![^>]*\baction\s*=)[^>]*>/i', 'Formulario sin destino', 'El formulario no declara dónde entregar la solicitud.', 'high');
            $this->match($findings, $content, '/(?:₡|&#8353;)\s*[\d.,]+/u', 'Precios publicados', 'Los precios requieren responsable y fecha de vigencia.', 'high');
            $this->match($findings, $content, '/licitaci[oó]n|presupuesto estimado/i', 'Contratación o presupuesto', 'Debe confirmarse con la Junta Administrativa y mostrar vigencia y fuente.', 'high');
            $this->match($findings, $content, '/empleabilidad|inserci[oó]n laboral|convenios? empresariales?/i', 'Afirmación institucional por verificar', 'Requiere una fuente comprobable o confirmación del área responsable.', 'medium');
            $this->match($findings, $content, '/400\s+horas/i', 'Duración de práctica por verificar', 'Debe contrastarse con el programa oficial y Coordinación Técnica.', 'medium');

            if (in_array($page->route_name, ['board', 'contact', 'information'], true)) {
                $this->match($findings, $content, '/\b202[0-5]\b/', 'Referencia posiblemente vencida', 'Revise si esta fecha sigue vigente para el trámite o proceso.', 'medium');
            }

            if ($page->route_name === 'anniversary') {
                $this->match($findings, $content, '/testimonios?|exalumnos? destacados?/i', 'Testimonio por documentar', 'Confirme identidad, autorización y fidelidad del testimonio.', 'medium');
            }

            preg_match_all('/<iframe\b[^>]*\bsrc=["\']([^"\']+)["\']/i', $content, $iframeMatches);
            if (count($iframeMatches[1] ?? []) > count(array_unique($iframeMatches[1] ?? []))) {
                $findings->push($this->finding('Contenido multimedia repetido', 'Hay videos o recursos incrustados con la misma dirección.', 'low'));
            }

            return [
                'page' => $page,
                'findings' => $findings,
                'score' => max(0, 100 - $findings->sum(fn (array $finding) => ['high' => 25, 'medium' => 12, 'low' => 5][$finding['severity']])),
            ];
        });
    }

    private function match(Collection $findings, string $content, string $pattern, string $title, string $description, string $severity): void
    {
        if (preg_match($pattern, $content)) {
            $findings->push($this->finding($title, $description, $severity));
        }
    }

    private function finding(string $title, string $description, string $severity): array
    {
        return compact('title', 'description', 'severity');
    }
}
