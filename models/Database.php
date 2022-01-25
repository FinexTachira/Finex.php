<?php
session_start();
error_reporting(0);

class DataBase {
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

  public function Count_Users() {
    $query  = "SELECT idt_usr FROM users";
    $result = $this->connect()->query($query);
    $count  = $result->num_rows;
    return $count;
  }

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
      );
      echo json_encode($array);
    }else{
      $array = array(
        'title' => 'Ha ocurrido un error',
        'text'  => 'El correo o número de teléfono ya está registrado, o tenemos problemas para registrarte',
        'icon'  => 'error',
      );
      echo json_encode($array);
    }
  }

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

  public function Validate ($phone,$email,$phoCode,$emaCode) {
    $sql = "SELECT
              COUNT(cod_2fa) AS suma1
            FROM code_phone
            WHERE cod_2fa = '$phoCode' AND tlf_usr = '$phone'
            UNION ALL
            SELECT
              COUNT(cod_2fa) AS suma2
            FROM code_email
            WHERE cod_2fa = '$emaCode' AND ema_usr = '$email';";
    $sum = 0;
    $con = $this->connect()->query($sql);
    while ($res = $con->fetch_assoc()){
      $sum += $res['suma1'];
    }
    return $sum;
  }

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

  public function consultWallet ($email) {
    $sql = "SELECT
              idt_wal
            FROM wallet
            WHERE ema_usr = '$email';";
    if ($con = $this->connect()->query($sql)) {
      $result = $con->fetch_assoc();
      return $result['idt_wal'];
    }
  }

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
}