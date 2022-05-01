<?php
require 'Database.php';
require '../vendor/autoload.php';
use Twilio\Rest\Client;

//Twilio Credentials
$ACCOUNT_SID_TWI  = "AC4a7de8f20d5ec9d8a421e2c0207bb0ef";
$AUTH_TOKEN_TWI   = "8053176427570e3acaa83f4068d5bfa0";
$PHONE_NUMBER_TWI = "+13344589106";

//Receiver
if (empty($_POST['phone'])) {
  $array = array(
    'title' => 'Error',
    'text'  => 'Se debe proporcionar un número telefónico, o el que registró es invalido',
    'icon'  => 'warning',
  );
  echo json_encode($array);
}else {
  $to     = $_POST['phone'];
  $code   = $_POST['code'];
  $client = new Client($ACCOUNT_SID_TWI,$AUTH_TOKEN_TWI);
  
  if($client->messages->create(
    $to,
    array(
      'from' => $PHONE_NUMBER_TWI,
      'body' => "$code es tu código para iniciar sesión en Finex"
    )
  )){
    $array = array(
      'title' => 'Envíado',
      'text'  => 'Mensaje de texto enviado con exito',
      'icon'  => 'success',
    );
    echo json_encode($array);
    $DB = new Database();
    $DB->send2FAPhone($code,$to);
  }else{
    $array = array(
      'title' => 'Error',
      'text'  => 'No se pudo envíar el mensaje de texto',
      'icon'  => 'error',
    );
    echo json_encode($array);
  }
}