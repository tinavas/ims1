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
 
 
 
 $flock = $_GET['flock'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Flock Production Report</font></strong></td>
</tr>
</table>
<!--<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>
-->
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
&nbsp;&nbsp;<a href="productionreport.php?export=html&flock=<?php echo $flock; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="productionreport.php?export=excel&flock=<?php echo $flock; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="productionreport.php?export=word&flock=<?php echo $flock; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="productionreport.php?cmd=reset&flock=<?php echo $flock; ?>">Reset All Filters</a>
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
 <td>Flock</td>
 <td><select name="flock" id="flock" style="width:100px;" onChange="reloadpage();">
     <option value="">-Select-</option>
	 <?php 
	 include "config.php";
	 $query = "select distinct(flock) from layer_production order by flock";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['flock']; ?>" <?php if($flock == $rows['flock']) { ?> selected="selected" <?php } ?>><?php echo $rows['flock']; ?></option>
	 <?php } ?>
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
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Age</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php
  $query467 = "SELECT * FROM ims_itemcodes where cat like 'Layer Eggs' and client = '$client'  ORDER BY code ASC ";
  $result467 = mysql_query($query467,$conn1); 
  while($row467 = mysql_fetch_assoc($result467))
  { 
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		<?php echo $row467['code'] . "<br />" . $row467['description']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><?php echo $row467['code'] . "<br />" . $row467['description']; ?></td>
			</tr></table>
		</td>
<?php } ?>

<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		T.Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">T.Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Production %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Production %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		E.Wt
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">E.Wt</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
$dupcheck = '';
$i1=0;
$query2 = "select distinct(date1),eggwt from layer_production where flock = '$flock' order by date1";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_assoc($result2))
{
$date = date("d.m.Y",strtotime($rows2['date1']));
$x_date = date("Y-m-d",strtotime($date));
$eggwt = $rows2['eggwt'];
$query1 = "select startdate,age from layer_flock where flockcode = '$flock' order by flockcode";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
$date1 = date("d.m.Y",strtotime($rows1['startdate']));
$days = (strtotime($date) - strtotime($date1))/(60*60*24);
$age1 = $rows1['age'] + $days;
?>
	<tr>
		<td class="ewRptGrpField3">
<?php if($dupcheck == '') { echo ewrpt_ViewValue($flock); $dupcheck = $flock; } else { echo ewrpt_ViewValue(); } ?></td>
		<td class="ewRptGrpField3" align="right">
	<?php	
		      $age = $age1;
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              $nrYearsPassed = floor($nrSeconds / 31536000); 
              echo ewrpt_ViewValue($nrWeeksPassed . "." . $nrDaysPassed); 
		
  ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($date); ?></td>
<?php

///////////// Opening Birds ///////////////////

             $fopening = 0;
             $q = "select femaleopening from layer_flock where flockcode = '$flock' and client = '$client'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             
 
             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from layer_consumption where flock = '$flock' and client = '$client'  and date2 < '$x_date' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }

        
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse = '$flock' and date < '$x_date'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flock' and client = '$client'  and date < '$x_date' and code in (select distinct(code) from ims_itemcodes where cat = 'Layer Birds' and client = '$client')"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$flock' and date < '$x_date'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

             $q = "select sum(receivedquantity) as 'quantity' from pp_sobi where warehouse = '$flock' and client = '$client'  and date < '$x_date' and code in (select distinct(code) from ims_itemcodes where cat = 'Layer Birds' and client = '$client')"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tpur = $qr['quantity'];
               }
             }
             else
             {
                $tpur = 0;
             } 
			 
             $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale + $tpur;
			// echo $fopening."/".$minus."/".$ftransfer."/".$ttransfer."/".$tsale."/".$tpur;
?>


<?php

///////////// Transfer In ////////////////
              
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$flock' and date = '$x_date'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
             if($ttransfer == "") { $ttransfer = 0; }
?>
<?php
  $totaleggs = 0;
  
  $query467 = "SELECT * FROM ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  ORDER BY code ASC ";
  $result467 = mysql_query($query467,$conn1); 
  while($row467 = mysql_fetch_assoc($result467))
  { 

        $q1 = "select sum(quantity) as 'quantity' from layer_production where itemcode = '$row467[code]' and client = '$client'  and flock = '$flock' and date1 = '$x_date' group by flock order by flock"; 
  		$qrs1 = mysql_query($q1,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs1))
            {
		  while($qr1 = mysql_fetch_assoc($qrs1))
		  {
                   $qty = $qr1['quantity'];
				   
              }
            }
            else
            {
                   $qty = 0; 
            }
            $xeggs[$row467['code']] = $xeggs[$row467['code']] + $qty; 
?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $qty; $totaleggs = $totaleggs + $qty; ?>
</td>
<?php } ?>
<td<?php echo $sItemRowClass; ?>>
<?php echo $totaleggs;
$ab12=$ab12+$totaleggs; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $ab=$ab+round(($totaleggs/$remaining) * 100,2);

$i1++;
 ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($eggwt) ?>
</td>
	</tr>
<?php
}
}
?>
	</tbody>
	<tfoot>
		<tr><td>Total:</td><td>&nbsp;</td><td>&nbsp;</td><td><?php echo $a12; ?></td></tr>

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
	var flock = document.getElementById('flock').value;
	document.location = "productionreport.php?flock=" + flock;
}
</script>