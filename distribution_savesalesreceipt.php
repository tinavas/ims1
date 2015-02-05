<?php

//print_r($_POST);

include "getemployee.php";


$addempname=$empname;

$addempid=$empid;


$date=date("Y-m-d",strtotime($_POST['date']));

$warehouse=$_POST['warehouse'];

$party=$_POST['party'];

$cobi=$_POST['cobi'];

$remarks=$_POST['remarks'];

$q1="select max(tid) as tid from distribution_salesreceipt";

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


$trnum="DCOBIR-".$incr;;

$q1=mysql_query("select invoice from distribution_salesreceipt where invoice='$cobi'",$conn) or die(mysql_error());
$n=mysql_num_rows($q1);
if($n<=0 || $n=="")
{

for($i=0;$i<count($_POST['cat']);$i++)
{

 $category=$_POST['cat'][$i];

 $code=$_POST['code'][$i];

 $description=$_POST['description'][$i];

  $q2="select quantity,cquantity,units,cunits from oc_cobi where invoice='$cobi' and code='$code'";

  $q2=mysql_query($q2) or die(mysql_error());

  $r2=mysql_fetch_assoc($q2);

 $squantity=$r2['quantity'];

 $cquantity=$r2['cquantity'];

 $sunits=$r2['units'];

 $cunits=$r2['cunits'];


 $q3="select finaltotal from oc_cobi where invoice='$cobi'";

 $q3=mysql_query($q3) or die(mysql_error());
 
 $r3=mysql_fetch_assoc($q3);
 
 $finaltotal=$r3['finaltotal'];
 
 
  $q3="INSERT INTO `distribution_salesreceipt` (`tid`, `trnum`, `date`, `warehouse`, `party`, `invoice`, `category`, `code`, `description`, `sunits`, `cunits`, `squantity`, `cquantity`, `finaltotal`, `addempname`, `addempid`, `remarks`) VALUES ('$incr','$trnum','$date','$warehouse','$party','$cobi','$category','$code','$description','$sunits','$cunits','$squantity','$cquantity','$finaltotal','$addempname','$addempid','$remarks');";
  
  $q3=mysql_query($q3) or die(mysql_error());

}

$q3="select ca from contactdetails where name='$party'";

$q3=mysql_query($q3) or die(mysql_error());

$r3=mysql_fetch_assoc($q3);

$ca=$r3['ca'];

$qcobi=mysql_query("select * from ac_financialpostings where coacode='$ca' and trnum='$cobi'");

if(mysql_fetch_row($qcobi))
{

}
else
{
//Save in finnacial postings

$q3="select sum(amount) as amount from ac_financialpostings where trnum='$cobi' and coacode='SATR01' and type='COBI' and crdr='Dr'";

$q3=mysql_query($q3) or die(mysql_error());

$r3=mysql_fetch_assoc($q3);

$amount=$r3['amount'];



 $q4="insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) values ('$date','','Cr','SATR01','0','$amount','$trnum','DCOBIR','$party','$warehouse'),('$date','','Dr','$ca','0','$amount','$trnum','DCOBIR','$party','$warehouse')";
 
 $q4=mysql_query($q4) or die(mysql_error());

//---end of postings

//update srflag in cobi table
}

 $q5="update oc_cobi set srflag=1 where invoice='$cobi'";
 
 $q5=mysql_query($q5) or die(mysql_error());
 
 //--------------------------------------------
}

//header("Location:dashboardsub.php?page=distribution_salesreceipt");

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=distribution_salesreceipt'";

echo "</script>";




?>