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
  <!-- Push.min.js -->
  <script src="assets/js/push/push.min.js"></script>
  <!-- My Links and Title -->
  <link rel="stylesheet" href="assets/css/home.css">
  <link href="assets/img/favicon.ico" rel="icon">
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
          <?php include 'views/partials/cardBox.php'; ?>
        </div>
        <!--CardsBox-->

        <!--Carrousel-->
        <div class="carrousel">
          <?php include 'views/partials/carrousel.php'; ?>
        </div>
        <!--Carrousel-->

        <!--Little Cards-->
        <div class="little-cards">
          
        </div>
        <!--Little Cards-->
        
        <!--TradingView-->
          <div class="tradingview-widget-container">
            <?php include 'views/partials/tradingView.php'; ?>
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
<script src="assets/js/setProfile.js"></script>
<script src="assets/js/globalPush.js"></script>
</html>