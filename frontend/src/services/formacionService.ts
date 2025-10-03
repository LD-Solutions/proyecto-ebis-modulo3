import api from './api';

export interface Formacion {
  id: number;
  titulo: string;
  descripcion: string;
  tipo: 'curso' | 'video' | 'libro' | 'webinar';
  nivel: 'principiante' | 'intermedio' | 'avanzado';
  duracion: string;
  instructor: string;
  url?: string;
  imagen?: string;
  created_at: string;
}

export interface FormacionesResponse {
  data: Formacion[];
  meta?: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

export interface FormacionFilters {
  tipo?: 'curso' | 'video' | 'libro' | 'webinar' | null;
  nivel?: 'principiante' | 'intermedio' | 'avanzado' | null;
  page?: number;
  per_page?: number;
}

/**
 * Fetch formaciones with optional filters
 */
export const getFormaciones = async (filters?: FormacionFilters): Promise<FormacionesResponse> => {
  const params = new URLSearchParams();

  if (filters?.tipo) params.append('tipo', filters.tipo);
  if (filters?.nivel) params.append('nivel', filters.nivel);
  if (filters?.page) params.append('page', filters.page.toString());
  if (filters?.per_page) params.append('per_page', filters.per_page.toString());

  const response = await api.get<FormacionesResponse>(`/formaciones?${params.toString()}`);
  return response.data;
};

/**
 * Get a single formacion by ID
 */
export const getFormacion = async (id: number): Promise<Formacion> => {
  const response = await api.get<Formacion>(`/formaciones/${id}`);
  return response.data;
};

/**
 * Update a formacion
 */
export const updateFormacion = async (id: number, data: Partial<Formacion>): Promise<Formacion> => {
  const response = await api.put<Formacion>(`/formaciones/${id}`, data);
  return response.data;
};

/**
 * Delete a formacion
 */
export const deleteFormacion = async (id: number): Promise<void> => {
  await api.delete(`/formaciones/${id}`);
};