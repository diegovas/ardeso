#!/usr/bin/env bash

set -euo pipefail

COMPOSE="docker compose"
DB_SERVICE="db"
WP_SERVICE="wordpress"
DB_NAME="${ARDESO_DB_NAME:-u417236294_ZqpVf}"
DB_USER="${ARDESO_DB_USER:-ardeso}"
DB_PASS="${ARDESO_DB_PASSWORD:-ardeso_local_password}"
LOCAL_OPTIONS=".docker/mysql/02-local-options.sql"

case "${1:-help}" in
  up)
    $COMPOSE up -d
    echo ""
    echo "Sitio disponible:"
    echo "  Ardeso: http://localhost:8087"
    echo "  phpMyAdmin: http://localhost:8088"
    ;;

  down)
    $COMPOSE down
    ;;

  logs)
    if [[ -n "${2:-}" ]]; then
      $COMPOSE logs -f "$2"
    else
      $COMPOSE logs -f
    fi
    ;;

  import-db)
    FILE="${2:-}"
    if [[ -z "$FILE" || ! -f "$FILE" ]]; then
      echo "Uso: ./docker-dev.sh import-db archivo.sql" >&2
      exit 1
    fi

    $COMPOSE exec -T "$DB_SERVICE" mariadb -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$FILE"
    if [[ -f "$LOCAL_OPTIONS" ]]; then
      $COMPOSE exec -T "$DB_SERVICE" mariadb -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$LOCAL_OPTIONS"
    fi
    echo "Importado $FILE en $DB_NAME."
    ;;

  export-db)
    FILE="${2:-ardeso-backup.sql}"
    $COMPOSE exec -T "$DB_SERVICE" mariadb-dump -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$FILE"
    echo "Exportado $DB_NAME en $FILE."
    ;;

  local-options)
    if [[ ! -f "$LOCAL_OPTIONS" ]]; then
      echo "No existe $LOCAL_OPTIONS" >&2
      exit 1
    fi
    $COMPOSE exec -T "$DB_SERVICE" mariadb -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$LOCAL_OPTIONS"
    echo "Ajustes locales aplicados."
    ;;

  shell)
    $COMPOSE exec "$WP_SERVICE" bash
    ;;

  help|*)
    echo ""
    echo "Comandos:"
    echo "  ./docker-dev.sh up"
    echo "  ./docker-dev.sh down"
    echo "  ./docker-dev.sh logs [servicio]"
    echo "  ./docker-dev.sh import-db archivo.sql"
    echo "  ./docker-dev.sh export-db archivo.sql"
    echo "  ./docker-dev.sh local-options"
    echo "  ./docker-dev.sh shell"
    echo ""
    ;;
esac
