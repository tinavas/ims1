<?php session_start(); $flockget = $_SESSION['flock']; 
$breedi = $_SESSION['breedi'] ;
include "../config.php";
$query1 = "SELECT * FROM turkey_flock WHERE flockcode = '$flockget'";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening'];
      $startmale = $row11['maleopening'];
}
$querymin = "SELECT min(date2) as 'date2' FROM turkey_consumption WHERE flock like '$flockget' ";
$resultmin = mysql_query($querymin,$conn); 
while($row1min = mysql_fetch_assoc($resultmin))
{
$mincmpdate = $row1min['date2'];
}
 $femalet = 0;$malet=0;
 $query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat IN ('Turkey Female Birds', 'Turkey Male Birds') AND client = '$client' AND towarehouse like '$flockget' AND date<='$mincmpdate'";
  $result1t = mysql_query($query1t,$conn); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
      if($row11t['cat'] == 'Turkey Female Birds')
	  {
	  $femalet = $femalet + $row11t['quantity'];
	  }
	  else
	  {
	  $malet = $malet + $row11t['quantity'];
	  }
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
	 $query34 = "SELECT * FROM turkey_standards where client = '$client' and breed = '$breedi' ORDER BY age ASC ";
	}
	else
	{
	 $query34 = "SELECT * FROM turkey_standards where client = '$client' ORDER BY age ASC ";
	}
	  
//$query34 = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdmort[$row134['age']] = $row134['fcummmort'];
  $hdper[$row134['age']] = $row134['productionper'];
  $stdeggbird[$row134['age']] = $row134['alleggbird'];
  $stdheggbird[$row134['age']] = $row134['eggbird'];
  $stdheggper[$row134['age']] = $row134['heggper'];
  $stdeggwt[$row134['age']] = $row134['eggwt'];
  if($row134['age'] > 23)
  {
   $stdffeed[$row134['age']] = $row134['ffeed'];
   $stdmfeed[$row134['age']] = $row134['mfeed'];
  }
}

	  if($breedi != "")
	{
	 $query34 = "SELECT * FROM turkey_standards where client = '$client' and breed = '$breedi' ORDER BY age ASC ";
	}
	else
	{
	 $query34 = "SELECT * FROM turkey_standards where client = '$client' ORDER BY age ASC ";
	}
//$query34 = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdfw[$row134['age']] = $row134['fweight'];
  $stdmw[$row134['age']] = $row134['mweight'];
  if($row134['age'] < 24)
  {
   $stdffeed[$row134['age']] = $row134['ffeed'];
   $stdmfeed[$row134['age']] = $row134['mfeed'];
  }
}

$query1 = "SELECT min(date1) as 'date1' FROM turkey_production WHERE flock = '$flockget'";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
  $prodate = $row11['date1'];
}
$query1 = "SELECT max(date2) as 'date2' FROM turkey_consumption WHERE flock = '$flockget'";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
  $condate = $row11['date2'];
}
if($prodate)
{
$prodate = $prodate;
}
else
{
$prodate = $condate;
}

  $diffdate11 = strtotime($prodate) - strtotime($startdate);
  $diffdate11 = $diffdate11/(24*60*60);   
  $newage11 = $startage + $diffdate11;
  $nrSeconds = $newage11 * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $newage11 = floor($nrSeconds / 604800) + 1; 
  $untildate = strtotime($prodate) - ($nrDaysPassed * 60 * 24 * 24);
  $untildate = date("Y-m-d",$untildate);


$nrSeconds = $startage * 24 * 60 * 60;
$startweeks = floor($nrSeconds / 604800); 


$e = 1;
$eggtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE  cat In ('Turkey Hatch Eggs','Turkey Eggs')";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $eggtype[$e] = $row1['code'];
  $e = $e + 1;
}

$h = 1;
$hatcheggtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Turkey Hatch Eggs'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $hatcheggtype[$h] = $row1['code'];
  $h = $h + 1;
}


$ff= 1;
$ffeedtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Turkey Female Feed'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $ffeedtype[$ff] = $row1['code'];
  $ff = $ff + 1;
}

$mf= 1;
$mfeedtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Turkey Male Feed'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $mfeedtype[$mf] = $row1['code'];
  $mf = $mf + 1;
}

$weekffeed = 0;
$weekmfeed = 0;
$frem = 0;
$mrem = 0;
$frem1 = 0;
$mrem1 = 0;
$weekf = 0;
$weekm = 0;
$weekfemale = $startfemale;
$query = "SELECT * FROM turkey_consumption WHERE flock = '$flockget' GROUP BY date2 ORDER BY date2 ASC";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
  $diffdate = strtotime($row1['date2']) - strtotime($startdate);
  $diffdate = $diffdate/(24*60*60);   
  $newage = $startage + $diffdate;
  $nrSeconds = $newage * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $nrWeeksPassed = floor($nrSeconds / 604800); 
  $fdayfeed = 0;$mdayfeed = 0;

  
  $query1 = "SELECT * FROM turkey_consumption WHERE flock = '$flockget' and date2 = '$row1[date2]' ORDER BY date2 ASC";
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
  $weekffeed = $weekffeed + $fdayfeed;
  $weekmfeed = $weekmfeed + $mdayfeed;
  $weekf = $weekf + (round(($fdayfeed / ($startfemale - $frem)*1000),3));  
  $weekm = $weekm + (round(($mdayfeed / ($startmale - $mrem)*1000),3));




  $tdayeggs = 0;
  $tdayhatcheggs = 0;
  $mdayfeed = 0;
  $fdayfeed = 0;
  $query1 = "SELECT * FROM turkey_production WHERE flock = '$flockget' and date1 = '$row1[date2]' ORDER BY date1 ASC";
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
  
  $frem = $frem + $row1['fmort'] + $row1['fcull'];
  $mrem = $mrem + $row1['mmort'] + $row1['mcull'];

  $frem1 = $frem1 + $row1['fmort'];
  $mrem1 = $mrem1 + $row1['mmort'];

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

    $eggwt[$nrWeeksPassed] = $row1['eggwt'];
    $fmortper[$nrWeeksPassed] = ($frem1 / $startfemale) * 100;
    $mmortper[$nrWeeksPassed] = ($mrem1 / $startmale) * 100;
    $weekffeed1[$nrWeeksPassed] = round($weekf/7,2);
    $weekmfeed1[$nrWeeksPassed] = round($weekm/7,2);
    $weekeggs1[$nrWeeksPassed] = round((($weekeggs/7)/$weekfemale)*100,2); 
    $weekheggs1[$nrWeeksPassed] = round(($weekhatcheggs/$weekeggs)*100,2); 
    $hhe[$nrWeeksPassed] = round(($teggs/($startfemale - $frem)),2); 
    $hhhe[$nrWeeksPassed] = round(($thatcheggs/($startfemale - $frem)),2); 
    $weekffeed = 0;
    $weekmfeed = 0;
    $weekf = 0;
    $weekm = 0;
    $weekeggs = 0;
    $weekhatcheggs = 0;
    $weekfemale = $startfemale - $frem;
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
	{margin:1.0in 1.0in 3.5in 1.0in;
	mso-header-margin:1.0in;
	mso-footer-margin:1.0in;
	mso-page-orientation:landscape;}
-->
</style>
<![if !supportTabStrip]><script language="JavaScript">
<!--
function fnUpdateTabs()
 {
  if (parent.window.g_iIEVer>=4) {
   if (parent.document.readyState=="complete"
    && parent.frames['frTabs'].document.readyState=="complete")
   parent.fnSetActiveSheet(3);
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

<body link=blue vlink=purple class=xl577>

<center>
  <table><tr><td style="font-size:13px"><b>Breeder Performance Summary For Flock <?php session_start(); echo $_SESSION['flock']; ?></b></td></tr></table>
</center>

<table border=0 cellpadding=0 cellspacing=0 width=1227 style='border-collapse:
 collapse;table-layout:fixed;width:922pt'>
 <col class=xl577 width=55 style='mso-width-source:userset;mso-width-alt:2011;
 width:41pt'>
 <col class=xl577 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl613 width=45 style='mso-width-source:userset;mso-width-alt:1645;
 width:34pt'>
 <col class=xl577 width=45 style='mso-width-source:userset;mso-width-alt:1645;
 width:34pt'>
 <col class=xl611 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl577 width=39 style='mso-width-source:userset;mso-width-alt:1426;
 width:29pt'>
 <col class=xl577 width=56 style='mso-width-source:userset;mso-width-alt:2048;
 width:42pt'>
 <col class=xl613 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl611 width=46 style='mso-width-source:userset;mso-width-alt:1682;
 width:35pt'>
 <col class=xl577 width=44 style='mso-width-source:userset;mso-width-alt:1609;
 width:33pt'>
 <col class=xl611 width=46 style='mso-width-source:userset;mso-width-alt:1682;
 width:35pt'>
 <col class=xl613 width=45 style='mso-width-source:userset;mso-width-alt:1645;
 width:34pt'>
 <col class=xl611 width=33 style='mso-width-source:userset;mso-width-alt:1206;
 width:25pt'>
 <col class=xl613 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl611 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl613 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl577 width=39 style='mso-width-source:userset;mso-width-alt:1426;
 width:29pt'>
 <col class=xl611 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl577 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl577 width=50 style='mso-width-source:userset;mso-width-alt:1828;
 width:38pt'>
 <col class=xl577 width=56 style='mso-width-source:userset;mso-width-alt:2048;
 width:42pt'>
 <col class=xl577 width=52 style='mso-width-source:userset;mso-width-alt:1901;
 width:39pt'>
 <col class=xl577 width=36 style='mso-width-source:userset;mso-width-alt:1316;
 width:27pt'>
 <col class=xl577 width=46 style='mso-width-source:userset;mso-width-alt:1682;
 width:35pt'>
 <col class=xl577 width=28 span=2 style='mso-width-source:userset;mso-width-alt:
 1024;width:21pt'>
 <col class=xl577 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl577 width=81 style='mso-width-source:userset;mso-width-alt:2962;
 width:61pt'>
 <tr height=27 style='mso-height-source:userset;height:20.25pt'>
  <td colspan=27 height=27 class=xl762 width=1146 style='height:20.25pt;
  width:861pt'><a name="Print_Area"><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span></a></td>
  <td class=xl577 width=81 style='width:61pt'></td>
 </tr>
 <tr height=24 style='mso-height-source:userset;height:18.0pt'>
  <td colspan=4 height=24 class=xl578 style='height:18.0pt'>Farm name</td>
  <td colspan=4 class=xl578 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl578 style='border-left:none'>Hen Housed</td>
  <td colspan=2 class=xl578 style='border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl578 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl579 style='border-left:none'>&nbsp;</td>
  <td class=xl577></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl580 style='height:14.25pt;border-top:none'>&nbsp;</td>
  <td colspan=7 class=xl581 style='border-left:none'>FEMALE BODY WEIGHT</td>
  <td colspan=6 class=xl581 style='border-left:none'>FEED PER BIRD PER DAY</td>
  <td colspan=7 class=xl581 style='border-left:none'>MALE BODY WEIGHT</td>
  <td colspan=6 class=xl581 style='border-left:none'>FEED PER BIRD PER DAY</td>
  <td class=xl577></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl580 style='height:14.25pt;border-top:none'>AGE</td>
  <td class=xl593 style='border-top:none;border-left:none'>STD</td>
  <td colspan=4 class=xl602 style='border-left:none'>ACTUAL</td>
  <td class=xl580 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl604 style='border-top:none;border-left:none'>GAIN</td>
  <td class=xl593 style='border-top:none;border-left:none'>STD</td>
  <td colspan=5 class=xl602 style='border-left:none'>ACTUAL</td>
  <td class=xl593 style='border-top:none;border-left:none'>STD</td>
  <td colspan=4 class=xl602 style='border-left:none'>ACTUAL</td>
  <td class=xl580 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl604 style='border-top:none;border-left:none'>WT</td>
  <td class=xl593 style='border-top:none;border-left:none'>STD</td>
  <td colspan=4 class=xl764 style='border-left:none'>ACTUAL</td>
  <td class=xl619 style='border-top:none'>&nbsp;</td>
  <td class=xl577></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl580 style='height:14.25pt;border-top:none'>&nbsp;</td>
  <td class=xl593 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl602 style='border-top:none;border-left:none'>A</td>
  <td class=xl602 style='border-top:none;border-left:none'>B</td>
  <td class=xl602 style='border-top:none;border-left:none'>C</td>
  <td class=xl602 style='border-top:none;border-left:none'>D</td>
  <td class=xl603 style='border-top:none;border-left:none'>AVG</td>
  <td class=xl604 style='border-top:none;border-left:none'>GRAM</td>
  <td class=xl593 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl602 style='border-top:none;border-left:none'>A</td>
  <td class=xl602 style='border-top:none;border-left:none'>B</td>
  <td class=xl602 style='border-top:none;border-left:none'>C</td>
  <td class=xl602 style='border-top:none;border-left:none'>D</td>
  <td class=xl603 style='border-top:none;border-left:none'>AVG</td>
  <td class=xl593 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl602 style='border-top:none;border-left:none'>A</td>
  <td class=xl602 style='border-top:none;border-left:none'>B</td>
  <td class=xl602 style='border-top:none;border-left:none'>C</td>
  <td class=xl602 style='border-top:none;border-left:none'>D</td>
  <td class=xl603 style='border-top:none;border-left:none'>AVG</td>
  <td class=xl604 style='border-top:none;border-left:none'>GAIN</td>
  <td class=xl593 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl602 style='border-top:none;border-left:none'>A</td>
  <td class=xl602 style='border-top:none;border-left:none'>B</td>
  <td class=xl602 style='border-top:none;border-left:none'>C</td>
  <td class=xl602 style='border-top:none;border-left:none'>D</td>
  <td class=xl603 style='border-top:none;border-left:none'>AVG</td>
  <td class=xl577></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl585 style='height:14.25pt;border-top:none'>BROOD</td>
  <td class=xl592 style='border-top:none'>&nbsp;</td>
  <td class=xl582 style='border-left:none'>&nbsp;</td>
  <td class=xl582 style='border-left:none'>&nbsp;</td>
  <td class=xl583 style='border-left:none'>&nbsp;</td>
  <td class=xl583 style='border-left:none'>&nbsp;</td>
  <td class=xl583 style='border-left:none'>&nbsp;</td>
  <td class=xl583 style='border-left:none'>&nbsp;</td>
  <td class=xl605 style='border-left:none'>&nbsp;</td>
  <td class=xl606 style='border-left:none'>&nbsp;</td>
  <td class=xl606 style='border-left:none'>&nbsp;</td>
  <td class=xl606 style='border-left:none'>&nbsp;</td>
  <td class=xl607 style='border-left:none'>&nbsp;</td>
  <td class=xl625 style='border-left:none'>&nbsp;</td>
  <td class=xl608 style='border-left:none'>&nbsp;</td>
  <td class=xl612 style='border-left:none'>&nbsp;</td>
  <td class=xl612>&nbsp;</td>
  <td class=xl612>&nbsp;</td>
  <td class=xl612>&nbsp;</td>
  <td class=xl615 style='border-top:none'>&nbsp;</td>
  <td class=xl617 style='border-left:none'>&nbsp;</td>
  <td class=xl609>&nbsp;</td>
  <td class=xl621>&nbsp;</td>
  <td class=xl614 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl614 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl614 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl623 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl577></td>
 </tr>
 

<?php
for($bage = $startweeks + 1;$bage < $newage11;$bage++) {
?>
<tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl584 style='height:14.25pt;border-top:none'><?php echo $bage; ?></td>
  <td class=xl594 style='border-top:none;border-left:none'><?php echo $stdfw[$bage]; ?></td>
  <td class=xl595 style='border-top:none;border-left:none'><?php echo $fwa[$bage]; ?></td>
  <td class=xl596 style='border-top:none;border-left:none'><?php echo $fwb[$bage]; ?></td>
  <td class=xl597 style='border-top:none;border-left:none'><?php echo $fwc[$bage]; ?></td>
  <td class=xl597 style='border-top:none;border-left:none'><?php echo $fwd[$bage]; ?></td>
  <td class=xl599 style='border-top:none;border-left:none'><?php if($favg[$bage]) { echo $favg[$bage]; } else { echo 0; } ?></td>
  <td class=xl601 style='border-top:none;border-left:none'><?php echo $favg[$bage] - $favg[$bage-1]; ?></td>
  <td class=xl594 style='border-top:none;border-left:none'><?php echo $stdffeed[$bage]; ?></td>
  <td class=xl597 style='border-top:none;border-left:none'>-</td>
  <td class=xl597 style='border-top:none;border-left:none'>-</td>
  <td class=xl597 style='border-top:none;border-left:none'>-</td>
  <td class=xl597 style='border-top:none;border-left:none'>-</td>
  <td class=xl668 style='border-top:none;border-left:none'><?php echo $weekffeed1[$bage]; ?></td>
  <td class=xl594 style='border-top:none;border-left:none'><?php echo $stdmw[$bage]; ?></td>
  <td class=xl598 style='border-top:none;border-left:none'><?php echo $mwa[$bage]; ?></td>
  <td class=xl598 style='border-top:none'><?php echo $mwb[$bage]; ?></td>
  <td class=xl598 style='border-top:none'><?php echo $mwc[$bage]; ?></td>
  <td class=xl598 style='border-top:none'><?php echo $mwd[$bage]; ?></td>
  <td class=xl616><?php if($mavg[$bage]) { echo $mavg[$bage]; } else { echo 0; } ?></td>
  <td class=xl618 style='border-top:none;border-left:none'><?php echo $mavg[$bage] - $mavg[$bage-1]; ?></td>
  <td class=xl610 style='border-top:none'><?php echo $stdmfeed[$bage]; ?></td>
  <td class=xl622>-</td>
  <td class=xl622 style='border-top:none;border-left:none'>-</td>
  <td class=xl622 style='border-top:none;border-left:none'>-</td>
  <td class=xl622 style='border-top:none;border-left:none'>-</td>
  <td class=xl624 style='border-top:none;border-left:none'><?php echo $weekmfeed1[$bage]; ?></td>
  <td class=xl577></td>
 </tr>
<?php } ?>




 <tr class=xl128 height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl585 style='height:14.25pt;border-top:none'>LAYING</td>
  <td colspan=27 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=19 style='page-break-before:always;mso-height-source:userset;
  height:14.25pt'>
  <td height=19 class=xl578 style='height:14.25pt;border-top:none'>AGE</td>
  <td colspan=3 class=xl578 style='border-left:none'>MORTALITY%</td>
  <td colspan=2 class=xl578 style='border-left:none'>HEN DAY%</td>
  <td colspan=2 class=xl578 style='border-left:none'>HE %</td>
  <td colspan=2 class=xl578 style='border-left:none'>HHE</td>
  <td colspan=2 class=xl578 style='border-left:none'>C.HHHE</td>
  <td colspan=2 class=xl758 style='border-left:none'>FEED/ BIRD</td>
  <td colspan=3 class=xl758 style='border-right:.5pt solid black'>BODY WEIGHT</td>
  <td colspan=3 class=xl758 style='border-left:none'><span
  style='mso-spacerun:yes'>&nbsp;</span>EGG<span
  style='mso-spacerun:yes'>&nbsp; </span>WEIGHT</td>
  <td colspan=2 class=xl758 style='border-right:.5pt solid black'>M. MORTALITY%</td>
  <td colspan=2 class=xl760 style='border-right:.5pt solid black;border-left:
  none'>Feed Male</td>
  <td colspan=4 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=19 style='mso-height-source:userset;height:14.25pt'>
  <td height=19 class=xl578 style='height:14.25pt;border-top:none'>&nbsp;</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl578 style='border-top:none;border-left:none'>DIF</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl581 style='border-top:none;border-left:none'>DIF</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl633 style='border-top:none;border-left:none'>ACT</td>
  <td class=xl620 style='border-top:none;border-left:none'>DIF</td>
  <td colspan=2 class=xl695 style='border-top:none'>ACT</td>
  <td class=xl626 style='border-top:none;border-left:none'>STD</td>
  <td class=xl695 style='border-top:none;border-left:none'>ACT</td>
  <td colspan=4 class=xl128 style='mso-ignore:colspan'></td>
 </tr>



<?php
for($bage = $newage11;$bage < $nrWeeksPassed + 1;$bage++) {
?>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 class=xl586 style='height:12.75pt;border-top:none'><?php echo $bage; ?></td>
  <td class=xl627 style='border-top:none;border-left:none'><?php echo $stdmort[$bage]; ?></td>
  <td class=xl634 style='border-top:none;border-left:none'><?php echo round($fmortper[$bage],2); ?></td>
  <td class=xl693 style='border-top:none;border-left:none'><?php echo round($fmortper[$bage] - $stdmort[$bage],2); ?></td>
  <td class=xl635 style='border-top:none;border-left:none'><?php echo $hdper[$bage]; ?></td>
  <td class=xl634 style='border-top:none;border-left:none'><?php echo $weekeggs1[$bage]; ?></td>
  <td class=xl635 style='border-top:none;border-left:none'><?php echo $stdheggper[$bage]; ?></td>
  <td class=xl634 style='border-top:none;border-left:none'><?php echo $weekheggs1[$bage]; ?></td>
  <td class=xl629 style='border-top:none;border-left:none'><?php echo $stdeggbird[$bage]; ?></td>
  <td class=xl634 style='border-top:none;border-left:none'><?php echo $hhe[$bage]; ?></td>
  <td class=xl629 style='border-top:none;border-left:none'><?php echo $stdheggbird[$bage]; ?></td>
  <td class=xl634 style='border-top:none;border-left:none'><?php echo $hhhe[$bage]; ?></td>
  <td class=xl635 style='border-top:none;border-left:none'><?php echo $stdffeed[$bage]; ?></td>
  <td class=xl634 style='border-top:none;border-left:none'><?php echo $weekffeed1[$bage]; ?></td>
  <td class=xl638 align=right style='border-top:none;border-left:none'><?php echo $stdfw[$bage]; ?></td>
  <td class=xl642 style='border-top:none;border-left:none'><?php if($favg[$bage]) { echo $favg[$bage]; } else { echo 0; } ?></td>
  <td class=xl587 align=right style='border-top:none;border-left:none'><?php echo $favg[$bage] - $stdfw[$bage]; ?></td>
  <td class=xl645 align=right style='border-top:none'><?php echo $stdeggwt[$bage]; ?></td>
  <td class=xl642 style='border-top:none;border-left:none'><?php echo $eggwt[$bage]; ?></td>
  <td class=xl588 align=right style='border-top:none;border-left:none'><?php echo $eggwt[$bage] - $stdeggwt[$bage]; ?></td>
  <td colspan=2 class=xl634 style='border-top:none'><?php echo round($mmortper[$bage],2); ?></td>
  <td class=xl558 align=right style='border-top:none;border-left:none'><?php echo $stdmfeed[$bage]; ?></td>
  <td class=xl634 style='border-top:none;border-left:none'><?php echo $weekmfeed1[$bage]; ?></td>
  <td colspan=4 class=xl128 style='mso-ignore:colspan'></td>
 </tr>
<?php } ?>
</table>

</body>

</html>
