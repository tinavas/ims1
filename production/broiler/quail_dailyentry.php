<?php 

$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "../../getemployee.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 


$sExport = @$_GET["export"]; 
if (@$sExport == "") { 



?>
 
  <!--<style type="text/css">
        thead tr {
            position: absolute; 
            height: 30px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:30px; 
            overflow: scroll; 
        }
    </style>-->
<?php } ?>

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
 <td> <strong><font color="#3e3276">Live Flocks Daily Entry Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 
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
&nbsp;&nbsp;<a href="quail_dailyentry.php?export=html&fromdate=<?php echo $fromdate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="quail_dailyentry.php?export=excel&fromdate=<?php echo $fromdate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="quail_dailyentry.php?export=word&fromdate=<?php echo $fromdate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="quail_dailyentry.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
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
		<td valign="bottom" class="ewRptGrpHeader1">
		Place
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Place</td>
			
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Farmer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Farmer</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader4">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Entrydate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Entrydate</td>
			
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
		<td valign="bottom" class="ewTableHeader" title="Mortality">
		Mort.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Mortality">Mort.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Mortality">
		C.Mort.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Mortality">C.Mort.</td>
			</tr></table>
		</td>
<?php } ?> 
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Mortality">
		C.Mort %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Mortality %">C.Mort %</td>
			</tr></table>
		</td>
<?php } ?> 
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Trnasfer In" >
		Tr.In 
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Trnasfer In">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td >Tr.In</td>
			</tr></table>
		</td>
<?php } ?> 
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Trnasfer Out" >
		Tr.Out
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Trnasfer Out">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td >Tr.Out</td>
			</tr></table>
		</td>
<?php } ?> 
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Birds</td>
			</tr></table>
		</td>
<?php } ?>

<?php
if($_SESSION['db'] == 'central')
{
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sent/Transfer <br /> Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sent/Transfer <br /> Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php 

if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sent/Transfer<br />Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sent/Transfer<br /> Weight</td>
			</tr></table>
		</td>
<?php } } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Consumed">
		F.cons
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Feed Consumed">F.cons</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Feed Consumed">
		C.Feed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed Consumed">C.Feed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed/Bird Standard">
		Feed/Bird Std
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Feed/Bird Standard">Feed/Bird Std</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Intake Per Bird">
		Feed/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed Consumed">Feed/Bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Feed Per Bird Standard">
		C.Feed/Bird Std
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed Per Bird Standard">C.Feed/Bird Std</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Feed/Bird ">
		C.Feed/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed/Bird">C.Feed/Bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Average Weight">
		Std A.Weight 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Standard Average Weight">Std A.Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Average Weight">
		A.Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Average Weight">A.Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Std F.C.R
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std F.C.R</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="F.C.R">
		F.C.R
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="F.C.R">F.C.R</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td style="display:none" valign="bottom" class="ewTableHeader" title="Medicine Name">
		M.Name
		</td>
<?php } else { ?>
		<td style="display:none" class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Medicine Name">M.Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td style="display:none" valign="bottom" class="ewTableHeader" title="Medicine Quantity">
		M.Qty
		</td>
<?php } else { ?>
		<td style="display:none"class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Medicine Quantity">M.Qty</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Vaccine Name">
		V.Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Vaccine Name">V.Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Vaccine Quantity">
		V.Qty
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Vaccine Quantity">V.Qty</td>
			</tr></table>
		</td>
<?php } ?>	
	</tr>
	</thead>
	<tbody>
<?php 

// Retrieving Standard Values
	$queryaa = "SELECT feed,cumfeed,fcr,avgweight,age FROM quail_broiler_allstandards order by age";
$resultaa = mysql_query($queryaa,$conn1);
while($rowaa = mysql_fetch_assoc($resultaa))
{
  $feedstdarr[$rowaa['age']] = $rowaa['feed'];
  $cumfeedstdarr[$rowaa['age']] = $rowaa['cumfeed'];
  $stdfcrarr[$rowaa['age']] = $rowaa['fcr'];
  $stdwtarr[$rowaa['age']] = $rowaa['avgweight'];
} 
// retriving medicine and vaccine names	
$result = mysql_query("select distinct(code),description from ims_itemcodes where cat = 'Medicines' or cat = 'Vaccines'",$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$medicinevaccine[$res['code']] = $res['description'];


$query = "SELECT d1.place,d1.farm,d1.flock,d1.entrydate,d1.age,d1.mortality,d1.feedconsumed,d1.average_weight,d1.medicine_name,d1.medicine_quantity,d1.vaccine_name,d1.vaccine_quantity FROM quail_broiler_daily_entry d1 INNER JOIN ( SELECT flock,MAX(entrydate) AS entrydate FROM quail_broiler_daily_entry where cullflag <> 1 GROUP BY flock) d2 ON d2.flock = d1.flock AND d2.entrydate = d1.entrydate group by flock order by d1.place,d1.farm,d1.flock";
$result = mysql_query($query,$conn1) or die(mysql_error()); 
$preplace=$presuper=$prefarm="";
while($res = mysql_fetch_assoc($result))
{
 $query2 = "select sum(mortality) as cmortality,sum(feedconsumed) as cfeedconsumed,sum(cull) as ccull,max(average_weight) as avw from quail_broiler_daily_entry where flock = '$res[flock]' and farm = '$res[farm]'";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$res2 = mysql_fetch_assoc($result2);

	$cmortality = $res2['cmortality'];
	$cfeedconsumed = $res2['cfeedconsumed'];
    $ccull = $res2['ccull'];
	$avw = $res2['avw'];
	
 $birds = 0;
  $soldbirds = 0;
  $sentbirds = 0;
  $query111a = "SELECT (sum(quantity) - sum(tmort) - sum(shortage)) as chicks FROM ims_stocktransfer where aflock = '$res[flock]' and towarehouse = '$res[farm]' AND cat = 'Quail Chicks'"; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
  if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) { $birds = $birds + $row111a['chicks'];  } }
  
  // fattener birds transfer calculation
  $fatquery = "select sum(mbirds) as mbirds,sum(fbirds) as fbirds from quail_broiler_fattenertransfer where ffarm = '$res[farm]' and fflock = '$res[flock]' and client = '$client'";
  $fatresult = mysql_query($fatquery,$conn1) or die(mysql_error());
  $fatres = mysql_fetch_assoc($fatresult);
  $transferedbirds = $fatres['mbirds'] + $fatres['fbirds'];
  
  // fattener birds sending details
  $sentquery = "SELECT sum(birds) as birds from quail_broiler_chickentransfer where flock = '$res[flock]'";
  $sentresult = mysql_query($sentquery,$conn1) or die(mysql_error()); 
  $sentres = mysql_fetch_assoc($sentresult);
   if($sentres['birds'])
   $sentbirds = $sentres['birds']; 
 
 /// transfer in birds 
  $transferin = 0;
    $query111a = "SELECT (sum(quantity) - sum(tmort) - sum(shortage)) as chicks FROM ims_stocktransfer where aflock = '$res[flock]' and towarehouse = '$res[farm]' AND cat = 'Fattener Birds'"; 
	$result111a = mysql_query($query111a,$conn1);  
	$rowsa = mysql_num_rows($result111a);
  if( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) { if($row111a['chicks'])$transferin = $row111a['chicks'];  } }
  
  
  // transfered out birds
   $transferout = 0;
    $query111a = "SELECT (sum(quantity) - sum(tmort) - sum(shortage)) as chicks FROM ims_stocktransfer where tflock = '$res[flock]' and fromwarehouse = '$res[farm]' AND (cat = 'Fattener Birds' )"; 
	$result111a = mysql_query($query111a,$conn1);  
	$rowsa = mysql_num_rows($result111a);
  if( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) { if($row111a['chicks']) $transferout = $row111a['chicks'];  } }
  

  //if(($birds == "") OR ($birds == 0))
  {
   $query111a = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$res[flock]' and warehouse = '$res[farm]' and description = 'Quail Chicks' "; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
   if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) {   $birds = $birds + $row111a['chicks'];  } }
  }
  
  $query111 = "SELECT sum(birds) as chicks FROM oc_cobi where flock = '$res[flock]' and code = 'FBRD100'"; 
  
   $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $soldbirds = $row111['chicks'];  } }
  
 // broiler send birds calculation
if($_SESSION['db'] == 'central')
{
  $sentquery = "SELECT sum(birds) as birds,sum(weight) as weight from broiler_chickentransfer where flock = '$res[flock]'";
  $sentresult = mysql_query($sentquery,$conn1) or die(mysql_error()); 
  $sentres = mysql_fetch_assoc($sentresult);
  $birds = $birds - $sentres['birds']; 
  $sentbirds = $sentres['birds']; 
  $sentweight = $sentres['weight']; 
  }
     
  $oobirds = $birds;
  $birds = $birds + $transferin - $cmortality - $soldbirds - $ccull - $transferedbirds - $sentbirds - $transferout;	

	
  $feedstd = $feedstdarr[$res['age']];
  $cumfeedstd = $cumfeedstdarr[$res['age']];
  $stdfcr = $stdfcrarr[$res['age']];
  $stdwt = $stdwtarr[$res['age']];

	?>
	<tr>
	<td><?php if($preplace !=$res['place']) { echo $preplace=$res['place']; $presuper = ""; } else  echo "&nbsp;";   ?></td>	
	
	<td><?php echo $res['farm']; ?></td>
	<td><?php echo $res['flock']; ?></td>
	<td><?php echo date($datephp,strtotime($res['entrydate'])); ?></td>
	<td><?php echo $res['age']; ?></td>
	<td><?php echo $res['mortality']; ?></td>
	<td><?php echo $cmortality; ?></td>
	<td><?php echo round(($cmortality / ($oobirds)) * 100,2) ?></td>
	<td><?php echo $transferin; ?></td>
	<td><?php echo $sentbirds + $transferedbirds + $transferout; ?></td>
	
	<td><?php echo $birds; ?></td>

	<td><?php echo $res['feedconsumed']; ?></td>
	<td><?php echo $cfeedconsumed; ?></td>
	<td><?php if($feedstd)echo $feedstd; else echo "0"; ?></td>
	<td><?php echo round((($res['feedconsumed']/$birds) * 1000),2); ?></td>
	<td><?php if($cumfeedstd) echo $cumfeedstd; else echo "0"; ?></td>
	<td><?php echo round((($cfeedconsumed/$oobirds) * 1000),2); ?></td>
	
	<td><?php if($stdwt)echo $stdwt; else echo "0"; ?></td>
	
	<td><?php if($avw)echo $avw; else echo "0"; ?></td>
	<td><?php if($stdfcr) echo $stdfcr; else echo "0"; ?></td>
	<td><?php  $fcr=round(($cfeedconsumed / (($avw / 1000) * $birds )),2); if($fcr<0) echo "0"; else echo $fcr; ?></td>
	
	<td style="display:none"><?php if($res['medicine_name'])echo $medicinevaccine[$res['medicine_name']]; else echo "&nbsp;";  ?></td>
	<td style="display:none"><?php if($res['medicine_quantity'])echo $res['medicine_quantity']; else echo "0"; ?></td>
	<td><?php if($res['vaccine_name']) echo $medicinevaccine[$res['vaccine_name']]; else echo "&nbsp;";?></td>
	<td><?php if($res['vaccine_quantity'])echo $res['vaccine_quantity']; else echo "0";?></td>
		
		
	</tr>
<?php } ?>
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
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
