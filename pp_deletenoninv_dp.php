 <?php 

include "config.php";

include "getemployee.php";




$id = $_GET['id'];
$code = $_GET['code'];

$q = "delete from pp_sobi where so='$id'";
$r=mysql_query($q);

$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'SOBI' and  client='$client'";

$r1q = mysql_query($q1q,$conn) or die(mysql_error());

while($qr = mysql_fetch_assoc($r1q))

{

$amount123 = $qr['amount'];

 $date12 = $qr['date'];

 $coacode = $qr['coacode'];

 $crdr = $qr['crdr'];

$warehouse = $qr['warehouse'];



$q1 = "update ac_financialpostingssummary set amount = amount - $amount123 where coacode = '$coacode'and date = '$date12' and crdr = '$crdr' AND warehouse = '$warehouse'";

$r1 = mysql_query($q1,$conn) or die(mysql_error());

}



$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'SOBI' ";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());









echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=noninv_directpurchasedisplay'";

echo "</script>";



?>



