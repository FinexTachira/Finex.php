<?php
require '../models/Database.php';

$phone   = $_POST['phone'];
$email   = $_POST['email'];
$phoCode = $_POST['phoCode'];
$emaCode = $_POST['emaCode'];

$DB  = new Database();
$sum = $DB->Validate($phone,$email,$phoCode,$emaCode);

if ($sum == "good") {
  $_SESSION['active'] = TRUE;
  $array = array(
    'title' => 'Iniciando Sesión',
    'text'  => 'Espere un momento...',
    'icon'  => 'success'
  );
  echo json_encode($array);
}
else if ($sum == "bad") {
  $array = array(
    'title' => 'Intente nuevamente',
    'text'  => 'Uno de los códigos parece ser incorrecto',
    'icon'  => 'warning'
  );
  echo json_encode($array);
}
else if ($sum == "nothing") {
  $array = array(
    'title' => 'Error',
    'text'  => 'Ninguno de los códigos coinciden',
    'icon'  => 'error'
  );
  echo json_encode($array);
}
else if ($sum == "not") {
  $array = array(
    'title' => 'Error',
    'text'  => 'Algo ha ocurrido mal... intente más tarde',
    'icon'  => 'error'
  );
  echo json_encode($array);
}