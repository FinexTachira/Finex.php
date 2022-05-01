<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FINEX | CAPITAL</title>
  <script src="assets/js/auth.js"></script>
  <!-- JQuery -->
  <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
</head>
<body>
  <h1>Finex Server</h1>

  <div class="auth">
    <h3>Autenticate:</h3>
    <div class="form_validate">
      <input type="email" id="ema" placeholder="Correo" autocomplete="off">
      <input type="password" id="psw" placeholder="Contraseña">
      <input type="button" value="Autenticar" id="setAdmin">
    </div>
  </div>

  <ul class="menu">
    <li>
      <a href="index.php" class="btn">
        Abrir Finex App
      </a>
    </li>
    <li>
      <a href="#" class="btn sellOrd">
        Establecer nuevos valores para la venta de activos
      </a>
    </li>
    <li>
      <a href="#" class="btn buyOrd">
        Establecer nuevos valores para la compra de activos
      </a>
    </li>
    <li>
      <a href="#" class="btn comision">
        Establecer nueva tasa de comisión de Finex
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Procesar una compra de activos
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Procesar una venta de activos
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Hacer un deposito
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Desbloquear un usuario
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Cambiar contraseña
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Eliminar un usuario
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Ver historial de depósitos
      </a>
    </li>
    <li>
      <a href="#" class="btn">
        Ver historial de ordenes de compra y venta
      </a>
    </li>
    <li>
      <a href="#" id="out">
        Salir
      </a>
    </li>
  </ul>

  <div class="saldos"></div>

  <div class="tasas">
    <div class="buy"></div>
    <div class="sell"></div>
  </div>
</body>
<script src="assets/js/jquery/jquery.min.js"></script>
<script src="assets/js/admin.js"></script>
</html>