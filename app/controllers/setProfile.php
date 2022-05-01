<?php
include '../models/Database.php';
$DB = new Database();

$email = $_POST['ema'];
$data  = $DB->setDataProfile($email);

echo $data;