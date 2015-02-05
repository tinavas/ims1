<?php
include "config.php";
$code = $_POST['tno'];
$query = "select * from ac_vgrmap where vgroup = '$code' ";
$resultb = mysql_query($query,$conn);
$rowcnt = mysql_num_rows($resultb);
if ( $rowcnt > 0)
{
     echo "<script type='text/javascript'>";
             echo "alert('Code has been already assigned to an account,Please use different code');";
             echo "document.location = 'vengrmap';";
             echo "</script>";
}
else
{
 $query="INSERT INTO ac_vgrmap(vgroup,vdesc,vca,vppac,flag)
 VALUES ('".$_POST['tno']."','".$_POST['desc']."','".$_POST['ca']."','".$_POST['ppac']."','V')" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_vendorgroup';";
echo "</script>";
 
}

 
?>
