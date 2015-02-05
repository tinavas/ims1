<?php
include "config.php";
$id = $_POST['oldid'];
$c=0;
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
   $q="select iac from ims_itemcodes where code='$code'";
   $r=mysql_query($q,$conn);
   $r1=mysql_fetch_array($r);
   $coacode=$r1['iac'];
   
   $q1="select max(date) as maxdate from ac_financialpostings where itemcode='$code' and coacode='$coacode'";
   $r1=mysql_query($q1,$conn);
   $r2=mysql_fetch_array($r1);
  $maxdate=$r2['maxdate'];
   
   if($todate<$maxdate && $maxdate>=$fromdate)
   {
 $c=1;
 echo  "<script type='text/javascript'>";
  
  echo "alert('You cant modify.Because Transaction already exists');";
 echo "document.location='dashboardsub.php?page=ims_editstandardcosts&id=$id'";
echo   "</script>";
  

   
   
   }
   
   
   
   }
   
   
   }
   
   
   if($c==0)
   {
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
else 
echo "document.location='dashboardsub.php?page=ims_standardcosts'";
echo "</script>";
?>