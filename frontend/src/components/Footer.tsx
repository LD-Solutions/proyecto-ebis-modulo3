import React from 'react';

const Footer: React.FC = () => {
    return (
        <footer className="pie-pagina">
            <section className="col3">
                <div className="columna">
                    <h3><strong>Nuestra Empresa</strong></h3>
                    <ol>
                        <li>
                            <a href="/conocenos">Conocenos</a>
                        </li>
                        <li>
                            <a href="/aviso">Aviso</a>
                        </li>
                        <li>
                            <a href="/contacto">Contacto</a>
                        </li>
                    </ol>
                </div>
                <div className="columna">
                    <h3><strong>Herramientas</strong></h3>
                    <ol>
                        <li>
                            <a href="/ahorro">Calculadora de ahorro</a>
                        </li>
                        <li>
                            <a href="/bolsa">Estado de la bolsa</a>
                        </li>
                        <li>
                            <a href="/dashboard">Consulta tu portfolio</a>
                        </li>
                    </ol>
                </div>
                <div className="columna">
                    <h3><strong>Otros</strong></h3>
                    <ol>
                        <li>
                            <a href="/formacion">Fórmate con nosotros</a>
                        </li>
                        <li>
                            <a href="/noticias">Ponte al día de las noticias</a>
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
    );
};

export default Footer;