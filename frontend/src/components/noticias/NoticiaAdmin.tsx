import React, { useState } from 'react';
import { useToast } from '@context/ToastContext';
import { createNoticia, updateNoticia, deleteNoticia, type Noticia } from '@services/noticiasService';
import { CATEGORIAS } from '@constants/categories';
import styles from './NoticiaAdmin.module.css';

interface NoticiaAdminProps {
  noticias: Noticia[];
  onSuccess: () => void;
}

interface NoticiaFormData {
  titulo: string;
  contenido: string;
  fecha_publicacion: string;
  autor: string;
  categoria: string;
  imagen_url: string;
}

const NoticiaAdmin: React.FC<NoticiaAdminProps> = ({ noticias, onSuccess }) => {
  const { showToast } = useToast();
  const [showForm, setShowForm] = useState(false);
  const [showEditList, setShowEditList] = useState(false);
  const [editingId, setEditingId] = useState<number | null>(null);
  const [submitting, setSubmitting] = useState(false);
  const [currentPage, setCurrentPage] = useState(1);
  const [formData, setFormData] = useState<NoticiaFormData>({
    titulo: '',
    contenido: '',
    fecha_publicacion: new Date().toISOString().split('T')[0],
    autor: '',
    categoria: '',
    imagen_url: '',
  });

  const itemsPerPage = 5;
  const totalPages = Math.ceil(noticias.length / itemsPerPage);
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const paginatedNoticias = noticias.slice(startIndex, endIndex);

  const resetForm = () => {
    setFormData({
      titulo: '',
      contenido: '',
      fecha_publicacion: new Date().toISOString().split('T')[0],
      autor: '',
      categoria: '',
      imagen_url: '',
    });
    setEditingId(null);
    setShowForm(false);
  };

  const handleCreate = () => {
    resetForm();
    setShowForm(true);
  };

  const handleEdit = (noticia: Noticia) => {
    setFormData({
      titulo: noticia.titulo,
      contenido: noticia.contenido,
      fecha_publicacion: noticia.fecha_publicacion.split('T')[0],
      autor: noticia.autor,
      categoria: noticia.categoria,
      imagen_url: noticia.imagen_url || '',
    });
    setEditingId(noticia.id);
    setShowForm(true);
    setShowEditList(false);
  };

  const handleDelete = async (id: number, titulo: string) => {
    if (!confirm(`¿Estás seguro de que quieres eliminar la noticia "${titulo}"?`)) {
      return;
    }

    try {
      await deleteNoticia(id);
      showToast('Noticia eliminada exitosamente', 3000);
      onSuccess();
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } catch (err: any) {
      showToast(err.response?.data?.error || 'Error al eliminar la noticia', 3000);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (!formData.titulo || !formData.contenido || !formData.autor || !formData.categoria) {
      showToast('El título, contenido, autor y categoría son obligatorios', 3000);
      return;
    }

    setSubmitting(true);

    try {
      if (editingId) {
        await updateNoticia(editingId, formData);
        showToast('Noticia actualizada exitosamente', 3000);
      } else {
        await createNoticia(formData);
        showToast('Noticia creada exitosamente', 3000);
      }
      resetForm();
      onSuccess();
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } catch (err: any) {
      showToast(err.response?.data?.error || 'Error al guardar la noticia', 3000);
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <div className={styles.adminPanel}>
      <div className={styles.actions}>
        <button
          onClick={handleCreate}
          className={styles.createButton}
          disabled={showForm}
        >
          + Crear Nueva Noticia
        </button>
        <button
          onClick={() => setShowEditList(!showEditList)}
          className={styles.editListButton}
          disabled={showForm}
        >
          {showEditList ? 'Ocultar Lista' : 'Editar/Eliminar'}
        </button>
      </div>

      {showForm && (
        <div className={styles.formContainer}>
          <div className={styles.formHeader}>
            <h3>{editingId ? 'Editar Noticia' : 'Nueva Noticia'}</h3>
            <button onClick={resetForm} className={styles.closeButton}>
              ✕
            </button>
          </div>

          <form onSubmit={handleSubmit} className={styles.form}>
            <div className={styles.formGroup}>
              <label htmlFor="titulo" className={styles.label}>
                Título *
              </label>
              <input
                type="text"
                id="titulo"
                value={formData.titulo}
                onChange={(e) => setFormData({ ...formData, titulo: e.target.value })}
                className={styles.input}
                required
                disabled={submitting}
              />
            </div>

            <div className={styles.formGroup}>
              <label htmlFor="contenido" className={styles.label}>
                Contenido *
              </label>
              <textarea
                id="contenido"
                value={formData.contenido}
                onChange={(e) => setFormData({ ...formData, contenido: e.target.value })}
                className={styles.textarea}
                rows={8}
                required
                disabled={submitting}
              />
            </div>

            <div className={styles.formRow}>
              <div className={styles.formGroup}>
                <label htmlFor="autor" className={styles.label}>
                  Autor *
                </label>
                <input
                  type="text"
                  id="autor"
                  value={formData.autor}
                  onChange={(e) => setFormData({ ...formData, autor: e.target.value })}
                  className={styles.input}
                  required
                  disabled={submitting}
                />
              </div>

              <div className={styles.formGroup}>
                <label htmlFor="categoria" className={styles.label}>
                  Categoría *
                </label>
                <select
                  id="categoria"
                  value={formData.categoria}
                  onChange={(e) => setFormData({ ...formData, categoria: e.target.value })}
                  className={styles.input}
                  required
                  disabled={submitting}
                >
                  <option value="">Seleccionar categoría</option>
                  {CATEGORIAS.map((cat) => (
                    <option key={cat} value={cat}>
                      {cat.charAt(0).toUpperCase() + cat.slice(1)}
                    </option>
                  ))}
                </select>
              </div>
            </div>

            <div className={styles.formGroup}>
              <label htmlFor="fecha_publicacion" className={styles.label}>
                Fecha de Publicación
              </label>
              <input
                type="date"
                id="fecha_publicacion"
                value={formData.fecha_publicacion}
                onChange={(e) => setFormData({ ...formData, fecha_publicacion: e.target.value })}
                className={styles.input}
                disabled={submitting}
              />
            </div>

            <div className={styles.formGroup}>
              <label htmlFor="imagen_url" className={styles.label}>
                URL de Imagen
              </label>
              <input
                type="url"
                id="imagen_url"
                value={formData.imagen_url}
                onChange={(e) => setFormData({ ...formData, imagen_url: e.target.value })}
                className={styles.input}
                placeholder="https://ejemplo.com/imagen.jpg"
                disabled={submitting}
              />
            </div>

            <div className={styles.formActions}>
              <button
                type="button"
                onClick={resetForm}
                className={styles.cancelButton}
                disabled={submitting}
              >
                Cancelar
              </button>
              <button
                type="submit"
                className={styles.submitButton}
                disabled={submitting}
              >
                {submitting ? 'Guardando...' : editingId ? 'Actualizar' : 'Crear'}
              </button>
            </div>
          </form>
        </div>
      )}

      {showEditList && (
        <div className={styles.noticiasList}>
          <h3 className={styles.listTitle}>Noticias Existentes ({noticias.length})</h3>
          {noticias.length === 0 ? (
            <p className={styles.emptyMessage}>No hay noticias disponibles</p>
          ) : (
            <>
              <div className={styles.table}>
                {paginatedNoticias.map((noticia) => (
                  <div key={noticia.id} className={styles.noticiaRow}>
                    <div className={styles.noticiaInfo}>
                      <h4 className={styles.noticiaTitle}>{noticia.titulo}</h4>
                      <p className={styles.noticiaDate}>
                        {new Date(noticia.fecha_publicacion).toLocaleDateString('es-ES')}
                      </p>
                    </div>
                    <div className={styles.noticiaActions}>
                      <button
                        onClick={() => handleEdit(noticia)}
                        className={styles.editButton}
                        disabled={showForm}
                      >
                        Editar
                      </button>
                      <button
                        onClick={() => handleDelete(noticia.id, noticia.titulo)}
                        className={styles.deleteButton}
                      >
                        Eliminar
                      </button>
                    </div>
                  </div>
                ))}
              </div>

              {totalPages > 1 && (
                <div className={styles.pagination}>
                  <button
                    onClick={() => setCurrentPage(currentPage - 1)}
                    disabled={currentPage === 1}
                    className={styles.pageButton}
                  >
                    ← Anterior
                  </button>
                  <span className={styles.pageInfo}>
                    Página {currentPage} de {totalPages}
                  </span>
                  <button
                    onClick={() => setCurrentPage(currentPage + 1)}
                    disabled={currentPage === totalPages}
                    className={styles.pageButton}
                  >
                    Siguiente →
                  </button>
                </div>
              )}
            </>
          )}
        </div>
      )}
    </div>
  );
};

export default NoticiaAdmin;