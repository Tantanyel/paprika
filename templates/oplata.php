<?php
include("connect.php");

$skey = "356a586773307b667268535a76746a4c494864644d3634356e6e47";

function print_answer($result, $description)
{
  print "WMI_RESULT=" . strtoupper($result) . "&";
  print "WMI_DESCRIPTION=" .$description;
  exit();
}

if (!isset($_POST["WMI_SIGNATURE"]))
  print_answer("Retry", "Отсутствует параметр WMI_SIGNATURE");

if (!isset($_POST["WMI_PAYMENT_NO"]))
  print_answer("Retry", "Отсутствует параметр WMI_PAYMENT_NO");

if (!isset($_POST["WMI_ORDER_STATE"]))
  print_answer("Retry", "Отсутствует параметр WMI_ORDER_STATE");

foreach($_POST as $name => $value)
{
  if ($name !== "WMI_SIGNATURE") $params[$name] = $value;
}

uksort($params, "strcasecmp"); $values = "";

foreach($params as $name => $value)
{

  $values .= $value;
}

$signature = base64_encode(pack("H*", md5($values . $skey)));

if ($signature == $_POST["WMI_SIGNATURE"])
{
  if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED")
  {
    $idzak = $_POST["WMI_PAYMENT_NO"];
    $zakazq = @mysql_query("SELECT * FROM zakaz WHERE id=$idzak",$db);
    $myrow = @mysql_fetch_array($zakazq);
    if($myrow){
      $cenazak = $myrow['cena'].".00";
      if($cenazak==$_POST["WMI_PAYMENT_AMOUNT"]){
        $query = mysql_query("UPDATE zakaz SET oplata='onlok' WHERE id='$idzak'",$db);
      }
    }

    print_answer("Ok", "Заказ #" . $_POST["WMI_PAYMENT_NO"] . " оплачен!");
  }
  else
  {
    print_answer("Retry", "Неверное состояние ". $_POST["WMI_ORDER_STATE"]);
  }
}
else
{
  print_answer("Retry", "Неверная подпись " . $_POST["WMI_SIGNATURE"]);
}

?>