<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; include "getemployee.php";

if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
 
 if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
 else
 $todate = date("Y-m-d");
 
 if($_GET['hatchery'] <> "")
 $hatchery = $_GET['hatchery'];
 else
 $hatchery ='Hatchery';
 
 if($_GET['flock'] <> "" && $_GET['flock']!='All')
 $cond = "and flockcode ='".$_GET[flock]."'";
 else
 $cond ='';
 
 $q = "select distinct(warehouse) from tbl_sector WHERE sector='$hatchery' and type1 = 'Hatchery' order by sector ";
 $qrs = mysql_query($q,$conn1);
 if($qr = mysql_fetch_assoc($qrs))
 {
   $coldroom = $qr['warehouse'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Egg Transfer Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong> From Date : </strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
 <td><strong> To Date: </strong><?php echo date($datephp,strtotime($todate)); ?></td>
</tr> 
<tr>
 <td align="center" ><strong> Hatchery : </strong><?php echo $hatchery; ?></td>

 <td align="center"><strong><font color="#3e3276">Flock : <?php if($_GET[flock] <> '') echo $_GET[flock]; else echo 'All' ?></font></strong></td>
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
&nbsp;&nbsp;<a href="eggtransfer.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>&flock=<?php echo $_GET[flock]; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="eggtransfer.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>&flock=<?php echo $_GET[flock]; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="eggtransfer.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>&flock=<?php echo $_GET[flock]; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="eggtransfer.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>">Reset All Filters</a>
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
 <td> From Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 
 <td> To Date </td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
 
 <td>&nbsp;&nbsp;</td>
 <td> Flock </td>
 <td><select onchange="reloadpage()" id="flock">
 <option <?Php if($_GET['flock']=='All') echo 'selected="selected"'; ?> value="All" >All</option>
 <?php
 echo $q="select distinct(flkmain) as flkmain from breeder_flock order by flkmain";
 $r=mysql_query($q);
 while($a=mysql_fetch_array($r)) {
 ?>
 <option  <?Php if($_GET['flock']==$a[flkmain]) echo 'selected="selected"'; ?> value="<?php echo $a[flkmain] ?>" ><?php echo $a[flkmain] ?></option>
 <?php } ?>
 </select></td>
 
 <td> Hatchery </td>
 <td><select id="hatchery">
 <?php
 include 'config.php';
 $q="select sector from tbl_sector where type1='Hatchery'";
 $r=mysql_query($q);
 while($a=mysql_fetch_array($r)) {
 ?>
 <option value="<?php echo $a[sector] ?>" ><?php echo $a[sector] ?></option>
 <?php } ?>
 </select></td>
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
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Hatchery
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatchery</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		From Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
	To Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">To Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Hatch Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatch Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php
$query="select code from ims_itemcodes where cat='Hatch Eggs'";
$result=mysql_query($query);
$i=-1;
while($array=mysql_fetch_assoc($result))
 {
 $hatcheggcode[++$i]=$array[code];
 }
 $query="SELECT distinct(tocode),lower(todescription) as todescription FROM ims_eggtransfer where client = '$client'  and date >= '$fromdate' and date <= '$todate' and tocode not in (select code from ims_itemcodes where cat='Hatch Eggs') order by tocode";
$result=mysql_query($query);
$eggcodecount=-1;
while($array=mysql_fetch_assoc($result))
 {
 $eggcodecount++;
 $eggcode[$eggcodecount]=$array[tocode];
 $eggdescription[$eggcodecount]=$array[todescription];
 $eggqnty[$eggcodecount]=0;
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		<?php echo ucfirst($array[todescription]); ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php echo ucfirst($array[todescription]); ?></td>
			</tr></table>
		</td>
<?php } } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Waste Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Waste Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Total Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Total Eggs</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 

   $query = "SELECT distinct(tid) FROM ims_eggtransfer where client = '$client' $cond and date >= '$fromdate'  and date <= '$todate' order by date";
           $result = mysql_query($query,$conn1) or die(mysql_error()); 
           while($row1 = mysql_fetch_assoc($result))
           {  
           $query1 = "SELECT * FROM ims_eggtransfer where client = '$client' $cond and date >= '$fromdate' and date <= '$todate' and tid = '$row1[tid]'";
           $result1 = mysql_query($query1,$conn1); 
		  $hatcheggs= $othereggs= $totaleggs=0;
		   $i=1;
           while($row2 = mysql_fetch_assoc($result1))
            {  
			 
			   if(in_array($row2[tocode],$hatcheggcode)) 
                  $hatcheggs+=$row2[toeggs];
			   else	{
				 $eggqnty[array_search($row2[tocode],$eggcode)]=$row2[toeggs];
				  }
				
			   $totaleggs+=$row2[toeggs];
			   if($i--) 
			   {
			   $fromeggs=$row2[fromeggs];
			   $towarehouse=$row2[towarehouse];
			   $flock=$row2['flockcode'];
			   $fromwarehouse=$row2[fromwarehouse];
			   $date=date($datephp,strtotime($row2['date']));
			   }
            } 
			$wasteeggs=$fromeggs-$totaleggs;
?>
	<tr>
	<td class="ewRptGrpField2">
<?php if($dup_date!=$date) echo $date; else echo '&nbsp;'; $dup_date=$date; ?></td>
		<td class="ewRptGrpField2">
<?php if($dup_hatchery!=$hatchery) echo $hatchery; else echo '&nbsp;'; $dup_hatchery=$hatchery; ?></td>
		<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($fromwarehouse); ?></td>
		<td class="ewRptGrpField1" >
<?php echo ewrpt_ViewValue($towarehouse); ?></td>
<td class="ewRptGrpField1" >
<?php echo ewrpt_ViewValue($flock); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($hatcheggs); $total_hatcheggs+=$hatcheggs; ?></td>
<?php for($i=0;$i<count($eggcode);$i++) { ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($eggqnty[$i]); $$eggcode[$i]+=$eggqnty[$i]; $eggqnty[$i]=0; ?></td><?php } ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($wasteeggs); $total_waste+=$wasteeggs; ?></td> 
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($totaleggs+$wasteeggs); $total+=($totaleggs+$wasteeggs) ?></td>
	</tr>
<?php
}
?>
<tr>
		<td colspan="5" align="right" class="ewRptGrpField2">
<strong><?php echo ewrpt_ViewValue(Total) ?></strong></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<strong><?php echo changeprice1($total_hatcheggs); ?></strong></td>
<?php for($i=0;$i<count($eggcode);$i++) { ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<strong><?php echo changeprice1($$eggcode[$i]); ?></strong></td><?php } ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<strong><?php echo changeprice1($total_waste); ?></strong></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<strong><?php echo changeprice1($total); ?></strong></td></strong>
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
<?php } include "phprptinc/footer.php"; ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var hatchery = document.getElementById('hatchery').value;
    var flock = document.getElementById('flock').value;
	document.location = "eggtransfer.php?fromdate=" + fdate+'&todate=' + tdate+'&hatchery=' + hatchery+'&flock=' + flock;
}
</script>
