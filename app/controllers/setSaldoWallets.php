<?php
include '../models/Database.php';
$DB = new Database();

$email  = $_POST['email'];
$tipDiv = $_POST['tip'];

$DB->setSaldoWallets($email,$tipDiv);