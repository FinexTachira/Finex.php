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
  <!-- SweetAlert2 -->
  <script src="assets/js/sweetalert2/sweetalert2.min.js"></script>
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
        <div class="container-wallet">
          <div>
            <button type="button" class="btn-wallet btn1 create">
              <i class="bx bx-plus"></i>
              Crear
            </button>
            <button type="button" class="btn-wallet btn2">
              <i class="bx bxs-send"></i>
              Depositar
            </button>
            <button type="button" class="btn-wallet btn3">
              <i class="bx bx-money-withdraw"></i>
              Retirar
            </button>
            <button type="button" class="btn-wallet btn3">
              <i class="bx bx-transfer-alt"></i>
              Convertir
            </button>
            <a href="#">historial</a>
          </div>

          <div class="saldo-wallet-container">
            <div class="header-saldo-wallets">
              <h3>Saldo estimado de tus wallets</h3>
            </div>
            <div class="cantidad-saldo-wallets">
              <h4 class="the_saldo">Calculando...</h4>
            </div>
          </div>

          <div class="wallets">
            <div class="fiat-wallets">
              <h2>Billeteras Fiat</h2>

              <div class="container-fiat-wallets">
                <div class="wallet-usd">
                  <p>Billetera USD - Dolar Americano</p>
                  <span id="wallet-usd">No posee</span>
                </div>
              </div>
              <div class="container-fiat-wallets">
                <div class="wallet-cop">
                  <p>Billetera COP - Peso Colombiano</p>
                  <span id="wallet-cop">No posee</span>
                </div>
              </div>
              <div class="container-fiat-wallets">
                <div class="wallet-ves">
                  <p>Billetera VES - Bolívar Venezolano</p>
                  <span id="wallet-ves">No posee</span>
                </div>
              </div>
            </div>
            <div class="crypto-wallets">
              <h2>Billeteras Cripto</h2>

              <div class="container-crypto-wallets">
                <div class="wallet-btc">
                  <p>Billetera BTC - Bitcoin</p>
                  <span>No posee</span>
                </div>
              </div>
              <div class="container-crypto-wallets">
                <div class="wallet-btc">
                  <p>Billetera USDT - Tether</p>
                  <span>No posee</span>
                </div>
              </div>
              <div class="container-crypto-wallets">
                <div class="wallet-btc">
                  <p>Billetera FBT - Finex Token</p>
                  <span>No posee</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        
      </div>
      <!--Main-->
    </div>
    <!--content-->
  </div>
  <!--Flex-->
</body>
<script src="assets/js/wallet.js"></script>
</html>
