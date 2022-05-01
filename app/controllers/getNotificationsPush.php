<?php
include '../models/Database.php';
$DB = new Database();

$email = $_POST['email'];
$DB->getNotificationsPush($email);