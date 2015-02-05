<?php
$start_process = (float) array_sum(explode(' ',microtime()));
 session_start(); $flockget = $_SESSION['flockcode']; 
$istart = $_SESSION['istartage'];
$iend = $_SESSION['iage'];
$jstart = $_SESSION['jstartage'];
$jend = $_SESSION['jage'];
$breedi = $_SESSION['breedi'] ;
include "../config.php";
if($breedi != "")
{
$query34 = "SELECT * FROM breeder_standards where breed = '$breedi' ORDER BY age ASC ";
}
else
{
$query34 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
}
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $istdhdper[$row134['age']] = $row134['productionper'];
  $istdheggper[$row134['age']] = $row134['heggper'];
  $istdeggwt[$row134['age']] = $row134['eggwt'];
  $istdfweight[$row134['age']] = $row134['fweight'];
  $istdmweight[$row134['age']] = $row134['mweight'];
}
$startfemale = $_SESSION['ifemale'][$istart]; 
$startmale = $_SESSION['imale'][$istart]; 
$cummfmort = $cummmort = $cummfcull = $cummmcull = $cummfsexing = $cummmsexing = $cummeggs = $cummhatcheggs = $cummffeed = $cummmfeed = $cummpcost = $cummccost = 0;


$ffeedtype = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Female Feed'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $ffeedtype = $ffeedtype . ",'" . $row1['code'] . "'";
}

$mfeedtype = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Male Feed'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $mfeedtype = $mfeedtype . ",'" . $row1['code'] . "'";
}

$medicine = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Medicines'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $medicine = $medicine . ",'" . $row1['code'] . "'";
}

$vaccine = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Vaccines'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $vaccine = $vaccinne . ",'" . $row1['code'] . "'";
}

$otheritems = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat not in ('Vaccines','Medicines','Eggs','Hatch Eggs','Male Feed','Female Feed')";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $otheritems = $otheritems . ",'" . $row1['code'] . "'";
}

$mbirds = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Male Birds'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $mbirds = $mbirds . ",'" . $row1['code'] . "'";
}

$eggs = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Eggs'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $eggs = $eggs . ",'" . $row1['code'] . "'";
}

$hatcheggs = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Hatch Eggs'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $hatcheggs = $hatcheggs . ",'" . $row1['code'] . "'";
}

$fbirds = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Female Birds'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $fbirds = $fbirds . ",'" . $row1['code'] . "'";
}

$bchicks = "''";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Broiler Chicks'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $bchicks = $bchicks . ",'" . $row1['code'] . "'";
}
$unitarr ="";$ui = 0;
$query = "SELECT distinct(unitcode) FROM breeder_flock WHERE flockcode like '%$flockget'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
   $unitarr[$ui] = $row1['unitcode'];
  $ui++;
}

?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=us-ascii">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link id=Main-File rel=Main-File href=newreport.php>
<link rel=File-List href="newreport_filelist.xml">
<link rel=Stylesheet href="newreport_stylesheet.css">
<style>
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
@page
	{margin:1.0in .75in 1.0in .75in;
	mso-header-margin:.5in;
	mso-footer-margin:.5in;}
-->
</style>
<![if !supportTabStrip]>

<SCRIPT LANGUAGE="JavaScript">
NavName = navigator.appName.substring(0,3);
NavVersion = navigator.appVersion.substring(0,1);
if (NavName != "Mic" || NavVersion>=4)
	{
	entree = new Date;
	entree = entree.getTime();
	}

function calculateloadgingtime()
	{
	if (NavName != "Mic" || NavVersion>=4)
		{
		fin = new Date;
		fin = fin.getTime();
		secondes = (fin-entree)/1000;
		var exetime11 = document.getElementById("exetime1").value;
		secondes = parseFloat(secondes) + parseFloat(exetime11);
	    secondes =  secondes.toFixed(3);
		window.status='Page loaded in ' + secondes + ' seconde(s).';
		document.getElementById("loadgingpage").innerHTML = "(Page loaded in " + secondes + " second(s).)";
		}
	}
window.onload = calculateloadgingtime;

</SCRIPT>
<script language="JavaScript">
<!--
function fnUpdateTabs()
 {
  if (parent.window.g_iIEVer>=4) {
   if (parent.document.readyState=="complete"
    && parent.frames['frTabs'].document.readyState=="complete")
   parent.fnSetActiveSheet(12);
  else
   window.setTimeout("fnUpdateTabs();",150);
 }
}

if (window.name!="frSheet")
 window.location.replace("newreport.php");
else
 fnUpdateTabs();
//-->
</script>
<![endif]>
</head>

<body link=blue vlink=purple class=xl128>
<center><div id="loadingimg" >
<table>
<tr >
<td valign="bottom"><img src="../images/mask-loader.gif" align="bottom"/></td><td valign="top" align="center" style="text-align:center">(Please wait report is loading)</td>
</tr>
</table>
</div></center>

<center>
  <table><tr><td style="font-size:13px"><b>Costing Report For Flock <?php session_start(); echo $_SESSION['displayflock']; ?></b></td></tr></table>
</center>

<table border=0 cellpadding=0 cellspacing=0 width=1202 style='border-collapse:
 collapse;width:898pt'>
<tr height="65px"><td></td></tr>
 <tr height=36 style='mso-height-source:userset;height:27.0pt'>
  <td rowspan=2 height=98 class=xl497 style='height:73.5pt'>Date</td>
  <td rowspan=2 class=xl497>Age</td>
  <td colspan=2 class=xl497 style='border-left:none'>No. of Birds</td>
  <td colspan=2 class=xl497 style='border-left:none'>Mort.</td>
  <td colspan=2 class=xl497 style='border-left:none'>culls</td>
  <td colspan=2 class=xl497 style='border-left:none'>Sexing</td>
  

  <td rowspan=2 class=xl498 width=75 style='width:56pt'>Total Feed in kgs</td>
  <td colspan=4 class=xl497 style='border-left:none'>Feed Consumption</td>
  <td colspan=5 class=xl497 style='border-left:none'>Consumption Cost</td>

  <td colspan=3 class=xl756 style='border-left:none'>Prod.</td>
  <td colspan=3 class=xl756 >Hat. Eggs</td>

  <td colspan=6 class=xl497 >Sales</td>

  <td rowspan=2 class=xl498 width=75 style='width:56pt'>Feed / Hatch Egg</td>
  <td rowspan=2 class=xl498 width=75 style='width:56pt'>Cost / Hatch Egg</td>

  <!-- <td colspan=3 class=xl498 width=109 style='border-left:none;width:81pt'>Female<span
  style='mso-spacerun:yes'>&nbsp; </span>Body<span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span>Wt in Gms</td>
  <td colspan=3 class=xl498 width=109 style='border-left:none;width:81pt'>Male
  Body<span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Wt in Gms</td>
  <td colspan=3 class=xl754 width=93 style='border-right:.5pt solid black;
  border-left:none;width:69pt'>EGG WT</td> -->
 </tr>



 <tr height=62 style='mso-height-source:userset;height:46.5pt'>
  <td height=62 class=xl497 style='height:46.5pt;border-top:none;border-left:
  none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>
  <td class=xl497 style='border-top:none;border-left:none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>
  <td class=xl497 style='border-top:none;border-left:none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>
  <td class=xl497 style='border-top:none;border-left:none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>


  <td class=xl498 width=56 style='border-top:none;border-left:none;width:42pt'>F
  Total in kgs</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Per
  Bird/day in gms</td>
  <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>M
  Total in kgs</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Per
  Bird/day in gms</td>

  <td class=xl498 width=56 style='border-top:none;border-left:none;width:42pt'>Feed Cost</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Med. Cost</td>
  <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>Vac. Cost</td>
  <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>Others</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Total Cost</td>

  <td class=xl497 style='border-top:none;border-left:none'>No.</td>
  <td class=xl497 style='border-top:none;border-left:none'>%</td>
  <td class=xl499 width=40 style='border-top:none;border-left:none;width:30pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>St. %<span
  style='mso-spacerun:yes'>&nbsp;</span></td>
  <td class=xl497 style='border-top:none;border-left:none'>No.</td>
  <td class=xl497 style='border-top:none;border-left:none'>%</td>
  <td class=xl499 width=40 style='border-top:none;border-left:none;width:30pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>St. %<span
  style='mso-spacerun:yes'>&nbsp;</span></td>


  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Hatch Eggs</td>
  <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>Female Birds</td>
  <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>Male Birds</td>
  <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>Chicks</td>
  <td class=xl498 width=56 style='border-top:none;border-left:none;width:42pt'>Others</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Total</td>

  <!-- <td class=xl500 width=35 style='border-top:none;width:26pt'>Std.</td>
  <td class=xl498 width=35 style='border-top:none;border-left:none;width:26pt'>Act.</td>
  <td class=xl498 width=39 style='border-top:none;border-left:none;width:29pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+/-</td>
  <td class=xl498 width=35 style='border-top:none;border-left:none;width:26pt'>Std.</td>
  <td class=xl498 width=35 style='border-top:none;border-left:none;width:26pt'>Act.</td>
  <td class=xl498 width=39 style='border-top:none;border-left:none;width:29pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+/-</td>

  <td class=xl498 width=31 style='border-top:none;border-left:none;width:23pt'>Std.</td>
  <td class=xl498 width=31 style='border-top:none;border-left:none;width:23pt'>Act.</td>
  <td class=xl498 width=31 style='border-top:none;border-left:none;width:23pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+/-</td> -->
 </tr>


 

 <tr class=xl523 height=17 style='height:12.75pt'>
  <td height=17 class=xl523 style='height:12.75pt'></td>
  <td class=xl525></td>
  <td colspan=2 class=xl557 style='mso-ignore:colspan'></td>
  <td colspan=5 class=xl542 style='mso-ignore:colspan'></td>
  <td class=xl543 style='border-top:none'>&nbsp;</td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>
  <td class=xl544 style='border-top:none'>&nbsp;</td>
  <td class=xl523></td>
  <td class=xl526></td>
  <td class=xl544 style='border-top:none'>&nbsp;</td>
  <td class=xl544 style='border-top:none'>&nbsp;</td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl545></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <td class=xl544>&nbsp;</td>
  <td class=xl544>&nbsp;</td>
  <td class=xl544>&nbsp;</td>
 </tr>


<?php
if($jstart == "")
{
 $query12 = "SELECT min(age) as minage,female,male from breeder_initial WHERE flock like '%$flockget' and age < '$istart' and eggs = '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$ijstart = $row12['minage'];
$strtbfemale = $row12['female'];
$strtbmale = $row12['male'];
}
}
 if(($jstart) or ($ijstart)) { ?>

<!---------------------- Brooding Start ------------------------------------>


<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl546 style='height:12.75pt'>Brooding</td>
  <td class=xl528 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>

  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl531 style='border-left:none'>&nbsp;</td>
  <td class=xl531 style='border-left:none'>&nbsp;</td>
  <!-- <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style=''>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td> -->
 </tr>
<?php
$startdummage = 0;
$mcummort = 0;
$mcumcull = 0;
$fcummort = 0;
$fcumcull = 0;
$strtfemale = 0;
$strtmale = 0;
$query12 = "SELECT min(age) as minage,female,male from breeder_initial WHERE flock like '%$flockget' and age < '$istart' and eggs = '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage'];
$strtfemale = $row12['female'];
$strtmale = $row12['male'];
}
$query12 = "SELECT sum(fmort) as fmort,sum(fcull) as fcull,sum(mmort) as mmort,sum(mcull) as mcull from breeder_initial WHERE flock like '%$flockget' and age < '$startdummage' and eggs = '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$fcummort = $row12['fmort'];
$fcumcull = $row12['fcull'];
$mcummort = $row12['mmort'];
$mcumcull = $row12['mcull'];
}
$fprodop = $strtfemale - $fcummort - $fcumcull;
$mprodop = $strtmale - $mcummort - $mcumcull; 
if($jstart == "")
{
$agdif = $istart - $startdummage;
$actdate = $_SESSION['idate'][$istart];
$strdate = $_SESSION['idate'][$istart] - ($agdif*7*24*60*60);
}
else
{
$agdif = $jstart - $startdummage;
$actdate = $_SESSION['jdate'][$jstart];
$strdate = $_SESSION['jdate'][$jstart] - ($agdif*7*24*60*60);
}

//$strdate = date("d-m-Y",$strdate);
//echo $strdate;
$query12 = "SELECT * from breeder_initial WHERE flock like '%$flockget' and age < '$istart' and eggs = '' order by age  ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$datenow = "";
  ?>
  <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo  date("j-M",$strdate);$datenow =  date("Y-m-d",$strdate);?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $row12['age'] ; ?></td>
    <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $fprodop; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $mprodop; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fmort']; $cummfmort = $cummfmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['mmort'];  $cummmmort = $cummmmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fcull'];  $cummfcull = $cummfcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['mcull'];  $cummmcull = $cummmcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummfsexing = $cummfsexing + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummmsexing = $cummmsexing + $a; ?></td>
   <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($row12['ffeedqty'] + $row12['mfeedqty']),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($row12['ffeedqty']),2);  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round((($row12['ffeedqty'] * 1000)/($fprodop * 7)),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($row12['mfeedqty']),2);  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round((($row12['mfeedqty'] * 1000)/($mprodop * 7)),2); ?></td>
   <!-- Consumption Costing Start-->
<?php
$fromdatedc = "";$todatedc ="";$flkdc1=0;
for($ui=0;$ui < count($unitarr);$ui++)
{
$unit = "";$unitcost=0;
$unit = $unitarr[$ui];
$query = "SELECT dayspan,fromdate,todate FROM breeder_unitwisemaintaincecost WHERE unit = '$unit' and fromdate <='$datenow' and todate>='$datenow'";
$resultdc = mysql_query($query,$conn); 
while($rowdc = mysql_fetch_assoc($resultdc))  
  {
      $unitcost = $unitcost + $rowdc['dayspan'];
	  $fromdatedc = $rowdc['fromdate'];
	  $todatedc = $rowdc['todate'];
  }
}
$unitcost = $unitcost * 7;
$fc1 =0;
if( $fromdatedc != "" && $todatedc != "")
{
$fc = 0;$flkdcarr = "";
$query = "SELECT distinct(flock) FROM breeder_consumption WHERE  date2 >='$fromdatedc' and date2>='$todatedc'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkdcarr[$fc] = $rowdc1['flock'];
$fc++;
}
$flkdcarrmain ="";
for($fc=0;$fc<count($flkdcarr);$fc++)
{
$flkco="";
$flkco = $flkdcarr[$fc];
$query = "SELECT flkmain,unitcode FROM breeder_flock WHERE  flockcode ='$flkco'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkmainc ="";
$flkmainc = $rowdc1['flkmain'];
$unitcc = $rowdc1['unitcode'];
if((!in_array($flkmainc,$flkdcarrmain)) && (in_array($unitcc,$unitarr)))
{
$flkdcarrmain[$fc1] = $flkmainc;
$fc1++;
$flkdc1++;
}
}
}
//echo $flkdc1 = count($flkdcarrmain);

$flkunitcost = round(($unitcost/$flkdc1),2);
}

?>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0;" ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php if($flkunitcost == "") { echo "0"; } else {echo $flkunitcost; }?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = "0"; $cummccost = $cummccost + $a; ?></td>

<!-- Consumption Costing End -->
<td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo 0; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = 0; $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php echo 0; ?></td>
  <!-- Sale Costing Start-->

  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = "0"; $cummpcost = $cummpcost + $a; ?></td>

<!-- Sale Costing End -->

<td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  </tr>
<?php
$strdate = $strdate + (7 * 24 * 60 * 60);
$fprodop = $fprodop - $row12['fmort'] - $row12['fcull'];
$mprodop = $mprodop - $row12['mmort'] - $row12['mcull'];
 } ?>

<?php
for($m = $jstart;$m <= $jend;$m++)
{

 $ctodate =  date("Y-m-d",$_SESSION['jdatetime'][$m]); 
 $gpdate = $_SESSION['jdatetime'][$m] - (6 * 24 * 60 * 60);
 $cfromdate = date("Y-m-d",$gpdate);
 $tfeedtype = $ffeedtype . "," . $mfeedtype;



  $remfeed = 0;
  $remfeedcost = 0;
  $tfeedcost = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($tfeedtype) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {

    $query1a = "SELECT avg(feedcostperkg) as 'feedcostperkg' FROM feed_productionunit WHERE date >= '$cfromdate' and date <= '$ctodate' and mash = '$row11[itemcode]' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $tfeedprice = $row11a['feedcostperkg'];
    }
    $tfeedcost  = $tfeedcost + ($tfeedprice * $row11['quantity']);
  }
  $tfeedcost = round($tfeedcost,2);

  $tmedcost = 0;
  $tmedprice = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($medicine) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
    $query1a = "SELECT avg(price) as 'price' FROM ims_stocktransfer WHERE date >= '$cfromdate' and date <= '$ctodate' and code = '$row11[itemcode]' and towarehouse like '%$flockget' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $tmedprice = $row11a['price'];
    }
    if($tmedprice == 0 || $tmedprice == "")
    {
      $query1a = "SELECT avg(rateperunit) as 'price' FROM pp_sobi WHERE code = '$row11[itemcode]'";
      $result1a = mysql_query($query1a,$conn); 
      while($row11a = mysql_fetch_assoc($result1a))
      {
        $tmedprice = $row11a['price'];
      }
    }
    $tmedcost  = $tmedcost + ($tmedprice * $row11['quantity']);
  }

  $tvaccost = 0;
  $tvacprice = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($vaccine) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
    $query1a = "SELECT avg(price) as 'price' FROM ims_stocktransfer WHERE date >= '$cfromdate' and date <= '$ctodate' and code = '$row11[itemcode]' and towarehouse like '%$flockget' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $tvacprice = $row11a['price'];
    }
    if($tvacprice == 0 || $tvacprice == "")
    {
      $query1a = "SELECT avg(rateperunit) as 'price' FROM pp_sobi WHERE code = '$row11[itemcode]'";
      $result1a = mysql_query($query1a,$conn); 
      while($row11a = mysql_fetch_assoc($result1a))
      {
        $tvacprice = $row11a['price'];
      }
    }
    $tvaccost  = $tvaccost + ($tvacprice * $row11['quantity']);
  }

  $toicost = 0;
  $toiprice = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($otheritems) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
    $query1a = "SELECT avg(price) as 'price' FROM ims_stocktransfer WHERE date >= '$cfromdate' and date <= '$ctodate' and code = '$row11[itemcode]' and towarehouse like '%$flockget' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $toiprice = $row11a['price'];
    }
    if($toiprice == 0 || $toiprice == "")
    {
      $query1a = "SELECT avg(rateperunit) as 'price' FROM pp_sobi WHERE code = '$row11[itemcode]'";
      $result1a = mysql_query($query1a,$conn); 
      while($row11a = mysql_fetch_assoc($result1a))
      {
        $toiprice = $row11a['price'];
      }
    }
    $toicost  = $toicost + ($toiprice * $row11['quantity']);
  }

  $salembirds = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($mbirds) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salembirds = round($row11a['total'],2);
  }

  $salefbirds = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($fbirds) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salefbirds = round($row11a['total'],2);
  }

  $saleeggs = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($eggs) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $saleeggs = round($row11a['total'],2);
  }

  $salehatcheggs = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($hatcheggs) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salehatcheggs = round($row11a['total'],2);
  }

  $salechicks = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($bchicks) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salechicks = round($row11a['total'],2);
  }
  $datenow = "";
?>



<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo $_SESSION['jdate'][$m]; $datenow =  date("Y-m-j",$_SESSION['jdate'][$m]);?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $m ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jfemale'][$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jmale'][$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jfmort'][$m]; $cummfmort = $cummfmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jmmort'][$m];  $cummmmort = $cummmmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jfcull'][$m];  $cummfcull = $cummfcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jmcull'][$m];  $cummmcull = $cummmcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jfsexing'][$m];  $cummfsexing = $cummfsexing + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jmsexing'][$m];  $cummmsexing = $cummmsexing + $a; ?></td>

  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $t1 = $_SESSION['jffeed'][$m] + $_SESSION['jmfeed'][$m]; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jffeed'][$m];  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jffeedpb'][$m]; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['jmfeed'][$m];  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jmfeedpb'][$m]; ?></td>

 <!-- Consumption Costing Start-->
<?php
$fromdatedc = "";$todatedc ="";$flkdc1=0;
for($ui=0;$ui < count($unitarr);$ui++)
{
$unit = "";$unitcost=0;
$unit = $unitarr[$ui];
$query = "SELECT dayspan,fromdate,todate FROM breeder_unitwisemaintaincecost WHERE unit = '$unit' and fromdate <='$datenow' and todate>='$datenow'";
$resultdc = mysql_query($query,$conn); 
while($rowdc = mysql_fetch_assoc($resultdc))  
  {
      $unitcost = $unitcost + $rowdc['dayspan'];
	  $fromdatedc = $rowdc['fromdate'];
	  $todatedc = $rowdc['todate'];
  }
}
$unitcost = $unitcost * 7;
$fc1 =0;
if( $fromdatedc != "" && $todatedc != "")
{
$fc = 0;$flkdcarr = "";
$query = "SELECT distinct(flock) FROM breeder_consumption WHERE  date2 >='$fromdatedc' and date2>='$todatedc'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkdcarr[$fc] = $rowdc1['flock'];
$fc++;
}
$flkdcarrmain ="";
for($fc=0;$fc<count($flkdcarr);$fc++)
{
$flkco="";
$flkco = $flkdcarr[$fc];
$query = "SELECT flkmain,unitcode FROM breeder_flock WHERE  flockcode ='$flkco'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkmainc ="";
$flkmainc = $rowdc1['flkmain'];
$unitcc = $rowdc1['unitcode'];
if((!in_array($flkmainc,$flkdcarrmain)) && (in_array($unitcc,$unitarr)))
{
$flkdcarrmain[$fc1] = $flkmainc;
$fc1++;
$flkdc1++;
}
}
}
//echo $flkdc1 = count($flkdcarrmain);

$flkunitcost = round(($unitcost/$flkdc1),2);
}
?>


  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $tfeedcost; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $tmedcost; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $tvaccost; ?></td>
<!--  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $toicost; ?></td>
-->  
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php if($flkunitcost == "") { echo "0"; } else {echo $flkunitcost; } ?></td>

  
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = round($tfeedcost + $tmedcost + $tvaccost + $toicost,2); $cummccost = $cummccost + $a; ?></td>

<!-- Consumption Costing End -->


  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = 0;  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span> &nbsp;<?php echo 0; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = 0; $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span> &nbsp;<?php echo 0; ?></td>

 <!-- Sale Costing Start-->

  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salehatcheggs; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salefbirds; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salembirds; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salechicks; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $saleeggs; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = round($saleeggs + $salehatcheggs + $salefbirds + $salembirds + $salechicks,2); $cummpcost = $cummpcost + $a; ?></td>

<!-- Sale Costing End -->

  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;0</td>
  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;0</td>


<!--  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $istdfweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jfbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jfbweight'][$m] - $istdfweight[$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $istdmweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jmbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['jmbweight'][$m] - $istdmweight[$m]; ?></td>
  

  <td class=xl558 align=right style='border-left:none'> &nbsp;<?php echo 0; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo 0; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo 0; ?></td> -->
 </tr>




<?php } ?>

 
  <tr height=18 style='height:13.5pt;'>
  <td height=18 class=xl524 style='height:13.5pt'>TOTAL</td>
  <td class=xl509></td>
  <td class=xl516 style='border-top:none'>&nbsp;</td>
  <td class=xl516 style='border-top:none'>&nbsp;</td>
  <td class=xl535 align=right style='border-top:none'><?php echo round($cummfmort,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmmort,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummfcull,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmcull,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummfsexing,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmsexing,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed + $cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummccost,2); ?></td>
  <td class=xl536 align=right style='border-top:none'>&nbsp;<?php echo round($cummeggs,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummhatcheggs,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummpcost,2); ?></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr class=xl523 height=18 style='height:13.5pt;display:none'>
  <td height=18 class=xl523 style='height:13.5pt'></td>
  <td class=xl525></td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl551 align=center><?php echo round(($cummfmort/$startfemale)*100,2); ?></td>
  <td class=xl551 align=center><?php echo round(($cummmmort/$startmale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummfcull/$startfemale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummmcull/$startmale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummfsexing/$startfemale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummmsexing/$startmale)*100,2); ?></td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>
  <td class=xl526></td>
  <td class=xl526></td>
  <td colspan=3 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
 </tr>

 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=10 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=10 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
 </tr>



<!---------------- Brooding End ---------------------------------->

<?php } ?>

<?php if($istart) { ?>

<!---------------- Laying Start ---------------------------------->

 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl546 style='height:12.75pt'>Laying</td>
  <td class=xl528 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>

  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl531 style='border-left:none'>&nbsp;</td>
  <td class=xl531 style='border-left:none'>&nbsp;</td>
  <!-- <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style=''>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td> -->
 </tr>


<!-- /////// FIFO //////////// -->

 <!--
   echo $row11['date2'] . "-" . $row11['quantity'] . "-";
    $tqty = $row11['quantity'];
    if($remfeed)
    {
      if($remfeed >= $tqty) { $tqty = $tqty; } else { $tqty = $remfeed; }
      $tfeedcost = $tfeedcost + ($tqty * $remfeedcost);
      if($remfeed >= $tqty) { $tqty = 0; } else { $tqty = $tqty - $remfeed; }
      $remfeed = $remfeed - $tqty;      
    }

    $query1a = "SELECT * FROM feed_productionunit WHERE date = '$row11[date2]' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $tfeedcost = $tfeedcost + ($tqty * $row11a['feedcostperkg']);
       $remfeedcost = $row11a['feedcostperkg'];
       $remfeed = $remfeed + ($row11a['production'] - $tqty);
    }
    echo $tfeedcost; echo "<br />";
-->

<?php
$startdummage = 0;
$mcummort = 0;
$mcumcull = 0;
$fcummort = 0;
$fcumcull = 0;
$strtfemale = 0;
$strtmale = 0;
$query12 = "SELECT min(age) as minage,female,male from breeder_initial WHERE flock like '%$flockget' and age < '$istart' and eggs <> '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage'];
$strtfemale = $row12['female'];
$strtmale = $row12['male'];
}
 $query12 = "SELECT sum(fmort) as fmort,sum(fcull) as fcull,sum(mmort) as mmort,sum(mcull) as mcull from breeder_initial WHERE flock like '%$flockget' and age < '$startdummage' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
  $fcummort = $row12['fmort'];
 $fcumcull = $row12['fcull'];
$mcummort = $row12['mmort'];
$mcumcull = $row12['mcull'];
}
$fprodop = $strtfemale - $fcummort - $fcumcull;
$mprodop = $strtmale - $mcummort - $mcumcull; 
$agdif = $istart - $startdummage;
$actdate = $_SESSION['idate'][$istart];
$strdate = $_SESSION['idate'][$istart] - ($agdif*7*24*60*60);
//$strdate = date("d-m-Y",$strdate);
//echo $strdate;
 $query12 = "SELECT * from breeder_initial WHERE flock like '%$flockget' and age < '$istart' and eggs <> '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{
$totprod = 0;
$tothe = 0;
  $prod = $row12['eggs'];
  $cat = explode(",",$prod);
  $eggcnt = count($cat) - 1;
  for($d = 0;$d < $eggcnt;$d++)
  {
    $eggs = explode(":",$cat[$d]);
	if($eggs[1] > 0)
	{
	$totprod = $totprod + $eggs[1];
	}
	if($eggs[0] == "HE100")
	{
	$tothe = $eggs[1];
	}
  }
  $datenow = "";
 ?>
<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo date("j-M",$strdate);$datenow =  date("Y-m-j",$strdate); ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $row12['age'] ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $fprodop; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $mprodop; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fmort']; $cummfmort = $cummfmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['mmort'];  $cummmmort = $cummmmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fcull'];  $cummfcull = $cummfcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['mcull'];  $cummmcull = $cummmcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummfsexing = $cummfsexing + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummmsexing = $cummmsexing + $a; ?></td>
  <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($row12['ffeedqty'] + $row12['mfeedqty']),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($row12['ffeedqty']),2);  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round((($row12['ffeedqty'] * 1000)/($fprodop * 7)),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($row12['mfeedqty']),2);  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round((($row12['mfeedqty'] * 1000)/($mprodop * 7)),2); ?></td>
   <!-- Consumption Costing Start-->
<?php
$fromdatedc = "";$todatedc ="";$flkdc1=0;
for($ui=0;$ui < count($unitarr);$ui++)
{
$unit = "";$unitcost=0;
$unit = $unitarr[$ui];
$query = "SELECT dayspan,fromdate,todate FROM breeder_unitwisemaintaincecost WHERE unit = '$unit' and fromdate <='$datenow' and todate>='$datenow'";
$resultdc = mysql_query($query,$conn); 
while($rowdc = mysql_fetch_assoc($resultdc))  
  {
      $unitcost = $unitcost + $rowdc['dayspan'];
	  $fromdatedc = $rowdc['fromdate'];
	  $todatedc = $rowdc['todate'];
  }
}
$unitcost = $unitcost * 7;
$fc1 =0;
if( $fromdatedc != "" && $todatedc != "")
{
$fc = 0;$flkdcarr = "";
$query = "SELECT distinct(flock) FROM breeder_consumption WHERE  date2 >='$fromdatedc' and date2>='$todatedc'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkdcarr[$fc] = $rowdc1['flock'];
$fc++;
}
$flkdcarrmain ="";
for($fc=0;$fc<count($flkdcarr);$fc++)
{
$flkco="";
$flkco = $flkdcarr[$fc];
$query = "SELECT flkmain,unitcode FROM breeder_flock WHERE  flockcode ='$flkco'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkmainc ="";
$flkmainc = $rowdc1['flkmain'];
$unitcc = $rowdc1['unitcode'];
if((!in_array($flkmainc,$flkdcarrmain)) && (in_array($unitcc,$unitarr)))
{
$flkdcarrmain[$fc1] = $flkmainc;
$fc1++;
$flkdc1++;
}
}
}
//echo $flkdc1 = count($flkdcarrmain);

$flkunitcost = round(($unitcost/$flkdc1),2);
}
?>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0;" ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php if($flkunitcost == "") { echo "0"; } else {echo $flkunitcost; } ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = "0"; $cummccost = $cummccost + $a; ?></td>

<!-- Consumption Costing End -->
<td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $totprod;  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo round((($totprod/7)/$fprodop)*100,1); ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo $istdhdper[$row12['age']]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $tothe;  $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo round(($tothe/$totprod)*100,1); ?></td>
   <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php echo $istdheggper[$row12['age']]; ?></td>
  
   <!-- Sale Costing Start-->

  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo "0"; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = "0"; $cummpcost = $cummpcost + $a; ?></td>

<!-- Sale Costing End -->

<td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo round((($row12['ffeedqty'] + $row12['mfeedqty']) / $tothe)*1000,2); ?></td>
  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo round(($tfeedcost + $tmedcost + $tvaccost + $toicost) / $tothe,2); ?></td>

</tr>
<?php
$strdate = $strdate + (7 * 24 * 60 * 60);
$fprodop = $fprodop - $row12['fmort'] - $row12['fcull'];
$mprodop = $mprodop - $row12['mmort'] - $row12['mcull'];
}?>

<?php
for($m = $istart;$m <= $iend;$m++)
{
 $ctodate =  date("Y-m-d",$_SESSION['idate'][$m]); 
 $gpdate = $_SESSION['idate'][$m] - (6 * 24 * 60 * 60);
 $cfromdate = date("Y-m-d",$gpdate);
 $tfeedtype = $ffeedtype . "," . $mfeedtype;



  $remfeed = 0;
  $remfeedcost = 0;
  $tfeedcost = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($tfeedtype) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {

    $query1a = "SELECT avg(feedcostperkg) as 'feedcostperkg' FROM feed_productionunit WHERE date >= '$cfromdate' and date <= '$ctodate' and mash = '$row11[itemcode]' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $tfeedprice = $row11a['feedcostperkg'];
    }
    $tfeedcost  = $tfeedcost + ($tfeedprice * $row11['quantity']);
  }
  $tfeedcost = round($tfeedcost,2);

  $tmedcost = 0;
  $tmedprice = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($medicine) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
    $query1a = "SELECT avg(price) as 'price' FROM ims_stocktransfer WHERE date >= '$cfromdate' and date <= '$ctodate' and code = '$row11[itemcode]' and towarehouse like '%$flockget' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $tmedprice = $row11a['price'];
    }
    if($tmedprice == 0 || $tmedprice == "")
    {
      $query1a = "SELECT avg(rateperunit) as 'price' FROM pp_sobi WHERE code = '$row11[itemcode]'";
      $result1a = mysql_query($query1a,$conn); 
      while($row11a = mysql_fetch_assoc($result1a))
      {
        $tmedprice = $row11a['price'];
      }
    }
    $tmedcost  = $tmedcost + ($tmedprice * $row11['quantity']);
  }

  $tvaccost = 0;
  $tvacprice = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($vaccine) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
    $query1a = "SELECT avg(price) as 'price' FROM ims_stocktransfer WHERE date >= '$cfromdate' and date <= '$ctodate' and code = '$row11[itemcode]' and towarehouse like '%$flockget' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $tvacprice = $row11a['price'];
    }
    if($tvacprice == 0 || $tvacprice == "")
    {
      $query1a = "SELECT avg(rateperunit) as 'price' FROM pp_sobi WHERE code = '$row11[itemcode]'";
      $result1a = mysql_query($query1a,$conn); 
      while($row11a = mysql_fetch_assoc($result1a))
      {
        $tvacprice = $row11a['price'];
      }
    }
    $tvaccost  = $tvaccost + ($tvacprice * $row11['quantity']);
  }

  $toicost = 0;
  $toiprice = 0;
  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and itemcode in ($otheritems) and date2 >= '$cfromdate' and date2 <= '$ctodate' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
    $query1a = "SELECT avg(price) as 'price' FROM ims_stocktransfer WHERE date >= '$cfromdate' and date <= '$ctodate' and code = '$row11[itemcode]' and towarehouse like '%$flockget' ORDER BY date ASC";
    $result1a = mysql_query($query1a,$conn); 
    while($row11a = mysql_fetch_assoc($result1a))
    {
       $toiprice = $row11a['price'];
    }
    if($toiprice == 0 || $toiprice == "")
    {
      $query1a = "SELECT avg(rateperunit) as 'price' FROM pp_sobi WHERE code = '$row11[itemcode]'";
      $result1a = mysql_query($query1a,$conn); 
      while($row11a = mysql_fetch_assoc($result1a))
      {
        $toiprice = $row11a['price'];
      }
    }
    $toicost  = $toicost + ($toiprice * $row11['quantity']);
  }

  $salembirds = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($mbirds) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salembirds = round($row11a['total'],2);
  }

  $salefbirds = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($fbirds) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salefbirds = round($row11a['total'],2);
  }

  $saleeggs = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($eggs) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $saleeggs = round($row11a['total'],2);
  }

  $salehatcheggs = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($hatcheggs) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salehatcheggs = round($row11a['total'],2);
  }

  $salechicks = 0;
  $query1a = "SELECT sum(finaltotal) as 'total' FROM oc_cobi WHERE date >= '$cfromdate' and date <= '$ctodate' and code in ($bchicks) and flock like '%$flockget' ORDER BY date ASC";
  $result1a = mysql_query($query1a,$conn); 
  while($row11a = mysql_fetch_assoc($result1a))
  {
       $salechicks = round($row11a['total'],2);
  }
  $datenow = "";
?>

<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo date("j-M",$_SESSION['idate'][$m]);$datenow =  date("Y-m-d",$_SESSION['idate'][$m]);  ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $m ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['ifemale'][$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['imale'][$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['ifmort'][$m]; $cummfmort = $cummfmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['immort'][$m];  $cummmmort = $cummmmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['ifcull'][$m];  $cummfcull = $cummfcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['imcull'][$m];  $cummmcull = $cummmcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = 0;  $cummfsexing = $cummfsexing + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = 0;  $cummmsexing = $cummmsexing + $a; ?></td>

  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $t1 = $_SESSION['iffeed'][$m] + $_SESSION['imfeed'][$m]; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['iffeed'][$m];  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['iffeedpb'][$m]; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['imfeed'][$m];  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['imfeedpb'][$m]; ?></td>

 <!-- Consumption Costing Start-->
<?php
$fromdatedc = "";$todatedc ="";$flkdc1=0;
for($ui=0;$ui < count($unitarr);$ui++)
{
$unit = "";$unitcost=0;
$unit = $unitarr[$ui];
$query = "SELECT dayspan,fromdate,todate FROM breeder_unitwisemaintaincecost WHERE unit = '$unit' and fromdate <='$datenow' and todate>='$datenow'";
$resultdc = mysql_query($query,$conn); 
while($rowdc = mysql_fetch_assoc($resultdc))  
  {
      $unitcost = $unitcost + $rowdc['dayspan'];
	  $fromdatedc = $rowdc['fromdate'];
	  $todatedc = $rowdc['todate'];
  }
}
$unitcost = $unitcost * 7;
$fc1 =0;
if( $fromdatedc != "" && $todatedc != "")
{
$fc = 0;$flkdcarr = "";
$query = "SELECT distinct(flock) FROM breeder_consumption WHERE  date2 >='$fromdatedc' and date2>='$todatedc'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkdcarr[$fc] = $rowdc1['flock'];
$fc++;
}
$flkdcarrmain ="";
for($fc=0;$fc<count($flkdcarr);$fc++)
{
$flkco="";
$flkco = $flkdcarr[$fc];
$query = "SELECT flkmain,unitcode FROM breeder_flock WHERE  flockcode ='$flkco'";
$resultdc1 = mysql_query($query,$conn); 
while($rowdc1= mysql_fetch_assoc($resultdc1))  
{
$flkmainc ="";
$flkmainc = $rowdc1['flkmain'];
$unitcc = $rowdc1['unitcode'];
if((!in_array($flkmainc,$flkdcarrmain)) && (in_array($unitcc,$unitarr)))
{
$flkdcarrmain[$fc1] = $flkmainc;
$fc1++;
$flkdc1++;
}
}
}
//echo $flkdc1 = count($flkdcarrmain);

$flkunitcost = round(($unitcost/$flkdc1),2);
}

?>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $tfeedcost; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $tmedcost; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $tvaccost; ?></td>
  <!--<td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $toicost; ?></td>-->
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php if($flkunitcost == "") { echo "0"; } else {echo $flkunitcost; } ?></td>
  
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = round($tfeedcost + $tmedcost + $tvaccost + $toicost,2); $cummccost = $cummccost + $a; ?></td>

<!-- Consumption Costing End -->


  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['ieggs'][$m];  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo round((($_SESSION['ieggs'][$m]/7)/$_SESSION['ifemale'][$m])*100,1); ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span> &nbsp;<?php echo $istdhdper[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = $_SESSION['iheggs'][$m];  $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo round(($_SESSION['iheggs'][$m]/$_SESSION['ieggs'][$m])*100,1); ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span> &nbsp;<?php echo $istdheggper[$m]; ?></td>


 <!-- Sale Costing Start-->

  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salehatcheggs; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salefbirds; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salembirds; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $salechicks; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $saleeggs; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $a = round($saleeggs + $salehatcheggs + $salefbirds + $salembirds + $salechicks,2); $cummpcost = $cummpcost + $a; ?></td>

<!-- Sale Costing End -->

  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo round((($_SESSION['iffeed'][$m] + $_SESSION['imfeed'][$m]) / $_SESSION['iheggs'][$m])*1000,2); ?></td>
  <td class=xl688 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo round(($tfeedcost + $tmedcost + $tvaccost + $toicost) / $_SESSION['iheggs'][$m],2); ?></td>


  <!-- <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $istdfweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['ifbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['ifbweight'][$m] - $istdfweight[$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $istdmweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['imbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['imbweight'][$m] - $istdmweight[$m]; ?></td>
  


  <td class=xl558 align=right style='border-left:none'> &nbsp;<?php echo $istdeggwt[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo $_SESSION['ieggwt'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'> &nbsp;<?php echo round($_SESSION['ieggwt'][$m],1) - round($istdeggwt[$m],1); ?></td> -->
 </tr>

<?php } ?>

 
  <tr height=18 style='height:13.5pt;'>
  <td height=18 class=xl524 style='height:13.5pt'>TOTAL</td>
  <td class=xl509></td>
  <td class=xl516 style='border-top:none'>&nbsp;</td>
  <td class=xl516 style='border-top:none'>&nbsp;</td>
  <td class=xl535 align=right style='border-top:none'><?php echo round($cummfmort,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmmort,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummfcull,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmcull,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummfsexing,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmsexing,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed + $cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummccost,2); ?></td>
  <td class=xl536 align=right style='border-top:none'>&nbsp;<?php echo round($cummeggs,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummhatcheggs,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummpcost,2); ?></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr class=xl523 height=18 style='height:13.5pt;display:none'>
  <td height=18 class=xl523 style='height:13.5pt'></td>
  <td class=xl525></td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl551 align=center><?php echo round(($cummfmort/$startfemale)*100,2); ?></td>
  <td class=xl551 align=center><?php echo round(($cummmmort/$startmale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummfcull/$startfemale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummmcull/$startmale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummfsexing/$startfemale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummmsexing/$startmale)*100,2); ?></td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>
  <td class=xl526></td>
  <td class=xl526></td>
  <td colspan=3 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
 </tr>

 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=10 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=10 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
 </tr>

<!---------------- Laying End ---------------------------------->

<?php } ?>

 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=50 style='width:38pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=40 style='width:30pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=40 style='width:30pt'></td>
  <td width=75 style='width:56pt'></td>
  <td width=56 style='width:42pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=39 style='width:29pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=39 style='width:29pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
  <td width=31 style='width:23pt'></td>
 </tr>
 <![endif]>
</table>


<?php  $end_process = (float) array_sum(explode(' ',microtime())); 
	$exetime = $end_process-$start_process;
?>
<input id="exetime1" value="<?php echo $exetime; ?>" type="hidden"/>
<center>
<br/><br/>
<p ><div id="loadgingpage" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif"></div></p>
</center>


</body>
<script type="text/javascript">
document.getElementById("loadingimg").style.visibility = "hidden";
</script>
</html>
