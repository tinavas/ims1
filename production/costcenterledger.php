<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
if($_GET['fromdate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
$costcenter = $_GET['costcenter'];
$currencyunits=$_SESSION['currency'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Cost Center Ledger</font></strong></td>
</tr>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Cost Center : </font><?php echo $costcenter; ?></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From : </font></strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To : </font></strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="templet.php?export=html&fromdate=<?php echo $fromdate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="templet.php?export=excel&fromdate=<?php echo $fromdate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="templet.php?export=word&fromdate=<?php echo $fromdate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="templet.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
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
	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Cr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Cr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Dr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Dr</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
 $query = "select distinct(coacode) from ac_financialpostings where date between '$fromdate' and '$todate' and coacode in (select code from ac_coa where costcentre = '$costcenter' and client = '$client') and amount > 0 order by coacode";
$result = mysql_query($query,$conn1);
while($rows = mysql_fetch_assoc($result))
{
 $coacode = $rows['coacode'];
 $query2 = "select sum(amount) as cramount from ac_financialpostings where date between '$fromdate' and '$todate' and crdr = 'Cr' and coacode = '$coacode'";
 $result2 = mysql_query($query2,$conn1);
 $rows2 = mysql_fetch_assoc($result2);
 $cramount = $rows2['cramount'];
 
 $query2 = "select sum(amount) as dramount from ac_financialpostings where date between '$fromdate' and '$todate' and crdr = 'Dr' and coacode = '$coacode'";
 $result2 = mysql_query($query2,$conn1);
 $rows2 = mysql_fetch_assoc($result2);
 $dramount = $rows2['dramount'];
 $diff = $cramount - $dramount;
 
 $q = "select description from ac_coa where code = '$coacode' and client = '$client'";
 $r = mysql_query($q,$conn1) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $desc = $rr['description'];
?>
	<tr>
		<td class="ewRptGrpField2"><a href="dummy.php?fromdate=<?php echo $_GET['fromdate']; ?>&todate=<?php echo $_GET['todate']; ?>&code=<?php echo $coacode; ?>&desc=<?php echo $desc; ?>" target="_blank" title="View Complete Details" style="color:0000FF;"><?php echo ewrpt_ViewValue($coacode); ?></a></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($desc) ?></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;">
<?php if ($diff >= 0) { echo ewrpt_ViewValue(changeprice($diff)); } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php if ($diff < 0) { echo ewrpt_ViewValue(changeprice(-$diff)); } else { echo ewrpt_ViewValue(); } ?></td>
	</tr>
<?php
}

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
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	document.location = "templet.php?fromdate=" + fdate;
}
</script>