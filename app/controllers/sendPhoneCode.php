<?php
include '../models/Database.php';
$DB = new Database();

$phoCode = $_POST['phoCode'];
$phone   = $_COOKIE['tlf_usr'];

$DB->send2FAPhone($phoCode,$phone);