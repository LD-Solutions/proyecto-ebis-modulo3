import React from 'react';
import styles from './FormacionFilters.module.css';

interface FormacionFiltersProps {
  selectedTipo: string | null;
  selectedNivel: string | null;
  onTipoChange: (tipo: string | null) => void;
  onNivelChange: (nivel: string | null) => void;
  onClearFilters: () => void;
}

const FormacionFilters: React.FC<FormacionFiltersProps> = ({
  selectedTipo,
  selectedNivel,
  onTipoChange,
  onNivelChange,
  onClearFilters,
}) => {
  const tipos = ['curso', 'video', 'libro', 'webinar'];
  const niveles = ['principiante', 'intermedio', 'avanzado'];

  const hasActiveFilters = selectedTipo || selectedNivel;

  return (
    <div className={styles.filters}>
      <div className={styles.filterGroup}>
        <label className={styles.filterLabel}>Tipo de contenido:</label>
        <div className={styles.filterButtons}>
          {tipos.map((tipo) => (
            <button
              key={tipo}
              className={`${styles.filterButton} ${
                selectedTipo === tipo ? styles.filterButtonActive : ''
              }`}
              onClick={() => onTipoChange(selectedTipo === tipo ? null : tipo)}
            >
              {tipo}
            </button>
          ))}
        </div>
      </div>

      <div className={styles.filterGroup}>
        <label className={styles.filterLabel}>Nivel:</label>
        <div className={styles.filterButtons}>
          {niveles.map((nivel) => (
            <button
              key={nivel}
              className={`${styles.filterButton} ${
                selectedNivel === nivel ? styles.filterButtonActive : ''
              }`}
              onClick={() => onNivelChange(selectedNivel === nivel ? null : nivel)}
            >
              {nivel}
            </button>
          ))}
        </div>
      </div>

      {hasActiveFilters && (
        <button className={styles.clearButton} onClick={onClearFilters}>
          Limpiar filtros
        </button>
      )}
    </div>
  );
};

export default FormacionFilters;