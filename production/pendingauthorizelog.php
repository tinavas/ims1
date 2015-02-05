<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php";
include "config.php";
$cond = ""; 
$otype = $type = $_GET['type'];
if($type <> "All")
 $cond .= " and type = '$type'";

if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
if($type == "COBI") $dtype = "Sales";
elseif($type == "SOBI") $dtype = "Purchases";
elseif($type == "PMT") $dtype = "Payments";
elseif($type == "RCT") $dtype = "Receipts";
elseif($type == "PV") $dtype = "Payment Vouchers";
elseif($type == "RV") $dtype = "Receipt Vouchers";
elseif($type == "JV") $dtype = "Journal Vouchers";
else $dtype = "All";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Pending Authorization Records</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center" colspan="2"><strong><font color="#3e3276">Type :</font></strong><?php echo $dtype; ?></td>
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
&nbsp;&nbsp;<a href="pendingauthorizelog.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="pendingauthorizelog.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="pendingauthorizelog.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="pendingauthorizelog.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Reset All Filters</a>
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
 <td>Type</td>
 <td>
   <select id="section" name="section" onchange="reloadpage();">
   <option value="">-Select-</option>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',SOBI,COBI,PMT,RCT,PV,RV,JV,' ))>0 ) { ?><option value="All" <?php if($type == "All") { ?> selected="selected" <?php } ?>>All</option><?php } ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',JV,' ))>0 ) { ?><option value="JV" <?php if($type == "JV") { ?> selected="selected" <?php } ?>>Journal Voucher</option><?php } ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',PMT,' ))>0 ) { ?><option value="PMT" <?php if($type == "PMT") { ?> selected="selected" <?php } ?>>Payment</option><?php } ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',PV,' ))>0 ) { ?><option value="PV" <?php if($type == "PV") { ?> selected="selected" <?php } ?>>Payment Voucher</option><?php } ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',SOBI,' ))>0 ) { ?><option value="SOBI" <?php if($type == "SOBI") { ?> selected="selected" <?php } ?>>Purchases</option><?php } ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',RCT,' ))>0 ) { ?><option value="RCT" <?php if($type == "RCT") { ?> selected="selected" <?php } ?>>Receipt</option><?php } ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',RV,' ))>0 ) { ?><option value="RV" <?php if($type == "RV") { ?> selected="selected" <?php } ?>>Receipt Voucher</option><?php } ?>
<?php if ( strlen(strstr(','.$_SESSION['authorizesectors'],',COBI,' ))>0 ) { ?><option value="COBI" <?php if($type == "COBI") { ?> selected="selected" <?php } ?>>Sales</option><?php } ?>
   </select>
 </td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if($type == "All") { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Type</td>
			</tr></table>
		</td>
<?php } }?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Transaction Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Transaction No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Details
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Details</td>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php

if($type == "COBI" or $type == "All")
{ $i = 0; $pdate = "";
 $query2 = "SELECT distinct(invoice),party,finaltotal,date FROM oc_cobi WHERE flag = 0 ORDER BY date";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $invoice = $rows2['invoice'];
  $itemcode = "";
  $date = date("d.m.Y",strtotime($rows2['date']));
  $query3 = "SELECT code FROM oc_cobi WHERE invoice = '$invoice'";
  $result3 = mysql_query($query3,$conn1) or die(mysql_error());
  while($rows3 = mysql_fetch_assoc($result3))
   $itemcode .= $rows3['code']."/";
  $itemcode = substr($itemcode,0,-1);

?>
	<tr>
<?php if($type == "All") { ?>
		<td class="ewRptGrpField1">
<?php if($i == 0) { echo ewrpt_ViewValue("Sales"); } else { echo ewrpt_ViewValue(); }  ?></td>
<?php } ?>
		<td class="ewRptGrpField3">
<?php if($date <> $pdate) { echo ewrpt_ViewValue($date); } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($invoice) ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows2['party']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($itemcode) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows2['finaltotal'])); ?></td>
	</tr>
<?php
  $i  = 1;
  $pdate = $date; 
 }
}
if($type == "SOBI" or $type == "All")
{ $i = 0; $pdate = "";
 $query2 = "SELECT distinct(so),vendor,orgamount as grandtotal,date FROM pp_sobi WHERE flag = 0 ORDER BY date";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $invoice = $rows2['so'];
  $itemcode = "";
  $date = date("d.m.Y",strtotime($rows2['date']));
  $query3 = "SELECT code FROM pp_sobi WHERE so = '$invoice'";
  $result3 = mysql_query($query3,$conn1) or die(mysql_error());
  while($rows3 = mysql_fetch_assoc($result3))
   $itemcode .= $rows3['code']."/";
  $itemcode = substr($itemcode,0,-1);

?>
	<tr>
<?php if($type == "All") { ?>
		<td class="ewRptGrpField1">
<?php if($i == 0) { echo ewrpt_ViewValue("Purchases"); } else { echo ewrpt_ViewValue(); }  ?></td>
<?php } ?>
		<td class="ewRptGrpField3">
<?php if($date <> $pdate) { echo ewrpt_ViewValue($date); } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($invoice) ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows2['vendor']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($itemcode) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows2['grandtotal'])); ?></td>
	</tr>
<?php 
  $i  = 1;
  $pdate = $date; 
 }
} 
if($type == "PMT" or $type == "All")
{ $i = 0; $pdate = "";
 $query2 = "SELECT distinct(tid),vendor,(totalamount/camount) as grandtotal,date,code1 FROM pp_payment WHERE flag = 0 ORDER BY date";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $invoice = $rows2['tid'];
  $itemcode = "";
  $date = date("d.m.Y",strtotime($rows2['date']));
?>
	<tr>
<?php if($type == "All") { ?>
		<td class="ewRptGrpField1">
<?php if($i == 0) { echo ewrpt_ViewValue("Payments"); } else { echo ewrpt_ViewValue(); }  ?></td>
<?php } ?>
		<td class="ewRptGrpField3">
<?php if($date <> $pdate) { echo ewrpt_ViewValue($date); } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($invoice) ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows2['vendor']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows2['code1']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows2['grandtotal'])); ?></td>
	</tr>
<?php
  $i  = 1;
  $pdate = $date;  
 } 
}
if($type == "RCT" or $type == "All")
{  $i = 0; $pdate = "";
  $query2 = "SELECT distinct(tid),party,totalamount as grandtotal,date,code1 FROM oc_receipt WHERE flag = 0 ORDER BY date";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $invoice = $rows2['tid'];
  $itemcode = "";
?>
	<tr>
<?php if($type == "All") { ?>
		<td class="ewRptGrpField1">
<?php if($i == 0) { echo ewrpt_ViewValue("Receipts"); } else { echo ewrpt_ViewValue(); }  ?></td>
<?php } ?>
		<td class="ewRptGrpField3">
<?php if($date <> $pdate) { echo ewrpt_ViewValue($date); } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($invoice) ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows2['party']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows2['code1']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows2['grandtotal'])); ?></td>
	</tr>
<?php
  $i  = 1;
  $pdate = $date;  
 } 
}
if($type == "PV" or $type == "RV" or $type == "JV")
{ $i = 0;  $pdate = "";
 $voucher = substr($type,0,1);
 if($voucher == "P") $dtype = "Payment Voucher";
 elseif($voucher == "R") $dtype = "Receipt Voucher";
 else $dtype = "Journal Voucher";

 $query2 = "SELECT distinct(transactioncode) as tid,bccodeno,crtotal as grandtotal,date FROM ac_gl WHERE vstatus = 'U' and voucher = '$voucher' ORDER by date,id";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $invoice = $rows2['tid'];
  $itemcode = "";
  $query3 = "SELECT code FROM ac_gl WHERE transactioncode = '$invoice' and voucher = '$voucher' ORDER BY id LIMIT 1,10";
  $result3 = mysql_query($query3,$conn1) or die(mysql_error());
  while($rows3 = mysql_fetch_assoc($result3))
   $itemcode .= $rows3['code']."/";
  $itemcode = substr($itemcode,0,-1);

?>
	<tr>
<?php if($type == "All") { ?>
		<td class="ewRptGrpField1">
<?php if($i == 0) { echo ewrpt_ViewValue($dtype); } else { echo ewrpt_ViewValue(); }  ?></td>
<?php } ?>
		<td class="ewRptGrpField3">
<?php if($date <> $pdate) { echo ewrpt_ViewValue($date); } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($invoice) ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows2['bccodeno']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($itemcode) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows2['grandtotal'])); ?></td>
	</tr>
<?php
  $i  = 1;
  $pdate = $date; 
 }
}
if($type == "All")
{ $i = 0;  $pdate = "";
  $query2 = "SELECT distinct(transactioncode) as tid,bccodeno,crtotal as grandtotal,date,voucher FROM ac_gl WHERE vstatus = 'U' ORDER by voucher,date,id";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 $voucher = $rows2['voucher'];
 if($voucher == "P") $dtype = "Payment Voucher";
 elseif($voucher == "R") $dtype = "Receipt Voucher";
 else $dtype = "Journal Voucher";
 
  $invoice = $rows2['tid'];
  $itemcode = "";
  $query3 = "SELECT code FROM ac_gl WHERE transactioncode = '$invoice' and voucher = '$voucher' ORDER BY id LIMIT 1,10";
  $result3 = mysql_query($query3,$conn1) or die(mysql_error());
  while($rows3 = mysql_fetch_assoc($result3))
   $itemcode .= $rows3['code']."/";
  $itemcode = substr($itemcode,0,-1);

?>
	<tr>
<?php if($type == "All") { ?>
		<td class="ewRptGrpField1">
<?php if($voucher <> $pvoucher) { echo ewrpt_ViewValue($dtype); } else { echo ewrpt_ViewValue(); }  ?></td>
<?php } ?>
		<td class="ewRptGrpField3">
<?php if($date <> $pdate or $voucher <> $pvoucher) { echo ewrpt_ViewValue($date); } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($invoice) ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows2['bccodeno']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($itemcode) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows2['grandtotal'])); ?></td>
	</tr>
<?php
  $i  = 1;
  $pdate = $date;
  $pvoucher = $voucher; 
 }
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
<?php include "phprptinc/footer.php";?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('section').value;
	document.location = "pendingauthorizelog.php?type=" + fdate;
}
</script>
<?php

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