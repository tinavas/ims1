<?php
include "getemployee.php";
include "config.php";
session_start();

$m = $_POST['m'];
$y = $_POST['y'];

$ddate = $_POST['ddate'];

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
   
$ddate = date("Y-m-j", strtotime($ddate));
$remarks = $_POST['remarks'];
if($_SESSION['db'] == "central")
 $approve = '0';
else
 $approve = '1';
$flag = '0';
$adate=date("Y-m-d");
/////////////////purchseindent table//////////////////////////

for($j=0;$j<count($_POST['ing']);$j++)
{
  if (($_POST['ingweight'][$j] != "") && ($_POST['code'][$j] != "") && ($_POST['doffice'][$j] != ""))
   {
      $type = $_POST['type'][$j]; 
	$codes = $_POST['code'][$j];
	$code=explode("@",$codes);
	$code=$code[0];
	$name = $_POST['ing'][$j];
      $quantity = $_POST['ingweight'][$j];
 	$unit = $_POST['unit'][$j];
	$rdate = $_POST['rdate'][$j];
	$rdate = date("Y-m-j", strtotime($rdate));
	$doffice = $_POST['doffice'][$j];
	$demp = $_POST['demp'][$j];
	$chk = $_POST['qc'][$j];
	 
      $query5 = "INSERT INTO pp_purchaseindent (piincr,m,y,date,pi,ioffice,iid,initiator,doffice,cat,receiver,rdate,name,quantity,units,icode,qc,remarks,approve,flag,empname,adate)
           VALUES ('".$piincr."','".$m."','".$y."','".$ddate."','".$pi."','".$sector."','".$empid."','".$empname."','".$doffice."','".$type."','".$demp."','".$rdate."','".$name."','".$quantity."','".$unit."','".$code."','".$chk."','".$remarks."','".$approve."','".$flag."','$empname','$adate')" or die(mysql_error());
		
     $get_entriess_res5 = mysql_query($query5,$conn) or die(mysql_error());

   }
}

/////////////////end of purchaseindent table//////////////////////////





$email = "sivanath@tulassi.com";
$sub = "Purchase Indent";
          
$body = "<html><body>";
$body .= "";
$body .= "<table>
            <tr> 
              <td>Item</td><td>Quantity</td><td>Requested By</td><td>Requesting Office</td>
            </tr>";
for($j=0;$j<count($_POST['ing']);$j++)
{
  if (($_POST['ingweight'][$j] != "") && ($_POST['code'][$j] != "") )
   {
$body .=   "<tr>
              <td>".$name."</td><td>".$quantity."</td><td>".$empname."</td><td>".$sector."</td>
            </tr>";
   }
}


$body .= "</table>";
$db = $_SESSION['db'];
$body .= "Click the link to authorize http://localhost/bimsNEW/authorize.php?db=".$db."&pi=".$pi;
$headers =  'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: info@tulassi.com' . "\r\n";

$toUser  = $email; 
$subject = $sub; 
$body    .= "</body></html>"; 

/*if (mail($toUser,$subject,$body,$headers)) {
} else {
    echo "failed";
}*/




echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_purchaseindent';";
echo "</script>";

  
?>
