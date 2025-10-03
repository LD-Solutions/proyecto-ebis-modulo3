import React, { useState, useEffect } from 'react';
import styles from './Formaciones.module.css';
import type { Formacion, FormacionFilters as Filters } from '../services/formacionService';
import { getFormaciones, updateFormacion, deleteFormacion } from '../services/formacionService';
import { useToast } from '../context/ToastContext';
import FormacionCard from '../components/FormacionCard';
import FormacionFilters from '../components/FormacionFilters';
import EditFormacionModal from '../components/EditFormacionModal';

const Formaciones: React.FC = () => {
  const [formaciones, setFormaciones] = useState<Formacion[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [selectedTipo, setSelectedTipo] = useState<string | null>(null);
  const [selectedNivel, setSelectedNivel] = useState<string | null>(null);
  const [editingFormacion, setEditingFormacion] = useState<Formacion | null>(null);
  const { showToast } = useToast();

  useEffect(() => {
    fetchFormaciones();
  }, [selectedTipo, selectedNivel]);

  const fetchFormaciones = async () => {
    setLoading(true);
    setError(null);

    try {
      const filters: Filters = {};
      if (selectedTipo) filters.tipo = selectedTipo as any;
      if (selectedNivel) filters.nivel = selectedNivel as any;

      const response = await getFormaciones(filters);
      setFormaciones(response.data || response as any);
    } catch (err) {
      setError('Error al cargar las formaciones. Por favor, intenta de nuevo.');
      console.error('Error fetching formaciones:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleClearFilters = () => {
    setSelectedTipo(null);
    setSelectedNivel(null);
  };

  const handleEdit = (formacion: Formacion) => {
    setEditingFormacion(formacion);
  };

  const handleSave = async (id: number, data: Partial<Formacion>) => {
    await updateFormacion(id, data);
    showToast('Formación actualizada correctamente');
    fetchFormaciones();
  };

  const handleDelete = async (id: number) => {
    if (window.confirm('¿Estás seguro de que deseas eliminar esta formación?')) {
      try {
        await deleteFormacion(id);
        showToast('Formación eliminada correctamente');
        fetchFormaciones();
      } catch (err) {
        showToast('Error al eliminar la formación');
      }
    }
  };

  return (
    <div className={styles.page}>
      <div className={styles.container}>
        {/* Header */}
        <div className={styles.header}>
          <h1 className={styles.title}>Plataforma de Formación</h1>
          <p className={styles.subtitle}>
            Aprende a gestionar tus finanzas con nuestros cursos, videos y recursos educativos
          </p>
        </div>

        {/* Filters */}
        <FormacionFilters
          selectedTipo={selectedTipo}
          selectedNivel={selectedNivel}
          onTipoChange={setSelectedTipo}
          onNivelChange={setSelectedNivel}
          onClearFilters={handleClearFilters}
        />

        {/* Loading State */}
        {loading && (
          <div className={styles.loading}>
            <div className={styles.spinner}></div>
            <p>Cargando formaciones...</p>
          </div>
        )}

        {/* Error State */}
        {error && (
          <div className={styles.error}>
            <p>{error}</p>
            <button onClick={fetchFormaciones} className={styles.retryButton}>
              Reintentar
            </button>
          </div>
        )}

        {/* Empty State */}
        {!loading && !error && formaciones.length === 0 && (
          <div className={styles.empty}>
            <p>No se encontraron formaciones con los filtros seleccionados.</p>
            <button onClick={handleClearFilters} className={styles.clearButton}>
              Limpiar filtros
            </button>
          </div>
        )}

        {/* Grid of Formaciones */}
        {!loading && !error && formaciones.length > 0 && (
          <div className={styles.grid}>
            {formaciones.map((formacion) => (
              <FormacionCard
                key={formacion.id}
                formacion={formacion}
                onEdit={handleEdit}
                onDelete={handleDelete}
              />
            ))}
          </div>
        )}
      </div>

      {/* Edit Modal */}
      {editingFormacion && (
        <EditFormacionModal
          formacion={editingFormacion}
          onClose={() => setEditingFormacion(null)}
          onSave={handleSave}
        />
      )}
    </div>
  );
};

export default Formaciones;