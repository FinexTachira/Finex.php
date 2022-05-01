<?php
include '../../models/Database.php';
$DB = new Database();

$comision = $_POST['comision'];
$email    = $_POST['email'];
$DB->setNewBuyComisionValues($comision, $email);