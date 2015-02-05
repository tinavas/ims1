<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php"; 
/*if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 */
 
  if($_GET['flock'] <> "")
 {
  $flock=$_GET["flock"];
  $cond3=" where flock = '".$flock."'";
   //$cond4=" flockcode = '".$flock."'";
  }
else
 $flock = ""; 
 
 
 if($_GET['pen'] <> "")
 {
  $pen=$_GET["pen"];
  $cond2=" and pen = '".$pen."'";
  
  }
else
 $pen = ""; 

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Hatchery Report</font></strong></td>
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
&nbsp;&nbsp;<a href="templet.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="templet.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="templet.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="templet.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
 <td>Flock</td>
 <td><select name="flock" id="flock" style="width:100px;" onChange="reloadpage();">
     <option value="">-Select-</option>
	 <?php 
	 include "config.php";
	 $query = "select distinct(flock) from breeder_production order by flock";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['flock']; ?>" <?php if($flock == $rows['flock']) { ?> selected="selected" <?php } ?>><?php echo $rows['flock']; ?></option>
	 <?php } ?>
	 </select>	 </td>
	  <td>Pen</td>
 <td>
 <select id="pen" name="pen" onChange="reloadpage();">
 <option value="">All</option>
 <?php
 $query56 = "SELECT distinct(`area`) as area FROM `breeder_flockdistribution`  where client = '$client' and `flock`='$flock' and area <> '' order by area asc";
              $result = mysql_query($query56); 
              while($row = mysql_fetch_array($result))
              {  ?>
 <option value="<?php echo $row['area'] ?>" <?php if($row['area']==$pen) { ?> selected="selected" <?php } ?>><?php echo $row['area'] ?></option>
 <?php
 }
 ?>
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

		<td valign="bottom" class="ewTableHeader">

		Pen

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Pen</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

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

		<td valign="bottom" class="ewTableHeader">

		Age

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Age</td>

			</tr></table>

		</td>

<?php } ?>



<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Opening

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Opening</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Opening

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Opening</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Male Opening

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Male Opening</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Feed<br />(Kgs)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Feed<br />(Kgs)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Feed<br />(Kgs)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Feed<br />(Kgs)</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Eggs</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Eggs</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Table Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Table Eggs</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Total Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Total Eggs</td>

			</tr></table>

		</td>

<?php } ?>



<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Feed/Egg<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Feed/Egg<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Feed/Egg<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Feed/Egg<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Feed/Egg<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Feed/Egg<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" title="Cumulative Feed/Bird">

		C.Feed/Bird<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td title="Cumulative Feed/Bird">C.Feed/Bird<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 

$q11="SELECT Distinct(flock),pen FROM breeder_consumption  $cond3 $cond2  ORDER BY flock ASC "; 
$r11=mysql_query($q11);
while($row786=mysql_fetch_array($r11))
{
$x_flock=$row786[0];

?>
<td class="ewRptGrpField1">

		<?php echo ewrpt_ViewValue($x_flock); ?>

		</td>
		<td

		<td class="ewRptGrpField1">

		<?php echo ewrpt_ViewValue($row786['pen']); ?>

		</td>
<?php

            $q = "select age,date2 from breeder_consumption where flock = '$x_flock' order by date2 DESC "; 

  		$qrs = mysql_query($q,$conn1) or die(mysql_error());

		if($qr = mysql_fetch_assoc($qrs))

		{

              $age = $qr['age'];

              //$age1 = $age % 7; 

              //$age = round($age / 7);

              $nrSeconds = $age * 24 * 60 * 60;

              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 

              $nrWeeksPassed = floor($nrSeconds / 604800); 

              $nrYearsPassed = floor($nrSeconds / 31536000); 

			  

		 }

		  $mindate = "";

		  $maxdate = "";

	          $query14 = "SELECT min(date2) as mindate,max(date2) as maxdate FROM breeder_consumption where flock = '$x_flock'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $mindate = $row14['mindate'];

				 $maxdate = $row14['maxdate'];

              }

			  $flockdate = date($datephp,strtotime($maxdate));

         ?>

		<td class="ewRptGrpField1">

		<?php echo ewrpt_ViewValue($flockdate); ?>

		</td>
		<td

		<td class="ewRptGrpField1">

		<?php echo $nrWeeksPassed; ?>.<?php echo $nrDaysPassed; ?>

		</td>

<?php

              //include "config.php";

              $feedtypes = "''";

              $eggtypes = "''";

			  $hatchegg = "''";



              $query14 = "SELECT * FROM breeder_flock where flockcode = '$x_flock'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $femaleopening = $row14['femaleopening'];
                 $cfemaleopening = $row14['classicopening'];
                 $maleopening = $row14['maleopening'];

              }

             

			  $ftin = $cftin=$ftout = $cftout = $ttin = $cttin = $ttout = $cttout = $fpur = $cfput= $mpur = 0;

			  $query14 = "SELECT sum(quantity) as ftin from ims_stocktransfer where towarehouse = '$x_flock' and date <= '$mindate' and cat = 'Female Birds' and fromwarehouse <> '$x_flock' group by code";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {
			  if($row14['code'] == "FB101")
    			  $ftin = $row14['ftin'];
				 else		  
			      $cftin = $row14['ftin'];

              }

			  $q = "SELECT sum(receivedquantity) as quant,code FROM pp_sobi WHERE flock = '$x_flock' AND date <= '$mindate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds') group by code";  

             $r = mysql_query($q,$conn1) or die(mysql_error());

			 if(mysql_num_rows($r))

             {

		   while($qr = mysql_fetch_assoc($r))

    		   {

			  if($qr['code'] == "FB101")
			 $fpur = $fpur + $qr['quant'];
             else
			 $cfpur = $cfpur + $qr['quant'];

               }

             }

             else

             {

                $fpur = 0;
				$cfpur = 0;

             } 

			  

			  $query14 = "SELECT sum(quantity) as mtin from ims_stocktransfer where towarehouse = '$x_flock' and date <= '$mindate' and cat = 'Male Birds' and fromwarehouse <> '$x_flock' ";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $mtin = $row14['mtin'];

              }

			   $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date <= '$mindate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  

             $r = mysql_query($q,$conn1) or die(mysql_error());

			 if(mysql_num_rows($r))

             {

		   while($qr = mysql_fetch_assoc($r))

    		   {

			 $mpur = $mpur + $qr['quant'];

               }

             }

             else

             {

                $mpur = 0;

             } 

			  

              /*$query14 = "SELECT * FROM ims_itemcodes where cat = 'Female Feed'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $feedtypes = $feedtypes . ",'" . $row14['code'] . "'";

              }



              $query14 = "SELECT * FROM ims_itemcodes where cat = 'Male Feed'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $feedtypes = $feedtypes . ",'" . $row14['code'] . "'";

              }
*/


              $query14 = "SELECT * FROM ims_itemcodes where cat = 'Eggs'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $eggtypes = $eggtypes . ",'" . $row14['code'] . "'";

              }



              $query14 = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $hatchegg = $hatchegg . ",'" .$row14['code']."'";

              }

              

              $totalfeed = 0;

             

              $query14 = "SELECT sum(ffeed) as feed,sum(cfeed) as cfeed,sum(mfeed) as mfeed FROM breeder_consumption where flock = '$x_flock'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $totalfeed = $row14['feed'];
				 $ctotalfeed = $row14['cfeed'];
				 $totalfeedm = $row14['mfeed'];

              }




              $totaleggs = 0;

              $query14 = "SELECT sum(quantity) as 'eggs' FROM breeder_production where flock = '$x_flock' and itemcode in ($eggtypes)";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $totaleggs = $row14['eggs'];

              }



              $f15eggs = $classiceggs=$totalhatcheggs = 0;

            $query14 = "SELECT sum(quantity) as 'hatcheggs',itemcode FROM breeder_production where flock = '$x_flock' and itemcode in ($hatchegg) group by itemcode";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {
               if($row14['itemcode'] == "HE102" or $row14['itemcode'] == "F15")
                $f15eggs = $row14['hatcheggs'];
               else if($row14['itemcode'] == "HE101" or $row14['itemcode'] == "CLA")
                $classiceggs = $row14['hatcheggs'];
                 $totalhatcheggs += $row14['hatcheggs'];

              } 



              if($totalhatcheggs == '') { $totalhatcheggs = 0;}

			  if($totaleggs == '') { $totaleggs = 0;}

?>

		<td<?php echo $sItemRowClass; ?> align="right" >

<?php  echo (changequantity($femaleopening + $ftin + $fpur)); ?>

<td<?php echo $sItemRowClass; ?> align="right" >

<?php  echo (changequantity($cfemaleopening + $cftin + $cfpur)); ?>

</td>

		<td<?php echo $sItemRowClass; ?> align="right" >

<?php  echo (changequantity($maleopening + $mtin + $mpur)); ?>

</td>

		<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changeprice(round($totalfeed,2)); ?>

<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changeprice(round($ctotalfeed,2)); ?>

</td>

		<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changequantity($f15eggs); ?>

</td>
		<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changequantity($classiceggs); ?>

</td>
		<td<?php echo $sItemRowClass; ?>  align="right" >

<?php echo changequantity($totaleggs); ?>

</td>

		<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changequantity($totaleggs + $totalhatcheggs); ?>

</td>

	

<?php

$q1 = "SELECT min(date1) as mindate FROM breeder_production WHERE flock = '$x_flock' AND itemcode in (select distinct(code) from ims_itemcodes where cat LIKE '%Eggs%') AND client = '$client'";

$r1 = mysql_query($q1,$conn1) or die(mysql_error());

$rows1 = mysql_fetch_assoc($r1);

$mindate = $rows1['mindate'];



$q2 = "SELECT SUM(ffeed) as quantity,sum(cfeed) as classic FROM breeder_consumption WHERE flock = '$x_flock' AND date2 >= '$mindate'";
$r2 = mysql_query($q2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($r2);
$totalfeed2 = $rows2['quantity'];
$ctotalfeed2 = $rows2['classic'];



if($mindate == "")
{
$totalfeed2 = 0;
$ctotalfeed2 = 0;
}



?>

		<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changeprice(round(($totalfeed2 * 1000)/$f15eggs,2)); ?>

</td>
<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changeprice(round(($ctotalfeed2 * 1000)/$classiceggs,2)); ?>

</td>
		<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changeprice(round((($totalfeed2 + $ctotalfeed2) * 1000)/($totaleggs + $totalhatcheggs),2)); ?>

</td>

	<td<?php echo $sItemRowClass; ?> align="right" >

<?php echo changeprice(round((($totalfeed + $ctotalfeed + $totalfeedm) * 1000)/($femaleopening + $maleopening + $ftin + $fpur  + $mtin + $mpur + $cfemaleopening  + $cftin + $cfpur),2)); ?>

</td>





	</tr>
<?php }
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

	var flock = document.getElementById('flock').value;
	var pen = document.getElementById('pen').value;
	document.location = "penwisefeedeggbird1.php?flock=" + flock+ "&pen=" + pen;
	//document.location = "templet.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>