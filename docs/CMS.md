# Gestión de páginas y menú

## Páginas institucionales

Las páginas Inicio, Noticias, Información, Especialidades, Junta Administrativa, Contacto y 50 Aniversario se importan a `content_pages` durante la carga de datos iniciales. La importación es idempotente: crea registros ausentes, pero no sobrescribe cambios editoriales existentes.

Desde `0.25.0`, Inicio utiliza una plantilla pública estructurada alimentada por especialidades, talleres, calendario y noticias. `content_pages` conserva el título y el contenido heredado como respaldo editorial, pero el campo `content` de Inicio no se imprime públicamente para evitar duplicar bloques trasladados a Información y otros módulos.

Desde `0.26.0`, la página con `route_name=information` se presenta editorialmente como “Nuestra institución”. La ruta histórica `/informacion` no cambia. El módulo conserva misión, visión, identidad e historia; los trámites y apoyos deben mantenerse en Servicios.

Desde `0.27.0`, esta página utiliza una composición visual propia con portada, características, misión, visión, valores y accesos relacionados. La estructura HTML se conserva en `content_pages.content`, por lo que continúa disponible en el editor avanzado del CMS. La migración de actualización solo reemplaza el contenido heredado reconocible y no sobrescribe una edición manual distinta.

Las páginas institucionales muestran la etiqueta **Institucional** en el panel. Se puede modificar:

- título;
- resumen;
- contenido;
- estado de publicación.

## Resumen administrativo

Desde `0.35.0`, la entrada de Administración es un tablero operativo y no un simple contador. Presenta:

- estado público o modo mantenimiento;
- cantidad de secciones visibles;
- contenido publicado y tareas pendientes;
- publicaciones y borradores por módulo;
- próximas actividades;
- consultas recientes;
- totales de usuarios y roles.

Los enlaces y datos sensibles respetan los permisos del usuario autenticado. Las tarjetas se reorganizan progresivamente hasta una sola columna en teléfonos. Todos los indicadores se calculan desde el estado actual almacenado en MySQL.

## Contacto público

Desde `0.28.0`, la página `/contacto` no imprime el HTML heredado de la página del CMS. Utiliza parámetros estructurados de `site_settings`, administrables desde **Contenido → Contacto**:

- título y texto introductorio;
- teléfono principal y secundario;
- correo electrónico;
- horario;
- dirección y enlace público del mapa;
- fecha de verificación y fuente responsable.

El permiso `contact.manage` controla esta pantalla. Los editores de contenido y la superadministración lo reciben de forma predeterminada.

Desde `0.29.0`, el formulario público es funcional. Cada envío:

- se valida y almacena en `contact_messages`;
- exige consentimiento para atender la consulta;
- aplica una trampa antispam y límite de frecuencia;
- notifica al correo receptor configurado o, en su ausencia, al correo público;
- aparece en **Contenido → Consultas** con estados nuevo, leído, atendido y archivado.

La consulta permanece guardada aunque el servicio de correo falle. El panel registra las fechas de lectura y atención, y no expone los mensajes en rutas públicas.

Desde `0.29.1`, cuando existe una dirección, Contacto genera un mapa visible y adaptable dentro de la página. El campo **Enlace público del mapa** continúa definiendo el destino del botón “Abrir mapa”; no se necesita pegar código de inserción ni un iframe en el CMS.

## Junta Administrativa

Desde `0.30.0`, **Contenido → Junta y transparencia** permite mantener publicaciones de:

- proyectos;
- licitaciones o contrataciones;
- uniformes;
- materiales;
- informes;
- avisos.

Cada publicación admite resumen, contenido, responsable, fuente, fecha, vigencia, documentos y orden. El precio y su nota son opcionales: si no existe un monto confirmado, puede mostrarse una nota como “Precio pendiente de confirmación”. Para publicar siguen siendo obligatorias la fuente y la fecha de verificación.

El HTML heredado con proyectos, licitaciones y precios demostrativos fue retirado. Las camisas del uniforme y el cuaderno de comunicaciones se cargaron como publicaciones verificadas sin precio.

## Estado público del sitio

Desde `0.31.0`, **Contenido → Estado del sitio** muestra en un solo panel las secciones públicas principales. Un editor autorizado puede activar o desactivar Noticias, Institución, Especialidades, Talleres, Junta Administrativa, Contacto, Servicios, Calendario, Práctica profesional, Directorio, Documentos, Admisión y matrícula y 50 Aniversario.

Cuando una sección está desactivada:

- desaparece de la navegación principal;
- se retiran sus accesos de Inicio y del pie cuando corresponda;
- sus rutas públicas responden 404;
- sus datos y configuración permanecen intactos en MySQL.

Inicio y Administración no se pueden desactivar desde este panel. El permiso requerido es `site-sections.manage`.

Los listados administrativos de Especialidades y Talleres ofrecen además una acción rápida **Activar/Desactivar** para cada ficha. Desactivar cambia el registro a borrador, lo retira del catálogo público y conserva toda su información, imagen y planes.

## Admisión y matrícula

Desde `0.33.0`, el portal `/admision-y-matricula` integra información administrada desde cuatro lugares:

- **Contenido → Páginas:** título, resumen e introducción de la página de Admisión.
- **Contenido → Actividades:** fechas del proceso y categoría Admisión.
- **Contenido → Documentos:** circulares, reglamentos, vigencia y responsable.
- **Contenido → Menú principal:** etiqueta, posición y visibilidad del acceso.

El panel **Estado del sitio** permite desactivar toda la sección sin eliminar sus datos. La página separa el ingreso a 7.º de la elección de especialidad para 10.º y no duplica los eventos ni los archivos.

Los tres PDF recibidos se distribuyen como documentos versionados del proyecto. Si Dirección emite archivos corregidos, deben cargarse desde Documentos y marcar los anteriores como reemplazados. No se deben copiar al resumen público montos, fechas o requisitos contradictorios mientras no exista una comunicación aclaratoria.

## Modo mantenimiento y revisión autenticada

Desde `0.34.0`, **Contenido → Estado del sitio** incluye el control de mantenimiento general. Al activarlo:

- las rutas públicas muestran una pantalla temporal y responden HTTP 503;
- el formulario de inicio de sesión y el panel permanecen disponibles;
- cualquier usuario autenticado puede navegar por el sitio público completo;
- aparece una franja que advierte que se está utilizando la vista de revisión;
- el contenido, los archivos y las secciones no se modifican.

Para entregar acceso de revisión sin permisos administrativos:

1. Ir a **Seguridad → Usuarios**.
2. Crear o editar una cuenta.
3. Asignar únicamente el rol **Lector del sitio**.
4. Compartir de forma segura sus credenciales, nunca mediante archivos versionados.
5. El lector inicia sesión desde el botón de la pantalla de mantenimiento y vuelve a la página que intentaba consultar.

El rol lector no contiene `admin.access`; por ello, `/administracion` responde 403 para esa cuenta. Al cerrar sesión vuelve a aplicarse la pantalla de mantenimiento. El título y el mensaje públicos se editan junto al interruptor antes de guardar.

No se puede modificar su ruta ni eliminarlas desde el panel. Los scripts interactivos originales están separados del HTML y no se presentan en el editor.

## Editor

El formulario ofrece dos modos:

- **Visual:** formato común con títulos, negrita, cursiva, listas y enlaces.
- **HTML:** edición avanzada de la estructura conservando clases CSS existentes.

Al guardar se eliminan scripts, atributos de eventos como `onclick`, URLs con protocolos ejecutables e iframes que no sean videos embebidos de YouTube. La vista publicada permite comprobar el resultado en otra pestaña.

## Menú principal

La sección **Contenido → Menú principal** permite:

- cambiar la etiqueta visible;
- enlazar una página institucional;
- utilizar una URL externa;
- definir el orden numérico;
- mostrar u ocultar la opción;
- abrir el enlace en una pestaña nueva;
- quitar la opción sin eliminar su página.

Los valores de orden se comparan de menor a mayor. Se recomienda utilizar intervalos de diez (`10`, `20`, `30`) para insertar nuevas opciones posteriormente.

## Fuente de importación

Las vistas en `resources/views/public` se conservan como plantillas de recuperación para instalaciones nuevas. Una vez importadas, MySQL es la fuente del contenido publicado y las semillas no sobrescriben ediciones realizadas desde el CMS.
