<?php

$trnum=$_GET['trnum'];

$q1="delete from packing_dailypacking where trnum='$trnum'";


$q1=mysql_query($q1) or die(mysql_error());


$q1="delete from ac_financialpostings where trnum='$trnum'";


$q1=mysql_query($q1) or die(mysql_error());



 echo "<script type='text/javascript'>";
	  
 echo "document.location='dashboardsub.php?page=dailypacking'";
	  
 echo "</script>";
 

?>