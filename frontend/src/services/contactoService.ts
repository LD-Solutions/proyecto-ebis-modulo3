import api from '@services/api';

export interface MensajeContacto {
  id: number;
  nombre_apellidos: string;
  email: string;
  telefono: string;
  mensaje: string;
  created_at: string;
  updated_at: string;
}

export interface CreateMensajeContacto {
  nombre_apellidos: string;
  email: string;
  telefono: string;
  mensaje: string;
}

export interface MensajeContactoResponse {
  message: string;
  data: MensajeContacto;
}

/**
 * Get all mensajes de contacto (admin only)
 */
export const getAllMensajes = async (): Promise<MensajeContacto[]> => {
  const response = await api.get<MensajeContacto[]>('/mensajes-contacto');
  return response.data;
};

/**
 * Get a single mensaje de contacto by ID (admin only)
 */
export const getMensajeById = async (id: number): Promise<MensajeContacto> => {
  const response = await api.get<MensajeContacto>(`/mensajes-contacto/${id}`);
  return response.data;
};

/**
 * Create a new mensaje de contacto (public)
 */
export const createMensaje = async (data: CreateMensajeContacto): Promise<MensajeContactoResponse> => {
  const response = await api.post<MensajeContactoResponse>('/mensajes-contacto', data);
  return response.data;
};

/**
 * Update a mensaje de contacto (admin only)
 */
export const updateMensaje = async (id: number, data: Partial<CreateMensajeContacto>): Promise<MensajeContactoResponse> => {
  const response = await api.put<MensajeContactoResponse>(`/mensajes-contacto/${id}`, data);
  return response.data;
};

/**
 * Delete a mensaje de contacto (admin only)
 */
export const deleteMensaje = async (id: number): Promise<{ message: string }> => {
  const response = await api.delete<{ message: string }>(`/mensajes-contacto/${id}`);
  return response.data;
};