<?php
//print_r($_POST);


include "getemployee.php";

$addempname=$empname;

$addempid=$empid;



$date=date("Y-m-d",strtotime($_POST['date']));

$superstockist=$_POST['superstockist'];

$distributor=$_POST['distributor'];

$area=$_POST['area'];


$salesman=$_POST['salesman'];

$order=$_POST['order'];

$time=$_POST['time'];

$narration=$_POST['narration'];


$q1="select max(tid) as tid from distribution_salesmanvisits";

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

$trnum="SAVI-".$incr;


if($_POST['edit']=="1")
{

$trnum=$_POST['oldid'];

$tr=explode("-",$trnum);

$incr=$tr[1];


$q2="select addempname,addempid from distribution_salesmanvisits where trnum='$trnum' limit 1";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$addempname=$r2['addempname'];

$addempid=$r2['addempid'];

$editempname=$empname;

$editempid=$empid;

$q3="delete from distribution_salesmanvisits where trnum='$trnum' ";

$q3=mysql_query($q3) or die(mysql_error());


}


if($order=="YES")
{

for($i=0;$i<count($_POST['category']);$i++)
 {

$cat=$_POST['category'][$i];

$code=$_POST['code'][$i];

$description=$_POST['description'][$i];

$units=$_POST['units'][$i];

$stock=$_POST['stock'][$i];

if($cat!="" && $code!="" && $stock!="")

{

    $q1="INSERT INTO `distribution_salesmanvisits` ( `tid`, `trnum`, `date`, `superstockist`,`salesman`,`area`,`order`,`time`,`distributor`,`category`, `code`, `description`, `units`, `quantity`, `addempname`, `addempid`, `editempname`, `editempid`,narration) VALUES ('$incr','$trnum','$date','$superstockist','$salesman','$area','$order','$time','$distributor','$cat','$code','$description','$units','$stock','$addempname','$addempid','$editempname','$editempid','$narration');";

$q1=mysql_query($q1) or die(mysql_error());
}

}
}

if($order=="NO")
{

  $q1="INSERT INTO `distribution_salesmanvisits` ( `tid`, `trnum`, `date`, `superstockist`,`salesman`,`area`,`order`,`time`,`distributor`,`category`, `code`, `description`, `units`, `quantity`, `addempname`, `addempid`, `editempname`, `editempid`,narration) VALUES ('$incr','$trnum','$date','$superstockist','$salesman','$area','$order','$time','$distributor','$cat','$code','$description','$units','$stock','$addempname','$addempid','$editempname','$editempid','$narration');";


$q1=mysql_query($q1) or die(mysql_error());
}



echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=distribution_salesmanvisits';";

echo "</script>";


?>