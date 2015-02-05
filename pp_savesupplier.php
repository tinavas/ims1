<?php
include "config.php";
include "getemployee.php";
$name = strtoupper($_POST['name']);
$cterm =  $_POST['cterm'];
$temp = explode("@",$_POST['vgroup']);
   $vgroup = $temp[0];
   $va = $temp[1];
   $vppa = $temp[2];
$type = $_POST['type'];
   $code=$_POST['vpcode'];
   if($_SESSION['db']=="naidu")
   {
   $check=$_POST['check'];
   if($check=="")
   {
   	$check="not checked";
   }
   }
if(mysql_num_rows(mysql_query("select id from contactdetails where name='$name' and type like '%vendor%'"))>0)
{
 ?>
 <script>
alert('Already <?php echo $name; ?> is added'); document.location ='dashboardsub.php?page=pp_addsupplier';

 </script>
 <?php
}

else 
{
   
if($type <> 'vendor and party')
{
 
  $query="INSERT INTO contactdetails (id,code,name,address,phone,mobile,type,note,place,pan,cterm,vgroup,va,vppa,client)
 VALUES (NULL,'".$code."','".$name."','".$_POST['address']."','".$_POST['phone']."','".$_POST['mobile']."','".$_POST['type']."','".$_POST['note']."','".$_POST['place']."','".$_POST['pan']."','".$cterm."','".$vgroup."','".$va."','".$vppa."','$client')";


 
}
elseif($type == 'vendor and party')
{
$temp = explode("@",$_POST['cgroup']);
   $cgroup = $temp[0];
   $ca = $temp[1];
   $cppa = $temp[2];

 
  $query="INSERT INTO contactdetails (id,code,name,address,phone,mobile,type,note,place,pan,cterm,vgroup,va,vppa,cgroup,ca,cac,client)
 VALUES (NULL,'".$code."','".$name."','".$_POST['address']."','".$_POST['phone']."','".$_POST['mobile']."','".$_POST['type']."','".$_POST['note']."','".$_POST['place']."','".$_POST['pan']."','".$cterm."','".$vgroup."','".$va."','".$vppa."','".$cgroup."','".$ca."','".$cppa."','$client')";



}
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());


 header('Location:dashboardsub.php?page=pp_supplier');
}
?>



