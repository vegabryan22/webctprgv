# Registro de cambios

Todos los cambios relevantes del proyecto se documentan aquí en español. El formato se basa en *Keep a Changelog* y el proyecto utiliza versionado semántico.

## [0.2.0] - 2026-07-22

### Añadido

- Panel GitHub GitOps con estado del repositorio local e historial de commits.
- Consulta configurable de las ejecuciones recientes de GitHub Actions.
- Disparo manual del workflow de despliegue con confirmación y permiso independiente.
- Bitácora local auditable para cada solicitud de despliegue.
- Permisos `gitops.view` y `gitops.deploy`.
- Iconos representativos en navegación, métricas, acciones y estados.

### Cambiado

- Botones y enlaces administrativos con mejores contrastes, foco visible, estados interactivos y variantes semánticas.
- Etiquetas visuales diferenciadas para éxito, advertencia, error y estados neutrales.

### Seguridad

- El token de GitHub se mantiene exclusivamente en variables de entorno.
- La consulta y el despliegue remoto requieren permisos distintos.
- El panel nunca presenta el contenido del token configurado.

## [0.1.1] - 2026-07-22

### Cambiado

- MySQL 8.0 pasa a ser el motor de base de datos predeterminado del proyecto.
- La configuración de ejemplo utiliza la base `ctprgv` y un usuario de aplicación dedicado.

### Seguridad

- Laravel deja de conectarse con una cuenta administrativa de MySQL.
- El usuario `ctprgv_app` limita sus permisos exclusivamente a la base `ctprgv`.

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
