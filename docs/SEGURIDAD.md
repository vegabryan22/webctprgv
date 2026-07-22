# Seguridad, roles y permisos

## Modelo

La relación es de muchos a muchos: un usuario puede tener varios roles y cada rol puede reunir varios permisos. No se guardan permisos directamente en la sesión; se consultan desde la base de datos.

## Matriz de permisos

| Grupo | Permiso | Propósito |
|---|---|---|
| Administración | `admin.access` | Ingresar al panel |
| Usuarios | `users.view` | Consultar cuentas |
| Usuarios | `users.create` | Crear cuentas |
| Usuarios | `users.update` | Modificar cuentas y roles |
| Usuarios | `users.delete` | Eliminar cuentas |
| Seguridad | `roles.view` | Consultar roles y permisos |
| Seguridad | `roles.manage` | Crear, editar y eliminar roles personalizados |
| Contenido | `pages.view` | Consultar páginas del CMS |
| Contenido | `pages.manage` | Crear, editar, archivar y eliminar páginas |
| Contenido | `pages.publish` | Publicar contenido visible |
| Contenido | `menu.view` | Consultar el menú principal |
| Contenido | `menu.manage` | Crear, ordenar, ocultar y eliminar opciones del menú |
| Calendario | `events.view` | Consultar actividades en el panel |
| Calendario | `events.manage` | Crear, editar, eliminar y administrar categorías |
| Calendario | `events.publish` | Publicar y cancelar actividades |
| Configuración | `settings.manage` | Modificar datos generales del sitio |
| GitOps | `gitops.view` | Consultar repositorio y ejecuciones de Actions |
| GitOps | `gitops.deploy` | Solicitar un workflow de despliegue manual |

## Roles iniciales

- **Superadministración:** acceso completo. Es un rol del sistema y no puede modificarse ni eliminarse desde el panel.
- **Editor de contenido:** administra y publica páginas, sin acceso a usuarios o configuración.
- **Gestor de usuarios:** administra cuentas y puede consultar los roles disponibles, pero no cambiar permisos.

## Reglas operativas

- Cada persona debe utilizar una cuenta individual.
- Las contraseñas deben tener al menos 12 caracteres.
- Se debe aplicar el principio de menor privilegio.
- La cuenta activa no puede eliminarse a sí misma.
- Las acciones destructivas utilizan confirmación en la interfaz.
- Las páginas institucionales no se pueden eliminar desde el CMS.
- El HTML editorial se sanea en el servidor antes de guardarse.
- `.env`, claves y contraseñas no deben incorporarse al repositorio.
