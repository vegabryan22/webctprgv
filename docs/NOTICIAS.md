# Módulo de noticias

## Alcance

El módulo reemplaza la página demostrativa anterior por publicaciones estructuradas y administrables. No duplica las actividades del calendario.

## Datos de una noticia

- Categoría.
- Título y dirección amigable.
- Resumen.
- Contenido HTML saneado.
- Autor.
- Imagen y documento opcionales.
- Estado borrador o publicado.
- Marca de noticia destacada.
- Fecha de publicación.
- Fecha de expiración opcional.

Una noticia pública debe estar publicada, haber alcanzado su fecha de publicación y no haber expirado.

## Permisos

| Permiso | Función |
| --- | --- |
| `news.view` | Consultar noticias en el panel |
| `news.manage` | Crear, editar y eliminar noticias y categorías |
| `news.publish` | Cambiar una noticia al estado publicado |

Los permisos se incorporan a Superadministración y Editor mediante la migración y las semillas.

## Despliegue

La migración `2026_07_24_000300_create_news_tables.php` crea las tablas, categorías iniciales y permisos. En producción debe ejecutarse exclusivamente mediante el flujo GitOps.

No se importan las noticias demostrativas del HTML anterior. El estado vacío se mantiene hasta que una persona autorizada publique información oficial.
