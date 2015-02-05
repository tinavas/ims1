<?php

//print_r($_POST);

include "getemployee.php";

$addempname=$empname;

$addempid=$empid;

$editempname="";

$editempid="";

$date=date("Y-m-d",strtotime($_POST['date']));

$location=$_POST['location'];


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
 
 //For Saving and fp
 $m=0;
 for($i=0;$i<count($_POST['category']);$i++)
{

  
  $contract=$_POST['contract'][$i];
  
  $category=$_POST['category'][$i];
  
  $code=$_POST['code'][$i];
  
  $description=$_POST['description'][$i];
  
  $units=$_POST['units'][$i];
  
  $packets=$_POST['packets'][$i];
  
  $coacode=$_POST['coacode'][$i];
  
  if($category!="" && $code!="" && $packets!="" )
  {

  
   //----------------------------
   $cost=0;
 
  $amount=$packets*$cost;
  
  $totalamount=$totalamount+$amount;
  
$qi="INSERT INTO `packing_dailypacking` ( `tid`, `trnum`, `date`, `location`, `labour`, `contractor`, `category`, `code`, `description`, `units`, `packets`, `cost`, `amount`,  `coacode`, `addempname`, `addempid`, `editempname`, `editempid`) VALUES ('$incr','$trnum','$date','$location','YES','Labour','$category','$code','$description','$units','$packets','$cost','$amount','$coacode','$addempname','$addempid','$editempname','$editempid');";
   
   $qi=mysql_query($qi) or die(mysql_error());
   

   
 for($k=0;$k<count($_POST['contract']);$k++)
 { 
 $contract=$_POST['contract'][$k];
 $pack=$_POST['contractor'][$m];
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
$qi="INSERT INTO `packing_dailypacking` ( `tid`, `trnum`, `date`, `location`, `labour`, `contractor`, `category`, `code`, `description`, `units`, `packets`, `cost`, `amount`,  `coacode`, `addempname`, `addempid`, `editempname`, `editempid`) VALUES ('$incr','$trnum','$date','$location','$labour','$contract','$category','$code','$description','$units','$pack','$cost','$amount','$coacode','$addempname','$addempid','$editempname','$editempid');";
   
   $qi=mysql_query($qi) or die(mysql_error());

    $q2 = "SELECT code FROM ac_coa WHERE description = '$contract' ";
	 
     $r2 = mysql_query($q2,$conn);
	 
      while($ro2 = mysql_fetch_assoc($r2))
	  
        $contractorac = $ro2['code'];
   
     $query2 = "SELECT va FROM contactdetails WHERE name = '$contract'";
	 
     $result2 = mysql_query($query2,$conn);
	 
      while($row2 = mysql_fetch_assoc($result2))
	  
        $ca = $row2['va'];
		
		 $qa="insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) values ('$date','$code','Dr','$contractorac','$pack','$amount','$trnum','DPACK','','$location'),('$date','$code','Cr','$ca','$pack','$amount','$trnum','DPACK','$contract','$location')";
   
         $qa=mysql_query($qa) or die(mysql_error());
		 }
$m++;

  
  }


}
 
 $update="update packing_dailypacking set totalamount='$totalamount' where trnum='$trnum'";
 
 $update=mysql_query($update) or die(mysql_error());
 
 
 
 //----------------------
 
 
 echo "<script type='text/javascript'>";
	  
 echo "document.location='dashboardsub.php?page=packing_dailypacking'";
	  
 echo "</script>";
 
 
 
}
 

?>