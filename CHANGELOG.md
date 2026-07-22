# Registro de cambios

Todos los cambios relevantes del proyecto se documentan aquí en español. El formato se basa en *Keep a Changelog* y el proyecto utiliza versionado semántico.

## [0.5.3] - 2026-07-22

### Corregido

- Los tooltips de redes sociales ahora se despliegan debajo de los iconos y permanecen dentro del área visible.

## [0.5.2] - 2026-07-22

### Corregido

- Etiqueta del menú público cambiada de “JUNTA” a “JUNTA ADMINISTRATIVA”.

## [0.5.1] - 2026-07-22

### Mejorado

- Menú público compacto y adaptable que evita el desbordamiento horizontal en escritorio.
- Iconos representativos, estado de página activa y foco visible para navegación por teclado.
- Marca institucional resumida y enlaces sociales más discretos.
- Estructura HTML válida mediante enlaces directos en lugar de botones anidados.

## [0.5.0] - 2026-07-22

### Añadido

- Importación de 56 fechas institucionales de la circular `DRED-SC07-CTPRGV-D-015-2026` para todos los niveles.
- Importación de 13 fechas académicas de referencia del Calendario 2026 del MEP.
- Metadatos de fuente, referencia, prioridad y carácter tentativo para cada actividad.
- Aviso visible sobre la vigencia de las fechas y distintivos CTPRGV/MEP.

### Cambiado

- Las fechas institucionales del CTPRGV se muestran antes que las referencias MEP cuando coinciden.
- El detalle de una actividad ahora presenta el intervalo completo de fechas.

### Documentado

- La circular institucional también advierte que sus fechas pueden cambiar por disposiciones ministeriales o situaciones fortuitas.

## [0.4.3] - 2026-07-22

### Corregido

- Respuesta 404 de las páginas institucionales causada por fechas de publicación futuras tras una conversión de zona horaria.
- Normalización segura de las fechas afectadas sin modificar borradores ni contenido editorial.

## [0.4.2] - 2026-07-22

### Añadido

- Importación idempotente de 24 actividades de Educación Técnica del Calendario 2026 del MEP.
- Referencia a la página de origen del PDF en la descripción de cada actividad.
- Clasificación de audiencias para actividades estudiantiles, administrativas y generales.

### Cambiado

- Versión de la aplicación actualizada a `0.4.2`.

## [0.4.1] - 2026-07-22

### Corregido

- Conflicto entre las clases del calendario nuevo y estilos heredados de la página de Noticias.
- Celdas circulares, columnas fuera de pantalla y encabezado mensual con contraste insuficiente.
- Idioma efectivo de meses y fechas en el entorno local.
- Desbordamiento horizontal de la navegación pública al incorporar el calendario.

### Añadido

- Menú público adaptable tipo hamburguesa para pantallas medianas y pequeñas.
- Versionado de hojas CSS para evitar que el navegador conserve estilos obsoletos.

## [0.4.0] - 2026-07-22

### Añadido

- Calendario público mensual con navegación entre meses.
- Listado de próximas actividades con filtros por categoría y público.
- Página de detalle para cada actividad.
- Exportación iCalendar (`.ics`) compatible con Google Calendar, Outlook y calendarios móviles.
- Administración de actividades con borrador, publicación y cancelación.
- Categorías administrables con color identificador.
- Audiencias: general, estudiantes, familias, personal y comunidad.
- Imagen destacada, documento adjunto, ubicación y enlace de inscripción.
- Permisos `events.view`, `events.manage` y `events.publish`.
- Indicador de próximas actividades en el resumen administrativo.

### Cambiado

- La aplicación utiliza la zona horaria `America/Costa_Rica` y el idioma español por defecto.
- El menú inicial incorpora “CALENDARIO” sin sobrescribir personalizaciones existentes.

### Seguridad

- Los borradores no son accesibles mediante rutas públicas.
- Publicar o cancelar requiere un permiso independiente.
- Imágenes y documentos tienen validación de formato y tamaño.
- Las descripciones se sanean antes de guardarse.

## [0.3.0] - 2026-07-22

### Añadido

- Importación idempotente de las siete páginas institucionales existentes a MySQL.
- Edición visual y HTML del contenido de páginas desde el CMS.
- Administración del menú principal con etiqueta, página o URL, orden, visibilidad y apertura en nueva pestaña.
- Permisos `menu.view` y `menu.manage`.
- Saneamiento de HTML para retirar scripts, eventos, protocolos peligrosos e iframes no autorizados.
- Protección de páginas institucionales contra eliminación accidental.

### Cambiado

- Todas las rutas públicas existentes obtienen su contenido desde MySQL.
- La navegación pública se construye con los elementos administrados desde el CMS.
- Los scripts técnicos heredados se conservan separados del contenido editorial.

### Seguridad

- El formulario editorial no permite modificar scripts de las páginas institucionales.
- Los enlaces externos del menú solo aceptan los protocolos HTTP y HTTPS.
- Las páginas institucionales conservan sus rutas protegidas aunque cambie su contenido.

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
