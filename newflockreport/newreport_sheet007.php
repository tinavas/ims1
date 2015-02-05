<?php
$start_process = (float) array_sum(explode(' ',microtime()));
 session_start(); $flockget = $_SESSION['flockcode']; 
include "../config.php";
$breedi = $_SESSION['breedi'] ;


/*include "../config.php";
$startfemale = 0;
$startmale = 0;


$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate";
$result1 = mysql_query($query1,$conn); 
$tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' order by startdate asc limit 1";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening'];
      $startmale = $row11['maleopening'];
  }
}
else
{
  $query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget'";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      $startmale = $startmale + $row11['maleopening'];
  }
}


$query34 = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdfw[$row134['age']] = $row134['fweight'];
  $stdmw[$row134['age']] = $row134['mweight'];
}*/

/*$query = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' GROUP BY date2 ORDER BY date2 ASC";
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
*/
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
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
   parent.fnSetActiveSheet(5);
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
<table border=0 cellpadding=0 cellspacing=0 width=713 style='border-collapse:
 collapse;table-layout:fixed;width:536pt'>
 <col class=xl128 width=28 style='mso-width-source:userset;mso-width-alt:1024;
 width:21pt'>
 <col class=xl128 width=35 span=2 style='mso-width-source:userset;mso-width-alt:
 1280;width:26pt'>
 <col class=xl128 width=54 style='mso-width-source:userset;mso-width-alt:1974;
 width:41pt'>
 <col class=xl128 width=58 style='mso-width-source:userset;mso-width-alt:2121;
 width:44pt'>
 <col class=xl510 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl128 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl128 width=54 style='mso-width-source:userset;mso-width-alt:1974;
 width:41pt'>
 <col class=xl128 width=58 style='mso-width-source:userset;mso-width-alt:2121;
 width:44pt'>
 <col class=xl510 width=55 style='mso-width-source:userset;mso-width-alt:2011;
 width:41pt'>
 <col class=xl128 width=68 style='mso-width-source:userset;mso-width-alt:2486;
 width:51pt'>
 <col class=xl128 width=66 style='mso-width-source:userset;mso-width-alt:2413;
 width:50pt'>
 <col class=xl512 width=68 style='mso-width-source:userset;mso-width-alt:2486;
 width:51pt'>
 <col width=64 style='mso-width-source:userset;mso-width-alt:2340;width:48pt'>
 <tr height=21 style='height:15.75pt'>
  <td colspan=13 height=21 class=xl704 width=649 style='height:15.75pt;
  width:488pt'>BODY WEIGHT COMPARISION - Cobb 400</td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <tr height=15 style='mso-height-source:userset;height:11.25pt'>
  <td colspan=5 height=15 class=xl790 style='height:11.25pt'>Females</td>
  <td colspan=4 class=xl790>Males</td>
  <td colspan=4 class=xl790 style='border-right:.5pt solid black'>Comparision</td>
  <td></td>
 </tr>
 <tr class=xl650 height=74 style='mso-height-source:userset;height:55.5pt'>
  <td height=74 class=xl662 width=28 style='height:55.5pt;border-top:none;
  width:21pt'>Age in wks</td>
  <td class=xl663 width=35 style='border-top:none;border-left:none;width:26pt'>Std.
  body wt</td>
  <td class=xl664 width=35 style='border-top:none;border-left:none;width:26pt'>Avg.
  body Wt</td>
  <td class=xl665 width=54 style='border-top:none;border-left:none;width:41pt'>Diff.
  from std. Body wt</td>
  <td class=xl662 width=58 style='border-top:none;border-left:none;width:44pt'>Diff.
  from std. Body wt %</td>
  <td class=xl663 width=35 style='border-top:none;border-left:none;width:26pt'>Std.
  body wt</td>
  <td class=xl664 width=35 style='border-top:none;border-left:none;width:26pt'>Avg.
  body wt</td>
  <td class=xl665 width=54 style='border-top:none;border-left:none;width:41pt'>Diff.
  from std. Body wt</td>
  <td class=xl662 width=58 style='border-top:none;border-left:none;width:44pt'>Diff.
  from std. Body wt %</td>
  <td class=xl662 width=55 style='border-top:none;border-left:none;width:41pt'>Diff.<span
  style='mso-spacerun:yes'>&nbsp; </span>in<span
  style='mso-spacerun:yes'>&nbsp; </span>weight males &amp; females</td>
  <td class=xl662 width=68 style='border-top:none;border-left:none;width:51pt'>Diff.<span
  style='mso-spacerun:yes'>&nbsp; </span>in<span
  style='mso-spacerun:yes'>&nbsp; </span>weight males &amp; females %</td>
  <td class=xl662 width=66 style='border-top:none;border-left:none;width:50pt'>Actual
  wt diff. needs males&amp;<span style='mso-spacerun:yes'>&nbsp; </span>females</td>
  <td class=xl662 width=68 style='border-top:none;border-left:none;width:51pt'>Actual
  wt diff. needs males &amp;<span style='mso-spacerun:yes'>&nbsp;
  </span>females %</td>
  <td></td>
 </tr>

<?php
include "../config.php";
$minage = 0;
$query = "SELECT min(age) as minage FROM breeder_consumption where flock like '%$flockget'  ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $minage = $row1['minage'];
}
 $minage = ceil($minage/7);
$query = "SELECT * FROM breeder_initial where flock like '%$flockget' and age < '$minage' ORDER BY age ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $_SESSION['fbweight'][$row1['age']]= $row1['fweight'];
  $_SESSION['mbweight'][$row1['age']]= $row1['mweight'];
}
if($breedi != "")
{
$query = "SELECT * FROM breeder_standards where client = '$client' and breed = '$breedi' ORDER BY age ASC ";
}
else
{
$query = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
}
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
?>

 <tr class=xl649 height=21 style='mso-height-source:userset;height:15.95pt'>
  <td height=21 class=xl649 width=28 style='height:15.95pt;width:21pt'><?php echo $row1['age']; ?></td>
  <td class=xl655 width=35 style='border-left:none;width:26pt'><?php echo $stdf = $row1['fweight']; ?></td>
  <td class=xl656 width=35 style='border-left:none;width:26pt'><?php if($_SESSION['fbweight'][$row1['age']] == "") {echo $actf=0;} else {echo $actf = $_SESSION['fbweight'][$row1['age']];} ?></td>
  <td class=xl559 align=right style='border-left:none'><?php echo $fdiff = $actf - $stdf; ?></td>
  <td class=xl547 align=right style='border-left:none'><?php echo round(($fdiff*100)/$row1['fweight'],1); ?></td>
  <td class=xl655 width=35 style='border-left:none;width:26pt'><?php echo $stdm = $row1['mweight']; ?></td>
  <td class=xl656 width=35 style='border-left:none;width:26pt'><?php  if($_SESSION['mbweight'][$row1['age']] == "") {echo $actm=0;} else {echo $actm = $_SESSION['mbweight'][$row1['age']];} ?></td>
  <td class=xl559 align=right style='border-left:none'><?php echo $mdiff = $actm - $stdm; ?></td>
  <td class=xl547 align=right style='border-left:none'><?php echo round(($mdiff*100)/$row1['mweight'],1); ?></td>
  <td class=xl529 align=right style='border-left:none'><?php echo $actm - $actf; ?></td>
  <td class=xl547 align=center style='border-left:none'><?php echo round((($actm - $actf)*100)/$actf,2); ?></td>
  <td class=xl529 align=right style='border-left:none'><?php echo $diff = $row1['mweight'] - $row1['fweight']; ?></td>
  <td class=xl547 align=right style='border-left:none'><?php echo round(($diff*100)/$row1['fweight'],1); ?></td>
  <td></td>
 </tr>
<?php } ?>

 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=28 style='width:21pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=54 style='width:41pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=35 style='width:26pt'></td>
  <td width=54 style='width:41pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=66 style='width:50pt'></td>
  <td width=68 style='width:51pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
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