<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finsmart API - Plataforma Empresarial</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🪙</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                        'mono': ['SF Mono', 'Monaco', 'monospace']
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                🪙 Finsmart API
            </h1>
            <p class="text-xl text-gray-700 mb-2">
                Plataforma financiera completa - Master EBIS Full Stack Developer
            </p>
            <p class="text-gray-500">
                Gestión integral con finanzas, noticias, empleados y contacto
            </p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <!-- Credentials Section -->
            <div class="p-6 mb-6 bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl border-l-4 border-amber-500">
                <h4 class="text-lg font-semibold text-amber-800 mb-4 flex items-center">
                    <span class="mr-2">🔑</span>
                    Credenciales de prueba
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                        <span class="font-medium text-amber-800 w-20">Email:</span>
                        <span
                            class="font-mono text-sm text-gray-800 bg-gray-100 px-2 py-1 rounded">test@example.com</span>
                    </div>
                    <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                        <span class="font-medium text-amber-800 w-20">Password:</span>
                        <span class="font-mono text-sm text-gray-800 bg-gray-100 px-2 py-1 rounded">password123</span>
                    </div>
                </div>
            </div>

            <!-- Authentication Section -->
            <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-500">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center cursor-pointer hover:text-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg p-2 -m-2"
                    onclick="toggleSection('auth')" tabindex="0"
                    onkeypress="if(event.key==='Enter') toggleSection('auth')">
                    <span class="mr-2">🔐</span>
                    Autenticación
                    <svg id="auth-arrow"
                        class="ml-auto w-5 h-5 text-gray-600 transform transition-all duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </h3>
                <div id="auth-content"
                    class="space-y-3 overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <span class="font-mono text-sm text-gray-800">POST /api/login</span>
                        <span class="text-sm text-gray-500">Iniciar sesión</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <span class="font-mono text-sm text-gray-800">POST /api/logout</span>
                        <span class="text-sm text-gray-500">Cerrar sesión</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <span class="font-mono text-sm text-gray-800">GET /api/user</span>
                        <span class="text-sm text-gray-500">Usuario autenticado</span>
                    </div>
                </div>
            </div>

            <!-- Noticias Section -->
            <div class="mb-8 p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border-l-4 border-green-500">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center cursor-pointer hover:text-green-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded-lg p-2 -m-2"
                    onclick="toggleSection('noticias')" tabindex="0"
                    onkeypress="if(event.key==='Enter') toggleSection('noticias')">
                    <span class="mr-2">📰</span>
                    Noticias
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-500 text-white rounded-full">
                        Implementado
                    </span>
                    <svg id="noticias-arrow"
                        class="ml-auto w-5 h-5 text-gray-600 transform transition-all duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </h3>
                <div id="noticias-content"
                    class="space-y-3 overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                            <span class="font-mono text-sm text-gray-800">/api/noticias</span>
                        </div>
                        <span class="text-sm text-gray-500">Con paginación</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded mr-3">POST</span>
                            <span class="font-mono text-sm text-gray-800">/api/noticias</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                            <span class="font-mono text-sm text-gray-800">/api/noticias/{id}</span>
                        </div>
                        <span class="text-sm text-gray-500">Ver específica</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded mr-3">PUT</span>
                            <span class="font-mono text-sm text-gray-800">/api/noticias/{id}</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-red-500 text-white rounded mr-3">DEL</span>
                            <span class="font-mono text-sm text-gray-800">/api/noticias/{id}</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                    </div>
                </div>
            </div>

            <!-- Empleados Section -->
            <div class="mb-8 p-6 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl border-l-4 border-indigo-500">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center cursor-pointer hover:text-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg p-2 -m-2"
                    onclick="toggleSection('empleados')" tabindex="0"
                    onkeypress="if(event.key==='Enter') toggleSection('empleados')">
                    <span class="mr-2">👥</span>
                    Empleados
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-500 text-white rounded-full">
                        Implementado
                    </span>
                    <svg id="empleados-arrow"
                        class="ml-auto w-5 h-5 text-gray-600 transform transition-all duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </h3>
                <div id="empleados-content"
                    class="space-y-3 overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                            <span class="font-mono text-sm text-gray-800">/api/empleados</span>
                        </div>
                        <span class="text-sm text-gray-500">Listar todos</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded mr-3">POST</span>
                            <span class="font-mono text-sm text-gray-800">/api/empleados</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                            <span class="font-mono text-sm text-gray-800">/api/empleados/{id}</span>
                        </div>
                        <span class="text-sm text-gray-500">Ver específico</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded mr-3">PUT</span>
                            <span class="font-mono text-sm text-gray-800">/api/empleados/{id}</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs font-medium bg-red-500 text-white rounded mr-3">DEL</span>
                            <span class="font-mono text-sm text-gray-800">/api/empleados/{id}</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                    </div>
                </div>
            </div>

            <!-- Calculadora Ahorros Section -->
            <div
                class="mb-8 p-6 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl border-l-4 border-emerald-500">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center cursor-pointer hover:text-emerald-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 rounded-lg p-2 -m-2"
                    onclick="toggleSection('calculadora')" tabindex="0"
                    onkeypress="if(event.key==='Enter') toggleSection('calculadora')">
                    <span class="mr-2">💰</span>
                    Calculadora de Ahorros
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-500 text-white rounded-full">
                        Implementado
                    </span>
                    <svg id="calculadora-arrow"
                        class="ml-auto w-5 h-5 text-gray-600 transform transition-all duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </h3>
                <div id="calculadora-content"
                    class="overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                    <div class="mb-4 p-3 bg-emerald-100 rounded-lg">
                        <p class="text-sm text-emerald-800">
                            <strong>Método 50/30/20:</strong> Gestión automática de finanzas personales
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/calculadora-ahorros</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/calculadora-ahorros/{id}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded mr-3">PUT</span>
                                <span class="font-mono text-sm text-gray-800">/api/calculadora-ahorros/{id}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-red-500 text-white rounded mr-3">DEL</span>
                                <span class="font-mono text-sm text-gray-800">/api/calculadora-ahorros/{id}</span>
                            </div>
                            <span class="text-sm text-gray-500">Resetear</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensajes de Contacto Section -->
            <div class="mb-8 p-6 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl border-l-4 border-orange-500">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center cursor-pointer hover:text-orange-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 rounded-lg p-2 -m-2"
                    onclick="toggleSection('mensajes')" tabindex="0"
                    onkeypress="if(event.key==='Enter') toggleSection('mensajes')">
                    <span class="mr-2">✉️</span>
                    Mensajes de Contacto
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-500 text-white rounded-full">
                        Implementado
                    </span>
                    <svg id="mensajes-arrow"
                        class="ml-auto w-5 h-5 text-gray-600 transform transition-all duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </h3>
                <div id="mensajes-content"
                    class="overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                    <div class="mb-4 p-3 bg-orange-100 rounded-lg">
                        <p class="text-sm text-orange-800">
                            <strong>Formulario web:</strong> Solo POST público para recibir mensajes, resto requiere
                            autenticación
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/mensajes-contacto</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded mr-3">POST</span>
                                <span class="font-mono text-sm text-gray-800">/api/mensajes-contacto</span>
                            </div>
                            <span class="text-sm text-gray-500">Enviar mensaje</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/mensajes-contacto/{id}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded mr-3">PUT</span>
                                <span class="font-mono text-sm text-gray-800">/api/mensajes-contacto/{id}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-red-500 text-white rounded mr-3">DEL</span>
                                <span class="font-mono text-sm text-gray-800">/api/mensajes-contacto/{id}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formación Section -->
            <div class="mb-8 p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl border-l-4 border-purple-500">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center cursor-pointer hover:text-purple-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 rounded-lg p-2 -m-2"
                    onclick="toggleSection('formacion')" tabindex="0"
                    onkeypress="if(event.key==='Enter') toggleSection('formacion')">
                    <span class="mr-2">🎓</span>
                    Formación
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-500 text-white rounded-full">
                        Implementado
                    </span>
                    <svg id="formacion-arrow"
                        class="ml-auto w-5 h-5 text-gray-600 transform transition-all duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </h3>
                <div id="formacion-content"
                    class="overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                    <div class="mb-4 p-3 bg-purple-100 rounded-lg">
                        <p class="text-sm text-purple-800">
                            <strong>Contenido educativo:</strong> Cursos, videos, libros y webinars financieros con mock
                            de libros en storage
                        </p>
                        <p class="text-xs text-purple-700 mt-2">
                            Tipos: curso, video, libro, webinar | Niveles: principiante, intermedio, avanzado
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/formaciones</span>
                            </div>
                            <span class="text-sm text-gray-500">Con filtros: tipo, categoria, nivel</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded mr-3">POST</span>
                                <span class="font-mono text-sm text-gray-800">/api/formaciones</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/formaciones/{id}</span>
                            </div>
                            <span class="text-sm text-gray-500">Ver específico</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded mr-3">PUT</span>
                                <span class="font-mono text-sm text-gray-800">/api/formaciones/{id}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-red-500 text-white rounded mr-3">DEL</span>
                                <span class="font-mono text-sm text-gray-800">/api/formaciones/{id}</span>
                            </div>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Portfolio Section -->
            <div class="mb-8 p-6 bg-gradient-to-r from-teal-50 to-teal-100 rounded-xl border-l-4 border-teal-500">
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center cursor-pointer hover:text-teal-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 rounded-lg p-2 -m-2"
                    onclick="toggleSection('portfolio')" tabindex="0"
                    onkeypress="if(event.key==='Enter') toggleSection('portfolio')">
                    <span class="mr-2">📊</span>
                    Portfolio
                    <span class="ml-2 px-2 py-1 text-xs font-medium bg-green-500 text-white rounded-full">
                        Implementado
                    </span>
                    <svg id="portfolio-arrow"
                        class="ml-auto w-5 h-5 text-gray-600 transform transition-all duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                    </svg>
                </h3>
                <div id="portfolio-content"
                    class="overflow-hidden transition-all duration-500 ease-in-out max-h-0 opacity-0">
                    <div class="mb-4 p-3 bg-teal-100 rounded-lg">
                        <p class="text-sm text-teal-800">
                            <strong>Plataforma de inversión:</strong> Gestión de portafolio de fondos índice con
                            valoración dinámica
                        </p>
                        <p class="text-xs text-teal-700 mt-2">
                            Balance inicial: $10,000 | Operaciones: Comprar, Vender, Consultar | Cálculo automático de
                            P&L
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/portfolios</span>
                            </div>
                            <span class="text-sm text-gray-500">Resumen completo + balance</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded mr-3">POST</span>
                                <span class="font-mono text-sm text-gray-800">/api/portfolios</span>
                            </div>
                            <span class="text-sm text-gray-500">Comprar posición inicial</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-500 text-white rounded mr-3">GET</span>
                                <span class="font-mono text-sm text-gray-800">/api/portfolios/{id}</span>
                            </div>
                            <span class="text-sm text-gray-500">Ver posición específica</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded mr-3">PUT</span>
                                <span class="font-mono text-sm text-gray-800">/api/portfolios/{id}</span>
                            </div>
                            <span class="text-sm text-gray-500">Comprar más / Vender parte</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-red-500 text-white rounded mr-3">DEL</span>
                                <span class="font-mono text-sm text-gray-800">/api/portfolios/{id}</span>
                            </div>
                            <span class="text-sm text-gray-500">Vender toda la posición</span>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">🔒 Auth</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="/api/documentation" target="_blank"
                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                <span class="mr-2">📖</span>
                Ver Documentación Swagger
            </a>
            <a href="https://github.com/LD-Solutions/proyecto-ebis-modulo2" target="_blank"
                class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                <span class="mr-2">💻</span>
                Ver en GitHub
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-600">
            <p class="mb-2">
                🎓 Desarrollado para el <strong>Master EBIS Full Stack Developer</strong>
            </p>
            <p class="text-sm">
                Powered by
                <a href="https://laravel.com" class="text-blue-600 hover:text-blue-800 underline">Laravel</a>
                &
                <a href="https://laravel.com/docs/sanctum"
                    class="text-blue-600 hover:text-blue-800 underline">Sanctum</a>
            </p>
        </div>
    </div>

    <script>
        function toggleSection(sectionId) {
            const content = document.getElementById(sectionId + '-content');
            const arrow = document.getElementById(sectionId + '-arrow');

            const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

            if (!isOpen) {
                // Opening animation
                content.style.maxHeight = content.scrollHeight + 'px';
                content.style.opacity = '1';
                arrow.style.transform = 'rotate(180deg)';

                // Add staggered animation to children
                const children = content.querySelectorAll('.bg-white');
                children.forEach((child, index) => {
                    child.style.animationDelay = `${index * 50}ms`;
                    child.classList.add('animate-slideIn');
                });
            } else {
                // Closing animation
                content.style.maxHeight = '0px';
                content.style.opacity = '0';
                arrow.style.transform = 'rotate(0deg)';

                // Remove staggered animation classes
                const children = content.querySelectorAll('.bg-white');
                children.forEach(child => {
                    child.classList.remove('animate-slideIn');
                    child.style.animationDelay = '';
                });
            }
        }

        // Add custom CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animate-slideIn {
                animation: slideIn 0.3s ease-out forwards;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>