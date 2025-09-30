import React from 'react';
import styles from './Footer.module.css';

const Footer: React.FC = () => {
    return (
        <footer className={styles.footer}>
            <div className={styles.container}>
                <section className={styles.linksSection}>
                    <div className={styles.column}>
                        <h3 className={styles.columnTitle}>Nuestra Empresa</h3>
                        <ul className={styles.linkList}>
                            <li>
                                <a href="/conocenos" className={styles.footerLink}>Conocenos</a>
                            </li>
                            <li>
                                <a href="/aviso" className={styles.footerLink}>Aviso</a>
                            </li>
                            <li>
                                <a href="/contacto" className={styles.footerLink}>Contacto</a>
                            </li>
                        </ul>
                    </div>
                    <div className={styles.column}>
                        <h3 className={styles.columnTitle}>Herramientas</h3>
                        <ul className={styles.linkList}>
                            <li>
                                <a href="/ahorro" className={styles.footerLink}>Calculadora de ahorro</a>
                            </li>
                            <li>
                                <a href="/bolsa" className={styles.footerLink}>Estado de la bolsa</a>
                            </li>
                            <li>
                                <a href="/dashboard" className={styles.footerLink}>Consulta tu portfolio</a>
                            </li>
                        </ul>
                    </div>
                    <div className={styles.column}>
                        <h3 className={styles.columnTitle}>Otros</h3>
                        <ul className={styles.linkList}>
                            <li>
                                <a href="/formacion" className={styles.footerLink}>Fórmate con nosotros</a>
                            </li>
                            <li>
                                <a href="/noticias" className={styles.footerLink}>Ponte al día de las noticias</a>
                            </li>
                        </ul>
                    </div>
                </section>
                <section className={styles.legalSection}>
                    <h2 className={styles.brandName}>Finsmart</h2>
                    <hr className={styles.divider} />
                    <p className={styles.copyright}>
                        &copy; 2025 Finsmart S.L.
                    </p>
                    <p className={styles.legalText}>
                        Finsmart S.L. está autorizada por la Banco de España en la España y por el Banco Central Europeo, y está regulada por la Comisión Nacional del Mercado de Valores en lo que respecta a las normas de conducta empresarial.
                    </p>
                    <p className={styles.legalText}>
                        Domicilio social: Calle de la Vida, 42, Madrid, 28001, España, número de registro B-12345678.
                    </p>
                    <p className={styles.legalText}>
                        Finsmart S.L. es una sociedad limitada.
                    </p>
                    <p className={styles.legalText}>
                        Finsmart S.L. ha establecido una sucursal en España, con número de registro en la Banco de España B-98765432, inscrita en el Registro Mercantil de Madrid al Tomo 45678, Libro 0, Folio 2, Sección 9, Hoja M987654, Inscripción 2 y con domicilio en Calle de la Fama, 10, 28001, Madrid.
                    </p>
                    <p className={styles.legalText}>
                        Finsmart S.L. ha sido fundada por el visionario y empresario Bruce Wayne, quien ha invertido en la empresa una fortuna comparable a la de Tony Stark. La dirección de la sucursal en Madrid es un edificio de oficinas diseñado por el arquitecto Gustavo Fring, famoso por su estilo minimalista y funcional.
                    </p>
                    <p className={styles.legalText}>
                        En cuanto a los registros, Finsmart S.L. tiene un número de registro en el Registro Mercantil de Madrid que es similar al número de registro de la película La lista de Schindler, y su sucursal en Madrid está ubicada en una calle que recuerda a la famosa Calle de la Sombra de la película El Padrino.
                    </p>
                </section>
            </div>
        </footer>
    );
};

export default Footer;