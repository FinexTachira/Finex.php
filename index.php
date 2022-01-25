<?php
  include 'models/Database.php';
  $DB = new Database();
  if ($_SESSION['active'] == FALSE):
    header("Location: views/pages/login.php");
  endif;
  $_SESSION['mi_wal'] = $DB->consultWallet($_SESSION['ema_usr']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <!-- BoxIcons -->
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
  <!-- My Links and Title -->
  <link rel="stylesheet" href="assets/css/home.css">
  <link href="assets/img/fav.png" rel="icon">
  <title>FINEX | CAPITAL</title>
</head>

<body>
  <!--Modal Profile-->
  <div class="modal_profile none">
    <?php include 'views/partials/Profile.php'; ?>
  </div>
  <!--Modal Profile-->
  
  <!--Navbar-->
  <div class="Navbar">
    <?php include 'views/partials/Navbar.php'; ?>
  </div>
  <!--Navbar-->

  <!--Flex-->
  <div class="flex">
    <!--Sidebar-->
    <div class="Sidebar">
      <?php include 'views/partials/Sidebar.php'; ?>
    </div>
    <!--Sidebar-->

    <!--content-->
    <div class="content">
      <!--Main-->
      <div class="main">
        <!--CardsBox-->
        <div class="cardsBox">
          <div class="card">
            <div>
              <div class="numbers">
                Calculando...
              </div>
              <div class="cardName">Saldo</div>
            </div>
            <div class="iconBox">
              <i class="bx bx-wallet-alt"></i>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers">15</div>
              <div class="cardName">Ventas</div>
            </div>
            <div class="iconBox">
              <i class="bx bx-check-square"></i>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers btc_price">
                
              </div>
              <div class="cardName">Bitcoin</div>
            </div>
            <div class="iconBox">
              <i class="bx bx-bitcoin"></i>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers">4,58Bs</div>
              <div class="cardName">Dolar - Bs</div>
            </div>
            <div class="iconBox">
              <i class="bx bx-dollar"></i>
            </div>
          </div>
        </div>
        <!--CardsBox-->

        <!--Orders-->
        <div class="orders">
          <!--RecentOrders-->
          <div class="recentOrders">
            <div class="cardHeader">
              <h2>Últimas compras:</h2>
              <a href="/" class="btn">Ver todas</a>
            </div>
            <table>
              <thead>
                <th>Activo</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Método</th>
                <th>Monto</th>
                <th>Fecha</th>
              </thead>
              <tbody>
                <tr>
                  <td>Dólar</td>
                  <td>4,4Bs</td>
                  <td>100Usd</td>
                  <td>Transferencia banco</td>
                  <td>440Bs</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>Dólar</td>
                  <td>4,4Bs</td>
                  <td>100Usd</td>
                  <td>Transferencia banco</td>
                  <td>440Bs</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>Dólar</td>
                  <td>4,4Bs</td>
                  <td>100Usd</td>
                  <td>Transferencia banco</td>
                  <td>440Bs</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>Dólar</td>
                  <td>4,4Bs</td>
                  <td>100Usd</td>
                  <td>Transferencia banco</td>
                  <td>440Bs</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>Dólar</td>
                  <td>4,4Bs</td>
                  <td>100Usd</td>
                  <td>Transferencia banco</td>
                  <td>440Bs</td>
                  <td>Nov 17, 2021</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--RecentOrders-->

          <?php
            echo $_COOKIE['tlf_usr'];
          ?>

          <!--RecentCustomers-->
          <div class="recentCustomers">
            <div class="cardHeader">
              <h2>Últimas ventas:</h2>
              <a href="/" class="btn">Ver todos</a>
            </div>
            <table>
              <thead>
                <th>Nombre</th>
                <th>Activo</th>
                <th>Venta</th>
                <th>Fecha</th>
              </thead>
              <tbody>
                <tr>
                  <td>John Doe</td>
                  <td>COP</td>
                  <td>150k</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>John Doe</td>
                  <td>COP</td>
                  <td>150k</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>John Doe</td>
                  <td>COP</td>
                  <td>150k</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>John Doe</td>
                  <td>COP</td>
                  <td>150k</td>
                  <td>Nov 17, 2021</td>
                </tr>
                <tr>
                  <td>John Doe</td>
                  <td>COP</td>
                  <td>150k</td>
                  <td>Nov 17, 2021</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--RecentOrders-->
        </div>
        <!--Orders-->
        
        <!--TradingView-->
          <div class="tradingview-widget-container">
            <h2>Resumen de Mercados Cripto (Bitcoin)</h2>
            <div id="tradingview_08c98"></div>
            <div class="tradingview-widget-copyright"><a href="https://es.tradingview.com/symbols/BTCUSD/?exchange=BITSTAMP" rel="noopener" target="_blank"><span class="blue-text">BTCUSD Gráfico</span></a> por TradingView</div>
            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
            <script type="text/javascript">
              new TradingView.widget({
                "autosize": true,
                "symbol": "BITSTAMP:BTCUSD",
                "interval": "D",
                "timezone": "Etc/UTC",
                "theme": "light",
                "style": "1",
                "locale": "es",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "allow_symbol_change": true,
                "container_id": "tradingview_08c98"
              })
            </script>
          </div>
        <!--TradingView-->
      </div>
      <!--Main-->
    </div>
    <!--content-->
  </div>
  <!--Flex-->
</body>
<script src="assets/js/index.js"></script>
</html>