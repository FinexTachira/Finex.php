<?php
include '../models/Database.php';
$DB = new Database();

$sell = $_POST['sell'];

$a      = $DB->consultOrders($sell);
$b      = $DB->calcularComision();
$activo = $a['tip_div'];
$divisa = $a['tip_act'];
$comi   = $b['cnt_com'];

/*************************
  cuando se trata de VES
    VES -> USD = /
    VES -> COP = *

  cuando se trata de USD
    USD -> VES = *
    USD -> COP = *

  cuando se trata de COP
    COP -> VES = /
    COP -> USD = /

  comision de Finex:
    0.005 = 0.5%
***************************/

switch ($activo) {
  case 'USD':
    $monto    = $a['mon_sll'] * $a['tas_cmb'];
    $comision = $monto * $comi;
    $monto   += $comision;
    break;

  case 'COP':
    $monto  = $a['mon_sll'] / $a['tas_cmb'];
    $comision = $monto * $comi;
    $monto   += $comision;
    break;
  
  case 'VES':
    if ($divisa === "USD") {
      $monto  = $a['mon_sll'] / $a['tas_cmb'];
    } else {
      $monto  = $a['mon_sll'] * $a['tas_cmb'];
    }
    $comision = $monto * $comi;
    $monto   += $comision;
    break;
}

if ($a) {
  $array = array(
    'title' => "¿Continuar con la operación?",
    'text'  => "Se le será descontado ".number_format($monto,2).$divisa." de su Wallet",
    'icon'  => "info",
    'monto' => number_format($monto,2),
    'comi'  => number_format($comision,5),
    'divi'  => $divisa,
    'slWal' => $a['idt_wal'],
    'mnSll' => $a['mon_sll'],
    'tpDiv' => $a['tip_div']
  );
}else{
  $array = array(
    'title' => "Ha ocurrido un error",
    'text'  => "Puede que la orden de venta haya caducado",
    'icon'  => "warning"
  );
}
echo json_encode($array);