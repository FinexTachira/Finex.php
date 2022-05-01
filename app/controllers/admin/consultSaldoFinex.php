<?php
include '../../models/Database.php';
$DB = new Database();

$ema = "admin@finex.capital";
$usd = $DB->setSaldoWalletsFinex($ema, "USD");
$cop = $DB->setSaldoWalletsFinex($ema, "COP");
$ves = $DB->setSaldoWalletsFinex($ema, "VES");

$allArray = array(
  "usd" => $usd["saldo"],
  "cop" => $cop["saldo"],
  "ves" => $ves["saldo"]
);

echo json_encode($allArray);