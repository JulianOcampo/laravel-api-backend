# 🧩 API-LARAVEL

API RESTful construida con **Laravel 10**, **PHP 8.2+** y **MySQL 8**, con rutas anidadas, validaciones con FormRequest, respuestas tipadas con API Resources, control centralizado de excepciones y documentación **OpenAPI (Swagger)** generada automáticamente con **Scribe**.
![alt text](<Screenshot 2025-10-24 at 11.24.26 PM.png>)
---

## 🚀 Requisitos mínimos

- PHP >= 8.2  
- Composer  
- Docker y Docker Compose  
- MySQL 8  
- Extensiones: `pdo_mysql`, `openssl`, `mbstring`, `tokenizer`, `xml`

---

## ⚙️ Instalación y ejecución con Docker


 **Copia el archivo de entorno y configura las variables:**
   ```bash
   cp .env.example .env
   ```

   Asegúrate de dejar estas variables coherentes con el `docker-compose.yml`:

   ```env
   APP_URL=http://localhost:8000
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=laravel
   DB_PASSWORD=laravel
   ```

 **Levanta los servicios:**
   ```bash
   docker compose up -d
   ```

   Esto iniciará:
   - `laravel-app` → Contenedor PHP con Laravel
   - `mysql-db` → Base de datos MySQL 8
   - `phpmyadmin` → Interfaz visual opcional (http://localhost:8081)

 **Instala dependencias dentro del contenedor:**
   ```bash
   docker compose exec app composer install
   ```

 **Genera la clave de aplicación:**
   ```bash
   docker compose exec app php artisan key:generate
   ```

 **Ejecuta migraciones:**
   ```bash
   docker compose exec app php artisan migrate
   ```

 **(Opcional) Carga datos de prueba:**
   ```bash
   docker compose exec app php artisan db:seed
   ```

---

## 🧭 Endpoints principales

```php
Route::apiResource('posts', PostController::class);
Route::apiResource('posts.comments', CommentController::class)->shallow();
```

- `GET /api/posts` — Listar posts con paginación y filtros.  
- `POST /api/posts` — Crear un nuevo post (usa `StorePostRequest`).  
- `GET /api/posts/{id}` — Obtener un post por ID.  
- `GET /api/posts/{post}/comments` — Listar comentarios de un post.  
- `POST /api/comments` — Crear comentario asociado a un post.

---

## 📘 Documentación OpenAPI (Scribe)

Generar la documentación:

```bash
docker compose exec app php artisan scribe:generate
```

Accede en el navegador:  
👉 [http://localhost:8000/docs](http://localhost:8000/docs)

También se genera un archivo OpenAPI JSON disponible en:  
```
/public/docs/openapi.json
```

---

## 🧪 Tests

Ejecuta los tests (feature + unit):

```bash
docker compose exec app php artisan test
```

Incluye:
- 2 tests de feature (HTTP) para endpoints principales.
- 1 test unitario para reglas de negocio (servicio).

---

## 🧰 Estructura principal

```
app/
 ├── Http/
 │   ├── Controllers/
 │   │   ├── PostController.php
 │   │   ├── CommentController.php
 │   ├── Requests/
 │   │   ├── StorePostRequest.php
 │   │   ├── StoreCommentRequest.php
 │   └── Resources/
 │       ├── PostResource.php
 │       ├── CommentResource.php
 ├── Models/
 │   ├── Post.php
 │   ├── Comment.php
database/
 ├── migrations/
 ├── seeders/
tests/
 ├── Feature/
 ├── Unit/
```
