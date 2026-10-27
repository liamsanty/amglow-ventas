# AmGlow · Sistema de Ventas

Sistema web de ventas e inventario para una tienda de productos de cuidado personal. Permite gestionar productos, compras, ventas, clientes, proveedores, inventario, usuarios y roles, y generar comprobantes y reportes en PDF.

**Demo desplegada:** https://amglow.infinityfreeapp.com

> Es un despliegue de prueba en hosting gratuito. Puede tardar en cargar la primera vez.

---

## Módulos

| Módulo | Qué hace |
|---|---|
| Panel | Pantalla de inicio después del login |
| Categorías y marcas | Clasificación de productos |
| Productos | Alta, edición y baja, con foto y reporte en PDF |
| Clientes y proveedores | Personas naturales o jurídicas con su documento |
| Compras | Registro de compras a proveedores |
| Ventas | Registro de ventas, comprobante en PDF y consulta por rango de fechas |
| Inventario | Existencias por producto y ubicación |
| Usuarios y roles | Roles con permisos (Spatie Laravel Permission) |

## Tecnologías

- **PHP 8.2+** con **Laravel 11**
- **MySQL / MariaDB**
- Blade + Bootstrap 5 (plantilla SB Admin), DataTables y Font Awesome
- `barryvdh/laravel-dompdf` para los PDF
- `spatie/laravel-permission` para roles y permisos
- `anhskohbo/no-captcha` para el reCAPTCHA del login

No usa Vite ni Node para compilar: el CSS y JS ya están en `public/`.

---

## Correr el proyecto en local

### Requisitos
- PHP 8.2 o superior con las extensiones `pdo_mysql`, `mbstring`, `gd`, `zip` y `bcmath`
- Composer
- MySQL o MariaDB (por ejemplo con XAMPP o Laragon)

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/liamsanty/amglow-ventas.git
cd amglow-ventas

# 2. Instalar dependencias de PHP
composer install

# 3. Crear el archivo de configuración y la llave de la app
cp .env.example .env
php artisan key:generate
```

4. Crear una base de datos vacía, por ejemplo `venta_sis`, y poner sus datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=venta_sis
DB_USERNAME=root
DB_PASSWORD=
```

5. Cargar la base de datos con datos de ejemplo e iniciar la app:

```bash
# Importa el respaldo con datos de ejemplo (usuarios, roles, permisos, productos...)
mysql -u root venta_sis < database/sistema_ventas.sql

# Aplica las migraciones que el respaldo no tenga
php artisan migrate

# Enlace para que se vean las fotos de productos
php artisan storage:link

# Levantar el servidor
php artisan serve
```

6. Abrir http://localhost:8000 e iniciar sesión con un usuario de la base de datos.

> **reCAPTCHA (opcional):** si `NOCAPTCHA_SITEKEY` y `NOCAPTCHA_SECRET` están vacías, el login funciona sin captcha. Si se llenan con las llaves de un sitio registrado en https://www.google.com/recaptcha/admin (reCAPTCHA v2, casilla "No soy un robot", con tu dominio y `localhost`), el captcha se muestra y se valida en el servidor.

---

## Despliegue (InfinityFree)

La demo está en **InfinityFree** (hosting PHP + MySQL gratuito):

| Dato | Valor |
|---|---|
| URL | https://amglow.infinityfreeapp.com |
| Servidor MySQL | `sql308.infinityfree.com` |
| Base de datos | `if0_43281187_venta_sis` |
| FTP | `ftpupload.net`, puerto 21 |

Las contraseñas **no** están en el repositorio: se configuran en el `.env` del servidor y en el panel de InfinityFree.

### Cómo se preparó

InfinityFree no tiene consola (no se puede correr `php artisan` ni `composer`) y su carpeta pública es `htdocs/`. Por eso:

1. **Se sube todo el proyecto a `htdocs/`, incluida la carpeta `vendor/`**, ya que no se puede correr `composer install` en el servidor.
2. **Se agrega un `.htaccess` en la raíz de `htdocs/`** que manda todas las peticiones a `public/`. Así `.env`, `vendor/` y `storage/` nunca quedan expuestos:

   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   ```

3. **Fotos de productos sin enlace simbólico:** InfinityFree no permite `php artisan storage:link`. Con `PUBLIC_DISK_ROOT=public/storage` en el `.env`, las fotos se guardan directamente en `public/storage/productos/`, que debe existir.
4. **La base de datos** se importó desde phpMyAdmin con un respaldo actualizado (el `.sql` del repo más las migraciones que le faltaban).
5. **`.env` de producción** (resumen):

   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://amglow.infinityfreeapp.com
   DB_HOST=sql308.infinityfree.com
   DB_DATABASE=if0_43281187_venta_sis
   DB_USERNAME=if0_43281187
   DB_PASSWORD=********
   PUBLIC_DISK_ROOT=public/storage
   FORCE_HTTPS=true
   SESSION_SECURE_COOKIE=true
   ```

---

## Flujo de trabajo (ramas, PR y despliegue automático)

```
rama-de-trabajo ──push──► PR automático a develop ──(pruebas ✅)──► merge
develop ────────push──► PR automático a main ─────(pruebas ✅)──► merge
main ───────────push──► despliegue automático a InfinityFree
```

| Rama | Para qué |
|---|---|
| `main` | Lo que está publicado. Cada cambio que llega aquí se despliega solo. |
| `develop` | Donde se juntan los cambios antes de publicarlos. |
| `feature/...`, `fix/...` | Una rama por cada cambio. |

### Paso a paso para hacer un cambio

```bash
git checkout develop
git pull
git checkout -b fix/nombre-del-cambio   # nueva rama para el cambio

# ... editar el código ...

git add .
git commit -m "Describe el cambio"
git push -u origin fix/nombre-del-cambio
```

1. Al hacer `push`, GitHub **abre solo un PR** de tu rama hacia `develop`.
2. En el PR corren las **pruebas** (`.github/workflows/ci.yml`). Si salen en verde ✅, se hace **Merge**.
3. Al llegar el cambio a `develop`, se **abre solo otro PR** de `develop` hacia `main`.
4. Cuando quieras publicar, revisas ese PR y haces **Merge**.
5. Al llegar a `main`, se **despliega solo** en InfinityFree (`.github/workflows/deploy.yml`).

### Qué hace cada workflow

| Archivo | Cuándo corre | Qué hace |
|---|---|---|
| `auto-pr.yml` | Push a cualquier rama menos `main` | Abre el PR a `develop` (o de `develop` a `main`) si no existe |
| `ci.yml` | En cada push a ramas de trabajo y a `develop` (el resultado se ve en el PR) | Instala dependencias, revisa sintaxis PHP y corre `php artisan test` |
| `deploy.yml` | Push a `main` (o a mano desde *Actions*) | Sube por FTP a `/htdocs/` **solo los archivos que cambiaron** |

### Qué NO sube el despliegue automático

- `vendor/`: ya está en el servidor. Si cambias dependencias (`composer.json`), hay que subir `vendor/` a mano (comprimida en zip).
- `.env` y `storage/`: el servidor conserva los suyos.
- Migraciones nuevas: no hay consola en InfinityFree, así que se aplican a mano desde phpMyAdmin.

### Configuración necesaria en GitHub (una sola vez)

- **Secrets** (*Settings → Secrets and variables → Actions*): `FTP_SERVER` = `ftpupload.net`, `FTP_USERNAME` = `if0_43281187`, `FTP_PASSWORD` = contraseña de la cuenta de InfinityFree.
- *Settings → Actions → General*: activar **"Allow GitHub Actions to create and approve pull requests"**.
- *Settings → Branches*: proteger `main` y `develop` (exigir PR y que pasen las pruebas).

### Subida manual (alternativa)

Con **WinSCP** (`ftpupload.net`, usuario `if0_43281187`), el botón **Sincronizar** sube a `htdocs/` solo lo que cambió.

---

## Seguridad

- Todas las pantallas del sistema requieren sesión iniciada; sin sesión se redirige a `/login`.
- El login se bloquea un minuto después de 5 intentos fallidos.
- Cada usuario solo puede cambiar **su propia** contraseña, desde el menú del ícono de usuario → *Cambiar contraseña*.
- En producción `APP_DEBUG=false`, para no mostrar errores internos.

## Pendientes conocidos

- **Usuarios:** todavía no existen las pantallas para crear y editar usuarios (`userController` solo lista), ni la opción para que un administrador restablezca la contraseña de otro.
- **Permisos por rol:** los middlewares de permisos están comentados, así que cualquier usuario con sesión iniciada entra a todos los módulos.
- **reCAPTCHA:** desactivado en la demo hasta registrar llaves propias para el dominio.
- **Inventario:** la ruta `/inventario/create` no tiene pantalla.

## Estructura principal

```
app/Http/Controllers   Lógica de cada módulo
app/Models             Modelos (Producto, Venta, Compra, Cliente, ...)
database/migrations    Estructura de la base de datos
database/seeders       Datos iniciales
database/sistema_ventas.sql   Respaldo con datos de ejemplo
resources/views        Pantallas (Blade)
routes/web.php         Rutas del sistema
public/                CSS, JS e imágenes
```
