# Registro de cambios

Todos los cambios relevantes del proyecto se documentan aquí en español. El formato se basa en *Keep a Changelog* y el proyecto utiliza versionado semántico.

## [0.14.0] - 2026-07-24

### Añadido

- Indicador de versiones más nuevas que la versión efectiva de producción.
- Selector de tag objetivo para aplicar versiones publicadas individualmente.
- Opción explícita para desplegar la última versión de la rama configurada.
- Verificación remota de la referencia antes de solicitar el workflow.

### Mejorado

- Separación clara entre actualización a una versión nueva y reversión a una versión anterior.
- Bitácora GitOps registra la referencia exacta seleccionada para el despliegue.

## [0.13.0] - 2026-07-24

### Añadido

- Módulo administrable de talleres exploratorios para 7.º, 8.º y 9.º.
- Recorridos públicos diferenciados entre talleres exploratorios y especialidades técnicas.
- Permisos de consulta, gestión y publicación para talleres.

### Corregido

- Las especialidades técnicas se identifican explícitamente como oferta para 10.º, 11.º y 12.º.

### Base de datos

- Migración `2026_07_24_000600_create_exploratory_workshops_table.php`.

## [0.12.0] - 2026-07-24

### Añadido

- Fichas estructuradas de especialidades con perfil, formación, oportunidades, contacto y programa oficial.
- Administración y permisos independientes de consulta, gestión y publicación.
- Listado y detalle públicos adaptables sobre la ruta existente de Especialidades.
- Precarga en borrador de los seis nombres heredados para revisión de Coordinación Técnica.

### Cambiado

- La página heredada deja de presentar automáticamente afirmaciones de empleabilidad, convenios y duración de práctica sin fuente.

### Base de datos

- Migración `2026_07_24_000500_create_specialties_table.php`.

## [0.11.0] - 2026-07-24

### Añadido

- Catálogo estructurado de servicios con categorías, requisitos, público, responsables, horarios y contactos.
- Administración de documentos, enlaces de gestión, fecha de verificación, orden y estados.
- Permisos independientes para consultar, gestionar y publicar servicios.
- Listado y detalle públicos adaptables, incorporados al menú principal.
- Estado vacío que evita presentar servicios genéricos como información oficial.

### Base de datos

- Migración `2026_07_24_000400_create_service_catalog_tables.php` con tablas, categorías, permisos y navegación.

## [0.10.0] - 2026-07-24

### Añadido

- Revisión editorial administrativa sobre el contenido vigente del CMS.
- Detección de enlaces vacíos, formularios incompletos, precios, fechas posiblemente vencidas y contenido demostrativo.
- Alertas para afirmaciones de empleabilidad, convenios, práctica profesional, testimonios y multimedia repetida.
- Inventario editorial con prioridades, responsables sugeridos y tratamiento de cada clasificación.
- Puntuación orientativa por página sin modificar automáticamente el contenido.

### Documentado

- La Junta Administrativa, Contacto, Especialidades y 50 Aniversario requieren confirmaciones institucionales antes de considerarse saneadas.
- El contenido heredado de Noticias queda excluido porque fue sustituido por el módulo estructurado.

## [0.9.1] - 2026-07-24

### Corregido

- Encabezado de Noticias compacto y alineado con la navegación pública.
- Contraste explícito del título y espaciado adaptable para evitar que el menú fijo cubra el contenido.
- Separación y tamaños de texto optimizados para escritorio, tabletas y teléfonos.

## [0.9.0] - 2026-07-24

### Añadido

- Módulo estructurado de noticias con categorías, borradores, publicación programada, expiración y destacados.
- Administración de noticias, imágenes, documentos adjuntos y permisos separados de consulta, gestión y publicación.
- Listado y detalle público adaptables con filtros por categoría y estado vacío institucional.
- Pruebas de visibilidad, vencimiento, publicación administrativa y atribución del pie.

### Cambiado

- El pie acredita al Departamento de Redes, Prof. Bryan Vega Rondón y estudiantes de 12.º año, usando automáticamente el año en curso.
- La página de Noticias deja de mostrar eventos demostrativos y el calendario estático de 2025.

### Base de datos

- Migración `2026_07_24_000300_create_news_tables.php` para noticias, categorías y permisos.

## [0.8.1] - 2026-07-24

### Añadido

- Plan maestro con etapas, unidades de trabajo, estados, dependencias y criterios de cierre.
- Registro de decisiones, riesgos, responsables y bitácora de versiones y commits.
- Proceso trazable desde la preparación local hasta la aplicación mediante GitOps.

### Mejorado

- Política de versionamiento vinculada con identificadores permanentes de trabajo y commits de implementación y cierre.

## [0.8.0] - 2026-07-24

### Añadido

- Accesos rápidos en la portada para calendario, especialidades, información estudiantil y contacto.
- Bloque dinámico de próximas actividades conectado con el calendario administrable.
- Identificación visible de las fechas tentativas procedentes del calendario MEP.
- Plan editorial y matriz de responsables para las siguientes fases de contenido.

### Mejorado

- La portada conserva el contenido administrable del CMS y lo complementa con componentes estructurados.
- Presentación adaptable y accesible de accesos y actividades para computadoras y dispositivos móviles.

## [0.7.3] - 2026-07-24

### Mejorado

- Flujo GitOps compacto en tres columnas con estados, resultados y acciones visibles.
- Consulta remota independiente y botón sólido para validar producción.
- Adaptación vertical del flujo operativo para pantallas pequeñas.

## [0.7.2] - 2026-07-24

### Corregido

- El workflow captura el commit desde el workspace Git antes de entrar al artefacto de producción.

## [0.7.1] - 2026-07-24

### Corregido

- Pruebas del panel actualizadas para la nueva terminología y lectura silenciosa del estado previo al primer despliegue registrado.

## [0.7.0] - 2026-07-24

### Añadido

- Centro de despliegue controlado con salud HTTP y base de datos, versión efectiva, commit, referencia y runner.
- Historial remoto de commits, tags y ejecuciones de GitHub Actions.
- Validación manual con bitácora, cancelación de ejecuciones activas y reversión segura a tags publicados.
- Confirmación obligatoria `REVERTIR` y permiso independiente `gitops.rollback`.
- Registro persistente del commit, referencia, operación y fecha de cada despliegue.

## [0.6.6] - 2026-07-24

### Actualizado

- GitHub Actions utiliza `actions/checkout@v5`, compatible con el runtime Node.js 24 del runner.

## [0.6.5] - 2026-07-24

### Corregido

- Las vistas Blade se limpian durante el despliegue y PHP-FPM las compila con el propietario correcto, evitando errores 500.

## [0.6.4] - 2026-07-24

### Corregido

- El despliegue preserva `storage` y `bootstrap/cache`, compartidos de forma segura entre el runner y PHP-FPM.

## [0.6.3] - 2026-07-24

### Corregido

- El entorno aislado de pruebas del workflow dispone de una clave de aplicación exclusiva para CI.

## [0.6.2] - 2026-07-24

### Corregido

- El workflow utiliza una versión aislada y actual de Composer, compatible con Laravel 13.
- La construcción tolera que `fileinfo` no esté habilitado en PHP CLI sin modificar la configuración global del servidor.

## [0.6.1] - 2026-07-24

### Añadido

- Workflow manual de GitHub Actions para validar y desplegar el sitio mediante un runner autohospedado.
- Despliegue restringido a `html`, con copia de seguridad, migraciones, cachés y comprobación HTTP.

## [0.6.0] - 2026-07-24

### Añadido

- Formulario administrativo para configurar repositorio, rama, workflow y token de GitHub desde el panel GitOps.
- Almacenamiento cifrado del token en la base de datos, con opciones independientes para conservarlo, reemplazarlo o eliminarlo.

## [0.5.9] - 2026-07-24

### Corregido

- El panel GitOps ya no produce un error 500 cuando PHP tiene `proc_open` deshabilitado o el despliegue no incluye el repositorio Git local.
- El estado y el historial local muestran una indicación clara cuando no están disponibles, sin afectar la integración remota con GitHub Actions.

## [0.5.8] - 2026-07-22

### Corregido

- Alineación del control “Mantener sesión iniciada” en el formulario de acceso.
- Versionado de la hoja de estilos del login para evitar estilos antiguos en caché.

### Añadido

- Enlace “Volver al sitio” desde la pantalla de administración.

## [0.5.7] - 2026-07-22

### Corregido

- Paginación sobredimensionada y en inglés en las tablas administrativas de actividades, páginas y usuarios.
- Controles administrativos compactos, accesibles y coherentes con la paleta del CMS.

## [0.5.6] - 2026-07-22

### Corregido

- Desbordamiento del menú al mostrar “Panel administrativo” junto a Calendario y las redes sociales.
- Puntos de quiebre progresivos que priorizan la navegación principal y el acceso administrativo.

## [0.5.5] - 2026-07-22

### Añadido

- Acceso “Iniciar sesión” en el menú público para visitantes.
- Acceso “Panel administrativo” cuando la persona autenticada posee el permiso `admin.access`.

### Seguridad

- El enlace administrativo no se muestra a usuarios autenticados sin permiso de acceso al panel.

## [0.5.4] - 2026-07-22

### Corregido

- Paginación pública del calendario reemplazada por controles compactos en español.
- Eliminada la flecha SVG sobredimensionada producida por los estilos predeterminados de Laravel/Tailwind.

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
