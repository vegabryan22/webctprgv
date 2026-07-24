# Fichas de especialidades técnicas

## Alcance

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

## Migración inicial

Se crean como borradores los seis nombres encontrados en el sitio heredado:

1. Redes de Computadoras.
2. Contabilidad y Finanzas.
3. Logística y Distribución.
4. Electrotecnia.
5. Ejecutivo para Centros de Servicio.
6. Dibujo Técnico.

La precarga no confirma que esos nombres coincidan con la oferta oficial vigente. Coordinación Técnica debe revisarlos antes de publicar.

## Regla editorial

No publicar cifras de empleabilidad, duración de práctica, convenios, certificaciones, equipos disponibles ni reconocimiento universitario sin una fuente verificable y vigente.

## Permisos

| Permiso | Función |
| --- | --- |
| `specialties.view` | Ver fichas en el panel |
| `specialties.manage` | Crear, editar y eliminar |
| `specialties.publish` | Publicar después de la verificación |

La migración `2026_07_24_000500_create_specialties_table.php` se ejecuta en producción exclusivamente mediante GitOps.
