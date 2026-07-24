# Catálogo de servicios institucionales

## Propósito

Centralizar gestiones y apoyos con información verificable para estudiantes, familias, personal y comunidad.

## Información administrable

- Categoría, nombre, resumen y descripción.
- Público al que se dirige.
- Requisitos.
- Departamento responsable y horario.
- Teléfono y correo.
- Enlace externo para realizar la gestión.
- Formulario o documento descargable.
- Fecha de verificación.
- Estado borrador o publicado.
- Orden de presentación.

## Regla editorial

Los servicios se crean inicialmente como borradores. Solo deben publicarse después de confirmar requisitos, horario, responsable y contacto con el departamento correspondiente.

No se importaron las tarjetas genéricas del HTML heredado.

## Permisos

| Permiso | Función |
| --- | --- |
| `services.view` | Consultar servicios en el panel |
| `services.manage` | Crear, editar, eliminar y clasificar |
| `services.publish` | Publicar información confirmada |

## Despliegue

La migración `2026_07_24_000400_create_service_catalog_tables.php` crea tablas, categorías iniciales, permisos y el acceso público `SERVICIOS`. En producción se ejecutará exclusivamente mediante GitOps.
