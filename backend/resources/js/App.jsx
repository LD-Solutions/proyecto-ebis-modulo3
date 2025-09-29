import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

function App() {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="*" element={<NotFound />} />
            </Routes>
        </Router>
    );
}

function Home() {
    return (
        <div className="min-h-screen bg-[#f9f9f9] font-['IBM_Plex_Sans_Condensed',sans-serif]">
            {/* Header with Hero */}
            <header
                className="min-h-screen bg-cover bg-center relative"
                style={{
                    backgroundImage: `linear-gradient(38deg, rgba(36,51,81,0.85) 10%, rgba(187,167,234,0.85) 90%), url('/assets/images/city.gif')`
                }}
            >
                {/* Navigation Bar */}
                <nav className="bg-[#f9f9f9] text-[#243351] flex items-center justify-between h-[10vh] px-8 shadow-lg">
                    <h2 className="text-2xl font-semibold">
                        <a href="/" className="text-[#243351] hover:text-[#bba7ea] transition-all duration-300">
                            Finsmart
                        </a>
                    </h2>
                    <ul className="flex gap-8">
                        <li>
                            <a href="#" className="text-[#243351] hover:text-[#bba7ea] transition-all duration-300">
                                Mi cartera
                            </a>
                        </li>
                        <li>
                            <a href="#" className="text-[#243351] hover:text-[#bba7ea] transition-all duration-300">
                                Estado de la bolsa
                            </a>
                        </li>
                        <li>
                            <a href="#" className="text-[#243351] hover:text-[#bba7ea] transition-all duration-300">
                                Conócenos
                            </a>
                        </li>
                    </ul>
                </nav>

                {/* Hero Section */}
                <section className="flex items-center justify-center flex-col gap-20 h-[90vh]">
                    <img
                        src="/assets/icons/logo.jpg"
                        alt="Finsmart Logo"
                        className="w-[20vw] md:w-[20vw] sm:w-[35vw] rounded-full border-[3px] border-white shadow-lg"
                    />
                    <a
                        href="#main"
                        className="no-underline text-lg font-medium text-white bg-[#243351] px-6 py-3 rounded-lg border border-transparent text-center transition-all duration-300 shadow-md hover:bg-white hover:text-[#243351] hover:border-[#243351] hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0 active:shadow-sm"
                    >
                        <span className="block">DESCUBRE NUESTRAS</span>
                        <span className="block">HERRAMIENTAS</span>
                        <span className="block mt-2 text-2xl">&darr;</span>
                    </a>
                </section>
            </header>

            {/* Main Content */}
            <main id="main">
                {/* Section 1: Team */}
                <section className="py-16 px-8 bg-[#f9f9f9]">
                    <div className="grid md:grid-cols-2 gap-12 items-center max-w-[1200px] mx-auto">
                        <div className="relative overflow-hidden rounded-lg shadow-xl">
                            <img
                                src="/assets/images/oficina2.webp"
                                alt="Equipo de Finsmart"
                                className="w-full h-auto block transition-transform duration-500 hover:scale-105"
                            />
                        </div>

                        <div className="flex flex-col gap-6">
                            <h2 className="text-4xl font-semibold text-[#243351] mb-2">
                                Conoce a nuestro equipo
                            </h2>
                            <h3 className="text-xl text-[rgba(36,51,81,0.85)] mb-4">
                                Expertos en finanzas a tu servicio
                            </h3>
                            <p className="text-base leading-relaxed text-[#444] mb-2">
                                En Finsmart contamos con un equipo de profesionales con amplia experiencia en el sector financiero. Cada miembro aporta conocimientos únicos y especializados para ayudarte a alcanzar tus metas de inversión y ahorro.
                            </p>
                            <p className="text-base leading-relaxed text-[#444] mb-2">
                                Nuestros asesores financieros, analistas de mercado y expertos en tecnología trabajan juntos para ofrecerte las mejores herramientas y consejos personalizados para tu situación financiera particular.
                            </p>
                            <a
                                href="#"
                                className="self-start no-underline text-lg font-medium text-white bg-[#243351] px-6 py-3 rounded-lg border border-transparent text-center transition-all duration-300 shadow-md mt-4 hover:bg-white hover:text-[#243351] hover:border-[#243351] hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0 active:shadow-sm"
                            >
                                Conoce al equipo
                            </a>
                        </div>
                    </div>
                </section>

                {/* Section 2: Services (Reversed) */}
                <section className="py-16 px-8 bg-[rgba(187,167,234,0.1)]">
                    <div className="grid md:grid-cols-2 gap-12 items-center max-w-[1200px] mx-auto">
                        <div className="relative overflow-hidden rounded-lg shadow-xl md:order-2">
                            <img
                                src="/assets/images/oficina1.webp"
                                alt="Servicios de inversión"
                                className="w-full h-auto block transition-transform duration-500 hover:scale-105"
                            />
                        </div>

                        <div className="flex flex-col gap-6 md:order-1">
                            <h2 className="text-4xl font-semibold text-[#243351] mb-2">
                                Nuestros servicios
                            </h2>
                            <h3 className="text-xl text-[rgba(36,51,81,0.85)] mb-4">
                                Soluciones financieras personalizadas
                            </h3>
                            <p className="text-base leading-relaxed text-[#444] mb-2">
                                Ofrecemos una amplia gama de servicios financieros diseñados para satisfacer tus necesidades específicas. Desde asesoramiento en inversiones hasta planificación de jubilación, nuestro objetivo es ayudarte a alcanzar tus metas financieras.
                            </p>
                            <p className="text-base leading-relaxed text-[#444] mb-2">
                                Nuestros expertos analizan tu situación actual y te ofrecen estrategias claras y efectivas para maximizar tus ahorros y optimizar tu cartera de inversiones.
                            </p>
                            <a
                                href="#"
                                className="self-start no-underline text-lg font-medium text-white bg-[#243351] px-6 py-3 rounded-lg border border-transparent text-center transition-all duration-300 shadow-md mt-4 hover:bg-white hover:text-[#243351] hover:border-[#243351] hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0 active:shadow-sm"
                            >
                                Ver servicios
                            </a>
                        </div>
                    </div>
                </section>
            </main>

            {/* Footer */}
            <footer className="p-8 bg-[#243351] text-[#a8a8a8] text-sm">
                <section className="grid md:grid-cols-3 gap-8 mb-8">
                    <div className="flex flex-col gap-1">
                        <h3 className="font-bold text-white mb-2">Nuestra Empresa</h3>
                        <ul className="flex flex-col gap-1">
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Conocenos
                                </a>
                            </li>
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Aviso
                                </a>
                            </li>
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Contacto
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div className="flex flex-col gap-1">
                        <h3 className="font-bold text-white mb-2">Herramientas</h3>
                        <ul className="flex flex-col gap-1">
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Calculadora de ahorro
                                </a>
                            </li>
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Estado de la bolsa
                                </a>
                            </li>
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Consulta tu portfolio
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div className="flex flex-col gap-1">
                        <h3 className="font-bold text-white mb-2">Otros</h3>
                        <ul className="flex flex-col gap-1">
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Fórmate con nosotros
                                </a>
                            </li>
                            <li>
                                <a href="#" className="text-[#a8a8a8] hover:text-white transition-all duration-300">
                                    Ponte al día de las noticias
                                </a>
                            </li>
                        </ul>
                    </div>
                </section>

                <section className="flex flex-col gap-4 mt-8 border-t border-[#444] pt-8">
                    <h2 className="font-bold text-white text-lg">Finsmart</h2>
                    <p>&copy; 2025 Finsmart S.L.</p>
                    <p>
                        Finsmart S.L. está autorizada por la Banco de España en la España y por el Banco Central Europeo,
                        y está regulada por la Comisión Nacional del Mercado de Valores en lo que respecta a las normas de conducta empresarial.
                    </p>
                    <p>
                        Domicilio social: Calle de la Vida, 42, Madrid, 28001, España, número de registro B-12345678.
                    </p>
                    <p>Finsmart S.L. es una sociedad limitada.</p>
                    <p>
                        Finsmart S.L. ha establecido una sucursal en España, con número de registro en la Banco de España B-98765432,
                        inscrita en el Registro Mercantil de Madrid al Tomo 45678, Libro 0, Folio 2, Sección 9, Hoja M987654,
                        Inscripción 2 y con domicilio en Calle de la Fama, 10, 28001, Madrid.
                    </p>
                    <p>
                        Finsmart S.L. ha sido fundada por el visionario y empresario Bruce Wayne, quien ha invertido en la empresa
                        una fortuna comparable a la de Tony Stark. La dirección de la sucursal en Madrid es un edificio de oficinas
                        diseñado por el arquitecto Gustavo Fring, famoso por su estilo minimalista y funcional.
                    </p>
                    <p>
                        En cuanto a los registros, Finsmart S.L. tiene un número de registro en el Registro Mercantil de Madrid
                        que es similar al número de registro de la película La lista de Schindler, y su sucursal en Madrid está
                        ubicada en una calle que recuerda a la famosa Calle de la Sombra de la película El Padrino.
                    </p>
                </section>
            </footer>
        </div>
    );
}

function NotFound() {
    return (
        <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
            <div className="text-center">
                <h1 className="text-6xl font-bold text-gray-900 mb-4">404</h1>
                <p className="text-xl text-gray-600">Página no encontrada</p>
            </div>
        </div>
    );
}

export default App;