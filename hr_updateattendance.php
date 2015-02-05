<?php
$dumpdate = $_POST['date1'];
$date = date("Y-m-j", strtotime($dumpdate));
$place = $_POST['sector'];
$reportingto = $_POST['reportingto'];
include "config.php";
$get_entriess = 
"DELETE FROM hr_attendance WHERE date = '$date' and place = '$place' and reportingto = '$reportingto'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

 
for($i=0;$i<count($_POST['box1']);$i++) 
{

$dumpdate = $_POST['date1'];
$date = date("Y-m-j", strtotime($dumpdate));
$breakdate = explode('-',$date);
$name1 = $_POST['box1'][$i];
$name = explode(',',$name1);
$daytype = "Full";

$query="INSERT INTO hr_attendance (id,eid,place,farm,name,date,day1,month1,year1,dumpdate,reportingto,daytype)
VALUES (NULL,'".$name[1]."','".$place."','".$name[2]."','".$name[0]."','".$date."','".$breakdate[2]."','".$breakdate[1]."','".$breakdate[0]."','".$dumpdate."','".$reportingto."','".$daytype."')";
$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

}

for($i=0;$i<count($_POST['box2']);$i++) 
{

$dumpdate = $_POST['date1'];
$date = date("Y-m-j", strtotime($dumpdate));
$breakdate = explode('-',$date);
$name1 = $_POST['box2'][$i];
$name = explode(',',$name1);
$daytype = "Half";

$query="INSERT INTO hr_attendance (id,eid,place,farm,name,date,day1,month1,year1,dumpdate,reportingto,daytype)
VALUES (NULL,'".$name[1]."','".$place."','".$name[2]."','".$name[0]."','".$date."','".$breakdate[2]."','".$breakdate[1]."','".$breakdate[0]."','".$dumpdate."','".$reportingto."','".$daytype."')";
$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

}
for($i=0;$i<count($_POST['box3']);$i++) 
{

$dumpdate = $_POST['date1'];
$date = date("Y-m-j", strtotime($dumpdate));
$breakdate = explode('-',$date);
$name1 = $_POST['box3'][$i];
$name = explode(',',$name1);
$daytype = "Leav";

$query="INSERT INTO hr_attendance (id,eid,place,farm,name,date,day1,month1,year1,dumpdate,reportingto,daytype)
VALUES (NULL,'".$name[1]."','".$place."','".$name[2]."','".$name[0]."','".$date."','".$breakdate[2]."','".$breakdate[1]."','".$breakdate[0]."','".$dumpdate."','".$reportingto."','".$daytype."')";
$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_attendance';";
echo "</script>";
?>