 <?php 
include "config.php";

$q = "select max(tid) as tid from pp_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;

$date = date("Y-m-d",strtotime($_POST['date']));
$temp = explode('@',$_POST['vendor']);
$vendor=$temp[0];
$vendorcode=$temp[1];
$paymentmethod = $_POST['paymentmethod'];
$tds = $_POST['tds'];
$doc=$_POST['doc_no'];
$choice = $_POST['choice'];
$paymentmode = $_POST['paymentmode'];
$code = $_POST['code'];
$remarks=$_POST['remarks'];
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
if($_POST['sead']==1)
	{
		$deltid = $_POST['deltid'];
		$q = "delete from pp_payment where tid = '$deltid'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
	}
$q = "select va as code1,id from contactdetails where name = '$vendor' and (type = 'vendor' OR type = 'vendor and party') order by va";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $codecontact = $qr['code1'];

if($codecontact <> "")
{

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
			
$q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,flag,actualamount,amountpaid,balance,doc_no) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$choice','$flag','$amount','$amount','$amount','$doc')";
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
$q1rs = mysql_query($q1,$conn) ;
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
}
echo "<script type='text/javascript'>";
echo "top.location='dashboard.php?page=pp_payment_a'";
echo "</script>";
?>


