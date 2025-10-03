import React, { useState, useEffect } from 'react';
import styles from './EditFormacionModal.module.css';
import type { Formacion } from '../services/formacionService';

interface EditFormacionModalProps {
  formacion: Formacion;
  onClose: () => void;
  onSave: (id: number, data: Partial<Formacion>) => Promise<void>;
}

const EditFormacionModal: React.FC<EditFormacionModalProps> = ({ formacion, onClose, onSave }) => {
  const [formData, setFormData] = useState({
    titulo: formacion.titulo,
    descripcion: formacion.descripcion,
    tipo: formacion.tipo,
    nivel: formacion.nivel,
    duracion: formacion.duracion,
    instructor: formacion.instructor,
    url: formacion.url || '',
    imagen: formacion.imagen || '',
  });
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [error, setError] = useState('');

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError('');
    setIsSubmitting(true);

    try {
      await onSave(formacion.id, formData);
      onClose();
    } catch (err: any) {
      setError(err.response?.data?.message || 'Error al actualizar la formación');
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className={styles.modalOverlay} onClick={onClose}>
      <div className={styles.modalContent} onClick={(e) => e.stopPropagation()}>
        <div className={styles.modalHeader}>
          <h2>Editar Formación</h2>
          <button className={styles.closeButton} onClick={onClose}>×</button>
        </div>

        {error && <div className={styles.error}>{error}</div>}

        <form onSubmit={handleSubmit} className={styles.form}>
          <div className={styles.formGroup}>
            <label htmlFor="titulo">Título</label>
            <input
              type="text"
              id="titulo"
              name="titulo"
              value={formData.titulo}
              onChange={handleChange}
              required
            />
          </div>

          <div className={styles.formGroup}>
            <label htmlFor="descripcion">Descripción</label>
            <textarea
              id="descripcion"
              name="descripcion"
              value={formData.descripcion}
              onChange={handleChange}
              rows={4}
              required
            />
          </div>

          <div className={styles.formRow}>
            <div className={styles.formGroup}>
              <label htmlFor="tipo">Tipo</label>
              <select id="tipo" name="tipo" value={formData.tipo} onChange={handleChange} required>
                <option value="curso">Curso</option>
                <option value="video">Video</option>
                <option value="libro">Libro</option>
                <option value="webinar">Webinar</option>
              </select>
            </div>

            <div className={styles.formGroup}>
              <label htmlFor="nivel">Nivel</label>
              <select id="nivel" name="nivel" value={formData.nivel} onChange={handleChange} required>
                <option value="principiante">Principiante</option>
                <option value="intermedio">Intermedio</option>
                <option value="avanzado">Avanzado</option>
              </select>
            </div>
          </div>

          <div className={styles.formRow}>
            <div className={styles.formGroup}>
              <label htmlFor="duracion">Duración</label>
              <input
                type="text"
                id="duracion"
                name="duracion"
                value={formData.duracion}
                onChange={handleChange}
                required
              />
            </div>

            <div className={styles.formGroup}>
              <label htmlFor="instructor">Instructor</label>
              <input
                type="text"
                id="instructor"
                name="instructor"
                value={formData.instructor}
                onChange={handleChange}
                required
              />
            </div>
          </div>

          <div className={styles.formGroup}>
            <label htmlFor="url">URL</label>
            <input
              type="url"
              id="url"
              name="url"
              value={formData.url}
              onChange={handleChange}
            />
          </div>

          <div className={styles.formGroup}>
            <label htmlFor="imagen">Imagen URL</label>
            <input
              type="url"
              id="imagen"
              name="imagen"
              value={formData.imagen}
              onChange={handleChange}
            />
          </div>

          <div className={styles.modalActions}>
            <button type="button" onClick={onClose} className={styles.cancelButton} disabled={isSubmitting}>
              Cancelar
            </button>
            <button type="submit" className={styles.saveButton} disabled={isSubmitting}>
              {isSubmitting ? 'Guardando...' : 'Guardar Cambios'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EditFormacionModal;