<?php

print_r($_POST);

include "config.php";
$name = strtoupper($_POST['name']);
$temp = explode("@",$_POST['cgroup']);
   $cgroup = $temp[0];
   $ca = $temp[1];
   $cac = $temp[2];
$type = $_POST['type'];
$code=$_POST['vpcode'];
$climit = $_POST['climit'];
if($climit == "") $climit = 0;
$cterm = $_POST['cterm'];
$customercategory = $_POST['category'];

if(mysql_num_rows(mysql_query("select id from contactdetails where name='$name' and type like '%party%'"))>0)
{
 ?>
 <script>
alert('Already <?php echo $name; ?> is added'); document.location ='dashboardsub.php?page=oc_addcustomer';

 </script>
 <?php
}
elseif(mysql_num_rows(mysql_query("select id from contactdetails where code='$code' and type like '%party%'"))>0 && $_SESSION[db]=='albustan' && $code <> '' )
{
 ?>
 <script>
alert('Already <?php echo $code; ?> is added'); document.location ='dashboardsub.php?page=oc_addcustomer';

 </script>
 <?php
}
else 
{

if($type <> 'vendor and party')
{

 $query="INSERT INTO contactdetails (id,code,name,address,phone,mobile,type,note,place,pan,cterm,cgroup,ca,cac,client,climit)
 VALUES (NULL,'$code','".$name."','".$_POST['address']."','".$_POST['phone']."','".$_POST['mobile']."','".$_POST['type']."','".$_POST['note']."','".$_POST['place']."','".$_POST['pan']."','".$cterm."','".$cgroup."','".$ca."','".$cac."','".$client."','$climit')";
 
 ////for client singh 
 
 if($_SESSION['db']=="singhsatrang")
{
if(isset($_POST['stockist']))
{
$state=$_POST['state'];
$superstockist="YES";
}
else
{
$state="";
$superstockist="NO";
}

 $query="INSERT INTO contactdetails (id,code,name,address,phone,mobile,type,note,place,pan,cterm,cgroup,ca,cac,client,climit,superstockist,state)
 VALUES (NULL,'$code','".$name."','".$_POST['address']."','".$_POST['phone']."','".$_POST['mobile']."','".$_POST['type']."','".$_POST['note']."','".$_POST['place']."','".$_POST['pan']."','".$cterm."','".$cgroup."','".$ca."','".$cac."','".$client."','$climit','$superstockist','$state')";


}
 
 //------------------------------------
 
}


elseif($type = 'vendor and party')
{
$temp = explode("@",$_POST['vgroup']);
   $vgroup = $temp[0];
   $va = $temp[1];
   $vppa = $temp[2];

 $term = '60';
 $q1 = "SELECT * FROM ac_vgrmap WHERE flag = 'V'";
 $r1 = mysql_query($q1,$conn) or die(mysql_error());
 $row1 = mysql_fetch_assoc($r1);
 
  $query="INSERT INTO contactdetails (id,code,name,address,phone,mobile,type,note,place,pan,cterm,cgroup,ca,cac,vgroup,va,vppa,client,cterm,climit)
 VALUES (NULL,'$code','".$name."','".$_POST['address']."','".$_POST['phone']."','".$_POST['mobile']."','".$_POST['type']."','".$_POST['note']."','".$_POST['place']."','".$_POST['pan']."','".$cterm."','".$cgroup."','".$ca."','".$cac."','".$vgroup."','".$va."','".$vppa."','".$client."','$cterm','$climit')";

//for client singh 
 
 if($_SESSION['db']=="singhsatrang")
{
if(isset($_POST['stockist']))
{
$state=$_POST['state'];
$superstockist="YES";
}
else
{
$state="";
$superstockist="NO";
}

 $query="INSERT INTO contactdetails (id,code,name,address,phone,mobile,type,note,place,pan,cterm,cgroup,ca,cac,client,climit,superstockist,state)
 VALUES (NULL,'$code','".$name."','".$_POST['address']."','".$_POST['phone']."','".$_POST['mobile']."','".$_POST['type']."','".$_POST['note']."','".$_POST['place']."','".$_POST['pan']."','".$cterm."','".$cgroup."','".$ca."','".$cac."','".$client."','$climit','$superstockist','$state')";


}
 //------------------------------
 
 
 
 }
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

if($_SESSION['db'] == "suriya")
{ 
$query = "INSERT INTO common_messages (id,title,message,fromname,toname,date,sentflag,receivedflag,client) VALUES (NULL,'New Customer Added','$name','$empname','suriya','".date("Y-m-d")."',0,1,'$client')";
$result = mysql_query($query,$conn) or die(mysql_error());
}
 header('Location:dashboardsub.php?page=oc_customer');
}
?>
