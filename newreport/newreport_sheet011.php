<?php 
$start_process = (float) array_sum(explode(' ',microtime()));
session_start(); $flockget = $_SESSION['flock']; 
 $breedi = $_SESSION['breedi'] ;
include "../config.php";
$query1 = "SELECT * FROM breeder_flock WHERE flockcode = '$flockget'";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening'];
      $startmale = $row11['maleopening'];
}
$querymin = "SELECT min(date2) as 'date2' FROM breeder_consumption WHERE flock like '$flockget' ";
$resultmin = mysql_query($querymin,$conn); 
while($row1min = mysql_fetch_assoc($resultmin))
{
$mincmpdate = $row1min['date2'];
}
 $femalet = 0;$malet=0;
 $query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat IN ('Female Birds', 'Male Birds') AND client = '$client' AND towarehouse like '$flockget' AND date<'$mincmpdate'";
  $result1t = mysql_query($query1t,$conn); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
      if($row11t['cat'] == 'Female Birds')
	  {
	  $femalet = $femalet + $row11t['quantity'];
	  }
	  else
	  {
	  $malet = $malet + $row11t['quantity'];
	  }
  }
   $femalet = 0;$malet=0;
 $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds') AND client = '$client' AND flock like '$flockget' AND date<'$mincmpdate'";
  $result1t = mysql_query($query1t,$conn); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
   
    	  $malet = $malet + $row11t['receivedquantity'];
	  
  }
  $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '$flockget' AND date<'$mincmpdate'";
  $result1t = mysql_query($query1t,$conn); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
   
     	  $femalet = $femalet + $row11t['receivedquantity'];
	  
  }
   if($femalet > 0)
  {
  $startfemale = $startfemale +$femalet;
  }
   if($malet > 0)
  {
  $startmale = $startmale + $malet;
  }
  
   if($femalet > 0)
  {
  $startfemale = $startfemale +$femalet;
  }
   if($malet > 0)
  {
  $startmale = $startmale + $malet;
  }
  

if($breedi != "")
{
$query34 = "SELECT * FROM breeder_standards where client = '$client' and breed = '$breedi' and age = '$tempage' ORDER BY age ASC ";
}
else
{
$query34 = "SELECT * FROM breeder_standards where client = '$client' and age = '$tempage' ORDER BY age ASC ";
}
//$query34 = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdfw[$row134['age']] = $row134['fweight'];
  $stdmw[$row134['age']] = $row134['mweight'];
  $fgain[$row134['age']] = $row134['fgain'];
  $mgain[$row134['age']] = $row134['mgain'];
}

$query = "SELECT * FROM breeder_consumption WHERE flock = '$flockget' GROUP BY date2 ORDER BY date2 ASC";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
  $diffdate = strtotime($row1['date2']) - strtotime($startdate);
  $diffdate = $diffdate/(24*60*60);   
  $newage = $startage + $diffdate;
  $nrSeconds = $newage * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $nrWeeksPassed = floor($nrSeconds / 604800); 

  
  if($nrDaysPassed == 0)
  {
    $fwa[$nrWeeksPassed] = $row1['fweight'];
    $fwb[$nrWeeksPassed] = $row1['fweightb'];
    $fwc[$nrWeeksPassed] = $row1['fweightc'];
    $fwd[$nrWeeksPassed] = $row1['fweightd'];

    $mwa[$nrWeeksPassed] = $row1['mweight'];
    $mwb[$nrWeeksPassed] = $row1['mweightb'];
    $mwc[$nrWeeksPassed] = $row1['mweightc'];
    $mwd[$nrWeeksPassed] = $row1['mweightd'];

    $fwx = 0; 
    if($row1['fweight']) { $fwx = $fwx + 1; } 
    if($row1['fweightb']) { $fwx = $fwx + 1; }
    if($row1['fweightc']) { $fwx = $fwx + 1; }
    if($row1['fweightd']) { $fwx = $fwx + 1; }

    $mwx = 0; 
    if($row1['mweight']) { $mwx = $mwx + 1; } 
    if($row1['mweightb']) { $mwx = $mwx + 1; }
    if($row1['mweightc']) { $mwx = $mwx + 1; }
    if($row1['mweightd']) { $mwx = $mwx + 1; }

    $favg[$nrWeeksPassed] = ($row1['fweight'] + $row1['fweightb'] + $row1['fweightc'] + $row1['fweightd'])/$fwx;
    $mavg[$nrWeeksPassed] = ($row1['mweight'] + $row1['mweightb'] + $row1['mweightc'] + $row1['mweightd'])/$mwx;

  }

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
   parent.fnSetActiveSheet(9);
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
  <table><tr><td style="font-size:13px"><b>Body Weight Comparision For Flock <?php session_start(); echo $_SESSION['flock']; ?></b></td></tr></table>
</center>
<center>

<table border=0 cellpadding=0 cellspacing=0 width=626 style='border-collapse:
 collapse;table-layout:fixed;width:472pt'>
 <col class=xl128 width=30 style='mso-width-source:userset;mso-width-alt:1097;
 width:23pt'>
 <col class=xl128 width=42 style='mso-width-source:userset;mso-width-alt:1536;
 width:32pt'>
 <col class=xl566 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl128 width=48 style='mso-width-source:userset;mso-width-alt:1755;
 width:36pt'>
 <col class=xl128 width=55 style='mso-width-source:userset;mso-width-alt:2011;
 width:41pt'>
 <col class=xl566 width=37 style='mso-width-source:userset;mso-width-alt:1353;
 width:28pt'>
 <col class=xl557 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl659 width=54 style='mso-width-source:userset;mso-width-alt:1974;
 width:41pt'>
 <col class=xl661 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl128 width=48 style='mso-width-source:userset;mso-width-alt:1755;
 width:36pt'>
 <col class=xl128 width=53 style='mso-width-source:userset;mso-width-alt:1938;
 width:40pt'>
 <col class=xl566 width=37 style='mso-width-source:userset;mso-width-alt:1353;
 width:28pt'>
 <col class=xl557 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl659 width=54 style='mso-width-source:userset;mso-width-alt:1974;
 width:41pt'>
 <col class=xl128 width=64 style='mso-width-source:userset;mso-width-alt:2340;
 width:48pt'>
 <tr height=17 style='height:12.75pt'>
  <td colspan=14 height=17 class=xl69 width=626 style='height:12.75pt;
  width:472pt'></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 colspan=2 class=xl69 style='height:12.75pt;mso-ignore:colspan'>&nbsp;</td>
  <td class=xl200>&nbsp;</td>
  <td colspan=5 class=xl69 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl244>&nbsp;</td>
  <td colspan=5 class=xl69 style='mso-ignore:colspan'>&nbsp;</td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td colspan=8 height=17 class=xl795 style='height:12.75pt'>Females</td>
  <td colspan=6 class=xl795 style='border-left:none'>Males</td>
 </tr>
 <tr class=xl650 height=68 style='height:51.0pt'>
  <td height=68 class=xl649 width=30 style='height:51.0pt;border-top:none;
  width:23pt'>Age in wks</td>
  <td class=xl649 width=42 style='border-top:none;border-left:none;width:32pt'>Grades</td>
  <td class=xl655 width=35 style='border-top:none;border-left:none;width:26pt'>Std.
  body wt</td>
  <td class=xl649 width=48 style='border-top:none;border-left:none;width:36pt'>Last
  wk Avg body wt</td>
  <td class=xl649 width=55 style='border-top:none;border-left:none;width:41pt'>This
  Wk Avg. body Wt</td>
  <td class=xl655 width=37 style='border-top:none;border-left:none;width:28pt'>Std
  Wkly Wt Gain</td>
  <td class=xl656 width=49 style='border-top:none;border-left:none;width:37pt'>Wkly.
  Wt. Gain</td>
  <td class=xl683 width=54 style='border-top:none;border-left:none;width:41pt'>Diff.
  from std. Body wt</td>
  <td class=xl655 width=35 style='border-top:none;width:26pt'>Std. body wt</td>
  <td class=xl649 width=48 style='border-top:none;border-left:none;width:36pt'>Last
  wk Avg body wt</td>
  <td class=xl649 width=53 style='border-top:none;border-left:none;width:40pt'>Avg.
  body wt</td>
  <td class=xl655 width=37 style='border-top:none;border-left:none;width:28pt'>Std
  Wkly Wt Gain</td>
  <td class=xl656 width=49 style='border-top:none;border-left:none;width:37pt'>Wkly.
  Wt. Gain</td>
  <td class=xl658 width=54 style='border-top:none;border-left:none;width:41pt'>Diff.
  from std. Body wt</td>
 </tr>

<?php
include "../config.php";
if($breedi != "")
{
$query = "SELECT * FROM breeder_standards where breed = '$breedi' and client = '$client' ORDER BY age ASC ";
}
else
{
$query = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
}
//$query = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
?>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl509 style='height:12.75pt'><?php echo $row1['age']; ?></td>
  <td class=xl509>A</td>
  <td class=xl678 align=right><?php echo $stdfw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $fwa[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $fwa[$row1['age']]; ?></td>
  <td class=xl678 align=right><?php echo $fgain[$row1['age']]; ?></td>
  <td class=xl557 align=right><?php echo $favg[$row1['age']] - $favg[$row1['age'] - 1]; ?></td>
  <td class=xl659 align=right><?php echo $fwa[$row1['age']] - $stdfw[$row1['age']]; ?></td>
  <td class=xl679 align=right><?php echo $stdmw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $mwa[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $mwa[$row1['age']]; ?></td>
  <td class=xl678 align=right><?php echo $mgain[$row1['age']]; ?></td>
  <td class=xl557 align=right><?php echo $mavg[$row1['age']] - $mavg[$row1['age'] - 1]; ?></td>
  <td class=xl659 align=right><?php echo $mwa[$row1['age']] - $stdmw[$row1['age']]; ?></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl509 style='height:12.75pt'></td>
  <td class=xl509>B</td>
  <td class=xl678 align=right><?php echo $stdfw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $fwb[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $fwb[$row1['age']]; ?></td>
  <td class=xl678 align=right></td>
  <td class=xl557 align=right></td>
  <td class=xl659 align=right><?php echo $fwb[$row1['age']] - $stdfw[$row1['age']]; ?></td>
  <td class=xl679 align=right><?php echo $stdmw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $mwb[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $mwb[$row1['age']]; ?></td>
  <td class=xl678 align=right></td>
  <td class=xl557 align=right></td>
  <td class=xl659 align=right><?php echo $mwb[$row1['age']] - $stdmw[$row1['age']]; ?></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl509 style='height:12.75pt'></td>
  <td class=xl509>C</td>
  <td class=xl678 align=right><?php echo $stdfw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $fwc[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $fwc[$row1['age']]; ?></td>
  <td class=xl678 align=right></td>
  <td class=xl557 align=right></td>
  <td class=xl659 align=right><?php echo $fwc[$row1['age']] - $stdfw[$row1['age']]; ?></td>
  <td class=xl679 align=right><?php echo $stdmw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $mwc[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $mwc[$row1['age']]; ?></td>
  <td class=xl678 align=right></td>
  <td class=xl557 align=right></td>
  <td class=xl659 align=right><?php echo $mwc[$row1['age']] - $stdmw[$row1['age']]; ?></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl509 style='height:12.75pt'></td>
  <td class=xl509>D</td>
  <td class=xl678 align=right><?php echo $stdfw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $fwd[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $fwd[$row1['age']]; ?></td>
  <td class=xl678 align=right></td>
  <td class=xl557 align=right></td>
  <td class=xl659 align=right><?php echo $fwd[$row1['age']] - $stdfw[$row1['age']]; ?></td>
  <td class=xl679 align=right><?php echo $stdmw[$row1['age']]; ?></td>
  <td class=xl128 align=right><?php echo $mwd[$row1['age'] - 1]; ?></td>
  <td class=xl557 align=right><?php echo $mwd[$row1['age']]; ?></td>
  <td class=xl678 align=right></td>
  <td class=xl557 align=right></td>
  <td class=xl659 align=right><?php echo $mwd[$row1['age']] - $stdmw[$row1['age']]; ?></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 colspan=2 class=xl509 style='height:12.75pt;mso-ignore:colspan'></td>
  <td class=xl653></td>
  <td class=xl650></td>
  <td class=xl684 width=55 style='width:41pt'><?php echo $favg[$row1['age']]; ?></td>
  <td class=xl653></td>
  <td class=xl657></td>
  <td class=xl659></td>
  <td class=xl660 width=35 style='width:26pt'>&nbsp;</td>
  <td class=xl650></td>
  <td class=xl684 width=53 style='width:40pt'><?php echo $mavg[$row1['age']]; ?></td>
  <td class=xl653></td>
  <td class=xl657></td>
  <td class=xl659></td>
 </tr>
<?php } ?>





</table>
</center>
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