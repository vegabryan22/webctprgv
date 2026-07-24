# Plan maestro de contenido y evolución del sitio

## Control del documento

| Campo | Valor |
| --- | --- |
| Proyecto | Sitio web CTP Roberto Gamboa Valverde |
| Código | CTPRGV-WEB |
| Creado | 2026-07-24 |
| Última actualización | 2026-07-24 |
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
                               └───> CTP-C08 Documentos

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
| CTP-C02 | Noticias estructuradas | Pendiente | CTP-B02 | Modelo, migración, CRUD, permisos, listado y detalle | Fecha, categoría, autor, imagen, adjunto, estado y destacado |
| CTP-C03 | Saneamiento editorial | Pendiente | Ninguna | Inventario de textos demostrativos, enlaces vacíos y datos vencidos | Corregir o marcar pendiente de confirmación |
| CTP-C04 | Actualidad en portada | Bloqueado | CTP-C02 | Noticias y avisos recientes en Inicio | Sin duplicación y con publicación/expiración |

## Etapa 2 — Servicios institucionales

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C05 | Catálogo de servicios | Pendiente | CTP-B02 | Matrícula, becas, comedor, orientación y constancias | Público, requisitos, horario y responsable |
| CTP-C07 | Directorio institucional | Pendiente | CTP-C05 | Departamentos, contactos, extensiones y horarios | Datos confirmados por Dirección o Secretaría |
| CTP-C08 | Biblioteca de documentos | Pendiente | CTP-C05 | Reglamentos, formularios y circulares versionados | Archivo, vigencia, categoría y responsable visibles |

## Etapa 3 — Oferta técnica y vinculación

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C06 | Especialidades estructuradas | Pendiente | CTP-B02 | Ficha, perfil, áreas, recursos, contacto y programa oficial | Validación DETCE/MEP y Coordinación Técnica |
| CTP-C09 | Empresas y práctica profesional | Pendiente | CTP-C06 | Práctica, pasantías, visitas y contacto empresarial | Sin convenios o estadísticas sin respaldo |

## Etapa 4 — Transparencia, historia y comunidad

| ID | Unidad | Estado | Dependencias | Entregables | Criterio específico |
| --- | --- | --- | --- | --- | --- |
| CTP-C11 | Junta y transparencia | Pendiente | CTP-C08 | Integrantes, proyectos, procesos, informes y documentos | Vigencia y fuente visibles |
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

## Bitácora de entregas

| Fecha | Unidad | Versión | Estado | Commit implementación | Commit cierre | Validación | Observaciones |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 2026-07-24 | CTP-C01 | 0.8.0 | Completado | `eb83570` | `eb83570` | 27 pruebas, 109 aserciones aprobadas con PHP portátil | Accesos y cuatro actividades próximas |
| 2026-07-24 | Control del proyecto | 0.8.1 | Completado | `7fe9a6d` | Pendiente de registrar | 27 pruebas aprobadas; Pint reporta dos diferencias preexistentes en GitOps | Etapas, dependencias, decisiones y bitácora |

## Riesgos y bloqueos

| ID | Riesgo | Probabilidad | Impacto | Tratamiento | Estado |
| --- | --- | --- | --- | --- | --- |
| R-01 | Datos demostrativos publicados como oficiales | Alta | Alto | Inventario y confirmación responsable | Abierto |
| R-02 | Sobrescribir contenido editado mediante migración | Media | Alto | Migraciones idempotentes, sin reemplazo ciego | Abierto |
| R-03 | Duplicar calendario, noticias y avisos | Media | Medio | Una fuente y componentes reutilizables | Mitigado en CTP-C01 |
| R-04 | Formularios que no entregan solicitudes | Alta | Alto | Implementar flujo o retirar formulario | Abierto |
| R-05 | Datos o fotografías sin autorización | Media | Alto | Consentimiento y política editorial | Abierto |

## Próxima unidad preparada

`CTP-C02 — Noticias estructuradas`

1. Diseñar tablas de noticias y categorías.
2. Definir permisos `news.view` y `news.manage`.
3. Construir CRUD administrativo.
4. Crear listado, detalle y publicaciones destacadas.
5. Migrar únicamente contenido confirmado.
6. Probar publicación, borradores y vencimiento.
7. Conectar CTP-C04 cuando el módulo esté validado.
