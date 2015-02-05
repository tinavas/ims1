<?php

include "config.php";
include "getemployee.php";
$date = $_POST['date'];
$date = date("Y-m-j", strtotime($date));

$formulaid = $_POST['formulaid'];
$q = "delete from product_formula where id = '$formulaid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$exp=explode("@",$_POST['producttype']);
$code=$exp[0];
$desc=$exp[1];



          
 $query="INSERT INTO product_formula (producttype,productdesc,name,date,quantity,total,warehouse)
 VALUES ('".$code."','".$desc."','".$_POST['formula']."','".$date."','".$_POST['kgs']."','".$_POST['tweight']."','".$_POST['warehouse']."')";
 
 

 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());


$q = "delete from product_fformula where formulaid = '$formulaid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$formulaid = "";
$q = "select id from product_formula order by id DESC LIMIT 1";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$formulaid = $qr['id'];

for($i=0;$i<count($_POST['quantity']);$i++) {
 if( $_POST['desc'][$i] != "Select") {
/* $item = explode("@",$_POST['item'][$i]);
 $item = $item[0];*/
  $item = $_POST['item'][$i];
  $quantity = $_POST['quantity'][$i];
 //$quantity = convertqty($quantity,$_POST['units'][$i],'Kgs',1);
 $kg = "Kgs"; 
 $kg=$_POST['units'][$i];

  $query1="INSERT INTO product_fformula (sid,formulaid,ingredient,quantity,oldquantity,unit,oldunit,producttype,warehouse)
 VALUES ('".$_POST['formula']."','$formulaid','".$item."','".$quantity."','".$_POST['quantity'][$i]."','".$kg."','".$_POST['units'][$i]."','".$code."','".$_POST['warehouse']."')" ;
 $get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
 }
}

header('Location:dashboardsub.php?page=product_productformula');
                      
?>