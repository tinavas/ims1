<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
$schedule = $_GET['schedule'];

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Cash Flow Statement</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td colspan="2" align="center"><strong>Schedule : </strong><?php echo $_GET['schedule']; ?></td>
</tr> 
<tr height="5px"></tr>
<tr>
 <td colspan="2" align="center"><strong>From : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong>To : </strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
</tr> 
</table>

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
&nbsp;&nbsp;<a href="cashflowdetail.php?export=html&schedule=<?php echo $schedule; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&coacode=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cashbank=<?php echo $cashbank; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="cashflowdetail.php?export=excel&schedule=<?php echo $schedule; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&coacode=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cashbank=<?php echo $cashbank; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="cashflowdetail.php?export=word&schedule=<?php echo $schedule; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&coacode=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cashbank=<?php echo $cashbank; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="cashflowdetail.php?cmd=reset&schedule=<?php echo $schedule; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&coacode=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cashbank=<?php echo $cashbank; ?>">Reset All Filters</a>
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
<div class="ewGridUpperPanel"></div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="3" align="center">
		In Flow
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="3" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">In Flow</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="3" align="center">
		Out Flow
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="3" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Out Flow</td>
			</tr></table>
		</td>
<?php } ?>

	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
$l = $r = -1; 
$totalcredit = $totaldebit = 0;
  $query3 = "SELECT sum(amount) as amount,cashcode FROM ac_financialpostings WHERE cash = 'YES' and crdr = 'Cr' AND schedule = '$schedule' AND date BETWEEN '$fromdate' AND '$todate' GROUP BY cashcode";
   $result3 = mysql_query($query3,$conn1) or die(mysql_error());
   while($rows3 = mysql_fetch_assoc($result3))
   { $l++;
     $totalcredit += $creditarray[$l] = $rows3['amount'];
    $creditdesc[$l] = $rows3['cashcode'];
   } 
  $query3 = "SELECT sum(amount) as amount,bankcode FROM ac_financialpostings WHERE bank = 'YES' and crdr = 'Cr' AND schedule = '$schedule' AND date BETWEEN '$fromdate' AND '$todate' GROUP BY bankcode";
   $result3 = mysql_query($query3,$conn1) or die(mysql_error());
   while($rows3 = mysql_fetch_assoc($result3))
   { $l++;
    $totalcredit += $creditarray[$l] = $rows3['amount'];
    $creditdesc[$l] = $rows3['bankcode'];
   } 
  $query3 = "SELECT sum(amount) as amount,cashcode FROM ac_financialpostings WHERE cash = 'YES' and crdr = 'Dr' AND schedule = '$schedule' AND date BETWEEN '$fromdate' AND '$todate' GROUP BY cashcode";
   $result3 = mysql_query($query3,$conn1) or die(mysql_error());
   while($rows3 = mysql_fetch_assoc($result3))
   { $r++;
    $totaldebit += $debitarray[$r] = $rows3['amount'];
    $debitdesc[$r] = $rows3['cashcode'];
   } 
 $query3 = "SELECT sum(amount) as amount,bankcode FROM ac_financialpostings WHERE bank = 'YES' and crdr = 'Dr' AND schedule = '$schedule' AND date BETWEEN '$fromdate' AND '$todate' GROUP BY bankcode";
   $result3 = mysql_query($query3,$conn1) or die(mysql_error());
   while($rows3 = mysql_fetch_assoc($result3))
   { $r++;
    $totaldebit += $debitarray[$r] = $rows3['amount'];
    $debitdesc[$r] = $rows3['bankcode'];
   } 

if($l>$r) $max = $l;
else $max = $r;
for($i = 0; $i<=$max; $i++)
{
?>
	<tr>
	<?php
		$q = "SELECT description FROM ac_coa WHERE code = '$creditdesc[$i]' AND client = '$client'";
		$r = mysql_query($q,$conn1) or die(mysql_error());
		$rr = mysql_fetch_assoc($r);
		?>
		<td class="ewRptGrpField3"><?php echo ewrpt_ViewValue($creditdesc[$i]); ?></a></td>
		<td class="ewRptGrpField2"><?php echo ewrpt_ViewValue($rr['description']) ?></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;">
<?php if($creditarray[$i] <> "") { echo ewrpt_ViewValue(changeprice($creditarray[$i])); } else { echo ewrpt_ViewValue(); } ?></td>
		
		<?php
		$q = "SELECT description FROM ac_coa WHERE code = '$debitdesc[$i]' AND client = '$client'";
		$r = mysql_query($q,$conn1) or die(mysql_error());
		$rr = mysql_fetch_assoc($r);
		?>
		<td class="ewRptGrpField3"><?php echo ewrpt_ViewValue($debitdesc[$i]); ?></a></td>
		<td class="ewRptGrpField2"><?php echo ewrpt_ViewValue($rr['description']) ?></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;">
<?php if($debitarray[$i] <> "") { echo ewrpt_ViewValue(changeprice($debitarray[$i])); } else { echo ewrpt_ViewValue(); } ?></td>
	</tr>
<?php
}
?>
	<tr>
	 <td colspan="2" align="right" style="padding-right:5px;"><b>Total</b></td>
	 <td align="right" style="padding-right:5px;"><b><?php echo changeprice($totalcredit); ?></b></td>
	 <td colspan="2" align="right" style="padding-right:5px;"><b>Total</b></td>
	 <td align="right" style="padding-right:5px;"><b><?php echo changeprice($totaldebit); ?></b></td>
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
<?php } ?>
<?php include "phprptinc/footer.php"; 

function makecomma($input)
{
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

function changeprice($num){
$pos = strpos((string)$num, ".");
if ($pos === false) { $decimalpart="00";}
else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

if(strlen($num)>3 & strlen($num) <= 12){
$last3digits = substr($num, -3 );
$numexceptlastdigits = substr($num, 0, -3 );
$formatted = makecomma($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
}elseif(strlen($num)<=3){
$stringtoreturn = $num.".".$decimalpart ;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 2);
}

if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}
$a  = explode('.',$stringtoreturn);
$c = "";
if(strlen($a[1]) < 2) { $c = "0"; }
$stringtoreturn = $stringtoreturn.$c;
return $stringtoreturn;
}

?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	document.location = "cashflowdetail.php?fromdate=" + fdate;
}
</script>