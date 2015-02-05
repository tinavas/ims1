<?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <!--<style type="text/css">
        #head1 {
            position: absolute;  
            height: 20px;
            top: expression(this.offsetParent.scrollTop);
        }
		#head2 {
            position: absolute; 
			margin-top:20px;
            height: 20px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:40px; 
            overflow: scroll; 
        }
    </style>-->
<?php } 
include "reportheader.php"; 
include "getemployee.php"; 
if($_GET['fromdate'] <> "")
{
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
 $todate = date("Y-m-d",strtotime($_GET['todate']));
 $unit = $_GET['unit'];
 $flock = $_GET['flock'];
 $condition = "and flock = '$flock'";
 }
else
{
 $fromdate=$todate=date("Y-m-d"); 
 $unit = $flock = "";
 $condition = "";
} 
if($flock == "ALL")
$condition = "";

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Culls Details</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>From Date : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?> <td><strong>   To Date : </strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="daywiseculls.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&unit=<?php echo $unit;?>&flock=<?php echo $flock;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="daywiseculls.php?export=excel&fromdate=<?php echo $fromdate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="daywiseculls.php?export=word&fromdate=<?php echo $fromdate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="daywiseculls.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
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
 <td>From Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>" onchange="reloadpage1();"  /></td>
 <td>To Date </td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>" onchange="reloadpage1();" /></td>
 <td>Unit</td><td><select id="unit" onchange="getflocks(this.value)">
 <option value="">-Select-</option>
 <option value="ALL" <?php if($unit == "ALL"){?>selected="selected"<?php } ?>>All</option>
 <?php 
 $result = mysql_query("select distinct(unitcode),unitdescription from breeder_unit order by unitcode",$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
 {?>
 <option value="<?php echo $res['unitcode'];?>" title="<?php echo $res['unitdescription'];?>" <?php if($unit == $res['unitcode']){?> selected="selected"<?php } ?>><?php echo $res['unitcode'];?></option>
 <?php
 } 
 ?>
 </select></td>
  <td>Flock</td><td><select id="flock" onchange="reloadpage()">
   <option value="">-Select-</option>
  <option value="ALL" <?php if($flock == "ALL"){?>selected="selected"<?php } ?>>All</option>
  <?php if($unit <> 'ALL' && $unit <> '') { 
     $result = mysql_query("select distinct(flockcode),flockdescription from breeder_flock where unitcode = '$unit' and cullflag <> 1 order by flockcode",$conn1) or die(mysql_error());
	 while($res = mysql_fetch_assoc($result))
	 {
  ?>
  <option value="<?php echo $res['flockcode'];?>" title="<?php echo $res['flockdescription']; ?>" <?php if($flock == $res['flockcode']){?> selected="selected"<?php } ?>><?php echo $res['flockcode'];?></option>
  <?php } } ?>
  </select></td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr id="head1">
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" style="width:100px;" align="center">
		Culls
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Culls</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	<tr id="head2">
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:50px;" align="center">
		Female
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:50px;" align="center">Female</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:50px;" align="center">
		Male
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:50px;" align="center">Male</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$predate = $preunit = "";
if($unit == "ALL" && $flock == "ALL")
  $query = "select date2,flock,fcull,mcull,unitcode from breeder_consumption bc,breeder_flock bf where bc.flock = bf.flockcode and date2 >= '$fromdate' and date2 <= '$todate' and (fcull <> 0 or mcull <> 0) $condition group by date2 asc,flock asc,unitcode asc";
 else if($unit <> "ALL" && $flock == "ALL")
 $query = "select date2,flock,fcull,mcull,unitcode from breeder_consumption bc,breeder_flock bf where bc.flock = bf.flockcode and bf.unitcode = '$unit' and date2 >= '$fromdate' and date2 <= '$todate' and (fcull <> 0 or mcull <> 0) $condition group by date2 asc,flock asc,unitcode asc";
 else
  $query = "select date2,flock,fcull,mcull from breeder_consumption where date2 >= '$fromdate' and date2 <= '$todate' and flock = '$flock' and (fcull <> 0 or mcull <> 0) group by flock asc,date2 asc";
  
 
$result = mysql_query($query,$conn1) or die(mysql_error()); 
while($res = mysql_fetch_assoc($result))
{ 
$bookinv = "N.A";
?>
	<tr>
   <?php $q="select bookinvoice from oc_cobi where date='$res[date2]' and flock='$res[flock]'; ";
	$r= mysql_query($q,$conn1) or die(mysql_error()); 
	if($a = mysql_fetch_assoc($r)) $bookinv=$a['bookinvoice'];
	?>
		<td class="ewRptGrpField2">
<?php if($predate == $res['date2']) echo "&nbsp;"; else {echo date("d.m.Y",strtotime($res['date2'])); $predate = $res['date2']; } ?></td>
		<td class="ewRptGrpField3" >
<?php if($unit == "ALL" && $flock == "ALL") 
      {
	  if($preunit == $res['unitcode']) 
	  echo "&nbsp;"; 
	  else  echo $preunit =$res['unitcode'];
	  }
	  else
	   { 
	   if($preunit == $unit) 
	   echo "&nbsp;"; 
	   else echo $preunit=$unit; 
	   } ?></td>
		<td class="ewRptGrpField1" >
<?php echo $res['flock']; ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo $res['fcull']; $tfcull+=$res['fcull']; ?></td>
<td class="ewRptGrpField1" align="right" >
<?php echo $res['mcull']; $tmcull+=$res['mcull']; ?></td>

	</tr>
<?php
}
?>
	</tbody>
	<tfoot>
<tr><td colspan="3" align='right'><b>Total</b></td><td align='right' > <b><?php echo changeprice1($tfcull); ?></b></td><td align='right' ><b><?php echo changeprice1($tmcull); ?></b></td></tr>
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
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var unitcode = document.getElementById('unit').value;
	var flock = document.getElementById('flock').value;
	document.location = "daywiseculls.php?fromdate=" + fdate + "&todate=" + tdate + "&unit=" + unitcode + "&flock=" +flock;
}
function reloadpage1()
{
   var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var unitcode = document.getElementById('unit').value;
	var flock = document.getElementById('flock').value;
	if(unitcode != "" && flock != "")
	document.location = "daywiseculls.php?fromdate=" + fdate + "&todate=" + tdate + "&unit=" + unitcode + "&flock=" +flock;
}
function getflocks(unitcode)
{
if(unitcode == "ALL")
{
document.getElementById("flock").value == "ALL";
var fdate = document.getElementById('fromdate').value;
var tdate = document.getElementById('todate').value;
document.location = "daywiseculls.php?fromdate=" + fdate + "&todate=" + tdate + "&unit=ALL&flock=ALL";

}
else
{
 removeAllOptions(document.getElementById('flock'));
	myselect1 = document.getElementById('flock');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("ALL");
theOption1.value = "ALL";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php 
$result = mysql_query("select distinct(flockcode),flockdescription,unitcode from breeder_flock where cullflag <> 1 order by flockcode",$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
?>
if(unitcode == "<?php echo $res['unitcode']; ?>")
{
            theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $res['flockcode'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $res['flockcode'];?>";
	        theOption1.title = "<?php echo $res['flockdescription'];?>";
              myselect1.appendChild(theOption1);
}
<?php } ?>
}
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

</script>