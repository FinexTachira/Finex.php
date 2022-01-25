<?php
include '../models/Database.php';
$DB = new Database();

switch ($_POST['state']) {
  case 'login':
    if (empty($_POST['email']) || empty($_POST['password'])) {
      $array = array(
        'title' => 'Error',
        'text'  => 'Todos los campos son obligatorios',
        'icon'  => 'warning',
      );
      echo json_encode($array);
    } else {
      $DB->Login($_POST['email'],$_POST['password']);
    }
  break;
  
  default:
    $array = array(
      'title' => 'Error',
      'text'  => 'No se ha podido realizar la acción',
      'icon'  => 'error',
    );
    echo json_encode($array);
  break;
}