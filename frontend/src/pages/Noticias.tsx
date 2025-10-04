import React, { useState, useEffect } from 'react';
import styles from './Noticias.module.css';
import { useAuth } from '@context/AuthContext';
import type { Noticia } from '@services/noticiasService';
import { getNoticias } from '@services/noticiasService';
import NoticiaCard from '@components/noticias/NoticiaCard';

const Noticias: React.FC = () => {
  const [noticias, setNoticias] = useState<Noticia[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [isAdminOpen, setIsAdminOpen] = useState<boolean>(false);
  const { isAuthenticated } = useAuth();

  useEffect(() => {
    fetchNoticias();
  }, []);

  const fetchNoticias = async () => {
    setLoading(true);
    setError(null);

    try {
      const response = await getNoticias();
      setNoticias(response.data || response as any);
    } catch (err) {
      setError('Error al cargar las noticias. Por favor, intenta de nuevo.');
      console.error('Error fetching noticias:', err);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className={styles.page}>
      <div className={styles.container}>
        {/* Header */}
        <div className={styles.header}>
          <h1 className={styles.title}>Noticias Financieras</h1>
          <p className={styles.subtitle}>
            Mantente al día con las últimas novedades del mundo financiero
          </p>
        </div>

        {/* Admin Section - Only visible when logged in */}
        {isAuthenticated && (
          <div className={styles.adminSection}>
            <button
              className={styles.adminToggle}
              onClick={() => setIsAdminOpen(!isAdminOpen)}
            >
              <span>Administración</span>
              <span className={`${styles.arrow} ${isAdminOpen ? styles.open : ''}`}>
                ▼
              </span>
            </button>
            {isAdminOpen && (
              <div className={styles.adminContent}>
                {/* TODO: Add action buttons here */}
                <p className={styles.placeholder}>Acciones de administración</p>
              </div>
            )}
          </div>
        )}

        {/* Loading State */}
        {loading && (
          <div className={styles.loading}>
            <div className={styles.spinner}></div>
            <p>Cargando noticias...</p>
          </div>
        )}

        {/* Error State */}
        {error && (
          <div className={styles.error}>
            <p>{error}</p>
            <button onClick={fetchNoticias} className={styles.retryButton}>
              Reintentar
            </button>
          </div>
        )}

        {/* Empty State */}
        {!loading && !error && noticias.length === 0 && (
          <div className={styles.empty}>
            <p>No hay noticias disponibles en este momento.</p>
          </div>
        )}

        {/* List of Noticias */}
        {!loading && !error && noticias.length > 0 && (
          <div className={styles.list}>
            {noticias.map((noticia) => (
              <NoticiaCard key={noticia.id} noticia={noticia} />
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default Noticias;