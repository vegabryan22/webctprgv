# Registro de cambios

Todos los cambios relevantes del proyecto se documentan aquí en español. El formato se basa en *Keep a Changelog* y el proyecto utiliza versionado semántico.

## [0.32.0] - 2026-07-27

### Añadido

- Categoría de calendario **Admisión**.
- Siete hitos del proceso de prematrícula para 7.º del curso lectivo 2027.
- Fechas de entrega de insumos, recepción documental, casos justificados, prueba, análisis, resultados y ratificación.
- Referencia visible a la circular `DRED-SCE07-CTPRGV-D-206-2026`.

### Seguridad editorial

- Los montos contradictorios y la referencia inconsistente al primer periodo 2025/2026 no se reproducen en los eventos.
- La ratificación se presenta como periodo general y advierte que el día específico será comunicado posteriormente.

### Base de datos

- Migración `2026_07_27_001000_import_seventh_grade_admission_schedule.php`.

## [0.31.2] - 2026-07-27

### Corregido

- El panel administrativo usa todo el ancho disponible en teléfonos y tabletas.
- La barra lateral se transforma en un encabezado compacto con navegación plegable.
- El menú móvil puede cerrarse al elegir una sección o presionar Escape y limita su altura para permanecer utilizable.
- El incremento de versión invalida el CSS administrativo anterior almacenado en caché.

## [0.31.1] - 2026-07-27

### Cambiado

- El sitio público se adapta de forma transversal a teléfonos, tabletas, portátiles y pantallas amplias.
- La navegación, tarjetas, formularios, mapas, planes de estudio y calendario reducen su densidad sin provocar desbordamiento horizontal.
- El panel administrativo presenta navegación horizontal desplazable, tablas contenidas y formularios apilados en pantallas estrechas.
- Los controles táctiles mantienen un área mínima cómoda y las animaciones respetan la preferencia de movimiento reducido.

### Corregido

- La biblioteca pública utiliza `/biblioteca-documental` para evitar el conflicto con la carpeta física `public/documentos`.
- Las imágenes, textos extensos y elementos embebidos respetan el ancho disponible.

## [0.31.0] - 2026-07-27

### Añadido

- Panel rápido **Estado del sitio** con interruptores para doce secciones públicas.
- Control independiente de Noticias, Institución, Especialidades, Talleres, Junta, Contacto, Servicios, Calendario, Práctica, Directorio, Documentos y 50 Aniversario.
- Acciones rápidas para activar o desactivar talleres y especialidades sin eliminarlos.
- Permiso `site-sections.manage` para superadministración y editores.

### Cambiado

- Las secciones desactivadas desaparecen del menú, Inicio y pie de página.
- Las rutas públicas desactivadas responden 404, mientras Inicio y Administración permanecen disponibles.
- El formulario de talleres conserva correctamente el estado Borrador seleccionado.

### Base de datos

- Migración `2026_07_27_000900_create_site_sections_table.php`.

## [0.30.0] - 2026-07-27

### Añadido

- Categorías administrables para proyectos, licitaciones o contrataciones, uniformes, materiales, informes y avisos.
- Precio opcional, nota de precio y fecha de vigencia para las publicaciones de la Junta.
- Publicaciones verificadas de camisas del uniforme y cuaderno de comunicaciones, sin inventar precios.

### Cambiado

- La página pública de la Junta adopta el formato visual actual del sitio y agrupa sus publicaciones por categoría.
- Precios, fechas y condiciones solo aparecen cuando han sido confirmados.

### Eliminado

- Proyectos, licitaciones, productos, precios, teléfonos, horarios, formas de pago y demás afirmaciones demostrativas del HTML heredado.

### Base de datos

- Migración `2026_07_27_000800_expand_board_publications.php`.

## [0.29.3] - 2026-07-27

### Añadido

- Bloque compacto de Facebook, TikTok e Instagram en la columna lateral de Contacto.

### Cambiado

- Los enlaces sociales de Contacto reutilizan la configuración central utilizada por el pie de página.

## [0.29.2] - 2026-07-27

### Cambiado

- El formulario de contacto pasa a ser el primer elemento y ocupa el área principal.
- Teléfonos, correo y horario se agrupan en una columna lateral compacta.
- La ubicación y el mapa permanecen debajo a todo lo ancho.
- En dispositivos móviles se conserva el formulario como primera acción.

## [0.29.1] - 2026-07-27

### Añadido

- Mapa integrado y adaptable dentro de la tarjeta de ubicación de Contacto.

### Cambiado

- El mapa visible se genera con la dirección administrada, sin exigir una URL especial de inserción.
- El enlace configurado se conserva en “Abrir mapa” para consultar la ubicación en una pestaña independiente.

## [0.29.0] - 2026-07-27

### Añadido

- Formulario público de contacto que almacena las consultas en MySQL.
- Bandeja administrativa con filtros y estados nuevo, leído, atendido y archivado.
- Notificación por correo al destinatario configurable, con respaldo en el correo público.
- Consentimiento obligatorio, campo trampa y límite de cinco envíos por minuto.
- Registro de lectura y atención de cada consulta.

### Seguridad

- Validación de longitud y formato para todos los campos.
- Los mensajes se presentan escapados en el panel y en las notificaciones.
- No se almacenan datos técnicos adicionales de la persona remitente.

### Base de datos

- Migración `2026_07_27_000700_create_contact_messages_table.php`.

## [0.28.0] - 2026-07-27

### Añadido

- Módulo “Contacto” en administración para editar título, introducción, teléfonos, correo, horario, dirección y enlace del mapa.
- Campos de fecha y fuente de verificación para la información institucional.
- Permiso `contact.manage`, asignado a superadministración y edición de contenido.
- Enlace desde Contacto al directorio institucional.

### Cambiado

- La página `/contacto` utiliza datos estructurados almacenados en `site_settings`.
- La presentación pública adopta un diseño compacto, adaptable y coherente con el sitio.

### Eliminado

- Formulario visual sin destino, que no enviaba ni almacenaba mensajes.
- Tarjetas heredadas de servicios que duplicaban el catálogo administrable.

### Base de datos

- Migración `2026_07_27_000600_create_contact_settings.php`.

## [0.27.0] - 2026-07-27

### Añadido

- Portada visual para “Nuestra institución” con fotografía, escudo e identidad institucional.
- Bloques diferenciados para misión, visión, características y valores institucionales.
- Accesos relacionados a Servicios, Junta Administrativa y Contacto.

### Cambiado

- La información institucional se presenta en una composición compacta, adaptable y coherente con el resto del sitio.
- Se retiran de esta página los bloques heredados de horarios, admisión, certificaciones y ubicación para evitar afirmaciones sin fuente y duplicidad con otros módulos.
- El contenido renovado permanece almacenado y editable desde MySQL.

### Base de datos

- Migración `2026_07_27_000500_redesign_institution_page.php`, condicionada para no sobrescribir ediciones posteriores.

## [0.26.0] - 2026-07-27

### Cambiado

- “Información” pasa a presentarse como “Institución” en la navegación.
- El título público se aclara como “Nuestra institución”.
- Inicio y pie de página diferencian identidad institucional de información para estudiantes.
- La ruta `/informacion` se conserva para mantener compatibilidad con enlaces existentes.

### Base de datos

- Migración `2026_07_27_000400_rename_information_as_institution.php`.

## [0.25.1] - 2026-07-27

### Cambiado

- Pie de página compacto con identidad, navegación útil y redes integradas.
- Créditos y versión trasladados a una franja secundaria de menor peso visual.
- Adaptación en dos columnas para tablet y una columna para móvil.

## [0.25.0] - 2026-07-27

### Añadido

- Portada institucional estructurada con hero compacto, accesos rápidos y recorridos académicos.
- Conteos dinámicos de especialidades y talleres publicados.
- Noticias recientes en el inicio cuando existan publicaciones oficiales.
- Cierre institucional con acceso a la información completa.

### Cambiado

- Próximas actividades se presentan en una cuadrícula compacta de hasta cuatro fechas.
- El título de Inicio continúa administrado desde el CMS, pero el HTML heredado deja de imprimirse para evitar misión, visión, valores y video duplicados.

## [0.24.0] - 2026-07-27

### Cambiado

- Navegación pública más baja, ligera y legible.
- Los enlaces dejan de competir como botones independientes y utilizan estados sutiles.
- El acceso al panel se presenta como “Administración”.
- El menú adaptable se activa antes de que los enlaces comiencen a comprimirse.

### Eliminado

- Redes sociales duplicadas en el encabezado; continúan disponibles en el pie de página.

## [0.23.3] - 2026-07-27

### Cambiado

- Las ilustraciones cubren completamente su área y se alinean desde el borde superior para preservar el sujeto principal.

## [0.23.2] - 2026-07-27

### Corregido

- Las ilustraciones predeterminadas se renderizan como elementos de imagen y no como fondos repetibles.
- Las tarjetas utilizan encuadre completo para evitar cortes excesivos.
- Los detalles muestran una sola ilustración sin efecto de mosaico.

## [0.23.1] - 2026-07-27

### Corregido

- Las 24 escenas del atlas fueron separadas en archivos individuales con los límites reales de cada celda.
- Las tarjetas y fichas ya no pueden mostrar fragmentos de una ilustración vecina.

## [0.23.0] - 2026-07-27

### Añadido

- Colección de 24 ilustraciones educativas, una para cada especialidad y taller.
- Ilustraciones temáticas en las tarjetas del catálogo y en los encabezados de las fichas.
- Mapeo centralizado de cada ficha con su posición dentro del atlas optimizado.

### Editorial

- Las ilustraciones son recursos gráficos generados para orientar visualmente; no representan instalaciones, equipos ni personas reales del colegio.
- Las imágenes cargadas manualmente desde el CMS conservan prioridad sobre la ilustración predeterminada.

## [0.22.3] - 2026-07-27

### Cambiado

- Se eliminó el nivel duplicado de las tarjetas de planes cuando ya forma parte del nombre del documento.

## [0.22.2] - 2026-07-27

### Cambiado

- Los planes de estudio públicos muestran únicamente el nivel y omiten el idioma para evitar confusión.

## [0.22.1] - 2026-07-27

### Cambiado

- Rediseño visual de los detalles de especialidades y talleres con encabezado destacado, iconografía y mejor jerarquía.
- Perfil y formación distribuidos en una composición adaptable de dos columnas.
- Planes de estudio compactos en una cuadrícula por nivel con acciones simplificadas.
- La sección de información oficial se oculta completamente cuando no contiene datos.

## [0.22.0] - 2026-07-27

### Añadido

- Perfil recomendado y formación ampliada para las siete especialidades técnicas.
- Descripciones completas y contenidos principales para los diecisiete talleres exploratorios.
- Cobertura automatizada para comprobar que todas las fichas documentadas contienen información ampliada.

### Seguridad editorial

- La carga conserva cualquier edición manual que ya no coincida con el contenido base.
- Las oportunidades profesionales continúan vacías mientras no exista confirmación institucional.

### Base de datos

- Migración `2026_07_27_000300_enrich_curricular_catalog_from_study_plans.php`.

## [0.21.0] - 2026-07-27

### Añadido

- Página de detalle para cada taller exploratorio con descripción completa y planes de estudio.
- Carga y retiro de hasta cinco planes PDF por operación desde la edición de especialidades y talleres.
- Carga de imagen para los talleres exploratorios.

### Cambiado

- Tarjetas uniformes de especialidades y talleres con cuatro columnas en escritorio.
- Los listados muestran únicamente imagen, nombre, resumen breve y acceso al detalle.
- Los encabezados de nivel de talleres eliminan la repetición entre insignia y título.

### Base de datos

- Migración `2026_07_27_000200_add_image_to_exploratory_workshops.php`.

## [0.20.0] - 2026-07-27

### Añadido

- Acceso público para abrir y descargar los planes de estudio de cada especialidad por nivel.
- Plan correspondiente en cada taller exploratorio.
- Tres accesos por nivel para el programa integral de Inglés conversacional.
- Documentos complementarios en inglés disponibles para 10.º y 11.º de Administración logística y distribución.
- Modelo estructurado para relacionar especialidades y talleres con documentos curriculares.

### Cambiado

- Los 40 PDF fueron normalizados y trasladados a `public/documentos/planes-estudio`.

### Base de datos

- Migración `2026_07_27_000100_create_curricular_documents_table.php`.

## [0.19.1] - 2026-07-26

### Añadido

- Publicación del catálogo documentado en las páginas de especialidades y talleres.
- Secciones públicas de talleres organizadas por 7.º, 8.º y 9.º.
- Sección diferenciada para Inglés conversacional como programa de todo el tercer ciclo.

### Base de datos

- Migración `2026_07_26_000200_publish_documented_curricular_catalog.php`.

## [0.19.0] - 2026-07-26

### Añadido

- Catálogo curricular documentado a partir de 40 planes de estudio del MEP.
- Siete especialidades técnicas con nombres oficiales, descripciones y áreas de formación.
- Diecisiete talleres exploratorios clasificados por nivel y precargados como borradores.
- Inglés conversacional representado como programa transversal de 7.º, 8.º y 9.º.
- Matriz de fuentes con archivo y páginas utilizadas para cada ficha.

### Cambiado

- Sustitución segura de los seis nombres provisionales de especialidades cuando no tienen edición previa.
- Selector administrativo de talleres compatible con programas que abarcan todo el tercer ciclo.

### Base de datos

- Migración `2026_07_26_000100_prepare_curricular_catalog_drafts.php`.

## [0.18.6] - 2026-07-24

### Corregido

- El seguimiento se detiene cuando la ejecución reciente de GitHub Actions termina.
- Resultado final visible con enlace a la ejecución exitosa o fallida.
- Limpieza automática de los parámetros de seguimiento en la URL.
- Compatibilidad con enlaces de seguimiento generados desde `v0.18.3`.

## [0.18.5] - 2026-07-24

### Corregido

- La tarjeta del repositorio local solo se consulta y muestra en `local` o `development`.
- Producción deja de intentar ejecutar Git dentro del directorio desplegado.
- La validación usa `APP_URL` en desarrollo y `GITOPS_HEALTH_URL` en producción.
- Etiquetas y mensajes del panel identifican el entorno que se está validando.

## [0.18.4] - 2026-07-24

### Corregido

- Separación de las pruebas en un runner de GitHub con PHP y `fileinfo` completos.
- El runner de producción solo recibe versiones que superaron la validación.
- Biblioteca documental compatible con enlaces y almacenamiento sin inicializar el detector MIME del servidor.
- Enlaces de archivos públicos generados sin depender de `fileinfo`.

## [0.18.3] - 2026-07-24

### Corregido

- Seguimiento temporal del despliegue después de solicitar una versión desde GitOps.
- Actualización automática del panel mientras GitHub Actions aplica la referencia seleccionada.
- Mensaje de confirmación que identifica la etiqueta o rama solicitada.

## [0.18.2] - 2026-07-24

### Corregido

- Alineación y separación visual de los datos del repositorio local en GitOps.
- Codificación de los textos y adaptación de la tarjeta para pantallas pequeñas.

## [0.18.1] - 2026-07-24

### Documentación

- Archivo `AGENTS.md` con instrucciones persistentes para continuar el proyecto desde cualquier computadora.
- Guía de traspaso con arquitectura, módulos, reglas editoriales, migraciones y próximo trabajo.
- Diferenciación explícita entre repositorio de trabajo local, remoto GitHub y producción GitOps.

## [0.18.0] - 2026-07-24

### Añadido

- Gestión de integrantes, cargos y periodos de la Junta Administrativa.
- Publicaciones de transparencia clasificadas como proyectos, procesos e informes.
- Fuente, responsable, fecha y verificación obligatorios para la información pública.
- Vinculación con documentos institucionales vigentes y permisos específicos.

### Base de datos

- Migración `2026_07_24_001000_create_board_transparency_tables.php`.

## [0.17.0] - 2026-07-24

### Añadido

- Módulo administrable de práctica profesional, pasantías y visitas técnicas.
- Relaciones con especialidades y documentos institucionales vigentes.
- Requisitos, etapas, duración, responsables y canales diferenciados para comunidad educativa y empresas.
- Publicación condicionada a fecha de verificación y permisos específicos.

### Base de datos

- Migración `2026_07_24_000900_create_professional_experiences_table.php`.

## [0.16.0] - 2026-07-24

### Añadido

- Biblioteca administrable de reglamentos, circulares, formularios y guías.
- Categorías, búsqueda, filtros, público, responsable, versión, emisión y expiración.
- Reemplazo controlado de documentos y ocultamiento automático de archivos vencidos.
- Permisos independientes de consulta, gestión y publicación.

### Base de datos

- Migración `2026_07_24_000800_create_document_library_tables.php`.

## [0.15.0] - 2026-07-24

### Añadido

- Directorio institucional administrable con departamentos, cargos, teléfonos, extensiones, correos y horarios.
- Búsqueda pública por departamento, cargo o persona.
- Fecha obligatoria de verificación y permisos independientes de publicación.
- Estado vacío que evita publicar contactos no confirmados.

### Base de datos

- Migración `2026_07_24_000700_create_directory_entries_table.php`.

## [0.14.1] - 2026-07-24

### Mejorado

- Selector de despliegue presentado como un control administrativo compacto y consistente.
- Campo de versión de ancho completo, foco visible y descripción del proceso seguro.
- Acciones adaptables con botón completo en pantallas pequeñas.

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
