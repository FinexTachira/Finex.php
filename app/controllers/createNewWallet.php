<?php
include '../models/Database.php';
$DB = new Database();

$idt = $_POST['mixed'];
$ema = $_POST['email'];
$typ = $_POST['type'];

$con = $DB->consultIfExistWallet($ema,$typ);

if ($con == 0) {
  $DB->createWallet($idt,$ema,$typ);
}else{
  $array = array(
    'title' => 'Error',
    'text'  => 'Ya posees una Wallet con este tipo de divisa',
    'icon'  => 'error',
  );
  echo json_encode($array);
}