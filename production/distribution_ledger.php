<?php 

set_time_limit(0);

$sExport = @$_GET["export"]; 
include "reportheader.php"; 

include"../distribution_getsuperstockist_singh.php";

if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 
 if($_GET['cnf']<>"")
 {
 $superstockist=$_GET['cnf'];
 $cond="where superstockist='$superstockist'";
 }
 else
 {
 $superstockist="singhsatrangsuperstockist";
  $cond="where superstockist='$superstockist'";
 }
 
 if($_GET['distributor']<>"")
 {
   $distributor=$_GET['distributor'];
 }
 else
 {
   $distributor="All";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Ledger Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr> 
</table>
<center><p style="padding-left:430px;color:red"></p></center>

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
&nbsp;&nbsp;<a href="distribution_ledger.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&distributor=<?php echo $distributor; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="distribution_ledger.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&distributor=<?php echo $distributor; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="distribution_ledger.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&distributor=<?php echo $distributor; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="distribution_ledger.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&distributor=<?php echo $distributor; ?>">Reset All Filters</a>
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
  <td>Super Stockist</td>
 <td>
 <select name="cnf" id="cnf" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php
 $q1="select name from contactdetails where superstockist='YES' and name in ($authorizedsuperstockistlist) and type like '%party%'";

 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 {
 ?>
  <option value="<?php echo $r1['name'];?>" <?php if($r1['name']==$_GET['cnf']){?> selected="selected" <?php }?>><?php echo $r1['name'];?></option>
 <?php }?> 
 </select>
 
 </td>
 <td>Distributor</td>
 <td>
 <select name="distributor" id="distributor" onchange="reloadpage();">
 <option value="All">-All-</option>
 <?php
 $q1="select distinct name from distribution_distributor where superstockist='$superstockist'";

 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 
 {
 ?>
 <option value="<?php echo $r1['name'];?>" title="<?php echo $r1['name'];?>" <?php if($r1['name']==$distributor){?> selected="selected"<?php }?>><?php echo $r1['name'];?></option>
 
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
    <?php
	if($distributor=="All")
	{
	?>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Name</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2" colspan="2">
		OB.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>OB.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3" colspan="2">
		Selected Period
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Selected Period</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Closing Balance
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Closing Balance </td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Balance
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Balance</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Dr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Cr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Dr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Dr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Dr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cr</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
    
    <?php }
	else {?>
    
    	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Transaction Number
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Transaction Number</td>
			</tr></table>
		</td>
<?php } ?>



<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Transaction Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Transaction Type</td>
			</tr></table>
		</td>
<?php } ?>




<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Balance
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Balance</td>
			</tr></table>
		</td>
<?php } ?>




	</tr>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>



<?php  if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Dr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dr</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cr
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cr</td>
			</tr></table>
		</td>
<?php } ?>



	</tr>
    
    
    <?php }?>
    
	</thead>
	<tbody>
<?php 
if($distributor=="All")
{ 

$q1="select  name from distribution_distributor $cond order by name";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{

//get the opening balance

$opbalance=$opdramount=$opcramount=0;

$q2="select sum(amount) as amount,crdr from distribution_financialpostings where warehouse='$r1[name]' and date<'$fromdate' and crdr='Dr'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$opdramount=$r2['amount'];


$q2="select sum(amount) as amount,crdr from distribution_financialpostings where warehouse='$r1[name]' and date<'$fromdate' and crdr='Cr'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$opcramount=$r2['amount'];

$opbalance=$opdramount-$opcramount;

//------------------------------

?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['name']) ?></td>
		<td class="ewRptGrpField2" align="right">
<?php echo ewrpt_ViewValue($opdramount); ?></td>
		<td class="ewRptGrpField2" align="right">
<?php echo ewrpt_ViewValue($opcramount); ?></td>

<?php
//get selected period amount

$mbalance=$mdramount=$mcramount=0;

$q2="select sum(amount) as amount,crdr from distribution_financialpostings where warehouse='$r1[name]' and
 date between   '$fromdate' and '$todate' and crdr='Dr'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$mdramount=$r2['amount'];


$q2="select sum(amount) as amount,crdr from distribution_financialpostings where warehouse='$r1[name]' and 
date between '$fromdate' and '$todate' and crdr='Cr'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$mcramount=$r2['amount'];

$mbalance=$mdramount-$mcramount;



//------------------------------------


?>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($mdramount) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($mcramount) ?></td>
<?php

$clcramount=$cldramount=0;

$clcramount=$opcramount+$mcramount;

$cldramount=$opdramount+$mdramount;

$allclosingcramounts[]=$clcramount;

$allclosingdramounts[]=$cldramount;



?>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($cldramount) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($clcramount) ?></td>
<?php

if($cldramount>$clcramount)
{
$tdramount=$cldramount-$clcramount;
$tcramount=0;
}
else
{
$tcramount=$clcramount-$cldramount;
$tdramount=0;
}
?>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($tdramount); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($tcramount); ?></td>
	</tr>
<?php

}
?>
<tr>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("<b>Total</b>"); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(array_sum($allclosingdramounts)); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(array_sum($allclosingcramounts)); ?></td>

<?php

$allcrsum=array_sum($allclosingcramounts);

$alldrsum=array_sum($allclosingdramounts);

if($alldrsum>$allcrsum)
{
$finaldramount=$alldrsum-$allcrsum;
$finalcramount=0;
}
if($allcrsum>$alldrsum)
{
$finalcramount=$allcrsum-$alldrsum;
$finaldramount=0;
}




?>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($finaldramount); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($finalcramount); ?></td>


</tr>



<?php


}
else
{
?>

<?php

$opbalance=$opdramount=$opcramount=0;

$q2="select sum(amount) as amount,crdr from distribution_financialpostings where BINARY  warehouse='$distributor' and date<'$fromdate' and crdr='Dr'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$opdramount=$r2['amount'];


$q2="select sum(amount) as amount,crdr from distribution_financialpostings where BINARY  warehouse='$distributor' and date<'$fromdate' and crdr='Cr'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$opcramount=$r2['amount'];

$opbalance=$opdramount-$opcramount;

//------------------------------

if($opdramount>$opcramount)
{

$opdamount=$opdramount-$opcramount;

$opcamount=0;

}
else
{
$opcamount=$opcramount-$opdramount;

$opdamount=0;

}

$allcramounts[]=$opcamount;

$alldramounts[]=$opdamount;


?>

<tr>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("Opening Balance") ?></td>
<td class="ewRptGrpField2">
<?php echo $opdamount ?></td>
<td class="ewRptGrpField2">
<?php echo $opcamount ?></td>
</tr>
<?php

 $q3="select sum(amount) as amount,crdr,type,date,trnum from distribution_financialpostings where date between '$fromdate' and '$todate' and BINARY  warehouse = '$distributor' group by trnum,crdr order by date ";

$q3=mysql_query($q3) or die(mysql_error());

while($r3=mysql_fetch_assoc($q3))
{

if($r3['type']=="RTDT")
{

$value="Stock Return";

}
else if ($r3['type']=="STDT")
{
$value="Stock Issue";
}
else if ($r3['type']=="DRCT")
{
$value="Receipt From Distributor";
}
else
{
$value="Other Type";
}

if($r3['crdr']=="Cr")
{

$cramount=$r3['amount'];
$dramount=0;
}
if($r3['crdr']=="Dr")
{

$dramount=$r3['amount'];
$cramount=0;
}


$allcramounts[]=$cramount;

$alldramounts[]=$dramount;


?>
<tr>

<td class="ewRptGrpField2">
<?php echo date("d.m.Y",strtotime($r3['date'])) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r3['trnum']) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($value) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($dramount) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($cramount) ?></td>

</tr>
<?php 
}

?>

<tr>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("<b>Total Amounts</b>") ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(array_sum($alldramounts)) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(array_sum($allcramounts)) ?></td>

</tr>

<?php

$alldrsum=array_sum($alldramounts);

$allcrsum=array_sum($allcramounts);

if($alldrsum>$allcrsum)
{

$outdrsum=$alldrsum-$allcrsum;

$outcrsum=0;

}
if($allcrsum>$alldrsum)
{

$outcrsum=$allcrsum-$alldrsum;

$outdrsum=0;

}


?>
<tr>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("<b>Outstanding Balance</b>") ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($outdrsum) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($outcrsum) ?></td>

</tr>



<?php }?>



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
	var distributor = document.getElementById('distributor').value;
		var cnf = document.getElementById('cnf').value;

	document.location = "distribution_ledger.php?fromdate=" + fdate + "&todate=" + tdate + "&cnf="+cnf + "&distributor="+distributor;
}
</script>