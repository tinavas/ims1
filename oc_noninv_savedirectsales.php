 <?php 

include "config.php";

include "getemployee.php";

//print_r($_POST);
$q = "select distinct(ca) as code1 from contactdetails where name = '$vendor' order by ca";

	$qrs = mysql_query($q,$conn) or die(mysql_error());

	if($qr = mysql_fetch_assoc($qrs))

	$code1 = $qr['code1'];
$so = $_POST['so'];

$type = "COBI";	

if($_POST['eid']=="1")
{
$date=$_POST['da'];
$co=$_POST['cod'];
$so=$_POST['co'];
$memp=$_POST['memp'];
$q="delete from oc_cobi where invoice='$so'";
$res=mysql_query($q);

$qf="delete from ac_financialpostings where trnum='$so' and type='$type' ";
$res=mysql_query($qf);


$date = date("Y-m-d",strtotime($_POST['date']));

$party = $_POST['party'];

$bookinvoice = $_POST['invoice'];

$temp = explode('-',$date);

$m = $temp[1];

$y = substr($temp[0],2);

$query1 = "SELECT * FROM contactdetails WHERE name ='$party' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $ca = $row1['ca']; }


$query1 = "SELECT MAX(cobiincr) as cobiincr FROM oc_cobi where m = '$m' AND y = '$y' ORDER BY date DESC";

$result1 = mysql_query($query1,$conn); $sobiincr = 0; 

while($row1 = mysql_fetch_assoc($result1)) 

$sobiincr = $row1['cobiincr']; 

$sobiincr = $sobiincr + 1;

if ($sobiincr < 10) 

$sobi = 'COBI-'.$m.$y.'-000'.$sobiincr; 

else if($sobiincr < 100 && $sobiincr >= 10) 

$sobi = 'COBI-'.$m.$y.'-00'.$sobiincr; 

else $sobi = 'COBI-'.$m.$y.'-0'.$sobiincr;

$invoice = $sobi;
$grandtotal=$_POST['gtot'];
$binvoice=$_POST['binvoice'];

$remarks=$_POST['remarks'];
 $warehouse = $_POST['warehouse'];

$totalquantity = 0;


  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
 VALUES('$date','','Dr','$ca',0,'$grandtotal','$invoice','$type','$party','$warehouse','$client')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	




for($i =0;$i < count($_POST['amt']); $i++)

if( $_POST['amt'][$i] != '0' && $_POST['amt'][$i] != '' && $_POST['code'][$i] !='')

{

    $noofentries++;

	$temp=explode("@",$_POST['code'][$i]);
  $code = $temp[0];
	$description = $temp[1];

    $price = $_POST['dis'][$i];

	$qtyr = $_POST['amt'][$i];
 $warehouse = $_POST['warehouse'];
 
	    
	$amt1=$qtyr-$price;




	

	/////////////////////////////////

	


 if($_SESSION['db']=="mew")
 $q = "insert into oc_cobi
(partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,total,finaltotal,balance,sector,niflag,discountamount,warehouse,client,empid,empname,marketingemp) 
values('$partycode','$remarks','$date','$sobiincr','$m','$y','$invoice','$binvoice','$party','$code','$description','$qtyr','$grandtotal','$grandtotal','$warehouse','1','$price','$warehouse','$client','$empid','$empname','$memp')";
else
$q = "insert into oc_cobi
(partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,total,finaltotal,balance,sector,niflag,discountamount,warehouse,client,empid,empname) 
values('$partycode','$remarks','$date','$sobiincr','$m','$y','$invoice','$binvoice','$party','$code','$description','$qtyr','$grandtotal','$grandtotal','$warehouse','1','$price','$warehouse','$client','$empid','$empname')";


mysql_query($q);

	
	  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
 VALUES('$date','','Cr','$code',0,'$amt1','$invoice','$type','$party','$warehouse','$client')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());





}

  
}

else
{


$date = date("Y-m-d",strtotime($_POST['date']));

$party = $_POST['party'];

$memp=$_POST['memp'];

$query1 = "SELECT * FROM contactdetails WHERE name ='$party' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $ca = $row1['ca']; }

$temp = explode('-',$date);

$m = $temp[1];

$y = substr($temp[0],2);

$query1 = "SELECT MAX(cobiincr) as cobiincr FROM oc_cobi where m = '$m' AND y = '$y' ORDER BY date DESC";

$result1 = mysql_query($query1,$conn); $sobiincr = 0; 

while($row1 = mysql_fetch_assoc($result1)) 

$sobiincr = $row1['cobiincr']; 

$sobiincr = $sobiincr + 1;

if ($sobiincr < 10) 

$sobi = 'COBI-'.$m.$y.'-000'.$sobiincr; 

else if($sobiincr < 100 && $sobiincr >= 10) 

$sobi = 'COBI-'.$m.$y.'-00'.$sobiincr; 

else $sobi = 'COBI-'.$m.$y.'-0'.$sobiincr;

$invoice = $sobi;
$grandtotal=$_POST['gtot'];
$binvoice=$_POST['binvoice'];

$remarks=$_POST['remarks'];
 $warehouse = $_POST['warehouse'];

$totalquantity = 0;
 count($_POST['amt']);
 $type="COBI";
 
  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
 VALUES('$date','','Dr','$ca',0,'$grandtotal','$invoice','$type','$party','$warehouse','$client')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
	
		 
 
 

for($i =0;$i < count($_POST['amt']); $i++)

if( $_POST['amt'][$i] != '0' && $_POST['amt'][$i] != '' && $_POST['code'][$i] !='')

{
    
    $noofentries++;
	
	$temp=explode("@",$_POST['code'][$i]);
  $code = $temp[0];
	$description = $temp[1];

	


    $price = $_POST['dis'][$i];

	$qtyr = $_POST['amt'][$i];

	
    
	$amt1=$qtyr-$price; 
	

	

	/////////////////////////////////


if($_SESSION['db']=="mew")
 $q = "insert into oc_cobi
(partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,total,finaltotal,balance,sector,niflag,discountamount,warehouse,client,empid,empname,marketingemp) 
values('$partycode','$remarks','$date','$sobiincr','$m','$y','$invoice','$binvoice','$party','$code','$description','$qtyr','$grandtotal','$grandtotal','$warehouse','1','$price','$warehouse','$client','$empid','$empname','$memp')";
else
$q = "insert into oc_cobi
(partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,total,finaltotal,balance,sector,niflag,discountamount,warehouse,client,empid,empname) 
values('$partycode','$remarks','$date','$sobiincr','$m','$y','$invoice','$binvoice','$party','$code','$description','$qtyr','$grandtotal','$grandtotal','$warehouse','1','$price','$warehouse','$client','$empid','$empname')";

mysql_query($q);

	
	  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
 VALUES('$date','','Cr','$code',0,'$amt1','$invoice','$type','$party','$warehouse','$client')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());
 

	

}




}



	//end of EXECUTE = 1

echo "<script type='text/javascript'>";
 echo "document.location='dashboardsub.php?page=oc_noninv_directsales'";
echo "</script>";



?>



