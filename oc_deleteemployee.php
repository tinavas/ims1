<?php
include "config.php";
$id=$_GET['id'];
//
//$get_name="SELECT name FROM contactdetails WHERE id ='$id'";
//$result_name=mysql_query($get_name,$conn) or die(mysql_error());
//$rows_name=mysql_fetch_array($result_name);
//$name=$rows_name['name'];
//
//$query1="SELECT * FROM ac_financialpostings WHERE venname = '$name'";
//$result1=mysql_query($query1,$conn) or die(mysql_error());
//$rows1=mysql_num_rows($result1);
//
//$query2="SELECT * FROM oc_cobi WHERE party = '$name'";
//$result2=mysql_query($query2,$conn) or die(mysql_error());
//$rows2=mysql_num_rows($result2);
//
//$query3="SELECT * FROM oc_receipt WHERE party = '$name'";
//$result3=mysql_query($query3,$conn) or die(mysql_error());
//$rows3=mysql_num_rows($result3);
//
//$query4="SELECT * FROM oc_payment WHERE party = '$name'";
//$result4=mysql_query($query4,$conn) or die(mysql_error());
//$rows4=mysql_num_rows($result4);
//
//$query5="SELECT * FROM ac_crdrnote WHERE vcode = '$name'";
//$result5=mysql_query($query5,$conn) or die(mysql_error());
//$rows5=mysql_num_rows($result5);
//
//$count=$rows1+$rows2+$rows3+$rows4+$rows5;
//if($count==0)
//{
 $delete_query="DELETE FROM oc_employee WHERE id = '$id'";
 $delete_result=mysql_query($delete_query,$conn) or die(mysql_error());
/*}
else
{
 echo "<script type='text/javascript'>";
 echo "alert('Cannot be deleted,already made transactions with the Customer');";
 echo "</script>";
}
*/
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=oc_employee';";
echo "</script>";
?>


