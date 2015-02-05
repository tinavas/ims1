<?php
include "config.php";
include "getemployee.php";

   $date1 = $_POST['date'];
   $date1 = date("Y-m-j", strtotime($date1));
   $fromwarehouse = $_POST['fromwarehouse'];


if($_POST['saed'] == "edit")
{
  $q = "delete from ac_financialpostings where trnum = '$_POST[oid]' AND venname = '$_POST[oflock]' AND type ='$_POST[otype]' AND date='$_POST[odate]' AND client='$client'";
   $qr = mysql_query($q,$conn) or die(mysql_error());

  $q = "delete from ims_stocktransfer where id = '$_POST[oid]' AND client='$client'";
  $qr = mysql_query($q,$conn) or die(mysql_error());
}


$q = "select * from ims_itemcodes where (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') and client='$client'";
 $qrs = mysql_query($q,$conn) or die(mysql_error());
 if($qr = mysql_fetch_assoc($qrs))
 {
      $cat = $qr['cat'];
      $code = $qr['code'];
      $mode = $qr['cm'];
	$iac = $qr['iac'];
	$wpac = $qr['wpac'];
	$pvac = $qr['pvac'];
      $warehouse = $qr['warehouse'];
      $stdcost = $qr['stdcost'];
 }


$tid = 0;
$flag = 1;

$q = "select max(tid) as tid from ims_stocktransfer WHERE client = '$client'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;


for($i=0;$i<count($_POST['chicks']);$i++) 
{
 if ($_POST['chicks'][$i] != "" ) 
 { $total = 0; $total1 = 0; $cost = 0; $cost1 = 0;
   $farmer = $_POST['farm'][$i];
   $units = "Numbers"; 
   $newflock = $_POST['flkcount'][$i];
   $aflock = $_POST['aflock'][$i];
   $parentflock = $_POST['parentflock'][$i];
   $chicks = $_POST['chicks'][$i];
$freechicks = $_POST['freechicks'][$i];
   $price = $_POST['price'][$i];
   $dc = $_POST['dc'][$i];
   $tcost = $_POST['tcost'][$i];
   $vehicle = $_POST['vehicle'][$i];
   $driver = $_POST['driver'][$i];
   $mort = $_POST['mort'][$i];
   $shortage = $_POST['shortage'][$i];
   $remarks = $_POST['remarks'][$i];
   $totalamount = ( $chicks - $freechicks ) * $price;
   $total = $chicks + $freechicks;
   $total1 = $total - ($mort + $shortage);

$query2="INSERT INTO ims_stocktransfer (tid,cat,code,flock,aflock,tmno,tcost,date,fromwarehouse,towarehouse,fromunits,tounits,parentflock,quantity,free,price,vehicleno,driver,tmort,shortage,remarks,empid,empname,sector,adate,aempid,aempname,asector,flag,client)
    VALUES ('".$tid."','".$cat."','".$code."','".$newflock."','".$aflock."','".$dc."','".$tcost."','".$date1."','".$fromwarehouse."','".$farmer."','".$units."','".$units."','".$parentflock."','".$chicks."','".$freechicks."','".$price."','".$vehicle."',
          '".$driver."','".$mort."','".$shortage."','".$remarks."','".$empid."','".$empname."','".$sector."','".$date1."','".$empid."','".$empname."','".$sector."','".$flag."','".$client."')" ;
   $get_entriess_res2 = mysql_query($query2,$conn) or die(mysql_error());
   $q = "select max(id) as id from ims_stocktransfer WHERE client = '$client'";
   $qrs = mysql_query($q,$conn) or die(mysql_error());
   if($qr = mysql_fetch_assoc($qrs))
   $id = $qr['id'];

   $type = "CT";
   $cost = $total * $stdcost;
   $cost1 = $total1 * $stdcost;

   $crdr = 'Cr';
  $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date1."','".$code."','".$crdr."','".$iac."','".$total."','".$cost."','".$type."','".$id."','".$aflock."','".$fromwarehouse."','".$client."')";
   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
   $crdr = 'Dr';
  $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date1."','".$code."','".$crdr."','".$iac."','".$total1."','".$cost1."','".$type."','".$id."','".$aflock."','".$farmer."','".$client."')";
   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());


   $diffquantity = $total - $total1;
   $diffamount = $cost - $cost1;

if($diffamount < 0 )
{
 $crdr = 'Cr'; $diffamount = -($diffamount);
 $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date1."','".$code."','".$crdr."','".$pvac."','".$diffquantity."','".$diffamount."','".$type."','".$id."','".$aflock."','".$farmer."','".$client."')";
 $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
}
else if($diffamount > 0 )
{
$crdr = 'Dr';
$q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date1."','".$code."','".$crdr."','".$pvac."','".$diffquantity."','".$diffamount."','".$type."','".$id."','".$aflock."','".$farmer."','".$client."')";
$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
}


 }
}
 
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hatchery_chickstransfer';"; 
echo "</script>";

?>
