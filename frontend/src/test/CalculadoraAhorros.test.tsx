import { render, screen, waitFor, fireEvent } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import { vi } from 'vitest';
import CalculadoraAhorros from '@pages/CalculadoraAhorros';
import * as calculadoraService from '@services/calculadoraAhorrosService';
import * as AuthContext from '@context/AuthContext';
import * as ToastContext from '@context/ToastContext';

vi.mock('@services/calculadoraAhorrosService');
vi.mock('@context/AuthContext');
vi.mock('@context/ToastContext');

const mockUsuario = {
  id: 1,
  name: 'Test User',
  email: 'test@example.com',
  created_at: '2024-01-01T00:00:00Z',
  updated_at: '2024-01-01T00:00:00Z'
};

const mockCalculadora = {
  id: 1,
  ingreso_mensual: 2500,
  id_usuario: 1,
  necesidad: 1250,
  ocio: 750,
  ahorros: 500,
  created_at: '2024-01-01T00:00:00Z',
  updated_at: '2024-01-01T00:00:00Z'
};

const mockAllCalculadoras = [
  mockCalculadora,
  {
    id: 2,
    ingreso_mensual: 3000,
    id_usuario: 2,
    necesidad: 1500,
    ocio: 900,
    ahorros: 600,
    created_at: '2024-01-02T00:00:00Z',
    updated_at: '2024-01-02T00:00:00Z'
  }
];

describe('CalculadoraAhorros Component', () => {
  const mockShowToast = vi.fn();

  beforeEach(() => {
    vi.clearAllMocks();
    
    vi.mocked(ToastContext.useToast).mockReturnValue({
      showToast: mockShowToast
    });
  });

  test('muestra pantalla de login requerido para usuarios no autenticados', () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: null,
      isAuthenticated: false
    });

    render(<CalculadoraAhorros />);

    // Verificar que se muestra el mensaje de login requerido
    expect(screen.getByText('Inicia sesión para usar la calculadora')).toBeInTheDocument();
    expect(screen.getByText(/Necesitas estar autenticado/i)).toBeInTheDocument();
    
    // Verificar que se muestra el botón de login
    expect(screen.getByText('Iniciar sesión')).toBeInTheDocument();
    
    // Verificar que se muestra información educativa
    expect(screen.getByText(/¿Cómo usar la calculadora 50\/30\/20\?/i)).toBeInTheDocument();
  });

  test('carga y muestra la calculadora del usuario normal', async () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    vi.mocked(calculadoraService.getAuthUser).mockResolvedValue(mockUsuario);
    vi.mocked(calculadoraService.getCalculadoraByUserId).mockResolvedValue(mockCalculadora);

    render(<CalculadoraAhorros />);

    // Esperar a que se cargue
    await waitFor(() => {
      expect(screen.getByText('Calculadora de ahorro 50/30/20')).toBeInTheDocument();
    });

    // Verificar que se cargó el ingreso mensual
    const input = screen.getByPlaceholderText('0') as HTMLInputElement;
    expect(input.value).toBe('2500');

    // Verificar los resultados calculados (50/30/20) - sin puntos de miles
    expect(screen.getByText((content, element) => {
      return element?.textContent === '1250 €' || element?.textContent === '1.250 €';
    })).toBeInTheDocument();
    
    expect(screen.getByText((content, element) => {
      return element?.textContent === '750 €';
    })).toBeInTheDocument();
    
    expect(screen.getByText((content, element) => {
      return element?.textContent === '500 €';
    })).toBeInTheDocument();
  });

  test('calcula correctamente los porcentajes al cambiar el ingreso', async () => {
    const user = userEvent.setup();
    
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    vi.mocked(calculadoraService.getAuthUser).mockResolvedValue(mockUsuario);
    vi.mocked(calculadoraService.getCalculadoraByUserId).mockResolvedValue({
      ...mockCalculadora,
      ingreso_mensual: 0
    });

    render(<CalculadoraAhorros />);

    await waitFor(() => {
      expect(screen.getByText('Calculadora de ahorro 50/30/20')).toBeInTheDocument();
    });

    // Cambiar el ingreso
    const input = screen.getByPlaceholderText('0');
    await user.clear(input);
    await user.type(input, '3000');

    // Verificar los nuevos cálculos
    await waitFor(() => {
      expect(screen.getByText((content, element) => {
        return element?.textContent === '1500 €' || element?.textContent === '1.500 €';
      })).toBeInTheDocument();
      
      expect(screen.getByText((content, element) => {
        return element?.textContent === '900 €';
      })).toBeInTheDocument();
      
      expect(screen.getByText((content, element) => {
        return element?.textContent === '600 €';
      })).toBeInTheDocument();
    });
  });

  test('cambia entre vista mensual y anual', async () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    vi.mocked(calculadoraService.getAuthUser).mockResolvedValue(mockUsuario);
    vi.mocked(calculadoraService.getCalculadoraByUserId).mockResolvedValue(mockCalculadora);

    render(<CalculadoraAhorros />);

    await waitFor(() => {
      expect(screen.getByText('Calculadora de ahorro 50/30/20')).toBeInTheDocument();
    });

    // Verificar cálculo mensual inicial (2500)
    expect(screen.getByText((content, element) => {
      return element?.textContent === '1250 €' || element?.textContent === '1.250 €';
    })).toBeInTheDocument();

    // Cambiar a vista anual
    const checkbox = screen.getByRole('checkbox');
    fireEvent.click(checkbox);

    // Verificar cálculo anual (2500 * 12 = 30000 * 0.5 = 15000)
    await waitFor(() => {
      expect(screen.getByText((content, element) => {
        return element?.textContent === '15000 €' || element?.textContent === '15.000 €';
      })).toBeInTheDocument();
      
      expect(screen.getByText((content, element) => {
        return element?.textContent === '9000 €' || element?.textContent === '9.000 €';
      })).toBeInTheDocument();
      
      expect(screen.getByText((content, element) => {
        return element?.textContent === '6000 €' || element?.textContent === '6.000 €';
      })).toBeInTheDocument();
    });
  });

  test('permite guardar la calculadora como usuario normal', async () => {
    const user = userEvent.setup();
    
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    vi.mocked(calculadoraService.getAuthUser).mockResolvedValue(mockUsuario);
    vi.mocked(calculadoraService.getCalculadoraByUserId).mockResolvedValue(mockCalculadora);
    vi.mocked(calculadoraService.updateCalculadora).mockResolvedValue(mockCalculadora);

    render(<CalculadoraAhorros />);

    await waitFor(() => {
      expect(screen.getByText('Calculadora de ahorro 50/30/20')).toBeInTheDocument();
    });

    // Cambiar el ingreso
    const input = screen.getByPlaceholderText('0');
    await user.clear(input);
    await user.type(input, '3000');

    // Hacer clic en guardar
    const saveButton = screen.getByText(/💾 Guardar/i);
    await user.click(saveButton);

    // Verificar que se llamó al servicio
    await waitFor(() => {
      expect(calculadoraService.updateCalculadora).toHaveBeenCalledWith(1, {
        ingreso_mensual: 3000
      });
      expect(mockShowToast).toHaveBeenCalledWith('Calculadora guardada correctamente');
    });
  });

  test('muestra panel de administrador con lista de usuarios', async () => {
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'admin' },
      isAuthenticated: true
    });

    vi.mocked(calculadoraService.getAuthUser).mockResolvedValue(mockUsuario);
    vi.mocked(calculadoraService.getAllCalculadoras).mockResolvedValue(mockAllCalculadoras);

    render(<CalculadoraAhorros />);

    await waitFor(() => {
      expect(screen.getByText('Calculadora de ahorro 50/30/20')).toBeInTheDocument();
    });

    // Verificar que se muestra el panel de admin
    expect(screen.getByText(/Panel de Administrador/i)).toBeInTheDocument();

    // Verificar que se muestran los usuarios
    expect(screen.getByText(/Usuario ID: 1/i)).toBeInTheDocument();
    expect(screen.getByText(/Usuario ID: 2/i)).toBeInTheDocument();
  });

  test('permite resetear la calculadora', async () => {
    global.confirm = vi.fn(() => true);
    
    vi.mocked(AuthContext.useAuth).mockReturnValue({
      user: { id: 1, role: 'user' },
      isAuthenticated: true
    });

    vi.mocked(calculadoraService.getAuthUser).mockResolvedValue(mockUsuario);
    vi.mocked(calculadoraService.getCalculadoraByUserId).mockResolvedValue(mockCalculadora);
    vi.mocked(calculadoraService.resetCalculadora).mockResolvedValue({
      message: 'Calculadora reseteada'
    });

    render(<CalculadoraAhorros />);

    await waitFor(() => {
      expect(screen.getByText('Calculadora de ahorro 50/30/20')).toBeInTheDocument();
    });

    // Hacer clic en resetear
    const resetButton = screen.getByText(/🔄 Resetear/i);
    fireEvent.click(resetButton);

    // Verificar que se llamó al servicio
    await waitFor(() => {
      expect(calculadoraService.resetCalculadora).toHaveBeenCalledWith(1);
      expect(mockShowToast).toHaveBeenCalledWith('Calculadora reseteada correctamente');
    });

    // Verificar que el input se resetea (puede quedar vacío)
    const input = screen.getByPlaceholderText('0') as HTMLInputElement;
    expect(input.value).toBe('');
  });
});