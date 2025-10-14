import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import { vi } from 'vitest';
import Contacto from '@pages/Contacto';
import * as contactoService from '@services/contactoService';
import * as AuthContext from '@context/AuthContext';
import * as ToastContext from '@context/ToastContext';

vi.mock('@services/contactoService');
vi.mock('@context/AuthContext');
vi.mock('@context/ToastContext');

const mockMensajes = [
  {
    id: 1,
    nombre_apellidos: 'Juan García López',
    email: 'juan@example.com',
    telefono: '+34 612 345 678',
    mensaje: 'Hola, me gustaría obtener más información sobre sus servicios',
    created_at: '2024-01-15T10:30:00Z',
    updated_at: '2024-01-15T10:30:00Z'
  },
  {
    id: 2,
    nombre_apellidos: 'María Rodríguez',
    email: 'maria@example.com',
    telefono: '+34 687 654 321',
    mensaje: 'Buenos días, quisiera solicitar una cotización',
    created_at: '2024-01-16T14:25:00Z',
    updated_at: '2024-01-16T14:25:00Z'
  }
];

describe('Contacto Component', () => {
  const mockShowToast = vi.fn();

  beforeEach(() => {
    vi.clearAllMocks();
    
    vi.mocked(ToastContext.useToast).mockReturnValue({
      showToast: mockShowToast
    });
  });

  test('muestra el formulario de contacto para usuarios no autenticados', () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: null,
      isAuthenticated: false
    });

    render(<Contacto />);

    // Verificar que se muestra el formulario público
    expect(screen.getByText('Contáctanos')).toBeInTheDocument();
    expect(screen.getByText('Envíanos un mensaje')).toBeInTheDocument();
    
    // Verificar inputs usando placeholders
    expect(screen.getByPlaceholderText('Juan García López')).toBeInTheDocument();
    expect(screen.getByPlaceholderText('juan.garcia@ejemplo.com')).toBeInTheDocument();
    expect(screen.getByPlaceholderText('+34 612 345 678')).toBeInTheDocument();
    expect(screen.getByPlaceholderText('Escribe tu mensaje aquí...')).toBeInTheDocument();
    
    // Verificar información de contacto
    expect(screen.getByText(/Calle de la Vida, 42/i)).toBeInTheDocument();
    expect(screen.getByText(/contacto@finsmart.es/i)).toBeInTheDocument();
  });

  test('permite enviar un mensaje de contacto como usuario no autenticado', async () => {
    const user = userEvent.setup();
    
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: null,
      isAuthenticated: false
    });

    vi.mocked(contactoService.createMensaje).mockResolvedValue({
      message: 'Mensaje creado',
      data: mockMensajes[0]
    });

    render(<Contacto />);

    // Rellenar el formulario usando placeholders
    await user.type(screen.getByPlaceholderText('Juan García López'), 'Juan García');
    await user.type(screen.getByPlaceholderText('juan.garcia@ejemplo.com'), 'juan@test.com');
    await user.type(screen.getByPlaceholderText('+34 612 345 678'), '+34 612345678');
    await user.type(screen.getByPlaceholderText('Escribe tu mensaje aquí...'), 'Test mensaje');

    // Enviar formulario
    const submitButton = screen.getByText(/Enviar Mensaje/i);
    await user.click(submitButton);

    // Verificar que se llamó al servicio
    await waitFor(() => {
      expect(contactoService.createMensaje).toHaveBeenCalledWith({
        nombre_apellidos: 'Juan García',
        email: 'juan@test.com',
        telefono: '+34 612345678',
        mensaje: 'Test mensaje'
      });
      expect(mockShowToast).toHaveBeenCalledWith(
        expect.stringContaining('Mensaje enviado correctamente')
      );
    });
  });

  test('muestra buzón de mensajes para administrador', async () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'admin' },
      isAuthenticated: true
    });

    vi.mocked(contactoService.getAllMensajes).mockResolvedValue(mockMensajes);

    render(<Contacto />);

    // Verificar que se muestra el título del buzón
    await waitFor(() => {
      expect(screen.getByText('Buzón de Mensajes de Contacto')).toBeInTheDocument();
    });

    // Verificar que se muestran los mensajes
    expect(screen.getByText('Juan García López')).toBeInTheDocument();
    expect(screen.getByText('María Rodríguez')).toBeInTheDocument();

    // Verificar que se muestran los botones de admin
    const viewButtons = screen.getAllByText(/Ver/i);
    expect(viewButtons.length).toBeGreaterThan(0);
    
    const editButtons = screen.getAllByText(/Editar/i);
    expect(editButtons.length).toBeGreaterThan(0);
    
    const deleteButtons = screen.getAllByText(/Eliminar/i);
    expect(deleteButtons.length).toBeGreaterThan(0);
  });

  test('permite ver mensaje completo en modal como administrador', async () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'admin' },
      isAuthenticated: true
    });

    vi.mocked(contactoService.getAllMensajes).mockResolvedValue(mockMensajes);

    render(<Contacto />);

    await waitFor(() => {
      expect(screen.getByText('Juan García López')).toBeInTheDocument();
    });

    // Hacer clic en Ver
    const viewButtons = screen.getAllByText(/👁️ Ver/i);
    fireEvent.click(viewButtons[0]);

    // Verificar que se abre el modal
    await waitFor(() => {
      expect(screen.getByText(/Mensaje #1/i)).toBeInTheDocument();
    });
    
    // El mensaje aparece en preview y en modal, verificar que hay al menos 2
    const mensajeElements = screen.getAllByText(mockMensajes[0].mensaje);
    expect(mensajeElements.length).toBeGreaterThanOrEqual(2);
  });

  test('permite eliminar un mensaje como administrador', async () => {
    global.confirm = vi.fn(() => true);

    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'admin' },
      isAuthenticated: true
    });

    vi.mocked(contactoService.getAllMensajes).mockResolvedValue(mockMensajes);
    vi.mocked(contactoService.deleteMensaje).mockResolvedValue({
      message: 'Mensaje eliminado'
    });

    render(<Contacto />);

    await waitFor(() => {
      expect(screen.getByText('Juan García López')).toBeInTheDocument();
    });

    // Hacer clic en Eliminar
    const deleteButtons = screen.getAllByText(/🗑️ Eliminar/i);
    fireEvent.click(deleteButtons[0]);

    // Verificar que se llamó al servicio
    await waitFor(() => {
      expect(contactoService.deleteMensaje).toHaveBeenCalledWith(1);
      expect(mockShowToast).toHaveBeenCalledWith('Mensaje eliminado correctamente');
    });
  });

  test('muestra mensaje vacío cuando no hay mensajes en buzón de admin', async () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'admin' },
      isAuthenticated: true
    });

    vi.mocked(contactoService.getAllMensajes).mockResolvedValue([]);

    render(<Contacto />);

    await waitFor(() => {
      expect(screen.getByText('No hay mensajes de contacto en el sistema.')).toBeInTheDocument();
    });
  });
});