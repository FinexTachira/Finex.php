<?php
include '../models/Database.php';
$DB = new Database();

$wallets = $DB->consultHowManyWalletsOnlyArray($_SESSION['ema_usr']);

$saldo = 0;
$usdta = $DB->consultarTasa();

for ($i = 0; $i < sizeof($wallets); $i++) {
  switch ($wallets[$i][tip_div]) {
    case 'USD':
      $saldo += $wallets[$i]['sal_wal'];
      break;

    case 'COP':
      $a = $wallets[$i]['sal_wal'] / $usdta['cop_usd'];
      $saldo += $a;
      break;

    case 'VES':
      $b = $wallets[$i]['sal_wal'] / $usdta['usd_ves'];
      $saldo += $b;
      break;
  }
}

if (!$saldo) {
  $saldo = '0.00';
}

$data = array(
  'saldo'   => number_format($saldo,5)."USD",
  'usdtasa' => $usdta['usd_ves'],
  'coptasa' => $usdta['cop_usd'],
  'vestasa' => $usdta['ves_cop']
);
echo json_encode($data);