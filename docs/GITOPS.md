# GitHub GitOps

## Alcance

El módulo `/administracion/gitops` reúne el estado del repositorio local, los commits recientes, las ejecuciones de GitHub Actions y una bitácora de solicitudes. No guarda tokens en la base de datos ni ejecuta comandos de escritura sobre el repositorio local.

## Configuración

Defina las siguientes variables únicamente en `.env`:

```dotenv
GITHUB_REPOSITORY=propietario/repositorio
GITHUB_DEFAULT_BRANCH=main
GITHUB_DEPLOY_WORKFLOW=deploy.yml
GITHUB_TOKEN=
```

El workflow configurado debe existir en `.github/workflows/` y aceptar el evento `workflow_dispatch`:

```yaml
on:
  workflow_dispatch:
```

## Token

Para un repositorio privado se recomienda un token de acceso específico de repositorio:

- `Actions: read` permite consultar ejecuciones.
- `Actions: write` es necesario para solicitar el workflow manual.

No se debe utilizar un token personal con acceso a repositorios que estén fuera del alcance del sitio.

## Permisos internos

- `gitops.view`: muestra el panel, commits y ejecuciones.
- `gitops.deploy`: habilita el botón de despliegue.

Cada solicitud se registra en `git_ops_events`, incluyendo usuario, repositorio, workflow, referencia, resultado y fecha. La aceptación de GitHub significa que el workflow fue encolado; no garantiza que el despliegue termine correctamente.

## Flujo esperado

1. El cambio se revisa y se incorpora a la rama configurada.
2. Un usuario autorizado solicita el workflow desde el panel o GitHub lo ejecuta por su evento normal.
3. GitHub Actions ejecuta pruebas y despliegue.
4. El estado aparece en la tabla de ejecuciones del panel.
