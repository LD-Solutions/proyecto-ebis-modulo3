<div align="center">

# 🪙 Finsmart - Plataforma de Gestión Financiera
### Sistema Full Stack Completo para Inversiones y Educación Financiera

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![React](https://img.shields.io/badge/React-19.1-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://reactjs.org)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.8-3178C6?style=for-the-badge&logo=typescript&logoColor=white)](https://www.typescriptlang.org/)
[![SQLite](https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)

> **🎓 Proyecto desarrollado por David y Luis para el Master EBIS Full Stack Developer**
> *Plataforma empresarial completa con backend Laravel y frontend React/TypeScript*

![Architecture](https://img.shields.io/badge/Architecture-Full_Stack-success?style=for-the-badge)
![API](https://img.shields.io/badge/API-REST_Completa-blue?style=for-the-badge)
![Auth](https://img.shields.io/badge/Auth-Laravel_Sanctum-orange?style=for-the-badge)

</div>

---

## 🌟 Descripción del Proyecto

**Finsmart** es una plataforma empresarial completa de gestión financiera que combina:

- 💰 **Gestión de Portfolio**: Sistema de inversión en fondos indexados con cálculo de P&L en tiempo real
- 📰 **Noticias Financieras**: Plataforma de contenido con categorías y panel de administración
- 🎓 **Formación**: Biblioteca educativa con cursos, videos y webinars filtrados por nivel
- 🔐 **Autenticación Segura**: Sistema de login con Laravel Sanctum y Context API
- 👥 **Gestión de Empleados**: Sistema RRHH con CRUD completo
- 💰 **Calculadora de Ahorros**: Método 50/30/20 para finanzas personales
- ✉️ **Mensajes de Contacto**: Sistema de comunicación con formularios

---

## 🏗️ Arquitectura del Sistema

```
proyecto-ebis-modulo3/
│
├── backend/                    # API REST con Laravel 12
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   │   ├── AuthController.php
│   │   │   ├── NoticiasController.php
│   │   │   ├── EmpleadosController.php
│   │   │   ├── CalculadoraAhorrosController.php
│   │   │   ├── MensajesContactoController.php
│   │   │   ├── FormacionController.php
│   │   │   └── PortfolioController.php
│   │   ├── Models/
│   │   └── Http/Resources/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── routes/api.php
│   └── config/
│
└── frontend/                   # Aplicación React + TypeScript
    ├── src/
    │   ├── pages/             # 6 vistas principales
    │   │   ├── Home.tsx
    │   │   ├── Login.tsx
    │   │   ├── Noticias.tsx
    │   │   ├── NoticiaDetail.tsx
    │   │   ├── Formaciones.tsx
    │   │   └── Portfolio.tsx
    │   ├── components/        # Componentes reutilizables
    │   │   ├── Layout.tsx
    │   │   ├── Navbar.tsx
    │   │   ├── Footer.tsx
    │   │   ├── Toast.tsx
    │   │   ├── noticias/
    │   │   └── formaciones/
    │   ├── context/           # Gestión de estado
    │   │   ├── AuthContext.tsx
    │   │   └── ToastContext.tsx
    │   ├── services/          # Servicios API
    │   └── constants/
    └── public/
```

---

## 🚀 Stack Tecnológico

### **Backend**
| Tecnología | Versión | Uso |
|------------|---------|-----|
| **Laravel** | 12.0 | Framework PHP principal |
| **PHP** | 8.2+ | Lenguaje del servidor |
| **Laravel Sanctum** | 4.1 | Autenticación con tokens API |
| **SQLite** | 3 | Base de datos embebida |
| **L5-Swagger** | 9.0 | Documentación API interactiva |

### **Frontend**
| Tecnología | Versión | Uso |
|------------|---------|-----|
| **React** | 19.1 | Biblioteca UI |
| **TypeScript** | 5.8 | Tipado estático |
| **Vite** | 7.1 | Build tool y dev server |
| **React Router** | 7.9 | Enrutamiento SPA |
| **Axios** | 1.12 | Cliente HTTP |
| **CSS Modules** | - | Estilos encapsulados |

---

## 📦 Instalación Completa

### **Requisitos Previos**
- PHP 8.2 o superior
- Composer
- Node.js 18+ y npm
- Git

### **Paso 1: Clonar el Repositorio**
```bash
git clone https://github.com/tu-usuario/proyecto-ebis-modulo3.git
cd proyecto-ebis-modulo3
```

### **Paso 2: Configurar Backend**
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```
✅ Backend disponible en: [`http://localhost:8000`](http://localhost:8000)
📚 API Docs en: [`http://localhost:8000/api/documentation`](http://localhost:8000/api/documentation)

### **Paso 3: Configurar Frontend**
```bash
cd ../frontend
npm install
npm run dev
```
✅ Frontend disponible en: [`http://localhost:5173`](http://localhost:5173)

---

## 🔑 Credenciales de Prueba

```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

**Balance inicial de portfolio**: €10,000
**Fondos disponibles**: SPY, QQQ, VTI, SCHD

---

## 🎯 Funcionalidades Principales

### 🏠 **Página de Inicio**
- Hero section con branding corporativo
- Secciones de presentación del equipo y servicios
- Diseño responsive con imágenes y contenido alternado
- Enlaces de navegación rápida

### 🔐 **Sistema de Autenticación**
- **Login con validación**: Formularios con validación en tiempo real
- **Gestión de sesión**: Token persistente con Laravel Sanctum
- **Redirección inteligente**: Vuelve a la página anterior después del login
- **Context API**: Estado global de autenticación en toda la app

### 📰 **Plataforma de Noticias**
- **Listado con paginación**: Sistema "Cargar más" para navegación fluida
- **Filtrado por categorías**: Bolsa, criptomonedas, inversiones, tecnología, economía, finanzas
- **Vista detallada**: Página individual para cada noticia con hero image
- **Panel de administración** (usuarios autenticados):
  - ✏️ Crear nuevas noticias
  - 📝 Editar noticias existentes
  - 🗑️ Eliminar noticias con confirmación
  - Paginación de 5 items en lista de admin
- **Imágenes con fallback**: Gradientes dinámicos si no hay imagen

### 🎓 **Plataforma de Formación**
- **Grid responsive** de contenido educativo
- **Filtrado avanzado**:
  - Por tipo: curso, video, libro, webinar
  - Por nivel: principiante, intermedio, avanzado
- **CRUD completo** (usuarios autenticados):
  - Crear nueva formación con modal
  - Editar formaciones existentes
  - Eliminar formaciones
- **Metadata completa**: Instructor, duración, descripción
- **Badges de colores**: Identificación visual de tipo y nivel

### 💼 **Gestión de Portfolio**
- **Dashboard financiero**:
  - Balance disponible en tiempo real
  - Valor total de la cartera
  - Total invertido
  - Ganancia/Pérdida con indicadores visuales (verde/rojo)
- **Operaciones de inversión**:
  - 🛒 Comprar nueva posición en fondo
  - 📈 Comprar más participaciones de posición existente
  - 📉 Vender parcialmente
  - 🔴 Vender toda la posición
- **Tabla detallada** con toda la información:
  - Símbolo y nombre del fondo
  - Participaciones actuales
  - Precio de compra vs precio actual
  - Valor actual de la posición
  - P&L individual por posición
- **Cálculos automáticos**: Valores en tiempo real
- **Formato EUR**: Moneda europea

### 👥 **Gestión de Empleados**
- CRUD completo de empleados
- Información detallada: nombre, email, puesto, salario
- API REST con paginación

### 💰 **Calculadora de Ahorros**
- Método 50/30/20 (necesidades/gastos/ahorros)
- Cálculo automático basado en ingresos
- Asignada automáticamente al crear usuario

### ✉️ **Mensajes de Contacto**
- Formulario de contacto público
- Panel de administración para gestionar mensajes
- Estado de mensajes (leído/no leído)

---

## 🛠️ API REST Endpoints

### **Autenticación**
```
POST   /api/login         - Iniciar sesión
POST   /api/logout        - Cerrar sesión (auth)
GET    /api/user          - Usuario actual (auth)
```

### **Noticias**
```
GET    /api/noticias              - Listar con paginación y filtros
POST   /api/noticias              - Crear (auth)
GET    /api/noticias/{id}         - Ver específica
PUT    /api/noticias/{id}         - Actualizar (auth)
DELETE /api/noticias/{id}         - Eliminar (auth)
```

### **Formación**
```
GET    /api/formaciones           - Listar con filtros
POST   /api/formaciones           - Crear (auth)
GET    /api/formaciones/{id}      - Ver específica
PUT    /api/formaciones/{id}      - Actualizar (auth)
DELETE /api/formaciones/{id}      - Eliminar (auth)
```

### **Portfolio**
```
GET    /api/portfolios            - Resumen + posiciones (auth)
POST   /api/portfolios            - Comprar nueva posición (auth)
GET    /api/portfolios/{id}       - Ver posición (auth)
PUT    /api/portfolios/{id}       - Comprar más / Vender (auth)
DELETE /api/portfolios/{id}       - Vender todo (auth)
```

### **Empleados, Calculadora y Mensajes**
Consulta el [`backend/README.md`](backend/README.md) para endpoints completos.

---

## 🎨 Características del Frontend

### **Componentes Modulares**
- **Layout System**: Navbar + Footer + contenido consistente
- **Sistema de Toasts**: Notificaciones globales con auto-cierre
- **CSS Modules**: Estilos encapsulados por componente
- **Componentes reutilizables**: Cards, modales, filtros

### **Gestión de Estado**
- **AuthContext**: Estado de autenticación global
- **ToastContext**: Sistema de notificaciones global
- **LocalStorage**: Persistencia de token de sesión

### **Enrutamiento**
- **React Router 7.9**: Navegación SPA fluida
- **Rutas protegidas**: Redirección automática a login
- **Parámetros dinámicos**: IDs para vistas de detalle
- **Query params**: Para filtros y redirecciones

### **Diseño Responsive**
- **Mobile First**: Diseño adaptado a todos los dispositivos
- **Grid System**: Layouts flexibles con CSS Grid
- **Media Queries**: Breakpoints para tablet y desktop
- **Imágenes optimizadas**: Lazy loading y fallbacks

---

## 🔍 Características Técnicas Destacadas

### **Backend**
- ✅ API REST completa con 7 módulos
- ✅ Autenticación con Laravel Sanctum
- ✅ Documentación automática con Swagger
- ✅ Base de datos SQLite embebida
- ✅ Seeders con datos de prueba
- ✅ API Resources para respuestas optimizadas
- ✅ Validación de requests
- ✅ Manejo centralizado de errores

### **Frontend**
- ✅ TypeScript para type safety
- ✅ Context API para estado global
- ✅ CSS Modules para estilos encapsulados
- ✅ Axios con interceptores
- ✅ Manejo de estados de loading/error
- ✅ Validación de formularios en tiempo real
- ✅ Componentes funcionales con Hooks
- ✅ Build optimizado con Vite

---

## 📚 Documentación Detallada

Para información detallada sobre cada parte del proyecto:

- **Backend completo**: Ver [`backend/README.md`](backend/README.md)
- **Frontend completo**: Ver [`frontend/README.md`](frontend/README.md)

---

## 🧪 Testing

### **Backend**
```bash
cd backend
php artisan test
```

### **Frontend**
```bash
cd frontend
npm run lint
```

---

## 🚀 Despliegue

### **Backend**
```bash
cd backend
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Frontend**
```bash
cd frontend
npm run build
# Los archivos optimizados estarán en dist/
```

---

## 🔧 Configuración de Desarrollo

### **Variables de Entorno Backend**
```env
APP_NAME=Finsmart
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
```

### **Configuración Frontend**
```typescript
// src/services/api.ts
const API_BASE_URL = 'http://localhost:8000/api';
```

---

## 🎯 Roadmap Futuro

- [ ] Sistema de notificaciones en tiempo real
- [ ] Dashboard de estadísticas avanzado
- [ ] Integración con APIs de mercados reales
- [ ] Sistema de reportes en PDF
- [ ] Chat en vivo con asesores
- [ ] Aplicación móvil nativa
- [ ] Tests automatizados E2E
- [ ] CI/CD con GitHub Actions

---

## 🐛 Problemas Conocidos

No hay problemas conocidos en este momento. Si encuentras algún error:
1. Verifica que tanto backend como frontend estén corriendo
2. Comprueba que las URLs base sean correctas
3. Limpia la caché del navegador
4. Revisa los logs de Laravel y la consola del navegador

---

## 📄 Licencia

**🎓 Proyecto Educativo** - Master EBIS Full Stack Developer

Este proyecto fue desarrollado con fines educativos como parte del programa Master EBIS.

---

<div align="center">

## 👨‍💻 **Desarrollado por David**

> *Finsmart representa una implementación completa de una plataforma full stack moderna,
> combinando las mejores prácticas de backend con Laravel y frontend con React/TypeScript.*

<table>
<tr>
<td align="center" width="50%">

### 🏆 **Backend Achievements**
```
✅ Laravel 12 + PHP 8.2
✅ API REST con 7 módulos
✅ Autenticación Sanctum
✅ Documentación Swagger
✅ SQLite + Seeders
```

</td>
<td align="center" width="50%">

### 🚀 **Frontend Achievements**
```
✅ React 19 + TypeScript
✅ 6 vistas principales
✅ Context API + Router
✅ CSS Modules
✅ Build optimizado Vite
```

</td>
</tr>
</table>

---

![Made with Laravel](https://img.shields.io/badge/Backend-Laravel-FF2D20?style=for-the-badge&logo=laravel)
![Made with React](https://img.shields.io/badge/Frontend-React-61DAFB?style=for-the-badge&logo=react)
![EBIS](https://img.shields.io/badge/Master-EBIS%20Full%20Stack-blue?style=for-the-badge)

### 🌟 **¡Gracias por explorar Finsmart!**

**Contacto**: [GitHub](https://github.com/misterdavs) | **Proyecto**: Master EBIS Full Stack Developer

</div>
