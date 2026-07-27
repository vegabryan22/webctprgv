<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $publishedAt = now();
        $verifiedAt = '2026-07-26 00:00:00';

        DB::table('specialties')
            ->whereIn('name', [
                'Ejecutivo comercial y de servicio al cliente',
                'Contabilidad y finanzas',
                'Administración logística y distribución',
                'Dibujo y modelado de edificaciones',
                'Configuración y soporte a redes de comunicación y sistemas operativos',
                'Electrotecnia',
                'Instalación y mantenimiento de sistemas eléctricos industriales',
            ])
            ->where('status', 'draft')
            ->update([
                'status' => 'published',
                'verified_at' => $verifiedAt,
                'published_at' => $publishedAt,
                'updated_at' => $publishedAt,
            ]);

        DB::table('exploratory_workshops')
            ->whereIn('name', [
                'Oficina secretarial y la inteligencia de las cosas (AIoT)',
                'Finanzas verdes',
                'Dibujo artístico',
                'Tecnologías de información y herramientas colaborativas',
                'Gestión innovadora de la información',
                'Banca joven',
                'Dibujo técnico',
                'Mantenimiento preventivo y correctivo de dispositivos',
                'Explorando con automatización industrial',
                'Destrezas digitales para Secretariado y Ejecutivo',
                'Ideando emprendimientos juveniles',
                'Emprendimiento juvenil en acción',
                'Diseño digital',
                'Introducción a la logística industrial',
                'Programación de aplicaciones',
                'Construye y programa tus propios dispositivos electrónicos IoT',
                'Inglés conversacional',
            ])
            ->where('status', 'draft')
            ->update([
                'status' => 'published',
                'verified_at' => $verifiedAt,
                'published_at' => $publishedAt,
                'updated_at' => $publishedAt,
            ]);
    }

    public function down(): void
    {
        // La publicación puede recibir ediciones posteriores y no se revierte automáticamente.
    }
};
