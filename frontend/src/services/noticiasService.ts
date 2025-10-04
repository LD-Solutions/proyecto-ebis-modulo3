import api from '@services/api';

export interface Noticia {
  id: number;
  titulo: string;
  contenido: string;
  fecha_publicacion: string;
  autor: string;
  categoria: string;
  imagen_url?: string;
  created_at: string;
  updated_at: string;
}

export interface NoticiasResponse {
  data: Noticia[];
  meta?: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

export interface NoticiasFilters {
  page?: number;
  per_page?: number;
}

/**
 * Fetch noticias with optional filters
 */
export const getNoticias = async (filters?: NoticiasFilters): Promise<NoticiasResponse> => {
  const params = new URLSearchParams();

  if (filters?.page) params.append('page', filters.page.toString());
  if (filters?.per_page) params.append('per_page', filters.per_page.toString());

  const response = await api.get<NoticiasResponse>(`/noticias?${params.toString()}`);
  return response.data;
};

/**
 * Get a single noticia by ID
 */
export const getNoticia = async (id: number): Promise<Noticia> => {
  const response = await api.get<Noticia>(`/noticias/${id}`);
  return response.data;
};

/**
 * Update a noticia
 */
export const updateNoticia = async (id: number, data: Partial<Noticia>): Promise<Noticia> => {
  const response = await api.put<Noticia>(`/noticias/${id}`, data);
  return response.data;
};

/**
 * Create a new noticia
 */
export const createNoticia = async (data: Omit<Noticia, 'id' | 'created_at' | 'updated_at'>): Promise<Noticia> => {
  const response = await api.post<Noticia>('/noticias', data);
  return response.data;
};

/**
 * Delete a noticia
 */
export const deleteNoticia = async (id: number): Promise<void> => {
  await api.delete(`/noticias/${id}`);
};
