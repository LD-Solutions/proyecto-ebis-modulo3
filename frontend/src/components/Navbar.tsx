import React from 'react';
import { Link } from 'react-router-dom';
import styles from './Navbar.module.css';

const Navbar: React.FC = () => {
    return (
        <nav className={styles.navbar}>
            <div className={styles.container}>
                <div className={styles.brand}>
                    <Link to="/" className={styles.logo}>Finsmart</Link>
                </div>
                <div className={styles.nav}>
                    <ul className={styles.navList}>
                        <li className={styles.navItem}>
                            <Link to="/formacion" className={styles.navLink}>Formación</Link>
                        </li>
                        <li className={styles.navItem}>
                            <Link to="/dashboard" className={styles.navLink}>Mi cartera</Link>
                        </li>
                        <li className={styles.navItem}>
                            <Link to="/bolsa" className={styles.navLink}>Estado de la bolsa</Link>
                        </li>
                        <li className={styles.navItem}>
                            <Link to="/conocenos" className={styles.navLink}>Conócenos</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;