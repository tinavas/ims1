<?php 
$start_process = (float) array_sum(explode(' ',microtime()));
session_start(); $flockget = $_SESSION['flock']; 
$client = $_SESSION['client']; 
$istart = $_SESSION['istartage'];
$iend = $_SESSION['iage'];
$jstart = $_SESSION['jstartage'];
$jend = $_SESSION['jage'];
$breedi = $_SESSION['breedi'] ;
include "../config.php";
	 if($breedi != "")
	{
	 $query34 = "SELECT * FROM breeder_standards where client = '$client' and breed = '$breedi' ORDER BY age ASC ";
	}
	else
	{
	 $query34 = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
	}
//$query34 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
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
<center><div id="loadingimg" >
<table>
<tr >
<td valign="bottom"><img src="../images/mask-loader.gif" align="bottom"/></td><td valign="top" align="center" style="text-align:center">(Please wait report is loading)</td>
</tr>
</table>
</div></center>

<center>
  <table><tr><td style="font-size:13px"><b>Weekly Report For Flock <?php session_start(); echo $flockget; ?></b></td></tr></table>
</center>

<table border=0 cellpadding=0 cellspacing=0 width=1202 style='border-collapse:
 collapse;table-layout:fixed;width:898pt'>
 <col class=xl128 width=50 style='mso-width-source:userset;mso-width-alt:1828;
 width:38pt'>
 <col class=xl509 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl128 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl128 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl510 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl128 width=31 span=5 style='mso-width-source:userset;mso-width-alt:
 1133;width:23pt'>
 <col class=xl510 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl128 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl511 width=40 style='mso-width-source:userset;mso-width-alt:1462;
 width:30pt'>
 <col class=xl510 width=49 style='mso-width-source:userset;mso-width-alt:1792;
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
  <td colspan=2 class=xl497 style='border-left:none'>No. of Birds</td>
  <td colspan=2 class=xl497 style='border-left:none'>Mort.</td>
  <td colspan=2 class=xl497 style='border-left:none'>culls</td>
  <td colspan=2 class=xl497 style='border-left:none'>Sexing</td>
  <td colspan=3 class=xl756 style='border-left:none'>Prod.</td>
  <td colspan=3 class=xl756>Hat. Eggs</td>
  <td rowspan=2 class=xl498 width=75 style='width:56pt'>Total Feed in kgs</td>
  <td colspan=4 class=xl497 style='border-left:none'>Feed Consumption</td>
  <td colspan=3 class=xl498 width=109 style='border-left:none;width:81pt'>Female<span
  style='mso-spacerun:yes'>&nbsp; </span>Body<span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span>Wt in Gms</td>
  <td colspan=3 class=xl498 width=109 style='border-left:none;width:81pt'>Male
  Body<span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Wt in Gms</td>
  <td colspan=3 class=xl754 width=93 style='border-right:.5pt solid black;
  border-left:none;width:69pt'>EGG WT</td>
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
  <td class=xl498 width=56 style='border-top:none;border-left:none;width:42pt'>F
  Total in kgs</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Per
  Bird/day in gms</td>
  <td class=xl498 width=49 style='border-top:none;border-left:none;width:37pt'>M
  Total in kgs</td>
  <td class=xl498 width=60 style='border-top:none;border-left:none;width:45pt'>Per
  Bird/day in gms</td>
  <td class=xl500 width=35 style='border-top:none;width:26pt'>Std.</td>
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


<?php if($jstart) { ?>

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
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
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
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>


<?php
for($m = $jstart;$m <= $jend;$m++)
{
?>

<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo $_SESSION['jdate'][$m]; ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $m ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jfemale'][$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jmale'][$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jfmort'][$m]; $cummfmort = $cummfmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jmmort'][$m];  $cummmmort = $cummmmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jfcull'][$m];  $cummfcull = $cummfcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jmcull'][$m];  $cummmcull = $cummmcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jfsexing'][$m];  $cummfsexing = $cummfsexing + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['jmsexing'][$m];  $cummmsexing = $cummmsexing + $a; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo 0; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = 0; $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php echo 0; ?></td>
  <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($_SESSION['jffeed'][$m] + $_SESSION['jmfeed'][$m]),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['jffeed'][$m]),2);  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['jffeedpb'][$m]),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['jmfeed'][$m]),2);  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['jmfeedpb'][$m]),2); ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdfweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jfbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jfbweight'][$m] - $istdfweight[$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdmweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jmbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['jmbweight'][$m] - $istdmweight[$m]; ?></td>
  <td class=xl558 align=right style='border-left:none'><?php echo 0; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo 0; ?></td>
 </tr>

<?php } ?>

 
  <tr height=18 style='height:13.5pt'>
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
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummeggs,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummhatcheggs,2); ?></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl511></td>
  <td class=xl535 align=right style='border-top:none'><?php echo round(($cummffeed + $cummmfeed),2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl128></td>
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
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-left:none'>&nbsp;</td>
  <td class=xl530 style='border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
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
  <td class=xl529 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>


<?php
for($m = $istart;$m <= $iend;$m++)
{
?>

<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo date("j-M",$_SESSION['idate'][$m]); ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $m ; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ifemale'][$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['imale'][$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['ifmort'][$m]; $cummfmort = $cummfmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['immort'][$m];  $cummmmort = $cummmmort + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['ifcull'][$m];  $cummfcull = $cummfcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['imcull'][$m];  $cummmcull = $cummmcull + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummfsexing = $cummfsexing + $a; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $a = 0;  $cummmsexing = $cummmsexing + $a; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['ieggs'][$m];  $cummeggs = $cummeggs + $a; ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php echo round((($_SESSION['ieggs'][$m]/7)/$_SESSION['ifemale'][$m])*100,1); ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo $istdhdper[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $a = $_SESSION['iheggs'][$m];  $cummhatcheggs = $cummhatcheggs + $a; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['iheggs'][$m]/$_SESSION['ieggs'][$m])*100,1); ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php echo $istdheggper[$m]; ?></td>
  <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = round(($_SESSION['iffeed'][$m] + $_SESSION['imfeed'][$m]),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['iffeed'][$m]),2);  $cummffeed = $cummffeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['iffeedpb'][$m]),2); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $a = round(($_SESSION['imfeed'][$m]),2);  $cummmfeed = $cummmfeed + $a; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo round(($_SESSION['imfeedpb'][$m]),2); ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdfweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ifbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ifbweight'][$m] - $istdfweight[$m]; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $istdmweight[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['imbweight'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['imbweight'][$m] - $istdmweight[$m]; ?></td>
  <td class=xl558 align=right style='border-left:none'><?php echo $istdeggwt[$m]; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $_SESSION['ieggwt'][$m]; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo round($_SESSION['ieggwt'][$m],1) - round($istdeggwt[$m],1); ?></td>
 </tr>

<?php } ?>

 
  <tr height=18 style='height:13.5pt'>
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
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummeggs,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummhatcheggs,2); ?></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl511></td>
  <td class=xl535 align=right style='border-top:none'><?php echo round($cummffeed + $cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'></td>
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl566></td>
  <td class=xl557></td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl128></td>
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

<?php } 

?>

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

