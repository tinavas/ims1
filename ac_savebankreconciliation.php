<?php 
include "config.php";
$bank = $_POST['bank'];
$date = $_POST['date'];


for($i = 0;$i<count($_POST['chno']);$i++)
{
if($_POST['date'][$i] != "" )
{
$type = $_POST['type'][$i];
$tid = $_POST['tid'][$i];
$chk = $_POST['chno'][$i];
$date = $_POST['cdate'][$i];
$date=date("Y-m-d",strtotime($date));
$chkdate = $_POST['date'][$i];
$chkdate=date("Y-m-d",strtotime($chkdate));
$dr = $_POST['dramount'][$i];
$cr = $_POST['cramount'][$i];
$pname = $_POST['name'][$i];

$q = "insert into ac_recons(bank,date,cheque,chdate,dr,cr,payee,type,trnum) VALUES ('$bank','$date','$chk','$chkdate','$dr','$cr','$pname','$type','$tid')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_gl set status = 'R',chkdate = '$chkdate' where chequeno = '$chk' and bccodeno = '$bank' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_bankreconciliation';"; 
echo "</script>";

?>
