import React from 'react';
import styles from './Navbar.module.css';

const Navbar: React.FC = () => {
    return (
        <nav className={styles.navbar}>
            <div className={styles.container}>
                <div className={styles.brand}>
                    <a href="/" className={styles.logo}>Finsmart</a>
                </div>
                <div className={styles.nav}>
                    <ul className={styles.navList}>
                        <li className={styles.navItem}>
                            <a href="/dashboard" className={styles.navLink}>Mi cartera</a>
                        </li>
                        <li className={styles.navItem}>
                            <a href="/bolsa" className={styles.navLink}>Estado de la bolsa</a>
                        </li>
                        <li className={styles.navItem}>
                            <a href="/conocenos" className={styles.navLink}>Conócenos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;