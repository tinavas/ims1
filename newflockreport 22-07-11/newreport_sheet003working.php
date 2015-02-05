<?php session_start(); $flockget = $_SESSION['flockcode']; 
include "../config.php";
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

$query1 = "SELECT min(date1) as 'date1' FROM breeder_production WHERE flock like '%$flockget'";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
  $prodate = $row11['date1'];
}
if($prodate)
{
$prodate = $prodate;
}
else
{
$prodate = "2020-01-01";
}


  $diffdate11 = strtotime($prodate) - strtotime($startdate);
  $diffdate11 = $diffdate11/(24*60*60);   
  $newage11 = $startage + $diffdate11;
  $nrSeconds = $newage11 * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $untildate = strtotime($prodate) - ($nrDaysPassed * 60 * 24 * 24);
  $untildate = date("Y-m-d",$untildate);
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
  <table><tr><td style="font-size:13px"><b>Weekly Report For Flock <?php session_start(); echo $_SESSION['flockcode']; ?></b></td></tr></table>
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
 <tr height=0 style='display:none'>
  <td class=xl129 colspan=3 style='mso-ignore:colspan'>Completion Date:</td>
  <td colspan=2 class=xl129 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=6 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl132 colspan=2 style='mso-ignore:colspan'>Males</td>
  <td class=xl129 align=right>694</td>
  <td class=xl490>&nbsp;</td>
  <td class=xl494>&nbsp;</td>
  <td class=xl129>&nbsp;</td>
  <td colspan=10 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=0 style='display:none'>
  <td height=0 class=xl129>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl490>&nbsp;</td>
  <td colspan=2 class=xl129 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=6 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl132>&nbsp;</td>
  <td class=xl493>&nbsp;</td>
  <td class=xl129>&nbsp;</td>
  <td class=xl490>&nbsp;</td>
  <td class=xl494>&nbsp;</td>
  <td class=xl129>&nbsp;</td>
  <td colspan=10 class=xl490 style='mso-ignore:colspan'>&nbsp;</td>
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


<?php
include "../config.php";

$r = 0;
$query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $rejections[$r] = $row1['code'];
  $rejectionsdesc[$r] = $row1['description'];
  $r = $r + 1;
}

?>

 <tr height=16 style='height:12.0pt;display:none'>
  <td height=16 class=xl469 style='height:12.0pt;border-top:none'>Date</td>
  <td class=xl308 style='border-top:none'>Wk</td>
  <td class=xl309 style='border-top:none'>Dy</td>
  <td class=xl310 style='border-top:none;border-left:none'>F</td>
  <td class=xl311 style='border-top:none;border-left:none'>M</td>
  <td class=xl312 style='border-left:none'>F</td>
  <td class=xl313>M</td>
  <td class=xl307 style='border-left:none'>F</td>
  <td class=xl314>M</td>
  <td class=xl315 style='border-left:none'>F</td>
  <td class=xl259>M</td>
  <td class=xl316 style='border-top:none;border-left:none'>F</td>
  <td class=xl258>M</td>
  <td class=xl317 style='border-top:none'>F</td>
  <td class=xl302 style='border-top:none;border-left:none'>M</td>
  <td class=xl318 style='border-top:none'>F</td>
  <td class=xl259>M</td>
  <td class=xl319 style='border-top:none;border-left:none'>F</td>
  <td class=xl320 style='border-top:none'>M</td>
  <td class=xl321 style='border-top:none;border-left:none'>Nos.</td>
  <td class=xl322 style='border-top:none;border-left:none'>HD %</td>
  <td class=xl323 style='border-top:none;border-left:none'>Cum</td>
  <td class=xl324 style='border-top:none;border-left:none'>Eg/Brd</td>
  <td class=xl325>Nos.</td>
  <td class=xl260>%</td>
  <td class=xl326 style='border-top:none;border-left:none'>Nos.</td>
  <td class=xl327 style='border-top:none;border-left:none'>%</td>
  <td class=xl328 style='border-top:none;border-left:none'>diff</td>
  <td class=xl329 style='border-top:none;border-left:none'>cum</td>
  <td class=xl330 style='border-top:none;border-left:none'>HE/BIRD</td>
  <td class=xl261 style='border-top:none'>Wt</td>

<?php
  for($i = 0; $i < sizeof($rejections); $i++)
  {
      $temp1 = $rejectionsdesc[$i];
      $temp1 = explode(' ',$temp1);
      $temp1a = str_split($temp1[0]);
      $temp1b = str_split($temp1[1]);
      $temp1 = $temp1a[0].$temp1b[0];
?>
  <td class=xl333 width=25 style='border-top:none;border-left:none;width:19pt'><?php echo $temp1; ?></td>
<?php if($i == (sizeof($rejections) - 1)) { ?>
  <td class=xl262 width=43 style='width:32pt'>%</td>
<?php } else { ?>
  <td class=xl332 width=43 style='border-top:none;border-left:none;width:32pt'>%</td>
<?php } } ?>

  <td class=xl263>Diff</td>
  <td class=xl334 style='border-top:none;border-left:none'>F</td>
  <td class=xl335 style='border-top:none;border-left:none'>M</td>
  <td class=xl336 style='border-top:none'>F</td>
  <td class=xl337 style='border-top:none;border-left:none'>M</td>
  <td class=xl264>F</td>
  <td class=xl265 style='border-top:none'>M</td>
  <td colspan=2 class=xl198 style='mso-ignore:colspan'></td>
 </tr>

<?php
include "../config.php";

$e = 1;
$eggtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat like '%Eggs'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $eggtype[$e] = $row1['code'];
  $e = $e + 1;
}

$h = 1;
$hatcheggtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Hatch Eggs'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $hatcheggtype[$h] = $row1['code'];
  $h = $h + 1;
}

$ff= 1;
$ffeedtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Female Feed'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $ffeedtype[$ff] = $row1['code'];
  $ff = $ff + 1;
}

$mf= 1;
$mfeedtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Male Feed'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $mfeedtype[$mf] = $row1['code'];
  $mf = $mf + 1;
}



$tfmort = 0;$tmmort = 0;
$tfcull = 0;$tmcull = 0;
$teggs = 0;
$thatcheggs = 0;
$weekeggs = 0;
$weekhatcheggs = 0;
$cummeggs = 0;
$cummhatcheggs = 0;
$female = $startfemale;
$male = $startmale;
$weekfmort = 0;$weekmmort = 0;
$weekfcull = 0;$weekmcull = 0;
$cummfmort = 0;$cummmmort = 0;
$cummfcull = 0;$cummmcull = 0;
$cummfsexing = 0;$cummmsexing = 0;
$weekfsexing = 0;$weekmsexing = 0;
$weekfemale = $startfemale;
$weekmale = $startmale;
$weekeggwt = 0;
$weekmfeed = 0;
$weekffeed = 0;
$weekmfeedg = 0;
$weekffeedg = 0;
$cummeggwt = 0;
$cummmfeed = 0;
$cummffeed = 0;
$cummmfeedg = 0;
$cummffeedg = 0;
$ltflag = 1;
$btflag = 1;
$query = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' GROUP BY date2 ORDER BY date2 ASC";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{

   $allfmort = 0;
   $allmmort = 0;
   $allfcull = 0;
   $allmcull = 0;
   $queryff = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and date2 = '$row1[date2]' GROUP BY date2,flock ORDER BY date2 ASC";
   $resultff = mysql_query($queryff,$conn); 
   while($rowff = mysql_fetch_assoc($resultff))
   {
     $allfmort = $allfmort + $rowff['fmort'];
     $allmmort = $allmmort + $rowff['mmort'];
     $allfcull = $allfcull + $rowff['fcull'];
     $allmcull = $allmcull + $rowff['mcull'];
   }

   $alleggwt = 0;
   $allfweight = 0;
   $allmweight = 0;
   $queryff = "SELECT max(eggwt) as 'eggwt',max(fweight) as 'fweight',max(mweight) as 'mweight' FROM breeder_consumption WHERE flock like '%$flockget' and date2 = '$row1[date2]' GROUP BY date2,flock ORDER BY date2 ASC";
   $resultff = mysql_query($queryff,$conn); 
   while($rowff = mysql_fetch_assoc($resultff))
   {
     $alleggwt = $rowff['eggwt'];
     $allfweight = $rowff['fweight'];
     $allmweight = $rowff['mweight'];
   }

 if($row1['date2'] < $untildate) {
  if($btflag) {
?>

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
  <td class=xl537 style='border-top:none'>&nbsp;</td>
  <td class=xl511></td>
  <td class=xl511></td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl128></td>
  <td class=xl535 align=right style='border-top:none'><?php echo round($cummffeed + $cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeedg,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeedg,2); ?></td>
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
 <tr class=xl523 height=18 style='height:13.5pt'>
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
  <td class=xl526></td>
  <td class=xl526></td>
  <td class=xl526></td>
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
$btflag = 0;
}


}
?>

<?php
if($row1['date2'] >= $untildate) {
 if($ltflag)
 {
?>





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
$ltflag = 0;
}
}
  $tdayeggs = 0;
  $tdayhatcheggs = 0;
  $mdayfeed = 0;
  $fdayfeed = 0;
  $query1 = "SELECT * FROM breeder_production WHERE flock like '%$flockget' and date1 = '$row1[date2]' ORDER BY date1 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
     if(array_search($row11['itemcode'],$eggtype))
     {
        $tdayeggs = $tdayeggs + $row11['quantity'];       
        for($i = 0;$i < sizeof($rejections); $i++)
        {
            if($row11['itemcode'] == $rejections[$i])
            {
               $query1df = "SELECT sum(quantity) as 'quantity' FROM breeder_production WHERE flock like '%$flockget' and itemcode = '$rejections[$i]' and date1 = '$row1[date2]' ORDER BY date1 ASC";
               $result1df = mysql_query($query1df,$conn); 
               while($row11df = mysql_fetch_assoc($result1df))
               {  
                $rejectionsqty[$i] = $row11df['quantity'];
               }
              //$rejectionsqty[$i] = $row11['quantity'];
            }
        }
        if(array_search($row11['itemcode'],$hatcheggtype))
        {
           $tdayhatcheggs = $tdayhatcheggs + $row11['quantity'];        
        }
     }
  }
  $teggs = $teggs + $tdayeggs;
  $weekeggs = $weekeggs + $tdayeggs;
  $thatcheggs = $thatcheggs + $tdayhatcheggs;
  $weekhatcheggs = $weekhatcheggs + $tdayhatcheggs;


  $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and date2 = '$row1[date2]' ORDER BY date2 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
     if(array_search($row11['itemcode'],$ffeedtype))
     {
           $fdayfeed = $fdayfeed + $row11['quantity'];
     }
     if(array_search($row11['itemcode'],$mfeedtype))
     {
           $mdayfeed = $mdayfeed + $row11['quantity'];
     }
  }

  $diffdate = strtotime($row1['date2']) - strtotime($startdate);
  $diffdate = $diffdate/(24*60*60);   
  $newage = $startage + $diffdate;
  $nrSeconds = $newage * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $nrWeeksPassed = floor($nrSeconds / 604800); 
  if($nrDaysPassed) { $nrDaysPassed = $nrDaysPassed; $nrWeeksPassed = $nrWeeksPassed; } else { $nrDaysPassed = 7; $nrWeeksPassed = $nrWeeksPassed - 1; }
  $tfmort = $tfmort + $allfmort;
  $tmmort = $tmmort + $allmmort;
  $tfcull = $tfcull + $allfcull;
  $tmcull = $tmcull + $allmcull;
?>
 <tr height=15 style='height:11.25pt;display:none'>
  <td height=15 class=xl470 align=right style='height:11.25pt'><?php echo date('n/j/Y',strtotime($row1['date2'])); ?></td>
  <td class=xl339 align=right><?php echo $nrWeeksPassed.".".$nrDaysPassed; ?></td>
  <td class=xl339 align=right><?php echo $newage; ?></td>
  <td class=xl340 style='border-left:none'><?php echo $female; ?></td>
  <td class=xl341 style='border-left:none'><?php echo $male; ?></td>
  <td class=xl342 style='border-top:none'><?php echo $allfmort; $weekfmort = $weekfmort + $allfmort; $weekfsexing = $weekfsexing + $row1['fsexing']; ?></td>
  <td class=xl343 style='border-left:none'><?php echo $allmmort; $weekmmort = $weekmmort + $allmmort; $weekmsexing = $weekmsexing + $row1['msexing']; ?></td>
  <td class=xl302 style='border-top:none;border-left:none'><?php echo $tfmort; ?></td>
  <td class=xl302 style='border-top:none;border-left:none'><?php echo $tmmort; ?></td>
  <td class=xl344 style='border-top:none;border-left:none'><?php echo number_format(round(($tfmort/$female)*100,2),2); ?></td>
  <td class=xl345 style='border-left:none'><?php echo number_format(round(($tmmort/$male)*100,2),2); ?></td>
  <td class=xl342 style='border-top:none'><?php echo $allfcull; $weekfcull = $weekfcull + $allfcull; ?></td>
  <td class=xl343 style='border-left:none'><?php echo $allmcull; $weekmcull = $weekmcull + $allmcull; ?></td>
  <td class=xl302 style='border-left:none'><?php echo $tfcull; ?></td>
  <td class=xl300 style='border-top:none'><?php echo $tmcull; ?></td>
  <td class=xl344 style='border-top:none;border-left:none'><?php echo number_format(round(($tfcull/$female)*100,2),2); ?></td>
  <td class=xl345 style='border-left:none'><?php echo number_format(round(($tmcull/$female)*100,2),2); ?></td>
  <td class=xl342 style='border-top:none'>0</td>
  <td class=xl346 style='border-left:none'>0</td>
  <td class=xl347 style='border-top:none'><?php echo $tdayeggs; ?></td>
  <td class=xl344 style='border-top:none;border-left:none'><?php echo $tdayeggsper = number_format(round(($tdayeggs/$female)*100,2),2); $tdayeggsperw = $tdayeggsperw + $tdayeggsper; ?></td>
  <td class=xl302 style='border-top:none;border-left:none'><?php echo $teggs; ?></td>
  <td class=xl348 style='border-top:none;border-left:none'><?php echo number_format(round(($teggs/$female),2),2); ?></td>
  <td class=xl300 style='border-top:none'><?php echo $tdayeggs - $tdaypreveggs; ?></td>
  <td class=xl345 style='border-left:none'><?php echo round($tdayeggsper - $tdaypreveggsper,2); ?></td>
  <td class=xl347 style='border-top:none'><?php echo $tdayhatcheggs; ?></td>
  <td class=xl349 style='border-top:none;border-left:none'><?php echo $tdayhatcheggsper = number_format(round(($tdayhatcheggs/$tdayeggs)*100,3),3); ?></td>
  <td class=xl302 style='border-left:none'><?php echo $tdayhatcheggs - $tdayprevhatcheggs; ?></td>
  <td class=xl350 style='border-left:none'><?php echo $thatcheggs; ?></td>
  <td class=xl351 style='border-top:none'><?php echo number_format(round(($thatcheggs/$female),2),2); ?></td>
  <td class=xl352 style='border-left:none'><?php echo number_format($row1['eggwt'],1); $weekeggwt = $weekeggwt + $row1['eggwt']; ?></td>
<?php
  for($i = 0; $i < sizeof($rejections); $i++)
  {
?>
 <td class=xl353 style='border-left:none'><?php echo $rejectionsqty[$i]; ?></td>
<?php 
  $rejqty[$i] = $rejqty[$i] + $rejectionsqty[$i];
  $rej[$i] = $rej[$i] + round(($rejectionsqty[$i] / $tdayeggs) * 100,2);
  if($i == (sizeof($rejections)-1)) { 
?>
  <td class=xl345 style=''><?php echo number_format(round(($rejectionsqty[$i] / $tdayeggs) * 100,2),2); ?></td>
<?php } else { ?>
  <td class=xl354 style='border-top:none'><?php echo number_format(round(($rejectionsqty[$i] / $tdayeggs) * 100,2),2); ?></td>
<?php } } ?> 




  <td class=xl355 style='border-left:none'><?php echo $tdayeggs - $tdayhatcheggs; ?></td>
  <td class=xl356 style='border-top:none'><?php echo number_format($fdayfeed,2); $weekffeed = $weekffeed + $fdayfeed; ?></td>
  <td class=xl357 style='border-top:none;border-left:none'><?php echo number_format($mdayfeed,2); $weekmfeed = $weekmfeed + $mdayfeed; ?></td>
  <td class=xl358><?php echo number_format(round(($fdayfeed/$female)*1000,3),3); $weekffeedg = $weekffeedg + round(($fdayfeed/$female)*1000,3); ?></td>
  <td class=xl359 style='border-top:none;border-left:none'><?php echo number_format(round(($mdayfeed/$male)*1000,3),3); $weekmfeedg = $weekmfeedg + round(($mdayfeed/$male)*1000,3); ?></td>
  <td class=xl354><?php echo $tdayfeed = number_format($fdayfeed + $mdayfeed,2); ?></td>
  <td class=xl345 style='border-left:none'><?php echo number_format(round($tdayfeed/$tdayhatcheggs,2),2); ?></td>
  <td class=xl342><?php echo $fweight = $allfweight; ?></td>
  <td class=xl346 style='border-left:none'><?php echo $mweight = $allmweight; ?></td>
  <td class=xl361 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl361 style='border-top:none;border-left:none'>&nbsp;</td>

 </tr>

<?php

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

      $fweight = ($row1['fweight'] + $row1['fweightb'] + $row1['fweightc'] + $row1['fweightd']) / $fwx;
      $mweight = ($row1['mweight'] + $row1['mweightb'] + $row1['mweightc'] + $row1['mweightd']) / $mwx;
?>

<?php 
 $tdaypreveggs = $tdayeggs;
 $tdaypreveggsper = number_format(round(($tdayeggs/$female)*100,2),2);
 $tdayprevhatcheggs = $tdayhatcheggs;
 $dflag = 0;

 if($nrDaysPassed == 1)
 {
   $tempdate = $row1['date2'];
   $dflag = 1;
 }
 
 if(!$dflag)
 {
   if($nrDaysPassed == 2)
   {
     $tempdate = $row1['date2'];
     $dflag = 1;
   }
 }

 if(!$dflag)
 {
   if($nrDaysPassed == 3)
   {
     $tempdate = $row1['date2'];
     $dflag = 1;
   }
 }

 if(!$dflag)
 {
   if($nrDaysPassed == 4)
   {
     $tempdate = $row1['date2'];
     $dflag = 1;
   }
 }

 if(!$dflag)
 {
   if($nrDaysPassed == 5)
   {
     $tempdate = $row1['date2'];
     $dflag = 1;
   }
 }

 if(!$dflag)
 {
   if($nrDaysPassed == 6)
   {
     $tempdate = $row1['date2'];
     $dflag = 1;
   }
 }

 if(!$dflag)
 {
   if($nrDaysPassed == 7)
   {
     $tempdate = $row1['date2'];
     $dflag = 1;
   }
 }

 if($nrDaysPassed == 7)
 {
   $cummfmort = $cummfmort + $weekfmort;$cummmmort = $cummmmort + $weekmmort;
   $cummfcull = $cummfcull + $weekfcull;$cummmcull = $cummmcull + $weekmcull;
   $cummfsexing = $cummfsexing + $weekfsexing;$cummmsexing = $cummmsexing + $weekmsexing;
   $cummeggs = $cummeggs + $weekeggs; $cummhatcheggs = $cummhatcheggs + $weekhatcheggs;
   $cummeggwt = $cummeggwt + $weekeggwt;
   $cummffeed = $cummffeed + $weekffeed;
   $cummmfeed = $cummmfeed + $weekmfeed;
   for($i = 0; $i < sizeof($rejections); $i++)
   {
      $cummrej[$i] = $cummrej[$i] + $rejqty[$i];
   }
?>
 <tr height=16 style='height:12.0pt;display:none'>
  <td height=16 class=xl473 style='height:12.0pt'>Week</td>
  <td class=xl392><?php echo $tempage = $nrWeeksPassed + 1; ?></td>
  <td class=xl393 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl268><?php echo $weekfmort; ?></td>
  <td class=xl268><?php echo $weekmmort; ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl268><?php echo number_format(round(($weekfmort/$startfemale)*100,3),3); ?></td>
  <td class=xl268><?php echo number_format(round(($weekmmort/$startmale)*100,3),3); ?></td>
  <td class=xl268><?php echo $weekfcull; ?></td>
  <td class=xl268><?php echo $weekmcull; ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl269><?php echo number_format(round(($weekfcull/$startfemale)*100,3),3); ?></td>
  <td class=xl269><?php echo number_format(round(($weekmcull/$startmale)*100,3),3); ?></td>
  <td class=xl268>0</td>
  <td class=xl268>0</td>
  <td class=xl268><?php echo $weekeggs; ?></td>
  <td class=xl269><?php echo $tempcomp1 = round((($weekeggs/7)/$weekfemale)*100,2); ?></td>
  <td class=xl268>&nbsp;</td>
  <td class=xl269><?php echo round($weekeggs/$startfemale,2); ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl268><?php echo $weekhatcheggs; ?></td>
  <td class=xl269><?php echo round(($weekhatcheggs/$weekeggs)*100,2); ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl269><?php echo round($weekhatcheggs/$startfemale,2); ?></td>
  <td class=xl268><?php echo $tempcomp5 = round($weekeggwt/7,2); ?></td>
  <?php for($i = 0; $i < sizeof($rejections); $i++)
  {
  ?>
  <td class=xl268><?php echo $rejqty[$i]; ?></td>
  <td class=xl269><?php echo round(($rejqty[$i]/$weekeggs)*100,2); ?></td>
  <?php } ?>

  <td class=xl268>&nbsp;</td>
  <td class=xl269><?php echo $weekffeed; ?></td>
  <td class=xl269><?php echo $weekmfeed; ?></td>
  <td class=xl269><?php echo $temp3 = round($weekffeedg/7,2); $cummffeedg = $cummffeedg + $temp3; ?></td>
  <td class=xl269><?php echo $temp4 = round($weekmfeedg/7,2); $cummmfeedg = $cummmfeedg + $temp4; ?></td>
  <td class=xl269><?php echo $t1 = $weekffeed + $weekmfeed; ?></td>
  <td class=xl394><?php echo number_format(round($t1/$weekhatcheggs,2),2); ?></td>
  <td class=xl268><?php echo $tempcomp6 = $fweight; ?></td>
  <td class=xl268><?php echo $tempcomp7 = $mweight; ?></td>
  <td class=xl268 style='mso-ignore:colspan'></td>
  <td class=xl268 style='mso-ignore:colspan;border-right: 1pt solid black'></td>
 </tr>



<?php
$query34 = "SELECT * FROM breeder_standards where client = '$client' and age = '$tempage' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdmort = $row134['fcummmort'];
  $hdper = $row134['productionper'];
  $stdeggbird = $row134['alleggbird'];
  $stdheggbird = $row134['eggbird'];
  $stdheggper = $row134['heggper'];
  $stdeggwt = $row134['eggwt'];
}
$query34 = "SELECT * FROM breeder_standards where client = '$client' and age = '$tempage' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdfw = $row134['fweight'];
  $stdmw = $row134['mweight'];
}
?>







<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl527 align=right style='height:12.75pt;border-top:none'><?php echo date("j-M",strtotime($tempdate)); ?></td>
  <td class=xl528 style='border-top:none;border-left:none'><?php echo $nrWeeksPassed + 1; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $female; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $male; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $weekfmort; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $weekmmort; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $weekfcull; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $weekmcull; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $weekfsexing; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $weekmsexing; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php if($row1['date2'] >= $untildate) { ?><?php echo $weekeggs; ?><?php } ?></td>
  <td class=xl547 align=right style='border-top:none;border-left:none'><?php if($row1['date2'] >= $untildate) { ?><?php echo $tempcomp1 = round((($weekeggs/7)/$female)*100,1); ?><?php } ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php if($row1['date2'] >= $untildate) { ?><?php echo $hdper; ?><?php } ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php if($row1['date2'] >= $untildate) { ?><?php echo $weekhatcheggs; ?><?php } ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php if($row1['date2'] >= $untildate) { ?><?php echo round(($weekhatcheggs/$weekeggs)*100,1); ?><?php } ?></td>
  <td class=xl530 style='border-top:none;border-left:none'><span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php if($row1['date2'] >= $untildate) { ?><?php echo $stdheggper; ?><?php } ?></td>
  <td class=xl688 align=right style='border-top:none;border-left:none'><?php echo $t1 = $weekffeed + $weekmfeed; ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $weekffeed; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo $temp3 = round($weekffeedg/7,1); ?></td>
  <td class=xl560 align=right style='border-top:none;border-left:none'><?php echo $weekmfeed; ?></td>
  <td class=xl531 align=right style='border-top:none;border-left:none'><?php echo $temp4 = round($weekmfeedg/7,1); ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $stdfw; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $allfweight; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $allfweight - $stdfw; ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $stdmw; ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php echo $allmweight; ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php echo $allmweight - $stdmw; ?></td>
  <td class=xl558 align=right style='border-left:none'><?php if($row1['date2'] >= $untildate) { ?><?php echo $stdeggwt; ?><?php } ?></td>
  <td class=xl554 align=right style='border-top:none;border-left:none'><?php if($row1['date2'] >= $untildate) { ?><?php echo $tempcomp5 = $alleggwt; ?><?php } ?></td>
  <td class=xl529 align=right style='border-top:none;border-left:none'><?php if($row1['date2'] >= $untildate) { ?><?php echo $tempcomp5 - $stdeggwt; ?><?php } ?></td>
 </tr>







<?php
   $weekfmort = 0;$weekmmort = 0;
   $weekfcull = 0;$weekmcull = 0;
   $weekeggs = 0; $weekhatcheggs = 0;
   $weekfemale = $female;
   $weekmale = $male;
   $weekeggwt = 0;
   $weekffeed = 0;
   $weekmfeed = 0;
   $weekffeedg = 0;
   $weekmfeedg = 0;
   for($i = 0; $i < sizeof($rejections); $i++)
   {
      $rej[$i] = 0;
      $rejqty[$i] = 0;
   }
 $female = $startfemale - ($tfmort + $tfcull);
 $male = $startmale - ($tmmort + $tmcull);

 }
} 
?>














 
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
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummffeedg,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeed,2); ?></td>
  <td class=xl536 align=right style='border-top:none'><?php echo round($cummmfeedg,2); ?></td>
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
 <tr class=xl523 height=18 style='height:13.5pt'>
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
