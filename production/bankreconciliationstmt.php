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
$bank = $_GET['bank']; 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Bank Reconciliation Statement</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
<?php
$query = "SELECT name FROM ac_bankmasters WHERE code = '$bank' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);

?>
 <td colspan="2" align="center"><strong>Bank:</strong>&nbsp;&nbsp;<?php echo $rows['name']; ?></td>
</tr>
<tr>
 <td colspan="2" align="center"><strong>Date : </strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>  
</tr> 
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
&nbsp;&nbsp;<a href="bankreconciliationstmt.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&bank=<?php echo $_GET['bank']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="bankreconciliationstmt.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&bank=<?php echo $_GET['bank']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="bankreconciliationstmt.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&bank=<?php echo $_GET['bank']; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="bankreconciliationstmt.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&bank=<?php echo $_GET['bank']; ?>">Reset All Filters</a>
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
 <tr>
  <td>Bank </td>
  <td><select id="bank" name="bank" onchange="reloadpage();">
      <option value="">-Select</option>
      <?php
	  include "config.php";
	  $query = "SELECT distinct(code) AS acno,name FROM ac_bankmasters WHERE mode = 'Bank' AND client = '$client' ORDER BY name";
	  $result = mysql_query($query,$conn1) or die(mysql_error());
	  while($rows = mysql_fetch_assoc($result))
	  {
	   ?>
	   <option value="<?php echo $rows['acno']; ?>" title="<?php echo $rows['acno']; ?>" <?php if($bank == $rows['acno']) { ?> selected="selected" <?php } ?>><?php echo $rows['name']; ?></option>
	   <?php
	  }
	  ?>
</select>
</td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
</tr>
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
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Debit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Debit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Credit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Credit</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
	$q = "select * from ac_bankmasters where code = '$bank' ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	   $bankcode = $qr['code'];
	   $bankcoa = $qr['coacode'];
	   $acno = $qr['acno'];
	}
	$query = "SELECT SUM(amount) AS cramount FROM ac_financialpostings WHERE date <= '$todate' AND coacode = '$bankcoa' AND crdr = 'Cr'";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	$rows = mysql_fetch_assoc($result);
	$obcr = $rows['cramount'];

	$query = "SELECT SUM(amount) AS dramount FROM ac_financialpostings WHERE date <= '$todate' AND coacode = '$bankcoa' AND crdr = 'Dr'";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	$rows = mysql_fetch_assoc($result);
	$obdr = $rows['dramount'];

	$obbal = round(($obcr - $obdr),2);
	$obcrdr = "Cr";
	if($obbal < 0)
	{ $obcrdr = "Dr"; $obbal = -$obbal; }
	

	$trnums = "'dummy',";
	$query = "SELECT trnum FROM ac_recons WHERE date <= '$todate' AND bank = '$bankcode' ORDER BY id";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	 $trnums .= "'".$rows['trnum']."',";
	$trnums = substr($trnums,0,-1);
	$qa = "select SUM(amount) AS amount,crdr from ac_financialpostings where coacode = '$bankcoa' and date <= '$todate' AND trnum NOT IN ($trnums) GROUP BY crdr ORDER BY crdr";
	$resa = mysql_query($qa,$conn1) or die(mysql_error());
	while(($qra = mysql_fetch_assoc($resa)))
	{
	 if($qra['crdr'] == "Cr")
	  $uncredit = $qra['amount'];
	 elseif($qra['crdr'] == "Dr")
	  $undebit = $qra['amount'];
	}
	$bank = ($obcr + $undebit) - ($obdr + $uncredit);
	$bankcrdr = "Cr";
	if($bank < 0)
	{ $bankcrdr = "Dr"; $bank = -$bank; }
	
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("Balance as per Book") ?></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php if($obcrdr == "Dr") echo changeprice($obbal); else echo "&nbsp;"; ?></b></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php if($obcrdr == "Cr") echo changeprice($obbal); else echo "&nbsp;"; ?></b></td>
	</tr>
		<td class="ewRptGrpField2"><a href="bankunclearedstmt.php?todate=<?php echo $todate; ?>&crdr=Dr&bank=<?php echo $_GET['bank']; ?>" target="_blank" title="View Complete Details" style="color:0000FF;"><?php echo ewrpt_ViewValue("Unprocessed Deposits"); ?></a></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php echo "&nbsp;"; ?></b></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php echo changeprice($undebit); ?></b></td>
	</tr>
		<td class="ewRptGrpField2"><a href="bankunclearedstmt.php?todate=<?php echo $todate; ?>&crdr=Cr&bank=<?php echo $_GET['bank']; ?>" target="_blank" title="View Complete Details" style="color:0000FF;"><?php echo ewrpt_ViewValue("Unprocessed Withdrawls"); ?></a></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php echo changeprice($uncredit); ?></b></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php echo "&nbsp;"; ?></b></td>
	</tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("Balance as per Statement") ?></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php if($bankcrdr == "Dr") echo changeprice($bank); else echo "&nbsp;"; ?></b>
	 <input type = "hidden" id="orgdr" value="<?php if($bankcrdr == "Dr") echo $bank; else echo "&nbsp;"; ?>" style="text-align:right; background:none; border:none; font-weight:bold" onkeyup="calculate()" />
	 </td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"><b><?php if($bankcrdr == "Cr") echo changeprice($bank); else echo "&nbsp;"; ?></b> <input type = "hidden" id="orgcr" value="<?php if($bankcrdr == "Cr") echo $bank; else echo "&nbsp;"; ?>" style="text-align:right; background:none; border:none;font-weight: bold" onkeyup="calculate()" /></td>
	</tr>
<?php
}
?>
	</tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("Balance as per Bank Statement") ?></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;">
	 <input type = "text" id="dr" value="<?php if($bankcrdr == "Dr") echo $bank; else echo "0"; ?>" style="text-align:right" onkeyup="calculate()" <?php if($bankcrdr == "Cr") { ?> readonly <?php } ?> title="You can only enter either Debit or Credit" />
	 </td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"> <input type = "text" id="cr" value="<?php if($bankcrdr == "Cr") echo $bank; else echo "0"; ?>" style="text-align:right" onkeyup="calculate()" <?php if($bankcrdr == "Dr") { ?> readonly <?php } ?> title="You can only enter either Debit or Credit" /></td>
	</tr>
	</tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("Difference") ?></td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;">
	 <input type = "text" id="diffdr" value="0" style="text-align:right; background:none; border:none;font-weight: bold" />
	 </td>
	 <td class="ewRptGrpField2" align="right" style="padding-right:5px;"> <input type = "text" id="diffcr" value="0" style="text-align:right; background:none; border:none;font-weight: bold" /></td>
	</tr>

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
function calculate()
{
 if(document.getElementById('cr').value > 0)
 {
  document.getElementById('dr').value = 0;
  document.getElementById('dr').setAttribute("readonly");
 } 
 if(document.getElementById('dr').value > 0)
 {
  document.getElementById('cr').value = 0;
  document.getElementById('cr').setAttribute("readonly");
 } 
 if(document.getElementById('cr').value == "0" && document.getElementById('dr').value == "0" )
 {
  document.getElementById('cr').removeAttribute("readonly","readonly");
  document.getElementById('dr').removeAttribute("readonly","readonly");
 } 
 //if(document.getElementById('dr').value == "" || document.getElementById('dr').value == "0")
  //document.getElementById('cr').removeAttribute("readonly","readonly");
  
 var bal = (Number(document.getElementById('orgcr').value) - Number(document.getElementById('orgdr').value)) - (Number(document.getElementById('cr').value) - Number(document.getElementById('dr').value))
 var crdr = "Cr";
 bal = bal.toFixed(2);
 if(bal < 0)
 { bal = -bal; crdr = "Dr"; }
 if(crdr == "Cr")
 {
	document.getElementById('diffcr').value = bal;
	document.getElementById('diffdr').value = "";
 }
 else if(crdr == "Dr")
 {
	document.getElementById('diffdr').value = bal;
	document.getElementById('diffcr').value = "";
 }
}

function reloadpage()
{
		var bank = document.getElementById('bank').value;
	var tdate = document.getElementById('todate').value;
	document.location = "bankreconciliationstmt.php?bank=" + bank + "&todate=" + tdate;
}
</script>