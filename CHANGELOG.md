# Registro de cambios

Todos los cambios relevantes del proyecto se documentan aquí en español. El formato se basa en *Keep a Changelog* y el proyecto utiliza versionado semántico.

## [0.1.0] - 2026-07-22

### Añadido

- Base Laravel 13.21.1 con PHP 8.5 para desarrollo local.
- Arquitectura MVC y rutas con nombres para las siete páginas institucionales.
- Layouts y parciales Blade para navegación y pie comunes.
- Panel administrativo con identidad visual azul, verde y amarilla del colegio.
- Inicio y cierre de sesión protegidos contra fijación de sesión y CSRF.
- Administración de usuarios con asignación de roles.
- Administración de roles y permisos granulares.
- Módulo CMS inicial para páginas con estados borrador, publicado y archivado.
- Configuración central de datos institucionales.
- Migraciones, datos iniciales y pruebas de autorización.
- Documentación técnica y operativa en español.

### Cambiado

- Las páginas HTML estáticas se migraron a vistas Blade sin cambiar la hoja de estilos pública.
- Los enlaces relativos se sustituyeron por rutas Laravel.
- Las imágenes y CSS públicos se organizaron dentro de `public/`.

### Seguridad

- Acceso administrativo sujeto al permiso `admin.access`.
- Separación de permisos por módulo y acción.
- Rol de superadministración protegido contra edición y eliminación desde el panel.
- Publicación de contenido validada también en el servidor mediante `pages.publish`.
