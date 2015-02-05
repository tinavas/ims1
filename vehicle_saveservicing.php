<?php
include "config.php";

 $date = date("Y-m-d",strtotime($_POST['date']));
 $serdate = date("Y-m-d",strtotime($_POST['sdate']));
$vtype= $_POST['vt'];
  $vnumber= $_POST['vnum'];
 $scode= $_POST['scod'];
$warranty= $_POST['warranty'];
$sc= $_POST['sc'];



 $q = "select transactioncode as tid from  `vehicle_servicing` where client = '$client'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],3);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$tno = "VS-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tno="VS-1";

}
$transactioncode = $tno;


$driver = "";
for($i=0;$i<count($_POST['driver']);$i++)
{

if($driver == "")
{
$driver = $_POST['driver'][$i];
}
else
{
$driver = $driver . "/". $_POST['driver'][$i] ;
}
}
 $remarks= $_POST['remarks'];
 $mode=$_POST['cb'];
 $cashbank=$_POST['cno'];
 $expensecoa=$_POST['code'];
 
 
 
 
 $q = "insert into vehicle_servicing(transactioncode,date,vehicletype,vehiclenumber,servicecode,tnextservicedate,warranty,servicecharges,driver,narration,client,empname,mode,cashbankcoa,expensecoa) values ('$transactioncode','$date','$vtype','$vnumber','$scode','$serdate','$warranty','$sc','$driver','$remarks','$client','$empname','$mode','$cashbank','$expensecoa')";
 $qrs = mysql_query($q,$conn) or die(mysql_error());

$amount=$sc;



$q3="SELECT coacode
FROM  `ac_bankmasters` 
WHERE acno =  '$cashbank'
AND MODE =  '$mode'";
$rse3=mysql_query($q3,$conn);
$rows1=mysql_fetch_array($rse3);
$coacode=$rows1['coacode'];




$allcodes = $coacode;
$entrycode=$coacode;
 
$c = $b = -1;	//$c means cash index and $b means bank index
$ce = $be = 0;	//$ce means cash entry and $be means bank entry
$q = "SELECT code,controltype FROM ac_coa WHERE (controltype = 'Cash' OR controltype LIKE '%Bank%') AND client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
while($rr = mysql_fetch_assoc($r))
{ 
 if($rr['controltype'] == 'Cash')
 { 
  
  if($rr['code']==$coacode)
  { $cash="YES";
  
  $bank="NO";
  $cashcode = $rr['code']; }	// It means one cash entry record is there   
 }
 elseif( strlen(strstr($rr['controltype'],"Bank")) > 0)  
 {
  
  if($rr['code']==$entrycode)
  {  $cash="NO";
  
  $bank="YES";
  $bankcode = $rr['code']; // It means one bank entry record is there   
 } 
}
}
//End

$adate=$date;



$q = "SELECT schedule FROM ac_coa WHERE code = '$coacode' AND client = '$client'";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $schedule = $rr['schedule'];

$q2="SELECT unit FROM  `vehicle_master` WHERE vnumber =  '$vnumber' and vtype='$vtype'";
$rse2=mysql_query($q2,$conn);
$rows=mysql_fetch_array($rse2);
$unit=$rows['unit'];



$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule,empname,adate) VALUES ('$date','Cr','$coacode','$amount','$transactioncode','VS','$client','$unit','$empname','$cash','$bank','$cashcode','$bankcode','$schedule','$empname','$adate') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	



$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,empname,adate) VALUES ('$date','Dr','$expensecoa','$amount','$transactioncode','VS','$client','$unit','$empname','$empname','$adate') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	






echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_servicing'";
echo "</script>";

?>







