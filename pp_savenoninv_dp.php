 <?php 

include "config.php";

include "getemployee.php";
$type="SOBI";



$date = date("Y-m-d",strtotime($_POST['date']));

$vendor = $_POST['vendor'];
$invoice = $_POST['invoice'];
$bookinvoice = $_POST['binvoice'];
$grandtotal =$_POST['gtot'];
 $warehouse = $_POST['warehouse'];
 
 $query1 = "SELECT * FROM contactdetails WHERE name = '$vendor' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $va = $row1['va']; }
  

$temp = explode('-',$date);

$m = $temp[1];



if($_POST['said']==1)
 {

$id=$_POST['oldinv'];



$get_entriess = "DELETE FROM pp_sobi WHERE so = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'SOBI' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());




$temp=explode("-",$id);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$so=$id;

else
{
$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $sobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sobiincr = $row1['sobiincr']; 
$sobiincr = $sobiincr + 1;
if ($sobiincr < 10) 
$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;
$so = $sobi;

 
 }



 
 }
 
 
if($_POST['said'] <>1)
{
$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $sobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sobiincr = $row1['sobiincr']; 
$sobiincr = $sobiincr + 1;
if ($sobiincr < 10) 
$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;
$so = $sobi;
}




/*
if($_POST['eid']=="1")
{


$date=$_POST['da'];
$co=$_POST['co'];
$so=$_POST['oldinv'];

$q="delete from pp_sobi where so='$so'";
$res=mysql_query($q);

$qf="delete from ac_financialpostings where trnum='$so' and type='$type'";
$res=mysql_query($qf);


$date = date("Y-m-d",strtotime($_POST['date']));

$vendor = $_POST['vendor'];
$invoice = $_POST['invoice'];
$bookinvoice = $_POST['binvoice'];

 $query1 = "SELECT * FROM contactdetails WHERE name = '$vendor' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $va = $row1['va']; }

  $m=$_POST['m'];
  $y=$_POST['y'];
  
  
$temp=explode("-",$id);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$so=$id;

else
{
$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $sobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sobiincr = $row1['sobiincr']; 
$sobiincr = $sobiincr + 1;
if ($sobiincr < 10) 
$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;
$so = $sobi;

 
 }

  



$remarks=$_POST['remarks'];


$grandtotal =$_POST['gtot'];
 $warehouse = $_POST['warehouse'];
 
  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client)
  VALUES('$date','','Cr','$va',0,'$grandtotal','$so','$type','$vendor','$warehouse','$client')"; 
$result4 = mysql_query($query4,$conn) or die(mysql_error());




for($i = 0;$i < count($_POST['amt']); $i++)

if( $_POST['amt'][$i] != '0' && $_POST['amt'][$i] != '' && $_POST['code'][$i] !='')

{

    $noofentries++;

	$temp = explode("@",$_POST['code'][$i]);
	
	$code=$temp[0];
	$description=$temp[1];

    $price = $_POST['dis'][$i];

	$amt = $_POST['amt'][$i];

	
	
	$amt1=$amt-$price;
    
  

	

	/////////////////////////////////

	



  $q = " insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,code,description,totalamount,grandtotal,balance,sector,niflag,discountamount,warehouse,empid,empname)

values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$code','$description','$amt','$grandtotal','$grandtotal','$warehouse','1','$price','$warehouse','$empid','$empname')";

  $r4 = mysql_query($q,$conn) or die(mysql_error());


		 
		  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
 VALUES('$date','','Dr','$code',0,'$amt1','$so','$type','$vendor','$warehouse','$client')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());



}



}

else
{*/

$date = date("Y-m-d",strtotime($_POST['date']));

$vendor = $_POST['vendor'];
$invoice = $_POST['invoice'];
$bookinvoice = $_POST['binvoice'];
$grandtotal =$_POST['gtot'];
 $warehouse = $_POST['warehouse'];
 
 $query1 = "SELECT * FROM contactdetails WHERE name = '$vendor' and client = '$client' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($row1 = mysql_fetch_assoc($result1)) { $va = $row1['va']; }
  

$temp = explode('-',$date);

$m = $temp[1];

$y = substr($temp[0],2);

$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";

$result1 = mysql_query($query1,$conn); $sobiincr = 0; 

while($row1 = mysql_fetch_assoc($result1)) 

$sobiincr = $row1['sobiincr']; 

$sobiincr = $sobiincr + 1;

if ($sobiincr < 10) 

$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 

else if($sobiincr < 100 && $sobiincr >= 10) 

$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 

else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;

$so = $sobi;


$remarks=$_POST['remarks'];

 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client)
  VALUES('$date','','Cr','$va',0,'$grandtotal','$so','$type','$vendor','$warehouse','$client')"; 
$result4 = mysql_query($query4,$conn) or die(mysql_error());


		 




for($i = 0;$i < count($_POST['amt']); $i++)

if( $_POST['amt'][$i] != '0' && $_POST['amt'][$i] != '' && $_POST['code'][$i] !='')

{

    $noofentries++;
	
	$temp = explode("@",$_POST['code'][$i]);
	
	$code=$temp[0];
	$description=$temp[1];

	
    $price = $_POST['dis'][$i];

	$qtyr = $_POST['amt'][$i];


	 
	$qtyr1=$qtyr-$price;

	/*$execute = 1;

	$autoflock ="";*/

	

	/////////////////////////////////
	



 $q = " insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,code,description,totalamount,grandtotal,balance,sector,niflag,discountamount,warehouse,empid,empname)

values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$code','$description','$qtyr','$grandtotal','$grandtotal','$warehouse','1','$price','$warehouse','$empid','$empname')";

mysql_query($q);



		  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
 VALUES('$date','','Dr','$code',0,'$qtyr1','$so','$type','$vendor','$warehouse','$client')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());



}

/*}*/



	//end of EXECUTE = 1

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=noninv_directpurchasedisplay'";

echo "</script>";



?>



