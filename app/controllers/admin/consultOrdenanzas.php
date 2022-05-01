<?php
include '../../models/Database.php';
$DB = new Database();

$buyOrd = $DB->consultarTasaCompra();
$sllOrd = $DB->consultarTasa();

$arrayBuy = array(
  "usd_ves" => $buyOrd['usd_ves'],
  "ves_cop" => $buyOrd['ves_cop'],
  "cop_usd" => $buyOrd['cop_usd']
);

$arraySll = array(
  "usd_ves" => $sllOrd['usd_ves'],
  "ves_cop" => $sllOrd['ves_cop'],
  "cop_usd" => $sllOrd['cop_usd']
);

$allArray = array(
  "buy"  => $arrayBuy,
  "sell" => $arraySll
);

echo json_encode($allArray);