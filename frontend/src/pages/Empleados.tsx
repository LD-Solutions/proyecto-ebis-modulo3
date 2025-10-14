import { useState, useEffect } from 'react';
import styles from './Empleados.module.css';
import type { Empleado } from '@services/empleadosService';
import { getEmpleados, createEmpleado, updateEmpleado, deleteEmpleado } from '@services/empleadosService';
import { useToast } from '@context/ToastContext';
import { useAuth } from '@context/AuthContext';

interface EmpleadoFormData {
  nombre: string;
  apellido: string;
  cargo: string;
  imagen_url: string;
}

const Empleados = () => {
  const [empleados, setEmpleados] = useState<Empleado[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [editingEmpleado, setEditingEmpleado] = useState<Empleado | null>(null);
  const [isCreating, setIsCreating] = useState<boolean>(false);
  const [formData, setFormData] = useState<EmpleadoFormData>({
    nombre: '',
    apellido: '',
    cargo: '',
    imagen_url: ''
  });

  const { user, isAuthenticated } = useAuth();
  const { showToast } = useToast();

  const isAdmin = isAuthenticated && user?.role === 'admin';

  useEffect(() => {
    fetchEmpleados();
  }, []);

  const fetchEmpleados = async () => {
    setLoading(true);
    setError(null);

    try {
      const response = await getEmpleados();
      setEmpleados(response.data || response as any);
    } catch (err) {
      setError('Error al cargar los empleados. Por favor, intenta de nuevo.');
      console.error('Error fetching empleados:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleEdit = (empleado: Empleado) => {
    if (!isAdmin) {
      showToast('No tienes permisos para realizar esta acción');
      return;
    }

    setEditingEmpleado(empleado);
    setFormData({
      nombre: empleado.nombre,
      apellido: empleado.apellido,
      cargo: empleado.cargo,
      imagen_url: empleado.imagen_url,
    });
  };

  const handleSave = async (id: number | null, data: Partial<Empleado>) => {
    if (!isAdmin) {
      showToast('No tienes permisos para realizar esta acción');
      return;
    }

    try {
      if (id) {
        await updateEmpleado(id, data);
        showToast('Empleado actualizado correctamente');
      } else {
        await createEmpleado(data as Omit<Empleado, 'id' | 'created_at' | 'updated_at'>);
        showToast('Empleado creado correctamente');
      }
      closeModal();
      fetchEmpleados();
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || 
        `Error al ${id ? 'actualizar' : 'crear'} el empleado`;
      showToast(errorMessage);
      console.error('Error:', err);
    }
  };

  const handleDelete = async (id: number) => {
    if (!isAdmin) {
      showToast('No tienes permisos para realizar esta acción');
      return;
    }

    if (!window.confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
      return;
    }

    try {
      await deleteEmpleado(id);
      showToast('Empleado eliminado correctamente');
      fetchEmpleados();
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || 'Error al eliminar el empleado';
      showToast(errorMessage);
      console.error('Error deleting empleado:', err);
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    handleSave(editingEmpleado?.id || null, formData);
  };

  const resetForm = () => {
    setFormData({
      nombre: '',
      apellido: '',
      cargo: '',
      imagen_url: ''
    });
  };

  const closeModal = () => {
    setEditingEmpleado(null);
    setIsCreating(false);
    resetForm();
  };

  const agruparPorDepartamento = () => {
    const departamentos: { [key: string]: Empleado[] } = {};

    empleados.forEach(empleado => {
      const departamento = empleado.cargo.split(' ')[0] || 'Otros';
      
      if (!departamentos[departamento]) {
        departamentos[departamento] = [];
      }
      
      departamentos[departamento].push(empleado);
    });

    return departamentos;
  };

  const departamentos = agruparPorDepartamento();

  return (
    <div className={styles.page}>
      <div className={styles.container}>
        {/* Header */}
        <div className={styles.header}>
          <h1 className={styles.title}>Conoce a nuestro equipo</h1>
          <p className={styles.subtitle}>
            Expertos en finanzas a tu servicio. Profesionales comprometidos con tu éxito financiero.
          </p>
          {isAdmin && (
            <button onClick={() => setIsCreating(true)} className={styles.createButton}>
              + Agregar Empleado
            </button>
          )}
        </div>

        {/* Loading State */}
        {loading && (
          <div className={styles.loading}>
            <div className={styles.spinner}></div>
            <p>Cargando empleados...</p>
          </div>
        )}

        {/* Error State */}
        {error && (
          <div className={styles.error}>
            <p>{error}</p>
            <button onClick={fetchEmpleados} className={styles.retryButton}>
              Reintentar
            </button>
          </div>
        )}

        {/* Empty State */}
        {!loading && !error && empleados.length === 0 && (
          <div className={styles.empty}>
            <p>No hay empleados registrados en el sistema.</p>
            {isAdmin && (
              <button onClick={() => setIsCreating(true)} className={styles.clearButton}>
                Agregar primer empleado
              </button>
            )}
          </div>
        )}

        {/* Departamentos */}
        {!loading && !error && empleados.length > 0 && (
          <div className={styles.departamentos}>
            {Object.entries(departamentos).map(([departamento, miembros]) => (
              <div key={departamento} className={styles.departamento}>
                <h2 className={styles.departamentoTitle}>{departamento}</h2>
                
                <div className={styles.grid}>
                  {miembros.map((empleado) => (
                    <div key={empleado.id} className={styles.card}>
                      <div className={styles.cardImage}>
                        <img
                          src={empleado.imagen_url}
                          alt={`${empleado.nombre} ${empleado.apellido}`}
                          onError={(e) => {
                            e.currentTarget.src = 'https://via.placeholder.com/400x400?text=Sin+Imagen';
                          }}
                        />
                      </div>
                      
                      <div className={styles.cardContent}>
                        <h3 className={styles.cardName}>
                          {empleado.nombre} {empleado.apellido}
                        </h3>
                        <p className={styles.cardCargo}>{empleado.cargo}</p>
                        
                        {isAdmin && (
                          <div className={styles.cardActions}>
                            <button
                              onClick={() => handleEdit(empleado)}
                              className={styles.editButton}
                            >
                              Editar
                            </button>
                            <button
                              onClick={() => handleDelete(empleado.id)}
                              className={styles.deleteButton}
                            >
                              Eliminar
                            </button>
                          </div>
                        )}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            ))}
          </div>
        )}
      </div>

      {/* Modal: Crear/Editar */}
      {(isCreating || editingEmpleado) && (
        <div className={styles.modalOverlay} onClick={closeModal}>
          <div className={styles.modal} onClick={(e) => e.stopPropagation()}>
            <div className={styles.modalHeader}>
              <h2>{editingEmpleado ? 'Editar Empleado' : 'Nuevo Empleado'}</h2>
            </div>

            <form className={styles.modalForm} onSubmit={handleSubmit}>
              <div className={styles.formGroup}>
                <label>Nombre</label>
                <input
                  type="text"
                  required
                  value={formData.nombre}
                  onChange={(e) => setFormData({ ...formData, nombre: e.target.value })}
                  placeholder="Juan Carlos"
                />
              </div>

              <div className={styles.formGroup}>
                <label>Apellido</label>
                <input
                  type="text"
                  required
                  value={formData.apellido}
                  onChange={(e) => setFormData({ ...formData, apellido: e.target.value })}
                  placeholder="García López"
                />
              </div>

              <div className={styles.formGroup}>
                <label>Cargo</label>
                <input
                  type="text"
                  required
                  value={formData.cargo}
                  onChange={(e) => setFormData({ ...formData, cargo: e.target.value })}
                  placeholder="Desarrollador Full Stack"
                />
              </div>

              <div className={styles.formGroup}>
                <label>URL de Imagen</label>
                <input
                  type="url"
                  required
                  value={formData.imagen_url}
                  onChange={(e) => setFormData({ ...formData, imagen_url: e.target.value })}
                  placeholder="https://ejemplo.com/foto.jpg"
                />
              </div>

              <div className={styles.modalActions}>
                <button type="button" onClick={closeModal} className={styles.cancelButton}>
                  Cancelar
                </button>
                <button type="submit" className={styles.saveButton}>
                  {editingEmpleado ? 'Actualizar' : 'Crear'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default Empleados;