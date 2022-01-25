<?php
  include 'models/Database.php';
  $DB = new Database();
  if ($_SESSION['active'] == FALSE):
    header("Location: views/pages/login.php");
  endif;
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
  <link rel="stylesheet" href="assets/css/P2P.css">
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
      <?php include 'views/partials/Sidebar.php' ?>
    </div>
    <!--Sidebar-->

    <!--content-->
    <div class="content">
      <!--Main-->
      <div class="main_p2p">
        <div class="cardsBox">
          <div class="card">
            <div>
              <div class="numbers Saldo">
                Calculando...
              </div>
              <div class="cardName">Saldo disponible</div>
            </div>
            <div class="iconBox">
              <i class="bx bx-wallet-alt"></i>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers">15</div>
              <div class="cardName">Transacciones esta semana</div>
            </div>
            <div class="iconBox">
              <i class="bx bx-transfer-alt"></i>
            </div>
          </div>
        </div>

        <div class="make_deposit_p2p">
          <div class="header_deposit_p2p">
            <h1>Hacer un deposito</h1>
          </div>
          
          <div class="form_p2p">
            <div class="inline">
              <input type="number" placeholder="monto" id="amount">
              <select id="tip_div">
                <option value="USD">USD</option>
              </select>
            </div>
            <input type="email" placeholder="Correo del usuario a depositar" id="ema_who">
            <input type="text" placeholder="Concepto" id="concepto">
            <br>
            <button type="button"  id="Depositar">
              <i class="bx bxs-send"></i>
              Depositar
            </button>
            <span class="center">o</span>
            <button type="button" id="ScanQR">
              <i class="bx bx-qr"></i>
              Escanear QR
            </button>
          </div>
        </div>

        <div class="history_p2p">
          <div class="header_history_p2p">
            <h1>Historial de depositos</h1>
          </div>

          <div class="body_history_p2p">
            <br />
            <p>No hay datos disponibles para mostrar</p>
          </div>
        </div>
      </div>
      <!--Main-->
    </div>
    <!--content-->
  </div>
  <!--Flex-->
</body>
<script src="assets/js/p2p.js"></script>
</html>