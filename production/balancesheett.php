<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate =$fdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate=$fdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate=$tdate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate =$tdate= date("Y-m-d"); 
 include "../getemployee.php";
 
 $lastyear = date("Y-m-d",strtotime($fromdate)-86400);
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php //include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Balance Sheet</font></strong></td>
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
&nbsp;&nbsp;<a href="balancesheetlatest.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="balancesheetlatest.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="balancesheetlatest.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="balancesheetlatest.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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

<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" rowspan="2"  align="center">
		Particulars
		</td>
<?php } else { ?>
		<td class="ewTableHeader" rowspan="2"  align="center" style="vertical-align:middle">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Particulars</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		<?php echo date($datephp,strtotime($fromdate));?> To <?php echo date($datephp,strtotime($todate));?> 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><?php echo date($datephp,strtotime($fromdate));?> To <?php echo date($datephp,strtotime($todate));?> </td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Till <?php echo date($datephp,strtotime($lastyear));?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Till <?php echo date($datephp,strtotime($lastyear));?></td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
		<tr>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Amount</td>
			</tr></table>
		</td>
		<?php } ?>
</tr>
	</thead>
	<tbody>
	<tr><td colspan="3" align="center"><b>A) EQUITY AND LIABILITIES</b></td></tr>
<?php 

$query2 = "SELECT * FROM ac_definefy WHERE fdate < '$fdate' order by fdate DESC LIMIT 1";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
$prevfromdate = $rows2['fdate'];

/* $query = "SELECT amount,coacode,crdr FROM ac_fp_closingfy WHERE fromdate = '$prevfromdate'";
$result = mysql_query($query,$conn1);
while($rows = mysql_fetch_assoc($result))
if($rows['crdr'] == "Cr")
{
 $prevcrarray[$rows['coacode']] = $rows['amount'];
 $prevexist[$rows['coacode']] = 1;
}
else if($rows['crdr'] == "Dr")
{
 $prevdrarray[$rows['coacode']] = $rows['amount'];
 $prevexist[$rows['coacode']] = 1;
}*/
	
 $query = "SELECT sum(amount) as cramount,coacode,crdr FROM ac_financialpostings WHERE date<='$lastyear' GROUP BY coacode,crdr";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
if($rows['crdr']=="Cr")
 { $lcrarray[$rows['coacode']] = $rows['cramount']; $lexist[$rows['coacode']] = 1; }
else if($rows['crdr']=="Dr") 	
{ $ldrarray[$rows['coacode']] = $rows['cramount']; $lexist[$rows['coacode']] = 1; } 
 	
$query = "SELECT sum(amount) as cramount,coacode,crdr FROM ac_financialpostings WHERE date<='$tdate' GROUP BY coacode,crdr";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
if($rows['crdr']=="Cr")
 { $crarray[$rows['coacode']] = $rows['cramount']; $exist[$rows['coacode']] = 1; }
else if($rows['crdr']=="Dr") 	
{ $drarray[$rows['coacode']] = $rows['cramount']; $exist[$rows['coacode']] = 1; }


$query = "select distinct(schedule),pschedule from ac_schedule";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$parentschedule[$res['schedule']] = $res['pschedule'];


	$leftcount = $sctotal= $psctotal =$lsum=0;
	$osc=$opsc= "dummy"; 
	$quer = "select distinct(code),description,type,schedule from ac_coa where ( type = 'Liability' or type = 'Capital' or type = 'Asset') order by type,schedule,code ";
	/*$quer="select ass.type,ass.pschedule,ass.schedule,ac.code,ac.description from ac_coa ac,ac_schedule ass where ass.type =ac.type and ass.schedule=ac.schedule and ( ac.type = 'Liability' or ac.type = 'Capital' or ac.type = 'Asset') order by ass.type,ass.pschedule,ass.schedule,ac.code";*/
	          $quers = mysql_query($quer,$conn1) or die(mysql_error());
		       while($row1 = mysql_fetch_assoc($quers))
			   if($exist[$row1['code']] > 0 or $lexist[$row1['code']] > 0 /*or $prevexist[$row1['code']] > 0*/)
			   {
			  
			     $code = $row1['code']; 
				 $parent = $parentschedule[$row1['schedule']];
				 $mbal = ($crarray[$code] - $drarray[$code])/* + ($prevcrarray[$code] - $prevdrarray[$code])*/;
				 $lmbal = ($lcrarray[$code] - $ldrarray[$code])/* + ($prevcrarray[$code] - $prevdrarray[$code])*/;
				if ( ($mbal <> 0) or ($lmbal <> 0) )
				if($row1['type'] == "Asset")
				{ $pscarr[$leftcount] = $parent; 
				  $scarr[$leftcount] = $row1['schedule'];
				  $codearr[$leftcount] = $row1['code'];
				  $descarr[$leftcount] = $row1['description'];
				  $amountarr[$leftcount] = -$mbal;
				  $lamountarr[$leftcount] = -$lmbal;
				  $leftcount = $leftcount + 1;
				 } else { 
				
				 /*if($osc == 1)
                $osc =$sc= $row1['schedule'];
                  else
               $sc = $row1['schedule'];*/
  
				if($osc != $row1['schedule'])
				{?>
				<?php if($sctotal)
				{ 
				?>
		<tr><td align="right"><?php echo $osc." Total"; ?></td><td align="right"><b><?php echo changeprice($sctotal); ?></b></td><td align="right"><b><?php echo changeprice($lsctotal); ?></b></td></tr>
				<?php $sctotal = 0; $lsctotal = 0; } ?>
				
				
				
				<?php  }	
				
				
		if($opsc != $parent)
				{?>
				<?php if($psctotal)
				{ 
				?>
		<tr><td  align="right"><?php echo $opsc." Total"; ?></td><td align="right"><b><?php echo changeprice($psctotal); ?></b></td><td align="right"><b><?php echo changeprice($lpsctotal); ?></b></td></tr>
				<?php $psctotal = 0; $lpsctotal = 0; } ?>
				
				
				
				<?php  }	?>		
	
	<?php if($opsc != $parent){ ?>			
	<tr><td colspan="3"><b><?php echo $parent; $opsc = $parent; ?></b></td></tr>
	<?php } ?>
	<?php if($osc != $row1['schedule']){?>			
	<tr><td colspan="3" ><b><?php echo $row1['schedule']; $osc = $row1['schedule']; ?></b></td></tr>					
	<?php } ?>
	<tr>
		<!--<td >
		<a href="dummy.php?fromdate=<?php echo $fdate; ?>&todate=<?php echo $tdate; ?>&code=<?php echo $row1['code']; ?>&desc=<?php echo $row1['description']; ?>" target="_blank" title="View Ledger Details" style="color:0000FF;"><?php echo $row1['code']; ?></a>
</td>-->
		<td >
<?php echo $row1['description']; ?></td>
		<td align="right">
<?php echo changeprice($mbal); $lsum +=$mbal; $sctotal += $mbal; $psctotal += $mbal; ?></td>
<td align="right">
<?php echo changeprice($lmbal); $llsum +=$lmbal; $lsctotal += $lmbal; $lpsctotal += $lmbal; ?></td>
	</tr>
<?php   
		
				}
			   }
?>
<tr><td  align="right"><?php echo $osc." Total"; ?></td><td align="right"><b><?php echo changeprice($sctotal); ?></b></td><td align="right"><b><?php echo changeprice($lsctotal); ?></b></td></tr>
<tr><td align="right"><?php echo $opsc." Total"; ?></td><td align="right"><b><?php echo changeprice($psctotal); ?></b></td><td align="right"><b><?php echo changeprice($lpsctotal); ?></b></td></tr>

<?php	
  $expsum = $revsum = $lexpsum = $lrevsum = 0;
   $quer = "select code,type from ac_coa where type = 'Expense' or type = 'Revenue'";
	$quers = mysql_query($quer,$conn1) or die(mysql_error());
	while($row1 = mysql_fetch_assoc($quers))
	{
	   $code = $row1['code']; 
	
	   if($row1['type'] == "Expense")
	   {
	   $mbal = ($drarray[$code] - $crarray[$code]) /*+ ($prevdrarray[$code] - $prevcrarray[$code])*/;
	   $expsum = $expsum + $mbal;
	   
	    $lmbal = ($ldrarray[$code] - $lcrarray[$code]) /*+ ($prevdrarray[$code] - $prevcrarray[$code])*/;
	   $lexpsum = $lexpsum + $lmbal;
	   }
	   
	 
	   if($row1['type'] == "Revenue")
	   {
	   $mbal = ($crarray[$code] - $drarray[$code])/* + ($prevcrarray[$code] - $prevdrarray[$code])*/;
	   $revsum = $revsum + $mbal; 
	   
	   $lmbal = ($lcrarray[$code] - $ldrarray[$code])/* + ($prevcrarray[$code] - $prevdrarray[$code])*/;
	   $lrevsum = $lrevsum + $lmbal; 
	   }
	 } 
	 
	 
	 
$eqflag = $leqflag = 0;	 
if ( ($expsum < $revsum) || ($lexpsum < $lrevsum)  )
   {
    ?>
<tr>
		<!--<td >&nbsp;</td>-->
		<td >Retained Earnings</td>
		<td align="right"><?php if($expsum < $revsum){ $eqflag = 1;	$mainbal = $revsum - $expsum; echo changeprice($mainbal); $lsum +=$mainbal; } else {echo "0.00"; $mainbal = $expsum-$revsum;} ?></td>
		<td align="right"><?php if($lexpsum < $lrevsum ){ $leqflag = 1; $lmainbal = $lrevsum - $lexpsum; echo changeprice($lmainbal); $llsum +=$lmainbal;} else { echo "0.00";  $lmainbal = $lexpsum-$lrevsum; } ?></td>
	</tr>   
   
   
 <?php 
 } else { 
 $mainbal = $expsum-$revsum;
  $lmainbal = $lexpsum-$lrevsum;
 }
 ?>

<tr>
<td  align="right"><b>Total</b></td><td align="right"><b><?php echo changeprice($lsum); ?></b></td><td align="right"><b><?php echo changeprice($llsum); ?></b></td>
</tr>
<tr><td colspan="3">&nbsp;</td>
	</tbody>
	
	<thead>
	<tr><td colspan="3" align="center"><b>B) ASSETS</b></td></tr>
	
	</thead>
<tbody>
<?php 
$lsum = $sctotal=$psctotal= $llsum = $lsctotal=$lpsctotal=0;
$osc = "dummy";
for($i=0; $i < $leftcount; $i++)
{ 

if($osc <> $scarr[$i])
{
 if($sctotal)
 { 
?>
<tr><td align="right"><?php echo $osc." Total"; ?></td><td align="right"><b><?php echo changeprice($sctotal); ?></b></td><td align="right"><b><?php echo changeprice($lsctotal); ?></b></td></tr>
<?php $sctotal = 0; $lsctotal = 0; } ?>

<?php 

} 

if($opsc != $pscarr[$i])
				{?>
				<?php if($psctotal)
				{ 
				?>
		<tr><td align="right"><?php echo $opsc." Total"; ?></td><td align="right"><b><?php echo changeprice($psctotal); ?></b></td><td align="right"><b><?php echo changeprice($lpsctotal); ?></b></td></tr>
				<?php $psctotal = 0; $lpsctotal = 0; } ?>
				
				
				
				<?php  }	?>		
		<?php if($opsc != $pscarr[$i]) {?>		
		<tr><td colspan="3" ><b><?php echo $pscarr[$i]; $opsc = $pscarr[$i]; ?></b></td></tr>		
		<?php } ?>
		<?php if($osc <> $scarr[$i]){?>
		<tr> <td colspan="3" ><b><?php echo $scarr[$i]; $osc = $scarr[$i]; ?></b></td></tr>		
		<?php }?>		
	<tr>
	<!--	<td >
		<a href="dummy.php?fromdate=<?php echo $fdate; ?>&todate=<?php echo $tdate; ?>&code=<?php echo $codearr[$i]; ?>&desc=<?php echo $descarr[$i]; ?>" target="_blank" title="View Ledger Details" style="color:0000FF;"><?php echo $codearr[$i]; ?></a>
</td>-->
		<td >
<?php echo $descarr[$i]; ?></td>
		<td align="right">
<?php echo changeprice($amountarr[$i]); $lsum += $amountarr[$i]; $sctotal += $amountarr[$i]; $psctotal += $amountarr[$i];  ?></td>

<td align="right">
<?php echo changeprice($lamountarr[$i]); $llsum += $lamountarr[$i]; $lsctotal += $lamountarr[$i]; $lpsctotal += $lamountarr[$i];  ?></td>
	</tr>
<?php }
?>

<tr><td align="right"><?php echo $osc." Total"; ?></td><td align="right"><b><?php echo changeprice($sctotal); ?></b></td><td align="right"><b><?php echo changeprice($lsctotal); ?></b></td></tr>
<tr><td align="right"><?php echo $opsc." Total"; ?></td><td align="right"><b><?php echo changeprice($psctotal); ?></b></td><td align="right"><b><?php echo changeprice($psctotal); ?></b></td></tr>
<?php
if($eqflag == 0 || $leqflag == 0)
  {
   ?>
<tr>
		<!--<td >&nbsp;</td>-->
		<td >Retained Earnings</td>
		<td align="right"><?php if($eqflag==0){echo changeprice($mainbal); $lsum +=$mainbal;} else echo "0.00";  ?></td>
		<td align="right"><?php if($leqflag==0){echo changeprice($lmainbal); $llsum +=$lmainbal;} else echo "0.00";  ?></td>
	</tr>   
   
   
 <?php 
 }

 ?>	
<tr>
<td align="right"><b>Total</b></td><td align="right"><b><?php echo changeprice($lsum); ?></b></td><td align="right"><b><?php echo changeprice($llsum); ?></b></td>
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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
