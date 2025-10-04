import React, { useState } from 'react';
import styles from './EditFormacionModal.module.css';
import type { Formacion } from '@services/formacionService';

interface EditFormacionModalProps {
  formacion?: Formacion;
  onClose: () => void;
  onSave: (id: number | null, data: Partial<Formacion>) => Promise<void>;
}

const EditFormacionModal: React.FC<EditFormacionModalProps> = ({ formacion, onClose, onSave }) => {
  const [formData, setFormData] = useState({
    titulo: formacion?.titulo || '',
    descripcion: formacion?.descripcion || '',
    instructor: formacion?.instructor || '',
    duracion_horas: formacion?.duracion_horas || '',
    precio: formacion?.precio || '',
    tipo: formacion?.tipo || 'curso' as const,
    categoria: formacion?.categoria || '',
    nivel: formacion?.nivel || 'principiante' as const,
    fecha_inicio: formacion?.fecha_inicio || '',
    archivo_path: formacion?.archivo_path || '',
    paginas: formacion?.paginas || '',
    url_video: formacion?.url_video || '',
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
      // Clean up the data - convert empty strings to undefined for optional fields
      const cleanedData = {
        ...formData,
        precio: formData.precio ? Number(formData.precio) : 0,
        duracion_horas: formData.duracion_horas ? Number(formData.duracion_horas) : undefined,
        paginas: formData.paginas ? Number(formData.paginas) : undefined,
        fecha_inicio: formData.fecha_inicio || undefined,
        archivo_path: formData.archivo_path || undefined,
        url_video: formData.url_video || undefined,
      };

      await onSave(formacion?.id || null, cleanedData);
      onClose();
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } catch (err: any) {
      setError(err.response?.data?.message || `Error al ${formacion ? 'actualizar' : 'crear'} la formación`);
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className={styles.modalOverlay} onClick={onClose}>
      <div className={styles.modalContent} onClick={(e) => e.stopPropagation()}>
        <div className={styles.modalHeader}>
          <h2>{formacion ? 'Editar' : 'Crear'} Formación</h2>
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

            <div className={styles.formGroup}>
              <label htmlFor="categoria">Categoría</label>
              <input
                type="text"
                id="categoria"
                name="categoria"
                value={formData.categoria}
                onChange={handleChange}
                required
              />
            </div>
          </div>

          <div className={styles.formRow}>
            <div className={styles.formGroup}>
              <label htmlFor="precio">Precio (€)</label>
              <input
                type="number"
                id="precio"
                name="precio"
                step="0.01"
                min="0"
                value={formData.precio}
                onChange={handleChange}
                required
              />
            </div>

            <div className={styles.formGroup}>
              <label htmlFor="duracion_horas">Duración (horas)</label>
              <input
                type="number"
                id="duracion_horas"
                name="duracion_horas"
                min="1"
                value={formData.duracion_horas}
                onChange={handleChange}
              />
            </div>
          </div>

          <div className={styles.formRow}>
            <div className={styles.formGroup}>
              <label htmlFor="fecha_inicio">Fecha de Inicio</label>
              <input
                type="datetime-local"
                id="fecha_inicio"
                name="fecha_inicio"
                value={formData.fecha_inicio}
                onChange={handleChange}
              />
            </div>

            <div className={styles.formGroup}>
              <label htmlFor="paginas">Páginas</label>
              <input
                type="number"
                id="paginas"
                name="paginas"
                min="1"
                value={formData.paginas}
                onChange={handleChange}
              />
            </div>
          </div>

          <div className={styles.formGroup}>
            <label htmlFor="url_video">URL del Video</label>
            <input
              type="url"
              id="url_video"
              name="url_video"
              value={formData.url_video}
              onChange={handleChange}
            />
          </div>

          <div className={styles.formGroup}>
            <label htmlFor="archivo_path">Ruta del Archivo</label>
            <input
              type="text"
              id="archivo_path"
              name="archivo_path"
              value={formData.archivo_path}
              onChange={handleChange}
            />
          </div>

          <div className={styles.modalActions}>
            <button type="button" onClick={onClose} className={styles.cancelButton} disabled={isSubmitting}>
              Cancelar
            </button>
            <button type="submit" className={styles.saveButton} disabled={isSubmitting}>
              {isSubmitting ? 'Guardando...' : (formacion ? 'Guardar Cambios' : 'Crear Formación')}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EditFormacionModal;