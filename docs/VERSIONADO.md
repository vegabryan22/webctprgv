# Política de versiones

El número vigente se almacena en `VERSION`, se muestra en el panel y en el pie público, y debe coincidir con la última entrada de `CHANGELOG.md`.

Se utiliza el formato `MAYOR.MENOR.PARCHE`:

- **MAYOR:** cambios incompatibles de arquitectura, datos o integración.
- **MENOR:** funcionalidades nuevas compatibles, como un módulo del CMS.
- **PARCHE:** correcciones compatibles, ajustes de contenido o seguridad.

Durante la etapa inicial `0.x`, cada avance funcional incrementará el número menor. Ejemplo: el módulo de noticias puede publicar `0.2.0`; una corrección posterior, `0.2.1`.

## Lista de comprobación

1. Actualizar `VERSION`.
2. Añadir la sección correspondiente en `CHANGELOG.md` con fecha y cambios en español.
3. Ejecutar pruebas y formateador.
4. Crear una etiqueta Git anotada cuando la versión se considere entregable: `git tag -a v0.1.0 -m "Versión 0.1.0"`.

## Trazabilidad del proyecto

Cada cambio funcional debe asociarse con una unidad `CTP-CNN` del [plan maestro](PLAN-CONTENIDO.md). Al cerrar una unidad se registra:

- Fecha de cierre.
- Estado.
- Versión publicada.
- Commit de implementación.
- Commit de cierre documental.
- Resultado de pruebas.
- Migraciones o dependencias relevantes.

El commit de implementación contiene el cambio funcional. El commit de cierre actualiza la bitácora con el hash real del primero y puede coincidir con el commit etiquetado de la versión.
