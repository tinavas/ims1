<?php
include "config.php";
$id = $_POST['oldid'];
$c=1;
for($i = 0; $i <= count($_POST['code']); $i++)
{
 if($_POST['code'][$i] <> '' && $_POST['stdcost'][$i] > 0)
 {
   $fromdate = date("Y-m-d",strtotime($_POST['fromdate'][$i]));
   $todate = date("Y-m-d",strtotime($_POST['todate'][$i]));
   $cat = $_POST['cat'][$i];
   $temp = explode('@',$_POST['code'][$i]);
   $code = $temp[0];
   $desc = $temp[1];
   $stdcost = $_POST['stdcost'][$i];
   
   $q2="select iac from ims_itemcodes where code='$code'";
   
   $res2=mysql_query($q2,$conn);
   $r2=mysql_fetch_array($res2);
   $coacode=$r2['iac'];
   
 $q1="Select max(date) as date from `ac_financialpostings`  WHERE itemcode ='$code' and coacode='$coacode'"; 
   $res1=mysql_query($q1,$conn);
   $r1=mysql_fetch_array($res1);
 
 $maxdate=$r1['date'];

   
   if($maxdate<$fromdate )

   	{$c=0;
  echo "<script type='text/javascript'>";
   echo "alert('Transaction already completed in between the dates');";
  echo "document.location='dashboardsub.php?page=ims_editstandardcosts&id=$id'";
   echo " </script>";
  
   }	
   
   
   
   }
   
   }
   
   
   
   if($c==1)
   {
for($i = 0; $i <= count($_POST['code']); $i++)
{
 if($_POST['code'][$i] <> '' && $_POST['stdcost'][$i] > 0)
 {
   $query1 = "SELECT id FROM ims_standardcosts WHERE code = '$code' AND ('$fromdate' BETWEEN fromdate AND todate or '$todate' BETWEEN fromdate AND todate) AND id <> '$id'";
   $result1 = mysql_query($query1,$conn) or die(mysql_error());
   $rows1 = mysql_num_rows($result1);
   
   if($rows1 > 0)
   {
    $alertmsg .= "Standard Cost has already been entered for item code $code - $desc for the selected span  ";
   }
   else
   {
    $query2 = "UPDATE ims_standardcosts SET fromdate = '$fromdate', todate = '$todate', cat = '$cat',code = '$code', description = '$desc', stdcost = '$stdcost' WHERE id = '$id'";
	$result2 = mysql_query($query2,$conn) or die(mysql_error());
   }
 }
}

}

echo "<script type='text/javascript'>";
if($alertmsg <> '')
{
 echo "alert('$alertmsg');";
echo "document.location='dashboardsub.php?page=ims_editstandardcosts&id=$id'";
}
echo "document.location='dashboardsub.php?page=ims_standardcosts'";
echo "</script>";
?>