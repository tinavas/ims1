<?php
include "config.php";
$code = $_POST['code'];
$flag = '0';
$tflag = '0';
$query = "select * from ac_coa where code = '$code'";
$resultb = mysql_query($query,$conn);
$rowcnt = mysql_num_rows($resultb);
if ( $rowcnt > 0)
{
     echo "<script type='text/javascript'>";
             echo "alert('Code has been already assigned to an account,Please use different code');";
             echo "document.location = 'dashboardsub.php?page=ac_addcoa';";
             echo "</script>";
}
else
{
if($_SESSION['db'] <> 'central')
{
 $query="INSERT INTO ac_coa(code,description,type,controltype,schedule,flag,tflag)
 VALUES ('".strtoupper($_POST['code'])."','".ucwords($_POST['description'])."','".$_POST['type']."','".$_POST['ctype']."','".$_POST['schedule']."','$flag','$tflag')";
}
else
{
$query="INSERT INTO ac_coa(code,description,type,controltype,schedule,flag,tflag,costcentre)
 VALUES ('".strtoupper($_POST['code'])."','".ucwords($_POST['description'])."','".$_POST['type']."','".$_POST['ctype']."','".$_POST['schedule']."','$flag','$tflag','".$_POST['costcentre']."')";
} 
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 $schedule = $_POST['schedule'];
 
 $query1 = "SELECT * FROM ac_schedule WHERE schedule = '$schedule'";
 $get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
 while($row1 = mysql_fetch_assoc($get_entriess_res2))
 {
  $fg = $row1['flag'];
 }

 if($fg <> 'Fixed')
 {
   $query1 = "UPDATE ac_schedule SET flag = 'Used' WHERE schedule = '$schedule'" or die(mysql_error());
   $get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
 }
 header('Location:dashboardsub.php?page=ac_coa');
}

 
?>