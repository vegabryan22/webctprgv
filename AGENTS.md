# Instrucciones persistentes para Codex

Este archivo es el punto de entrada obligatorio al retomar el proyecto en cualquier computadora. Léalo completo antes de modificar archivos y consulte `docs/CONTINUIDAD.md` para conocer el estado funcional y el historial.

## Objetivo del proyecto

Construir y mantener el sitio web y CMS del CTP Roberto Gamboa Valverde en Laravel MVC, con contenido estructurado, permisos explícitos, documentación en español, versionado semántico y despliegues controlados mediante GitOps.

## Reglas acordadas con el usuario

1. Trabajar únicamente en la copia local del repositorio.
2. No conectarse al servidor por SSH, no modificar producción y no ejecutar comandos remotos.
3. Las migraciones locales pueden ejecutarse para validar el desarrollo. En producción se aplican exclusivamente desde el panel GitOps.
4. No hacer `push`, publicar etiquetas ni abrir solicitudes de cambio salvo petición explícita del usuario.
5. Trabajar sobre `main` cuando el usuario solicite publicar los cambios.
6. No inventar nombres, convenios, estadísticas, contactos, fotografías ni información institucional.
7. Mantener como borrador todo contenido pendiente de confirmación y exigir fecha/fuente de verificación cuando corresponda.
8. Documentar cada etapa en español, actualizar `VERSION`, `CHANGELOG.md`, la documentación funcional y `docs/PLAN-CONTENIDO.md`.
9. Cada entrega funcional debe tener pruebas, un commit de implementación, un commit de cierre documental y una etiqueta semántica local.
10. No incluir tokens, contraseñas ni credenciales en archivos versionados, comandos visibles o documentación.

## Entorno local conocido

- Aplicación Laravel dentro de este repositorio.
- PHP portátil usado durante el desarrollo en Windows: `..\.tools\php-8.5.8\php.exe`.
- Servidor local habitual: `http://127.0.0.1:8000`.
- Comandos de validación:

```powershell
& '..\.tools\php-8.5.8\php.exe' vendor\bin\pint app database tests routes
& '..\.tools\php-8.5.8\php.exe' artisan migrate
& '..\.tools\php-8.5.8\php.exe' artisan test
git diff --check
```

En otra computadora puede usarse el PHP instalado globalmente si cumple los requisitos del proyecto.

## Git y GitOps

- GitHub es la fuente remota de verdad para producción.
- La copia de trabajo local no puede actuar como su propio remoto: un remoto representa otro repositorio y un despliegue necesita una referencia inmutable disponible para el runner.
- El panel puede mostrar el estado del repositorio local durante desarrollo, pero eso no convierte commits locales en versiones desplegables.
- Para simular un remoto sin GitHub se necesitaría un repositorio `bare` separado y un runner local; no debe confundirse con el flujo de producción.
- Las acciones de despliegue, reversión y migración de producción continúan pasando por GitHub Actions y el panel GitOps.

## Estado actual

- Última etapa funcional cerrada: CTP-C11, Junta Administrativa y transparencia.
- Última versión funcional: `v0.25.1`.
- Próxima etapa preparada: CTP-C12, Historia institucional.
- Consulte siempre `VERSION`, `git log`, `git status`, las etiquetas y `docs/PLAN-CONTENIDO.md`; estos datos pueden haber avanzado después de redactar este resumen.

## Proceso obligatorio para la siguiente etapa

1. Confirmar que el árbol de trabajo está limpio y revisar cambios ajenos antes de editar.
2. Leer la sección correspondiente en `docs/PLAN-CONTENIDO.md`.
3. Implementar migración, modelos, controladores, permisos, administración y presentación pública según corresponda.
4. No precargar información institucional no confirmada.
5. Ejecutar migraciones y pruebas solo en local.
6. Verificar las rutas públicas por HTTP local.
7. Actualizar documentación y este archivo si cambian reglas, entorno, arquitectura o estado general.
8. Crear commits y etiqueta local; no publicar sin autorización.

## Archivos de referencia

- `docs/CONTINUIDAD.md`: resumen de arquitectura, módulos y traspaso.
- `docs/PLAN-CONTENIDO.md`: etapas, dependencias, decisiones, riesgos y bitácora.
- `CHANGELOG.md`: cambios por versión.
- `VERSION`: versión efectiva.
- `docs/GITOPS.md`: operación del despliegue, si existe.
