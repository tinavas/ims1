<?php session_start(); $flockget = $_SESSION['flock']; 
$client = $_SESSION['client']; 
$istart = $_SESSION['istartage'];
$iend = $_SESSION['iage'];
 $jstart = $_SESSION['jstartage'];
$jend = $_SESSION['jage'];
$breedi = $_SESSION['breedi'] ;
include "../config.php";
	
	 $query34 = "SELECT * FROM breeder_standards where client = '$client' and breed = '$breedi' ORDER BY age ASC ";
	
//$query34 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 

  $istdhdper[$row134['age']] = $row134['henday'];
 // $istdheggper[$row134['age']] = $row134['heggper'];
  $istdeggwt[$row134['age']] = $row134['eggweight'];
  $istdfweight[$row134['age']] = $row134['bodyweight'];
  //$istdmweight[$row134['age']] = $row134['mweight'];
}
$startfemale = $_SESSION['ifemale'][$istart]; 
$startmale = $_SESSION['imale'][$istart]; 
$cummfmort = $cummmort = $cummfcull = $cummmcull = $cummfsexing = $cummmsexing = $cummeggs = $cummhatcheggs = $cummffeed = $cummmfeed = 0;
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
<![if !supportTabStrip]><script language="JavaScript">
<!--
function fnUpdateTabs()
 {
  if (parent.window.g_iIEVer>=4) {
   if (parent.document.readyState=="complete"
    && parent.frames['frTabs'].document.readyState=="complete")
   parent.fnSetActiveSheet(2);
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

<center>
  <table><tr><td style="font-size:13px"><b>Weekly Report For Flock <?php session_start(); echo $flockget; ?></b></td></tr></table>
</center>

<table border=0 cellpadding=0 cellspacing=0 width=1202 style='border-collapse:
 collapse;table-layout:fixed;width:898pt'>
 <col class=xl128 width=50 style='mso-width-source:userset;mso-width-alt:1828;
 width:38pt'>
 <col class=xl509 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl128 width=45 style='mso-width-source:userset;mso-width-alt:1280;
 width:36pt'>
 <col class=xl128 width=41 style='mso-width-source:userset;mso-width-alt:1133;
 width:33pt'>
 <col class=xl510 width=41 style='mso-width-source:userset;mso-width-alt:1133;
 width:33pt'>
 <col class=xl128 width=41 span=3 style='mso-width-source:userset;mso-width-alt:
 1133;width:33pt'>
 <col class=xl510 width=60 style='mso-width-source:userset;mso-width-alt:1792;
 width:50pt'>
 <col class=xl128 width=60 span=2 style='mso-width-source:userset;mso-width-alt:1133;
 width:50pt'>
 <col class=xl511 width=40 span=3 style='mso-width-source:userset;mso-width-alt:1462;
 width:30pt'>
 <col class=xl510 width=49 span =3 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl128 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl511 width=40 style='mso-width-source:userset;mso-width-alt:1462;
 width:30pt'>
 <col class=xl510 width=75 style='mso-width-source:userset;mso-width-alt:2742;
 width:56pt'>
 <col class=xl510 width=56 style='mso-width-source:userset;mso-width-alt:2048;
 width:42pt'>
 <col class=xl128 width=60 style='mso-width-source:userset;mso-width-alt:2194;
 width:45pt'>
 <col class=xl128 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl128 width=60 style='mso-width-source:userset;mso-width-alt:2194;
 width:45pt'>
 <col class=xl566 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl557 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl128 width=39 style='mso-width-source:userset;mso-width-alt:1426;
 width:29pt'>
 <col class=xl566 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl557 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl128 width=39 style='mso-width-source:userset;mso-width-alt:1426;
 width:29pt'>
 <col class=xl566 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl557 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl128 width=31 style='width:23pt'>
 <tr height=17 style='height:12.75pt'>
  <td colspan=27 height=17 class=xl69 width=1109 style='height:12.75pt;
  width:829pt'>&nbsp;</td>
  <td class=xl128 width=31 style='width:23pt'></td>
  <td class=xl128 width=31 style='width:23pt'></td>
  <td class=xl128 width=31 style='width:23pt'></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 colspan=12 class=xl69 style='height:12.75pt;mso-ignore:colspan'>&nbsp;</td>
  <td class=xl183>&nbsp;</td>
  <td colspan=2 class=xl69 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl183>&nbsp;</td>
  <td colspan=11 class=xl69 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:9.75pt'>
  <td colspan=27 height=13 class=xl69 style='height:15.75pt'></td>
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
<tr height="20px"><td></td></tr>
 <tr height=0 style='display:none;mso-height-source:userset;mso-height-alt:
  1230'>
  <td class=xl129 colspan=2 style='mso-ignore:colspan'>BATCH No<span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span><span style='display:none'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>:
  4</span></td>
  <td class=xl129 align=right>5</td>
  <td colspan=3 class=xl69>&nbsp;</td>
  <td colspan=6 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl491>&nbsp;</td>
  <td colspan=2 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl491>&nbsp;</td>
  <td colspan=11 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=0 style='display:none;mso-height-source:userset;mso-height-alt:
  300'>
  <td colspan=3 class=xl69>Received Date<span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp; </span>:</td>
  <td class=xl492 colspan=2 style='mso-ignore:colspan'>13/3/2008</td>
  <td colspan=6 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl132 colspan=2 style='mso-ignore:colspan'>F-Males</td>
  <td class=xl129 align=right>5496</td>
  <td class=xl490>&nbsp;</td>
  <td class=xl494>&nbsp;</td>
  <td class=xl129>&nbsp;</td>
  <td class=xl490>&nbsp;</td>
  <td class=xl495>&nbsp;</td>
  <td colspan=2 class=xl496 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=6 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=36 style='mso-height-source:userset;height:27.0pt'>
  <td rowspan=2 height=98 class=xl497 style='height:73.5pt'>Date</td>
  <td rowspan=2 class=xl497>Age</td>
  <td rowspan=2  class=xl497 style='border-left:none'>No. of Birds</td>
  <td rowspan=2 class=xl497 style='border-left:none'>Mort.</td>
  <td rowspan=2 class=xl497 style='border-left:none'>culls</td>
  <!--<td  rowspan=2 class=xl497 style='border-left:none'>Sexing</td>-->
  <td colspan=3 class=xl756 style='border-left:none'>Prod.</td>
 <!-- <td colspan=3 class=xl756>Hat. Eggs</td>-->
  <td rowspan=2 class=xl498 width=75 style='width:56pt'>Total Feed in kgs</td>
  <td colspan=2 class=xl497 style='border-left:none'>Feed Consumption</td>
  <td colspan=3 class=xl498 width=109 style='border-left:none;width:81pt'><span
  style='mso-spacerun:yes'>&nbsp; </span>Body<span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span>Wt in Gms</td>
  <!--<td colspan=3 class=xl498 width=109 style='border-left:none;width:81pt'>Male
  Body<span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Wt in Gms</td>-->
  <td colspan=3 class=xl754 width=93 style='border-right:.5pt solid black;
  border-left:none;width:69pt'>EGG WT</td>
 </tr>
 <tr height=62 style='mso-height-source:userset;height:46.5pt'>
<!--  <td height=62 class=xl497 style='height:46.5pt;border-top:none;border-left:
  none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>
  <td class=xl497 style='border-top:none;border-left:none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>
  <td class=xl497 style='border-top:none;border-left:none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>
  <td class=xl497 style='border-top:none;border-left:none'>F</td>
  <td class=xl497 style='border-top:none;border-left:none'>M</td>-->
  <td class=xl497 style='border-top:none;border-left:none'>No.</td>
  <td class=xl497 style='border-top:none;border-left:none'>%</td>
  <td class=xl499  style='border-top:none;border-left:none;width:30pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>St. %<span
  style='mso-spacerun:yes'>&nbsp;</span></td>
 <!-- <td class=xl497 style='border-top:none;border-left:none'>No.</td>
  <td class=xl497 style='border-top:none;border-left:none'>%</td>
  <td class=xl499 width=40 style='border-top:none;border-left:none;width:30pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>St. %<span
  style='mso-spacerun:yes'>&nbsp;</span></td>-->
  <td class=xl498 width=56 style='border-top:none;border-left:none;width:42pt'>Total in kgs</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Per
  Bird/day in gms</td>
 <!-- <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>M
  Total in kgs</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Per
  Bird/day in gms</td>-->
  <td class=xl500 width=35 style='border-top:none;width:26pt'>Std.</td>
  <td class=xl498 width=35 style='border-top:none;border-left:none;width:26pt'>Act.</td>
  <td class=xl498 width=39 style='border-top:none;border-left:none;width:29pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+/-</td>
 <!-- <td class=xl498 width=35 style='border-top:none;border-left:none;width:26pt'>Std.</td>
  <td class=xl498 width=35 style='border-top:none;border-left:none;width:26pt'>Act.</td>
  <td class=xl498 width=39 style='border-top:none;border-left:none;width:29pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+/-</td>-->
  <td class=xl498 width=31 style='border-top:none;border-left:none;width:23pt'>Std.</td>
  <td class=xl498 width=31 style='border-top:none;border-left:none;width:23pt'>Act.</td>
  <td class=xl498 width=31 style='border-top:none;border-left:none;width:23pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+/-</td>
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
  <!-- <td class=xl544 style='border-top:none'>&nbsp;</td>
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
  <td class=xl544>&nbsp;</td>-->
 </tr>


<?php 

if($jstart == "")
{
$query12 = "SELECT min(age) as minage,female from layer_initial WHERE flock like '$flockget' and age < '$istart' and eggs = '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$ijstart = $row12['minage'];
$strtbfemale = $row12['female'];
//$strtbmale = $row12['male'];
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
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
  <!--  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
<td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl531 style='border-left:none'>&nbsp;</td>
  <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl128></td>
  <td class=xl529 style='border-top:none'>&nbsp;</td>
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>-->
 </tr>
 
 <?php
$startdummage = 0;
$mcummort = 0;
$mcumcull = 0;
$fcummort = 0;
$fcumcull = 0;
$strtfemale = 0;
$strtmale = 0;
$query12 = "SELECT min(age) as minage,female from layer_initial WHERE flock like '$flockget' and age < '$istart' and eggs = '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage'];
$strtfemale = $row12['female'];
//$strtmale = $row12['male'];
}
$query12 = "SELECT sum(fmort) as fmort,sum(fcull) as fcull, from layer_initial WHERE flock like '$flockget' and age < '$startdummage' and eggs = '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$fcummort = $row12['fmort'];
$fcumcull = $row12['fcull'];
//$mcummort = $row12['mmort'];
//$mcumcull = $row12['mcull'];
}
$fprodop = $strtfemale - $fcummort - $fcumcull;
//$mprodop = $strtmale - $mcummort - $mcumcull; 
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
 $query12 = "SELECT * from layer_initial WHERE flock like '$flockget' and age < '$istart' and eggs = '' order by age  ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$tage = $row12['age'];

  ?>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo $a = date("j-M",$strdate); $_SESSION['jdate'][$tage] = $a; $_SESSION['jdatetime'][$tage] = strtotime($strdate);?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $row12['age'] ; ?></td>
    <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $fprodop;  $_SESSION['jfemale'][$tage] =  $fprodop; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fmort']; $cummfmort = $cummfmort + $a;  $_SESSION['jfmort'][$tage] = $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fcull'];  $cummfcull = $cummfcull + $a; $_SESSION['jfcull'][$tage] = $a;?></td>
   <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo 0; ?></td>
   <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($row12['ffeedqty']),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($row12['ffeedqty']),2);  $cummffeed = $cummffeed + $a; $_SESSION['jffeed'][$tage] = $a;?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo $a= round((($row12['ffeedqty'] * 1000)/($fprodop * 7)),2); $_SESSION['jffeedpb'][$tage] = $a;?></td>
    <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdfweight[$row12['age']]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $tx1 = $row12['fweight'];  $_SESSION['fbweight'][$tage] =$tx1;?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $row12['fweight'] - $istdfweight[$row12['age']]; ?></td>
    <td class=xl558 align=right style='border-left:none'><?php echo $istdeggwt[$row12['age']]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $row12['eggwt']; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo round($row12['eggwt'],1) - round($istdeggwt[$row12['age']],1); ?></td>
  </tr> 
<?php
$strdate = $strdate + (7 * 24 * 60 * 60);
$fprodop = $fprodop - $row12['fmort'] - $row12['fcull'];
//$mprodop = $mprodop - $row12['mmort'] - $row12['mcull'];
 } ?>


<?php
for($m = $jstart;$m <= $jend;$m++)
{
?>

<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo $_SESSION['jdate'][$m]; ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $m ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jfemale'][$m]; ?></td>
 <?php /*?> <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jmale'][$m]; ?></td><?php */?>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jfmort'][$m]; $cummfmort = $cummfmort + $a; ?></td>
<?php /*?>  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jmmort'][$m];  $cummmmort = $cummmmort + $a; ?></td><?php */?>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jfcull'][$m];  $cummfcull = $cummfcull + $a; ?></td>
<?php /*?>  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jmcull'][$m];  $cummmcull = $cummmcull + $a; ?></td><?php */?>
  <?php /*?><td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jfsexing'][$m];  $cummfsexing = $cummfsexing + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jmsexing'][$m];  $cummmsexing = $cummmsexing + $a; ?></td><?php */?>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
 <?php /*?> <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><span class="xl530" style="border-top:none;border-left:none"><?php echo 0; ?></span></td><?php */?>
<?php /*?>  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = 0; $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php echo 0; ?></td><?php */?>
  <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($_SESSION['jffeed'][$m]),2) ; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['jffeed'][$m]),2);  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['jffeedpb'][$m]),2); ?></td>
 <?php /*?> <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['jmfeed'][$m]),2);  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['jmfeedpb'][$m]),2); ?></td><?php */?>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdfweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jfbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jfbweight'][$m] - $istdfweight[$m]; ?></td>
<?php /*?>  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdmweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jmbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jmbweight'][$m] - $istdmweight[$m]; ?></td><?php */?>
  <td class=xl558 align=right style='border-left:none'><?php echo 0; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
 </tr>

<?php } ?>

 
  <tr height=18 style='height:13.5pt'>
  <td height=18 class=xl524 style='height:13.5pt'>TOTAL</td>
  <td class=xl509></td>
  <td class=xl516 style='border-top:none'>&nbsp;</td>
 <!-- <td class=xl516 style='border-top:none'>&nbsp;</td>-->
  <td class=xl535 align=right style='border-top:none'><?php echo round($cummfmort,2); ?></td>
<?php /*?>  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmmort,2); ?></td><?php */?>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummfcull,2); ?></td>
 <?php /*?> <td class=xl536 align=right style='border-top:none'><?php echo round($cummmcull,2); ?></td><?php */?>
   <?php /*?><td class=xl536 align=right style='border-top:none'><?php echo round($cummfsexing,2); ?></td>
 <td class=xl536 align=right style='border-top:none'><?php echo round($cummmsexing,2); ?></td><?php */?>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummeggs,2); ?></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl516 align=right style='border-top:none'></td>
 <?php /*?> <td class=xl536 align=right style='border-top:none'><?php echo round($cummhatcheggs,2); ?></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl511></td><?php */?>
  <td class=xl535 align=right style='border-top:none'><?php echo round(($cummffeed ),2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <?php /*?><td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td><?php */?>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl128></td>
  <td class=xl128></td>
  <!--<td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>-->
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl128></td>
 </tr>
 <tr class=xl523 height=18 style='height:13.5pt;display:none'>
  <td height=18 class=xl523 style='height:13.5pt'></td>
  <td class=xl525></td>
  <td  class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl551 align=center><?php echo round(($cummfmort/$startfemale)*100,2); ?></td>
<?php /*?>  <td class=xl551 align=center><?php echo round(($cummmmort/$startmale)*100,2); ?></td><?php */?>
  <td class=xl551 align=right><?php echo round(($cummfcull/$startfemale)*100,2); ?></td>
 <?php /*?> <td class=xl551 align=right><?php echo round(($cummmcull/$startmale)*100,2); ?></td><?php */?>
  <?php /*?> <td class=xl551 align=right><?php echo round(($cummfsexing/$startfemale)*100,2); ?></td>
 <td class=xl551 align=right><?php echo round(($cummmsexing/$startmale)*100,2); ?></td><?php */?>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>
  <!--<td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>-->
  <td class=xl526></td>
  <td class=xl526></td>
  <td  class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <!--<td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>-->
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
 </tr>

 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
<!--  <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>-->
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <!--<td class=xl557></td>
  <td class=xl128></td>
  <td class=xl566></td>-->
  <td class=xl557></td>
  <td class=xl128></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
 <!-- <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>-->
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
 <!-- <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>-->
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
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <!--  <td class=xl529 style='border-left:none'>&nbsp;</td>
<td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl531 style='border-left:none'>&nbsp;</td>
  <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl558 style='border-left:none'>&nbsp;</td>
  <td class=xl554 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl128></td>
  <td class=xl529 style='border-top:none'>&nbsp;</td>
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>-->
 </tr>


<?php
$startdummage = 0;
$mcummort = 0;
$mcumcull = 0;
$fcummort = 0;
$fcumcull = 0;
$strtfemale = 0;
$strtmale = 0;
$query12 = "SELECT min(age) as minage,female from layer_initial WHERE flock like '$flockget' and age < '$istart' and eggs <> '' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage'];
$strtfemale = $row12['female'];
//$strtmale = $row12['male'];
}
 $query12 = "SELECT sum(fmort) as fmort,sum(fcull) as fcull from layer_initial WHERE flock like '$flockget' and age < '$startdummage' ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
  $fcummort = $row12['fmort'];
 $fcumcull = $row12['fcull'];
//$mcummort = $row12['mmort'];
//$mcumcull = $row12['mcull'];
}
$fprodop = $strtfemale - $fcummort - $fcumcull;
//$mprodop = $strtmale - $mcummort - $mcumcull; 
$agdif = $istart - $startdummage;
$actdate = $_SESSION['idate'][$istart];
$strdate = $_SESSION['idate'][$istart] - ($agdif*7*24*60*60);
//$strdate = date("d-m-Y",$strdate);
//echo $strdate;
 $query12 = "SELECT * from layer_initial WHERE flock like '$flockget' and age < '$istart' and eggs <> '' ";
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
   $tage = $row12['age'];
  ?>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo date("j-M",$strdate); ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $row12['age'] ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $fprodop; $_SESSION['ifemale'][$tage] =  $fprodop; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fmort']; $cummfmort = $cummfmort + $a; $_SESSION['ifmort'][$tage] = $a;?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['fcull'];  $cummfcull = $cummfcull + $a; $_SESSION['ifcull'][$tage] = $a;?></td>
   <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $totprod;  $cummeggs = $cummeggs + $a;  $_SESSION['ieggs'][$tage] = $a;  $tempcomp2 = round($cummeggs/$fprodop,2); $_SESSION['eggbird'][$tage] = $tempcomp2;?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo $a = round((($totprod/7)/$fprodop)*100,1); $_SESSION['hd'][$tage] = $a;?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo $istdhdper[$row12['age']]; ?></td>
     <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($row12['ffeedqty'] + $row12['mfeedqty']),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($row12['ffeedqty']),2);  $cummffeed = $cummffeed + $a; $_SESSION['iffeed'][$tage] = $a;?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo $a = round((($row12['ffeedqty'] * 1000)/($fprodop * 7)),2); $_SESSION['iffeedpb'][$tage] = $a;?></td>
    <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdfweight[$row12['age']]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $tx1 = $row12['fweight']; $_SESSION['fbweight'][$tage] =$tx1;?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $row12['fweight'] - $istdfweight[$row12['age']]; ?></td>
  <td class=xl558 align=right style='border-left:none'><?php echo $istdeggwt[$row12['age']]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $row12['eggwt']; $_SESSION['ieggwt'][$tage] = $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo round($row12['eggwt'],1) - round($istdeggwt[$row12['age']],1); ?></td>

  </tr>
<?php
$strdate = $strdate + (7 * 24 * 60 * 60);
$fprodop = $fprodop - $row12['fmort'] - $row12['fcull'];
$mprodop = $mprodop - $row12['mmort'] - $row12['mcull'];
 }

for($m = $istart;$m <= $iend;$m++)
{
?>

<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo date("j-M",$_SESSION['idate'][$m]); ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $m ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ifemale'][$m]; ?></td>
 <?php /*?> <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['imale'][$m]; ?></td><?php */?>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['ifmort'][$m]; $cummfmort = $cummfmort + $a; ?></td>
 <?php /*?> <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['immort'][$m];  $cummmmort = $cummmmort + $a; ?></td><?php */?>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['ifcull'][$m];  $cummfcull = $cummfcull + $a; ?></td>
 <?php /*?> <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['imcull'][$m];  $cummmcull = $cummmcull + $a; ?></td><?php */?>
  <?php /*?> <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummfsexing = $cummfsexing + $a; ?></td>
 <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummmsexing = $cummmsexing + $a; ?></td><?php */?>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['ieggs'][$m];  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo round((($_SESSION['ieggs'][$m]/7)/$_SESSION['ifemale'][$m])*100,1); ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo $istdhdper[$m]; ?></td>
 <?php /*?> <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['iheggs'][$m];  $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['iheggs'][$m]/$_SESSION['ieggs'][$m])*100,1); ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php echo $istdheggper[$m]; ?></td><?php */?>
  <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($_SESSION['iffeed'][$m]),2) ; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['iffeed'][$m]),2);  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['iffeedpb'][$m]),2); ?></td>
 <?php /*?> <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['imfeed'][$m]),2);  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['imfeedpb'][$m]),2); ?></td><?php */?>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdfweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ifbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ifbweight'][$m] - $istdfweight[$m]; ?></td>
  <?php /*?><td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdmweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['imbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['imbweight'][$m] - $istdmweight[$m]; ?></td><?php */?>
  <td class=xl558 align=right style='border-left:none'><?php echo $istdeggwt[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ieggwt'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo round($_SESSION['ieggwt'][$m],1) - round($istdeggwt[$m],1); ?></td>
 </tr>

<?php } ?>

 
  <tr height=18 style='height:13.5pt'>
  <td height=18 class=xl524 style='height:13.5pt'>TOTAL</td>
  <td class=xl509></td>
  <td class=xl516 style='border-top:none'>&nbsp;</td>
 <!-- <td class=xl516 style='border-top:none'>&nbsp;</td>-->
  <td class=xl535 align=right style='border-top:none'><?php echo round($cummfmort,2); ?></td>
<?php /*?>  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmmort,2); ?></td><?php */?>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummfcull,2); ?></td>
<?php /*?>  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmcull,2); ?></td><?php */?>
 <?php /*?> <td class=xl536 align=right style='border-top:none'><?php echo round($cummfsexing,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmsexing,2); ?></td><?php */?>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummeggs,2); ?></td>
 <td class=xl537 style='border-top:none'>&nbsp;</td>
 <td  class=xl523 style='mso-ignore:colspan'></td>
 <?php /*?> <td class=xl536 align=right style='border-top:none'><?php echo round($cummhatcheggs,2); ?></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl511></td><?php */?>
  <td class=xl535 align=right style='border-top:none'><?php echo round($cummffeed ,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <?php /*?><td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td><?php */?>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl128></td>
  <td class=xl128></td>
  <!--<td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>-->
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl128></td>
 </tr>
 <tr class=xl523 height=18 style='height:13.5pt;display:none'>
  <td height=18 class=xl523 style='height:13.5pt'></td>
  <td class=xl525></td>
  <td  class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl551 align=center><?php echo round(($cummfmort/$startfemale)*100,2); ?></td>
 <?php /*?> <td class=xl551 align=center><?php echo round(($cummmmort/$startmale)*100,2); ?></td><?php */?>
  <td class=xl551 align=right><?php echo round(($cummfcull/$startfemale)*100,2); ?></td>
  <?php /*?><td class=xl551 align=right><?php echo round(($cummmcull/$startmale)*100,2); ?></td><?php */?>
  <?php /*?><td class=xl551 align=right><?php echo round(($cummfsexing/$startfemale)*100,2); ?></td>
  <td class=xl551 align=right><?php echo round(($cummmsexing/$startmale)*100,2); ?></td><?php */?>
  <td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>
  <!--<td colspan=2 class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl526></td>-->
  <td class=xl526></td>
  <td class=xl526></td>
  <td class=xl523 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
  <!--<td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>-->
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl523></td>
 </tr>

 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
 <!-- <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>-->
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <!--<td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>-->
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl128 style='height:12.75pt'></td>
  <td class=xl509></td>
  <td colspan=5 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>
 <!-- <td colspan=2 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl511></td>-->
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <!--<td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>-->
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

</body>

</html>

