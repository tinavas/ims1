<?php

$date = $_POST['date'];
$date = date("Y-m-j", strtotime($date));

include "config.php";
for($i=0;$i<count($_POST['param']);$i++) {
 if( $_POST['param'][$i] != "") {

 $query1="INSERT INTO tbl_labvalues (date,ge,po,itd,vendor,branch,name,param,first,second,third,fourth,fifth,sixth,result,unit,type)
 VALUES ('".$date."','".$_POST['ge']."','".$_POST['po']."','".$_POST['itd']."','".$_POST['vendor']."'
,'".$_POST['branch']."','".$_POST['name']."','".$_POST['param'][$i]."'
,'".$_POST['First'][$i]."','".$_POST['Second'][$i]."','".$_POST['Third'][$i]."'
,'".$_POST['Fourth'][$i]."','".$_POST['Fifth'][$i]."','".$_POST['Sixth'][$i]."'
,'".$_POST['result'][$i]."','".$_POST['unit'][$i]."','".$_POST['type']."')" or die(mysql_error());
$get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
 }
}


$q = "update pp_gateentry set flag = '1' , qcaflag = '1' where ge = '$_POST[ge]' and desc1 = '$_POST[name]'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "parent.location='dashboardsub.php?page=pp_qc'";
echo "</script>";

?>