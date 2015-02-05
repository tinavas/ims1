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
 include "config.php";
 include "../getemployee.php";
 if($_GET['type'])
 $displaytype = $_GET['type'];
 else
 $displaytype = "Type";
 if($displaytype == "Type")
 $span = 3;
 else if($displaytype == "Parent")
 $span = 4;
 else if($displaytype == "Schedule")
 $span = 5;
 
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Trial Balance</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">Date </font></strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="trialbalance.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $displaytype; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="trialbalance.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $displaytype; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="trialbalance.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $displaytype; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="trialbalance.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $displaytype; ?>">Reset All Filters</a>
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
		<td valign="bottom" class="ewTableHeader" >
		Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Type</td>
			</tr></table>
		</td>
<?php } 

if($displaytype == "Parent" or $displaytype == "Schedule" )
{
if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Parent Schedule
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Parent Schedule</td>
			</tr></table>
		</td>
<?php }

}
if($displaytype == "Schedule" )
{
if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Schedule
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Schedule</td>
			</tr></table>
		</td>
<?php }

}?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Description</td>
			</tr></table>
		</td>
<?php } ?>

<?php
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Debit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td colspan="3">Debit</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Credit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Credit</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 

 $drtotal = 0;
  $crtotal = 0;
  $expsum = 0;
  $revsum = 0;
  $ecount = 0;
  $rcount = 0;
  $opsc=$osc=$otype=$con = 1;
 
$query = "SELECT sum(amount) as cramount,coacode,crdr FROM ac_financialpostings WHERE date <= '$todate' GROUP BY coacode,crdr";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
if($rows['crdr'] == "Cr"){ $crarray[$rows['coacode']] = $rows['cramount'];	$coacodes[$rows['coacode']] = 1; }
elseif($rows['crdr'] == "Dr"){ $drarray[$rows['coacode']] = $rows['cramount']; $coacodes[$rows['coacode']] = 1; }

 $crtotal = $drtotal = $pcr = $pdr = $scr=$sdr=0;
if($displaytype == "Type")
$query2 = "select type,code,description from ac_coa order by type,code";
else
$query2 = "select distinct(ac.code),ass.type,ass.pschedule,ass.schedule,ac.description from ac_coa ac,ac_schedule ass where ass.type =ac.type and ass.schedule=ac.schedule  group by ac.code order by ass.type,ass.pschedule,ass.schedule,ac.code";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 if($coacodes[$rows2['code']] == 1)
 {
  if($otype == 1)
  $type =$otype= $rows2['type'];
  else
  $type = $rows2['type'];
  
  if($opsc == 1)
  $opsc =$psc= $rows2['pschedule'];
  else
  $psc = $rows2['pschedule'];
  
   if($osc == 1)
  $osc =$sc= $rows2['schedule'];
  else
  $sc = $rows2['schedule'];
  
  $coacode = $rows2['code'];
  	 $bal = ($crarray[$coacode] - $drarray[$coacode]);
	   if ( $bal > 0)
	   {
	   $mbal = $bal;
	   $flag = "Cr";
	   }
	   else
	   {
	   $mbal = -$bal;
	   $flag = "Dr";
	   }
if($displaytype == "Schedule")	   
if(($scr > 0 or $sdr > 0) && $osc <> $sc)
 {
 	?>
	<tr>
		<td class="ewRptGrpField3" align="right" colspan="<?php echo $span; ?>"><b>
		<?php echo ewrpt_ViewValue($osc." Total") ?></b>
		</td>
		<td align="right"><b>
        <?php  if ( $sdr > 0 ) {  echo changeprice($sdr);  } else { echo "0.00"; } ?></b>
        </td>
		<td align="right"><b>
         <?php  if ( $scr > 0 ) {  echo changeprice($scr);  } else { echo "0.00"; }  ?></b>
        </td>
         
	</tr>
	<?php 
	
	$scr = $sdr =0;

 } 
 
 if($displaytype == "Schedule" or $displaytype == "Parent" )		   
if(($pcr > 0 or $pdr > 0) && $opsc <> $psc)
 {
 	?>
	<tr>
		<td class="ewRptGrpField3" align="right" colspan="<?php echo $span; ?>"><b>
		<?php echo ewrpt_ViewValue($opsc." Total") ?></b>
		</td>
		<td align="right"><b>
        <?php  if ( $pdr > 0 ) {  echo changeprice($pdr);  } else { echo "0.00"; } ?></b>
        </td>
		<td align="right"><b>
         <?php  if ( $pcr > 0 ) {  echo changeprice($pcr);  } else { echo "0.00"; }  ?></b>
        </td>
         
	</tr>
	<?php 
	
	$pcr = $pdr =0;

 }   
	   
 if(($crtotal > 0 or $drtotal > 0) && $otype <> $type)
 {
 	?>
	<tr>
		<td class="ewRptGrpField3" align="right" colspan="<?php echo $span; ?>"><b>
		<?php echo ewrpt_ViewValue($otype." Total") ?></b>
		</td>
		<td align="right"><b>
        <?php  if ( $drtotal > 0 ) {  echo ewrpt_ViewValue(changeprice($drtotal)); $gdrtotal = $gdrtotal + $drtotal; } else { echo "0.00"; } ?></b>
        </td>
		<td align="right"><b>
         <?php  if ( $crtotal > 0 ) {  echo ewrpt_ViewValue(changeprice($crtotal)); $gcrtotal = $gcrtotal + $crtotal; } else { echo "0.00"; }  ?></b>
        </td>
         
	</tr>
	<?php 
	
	$crtotal = $drtotal =0;

 }

  
  if ( $mbal > 0) 
  {
  ?>
	<tr>
		
		<td class="ewRptGrpField3" >
		<?php if(($otype <> $type) or ($con)) echo $type; else echo "&nbsp;"; ?>
		</td>
		
		<?php 
		if($displaytype == "Parent" or $displaytype == "Schedule" )
		{?>
		<td class="ewRptGrpField3" >
		<?php if(($opsc <> $psc) or ($con)) echo $rows2['pschedule']; else echo "&nbsp;"; ?>
		</td>
		<?php
		}
		?>
		<?php 
		if($displaytype == "Schedule" )
		{?>
		<td class="ewRptGrpField3" >
		<?php if(($osc <> $sc) or ($con)) echo $rows2['schedule']; else echo "&nbsp;"; ?>
		</td>
		<?php
		}
		?>
		<td class="ewRptGrpField1">
		<?php  echo $coacode; ?>
		</td>
		<td class="ewRptGrpField2">
		<?php echo $rows2['description']; ?>
		</td>
		<td align="right">
        <?php  if ( $flag == "Dr" ) {  echo changeprice($mbal); $drtotal = $drtotal + $mbal; $pdr +=$mbal; $sdr +=$mbal;  } else { echo "&nbsp;"; } ?>
        </td>
		<td align="right">
         <?php  if ( $flag == "Cr" ) {  echo changeprice($mbal); $crtotal = $crtotal + $mbal; $pcr +=$mbal; $scr +=$mbal; } else { echo "&nbsp;"; }  ?>
        </td>
         
	</tr>
	<?php   $con = 0;
  }
 
  if($otype <> $type)
 $otype = $type;
  if($opsc <> $psc)
 $opsc = $psc;
 if($osc <> $sc)
 $osc = $sc; 
  
 } 
 if($displaytype == "Schedule" )	
if(($scr > 0 or $sdr > 0))
 {
 	?>
	<tr>
		<td class="ewRptGrpField3" align="right" colspan="<?php echo $span; ?>"><b>
		<?php echo ewrpt_ViewValue($sc." Total") ?></b>
		</td>
		<td align="right"><b>
        <?php  if ( $sdr > 0 ) {  echo changeprice($sdr);  } else { echo "0.00"; } ?></b>
        </td>
		<td align="right"><b>
         <?php  if ( $scr > 0 ) {  echo changeprice($scr);  } else { echo "0.00"; }  ?></b>
        </td>
         
	</tr>
	<?php 
	
	 }
 if($displaytype == "Schedule" or $displaytype == "Parent" )	 
 if(($pcr > 0 or $pdr > 0))
 {
 	?>
	<tr>
		<td class="ewRptGrpField3" align="right" colspan="<?php echo $span; ?>"><b>
		<?php echo ewrpt_ViewValue($psc." Total") ?></b>
		</td>
		<td align="right"><b>
        <?php  if ( $pdr > 0 ) {  echo changeprice($pdr);  } else { echo "0.00"; } ?></b>
        </td>
		<td align="right"><b>
         <?php  if ( $pcr > 0 ) {  echo changeprice($pcr);  } else { echo "0.00"; }  ?></b>
        </td>
         
	</tr>
	<?php 
	
	 }
  if($crtotal > 0 or $drtotal > 0)
 {
 	?>
	<tr>
		<td class="ewRptGrpField3" align="right" colspan="<?php echo $span; ?>"><b>
		<?php echo ewrpt_ViewValue($type." Total") ?></b>
		</td>
		<td align="right"><b>
        <?php  if ( $drtotal > 0 ) {  echo ewrpt_ViewValue(changeprice($drtotal)); $gdrtotal = $gdrtotal + $drtotal; } else { echo "0.00"; } ?></b>
        </td>
		<td align="right"><b>
         <?php  if ( $crtotal > 0 ) {  echo ewrpt_ViewValue(changeprice($crtotal)); $gcrtotal = $gcrtotal + $crtotal; } else { echo "0.00"; }  ?></b>
        </td>
         
	</tr>
	<?php 
 }


?>

<tr>
	<td class="ewRptGrpField1" colspan="<?php echo $span; ?>" align="right"><b>Grand Total</b>
		</td>
		<td align="right"><b>
<?php echo changeprice($gdrtotal); ?></b>
</td>
		<td align="right"><b>
<?php echo changeprice($gcrtotal);  ?></b>
</td></tr>
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
