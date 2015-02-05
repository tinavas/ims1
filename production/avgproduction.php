<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";

$month = $_GET['month'];
$year = $_GET['year'];
$fromdate = $year."-".$month."-01";
 $monthenddate = date("t",strtotime($fromdate));
 $todate = $year."-".$month."-".$monthenddate;
$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");s
  
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
 <td colspan="2" align="center"><strong><font color="#3e3276"><?php echo $montharr[$month-1].", ".$year ;?> Average Production</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <!--<td><strong>Date : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?></td>-->
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
&nbsp;&nbsp;<a href="avgproduction.php?export=html&month=<?php echo $month; ?>&year=<?php echo $year;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="avgproduction.php?export=excel&month=<?php echo $month; ?>&year=<?php echo $year;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="avgproduction.php?export=word&month=<?php echo $month; ?>&year=<?php echo $year;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="avgproduction.php?cmd=reset&month=<?php echo $month; ?>&year=<?php echo $year;?>">Reset All Filters</a>
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
 
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">&nbsp;
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">&nbsp;
		Week
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Week</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Hatch Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatch Eggs</td>
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Book%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Book%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Farm%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Farm%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Diff %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Diff %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		F.Mortality
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">F.Mortality</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		M.Mortality
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">M.Mortality</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		F.Feed 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">F.Feed </td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		M.Feed 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">M.Feed </td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Consumption
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Consumption</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
	
<?php
$tothatcheggs = 0;	
$totothereggs = 0;
$totaleggs = 0;
$totfmort = 0;
$totmmort = 0;
$totffeed = 0;
$totmfeed = 0;

$perfarm = 0;
$count = 0;	
$mortality = 0;
$feedlater = 0;
$consumption = 0;
$henday23 = 0;

$ffeedlist = "'dummy'";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Female Feed'";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $ffeedlist = $ffeedlist . ",'" . $row1['code'] . "'";
  $ffeedname[$row1['code']] = $row1['description'];
}
$mfeedlist = "'dummy'";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Male Feed'";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $mfeedlist = $mfeedlist . ",'" . $row1['code'] . "'";
  $mfeedname[$row1['code']] = $row1['description'];
}
$eggslist = "'dummy'";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Eggs'";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $eggslist = $eggslist . ",'" . $row1['code'] . "'";
  $eggsname[$row1['code']] = $row1['description'];
}
$heggslist = "'dummy'";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Hatch Eggs'";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $heggslist = $heggslist . ",'" . $row1['code'] . "'";
  $heggsname[$row1['code']] = $row1['description'];
}


$q = "select * from breeder_flock where flkmain != '' and client = '$client' group by flkmain";
	$r = mysql_query($q,$conn1);

	while($qr = mysql_fetch_assoc($r))
	{
$toteggs = 0;
    $flock = $qr['flkmain'];
	$q2 = "select count(*) as c1 from breeder_production where date1 >= '$fromdate' and date1 <= '$todate' and flock like '%$flock' and client = '$client'";
$r2 = mysql_query($q2,$conn1);
while($qr2 = mysql_fetch_assoc($r2))
{
  $c1 = $qr2['c1'];
if($c1 >0)
{


 $q2 = "select min(startdate) as  startdate from breeder_flock where flockcode like '%$flock' and client = '$client'";
$r2 = mysql_query($q2,$conn1);
while($qr2 = mysql_fetch_assoc($r2))
{
$sdate = strtotime($qr2['startdate']);
$tdate = strtotime($todate);
$dif = $tdate - $sdate;
$days = $dif/(24*60*60);
$age = $qr2['age'];
$a = $age + $days;
$agenew = floor(($age + $days)/7);
 $n = $agenew %7;
 $nrSeconds = $a * 24 * 60 * 60;
$nrd = floor($nrSeconds / 86400) % 7; 
$aget = $agenew.".".$nrd;
}
	
	$eggs =0;
// $q3 = "select sum(quantity) as eggs from breeder_production where itemcode in (select distinct(code) from ims_itemcodes where cat='Eggs') and date1 >= '$fromdate' and date1 <= '$todate' and flock like '%$flock' and client = '$client'";
 $q3 = "select sum(quantity) as eggs from breeder_production where itemcode in ($eggslist) and date1 >= '$fromdate' and date1 <= '$todate' and flock like '%$flock' and client = '$client'";
$r3 = mysql_query($q3,$conn1);
while($qr3 = mysql_fetch_assoc($r3))
{
  $eggs = $qr3['eggs'];
}
$eggs2 =0;
$q4 = "select sum(quantity) as eggs from breeder_production where itemcode in ($heggslist) and date1 >= '$fromdate' and date1 <= '$todate' and flock like '%$flock' and client = '$client'";
$r4 = mysql_query($q4,$conn1);
while($qr4 = mysql_fetch_assoc($r4))
{
  $eggs2 = $qr4['eggs'];
}
 
 $totothereggs = $totothereggs + $eggs;
 $tothatcheggs = $tothatcheggs + $eggs2;
 $totaleggs = $eggs + $eggs2;
 
$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flock' group by startdate";
$result1 = mysql_query($query1,$conn1); 
$tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT sum(femaleopening) as femaleopening,sum(maleopening) as maleopening,age,startdate FROM breeder_flock WHERE flockcode like '%$flock' group by startdate order by startdate asc limit 1";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening'];
      //$startmale = $row11['maleopening'];
  }
}
else
{
  $query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flock'";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      //$startmale = $startmale + $row11['maleopening'];
  }
}
$query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flock' and date2 < '$fromdate' group by date2,flock";
$result1 = mysql_query($query1,$conn1); 
while($row11 = mysql_fetch_assoc($result1))
{

   $startfemale = $startfemale - ($row11['fmort'] + $row11['fcull']);
   ///$startmale = $startmale - ($row11['mmort'] + $row11['mcull']);
 
}

 //echo $startfemale ."&&&&&".$startmale;
 $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND  towarehouse like '%$flock' and fromwarehouse not like '%$flock' AND date < '$fromdate' ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	// echo "female tr in    ";echo 
	$startfemale = $startfemale + $row11t['quantity'];
	}
	  $query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND client = '$client' AND towarehouse not like '%$flock' and fromwarehouse like '%$flock' AND date < '$fromdate'";
  	$result1t2 = mysql_query($query1t2,$conn1); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
	 //echo "female tr out    ";echo  
	 $startfemale = $startfemale - $row11t2['quantity'];
	 }
 $query1tpur = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flock' AND date < '$fromdate'";
  $result1tpur = mysql_query($query1tpur,$conn1); 
  while($row11tpur = mysql_fetch_assoc($result1tpur))  
  {
	  //echo "female pr     ";echo 
	  $startfemale = $startfemale + $row11tpur['receivedquantity'];
  }
 $femalesale = 0;
  $query1t = "SELECT * FROM `oc_cobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flock' AND date<'$fromdate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {  
     	  $femalesale = $femalesale + $row11t['quantity'];	  
  }
   if($femalesale > 0)
  {
  $startfemale = $startfemale - $femalesale;
  }

$remaining =  $startfemale;
$monthenddate = date("t",strtotime($fromdate));

if(($remaining == 0) || ($remaining == ""))
 {
			$q2a = "select min(date1) as dt from breeder_production where flock like '%$flock' and client = '$client' ";
			$r2a = mysql_query($q2a,$conn1);
			while($q22 = mysql_fetch_assoc($r2a))
			{
             $dt1 = $q22['dt'];
			 $difff = strtotime($todate) - strtotime($dt1);
			 $daysnew = $difff/(24*60*60);
			 $monthenddate = $daysnew;
			 }
			
$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flock' group by startdate";
$result1 = mysql_query($query1,$conn1); 
$tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT sum(femaleopening) as femaleopening,sum(maleopening) as maleopening,age,startdate FROM breeder_flock WHERE flockcode like '%$flock' group by startdate order by startdate asc limit 1";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening'];
      //$startmale = $row11['maleopening'];
  }
}
else
{
  $query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flock'";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      //$startmale = $startmale + $row11['maleopening'];
  }
}
$query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flock' and date2 < '$dt1' group by date2,flock";
$result1 = mysql_query($query1,$conn1); 
while($row11 = mysql_fetch_assoc($result1))
{

   $startfemale = $startfemale - ($row11['fmort'] + $row11['fcull']);
   ///$startmale = $startmale - ($row11['mmort'] + $row11['mcull']);
 
}

 //echo $startfemale ."&&&&&".$startmale;
 $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND  towarehouse like '%$flock' and fromwarehouse not like '%$flock' AND date < '$dt1' ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	// echo "female tr in    ";echo 
	$startfemale = $startfemale + $row11t['quantity'];
	}
	  $query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND client = '$client' AND towarehouse not like '%$flock' and fromwarehouse like '%$flock' AND date < '$dt1'";
  	$result1t2 = mysql_query($query1t2,$conn1); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
	 //echo "female tr out    ";echo  
	 $startfemale = $startfemale - $row11t2['quantity'];
	 }
 $query1tpur = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flock' AND date < '$dt1'";
  $result1tpur = mysql_query($query1tpur,$conn1); 
  while($row11tpur = mysql_fetch_assoc($result1tpur))  
  {
	  //echo "female pr     ";echo 
	  $startfemale = $startfemale + $row11tpur['receivedquantity'];
  }
 $femalesale = 0;
  $query1t = "SELECT * FROM `oc_cobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flock' AND date<'$dt1'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {  
     	  $femalesale = $femalesale + $row11t['quantity'];	  
  }
   if($femalesale > 0)
  {
  $startfemale = $startfemale - $femalesale;
  }
$remaining =  $startfemale;
}
echo $remaining;echo "<br>";
$dif23 = strtotime($todate) - strtotime(fromdate);
			 $de = date("d.m.Y",$dif23);
		   $e = explode(".",$de);
		   $dum = $e[0];
		   
		   //echo $totaleggs."/".$remaining."/".$d;
			 $farm = round(((($totaleggs / $remaining)/$dum)*100),2);
			 
			  ///////////////////////////Book %//////////////////////////////
			  $q11 = "select min(age) as minage,max(age) as maxage from breeder_consumption where date2 >= '$fromdate' and date2 <= '$todate' and flock like '%$flock' and client = '$client'";
			 $r11 = mysql_query($q11,$conn1);
			 while($qr11 = mysql_fetch_assoc($r11))
			 {
			 $minage = floor($qr11['minage']/7);
			 $maxage = floor($qr11['maxage']/7);
			 $difage = ($maxage - $minage)+1;
			 
			 $q12 = "select sum(productionper) as henday from breeder_standards where age >= '$minage' and age <= '$maxage' and client = '$client'";
			 $r12 = mysql_query($q12,$conn1);
			 
			 while($qr12 = mysql_fetch_assoc($r12))
			 {
			 $hd = $qr12[henday];
			 $hd1 = round(($hd/$difage),2);
			 $henday23 = $henday23 + $hd1;
			 //echo $hd."/".$minage."/".$maxage."/".$difage."/".$hd1;
			 }
			 }
			 $percen = round(($farm - $hd1),2);
			 
			  //////////////////////////////////MORTALITY/////////////////////////
		
$fmort = 0;$mmort = 0;
 $q9 = "select distinct(date2),fmort,mmort from breeder_consumption where date2 >= '$fromdate' and date2 <= '$todate' and flock like '%$flock' and client = '$client'";
$r9 = mysql_query($q9,$conn1);
while($qr9 = mysql_fetch_assoc($r9))
 {
 $fmort = $fmort + $qr9['fmort'];
 $mmort = $mmort + $qr9['mmort'];
 }
 $totfmort = $totfmort + $fmort;
 $totmmort = $totmmort + $mmort;
 
 $ffeed = 0;
 $q10 = "select sum(quantity) as quantity from breeder_consumption where date2 >= '$fromdate' and date2 <= '$todate' and flock like '%$flock' and itemcode in ($ffeedlist) and client = '$client'";
$r10 = mysql_query($q10,$conn1);
while($qr10 = mysql_fetch_assoc($r10))
 {
 $ffeed = $qr10['quantity'];
 }
 $totffeed = $totffeed + $ffeed;
  $mfeed = 0;
$q10 = "select sum(quantity) as quantity from breeder_consumption where date2 >= '$fromdate' and date2 <= '$todate' and flock like '%$flock' and itemcode in ($mfeedlist) and client = '$client'";
$r10 = mysql_query($q10,$conn1);
while($qr10 = mysql_fetch_assoc($r10))
 {
 $mfeed = $qr10['quantity'];
 }
 $totmfeed = $totmfeed + $mfeed;
 //echo $feed."/".$ob;
 $con = round((($ffeed/$remaining)*1000),2);
 
 ?>
 <tr>
	<td align="center">
<?php  echo ewrpt_ViewValue($flock);  ?>
</td>
<?php 
if($aget != "")
{
$count = $count + 1;

}

?>
<td align="center">
<?php  echo ewrpt_ViewValue($aget); ?>
</td>
<td align="right">

<?php if($eggs <> "") { $toteggs+=$eggs ; echo ewrpt_ViewValue($eggs); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">

<?php if($eggs2 <> "") { $tothatcheggs+=$eggs2; echo ewrpt_ViewValue($eggs2); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">
<?php if($totaleggs <> "") { echo ewrpt_ViewValue($totaleggs); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">
<?php if($hd1 <> "") { $henday+=$hd1; echo ewrpt_ViewValue($hd1); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">
<?php if($farm <> "") { $perfarm+=$farm; echo ewrpt_ViewValue($farm); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">
<?php if($percen <> "") { $percentage+=$percen; echo ewrpt_ViewValue($percen); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">
<?php if($fmort <> "") { $mortality+=$mort; echo ewrpt_ViewValue($fmort); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">
<?php if($mmort <> "") { $mortality+=$mort; echo ewrpt_ViewValue($mmort); } else { echo ewrpt_ViewValue("0"); } ?>
</td>

<td align="right">
<?php if($ffeed <> "") { $feedlater+= $feed; echo ewrpt_ViewValue($ffeed); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td align="right">
<?php if($mfeed <> "") { $feedlater+= $feed; echo ewrpt_ViewValue($mfeed); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<?php $cons = round(($con/$monthenddate),2); ?>
<td align="right">
<?php if($cons <> "") { $consumption+= $cons; echo ewrpt_ViewValue($cons); } else { echo ewrpt_ViewValue("0"); } ?>
</td>



</tr>
 <?php 
}
}
}

?>
<tr>

<td align="right">&nbsp;</td><td align="right"><b>TOTAL</b></td>
<td align="right"><?php echo $totothereggs; ?></td>
<td align="right"><?php echo $tothatcheggs; ?></td>
<td align="right">&nbsp;</td>
<td align="right"><?php echo $henday23;?></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right"><?php echo $totfmort; ?></td>
<td align="right"><?php echo $totmmort; ?></td>
<td align="right"><?php echo $totffeed; ?></td>
<td align="right"><?php echo $totmfeed; ?></td>
<td align="right">&nbsp;</td>
</tr>

<tr>

<td align="right">&nbsp;</td>
<td align="center" colspan="3"><b>TOTAL FEMALE FEED</b></td>
<td align="right"><?php echo $totffeed;?></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>

<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>

<tr>

<td align="right">&nbsp;</td>
<td align="center" colspan="3"><b>TOTAL MALE FEED</b></td>
<td align="right"><?php echo $totmfeed;?></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>

<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>

<tr>

<td align="right">&nbsp;</td>
<td align="center" colspan="3">&nbsp;</td>
<td align="right"><b><?php echo $totffeed+$totmfeed;?></b></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>

<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>

<tr>

<td align="right">&nbsp;</td>
<td align="center" colspan="3"><b>Total Eggs</b></td>
<td align="right"><?php echo $totothereggs+$tothatcheggs;?></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>

<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>

<?php 
$eggpton = round(((($totothereggs+$tothatcheggs)/($totffeed))*1000),2);
$fperegg = round(((($totffeed)/($totothereggs+$tothatcheggs))*1000),2);
?>

<tr>

<td align="right">&nbsp;</td>
<td align="center" colspan="3"><b>Eggs Per One Ton Of Feed</b></td>
<td align="right"><?php echo $eggpton;?></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>

<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>
<tr>

<td align="right">&nbsp;</td>
<td align="center" colspan="3"><b>Gms Feed Per One Egg</b> </td>
<td align="right"><?php echo $fperegg;?></td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>

<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
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
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "avgproduction.php?fromdate=" + fdate + "&todate=" +tdate;
}
</script>