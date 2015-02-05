<?php 

//print_r($_POST);

include "getemployee.php";

 $date = date("Y-m-d",strtotime($_POST['edate']));
$cat = $_POST['cat'];
$towarehouse =$_POST['warehouse'];
$adate=date("Y-m-d");
//echo $_POST[sdate];
$sdate= date("Y-m-d",strtotime($_POST['sdate']));
$type = "SRC";
$empname=$_SESSION['valid_user'];
$adate=date("Y-m-d");
if($_POST['saed'] == "edit")
{
$empname=$_POST['cuser'];
}

{

	$tnum=0;
	$trnum1="";		


$q1="SELECT max(right(tid,length(tid)-4)*1) as max FROM `ims_stockreceive` order by id desc";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

if($r1['max']=="" || $r1['max']=="0")
{
$incr=1;
}
else
{
$incr=$r1['max']+1;
}

$tnum="SRC-".$incr;

$tid=$tnum;
$str=$_POST['str'];

for($i = 0; $i < count($_POST['rquantity']); $i++)
{
if($_POST['rquantity'][$i] != '0'  || $_POST['lossqty'][$i]!='0'   )
{
     $cat = $_POST['cat'][$i];
	
	
	$code = $_POST['code'][$i];	
	
	$units = $_POST['units'][$i];
	$fromwarehouse = $_POST['towarehouse'][$i];
	$sentquantity = $_POST['squantity'][$i];
	$receivedquantity = $_POST['rquantity'][$i];
	 $tlossquantity = round($_POST['squantity'][$i]-$_POST['rquantity'][$i],5);
	
	$query = "select cm from ims_itemcodes where code = '$code'";
	 $result = mysql_query($query,$conn);
	  $res=mysql_fetch_assoc($result);
	  $mode = $res['cm'];
	  
	$price=0;
	//echo $fromwarehouse."/".$mode."/".$code."/".$sdate;
	/* $price = calculatenew($fromwarehouse,$mode,$code,$sdate);
	if($price=='' || $price==0)
	{*/
	
	
	$qq=mysql_query("select price from ims_stocktransfer where tmno='$str' and code='$code'",$conn) or die(mysql_error());
	$rq=mysql_fetch_array($qq);
	$price=$rq[price];

	
	$tmno = $_POST['tmno'][$i];
	
	$vno = $_POST['vno'][$i];
	
	$remarks = $_POST['remarks'][$i];
      $amount = $samt=$lamt=0; 

	$q = "insert into ims_stockreceive (tid,transferid,date,cat,fromwarehouse,fromunits,towarehouse,tounits,code,sentquantity,receivedquantity,lossquantity,empid,empname,sector,adate,aempid,aempname,asector,price,vehicleno,tmno,remarks,flag,client) values ('$tid','$str','$date','$cat','$fromwarehouse','$units','$towarehouse','$units','$code','$sentquantity','$receivedquantity','$tlossquantity','$empid','$empname','$sector','$date','$empid','$empname','$sector','$price','$vno','$tmno','$remarks','1','$client') ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());

/////////financial postings//////////
 
      $q1 = "SELECT * FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1))
      {
        $mode = $row1['cm'];
	  $iac = $row1['iac'];
	  $wpac = $row1['wpac'];
      }

	 $amount = round($receivedquantity * $price,5);
	$samt=round($sentquantity*$price,5);
	$lamt=round(($tlossquantity*$price),5);
  $crdr = "Cr";
  $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,warehouse,client,empname,adate) values('$date','$code','$crdr','STTR1',$sentquantity,'$samt','$type','$tid','$fromwarehouse','$client','$empname','$adate')";
    $qrs1 = mysql_query($q1,$conn) or die(mysql_error());

    $crdr = "Dr";
   $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,warehouse,client,empname,adate) values('$date','$code','$crdr','$iac','$receivedquantity','$amount','$type','$tid','$towarehouse','$client','$empname','$adate')";
    $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	
   $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,warehouse,client,empname,adate) values('$date','$code','$crdr','STLOSS','$tlossquantity','$lamt','$type','$tid','$towarehouse','$client','$empname','$adate')";
    $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	
$q2=mysql_query("update ims_stocktransfer set flag='1' where tmno='$str'");


/////////financial postings//////////
	
}
}

}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ims_stockreceive'";
echo "</script>";

?>