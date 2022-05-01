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
    <div class="container">
      <div class="login-content">
        <form>
          <h2 class="title">Registrate</h2>
          <div class="input-div name">
            <div class="i">
              <i class="bx bxs-user"></i>
            </div>
            <div class="div">
              <h5>Nombre completo</h5>
              <input type="text" id="ones" class="input" onfocus="toggleName()" onblur="toggleName()" required>
            </div>
          </div>
          <div class="input-div phone">
            <div class="i">
              <i class="bx bxs-phone"></i>
            </div>
            <div class="div">
              <h5>Teléfono</h5>
              <input type="tel" id="twos" class="input" onfocus="togglePhone()" onblur="togglePhone()" required>
            </div>
          </div>
          <div class="input-div one">
            <div class="i">
              <i class="bx bxs-envelope"></i>
            </div>
            <div class="div">
              <h5>Correo</h5>
              <input type="email" id="threes" class="input" onfocus="toggleOne()" onblur="toggleOne()" required>
            </div>
          </div>
          <div class="input-div pass">
            <div class="i"> 
              <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="div">
              <h5>Contraseña</h5>
              <input type="password" id="fours" class="input" onfocus="togglePass()" onblur="togglePass()" required>
            </div>
          </div>
          <br>
          <input type="button" class="btn Registrar" value="Registrar">
          <a href="login.php" class="frgPsw">Ya tengo cuenta</a>
        </form>
      </div>
    </div>
  </div>
</body>
<script src="../../assets/js/register.js"></script>
</html>