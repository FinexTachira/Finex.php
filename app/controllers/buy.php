<?php
include '../models/Database.php';
$DB = new Database();

$email   = $_POST['email'];
$monto   = $_POST['monto'];
$idtSl   = $_POST['b'];
$ref_buy = $_POST['date'];
$sll_wal = $_POST['slWal'];
$mon_sll = $_POST['mnSll'];
$tip_dvs = $_POST['tpDiv'];
$tip_dvb = $_POST['divis'];
$com_pag = $_POST['comis'];

$a = $DB->consultWalletByEmailAndType($email,$tip_dvb);
$b = $DB->consultarSaldo($a);

if ($monto>$b) {
  $array = array(
    "title"  => "Error",
    "text"   => "No posee los fondos suficientes para comprar esta divisa",
    "icon"   => "error",
    "status" => "fondos insuficientes",
    "a" => $a,
    "b" => $b,
    "monto" => $monto>$b
  );
}else{
  $sql = "INSERT INTO
            buy_order (ref_buy,idt_sll,sll_wal,buy_wal,mon_sll,tip_dvs,mon_buy,tip_dvb,com_pag)
          VALUES
            (md5('$ref_buy'), '$idtSl', '$sll_wal', '$a', '$mon_sll', '$tip_dvs', '$monto', '$tip_dvb', '$com_pag');";
  if ($con = $DB->registerBuy($sql)) {
    $array = array(
      "status" => "done"
    );
  }else{
    $array = array(
      "status" => "error 1011",
      "sql" => $sql
    );
  }
}

echo json_encode($array);