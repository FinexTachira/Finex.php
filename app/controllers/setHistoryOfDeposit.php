<?php
include '../models/Database.php';
$DB = new Database();

$email = $_SESSION['ema_usr'];
$a = $DB->getHistoryOfDeposit($email);
echo $a;