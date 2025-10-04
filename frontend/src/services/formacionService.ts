import api from '@services/api';

export interface Formacion {
  id: number;
  titulo: string;
  descripcion: string;
  instructor: string;
  duracion_horas?: number;
  precio: number;
  tipo: 'curso' | 'video' | 'libro' | 'webinar';
  categoria: string;
  nivel: 'principiante' | 'intermedio' | 'avanzado';
  fecha_inicio?: string;
  archivo_path?: string;
  paginas?: number;
  url_video?: string;
  created_at: string;
  updated_at: string;
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
 * Create a new formacion
 */
export const createFormacion = async (data: Omit<Formacion, 'id' | 'created_at' | 'updated_at'>): Promise<Formacion> => {
  const response = await api.post<Formacion>('/formaciones', data);
  return response.data;
};

/**
 * Delete a formacion
 */
export const deleteFormacion = async (id: number): Promise<void> => {
  await api.delete(`/formaciones/${id}`);
};