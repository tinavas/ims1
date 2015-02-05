<?php session_start(); $flockget = $_SESSION['flock']; 
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

$query1 = "SELECT min(date1) as 'date1' FROM breeder_production WHERE flock = '$flockget'";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
  $prodate = $row11['date1'];
}

  $diffdate11 = strtotime($prodate) - strtotime($startdate);
  $diffdate11 = $diffdate11/(24*60*60);   
  $newage11 = $startage + $diffdate11;
  $nrSeconds = $newage11 * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $untildate = strtotime($prodate) - ($nrDaysPassed * 60 * 24 * 24);
  $untildate = date("Y-m-d",$untildate);
?>

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
   parent.fnSetActiveSheet(0);
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

<body link=blue vlink=purple class=xl68>

<table border=0 cellpadding=0 cellspacing=0 width=1113 style='border-collapse:
 collapse;table-layout:fixed;width:839pt'>
 <col class=xl68 width=44 style='mso-width-source:userset;mso-width-alt:1609;
 width:33pt'>
 <col class=xl68 width=29 style='mso-width-source:userset;mso-width-alt:1060;
 width:22pt'>
 <col class=xl68 width=43 style='mso-width-source:userset;mso-width-alt:1572;
 width:32pt'>
 <col class=xl68 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl68 width=29 span=3 style='mso-width-source:userset;mso-width-alt:
 1060;width:22pt'>
 <col class=xl68 width=26 style='mso-width-source:userset;mso-width-alt:950;
 width:20pt'>
 <col class=xl68 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl68 width=26 style='mso-width-source:userset;mso-width-alt:950;
 width:20pt'>
 <col class=xl68 width=46 style='mso-width-source:userset;mso-width-alt:1682;
 width:35pt'>
 <col class=xl68 width=50 style='mso-width-source:userset;mso-width-alt:1828;
 width:38pt'>
 <col class=xl68 width=46 span=2 style='mso-width-source:userset;mso-width-alt:
 1682;width:35pt'>
 <col class=xl68 width=45 style='mso-width-source:userset;mso-width-alt:1645;
 width:34pt'>
 <col class=xl68 width=42 style='mso-width-source:userset;mso-width-alt:1536;
 width:32pt'>
 <col class=xl68 width=36 span=2 style='mso-width-source:userset;mso-width-alt:
 1316;width:27pt'>
 <col class=xl68 width=41 style='mso-width-source:userset;mso-width-alt:1499;
 width:31pt'>
 <col class=xl68 width=33 span=2 style='mso-width-source:userset;mso-width-alt:
 1206;width:25pt'>
 <col class=xl68 width=171 style='mso-width-source:userset;mso-width-alt:6253;
 width:128pt'>
 <col class=xl68 width=103 style='mso-width-source:userset;mso-width-alt:3766;
 width:77pt'>
 <col class=xl127 width=64 style='mso-width-source:userset;mso-width-alt:2340;
 width:48pt'>
 <col class=xl68 width=0 span=232 style='display:none'>
 <tr class=xl68 height=19 style='mso-height-source:userset;height:14.25pt'>
  <td colspan=22 height=19 class=xl704 width=946 style='height:14.25pt;
  width:714pt'><a name="Print_Area">&nbsp;</a></td>
  <td class=xl686 width=103 style='border-left:none;width:77pt'>&nbsp;</td>
  <td class=xl127 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
  <td class=xl68 width=0></td>
 </tr>
 <tr class=xl68 height=19 style='mso-height-source:userset;height:14.25pt'>
  <td colspan=22 height=19 class=xl705 style='height:14.25pt'>Daily
  Reports<span style='mso-spacerun:yes'>&nbsp;</span></td>
  <td class=xl686 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl127 style='border-left:none'>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr class=xl68 height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl70 style='height:14.25pt'>&nbsp;</td>
  <td colspan=2 class=xl69>F= <?php echo $startfemale; ?></td>
  <td colspan=2 class=xl69>M= <?php echo $startmale; ?></td>
  <td colspan=17 class=xl69 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl102></td>
  <td class=xl127>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr class=xl68 height=2 style='mso-height-source:userset;height:1.5pt'>
  <td height=2 class=xl71 colspan=2 style='height:1.5pt;mso-ignore:colspan'>Hen
  Housed</td>
  <td class=xl69>&nbsp;</td>
  <td class=xl70>F</td>
  <td colspan=2 class=xl70>5500</td>
  <td colspan=16 class=xl69 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl102></td>
  <td class=xl127>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr class=xl68 height=0 style='display:none;mso-height-source:userset;
  mso-height-alt:270'>
  <td height=0 colspan=3 class=xl70 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl70>M</td>
  <td colspan=2 class=xl706>726</td>
  <td colspan=16 class=xl69 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl102></td>
  <td class=xl127>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr class=xl68 height=0 style='display:none;mso-height-source:userset;
  mso-height-alt:225'>
  <td height=0 colspan=2 class=xl72 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl73 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=17 class=xl72 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl102></td>
  <td class=xl127>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=34 style='mso-height-source:userset;height:25.5pt'>
  <td rowspan=3 height=81 class=xl74 width=44 style='height:60.75pt;width:33pt'>DATE</td>
  <td rowspan=3 class=xl481 width=29 style='width:22pt'>AGE</td>
  <td colspan=2 class=xl74 width=78 style='border-left:none;width:58pt'>OPENING
  STOCK</td>
  <td colspan=2 class=xl74 width=58 style='border-left:none;width:44pt'>MORT</td>
  <td colspan=2 class=xl74 width=55 style='border-left:none;width:42pt'>CULL
  BIRD</td>
  <td colspan=2 class=xl74 width=57 style='border-left:none;width:43pt'>SEXING
  ERROR</td>
  <td rowspan=3 class=xl707 width=46 style='border-bottom:.5pt solid black;
  width:35pt'>TOTAL FEED (KGS)</td>
  <td colspan=4 class=xl74 width=187 style='border-left:none;width:142pt'>FEED
  CONSUMPTION</td>
  <td colspan=6 class=xl715 style='border-left:none'>BODY WEIGHT</td>
  <td rowspan=3 class=xl707 width=171 style='border-bottom:.5pt solid black;
  width:128pt'>Medication</td>
  <td rowspan=3 class=xl709 width=103 style='border-bottom:.5pt solid black;
  width:77pt'>vaccine</td>
  <td class=xl685 width=64 style='width:48pt'>&nbsp;</td>
  <td colspan=7 class=xl75 style='mso-ignore:colspan'></td>
  <td colspan=225 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=15 style='mso-height-source:userset;height:11.25pt'>
  <td rowspan=2 height=47 class=xl74 width=43 style='height:35.25pt;border-top:
  none;width:32pt'>F</td>
  <td rowspan=2 class=xl74 width=35 style='border-top:none;width:26pt'>M</td>
  <td rowspan=2 class=xl74 width=29 style='border-top:none;width:22pt'>F</td>
  <td rowspan=2 class=xl74 width=29 style='border-top:none;width:22pt'>M</td>
  <td rowspan=2 class=xl74 width=29 style='border-top:none;width:22pt'>F</td>
  <td rowspan=2 class=xl74 width=26 style='border-top:none;width:20pt'>M</td>
  <td rowspan=2 class=xl74 width=31 style='border-top:none;width:23pt'>F</td>
  <td rowspan=2 class=xl74 width=26 style='border-top:none;width:20pt'>M</td>
  <td rowspan=2 class=xl74 width=50 style='border-top:none;width:38pt'>FEMALE
  FEED (KGS)<span style='mso-spacerun:yes'>&nbsp;&nbsp;</span></td>
  <td rowspan=2 class=xl74 width=46 style='border-top:none;width:35pt'>FEED PER
  BIRD</td>
  <td rowspan=2 class=xl74 width=46 style='border-top:none;width:35pt'>MALE
  FEED (KGS)<span style='mso-spacerun:yes'>&nbsp;&nbsp;</span></td>
  <td rowspan=2 class=xl74 width=45 style='border-top:none;width:34pt'>FEED PER
  BIRD</td>
  <td colspan=3 class=xl712 width=114 style='border-right:.5pt solid black;
  border-left:none;width:86pt'>F</td>
  <td colspan=3 class=xl712 width=107 style='border-right:.5pt solid black;
  border-left:none;width:81pt'>M</td>
  <td class=xl685 width=64 style='width:48pt'>&nbsp;</td>
  <td colspan=7 class=xl75 style='mso-ignore:colspan'></td>
  <td colspan=225 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=32 style='mso-height-source:userset;height:24.0pt'>
  <td height=32 class=xl481 width=42 style='height:24.0pt;border-top:none;
  border-left:none;width:32pt'>STD</td>
  <td class=xl485 width=36 style='border-top:none;border-left:none;width:27pt'>ACT<span
  style='mso-spacerun:yes'>&nbsp;</span></td>
  <td class=xl76 width=36 style='border-left:none;width:27pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+ / -</td>
  <td class=xl481 width=41 style='border-top:none;border-left:none;width:31pt'>STD</td>
  <td class=xl485 width=33 style='border-top:none;border-left:none;width:25pt'>ACT<span
  style='mso-spacerun:yes'>&nbsp;</span></td>
  <td class=xl76 width=33 style='border-left:none;width:25pt'><span
  style='mso-spacerun:yes'>&nbsp;</span>+ / -</td>
  <td class=xl127>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
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

$medlist = "'dummy'";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Medicines'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $medlist = $medlist . ",'" . $row1['code'] . "'";
  $medname[$row1['code']] = $row1['description'];
}

$vaclist = "'dummy'";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Vaccines'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $vaclist = $vaclist . ",'" . $row1['code'] . "'";
  $vacname[$row1['code']] = $row1['description'];
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
$weekfsexing = 0;$weekmsexing = 0;
$cummfmort = 0;$cummmmort = 0;
$cummfcull = 0;$cummmcull = 0;
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
$query = "SELECT * FROM breeder_consumption WHERE flock = '$flockget' GROUP BY date2 ORDER BY date2 ASC";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
 if($row1['date2'] < $untildate) {
  $medconsumed = ""; 
  $queryw = "SELECT * FROM breeder_consumption WHERE flock = '$flockget' and date2 = '$row1[date2]' and itemcode in ($medlist)";
  $resultw = mysql_query($queryw,$conn); 
  while($row1w = mysql_fetch_assoc($resultw))
  {
     $medconsumed = $medconsumed . "," . $medname[$row1w['itemcode']];
  }
  
  $vacconsumed = ""; 
  $queryw = "SELECT * FROM breeder_consumption WHERE flock = '$flockget' and date2 = '$row1[date2]' and itemcode in ($vaclist)";
  $resultw = mysql_query($queryw,$conn); 
  while($row1w = mysql_fetch_assoc($resultw))
  {
     $vacconsumed = $vacconsumed . "," . $vacname[$row1w['itemcode']];
  }

  $tdayeggs = 0;
  $tdayhatcheggs = 0;
  $mdayfeed = 0;
  $fdayfeed = 0;
  $query1 = "SELECT * FROM breeder_production WHERE flock = '$flockget' and date1 = '$row1[date2]' ORDER BY date1 ASC";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))
  {
     if(array_search($row11['itemcode'],$eggtype))
     {
        $tdayeggs = $tdayeggs + $row11['quantity'];        
        for($i = 0;$i < sizeof($rejections); $i++)
        {
            if($row11['itemcode'] == $rejections[$i])
              $rejectionsqty[$i] = $row11['quantity'];
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


  $query1 = "SELECT * FROM breeder_consumption WHERE flock = '$flockget' and date2 = '$row1[date2]' ORDER BY date2 ASC";
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
  $tfmort = $tfmort + $row1['fmort'];
  $tmmort = $tmmort + $row1['mmort'];
  $tfcull = $tfcull + $row1['fcull'];
  $tmcull = $tmcull + $row1['mcull'];
?>
 <tr height=15 style='height:11.25pt;display:none'>
  <td height=15 class=xl470 align=right style='height:11.25pt'><?php echo date('j/n/Y',strtotime($row1['date2'])); ?></td>
  <td class=xl339 align=right><?php echo $nrWeeksPassed.".".$nrDaysPassed; ?></td>
  <td class=xl339 align=right><?php echo $newage; ?></td>
  <td class=xl340 style='border-left:none'><?php echo $female; ?></td>
  <td class=xl341 style='border-left:none'><?php echo $male; ?></td>
  <td class=xl342 style='border-top:none'><?php echo $row1['fmort']; $weekfmort = $weekfmort + $row1['fmort']; ?></td>
  <td class=xl343 style='border-left:none'><?php echo $row1['mmort']; $weekmmort = $weekmmort + $row1['mmort']; ?></td>
  <td class=xl302 style='border-top:none;border-left:none'><?php echo $tfmort; ?></td>
  <td class=xl302 style='border-top:none;border-left:none'><?php echo $tmmort; ?></td>
  <td class=xl344 style='border-top:none;border-left:none'><?php echo number_format(round(($tfmort/$female)*100,2),2); ?></td>
  <td class=xl345 style='border-left:none'><?php echo number_format(round(($tmmort/$male)*100,2),2); ?></td>
  <td class=xl342 style='border-top:none'><?php echo $row1['fcull']; $weekfcull = $weekfcull + $row1['fcull']; $weekfsexing = $weekfsexing + $row1['fsexing']; ?></td>
  <td class=xl343 style='border-left:none'><?php echo $row1['mcull']; $weekmcull = $weekmcull + $row1['mcull']; $weekmsexing = $weekmsexing + $row1['msexing']; ?></td>
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
  <td class=xl342><?php echo $fweight = $row1['fweight']; ?></td>
  <td class=xl346 style='border-left:none'><?php echo $mweight = $row1['mweight']; ?></td>
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

      $tempax = $nrWeeksPassed + 1;
      $query34 = "SELECT * FROM breeder_bodyweights where client = '$client' and age = '$tempax' ORDER BY age ASC ";
      $result34 = mysql_query($query34,$conn); 
      while($row134 = mysql_fetch_assoc($result34))
      { 
         $stdfw = $row134['fweight'];
         $stdmw = $row134['mweight'];
      }

?>



 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl83 align=right style='height:11.25pt'><?php echo date("j-M",strtotime($row1['date2'])); ?></td>
  <td class=xl84 align=right><?php echo $nrWeeksPassed . "." . $nrDaysPassed; ?></td>
  <td class=xl68 align=right><?php echo $female; ?></td>
  <td class=xl68 align=right><?php echo $male; ?></td>
  <td class=xl112 align=right><?php echo $row1['fmort']; ?></td>
  <td class=xl112 align=right><?php echo $row1['mmort']; ?></td>
  <td class=xl112 align=right><?php echo $row1['fcull']; ?></td>
  <td class=xl112 align=right><?php echo $row1['mcull']; ?></td>
  <td class=xl68 align=right><?php echo $row1['fsexing']; ?></td>
  <td class=xl68 align=right><?php echo $row1['msexing']; ?></td>
  <td class=xl85 align=right><?php echo number_format($fdayfeed + $mdayfeed,2); ?></td>
  <td class=xl483 align=right><?php echo number_format($fdayfeed,2); ?></td>
  <td class=xl85 align=right><?php echo number_format(round(($fdayfeed/$female)*1000,3),3); ?></td>
  <td class=xl483 align=right><?php echo number_format($mdayfeed,2); ?></td>
  <td class=xl85 align=right><?php echo number_format(round(($mdayfeed/$male)*1000,3),3); ?></td>
  <td class=xl92><?php echo $stdfw; ?></td>
  <td class=xl92><?php echo $tx1 = round(($row1['fweight'] + $row1['fweightb'] + $row1['fweightc'] + $row1['fweightd'])/$fwx); ?></td>
  <td class=xl92><?php echo $tx1 - $stdfw; ?></td>
  <td class=xl92><?php echo $stdmw; ?></td>
  <td class=xl92><?php echo $tx2 = round(($row1['mweight'] + $row1['mweightb'] + $row1['mweightc'] + $row1['mweightd'])/$mwx); ?></td>
  <td class=xl92><?php echo $tx2 - $stdmw; ?></td>
  <td class=xl68><?php echo substr($medconsumed,1); ?></td>
  <td class=xl101><?php echo substr($vacconsumed,1); ?></td>
  <td class=xl699>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>




<?php 
 $female = $startfemale - ($tfmort + $tfcull);
 $male = $startmale - ($tmmort + $tmcull);
 $tdaypreveggs = $tdayeggs;
 $tdaypreveggsper = number_format(round(($tdayeggs/$female)*100,2),2);
 $tdayprevhatcheggs = $tdayhatcheggs;

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
  <td class=xl268><?php echo number_format(round(($weekfmort/$weekfemale)*100,3),3); ?></td>
  <td class=xl268><?php echo number_format(round(($weekmmort/$weekmale)*100,3),3); ?></td>
  <td class=xl268><?php echo $weekfcull; ?></td>
  <td class=xl268><?php echo $weekmcull; ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl269><?php echo number_format(round(($weekfcull/$weekfemale)*100,3),3); ?></td>
  <td class=xl269><?php echo number_format(round(($weekmcull/$weekmale)*100,3),3); ?></td>
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
 <tr height=15 style='height:11.25pt;display:none'>
  <td height=15 class=xl474 style='height:11.25pt'>Cum</td>
  <td class=xl270>&nbsp;</td>
  <td class=xl271>&nbsp;</td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo $cummfmort; ?></td>
  <td class=xl272><?php echo $cummmmort; ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo $tempcomp = number_format(round(($cummfmort/$startfemale)*100,3),3); ?></td>
  <td class=xl272><?php echo number_format(round(($cummmmort/$startmale)*100,3),3); ?></td>
  <td class=xl272><?php echo $cummfcull; ?></td>
  <td class=xl272><?php echo $cummmcull; ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo number_format(round(($cummfcull/$startfemale)*100,3),3); ?></td>
  <td class=xl272><?php echo number_format(round(($cummmcull/$startmale)*100,3),3); ?></td>
  <td class=xl272>0</td>
  <td class=xl272>0</td>
  <td class=xl272><?php echo $cummeggs; ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl273><?php echo $tempcomp2 = round($cummeggs/$startfemale,2); ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo $cummhatcheggs; ?></td>
  <td class=xl273><?php echo $tempcomp3 = round(($cummhatcheggs/$cummeggs)*100,2); ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl273><?php echo $tempcomp4 = round($cummhatcheggs/$startfemale,2); ?></td>
  <td class=xl272>&nbsp;</td>
  <?php for($i = 0; $i < sizeof($rejections); $i++)
  {
  ?>
  <td class=xl272><?php echo $cummrej[$i]; ?></td>
  <td class=xl273><?php echo round(($cummrej[$i]/$cummeggs)*100,2); ?></td>
  <?php } ?>
  <td class=xl272>&nbsp;</td>
  <td class=xl273><?php echo $cummffeed; ?></td>
  <td class=xl273><?php echo $cummmfeed; ?></td>
  <td class=xl273><?php echo $cummffeedg; ?></td>
  <td class=xl273><?php echo $cummmfeedg; ?></td>
  <td class=xl273><?php echo  $cummffeed + $cummmfeed; ?></td>
  <td class=xl273>&nbsp;</td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272 style='mso-ignore:colspan'></td>
  <td class=xl272 style='mso-ignore:colspan;border-right: 1pt solid black'></td>
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
$query34 = "SELECT * FROM breeder_bodyweights where client = '$client' and age = '$tempage' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdfw = $row134['fweight'];
  $stdmw = $row134['mweight'];
}
?>
 <tr height=15 style='height:11.25pt;display:none'>
  <td height=15 class=xl475 style='height:11.25pt'>Std</td>
  <td class=xl274>&nbsp;</td>
  <td class=xl275>&nbsp;</td>
  <td colspan=6 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $stdmort; ?></td>
  <td colspan=10 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $hdper; ?></td>
  <td class=xl276>&nbsp;</td>
  <td class=xl277><?php echo $stdeggbird; ?></td>
  <td colspan=3 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $stdheggper; ?></td>
  <td colspan=2 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl277><?php echo $stdheggbird; ?></td>
  <td class=xl276><?php echo $stdeggwt; ?></td>
  <td colspan=<?php echo $r * 2; ?> class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276>&nbsp;</td>
  <td colspan=4 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl277 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $stdfw; ?></td>
  <td class=xl276><?php echo $stdmw; ?></td>
  <td class=xl276 style='mso-ignore:colspan'></td>
  <td class=xl276 style='mso-ignore:colspan;border-right: 1pt solid black'></td>
 </tr>
 <tr height=16 style='height:12.0pt;display:none'>
  <td height=16 class=xl476 style='height:12.0pt'>Diff</td>
  <td class=xl278>&nbsp;</td>
  <td class=xl399>&nbsp;</td>
  <td colspan=6 class=xl400 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl400><?php echo round($tempcomp - $stdmort,2); ?></td>
  <td colspan=10 class=xl400 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl401><?php echo round($tempcomp1 - $hdper,2); ?></td>
  <td class=xl400>&nbsp;</td>
  <td class=xl401><?php echo round($tempcomp2 - $stdeggbird,2); ?></td>
  <td colspan=3 class=xl400 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl401><?php echo round($tempcomp3 - $stdheggper,2); ?></td>
  <td colspan=2 class=xl400 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl401><?php echo round($tempcomp4 - $stdheggbird,2); ?></td>
  <td class=xl400><?php echo round($tempcomp5 - $stdeggwt,2); ?></td>
  <td colspan=<?php echo $r * 2; ?> class=xl400 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl400>&nbsp;</td>
  <td colspan=4 class=xl400 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl401 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl400><?php echo round($tempcomp6 - $stdfw,2); ?></td>
  <td class=xl400><?php echo round($tempcomp7 - $stdmw,2); ?></td>
  <td class=xl400>&nbsp;</td>
  <td class=xl400 style="border-right: 1pt solid black">&nbsp;</td>
 </tr>






 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl89 colspan=3 style='height:11.25pt;mso-ignore:colspan'><?php echo $tempage; ?>
  Wk. Total</td>
  <td class=xl82></td>
  <td class=xl82 align=right><?php echo $weekfmort; ?></td>
  <td class=xl82 align=right><?php echo $weekmmort; ?></td>
  <td class=xl82 align=right><?php echo $weekfcull; ?></td>
  <td class=xl82 align=right><?php echo $weekmcull; ?></td>
  <td class=xl82 align=right><?php echo $weekfsexing; ?></td>
  <td class=xl82 align=right><?php echo $weekmsexing; ?></td>
  <td class=xl82 align=right><?php echo $weekffeed + $weekmfeed; ?></td>
  <td class=xl91 align=right><?php echo $weekffeed; ?></td>
  <td class=xl91 align=right><?php echo round($weekffeedg/7,2); ?></td>
  <td class=xl82 align=right><?php echo $weekmfeed; ?></td>
  <td class=xl91 align=right><?php echo round($weekmfeedg/7,2); ?></td>
  <td class=xl101 align=middle><?php echo $stdfw; ?></td>
  <td class=xl111 align=middle><?php echo $tx1; ?></td>
  <td class=xl82 align=middle><?php echo $tx1 - $stdfw; ?></td>
  <td class=xl101 align=middle><?php echo $stdmw; ?></td>
  <td class=xl111 align=middle><?php echo $tx2; ?></td>
  <td class=xl82 align=middle><?php echo $tx2 - $stdmw; ?></td>
  <td class=xl68></td>
  <td class=xl101></td>
  <td class=xl699>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl89 colspan=2 style='height:11.25pt;mso-ignore:colspan'>Current
  Wk</td>
  <td colspan=2 class=xl82 style='mso-ignore:colspan'></td>
  <td class=xl110 align=right><?php echo number_format(round(($weekfmort/$weekfemale)*100,2),2); ?></td>
  <td class=xl110 align=right><?php echo number_format(round(($weekmmort/$weekmale)*100,2),2); ?></td>
  <td class=xl110 align=right><?php echo number_format(round(($weekfcull/$weekfemale)*100,2),2); ?></td>
  <td class=xl110 align=right><?php echo number_format(round(($weekmcll/$weekmale)*100,2),2); ?></td>
  <td class=xl110 align=right><?php echo number_format(round(($weekfsexing/$weekfemale)*100,2),2); ?></td>
  <td class=xl110 align=right><?php echo number_format(round(($weekmsexing/$weekmale)*100,2),2); ?></td>
  <td class=xl82 align=right><?php echo $weekffeed + $weekmfeed; ?></td>
  <td class=xl91 align=right><?php echo $weekffeed; ?></td>
  <td class=xl91 align=right><?php echo round($weekffeedg/7,2); ?></td>
  <td class=xl91 align=right><?php echo $weekmfeed; ?></td>
  <td class=xl91 align=right><?php echo round($weekmfeedg/7,2); ?></td>
  <td class=xl112></td>
  <td class=xl68></td>
  <td colspan=2 class=xl112 style='mso-ignore:colspan'></td>
  <td class=xl68></td>
  <td class=xl112></td>
  <td class=xl68></td>
  <td class=xl101></td>
  <td class=xl699>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl113 colspan=2 style='height:11.25pt;mso-ignore:colspan'>Cumulative</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl78 align=right><?php echo $cummfmort; ?></td>
  <td class=xl78 align=right><?php echo $cummmmort; ?></td>
  <td class=xl78 align=right><?php echo $cummfcull; ?></td>
  <td class=xl78 align=right><?php echo $cummmcull; ?></td>
  <td class=xl78 align=right><?php echo $cummfsexing; ?></td>
  <td class=xl78 align=right><?php echo $cummmsexing; ?></td>
  <td class=xl114 align=right><?php echo $cummffeed + $cummmfeed; ?></td>
  <td class=xl115 align=right><?php echo $cummffeed; ?></td>
  <td class=xl115 align=right></td>
  <td class=xl115 align=right><?php echo $cummmfeed; ?></td>
  <td class=xl115 align=right></td>
  <td class=xl117>&nbsp;</td>
  <td class=xl124>&nbsp;</td>
  <td class=xl117>&nbsp;</td>
  <td class=xl117>&nbsp;</td>
  <td class=xl124>&nbsp;</td>
  <td class=xl117>&nbsp;</td>
  <td class=xl118>&nbsp;</td>
  <td class=xl101></td>
  <td class=xl699>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl119 colspan=3 style='height:11.25pt;mso-ignore:colspan'>Cum.
  Mort. %</td>
  <td class=xl95>&nbsp;</td>
  <td class=xl96 align=right><?php echo number_format(round(($cummfmort/$startfemale)*100,2),2); ?></td>
  <td class=xl94 align=right><?php echo number_format(round(($cummmmort/$startmale)*100,2),2); ?></td>
  <td class=xl96 align=right><?php echo number_format(round(($cummfcull/$startfemale)*100,2),2); ?></td>
  <td class=xl96 align=right><?php echo number_format(round(($cummmcull/$startmale)*100,2),2); ?></td>
  <td class=xl95 align=right><?php echo number_format(round(($cummfsexing/$startfemale)*100,2),2); ?></td>
  <td class=xl95 align=right><?php echo number_format(round(($cummmsexing/$startmale)*100,2),2); ?></td>
  <td class=xl95>&nbsp;</td>
  <td class=xl95>&nbsp;</td>
  <td class=xl97>&nbsp;</td>
  <td class=xl95>&nbsp;</td>
  <td class=xl94>&nbsp;</td>
  <td class=xl99>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl99>&nbsp;</td>
  <td class=xl99>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl99>&nbsp;</td>
  <td class=xl120>&nbsp;</td>
  <td class=xl101></td>
  <td class=xl699>&nbsp;</td>
  <td colspan=232 class=xl68 style='mso-ignore:colspan'></td>
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
 }
 }
} 
?>

































































</table>

</body>

</html>
