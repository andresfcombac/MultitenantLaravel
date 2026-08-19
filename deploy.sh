#!/bin/bash

# Colores para los mensajes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  DESPLIEGUE RÁPIDO DOCKER - COMBA${NC}"
echo -e "${GREEN}========================================${NC}"

# 1. Verificar si está en el directorio correcto
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: Ejecuta este script desde la raíz del proyecto Laravel (donde está artisan)${NC}"
    exit 1
fi

# 2. Crear estructura de carpetas necesarias
echo -e "${YELLOW}[1/9] Creando estructura de carpetas...${NC}"
mkdir -p nginx
mkdir -p docker
mkdir -p storage/framework/{views,cache,sessions,tmp}

# 3. Crear archivos de configuración si no existen
echo -e "${YELLOW}[2/9] Verificando archivos de configuración...${NC}"

# Dockerfile
if [ ! -f "Dockerfile" ]; then
    echo " -> Creando Dockerfile..."
    cat > Dockerfile << 'DOCKERFILE'
FROM php:8.4-fpm-alpine
RUN apk add --no-cache curl curl-dev zip libzip-dev unzip git libpng-dev libjpeg-turbo-dev freetype-dev libxml2-dev oniguruma-dev mysql-client \
    && docker-php-ext-install -j$(nproc) pdo_mysql mysqli mbstring xml bcmath curl zip pcntl gd opcache
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && git config --global --add safe.directory /var/www/html
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN sed -i 's/memory_limit = .*/memory_limit = 512M/' /usr/local/etc/php/php.ini
RUN sed -i 's/upload_max_filesize = .*/upload_max_filesize = 100M/' /usr/local/etc/php/php.ini
RUN sed -i 's/post_max_size = .*/post_max_size = 100M/' /usr/local/etc/php/php.ini
RUN sed -i 's/max_execution_time = .*/max_execution_time = 300/' /usr/local/etc/php/php.ini
RUN echo "sys_temp_dir = /tmp" > /usr/local/etc/php/conf.d/temp-dir.ini
EXPOSE 9000
CMD ["php-fpm"]
DOCKERFILE
fi

# docker-compose.yml
if [ ! -f "docker-compose.yml" ]; then
    echo " -> Creando docker-compose.yml..."
    cat > docker-compose.yml << 'COMPOSE'
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: comba_app
    restart: unless-stopped
    volumes:
      - .:/var/www/html
      - vendor_vol:/var/www/html/vendor
      - ./docker/php-overrides.ini:/usr/local/etc/php/conf.d/z-overrides.ini
    depends_on:
      mysql:
        condition: service_healthy
    networks:
      - comba_net

  webserver:
    image: nginx:1.25-alpine
    container_name: comba_nginx
    restart: unless-stopped
    ports:
      - "8002:80"
    volumes:
      - .:/var/www/html
      - ./nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app
    networks:
      - comba_net

  mysql:
    image: mysql:8.0
    container_name: comba_mysql
    restart: unless-stopped
    ports:
      - "3309:3306"
    environment:
      MYSQL_ROOT_PASSWORD: root_secret_2024
    volumes:
      - mysql_data:/var/lib/mysql
      - ./docker/init-db.sql:/docker-entrypoint-initdb.d/01-init-db.sql
    command: >
      --default-authentication-plugin=mysql_native_password
      --character-set-server=utf8mb4
      --collation-server=utf8mb4_unicode_ci
      --bind-address=0.0.0.0
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost", "-u", "root", "-proot_secret_2024"]
      interval: 10s
      timeout: 5s
      retries: 10
      start_period: 30s
    networks:
      - comba_net

  phpmyadmin:
    image: phpmyadmin:5.2
    container_name: comba_phpmyadmin
    restart: unless-stopped
    ports:
      - "8090:80"
    environment:
      PMA_HOST: mysql
      PMA_PORT: 3306
      PMA_USER: mt_user
      PMA_PASSWORD: mt_secret
      PMA_ARBITRARY: 1
      UPLOAD_LIMIT: 200M
    depends_on:
      mysql:
        condition: service_healthy
    networks:
      - comba_net

volumes:
  mysql_data:
    driver: local
  vendor_vol:
    driver: local

networks:
  comba_net:
    driver: bridge
COMPOSE
fi

# nginx/default.conf
if [ ! -f "nginx/default.conf" ]; then
    echo " -> Creando nginx/default.conf..."
    cat > nginx/default.conf << 'NGINX'
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php index.html;
    add_header Cache-Control "no-store, no-cache, must-revalidate";
    expires off;
    charset utf-8;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    location ~ /\.(?!well-known) { deny all; }
    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }
}
NGINX
fi

# docker/init-db.sql
if [ ! -f "docker/init-db.sql" ]; then
    echo " -> Creando docker/init-db.sql..."
    cat > docker/init-db.sql << 'SQL'
CREATE USER IF NOT EXISTS 'mt_user'@'%' IDENTIFIED BY 'mt_secret';
CREATE DATABASE IF NOT EXISTS `multitenant_laravel` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS `multitenant` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON `multitenant_laravel`.* TO 'mt_user'@'%';
GRANT ALL PRIVILEGES ON `multitenant`.* TO 'mt_user'@'%';
FLUSH PRIVILEGES;
SQL
fi

# docker/php-overrides.ini
if [ ! -f "docker/php-overrides.ini" ]; then
    echo " -> Creando docker/php-overrides.ini..."
    echo 'sys_temp_dir = "/var/www/html/storage/tmp"' > docker/php-overrides.ini
fi

# .dockerignore
if [ ! -f ".dockerignore" ]; then
    echo " -> Creando .dockerignore..."
    cat > .dockerignore << 'IGNORE'
.git
node_modules
vendor
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
storage/logs/*
public/hot
docker-compose.yml
Dockerfile
nginx/
docker/
IGNORE
fi

# 4. Ajustar el archivo .env automáticamente
echo -e "${YELLOW}[3/9] Ajustando archivo .env para Docker...${NC}"
if [ -f ".env" ]; then
    sed -i 's/^DB_HOST=127.0.0.1/DB_HOST=mysql/' .env
    sed -i 's/^DB_HOST=localhost/DB_HOST=mysql/' .env
    sed -i 's/^DB_PORT=3309/DB_PORT=3306/' .env
    sed -i 's/^LEGACY_DB_HOST=127.0.0.1/LEGACY_DB_HOST=mysql/' .env
    sed -i 's/^LEGACY_DB_HOST=localhost/LEGACY_DB_HOST=mysql/' .env
    sed -i 's/^LEGACY_DB_PORT=3309/LEGACY_DB_PORT=3306/' .env
    echo " -> .env ajustado correctamente."
else
    echo -e "${RED} -> ADVERTENCIA: No se encontró el archivo .env${NC}"
fi

# 5. Dar permisos estrictos con SUDO (La clave del éxito)
echo -e "${YELLOW}[4/9] Aplicando permisos a carpetas de almacenamiento (requiere sudo)...${NC}"
sudo chmod -R 777 storage bootstrap/cache

# 6. Construir y levantar contenedores
echo -e "${YELLOW}[5/9] Levantando contenedores Docker...${NC}"
docker compose up -d --build

# 7. Esperar a que MySQL esté listo e instalar Composer
echo -e "${YELLOW}[6/9] Esperando a que MySQL esté listo...${NC}"
for i in $(seq 1 15); do
    if docker compose exec -T mysql mysqladmin ping -h localhost -u root -proot_secret_2024 --silent 2>/dev/null; then
        echo " -> MySQL listo!"
        break
    fi
    sleep 2
done

echo -e "${YELLOW}[7/9] Instalando dependencias de PHP (Composer)...${NC}"
docker compose exec -T app composer install --no-interaction 2>&1

echo -e "${YELLOW}[8/9] Ejecutando migraciones de la base de datos...${NC}"
docker compose exec -T app php artisan migrate --force 2>&1

# Limpiar caché
docker compose exec -T app php artisan cache:clear 2>/dev/null

# 9. Restablecer contraseña del administrador para pruebas
echo -e "${YELLOW}[9/9] Estableciendo contraseña de prueba para el usuario Admin...${NC}"
docker compose exec -T app php artisan tinker --execute="DB::connection('legacy')->table('usuarios')->where('id_usuario', 1)->update(['pwd' => bcrypt('12345678')]);" 2>&1

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  ✅ DESPLIEGUE COMPLETADO CON ÉXITO${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "  🌐 Aplicación:     ${YELLOW}http://localhost:8002${NC}"
echo -e "  🗄️  phpMyAdmin:     ${YELLOW}http://localhost:8090${NC}"
echo -e "  📊 MySQL Externo:   ${YELLOW}localhost:3309${NC}"
echo ""
echo -e "${CYAN}------------------------------------------${NC}"
echo -e "${CYAN}  👤 CREDENCIALES DE ACCESO (PRUEBAS)${NC}"
echo -e "${CYAN}------------------------------------------${NC}"
echo -e "  📧 Correo:         ${YELLOW}admin@multitenant.dev${NC}"
echo -e "  🔑 Contraseña:     ${YELLOW}12345678${NC}"
echo -e "${CYAN}------------------------------------------${NC}"
echo ""
echo -e "  📝 Nota: Si haces cambios en código PHP, se reflejan al instante."
echo -e "         Si agregas paquetes (composer), ejecuta: docker compose exec app composer install"
echo ""
