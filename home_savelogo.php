<?php
include "config.php";

$file = basename( $_FILES['uploadedfile']['name']);
$image = $file;


$target_path = "logo/thumbnails/"; 
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
$i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);


$j = $image;
file_get_contents("http://bims1.spectacularsys.com/thumb.php?src=" . $j . "&dest=" . $j . "&x=70&y=60");
file_get_contents("http://bims1.spectacularsys.com/thumb1.php?src=" . $j . "&dest=" . $j . "&x=340&y=320");


if($_POST['id'])
{
   if($image != "" && $image != "NULL")
    {
       $query = "delete from home_logo where id = '$_POST[id]'";
       $result = mysql_query($query,$conn) or die(mysql_error());


       $query="INSERT INTO home_logo (id,address,image)
       VALUES (NULL,'".htmlentities($_POST['address'],ENT_QUOTES)."','".$image."')" or die(mysql_error());
      $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
    }
   else
    {
     $query = "update home_logo set address = '".htmlentities($_POST['address'],ENT_QUOTES)."' where id = '$_POST[id]'";
     $result = mysql_query($query,$conn) or die(mysql_error());
    }

}

else
{
 $query="INSERT INTO home_logo (id,address,image)
 VALUES (NULL,'".htmlentities($_POST['address'],ENT_QUOTES)."','".$image."')" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 }
header('Location:dashboardsub.php?page=home_logo');
?>