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
 
 if($_GET['cat']<>"")
 {
 $category=$_GET['cat'];
 }
 else
 {
 $category="singhsatrang";
 }
 
if($_GET['name']<>"")
 {
 $superstockist=$_GET['name'];
 }
 else
 {
 $superstockist="singhsatrangsuperstockist";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">CNF Stock Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
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
&nbsp;&nbsp;<a href="distribution_cnfstockreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $_GET['name']; ?>&cat=<?php echo $_GET['cat']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="distribution_cnfstockreport.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $_GET['name']; ?>&cat=<?php echo $_GET['cat']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="distribution_cnfstockreport.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $_GET['name']; ?>&cat=<?php echo $_GET['cat']; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="distribution_cnfstockreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $_GET['name']; ?>&cat=<?php echo $_GET['cat']; ?>">Reset All Filters</a>
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
 <td>From</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
 <td>Category</td>
 <td>
 <select name="category" id="category" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php
 $q1="select distinct cat from ims_itemcodes where iusage like '%sale%'";
 
 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 {
 ?>
 <option value="<?php echo $r1['cat'];?>" title="<?php echo $r1['cat'];?>" <?php if($r1['cat']==$_GET['cat']){?> selected="selected" <?php }?>><?php echo $r1['cat'];?></option>
 <?php }?>
 </select>
 </td>
 
  <td>CNF/Super Stockist</td>
 <td>
 <select name="cnf" id="cnf" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php
 $q1="select name from contactdetails where superstockist='YES' and type like '%party%'";

 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 {
 ?>
 
 <option value="<?php echo $r1['name'];?>" <?php if($r1['name']==$_GET['name']){?> selected="selected" <?php }?>><?php echo $r1['name'];?></option>
 <?php }?> 
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
		Sunits
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sunits</td>
			</tr></table>
		</td>
<?php } ?>



<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Opening</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sales
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sales</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Stock Issue TO Distributor
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Stock Issue TO Distributor</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Stock Return From Distributor
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Stock Return From Distributor</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Stock Adjustment(Add)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Stock Adjustment(Add)</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Stock Adjustment(Deduct)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Stock Adjustment(Deduct)</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Closing
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Closing</td>
			</tr></table>
		</td>
<?php } ?>


	</tr>
	</thead>
	<tbody>
<?php 


 $q1=mysql_query("set group_concat_max_len=100000000");
 
 $q1="select * from ims_itemcodes where cat='$category' order by code";

 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 {
 
 $finalop=$opstock=$pquantity=$dsquantity=$stockreturn=$stockadjustadd=$stockadjustdeduct=$stockissue=0;
 
 
 //calculate opening stock
 
 //get the opening stock
 
 $q2="select sum(stock) as opstock from distribution_cnfopeningstock where category='$category' and code='$r1[code]' and date<'$fromdate' and superstockist='$superstockist'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $opstock=$r2['opstock'];
 //-------------end--------------
 
 
 
 //get the values from packslip
 
 $q2="select sum(quantity) as quantity from oc_packslip where itemcode='$r1[code]' and date<'$fromdate' and party='$superstockist'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $pquantity=$r2['quantity'];
 //-------------end--------------
 
 
 //get the values from cobi
 
 $q2="select sum(quantity) as quantity from oc_cobi where code='$r1[code]' and date<'$fromdate' and party='$superstockist' and dflag=1";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $dsquantity=$r2['quantity'];
 //-------------end--------------
 
 
 //get the values for issue quantity for distributor
 $q2="select sum(quantity) as quantity from distribution_stockissuetodistributor where category='$category' and code='$r1[code]' and date<'$fromdate' and superstockist='$superstockist'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockissue=$r2['quantity'];
 //-------------end--------------
 
 
 //get the values for return quantity for distributor
 $q2="select sum(quantity) as quantity from distribution_stockreturnfromdistributor where category='$category' and code='$r1[code]' and date<'$fromdate' and superstockist='$superstockist'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockreturn=$r2['quantity'];
 //-------------end--------------
 
 //stock adjustment values
 $q2="select sum(quantity) as quantity from distribution_stockadjustment where category='$category' and code='$r1[code]' and date<'$fromdate' and superstockist='$superstockist' and type='Add'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockadjustadd=$r2['quantity'];
 
  $q2="select sum(quantity) as quantity from distribution_stockadjustment where category='$category' and code='$r1[code]' and date<'$fromdate' and superstockist='$superstockist' and type='Deduct'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockadjustdeduct=$r2['quantity'];
 
 //-------------end--------------
 $finalop=$opstock+$pquantity+$dsquantity+$stockreturn+$stockadjustadd-$stockadjustdeduct-$stockissue;
 
 
 

?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['code']) ?></td>
		<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($r1['description']); ?></td>
		<td class="ewRptGrpField1" >
<?php echo ewrpt_ViewValue($r1['sunits']); ?></td>
<td class="ewRptGrpField2">
<?php echo $finalop ?></td>

<?php


 $finalsalequantity=$pquantity=$dsquantity=0;
//get the values from packslip
 
 $q2="select sum(quantity) as quantity from oc_packslip where itemcode='$r1[code]' and date between '$fromdate' and '$todate' and party='$superstockist'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $pquantity=$r2['quantity'];
 
 
 //get the values from cobi
 
 $q2="select sum(quantity) as quantity from oc_cobi where code='$r1[code]' and date between '$fromdate' and '$todate' and party='$superstockist' and dflag=1";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $dsquantity=$r2['quantity'];

 $finalsalequantity=$pquantity+$dsquantity;

?>

<td class="ewRptGrpField2">
<?php echo $finalsalequantity ?></td>

<?php
$stockissue=0;

//get the values for issue quantity for distributor
 $q2="select sum(quantity) as quantity from distribution_stockissuetodistributor where category='$category' and code='$r1[code]' and date between '$fromdate' and '$todate' and superstockist='$superstockist'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockissue=$r2['quantity'];
 
 if(empty($stockissue)){$stockissue=0;};

?>



<td class="ewRptGrpField2">
<?php echo $stockissue ?></td>

<?php
$stockreturn=0;
 
 //get the values for return quantity for distributor
  $q2="select sum(quantity) as quantity from distribution_stockreturnfromdistributor where category='$category' and code='$r1[code]' and  date between '$fromdate' and '$todate' and superstockist='$superstockist'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockreturn=$r2['quantity'];

 if(empty($stockreturn)){$stockreturn=0;};
?>

<td class="ewRptGrpField2">
<?php echo $stockreturn ?></td>

<?php

$stockadjustadd=0;

$q2="select sum(quantity) as quantity from distribution_stockadjustment where category='$category' and code='$r1[code]' and date between '$fromdate' and '$todate' and superstockist='$superstockist' and type='Add'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockadjustadd=$r2['quantity'];

if(empty($stockadjustadd)){$stockadjustadd=0;};
?>

<td class="ewRptGrpField2">
<?php echo $stockadjustadd ?></td>
<td class="ewRptGrpField2">
<?php

$stockadjustdeduct=0;

 $q2="select sum(quantity) as quantity from distribution_stockadjustment where category='$category' and code='$r1[code]' and date between '$fromdate' and '$todate' and superstockist='$superstockist' and type='Deduct'";
 
 $q2=mysql_query($q2) or die(mysql_error());
 
 $r2=mysql_fetch_assoc($q2);
 
 $stockadjustdeduct=$r2['quantity'];
 
 if(empty($stockadjustdeduct)){$stockadjustdeduct=0;};
?>

<?php echo $stockadjustdeduct ?></td>
<td class="ewRptGrpField2">

<?php

$closing=$finalop+$finalsalequantity+$stockreturn+$stockadjustadd-$stockadjustdeduct-$stockissue;

 if(empty($closing)){$closing=0;};
?>



<?php echo $closing ?></td>
	</tr>
<?php
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
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var name = document.getElementById('cnf').value;
	var cat = document.getElementById('category').value;
	document.location = "distribution_cnfstockreport.php?fromdate=" + fdate + "&todate=" + tdate+"&name="+name+"&cat="+cat;
}
</script>