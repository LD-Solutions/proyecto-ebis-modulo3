import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import { vi } from 'vitest';
import Empleados from '@pages/Empleados';
import * as empleadosService from '@services/empleadosService';
import * as AuthContext from '@context/AuthContext';
import * as ToastContext from '@context/ToastContext';

// Mock de los servicios
vi.mock('@services/empleadosService');
vi.mock('@context/AuthContext');
vi.mock('@context/ToastContext');

const mockEmpleados = [
  {
    id: 1,
    nombre: 'Juan',
    apellido: 'García',
    cargo: 'Desarrollador Full Stack',
    imagen_url: 'https://example.com/juan.jpg',
    created_at: '2024-01-01T00:00:00Z',
    updated_at: '2024-01-01T00:00:00Z'
  },
  {
    id: 2,
    nombre: 'María',
    apellido: 'Rodríguez',
    cargo: 'Diseñadora UX/UI',
    imagen_url: 'https://example.com/maria.jpg',
    created_at: '2024-01-02T00:00:00Z',
    updated_at: '2024-01-02T00:00:00Z'
  }
];

describe('Empleados Component', () => {
  const mockShowToast = vi.fn();
  
  beforeEach(() => {
    vi.clearAllMocks();
    
    // Mock del contexto de Toast
    vi.mocked(ToastContext.useToast).mockReturnValue({
      showToast: mockShowToast
    });
  });

  test('muestra el loading spinner mientras carga los datos', () => {
    // Mock usuario autenticado
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    // Mock de getEmpleados que nunca se resuelve
    vi.mocked(empleadosService.getEmpleados).mockImplementation(
      () => new Promise(() => {})
    );

    render(<Empleados />);
    
    expect(screen.getByText('Cargando empleados...')).toBeInTheDocument();
  });

  test('muestra los empleados agrupados por departamento para usuario normal', async () => {
    // Mock usuario normal
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    // Mock de getEmpleados
    vi.mocked(empleadosService.getEmpleados).mockResolvedValue({
      data: mockEmpleados
    });

    render(<Empleados />);

    // Esperar a que se carguen los empleados
    await waitFor(() => {
      expect(screen.getByText('Conoce a nuestro equipo')).toBeInTheDocument();
    });

    // Verificar que se muestran los departamentos
    expect(screen.getByText('Desarrollador')).toBeInTheDocument();
    expect(screen.getByText('Diseñadora')).toBeInTheDocument();

    // Verificar que se muestran los empleados
    expect(screen.getByText('Juan García')).toBeInTheDocument();
    expect(screen.getByText('María Rodríguez')).toBeInTheDocument();

    // Verificar que NO se muestran botones de admin
    expect(screen.queryByText('Editar')).not.toBeInTheDocument();
    expect(screen.queryByText('Eliminar')).not.toBeInTheDocument();
  });

  test('muestra botones de admin y permite crear empleado como administrador', async () => {
    // Mock usuario admin
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'admin' },
      isAuthenticated: true
    });

    vi.mocked(empleadosService.getEmpleados).mockResolvedValue({
      data: mockEmpleados
    });

    render(<Empleados />);

    await waitFor(() => {
      expect(screen.getByText('Conoce a nuestro equipo')).toBeInTheDocument();
    });

    // Verificar que se muestra el botón de agregar
    expect(screen.getByText('+ Agregar Empleado')).toBeInTheDocument();

    // Verificar que se muestran botones de editar/eliminar
    const editButtons = screen.getAllByText('Editar');
    expect(editButtons.length).toBeGreaterThan(0);

    const deleteButtons = screen.getAllByText('Eliminar');
    expect(deleteButtons.length).toBeGreaterThan(0);

    // Abrir modal de crear
    fireEvent.click(screen.getByText('+ Agregar Empleado'));

    // Verificar que se abre el modal
    await waitFor(() => {
      expect(screen.getByText('Nuevo Empleado')).toBeInTheDocument();
    });
  });

  test('muestra mensaje de error cuando falla la carga de empleados', async () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    // Mock de error
    vi.mocked(empleadosService.getEmpleados).mockRejectedValue(
      new Error('Error de red')
    );

    render(<Empleados />);

    await waitFor(() => {
      expect(screen.getByText(/Error al cargar los empleados/i)).toBeInTheDocument();
    });

    // Verificar que se muestra el botón de reintentar
    expect(screen.getByText('Reintentar')).toBeInTheDocument();
  });

  test('permite eliminar un empleado como administrador', async () => {
    // Mock window.confirm
    global.confirm = vi.fn(() => true);

    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'admin' },
      isAuthenticated: true
    });

    vi.mocked(empleadosService.getEmpleados).mockResolvedValue({
      data: mockEmpleados
    });

    vi.mocked(empleadosService.deleteEmpleado).mockResolvedValue();

    render(<Empleados />);

    await waitFor(() => {
      expect(screen.getByText('Juan García')).toBeInTheDocument();
    });

    // Hacer clic en eliminar
    const deleteButtons = screen.getAllByText('Eliminar');
    fireEvent.click(deleteButtons[0]);

    // Verificar que se llamó a deleteEmpleado
    await waitFor(() => {
      expect(empleadosService.deleteEmpleado).toHaveBeenCalledWith(1);
      expect(mockShowToast).toHaveBeenCalledWith('Empleado eliminado correctamente');
    });
  });
});