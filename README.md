<div align="center">

# 🪙 Finsmart API
### Plataforma Empresarial Financiera Completa

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![MongoDB](https://img.shields.io/badge/MongoDB-5.4-47A248?style=for-the-badge&logo=mongodb&logoColor=white)](https://mongodb.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

[![API Documentation](https://img.shields.io/badge/API_Docs-Swagger-85EA2D?style=flat-square&logo=swagger&logoColor=black)](http://localhost:8000/api/documentation)
[![Live Demo](https://img.shields.io/badge/Live_Demo-Welcome_Page-4285F4?style=flat-square&logo=google-chrome&logoColor=white)](http://localhost:8000)
[![GitHub](https://img.shields.io/badge/GitHub-Repository-181717?style=flat-square&logo=github&logoColor=white)](https://github.com/LD-Solutions/proyecto-ebis-modulo2)

> **🎓 Proyecto desarrollado para el Master EBIS Full Stack Developer**  
> *API REST completa para gestión financiera empresarial con módulos integrados*

![Welcome Preview](https://img.shields.io/badge/UI-Modern_Interface-success?style=for-the-badge)
![Features](https://img.shields.io/badge/Features-7_Modules-blue?style=for-the-badge)
![Auth](https://img.shields.io/badge/Auth-Laravel_Sanctum-orange?style=for-the-badge)

</div>

---

## 🚀 Características Principales

<table>
<tr>
<td width="50%">

### ✅ **Módulos Core**
```diff
+ 🔐 Autenticación - Laravel Sanctum
+ 📰 Noticias - Gestión de contenido
+ 👥 Empleados - Sistema RRHH
+ 💰 Calculadora - Método 50/30/20
```

</td>
<td width="50%">

### 🌟 **Módulos Avanzados**
```diff
+ ✉️ Mensajes - Formulario contacto
+ 🎓 Formación - MongoDB educativa
+ 📊 Portfolio - Inversiones P&L
+ 🎨 UI - Tailwind + animaciones
```

</td>
</tr>
</table>

<div align="center">

### 🏆 **Stack Tecnológico Premium**

| Frontend | Backend | Base de Datos | Herramientas |
|:--------:|:-------:|:-------------:|:------------:|
| ![Tailwind](https://img.shields.io/badge/-Tailwind-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white) | ![Laravel](https://img.shields.io/badge/-Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white) | ![MySQL](https://img.shields.io/badge/-MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white) | ![Swagger](https://img.shields.io/badge/-Swagger-85EA2D?style=flat-square&logo=swagger&logoColor=black) |
| ![HTML5](https://img.shields.io/badge/-HTML5-E34F26?style=flat-square&logo=html5&logoColor=white) | ![PHP](https://img.shields.io/badge/-PHP_8.2+-777BB4?style=flat-square&logo=php&logoColor=white) | ![MongoDB](https://img.shields.io/badge/-MongoDB-47A248?style=flat-square&logo=mongodb&logoColor=white) | ![Composer](https://img.shields.io/badge/-Composer-885630?style=flat-square&logo=composer&logoColor=white) |

</div>

---

## 📋 Instalación Rápida

<details>
<summary><b>🚀 Instalación en 5 pasos</b></summary>

### **Paso 1** - Clonar proyecto
```bash
git clone https://github.com/LD-Solutions/proyecto-ebis-modulo2.git
cd proyecto-ebis-modulo2
composer install
```

### **Paso 2** - Configurar entorno
```bash
cp .env.example .env
php artisan key:generate
```

### **Paso 3** - Base de datos
```bash
# Crear base de datos y poblar con datos fake
php artisan migrate
php artisan db:seed
```

### **Paso 4** - ¡Listo! 🎉
```bash
php artisan serve
```

</details>

> **💡 Tip:** Para MongoDB (módulo Formación), instalar: `sudo apt install mongodb php-mongodb`

<div align="center">

### 🌐 **Accesos Directos**
| Servicio | URL | Descripción |
|:---------|:----|:------------|
| 🏠 **Aplicación** | [`localhost:8000`](http://localhost:8000) | Página principal |
| 📚 **API Docs** | [`localhost:8000/api/documentation`](http://localhost:8000/api/documentation) | Swagger interactivo |
| 💻 **Código** | [`GitHub Repository`](https://github.com/LD-Solutions/proyecto-ebis-modulo2) | Código fuente |

</div>

---

<div align="center">

## 🔑 Credenciales de Prueba

<table>
<tr>
<td align="center">

### 👤 **Usuario Demo**
```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

</td>
<td align="center">

### 💰 **Portfolio Initial**
```json
{
  "balance": "$10,000",
  "fondos": "4 disponibles",
  "status": "Activo"
}
```

</td>
</tr>
</table>

</div>

---

## 🛠 API Endpoints

<details>
<summary><b>🔐 Autenticación - Laravel Sanctum</b></summary>

| Método | Endpoint | Descripción | Auth |
|:------:|:---------|:------------|:----:|
| `POST` | `/api/login` | Iniciar sesión | ❌ |
| `POST` | `/api/logout` | Cerrar sesión | ✅ |
| `GET` | `/api/user` | Usuario autenticado | ✅ |

</details>

<details>
<summary><b>📰 Noticias - Gestión de Contenido</b></summary>

| Método | Endpoint | Descripción | Auth |
|:------:|:---------|:------------|:----:|
| `GET` | `/api/noticias` | Listar con paginación | ❌ |
| `POST` | `/api/noticias` | Crear nueva | ✅ |
| `GET` | `/api/noticias/{id}` | Ver específica | ❌ |
| `PUT` | `/api/noticias/{id}` | Actualizar | ✅ |
| `DELETE` | `/api/noticias/{id}` | Eliminar | ✅ |

> **Filtros**: `?page=1&per_page=10&categoria=tecnologia`

</details>

<details>
<summary><b>👥 Empleados - Sistema RRHH</b></summary>

| Método | Endpoint | Descripción | Auth |
|:------:|:---------|:------------|:----:|
| `GET` | `/api/empleados` | Listar todos | ❌ |
| `POST` | `/api/empleados` | Crear nuevo | ✅ |
| `GET` | `/api/empleados/{id}` | Ver específico | ❌ |
| `PUT` | `/api/empleados/{id}` | Actualizar | ✅ |
| `DELETE` | `/api/empleados/{id}` | Eliminar | ✅ |

</details>

<details>
<summary><b>💰 Calculadora de Ahorros - Método 50/30/20</b></summary>

| Método | Endpoint | Descripción | Auth |
|:------:|:---------|:------------|:----:|
| `GET` | `/api/calculadora-ahorros` | Ver calculadora | ✅ |
| `GET` | `/api/calculadora-ahorros/{id}` | Ver específica | ✅ |
| `PUT` | `/api/calculadora-ahorros/{id}` | Actualizar | ✅ |
| `DELETE` | `/api/calculadora-ahorros/{id}` | Resetear | ✅ |

> **Automático**: Se crea al registrar usuario. **50%** necesidades, **30%** gastos, **20%** ahorros

</details>

<details>
<summary><b>✉️ Mensajes de Contacto - Formulario Web</b></summary>

| Método | Endpoint | Descripción | Auth |
|:------:|:---------|:------------|:----:|
| `GET` | `/api/mensajes-contacto` | Listar todos | ✅ |
| `POST` | `/api/mensajes-contacto` | Enviar mensaje | ❌ |
| `GET` | `/api/mensajes-contacto/{id}` | Ver específico | ✅ |
| `PUT` | `/api/mensajes-contacto/{id}` | Actualizar | ✅ |
| `DELETE` | `/api/mensajes-contacto/{id}` | Eliminar | ✅ |

</details>

<details>
<summary><b>🎓 Formación - Plataforma Educativa (MongoDB)</b></summary>

| Método | Endpoint | Descripción | Auth |
|:------:|:---------|:------------|:----:|
| `GET` | `/api/formaciones` | Listar con filtros | ❌ |
| `POST` | `/api/formaciones` | Crear contenido | ✅ |
| `GET` | `/api/formaciones/{id}` | Ver específico | ❌ |
| `PUT` | `/api/formaciones/{id}` | Actualizar | ✅ |
| `DELETE` | `/api/formaciones/{id}` | Eliminar | ✅ |

> **Tipos**: `curso`, `video`, `libro`, `webinar` | **Niveles**: `principiante`, `intermedio`, `avanzado`

</details>

<details>
<summary><b>📊 Portfolio - Gestión de Inversiones</b></summary>

| Método | Endpoint | Descripción | Auth |
|:------:|:---------|:------------|:----:|
| `GET` | `/api/portfolios` | Resumen + balance | ✅ |
| `POST` | `/api/portfolios` | Comprar posición inicial | ✅ |
| `GET` | `/api/portfolios/{id}` | Ver posición específica | ✅ |
| `PUT` | `/api/portfolios/{id}` | Comprar más / Vender parte | ✅ |
| `DELETE` | `/api/portfolios/{id}` | Vender toda la posición | ✅ |

> **Balance inicial**: $10,000 | **P&L automático** | **4 fondos disponibles**

</details>

---

## 💻 Ejemplos de Uso

### 🔐 Autenticación
```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "test@example.com", "password": "password123"}'

# Respuesta
{
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  }
}
```

### 📰 Crear Noticia
```bash
curl -X POST http://localhost:8000/api/noticias \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "titulo": "Nueva funcionalidad",
    "contenido": "Detalles de la nueva feature...",
    "autor": "Equipo Dev",
    "categoria": "tecnologia"
  }'
```

### 📊 Consultar Portfolio
```bash
curl -X GET http://localhost:8000/api/portfolios \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🏗 Estructura del Proyecto

```
proyecto-ebis-modulo2/
├── app/
│   ├── Http/Controllers/
│   │   ├── Controller.php              # Tags Swagger ordenados
│   │   └── Api/
│   │       ├── AuthController.php      # Autenticación Sanctum
│   │       ├── NoticiasController.php  # Gestión noticias
│   │       ├── EmpleadosController.php # RRHH
│   │       ├── CalculadoraAhorrosController.php # Finanzas 50/30/20
│   │       ├── MensajesContactoController.php   # Formulario contacto
│   │       ├── FormacionController.php # Educación (MongoDB)
│   │       └── PortfolioController.php # Inversiones
│   ├── Models/
│   │   ├── User.php                    # Usuario base
│   │   ├── Noticia.php                 # Contenido
│   │   ├── Empleado.php                # RRHH
│   │   ├── CalculadoraAhorros.php      # Método 50/30/20
│   │   ├── MensajesContacto.php        # Formulario
│   │   ├── Formacion.php               # Educación (MongoDB)
│   │   ├── Portfolio.php               # Inversiones
│   │   └── IndexFund.php               # Fondos índice
│   └── Http/Resources/
│       ├── PortfolioResource.php       # API responses optimizadas
│       └── IndexFundResource.php
├── config/
│   ├── database.php                    # MySQL + MongoDB
│   └── l5-swagger.php                  # Documentación API
├── database/
│   ├── migrations/                     # Esquemas de base de datos
│   └── seeders/                        # Datos de prueba
├── resources/views/
│   └── welcome.blade.php               # Landing page Tailwind
└── routes/
    └── api.php                         # Endpoints API
```

---

## 🛠 Tecnologías

| Categoría | Tecnología | Versión | Uso |
|-----------|------------|---------|-----|
| **Backend** | Laravel | 12.0 | Framework principal |
| **Autenticación** | Laravel Sanctum | 4.1 | Tokens API |
| **Base de Datos** | MySQL | 8.0 | Base de datos principal |
| **NoSQL** | MongoDB | 5.4 | Módulo Formación |
| **Documentación** | L5-Swagger | 9.0 | API Docs |
| **Frontend** | Tailwind CSS | CDN | UI moderna |
| **Testing** | PHPUnit | 11.5 | Tests automatizados |

---

## 🎯 Configuración Avanzada

### 🔧 Variables de Entorno

**Base de datos principal (MySQL):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finsmart_api
DB_USERNAME=finsmart_user
DB_PASSWORD=password
```

**MongoDB (Formación):**
```env
MONGODB_HOST=127.0.0.1
MONGODB_PORT=27017
MONGODB_DATABASE=finsmart_formacion
MONGODB_USERNAME=
MONGODB_PASSWORD=
```

**Swagger:**
```env
L5_SWAGGER_GENERATE_ALWAYS=true  # Desarrollo
L5_SWAGGER_UI_DOC_EXPANSION=none
```

### 📊 Portfolio - Fondos Disponibles

| Símbolo | Nombre | Precio Base |
|---------|--------|-------------|
| **SPY** | SPDR S&P 500 ETF | $420.50 |
| **QQQ** | Invesco QQQ Trust | $350.25 |
| **VTI** | Vanguard Total Stock Market | $225.80 |
| **SCHD** | Schwab US Dividend Equity | $75.30 |

---

## 🧪 Testing y Desarrollo

### 🚀 Comandos Útiles
```bash
# Documentación
php artisan l5-swagger:generate

# Testing
php artisan test

# Base de datos
php artisan migrate:fresh --seed

# Cache
php artisan config:clear
php artisan cache:clear

# Modelos
php artisan make:model NuevoModelo -m
php artisan make:controller Api/NuevoController
```

### 📝 Crear Datos de Prueba
```bash
php artisan db:seed --class=NoticiasSeeder
php artisan db:seed --class=EmpleadosSeeder
php artisan db:seed --class=CalculadoraAhorrosSeeder
```

---

## 🔍 Funcionalidades Especiales

### 💰 **Calculadora 50/30/20**
- **50%** Necesidades básicas
- **30%** Gastos personales  
- **20%** Ahorros e inversiones
- Cálculo automático en tiempo real

### 📊 **Sistema de Portfolio**
- Valoración dinámica de fondos
- Cálculo automático de P&L
- Balance inicial de $10,000
- Operaciones de compra/venta

### 🎓 **Plataforma Formación (MongoDB)**
- Múltiples tipos de contenido
- Filtrado por categoría y nivel
- Almacenamiento de archivos
- Mock de libros en storage

### 🎨 **Interfaz Moderna**
- Animaciones Tailwind CSS
- Iconos SVG Heroicons
- Efectos hover y focus
- Diseño responsive

---

<div align="center">

---

## 📄 Licencia & Reconocimientos

**🎓 Proyecto Educativo** - Master EBIS Full Stack Developer

<table>
<tr>
<td align="center">

### 🏆 **Achievement Unlocked**
```
✅ API REST Completa
✅ 7 Módulos Integrados  
✅ MySQL + MongoDB
✅ UI Moderna Tailwind
✅ Documentación Swagger
```

</td>
<td align="center">

### 🚀 **Tech Stack Mastery**
```
✅ Laravel 12 + Sanctum
✅ Base de Datos Híbrida
✅ Interfaces Interactivas
✅ Animaciones CSS
✅ API Documentation
```

</td>
</tr>
</table>

---

### 👨‍💻 **Desarrollado con** ❤️

> *Este proyecto representa la culminación del módulo 2 del Master EBIS,  
> implementando una plataforma empresarial completa con tecnologías modernas  
> y mejores prácticas de desarrollo.*

![Made with Love](https://img.shields.io/badge/Made%20with-❤️-red?style=for-the-badge)
![EBIS](https://img.shields.io/badge/Master-EBIS%20Full%20Stack-blue?style=for-the-badge)
![Laravel](https://img.shields.io/badge/Powered%20by-Laravel-red?style=for-the-badge&logo=laravel)

### 🌟 **¡Gracias por explorar Finsmart API!**

</div>