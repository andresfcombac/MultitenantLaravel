#!/bin/bash
set -e

echo "============================================"
echo "  INICIALIZANDO PROYECTO COMBA EN DOCKER"
echo "============================================"

cd "$(dirname "$0")"

# Detener contenedores existentes
echo "🔄 Deteniendo contenedores existentes..."
docker compose down  2>/dev/null

# Construir imagen
echo "🔨 Construyendo imagen Docker..."
docker compose build --no-cache

# Iniciar servicios
echo "🚀 Iniciando servicios..."
docker compose up -d

# Esperar a que MySQL esté listo
echo "⏳ Esperando a que MySQL esté listo..."
sleep 15

# Preparar directorios escribibles por PHP
echo "📁 Ajustando permisos..."
docker compose exec app mkdir -p storage/tmp
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R ug+rwX storage bootstrap/cache

# Instalar dependencias PHP
echo "📦 Instalando dependencias PHP..."
docker compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader

# Generar clave solo si aún no existe
if ! grep -qE '^APP_KEY=base64:.+' .env; then
  echo "🔑 Generando clave de aplicación..."
  docker compose exec app php artisan key:generate --ansi
else
  echo "🔑 Clave de aplicación ya configurada."
fi

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
docker compose exec app php artisan migrate --force

# Dar permisos finales
echo "📁 Ajustando permisos..."
docker compose exec app mkdir -p storage/tmp
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R ug+rwX storage bootstrap/cache
docker compose exec app php artisan optimize:clear

echo ""
echo "============================================"
echo "  ✅ PROYECTO INICIALIZADO CORRECTAMENTE"
echo "============================================"
echo ""
echo "  📱 Aplicación Laravel:  http://localhost:8002"
echo "  🗄️  phpMyAdmin:         http://localhost:8090"
echo "  📊 MySQL externo:       localhost:3310"
echo ""
echo "  Credenciales: revisa las variables DOCKER_* de tu archivo .env"
echo ""
echo "  Comandos útiles:"
echo "    docker compose logs -f app       # Ver logs de Laravel"
echo "    docker compose logs -f nginx     # Ver logs de Nginx"
echo "    docker compose exec app bash     # Entrar al contenedor"
echo "    docker compose restart app       # Reiniciar solo Laravel"
echo "    docker compose down              # Detener todo"
echo "============================================"
