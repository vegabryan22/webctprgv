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

La versión `0.19.1` publica las fichas documentadas por solicitud expresa del usuario. La publicación respalda nombres y descripciones en los programas de estudio; no completa contactos, responsables, oportunidades laborales ni otros datos institucionales que continúan pendientes de confirmación.

## Planes de estudio por nivel

La versión `0.20.0` incorpora los 40 PDF al despliegue y los relaciona mediante `curricular_documents`:

- Cada especialidad presenta los programas disponibles de 10.º, 11.º y 12.º.
- Administración logística y distribución diferencia los documentos en español y los complementarios en inglés.
- Cada taller presenta su plan correspondiente.
- Inglés conversacional ofrece accesos diferenciados para 7.º, 8.º y 9.º al mismo programa integral.
- Todos los documentos pueden abrirse en una pestaña nueva o descargarse.

Los archivos públicos utilizan nombres estables sin espacios ni tildes en `public/documentos/planes-estudio`.

## Presentación y administración

La versión `0.21.0` presenta especialidades y talleres mediante tarjetas uniformes de cuatro columnas en escritorio. Cada tarjeta conserva únicamente imagen, nombre y resumen breve; la descripción completa y los planes se consultan en la página individual.

Los formularios administrativos de especialidades y talleres permiten:

- Adjuntar hasta cinco planes PDF por operación.
- Indicar nivel, idioma y un título opcional para cada plan.
- Abrir o retirar planes previamente asociados.
- Cargar una imagen representativa; los talleres incorporan esta capacidad desde `0.21.0`.

Los planes cargados desde el CMS se guardan en el disco público bajo `storage/curricular-plans`. Retirar una asociación solo elimina físicamente los archivos administrados desde el CMS; los planes versionados en `public/documentos/planes-estudio` permanecen protegidos.

## Contenido ampliado desde los planes

La versión `0.22.0` completa las fichas utilizando exclusivamente los 40 programas inventariados:

- Las siete especialidades incorporan perfil recomendado y una lista ampliada de áreas formativas.
- Los diecisiete talleres incorporan descripción completa y contenidos principales.
- Inglés conversacional identifica las capacidades comunicativas y la progresión indicada por su programa.
- La migración solo completa perfiles vacíos y sustituye el resumen formativo o la descripción cuando todavía coinciden exactamente con el contenido base de `0.19.0`.

El campo de oportunidades profesionales permanece vacío. Los planes respaldan competencias y perfiles ocupacionales, pero la oferta laboral, los convenios y las condiciones vigentes requieren confirmación institucional.

Desde `0.22.1`, las páginas individuales emplean un encabezado visual, secciones con iconografía y planes compactos en cuadrícula. La información oficial no genera espacios vacíos cuando todavía no hay coordinación, contacto o enlace confirmado.

## Regla editorial

No publicar cifras de empleabilidad, duración de práctica, convenios, certificaciones, equipos disponibles ni reconocimiento universitario sin una fuente verificable y vigente.

## Permisos

| Permiso | Función |
| --- | --- |
| `specialties.view` | Ver fichas en el panel |
| `specialties.manage` | Crear, editar y eliminar |
| `specialties.publish` | Publicar después de la verificación |

Las migraciones se ejecutan en producción exclusivamente mediante GitOps.
