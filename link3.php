<?php
$sExport = @$_GET["export"]; 
include "/production/reportheader.php"; 
 $date2=date("Y-m-d",strtotime(date("Y-m")));
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "/production/phprptinc/ewrcfg3.php"; ?>
<?php include "/production/phprptinc/ewmysql.php"; ?>
<?php include "/production/phprptinc/ewrfn3.php"; ?>
<?php include "/production/phprptinc/header.php"; ?>
<center>
<table align="center" border="0" width="960px">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Inventories</font></strong></td>
</tr>
<tr height="5px"></tr>
</table>
</center>
<link href="layout.css" rel="stylesheet" type="text/css"></link>
      <link href="css/common.css" rel="stylesheet" type="text/css">
	  <link href="css/standard.css" rel="stylesheet" type="text/css">
<iframe src="Flot Pie Chart/drawinventorylevel1.php" align="right" height="600" width="1300"  frameborder="0"  ></iframe>