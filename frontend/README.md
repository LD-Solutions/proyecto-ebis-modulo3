<div align="center">

# 🎨 Finsmart Frontend
### Interfaz de Usuario Moderna para Gestión Financiera

[![React](https://img.shields.io/badge/React-19.1-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://reactjs.org)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.8-3178C6?style=for-the-badge&logo=typescript&logoColor=white)](https://www.typescriptlang.org/)
[![Vite](https://img.shields.io/badge/Vite-7.1-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![React Router](https://img.shields.io/badge/React_Router-7.9-CA4245?style=for-the-badge&logo=react-router&logoColor=white)](https://reactrouter.com)

> **🎓 Frontend desarrollado por David para el Master EBIS Full Stack Developer**
> *Aplicación React moderna con TypeScript, enrutamiento avanzado y gestión de estado*

![Features](https://img.shields.io/badge/Features-6_Vistas_Principales-blue?style=for-the-badge)
![Components](https://img.shields.io/badge/Components-Modulares_y_Reutilizables-green?style=for-the-badge)
![State](https://img.shields.io/badge/State-Context_API-orange?style=for-the-badge)

</div>

---

## 🚀 Características Principales

<table>
<tr>
<td width="50%">

### ✅ **Tecnologías Core**
```diff
+ ⚛️ React 19.1 - UI moderna
+ 📘 TypeScript - Tipado estático
+ ⚡ Vite - Build ultrarrápido
+ 🧭 React Router 7.9 - Navegación
```

</td>
<td width="50%">

### 🌟 **Características Avanzadas**
```diff
+ 🔐 Autenticación con Context API
+ 🎨 CSS Modules - Estilos aislados
+ 📱 Diseño Responsive
+ 🌐 Axios - Peticiones HTTP
```

</td>
</tr>
</table>

---

## 📋 Instalación

<details>
<summary><b>🚀 Instalación en 3 pasos</b></summary>

### **Paso 1** - Instalar dependencias
```bash
cd frontend
npm install
```

### **Paso 2** - Configurar variables de entorno
```bash
# Asegúrate de que el backend esté corriendo en http://localhost:8000
# O actualiza la URL base en src/services/api.ts
```

### **Paso 3** - Iniciar servidor de desarrollo
```bash
npm run dev
```

La aplicación estará disponible en [`http://localhost:5173`](http://localhost:5173)

</details>

---

## 🏗️ Estructura del Proyecto

```
frontend/
├── src/
│   ├── components/          # Componentes reutilizables
│   │   ├── Footer.tsx       # Pie de página con enlaces
│   │   ├── Navbar.tsx       # Barra de navegación principal
│   │   ├── Layout.tsx       # Layout wrapper (Navbar + Footer)
│   │   ├── Toast.tsx        # Sistema de notificaciones
│   │   ├── noticias/        # Componentes de noticias
│   │   │   ├── NoticiaCard.tsx       # Tarjeta de noticia
│   │   │   └── NoticiaAdmin.tsx      # Panel de administración
│   │   └── formaciones/     # Componentes de formación
│   │       ├── FormacionCard.tsx     # Tarjeta de formación
│   │       ├── FormacionFilters.tsx  # Filtros de formación
│   │       └── EditFormacionModal.tsx # Modal de edición
│   ├── pages/              # Vistas principales
│   │   ├── Home.tsx        # Página de inicio
│   │   ├── Login.tsx       # Página de login
│   │   ├── Noticias.tsx    # Listado de noticias
│   │   ├── NoticiaDetail.tsx # Detalle de noticia
│   │   ├── Formaciones.tsx # Plataforma de formación
│   │   └── Portfolio.tsx   # Gestión de cartera
│   ├── context/            # Gestión de estado global
│   │   ├── AuthContext.tsx # Contexto de autenticación
│   │   └── ToastContext.tsx # Contexto de notificaciones
│   ├── services/           # Servicios API
│   │   ├── api.ts          # Configuración de Axios
│   │   ├── authService.ts  # Servicios de autenticación
│   │   ├── noticiasService.ts # Servicios de noticias
│   │   ├── formacionService.ts # Servicios de formación
│   │   └── portfolioService.ts # Servicios de portfolio
│   ├── constants/          # Constantes de la aplicación
│   ├── App.tsx             # Componente principal
│   └── main.tsx            # Punto de entrada
├── public/                 # Recursos estáticos
└── package.json           # Dependencias del proyecto
```

---

## 📄 Vistas Principales Creadas por David

### 🏠 **Home** (`pages/Home.tsx`)
Página de bienvenida con diseño moderno que presenta:
- **Hero Section**: Logo corporativo y llamada a la acción
- **Sección "Conoce a nuestro equipo"**: Presentación del equipo de Finsmart
- **Sección "Nuestros servicios"**: Descripción de los servicios financieros
- **Diseño responsive** con imágenes y contenido alternado

### 🔐 **Login** (`pages/Login.tsx`)
Sistema de autenticación completo que incluye:
- **Validación en tiempo real** de email y contraseña
- **Manejo de errores** con mensajes descriptivos en español
- **Redirección inteligente** después del login (guarda la página anterior)
- **Estados de carga** durante el proceso de autenticación
- **Integración con AuthContext** para gestión de sesión

### 📰 **Noticias** (`pages/Noticias.tsx`)
Plataforma de noticias financieras con:
- **Listado paginado** con sistema "Cargar más"
- **Filtrado por categorías** (bolsa, criptomonedas, inversiones, tecnología, economía, finanzas)
- **Panel de administración** (solo usuarios autenticados):
  - Crear nuevas noticias
  - Editar noticias existentes
  - Eliminar noticias
  - Paginación de 5 items por página
- **Estados de carga y error** con feedback visual
- **Integración con NoticiaCard** para visualización

### 📰 **Detalle de Noticia** (`pages/NoticiaDetail.tsx`)
Vista individual de cada noticia con:
- **Hero image** con gradientes dinámicos como fallback
- **Metadata completa**: fecha de publicación y autor
- **Contenido formateado** con párrafos separados
- **Navegación rápida** de vuelta al listado
- **Manejo de errores** para noticias no encontradas

### 🎓 **Formaciones** (`pages/Formaciones.tsx`)
Plataforma educativa con:
- **Grid responsive** de tarjetas de formación
- **Sistema de filtrado** por:
  - Tipo de contenido (curso, video, libro, webinar)
  - Nivel (principiante, intermedio, avanzado)
- **CRUD completo** para usuarios autenticados:
  - Crear nueva formación
  - Editar formación existente
  - Eliminar formación
- **Modal de edición** con formulario completo
- **Estados de carga** y mensajes de error descriptivos

### 💼 **Portfolio** (`pages/Portfolio.tsx`)
Sistema de gestión de cartera de inversiones:
- **Dashboard con resumen**:
  - Balance disponible
  - Valor total de la cartera
  - Total invertido
  - Ganancia/Pérdida con indicador visual (verde/rojo)
- **Operaciones de trading**:
  - Comprar nueva posición (modal)
  - Comprar más de una posición existente (modal)
  - Vender parcialmente (modal)
  - Vender toda la posición (confirmación)
- **Tabla detallada** de posiciones:
  - Símbolo y nombre del fondo
  - Número de participaciones
  - Precio de compra vs precio actual
  - Valor actual
  - Ganancia/Pérdida por posición
- **Cálculos en tiempo real** de costos y ganancias
- **Protección de rutas** - redirige al login si no está autenticado
- **Formato de moneda** en euros (EUR)

---

## 🧩 Componentes Principales Creados por David

### 📦 **Layout Components**

#### **Navbar** (`components/Navbar.tsx`)
Barra de navegación principal con:
- **Enlaces principales**: Mi cartera, Formación, Noticias
- **Botón de autenticación** dinámico (Login/Logout)
- **Redirección inteligente** al login con URL de retorno
- **Integración con AuthContext** para estado de autenticación
- **Toast notification** al cerrar sesión

#### **Footer** (`components/Footer.tsx`)
Pie de página corporativo con:
- **Tres columnas de enlaces**:
  - Nuestra Empresa (Conocenos, Aviso, Contacto)
  - Herramientas (Calculadora, Bolsa, Portfolio)
  - Otros (Formación, Noticias)
- **Información legal** completa de Finsmart S.L.
- **Diseño responsive** con CSS Modules

#### **Layout** (`components/Layout.tsx`)
Wrapper de aplicación que:
- **Encapsula** Navbar + contenido + Footer
- **Proporciona estructura consistente** en todas las páginas
- **Simplifica** el código de las vistas

#### **Toast** (`components/Toast.tsx`)
Sistema de notificaciones que:
- **Muestra mensajes** temporales al usuario
- **Integrado con ToastContext** para uso global
- **Animaciones suaves** de entrada/salida
- **Auto-cierre** configurable

### 📰 **Componentes de Noticias**

#### **NoticiaCard** (`components/noticias/NoticiaCard.tsx`)
Tarjeta de noticia con:
- **Imagen o gradiente** dinámico como fallback
- **Pill de categoría** con color específico
- **Metadata**: fecha formateada y autor
- **Extracto del contenido** con líneas limitadas
- **Botón "Leer noticia"** con navegación a detalle
- **Manejo de errores de imagen** automático

#### **NoticiaAdmin** (`components/noticias/NoticiaAdmin.tsx`)
Panel de administración completo con:
- **Botones de acción**: "Crear Nueva Noticia" y "Editar/Eliminar"
- **Formulario de creación/edición** con todos los campos:
  - Título
  - Contenido (textarea grande)
  - Autor
  - Categoría (select con opciones predefinidas)
  - Fecha de publicación
  - URL de imagen
- **Lista de noticias existentes** con paginación (5 por página)
- **Operaciones CRUD**:
  - Crear con validación de campos obligatorios
  - Editar cargando datos en formulario
  - Eliminar con confirmación
- **Estados de submitting** para prevenir duplicados
- **Integración con ToastContext** para feedback

### 🎓 **Componentes de Formación**

#### **FormacionCard** (`components/formaciones/FormacionCard.tsx`)
Tarjeta de formación con:
- **Badges** de tipo y nivel con colores específicos:
  - Tipos: curso, video, libro, webinar
  - Niveles: principiante, intermedio, avanzado
- **Metadata**:
  - Título y descripción
  - Instructor
  - Duración en horas
- **Botón de acción** para ver contenido (si tiene URL)
- **Botones de administración** (solo para usuarios autenticados):
  - Editar formación
  - Eliminar formación

#### **FormacionFilters** (`components/formaciones/FormacionFilters.tsx`)
Sistema de filtrado interactivo:
- **Filtro por tipo**: curso, video, libro, webinar
- **Filtro por nivel**: principiante, intermedio, avanzado
- **Toggle de filtros** (clic para activar/desactivar)
- **Botón "Limpiar filtros"** visible cuando hay filtros activos
- **Estilos dinámicos** para filtros activos

#### **EditFormacionModal** (`components/formaciones/EditFormacionModal.tsx`)
Modal de edición con:
- **Formulario completo** con todos los campos de formación
- **Modo creación y edición** en el mismo componente
- **Validación de campos** obligatorios
- **Estados de loading** durante el guardado
- **Cierre con backdrop** o botón de cancelar

---

## 🎨 Gestión de Estado

### **AuthContext** (`context/AuthContext.tsx`)
Contexto global de autenticación que proporciona:
- **Estado de autenticación**: `isAuthenticated`, `user`, `token`
- **Funciones**:
  - `login(email, password)`: Inicia sesión y guarda token
  - `logout()`: Cierra sesión y limpia datos
  - `checkAuth()`: Verifica token almacenado al cargar la app
- **Persistencia**: Token guardado en localStorage
- **Configuración automática**: Añade token a headers de Axios

### **ToastContext** (`context/ToastContext.tsx`)
Contexto para notificaciones que proporciona:
- **Estado**: `message`, `visible`
- **Función**: `showToast(message, duration)`
- **Auto-cierre**: Configurable por mensaje
- **Usado en toda la aplicación** para feedback del usuario

---

## 🔧 Servicios API

### **api.ts**
Configuración base de Axios:
- **Base URL**: `http://localhost:8000/api`
- **Headers**: Content-Type application/json
- **Timeout**: 10 segundos
- **Interceptors**: Manejo de errores global

### **authService.ts**
- `login(email, password)`: Autenticación de usuario
- `logout()`: Cierre de sesión
- `getCurrentUser()`: Obtener usuario actual

### **noticiasService.ts**
- `getNoticias(params)`: Listar noticias con paginación y filtros
- `getNoticia(id)`: Obtener noticia específica
- `createNoticia(data)`: Crear nueva noticia
- `updateNoticia(id, data)`: Actualizar noticia
- `deleteNoticia(id)`: Eliminar noticia

### **formacionService.ts**
- `getFormaciones(filters)`: Listar formaciones con filtros
- `createFormacion(data)`: Crear nueva formación
- `updateFormacion(id, data)`: Actualizar formación
- `deleteFormacion(id)`: Eliminar formación

### **portfolioService.ts**
- `getPortfolio()`: Obtener resumen de cartera
- `buyNew(data)`: Comprar nueva posición
- `buySell(id, data)`: Comprar más o vender
- `sellAll(id)`: Vender toda la posición

---

## 🎨 Estilos y CSS

### **Arquitectura de Estilos**
- **CSS Modules**: Cada componente tiene su propio archivo `.module.css`
- **Encapsulación**: Los estilos no se filtran entre componentes
- **Nombres únicos**: Los class names se generan automáticamente
- **Responsive**: Media queries para móvil, tablet y desktop

### **Paleta de Colores**
- **Primario**: Azul corporativo para acciones principales
- **Secundario**: Verde para éxito, Rojo para errores
- **Neutros**: Escala de grises para textos y fondos
- **Categorías**: Cada categoría de noticia tiene su color único

---

## 📦 Comandos Disponibles

```bash
# Desarrollo
npm run dev          # Inicia servidor de desarrollo (puerto 5173)

# Producción
npm run build        # Compila TypeScript y genera build optimizado
npm run preview      # Previsualiza el build de producción

# Calidad de código
npm run lint         # Ejecuta ESLint para detectar problemas
```

---

## 🔍 Características Técnicas Destacadas

### **TypeScript**
- **Tipado estricto** en toda la aplicación
- **Interfaces** definidas para todos los modelos de datos
- **Type safety** en props de componentes
- **Autocompletado** mejorado en el IDE

### **React Router**
- **Navegación declarativa** con `<Link>` y `<Navigate>`
- **Parámetros de URL** para vistas dinámicas
- **Search params** para redirecciones y filtros
- **Protección de rutas** con verificación de autenticación

### **Axios**
- **Interceptores** para manejo de errores
- **Configuración centralizada** de headers
- **Cancelación** de peticiones cuando sea necesario
- **Transformación** automática de datos

### **Optimización**
- **Code splitting** con Vite
- **Lazy loading** de componentes
- **Tree shaking** automático
- **Build optimizado** para producción

---

## 🧪 Mejores Prácticas Implementadas

1. **Separación de responsabilidades**: Componentes, servicios y contextos separados
2. **Reutilización**: Componentes modulares y reutilizables
3. **Manejo de estados**: Loading, error y success states en todas las vistas
4. **Feedback del usuario**: Toasts, mensajes de error y confirmaciones
5. **Validación**: Validación de formularios en tiempo real
6. **Accesibilidad**: Atributos ARIA y semántica HTML correcta
7. **Responsive**: Diseño adaptable a todos los tamaños de pantalla
8. **Seguridad**: Tokens en localStorage, rutas protegidas

---

<div align="center">

## 👨‍💻 **Desarrollado por David**

> *Este frontend representa una implementación moderna y completa de una aplicación React
> con TypeScript, demostrando las mejores prácticas de desarrollo web actual.*

![Made with React](https://img.shields.io/badge/Made%20with-React-61DAFB?style=for-the-badge&logo=react)
![EBIS](https://img.shields.io/badge/Master-EBIS%20Full%20Stack-blue?style=for-the-badge)
![TypeScript](https://img.shields.io/badge/Powered%20by-TypeScript-3178C6?style=for-the-badge&logo=typescript)

### 🌟 **¡Gracias por explorar el Frontend de Finsmart!**

</div>
