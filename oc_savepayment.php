<?php 
include "config.php";
include "getemployee.php";
include "cashcheck.php";

$empname=$_SESSION['valid_user'];

$flag=$flag1=0;

for($i = 0; $i < count($_POST['tdscode']);$i++)
{
$tdsamount=$_POST['tdsamount'][$i];
$tdscode=$_POST['tdscode'][$i];
 $flag1=cashcheck($tdscode,$tdsamount,Cr);
if($flag1=='1')
{
echo "<script type='text/javascript'>";
echo "alert('Remainder: Insufficient Funds in $code account');";
echo "</script>"; 
}
}
if($_POST['code'] != "")
{
 $code = $_POST['code'];
$amount = $_POST['amount'];
$code1 = $_POST['code1'];
 $flag=cashcheck($code1,$amount,Cr);
if($flag=='1')
{
echo "<script type='text/javascript'>";
echo "alert('Remainder: Insufficient Funds in $code account');";
echo "</script>"; 
}
}

if($_POST['saed']<>"")
{


$editemp=$empname;
$deltid = $_POST['deltid'];

$q = "delete from oc_payment where tid = '$deltid'";

$qrs = mysql_query($q,$conn) or die(mysql_error());


$q = "delete from ac_financialpostings where trnum = '$deltid' and type = 'OCPMT'";

$qrs = mysql_query($q,$conn) or die(mysql_error());

$empname=$_POST['cuser'];

}

$addemp=$empname;
$q = "select max(tid) as tid from oc_payment";

$qrs = mysql_query($q,$conn) or die(mysql_error());

if($qr = mysql_fetch_assoc($qrs))

$tid = $qr['tid'];

$flag = '0';

$tid = $tid + 1;



$date = date("Y-m-d",strtotime($_POST['date']));

$temp = explode('@',$_POST['party']); 

$party = $temp[0];

$partycode = $temp[1];

$paymentmethod = $_POST['paymentmethod'];
$unit=$_POST['unitc'];
$tds = $_POST['tds'];

$remarks = $_POST['remarks'];
$doc=$_POST['doc_no'];


$choice = $_POST['choice'];

$paymentmode = $_POST['paymentmode'];

$code = $_POST['code'];



$code1 = $_POST['code1'];

$description = $_POST['description'];

$cr = $_POST['cr'];

$amount = $_POST['amount'];


if($paymentmode <>"Cash")
{

$bank = $_POST['bank'];
$branch = $_POST['branch'];
if($paymentmode="Cheque")
{
$cheque = $_POST['cheque'];





}
}



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





$q = "insert into oc_payment (partycode,remarks,tid,date,party,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,totalamount,bank,branch,cheque,cdate,choice,flag,empname,unit,doc_no) 

values('$partycode','$remarks','$tid','$date','$party','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$flag','$empname','$unit','$doc')";

$qrs = mysql_query($q,$conn) or die(mysql_error());



///changed code

$quantity = '0';

$tid = $tid;

$adate = $date;

$party = $party;

$tdscode = split(",",$tdscode);

$tdsamount1 = split(",",$tdsamount1);

$amount = $amount;

$totalamount = $totalamount;

$code = $code1;

$type = 'OCPMT';



for($i = 0; $i < count($tdscode); $i++)

{ 

  if($tdsamount1[$i] > 0)

  {

    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname) 

	          VALUES('".$adate."','','Cr','".$tdscode[$i]."','$quantity','".$tdsamount1[$i]."','".$tid."','".$type."','".$party."','".$unit."','$empname')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());



  }

}



    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname) 

               VALUES('".$adate."','','Cr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$party."','".$unit."','$empname')";

    $result3 = mysql_query($query3,$conn) or die(mysql_error());



	$q = "select distinct(ca) as code1 from contactdetails where name = '$party' order by va";

	$qrs = mysql_query($q,$conn) or die(mysql_error());

	if($qr = mysql_fetch_assoc($qrs))

	$code1 = $qr['code1'];



	//To get the cash,bank,cashbankcode,schedule

	if($paymentmode == 'Cash')

	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $code; $bankcode = ""; }

	elseif($paymentmode == 'Cheque')

	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $code; $cashcode = ""; }

	$q = "SELECT schedule FROM ac_coa WHERE code = '$code1'";

	$r = mysql_query($q,$conn) or die(mysql_error());

	$rr = mysql_fetch_assoc($r);

	$schedule = $rr['schedule'];

	

    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule,empname) 

               VALUES('".$adate."','','Dr','".$code1."','$quantity','".$totalamount."','".$tid."','".$type."','".$party."','".$unit."','$cash','$bank','$cashcode','$bankcode','$schedule','$empname')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());

	

	






$query5 = "UPDATE oc_payment SET flag = '1',adate = '$adate',aempname = '$empname',asector = '$sector' where tid = '$tid'";

$result5 = mysql_query($query5,$conn) or die(mysql_error());





echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=oc_payment'";

echo "</script>";



?>