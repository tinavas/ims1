<?php 

include "config.php";

include "cashcheck.php";
//session_start();
$client = $_SESSION['client'];
$unit = $_POST['unitc'];

for($f = 0;$f<count($_POST['code']);$f++)
{
$flag=0;
if($_POST['code'][$f] != "")
{
 $code = $_POST['code'][$f];
$crdr = $_POST['drcr'][$f];
$dramount = $_POST['dramount'][$f];
$cramount = $_POST['cramount'][$f];

 if ( $crdr == "Cr" )
		 {
		   $amount = $cramount;
		 }
		 else
		 {
           $amount = $dramount;		 
		 }


 $flag=cashcheck($code,$amount,$crdr);
if($flag=='1')
{
	 echo "<script type='text/javascript'>";
echo "alert('Remainder: Insufficient Funds in $code account');";
echo "</script>"; 
}
}
}
$mode = $_POST['mode'];

$username=$_SESSION['valid_user'];

if($_POST['saed']==1)

{

$transactioncode=$_POST['transactioncode'];



 $get_entriess = "DELETE FROM ac_gl WHERE transactioncode = '$transactioncode' AND voucher = 'EPV' and  client='$client'";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$query = "delete from ac_financialpostings where type = 'EPV' and trnum = '$transactioncode'";
$result = mysql_query($query,$conn) or die(mysql_error());

}
else
{

 	$trnum1="";		
 $q = "select transactioncode as tid from  `ac_gl` where client = '$client' and voucher = 'EPV'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],4);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$transactioncode = "EPV-$tnum";
if(mysql_num_rows($qrs)==0)
{
$transactioncode="EPV-1";

}


}


$voucher = 'EPV';
$vouchernumber = $_POST['vno'];
$bccodeno = $_POST['cno'];
$drtotal = $_POST['drtotal'];
$crtotal = $_POST['crtotal'];
$name = ucwords($_POST['pname']);
$pmode = $_POST['pmode'];
if($pmode == 'Cheque')
{
  $q = "SELECT * FROM ac_chequeseries WHERE acno = '$bccodeno'";
  $r = mysql_query($q,$conn);
  while($r1 = mysql_fetch_assoc($r))
  {
    $rchls = $r1['rchls'];
  }
  $rchls = $rchls - 1;
  $q2 = "UPDATE ac_chequeseries SET rchls = '$rchls' WHERE acno = '$bccodeno'";
  $r2 = mysql_query($q2,$conn) or die(mysql_error());



}

$allcodes = "";



//To fill cash,bank,cashcode,bankcode,schdule

for($i = 0,$k = -1,$l = -1;$i<=count($_POST['code']);$i++)

 if($_POST['code'][$i] != "")

 {

   $entrycode[++$k] = $_POST['code'][$i];

   $allcodes .= "'".$_POST['code'][$i]."',";

  }


$allcodes = substr($allcodes,0,-1);


 $query = "SELECT code,description FROM ac_coa WHERE code IN ($allcodes) ORDER BY code";

$result = mysql_query($query,$conn) or die(mysql_error());

while($rows = mysql_fetch_assoc($result))

 $arraycode[$rows['code']] = $rows['description'];


$c = $b = $n = $o = -1;	//$c means cash index and $b means bank index

$ce = $be = $countcashentries = $countbankentries = 0;	//$ce means cash entry and $be means bank entry

 $q = "SELECT code,controltype FROM ac_coa WHERE (controltype = 'Cash' OR controltype LIKE '%Bank%') AND client = '$client'";

$r = mysql_query($q,$conn) or die(mysql_error());

while($rr = mysql_fetch_assoc($r))

{ 

 if($rr['controltype'] == 'Cash')

 { 

  $cashcodearray[++$c] = $rr['code'];

  if(in_array($rr['code'],$entrycode))

  { $ce = 1; $countcashentries++; $cashentriesarray[++$o] = $rr['code']; $creditcashcode = $rr['code']; }	// It means one cash entry record is there   

 }

 elseif( strlen(strstr($rr['controltype'],"Bank")) > 0)  

 {

  $bankcodearray[++$b] = $rr['code'];

  if(in_array($rr['code'],$entrycode))

  { $be = 1; $countbankentries++; $bankentriesarray[++$n] = $rr['code']; $creditbankcode = $rr['code'];}	// It means one bank entry record is there   

 } 

}

//End


$adate=date("Y-m-d");



$chno = $_POST['chno'];

$empname1 =$empname= $_POST['empname'];

$date=date("Y-m-d",strtotime($_POST['date']));



for($i = 0,$k = -1;$i<count($_POST['code']);$i++)

{

if($_POST['code'][$i] != "")

{

$remarks = $_POST['remarks'][$i];

$code = $_POST['code'][$i];

$desc = $arraycode[$_POST['code'][$i]];

$crdr = $_POST['drcr'][$i];

$dramount = $_POST['dramount'][$i];

$cramount = $_POST['cramount'][$i];



$sectoremp = "";



 if ( $crdr == "Cr" )

		 {

		   $amount = $cramount;

		 }

		 else

		 {

           $amount = $dramount;		 

		 }



 $q = "select * from ac_coa where code = '$code'";

$qrs = mysql_query($q,$conn) or die(mysql_error());

if($qr = mysql_fetch_assoc($qrs))

{

	$type = $qr['type'];

	$controltype = $qr['controltype'];

	$schedule = $qr['schedule'];

	if($controltype != ""  && $m == "")

	{

	$m = $controltype;

	}

}

//To fill cash,bank,cashcode,bankcode,schdule

$cash = $bank = 'NO';

$cashcode = $bankcode = "";

 if(in_array($code,$bankcodearray))

 { 

  $cash = 'NO';

  if($be == 1)

  {

   $bank = 'YES';

   $bankcode = $creditbankcode;

  }

 }

 elseif(in_array($code,$cashcodearray))

 {

  $bank = 'NO';

  if($ce == 1)

  {

   $cash = 'YES';

   $cashcode = $creditcashcode;

  }

 }

 else

 {

  if($ce == 1) { $cash = 'YES'; $cashcode = $creditcashcode; }

  if($be == 1) { $bank = 'YES'; $bankcode = $creditbankcode; }

 } 



if($countbankentries == 2)	//If the transaction is made between two banks, it is used

{

 if($code == $bankentriesarray[0])

 { $bank = 'YES'; $bankcode = $bankentriesarray[1]; }

 elseif($code == $bankentriesarray[1])

 { $bank = 'YES'; $bankcode = $bankentriesarray[0]; }

} 

if($countcashentries == 2)	//If the transaction is made between two CASH, it is used

{

 if($code == $cashentriesarray[0])

 { $cash = 'YES'; $cashcode = $cashentriesarray[1]; }

 elseif($code == $cashentriesarray[1])

 { $cash = 'YES'; $cashcode = $cashentriesarray[0]; }

} 

if($countbankentries == 1 && $countcashentries == 1 && $k == 1)	//If the transaction is made only through cash & bank, it is used

{

 if($code == $cashentriesarray[0])

 { $cash = 'NO'; $bank = 'YES'; $bankcode = $bankentriesarray[0]; }

 elseif($code == $bankentriesarray[0])

 { $cash = 'YES'; $bank = 'NO'; $cashcode = $cashentriesarray[0]; }

}


$vno = $_POST['vno'];


$empname1 =$empname= $_POST['empname'];


$q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,warehouse,client,cash,bank,cashcode,bankcode,empname,adate) VALUES ('$username','$m','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','EPV','U','$unit','$client','$cash','$bank','$cashcode','$bankcode','$empname','$adate')";

$qrs = mysql_query($q,$conn) or die(mysql_error());


$cash = $bank = 'NO';

$cashcode = $bankcode = $schedule = "";

 if(in_array($code,$cashcodearray))

 { 

  $cash = 'NO';

  if($be == 1)

  {

   $bank = 'YES';

   $bankcode = $creditbankcode;

  }

 }

 elseif(in_array($code,$bankcodearray))

 {

  $bank = 'NO';

  if($ce == 1)

  {

   $cash = 'YES';

   $cashcode = $creditcashcode;

  }

 }

 else

 {

  if($ce == 1) { $cash = 'YES'; $cashcode = $creditcashcode; }

  if($be == 1) { $bank = 'YES'; $bankcode = $creditbankcode; }

 } 



if($countbankentries == 2)	//If the transaction is made between two banks, it is used

{

 if($code == $bankentriesarray[0])

 { $bank = 'YES'; $bankcode = $bankentriesarray[1]; }

 elseif($code == $bankentriesarray[1])

 { $bank = 'YES'; $bankcode = $bankentriesarray[0]; }

}// echo $countcashentries;

if($countcashentries == 2)	//If the transaction is made between two CASH, it is used

{

 if($code == $cashentriesarray[0])

 { $cash = 'YES'; $cashcode = $cashentriesarray[1]; }

 elseif($code == $cashentriesarray[1])

 { $cash = 'YES'; $cashcode = $cashentriesarray[0]; }

} 

if($countbankentries == 1 && $countcashentries == 1 && $k == 1)	//If the transaction is made only through cash & bank, it is used

{

 if($code == $cashentriesarray[0])

 { $cash = 'NO'; $bank = 'YES'; $bankcode = $bankentriesarray[0]; }

 elseif($code == $bankentriesarray[0])

 { $cash = 'YES'; $bank = 'NO'; $cashcode = $cashentriesarray[0]; }

}



if($cash == 'YES' or $bank == 'YES')

{

 $q = "SELECT schedule FROM ac_coa WHERE code = '$code' AND client = '$client'";

 $r = mysql_query($q,$conn) or die(mysql_error());

 $rr = mysql_fetch_assoc($r);

 $schedule = $rr['schedule'];

}

 if($sectoremp == "")
{
$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule) VALUES ('$date','$crdr','$code','$amount','$transactioncode','EPV','$client','$unit','$empname','$cash','$bank','$cashcode','$bankcode','$schedule') ";
}
else
{
$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule,empname,adate) VALUES ('$date','$crdr','$code','$amount','$transactioncode','EPV','$client','$unit','$empname','$cash','$bank','$cashcode','$bankcode','$schedule','$empname','$adate') ";
}
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		  
		if($sectoremp == "")
		  {
		  $war1= $unit;
		  }
		  else
		  {
		   $war1= $sectoremp;
		   }






}



}

//End

$query = "update ac_gl SET vstatus = 'A' where transactioncode ='$transactioncode' and voucher = 'EPV'";
$result = mysql_query($query,$conn) or die(mysql_error());




		  echo "<script type='text/javascript'>";

	 echo "document.location = 'dashboardsub.php?page=hr_pvoucher';";

		  echo "</script>";

		

?>