<?php 
include "config.php";
$type = $_POST['type'];
$mode = $_POST['mode1'];
$tno = $_POST['tno'];

if($_POST['saed'] == 1)
{
$id = $tno;
$q = "select * from ac_financialpostings where trnum = '".$id."' AND type = '".$mode."' and client = '$client'";
$r = mysql_query($q,$conn);

while($qr = mysql_fetch_assoc($r))
{
  $coacode = $qr['coacode'];
		 $crdr = $qr['crdr'];
		 $date1 = $qr['date'];
		 
		$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$date1' and crdr = '$crdr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amt = $qhr1['amount'];
		 }
		$amt = $amt - $qr['amount'];
 		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode' and date = '$date1' and crdr = '$crdr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
 }

$query1="DELETE FROM ac_financialpostings WHERE trnum = '".$id."' AND type = '".$mode."'";
$result1=mysql_query($query1,$conn) or die(mysql_error());

$query = "select camount from ac_crdrnote where crnum = '".$id."' AND mode = '".$mode."'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$conversion = $rows['camount'];

$query2="DELETE FROM ac_crdrnote WHERE crnum = '".$id."' AND mode = '".$mode."'";
$result2=mysql_query($query2,$conn) or die(mysql_error());
}
//End: delete the Record

if($_SESSION['db'] == 'central' && $_POST['edit'] == 'yes')
{
 $q = "update hr_conversion set flag = 1 where id = '".$_POST['currencyid']."'";		//To Lock the Record
 $r = mysql_query($q,$conn) or die(mysql_error());
 $conversion = $_POST['conversion'];
}


$date=date("Y-m-d",strtotime($_POST['date']));
$vendor = $_POST['vendor'];
$vamount = $_POST['vendamount'];
$remarks = $_POST['remarks'];
$totamount = $_POST['vendamount'];
$crtotal = $_POST['crtotal'];
$drtotal = $_POST['drtotal'];

for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
$crdr = $_POST['drcr'][$i];
$dramount = $_POST['dramount'][$i];
$cramount = $_POST['cramount'][$i];


$q = "insert into ac_crdrnote (crnum,mode,vcode,crdr,coa,description,dramount,cramount,totalamount,date,remarks,flag,drtotal,crtotal,client,orgcramount,orgdramount,camount) VALUES ('$tno','$mode','$vendor','$crdr','$code','$desc',($dramount * $conversion),($cramount * $conversion),($totamount * $conversion),'$date','$remarks','U',($drtotal * $conversion),($crtotal * $conversion),'".$client."','$crtotal','$drtotal','$conversion')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}

/************* Authorization Code starts here *************************************/

if($mode == 'VCN') $drcr = 'Cr'; 
if($mode == 'VDN') $drcr = 'Dr'; 

$quantity = '0';

$q = "select * from ac_crdrnote where crnum = '$tno' and mode = '$mode' and client = '$client'  LIMIT 1"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) 
{ 
  $grandtotal = $qr['totalamount'];
  $query1 = "SELECT * FROM contactdetails WHERE name = '$qr[vcode]' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $va = $row1['va']; }

  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$drcr','".$va."','$quantity','".$grandtotal."','".$tno."','".$mode."','".$qr[vcode]."','".$qr[vcode]."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$va' and date = '$date' and crdr = '$drcr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		$q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$va','$grandtotal','$drcr','$qr[vcode]','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $grandtotal;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$va'and date = '$date' and crdr = '$drcr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

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
   //////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$qr[coa]' and date = '$date' and crdr = '$qr[crdr]'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$qr[coa]','$qr[dramount]','$qr[crdr]','$qr[vcode]','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $qr['dramount'];
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$qr[coa]'and date = '$date' and crdr = '$qr[crdr]'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
  }
 if($qr['cramount'] > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','$qr[crdr]','".$qr[coa]."','$quantity','".$qr['cramount']."','".$tno."','".$mode."','".$qr[vcode]."','".$qr[vcode]."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$qr[coa]' and date = '$date' and crdr = '$qr[crdr]'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		  $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$qr[coa]',$qr[cramount],'$qr[crdr]','$qr[vcode]','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + ($qr['cramount'] * $conversion);
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$qr[coa]'and date = '$date' and crdr = '$qr[crdr]'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
  }


}

if($type == 'Credit')
{
 $type1 = 'VCN';
}
else
{
 $type1 = 'VDN';
}



$q = "update ac_crdrnote set flag = 'A' where crnum = '$tno' and mode = '$mode' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());


/************* Authorization Code ends here ***************************************/
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_creditnote&type=$type'";
echo "</script>";

?>