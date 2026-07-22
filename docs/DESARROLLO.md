# Desarrollo local

## Preparación

1. Copie `.env.example` como `.env` si no existe.
2. Configure la base de datos y las variables `ADMIN_*`.
3. Instale dependencias con Composer.
4. Genere la clave y ejecute migraciones.

En la instalación portátil incluida fuera del repositorio:

```powershell
$php = '..\.tools\php-8.5.8\php.exe'
$composer = '..\.tools\composer.phar'
& $php $composer install
& $php artisan key:generate
& $php artisan migrate --seed
& $php artisan serve
```

## Flujo de cambios

1. Cree una rama descriptiva.
2. Implemente el cambio y sus pruebas.
3. Ejecute Pint y la suite de pruebas.
4. Actualice `CHANGELOG.md` en español.
5. Incremente `VERSION` según `docs/VERSIONADO.md` cuando corresponda.
6. Haga un commit pequeño y descriptivo.

## Base de datos

MySQL 8.0 es el motor predeterminado tanto para desarrollo como para producción. La base recomendada es `ctprgv` y Laravel debe conectarse mediante un usuario dedicado con permisos limitados a esa base. Nunca se deben guardar credenciales reales en Git.

## Estilo público

`public/css/site.css` conserva el diseño heredado. Los cambios estructurales deben realizarse en layouts o parciales Blade antes de duplicar marcado en vistas individuales.
