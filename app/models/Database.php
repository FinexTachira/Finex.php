<?php
session_start();
error_reporting(0);

class Database {
  private $host;
  private $db;
  private $user;
  private $psw;

  public function __construct() {
    // /*Finex*/
    // $this->host = "localhost";
    // $this->db   = "finex_bd";
    // $this->user = "finex_capital";
    // $this->psw  = "pirineos2021";
    /*Local*/
    $this->host = "localhost";
    $this->db   = "finex";
    $this->user = "beltz";
    $this->psw  = "andy7507650";
  }

  #Conexión a la base de datos
  public function connect() {
    $conection = new mysqli($this->host,$this->user,$this->psw,$this->db);
    if($conection->connect_errno):
      echo "<script>
              Swal.fire({
                title: 'Error',
                text: 'El sitio web no se encuentra disponible en estos momentos, intentelo mas tarde.',
                icon: 'error',
                confirmButtonText: 'OK',
                showCloseButton: true
              })
            </script>";
    endif;
    return $conection;
  }

  #Contar usuarios registrados
  public function Count_Users() {
    $query  = "SELECT idt_usr FROM users";
    $result = $this->connect()->query($query);
    $count  = $result->num_rows;
    return $count;
  }

  #Registrar usuarios
  public function Register($Name,$Phone,$Email,$Password) {
    $count = $this->Count_Users();
    $count++;
    $query = "INSERT INTO
                users (idt_usr,nom_usr,tlf_usr,ema_usr,psw_usr)
              VALUES (MD5('$count'), '$Name', '+58$Phone', '$Email', MD5('$Password'));";
    if($result = $this->connect()->query($query)){
      $array = array(
        'title' => 'Registro exitoso',
        'text'  => 'Ahora iniciar sesión',
        'icon'  => 'success',
        'sql'   => $query,
      );
      echo json_encode($array);
    }else{
      $array = array(
        'title' => 'Ha ocurrido un error',
        'text'  => 'El correo o número de teléfono ya está registrado, o tenemos problemas para registrarte',
        'icon'  => 'error',
        'sql'   => $query,
      );
      echo json_encode($array);
    }
  }

  #Logueo
  public function Login($Email,$Password) {
    $query = "SELECT * FROM
                users
              WHERE ema_usr = '$Email' AND psw_usr = MD5('$Password')";
    if($result = $this->connect()->query($query)){
      if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_COOKIE['tlf_usr']  = $row['tlf_usr'];
        $_COOKIE['ema_usr']  = $row['ema_usr'];
        $_SESSION['tlf_usr'] = $row['tlf_usr'];
        $_SESSION['ema_usr'] = $row['ema_usr'];
        $array = array(
          'title' => 'Espere un momento',
          'text'  => 'Enviando códigos de verificación a su correo y número de teléfono',
          'icon'  => 'success',
          'phone' => $_COOKIE['tlf_usr']
        );
        echo json_encode($array);
      }else{
        $array = array(
          'title' => 'Ha ocurrido un error',
          'text'  => 'El correo o la contraseña son incorrectos',
          'icon'  => 'error',
        );
        echo json_encode($array);
      }
    }else{
      $array = array(
        'title' => 'Ha ocurrido un error',
        'text'  => 'El correo o la contraseña son incorrectos',
        'icon'  => 'error',
      );
      echo json_encode($array);
    }
  }

  #Registrar código de verificación envíado al teléfono
  public function send2FAPhone ($PhoCode,$pho) {
    $query = "INSERT INTO
                code_phone (tlf_usr,cod_2fa)
              VALUES ('$pho', '$PhoCode');";    
    if($result = $this->connect()->query($query)){
      $array = array(
        'title' => 'Código enviado',
        'text'  => 'El código de verificación phone ha sido enviado a su número de teléfono',
        'icon'  => 'success',
      );
      echo json_encode($array);
    }else {
      $array = array(
        'title' => 'Ha ocurrido un error 2',
        'text'  => 'El código de verificación no ha sido enviado, intentelo mas tarde',
        'icon'  => 'error',
      );
      echo json_encode($array);
    }
  }

  #Registrar código de verificación envíado al correo
  public function send2FAEmail ($EmaCode,$ema) {
    $query = "INSERT INTO
                code_email (ema_usr,cod_2fa)
              VALUES ('$ema', '$EmaCode');";
    if($result = $this->connect()->query($query)) {
      $array = array(
        'title' => 'Código enviado',
        'text'  => 'El código de verificación email ha sido enviado a su correo',
        'icon'  => 'success',
      );
      echo json_encode($array);
    }else {
      $array = array(
        'title' => 'Ha ocurrido un error 2',
        'text'  => 'El código de verificación no ha sido enviado, intentelo mas tarde',
        'icon'  => 'error',
      );
      echo json_encode($array);
    }
  }

  #Validar códigos de verificación
  public function Validate ($phone,$email,$phoCode,$emaCode) {
    $sql = "SELECT
               COUNT(cod_2fa) AS result
             FROM code_email
             WHERE cod_2fa = '$emaCode' AND ema_usr = '$email';";
    $sum = 0;
    $con = $this->connect()->query($sql);
    while ($res = $con->fetch_assoc()):
      $sum += $res['result'];
    endwhile;

    switch ($sum):
      case 2:
        return "good";
        break;
      
      case 1:
        return "good";
        break;

      case 0:
        return "nothing";
        break;

      default:
        return "not";
        break;
    endswitch;
  }

  #Hacer depositos de una Wallet a otra mediante P2P
  public function depositWallet($walW,$walF,$remi,$emis,$mont,$divi,$conc) {
    $sql = "INSERT INTO
              deposit (wal_who,wal_frm,ema_who,ema_frm,sal_dep,tip_div,con_dep)
            VALUES ('$walW', '$walF', '$remi', '$emis', '$mont', '$divi', '$conc');";
    if ($result = $this->connect()->query($sql)) {
      $array = array(
        'title' => '¡Exito!',
        'text'  => 'Su transacción se ha completado exitosamente',
        'icon'  => 'success',
      );
      echo json_encode($array);
    }else{
      $array = array(
        'title' => 'Error',
        'text'  => 'Ha ocurrido un error en el deposito :( revisa que los datos estén correctos',
        'icon'  => 'error',
      );
      echo json_encode($array);
    }
  }

  #Consultar el idt de una wallet
  public function consultWallet($email) {
    $sql = "SELECT
              idt_wal
            FROM wallet
            WHERE ema_usr = '$email';";
    if ($con = $this->connect()->query($sql)) {
      $result = $con->fetch_assoc();
      return $result['idt_wal'];
    }
  }

  #Consultar saldo de una wallet mediante su idt
  public function consultarSaldo($wal) {
    $sql = "SELECT
              sal_wal
            FROM wallet
            WHERE idt_wal = '$wal';";
    if ($con = $this->connect()->query($sql)) {
      $result = $con->fetch_assoc();
      return $result['sal_wal'];
    }
  }

  #Consultar si existe una wallet mediante el correo y el tipo de divisa
  public function consultIfExistWallet($ema,$typ) {
    $sql = "SELECT
              idt_wal
            FROM wallet
            WHERE ema_usr = '$ema' AND tip_div = '$typ';";
    if ($con = $this->connect()->query($sql)) {
      $rows = $con->num_rows;
      return $rows;
    }
  }

  #Crear wallet
  public function createWallet($idt,$ema,$typ) {
    $sql = "INSERT INTO
              wallet (idt_wal,ema_usr,sal_wal,tip_div)
            VALUES (md5('$idt'), '$ema', '0', '$typ');";
    if ($con = $this->connect()->query($sql)) {
      $array = array(
        'title' => '¡Exito!',
        'text'  => 'Nueva wallet creada',
        'icon'  => 'success',
      );
      echo json_encode($array);
    }else{
      $array = array(
        'title' => 'Error',
        'text'  => 'Ocurrió un error inesperado... Lo sentimos',
        'icon'  => 'error',
      );
      echo json_encode($array);
    }
  }

  #Guardar idt, tipo y saldo disponible de una wallet mediante el email y el tipo de divisa
  public function setSaldoWallets($email,$tip) {
    $sql = "SELECT * FROM
              wallet
            WHERE ema_usr = '$email' AND tip_div = '$tip';";
    $con = $this->connect()->query($sql);
    $row = $con->num_rows;

    if ($row>0) {
      while ($res = $con->fetch_assoc()):
        $array = array(
          'idt'   => $res['idt_wal'],
          'tipo'  => $res['tip_div'],
          'saldo' => $res['sal_wal']
        );
      endwhile;
    }else{
      $array = array(
        'cantidad' => '0'
      );
    }
    echo json_encode($array);
  }

  #Establecer la data del perfil para mostrar
  public function setDataProfile($email) {
    $sql = "SELECT * FROM
              users
            WHERE ema_usr = '$email';";
    if ($con = $this->connect()->query($sql)) {
      $res = $con->fetch_assoc();
    }
    return json_encode($res);
  }

  #Retorna una lista de las ordenes de venta expedidas por los usuarios para volcarlas en el marketplace
  public function setAvailableOfertas($email,$divisa) {
    if (empty($divisa)) {
      $sql = "SELECT * FROM
              sell_order
            WHERE stt_sll = '1' ORDER BY fch_reg DESC;";
    }else{
      $sql = "SELECT * FROM
              sell_order
            WHERE stt_sll = '1' AND tip_div = '$divisa' ORDER BY fch_reg DESC;";
    }
    if ($con = $this->connect()->query($sql)) {
      $view = "";
      if ($con->num_rows === 0) {
        $view.="<div class='all'>
                  <h5>No hay ofertas dispoibles en el mercado</h5>
                </div>";
      }else{
        while ($res = $con->fetch_assoc()) {
          $a = $res['ema_usr'];
          $sq1 = "SELECT nom_usr FROM users WHERE ema_usr = '$a';";
          $co1 = $this->connect()->query($sq1);
          $re1 = $co1->fetch_assoc();
          $view.= "<div class='oferta'>
                    <div class='profile'>
                      <img src='assets/img/fav.png' class='img-profile'>
                      <h6>".ucwords($re1['nom_usr'])."</h6>
                    </div>
                    <div class='monto-venta'>
                      <span>".$res['mon_sll'].$res['tip_div']."</span>
                    </div>
                    <div class='metodo-venta'>
                      ".$res['met_sll']."
                    </div>
                    <div class='metodo-venta'>
                      ".$res['tip_act']."
                    </div>
                    <div class='metodo-venta'>
                      ".$res['tas_cmb']."
                    </div>";
            if ($res['ema_usr'] != $email) {
              $idt = $res['idt_sll'];
              $nam = "idt_sll";
              $view.= " <div class='button-oferta'>
                          <a href='#' id='puto' class='$idt btn'>Comprar</a>
                        </div>
                      </div>";
            }else{
              $idt = $res['idt_sll'];
              $view.= " <div class='button-oferta'>
                          <a href='#' id='show' class='$idt btn'>Ver</a>
                        </div>
                      </div>";
            }
        }
      }
      return $view;
    }
  }

  #Consultar cuántas wallets tiene un usurio mediante su correo
  public function consultHowManyWallets($email) {
    $sql = "SELECT * FROM wallet WHERE ema_usr = '$email';";
    if ($con = $this->connect()->query($sql)) {
      $array = [];
      $i     = 0;
      while ($res = $con->fetch_assoc()):
        $array[$i] = array(
          'idt_wal' => $res['idt_wal'],
          'sal_wal' => $res['sal_wal'],
          'tip_div' => $res['tip_div'],
        );
        $i++;
      endwhile;
      
      return json_encode($array);
    }
  }

  public function consultHowManyWalletsOnlyArray($email) {
    $sql = "SELECT * FROM wallet WHERE ema_usr = '$email';";
    if ($con = $this->connect()->query($sql)) {
      $array = [];
      $i     = 0;
      while ($res = $con->fetch_assoc()):
        $array[$i] = array(
          'idt_wal' => $res['idt_wal'],
          'sal_wal' => $res['sal_wal'],
          'tip_div' => $res['tip_div'],
        );
        $i++;
      endwhile;
      
      return $array;
    }
  }

  #Crear nueva orden de venta
  public function createNewSellOrder($tipWal,$metPag,$monto,$email,$idtWal,$actiRec,$tasa) {
    $saldo = $this->consultarSaldo($idtWal);

    if ($saldo>0 && $monto <= $saldo) {
      $sql = "INSERT INTO sell_order
              (ema_usr,idt_wal,mon_sll,tip_div,met_sll,tip_act,tas_cmb)
            VALUES
              ('$email', '$idtWal', '$monto', '$tipWal', '$metPag', '$actiRec', '$tasa');";
      if ($con = $this->connect()->query($sql)) {
        $array = array(
          'title' => '¡Exito!',
          'text'  => 'Nueva orden de venta creada',
          'icon'  => 'success',
        );
        echo json_encode($array);
      }else{
        $array = array(
          'title' => 'Error',
          'text'  => 'Ocurrió un error inesperado... Lo sentimos',
          'icon'  => 'error',
        );
        echo json_encode($array);
      }
    }else{
      $array = array(
        'title' => 'Error',
        'text'  => 'No tiene saldo suficiente',
        'icon'  => 'warning',
      );
      echo json_encode($array);
    }
  }

  public function consultOrders($a) {
    $sql = "SELECT * FROM sell_order WHERE idt_sll = '$a';";
    if ($con = $this->connect()->query($sql)) {
      $res = $con->fetch_assoc();
      return $res;
    }
  }

  public function registerBuy($sql) {
    if ($this->connect()->query($sql)) {
      return true;
    }else{
      return false;
    }
  }

  public function consultarTasa() {
    $sql = "SELECT * FROM ordenanzas_venta ORDER BY fch_reg DESC LIMIT 1";
    if ($con = $this->connect()->query($sql)) {
      $res = $con->fetch_assoc();
      return $res;
    }else {
      return "No registrado";
    }
  }

  public function consultarTasaCompra() {
    $sql = "SELECT * FROM ordenanzas_compra ORDER BY fch_reg DESC LIMIT 1";
    if ($con = $this->connect()->query($sql)) {
      $res = $con->fetch_assoc();
      return $res;
    }else {
      return "No registrado";
    }
  }

  public function validateAdmin($ema,$psw) {
    $sql = "SELECT COUNT(idt_usr) AS suma, ema_usr FROM users WHERE ema_usr = '$ema' AND psw_usr = MD5('$psw') AND stt_usr != 'circle';";
    if ($con = $this->connect()->query($sql)) {
      if($res = $con->fetch_assoc()):
        $array = array(
          "validate" => $res['suma'],
          "email"    => $res['ema_usr']
        );
      endif;
    }
    echo json_encode($array);
  }

  public function setSaldoWalletsFinex($email,$tip) {
    $sql = "SELECT * FROM
              wallet
            WHERE ema_usr = '$email' AND tip_div = '$tip';";
    $con = $this->connect()->query($sql);
    $row = $con->num_rows;

    if ($row>0) {
      while ($res = $con->fetch_assoc()):
        $array = array(
          'idt'   => $res['idt_wal'],
          'tipo'  => $res['tip_div'],
          'saldo' => $res['sal_wal']
        );
      endwhile;
    }else{
      $array = array(
        'cantidad' => '0'
      );
    }
    return $array;
  }

  public function calcularComision() {
    $sql = "SELECT * FROM ordenanzas_comision ORDER BY fch_reg ASC LIMIT 1";
    if ($con = $this->connect()->query($sql)) {
      $res = $con->fetch_assoc();
      return $res;
    }else {
      return "No registrado";
    }
  }

  public function consultWalletByEmailAndType($email,$divisa) {
    $sql = "SELECT
              idt_wal
            FROM wallet
            WHERE ema_usr = '$email' AND tip_div = '$divisa';";
    if ($con = $this->connect()->query($sql)) {
      $result = $con->fetch_assoc();
      return $result['idt_wal'];
    }
  }

  public function getHistoryOfDeposit($email) {
    $sql = "SELECT * FROM deposit WHERE ema_who = '$email' OR ema_frm = '$email';";
    if ($con = $this->connect()->query($sql)) {
      if ($con->num_rows>0):
        $view = "";
        $view.= " <table>
                    <thead>
                      <th>De</th>
                      <th>Para</th>
                      <th>Monto</th>
                      <th>Activo</th>
                      <th>Fecha</th>
                      <th></th>
                    </thead>
                    <tbody>";
        while ($res = $con->fetch_assoc()):
          $who = $res["ema_who"];
          $frm = $res["ema_frm"];
          $stt = "";

          if($who === $email) { $who = "Tú"; } else { $who; }
          if($frm === $email) { $frm = "Tú"; } else { $frm; }
          if($who == "Tú") {
            $stt = "<i class='bx bx-right-arrow-alt'></i>";
          } else {
            $stt = "<i class='bx bx-left-arrow-alt' ></i>";
          }
          $date = strtotime($res["fch_dep"]);

          $view.= " <tr>
                      <td>".$frm."</td>
                      <td>".$who."</td>
                      <td>".$res["sal_dep"]."</td>
                      <td>".$res["tip_div"]."</td>
                      <td>".date("d M Y", $date)."</td>
                      <td>".$stt."</td>
                    </tr>";
        endwhile;
        $view.= "</tbody></table>";
        return $view;
      endif;
    }
  }

  public function howManyOrdersIHave($email) {
    $sql = "SELECT COUNT(idt_sll) AS suma FROM sell_order WHERE ema_usr = '$email' AND stt_sll = '1';";
    if ($con = $this->connect()->query($sql)) {
      $res = $con->fetch_assoc();
      return $res['suma'];
    }
  }

  public function setNewSellOrBuyRateOrd($tip,$email,$ves,$usd,$cop) {
    $d = date("d-M-Y h:m:s");
    $a = md5($d);
    if ($tip == "buy") {
      $sql = "INSERT INTO
                ordenanzas_compra (tok_ord,usu_def,ves_cop,usd_ves,cop_usd)
              VALUES
                ('$a', '$email', '$ves', '$usd', '$cop');";
    } else if ($tip == "sell") {
      $sql = "INSERT INTO
                ordenanzas_venta (tok_ord,usu_def,ves_cop,usd_ves,cop_usd)
              VALUES
                ('$a', '$email', '$ves', '$usd', '$cop');";
    }
    if ($con = $this->connect()->query($sql)) {
      $array = array(
        'status'   => 'fine',
      );
    }else{
      $array = array(
        'status'   => 'bad',
      );
    }
    echo json_encode($array);
  }

  public function setNewBuyComisionValues($comision,$email) {
    $d = date("d-M-Y h:m:s");
    $a = md5($d);
    $sql = "INSERT INTO ordenanzas_comision (tok_ord,usu_def,cnt_com) VALUES ('$a', '$email', '$comision')";
    if ($con = $this->connect()->query($sql)) {
      $array = array(
        'status'   => 'fine',
      );
    }else{
      $array = array(
        'status'   => 'bad',
      );
    }
    echo json_encode($array);
  }

  public function getNotificationsPush($email) {
    $sql = "SELECT * FROM deposit WHERE ema_who = '$email' AND stt_vst = '0';";
    if ($con = $this->connect()->query($sql)):
      if ($res = $con->fetch_assoc()):
        $array = array(
          'ema_frm'   => $res['ema_frm'],
          'sal_dep'   => $res['sal_dep'],
          'tip_div'   => $res['tip_div'],
          'fch_dep'   => $res['fch_dep']
        );
        $idt = $res['idt_dep'];
        $sq2 = "UPDATE deposit SET stt_vst = '1' WHERE idt_dep = '$idt';";
        $this->connect()->query($sq2);
        echo json_encode($array);
      endif;
    endif;
  }
}