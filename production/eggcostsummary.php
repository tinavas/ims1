<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
include "config.php";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Egg Cost Summary </font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="eggcostsummary.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="eggcostsummary.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="eggcostsummary.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="eggcostsummary.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
<table align="center">
 <tr>
 <td>From Date</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();" size="10"/></td>
 <td>To Date</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();" size="10"/></td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">


	
	<?php
	$teggs=0;
	  $query = "SELECT sum(quantity) as quantity from breeder_production where   date1 >= '$fromdate' and date1 <= '$todate' and itemcode in(select code from ims_itemcodes where cat in ('Hatch Eggs'))";
     $result = mysql_query($query,$conn1); 
     while($row1 = mysql_fetch_assoc($result))
     {
       $teggs = $teggs+$row1['quantity']; 
	   
       
     } 
	 
	 $heggs=0;
	  $query1 = "SELECT sum(quantity) as quantity from breeder_production where   date1 >= '$fromdate' and date1 <= '$todate' and itemcode in(select code from ims_itemcodes where cat in ('Eggs'))";
     $result1 = mysql_query($query1,$conn1); 
     while($row2 = mysql_fetch_assoc($result1))
     {
       $heggs = $heggs+$row2['quantity']; 
	   
       
     }
	 $totaleggs=$heggs+$teggs; 
	 $feed=0;
	  $query4 = "SELECT sum(quantity) as quantity from breeder_consumption where   date2 >= '$fromdate' and date2 <= '$todate' and itemcode in(select code from ims_itemcodes where cat in ('Female Feed','Male Feed'))";
     $result4 = mysql_query($query4,$conn1); 
     while($row4 = mysql_fetch_assoc($result4))
     {
       $feed = $feed+$row4['quantity']; 
	   
       
     }
	 $feedexclu=0;
	  $query5 = "SELECT  distinct(flock), date1 from breeder_production where date1 >= '$fromdate' and date1 <= '$todate' ";
     $result5 = mysql_query($query5,$conn1); 
     while($row5 = mysql_fetch_assoc($result5))
     {
      $flock=$row5['flock']; 
	   $date=$row5['date1']; 
        $query6 = "SELECT sum(quantity) as quantity from breeder_consumption where   date2 = '$date' and flock = '$flock' and itemcode in(select code from ims_itemcodes where cat in ('Female Feed','Male Feed')) ";
     $result6 = mysql_query($query6,$conn1); 
     while($row6 = mysql_fetch_assoc($result6))
     {
       $feedexclu = $feedexclu+$row6['quantity']; 
	   
       
     }
     }
	  $query7 = "SELECT sum(production*feedcostperkg)/sum(production) as avg from feed_productionunit where  date >= '$fromdate' and date <= '$todate'";
     $result7 = mysql_query($query7,$conn1); 
     while($row7 = mysql_fetch_assoc($result7))
     {
       
	   $avg = $row7['avg'];
       
     }
	 $feedcost=$avg*$feed;
	 $medvac=0;
	  $query8 = "SELECT (itemcode) as item,sum(quantity) as so,itemdesc from breeder_consumption where   date2 >= '$fromdate' and date2 <= '$todate' and itemcode in(select code from ims_itemcodes where cat in ('Medicines','Vaccines')) group by itemcode";
     $result8 = mysql_query($query8,$conn1); 
     while($row8 = mysql_fetch_assoc($result8))
     {
       $so= round($row8['so'],3); 
	   
	   $item=$row8['item'];
	   $itemdesc=$row8['itemdesc'];
	   $query9 ="select distinct(cm) from ims_itemcodes where code='$item'";
       $result9 = mysql_query($query9,$conn1); 
     while($row9 = mysql_fetch_assoc($result9))
     {
	 $cm= $row9['cm']; 
	 $cost =round(calculate($cm,$item,$todate),2);
	 $medvac=$medvac+($so*$cost);
	
	 }
     }
	 
	 $f = strtotime($fromdate);
$t = strtotime($todate);
$year=date("Y",$f);
$month=date("m",$f);
$year1=date("Y",$t);
$month1=date("m",$t);
$fromdate1 = $year."-".$month."-01";
$todate1 = $year1."-".$month1."-"."-31";
$otherex=0;
	 $query10 = "SELECT sum(amount) as quantity from breeder_unitwisemaintaincecost 
 where   fromdate >= '$fromdate1' and todate <= '$todate1' ";
     $result10 = mysql_query($query10,$conn1); 
     while($row10 = mysql_fetch_assoc($result10))
     {
       $otherex = $otherex+$row10['quantity']; 
	   
       
     }
	 $totalcost=$otherex+$medvac+$feedcost;
	 $costhatch=$totalcost/$totaleggs;
	 ?>
	 <table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>

		<td valign="bottom" class="" >
		<b>Total Eggs Produced</b>
		</td>
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($totaleggs,2)); ?></td></tr>
<tr><td  align="bottom"><b>Hatch Eggs</b></td>
			
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($heggs,2)); ?></td></tr>
<tr>
			<td  align="bottom"><b>Table Eggs</b></td>
			
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($teggs,2)); ?></td></tr>
<tr>
			<td  align="bottom"><b>Total Feed Consumed</b></td>
			
		</td>
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($feed,2)); ?></td></tr>

<tr>
			<td  align="bottom"> <b>Feed Consumed Excluding (Chick and Grower)</b></td>
			
		
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($feedexclu,2)); ?></td></tr>
<tr>
			<td  align="left"><b>Feed Cost</b></td>
			
		
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($feedcost,2)); ?></td></tr>
<tr>
			<td  align="left"><b>Medicine and Vaccines cost</b></td>
			
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($medvac,2)); ?></td></tr>
<tr>
			<td  align="bottom"><b>Other Expenses</b></td>
			
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($otherex,2)); ?></td></tr>
<tr>
			<td  align="bottom"><b>Total Cost</b></td>
			
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($totalcost,2)); ?></td></tr>
<tr>
			<td  align="bottom"><b>Cost/Hatch Egg</b></td>
			
<td class="ewRptGrpField2" align="right">
<?php echo changeprice(round($costhatch,2)); ?></td></tr>
	
	</thead>
	<tbody>
		
		
		







	

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
	document.location = "eggcostsummary.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>