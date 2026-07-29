# MultitenantLaravel

## Descripción

MultitenantLaravel es una aplicación desarrollada en Laravel 13 para la administración de empresas, actividades, formularios, usuarios y control de asistencias bajo un esquema **multitenant**, donde cada empresa visualiza únicamente su propia información mientras el SuperAdministrador tiene acceso global.

Actualmente el proyecto incluye:

* Gestión de empresas.
* Gestión de usuarios y roles.
* Gestión de actividades.
* Gestión de formularios dinámicos.
* Registro de respuestas.
* Administración de asistentes.
* Confirmación manual de asistencia.
* Base preparada para confirmación mediante código QR.

---

# Requisitos

Servidor Linux recomendado (Ubuntu 22.04 o superior).

Software requerido:

* PHP 8.5+
* Composer 2.x
* MySQL 8.x
* Apache o Nginx
* Git

Extensiones PHP:

* BCMath
* Ctype
* Fileinfo
* JSON
* Mbstring
* OpenSSL
* PDO
* PDO_MySQL
* Tokenizer
* XML
* Zip
* GD

---

# Instalación

## 1. Clonar el proyecto

```bash
git clone https://github.com/<usuario>/MultitenantLaravel.git

cd MultitenantLaravel
```

---

## 2. Instalar dependencias

```bash
composer install
```

---

## 3. Copiar el archivo de entorno

```bash
cp .env.example .env
```

---

## 4. Configurar la base de datos

Editar:

```
.env
```

Ejemplo:

```env
DB_CONNECTION=legacy
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=multitenant
DB_USERNAME=root
DB_PASSWORD=password
```

---

## 5. Generar la llave

```bash
php artisan key:generate
```

---

## 6. Restaurar la base de datos

Importar el respaldo SQL:

```bash
mysql -u usuario -p multitenant < multitenant.sql
```

---

## 7. Limpiar cachés

```bash
php artisan optimize:clear
```

---

## 8. Verificar permisos

Linux:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache

sudo chmod -R 775 storage bootstrap/cache
```

---

## 9. Ejecutar

Servidor local:

```bash
php artisan serve
```

o configurar VirtualHost en Apache/Nginx apuntando a:

```
public/
```

---

# Usuarios

El sistema utiliza autenticación propia.

Los usuarios se almacenan en la base de datos.

El SuperAdministrador posee acceso global.

Los Administradores visualizan únicamente la información de su empresa.

Los Supervisores administran actividades y asistencia.

---

# Roles

Actualmente existen los siguientes roles:

* SuperAdministrador
* Administrador
* Supervisor
* Usuario

Próximamente:

* Validador QR

---

# Estructura

```
app/
config/
database/
public/
resources/
routes/
storage/
```

---

# Tecnologías

* Laravel 13
* PHP 8.5
* MySQL
* Bootstrap 5
* SweetAlert2
* FontAwesome

---

# Versionado

El proyecto utiliza Git Tags.

Ejemplo:

```
v1.8.1
```

Cada versión publicada representa un estado estable del sistema.

---

# Próximas funcionalidades

* Validación de asistencia mediante QR.
* Usuario Validador QR.
* Confirmación automática de asistencia.
* Reportes avanzados.
* Dashboard estadístico.

---

# Autor

Andrés Fernando Comba

Proyecto académico y de desarrollo para la gestión multitenant de actividades y formularios utilizando Laravel.
