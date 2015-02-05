<?php 

include "config.php";

$id = $_GET['id'];

$para = $_GET['par'];

$client = $_SESSION['client'];

$query1="desc hr_salary_parameters";
 $result1=mysql_query($query1,$conn);
while($row1=mysql_fetch_array($result1))
{$c=0;
if($para==$row1[0])
{

 $q = "select count(*) as count from hr_salary_parameters where `$para` !='0' and client='$client'";

 $res1 = mysql_query($q,$conn);

while($r1 = mysql_fetch_assoc($res1))

{

 $c = $r1['count'];

}

if($c == 0)

{

$qd = "ALTER TABLE `hr_salary_parameters`  Drop `$para` ";

$qrsd = mysql_query($qd,$conn) or die(mysql_error());



}

}
}
$q = "delete from hr_params  where id='$id'";

$qrs = mysql_query($q,$conn) or die(mysql_error());







echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=hr_salparams'";

echo "</script>";

?>