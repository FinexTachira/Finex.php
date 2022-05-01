<?php
include '../../models/Database.php';
$DB = new Database();

$tip_ord = $_POST['tip_ord'];
$usu_def = $_POST['usu_def'];
$ves_cop = $_POST['ves_cop'];
$usd_ves = $_POST['usd_ves'];
$cop_usd = $_POST['cop_usd'];

$DB->setNewSellOrBuyRateOrd($tip_ord,$usu_def,$ves_cop,$usd_ves,$cop_usd);