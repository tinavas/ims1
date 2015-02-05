<?php 
include "config.php";
if($_GET[edit]=='true') {
  $q="delete from tbl_ioratio where id=".$_GET[id];
  mysql_query($q,$conn) or die(mysql_error());
}
$pc=explode('@',$_POST[pc]);
$pc=$pc[0];
$icat =$_POST[icat];
$ocat =$_POST[ocat]; 
$tdate=date("Y-m-d",strtotime($_POST[tdate]));
$fdate=date("Y-m-d",strtotime($_POST[fdate]));
$units=$_POST[units];
$query = "insert into tbl_ioratio (profitcenter,inputcat,outputcat,tdate,fdate,units,client) values ('".$pc."','".$icat."','".$ocat."','".$tdate."','".$fdate."','".$units."','".$client."')";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=common_ioratio';";
echo "</script>";

?>