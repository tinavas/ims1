<?php
include "getemployee.php";
include "config.php";
session_start();
$pi = $_POST['oldpi'];
$m = $_POST['m'];
$y = $_POST['y'];
$piincr = $_POST['piincr'];
$ddate = $_POST['ddate'];
$ddate = date("Y-m-j", strtotime($ddate));
$remarks = $_POST['remarks'];
$approve = '1';
$flag = '0';




      $query = "DELETE FROM pp_purchaseindent WHERE pi = '$pi'";
      $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
/////////////////purchseindent table//////////////////////////



$temp=explode("-",$pi);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$pi=$pi;
else
{


   $query1 = "SELECT MAX(piincr) as piincr FROM pp_purchaseindent  where m = '$m' AND y = '$y' ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $piincr = 0;
   while($row1 = mysql_fetch_assoc($result1))
   {
	 $piincr = $row1['piincr'];
   }
   $piincr = $piincr + 1;

if ($piincr < 10)
    $pi = 'PR-'.$m.$y.'-000'.$piincr;
else if($piincr < 100 && $piincr >= 10)
    $pi = 'PR-'.$m.$y.'-00'.$piincr;
else
   $pi = 'PR-'.$m.$y.'-0'.$piincr;


}

for($j=0;$j<count($_POST['ing']);$j++)
{
  if (($_POST['ingweight'][$j] != "") && ($_POST['code'][$j] != "")  && ($_POST['doffice'][$j] != "")  )
   {
      $type = $_POST['type'][$j]; 
	$code = $_POST['code'][$j];
	$name = $_POST['ing'][$j];
      $quantity = $_POST['ingweight'][$j];
 	$unit = $_POST['unit'][$j];
      $rdate = $_POST['rdate'][$j];
	$rdate = date("Y-m-j", strtotime($rdate));
	$doffice = $_POST['doffice'][$j];
      $demp = $_POST['demp'][$j];
      $chk = $_POST['qc'][$j];
	  $adate=date("Y-m-d");
	  $empname=$_POST['cuser'];
	  
	 
      $query5 = "INSERT INTO pp_purchaseindent (piincr,m,y,date,pi,ioffice,iid,initiator,doffice,cat,receiver,rdate,name,quantity,units,icode,qc,remarks,approve,flag,empname,adate)
           VALUES ('".$piincr."','".$m."','".$y."','".$ddate."','".$pi."','".$sector."','".$empid."','".$empname."','".$doffice."','".$type."','".$demp."','".$rdate."','".$name."','".$quantity."','".$unit."','".$code."','".$chk."','".$remarks."','".$approve."','".$flag."','$empname','$adate')" or die(mysql_error());
		
     $get_entriess_res5 = mysql_query($query5,$conn) or die(mysql_error());

   }
}

/////////////////end of purchaseindent table//////////////////////////


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_purchaseindent';";
echo "</script>";

  
?>
