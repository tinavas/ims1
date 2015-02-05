<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
$bank = $_GET['bank'];
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
{
 $query = "SELECT * from ac_definefy";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 $rows = mysql_fetch_assoc($result);
 $fromdate = $rows['fdate'];
} 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Bank Reconciliation Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
<?php
$query = "SELECT name FROM ac_bankmasters WHERE acno = '$bank' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);

?>
 <td colspan="2" align="center"><strong>Bank:</strong>&nbsp;&nbsp;<?php echo $rows['name']; ?></td>
</tr>
<tr>
 <td><strong>From : </strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
 <td><strong>To : </strong><?php echo date($datephp,strtotime($todate)); ?></td>  
</tr> 
</table>
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
&nbsp;&nbsp;<a href="bankreconciliation.php?export=html&bank=<?php echo $bank; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="bankreconciliation.php?export=excel&bank=<?php echo $bank; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="bankreconciliation.php?export=word&bank=<?php echo $bank; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="bankreconciliation.php?cmd=reset&bank=<?php echo $bank; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
	  $query = "SELECT code FROM ac_bankmasters WHERE mode = 'Bank' AND client = '$client' ORDER BY name";
	  $result = mysql_query($query,$conn1) or die(mysql_error());
	  while($rows = mysql_fetch_assoc($result))
	  {
	   ?>
	   <option value="<?php echo $rows['code']; ?>" title="<?php echo $rows['code']; ?>" <?php if($bank == $rows['code']) { ?> selected="selected" <?php } ?>><?php echo $rows['code']; ?></option>
	   <?php
	  }
	  ?>
</select>
</td>
 <td>From Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
</td>
 <td>To Date </td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
 
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
		<td valign="bottom" class="ewTableHeader" style="width:auto;">
		Cheque No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:auto;">Cheque No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:auto;">
		Reconciliation Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:auto;">Reconciliation Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Issued Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Issued Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Credit Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Credit Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Debit Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Debit Amount</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$cr = $dr = 0;
$query2 = "SELECT * FROM ac_recons WHERE bank = '$bank' AND client = '$client' AND chdate BETWEEN '$fromdate' AND '$todate' ORDER BY date ASC,chdate ASC";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_assoc($result2))
{
$cr += $rows2['cr'];
$dr += $rows2['dr'];
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows2['cheque']) ?></td>

		<td class="ewRptGrpField3" align="center">
<?php echo ewrpt_ViewValue(date($datephp,strtotime($rows2['chdate']))); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue(date($datephp,strtotime($rows2['date']))); ?>
		</td>
		<td class="ewRptGrpField4" align="right" style="padding-right:10px;">
<?php if($rows2['cr'] <> "0") { ?>		
<?php echo ewrpt_ViewValue(changeprice($rows2['cr'])) ?>
<?php } else { echo ewrpt_ViewValue("0.00");?>
<?php } ?></td>
		<td class="ewRptGrpField4" align="right" style="padding-right:10px;">
<?php if($rows2['dr'] <> "0") { ?>		
<?php echo ewrpt_ViewValue(changeprice($rows2['dr'])) ?>
<?php } else { echo ewrpt_ViewValue("0.00");?>
<?php } ?></td>

	</tr>
<?php
}
?>
 <tr>
   <td colspan="3" align="right" style="padding-right:10px;"><b>Sum</b></td>
   <td align="right" style="padding-right:10px"><b><?php echo changeprice($cr); ?></b></td>
   <td align="right" style="padding-right:10px"><b><?php echo changeprice($dr); ?></b></td>
  </tr>  
 
	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<?php } ?>
<?php } ?>
</td></tr></table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var bank = document.getElementById('bank').value;
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "bankreconciliation.php?bank=" + bank + "&fromdate=" + fdate + "&todate=" + tdate;
}
</script>
<?php

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


$cheque_amt = 8747484 ; 
try
    {
    echo convert_number($cheque_amt);
    }
catch(Exception $e)
    {
    echo $e->getMessage();
    }

function makecomma($input)
{
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

?>