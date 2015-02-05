<?php

//print_r($_POST);

include "getemployee.php";

$addempname=$empname;

$addempid=$empid;

$editempname="";

$editempid="";

$date=date("Y-m-d",strtotime($_POST['date']));

$location=$_POST['location'];

//To check all codes have got costs

$flag=0;

for($i=0;$i<count($_POST['category']);$i++)
{

  $code=$_POST['code'][$i];
  
  $labour=$_POST['checkcb'][$i];
 
  if($code!="" && $labour=="NO" )
  
   {

     $q2="SELECT count(*) as count FROM `packing_packingcost` where '$date' between fromdate and todate and code='$code' and location='$location' ";
	 
	 $q2=mysql_query($q2) or die(mysql_error());
	 
	 $r2=mysql_fetch_assoc($q2);
	 
	 if($r2['count']==0)
	 
	  {
	  
	  $errorcodes[]=$code;
	  
	  echo "<script type='text/javascript'>";
	  
	  echo "alert('Itemcode:$code Has No Cost Please Add the Cost');";
	  
	  echo "</script>";
	  
	  $flag=1;
	  
	  }

   }



}

//--------------------------------

if($flag==1)
{

 $errorcodes=implode("*",$errorcodes);

 echo "<script type='text/javascript'>";
	  
 echo "document.location='dashboardsub.php?page=packing_addpackingcost&codes=$errorcodes'";
	  
 echo "</script>";


}



if($flag==0)

{

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
 
 for($i=0;$i<count($_POST['category']);$i++)
{

  $labour=$_POST['checkcb'][$i];
  
  $contractor=$_POST['contractor'][$i];
  
  if($contractor=="")
  {
  
   $contractor="Labour";
  
  }
  
  $category=$_POST['category'][$i];
  
  $code=$_POST['code'][$i];
  
  $description=$_POST['description'][$i];
  
  $units=$_POST['units'][$i];
  
  $packets=$_POST['packets'][$i];
  
  $coacode=$_POST['coacode'][$i];
  
  if($category!="" && $code!="" && $packets!="" )
  {
  //Get the cost for that code
  $cost="";
  
 $q5="SELECT cost FROM `packing_packingcost` where '$date' between fromdate and todate and code='$code' and location='$location'"; 
 
 $q5=mysql_query($q5) or die(mysql_error());
 
 $r5=mysql_fetch_assoc($q5);
 
 $cost=$r5['cost'];
 if($cost=="")
 $cost=0;
  
   //----------------------------
 if($labour=="YES")
 {
   $cost=0;
 }
 
  $amount=$packets*$cost;
  
  $totalamount=$totalamount+$amount;
  
   $qi="INSERT INTO `packing_dailypacking` ( `tid`, `trnum`, `date`, `location`, `labour`, `contractor`, `category`, `code`, `description`, `units`, `packets`, `cost`, `amount`,  `coacode`, `addempname`, `addempid`, `editempname`, `editempid`) VALUES ('$incr','$trnum','$date','$location','$labour','$contractor','$category','$code','$description','$units','$packets','$cost','$amount','$coacode','$addempname','$addempid','$editempname','$editempid');";
   
   $qi=mysql_query($qi) or die(mysql_error());
   
   if($labour=="NO")
   {
   
     $query2 = "SELECT va FROM contactdetails WHERE name = '$contractor'";
	 
     $result2 = mysql_query($query2,$conn);
	 
      while($row2 = mysql_fetch_assoc($result2))
	  
        $ca = $row2['va'];
		
		 $qa="insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) values ('$date','$code','Dr','$coacode','$packets','$amount','$trnum','DPACK','','$location'),('$date','$code','Cr','$ca','$packets','$amount','$trnum','DPACK','$contractor','$location')";
   
         $qa=mysql_query($qa) or die(mysql_error());
		 
   
   
   
   } 
  
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