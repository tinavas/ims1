<?php

//print_r($_POST);


include "getemployee.php";

$addempname=$empname;

$addempid=$empid;



$date=date("Y-m-d",strtotime($_POST['date']));

$superstockist=trim($_POST['superstockist']);


$distributor=$_POST['distributor'];

$docno=$_POST['docno'];

$narration=$_POST['narration'];

$q1="select max(tid) as tid from distribution_stockissuetodistributor";

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

$trnum="STDT-".$incr;


if($_POST['edit']=="1")
{

$trnum=$_POST['oldid'];

$tr=explode("-",$trnum);

$incr=$tr[1];


$q2="select addempname,addempid from distribution_stockissuetodistributor where trnum='$trnum' limit 1";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$addempname=$r2['addempname'];

$addempid=$r2['addempid'];

$editempname=$empname;

$editempid=$empid;

$q3="delete from distribution_stockissuetodistributor where trnum='$trnum' ";

$q3=mysql_query($q3) or die(mysql_error());


}

$totalamount=0;

for($i=0;$i<count($_POST['category']);$i++)
 {

$cat=$_POST['category'][$i];

$code=$_POST['code'][$i];

$description=$_POST['description'][$i];

$units=$_POST['units'][$i];

$stock=$_POST['stock'][$i];

$rateperunit=$_POST['rateperunit'][$i];

$amount=$stock*$rateperunit;

$totalamount=$totalamount+$amount;

if($cat!="" && $code!="" && $stock!="" && $rateperunit!="")

{

  $q1="INSERT INTO `distribution_stockissuetodistributor` ( `tid`, `trnum`, `date`, `superstockist`,`docno`, `category`, `code`, `description`, `units`,`distributor`, `quantity`,rateperunit,amount, `addempname`, `addempid`, `editempname`, `editempid`,`narration`) VALUES ('$incr','$trnum','$date','$superstockist','$docno','$cat','$code','$description','$units','$distributor','$stock','$rateperunit','$amount','$addempname','$addempid','$editempname','$editempid','$narration');";


$q1=mysql_query($q1) or die(mysql_error());


//query to insert in distribution_financialpostings


$q3="insert into distribution_financialpostings(date,itemcode,crdr,quantity,amount,trnum,type,warehouse) values ('$date','$code','Cr','$stock','$amount','$trnum','STDT','$superstockist'),('$date','$code','Dr','$stock','$amount','$trnum','STDT','$distributor') ";


$q3=mysql_query($q3) or die(mysql_error());



//--------------------------------------------------



}

}


// updating the Total amount

$q1="update distribution_stockissuetodistributor set totalamount='$totalamount' where trnum='$trnum'";

$q1=mysql_query($q1) or die(mysql_error());

//--------------------------------------



echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=distribution_stockissuedistributor';";

echo "</script>";


?>