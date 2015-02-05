<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
include "getemployee.php";

$date=date("Y-m-d",strtotime($_POST['date']));

$location=$_POST['location'];
$s=0;
$qry1="SELECT distinct(code) as code  FROM `ims_itemcodes` where iusage like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula` where warehouse='$location') order by code";
	$qr=mysql_query($qry1) or die(mysql_error());
	while($res=mysql_fetch_assoc($qr))
	{
	$codes[$s]=$res['code'];
	$s++;
	}



$addempname=$empname;

$addempid=$empid;

$editempname="";

$editempid="";




//For transaction number

$q1="select max(tid) as tid from packing_dailypacking";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

if($r1['tid']=="")
{
  $incr=1;
}
else
{
  $incr=$r1['tid']+1;
}


$trnum="DPACK-".$incr;

//--------------------------
if($_POST['edit']=="1")
{

 $trnum=$_POST['trnum'];

 $tt=explode("-",$trnum);

 $incr=$tt[1];

 $q1="select addempname,addempid from packing_dailypacking where trnum='$trnum'";
 
 $q1=mysql_query($q1) or die(mysql_error());
 
 $r1=mysql_fetch_assoc($q1);
 
 $addempname=$r1['addempname'];
 
 $addempid=$r1['addempid'];
 
 $editempname=$empname;
 
 $editempid=$empid;
 
 $q1="delete from packing_dailypacking where trnum='$trnum'";
 
 $q1=mysql_query($q1) or die(mysql_error());
 
 $q1="delete from ac_financialpostings where trnum='$trnum'";

  $q1=mysql_query($q1) or die(mysql_error());
 
 }
 
 $totalamount=0;
 
  for($i=0;$i<count($codes);$i++)
{
$items=mysql_query("select cat,code,description,sunits from ims_itemcodes where code='$codes[$i]'",$conn) or die(mysql_error());
$res_items=mysql_fetch_array($items);
  $contract=$_POST['contract'][$i];
  
  $category=$res_items['cat'];
  
  $code=$codes[$i];
  
  $description=$res_items['description'];
  
  $units=$res_items['sunits'];
  
  $packets=$_POST['lab'][$i];
  
  $coacode=$_POST['coacode'][$i];
  
  if($category!="" && $code!="" && $packets!="" )
  {

  
   //----------------------------
   $cost=0;
 
  $amount=$packets*$cost;
  
  $totalamount=$totalamount+$amount;
  
 $qi="INSERT INTO `packing_dailypacking` ( `tid`, `trnum`, `date`, `location`, `labour`, `contractor`, `category`, `code`, `description`, `units`, `packets`, `cost`, `amount`,  `coacode`, `addempname`, `addempid`, `editempname`, `editempid`) VALUES ('$incr','$trnum','$date','$location','YES','Labour','$category','$code','$description','$units','$packets','$cost','$amount','$coacode','$addempname','$addempid','$editempname','$editempid');";
   
   $qi=mysql_query($qi) or die(mysql_error());
   
}
}
 
  for($j=0;$j<count($_POST['contractor']);$j++)
 { 
 $contract=$_POST['contractor'][$j];
 
 for($k=0;$k<count($codes);$k++)
{
 
 $code=$codes[$k];
 $name="packs".$j;
 echo $pack=$_POST[$name][$k];
   //Get the cost for that code
  $cost="";
  
$q5="SELECT cost FROM `packing_packingcost` where '$date' between fromdate and todate and code='$code' and location='$location' and contractor='$contract'"; 
 
 $q5=mysql_query($q5) or die(mysql_error());
 
 $r5=mysql_fetch_assoc($q5);
 
 $cost=$r5['cost'];
 if($cost=="")
 $cost=0;
   $amount=$pack*$cost;
   
    $totalamount=$totalamount+$amount;
 
 if($pack>0)
 {
echo $qi="INSERT INTO `packing_dailypacking` ( `tid`, `trnum`, `date`, `location`, `labour`, `contractor`, `category`, `code`, `description`, `units`, `packets`, `cost`, `amount`,  `coacode`, `addempname`, `addempid`, `editempname`, `editempid`) VALUES ('$incr','$trnum','$date','$location','$labour','$contract','$category','$code','$description','$units','$pack','$cost','$amount','$coacode','$addempname','$addempid','$editempname','$editempid');";
 echo "<br>";  
   $qi=mysql_query($qi) or die(mysql_error());

   
     $query2 = "SELECT va,contractor_coacode as code FROM contactdetails WHERE name = '$contract' and contractor='YES'";
	 
     $result2 = mysql_query($query2,$conn);
	 
      while($row2 = mysql_fetch_assoc($result2))
	  {
        $ca = $row2['va'];
		$contractorac = $row2['code'];
		}
		
		 $qa="insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) values ('$date','$code','Dr','$contractorac','$pack','$amount','$trnum','DPACK','','$location'),('$date','$code','Cr','$ca','$pack','$amount','$trnum','DPACK','$contract','$location')";
   
         $qa=mysql_query($qa) or die(mysql_error());
		 }


  
  }


}
 $update="update packing_dailypacking set totalamount='$totalamount' where trnum='$trnum'";
 
 $update=mysql_query($update) or die(mysql_error());
 
 
  echo "<script type='text/javascript'>";
	  
 //echo "document.location='dashboardsub.php?page=dailypacking'";
	  
 echo "</script>";
 
 
 print_r($_POST);
 
 ?>
</body>
</html>
