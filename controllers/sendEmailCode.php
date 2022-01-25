<?php
include '../models/Database.php';
$DB = new Database();

$emaCode = $_POST['emaCode'];
$email   = $_POST['email'];

$DB->send2FAEmail($emaCode,$email);