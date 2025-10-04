import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '@context/AuthContext';
import { useToast } from '@context/ToastContext';
import { portfolioService } from '@services/portfolioService';
import type {Portfolio as PortfolioType, PortfolioSummary} from '@services/portfolioService';
import styles from './Portfolio.module.css';

export default function Portfolio() {
  const { user } = useAuth();
  const { showToast } = useToast();
  const navigate = useNavigate();

  const [summary, setSummary] = useState<PortfolioSummary | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  // Modal states
  const [showBuyNewModal, setShowBuyNewModal] = useState(false);
  const [showBuyMoreModal, setShowBuyMoreModal] = useState(false);
  const [showSellModal, setShowSellModal] = useState(false);
  const [selectedHolding, setSelectedHolding] = useState<PortfolioType | null>(null);

  // Form states
  const [symbol, setSymbol] = useState('');
  const [shares, setShares] = useState('');
  const [submitting, setSubmitting] = useState(false);

  useEffect(() => {
    if (!user) {
      navigate('/login', { state: { from: '/cartera' } });
      return;
    }
    loadPortfolio();
  }, [user, navigate]);

  const loadPortfolio = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await portfolioService.getPortfolio();
      setSummary(data);
    } catch (err: any) {
      console.error('Error loading portfolio:', err);
      setError(err.response?.data?.message || 'Error al cargar la cartera');
    } finally {
      setLoading(false);
    }
  };

  const handleBuyNew = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!symbol || !shares) return;

    setSubmitting(true);
    try {
      await portfolioService.buyNew({
        symbol: symbol.trim(),
        shares: parseFloat(shares),
      });
      showToast('Compra realizada exitosamente', 'success');
      setShowBuyNewModal(false);
      setSymbol('');
      setShares('');
      await loadPortfolio();
    } catch (err: any) {
      showToast(err.response?.data?.error || 'Error al realizar la compra', 'error');
    } finally {
      setSubmitting(false);
    }
  };

  const handleBuyMore = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedHolding || !shares) return;

    setSubmitting(true);
    try {
      await portfolioService.buySell(selectedHolding.id, {
        action: 'buy',
        shares: parseFloat(shares),
      });
      showToast('Compra adicional realizada exitosamente', 'success');
      setShowBuyMoreModal(false);
      setShares('');
      setSelectedHolding(null);
      await loadPortfolio();
    } catch (err: any) {
      showToast(err.response?.data?.error || 'Error al comprar más participaciones', 'error');
    } finally {
      setSubmitting(false);
    }
  };

  const handleSell = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!selectedHolding || !shares) return;

    setSubmitting(true);
    try {
      await portfolioService.buySell(selectedHolding.id, {
        action: 'sell',
        shares: parseFloat(shares),
      });
      showToast('Venta realizada exitosamente', 'success');
      setShowSellModal(false);
      setShares('');
      setSelectedHolding(null);
      await loadPortfolio();
    } catch (err: any) {
      showToast(err.response?.data?.error || 'Error al vender participaciones', 'error');
    } finally {
      setSubmitting(false);
    }
  };

  const handleSellAll = async (holding: PortfolioType) => {
    if (!confirm(`¿Estás seguro de que quieres vender todas las participaciones de ${holding.symbol}?`)) {
      return;
    }

    try {
      const result = await portfolioService.sellAll(holding.id);
      showToast(`Posición vendida por €${result.sale_value.toFixed(2)}`, 'success');
      await loadPortfolio();
    } catch (err: any) {
      showToast(err.response?.data?.error || 'Error al vender la posición', 'error');
    }
  };

  const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('es-ES', {
      style: 'currency',
      currency: 'EUR',
    }).format(value);
  };

  const openBuyMoreModal = (holding: PortfolioType) => {
    setSelectedHolding(holding);
    setShares('');
    setShowBuyMoreModal(true);
  };

  const openSellModal = (holding: PortfolioType) => {
    setSelectedHolding(holding);
    setShares('');
    setShowSellModal(true);
  };

  if (loading) {
    return (
      <div className={styles.container}>
        <div className={styles.loading}>Cargando cartera...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div className={styles.container}>
        <div className={styles.error}>{error}</div>
      </div>
    );
  }

  if (!summary) {
    return null;
  }

  return (
    <div className={styles.container}>
      <div className={styles.header}>
        <h1 className={styles.title}>Mi Cartera</h1>

        <div className={styles.summary}>
          <div className={styles.summaryCard}>
            <div className={styles.summaryLabel}>Balance Disponible</div>
            <div className={styles.summaryValue}>{formatCurrency(summary.balance)}</div>
          </div>
          <div className={styles.summaryCard}>
            <div className={styles.summaryLabel}>Valor Total</div>
            <div className={styles.summaryValue}>{formatCurrency(summary.total_portfolio_value)}</div>
          </div>
          <div className={styles.summaryCard}>
            <div className={styles.summaryLabel}>Total Invertido</div>
            <div className={styles.summaryValue}>{formatCurrency(summary.total_invested)}</div>
          </div>
          <div className={styles.summaryCard}>
            <div className={styles.summaryLabel}>Ganancia/Pérdida</div>
            <div className={`${styles.summaryValue} ${summary.total_profit_loss >= 0 ? styles.positive : styles.negative}`}>
              {formatCurrency(summary.total_profit_loss)}
            </div>
          </div>
        </div>
      </div>

      <div className={styles.controls}>
        <button className={`${styles.button} ${styles.buttonPrimary}`} onClick={() => setShowBuyNewModal(true)}>
          Comprar Nueva Posición
        </button>
      </div>

      {summary.holdings.length === 0 ? (
        <div className={styles.emptyState}>
          <h3>No tienes posiciones en tu cartera</h3>
          <p>Comienza comprando tu primera posición en fondos indexados</p>
          <button className={`${styles.button} ${styles.buttonPrimary}`} onClick={() => setShowBuyNewModal(true)}>
            Comprar Ahora
          </button>
        </div>
      ) : (
        <div className={styles.tableWrapper}>
          <table className={styles.table}>
            <thead className={styles.tableHeader}>
              <tr>
                <th>Símbolo</th>
                <th>Participaciones</th>
                <th>Precio Compra</th>
                <th>Precio Actual</th>
                <th>Valor Actual</th>
                <th>Ganancia/Pérdida</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {summary.holdings.map((holding) => (
                <tr key={holding.id} className={styles.tableRow}>
                  <td className={`${styles.tableCell} ${styles.symbolCell}`}>
                    <div>{holding.symbol}</div>
                    <div className={styles.fundName}>{holding.index_fund.name}</div>
                  </td>
                  <td className={styles.tableCell}>{Number(holding.shares).toFixed(2)}</td>
                  <td className={styles.tableCell}>{formatCurrency(holding.purchase_price)}</td>
                  <td className={styles.tableCell}>{formatCurrency(holding.index_fund.current_price)}</td>
                  <td className={styles.tableCell}>{formatCurrency(holding.current_value)}</td>
                  <td className={`${styles.tableCell} ${holding.profit_loss >= 0 ? styles.positive : styles.negative}`}>
                    {formatCurrency(holding.profit_loss)}
                  </td>
                  <td className={styles.tableCell}>
                    <div className={styles.rowActions}>
                      <button
                        className={`${styles.iconButton} ${styles.buy}`}
                        onClick={() => openBuyMoreModal(holding)}
                        title="Comprar más"
                      >
                        <span className={styles.buttonIcon}>+</span>
                      </button>
                      <button
                        className={`${styles.iconButton} ${styles.sell}`}
                        onClick={() => openSellModal(holding)}
                        title="Vender"
                      >
                        <span className={styles.buttonIcon}>−</span>
                      </button>
                      <button
                        className={`${styles.iconButton} ${styles.danger}`}
                        onClick={() => handleSellAll(holding)}
                        title="Vender todo"
                      >
                        <span className={styles.buttonIcon}>✕</span>
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}

      {/* Buy New Modal */}
      {showBuyNewModal && (
        <div className={styles.modal} onClick={() => setShowBuyNewModal(false)}>
          <div className={styles.modalContent} onClick={(e) => e.stopPropagation()}>
            <h2 className={styles.modalHeader}>Comprar Nueva Posición</h2>
            <form onSubmit={handleBuyNew}>
              <div className={styles.formGroup}>
                <label className={styles.label}>Símbolo del Fondo</label>
                <input
                  type="text"
                  className={styles.input}
                  value={symbol}
                  onChange={(e) => setSymbol(e.target.value)}
                  placeholder="ej. VTIAX"
                  required
                />
              </div>
              <div className={styles.formGroup}>
                <label className={styles.label}>Número de Participaciones</label>
                <input
                  type="number"
                  step="0.01"
                  min="0.01"
                  className={styles.input}
                  value={shares}
                  onChange={(e) => setShares(e.target.value)}
                  placeholder="ej. 10.5"
                  required
                />
              </div>
              <div className={styles.modalActions}>
                <button type="button" className={styles.buttonCancel} onClick={() => setShowBuyNewModal(false)}>
                  Cancelar
                </button>
                <button type="submit" className={styles.buttonSubmit} disabled={submitting}>
                  {submitting ? 'Comprando...' : 'Comprar'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* Buy More Modal */}
      {showBuyMoreModal && selectedHolding && (
        <div className={styles.modal} onClick={() => setShowBuyMoreModal(false)}>
          <div className={styles.modalContent} onClick={(e) => e.stopPropagation()}>
            <h2 className={styles.modalHeader}>Comprar Más - {selectedHolding.symbol}</h2>
            <form onSubmit={handleBuyMore}>
              <div className={styles.formGroup}>
                <label className={styles.label}>Precio Actual</label>
                <input
                  type="text"
                  className={styles.input}
                  value={formatCurrency(selectedHolding.index_fund.current_price)}
                  disabled
                />
              </div>
              <div className={styles.formGroup}>
                <label className={styles.label}>Número de Participaciones</label>
                <input
                  type="number"
                  step="0.01"
                  min="0.01"
                  className={styles.input}
                  value={shares}
                  onChange={(e) => setShares(e.target.value)}
                  placeholder="ej. 5.0"
                  required
                />
              </div>
              {shares && (
                <div className={styles.formGroup}>
                  <label className={styles.label}>Costo Total</label>
                  <input
                    type="text"
                    className={styles.input}
                    value={formatCurrency(parseFloat(shares) * selectedHolding.index_fund.current_price)}
                    disabled
                  />
                </div>
              )}
              <div className={styles.modalActions}>
                <button type="button" className={styles.buttonCancel} onClick={() => setShowBuyMoreModal(false)}>
                  Cancelar
                </button>
                <button type="submit" className={styles.buttonSubmit} disabled={submitting}>
                  {submitting ? 'Comprando...' : 'Comprar'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* Sell Modal */}
      {showSellModal && selectedHolding && (
        <div className={styles.modal} onClick={() => setShowSellModal(false)}>
          <div className={styles.modalContent} onClick={(e) => e.stopPropagation()}>
            <h2 className={styles.modalHeader}>Vender - {selectedHolding.symbol}</h2>
            <form onSubmit={handleSell}>
              <div className={styles.formGroup}>
                <label className={styles.label}>Participaciones Disponibles</label>
                <input
                  type="text"
                  className={styles.input}
                  value={Number(selectedHolding.shares).toFixed(2)}
                  disabled
                />
              </div>
              <div className={styles.formGroup}>
                <label className={styles.label}>Precio Actual</label>
                <input
                  type="text"
                  className={styles.input}
                  value={formatCurrency(selectedHolding.index_fund.current_price)}
                  disabled
                />
              </div>
              <div className={styles.formGroup}>
                <label className={styles.label}>Número de Participaciones a Vender</label>
                <input
                  type="number"
                  step="0.01"
                  min="0.01"
                  max={selectedHolding.shares}
                  className={styles.input}
                  value={shares}
                  onChange={(e) => setShares(e.target.value)}
                  placeholder="ej. 5.0"
                  required
                />
              </div>
              {shares && (
                <div className={styles.formGroup}>
                  <label className={styles.label}>Valor de Venta</label>
                  <input
                    type="text"
                    className={styles.input}
                    value={formatCurrency(parseFloat(shares) * selectedHolding.index_fund.current_price)}
                    disabled
                  />
                </div>
              )}
              <div className={styles.modalActions}>
                <button type="button" className={styles.buttonCancel} onClick={() => setShowSellModal(false)}>
                  Cancelar
                </button>
                <button type="submit" className={styles.buttonSubmit} disabled={submitting}>
                  {submitting ? 'Vendiendo...' : 'Vender'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}