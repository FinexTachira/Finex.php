<?php
  include 'models/Database.php';
  if ($_SESSION['active'] == FALSE) {
    header("Location: views/pages/login.php");
  }
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
  <link rel="stylesheet" href="assets/css/markets.css">
  <link href="assets/img/fav.png" rel="icon">
  <title>FINEX | CAPITAL</title>
</head>

<body>
  <!--Navbar-->
  <div class="Navbar">
    <div class="Nav">
      <i class="bx bx-menu"></i>
      <h1>Finex</h1>
      <img src="assets/img/fav.png" class="logoFinex" alt="Logo de Finex" />
    </div>
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
      <div class="main">
        <h2 class="titleGreen">Resumen de mercados Crypto</h2>
        <div class="tabla">
          <div class='centered'>
            <h2 class='litleGreen'>Cargando...</h2>
          </div>
        </div>
      </div>
      <!--Main-->
    </div>
    <!--content-->
  </div>
  <!--Flex-->
</body>
<script src="assets/js/markets.js"></script>
</html>