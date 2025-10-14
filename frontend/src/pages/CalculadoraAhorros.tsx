import { useState, useEffect } from 'react';
import styles from './CalculadoraAhorros.module.css';
import type { CalculadoraAhorros, Usuario } from '@services/calculadoraAhorrosService';
import { 
  getAuthUser, 
  getAllCalculadoras, 
  getCalculadoraByUserId, 
  updateCalculadora, 
  resetCalculadora 
} from '@services/calculadoraAhorrosService';
import { useToast } from '@context/ToastContext';
import { useAuth } from '@context/AuthContext';

const CalculadoraAhorrosPage = () => {
  const [ingresoMensual, setIngresoMensual] = useState<number>(0);
  const [calculoAnual, setCalculoAnual] = useState<boolean>(false);
  const [loading, setLoading] = useState<boolean>(true);
  const [currentUser, setCurrentUser] = useState<Usuario | null>(null);
  const [allCalculadoras, setAllCalculadoras] = useState<CalculadoraAhorros[]>([]);
  const [selectedUserId, setSelectedUserId] = useState<number | null>(null);

  const { user, isAuthenticated } = useAuth();
  const { showToast } = useToast();

  const isAdmin = isAuthenticated && user?.role === 'admin';

  useEffect(() => {
    if (isAuthenticated) {
      fetchData();
    } else {
      setLoading(false);
    }
  }, [isAuthenticated]);

  const fetchData = async () => {
    setLoading(true);
    try {
      const authUser = await getAuthUser();
      setCurrentUser(authUser);

      if (isAdmin) {
        // Admin: cargar todas las calculadoras
        const calculadoras = await getAllCalculadoras();
        setAllCalculadoras(calculadoras);
        
        // Por defecto, seleccionar la del propio admin
        setSelectedUserId(authUser.id);
        const adminCalc = calculadoras.find(c => c.id_usuario === authUser.id);
        if (adminCalc) {
          setIngresoMensual(adminCalc.ingreso_mensual);
        }
      } else {
        // Usuario normal: solo cargar su calculadora
        const calculadora = await getCalculadoraByUserId(authUser.id);
        setIngresoMensual(calculadora.ingreso_mensual);
      }
    } catch (err) {
      console.error('Error fetching data:', err);
    } finally {
      setLoading(false);
    }
  };

  const handleSave = async () => {
    if (!isAuthenticated) {
      showToast('Debes iniciar sesión para guardar');
      return;
    }

    const targetUserId = isAdmin && selectedUserId ? selectedUserId : currentUser?.id;

    if (!targetUserId) return;

    try {
      await updateCalculadora(targetUserId, { ingreso_mensual: ingresoMensual });
      showToast('Calculadora guardada correctamente');
      
      if (isAdmin) {
        // Recargar todas las calculadoras para actualizar la lista
        const calculadoras = await getAllCalculadoras();
        setAllCalculadoras(calculadoras);
      }
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || 'Error al guardar la calculadora';
      showToast(errorMessage);
      console.error('Error saving:', err);
    }
  };

  const handleReset = async () => {
    if (!isAuthenticated) return;

    if (!window.confirm('¿Estás seguro de que deseas resetear la calculadora?')) {
      return;
    }

    const targetUserId = isAdmin && selectedUserId ? selectedUserId : currentUser?.id;

    if (!targetUserId) return;

    try {
      await resetCalculadora(targetUserId);
      setIngresoMensual(0);
      showToast('Calculadora reseteada correctamente');
      
      if (isAdmin) {
        // Recargar todas las calculadoras
        const calculadoras = await getAllCalculadoras();
        setAllCalculadoras(calculadoras);
      }
    } catch (err: any) {
      const errorMessage = err.response?.data?.message || 'Error al resetear la calculadora';
      showToast(errorMessage);
      console.error('Error resetting:', err);
    }
  };

  const handleUserSelect = (userId: number) => {
    setSelectedUserId(userId);
    const userCalc = allCalculadoras.find(c => c.id_usuario === userId);
    if (userCalc) {
      setIngresoMensual(userCalc.ingreso_mensual);
    } else {
      setIngresoMensual(0);
    }
  };

  const calcularResultados = () => {
    const multiplicador = calculoAnual ? 12 : 1;
    return {
      necesidades: ingresoMensual * 0.50 * multiplicador,
      caprichos: ingresoMensual * 0.30 * multiplicador,
      ahorros: ingresoMensual * 0.20 * multiplicador
    };
  };

  const formatearDinero = (valor: number): string => {
    return new Intl.NumberFormat('es-ES', {
      minimumFractionDigits: 0,
      maximumFractionDigits: 2,
    }).format(valor);
  };

  const resultados = calcularResultados();

  if (loading) {
    return (
      <div className={styles.page}>
        <div className={styles.loading}>
          <div className={styles.spinner}></div>
          <p>Cargando calculadora...</p>
        </div>
      </div>
    );
  }

  if (!isAuthenticated) {
    return (
      <div className={styles.page}>
        <div className={styles.container}>
          <div className={styles.header}>
            <h1 className={styles.title}>Calculadora de ahorro 50/30/20</h1>
            <p className={styles.subtitle}>
              Descubre cómo dividir tus ingresos mensuales en necesidades, deseos y ahorros.
            </p>
          </div>

          <div className={styles.loginRequired}>
            <div className={styles.loginIcon}>🔒</div>
            <h2>Inicia sesión para usar la calculadora</h2>
            <p>Necesitas estar autenticado para guardar y gestionar tu calculadora de ahorros.</p>
            <a href="/login" className={styles.loginButton}>
              Iniciar sesión
            </a>
          </div>

          <div className={styles.infoSection}>
            <h2>¿Cómo usar la calculadora 50/30/20?</h2>
            <ul>
              <li>Ingresa tus ingresos mensuales netos después de impuestos</li>
              <li>50% se destinará a necesidades (alquiler, comida, transporte)</li>
              <li>30% para caprichos y ocio (entretenimiento, restaurantes)</li>
              <li>20% para ahorros e inversiones</li>
              <li>Cambia entre vista mensual y anual con el interruptor</li>
            </ul>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className={styles.page}>
      <div className={styles.container}>
        <div className={styles.header}>
          <h1 className={styles.title}>Calculadora de ahorro 50/30/20</h1>
          <p className={styles.subtitle}>
            Descubre cómo dividir tus ingresos mensuales en necesidades, deseos y ahorros.
          </p>
        </div>

        {isAdmin && (
          <div className={styles.adminPanel}>
            <h3>Panel de Administrador - Selecciona un usuario</h3>
            <div className={styles.userList}>
              {allCalculadoras.map((calc) => {
                const isCurrentUser = calc.id_usuario === currentUser?.id;
                const isSelected = selectedUserId === calc.id_usuario;
                
                return (
                  <button
                    key={calc.id_usuario}
                    onClick={() => handleUserSelect(calc.id_usuario)}
                    className={`${styles.userButton} ${isSelected ? styles.userButtonActive : ''}`}
                  >
                    <span className={styles.userName}>
                      Usuario ID: {calc.id_usuario}
                      {isCurrentUser && ' (Tú)'}
                    </span>
                    <span className={styles.userIncome}>
                      {formatearDinero(calc.ingreso_mensual)} €/mes
                    </span>
                  </button>
                );
              })}
            </div>
          </div>
        )}

        <div className={styles.calculatorSection}>
          <div className={styles.infoBox}>
            <h2>¿Cómo usar la calculadora 50/30/20?</h2>
            <ul>
              <li>Ingresa tus ingresos mensuales netos después de impuestos</li>
              <li>50% se destinará a necesidades básicas (alquiler, comida, servicios)</li>
              <li>30% para caprichos y ocio (entretenimiento, restaurantes, hobbies)</li>
              <li>20% para ahorros e inversiones (fondo de emergencia, jubilación)</li>
              <li>Cambia entre vista mensual y anual con el interruptor</li>
            </ul>
          </div>

          <div className={styles.inputSection}>
            <label className={styles.inputLabel}>
              Total ingresos netos mensuales
              {isAdmin && selectedUserId && selectedUserId !== currentUser?.id && (
                <span className={styles.editingLabel}> - Editando Usuario ID: {selectedUserId}</span>
              )}
            </label>
            <input
              type="number"
              value={ingresoMensual || ''}
              onChange={(e) => setIngresoMensual(Number(e.target.value))}
              placeholder="0"
              className={styles.input}
              min="0"
              step="0.01"
            />
            <div className={styles.buttonGroup}>
              <button onClick={handleSave} className={styles.saveButton}>
                💾 Guardar
              </button>
              <button onClick={handleReset} className={styles.resetButton}>
                🔄 Resetear
              </button>
            </div>
          </div>

          <div className={styles.resultsSection}>
            <div className={styles.resultsHeader}>
              <h2>Tu resultado</h2>
              <div className={styles.toggle}>
                <span className={!calculoAnual ? styles.toggleActive : ''}>Mensual</span>
                <label className={styles.switch}>
                  <input
                    type="checkbox"
                    checked={calculoAnual}
                    onChange={(e) => setCalculoAnual(e.target.checked)}
                  />
                  <span className={styles.slider}></span>
                </label>
                <span className={calculoAnual ? styles.toggleActive : ''}>Anual</span>
              </div>
            </div>

            <div className={styles.resultsGrid}>
              <div className={`${styles.resultCard} ${styles.necesidades}`}>
                <p className={styles.resultLabel}>Necesidades</p>
                <p className={styles.resultValue}>{formatearDinero(resultados.necesidades)} €</p>
                <p className={styles.resultPercent}>50%</p>
              </div>
              <div className={`${styles.resultCard} ${styles.caprichos}`}>
                <p className={styles.resultLabel}>Caprichos</p>
                <p className={styles.resultValue}>{formatearDinero(resultados.caprichos)} €</p>
                <p className={styles.resultPercent}>30%</p>
              </div>
              <div className={`${styles.resultCard} ${styles.ahorros}`}>
                <p className={styles.resultLabel}>Ahorros</p>
                <p className={styles.resultValue}>{formatearDinero(resultados.ahorros)} €</p>
                <p className={styles.resultPercent}>20%</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CalculadoraAhorrosPage;