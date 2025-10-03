import React from 'react';
import { useAuth } from '../context/AuthContext';
import styles from './FormacionCard.module.css';
import type { Formacion } from '../services/formacionService';

interface FormacionCardProps {
  formacion: Formacion;
  onEdit?: (formacion: Formacion) => void;
  onDelete?: (id: number) => void;
}

const FormacionCard: React.FC<FormacionCardProps> = ({ formacion, onEdit, onDelete }) => {
  const { isAuthenticated } = useAuth();
  const getTipoBadgeColor = (tipo: string) => {
    switch (tipo) {
      case 'curso': return styles.badgeCurso;
      case 'video': return styles.badgeVideo;
      case 'libro': return styles.badgeLibro;
      case 'webinar': return styles.badgeWebinar;
      default: return '';
    }
  };

  const getNivelBadgeColor = (nivel: string) => {
    switch (nivel) {
      case 'principiante': return styles.badgePrincipiante;
      case 'intermedio': return styles.badgeIntermedio;
      case 'avanzado': return styles.badgeAvanzado;
      default: return '';
    }
  };

  return (
    <div className={styles.card}>
      {formacion.imagen && (
        <div className={styles.imageContainer}>
          <img
            src={formacion.imagen}
            alt={formacion.titulo}
            className={styles.image}
          />
        </div>
      )}

      <div className={styles.content}>
        <div className={styles.badges}>
          <span className={`${styles.badge} ${getTipoBadgeColor(formacion.tipo)}`}>
            {formacion.tipo}
          </span>
          <span className={`${styles.badge} ${getNivelBadgeColor(formacion.nivel)}`}>
            {formacion.nivel}
          </span>
        </div>

        <h3 className={styles.title}>{formacion.titulo}</h3>
        <p className={styles.description}>{formacion.descripcion}</p>

        <div className={styles.meta}>
          <div className={styles.metaItem}>
            <span className={styles.metaLabel}>Instructor:</span>
            <span className={styles.metaValue}>{formacion.instructor}</span>
          </div>
          <div className={styles.metaItem}>
            <span className={styles.metaLabel}>Duración:</span>
            <span className={styles.metaValue}>{formacion.duracion}</span>
          </div>
        </div>

        <div className={styles.actions}>
          {formacion.url && (
            <a
              href={formacion.url}
              target="_blank"
              rel="noopener noreferrer"
              className={styles.button}
            >
              Ver contenido →
            </a>
          )}

          {isAuthenticated && (
            <div className={styles.adminButtons}>
              <button
                onClick={() => onEdit?.(formacion)}
                className={styles.editButton}
                title="Editar formación"
              >
                ✏️ Editar
              </button>
              <button
                onClick={() => onDelete?.(formacion.id)}
                className={styles.deleteButton}
                title="Eliminar formación"
              >
                🗑️ Eliminar
              </button>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default FormacionCard;