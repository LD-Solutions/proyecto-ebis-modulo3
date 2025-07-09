# Finsmart API - Laravel

API REST para la plataforma Finsmart con gestión de noticias, formación y empleados, entre otras cosas. Autenticación mediante Laravel Sanctum.

**Proyecto desarrollado para el Master de EBIS Full Stack Developer**

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

## Documentación API

La documentación completa de la API está disponible en Swagger:
- **URL**: `http://localhost:8000/api/documentation`
- Acceso completo a todos los endpoints con ejemplos interactivos

## Endpoints de la API

### Autenticación
- `POST /api/login` - Iniciar sesión
- `POST /api/logout` - Cerrar sesión (requiere token)
- `GET /api/user` - Obtener usuario autenticado (requiere token)

### Noticias
- `GET /api/noticias` - Listar todas las noticias publicadas
  - Parámetros: `?page=1&per_page=10&categoria=tecnologia`
- `POST /api/noticias` - Crear nueva noticia (requiere autenticación)
- `GET /api/noticias/{id}` - Obtener noticia específica
- `PUT /api/noticias/{id}` - Actualizar noticia completa (requiere autenticación)
- `DELETE /api/noticias/{id}` - Eliminar noticia (requiere autenticación)

**Estructura de Noticia:**
```json
{
  "id": 1,
  "titulo": "Título de la noticia",
  "contenido": "Contenido completo...",
  "autor": "Juan Pérez",
  "categoria": "tecnologia",
  "imagen_url": "https://example.com/image.jpg",
  "fecha_publicacion": "2024-01-15T10:30:00Z",
  "publicado": true,
  "created_at": "2024-01-15T10:30:00Z",
  "updated_at": "2024-01-15T10:30:00Z"
}
```

### Formación (Próximamente)

**Estructura de Curso:**
```json
{
  "id": 1,
  "nombre": "Desarrollo Web con Laravel",
}
```

### Empleados (Próximamente)

**Estructura de Empleado:**
```json
{
  "id": 1,
  "nombre": "Carlos López",
}
```

## Uso

### Autenticación
1. Hacer login en `/api/login` con las credenciales de prueba
2. Usar el token devuelto en el header `Authorization: Bearer {token}`
3. Acceder a los endpoints protegidos

### Ejemplo de uso con cURL
```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com", "password": "password123"}'

# Usar token para crear noticia
curl -X POST http://localhost:8000/api/noticias \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"titulo": "Nueva noticia", "contenido": "Contenido...", "autor": "Test", "categoria": "general"}'
```

## Características de Finsmart

- **Gestión de Noticias**: Sistema completo de publicación y gestión de contenido
- **Formación Empresarial**: Plataforma de cursos y capacitación para empleados
- **Gestión de RRHH**: Sistema de administración de empleados y evaluaciones
- **Autenticación Segura**: Sistema de tokens con Laravel Sanctum
- **API RESTful**: Endpoints bien documentados con Swagger
- **Paginación**: Listados optimizados con paginación automática

## Tecnologías

- **Backend**: Laravel 11
- **Autenticación**: Laravel Sanctum
- **Base de datos**: SQLite (desarrollo) / MySQL (producción)
- **Documentación**: Swagger/OpenAPI
- **Testing**: PHPUnit
- **Datos de prueba**: Faker

## Desarrollo

### Estructura del proyecto
```
app/
├── Http/Controllers/Api/
│   ├── AuthController.php
│   ├── NoticiasController.php
│   ├── FormacionController.php (próximamente)
│   └── EmpleadosController.php (próximamente)
├── Models/
│   ├── User.php
│   ├── Noticia.php
│   ├── Curso.php (próximamente)
│   └── Empleado.php (próximamente)
```

### Comandos útiles
```bash
# Generar documentación Swagger
php artisan l5-swagger:generate

# Ejecutar tests
php artisan test

# Crear seeder
php artisan make:seeder NoticiaSeeder

# Crear modelo con migración
php artisan make:model Curso -m
```

## Contribución

Este proyecto es parte del Master de EBIS Full Stack Developer. Para contribuir:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Añade nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crea un Pull Request

## Licencia

Proyecto educativo para el Master de EBIS Full Stack Developer.