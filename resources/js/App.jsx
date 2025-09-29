import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

function App() {
    return (
        <Router>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
                <div className="container mx-auto px-4 py-8">
                    <Routes>
                        <Route path="/" element={<Home />} />
                        <Route path="*" element={<NotFound />} />
                    </Routes>
                </div>
            </div>
        </Router>
    );
}

function Home() {
    return (
        <div className="max-w-4xl mx-auto">
            <div className="text-center mb-12">
                <h1 className="text-5xl font-bold text-gray-900 mb-4">
                    🪙 Finsmart API
                </h1>
                <p className="text-xl text-gray-700 mb-2">
                    React Frontend - Master EBIS Module 3
                </p>
                <p className="text-gray-500">
                    ¡Aplicación React funcionando correctamente!
                </p>
            </div>

            <div className="bg-white rounded-2xl shadow-xl p-8">
                <h2 className="text-2xl font-semibold text-gray-800 mb-4">
                    🚀 Setup Completo
                </h2>
                <ul className="space-y-2 text-gray-600">
                    <li className="flex items-center">
                        <span className="text-green-500 mr-2">✓</span>
                        React 19 instalado y funcionando
                    </li>
                    <li className="flex items-center">
                        <span className="text-green-500 mr-2">✓</span>
                        React Router configurado
                    </li>
                    <li className="flex items-center">
                        <span className="text-green-500 mr-2">✓</span>
                        Vite + Laravel integración activa
                    </li>
                    <li className="flex items-center">
                        <span className="text-green-500 mr-2">✓</span>
                        Tailwind CSS funcionando
                    </li>
                    <li className="flex items-center">
                        <span className="text-blue-500 mr-2">⏳</span>
                        Próximo: Sistema de autenticación
                    </li>
                </ul>
            </div>
        </div>
    );
}

function NotFound() {
    return (
        <div className="text-center">
            <h1 className="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <p className="text-xl text-gray-600">Página no encontrada</p>
        </div>
    );
}

export default App;