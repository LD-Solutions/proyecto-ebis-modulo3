import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '@context/AuthContext';
import { useToast } from '@context/ToastContext';
import styles from './Navbar.module.css';

const Navbar: React.FC = () => {
    const { isAuthenticated, logout } = useAuth();
    const { showToast } = useToast();
    const navigate = useNavigate();

    const handleAuthAction = () => {
        if (isAuthenticated) {
            logout();
            showToast('¡Gracias por usar nuestros servicios!', 3000);
            navigate('/');
        } else {
            navigate('/login');
        }
    };

    return (
        <nav className={styles.navbar}>
            <div className={styles.container}>
                <div className={styles.brand}>
                    <Link to="/" className={styles.logo}>Finsmart</Link>
                </div>
                <div className={styles.nav}>
                    <ul className={styles.navList}>
                        <li className={styles.navItem}>
                            <Link to="/cartera" className={styles.navLink}>Mi cartera</Link>
                        </li>
                        <li className={styles.navItem}>
                            <Link to="/formacion" className={styles.navLink}>Formación</Link>
                        </li>
                        <li className={styles.navItem}>
                            <Link to="/bolsa" className={styles.navLink}>Estado de la bolsa</Link>
                        </li>
                        <li className={styles.navItem}>
                            <Link to="/conocenos" className={styles.navLink}>Conócenos</Link>
                        </li>
                        <li className={styles.navItem}>
                            <button
                                onClick={handleAuthAction}
                                className={styles.authButton}
                            >
                                {isAuthenticated ? 'Logout' : 'Login'}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;