<?php
include "config.php";

$date = date("Y-m-d",strtotime($_POST['date']));

$query0 = "SELECT id FROM ac_autodepreciation WHERE date = '$date'";
$result0 = mysql_query($query0,$conn) or die(mysql_error());
if(! mysql_num_rows($result0))
{
$query = "SELECT id,code,ecode,type,amount FROM ac_depreciation WHERE '$date' BETWEEN fromdate AND todate ORDER BY code";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $id = $rows['id'];
 $code = $rows['code'];
 $ecode = $rows['ecode'];
 $amount = $rows['amount'];
 $type = $rows['type'];
$query1 = "select sum(amount) as cramount from ac_financialpostings where date <= '$date' and crdr = 'Cr' and coacode = '$code'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$cramount = $rows['cramount'];
if($cramount == '')
$cramount = 0;
 
 $query1 = "SELECT sum(amount) AS dramount FROM ac_financialpostings WHERE date <= '$date' AND crdr = 'Dr' AND coacode = '$code'";
 $result1 = mysql_query($query1,$conn) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $dramount = $rows1['dramount'];
 if($dramount == "")
 $dramount = 0;
 $diff = $dramount - $cramount;
 $dep_amount = 0;

 $crdr1 = 'Cr'; $crdr2 = 'Dr';
 if($diff < 0)
 { $crdr1 = 'Dr'; $crdr2 = 'Cr'; $diff = -$diff; } 

 if($type == 'Percent')
  $dep_amount = round(($diff * $amount / 100),2);
 else if($type == 'Amount')
  $dep_amount = $amount;
 if($dep_amount <> "0")
 {
 $query1 = "SELECT max(transactioncode) as max FROM ac_gl WHERE voucher = 'J'";
 $result1 = mysql_query($query1,$conn) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $tid = $rows1['max'] + 1;
 
 $query1 = "SELECT code,description,type,controltype,schedule FROM ac_coa WHERE  code IN ('$code','$ecode')";
 $result1 = mysql_query($query1,$conn) or die(mysql_error());
 while($rows1 = mysql_fetch_assoc($result1))
 {
  if($code == "$rows1[code]")
  {
   $desc1 = $rows1['description'];
   $type1 = $rows1['type'];
   $ctype1 = $rows1['controltype'];
   $schedule1 = $rows1['schedule'];
  }
  else if($ecode == "$rows1[code]")
  {
   $desc2 = $rows1['description'];
   $type2 = $rows1['type'];
   $ctype2 = $rows1['controltype'];
   $schedule2 = $rows1['schedule'];
  }
 }
 if($crdr1 == 'Cr')
 { 
 $cramount1 = $dep_amount; $dramount1 = 0; }
 else
 { 
 $dramount1 = $dep_amount; $cramount1 = 0; }

 if($crdr2 == 'Cr')
 { 
 $cramount2 = $dep_amount; $dramount2 = 0; }
 else
 { 
 $dramount2 = $dep_amount; $cramount2 = 0; }

 $query1 = "INSERT INTO ac_gl (code,description,type,controltype,schedule,crdr,cramount,dramount,crtotal,drtotal,voucher,vstatus,transactioncode,mode,bccodeno,date,client,rremarks,warehouse) VALUES ('$code','$desc1','$type1','$ctype1','$schedule1','$crdr1','$cramount1','$dramount1','$dep_amount','$dep_amount','J','A','$tid','Journal','0','$date','$client','Depreciation','Administrative Office'),('$ecode','$desc2','$type2','$ctype2','$schedule2','$crdr2','$cramount2','$dramount2','$dep_amount','$dep_amount','J','A','$tid','Journal','0','$todate','$client','Depreciation','Administrative Office')";
  mysql_query($query1,$conn) or die(mysql_error());
  
 echo  $query1 = "INSERT INTO ac_financialpostings (id,date,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES 
 (NULL,'$date','$crdr1','$code','0','$dep_amount','$tid','Journal','Depreciation','Administrative Office'), (NULL,'$date','$crdr2','$ecode','0','$dep_amount','$tid','Journal','Depreciation','Administrative Office')";
  mysql_query($query1,$conn) or die(mysql_error());
  
  $query1 = "UPDATE ac_depreciation SET flag = 1 WHERE id = '$id'";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
 }
}
echo $query1 = "INSERT INTO ac_autodepreciation (date,client) VALUES ('$date','$client')";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
}
else
 $alertmsg = "The Depreciation has been done for this month and year";
 
echo "<script type='text/javascript'>";
if($alertmsg <> "")
 echo "alert('$alertmsg');"; 
//echo "document.location='dashboardsub.php?page=ac_autodepreciation'";
echo "</script>";

?>