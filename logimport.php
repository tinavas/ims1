<?php ob_start();
 ini_set('display_errors', 0);

 ini_set('log_errors', 0);

 ini_set('error_reporting', E_ALL);
include "config.php";
include("createxslfromtable.php");
//print_r($_POST);
$year=$_POST['year'];
$month=$_POST['month'];
$day=date("Y-m-d");

//If selected current month and year
$dayexp=explode("-",$day);
$formday=$dayexp[0]."-".$dayexp[1];
$selected=$year."-".$month;
if($formday==$selected)
{
$ccfile="currentyearandmonth.xls";
$excel=$ccfile;
 createxsl($db,"69.162.85.106","TuL@Ss!12","poultry",$ccfile);
          header('Content-Description: File Transfer');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename='.$excel);
          header('Content-Transfer-Encoding: binary');
          header('Expires: 0');
          header('Cache-Control: must-revalidate');
          header('Pragma: public');
          header('Content-Length: ' . filesize("logbackup/$excel"));
          ob_clean();
          flush();
          readfile("logbackup/$excel");
		  
		  

}
else
{


$sql=mysql_query("select * from logregister where year(amy)='$year' and month(amy)='$month'");
$r=mysql_num_rows($sql);
if($r!="")
{
$r1=mysql_fetch_array($sql);
$file=$r1['filename'];
set_time_limit(0);
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
ini_set('max_allowed_packet','10000000000000000000000000');
ini_set('net_buffer_length','1000000000000000');
$excel=$file;

          header('Content-Description: File Transfer');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment; filename='.$excel);
          header('Content-Transfer-Encoding: binary');
          header('Expires: 0');
          header('Cache-Control: must-revalidate');
          header('Pragma: public');
          header('Content-Length: ' . filesize("logbackup/$excel"));
          ob_clean();
          flush();
          readfile("logbackup/$excel");
		 
}


else
{
//header("Location:dashboardsub.php?page=logdisplay&error=1");
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=logdisplay&error=1'";
echo "</script>";


}

}

?>