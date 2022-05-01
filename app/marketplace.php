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
  <!-- Push.min.js -->
  <script src="assets/js/push/push.min.js"></script>
  <!-- My Links and Title -->
  <link rel="stylesheet" href="assets/css/home.css">
  <link rel="stylesheet" href="assets/css/marketplace.css">
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
      <!--main-->
      <div class="main">
        <div class="marketplace">
          <div class="tabulador">
            <div class="lista">
              <div class="item active">
                <a href="#all">Todos</a>
              </div>
              <div class="item">
                <a href="#ves">VES</a>
              </div>
              <div class="item">
                <a href="#cop">COP</a>
              </div>
              <div class="item">
                <a href="#usd">USD</a>
              </div>
              <div class="item">
                <a href="#crypto"')">Cripto</a>
              </div>
            </div>
          </div>
          <div class="body">
            <div class="ofertas">
              <div class="head-ofertas">
                <div class="usuario">
                  <span>usuario</span>
                </div>
                <div class="activo">
                  <span>activo</span>
                </div>
                <div class="metodo">
                  método
                </div>
                <div class="recibe">
                  recibe
                </div>
                <div class="tasa">
                  tasa de cambio
                </div>
              </div>
              <div class="body-ofertas">
                <?php include 'controllers/setOfertas.php'; ?>
              </div>
            </div>
          </div>
          <!-- <div class="pager">
            <ul>
              <a href="#" class="pager-item">
                <li><</li>
              </a>
              <a href="#" class="pager-item">
                <li>1</li>
              </a>
              <a href="#" class="pager-item">
                <li>2</li>
              </a>
              <a href="#" class="pager-item">
                <li>3</li>
              </a>
              <a href="#" class="pager-item">
                <li>></li>
              </a>
            </ul>
          </div> -->
        </div>
      </div>
      <!--main-->
    </div>
    <!--content-->
</body>
<script src="assets/js/push/push.min.js"></script>
<script src="assets/js/marketplace.js"></script>
<script src="assets/js/setProfile.js"></script>
<script src="assets/js/globalPush.js"></script>
</html>