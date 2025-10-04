import React, { useState, useEffect } from 'react';
import styles from './Noticias.module.css';
import { useAuth } from '@context/AuthContext';
import type { Noticia } from '@services/noticiasService';
import { getNoticias } from '@services/noticiasService';
import NoticiaCard from '@components/noticias/NoticiaCard';
import NoticiaAdmin from '@components/noticias/NoticiaAdmin';
import { CATEGORIAS, getCategoryColor } from '@constants/categories';

const Noticias: React.FC = () => {
  const [allNoticias, setAllNoticias] = useState<Noticia[]>([]);
  const [displayedCount, setDisplayedCount] = useState<number>(5);
  const [loading, setLoading] = useState<boolean>(true);
  const [loadingMore, setLoadingMore] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);
  const [isAdminOpen, setIsAdminOpen] = useState<boolean>(false);
  const [selectedCategories, setSelectedCategories] = useState<string[]>([]);
  const { isAuthenticated } = useAuth();

  useEffect(() => {
    fetchNoticias();
  }, []);

  const fetchNoticias = async () => {
    setLoading(true);
    setError(null);

    try {
      const response = await getNoticias({ per_page: 100 }); // Fetch more noticias for admin
      setAllNoticias(response.data || response as any);
    } catch (err) {
      setError('Error al cargar las noticias. Por favor, intenta de nuevo.');
      console.error('Error fetching noticias:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleLoadMore = () => {
    setLoadingMore(true);
    // Simulate loading delay
    setTimeout(() => {
      setDisplayedCount(prev => prev + 5);
      setLoadingMore(false);
    }, 300);
  };

  const toggleCategory = (categoria: string) => {
    setSelectedCategories(prev =>
      prev.includes(categoria)
        ? prev.filter(c => c !== categoria)
        : [...prev, categoria]
    );
    setDisplayedCount(5); // Reset to initial count when filtering
  };

  const clearFilters = () => {
    setSelectedCategories([]);
    setDisplayedCount(5);
  };

  const filteredNoticias = selectedCategories.length > 0
    ? allNoticias.filter(noticia => selectedCategories.includes(noticia.categoria))
    : allNoticias;

  const displayedNoticias = filteredNoticias.slice(0, displayedCount);
  const hasMore = displayedCount < filteredNoticias.length;

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
                <NoticiaAdmin noticias={allNoticias} onSuccess={fetchNoticias} />
              </div>
            )}
          </div>
        )}

        {/* Category Filters */}
        {!loading && allNoticias.length > 0 && (
          <div className={styles.filterSection}>
            <h3 className={styles.filterTitle}>Filtrar por categoría:</h3>
            <div className={styles.filterPills}>
              {CATEGORIAS.map((categoria) => (
                <button
                  key={categoria}
                  onClick={() => toggleCategory(categoria)}
                  className={`${styles.filterPill} ${selectedCategories.includes(categoria) ? styles.active : ''}`}
                  style={{
                    backgroundColor: selectedCategories.includes(categoria)
                      ? getCategoryColor(categoria)
                      : 'transparent',
                    borderColor: getCategoryColor(categoria),
                    color: selectedCategories.includes(categoria)
                      ? 'white'
                      : getCategoryColor(categoria)
                  }}
                >
                  {categoria.charAt(0).toUpperCase() + categoria.slice(1)}
                </button>
              ))}
              {selectedCategories.length > 0 && (
                <button onClick={clearFilters} className={styles.clearFiltersButton}>
                  Borrar filtros
                </button>
              )}
            </div>
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
        {!loading && !error && allNoticias.length === 0 && (
          <div className={styles.empty}>
            <p>No hay noticias disponibles en este momento.</p>
          </div>
        )}

        {/* List of Noticias */}
        {!loading && !error && displayedNoticias.length > 0 && (
          <>
            <div className={styles.list}>
              {displayedNoticias.map((noticia) => (
                <NoticiaCard key={noticia.id} noticia={noticia} />
              ))}
            </div>

            {/* Load More Button */}
            {hasMore && (
              <div className={styles.loadMoreContainer}>
                <button
                  onClick={handleLoadMore}
                  className={styles.loadMoreButton}
                  disabled={loadingMore}
                >
                  {loadingMore ? 'Cargando...' : 'Cargar más noticias'}
                </button>
              </div>
            )}
          </>
        )}
      </div>
    </div>
  );
};

export default Noticias;