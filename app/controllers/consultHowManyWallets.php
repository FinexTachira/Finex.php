<?php
include '../models/Database.php';
$DB = new Database();

$email = $_POST["email"];
$con   = $DB->consultHowManyWallets($email);
echo $con;