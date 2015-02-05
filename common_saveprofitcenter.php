<?php 
include "config.php";
if($_GET[edit]=='true') {
  $q="delete from tbl_profitcenter where tid=".$_GET[id];
  mysql_query($q,$conn) or die(mysql_error());
}
/*$i=0;
while($_POST[costcenter][$i])
$cc .=$_POST[costcenter][$i++].",";
 $cc=substr($cc,0,-1);
 */
$tid = "";
$q = "select max(tid) as tid from tbl_profitcenter where client = '$client'";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;
for($i = 0; $i < count($_POST['inputcat']); $i++)
{
if($_POST['inputcat'][$i] != "" && $_POST['outputcat'][$i] != "" )
{

$icat =$_POST[inputcat][$i];
$ocat =$_POST[outputcat][$i]; 
$j=0;
while($_POST[costcenter][$j])
{
$cc = $_POST[costcenter][$j++];
$query = "insert into tbl_profitcenter (tid,profitcenter,costcenter,inputcat,outputcat,client) values ('$tid','".$_POST[pc]."','".$cc."','".$icat."','".$ocat."','".$client."')";
$result = mysql_query($query,$conn) or die(mysql_error());
}

}
}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=common_profitcenter';";
echo "</script>";

?>