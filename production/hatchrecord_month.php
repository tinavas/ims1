<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
 if($_GET['hatchery'] <> "")
 $hatchery = $_GET['hatchery'];
 else
 $hatchery ='Hatchery';
 
 if($_GET['year'] <> "")
 $year = $_GET['year'];
 else
 $year =date("Y");
 
 
 if($_GET['flock'] <> "" && $_GET['flock']!='All')
 $cond = "and flock ='".$_GET[flock]."'";
 else
 $cond ='';
 
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
 <td align="center"><strong><font color="#3e3276">Hatch Report of <?php echo $year ?></font></strong></td>
</tr>
<tr>
 <td align="center"><strong><font color="#3e3276">Flock : <?php if($_GET[flock] <> '') echo $_GET[flock]; else echo 'All' ?></font></strong></td>
</tr>
<tr height="5px"></tr>
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
&nbsp;&nbsp;<a href="hatchrecord_month.php?export=html&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="hatchrecord_month.php?export=excel&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="hatchrecord_month.php?export=word&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="hatchrecord_month.php?cmd=reset&&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Reset All Filters</a>
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
 
 <td> Year </td>
 <td><select onchange="reloadpage()" id="year">
 
 <option <?php if($year=='2011') echo 'selected="selected"' ?> value="2011" >2011</option>
  <option <?php if($year=='2012') echo 'selected="selected"' ?> value="2012" >2012</option>
   <option <?php if($year=='2013') echo 'selected="selected"' ?> value="2013" >2013</option>
    <option <?php if($year=='2014') echo 'selected="selected"' ?> value="2014" >2014</option>
	 <option <?php if($year=='2015') echo 'selected="selected"' ?> value="2015" >2015</option>
	  <option <?php if($year=='2016') echo 'selected="selected"' ?> value="2016" >2016</option>
	   <option <?php if($year=='2017') echo 'selected="selected"' ?> value="2017" >2017</option>

 </select></td>
 
 <td> Hatchery </td>
 <td><select onchange="reloadpage()" id="hatchery">
 <?php
 include 'config.php';
 $q="select sector from tbl_sector where type1='Hatchery'";
 $r=mysql_query($q);
 while($a=mysql_fetch_array($r)) {
 ?>
 <option value="<?php echo $a[sector] ?>" ><?php echo $a[sector] ?></option>
 <?php } ?>
 </select></td>
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
		Month
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Month</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Eggs Set
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Eggs Set</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Chicks <br />
Hatched
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Chicks <br />
Hatched</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Hatch %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatch %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Salable<br />
Chicks
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Salable<br />
Chicks</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Culls
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Culls</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Culls%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Culls%</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 

//opening calculation start

$month=$i=0;
           while($month<12)
           {  
		   $totaleggs=$sales=$shortage=$trayseteggs=0;
		   $month++;
		   if($month<10)
		    $month_q='0'.$month;
		   else
		    $month_q=$month;
		   
		   $query1 = "SELECT sum( noofeggsset ) AS eggsset, sum( rejections ) AS rejections, sum( culls ) as culls FROM `hatchery_hatchrecord` where settingdate like '$year-$month_q%'  $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1)) {
		      $trayseteggs=$array1[eggsset];	  
			  $rejections=$array1[rejections];
			  $culls=$array1[culls];
			  }
?>
	<tr>
	<td class="ewRptGrpField2">
<?php  echo date("F",strtotime($year.'-'.$month_q.'-01')); ?></td> 
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php if($trayseteggs=='') $trayseteggs=0; echo changeprice1($trayseteggs);  $totaltrayseteggs+=$trayseteggs;?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php $chicks=$trayseteggs-$rejections; if($chicks=='') $chicks=0; else  $i++; echo changeprice1($chicks);  $totalchicks+=$chicks;?></td>
<td align="center" class="ewRptGrpField1" >
<?php $chicksper=round(($chicks*100/$trayseteggs),2) ; echo changeprice($chicksper);   $totalchicksper+=$chicksper;?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php  $salechicks=$chicks-$culls ; echo changeprice1($salechicks);   $totalsalechicks+=$salechicks;?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php if($culls=='') $culls=0; echo changeprice1($culls);   $totalculls+=$culls;?></td>
<td class="ewRptGrpField1" align="center" style="padding-right:5px;">
<?php $cullsper=round(($culls*100/$chicks),2); echo changeprice($cullsper);   $totalcullsper+=$cullsper;?></td>
	</tr>
<?php
 }
?>
<tr>
		<td align="right" class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(Total) ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php echo changeprice1($totaltrayseteggs); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php echo changeprice1($totalchicks); ?></td>
<td class="ewRptGrpField1" align="center" style="padding-right:5px;">
<?php echo round($totalchicksper/$i,2); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php echo changeprice1($totalsalechicks); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:5px;">
<?php echo changeprice1($totalculls); ?></td>
<td class="ewRptGrpField1" align="center" style="padding-right:5px;">
<?php echo round($totalcullsper/$i,2); ?></td>
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
	var year=document.getElementById('year').value;
	var hatchery = document.getElementById('hatchery').value;
	var flock = document.getElementById('flock').value;
	document.location = "hatchrecord_month.php?year="+year+'&hatchery=' + hatchery+'&flock=' + flock;
}
</script>
