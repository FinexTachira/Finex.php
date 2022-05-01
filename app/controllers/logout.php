<?php
@session_start();
session_destroy();
$_SESSION['active'] = FALSE;
unset($_COOKIE['tlf_usr']); 
setcookie('tlf_usr', null, -1, '/');
header("Location: ../views/pages/login.php");