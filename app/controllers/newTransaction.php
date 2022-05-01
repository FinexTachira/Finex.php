<?php
require '../models/Database.php';
$DB = new Database();

$mont = $_POST['monto'];
$divi = $_POST['divisa'];
$remi = $_POST['remitente'];
$emis = $_SESSION['ema_usr'];
$conc = $_POST['concepto'];

$walF = $DB->consultWalletByEmailAndType($emis,$divi);
$saldoWallet = $DB->consultarSaldo($walF);

if ($saldoWallet == 0 || $saldoWallet < $mont) {
  $array = array(
    "title" => "Error",
    "text"  => "Tu saldo es insuficiente para hacer esta operación, o no posees una wallet para este tipo de divisa.",
    "icon"  => "error"
  );
  echo json_encode($array);
}else{
  $walW = $DB->consultWalletByEmailAndType($remi,$divi);

  if ($walW == $walF || $remi == $emis) {
    $array = array(
      "title" => "Error",
      "text"  => "No puedes depositar a tu wallet... Ve a Wallet en el menú para transferir",
      "icon"  => "error"
    );
    echo json_encode($array);
  }elseif (!$walW) {
    $array = array(
      "title" => "Error",
      "text"  => "El usuario al que intentas depositar no posee una wallet con este tipo de divisa. Transfiere tu dinero a una divisa que ambos tengan en común o pidele que cree una wallet para este tipo de divisa.",
      "icon"  => "error"
    );
    echo json_encode($array);
  }else{
    $DB->depositWallet($walW,$walF,$remi,$emis,$mont,$divi,$conc);
  }
}