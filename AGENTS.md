# AGENTS

Contexto para agentes de IA que trabajen en este repo.

## Proyecto

Este repo contiene el ambiente local del sitio WordPress de Ardeso.

- Sitio local: http://localhost:8087
- Tema principal: `wp-content/themes/ardeso-fse/`

El sitio completo existe en local para poder replicar produccion, pero Git debe enfocarse en la infraestructura local y en el tema personalizado.

## Tema principal

- Ardeso: `wp-content/themes/ardeso-fse/`

Los cambios de diseno, contenido hardcodeado del tema, estilos, templates, patrones y assets versionables deben hacerse en esa carpeta.

## Reglas de cuidado

- No editar ni versionar `wp-config.php` salvo que el usuario lo pida explicitamente.
- No agregar dumps `.sql`, ZIPs generados, `uploads/`, caches, plugins o WordPress core al historial.
- No borrar archivos fuera del alcance del pedido.
- No tocar credenciales reales ni archivos de produccion.
- Los cambios en plugins activos suelen ser cambios de base de datos local, no cambios de Git.
- Antes de modificar una seccion visual, buscar primero dentro del tema con `rg`.
- Si el sitio esta corriendo, verificar visualmente en localhost cuando el cambio sea de UI.

## Docker local

Comandos utiles:

```sh
./docker-dev.sh up
./docker-dev.sh import-db archivo.sql
./docker-dev.sh export-db archivo.sql
```

Servicios esperados:

- `ardeso_wp` en puerto `8087`
- `ardeso_pma` en puerto `8088`
- `ardeso_db` con base `u417236294_ZqpVf`

## Flujo de trabajo

1. Buscar el texto, template, CSS o asset dentro de `wp-content/themes/ardeso-fse/`.
2. Hacer cambios acotados.
3. Verificar en navegador local cuando aplique.
4. Revisar `git diff` antes de finalizar.
5. Dejar los cambios listos para que el usuario los commitee.

## Estado actual conocido

- El tema activo en local debe ser `ardeso-fse`.
- Version del tema: `1.0.4`.
- El usuario genera los commits manualmente.
