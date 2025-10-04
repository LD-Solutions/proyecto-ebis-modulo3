export const CATEGORIAS = [
  'finanzas',
  'inversión',
  'tecnología',
  'economía',
  'mercados',
  'criptomonedas'
] as const;

export type Categoria = typeof CATEGORIAS[number];

export const categoryColors: Record<string, string> = {
  'finanzas': '#3b82f6',
  'inversión': '#10b981',
  'tecnología': '#8b5cf6',
  'economía': '#f59e0b',
  'mercados': '#06b6d4',
  'criptomonedas': '#ec4899',
  'default': '#6b7280'
};

export const getCategoryColor = (categoria: string): string => {
  const normalized = categoria.toLowerCase();
  return categoryColors[normalized] || categoryColors['default'];
};
