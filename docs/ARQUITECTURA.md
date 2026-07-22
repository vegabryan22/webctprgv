# Arquitectura

## Objetivo

El proyecto separa presentación, reglas de aplicación y persistencia mediante el patrón MVC de Laravel.

## Capas

- **Rutas:** `routes/web.php` define direcciones públicas, autenticación y administración.
- **Controladores:** `app/Http/Controllers` recibe solicitudes, valida datos y coordina modelos y vistas.
- **Modelos:** `app/Models` representa usuarios, roles, permisos, páginas y configuración.
- **Vistas públicas:** `resources/views/public` contiene únicamente el contenido particular de cada página.
- **Layouts y parciales:** `resources/views/layouts` y `resources/views/partials` unifican estructura común.
- **Vistas administrativas:** `resources/views/admin` implementa el CMS.
- **Recursos públicos:** `public/css` y `public/images` contiene los archivos que puede servir el navegador.
- **Persistencia:** `database/migrations` mantiene el esquema reproducible; `database/seeders` crea catálogos iniciales.

## Sitio público

`PublicSiteController` sirve las páginas institucionales migradas. La navegación utiliza rutas con nombre para evitar enlaces rotos al cambiar direcciones. Las páginas creadas en el CMS se publican en `/paginas/{slug}` y su contenido se escapa antes de renderizar para prevenir inyección de HTML.

## CMS

El panel vive bajo `/administracion`. Cada solicitud requiere autenticación y el permiso `admin.access`; los módulos aplican además su permiso específico. La interfaz administrativa tiene CSS independiente para que los cambios del panel no afecten el sitio público.

## Próximas extensiones previstas

- Convertir noticias, eventos y especialidades en módulos estructurados del CMS.
- Gestión de archivos e imágenes con validación de tipo y tamaño.
- Historial editorial y aprobación de publicaciones.
- Recuperación de contraseña mediante correo institucional.
