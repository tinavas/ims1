<?php 
include "config.php";
$type = $_POST['type'];
$mode = $_POST['mode1']; 
for($i = 0;i<count($_POST['tno']) && $_POST['vendor'][$i]!='' && $_POST['code'][$i] != "" && $_POST['vendamount'][$i] !=0 && $_POST['vendamount'][$i] !="" ;$i++)
{
$tno = $_POST['tno'][$i];
$date=date("Y-m-d",strtotime($_POST['date'][$i]));
$vendor = $_POST['vendor'][$i];
$vamount = $_POST['vendamount'][$i];
$remarks = $_POST['remarks'][$i];
$totamount = $_POST['vendamount'][$i];
$crtotal = $_POST['crtotal'][$i];
$drtotal = $_POST['drtotal'][$i];

$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
$crdr = $_POST['drcr'][$i];
$dramount = $_POST['dramount'][$i]; if($dramount=='') $dramount=0; if($drtotal=='') $drtotal=0;
$cramount = $_POST['cramount'][$i]; if($cramount=='') $cramount=0; if($crtotal=='') $crtotal=0;


$q = "insert into ac_crdrnote (crnum,mode,vcode,crdr,coa,description,dramount,cramount,totalamount,date,remarks,flag,drtotal,crtotal,client) VALUES ('$tno','$mode','$vendor','$crdr','$code','$desc','$dramount','$cramount','$totamount','$date','$remarks','U','$drtotal','$crtotal','".$client."')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());


/*************Authorization Code begins here**************************/

if($mode == 'CCN') $drcr = 'Cr'; 
if($mode == 'CDN') $drcr = 'Dr'; 

$quantity = '0';
$q = "select * from ac_crdrnote where crnum = '$tno' and client = '$client'  and mode = '$mode' LIMIT 1"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) 
{ 
  $grandtotal = $qr['totalamount'];
  $query1 = "SELECT * FROM contactdetails WHERE name = '$qr[vcode]' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $ca = $row1['ca']; }

  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$drcr','".$ca."','$quantity','".$grandtotal."','".$tno."','".$mode."','".$qr[vcode]."','".$qr[vcode]."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());	
}

$q = "select * from ac_crdrnote where crnum = '$tno' and mode = '$mode' and client = '$client'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) 
{ 
  if($qr['dramount'] > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$qr[crdr]','".$qr[coa]."','$quantity','".$qr['dramount']."','".$tno."','".$mode."','".$qr[vcode]."','".$qr[vcode]."','".$client."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
  }
 if($qr['cramount'] > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$qr[crdr]','".$qr[coa]."','$quantity','".$qr['cramount']."','".$tno."','".$mode."','".$qr[vcode]."','".$qr[vcode]."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
  }


}

$q = "update ac_crdrnote set flag = 'A' where crnum = '$tno' and mode = '$mode' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}

/************Authorization Code ends here****************************/
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=oc_creditnote&type=$type'";
echo "</script>";

?>