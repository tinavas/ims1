<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
$ven = $_GET['vendor'];

if($_GET['vendor'] == "All")
{
//$ven = $_GET['vendor'];
$cond1="";
$cond2="";
$cond3="";
}
else if($_GET['vendor'] <> "")
{
$ven = $_GET['vendor'];
$cond1=" and name = '$ven'";
$cond2=" and venname = '$ven'";
$cond3=" and name = '$ven'";
}

else
{
$ven="";
$cond1="and (type = '$type' or type = 'vendor and party') order by name";
//$cond1=" and name = '$//ven'";
}

if($_GET['type']=="vendor")
{
$cond5=" and type = 'vendor' or type = 'vendor and party'";
}
else
{
$cond5=" and type = 'party' or type = 'vendor and party'";
}
 $quer1 = "select * from contactdetails where client = '$client' $cond1 $cond5   ";
	$quers1 = mysql_query($quer1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{ 
	  if ( ($row11['type'] == "vendor") or ($row11['type'] == "vendor and party") )
	  {
	    $vflag = 1;
	  }
	  if ( ($row11['type'] == "party") or ($row11['type'] == "vendor and party") )
	  {
	    $cflag = 1;
	  }
	  $ca = $row11['ca'];
	  $cac = $row11['cac'];
	  $va = $row11['va'];
	  $vppac = $row11['vppac'];
	  $cterm = $row11['cterm'];
	  $climit = $row11['climit'];
	
	  $active = $row11['hold'];
	}
	
	//echo $cflag."aa";
	//echo $vflag."vv";
	
	if($_GET['type']=="party")
	{
	$vflag=0;
	$cflag=1;
	}
	if($_GET['type']=="vendor")
	{
	$cflag=0;
	$vflag=1;
	}

$url = "&todate=" . $_GET['todate']."&vendor=" . $_GET['vendor']."&type=" . $_GET['type'];
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Ageing Analysis</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276"><?php if($vflag == 1) echo "Supplier"; else echo "Customer"; ?> Name&nbsp;</font></strong><?php echo $ven; ?></td>
</tr>
<tr height="5px"></tr>
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276">Credit Term&nbsp;</font></strong><?php echo $cterm; ?> Days&nbsp; &nbsp;<strong><font color="#3e3276">Credit Limit&nbsp;</font></strong><?php echo changeprice1($climit); ?></td>
</tr>
<?php if($vflag == 0) { ?>
<tr height="5px"></tr>
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276">Account Type&nbsp;</font></strong><?php if($active == 1) echo "Open"; else echo "Closed"; ?></td>
</tr>
<?php } ?>
<tr height="5px"></tr>
<tr>
 <td align="center"><strong><font color="#3e3276">Till Date </font></strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
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
<table align="center" id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="vendorageingall.php?export=html&todate=<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="vendorageingall.php?export=excel&todate=<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="vendorageingall.php?export=word&todate=<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="vendorageingall.php?cmd=reset&fromdate=<?php echo $url; ?>">Reset All Filters</a>
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
 <td>Till Date</td>
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
		<td valign="bottom" class="ewTableHeader">
		Supplier Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Supplier Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		0 To 30 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>0 To 30 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		31 To 60 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>31 To 60 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		61 To 90 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>61 To 90 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		91 To 120 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>91 To 120 Days</td>
			</tr></table>
		</td>
<?php } ?>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		121 To 150 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>121 To 150 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		151 To 180 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>151 To 180 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		181 Days And More
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>181 Days And More</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Grand Total
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Grand Total</td>
			</tr></table>
		</td>
<?php } ?>
</tr>

	</thead>
	<tbody>
<?php
if($cflag == 1)
{
 
  $q1="Select distinct(name) from contactdetails where ( type ='vendor and party' or type='party' ) $cond3 order by name";
$r1=mysql_query($q1);
while($qr111=mysql_fetch_array($r1))
{
	$ven = $qr111['name'];
	
	 $q2="select ca from contactdetails where ( type ='vendor and party' or type='party') and name='$ven' ";
	
	$r2=mysql_query($q2);
$qr112=mysql_fetch_array($r2);
	
	 $ca=$qr112['ca'];
	$sumbal = 0;
$dup = 0;
$nubal = 0;
		$thbal = 0;
		$sibal = 0;
		$nibal = 0;
		$twbal = 0;
		$fibal = 0;
		$eibal = 0;
		
	$amountpaid = 0;	
	 $query = "SELECT SUM(amount) AS amountreceived FROM ac_financialpostings WHERE date <= '$todate' AND venname = '$ven' AND crdr = 'Cr' AND coacode = '$ca'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
 $amountpaid  = $rows['amountreceived'];
	
	
	
	 $q = "select date,amount as grandtotal,trnum from ac_financialpostings where venname = '$ven' and date <= '$todate' AND crdr = 'Dr' AND coacode = '$ca'   order by date   ";
	$qrs = mysql_query($q,$conn1) ;
	while($qr = mysql_fetch_assoc($qrs))
	{
$balamt = 0;
$grandtotal=0;
 $grandtotal=$qr['grandtotal'];

if($amountpaid>0)
 $balamt = $grandtotal - $amountpaid;
 else
 $balamt = $grandtotal;
 


	if($amountpaid>0)
	$amountpaid=$amountpaid-$qr['grandtotal'];

	  $diffdays = 0;
	  if ( $balamt > 0 )
	  {
	 
		 $dumdate = strtotime($qr['date']);
		$dumdate1 = strtotime($todate);
		$difsecs = $dumdate1 - $dumdate;
		 $difdays = abs(round(($difsecs/(60 * 60 * 24)),0)); 
		 
		
		 
?>
  
<?php if ($difdays < 31) { $sumbal = $sumbal + $balamt;  $nubal = $nubal + $balamt; $nutotal = $nutotal + $balamt; }
 if (($difdays > 30) and ($difdays < 61))  {   $sumbal = $sumbal + $balamt; $thbal = $thbal + $balamt; $thtotal = $thtotal + $balamt; }
 if (($difdays > 60) and ($difdays < 91))  {  $sumbal = $sumbal + $balamt; $sibal = $sibal + $balamt; $sitotal = $sitotal + $balamt;  }
 if (($difdays > 90) and ($difdays < 121))  {  $sumbal = $sumbal + $balamt; $nibal = $nibal + $balamt; $nitotal = $nitotal + $balamt; }
  if (($difdays > 120) and ($difdays < 151))  { $sumbal = $sumbal + $balamt; $twbal = $twbal + $balamt; $twtotal = $twtotal + $balamt; }
  if (($difdays > 150) and ($difdays < 181))  {  $sumbal = $sumbal + $balamt; $fibal = $fibal + $balamt; $fitotal = $fitotal + $balamt; }
 if ($difdays > 180)   {  $sumbal = $sumbal + $balamt; $eibal = $eibal + $balamt; $eitotal = $eitotal + $balamt; }
 
	 }
	
	 }
	 

 
 
	   ?>
	   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue($ven) ?>
		</td>
		
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nubal)); $c1+=$nubal; 
 ?>
</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($thbal)); $c2+=$thbal; ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sibal)); $c3+=$sibal; ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nibal)); $c4+=$nibal;?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($twbal));  $c5+=$twbal;?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($fibal));  $c6+=$fibal;?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($eibal)); $c7+=$eibal;?>
</td>

<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal )); $grandtot = $grandtot + $sumbal;   ?>
</td>

	</tr>
	 
<?php }	 
?>
<tr style="font-weight:bold;">
<td><strong>Total</strong></td>
	<td align="right">
<?php echo ewrpt_ViewValue(changeprice($c1));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($c2));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($c3));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($c4));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($c5));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($c6));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($c7));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($grandtot));  
 ?>
</td>
</tr>
<?php

} // End detail records loop
?>

<?php
if($vflag == 1)
{
 $q1="Select name,va from contactdetails where ( type ='vendor and party' or type='vendor' )  $cond3";
$r1=mysql_query($q1);
while($qr111=mysql_fetch_array($r1))
{
	$ven = $qr111['name'];
	$va = $qr111['va'];
	$sumbal = 0;
$dup = 0;
$nubal = 0;
		$thbal = 0;
		$sibal = 0;
		$nibal = 0;
		$twbal = 0;
		$fibal = 0;
		$eibal = 0;
		
		
		
		$amountpaid = 0;	
	 $query = "SELECT SUM(amount) AS amountreceived FROM ac_financialpostings WHERE date <= '$todate' AND venname = '$ven' AND crdr = 'Dr' AND coacode = '$va'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
 $amountpaid  = $rows['amountreceived'];
	
	
	
	 $q = "select date,amount as grandtotal,trnum from ac_financialpostings where venname = '$ven' and date <= '$todate' AND crdr = 'Cr' AND coacode = '$va'   order by date   ";
	$qrs = mysql_query($q,$conn1) ;
	while($qr = mysql_fetch_assoc($qrs))
	{
$balamt = 0;
$grandtotal=0;
 $grandtotal=$qr['grandtotal'];

if($amountpaid>0)
 $balamt = $grandtotal - $amountpaid;
 else
 $balamt = $grandtotal;
 


	if($amountpaid>0)
	$amountpaid=$amountpaid-$qr['grandtotal'];

	  $diffdays = 0;
	  if ( $balamt > 0 )
		
		

	  {
	  
	   $dumdate = strtotime($qr['date']);
		$dumdate1 = strtotime($todate);
		$difsecs = $dumdate1 - $dumdate;
		 $difdays = round(($difsecs/(60 * 60 * 24)),0); 
?>
  
<?php if ($difdays < 31) { $sumbal = $sumbal + $balamt;  $nubal = $nubal + $balamt; $nutotal = $nutotal + $balamt; }
 if (($difdays > 30) and ($difdays < 61))  {   $sumbal = $sumbal + $balamt; $thbal = $thbal + $balamt; $thtotal = $thtotal + $balamt; }
 if (($difdays > 60) and ($difdays < 91))  {  $sumbal = $sumbal + $balamt; $sibal = $sibal + $balamt; $sitotal = $sitotal + $balamt;  }
 if (($difdays > 90) and ($difdays < 121))  {  $sumbal = $sumbal + $balamt; $nibal = $nibal + $balamt; $nitotal = $nitotal + $balamt; }
  if (($difdays > 120) and ($difdays < 151))  { $sumbal = $sumbal + $balamt; $twbal = $twbal + $balamt; $twtotal = $twtotal + $balamt; }
  if (($difdays > 150) and ($difdays < 181))  {  $sumbal = $sumbal + $balamt; $fibal = $fibal + $balamt; $fitotal = $fitotal + $balamt; }
 if ($difdays > 180)   {  $sumbal = $sumbal + $balamt; $eibal = $eibal + $balamt; $eitotal = $eitotal + $balamt; }
 
	 }
	 }
	 $onacpay = 0;
	 $quer1 = "select sum(amountpaid) as opmt from pp_payment where choice = 'On A/C' and vendor = '$ven' and adate <= '$todate' ";
	$quers1 = mysql_query($quer1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{
	  $onacpay = $row11['opmt'];
	} 
	   ?>
	   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue($ven) ?>
		</td>
		
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nubal)); $v1+=$nubal;
 ?>
</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($thbal));  $v2+=$thbal;?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sibal));  $v3+=$sibal;?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nibal)); $v4+=$nibal; ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($twbal));  $v5+=$twbal;?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($fibal));  $v6+=$fibal;?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($eibal)); $v7+=$eibal;?>
</td>

<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal)); $grandtot = $grandtot + $sumbal;  ?>
</td>

	</tr>
	 
<?php }
?>
<tr style="font-weight:bold;">
<td><strong>Total</strong></td>
	<td align="right">
<?php echo ewrpt_ViewValue(changeprice($v1));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($v2));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($v3));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($v4));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($v5));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($v6));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($v7));  
 ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($grandtot));  
 ?>
</td>
</tr>
<?php
	 } // End detail records loop
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
	var fromdate = document.getElementById('todate').value;
	var todate = document.getElementById('todate').value;
	var type="<?php echo $_GET['type'];?>";
	
	document.location = "vendorageingall.php?fromdate="+fromdate+"&todate=" + todate+"&type="+type;
}
</script>