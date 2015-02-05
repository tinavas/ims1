<?php


$trnum=$_GET['trnum'];

$cobi=$_GET['cobi'];


$q1="delete from distribution_salesreceipt where trnum='$trnum'";

$q1=mysql_query($q1) or die(mysql_error());


$q1="delete from ac_financialpostings where trnum='$trnum' and type='DCOBIR'";

$q1=mysql_query($q1) or die(mysql_error());


 $q5="update oc_cobi set srflag=0 where invoice='$cobi'";
 
 $q5=mysql_query($q5) or die(mysql_error());



//header("Location:dashboardsub.php?page=distribution_salesreceipt");

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=distribution_salesreceipt';";

echo "</script>";




?>