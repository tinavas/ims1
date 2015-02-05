<?php
$p = "employeeimages";
include "config.php";
            $query2 = "SELECT * FROM hr_employee where employeeid = '$_GET[id]' ";
            $result2 = mysql_query($query2,$conn);
            while($row2 = mysql_fetch_assoc($result2))
            {
                $path = $row2['image']; 
            }
            unlink("employeeimages/reduced/".$path);
            unlink("employeeimages/thumbnails/".$path);
            unlink("employeeimages/".$path);

include "config.php";
$get_entriess = "DELETE FROM hr_employee WHERE employeeid = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM hr_salaryparameters WHERE eid = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM leaves WHERE empid = $_GET[id]";
//$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM hr_attendance WHERE eid = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM expenses WHERE eid = $_GET[id]";
//$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM payment WHERE eid = $_GET[id]";
//$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());





echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_employee';";
echo "</script>";
?>

