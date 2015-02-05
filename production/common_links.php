<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
//include "config.php"; 
session_start();
$client = $_GET['client'];
if($client == "")
{ 
 $client = $_SESSION['client'];
 $database = $_SESSION['db'];
}
?>

<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Links Report</font></strong></td>
</tr>
<tr> 
 <td colspan="2" align="center"><strong><font color="#3e3276">Client</font>&nbsp;&nbsp;<?php echo ucfirst($client); ?></strong></td>
</tr>
</table>

<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {
	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="common_links.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="common_links.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="common_links.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="common_links.php?cmd=reset">Reset All Filters</a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<center>
Select the Client
<select id="db" onchange="reloadpage(this.value)">
<?php
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "4(vQLs+#-b";

 $db_name = "users";

 $conn1=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

 $query = "SELECT * FROM bims ORDER BY client";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {
  ?>
  <option value="<?php echo $rows['client']; ?>" <?php if($rows['client'] == $client) { $database = $rows['db']; ?> selected="selected" <?php } ?>><?php echo $rows['client']; ?></option>
  <?php
 }

?>
</select>
</center>
</div>
<?php } ?>
<?php
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "4(vQLs+#-b";

 $db_name = $database;

//$client = $_SESSION['client'];

 $conn1=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Step-1
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Step-1</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Step-2
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Step-2</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Step-3
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Step-3</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Step-4
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Step-4</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Ref Id
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Ref Id</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sort Order
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sort Order</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Icon
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Icon</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Link
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Link</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Active
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Active</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php $result = "";
$q = "SELECT name FROM common_links WHERE step = 1 AND active = 1 AND client = '$client' ORDER BY sortorder";
$r = mysql_query($q,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($r))
{ $result .= $rows['name']." @ "; }
?>
<tr><td colspan="9"><font size="+1"><b><?php echo $result; ?></b></font></td></tr>
<?php
 
$query1 = "SELECT refid,name,sortorder,active,icon,link FROM common_links WHERE step = 1 AND client = '$client' AND active = 1 ORDER BY sortorder"; 
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
$num1 = mysql_num_rows($result1);
while($rows1 = mysql_fetch_assoc($result1))
{ $num2 = $num3 = $num4 = 0;
 $s1 = $rows1['name']." (".$rows1['refid'].")";
	//if($olds1 <> $s1)
	 $displays1 = $olds1 = $s1;
	//else
	 //$displays1 = "";
 
 $query2 = "SELECT refid,name,sortorder,active,icon,link FROM common_links WHERE step = 2 AND parentid = '$rows1[refid]' AND active = 1 AND client = '$client' ORDER BY sortorder";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $num2 = mysql_num_rows($result1);
 while($rows2 = mysql_fetch_assoc($result2))
 { $num3 = $num4 = 0;
  $s2 = $rows2['name']." (".$rows2['refid'].")";
	//if($olds2 <> $s2)
	 $displays2 = $olds2 = $s2;
	//else
	 //$displays2 = "";
  
  $query3 = "SELECT refid,name,sortorder,active,icon,link FROM common_links WHERE step = 3 AND parentid = '$rows2[refid]' AND active = 1 AND client = '$client' ORDER BY sortorder";
  $result3 = mysql_query($query3,$conn1) or die(mysql_error());
  $num3 = mysql_num_rows($result3);
  while($rows3 = mysql_fetch_assoc($result3))
  { $num4 = 0;
   $s3 = $rows3['name']." (".$rows3['refid'].")";
	//if($olds3 <> $s3)
	 $displays3 = $olds3 = $s3;
	//else
	 //$displays3 = "";
   
   $query4 = "SELECT refid,name,sortorder,active,icon,link FROM common_links WHERE step = 4 AND parentid = '$rows3[refid]' AND client = '$client' ORDER BY sortorder";
   $result4 = mysql_query($query4,$conn1) or die(mysql_error());
   $num4 = mysql_num_rows($result4);
   while($rows4 = mysql_fetch_assoc($result4))
   {
   
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displays1) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($displays2); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($displays3); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows4['name']) ?></td>
		<td class="ewRptGrpField3" align="center">
<?php echo ewrpt_ViewValue($rows4['refid']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows4['sortorder']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows4['icon']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows4['link']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows4['active']); ?></td>
	</tr>
<?php
    $displays1 = $displays2 = $displays3 = "";
   }  //end of rows4 
   if($num4 == 0 && $num3 > 0)
   {
    ?>
<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displays1) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($displays2); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($displays3); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
		<td class="ewRptGrpField3" align="center">
<?php echo ewrpt_ViewValue($rows3['refid']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows3['sortorder']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows3['icon']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows3['link']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows3['active']); ?></td>
	</tr>	
	<?php
	$displays1 = $displays2 = "";
   }
  }	 //end of rows3
   if($num3 == 0 && $num2 > 0)
   {
    ?>
<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displays1) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($displays2); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
		<td class="ewRptGrpField3" align="center">
<?php echo ewrpt_ViewValue($rows2['refid']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows2['sortorder']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows2['icon']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows2['link']); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows2['active']); ?></td>
	</tr>	
	<?php
	$displays1 = "";
   }
  
 }	//end of rows2
 if($num4 > 0) {
 ?><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><?php }
}	//end of rows1
?>
	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
</td></tr></table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<script type="text/javascript">
function reloadpage()
{
	var db = document.getElementById('db').value;
	document.location = "common_links.php?client=" + db;
}
</script>