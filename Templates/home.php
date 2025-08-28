<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Clientes | CRM</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --primary: #FF4F5E;
      --primary-light: #FFF4F5;
      --primary-dark: #E53E4D;
      --accent: #5B6EF7;
      --success: #17c7a7;
      --info: #21c1ff;
      --warning: #ff9800;
      --text-primary: #2c3e50;
      --text-secondary: #67748B;
      --bg-light: #f8fafc;
      --border: #E9ECEF;
      --card-bg: #FFFFFF;
      --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-light);
      color: var(--text-primary);
      display: flex;
      min-height: 100vh;
    }

    /* Main Content */
    .main-content {
      flex: 1;
      padding: 24px 32px;
      overflow-y: auto;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .header h2 {
      font-weight: 600;
      color: var(--text-primary);
      font-size: 1.5rem;
    }

    .user-menu {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: var(--accent);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 500;
    }

    /* Filtros */
    .filters {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: var(--card-bg);
      padding: 16px 24px;
      border-radius: 12px;
      box-shadow: var(--card-shadow);
      margin-bottom: 24px;
      border: 1px solid var(--border);
    }

    .filter-group {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .filters select,
    .filters input[type="date"] {
      padding: 8px 16px;
      border-radius: 8px;
      border: 1px solid var(--border);
      background: var(--card-bg);
      font-size: 14px;
      color: var(--text-primary);
      transition: border-color 0.2s;
    }

    .filters select:focus,
    .filters input[type="date"]:focus {
      border-color: var(--primary);
      outline: none;
    }

    .btn-primary {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 8px 20px;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .btn-primary:hover {
      background-color: var(--primary-dark);
    }

    /* Tarjetas de métricas */
    .metrics-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 24px;
    }

    .metric-card {
      background: var(--card-bg);
      padding: 24px;
      border-radius: 12px;
      box-shadow: var(--card-shadow);
      display: flex;
      flex-direction: column;
      border: 1px solid var(--border);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .metric-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .metric-card h3 {
      font-size: 14px;
      font-weight: 500;
      color: var(--text-secondary);
      margin-bottom: 12px;
    }

    .metric-value {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 8px;
      color: var(--text-primary);
    }

    .metric-trend {
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .trend-up {
      color: var(--success);
    }

    .trend-down {
      color: #f44336;
    }

    /* Layout de gráficos */
    .charts-container {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
      margin-bottom: 24px;
    }

    .secondary-charts {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 24px;
    }

    .chart-card {
      background: var(--card-bg);
      padding: 24px;
      border-radius: 12px;
      box-shadow: var(--card-shadow);
      border: 1px solid var(--border);
    }

    .chart-card h3 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 20px;
      color: var(--text-primary);
    }

    .chart-container {
      position: relative;
      height: 300px;
    }

    .secondary-charts .chart-container {
      height: 240px;
    }

    /* Tabla */
    .table-card {
      background: var(--card-bg);
      padding: 24px;
      border-radius: 12px;
      box-shadow: var(--card-shadow);
      margin-bottom: 24px;
      border: 1px solid var(--border);
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .table-header h3 {
      font-size: 18px;
      font-weight: 600;
      color: var(--text-primary);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border);
    }

    th {
      font-weight: 600;
      color: var(--text-secondary);
      font-size: 14px;
      background-color: var(--bg-light);
    }

    td {
      font-size: 14px;
      color: var(--text-primary);
    }

    tr:hover {
      background-color: var(--primary-light);
    }

    /* Responsive */
    @media (max-width: 1200px) {
      .metrics-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .secondary-charts {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 900px) {
      .charts-container {
        grid-template-columns: 1fr;
      }
      
      .secondary-charts {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {
      .main-content {
        padding: 16px;
      }
      
      .metrics-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
      
      .filters {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
      }
      
      .filter-group {
        width: 100%;
        flex-direction: column;
        gap: 12px;
      }
      
      .filters select,
      .filters input[type="date"] {
        width: 100%;
      }
      
      .btn-primary {
        width: 100%;
      }
      
      .chart-card {
        padding: 20px;
      }
      
      .chart-container {
        height: 250px;
      }
    }
  </style>
</head>
<body>

  <!-- Main Content -->
  <main class="main-content">
    <div class="header">
    </div>

    <!-- Filtros -->
    <div class="filters">
      <div class="filter-group">
        <select>
          <option>Últimos 7 días</option>
          <option>Últimos 30 días</option>
          <option>Este mes</option>
          <option>Personalizado</option>
        </select>
        <input type="date">
        <input type="date">
      </div>
      <button class="btn-primary">Aplicar filtros</button>
    </div>

    <!-- Métricas principales -->
    <div class="metrics-grid">
      <div class="metric-card">
        <h3>Clientes Totales</h3>
        <div class="metric-value">1,250</div>
        <div class="metric-trend trend-up">+5.2% vs mes anterior</div>
      </div>
      <div class="metric-card">
        <h3>Suscripciones Activas</h3>
        <div class="metric-value">980</div>
        <div class="metric-trend trend-up">+3.7% vs mes anterior</div>
      </div>
      <div class="metric-card">
        <h3>Tasa de Conversión</h3>
        <div class="metric-value">32.5%</div>
        <div class="metric-trend trend-up">+2.1% vs mes anterior</div>
      </div>
      <div class="metric-card">
        <h3>Ingresos Mensuales</h3>
        <div class="metric-value">$85,420</div>
        <div class="metric-trend trend-up">+8.3% vs mes anterior</div>
      </div>
    </div>

    <!-- Gráficos principales -->
    <div class="charts-container">
      <div class="chart-card">
        <h3>Suscripciones por Mes</h3>
        <div class="chart-container">
          <canvas id="suscripcionesPorMes"></canvas>
        </div>
      </div>
      <div class="chart-card">
        <h3>Distribución de Clientes</h3>
        <div class="chart-container">
          <canvas id="distribucionClientes"></canvas>
        </div>
      </div>
    </div>

    <!-- Gráficos secundarios -->
    <div class="secondary-charts">
      <div class="chart-card">
        <h3>Tipos de Suscripción</h3>
        <div class="chart-container">
          <canvas id="tiposSuscripcion"></canvas>
        </div>
      </div>
      <div class="chart-card">
        <h3>Regiones</h3>
        <div class="chart-container">
          <canvas id="regiones"></canvas>
        </div>
      </div>
      <div class="chart-card">
        <h3>Métodos de Pago</h3>
        <div class="chart-container">
          <canvas id="metodosPago"></canvas>
        </div>
      </div>
    </div>

    <!-- Tabla de actividad reciente -->
    <div class="table-card">
      <div class="table-header">
        <h3>Actividad Reciente de Clientes</h3>
        <button class="btn-primary">Exportar</button>
      </div>
      <table>
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Acción</th>
            <th>Detalles</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>2025-08-27</td>
            <td>María López</td>
            <td>Suscripción renovada</td>
            <td>Plan Premium</td>
          </tr>
          <tr>
            <td>2025-08-26</td>
            <td>Carlos Ruiz</td>
            <td>Nuevo registro</td>
            <td>Plan Básico</td>
          </tr>
          <tr>
            <td>2025-08-25</td>
            <td>Ana Martínez</td>
            <td>Actualización de plan</td>
            <td>De Básico a Premium</td>
          </tr>
          <tr>
            <td>2025-08-24</td>
            <td>Jorge Fernández</td>
            <td>Pago realizado</td>
            <td>$99.99</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    // Script para inicializar los gráficos (ejemplo)
    document.addEventListener('DOMContentLoaded', function() {
      // Gráfico de suscripciones por mes
      const suscripcionesCtx = document.getElementById('suscripcionesPorMes').getContext('2d');
      new Chart(suscripcionesCtx, {
        type: 'line',
        data: {
          labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
          datasets: [{
            label: 'Suscripciones',
            data: [120, 150, 180, 210, 240, 200, 230, 250],
            borderColor: '#FF4F5E',
            backgroundColor: 'rgba(255, 79, 94, 0.08)',
            tension: 0.4,
            fill: true,
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              labels: {
                color: '#2c3e50',
                font: {
                  family: 'Inter'
                }
              }
            }
          },
          scales: {
            y: {
              grid: {
                color: 'rgba(233, 236, 239, 0.6)'
              },
              ticks: {
                color: '#67748B',
                font: {
                  family: 'Inter'
                }
              }
            },
            x: {
              grid: {
                color: 'rgba(233, 236, 239, 0.6)'
              },
              ticks: {
                color: '#67748B',
                font: {
                  family: 'Inter'
                }
              }
            }
          }
        }
      });

      // Gráfico de distribución de clientes
      const distribucionCtx = document.getElementById('distribucionClientes').getContext('2d');
      new Chart(distribucionCtx, {
        type: 'doughnut',
        data: {
          labels: ['Nuevos', 'Activos', 'Inactivos', 'Prospectos'],
          datasets: [{
            data: [25, 45, 20, 10],
            backgroundColor: ['#FF4F5E', '#5B6EF7', '#17c7a7', '#ff9800'],
            borderWidth: 0,
            hoverOffset: 8
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '65%',
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                color: '#2c3e50',
                font: {
                  family: 'Inter',
                  size: 12
                },
                padding: 20
              }
            }
          }
        }
      });
    });
  </script>
</body>
</html>