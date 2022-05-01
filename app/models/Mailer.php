<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Database.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$Mail  = new PHPMailer(true);

if (!empty($_POST['email']) && !empty($_POST['code'])) {
  $email = $_POST['email'];
  $code  = $_POST['code'];

  try {
    //Server Settings
    $Mail->isSMTP();
    $Mail->SMTPDebug  = 0;
    $Mail->Host       = "mail.finex.capital";
    $Mail->SMTPAuth   = true;
    $Mail->Username   = "autenticacion@finex.capital";
    $Mail->Password   = "WKbttWGrJC3LGqs";
    $Mail->SMTPSecure = "ssl";
    $Mail->Port       = 465;
  
    //Recipients
    $Mail->setFrom("autenticacion@finex.capital", "Finex");
    $Mail->addAddress($email);
  
    //Content
    $Mail->isHTML(true);
    $Mail->Subject    = "Antes de iniciar, autenticate";
    $Mail->Body       = "
                          <h1>Código de verificación</h1>
                          <br>
                          <p>
                            Su código para iniciar sesión en Finex es: <b>$code</b>
                            <br><br>
                            Si cree que ha recibido este código por error, haga <a href='#'>click aquí</a>
                          </p>
                          <br>
                          <p>
                            Si no ha solicitado un código y desea aplicar medidas de seguridad ante un posible
                            ataque, haga <a href='#'>click aquí</a>
                          </p>
                        ";
    
    //Send
    if($Mail->send()){
      $array = array(
        'title' => 'Enviado',
        'text'  => 'Correo envíado exitosamente',
        'icon'  => 'success',
      );
      echo json_encode($array);
      $DB = new Database();
      $DB->send2FAEmail($code,$email);
    }
    
  }
  catch (Exception $e) {
    $array = array(
      'title' => 'Error',
      'text'  => 'No se pudo envíar el correo electrónico',
      'icon'  => 'error',
    );
    echo json_encode($array);
  }
}else{
  $array = array(
    'title' => 'Error',
    'text'  => 'No se pudo envíar el correo electrónico',
    'icon'  => 'error',
  );
  echo json_encode($array);
}