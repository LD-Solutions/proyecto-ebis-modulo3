# API de Noticias - Laravel

API REST para gestión de noticias con autenticación mediante Laravel Sanctum.

## Instalación

1. **Clonar el repositorio**
   ```bash
   git clone <url-del-repositorio>
   cd proyecto-ebis-modulo2
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar variables de entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**
   - Editar el archivo `.env` con la configuración de tu base de datos
   - Por defecto usa SQLite (ya incluido)

5. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Iniciar el servidor**
   ```bash
   php artisan serve
   ```

## Credenciales de prueba

- **Email**: test@example.com
- **Password**: password123

## Endpoints de la API

### Autenticación
- `POST /api/login` - Iniciar sesión
- `POST /api/logout` - Cerrar sesión (requiere token)
- `GET /api/user` - Obtener usuario autenticado (requiere token)

### Noticias
- `GET /api/noticias` - Listar todas las noticias
- `POST /api/noticias` - Crear nueva noticia
- `GET /api/noticias/{id}` - Obtener noticia específica
- `PUT/PATCH /api/noticias/{id}` - Actualizar noticia
- `DELETE /api/noticias/{id}` - Eliminar noticia

## Uso

1. Hacer login en `/api/login` con las credenciales de prueba
2. Usar el token devuelto en el header `Authorization: Bearer {token}`
3. Acceder a los endpoints de noticias

## Tecnologías

- Laravel 11
- Laravel Sanctum (autenticación API)
- SQLite (base de datos)
- Faker (datos de prueba)
