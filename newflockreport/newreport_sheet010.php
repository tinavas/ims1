<?php 
 session_start(); 
 $flockget = $_SESSION['flockcode']; 
 $breedi = $_SESSION['breedi'] ;
 $var = 0;
 foreach($_SESSION['eggbird'] as $k=>$v) 
 { 
   $arrage[$var] = $k;
   $maxage = $k;
   $var = $var+1;
 } 
  sort($arrage);
 $ll = count($arrage); 
 $maxage =$arrage[$ll-1];
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
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
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
   parent.fnSetActiveSheet(8);
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
<link href="flot/layout.css" rel="stylesheet" type="text/css"></link>
<!--[if IE]><script language="javascript" type="text/javascript" src="flot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="flot/jquery.js"></script>
<script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="flot/jquery.flot.dashes.js"></script>
</head>

<body link=blue vlink=purple>

<center>
  <table><tr><td style="font-size:13px"><b>Egg/Bird Graph For Flock <?php session_start(); echo $_SESSION['displayflock']; ?></b></td></tr></table>
</center>

<table border=0 cellpadding=0 cellspacing=0 width=1390 style='border-collapse:
 collapse;table-layout:fixed;width:1043pt'>
 <col width=46 style='mso-width-source:userset;mso-width-alt:1682;width:35pt'>
 <col class=xl677 width=32 style='mso-width-source:userset;mso-width-alt:1170;
 width:24pt'>
 <col class=xl674 width=32 style='mso-width-source:userset;mso-width-alt:1170;
 width:24pt'>
 <col width=64 span=20 style='width:48pt'>
 <tr height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 width=46 style='height:17.25pt;width:35pt'></td>
  <td width=32 style='width:24pt'></td>
  <td width=32 style='width:24pt'></td>
  <td width=64 style='width:48pt'></td>
  <td colspan=11 class=xl793 width=704 style='width:528pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>

 <tr height=17 style='height:12.75pt'>
  <td height=17 style='height:12.75pt'>Age</td>
  <td class=xl675>Act</td>
  <td class=xl672>Std</td>
  <td colspan=21 rowspan=37 height=629 width=1280>
  <table cellpadding=0 cellspacing=0>
   <tr>
  
    <td width=10 height=12></td>
  </tr>
   <tr>
   
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">No of Eggs</span></span>
      </td>
      <td><div id="placeholder" style="width:800px;height:800px"></div></td>
    <td width=26></td>
   </tr>
   <tr>
   	 <td height="1"></td>
     
       </tr>
  </table>
  </span><!--<![endif]>[if !mso & vml]><span style='width:960.0pt;height:471.75pt'></span><![endif]--></td>
 </tr>
<?php
include "../config.php";
/*$query12 = "SELECT min(age) as minage,female,male from breeder_initial WHERE flock like '%$flockget'   ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage']; 
$strtfemale = $row12['female'];
$strtmale = $row12['male'];
}
if($strtfemale == 0)
{
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
    echo   $startfemale = $startfemale + $row11['femaleopening'];
      $startmale = $startmale + $row11['maleopening'];
  }
}
$strtfemale = $startfemale;
$strtmale = $startmale;
}

$querymin = "SELECT min(date2) as 'date2' FROM breeder_production WHERE flock like '%$flockget' ";
$resultmin = mysql_query($querymin,$conn); 
while($row1min = mysql_fetch_assoc($resultmin))
{
 $mincmpdate = $row1min['date2'];
}

 $femalet = 0;$malet=0;
 $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat IN ('Female Birds','Male Birds')) AND client = '$client' AND flock like '%$flockget' AND date<'$mincmpdate'";
  $result1t = mysql_query($query1t,$conn); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
   
      if($row11t['code'] == 'BREFB101')
	  {
	 
	  $femalet = $femalet + $row11t['receivedquantity'];
	  }
	  else
	  {
	  $malet = $malet + $row11t['receivedquantity'];
	  }
  }
   if($femalet > 0)
  {
  $strtfemale = $strtfemale +$femalet;
  }
   if($malet > 0)
  {
  $strtmale = $strtmale + $malet;
  }

*/

$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' ";
$result1 = mysql_query($query1,$conn); 
$tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT sum(femaleopening) as femaleopening,sum(maleopening) as maleopening,min(age) as age,min(startdate) as startdate FROM breeder_flock WHERE flockcode like '%$flockget'";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      $startmale = $startmale + $row11['maleopening'];
  }
}
else
{
$query1 = "SELECT femaleopening,maleopening,age,startdate FROM breeder_flock WHERE flockcode like '%$flockget' ";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale =  $row11['femaleopening'];
      $startmale = $row11['maleopening'];
  }
}
/*else
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
*/


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
 
 
 $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and date2 < '$prodate' group by date2,flock";

$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{

   $startfemale = $startfemale - ($row11['fmort'] + $row11['fcull']);
   //$startmale = $startmale - ($row11['mmort'] + $row11['mcull']);
 
}
  //echo $startfemale ."&&&&&".$startmale;
 $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date < '$prodate' ";
    $result1t = mysql_query($query1t,$conn); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	// echo "female tr in    ";echo 
	$startfemale = $startfemale + $row11t['quantity'];
	}
	   /*$query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat= 'Male Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date < '$prodate'  ";
    $result1t = mysql_query($query1t,$conn); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
      
	  //echo "male tr in    ";echo 
	  $startmale = $startmale + $row11t['quantity'];
	  }*/
	  $query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND client = '$client' AND towarehouse not like '%$flockget' and fromwarehouse like '%$flockget' AND date < '$prodate'";
  	$result1t2 = mysql_query($query1t2,$conn); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
     
	 //echo "female tr out    ";echo  
	 $startfemale = $startfemale - $row11t2['quantity'];
	 
  }
 /*$query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat = 'Male Birds' AND client = '$client' AND towarehouse not like '%$flockget' and fromwarehouse like '%$flockget' AND date < '$prodate'";
  	$result1t2 = mysql_query($query1t2,$conn); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
     
	  //echo "male tr out    ";echo 
	   $startmale = $startmale - $row11t2['quantity'];
	  }*/


 $query1tpur = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat='Female Birds') AND client = '$client' AND flock like '%$flockget' AND date < '$prodate'";
  $result1tpur = mysql_query($query1tpur,$conn); 
  while($row11tpur = mysql_fetch_assoc($result1tpur))  
  {
   
      //echo "female pr     ";echo 
	  $startfemale = $startfemale + $row11tpur['receivedquantity'];
	 
  }

 $strtfemale = $startfemale;
 



$cumhhe = 0;
if($breedi != "")
{
$query = "SELECT * FROM breeder_standards where breed = '$breedi' and client = '$client' ORDER BY age ASC ";
}
else
{
$query = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
}
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
 if(in_array($row1['age'],$arrage)) {
 $cumhhe = $cumhhe + $_SESSION['iheggs'][$row1['age']];
?>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl671 style='height:12.75pt'><?php echo $age = $row1['age']; ?></td>
  <td class=xl676 align=right><?php echo round(($cumhhe/$strtfemale),1); ?></td>
  
  <td class=xl673 align=right><?php echo number_format($row1['cumhhp'],1); ?></td>
 </tr>
<?php }
else
{
$query11 = "SELECT * FROM breeder_initial where  flock like '%$flockget' and age = '$row1[age]' and eggs <> '' ORDER BY age ASC  ";
$result11 = mysql_query($query11,$conn); 
while($row11 = mysql_fetch_assoc($result11))
{
$totprod = 0;
$tothe = 0;
  $prod = $row11['eggs'];
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
  $cumhhe = $cumhhe + $tothe;
  
  ?>
<tr height=17 style='height:12.75pt'>
  <td height=17 class=xl671 style='height:12.75pt'><?php echo $age = $row1['age']; ?></td>
  <td class=xl676 align=right><?php echo round(($cumhhe/$strtfemale),1); ?></td>
  <td class=xl673 align=right><?php echo number_format($row1['cumhhp'],1); ?></td>
 </tr>
<?php

 
}
}
 } ?>


<script id="source" language="javascript" type="text/javascript">

$(function () {

var act = [
<?php
$strtfemale =0;
$query12 = "SELECT min(age) as minage,female,male from breeder_initial WHERE flock like '%$flockget'   ";
$result12 = mysql_query($query12,$conn); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage']; 
$strtfemale = $row12['female'];
$strtmale = $row12['male'];
}
if($strtfemale == 0)
{
/*$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate";
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
$strtfemale = $startfemale;
$strtmale = $startmale;*/

$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate";
$result1 = mysql_query($query1,$conn); 
$tcount = mysql_num_rows($result1);
$startfemale = 0;
if($tcount > 1)
{
  $query1 = "SELECT sum(femaleopening) as femaleopening,sum(maleopening) as maleopening,age,startdate FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate order by startdate asc limit 1";
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

 
 
 $query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and date2 < '$prodate' group by date2,flock";

$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{

   $startfemale = $startfemale - ($row11['fmort'] + $row11['fcull']);
   //$startmale = $startmale - ($row11['mmort'] + $row11['mcull']);
 
}
  //echo $startfemale ."&&&&&".$startmale;
 $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date < '$prodate' ";
    $result1t = mysql_query($query1t,$conn); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	// echo "female tr in    ";echo 
	$startfemale = $startfemale + $row11t['quantity'];
	}
	   /*$query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat= 'Male Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date < '$prodate'  ";
    $result1t = mysql_query($query1t,$conn); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
      
	  //echo "male tr in    ";echo 
	  $startmale = $startmale + $row11t['quantity'];
	  }*/
	  $query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND client = '$client' AND towarehouse not like '%$flockget' and fromwarehouse like '%$flockget' AND date < '$prodate'";
  	$result1t2 = mysql_query($query1t2,$conn); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
     
	 //echo "female tr out    ";echo  
	 $startfemale = $startfemale - $row11t2['quantity'];
	 
  }
 /*$query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat = 'Male Birds' AND client = '$client' AND towarehouse not like '%$flockget' and fromwarehouse like '%$flockget' AND date < '$prodate'";
  	$result1t2 = mysql_query($query1t2,$conn); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
     
	  //echo "male tr out    ";echo 
	   $startmale = $startmale - $row11t2['quantity'];
	  }*/


 $query1tpur = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat='Female Birds') AND client = '$client' AND flock like '%$flockget' AND date < '$prodate'";
  $result1tpur = mysql_query($query1tpur,$conn); 
  while($row11tpur = mysql_fetch_assoc($result1tpur))  
  {
   
     // echo "female pr     ";echo 
	   $startfemale = $startfemale + $row11tpur['receivedquantity'];
	 
  }

$strtfemale = $startfemale;
}
$cumhhe = 0;
if($breedi != "")
{
$query = "SELECT * FROM breeder_standards where breed = '$breedi' and client = '$client' ORDER BY age ASC ";
}
else
{
$query = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
}
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
 if(in_array($row1['age'],$arrage)) {
 $cumhhe = $cumhhe + $_SESSION['iheggs'][$row1['age']];
?>

[<?php echo $age = $row1['age']; ?>,<?php echo round(($cumhhe/$strtfemale),1); ?>],
<?php }
else
{
$query11 = "SELECT * FROM breeder_initial where  flock like '%$flockget' and age = '$row1[age]' ORDER BY age ASC  ";
$result11 = mysql_query($query11,$conn); 
while($row11 = mysql_fetch_assoc($result11))
{
$totprod = 0;
$tothe = 0;
  $prod = $row11['eggs'];
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
  $cumhhe = $cumhhe + $tothe;
  
  ?>
[<?php echo $age = $row1['age']; ?>,<?php echo round(($cumhhe/$strtfemale),1); ?>],
<?php

 
}
}
 } ?>
[<?php echo $age; ?>,<?php echo round(($cumhhe/$strtfemale),1); ?>]];


var std = [
<?php
if($breedi != "")
{
$query = "SELECT * FROM breeder_standards where breed = '$breedi' and client = '$client' ORDER BY age ASC ";
}
else
{
$query = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
}
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
 //if(in_array($row1['age'],$arrage)) {
?>

[<?php echo $age = $row1['age']; ?>,<?php echo $row1['cumhhp']; ?>],
<?php //}
        } ?>
[<?php echo $age; ?>,<?php echo $row1['cumhhp']; ?>]];


<!-- , dashes: { show: true }, hoverable: true  -->

            var plot =   $.plot($("#placeholder"),
           [ { data: act, Label: 'Actual', color:'#9999FF',yaxis: 1 },
             { data: std, Label: 'Standard', color:'#FF0000', yaxis: 1 }],
           { 
            lines: { show: true },
            points: { show: true },
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 24,tickSize: 1, max:<?php echo $maxage; ?>,label: "test"},
             yaxis: { min: 0, tickSize: 20, max:240 },
             legend: { margin: [660,280] } 
    });
 
    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (1) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.Label +" for " + x + " Weeks " + " is " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
        }
    });

    $("#placeholder").bind("plotclick", function (event, pos, item) {
        if (item) {
            $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
            plot.highlight(item.series, item.datapoint);
        }
    });
});



</script>

 <tr height=0 style='display:none'>
  <td class=xl671>61</td>
  <td class=xl676 align=right>57.6</td>
  <td class=xl673 align=right>58.0</td>
  <td colspan=20 style='mso-ignore:colspan'></td>
 </tr>
</table>

</body>

</html>

