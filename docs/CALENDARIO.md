# Calendario de actividades

## Acceso

- Sitio público: `/calendario`.
- Vista pública en lista: `/calendario/actividades`.
- Administración: **Contenido → Actividades**.
- Categorías: **Contenido → Categorías**.

## Datos de una actividad

Cada registro puede contener:

- nombre y dirección amigable;
- categoría y público;
- inicio y finalización;
- indicador de día completo;
- ubicación;
- resumen y descripción HTML saneada;
- enlace de inscripción o información;
- imagen destacada de hasta 4 MB;
- documento PDF, Word o Excel de hasta 10 MB;
- estado editorial.

## Estados

- **Borrador:** solo aparece en administración.
- **Publicado:** aparece en calendario, listado y página individual.
- **Cancelado:** continúa visible con una advertencia para evitar que la comunidad pierda el contexto de la actividad.

Publicar o cancelar exige `events.publish`. Un usuario con `events.manage` puede preparar borradores sin hacerlos públicos.

## Categorías

Las categorías iniciales son Académica, Técnica, Cultural, Deportiva, Administrativa e Institucional. Su color se utiliza en el calendario. Una categoría con actividades asociadas no puede eliminarse.

## Exportación

La acción **Agregar a mi calendario** descarga un archivo `.ics` con fecha, hora, lugar, descripción, enlace y estado. Los eventos de día completo utilizan fechas sin zona horaria; los eventos con hora se exportan en UTC a partir de `America/Costa_Rica`.

## Archivos

Los archivos se guardan en `storage/app/public/events` y se publican mediante el enlace `public/storage`. El despliegue debe ejecutar una vez:

```powershell
php artisan storage:link
```

## Ampliaciones previstas

- Recurrencia semanal o mensual.
- Vista anual e impresión.
- Recordatorios por correo.
- Suscripción a un calendario institucional completo.
