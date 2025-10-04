import api from '@services/api';

export interface IndexFund {
  name: string;
  symbol: string;
  current_price: number;
}

export interface Portfolio {
  id: number;
  symbol: string;
  shares: number;
  purchase_price: number;
  current_value: number;
  profit_loss: number;
  index_fund: IndexFund;
}

export interface PortfolioSummary {
  balance: number;
  total_portfolio_value: number;
  total_invested: number;
  total_profit_loss: number;
  holdings: Portfolio[];
}

export interface BuyNewRequest {
  symbol: string;
  shares: number;
}

export interface BuySellRequest {
  action: 'buy' | 'sell';
  shares: number;
}

export const portfolioService = {
  // GET /api/portfolios - Get all portfolio holdings
  getPortfolio: async (): Promise<PortfolioSummary> => {
    const response = await api.get<PortfolioSummary>('/portfolios');
    return response.data;
  },

  // GET /api/portfolios/:id - Get specific holding
  getHolding: async (id: number): Promise<Portfolio> => {
    const response = await api.get<Portfolio>(`/portfolios/${id}`);
    return response.data;
  },

  // POST /api/portfolios - Buy new position
  buyNew: async (data: BuyNewRequest): Promise<Portfolio> => {
    const response = await api.post<Portfolio>('/portfolios', data);
    return response.data;
  },

  // PUT /api/portfolios/:id - Buy more or sell shares
  buySell: async (id: number, data: BuySellRequest): Promise<Portfolio> => {
    const response = await api.put<Portfolio>(`/portfolios/${id}`, data);
    return response.data;
  },

  // DELETE /api/portfolios/:id - Sell all shares
  sellAll: async (id: number): Promise<{ message: string; sale_value: number }> => {
    const response = await api.delete(`/portfolios/${id}`);
    return response.data;
  },
};
