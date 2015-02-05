 <?php 
include "config.php";
$deltid = $_POST['deltid'];
$q = "delete from pp_payment where tid = '$deltid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

////insert into ac_financialpostingssummary
$q = "select * from ac_financialpostings where trnum = '$deltid' and type = 'PMT' and client = '$client'";
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
$q = "delete from ac_financialpostings where trnum = '$deltid' and type = 'PMT'";
$qrs = mysql_query($q,$conn) or die(mysql_error());


$q = "select max(tid) as tid from pp_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;
$doc=$_POST['doc_no'];
$date = date("Y-m-d",strtotime($_POST['date']));
$temp = explode('@',$_POST['vendor']);
$vendor=$temp[0];
$vendorcode=$temp[1];
$paymentmethod = $_POST['paymentmethod'];
$tds = $_POST['tds'];
$remarks=$_POST['remarks'];
$choice = $_POST['choice'];
$paymentmode = $_POST['paymentmode'];
$code = $_POST['code'];

$code1 = $_POST['code1'];
$description = $_POST['description'];
$cr = $_POST['cr'];
$amount = $_POST['amount'];
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
	$tdscr = $_POST['tdscr'][$i];
	$tdsamount1.=$_POST['tdsamount'][$i] . ",";
	$tdsamount+=$_POST['tdsamount'][$i];
}
$tdscode = substr($tdscode,0,-1);
$tdsdescription = substr($tdsdescription,0,-1);
$tdsamount1 = substr($tdsamount1,0,-1);
}
$totalamount = $tdsamount + $amount;

if($paymentmethod == "Pre Payment" && $choice == "POs")
{
$tempamount = 0;
for($i = 0; $i < count($_POST['po']); $i++)
if($_POST['poamountpaid'][$i] != 0 && $_POST['poamountpaid'][$i] != '' && $_POST['po'][$i] != '')
{
$po = $_POST['po'][$i];
$poactualamount = $_POST['poactualamount'][$i];
$poamountpaid = $_POST['poamountpaid'][$i];
$pobalance = $poactualamount - $poamountpaid;
if($pobalance < 0)
$pobalance = 0;
$tempamount+= ($poamountpaid - $poactualamount);
$q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,doc_no) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$choice','$po','$poactualamount','$poamountpaid','$pobalance','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}
}

else if($paymentmethod == "Pre Payment" && $choice == "On A/C")
{
	$tempamount = $amount + $tdsamount;
			
$q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,actualamount,amountpaid,cheque,cdate,choice,flag,doc_no) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$amount','$amount','$cheque','$cdate','$choice','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}

else if($paymentmethod == "Payment" && $choice == "SOBIs")
{
$tempamount = 0;
for($i = 0; $i < count($_POST['sobi']); $i++)
if($_POST['amountpaid'][$i] != 0 && $_POST['amountpaid'][$i] != '' && $_POST['sobi'][$i] != '')
{
$sobi = $_POST['sobi'][$i];
$actualamount = $_POST['actualamount'][$i];
$amountpaid = $_POST['amountpaid'][$i];
$balance = $actualamount - $amountpaid;
if($balance < 0)
$balance = 0;
$tempamount+= ($amountpaid - $actualamount);
$q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,totalamount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,doc_no) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr','$amount','$totalamount','$cheque','$cdate','$choice','$sobi','$actualamount','$amountpaid','$balance','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$query5 = "UPDATE pp_sobi SET balance = '$balance' where so = '$sobi'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

}
}
else if($paymentmethod == "Payment" && $choice == "On A/C")
{ 
	$actualamount = $amount + $tdsamount;
       $amountpaid = $amount + $tdsamount; $balance = '0';
	//$q = "select distinct(so),grandtotal from pp_sobi where flag = '1' and vendor = '$vendor' order by id";
	//$qrs = mysql_query($q,$conn) or die(mysql_error());
	//while($qr = mysql_fetch_assoc($qrs))
	//{
		//$sobi = $qr['so'];
		//$actualamount = $qr['grandtotal'];
		//if($tempamount == 0)
		//break;

			//if($tempamount >= $actualamount)
			//{
			//$amountpaid = $actualamount;
			//$tempamount = $tempamount - $actualamount;
			//}
			//else
			//{
			//$amountpaid = $tempamount;
			//$tempamount = 0;
			//}
			//$balance = $actualamount - $amountpaid;
			
		$q1 = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,cheque,cdate,totalamount,choice,posobi,actualamount,amountpaid,balance,flag,doc_no) values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$totalamount','$choice','$sobi','$actualamount','$amountpaid','$balance','$flag','$doc')";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());
	//}
}
else if($paymentmethod == "Payment" && $choice == "Credit Notes")
{

}

	/*if($tempamount > 0)
	{
		$q = "select * from tadvanceto where vendor = '$vendor' order by vendor";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		if(mysql_num_rows($qrs) > 0)
		{
			if($qr = mysql_fetch_assoc($qrs))
			{
			$advance = $qr['advance'];
			$crdr = $qr['crdr'];
			}
			if($crdr == "Dr")
			$newadvance = $advance + $tempamount;
			else if($crdr == "Cr")
			{
				if($tempamount > $advance)
				{
					$newadvance = $tempamount - $advance;
					$crdr = "Dr";
				}
				else if($advance > $tempamount)
				{
					$newadvance = $advance - $tempamount;
					$crdr = "Cr";
				}
				else
				{
					$newadvance = 0;
					$crdr = "";
				}
			}
			
			$q1 = "update tadvanceto set advance = '$newadvance',crdr = '$crdr' where vendor = '$vendor'";
			#$q1rs = mysql_query($q1,$conn) or die(mysql_error());
		}
		else
		{
			$newadvance = $tempamount;
			$crdr = "Dr";
			$q1 = "insert into tadvanceto (vendor,type,advance,crdr) values('$vendor','vendor','$newadvance','$crdr')";
			#$q1rs = mysql_query($q1,$conn) or die(mysql_error());
		}
	}*/

echo "<script type='text/javascript'>";
//echo "top.location='dashboard.php?page=pp_payment'";
echo "</script>";

?>
<?php 
//Start of Financialpostings
include "config.php";
include "getemployee.php";
$quantity = '0';
//$tid = $_POST['tid'];
$adate = $date;
$venname = $vendor;
$grandtotal = $amount + $tdsamount;
//$paymentmethod = $_POST['paymentmethod'];

$tdscode = split(",",$tdscode);
$tdsamount1 = split(",",$tdsamount1);
$type = 'PMT';
for($i = 0; $i < count($tdscode); $i++)
{
 if($tdsamount1[$i] > 0)
 {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$tdscode[$i]."','$quantity','".$tdsamount1[$i]."','".$tid."','".$type."','".$venname."','".$venname."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	$newamount = $tdsamount1[$i] + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$tdscode[$i]' and date = '$adate' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$tdscode[$i]','$tdsamount1[$i]','Cr','$venname','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$tdscode[$i]','$tdsamount1[$i]','Cr','$venname','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
	
	
 }
}


   $code = $code1;
   $amount = $amount;
  
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','','Cr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$venname."','".$venname."')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	
	
	
	$newamount = $amount + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$code' and date = '$adate' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code','$amount','Cr','$venname','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code','$amount','Cr','$venname','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		
		}
	
	
	if($paymentmethod == "Pre Payment")
	$q = "select distinct(vppa) as code1 from contactdetails where name = '$venname' and (type = 'vendor' OR type = 'vendor and party') order by vppa";
	else if($paymentmethod == "Payment")
	$q = "select distinct(va) as code1 from contactdetails where name = '$venname' and (type = 'vendor' OR type = 'vendor and party') order by va";
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
               VALUES('".$adate."','','Dr','".$code1."','$quantity','".$grandtotal."','".$tid."','".$type."','".$venname."','".$venname."','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
	$newamount = $grandtotal + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$code1' and date = '$adate' and crdr = 'Dr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1','$grandtotal','Dr','$venname','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1','$grandtotal','Dr','$venname','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
	
		}
	
	


$query5 = "UPDATE pp_payment SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_payment_a'";
echo "</script>";
?>
