<?php
include "config.php";
$id=$_POST['tno'];
$type=$_POST['type'];
$mode=$_POST['mode1'];
$tid=$_POST['tid'];
$tno=$_POST['tno'];
$query1="DELETE FROM ac_financialpostings WHERE trnum = '".$tid."' AND type = '".$mode."'";
$result1=mysql_query($query1,$conn) or die(mysql_error());

$query2="DELETE FROM ac_crdrnote WHERE tid='$tid' and crnum = '".$id."' AND mode = '".$mode."'";
$result2=mysql_query($query2,$conn) or die(mysql_error());

//Saving the record details
$type = $_POST['type'];
$mode = $_POST['mode1'];
$temp = explode('@',$_POST['vendor']);
$vendor = $temp[0];
$vendorcode = $temp[1];
$tno = $_POST['tno'];
$date=date("Y-m-d",strtotime($_POST['date']));
$temp = explode('@',$_POST['vendor']);
$vendor = $temp[0];
$vendorcode = $temp[1];
$vamount = $_POST['vendamount'];
$remarks = $_POST['remarks'];
$totamount = $_POST['vendamount'];
$crtotal = $_POST['crtotal'];
$drtotal = $_POST['drtotal'];
$unit=$_POST['unitc'];
$adate=date("Y-m-d");
for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "" && ($_POST['dramount'][$i]>0  || $_POST['cramount'][$i]>0) )
{
$codedesc = explode("@",$_POST['code'][$i]);
$code=$codedesc[0];
$desc = $codedesc[1];
$crdr = $_POST['drcr'][$i];
$dramount = $_POST['dramount'][$i];
$cramount = $_POST['cramount'][$i];
$empname=$_POST['cuser'];

$q = "insert into ac_crdrnote (vpcode,crnum,mode,tid,vcode,crdr,coa,description,dramount,cramount,totalamount,date,remarks,flag,drtotal,crtotal,client,unit,empname,adate) VALUES ('$vendorcode','$tno','$mode','$tid','$vendor','$crdr','$code','$desc','$dramount','$cramount','$totamount','$date','$remarks','U','$drtotal','$crtotal','".$client."','$unit','$empname','$adate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}

/************* Authorization Code starts here *************************************/

if($mode == 'CCN') $drcr = 'Cr'; 
if($mode == 'CDN') $drcr = 'Dr'; 

$quantity = '0';

$q = "select * from ac_crdrnote where crnum = '$tno' and mode = '$mode' and client = '$client'  LIMIT 1"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) 
{ 
  $grandtotal = $qr['totalamount'];
  $query1 = "SELECT * FROM contactdetails WHERE name = '$qr[vcode]' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $ca = $row1['ca']; }

  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$drcr','".$ca."','$quantity','".$grandtotal."','".$tid."','".$mode."','".$qr[vcode]."','".$unit."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
}

$q = "select * from ac_crdrnote where crnum = '$tno' and mode = '$mode' and client = '$client'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) 
{ 
  if($qr['dramount'] > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$qr[crdr]','".$qr[coa]."','$quantity','".$qr['dramount']."','".$tid."','".$mode."','".$qr[vcode]."','".$unit."','".$client."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
  }
 if($qr['cramount'] > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$qr[crdr]','".$qr[coa]."','$quantity','".$qr['cramount']."','".$tid."','".$mode."','".$qr[vcode]."','".$qr[vcode]."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
  }


}

if($type == 'Credit')
{
 $type1 = 'CCN';
}
else
{
 $type1 = 'CDN';
}



$q = "update ac_crdrnote set flag = 'A' where crnum = '$tno' and mode = '$mode' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

/************* Authorization Code ends here ***************************************/

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=oc_creditnote&type=$type'";
echo "</script>";

?>