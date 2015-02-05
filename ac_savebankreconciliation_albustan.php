<?php 
include "config.php";
include "getemployee.php";

$bank = $_POST['bank'];
$date = $_POST['date'];
$rdate = date("Y-m-d");
$empid = $empid;
$empname = $empname;

for($j = 0;$j<count($_POST['trnum']);$j++)
{
 $i = $_POST['trnum'][$j]; //if($_POST['tid'][$i] != "" )
{
$type = $_POST['type'][$i];
$tid = $_POST['tid'][$i];
$chk = $_POST['chno'][$i];
$date = $_POST['cdate'][$i];
$date=date("Y-m-d",strtotime($date));
$chkdate = $_POST['cdate'][$i];
$chkdate=date("Y-m-d",strtotime($chkdate));
$dr = $_POST['dramount'][$i];
$cr = $_POST['cramount'][$i];
$pname = $_POST['name'][$i];

$q = "insert into ac_recons(bank,date,cheque,rdate,dr,cr,payee,type,trnum,empid,empname) VALUES ('$bank','$chkdate','$chk','$rdate','$dr','$cr','$pname','$type','$tid','$empid','$empname')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$q = "update ac_gl set status = 'R',chkdate = '$chkdate' where chequeno = '$chk' and bccodeno = '$bank' ";
//$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_bankreconciliation_albustan';"; 
echo "</script>";

?>
