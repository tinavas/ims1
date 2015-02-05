<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<?php 
session_start();$currencyunits=$_SESSION['currency'];
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

if($currencyunits == "")
{
$currencyunits = "Rs";

	if($_SESSION[db] == "alkhumasiyabrd")
	{
	$currencyunits = "SR";
	}
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Cash Flow Statement</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td colspan="2" align="center"><strong>From : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong>To : </strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
</tr> 
</table>
<br/>
<?php if($_SESSION['client'] == 'KEHINDE')
{
?>
<center><p style="padding-left:430px;color:red"> All amounts in ?</p></center>

<?php 
}
else
{
?>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $currencyunits;?></p></center>
<?php } ?>
<br/>
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
&nbsp;&nbsp;<a href="cashflow.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="cashflow.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="cashflow.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="cashflow.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		In Flow
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">In Flow</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Out Flow
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Out Flow</td>
			</tr></table>
		</td>
<?php } ?>

	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Schedule
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Schedule</td>
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
		Schedule
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Schedule</td>
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
	<tr>
<?php
$obcredit = $obdebit = 0;
 $query1 = "SELECT SUM(amount) as amount,crdr FROM ac_financialpostings WHERE (cashcode IN (SELECT coacode from ac_bankmasters where mode = 'Cash') or bankcode IN (SELECT coacode from ac_bankmasters where mode = 'Bank')) AND client = '$client' AND date < '$fromdate' GROUP BY crdr ORDER BY crdr";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 while($rows1 = mysql_fetch_assoc($result1))
 {
  if($rows1['crdr'] == 'Cr')
   $obcredit = $rows1['amount'];
  elseif($rows1['crdr'] == 'Dr')
    $obdebit = $rows1['amount'];
 }
?>	<tr>
		<td class="ewRptGrpField2" colspan="3" align="right"><b>Opening Balance</b></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;"><b>
<?php echo ewrpt_ViewValue(changeprice(($obcredit - $obdebit))); ?></b></td>
	</tr>
	
<?php 
$l = $r = -1; $totalcredit = $totaldebit = 0;
$query1 = "SELECT distinct(schedule) FROM ac_coa WHERE client = '$client' ORDER BY schedule";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{ 
 $cramount = $dramount = 0; $displaycrdr = "";
 $query2 = "SELECT SUM(amount) as amount,crdr FROM ac_financialpostings WHERE (cash ='YES' or bank ='YES') AND client = '$client' AND schedule = '$rows1[schedule]' AND date BETWEEN '$fromdate' AND '$todate'and coacode NOT IN (SELECT code FROM ac_coa WHERE controltype IN ('Cash','Bank') and client = '$client') GROUP BY crdr ORDER BY crdr";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  if($rows2['crdr'] == 'Cr' && $rows2['amount'] > 0)
  { $l++;
   $totalcredit += $creditarray[$l] = $rows2['amount'];
   $creditdesc[$l] = $rows1['schedule'];
  }
  elseif($rows2['crdr'] == 'Dr' && $rows2['amount'] > 0)
  { $r++;
   $totaldebit += $debitarray[$r] = $rows2['amount'];
   $debitdesc[$r] = $rows1['schedule'];
  } 
 }
}
if($l>$r) $max = $l;
else $max = $r;
for($i = 0; $i<=$max; $i++)
{
?>
	<tr>
		<td class="ewRptGrpField2"><!--<?php if($creditdesc[$i] <> "") { ?><a href="cashflowdetail.php?schedule=<?php echo $creditdesc[$i]; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&coacode=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cashbank=<?php echo $cashbank; ?>" target="_blank" title="View Complete Details" style="color:0000FF;">--><?php echo ewrpt_ViewValue($creditdesc[$i]); ?><!--</a><?php } else { ?>-->&nbsp;<!--<?php } ?>--></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;">
<?php if($creditarray[$i] <> "") { echo ewrpt_ViewValue(changeprice($creditarray[$i])); } else { echo ewrpt_ViewValue(); } ?></td>

		<td class="ewRptGrpField2"><!--<?php if($debitdesc[$i] <> "") { ?><a href="cashflowdetail.php?schedule=<?php echo $debitdesc[$i]; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&coacode=<?php echo $code; ?>&desc=<?php echo $desc; ?>&cashbank=<?php echo $cashbank; ?>" target="_blank" title="View Complete Details" style="color:0000FF;">--><?php echo ewrpt_ViewValue($debitdesc[$i]); ?><!--</a><?php } else {?>-->&nbsp;<!--<?php } ?>--></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;">
<?php if($debitarray[$i] <> "") { echo ewrpt_ViewValue(changeprice($debitarray[$i])); } else { echo ewrpt_ViewValue(); } ?></td>
	</tr>
<?php
}
?>
	<tr>
	 <td align="right" style="padding-right:5px;"><b>Total</b></td>
	 <td align="right" style="padding-right:5px;"><b><?php echo changeprice(($totalcredit)); ?></b></td>
	 <td align="right" style="padding-right:5px;"><b>Total</b></td>
	 <td align="right" style="padding-right:5px;"><b><?php echo changeprice(($totaldebit)); ?></b></td>
	</tr> 
	<tr>
		<td class="ewRptGrpField2" colspan="3" align="right"><b>Outstanding Balance</b></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;"><b>
<?php echo ewrpt_ViewValue(changeprice(($obcredit - $obdebit + $totalcredit - $totaldebit))); ?></b></td>
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
	document.location = "cashflow.php?fromdate=" + fdate;
}
</script>