# Fichas de especialidades técnicas

## Alcance

Las especialidades corresponden a 10.º, 11.º y 12.º. Los talleres exploratorios de 7.º, 8.º y 9.º se administran en un módulo separado para no confundir ambos recorridos.

Cada especialidad se administra como una ficha independiente con:

- Nombre y resumen.
- Descripción.
- Perfil recomendado del estudiante.
- Áreas o plan de formación.
- Oportunidades profesionales verificadas.
- Programa oficial DETCE/MEP.
- Coordinación y correo de contacto.
- Imagen, orden y fecha de verificación.
- Estado borrador o publicado.

## Catálogo curricular documentado

La migración `2026_07_26_000100_prepare_curricular_catalog_drafts.php` prepara como borrador los siete nombres respaldados por los planes de estudio disponibles:

1. Ejecutivo comercial y de servicio al cliente.
2. Contabilidad y finanzas.
3. Administración logística y distribución.
4. Electrotecnia.
5. Dibujo y modelado de edificaciones.
6. Configuración y soporte a redes de comunicación y sistemas operativos.
7. Instalación y mantenimiento de sistemas eléctricos industriales.

La migración solo reemplaza fichas provisionales que continúan intactas y crea los registros faltantes. No sobrescribe contenido editado, verificado o publicado.

La evidencia, las descripciones propuestas y los talleres clasificados por nivel se encuentran en [OFERTA-ACADEMICA-FUENTES.md](OFERTA-ACADEMICA-FUENTES.md).

La presencia de un plan en el archivo documental no confirma por sí sola que la oferta se imparta actualmente en el CTPRGV. Coordinación Técnica debe confirmar cada ficha antes de publicarla.

## Regla editorial

No publicar cifras de empleabilidad, duración de práctica, convenios, certificaciones, equipos disponibles ni reconocimiento universitario sin una fuente verificable y vigente.

## Permisos

| Permiso | Función |
| --- | --- |
| `specialties.view` | Ver fichas en el panel |
| `specialties.manage` | Crear, editar y eliminar |
| `specialties.publish` | Publicar después de la verificación |

Las migraciones se ejecutan en producción exclusivamente mediante GitOps.
