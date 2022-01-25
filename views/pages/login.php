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
    <img class="wave" src="../../assets/img/bg.jpg" alt="background">
    <div class="container">
      <div class="img">
        <img src="../../assets/img/security1.jpg" alt="Login" class="login-logo-aside">
      </div>
      <div class="login-content">
        <form>
          <h2 class="title">Inicia sesión</h2><br>
          <div class="input-div one">
            <div class="i">
              <i class="bx bxs-envelope"></i>
            </div>
            <div class="div">
              <h5>Correo</h5>
              <input type="email" id="ones" class="input" onfocus="toggleOne()" onblur="toggleOne()">
            </div>
          </div>
          <div class="input-div pass">
            <div class="i"> 
              <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="div">
              <h5>Contraseña</h5>
              <input type="password" id="twos" class="input" onfocus="togglePass()" onblur="togglePass()">
            </div>
          </div>
          <a href="#" class="rightLink">¿Olvidaste la contraseña?</a>
          <br><br>
          <input type="button" class="btn Login" value="Iniciar">
          <a href="register.php" class="frgPsw">Crear cuenta nueva</a>
        </form>
      </div>
    </div>
  </div>
</body>
<script src="../../assets/js/login.js"></script>
</html>