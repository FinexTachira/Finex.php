<?php
  include '../partials/Head.php';
  include '../../models/Database.php';
  if ($_SESSION['active'] == TRUE):
    header("Location: ../../index.php");
  endif;
?>
<body>
  <?php
    $DB = new Database();
    $DB->connect();
  ?>
  <div class="body">
    <img class="wave" src="../../assets/img/bg.jpg" alt="background" />
    <div class="container">
      <div class="img">
        <img src="../../assets/img/security3.jpg" alt="Login" class="login-logo-aside" />
      </div>
      <div class="login-content">
        <form>
          <h2 class="title">Autenticate</h2>
          <div class="input-div one">
            <div class="i">
              <i class="bx bxs-user"></i>
            </div>
            <div class="div">
              <h5>Código enviado a tu teléfono</h5>
              <input type="text" id="ones" class="input" class="input" onfocus="toggleOne()" onblur="toggleOne()">
            </div>
          </div>
          <div class="input-div pass">
            <div class="i"> 
              <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="div">
              <h5>Código enviado a tu correo</h5>
              <input type="text" id="twos" class="input" class="input" onfocus="togglePass()" onblur="togglePass()">
            </div>
          </div>
          <br />
          <input type="button" class="btn Auth" value="Autenticar">
        </form>
      </div>
    </div>
  </div>
</body>
<script src="../../assets/js/2fa.js"></script>
</html>