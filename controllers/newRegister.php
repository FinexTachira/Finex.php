<?php
include '../models/Database.php';
$DB = new Database();

if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['email']) || empty($_POST['password'])) {
  $array = array(
    'title' => 'Error',
    'text'  => 'Todos los campos son obligatorios',
    'icon'  => 'warning',
  );
  echo json_encode($array);
}else{
  $name     = $_POST['name'];
  $phone    = $_POST['phone'];
  $email    = $_POST['email'];
  $password = $_POST['password'];

  $DB->Register($name,$phone,$email,$password);
}