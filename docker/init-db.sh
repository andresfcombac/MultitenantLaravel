#!/bin/bash
set -euo pipefail

# Crea el usuario y las bases de datos de la app a partir de variables de entorno
# (MT_DB_USER, MT_DB_PASSWORD, MT_DB_NAME, MT_DB_LEGACY_NAME), definidas en docker-compose.yml.

mysql -u root -p"${MYSQL_ROOT_PASSWORD}" <<-EOSQL
    CREATE USER IF NOT EXISTS '${MT_DB_USER}'@'%' IDENTIFIED BY '${MT_DB_PASSWORD}';
    CREATE USER IF NOT EXISTS '${MT_DB_USER}'@'localhost' IDENTIFIED BY '${MT_DB_PASSWORD}';

    CREATE DATABASE IF NOT EXISTS \`${MT_DB_NAME}\`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci;

    CREATE DATABASE IF NOT EXISTS \`${MT_DB_LEGACY_NAME}\`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci;

    GRANT ALL PRIVILEGES ON \`${MT_DB_NAME}\`.* TO '${MT_DB_USER}'@'%';
    GRANT ALL PRIVILEGES ON \`${MT_DB_NAME}\`.* TO '${MT_DB_USER}'@'localhost';
    GRANT ALL PRIVILEGES ON \`${MT_DB_LEGACY_NAME}\`.* TO '${MT_DB_USER}'@'%';
    GRANT ALL PRIVILEGES ON \`${MT_DB_LEGACY_NAME}\`.* TO '${MT_DB_USER}'@'localhost';

    FLUSH PRIVILEGES;
EOSQL
