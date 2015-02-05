<?php 
 session_start(); 
 $flockget = $_SESSION['flockcode']; 
 $var = 0;
 foreach($_SESSION['ifmort'] as $k=>$v) 
 { 
   $arrage[$var] = $k;
   $maxage = $k;
   $var = $var+1;
 } 

include "../config.php";
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
$currage = 0 ;
for($z=0;$z<count($arrage);$z++)
{
$currage = $arrage[$z];
$query = "SELECT * FROM breeder_standards where client = '$client' and age = '$currage' ORDER BY age ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
$stdmotper[$z] = $row1['fcummmort'] ;
}
if ( $stdmotper[$z] == "")
{
$stdmotper[$z] =0;
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
   parent.fnSetActiveSheet(11);
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
  <table><tr><td style="font-size:13px"><b>Mortality Graph For Flock <?php session_start(); echo $_SESSION['flockcode']; ?></b></td></tr></table>
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
  <td height=23 width=46 style='height:17.25pt;width:35pt'><h5>Female</h5></td>
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
  <td colspan=20 rowspan=37 height=629 width=1280>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td width=10 height=12></td>
   </tr>
   <tr>
    <td></td>
    <td><div id="placeholder" style="width:800px;height:800px"></div></td>
    <td width=26></td>
   </tr>
   <tr>
    <td height=1></td>
   </tr>
  </table>
  </span><![endif]><!--[if !mso & vml]><span style='width:960.0pt;height:471.75pt'></span><![endif]--></td>
 </tr>
<?php
$oldfm1 = 0;
$currmor = 0;
$currmorper = 0;
include "../config.php";
/*$query = "SELECT * FROM breeder_standards where client = '$client' ORDER BY age ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))$row1['fcummmort'];
{ */

$oldfm11 =0;
for($z=0;$z<count($arrage);$z++)
{
?>

 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl671 style='height:12.75pt'><?php echo $age = $arrage[$z]; ?> </td>
  <?php $currmor = $currmor + $_SESSION['ifmort'][$age];
   $currmorper  =   number_format(round(($currmor/$startfemale)*100,2),2) ?>
  <td class=xl676 align=right style="color:#00FF00"><?php echo $currmorper;  ?>&nbsp;,</em></td>
  <td class=xl673 align=right style="color:#006600"><?php if($stdmotper[$z] <= 0) { echo $oldfm11; } else { echo $oldfm11 = $stdmotper[$z]; } ?></td>

 </tr>
<?php }  ?>

<tr height="20px"><td></td></tr>




<script id="source" language="javascript" type="text/javascript">

$(function () {


var fmortv = [
<?php
/*$query = "SELECT * FROM breeder_standards where client = '$client' and age <= '$maxage' ORDER BY age ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
 if(array_search($row1['age'],$arrage)) {*/
 
 
  
$currmorc = 0;
for($z=0;$z<count($arrage);$z++)
{
$age = $arrage[$z];
$currmorc = $currmorc + $_SESSION['ifmort'][$age];
$currmorperc  =   number_format(round(($currmorc/$startfemale)*100,2),2); 
?>
[<?php echo $age; ?>,<?php echo $currmorperc; ?>],
<?php }  ?>
[<?php echo $age; ?>,<?php echo $currmorperc; ?>]];


var stdmort = [
<?php
$oldfm22 = 0;
for($z=0;$z<count($arrage);$z++)
{
 ?>
[<?php echo $age = $arrage[$z]; ?>,<?php if($stdmotper[$z] <= 0) { echo $oldfm22; } else { echo $oldfm22 = $stdmotper[$z]; } ?>],
 <?php   } ?>
	
[<?php echo $age; ?>,<?php echo $oldfm22; ?>]];


/*var stdmortdummy = [[63,7.67],[64,7.89],[65,8.11],[66,8.33]];*/

<!-- , dashes: { show: true }, hoverable: true  -->

          /*  var plot =   $.plot($("#placeholder"),
           [ { data: fmortv, Label: 'Female Mortality', color:'#00FF00',yaxis: 1 },
             { data: std, Label: 'Female Standard', color:'#006600', yaxis: 1 },
             { data: act1, Label: 'Male Actual', color:'#FF9999',yaxis: 2 },
             { data: std1, Label: 'Male Standard', color:'#CC0000',yaxis: 2 }],*/
			  var plot =   $.plot($("#placeholder"),
           [ { data: fmortv, Label: 'Female Mortality', color:'#00FF00',yaxis: 1 },
		  /*  { data: stdmortdummy, Label: 'Female Mortality', color:'#FF9999',yaxis: 1 }],*/
		   
		    { data: stdmort, Label: 'Female Standard Mortality', color:'#006600', yaxis: 1 }],
			 
           { 
            lines: { show: true },
            points: { show: true },
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,tickSize: 2,max:<?php echo $maxage; ?>,label: "test"},
             yaxis: { min: 0, tickSize: 5, max:100 },
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


