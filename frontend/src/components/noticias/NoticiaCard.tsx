import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import styles from './NoticiaCard.module.css';
import type { Noticia } from '@services/noticiasService';

interface NoticiaCardProps {
  noticia: Noticia;
}

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

const NoticiaCard: React.FC<NoticiaCardProps> = ({ noticia }) => {
  const [imageError, setImageError] = useState(false);
  const navigate = useNavigate();
  const showGradient = !noticia.imagen_url || imageError;

  const handleReadClick = () => {
    navigate(`/noticias/${noticia.id}`);
  };

  return (
    <article className={styles.card}>
      <div
        className={styles.imageContainer}
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
        <div className={styles.textContent}>
          <h2 className={styles.title}>{noticia.titulo}</h2>
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
          <p className={styles.excerpt}>{noticia.contenido}</p>
        </div>
        <div className={styles.actions}>
          <button className={styles.readButton} onClick={handleReadClick}>
            Leer noticia →
          </button>
        </div>
      </div>
    </article>
  );
};

export default NoticiaCard;
