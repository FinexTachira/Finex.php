<?php
include '../models/Database.php';
$DB = new Database();

$email = $_SESSION['ema_usr'];
$a = $DB->howManyOrdersIHave($email);
echo $a;