<?php 

include "config.php";

include "getemployee.php";



$code = $_POST['code'];

$description = mysql_real_escape_string($_POST['description']);

$cat = $_POST['cat'];

$cm = $_POST['cm'];

$sunits = $_POST['sunits'];
$cunits = $_POST['cunits'];


$usage = $_POST['usage'];

$source = $_POST['source'];

$stdcost = $_POST['stdcost'];

$type = $_POST['type'];
 if($_POST['expca']!="")
	$wpac = $_POST['expca'];
	else
	$wpac="";

$iac = $_POST['iac'];



$cogsac = $_POST['cogsac'];

$sac = $_POST['sac'];

$srac = $_POST['srac'];










$q = "INSERT INTO ims_itemcodes (code,description,cat,cm,sunits,cunits,iusage,source,stdcost,type,iac,cogsac,wpac,sac,srac,client) VALUES ('$code','$description','$cat','$cm','$sunits','$cunits','$usage','$source','$stdcost','$type','$iac','$cogsac','$wpac','$sac','$srac','$client')";



$qrs = mysql_query($q,$conn) or die(mysql_error());




$q1 = "select * from tbl_sector where type1 = 'Warehouse' AND client = '$client'";

$q1rs = mysql_query($q1,$conn) or die(mysql_error());

while($q1r = mysql_fetch_assoc($q1rs))

{



	$q2 = "select * from ims_initialstock where warehouse = '$q1r[sector]' and itemcode = '$code' AND client = '$client'";

	$q2rs = mysql_query($q2) or die(mysql_error());

	if( mysql_num_rows($q2rs) == 0)

	{

	$q = "insert into ims_initialstock (warehouse,itemcode,unit,quantity,rate,amount,client) values  ('$q1r[sector]','$code','$sunits','0','0','0','$client')";

	$qrs = mysql_query($q,$conn) or die(mysql_error());

	}

	

	$q2 = "select * from ims_stock where warehouse = '$q1r[sector]' and itemcode = '$code' AND client = '$client'";

	$q2rs = mysql_query($q2) or die(mysql_error());

	if( mysql_num_rows($q2rs) == 0)

	{

	$q = "insert into ims_stock (warehouse,itemcode,unit,quantity,client) values ('$q1r[sector]','$code','$sunits','0','$client')";

	$qrs = mysql_query($q,$conn) or die(mysql_error());

	}

	

}




echo "<script type='text/javascript'>";

echo "if(confirm('Do you want to add one more')) {";

echo "document.location='dashboardsub.php?page=ims_additemcodes'";

echo "} else {";

echo "document.location='dashboardsub.php?page=ims_itemcodes'";

echo "}";

echo "</script>";





?>