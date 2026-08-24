#!/bin/bash
set -e

# Colores para los mensajes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

cd "$(dirname "$0")"

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  DESPLIEGUE RÁPIDO DOCKER - COMBA${NC}"
echo -e "${GREEN}========================================${NC}"

# 1. Verificar si está en el directorio correcto
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: Ejecuta este script desde la raíz del proyecto Laravel (donde está artisan)${NC}"
    exit 1
fi

# 2. Verificar que exista el .env con las credenciales de Docker
echo -e "${YELLOW}[1/7] Verificando archivo .env...${NC}"
if [ ! -f ".env" ]; then
    echo -e "${RED} -> No se encontró .env. Copia .env.example a .env y completa las variables DOCKER_* antes de continuar.${NC}"
    exit 1
fi

for var in DOCKER_MYSQL_ROOT_PASSWORD DOCKER_MYSQL_USER DOCKER_MYSQL_PASSWORD DOCKER_PMA_USER DOCKER_PMA_PASSWORD; do
    if ! grep -qE "^${var}=.+" .env; then
        echo -e "${RED} -> Falta definir ${var} en .env${NC}"
        exit 1
    fi
done

# 3. Ajustar el archivo .env para que Laravel apunte a los contenedores
echo -e "${YELLOW}[2/7] Ajustando .env para Docker...${NC}"
sed -i 's/^DB_HOST=127.0.0.1/DB_HOST=mysql/' .env
sed -i 's/^DB_HOST=localhost/DB_HOST=mysql/' .env
sed -i 's/^DB_PORT=3309/DB_PORT=3306/' .env
sed -i 's/^LEGACY_DB_HOST=127.0.0.1/LEGACY_DB_HOST=mysql/' .env
sed -i 's/^LEGACY_DB_HOST=localhost/LEGACY_DB_HOST=mysql/' .env
sed -i 's/^LEGACY_DB_PORT=3309/LEGACY_DB_PORT=3306/' .env
echo " -> .env ajustado correctamente."

# 4. Dar permisos a carpetas de almacenamiento
echo -e "${YELLOW}[3/7] Ajustando permisos de storage y bootstrap/cache...${NC}"
mkdir -p storage/framework/{views,cache,sessions,tmp}
# 775: el dueño y el grupo pueden escribir; no "el resto del mundo"
sudo chmod -R 775 storage bootstrap/cache

# 5. Construir y levantar contenedores
echo -e "${YELLOW}[4/7] Levantando contenedores Docker...${NC}"
docker compose up -d --build

# 6. Esperar a que MySQL esté listo
echo -e "${YELLOW}[5/7] Esperando a que MySQL esté listo...${NC}"
ROOT_PASSWORD=$(grep -E '^DOCKER_MYSQL_ROOT_PASSWORD=' .env | cut -d '=' -f2-)
for i in $(seq 1 15); do
    if docker compose exec -T mysql mysqladmin ping -h localhost -u root -p"${ROOT_PASSWORD}" --silent 2>/dev/null; then
        echo " -> MySQL listo!"
        break
    fi
    sleep 2
done

echo -e "${YELLOW}[6/7] Instalando dependencias de PHP (Composer) y migrando...${NC}"
docker compose exec -T app composer install --no-interaction 2>&1
docker compose exec -T app php artisan migrate --force 2>&1
docker compose exec -T app php artisan cache:clear 2>/dev/null

# 7. Restablecer contraseña del administrador de pruebas (opcional)
ADMIN_TEST_PASSWORD=$(grep -E '^DOCKER_ADMIN_TEST_PASSWORD=' .env | cut -d '=' -f2-)
if [ -n "${ADMIN_TEST_PASSWORD}" ]; then
    echo -e "${YELLOW}[7/7] Estableciendo contraseña de prueba para el usuario Admin...${NC}"
    # La contraseña viaja como variable de entorno del contenedor (-e) y se
    # lee con env() dentro de tinker, así nunca aparece en la línea de
    # comandos (visible en ps) ni sufre interpolación del shell.
    docker compose exec -T \
        -e ADMIN_TEST_PASSWORD="${ADMIN_TEST_PASSWORD}" \
        app php artisan tinker --execute="DB::connection('legacy')->table('usuarios')->where('id_usuario', 1)->update(['pwd' => bcrypt(env('ADMIN_TEST_PASSWORD'))]);" 2>&1
fi

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  ✅ DESPLIEGUE COMPLETADO CON ÉXITO${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "  🌐 Aplicación:     ${YELLOW}http://localhost:8002${NC}"
echo -e "  🗄️  phpMyAdmin:     ${YELLOW}http://localhost:8090${NC}"
echo -e "  📊 MySQL Externo:   ${YELLOW}localhost:3309${NC}"
echo ""
echo -e "  📝 Nota: Las credenciales de acceso viven en tu .env (variables DOCKER_*)."
echo -e "         Si haces cambios en código PHP, se reflejan al instante."
echo -e "         Si agregas paquetes (composer), ejecuta: docker compose exec app composer install"
echo ""
