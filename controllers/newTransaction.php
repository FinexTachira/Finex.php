<?php
require '../models/Database.php';
$DB = new Database();

$mont = $_POST['monto'];
$divi = $_POST['divisa'];
$remi = $_POST['remitente'];
$emis = $_SESSION['ema_usr'];
$conc = $_POST['concepto'];

$walW = $DB->consultWallet($remi);
$walF = $_SESSION['mi_wal'];

if ($walW == $walF) {
  $array = array(
    "title" => "Error",
    "text"  => "No puedes depositar a tu wallet... Ve a Wallet en el menú para transferir",
    "icon"  => "error"
  );
  echo json_encode($array);
}else{
  $DB->depositWallet($walW,$walF,$remi,$emis,$mont,$divi,$conc);
}