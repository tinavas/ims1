<?php

include "config.php";



$file = basename($_FILES['uploadedfile']['name']);
$target_path = "diseases/"; 
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
$i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);


 $query="INSERT INTO tbl_diseases (id,code,name,symptoms,diagnosis,treatment,image)
 VALUES (NULL,'".$_POST['code']."','".$_POST['name']."','".$_POST['symptoms']."','".$_POST['diagnosis']."','".$_POST['treatment']."','".$file."')" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

header('Location:dashboardsub.php?page=common_diseases');
?>

