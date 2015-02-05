<?php

//print_r($_POST);


include "getemployee.php";

$addempname=$empname;

$addempid=$empid;



$date=date("Y-m-d",strtotime($_POST['date']));

$superstockist=$_POST['superstockist'];

$docno=$_POST['docno'];

$narration=$_POST['narration'];

$q1="select max(tid) as tid from distribution_stockreturnfromdistributor";

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

$trnum="RTDT-".$incr;


if($_POST['edit']=="1")
{

$trnum=$_POST['oldid'];

$tr=explode("-",$trnum);

$incr=$tr[1];


$q2="select addempname,addempid from distribution_stockreturnfromdistributor where trnum='$trnum' limit 1";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$addempname=$r2['addempname'];

$addempid=$r2['addempid'];

$editempname=$empname;

$editempid=$empid;

$q3="delete from distribution_stockreturnfromdistributor where trnum='$trnum' ";

$q3=mysql_query($q3) or die(mysql_error());


}


for($i=0;$i<count($_POST['category']);$i++)
 {

$cat=$_POST['category'][$i];

$code=$_POST['code'][$i];

$description=$_POST['description'][$i];

$units=$_POST['units'][$i];

$distributor=$_POST['distributor'][$i];

$stock=$_POST['stock'][$i];

if($cat!="" && $code!="" && $stock!="")

{

  $q1="INSERT INTO `distribution_stockreturnfromdistributor` ( `tid`, `trnum`, `date`, `superstockist`,`docno`, `category`, `code`, `description`, `units`,`distributor`, `quantity`, `addempname`, `addempid`, `editempname`, `editempid`,`narration`) VALUES ('$incr','$trnum','$date','$superstockist','$docno','$cat','$code','$description','$units','$distributor','$stock','$addempname','$addempid','$editempname','$editempid','$narration');";


$q1=mysql_query($q1) or die(mysql_error());



}

}

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=distribution_stockreturnfromdistributor';";

echo "</script>";


?>