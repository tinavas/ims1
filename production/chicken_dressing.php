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
 $cond="where `date` between '$fromdate' and '$todate'";
$unit=$_GET['unit'];
 if($unit == "")
 {
$cond=$cond."";
$unit="";
}
else
{
$cond=$cond." and unit='$unit' ";

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Chicken Dressing</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr> 
<?php

  if($unit==""){} else{
  ?>
<tr>
 
 <td colspan="2" align="center"><strong><font color="#3e3276">Unit: </font></strong><?php echo $unit; ?></td></tr><?php } ?>


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
&nbsp;&nbsp;<a href="chicken_dressing.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&unit=<?php echo $unit;?> ">Printer Friendly</a>
&nbsp;&nbsp;<a href="chicken_dressing.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&unit=<?php echo $unit;?> ">Export to Excel</a>
&nbsp;&nbsp;<a href="chicken_dressing.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?> &unit=<?php echo $unit;?> ">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chicken_dressing.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?> &unit=<?php echo $unit;?> ">Reset All Filters</a>
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
 <td>Unit</td>
 <td><select name="unit" id="unit" onChange="reloadpage()">
   <option value="">--All--</option>
   <?php

 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Processing Unit' || type1 = 'Chicken Center' and client = '$client' order by sector";
 $r1 = mysql_query($q1,$conn1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
   <option value="<?php echo $row1['sector']; ?>"<?php if($unit==$row1['sector']) { ?> selected="selected"<?php }?>><?php echo $row1['sector']; ?></option>
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
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Transaction No
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction No</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		From Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		From Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		From Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		From Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Output Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Output Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Output Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Output Description</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Yeidld%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Yeild%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Wastage
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Wastage</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Wastage%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Wasatge%</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
{
$count1=0;
$iqty=0;
$oqty=0;
$twastage=0;
$ikgs=0;
$okgs=0; 
 $query="SELECT distinct(tid) FROM `chicken_chickentransferdressing` $cond ";
$result=mysql_query($query,$conn1);
while($row=mysql_fetch_array($result))
{$count=0;
 $query1 ="SELECT * FROM `chicken_chickentransferdressing` where tid='$row[tid]' ";
$result1=mysql_query($query1,$conn1);
while($row1=mysql_fetch_array($result1))
{$yeild=($row1['kgs']/$row1['weight'])*100;
$query2="select sum(kgs) as opweight from `chicken_chickentransferdressing` where tid='$row[tid]' ";
$result2=mysql_query($query2,$conn1);
$row2=mysql_fetch_array($result2);
$wastage=$row1['weight']-$row2['opweight'];
$wastageper=($wastage/$row1['weight'])*100;
$count1=1;

?>
	<tr>
		<td class="ewRptGrpField2">
<?php if($count==0) echo ewrpt_ViewValue(date("d.m.Y",strtotime($row1['date'])));  else echo ewrpt_ViewValue("&nbsp"); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php if($count==0) echo ewrpt_ViewValue($row1['unit']);   else echo ewrpt_ViewValue("&nbsp"); ?></td>
		<td class="ewRptGrpField1" align="right">
		<?php if($count==0) echo ewrpt_ViewValue($row1['tid']);   else echo ewrpt_ViewValue("&nbsp"); ?></td>
		<td class="ewRptGrpField2">
		<?php if($count==0) echo ewrpt_ViewValue($row1['fromtype']);   else echo ewrpt_ViewValue("&nbsp"); ?></td>
		<td class="ewRptGrpField2">
		<?php if($count==0) echo ewrpt_ViewValue($row1['fromcode']); else echo ewrpt_ViewValue("&nbsp"); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php if($count==0) { echo ewrpt_ViewValue($row1['birds']); $iqty=$iqty+$row1['birds'];}  else echo ewrpt_ViewValue("&nbsp");  ?></td>
		<td class="ewRptGrpField2">
		<?php if($count==0) { echo ewrpt_ViewValue(changeprice($row1['weight'])); $ikgs=$ikgs+$row1['weight']; }  else echo ewrpt_ViewValue("&nbsp");  ?></td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue($row1['tocode']);  echo ewrpt_ViewValue("&nbsp");?></td>
		<td class="ewRptGrpField1" align="right">
			<?php echo ewrpt_ViewValue($row1['todescription']); ?></td>
		<td class="ewRptGrpField2">
		<?php echo ewrpt_ViewValue($row1['quantity']);
		$oqty=$oqty+$row1['quantity']; ?></td>
		<td class="ewRptGrpField3" align="right">
		<?php echo ewrpt_ViewValue(changeprice($row1['kgs'])); $okgs=$okgs+$row1['kgs']; ?></td>
		<td class="ewRptGrpField1" align="right">
		<?php echo ewrpt_ViewValue(changeprice($yeild)); ?></td>
	<td class="ewRptGrpField3" align="right">
		<?php if($count==0 && $wastage!=0) {  echo ewrpt_ViewValue(changeprice($wastage));   $twastage=$twastage+$wastage;}else  if($wastage==0 && $count==0) { echo ewrpt_ViewValue(changeprice("0"));   $twastage=$twastage+$wastage;} else echo ewrpt_ViewValue("&nbsp");   ?></td>
		<td class="ewRptGrpField1" align="right">
		<?php if($count==0 && $wastageper!=0) echo ewrpt_ViewValue(changeprice($wastageper)); else if($wastageper==0 && $count==0) echo ewrpt_ViewValue(changeprice("0"));  else echo ewrpt_ViewValue("&nbsp");   ?></td>

	</tr>
<?php
$count++;}}
$twastageper=($twastage/$ikgs)*100;
$yeildper=($okgs/$ikgs)*100;
?>

<tr>
<td colspan="5" align="right">Total</td>
<td align="right"><?php echo $iqty; ?></td>
<td><?php echo changeprice($ikgs);?></td>
<td colspan="2"><?php echo "&nbsp";?></td>
<td align="right"><?php echo $oqty;?></td>
<td align="right"><?php echo changeprice($okgs);?></td>
<td><?php echo  changeprice($yeildper);?></td>
<td align="right"><?php echo changeprice($twastage);?></td>
<td><?php echo changeprice($twastageper);?></td>
</tr>

<?php

if($count1==0)
{
?>
<tr>
<td colspan="14" align="left"> No records Found</td>
<?php }


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
<?php } 

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
	
	
function makecomma($input)
{
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

?>
 
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var units = document.getElementById('unit').value;
	document.location = "chicken_dressing.php?fromdate=" + fdate + "&todate=" + tdate+"&unit="+units;
}
</script>