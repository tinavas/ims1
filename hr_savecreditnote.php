<?php
include "config.php";
include "getemployee.php";

$type = $_POST['type'];
if($type == 'Credit') { $mode = 'Employee Credit';$mode1 = 'ECN'; }
else if($type == 'Debit') { $mode = 'Employee Debit';  $mode1 = 'EDN'; }
$dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];
$entrydate = date("d.m.Y");
$addempid = $empid;
$addempname = $empname;
$flag = 1;
$adate=date("Y-m-d");

if($_POST['saed'] == 1)
{
 $incr = $_POST['incr'];
 $tnum = $_POST['tid'];
 $eempid = $empid;
 $eempname = $empname;
 $query = "SELECT empdate,empid,empname,adate,aempid,aempname,flag FROM hr_empcrdrnote WHERE tid = '$tnum' LIMIT 1";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $rows = mysql_fetch_assoc($result);
 $entrydate = $rows['empdate'];
 $empid = $rows['empid'];
 $empname = $rows['empname'];
 $adate = $rows['adate'];
 $aempid = $rows['aempid'];
 $aempname = $rows['aempname'];
 $flag = $rows['flag'];
 
 $query = "DELETE FROM hr_empcrdrnote WHERE tid = '$tnum' AND mode = '$mode1'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 //if($flag == 1)
 {
  $query = "DELETE FROM ac_financialpostings WHERE trnum = '$tnum' AND type = '$type'";
  $result = mysql_query($query,$conn) or die(mysql_error());
 }
}
else
{
 $q = "select max(incr) as incr from hr_empcrdrnote WHERE mode = '$mode1' and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['incr']; }
$incr = $tnum + 1;
$tnum = "$mode1-$incr";
}
$ename = $_POST['empname'];
$date = date("Y-m-d",strtotime($_POST['date']));
$docno = $_POST['docno'];

$crtotal = $_POST['crtotal'];
$drtotal = $_POST['drtotal'];
$narration = $_POST['narration'];


for($i = 0; $i < count($_POST['code']); $i++)
{
 if($_POST['code'][$i] <> '' && $_POST['drcr'][$i] <> '')
 {
  $temp = explode('@',$_POST['code'][$i]);
  $code = $temp[0];
  $desc = $temp[1];
  $unit = $_POST['unit'][$i];
  $crdr = $_POST['drcr'][$i];
  $cramount = $_POST['cramount'][$i];
  $dramount = $_POST['dramount'][$i];
  if($cramount == '') $cramount = 0;
  if($dramount == '') $dramount = 0;
 $adate =date("Y-m-d");
$query = "INSERT INTO hr_empcrdrnote (incr,tid,docno,mode,date,ecode,ename,sector,code,description,crdr,cramount,dramount,crtotal,drtotal,empdate,empid,empname,eempid,eempname,adate,aempid,aempname,flag,narration,client,balamount) VALUES ('$incr','$tnum','$docno','$mode1','$date','$ecode','$ename','$unit','$code','$desc','$crdr','$cramount','$dramount','$crtotal','$drtotal','$entrydate','$addempid','$addempname','0','$eempname','$adate','$addempid','$addempname','1','$narration','$client','$crtotal')";
  $result = mysql_query($query,$conn) or die(mysql_error());
  //Financial Postings if the record is Authorized only
//  if($flag == 1)
  {
	$amount = $cramount + $dramount;
	$query = "INSERT INTO ac_financialpostings (date,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES ('$date','$crdr','$code','0','$amount','$tnum','$type','$ename','$unit')";
	$result = mysql_query($query,$conn) or die(mysql_error());
  }
 } 
}


echo "<script type='text/javascript'>";
if($mode1 == "ECN")
echo "document.location = 'dashboardsub.php?page=hr_creditnote&type=$type'";
else
echo "document.location = 'dashboardsub.php?page=hr_debitnote&type=$type'";
echo "</script>";

?>