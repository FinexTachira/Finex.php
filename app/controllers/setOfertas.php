<?php
include '../models/Database.php';
$DB = new Database();

$email = $_SESSION['ema_usr'];
$tip   = $_POST['tip'];

switch ($tip) {
  case '#usd':
    $tip = "USD";
    break;

  case '#cop':
    $tip = "COP";
    break;

  case '#ves':
    $tip = "VES";
    break;
    
  case '#all':
    $tip = "";
    break;
}

$row   = $DB->setAvailableOfertas($email,$tip);
echo $row;