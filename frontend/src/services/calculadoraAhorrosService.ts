import api from '@services/api';

export interface CalculadoraAhorros {
  id: number;
  ingreso_mensual: number;
  id_usuario: number;
  necesidad: number;
  ocio: number;
  ahorros: number;
  created_at: string;
  updated_at: string;
}

export interface Usuario {
  id: number;
  name: string;
  email: string;
  created_at: string;
  updated_at: string;
}

/**
 * Get authenticated user
 */
export const getAuthUser = async (): Promise<Usuario> => {
  const response = await api.get<Usuario>('/user');
  return response.data;
};

/**
 * Get all calculadoras (admin only)
 */
export const getAllCalculadoras = async (): Promise<CalculadoraAhorros[]> => {
  const response = await api.get<CalculadoraAhorros[]>('/calculadora-ahorros');
  return response.data;
};

/**
 * Get calculadora by user ID
 */
export const getCalculadoraByUserId = async (userId: number): Promise<CalculadoraAhorros> => {
  const response = await api.get<CalculadoraAhorros>(`/calculadora-ahorros/${userId}`);
  return response.data;
};

/**
 * Update calculadora by user ID
 */
export const updateCalculadora = async (
  userId: number, 
  data: { ingreso_mensual: number }
): Promise<CalculadoraAhorros> => {
  const response = await api.put<CalculadoraAhorros>(`/calculadora-ahorros/${userId}`, data);
  return response.data;
};

/**
 * Reset calculadora by user ID (set ingreso_mensual to 0)
 */
export const resetCalculadora = async (userId: number): Promise<{ message: string }> => {
  const response = await api.delete<{ message: string }>(`/calculadora-ahorros/${userId}`);
  return response.data;
};