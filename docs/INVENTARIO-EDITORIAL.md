# Inventario editorial inicial

## Control

| Campo | Valor |
| --- | --- |
| Unidad | CTP-C03 |
| Fecha de creación | 2026-07-24 |
| Fuente | Contenido heredado local y páginas administradas por el CMS |
| Estado | En revisión |

Este inventario identifica información que requiere validación. Un hallazgo no demuestra que el dato sea falso; indica que no debe considerarse confirmado sin fuente, responsable y vigencia.

## Prioridad alta

| Página | Hallazgo | Tratamiento |
| --- | --- | --- |
| Junta Administrativa | Precios de uniformes, útiles y materiales | Confirmar proveedor, fecha de vigencia y autorización; retirar si son demostrativos |
| Junta Administrativa | Licitaciones y presupuestos identificados como procesos 2025 | Confirmar con la Junta o retirar del contenido oficial |
| Contacto | Formulario HTML sin destino de entrega | Implementar flujo completo o retirar el formulario |
| Noticias heredadas | Eventos demostrativos, enlaces `#` y calendario 2025 | Resuelto por el módulo estructurado de Noticias en v0.9.0 |
| 50 Aniversario | Formulario marcado en código como “solo para demostración” | Retirar o implementar un proceso real |

## Requiere fuente institucional

| Página | Afirmación | Responsable sugerido |
| --- | --- | --- |
| Especialidades | 400 horas de práctica profesional | Coordinación Técnica y programa DETCE/MEP |
| Especialidades | Convenios empresariales | Coordinación con la Empresa |
| Especialidades | Alto índice de empleabilidad | Coordinación Técnica; requiere indicador y período |
| Especialidades | Certificaciones, tecnología actualizada y reconocimiento universitario | Coordinación Técnica |
| 50 Aniversario | Línea histórica, hitos y fechas | Dirección |
| 50 Aniversario | Testimonios y exalumnos destacados | Dirección; consentimiento de las personas |
| Información | Requisitos de admisión, horarios y certificaciones | Secretaría y Dirección |
| Contacto | Teléfonos, correos, horarios y servicios | Secretaría |

## Clasificación operativa

| Clasificación | Acción |
| --- | --- |
| Confirmado | Registrar responsable, fuente y fecha de revisión |
| Pendiente | Mantener en revisión; evitar afirmación definitiva |
| Vencido | Retirar del sitio público y conservar solo si existe valor histórico |
| Demostrativo | Retirar; no migrar como contenido oficial |

## Herramienta administrativa

La ruta `/administracion/revision-editorial` analiza el contenido actual del CMS, no solamente las plantillas iniciales. Detecta:

- Enlaces sin destino.
- Contenido que se identifica como demostración.
- Formularios sin acción.
- Precios.
- Contrataciones y presupuestos.
- Afirmaciones de empleabilidad y convenios.
- Duración de práctica profesional.
- Fechas posiblemente vencidas en páginas operativas.
- Testimonios que requieren autorización.
- Recursos multimedia repetidos.

La herramienta no modifica el contenido automáticamente. Cada corrección debe realizarse desde Páginas y confirmarse con el responsable institucional.
