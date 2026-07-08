# Ardeso WordPress Local

Ambiente local para replicar y trabajar el sitio WordPress de Ardeso:

- Sitio local: http://localhost:8087
- phpMyAdmin: http://localhost:8088
- Tema principal: `wp-content/themes/ardeso-fse/`

El objetivo principal del repo es mantener historial del tema personalizado y la infraestructura local necesaria para trabajar el sitio.

## Que se versiona

Se versionan:

- `docker-compose.yml`
- `docker-dev.sh`
- Configuracion local de Docker en `.docker/`
- Tema Ardeso: `wp-content/themes/ardeso-fse/`
- Documentacion del proyecto

No se versionan:

- WordPress core
- Plugins instalados
- Temas externos o temas base
- `wp-config.php`
- Dumps SQL
- ZIPs generados
- `uploads/`
- Caches, logs y archivos temporales

## Levantar el sitio

```sh
./docker-dev.sh up
```

URL local:

- Ardeso: http://localhost:8087

## Importar base de datos

Los dumps SQL se importan manualmente cuando sea necesario:

```sh
./docker-dev.sh import-db archivo.sql
```

La base local usa por defecto:

- Base: `u417236294_ZqpVf`
- Usuario: `ardeso`
- Password: `ardeso_local_password`

Despues de importar, el script aplica ajustes locales para activar el tema `ardeso-fse`, usar URLs `localhost` y desactivar plugins pesados.

## Trabajar el tema en local

Los cambios se hacen directamente dentro de:

```sh
wp-content/themes/ardeso-fse/
```

No es necesario subir un ZIP para ver cambios en local. Basta con que el tema este activo en WordPress y recargar el navegador.

## Generar ZIP del tema

Cuando el tema este listo para instalarse o actualizarse en otro ambiente, generar el ZIP desde la raiz del proyecto.

Los ZIPs generados no se versionan en Git.
