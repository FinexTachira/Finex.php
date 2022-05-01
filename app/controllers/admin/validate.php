<?php
include '../../models/Database.php';
$DB = new Database();

$ema = $_POST['ema'];
$psw = $_POST['psw'];

$DB->validateAdmin($ema,$psw);