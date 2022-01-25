<?php
include '../models/Database.php';
$DB = new Database();

$saldo = $DB->consultarSaldo($_SESSION['mi_wal']);
if (!$saldo) {
  $saldo = '0.00';
}
echo $saldo."USD";