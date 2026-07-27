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
