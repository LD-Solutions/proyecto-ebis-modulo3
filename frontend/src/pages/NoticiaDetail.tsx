import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import styles from './NoticiaDetail.module.css';
import { getNoticia } from '@services/noticiasService';
import type { Noticia } from '@services/noticiasService';

const gradients = [
  'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
  'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
  'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
  'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
  'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
  'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
  'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
  'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
];

const getRandomGradient = (id: number) => {
  return gradients[id % gradients.length];
};

const NoticiaDetail: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const [noticia, setNoticia] = useState<Noticia | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [imageError, setImageError] = useState(false);

  useEffect(() => {
    if (id) {
      fetchNoticia(parseInt(id));
    }
  }, [id]);

  const fetchNoticia = async (noticiaId: number) => {
    setLoading(true);
    setError(null);

    try {
      const response = await getNoticia(noticiaId);
      setNoticia(response);
    } catch (err) {
      setError('Error al cargar la noticia. Por favor, intenta de nuevo.');
      console.error('Error fetching noticia:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleBack = () => {
    navigate('/noticias');
  };

  if (loading) {
    return (
      <div className={styles.page}>
        <div className={styles.container}>
          <div className={styles.loading}>
            <div className={styles.spinner}></div>
            <p>Cargando noticia...</p>
          </div>
        </div>
      </div>
    );
  }

  if (error || !noticia) {
    return (
      <div className={styles.page}>
        <div className={styles.container}>
          <div className={styles.error}>
            <p>{error || 'Noticia no encontrada'}</p>
            <button onClick={handleBack} className={styles.backButton}>
              ← Volver a noticias
            </button>
          </div>
        </div>
      </div>
    );
  }

  const showGradient = !noticia.imagen_url || imageError;

  return (
    <div className={styles.page}>
      <div className={styles.container}>
        <button onClick={handleBack} className={styles.backButton}>
          ← Volver a noticias
        </button>

        <article className={styles.article}>
          <div
            className={styles.heroImage}
            style={showGradient ? { background: getRandomGradient(noticia.id) } : {}}
          >
            {!showGradient && (
              <img
                src={noticia.imagen_url}
                alt={noticia.titulo}
                className={styles.image}
                onError={() => setImageError(true)}
              />
            )}
          </div>

          <div className={styles.content}>
            <h1 className={styles.title}>{noticia.titulo}</h1>

            <div className={styles.meta}>
              <span className={styles.date}>
                {new Date(noticia.fecha_publicacion).toLocaleDateString('es-ES', {
                  year: 'numeric',
                  month: 'long',
                  day: 'numeric'
                })}
              </span>
              {noticia.autor && (
                <span className={styles.author}>Por {noticia.autor}</span>
              )}
            </div>

            <div className={styles.body}>
              {noticia.contenido.split('\n').map((paragraph, index) => (
                <p key={index}>{paragraph}</p>
              ))}
            </div>
          </div>
        </article>
      </div>
    </div>
  );
};

export default NoticiaDetail;
