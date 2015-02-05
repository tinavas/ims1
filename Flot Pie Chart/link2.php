<?php

$sExport = @$_GET["export"]; 
include "../production/reportheader.php"; 
 $date2=date("Y-m-d",strtotime(date("Y-m")));

	 $tdate = date("Y-m-d",strtotime($_GET['tdate']));
$fromdate=date("Y-m-d",strtotime($_GET['fdate']));
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "../production/phprptinc/ewrcfg3.php"; ?>
<?php include "../production/phprptinc/ewmysql.php"; ?>
<?php include "../production/phprptinc/ewrfn3.php"; ?>
<?php include "../production/phprptinc/header.php"; ?>
<center>
<table align="center" border="0" width="960px">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Assets & Liability Chart</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center"><strong><font color="#3e3276">From Date </font></strong><?php echo date("d.m.Y",strtotime($fromdate)); ?></td>

 <td align="center"><strong><font color="#3e3276">To Date </font></strong><?php echo date("d.m.Y",strtotime($tdate)); ?></td>
</tr> 
</table>
</center>
 <p ><iframe src="expenseandrevenue2.php?fdate=<?php echo $fromdate;  ?>&tdate=<?php echo $tdate; ?>" align="right" height="700" width="600"  frameborder="0"  ></iframe>
      <iframe src="expenseandrevenue3.php?fdate=<?php echo $fromdate;  ?>&tdate=<?php echo $tdate; ?>" align="right" height="700" width="600"  frameborder="0"  ></iframe></p>