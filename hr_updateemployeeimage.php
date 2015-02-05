<?php
include "config.php";
$id = $_POST['id'];

            $query2 = "SELECT * FROM employee where id = '$_POST[id]' ORDER BY id ASC ";
            $result2 = mysql_query($query2,$conn);
            while($row2 = mysql_fetch_assoc($result2))
            {
                $path = $row2['image']; 
            }
            unlink("employeeimages/reduced/".$path);
            unlink("employeeimages/thumbnails/".$path);
            unlink("employeeimages/".$path);

$file = basename( $_FILES['uploadedfile']['name']);
$image = $file;
$target_path = "employeeimages/"; 
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
$i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
$j = $image;
file_get_contents("hr_thumb.php?src=" . $j . "&dest=" . $j . "&x=70&y=53");
file_get_contents("hr_thumb1.php?src=" . $j . "&dest=" . $j . "&x=600&y=500");



?>

<?php

$get_entriess = "UPDATE `hr_employee` SET `image` = '$image' WHERE `hr_employee`.`employeeid` = '$id' LIMIT 1  ;";     
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_employee'";
echo "</script>";
?>