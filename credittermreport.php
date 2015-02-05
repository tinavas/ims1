<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Credit Term Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<!--<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr>--> 
</table>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>

<?php
session_start();
$client = $_SESSION['client'];
?>
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
&nbsp;&nbsp;<a href="credittermreport.php?export=html&party=<?php echo $_GET[party]; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="credittermreport.php?export=excel&party=<?php echo $_GET[party]; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="credittermreport.php?export=word&party=<?php echo $_GET[party]; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="credittermreport.php?cmd=reset&party=<?php echo $_GET[party]; ?>">Reset All Filters</a>
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
<table>
<tr><td>Customer Name &nbsp;<select onchange="reloadpage(this.value)" id="party"><option value="">-select-</option>
<?php
		$query="select name from contactdetails where type like '%party%' order by name";
							$result1=mysql_query($query) or die(mysql_error());
							while($a=mysql_fetch_assoc($result1))
							{ 
							?>
							<option <?php if($a[name]==$_GET[party]) echo 'selected="selected"'; ?> value="<?php echo $a[name] ?>"><?php echo $a[name] ?></option>
							<?php 
							} ?> 

</select></td></tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Customer Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Customer Report</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Pending Transactions
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Pending Transactions</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Transaction Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction Amount</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Pending Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Pending Amount</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 
$query="select name,ca,va,type,cterm from contactdetails where type like '%party%' and name='".$_GET[party]."'";
							$result1=mysql_query($query) or die(mysql_error());
							while($a=mysql_fetch_assoc($result1))
							{ 
							if($a[type]=='party')
							 $coacode="'$a[ca]'";
							else if ($a[type]=='vendor') 
							$coacode="'$a[va]'";
							else 
							 $coacode="'$a[ca]','$a[va]'";
  
							$query="SELECT sum(amount) as Dramount FROM `ac_financialpostings` WHERE `venname` LIKE ".' "'.$a[name].'"'." and coacode in ($coacode) and crdr='Dr'";
					
							$result=mysql_query($query) or die( mysql_error()) ;
							$a1=mysql_fetch_assoc($result);
							$query="SELECT sum(amount) as Cramount FROM `ac_financialpostings` WHERE `venname`LIKE ".' "'.$a[name].'"'." and coacode in ($coacode) and crdr='Cr'";
		
							$result=mysql_query($query) or die(mysql_error()) ;
							$a2=mysql_fetch_assoc($result);
							
							$bal=$a1[Dramount]-$a2[Cramount];
							
							if ($bal > 0) { 
							$countofCT++;
							    $remaining=$bal;
								$trnum='';
								$date='';
		$q="SELECT date_add( date, INTERVAL $a[cterm] DAY ) AS ctdate,finaltotal as amount,invoice as trnum  FROM oc_cobi WHERE party LIKE ".' "'.$a[name].'"'." having ctdate<(select now() from dual) ORDER BY ctdate desc";
							 $r=mysql_query($q) or die(mysql_error());
							 while($array=mysql_fetch_assoc($r))
							 {
							  $date=$array[ctdate];
							  $trnum=$array[trnum];
							  $remaining-=$array[amount];
							  
							  if($remaining > 0)
							    $amount=$array[amount];
							  else
							    $amount =$array[amount]+($remaining);
							   ?> 
							  
							  <tr>
		<td class="ewRptGrpField2">
<?php if($a[name]!=$dupname) { echo $a[name]; $dupname=$a[name]; } else echo '&nbsp;'; ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($date); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($trnum); ?></td>
<td class="ewRptGrpField3" align="right">
<?php echo changeprice($array[amount]); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php if($remaining > 0) echo changeprice($amount);  else echo changeprice($amount); $totalamount+=$amount; ?></td>
	</tr>
							  <?php
							  if($remaining < 0)
							   break;
							 }		
							 // end of if cond of bal	
?>


    <tr>
		<td align="right" colspan="4" title="Total Pending Amount(As per Credit Term)"> Total Pending Amount(As per CT)</td>
		<td  align="right">
<?php echo changeprice($totalamount); ?></td>
	</tr>
	
	<tr>
		<td align="right" colspan="4"> Total Debited Amount</td>
		<td  align="right">
<?php echo changeprice($a1[Dramount]); ?></td>
	</tr>
	
	<tr>
		<td align="right" colspan="4"> Total Credited Amount</td>
		<td  align="right">
<?php echo changeprice($a2[Cramount]); ?></td>
	</tr>
	
	<tr>
		<td align="right" colspan="4"> Balance Amount Amount</td>
		<td  align="right">
<?php echo changeprice($bal); ?></td>
	</tr>
<?php }
}
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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage(value)
{
	document.location = "credittermreport.php?party=" + value ;
}
</script>