import React from 'react';

const Home: React.FC = () => {
    return (
        <>
            {/*----------NAVEGACIÓN Y CABECERA----------*/}
            <header className="cabecera index">
                <nav className="barra-navegacion">
                    <h2>
                        <a href="index.html">Finsmart</a>
                    </h2>
                    <ul>
                        <li>
                            <a href="views/dashboard.html">Mi cartera</a>
                        </li>
                        <li>
                            <a href="views/bolsa.html">Estado de la bolsa</a>
                        </li>
                        <li>
                            <a href="views/conocenos.html">Conócenos</a>
                        </li>
                    </ul>
                </nav>
                <section className="hero">
                    <img src="/assets/icons/logo.jpg" alt="" />
                    <a className="hero__cta" href="#main">
                        <span>DESCUBRE NUESTRAS <br /> HERRAMIENTAS</span>
                        <br />
                        <span>&darr;</span>
                    </a>
                </section>
            </header>

            {/*----------CUERPO----------*/}
            <main id="main">
                {/* Ejemplo: Sección sobre el equipo */}
                <section className="dual-section">
                    <div className="dual-section__container">
                        <div className="dual-section__media">
                            <img src="/assets/images/oficina2.webp" alt="Equipo de Finsmart" className="dual-section__image" />
                        </div>
                        
                        <div className="dual-section__content">
                            <h2 className="dual-section__title">Conoce a nuestro equipo</h2>
                            <h3 className="dual-section__subtitle">Expertos en finanzas a tu servicio</h3>
                            <p className="dual-section__text">
                                En Finsmart contamos con un equipo de profesionales con amplia experiencia en el sector financiero. Cada miembro aporta conocimientos únicos y especializados para ayudarte a alcanzar tus metas de inversión y ahorro.
                            </p>
                            <p className="dual-section__text">
                                Nuestros asesores financieros, analistas de mercado y expertos en tecnología trabajan juntos para ofrecerte las mejores herramientas y consejos personalizados para tu situación financiera particular.
                            </p>
                            <a href="views/conocenos.html" className="dual-section__cta">Conoce al equipo</a>
                        </div>
                    </div>
                </section>

                {/* Ejemplo: Sección sobre servicios (imagen a la derecha) */}
                <section className="dual-section dual-section--alt">
                    <div className="dual-section__container dual-section__container--reverse">
                        <div className="dual-section__media">
                            <img src="/assets/images/oficina1.webp" alt="Servicios de inversión" className="dual-section__image" />
                        </div>
                        
                        <div className="dual-section__content">
                            <h2 className="dual-section__title">Nuestros servicios</h2>
                            <h3 className="dual-section__subtitle">Soluciones financieras personalizadas</h3>
                            <p className="dual-section__text">
                                Ofrecemos una amplia gama de servicios financieros diseñados para satisfacer tus necesidades específicas. Desde asesoramiento en inversiones hasta planificación de jubilación, nuestro objetivo es ayudarte a alcanzar tus metas financieras.
                            </p>
                            <p className="dual-section__text">
                                Nuestros expertos analizan tu situación actual y te ofrecen estrategias claras y efectivas para maximizar tus ahorros y optimizar tu cartera de inversiones.
                            </p>
                            <a href="views/bolsa.html" className="dual-section__cta">Ver servicios</a>
                        </div>
                    </div>
                </section>
            </main>

            {/*----------PIÉ DE PÁGINA----------*/}
            <footer className="pie-pagina">
                <section className="col3">
                    <div className="columna">
                        <h3><strong>Nuestra Empresa</strong></h3>
                        <ol>
                            <li>
                                <a href="views/conocenos.html">Conocenos</a>
                            </li>
                            <li>
                                <a href="views/aviso.html">Aviso</a>
                            </li>
                            <li>
                                <a href="views/contacto.html">Contacto</a>
                            </li>
                        </ol>
                    </div> 
                    <div className="columna">
                        <h3><strong>Herramientas</strong></h3>
                        <ol>
                            <li>
                                <a href="views/ahorro.html">Calculadora de ahorro</a>
                            </li>
                            <li>
                                <a href="views/bolsa.html">Estado de la bolsa</a>
                            </li>
                            <li>
                                <a href="views/dashboard.html">Consulta tu portfolio</a>
                            </li>
                        </ol>
                    </div>
                    <div className="columna">
                        <h3><strong>Otros</strong></h3>
                        <ol>
                            <li>
                                <a href="views/formacion.html">Fórmate con nosotros</a>
                            </li>
                            <li>
                                <a href="views/noticias.html">Ponte al día de las noticias</a>
                            </li>
                            <li>

                            </li>
                        </ol>
                    </div>
                </section>
                <section className="pie-pagina__copy">
                    <h2>
                        <strong>Finsmart</strong>
                    </h2>
                    <hr />
                    <p>
                        &copy; 2025 Finsmart S.L.
                    </p>
                    <p>
                        Finsmart S.L. está autorizada por la Banco de España en la España y por el Banco Central Europeo, y está regulada por la Comisión Nacional del Mercado de Valores en lo que respecta a las normas de conducta empresarial.
                    </p>
                    <p>
                        Domicilio social: Calle de la Vida, 42, Madrid, 28001, España, número de registro B-12345678.
                    </p>
                    <p>
                        Finsmart S.L. es una sociedad limitada.
                    </p>
                    <p>
                        Finsmart S.L. ha establecido una sucursal en España, con número de registro en la Banco de España B-98765432, inscrita en el Registro Mercantil de Madrid al Tomo 45678, Libro 0, Folio 2, Sección 9, Hoja M987654, Inscripción 2 y con domicilio en Calle de la Fama, 10, 28001, Madrid.
                    </p>
                    <p>
                        Finsmart S.L. ha sido fundada por el visionario y empresario Bruce Wayne, quien ha invertido en la empresa una fortuna comparable a la de Tony Stark. La dirección de la sucursal en Madrid es un edificio de oficinas diseñado por el arquitecto Gustavo Fring, famoso por su estilo minimalista y funcional.
                    </p>
                    <p>
                        En cuanto a los registros, Finsmart S.L. tiene un número de registro en el Registro Mercantil de Madrid que es similar al número de registro de la película La lista de Schindler, y su sucursal en Madrid está ubicada en una calle que recuerda a la famosa Calle de la Sombra de la película El Padrino.                    
                    </p>
                </section>
            </footer>
        </>
    );
};

export default Home;
