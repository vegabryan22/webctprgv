# Continuidad del proyecto

Fecha de actualización: 2026-07-24.

Este documento permite retomar el proyecto después de clonar el repositorio en otra computadora. Las instrucciones obligatorias están en `AGENTS.md`.

## Contexto

El sitio original fue reorganizado como una aplicación Laravel MVC con CMS, Blade, MySQL, administración de usuarios/roles/permisos, documentación en español y versionado semántico. La apariencia pública conserva la identidad visual del colegio; la administración utiliza una interfaz sobria basada en la misma paleta.

El usuario estableció que el servidor no debe modificarse manualmente. Todo cambio se desarrolla y prueba localmente, se publica en GitHub solo cuando lo solicite y luego se aplica desde el panel GitOps.

## Módulos terminados

| Versión | Unidad | Resultado principal |
| --- | --- | --- |
| 0.8.0–0.8.1 | CTP-C01 y control | Portada dinámica, calendario próximo y control documental del proyecto |
| 0.9.0–0.9.1 | CTP-C02 | Noticias estructuradas y encabezado adaptable |
| 0.10.0 | CTP-C03 | Revisión editorial y detección de contenido pendiente |
| 0.11.0 | CTP-C05 | Catálogo de servicios |
| 0.12.0–0.13.0 | CTP-C06 | Estructura administrable de especialidades de 10.º–12.º y talleres de 7.º–9.º |
| 0.14.0–0.14.1 | CTP-B04 | Selector y refinamiento del despliegue GitOps |
| 0.15.0 | CTP-C07 | Directorio institucional verificable |
| 0.16.0 | CTP-C08 | Biblioteca de documentos con vigencia y reemplazos |
| 0.17.0 | CTP-C09 | Práctica profesional, pasantías y visitas técnicas |
| 0.18.0 | CTP-C11 | Junta Administrativa y transparencia |
| 0.19.0 | CTP-C06 | Catálogo curricular documentado con siete especialidades y diecisiete talleres en borrador |
| 0.19.1 | CTP-C06 | Catálogo curricular publicado y talleres organizados por nivel |
| 0.20.0 | CTP-C06 | Planes de estudio públicos por especialidad, taller y nivel |
| 0.21.0 | CTP-C06 | Catálogo compacto, detalle de talleres y carga administrativa de planes |
| 0.22.0 | CTP-C06 | Perfiles, formación y contenidos ampliados desde los 40 planes |
| 0.22.1 | CTP-C06 | Rediseño visual de fichas y planes curriculares compactos |
| 0.22.2 | CTP-C06 | Simplificación de las etiquetas públicas de planes |
| 0.22.3 | CTP-C06 | Eliminación del nivel duplicado en tarjetas de planes |
| 0.23.0 | CTP-C06 | Ilustraciones temáticas para las 24 fichas curriculares |
| 0.23.1 | CTP-C06 | Separación física y corrección de recortes de las 24 ilustraciones |
| 0.23.2 | CTP-C06 | Encuadre completo y eliminación del mosaico en detalles |
| 0.23.3 | CTP-C06 | Cobertura completa de ilustraciones con anclaje superior |

La bitácora con hashes exactos está en `docs/PLAN-CONTENIDO.md`.

## Base de datos

Las migraciones funcionales más recientes son:

- `2026_07_24_000700_create_directory_entries_table.php`
- `2026_07_24_000800_create_document_library_tables.php`
- `2026_07_24_000900_create_professional_experiences_table.php`
- `2026_07_24_001000_create_board_transparency_tables.php`
- `2026_07_26_000100_prepare_curricular_catalog_drafts.php`
- `2026_07_26_000200_publish_documented_curricular_catalog.php`
- `2026_07_27_000100_create_curricular_documents_table.php`
- `2026_07_27_000200_add_image_to_exploratory_workshops.php`
- `2026_07_27_000300_enrich_curricular_catalog_from_study_plans.php`

No deben editarse migraciones que ya hayan llegado a producción. Si una versión ya fue desplegada, cualquier ajuste de esquema requiere una migración nueva.

## Seguridad editorial

- Publicar solo contenido con responsable y verificación.
- Ocultar automáticamente borradores, elementos vencidos y documentos reemplazados.
- Mostrar fuente y vigencia en contenidos sensibles.
- No publicar datos personales o fotografías sin autorización.
- No afirmar convenios, empresas, resultados o cifras sin respaldo.
- Reutilizar documentos desde la biblioteca en vez de duplicar archivos.

## GitOps local y remoto

El panel consulta GitHub mediante su API y solicita workflows de GitHub Actions. Por ello, un commit local que todavía no existe en GitHub no puede desplegarse ni aparecer como versión remota.

Hay tres conceptos distintos:

1. **Repositorio de trabajo local:** contiene archivos editables y cambios sin publicar.
2. **Repositorio remoto GitHub:** conserva commits y etiquetas que el runner puede descargar.
3. **Producción:** aplica una referencia remota mediante el workflow y ejecuta respaldo, migraciones, cachés y validación.

Para ensayar Git sin Internet puede crearse otro repositorio `bare` en una ruta separada y configurarlo como remoto local. Eso sirve para probar `fetch`, `push`, etiquetas y diferencias, pero no representa GitHub Actions ni autoriza despliegues de producción.

El panel nunca debe ofrecer una operación que haga `reset --hard`, elimine cambios locales o sobrescriba producción sin confirmación y trazabilidad.

## Cómo retomar en otra computadora

1. Clonar el repositorio y entrar en su directorio.
2. Leer `AGENTS.md`, este documento y `docs/PLAN-CONTENIDO.md`.
3. Copiar `.env.example` a `.env` y configurar credenciales locales propias, sin versionarlas.
4. Instalar dependencias de Composer y frontend si son necesarias.
5. Generar la clave local, crear la base local y ejecutar migraciones/seeders.
6. Crear el enlace de almacenamiento si falta.
7. Ejecutar la suite completa antes de modificar código.
8. Revisar `git status`, `git log --oneline -10`, `git tag --sort=-v:refname` y `VERSION`.

Comandos Laravel habituales:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan test
php artisan serve
```

## Próximo trabajo

CTP-C12 debe crear una historia institucional estructurada y una línea del tiempo con fecha, descripción, fuente, responsable y verificación. Las fotografías serán opcionales y solo podrán publicarse con autorización. Debe integrarse con la página informativa existente sin duplicar misión y visión.

Después quedan CTP-C13 (proyectos y egresados), CTP-C04 (actualidad en portada cuando existan noticias oficiales) y CTP-C10 (revisión integral final), según las dependencias del plan.

El catálogo curricular fue publicado en `v0.19.1` por solicitud expresa del usuario. Continúan pendientes los contactos, responsables, disponibilidad y oportunidades profesionales que requieran confirmación institucional adicional.

Los 40 planes curriculares están versionados en `public/documentos/planes-estudio` y asociados mediante `curricular_documents`. No deben renombrarse sin agregar una migración que actualice `file_path`.

Los planes nuevos cargados desde el CMS se almacenan en `storage/app/public/curricular-plans`. Especialidades y talleres admiten imágenes y muestran listados compactos; el contenido completo se presenta en sus páginas individuales.

Las fichas curriculares publicadas contienen perfiles, áreas formativas y contenidos sintetizados desde los programas. `career_opportunities` continúa sin precarga hasta contar con confirmación institucional.

El catálogo conserva `public/images/curricular/catalog-atlas.png` como fuente y utiliza los 24 archivos separados de `public/images/curricular/items` en la web. `App\Support\CurricularIllustrations` resuelve el archivo por slug; las imágenes administradas desde el CMS tienen prioridad.
