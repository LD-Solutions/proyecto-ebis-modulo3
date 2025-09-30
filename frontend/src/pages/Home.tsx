import React from 'react';
import styles from './Home.module.css';

const Home: React.FC = () => {
    return (
        <>
            {/*----------HERO SECTION----------*/}
            <section className={styles.hero}>
                <img src="/assets/icons/logo.jpg" alt="Finsmart Logo" className={styles.heroLogo} />
                <div className={styles.heroContent}>
                    <h1 className={styles.heroTitle}>Gestiona tu futuro financiero</h1>
                    <p className={styles.heroSubtitle}>
                        Herramientas inteligentes para inversiones, ahorro y planificación financiera.
                        Toma el control de tu patrimonio con Finsmart.
                    </p>
                    <a href="#main" className={styles.heroCta}>
                        Descubre nuestras herramientas
                        <span>↓</span>
                    </a>
                </div>
            </section>

            {/*----------MAIN CONTENT----------*/}
            <main id="main" className={styles.main}>
                {/* Sección: Conoce a nuestro equipo */}
                <section className={styles.section}>
                    <div className={styles.container}>
                        <div className={styles.media}>
                            <img src="/assets/images/oficina2.webp" alt="Equipo de Finsmart" className={styles.image} />
                        </div>

                        <div className={styles.content}>
                            <h2 className={styles.title}>Conoce a nuestro equipo</h2>
                            <h3 className={styles.subtitle}>Expertos en finanzas a tu servicio</h3>
                            <p className={styles.text}>
                                En Finsmart contamos con un equipo de profesionales con amplia experiencia en el sector financiero. Cada miembro aporta conocimientos únicos y especializados para ayudarte a alcanzar tus metas de inversión y ahorro.
                            </p>
                            <p className={styles.text}>
                                Nuestros asesores financieros, analistas de mercado y expertos en tecnología trabajan juntos para ofrecerte las mejores herramientas y consejos personalizados para tu situación financiera particular.
                            </p>
                            <a href="/conocenos" className={styles.cta}>Conoce al equipo →</a>
                        </div>
                    </div>
                </section>

                {/* Sección: Nuestros servicios */}
                <section className={`${styles.section} ${styles.sectionAlt}`}>
                    <div className={`${styles.container} ${styles.containerReverse}`}>
                        <div className={styles.media}>
                            <img src="/assets/images/oficina1.webp" alt="Servicios de inversión" className={styles.image} />
                        </div>

                        <div className={styles.content}>
                            <h2 className={styles.title}>Nuestros servicios</h2>
                            <h3 className={styles.subtitle}>Soluciones financieras personalizadas</h3>
                            <p className={styles.text}>
                                Ofrecemos una amplia gama de servicios financieros diseñados para satisfacer tus necesidades específicas. Desde asesoramiento en inversiones hasta planificación de jubilación, nuestro objetivo es ayudarte a alcanzar tus metas financieras.
                            </p>
                            <p className={styles.text}>
                                Nuestros expertos analizan tu situación actual y te ofrecen estrategias claras y efectivas para maximizar tus ahorros y optimizar tu cartera de inversiones.
                            </p>
                            <a href="/bolsa" className={styles.cta}>Ver servicios →</a>
                        </div>
                    </div>
                </section>
            </main>
        </>
    );
};

export default Home;
