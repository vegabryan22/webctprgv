# Sitio web CTP Roberto Gamboa Valverde

Aplicación web institucional desarrollada con Laravel 13 bajo arquitectura MVC. Incluye el sitio público migrado a Blade y un panel CMS para administrar contenido, configuración, usuarios, roles y permisos.

## Requisitos

- PHP 8.3–8.5 con extensiones `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_sqlite`, `sqlite3` y `zip`.
- Composer 2.
- MySQL 8.0.

En este equipo existe una instalación portátil en `../.tools`. Desde la raíz del proyecto:

```powershell
$php = '..\.tools\php-8.5.8\php.exe'
& $php artisan migrate --seed
& $php artisan serve
```

El sitio queda disponible en `http://127.0.0.1:8000` y el panel en `http://127.0.0.1:8000/administracion`.

## Configuración inicial del administrador

Antes de ejecutar las semillas en un entorno nuevo, defina en `.env`:

```dotenv
ADMIN_NAME="Administrador"
ADMIN_EMAIL="administrador@dominio.test"
ADMIN_PASSWORD="una-contraseña-unica-de-12-o-mas-caracteres"
```

El archivo `.env` nunca se almacena en Git. Consulte [DESARROLLO.md](docs/DESARROLLO.md) para el flujo completo.

## Documentación

- [Arquitectura](docs/ARQUITECTURA.md)
- [Seguridad, roles y permisos](docs/SEGURIDAD.md)
- [Desarrollo local](docs/DESARROLLO.md)
- [Política de versiones](docs/VERSIONADO.md)
- [GitHub GitOps](docs/GITOPS.md)
- [Gestión de páginas y menú](docs/CMS.md)
- [Calendario de actividades](docs/CALENDARIO.md)
- [Plan maestro, dependencias y bitácora](docs/PLAN-CONTENIDO.md)
- [Módulo de noticias](docs/NOTICIAS.md)
- [Inventario y revisión editorial](docs/INVENTARIO-EDITORIAL.md)
- [Catálogo de servicios](docs/SERVICIOS.md)
- [Fichas de especialidades](docs/ESPECIALIDADES.md)
- [Directorio institucional](docs/DIRECTORIO.md)
- [Biblioteca de documentos](docs/DOCUMENTOS.md)
- [Registro de cambios](CHANGELOG.md)

## Verificación

```powershell
$php = '..\.tools\php-8.5.8\php.exe'
& $php vendor\bin\pint --test
& $php artisan test
```
