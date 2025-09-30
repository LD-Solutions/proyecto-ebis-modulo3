import React from 'react';

const Navbar: React.FC = () => {
    return (
        <nav className="barra-navegacion">
            <h2>
                <a href="/">Finsmart</a>
            </h2>
            <ul>
                <li>
                    <a href="/dashboard">Mi cartera</a>
                </li>
                <li>
                    <a href="/bolsa">Estado de la bolsa</a>
                </li>
                <li>
                    <a href="/conocenos">Conócenos</a>
                </li>
            </ul>
        </nav>
    );
};

export default Navbar;