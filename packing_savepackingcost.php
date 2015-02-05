<?php
include "getemployee.php";

$addempname=$empname;

$addempid=$empid;

$editempname="";

$editempid="";

$flag=0;

if($_POST['edit']=='1')
{

 $id=$_POST['oldid'];
 
 $q1="select addempname,addempid from packing_packingcost where id='$id'";
 
 $q1=mysql_query($q1) or die(mysql_error());
 
 $r1=mysql_fetch_assoc($q1);
 
 $addempname=$r1['addempname'];
 
 $addempid=$r1['addempid'];
 
 $editempname=$empname;
 
 $editempid=$empid;
 
 $q1="delete from packing_packingcost where id='$id'";
 
 $q1=mysql_query($q1) or die(mysql_error());


}


$fromdate=date("Y-m-d",strtotime($_POST['fromdate']));

$todate=date("Y-m-d",strtotime($_POST['todate']));

$location=$_POST['location'];

$length=count($_POST['category']);

for($i=0;$i<$length;$i++)
{

  $category=$_POST['category'][$i]; 
  
  $code=$_POST['code'][$i]; 
  
  $description=$_POST['description'][$i];
  
  $units=$_POST['units'][$i];
  
   $cost=$_POST['cost'][$i];
   
   $contractor=$_POST['contractor'][$i];
  
  if($category!="" && $code!="" && $cost!="")
  
    {
	
	$q5="select * from packing_packingcost where (('$fromdate' between fromdate and todate) or ('$todate' between fromdate and todate)) and code='$code' and location='$location' and contractor='$contractor'";
	
	$num=mysql_num_rows(mysql_query($q5));
	
	if($num>0)
	{
	
	$errorcodes[]=$code;
	
	$flag=1;
	
	echo "<script type='text/javascript'>";
	
	echo "alert('Item Code:$code Is Already Added For This Date Span Please Select Another Date Span For This Code')";
	
	echo "</script>";
	
	}
	else
	{
	
	$q2="INSERT INTO `packing_packingcost` ( `fromdate`, `todate`, `location`, `contractor`,`category`, `code`, `description`, `units`, `cost`, `addempname`, `addempid`, `editempname`, `editempid`) VALUES ('$fromdate','$todate','$location','$contractor','$category','$code','$description','$units','$cost','$addempname','$addempid','$editempname','$editempid');";
	  
	  $q2=mysql_query($q2) or die(mysql_error());
	  
	}
	
	
	}
 
 
}

if($flag==1)
{

    $codes=implode("*",$errorcodes);
	
    echo "<script type='text/javascript'>";
	
	echo "document.location='dashboardsub.php?page=packing_addpackingcost&codes=$codes'";
	
	echo "</script>";

}

else
{

    echo "<script type='text/javascript'>";
	
	echo "document.location='dashboardsub.php?page=packing_packingcost'";
	
	echo "</script>";

}

?>