<?php 

include "getemployee.php";


$date = date("Y-m-d",strtotime($_POST['date']));



$superstockist = $_POST['superstockist'];

$addempname=$empname;

$addempid=$empid;

$editempname="";

$editempid="";

$narration = $_POST['remarks'];


$doc=$_POST['doc'];


$query0="select max(tid) as tid from distribution_stockadjustment";

$query0=mysql_query($query0) or die(mysql_error());

$res=mysql_fetch_assoc($query0);

if($res['tid']=="" || $res['tid']=="0")
{
$incr=1;
}
else
{
$incr=$res['tid']+1;
}
 
$trnum="DTAT-".$incr;

if($_POST['edit']=='1')
{

$trnum=$_POST['oldid'];

$td=explode("-",$trnum);

$incr=$td[1];

$q1="select addempname,addempid from distribution_stockadjustment where trnum='$trnum'";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$addempname=$r1['addempname'];

$addempid=$r1['addempid'];

$editempname=$empname;

$editempid=$empid;

$q1="delete from distribution_stockadjustment where trnum='$trnum'";

$q1=mysql_query($q1) or die(mysql_error());



}


for($i = 0;$i < count($_POST['qtys']); $i++)
	{
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	
	$t=explode("@",$code);
	$code=$t[0];
	$description = $t[1];;
	$units = $_POST['units'][$i];
	$type=$_POST['addded'][$i];
	$quantity = $_POST['qtys'][$i];
	
	
if($cat!="" && $code!="" && $type!="" && $quantity!="")
{
$qu="insert into distribution_stockadjustment(date,superstockist,category,code,description,units,type,quantity,trnum,tid,narration,docno,addempname,addempid,editempname,editempid) values('$date','$superstockist','$cat','$code','$description','$units','$type','$quantity','$trnum','$incr','$narration','$doc','$addempname','$addempid','$editempname','$editempid')";	


$re=mysql_query($qu,$conn) or die(mysql_error());
}

 }
 

 
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=distribution_stockadjust'";
echo "</script>"; 
 
?>


