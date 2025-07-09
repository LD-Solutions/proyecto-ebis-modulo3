<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API de Finsmart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #374151;
            line-height: 1.6;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .header h1 {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 1.1rem;
            color: #6b7280;
        }
        
        .api-info {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        
        .endpoint {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 6px;
            border-left: 4px solid #3b82f6;
        }
        
        .endpoint h3 {
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .endpoint-list {
            margin: 0;
            padding-left: 1.5rem;
        }
        
        .endpoint-list li {
            margin-bottom: 0.25rem;
            font-family: monospace;
            font-size: 0.9rem;
        }
        
        .credentials {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1.5rem;
        }
        
        .credentials h4 {
            color: #92400e;
            margin-bottom: 0.5rem;
        }
        
        .credentials p {
            color: #92400e;
            margin: 0.25rem 0;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>API de Finsmart</h1>
            <p>Acceso a endpoints REST para gestión de Finsmart</p>
        </div>
        
        <div class="api-info">
            <div class="endpoint">
                <h3>Autenticación</h3>
                <ul class="endpoint-list">
                    <li>POST /api/login - Iniciar sesión</li>
                    <li>POST /api/logout - Cerrar sesión</li>
                    <li>GET /api/user - Usuario autenticado</li>
                </ul>
            </div>
            
            <div class="endpoint">
                <h3>Noticias</h3>
                <ul class="endpoint-list">
                    <li>GET /api/noticias - Listar noticias</li>
                    <li>POST /api/noticias - Crear noticia</li>
                    <li>GET /api/noticias/{id} - Ver noticia</li>
                    <li>PUT /api/noticias/{id} - Actualizar noticia</li>
                    <li>DELETE /api/noticias/{id} - Eliminar noticia</li>
                </ul>
            </div>
            
            <div class="credentials">
                <h4>Credenciales de prueba</h4>
                <p>Email: test@example.com</p>
                <p>Password: password123</p>
            </div>
        </div>
    </div>
</body>
</html>