import { useState, useEffect } from 'react';
import styles from './Contacto.module.css';
import type { MensajeContacto, CreateMensajeContacto } from '@services/contactoService';
import { 
  getAllMensajes, 
  createMensaje, 
  updateMensaje, 
  deleteMensaje 
} from '@services/contactoService';
import { useToast } from '@context/ToastContext';
import { useAuth } from '@context/AuthContext';

const Contacto = () => {
  const [mensajes, setMensajes] = useState<MensajeContacto[]>([]);
  const [loading, setLoading] = useState<boolean>(false);
  const [submitting, setSubmitting] = useState<boolean>(false);
  const [editingMensaje, setEditingMensaje] = useState<MensajeContacto | null>(null);
  const [viewingMensaje, setViewingMensaje] = useState<MensajeContacto | null>(null);
  
  const [formData, setFormData] = useState<CreateMensajeContacto>({
    nombre_apellidos: '',
    email: '',
    telefono: '',
    mensaje: ''
  });

  const { user, isAuthenticated } = useAuth();
  const { showToast } = useToast();

  const isAdmin = isAuthenticated && user?.role === 'admin';

  useEffect(() => {
    if (isAdmin) {
      fetchMensajes();
    }
  }, [isAdmin]);

  const fetchMensajes = async () => {
    setLoading(true);
    try {
      const data = await getAllMensajes();
      setMensajes(data);
    } catch (err) {
      console.error('Error fetching mensajes:', err);
      showToast('Error al cargar los mensajes');
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSubmitting(true);

    try {
      if (editingMensaje) {
        // Admin editando mensaje existente
        await updateMensaje(editingMensaje.id, formData);
        showToast('Mensaje actualizado correctamente');
        closeModal();
        fetchMensajes();
      } else {
        // Usuario/invitado enviando nuevo mensaje
        await createMensaje(formData);
        showToast('Mensaje enviado correctamente. ¡Nos pondremos en contacto contigo pronto!');
        resetForm();
        
        if (isAdmin) {
          fetchMensajes();
        }
      }
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || 'Error al enviar el mensaje';
      showToast(errorMessage);
      console.error('Error:', err);
    } finally {
      setSubmitting(false);
    }
  };

  const handleEdit = (mensaje: MensajeContacto) => {
    setEditingMensaje(mensaje);
    setFormData({
      nombre_apellidos: mensaje.nombre_apellidos,
      email: mensaje.email,
      telefono: mensaje.telefono,
      mensaje: mensaje.mensaje
    });
  };

  const handleDelete = async (id: number) => {
    if (!window.confirm('¿Estás seguro de que deseas eliminar este mensaje?')) {
      return;
    }

    try {
      await deleteMensaje(id);
      showToast('Mensaje eliminado correctamente');
      fetchMensajes();
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || 'Error al eliminar el mensaje';
      showToast(errorMessage);
      console.error('Error deleting:', err);
    }
  };

  const handleView = (mensaje: MensajeContacto) => {
    setViewingMensaje(mensaje);
  };

  const resetForm = () => {
    setFormData({
      nombre_apellidos: '',
      email: '',
      telefono: '',
      mensaje: ''
    });
  };

  const closeModal = () => {
    setEditingMensaje(null);
    setViewingMensaje(null);
    resetForm();
  };

  const formatDate = (dateString: string): string => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('es-ES', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    }).format(date);
  };

  // Vista para usuarios normales e invitados
  if (!isAdmin) {
    return (
      <div className={styles.page}>
        <div className={styles.container}>
          <div className={styles.header}>
            <h1 className={styles.title}>Contáctanos</h1>
            <p className={styles.subtitle}>
              ¿Tienes alguna pregunta? Estamos aquí para ayudarte. Rellena el formulario y nos pondremos en contacto contigo lo antes posible.
            </p>
          </div>

          <div className={styles.contactGrid}>
            <div className={styles.contactInfo}>
              <h2>Información de contacto</h2>
              
              <div className={styles.infoItem}>
                <div className={styles.infoIcon}>📍</div>
                <div>
                  <h3>Dirección</h3>
                  <p>Calle de la Vida, 42<br />28001 Madrid, España</p>
                </div>
              </div>

              <div className={styles.infoItem}>
                <div className={styles.infoIcon}>📧</div>
                <div>
                  <h3>Email</h3>
                  <p>contacto@finsmart.es</p>
                </div>
              </div>

              <div className={styles.infoItem}>
                <div className={styles.infoIcon}>📞</div>
                <div>
                  <h3>Teléfono</h3>
                  <p>+34 912 345 678</p>
                </div>
              </div>

              <div className={styles.infoItem}>
                <div className={styles.infoIcon}>🕒</div>
                <div>
                  <h3>Horario</h3>
                  <p>Lunes a Viernes: 9:00 - 18:00<br />Sábados: 10:00 - 14:00</p>
                </div>
              </div>
            </div>

            <div className={styles.formCard}>
              <h2>Envíanos un mensaje</h2>
              <form className={styles.form} onSubmit={handleSubmit}>
                <div className={styles.formGroup}>
                  <label>Nombre y Apellidos *</label>
                  <input
                    type="text"
                    required
                    value={formData.nombre_apellidos}
                    onChange={(e) => setFormData({ ...formData, nombre_apellidos: e.target.value })}
                    placeholder="Juan García López"
                  />
                </div>

                <div className={styles.formGroup}>
                  <label>Email *</label>
                  <input
                    type="email"
                    required
                    value={formData.email}
                    onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    placeholder="juan.garcia@ejemplo.com"
                  />
                </div>

                <div className={styles.formGroup}>
                  <label>Teléfono *</label>
                  <input
                    type="tel"
                    required
                    value={formData.telefono}
                    onChange={(e) => setFormData({ ...formData, telefono: e.target.value })}
                    placeholder="+34 612 345 678"
                  />
                </div>

                <div className={styles.formGroup}>
                  <label>Mensaje *</label>
                  <textarea
                    required
                    value={formData.mensaje}
                    onChange={(e) => setFormData({ ...formData, mensaje: e.target.value })}
                    placeholder="Escribe tu mensaje aquí..."
                    rows={5}
                  />
                </div>

                <button type="submit" disabled={submitting} className={styles.submitButton}>
                  {submitting ? 'Enviando...' : '📨 Enviar Mensaje'}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    );
  }

  // Vista de administrador
  return (
    <div className={styles.page}>
      <div className={styles.container}>
        <div className={styles.header}>
          <h1 className={styles.title}>Buzón de Mensajes de Contacto</h1>
          <p className={styles.subtitle}>
            Panel de administración para gestionar todos los mensajes de contacto recibidos.
          </p>
        </div>

        {loading && (
          <div className={styles.loading}>
            <div className={styles.spinner}></div>
            <p>Cargando mensajes...</p>
          </div>
        )}

        {!loading && mensajes.length === 0 && (
          <div className={styles.empty}>
            <p>No hay mensajes de contacto en el sistema.</p>
          </div>
        )}

        {!loading && mensajes.length > 0 && (
          <div className={styles.messagesGrid}>
            {mensajes.map((mensaje) => (
              <div key={mensaje.id} className={styles.messageCard}>
                <div className={styles.messageHeader}>
                  <div>
                    <h3>{mensaje.nombre_apellidos}</h3>
                    <p className={styles.messageDate}>{formatDate(mensaje.created_at)}</p>
                  </div>
                  <span className={styles.messageId}>#{mensaje.id}</span>
                </div>
                
                <div className={styles.messageContact}>
                  <span>📧 {mensaje.email}</span>
                  <span>📞 {mensaje.telefono}</span>
                </div>

                <p className={styles.messagePreview}>
                  {mensaje.mensaje.substring(0, 120)}
                  {mensaje.mensaje.length > 120 && '...'}
                </p>

                <div className={styles.messageActions}>
                  <button onClick={() => handleView(mensaje)} className={styles.viewButton}>
                    👁️ Ver
                  </button>
                  <button onClick={() => handleEdit(mensaje)} className={styles.editButton}>
                    ✏️ Editar
                  </button>
                  <button onClick={() => handleDelete(mensaje.id)} className={styles.deleteButton}>
                    🗑️ Eliminar
                  </button>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>

      {/* Modal: Ver mensaje completo */}
      {viewingMensaje && (
        <div className={styles.modalOverlay} onClick={closeModal}>
          <div className={styles.modal} onClick={(e) => e.stopPropagation()}>
            <div className={styles.modalHeader}>
              <h2>Mensaje #{viewingMensaje.id}</h2>
              <button onClick={closeModal} className={styles.closeButton}>✕</button>
            </div>

            <div className={styles.modalContent}>
              <div className={styles.viewField}>
                <label>Nombre y Apellidos</label>
                <p>{viewingMensaje.nombre_apellidos}</p>
              </div>

              <div className={styles.viewField}>
                <label>Email</label>
                <p>{viewingMensaje.email}</p>
              </div>

              <div className={styles.viewField}>
                <label>Teléfono</label>
                <p>{viewingMensaje.telefono}</p>
              </div>

              <div className={styles.viewField}>
                <label>Mensaje</label>
                <p className={styles.messageText}>{viewingMensaje.mensaje}</p>
              </div>

              <div className={styles.viewField}>
                <label>Fecha de recepción</label>
                <p>{formatDate(viewingMensaje.created_at)}</p>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Modal: Editar mensaje */}
      {editingMensaje && (
        <div className={styles.modalOverlay} onClick={closeModal}>
          <div className={styles.modal} onClick={(e) => e.stopPropagation()}>
            <div className={styles.modalHeader}>
              <h2>Editar Mensaje #{editingMensaje.id}</h2>
              <button onClick={closeModal} className={styles.closeButton}>✕</button>
            </div>

            <form className={styles.modalForm} onSubmit={handleSubmit}>
              <div className={styles.formGroup}>
                <label>Nombre y Apellidos *</label>
                <input
                  type="text"
                  required
                  value={formData.nombre_apellidos}
                  onChange={(e) => setFormData({ ...formData, nombre_apellidos: e.target.value })}
                />
              </div>

              <div className={styles.formGroup}>
                <label>Email *</label>
                <input
                  type="email"
                  required
                  value={formData.email}
                  onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                />
              </div>

              <div className={styles.formGroup}>
                <label>Teléfono *</label>
                <input
                  type="tel"
                  required
                  value={formData.telefono}
                  onChange={(e) => setFormData({ ...formData, telefono: e.target.value })}
                />
              </div>

              <div className={styles.formGroup}>
                <label>Mensaje *</label>
                <textarea
                  required
                  value={formData.mensaje}
                  onChange={(e) => setFormData({ ...formData, mensaje: e.target.value })}
                  rows={5}
                />
              </div>

              <div className={styles.modalActions}>
                <button type="button" onClick={closeModal} className={styles.cancelButton}>
                  Cancelar
                </button>
                <button type="submit" disabled={submitting} className={styles.saveButton}>
                  {submitting ? 'Guardando...' : 'Guardar Cambios'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default Contacto;