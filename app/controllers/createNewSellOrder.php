<?php
include '../models/Database.php';
$DB = new Database();

$tipWal  = $_POST['tipWal'];
$metPag  = $_POST['metPag'];
$monto   = $_POST['monto'];
$email   = $_POST['email'];
$idtWal  = $_POST['idtWal'];
$actiRec = $_POST['actiRec'];
$tasa    = $_POST['tasa'];

$DB->createNewSellOrder($tipWal,$metPag,$monto,$email,$idtWal,$actiRec,$tasa);