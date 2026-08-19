-- Crear usuario si no existe
CREATE USER IF NOT EXISTS 'mt_user'@'%' IDENTIFIED BY 'mt_secret';
CREATE USER IF NOT EXISTS 'mt_user'@'localhost' IDENTIFIED BY 'mt_secret';

-- Base de datos principal de Laravel
CREATE DATABASE IF NOT EXISTS `multitenant_laravel`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Base de datos legacy
CREATE DATABASE IF NOT EXISTS `multitenant`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Permisos sobre ambas bases de datos
GRANT ALL PRIVILEGES ON `multitenant_laravel`.* TO 'mt_user'@'%';
GRANT ALL PRIVILEGES ON `multitenant_laravel`.* TO 'mt_user'@'localhost';
GRANT ALL PRIVILEGES ON `multitenant`.* TO 'mt_user'@'%';
GRANT ALL PRIVILEGES ON `multitenant`.* TO 'mt_user'@'localhost';

FLUSH PRIVILEGES;
