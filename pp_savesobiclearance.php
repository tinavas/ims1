<?php
include "getemployee.php";
include "config.php";
session_start();

$q = "select max(trid) as mid from pp_sobiclearance where client = '$client' ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	  $mid = $qr['mid'];
	}
	$mid = $mid + 1;
   $ddate = date("Y-m-j", strtotime($_POST['date']));
  // $party = $_POST['vendor'];
   $vendor = $_POST['vendor'];
   $r= mysql_query("select code from contactdetails where name='$vendor'");
   $a=mysql_fetch_assoc($r);
   $vendorcode=$a['code'];
   $remarks = $_POST['remarks'];
   $cobi = $_POST['sobi'];
   $amount = $_POST['amount'];
   $totalamt = $_POST['total1'];
   $adate=date("Y-m-d");
  
if ( $totalamt  > $amount )
{
     echo "<script type='text/javascript'>";
             echo "alert('Cannot clear more than balance amount');";
             echo "document.location = 'dashboard.php?page=pp_addsobiclearance';";
             echo "</script>";
}

else
{
   
/////////////////COBIClearance table//////////////////////////

for($j=0;$j<count($_POST['samount']);$j++)
{
  //echo $j;
 
  if ($_POST['samount'][$j] > 0)
  {
     $souramount = $_POST['samount'][$j];
	 $sourcenum = $_POST['tnum'][$j];
	 $sourtype = $_POST['type'][$j];
	 $unit=$_POST['unit'][$j];
    $query5 = "INSERT INTO pp_sobiclearance(vendorcode,trid,sobi,sobiamount,date,sourcetype,sourcenum,sourceamount,vendor,narration,flag,client,empname,adate,unit)
           VALUES ('$vendorcode','".$mid."','".$cobi."','".$amount."','".$ddate."','".$sourtype."','".$sourcenum."','".$souramount."','".$vendor."','".$remarks."','0','".$client."','$empname','$adate','$unit')" ;
		
     $get_entriess_res5 = mysql_query($query5,$conn) or die(mysql_error());
  }
 
}

/////////////////end of COBIClearance table//////////////////////////




echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_sobiclearance';";
echo "</script>";

}  
?>
