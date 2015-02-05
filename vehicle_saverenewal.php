<?php
include "config.php";



 $date = date("Y-m-d",strtotime($_POST['date']));
$vtype= $_POST['vt'];
  $vnumber= $_POST['vnum'];
 $ccode= $_POST['ccode'];
$amount= $_POST['amount'];
$time= $_POST['time'];
 $remarks= $_POST['remarks'];

 
 $q = "select transactioncode as tid from  `vehicle_renewal` where client = '$client'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],3);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$tno = "RW-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tno="RW-1";

}
$transactioncode = $tno;
 
 $mode=$_POST['cb'];
 $cashbank=$_POST['cno'];
 $expensecoa=$_POST['code'];
 

 
 $q = "insert into vehicle_renewal(transactioncode,date,vehicletype,vehiclenumber,chargecode,amount,validtime,narration,empname,client,mode,cashbankcoa,expensecoa) values ('$transactioncode','$date','$vtype','$vnumber','$ccode','$amount','$time','$remarks','$empname','$client','$mode','$cashbank','$expensecoa')";
 $qrs = mysql_query($q,$conn) or die(mysql_error());




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



$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule,empname,adate) VALUES ('$date','Cr','$coacode','$amount','$transactioncode','RW','$client','$unit','$empname','$cash','$bank','$cashcode','$bankcode','$schedule','$empname','$adate') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	



$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,empname,adate) VALUES ('$date','Dr','$expensecoa','$amount','$transactioncode','RW','$client','$unit','$empname','$empname','$adate') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());






echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_renewal'";
echo "</script>";

?>







