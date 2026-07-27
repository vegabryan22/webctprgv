<?php

namespace App\Support;

final class CurricularIllustrations
{
    private const POSITIONS = [
        'ejecutivo-comercial-y-de-servicio-al-cliente' => [0, 0],
        'contabilidad-y-finanzas' => [1, 0],
        'administracion-logistica-y-distribucion' => [2, 0],
        'dibujo-y-modelado-de-edificaciones' => [3, 0],
        'configuracion-y-soporte-a-redes-de-comunicacion-y-sistemas-operativos' => [0, 1],
        'electrotecnia' => [1, 1],
        'instalacion-y-mantenimiento-de-sistemas-electricos-industriales' => [2, 1],
        'oficina-secretarial-y-la-inteligencia-de-las-cosas-aiot' => [3, 1],
        'finanzas-verdes' => [0, 2],
        'dibujo-artistico' => [1, 2],
        'tecnologias-de-informacion-y-herramientas-colaborativas' => [2, 2],
        'gestion-innovadora-de-la-informacion' => [3, 2],
        'banca-joven' => [0, 3],
        'dibujo-tecnico' => [1, 3],
        'mantenimiento-preventivo-y-correctivo-de-dispositivos' => [2, 3],
        'explorando-con-automatizacion-industrial' => [3, 3],
        'destrezas-digitales-para-secretariado-y-ejecutivo' => [0, 4],
        'ideando-emprendimientos-juveniles' => [1, 4],
        'emprendimiento-juvenil-en-accion' => [2, 4],
        'diseno-digital' => [3, 4],
        'introduccion-a-la-logistica-industrial' => [0, 5],
        'programacion-de-aplicaciones' => [1, 5],
        'construye-y-programa-tus-propios-dispositivos-electronicos-iot' => [2, 5],
        'ingles-conversacional' => [3, 5],
    ];

    public static function style(string $slug): ?string
    {
        if (! isset(self::POSITIONS[$slug])) {
            return null;
        }

        [$column, $row] = self::POSITIONS[$slug];
        $x = [0, 33.333, 66.667, 100][$column];
        $y = [0, 20, 40, 60, 80, 100][$row];

        return "--atlas-x: {$x}%; --atlas-y: {$y}%";
    }
}
