<?php
include "config.php";
$deltid = $_POST['deltid'];

$get_entriess = "DELETE FROM oc_receipt WHERE tid = '$deltid'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$deltid' and type = 'RCT' ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


?>
<?php
//Insertion Starts Here
?>
<?php 
include "config.php";

$q = "select max(tid) as tid from oc_receipt";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;
$doc=$_POST['doc_no'];
$date = date("Y-m-d",strtotime($_POST['date']));
$temp = explode('@',$_POST['party']); 
$party = $temp[0];
$partycode = $temp[1];
$paymentmethod = $_POST['paymentmethod'];
$tds = $_POST['tds'];
$remarks = $_POST['remarks'];
$unit=$_POST['unitc'];
$adate=$date;

$choice = $_POST['choice'];
$paymentmode = $_POST['paymentmode'];
$code = $_POST['code'];

$code1 = $_POST['code1'];
$description = $_POST['description'];
$dr = $_POST['dr'];
$amount = $_POST['amount'];
$bank = $_POST['bank'];
$branch = $_POST['branch'];
$cheque = $_POST['cheque'];
$cdate = date("Y-m-d",strtotime($_POST['cdate']));

$tdscode = "";
$tdsdescription = "";
$tdscr = "";
$tdsamount = 0;
$tdsamount1 = "";
if($tds == "With TDS")
{
for($i = 0; $i < count($_POST['tdscode']);$i++)
if($_POST['tdsamount'][$i] != '0' && $_POST['tdsamount'][$i] != '')
{
	$tdscode.=$_POST['tdscode'][$i] . ",";
	$tdsdescription.=$_POST['tdsdescription'][$i] . ",";
	$tdsdr = $_POST['tdsdr'][$i];
	$tdsamount1.=$_POST['tdsamount'][$i] . ",";
	$tdsamount+=$_POST['tdsamount'][$i];
}
$tdscode = substr($tdscode,0,-1);
$tdsdescription = substr($tdsdescription,0,-1);
$tdsamount1 = substr($tdsamount1,0,-1);
}
$totalamount = $tdsamount + $amount;
	$tempamount = $amount + $tdsamount;
			
$q = "insert into oc_receipt (partycode,remarks,tid,date,party,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,flag,doc_no,unit,empname,adate) 
values('$partycode','$remarks','$tid','$date','$party','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$flag','$doc','$unit','$empname','$adate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());





echo "<script type='text/javascript'>";
//echo "top.location='dashboard.php?page=oc_receipt'";
echo "</script>";

?>

<?php 
//Financialpostings starts here
include "config.php";
include "getemployee.php";

$quantity = '0';
//$tid = $_POST['tid'];
$adate = $date;
//$party = $_POST['party'];
$grandtotal = $amount + $tdsamount;
//$paymentmethod = $_POST['paymentmethod'];

//$tdscode = split(",",$_POST['tdscode']);
//$tdsamount1 = split(",",$_POST['tdsamount1']);
$tdscode = split(",",$tdscode);
$tdsamount1 = split(",",$tdsamount1);
$type = 'RCT';
for($i = 0; $i < count($tdscode); $i++)
{ 
  if($tdsamount1[$i] > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Dr','".$tdscode[$i]."','$quantity','".$tdsamount1[$i]."','".$tid."','".$type."','".$party."','".$unit."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	

	
	
	
  }
}



  //$amount = $_POST['amount'];
  $code = $code1;
  
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','','Dr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$party."','".$unit."')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	

	
	  $q = "select distinct(ca) as code1 from contactdetails where name = '$party' AND (type = 'party' OR type = 'vendor and party') order by va";
    
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];
	
	//To get the cash,bank,cashbankcode,schedule
	if($paymentmode == 'Cash')
	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $code; $bankcode = ""; }
	elseif($paymentmode == 'Cheque' or $paymentmode == 'Transfer')
	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $code; $cashcode = ""; }
	$q = "SELECT schedule FROM ac_coa WHERE code = '$code1'";
	$r = mysql_query($q,$conn) or die(mysql_error());
	$rr = mysql_fetch_assoc($r);
	$schedule = $rr['schedule'];
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
               VALUES('".$adate."','','Cr','".$code1."','$quantity','".$grandtotal."','".$tid."','".$type."','".$party."','".$unit."','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	



$query5 = "UPDATE oc_receipt SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_receipt'";
echo "</script>";
?>