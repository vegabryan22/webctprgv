# Plan maestro de contenido y evolución del sitio

## Control del documento

| Campo | Valor |
| --- | --- |
| Proyecto | Sitio web CTP Roberto Gamboa Valverde |
| Código | CTPRGV-WEB |
| Creado | 2026-07-24 |
| Última actualización | 2026-07-27 |
| Responsable funcional | Dirección del CTPRGV |
| Responsable técnico | Administración del sitio |
| Versión inicial del plan | 0.8.1 |
| Estado general | En ejecución |

Este documento es la fuente principal para conocer qué se pretende construir, en qué orden, qué depende de qué y en cuál versión quedó cada entrega. `CHANGELOG.md` conserva el resumen público de versiones; este plan conserva el seguimiento operativo.

## Forma de trabajo

Cada unidad utiliza un identificador permanente `CTP-CNN`. No se inicia una unidad bloqueada por dependencias pendientes.

### Estados permitidos

| Estado | Significado |
| --- | --- |
| Pendiente | Aún no se ha iniciado |
| Preparado | Dependencias y contenido disponibles |
| En curso | Implementación local activa |
| En revisión | Implementado y pendiente de validación |
| Completado | Criterios aprobados, documentado y versionado |
| Bloqueado | Falta una decisión, dato o dependencia |
| Descartado | Se decidió no ejecutar; debe indicarse el motivo |

### Proceso de cada unidad

1. Confirmar objetivo, responsable del contenido y dependencias.
2. Recopilar y verificar los datos institucionales necesarios.
3. Diseñar modelo de datos, rutas, permisos e interfaz cuando corresponda.
4. Implementar únicamente en el repositorio local.
5. Crear o actualizar pruebas automatizadas.
6. Ejecutar pruebas y revisar el resultado visual.
7. Documentar cambios, decisiones y migraciones.
8. Actualizar `VERSION` y `CHANGELOG.md`.
9. Crear commit y etiqueta local.
10. Publicar en GitHub cuando se autorice; despliegue y migraciones se ejecutan desde GitOps.
11. Registrar el resultado en la bitácora de este documento.

### Criterio general de terminado

- Dependencias completadas.
- Sin datos demostrativos presentados como oficiales.
- Contenido sensible confirmado por su responsable.
- Interfaz funcional en escritorio y móvil.
- Permisos administrativos definidos.
- Pruebas aprobadas o excepción documentada.
- Versión, changelog, commit y documentación actualizados.

## Objetivo y principios editoriales

Convertir el sitio en un portal institucional útil, verificable y fácil de mantener para estudiantes, familias, empresas, egresados y personal.

- Publicar únicamente información confirmada.
- Fechar la información sensible al tiempo.
- Evitar contenido demostrativo, enlaces vacíos y formularios incompletos.
- Resolver necesidades concretas del visitante.
- Mantener una sola fuente para cada dato.
- Diferenciar fechas oficiales del CTPRGV y fechas tentativas del MEP.
- Preferir registros estructurados sobre grandes bloques de HTML.

## Mapa de dependencias

```text
CTP-C01 Portada dinámica ──────┐
                               ├─> CTP-C04 Actualidad en portada
CTP-C02 Módulo de noticias ────┘

CTP-C03 Saneamiento editorial ─────> CTP-C10 Revisión integral

CTP-C05 Catálogo de servicios ─┬───> CTP-C07 Directorio
                               ├───> CTP-C08 Documentos
                               └───> CTP-C15 Admisión y matrícula

CTP-C08 Biblioteca documental ─────> CTP-C15 Admisión y matrícula

CTP-C06 Modelo de especialidades ──> CTP-C09 Empresas y práctica

CTP-C02 + C05 + C06 + C07 + C08 + C09
                               └───> CTP-C10 Revisión integral
```

## Etapa 0 — Base técnica y operación

| ID | Unidad | Estado | Dependencias | Resultado | Versión |
| --- | --- | --- | --- | --- | --- |
| CTP-B01 | Laravel MVC y layouts Blade | Completado | Ninguna | Aplicación base y vistas unificadas | 0.1.x |
| CTP-B02 | CMS, usuarios, roles y permisos | Completado | CTP-B01 | Administración segura | 0.2.x |
| CTP-B03 | Calendario administrable | Completado | CTP-B02 | Eventos públicos y gestión interna | 0.4.x |
| CTP-B04 | GitOps y despliegue controlado | Completado | CTP-B01 | Validación, despliegue y reversión | 0.6–0.7 |

## Etapa 1 — Portada y actualidad

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C01 | Portada dinámica | Completado | CTP-B03 | Accesos rápidos y próximas actividades | Conserva CMS, solo eventos públicos y distingue fechas MEP |
| CTP-C02 | Noticias estructuradas | Completado | CTP-B02 | Modelo, migración, CRUD, permisos, listado y detalle | Fecha, categoría, autor, imagen, adjunto, estado y destacado |
| CTP-C03 | Saneamiento editorial | Completado | Ninguna | Inventario, reglas automáticas y datos pendientes de confirmación | Cada hallazgo fue resuelto o quedó identificado con responsable |
| CTP-C04 | Actualidad en portada | Completado | CTP-C02 | Noticias y avisos recientes en Inicio | Sin duplicación y con publicación/expiración |

## Etapa 2 — Servicios institucionales

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C05 | Catálogo de servicios | Completado | CTP-B02 | Servicios, categorías, requisitos, responsables y documentos | Solo información confirmada puede publicarse |
| CTP-C07 | Directorio institucional | Completado | CTP-C05 | Departamentos, contactos, extensiones, búsqueda y horarios | Datos confirmados por Dirección o Secretaría |
| CTP-C08 | Biblioteca de documentos | Completado | CTP-C05 | Reglamentos, formularios y circulares versionados | Archivo, vigencia, categoría y responsable visibles |
| CTP-C15 | Admisión y matrícula | En revisión | CTP-C05, CTP-C08 | Página pública para 7.º y 10.º, cronograma, avisos y documentos oficiales | Portal funcional; Dirección aún debe resolver contradicciones entre fuentes |

## Etapa 3 — Oferta técnica y vinculación

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C06 | Especialidades estructuradas | Completado | CTP-B02 | Ficha, perfil, áreas, contacto y programa oficial | Borradores sujetos a validación DETCE/MEP y Coordinación Técnica |
| CTP-C09 | Empresas y práctica profesional | Completado | CTP-C06 | Práctica, pasantías, visitas y contacto empresarial | Sin convenios o estadísticas sin respaldo |

## Etapa 4 — Transparencia, historia y comunidad

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C11 | Junta y transparencia | Completado | CTP-C08 | Integrantes, proyectos, procesos, informes y documentos | Vigencia y fuente visibles |
| CTP-C12 | Historia institucional | Pendiente | CTP-C03 | Historia y línea del tiempo verificadas | Fuentes y autorización de Dirección |
| CTP-C13 | Proyectos y egresados | Pendiente | CTP-C06 | Proyectos y testimonios autorizados | Consentimiento y fuente de fotografías |

## Etapa 5 — Calidad y mantenimiento

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C10 | Revisión integral | Pendiente | CTP-C02, C03, C05, C06, C07, C08, C09 | Revisión editorial, accesibilidad, móvil, SEO y enlaces | Sin contenido demostrativo ni errores críticos |
| CTP-C14 | Medición y mantenimiento | Pendiente | CTP-C10 | Indicadores y frecuencia de revisión | Calendario editorial definido |

## Información y responsables

| Contenido | Responsable sugerido | Requerido por |
| --- | --- | --- |
| Historia, misión y visión | Dirección | CTP-C03, CTP-C12 |
| Oferta académica | Coordinación Académica | CTP-C03 |
| Especialidades y práctica | Coordinación Técnica | CTP-C06, CTP-C09 |
| Matrícula, constancias y horarios | Secretaría | CTP-C05, CTP-C07 |
| Admisión, prematrícula, costos y fechas | Dirección y Comité de Matrícula | CTP-C15 |
| Becas, comedor, transporte y orientación | Administración u Orientación | CTP-C05 |
| Proyectos, concursos e informes | Junta Administrativa | CTP-C11 |
| Calendario y comunicados | Dirección | CTP-C01, CTP-C02 |
| Noticias, fotografías y galerías | Responsable de comunicación | CTP-C02, CTP-C13 |
| Empresas y convenios | Coordinación con la Empresa | CTP-C09 |

## Registro de decisiones

| Fecha | ID | Decisión | Motivo | Impacto |
| --- | --- | --- | --- | --- |
| 2026-07-24 | DEC-001 | El servidor no se modifica manualmente | Los cambios se aplican mediante GitOps | Todo debe versionarse antes del despliegue |
| 2026-07-24 | DEC-002 | Inicio conserva el CMS y añade componentes dinámicos | Evita perder edición y duplicar calendario | CTP-C01 usa una vista específica |
| 2026-07-24 | DEC-003 | El contenido futuro será estructurado | Los bloques HTML son difíciles de validar y reutilizar | Noticias, servicios y especialidades tendrán modelos propios |
| 2026-07-27 | DEC-004 | Inicio conserva el título administrado, pero no imprime el HTML heredado | La portada anterior duplicaba misión, valores, video y componentes dinámicos | Inicio se alimenta de módulos estructurados y el contenido anterior permanece como respaldo |
| 2026-07-27 | DEC-005 | La futura sección de admisión separará 7.º de la escogencia de especialidad de 10.º | Son procesos, públicos y requisitos distintos | CTP-C15 tendrá recorridos independientes y documentos comunes |

## Fuentes recibidas para CTP-C15

| Documento | Fecha | Uso previsto | Estado de revisión |
| --- | --- | --- | --- |
| Circular DRED-SC07-CTPRGV-D-207-2026, Reglamento de Admisión y Matrícula | 03/07/2026 | Comunicación general y descarga asociada al reglamento | Recibida; la portada del reglamento indica 2025-2026, pero la circular y la disposición final señalan curso lectivo 2027 |
| Reglamento de Admisión y Matrícula del CTPRGV | Rige desde junio de 2026 | Documento normativo completo para 7.º y 10.º | Bloqueado hasta confirmar o corregir el período de la portada |
| Circular DRED-SCE07-CTPRGV-D-206-2026, Prematrícula de 7.º para 2027 | 03/07/2026 | Cronograma, requisitos y avisos específicos para aspirantes de 7.º | Bloqueada: indica ₡4.000 y ₡3.000 para la prueba en páginas distintas; también menciona I período 2025 y 2026 |

### Alcance previsto de CTP-C15

1. Crear una página pública de admisión y matrícula con recorridos separados para ingreso a 7.º y elección de especialidad de 10.º.
2. Mostrar un cronograma administrable con fecha, horario, audiencia, lugar, estado y fuente.
3. Vincular circulares y reglamentos desde la biblioteca documental, sin duplicar archivos.
4. Permitir avisos destacados y correcciones posteriores sin modificar contenido histórico.
5. Publicar costos, cuentas, requisitos y fechas únicamente después de su confirmación por Dirección.
6. Integrar accesos desde Inicio, Especialidades y la navegación pública, sujetos al control de estado del sitio.

## Bitácora de entregas

| Fecha | Unidad | Versión | Estado | Commit implementación | Commit cierre | Validación | Observaciones |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 2026-07-24 | CTP-C01 | 0.8.0 | Completado | `eb83570` | `eb83570` | 27 pruebas, 109 aserciones aprobadas con PHP portátil | Accesos y cuatro actividades próximas |
| 2026-07-24 | Control del proyecto | 0.8.1 | Completado | `7fe9a6d` | `8765589` | 27 pruebas aprobadas; Pint reporta dos diferencias preexistentes en GitOps | Etapas, dependencias, decisiones y bitácora |
| 2026-07-24 | CTP-C02 | 0.9.0 | Completado | `8c143bf` | `d4bd2f2` | 31 pruebas y 125 aserciones aprobadas; migración local correcta | Noticias estructuradas y retiro de demostraciones |
| 2026-07-24 | CTP-C02 | 0.9.1 | Completado | `052532f` | `052532f` | 31 pruebas y 125 aserciones aprobadas; HTTP 200 | Corrección adaptable del encabezado público |
| 2026-07-24 | CTP-C03 | 0.10.0 | Completado | `c8fce6b` | `a773113` | 34 pruebas y 132 aserciones aprobadas; 6 páginas auditadas | Inventario y revisión editorial administrativa |
| 2026-07-24 | CTP-C05 | 0.11.0 | Completado | `2249a74` | `2b84b68` | 37 pruebas y 143 aserciones aprobadas; migración local y HTTP 200 | Catálogo estructurado de servicios |
| 2026-07-24 | CTP-C06 | 0.12.0 | Completado | `48a1e05` | `a3e58ee` | 40 pruebas y 155 aserciones aprobadas; migración local y HTTP 200 | Especialidades estructuradas y borradores revisables |
| 2026-07-24 | CTP-C06 | 0.13.0 | Completado | `f93f228` | `3a6d1d0` | 42 pruebas y 163 aserciones aprobadas; HTTP 200 en ambas rutas | Talleres 7.º–9.º y especialidades 10.º–12.º |
| 2026-07-24 | CTP-B04 | 0.14.0 | Completado | `9bb7f3a` | `fb6a55d` | 43 pruebas y 166 aserciones aprobadas | Selector de versiones nuevas en GitOps |
| 2026-07-24 | CTP-B04 | 0.14.1 | Completado | `c5c0639` | `c5c0639` | 6 pruebas GitOps y 15 aserciones aprobadas | Refinamiento visual del selector de despliegue |
| 2026-07-24 | CTP-C07 | 0.15.0 | Completado | `99a54df` | `2c420af` | 46 pruebas y 173 aserciones aprobadas; migración local y HTTP 200 | Directorio institucional verificable |
| 2026-07-24 | CTP-C08 | 0.16.0 | Completado | `b3fa8e0` | `2ab8e40` | 50 pruebas y 187 aserciones aprobadas; migración local y HTTP 200 | Biblioteca de documentos vigente y versionada |
| 2026-07-24 | CTP-C09 | 0.17.0 | Completado | `cf4e5cc` | `b8e8149` | 54 pruebas y 201 aserciones aprobadas; migración local y HTTP 200 | Práctica, pasantías y visitas vinculadas con especialidades y documentos |
| 2026-07-24 | CTP-C11 | 0.18.0 | Completado | `7101ec4` | `9766ff4` | 58 pruebas y 218 aserciones aprobadas; migración local y HTTP 200 | Integrantes vigentes y transparencia con fuentes verificables |
| 2026-07-24 | Continuidad y GitOps local | 0.18.1 | Completado | `820af5d` | `1653bd2` | 58 pruebas y 219 aserciones aprobadas | Instrucciones persistentes e inspección Git local de solo lectura |
| 2026-07-24 | GitOps local | 0.18.2 | Completado | `80b942c` | `46974f8` | 58 pruebas y 219 aserciones aprobadas | Alineación adaptable y corrección UTF-8 de la tarjeta local |
| 2026-07-24 | Seguimiento GitOps | 0.18.3 | Completado | `76ab3d8` | `9205e4b` | 59 pruebas y 224 aserciones aprobadas | Actualización automática tras solicitar una versión |
| 2026-07-24 | Compatibilidad del despliegue | 0.18.4 | Completado | `ee6646c` | `0078ff2` | 59 pruebas y 224 aserciones aprobadas | Validación separada del runner de producción sin fileinfo |
| 2026-07-24 | Entornos GitOps | 0.18.5 | Completado | `a815e9a` | `af462ad` | 60 pruebas y 227 aserciones aprobadas | Inspección local solo en desarrollo y validación contextual |
| 2026-07-24 | Fin de seguimiento GitOps | 0.18.6 | Completado | `20ebde2` | `ad98efe` | 61 pruebas y 232 aserciones aprobadas | El refresco termina según el resultado del workflow |
| 2026-07-26 | CTP-C06, catálogo curricular | 0.19.0 | Completado | `9af5ae3` | `d0089ba` | 62 pruebas y 240 aserciones aprobadas; migración local correcta | Siete especialidades y diecisiete talleres documentados como borradores |
| 2026-07-26 | CTP-C06, publicación curricular | 0.19.1 | Completado | `3fa923e` | `b0b8d9d` | 62 pruebas y 244 aserciones aprobadas; HTTP 200 | Catálogo público y talleres agrupados por nivel |
| 2026-07-27 | CTP-C06, planes por nivel | 0.20.0 | Completado | `20ef7ca` | `4263466` | 63 pruebas y 297 aserciones aprobadas; 40 PDF con HTTP 200 | Apertura y descarga de planes por especialidad, taller y nivel |
| 2026-07-27 | CTP-C06, presentación y administración | 0.21.0 | Completado | `7d617d2` | `4cc9123` | 65 pruebas y 309 aserciones aprobadas; rutas públicas con HTTP 200 | Tarjetas uniformes, detalle de talleres, imágenes y carga administrativa de planes |
| 2026-07-27 | CTP-C06, contenido ampliado | 0.22.0 | Completado | `863fa2f` | `0e582ae` | 67 pruebas y 368 aserciones aprobadas; rutas de detalle con HTTP 200 | Perfiles y formación de 7 especialidades; contenidos de 17 talleres extraídos de 40 PDF |
| 2026-07-27 | CTP-C06, diseño de fichas | 0.22.1 | Completado | `aef4ae1` | `d0da25d` | 67 pruebas y 373 aserciones aprobadas; detalles con HTTP 200 | Encabezado visual, secciones equilibradas, planes compactos y eliminación de espacios vacíos |
| 2026-07-27 | CTP-C06, etiquetas de planes | 0.22.2 | Completado | `e755551` | `32cfd32` | 67 pruebas y 375 aserciones aprobadas | El idioma se conserva en el CMS y se oculta en la presentación pública |
| 2026-07-27 | CTP-C06, nivel de planes | 0.22.3 | Completado | `1964fc1` | `3accac7` | 67 pruebas y 377 aserciones aprobadas | El nivel se muestra únicamente dentro del nombre del documento |
| 2026-07-27 | CTP-C06, ilustraciones curriculares | 0.23.0 | Completado | `41b6443` | `ffbdc93` | 69 pruebas y 404 aserciones aprobadas; listados y detalles con HTTP 200 | Atlas con 24 escenas temáticas y prioridad para imágenes del CMS |
| 2026-07-27 | CTP-C06, recorte de ilustraciones | 0.23.1 | Completado | `02cb4e6` | `7bffb4a` | 69 pruebas y 404 aserciones aprobadas; listado con archivos individuales y HTTP 200 | Separación física de las 24 escenas para impedir recortes entre filas |
| 2026-07-27 | CTP-C06, presentación de ilustraciones | 0.23.2 | Completado | `40931a5` | `c13b94d` | 69 pruebas y 404 aserciones aprobadas; HTML sin fondos en línea y HTTP 200 | Imágenes reales con encuadre completo y sin repetición en mosaico |
| 2026-07-27 | CTP-C06, encuadre de ilustraciones | 0.23.3 | Completado | `6596d07` | `290c2eb` | 69 pruebas y 404 aserciones aprobadas; detalle con HTTP 200 | Cobertura total con posición superior y sin fondos repetibles |
| 2026-07-27 | Navegación pública | 0.24.0 | Completado | `e5b9a98` | `939fa41` | 69 pruebas y 405 aserciones aprobadas; portada con HTTP 200 | Enlaces planos, redes en el pie, administración abreviada y menú móvil anticipado |
| 2026-07-27 | CTP-C01 y CTP-C04, portada estructurada | 0.25.0 | Completado | `fa749f8` | `782f482` | 70 pruebas y 415 aserciones aprobadas; portada con HTTP 200 y sin bloques heredados | Hero compacto, accesos, recorridos, agenda, noticias condicionales e identidad |
| 2026-07-27 | Navegación pública, pie de página | 0.25.1 | Completado | `d35ead1` | `2879830` | 71 pruebas y 422 aserciones aprobadas; portada con HTTP 200 | Pie compacto con navegación, redes y créditos de menor jerarquía |
| 2026-07-27 | Identidad institucional | 0.26.0 | Completado | `4a1558f` | `f067307` | 72 pruebas y 428 aserciones aprobadas; `/informacion` con HTTP 200 | Nombre público “Institución”, título claro y URL histórica conservada |
| 2026-07-27 | Identidad institucional, diseño visual | 0.27.0 | Completado | `72292bf` | `b2e845d` | 72 pruebas y 438 aserciones aprobadas; migración local y `/informacion` con HTTP 200 | Hero institucional, misión, visión, valores y accesos relacionados sin contenido no confirmado |
| 2026-07-27 | Contacto institucional parametrizable | 0.28.0 | Completado | `20b9656` | `4558cd7` | 76 pruebas y 461 aserciones aprobadas; migración local y `/contacto` con HTTP 200 | Canales, ubicación y verificación editables; formulario inactivo retirado |
| 2026-07-27 | Consultas públicas funcionales | 0.29.0 | Completado | `6584dcb` | `68fd2ce` | 79 pruebas y 482 aserciones aprobadas; migración local, formulario y siete rutas verificadas | Registro MySQL, correo configurable, antispam y bandeja con seguimiento |
| 2026-07-27 | Mapa de contacto | 0.29.1 | Completado | `e67ea04` | `3979f6b` | 79 pruebas y 484 aserciones aprobadas; `/contacto` con iframe verificado y HTTP 200 | Mapa adaptable generado desde la dirección, con enlace externo independiente |
| 2026-07-27 | Composición compacta de Contacto | 0.29.2 | Completado | `a1708fc` | `fcce3be` | 79 pruebas y 486 aserciones aprobadas; orden y cuadrícula verificados con HTTP 200 | Formulario primero, canales laterales y mapa inferior a todo lo ancho |
| 2026-07-27 | Redes en Contacto | 0.29.3 | Completado | `ed59be4` | `75f55d9` | 79 pruebas y 493 aserciones aprobadas; tres redes verificadas con HTTP 200 | Bloque social compacto alimentado por la configuración central |
| 2026-07-27 | Junta Administrativa mantenible | 0.30.0 | Completado | `69b9da6` | `e4dc805` | 80 pruebas y 508 aserciones aprobadas; migración local y `/junta-administrativa` con HTTP 200 | Categorías reales, precios opcionales y retiro integral de datos demostrativos |
| 2026-07-27 | Estado público del sitio | 0.31.0 | Completado | `f89a3a2` | `7c419c8` | 83 pruebas y 529 aserciones aprobadas; ocultamiento de menú y HTTP 404 verificados | Doce módulos con interruptor global y fichas curriculares desactivables sin eliminación |
| 2026-07-27 | Responsividad transversal | 0.31.1 | Completado | `e3b8fd8` | `4dad41e` | 86 pruebas y 562 aserciones aprobadas; once rutas públicas con HTTP 200 | Sitio público, calendario y panel adaptados desde teléfonos hasta pantallas amplias; biblioteca sin colisión de URL |
| 2026-07-27 | Responsividad administrativa | 0.31.2 | Completado | `f199361` | `4aaff19` | 87 pruebas y 569 aserciones aprobadas | Menú lateral convertido en navegación móvil plegable y contenido administrativo a ancho completo |
| 2026-07-27 | CTP-C15, cronograma de admisión de 7.º | 0.32.0 | Completado | `226bbff` | `70b6d28` | 88 pruebas y 577 aserciones aprobadas; cinco meses del calendario con HTTP 200 | Siete hitos publicados sin reproducir montos ni años contradictorios de la circular |
| 2026-07-27 | CTP-C15, portal de admisión y matrícula | 0.33.0 | En revisión | `5858ff4` | `8962e3b` | 92 pruebas y 605 aserciones aprobadas; página, biblioteca y tres PDF con HTTP 200 | Recorridos 7.º/10.º, cronograma, documentos y administración integrada; correcciones documentales pendientes de Dirección |
| 2026-07-27 | CTP-C15, contraste del encabezado | 0.33.1 | Completado | `f6ac960` | `750a8df` | 93 pruebas y 607 aserciones aprobadas | Título blanco, escala controlada y renovación de caché CSS |

## Riesgos y bloqueos

| ID | Riesgo | Probabilidad | Impacto | Tratamiento | Estado |
| --- | --- | --- | --- | --- | --- |
| R-01 | Datos demostrativos publicados como oficiales | Alta | Alto | Inventario y confirmación responsable | Abierto |
| R-02 | Sobrescribir contenido editado mediante migración | Media | Alto | Migraciones idempotentes, sin reemplazo ciego | Abierto |
| R-03 | Duplicar calendario, noticias y avisos | Media | Medio | Una fuente y componentes reutilizables | Mitigado en CTP-C01 |
| R-04 | Formularios que no entregan solicitudes | Alta | Alto | Implementar flujo o retirar formulario | Abierto |
| R-05 | Datos o fotografías sin autorización | Media | Alto | Consentimiento y política editorial | Abierto |

## Próxima unidad preparada

`CTP-C12 — Historia institucional`

1. Estructurar hitos de una línea del tiempo institucional.
2. Registrar fecha, descripción, fuente y responsable de verificación.
3. Incorporar fotografías únicamente cuando exista autorización.
4. Mantener en borrador fechas o relatos sin respaldo documental.
5. Integrar historia, misión y visión sin duplicar páginas del CMS.

`CTP-C04 — Actualidad en portada` quedó preparado funcionalmente en `0.25.0`: muestra hasta tres noticias publicadas y oculta la sección cuando no existen.
