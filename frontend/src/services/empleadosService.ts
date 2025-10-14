import api from '@services/api';

export interface Empleado {
  id: number;
  nombre: string;
  apellido: string;
  cargo: string;
  imagen_url: string;
  created_at: string;
  updated_at: string;
}

export interface EmpleadosResponse {
  data: Empleado[];
  meta?: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

/**
 * Fetch all empleados
 */
export const getEmpleados = async (): Promise<EmpleadosResponse> => {
  const response = await api.get<EmpleadosResponse>('/empleados');
  return response.data;
};

/**
 * Get a single empleado by ID
 */
export const getEmpleado = async (id: number): Promise<Empleado> => {
  const response = await api.get<Empleado>(`/empleados/${id}`);
  return response.data;
};

/**
 * Create a new empleado
 */
export const createEmpleado = async (data: Omit<Empleado, 'id' | 'created_at' | 'updated_at'>): Promise<Empleado> => {
  const response = await api.post<Empleado>('/empleados', data);
  return response.data;
};

/**
 * Update an empleado
 */
export const updateEmpleado = async (id: number, data: Partial<Empleado>): Promise<Empleado> => {
  const response = await api.put<Empleado>(`/empleados/${id}`, data);
  return response.data;
};

/**
 * Delete an empleado
 */
export const deleteEmpleado = async (id: number): Promise<void> => {
  await api.delete(`/empleados/${id}`);
};