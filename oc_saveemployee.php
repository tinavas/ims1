<?php
include "config.php";
$name = strtoupper($_POST['name']);
if(mysql_num_rows(mysql_query("select id from oc_employee where name='$name'"))>0)
{
 ?>
 <script>
alert('Already <?php echo $name; ?> is added'); document.location ='dashboardsub.php?page=oc_addemployee';

 </script>
 <?php
}

else 
{
 $query="INSERT INTO oc_employee (id,name,address,phone,mobile,note,place,pan,ctype)
 VALUES (NULL,'".$name."','".$_POST['address']."','".$_POST['phone']."','".$_POST['mobile']."','".$_POST['note']."','".$_POST['place']."','".$_POST['pan']."','".$_POST['ctype']."')";

 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 header('Location:dashboardsub.php?page=oc_employee');
}
?>
