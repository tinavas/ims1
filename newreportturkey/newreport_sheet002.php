<?php session_start();
 $flockget = $_SESSION['flock']; 
  unset($_SESSION['istartage']);
  unset($_SESSION['iage']);
  unset($_SESSION['jstartage']);
  unset($_SESSION['iage']);

for($rt=0;$rt<100;$rt++)
{
  unset($_SESSION['hd'][$rt]);
  unset($_SESSION['heper'][$rt]);
  unset($_SESSION['fbweight'][$rt]);
  unset($_SESSION['mbweight'][$rt]);
  unset($_SESSION['eggbird'][$rt]);
  
  unset($_SESSION['fmort'][$rt]);
  unset($_SESSION['mmort'][$rt]);
  unset($_SESSION['ifmort'][$rt]);
  unset($_SESSION['immort'][$rt]);
  unset($_SESSION['ifcull'][$rt]);
  unset($_SESSION['imcull'][$rt]);
  unset($_SESSION['ieggs'][$rt]);
  unset($_SESSION['iheggs'][$rt]);
  unset($_SESSION['iffeed'][$rt]);
  unset($_SESSION['imfeed'][$rt]);
  unset($_SESSION['ifbweight'][$rt]);
  unset($_SESSION['imbweight'][$rt]);
  unset($_SESSION['ieggwt'][$rt]);
  unset($_SESSION['iffeedpb'][$rt]);
  unset($_SESSION['imfeedpb'][$rt]);
  unset($_SESSION['idate'][$rt]);

  unset($_SESSION['jfmort'][$rt]);
  unset($_SESSION['jmmort'][$rt]);
  unset($_SESSION['jfcull'][$rt]);
  unset($_SESSION['jmcull'][$rt]);
  unset($_SESSION['jffeed'][$rt]);
  unset($_SESSION['jmfeed'][$rt]);
  unset($_SESSION['jfbweight'][$rt]);
  unset($_SESSION['jmbweight'][$rt]);
  unset($_SESSION['jffeedpb'][$rt]);
  unset($_SESSION['jmfeedpb'][$rt]);
  unset($_SESSION['jdate'][$rt]);
  
   unset($_SESSION['cfmort'][$rt]);
  unset($_SESSION['cfmortstd'][$rt]);
  unset($_SESSION['cmmort'][$rt]);
    unset($_SESSION['hdstd'][$rt]);
	 unset($_SESSION['heperstd'][$rt]);
	  unset($_SESSION['eggbirdstd'][$rt]);
	  unset($_SESSION['hebird'][$rt]);
	    unset($_SESSION['hebirdstd'][$rt]); 
		unset($_SESSION['fbweightstd'][$rt]); 
		unset($_SESSION['mbweightstd'][$rt]); 
		unset($_SESSION['ieggwtstd'][$rt]); 
			unset($_SESSION['breedi']); 
		
		
		

  

}
include "../config.php";
$startfemale = 0;
$startmale = 0;
$startflag = 1;
$weekflag = 1;

$query1 = "SELECT * FROM turkey_flock WHERE flockcode like '$flockget' group by startdate";
$result1 = mysql_query($query1,$conn); 
$tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT * FROM turkey_flock WHERE flockcode like '$flockget' order by startdate asc limit 1";
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
  $query1 = "SELECT * FROM turkey_flock WHERE flockcode like '$flockget'";
  $result1 = mysql_query($query1,$conn); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      $startmale = $startmale + $row11['maleopening'];
  }
}




$query1 = "SELECT min(date1) as 'date1' FROM turkey_production WHERE flock like '$flockget'";
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
//echo $prodate;
  $diffdate11 = strtotime($prodate) - strtotime($startdate);
  $diffdate11 = $diffdate11/(24*60*60);   
  $newage11 = $startage + $diffdate11;
  $nrSeconds = $newage11 * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $untildate = strtotime($prodate) - ($nrDaysPassed * 60 * 24 * 24);
  $untildate = date("Y-m-d",$untildate);

$query1 = "SELECT * FROM turkey_consumption WHERE flock like '$flockget' and date2 < '$prodate' group by date2,flock";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
  $startfemale = $startfemale - ($row11['fmort'] + $row11['fcull']);
  $startmale = $startmale - ($row11['mmort'] + $row11['mcull']);
}

?>

<?php
include "../config.php";

$r = 0;
$query = "SELECT * FROM ims_itemcodes where cat = 'Turkey Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
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
   parent.fnSetActiveSheet(1);
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
<![endif]><![if !supportAnnotations]><style id="dynCom" type="text/css"><!-- --></style>

<script language="JavaScript"><!--

function msoCommentShow(com_id,anchor_id) {
	if(msoBrowserCheck()) {
	   c = document.all(com_id);
	   a = document.all(anchor_id);
	   if (null != c) {
		var cw = c.offsetWidth;
		var ch = c.offsetHeight;
		var aw = a.offsetWidth;
		var ah = a.offsetHeight;
		var x = a.offsetLeft;
		var y = a.offsetTop;
		var el = a;
		while (el.tagName != "BODY") {
		   el = el.offsetParent;
		   x = x + el.offsetLeft;
		   y = y + el.offsetTop;
		   }		
		var bw = document.body.clientWidth;
		var bh = document.body.clientHeight;
		var bsl = document.body.scrollLeft;
		var bst = document.body.scrollTop;
		if (x + cw + ah/2 > bw + bsl && x + aw - ah/2 - cw >= bsl ) {
		   c.style.left = x + aw - ah / 2 - cw; 
		}
		else {
		   c.style.left = x + ah/2; 
		}
		if (y + ch + ah/2 > bh + bst && y + ah/2 - ch >= bst ) {
	 	   c.style.top = y + ah/2 - ch;
		} 
		else {
		   c.style.top = y + ah/2;
		}
		c.style.visibility = "visible";
	   }
	}
}

function msoCommentHide(com_id) {
	if(msoBrowserCheck()) {
	  c = document.all(com_id)
	  if (null != c) {
	    c.style.visibility = "hidden";
	    c.style.left = "-10000";
	    c.style.top = "-10000";
	  }
	}
}

function msoBrowserCheck() {
 ms=navigator.appVersion.indexOf("MSIE");
 vers = navigator.appVersion.substring(ms+5, ms+6);
 ie4 = (ms>0) && (parseInt(vers) >=4);
 return ie4
}

if (msoBrowserCheck()) {
document.styleSheets.dynCom.addRule(".msocomspan1","position:absolute");
document.styleSheets.dynCom.addRule(".msocomspan2","position:absolute");
document.styleSheets.dynCom.addRule(".msocomspan2","left:-1.5ex");
document.styleSheets.dynCom.addRule(".msocomspan2","width:2ex");
document.styleSheets.dynCom.addRule(".msocomspan2","height:0.5em");
document.styleSheets.dynCom.addRule(".msocomanch","font-size:0.5em");
document.styleSheets.dynCom.addRule(".msocomanch","color:red");
document.styleSheets.dynCom.addRule(".msocomhide","display: none");
document.styleSheets.dynCom.addRule(".msocomtxt","visibility: hidden");
document.styleSheets.dynCom.addRule(".msocomtxt","position: absolute");        
document.styleSheets.dynCom.addRule(".msocomtxt","top:-10000");         
document.styleSheets.dynCom.addRule(".msocomtxt","left:-10000");         
document.styleSheets.dynCom.addRule(".msocomtxt","width: 33%");                 
document.styleSheets.dynCom.addRule(".msocomtxt","background: infobackground");
document.styleSheets.dynCom.addRule(".msocomtxt","color: infotext");
document.styleSheets.dynCom.addRule(".msocomtxt","border-top: 1pt solid threedlightshadow");
document.styleSheets.dynCom.addRule(".msocomtxt","border-right: 2pt solid threedshadow");
document.styleSheets.dynCom.addRule(".msocomtxt","border-bottom: 2pt solid threedshadow");
document.styleSheets.dynCom.addRule(".msocomtxt","border-left: 1pt solid threedlightshadow");
document.styleSheets.dynCom.addRule(".msocomtxt","padding: 3pt 3pt 3pt 3pt");
document.styleSheets.dynCom.addRule(".msocomtxt","z-index: 100");
}

// -->
</script>
<![endif]>
</head>

<?php
//$query = "SELECT min(date2) as 'date2' FROM breeder_consumption WHERE flock like '$flockget' GROUP BY date2 ORDER BY date2 ASC";
$query = "SELECT max(date2) as 'date2' FROM turkey_consumption WHERE flock like '$flockget' ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
// if($row1['date2'] >= $untildate) { $norecords = 1; } else { $norecords = 0; }
//if($row1['date2'] >= $prodate) { $norecords = 1; } else { $norecords = 0; }
 if($row1['date2'] <= $prodate) { $norecords = 0; } else { $norecords = 1; }
}
if(!$norecords)
{
 include "norecords.htm"; 
}
else
{

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

?>

<body link=blue vlink=purple class=xl198>

<center>
  <table><tr><td style="font-size:13px"><b>Laying Report For Flock <?php session_start(); echo $_SESSION['flock']; ?></b></td></tr></table>
</center>
<br /><br />
<table border=0 cellpadding=0 cellspacing=0 width=2526 style='border-collapse:
 collapse;table-layout:fixed;width:1893pt'>
 <col class=xl480 width=55 style='mso-width-source:userset;mso-width-alt:2011;
 width:41pt'>
 <col class=xl198 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl198 width=25 style='mso-width-source:userset;mso-width-alt:914;
 width:19pt'>
 <col class=xl198 width=37 style='mso-width-source:userset;mso-width-alt:1353;
 width:28pt'>
 <col class=xl198 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl198 width=26 style='mso-width-source:userset;mso-width-alt:950;
 width:20pt'>
 <col class=xl198 width=19 style='mso-width-source:userset;mso-width-alt:694;
 width:14pt'>
 <col class=xl198 width=22 style='mso-width-source:userset;mso-width-alt:804;
 width:17pt'>
 <col class=xl198 width=18 style='mso-width-source:userset;mso-width-alt:658;
 width:14pt'>
 <col class=xl280 width=43 span=2 style='mso-width-source:userset;mso-width-alt:
 1572;width:32pt'>
 <col class=xl198 width=19 span=4 style='mso-width-source:userset;mso-width-alt:
 694;width:14pt'>
 <col class=xl280 width=43 span=2 style='mso-width-source:userset;mso-width-alt:
 1572;width:32pt'>
 <col class=xl280 width=25 span=2 style='mso-width-source:userset;mso-width-alt:
 914;width:19pt'>
 <col class=xl198 width=43 style='mso-width-source:userset;mso-width-alt:1572;
 width:32pt'>
 <col class=xl280 width=49 style='mso-width-source:userset;mso-width-alt:1792;
 width:37pt'>
 <col class=xl198 width=43 style='mso-width-source:userset;mso-width-alt:1572;
 width:32pt'>
 <col class=xl280 width=46 style='mso-width-source:userset;mso-width-alt:1682;
 width:35pt'>
 <col class=xl198 width=35 style='mso-width-source:userset;mso-width-alt:1280;
 width:26pt'>
 <col class=xl198 width=38 style='mso-width-source:userset;mso-width-alt:1389;
 width:29pt'>
 <col class=xl198 width=52 span=2 style='mso-width-source:userset;mso-width-alt:
 1901;width:39pt'>
 <col class=xl198 width=47 style='mso-width-source:userset;mso-width-alt:1718;
 width:35pt'>
 <col class=xl279 width=43 style='mso-width-source:userset;mso-width-alt:1572;
 width:32pt'>
 <col class=xl280 width=47 style='mso-width-source:userset;mso-width-alt:1718;
 width:35pt'>
 <col class=xl199 width=28 style='mso-width-source:userset;mso-width-alt:1024;
 width:21pt'>
 <!-- <col class=xl198 width=37 style='mso-width-source:userset;mso-width-alt:1353;
 width:28pt'>
 <col class=xl198 width=41 style='mso-width-source:userset;mso-width-alt:1499;
 width:31pt'>
 <col class=xl198 width=37 style='mso-width-source:userset;mso-width-alt:1353;
 width:28pt'>
 <col class=xl198 width=41 style='mso-width-source:userset;mso-width-alt:1499;
 width:31pt'>
 <col class=xl198 width=25 style='mso-width-source:userset;mso-width-alt:914;
 width:19pt'>
 <col class=xl198 width=43 style='mso-width-source:userset;mso-width-alt:1572;
 width:32pt'>
 <col class=xl198 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl198 width=41 style='mso-width-source:userset;mso-width-alt:1499;
 width:31pt'>
 <col class=xl198 width=31 style='mso-width-source:userset;mso-width-alt:1133;
 width:23pt'>
 <col class=xl198 width=41 style='mso-width-source:userset;mso-width-alt:1499;
 width:31pt'>
 <col class=xl198 width=29 style='mso-width-source:userset;mso-width-alt:1060;
 width:22pt'>
 <col class=xl198 width=56 style='mso-width-source:userset;mso-width-alt:2048;
 width:42pt'>
 <col class=xl198 width=59 style='mso-width-source:userset;mso-width-alt:2157;
 width:44pt'> -->
<?php for($rr=0;$rr<$r;$rr++) { ?>
 <col class=xl198 width=37 >
 <col class=xl198 width=41 >
<?php } ?>
 <col class=xl198 width=30>
 <col class=xl198 width=50>
 <col class=xl198 width=50>
 <col class=xl198 width=45>
 <col class=xl198 width=45>
 <col class=xl198 width=50>
 <col class=xl198 width=35>
 <col class=xl198 width=45>
 <col class=xl198 width=45>
 <col class=xl198 width=64 span=2 style='width:148pt'>
 <col class=xl462 width=64 style='width:48pt'>

 <col class=xl198 width=31 span=2 style='mso-width-source:userset;mso-width-alt:
 1133;width:23pt'>
 <col class=xl198 width=128 span=3 style='mso-width-source:userset;mso-width-alt:
 4681;width:96pt'> 

 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 class=xl466 style='height:12.75pt'>&nbsp;</td>
  <td colspan=8 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl246 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=4 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl246 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl750>F L O C K :</td>
  <td colspan=2 class=xl249 style='border-left:none'><?php echo $flockget; ?></td>
  <td class=xl245>&nbsp;</td>
  <td colspan=5 class=xl752>H E N<span style='mso-spacerun:yes'>&nbsp;&nbsp;
  </span>H O U S E D</td>
  <td class=xl247>&nbsp;</td>
  <td class=xl246>&nbsp;</td>
  <td class=xl248>&nbsp;</td>
  <td colspan=13 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl304 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=8 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl198 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='height:12.75pt'>
  <td height=17 class=xl466 style='height:12.75pt'>&nbsp;</td>
  <td colspan=8 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl246 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=4 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=4 class=xl246 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl245>&nbsp;</td>
  <td class=xl246>&nbsp;</td>
  <td class=xl198></td>
  <td class=xl250>F :</td>
  <td colspan=2 class=xl753><?php echo $startfemale; ?></td>
  <td class=xl251>M :</td>
  <td colspan=2 class=xl751><?php echo $startmale; ?></td>
  <td class=xl247>&nbsp;</td>
  <td class=xl246>&nbsp;</td>
  <td class=xl248>&nbsp;</td>
  <td colspan=13 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl304 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=8 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl198 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=16 style='height:12.0pt'>
  <td height=16 class=xl466 style='height:12.0pt'>&nbsp;</td>
  <td colspan=8 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl246 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=4 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl246 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl252>&nbsp;</td>
  <td class=xl252>&nbsp;</td>
  <td class=xl245>&nbsp;</td>
  <td class=xl246>&nbsp;</td>
  <td class=xl245>&nbsp;</td>
  <td class=xl246>&nbsp;</td>
  <td colspan=5 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl247>&nbsp;</td>
  <td class=xl246>&nbsp;</td>
  <td class=xl248>&nbsp;</td>
  <td colspan=13 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl304 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=8 class=xl245 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=3 class=xl198 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=16 style='height:12.0pt'>
  <td height=16 class=xl467 style='height:12.0pt'>&nbsp;</td>
  <td class=xl253 style='border-left:none'>&nbsp;</td>
  <td class=xl254>&nbsp;</td>
  <td class=xl254>&nbsp;</td>
  <td class=xl255>&nbsp;</td>
  <td colspan=6 class=xl717 style='border-right:2.0pt double black;border-left:
  none'>M<span style='mso-spacerun:yes'>&nbsp; </span>O<span
  style='mso-spacerun:yes'>&nbsp; </span>R<span style='mso-spacerun:yes'>&nbsp;
  </span>T<span style='mso-spacerun:yes'>&nbsp; </span>A<span
  style='mso-spacerun:yes'>&nbsp; </span>L<span style='mso-spacerun:yes'>&nbsp;
  </span>I<span style='mso-spacerun:yes'>&nbsp; </span>T<span
  style='mso-spacerun:yes'>&nbsp; </span>Y</td>
  <td colspan=6 class=xl721 style='border-right:2.0pt double black;border-left:
  none'>C<span style='mso-spacerun:yes'>&nbsp; </span>U<span
  style='mso-spacerun:yes'>&nbsp; </span>L<span style='mso-spacerun:yes'>&nbsp;
  </span>L<span style='mso-spacerun:yes'>&nbsp; </span>S</td>
  <td colspan=2 rowspan=2 class=xl737 width=50 style='border-right:2.0pt double black;
  border-bottom:.5pt solid black;width:38pt'>Sales</td>
  <td colspan=<?php echo (12 + $r * 2); ?> class=xl735 style='border-right:2.0pt double black;border-bottom:
  1.0pt solid black;border-left:none'>T<span style='mso-spacerun:yes'>&nbsp;
  </span>O<span style='mso-spacerun:yes'>&nbsp; </span>T<span
  style='mso-spacerun:yes'>&nbsp; </span>A<span style='mso-spacerun:yes'>&nbsp;
  </span>L<span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>P<span style='mso-spacerun:yes'>&nbsp; </span>R<span
  style='mso-spacerun:yes'>&nbsp; </span>O<span style='mso-spacerun:yes'>&nbsp;
  </span>D<span style='mso-spacerun:yes'>&nbsp; </span>U<span
  style='mso-spacerun:yes'>&nbsp; </span>C<span style='mso-spacerun:yes'>&nbsp;
  </span>T<span style='mso-spacerun:yes'>&nbsp; </span>I<span
  style='mso-spacerun:yes'>&nbsp; </span>O<span style='mso-spacerun:yes'>&nbsp;
  </span>N</td>
  <td class=xl256>&nbsp;</td>
  <td colspan=6 class=xl731 style='border-right:2.0pt double black'>F<span
  style='mso-spacerun:yes'>&nbsp; </span>E<span style='mso-spacerun:yes'>&nbsp;
  </span>E<span style='mso-spacerun:yes'>&nbsp; </span>D<span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span>C O N S U M P T I O N</td>
  <td colspan=2 class=xl731 style='border-right:2.0pt double black'>Body Wt</td>
  <td colspan=9 class=xl198 style='mso-ignore:colspan'></td>
 </tr>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 class=xl468 style='height:12.75pt'>&nbsp;</td>
  <td class=xl257 style='border-left:none'>&nbsp;</td>
  <td class=xl305 style='border-top:none'>&nbsp;</td>
  <td colspan=2 class=xl717 style='border-right:1.0pt solid black;border-left:
  none'>Birds</td>
  <td colspan=2 class=xl724 style='border-right:.5pt solid black'>Daily</td>
  <td colspan=2 class=xl719 style='border-right:.5pt solid black;border-left:
  none'>Cum</td>
  <td colspan=2 class=xl719 style='border-right:2.0pt double black;border-left:
  none'>%</td>
  <td colspan=2 class=xl726>Daily</td>
  <td colspan=2 class=xl307 style='border-left:none'>Cum</td>
  <td colspan=2 class=xl307 style='border-right:2.0pt double black;border-left:
  none'>%</td>
  <td colspan=4 class=xl721 style='border-right:2.0pt double black;border-left:
  none'>Hen Day</td>
  <td colspan=2 class=xl728 style='border-right:2.0pt double black;border-left:
  none'>Incr / Decr</td>
  <td colspan=6 class=xl722 style='border-right:2.0pt double black'>H a t c h i
  n g<span style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span>E g g s<span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span>S e l e c t I o n</td>
  <td colspan=<?php echo $r * 2; ?> class=xl721 style='border-right:2.0pt double black;border-left:
  none'>R e j e c t i o n s<span style='mso-spacerun:yes'>&nbsp;</span></td>
  <td class=xl256>&nbsp;</td>
  <td colspan=2 class=xl733 style='border-right:1.0pt solid black'>Feed Kg</td>
  <td colspan=2 class=xl742 style='border-right:2.0pt double black;border-left:
  none'>Feed gms</td>
  <td rowspan=2 class=xl743 width=64 style='width:48pt;border-right:1.0pt solid black'>Total Feed</td>
  <td rowspan=2 class=xl744 width=43 style='border-top:none;width:32pt'>Feed<br />
  /egg</td>
  <td colspan=2 class=xl733 style='border-right:2.0pt double black'>Actual</td>
  <td rowspan=2 class=xl746 style='border-bottom:.5pt solid black'>M E D I C A
  T I O N</td>
  <td rowspan=2 class=xl746 style='border-bottom:.5pt solid black'>V A C C I N
  E</td>
 </tr>



 <tr height=16 style='height:12.0pt'>
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
$query = "SELECT * FROM ims_itemcodes WHERE cat In ('Turkey Hatch Eggs','Turkey Eggs')";
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

 $tftrin = 0;
   $tmtrin = 0;
   $tftrout = 0;
   $tmtrout = 0;
$tfcull = 0;$tmcull = 0;
$teggs = 0;
$thatcheggs = 0;
$weekeggs = 0;
$weekhatcheggs = 0;
$cummeggs = 0;
$cummhatcheggs = 0;
$female = $startfemale;
$male = $startmale;
$weektrfin = 0;$weektrmin = 0;
$weektrfout = 0;$weektrmout = 0;

$weekfmort = 0;$weekmmort = 0;
$weekfcull = 0;$weekmcull = 0;
$cummfmort = 0;$cummmmort = 0;

 $cummtrfin = 0;$cummtrfout = 0;
	$cummtrmin =0;$cummtrmout =0;
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
$query = "SELECT * FROM turkey_consumption WHERE flock like '$flockget' GROUP BY date2 ORDER BY date2 ASC";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{

   $allftrin = 0;
   $allmtrin = 0;
   $allftrout = 0;
   $allmtrout = 0;

   $allfmort = 0;
   $allmmort = 0;
   $allfcull = 0;
   $allmcull = 0;
   $queryff = "SELECT * FROM turkey_consumption WHERE flock like '$flockget' and date2 = '$row1[date2]' GROUP BY date2,flock ORDER BY date2 ASC";
   $resultff = mysql_query($queryff,$conn); 
   while($rowff = mysql_fetch_assoc($resultff))
   {
     $allfmort = $allfmort + $rowff['fmort'];
     $allmmort = $allmmort + $rowff['mmort'];
     $allfcull = $allfcull + $rowff['fcull'];
     $allmcull = $allmcull + $rowff['mcull'];
   }
   
   $query1t = "SELECT cat,sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Turkey Female Birds' AND  towarehouse like '$flockget' and fromwarehouse not like '$flockget' AND date = '$row1[date2]' ";
    $result1t = mysql_query($query1t,$conn); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	  $allftrin = $allftrin + $row11t['quantity'];
	}
	   $query1t = "SELECT cat,sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat= 'Turkey Male Birds' AND  towarehouse like '$flockget' and fromwarehouse not like '$flockget' AND date = '$row1[date2]' ";
    $result1t = mysql_query($query1t,$conn); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
      
	  $allmtrin = $allmtrin + $row11t['quantity'];
	  }
	  
	   $query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat ='Turkey Female Birds' AND client = '$client' AND towarehouse not like '$flockget' and fromwarehouse like '$flockget' AND date = '$row1[date2]'";
  	$result1t2 = mysql_query($query1t2,$conn); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
     
	  $allftrout = $allftrout + $row11t2['quantity'];
	 
  }
  $query1t2 = "SELECT cat,sum(quantity) as quantity FROM `ims_stocktransfer` WHERE cat = 'Turkey Male Birds' AND client = '$client' AND towarehouse not like '$flockget' and fromwarehouse like '$flockget' AND date = '$row1[date2]'";
  	$result1t2 = mysql_query($query1t2,$conn); 
  	while($row11t2= mysql_fetch_assoc($result1t2))  
  	{
     
	  $allmtrout = $allmtrout + $row11t2['quantity'];
	  }
   

   $alleggwt = 0;
   $allfweight = 0;
   $allmweight = 0;
   $queryff = "SELECT max(eggwt) as 'eggwt',max(fweight) as 'fweight',max(mweight) as 'mweight' FROM turkey_consumption WHERE flock like '$flockget' and date2 = '$row1[date2]' GROUP BY date2,flock ORDER BY date2 ASC";
   $resultff = mysql_query($queryff,$conn); 
   while($rowff = mysql_fetch_assoc($resultff))
   {
     $alleggwt = $rowff['eggwt'];
     $allfweight = $rowff['fweight'];
     $allmweight = $rowff['mweight'];
   }

 if($row1['date2'] >= $prodate) {
  $medconsumed = ""; 
  $queryw = "SELECT * FROM turkey_consumption WHERE flock like '$flockget' and date2 = '$row1[date2]' and itemcode in ($medlist)";
  $resultw = mysql_query($queryw,$conn); 
  while($row1w = mysql_fetch_assoc($resultw))
  {
     $medconsumed = $medconsumed . "," . $medname[$row1w['itemcode']];
  }
  
  $vacconsumed = ""; 
  $queryw = "SELECT * FROM turkey_consumption WHERE flock like '$flockget' and date2 = '$row1[date2]' and itemcode in ($vaclist)";
  $resultw = mysql_query($queryw,$conn); 
  while($row1w = mysql_fetch_assoc($resultw))
  {
     $vacconsumed = $vacconsumed . "," . $vacname[$row1w['itemcode']];
  }

  $tdayeggs = 0;
  $tdayhatcheggs = 0;
  $mdayfeed = 0;
  $fdayfeed = 0;
  $query1 = "SELECT * FROM turkey_production WHERE flock like '$flockget' and date1 = '$row1[date2]' ORDER BY date1 ASC";
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
               $query1df = "SELECT sum(quantity) as 'quantity' FROM turkey_production WHERE flock like '$flockget' and itemcode = '$rejections[$i]' and date1 = '$row1[date2]' ORDER BY date1 ASC";
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


  $query1 = "SELECT * FROM turkey_consumption WHERE flock like '$flockget' and date2 = '$row1[date2]' ORDER BY date2 ASC";
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
  
    $tftrin = $tftrin + $allftrin;
  $tmtrin = $tmtrin + $allmtrin;
  $tftrout = $tftrout + $allftrout;
  $tmtrout = $tmtrout + $allmtrout;
?>
 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl470 align=right style='height:11.25pt'><?php echo $s = date('j/n/Y',strtotime($row1['date2'])); if(!$weekflag) { $_SESSION['idate'][$nrWeeksPassed + 1] = strtotime($row1['date2']); } ?></td>
  <td class=xl339 align=right><?php echo $nrWeeksPassed.".".$nrDaysPassed; ?></td>
  <td class=xl339 align=right><?php echo round($newage); ?></td>
  <td class=xl340 style='border-left:none'><?php echo $female; if($weekflag) { $_SESSION['ifemale'][$nrWeeksPassed + 1] = $female; $_SESSION['imale'][$nrWeeksPassed + 1] = $male; $weekflag = 0; } ?></td>
  <td class=xl341 style='border-left:none'><?php echo $male; ?></td>
  <td class=xl342 style='border-top:none'><?php echo $allfmort; $weekfmort = $weekfmort + $allfmort; ?></td>
  <td class=xl343 style='border-left:none'><?php echo $allmmort; $weekmmort = $weekmmort + $allmmort?></td>
    <?php 
 
  $weektrfin = $weektrfin + $allftrin;
  $weektrmin = weektrmin + $allmtrin;
  $weektrfout =$weektrfout + $allftrout;
  $weektrmout = $weektrmout + $allmtrout;
  ?>
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
  <td class=xl352 style='border-left:none'><?php echo number_format($alleggwt,1); $weekeggwt = $weekeggwt + $alleggwt; ?></td>
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
  <td class=xl361 style='border-top:none;border-left:none'>&nbsp;&nbsp;<?php echo substr($medconsumed,1); ?></td>
  <td class=xl361 style='border-top:none;border-left:none'>&nbsp;&nbsp;<?php echo substr($vacconsumed,1); ?></td>
 </tr>
<?php 
 //$female = $startfemale - ($tfmort + $tfcull);
 //$male = $startmale - ($tmmort + $tmcull);
   $female = $startfemale - ($tfmort + $tfcull) + $tftrin - $tftrout;
 $male = $startmale - ($tmmort + $tmcull) + $tmtrin - $tmtrout;
 $tdaypreveggs = $tdayeggs;
 $tdaypreveggsper = number_format(round(($tdayeggs/$female)*100,2),2);
 $tdayprevhatcheggs = $tdayhatcheggs;

 if($nrDaysPassed == 7)
 {
   $weekflag = 1;
   $cummfmort = $cummfmort + $weekfmort;$cummmmort = $cummmmort + $weekmmort;
   
       $cummtrfin = $cummtrfin + $weektrfin;$cummtrfout = $cummtrfout +  $weektrfout;
	$cummtrmin =$cummtrmin  + $weektrmin;$cummtrmout =$cummtrmout  + $weektrmout;
   $cummfcull = $cummfcull + $weekfcull;$cummmcull = $cummmcull + $weekmcull;
   $cummeggs = $cummeggs + $weekeggs; $cummhatcheggs = $cummhatcheggs + $weekhatcheggs;
   $cummeggwt = $cummeggwt + $weekeggwt;
   $cummffeed = $cummffeed + $weekffeed;
   $cummmfeed = $cummmfeed + $weekmfeed;
   for($i = 0; $i < sizeof($rejections); $i++)
   {
      $cummrej[$i] = $cummrej[$i] + $rejqty[$i];
   }
   if($startflag)
   {
      $_SESSION['istartage'] = $nrWeeksPassed + 1;
      $startflag = 0;
   }
?>
 <tr height=16 style='height:12.0pt'>
  <td height=16 class=xl473 style='height:12.0pt'>Week</td>
  <td class=xl392><?php echo $tempage = $nrWeeksPassed + 1; $_SESSION['iage'] = $tempage; ?></td>
  <td class=xl393 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl268><?php echo $weekfmort; $_SESSION['ifmort'][$tempage] = $weekfmort; $_SESSION['fmort'][$tempage] = $weekfmort;?></td>
  <td class=xl268><?php echo $weekmmort; $_SESSION['immort'][$tempage] = $weekmmort; $_SESSION['mmort'][$tempage] = $weekmmort; ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl268><?php echo number_format(round(($weekfmort/$weekfemale)*100,3),3); ?></td>
  <td class=xl268><?php echo number_format(round(($weekmmort/$weekmale)*100,3),3); ?></td>
  <td class=xl268><?php echo $weekfcull; $_SESSION['ifcull'][$tempage] = $weekfcull; ?></td>
  <td class=xl268><?php echo $weekmcull; $_SESSION['imcull'][$tempage] = $weekmcull; ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl269><?php echo number_format(round(($weekfcull/$weekfemale)*100,3),3); ?></td>
  <td class=xl269><?php echo number_format(round(($weekmcull/$weekmale)*100,3),3); ?></td>
  <td class=xl268>0</td>
  <td class=xl268>0</td>
  <td class=xl268><?php echo $weekeggs; $_SESSION['ieggs'][$tempage] = $weekeggs; ?></td>
  <td class=xl269><?php echo $tempcomp1 = round((($weekeggs/7)/$weekfemale)*100,2); $_SESSION['hd'][$tempage] = $tempcomp1; ?></td>
  <td class=xl268>&nbsp;</td>
  <td class=xl269><?php echo round($weekeggs/$startfemale,2); ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl268><?php echo $weekhatcheggs; $_SESSION['iheggs'][$tempage] = $weekhatcheggs; ?></td>
  <td class=xl269><?php echo $tempcomp231 = round(($weekhatcheggs/$weekeggs)*100,2); $_SESSION['heper'][$tempage] = $tempcomp231; ?></td>
  <td colspan=2 class=xl268 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl269><?php echo round($weekhatcheggs/$startfemale,2); ?></td>
  <td class=xl268><?php echo $tempcomp5 = round($weekeggwt/7,2); $_SESSION['ieggwt'][$tempage] = $tempcomp5; ?></td>
  <?php for($i = 0; $i < sizeof($rejections); $i++)
  {
  ?>
  <td class=xl268><?php echo $rejqty[$i]; ?></td>
  <td class=xl269><?php echo round(($rejqty[$i]/$weekeggs)*100,2); ?></td>
  <?php } ?>

  <td class=xl268>&nbsp;</td>
  <td class=xl269><?php echo $weekffeed; $_SESSION['iffeed'][$tempage] = $weekffeed; ?></td>
  <td class=xl269><?php echo $weekmfeed; $_SESSION['imfeed'][$tempage] = $weekmfeed; ?></td>
  <td class=xl269><?php echo $temp3 = round($weekffeedg/7,2); $_SESSION['iffeedpb'][$tempage] = $temp3; $cummffeedg = $cummffeedg + $temp3; ?></td>
  <td class=xl269><?php echo $temp4 = round($weekmfeedg/7,2); $_SESSION['imfeedpb'][$tempage] = $temp4; $cummmfeedg = $cummmfeedg + $temp4; ?></td>
  <td class=xl269><?php echo $t1 = $weekffeed + $weekmfeed; ?></td>
  <td class=xl394><?php echo number_format(round($t1/$weekhatcheggs,2),2); ?></td>
  <td class=xl268><?php echo $tempcomp6 = $fweight; $_SESSION['fbweight'][$tempage] = $fweight; $_SESSION['ifbweight'][$tempage] = $fweight; ?></td>
  <td class=xl268><?php echo $tempcomp7 = $mweight; $_SESSION['mbweight'][$tempage] = $mweight; $_SESSION['imbweight'][$tempage] = $mweight; ?></td>
  <td class=xl268 style='mso-ignore:colspan'></td>
  <td class=xl268 style='mso-ignore:colspan;border-right: 1pt solid black'></td>
 </tr>
 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl474 style='height:11.25pt'>Cum</td>
  <td class=xl270>&nbsp;</td>
  <td class=xl271>&nbsp;</td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo $cummfmort; ?></td>
  <td class=xl272><?php echo $cummmmort; ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo $tempcomp = number_format(round(($cummfmort/$startfemale)*100,3),3); $_SESSION['cfmort'][$tempage] = number_format(round(($cummfmort/$startfemale)*100,3),3);  ?></td>
  <td class=xl272><?php echo number_format(round(($cummmmort/$startmale)*100,3),3); $_SESSION['cmmort'][$tempage] = number_format(round(($cummmmort/$startmale)*100,3),3); ?></td>
  <td class=xl272><?php echo $cummfcull; ?></td>
  <td class=xl272><?php echo $cummmcull; ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo number_format(round(($cummfcull/$startfemale)*100,3),3); ?></td>
  <td class=xl272><?php echo number_format(round(($cummmcull/$startmale)*100,3),3); ?></td>
  <td class=xl272>0</td>
  <td class=xl272>0</td>
  <td class=xl272><?php echo $cummeggs; ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl273><?php echo $tempcomp2 = round($cummeggs/$startfemale,2); $_SESSION['eggbird'][$tempage] = $tempcomp2; ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl272><?php echo $cummhatcheggs; ?></td>
  <td class=xl273><?php echo $tempcomp3 = round(($cummhatcheggs/$cummeggs)*100,2); ?></td>
  <td colspan=2 class=xl272 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl273><?php echo $tempcomp4 = round($cummhatcheggs/$startfemale,2);  $_SESSION['hebird'][$tempage] = $tempcomp4;?></td>
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
/*if($client == "JOHNSON")
{*/
  $qb = "SELECT breed FROM turkey_flock WHERE flockcode like '$flockget'";
  $rb = mysql_query($qb,$conn); 
  while($rb1 = mysql_fetch_assoc($rb))  
  {
  $breedi = $rb1['breed'];
  $_SESSION['breedi']= $breedi;
  }
//}

if($breedi != "")
{
$query34 = "SELECT * FROM turkey_standards where client = '$client' and breed = '$breedi' and age = '$tempage' ORDER BY age ASC ";
}
else
{
$query34 = "SELECT * FROM turkey_standards where client = '$client' and age = '$tempage' ORDER BY age ASC ";
}
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdmort = $row134['fcummmort'];
  $hdper = $row134['productionper'];
  $stdeggbird = $row134['cumhhp'];
  $stdheggbird = $row134['cumhhe'];
  $stdheggper = $row134['heggper'];
  $stdeggwt = $row134['eggwt'];
}
if($breedi != "")
{
$query34 = "SELECT * FROM turkey_standards where client = '$client' and breed = '$breedi' and age = '$tempage' ORDER BY age ASC ";
}
else
{
$query34 = "SELECT * FROM turkey_standards where client = '$client' and age = '$tempage' ORDER BY age ASC ";
}


$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $stdfw = $row134['fweight'];
  $stdmw = $row134['mweight'];
}
?>
 <tr height=15 style='height:11.25pt'>
  <td height=15 class=xl475 style='height:11.25pt'>Std</td>
  <td class=xl274>&nbsp;</td>
  <td class=xl275>&nbsp;</td>
  <td colspan=6 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $stdmort;  $_SESSION['cfmortstd'][$tempage] = $stdmort;?></td>
  <td colspan=10 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $hdper; $_SESSION['hdstd'][$tempage] = $hdper;?></td>
  <td class=xl276>&nbsp;</td>
  <td class=xl277><?php echo $stdeggbird; $_SESSION['eggbirdstd'][$tempage] = $stdeggbird;?></td>
  <td colspan=3 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $stdheggper; $_SESSION['heperstd'][$tempage] = $stdheggper; ?></td>
  <td colspan=2 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl277><?php echo $stdheggbird;  $_SESSION['hebirdstd'][$tempage] =  $stdheggbird;?></td>
  <td class=xl276><?php echo $stdeggwt; $_SESSION['ieggwtstd'][$tempage] = $stdeggwt;?></td>
  <td colspan=<?php echo $r * 2; ?> class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276>&nbsp;</td>
  <td colspan=4 class=xl276 style='mso-ignore:colspan'>&nbsp;</td>
  <td colspan=2 class=xl277 style='mso-ignore:colspan'>&nbsp;</td>
  <td class=xl276><?php echo $stdfw; $_SESSION['fbweightstd'][$tempage] = $stdfw;?></td>
  <td class=xl276><?php echo $stdmw; $_SESSION['mbweightstd'][$tempage] = $stdmw;?></td>
  <td class=xl276 style='mso-ignore:colspan'></td>
  <td class=xl276 style='mso-ignore:colspan;border-right: 1pt solid black'></td>
 </tr>
 <tr height=16 style='height:12.0pt'>
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

<?php
   $weekfmort = 0;$weekmmort = 0;
   $weektrfin =0;
  $weektrmin = 0;
  $weektrfout =0;
  $weektrmout = 0;
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

<div style='mso-element:comment-list'><![if !supportAnnotations]>

<hr class=msocomhide align=left size=1 width="33%">

<![endif]>

<div style='mso-element:comment'><![if !supportAnnotations]>

<div id="_com_1" class=msocomtxt
onmouseover="msoCommentShow('_com_1','_anchor_1')"
onmouseout="msoCommentHide('_com_1')" language=JavaScript><![endif]>

<div><![if !supportAnnotations]><a class=msocomhide href="#_msoanchor_1"
name="_msocom_1">[1]</a><![endif]><!--[if gte mso 9]><xml>
 <v:shapetype id="_x0000_t202" coordsize="21600,21600" o:spt="202" path="m,l,21600r21600,l21600,xe">
  <v:stroke joinstyle="miter"/>
  <v:path gradientshapeok="t" o:connecttype="rect"/>
 </v:shapetype><v:shape id="_x0000_s14343" type="#_x0000_t202" style='position:absolute;
  margin-left:606pt;margin-top:-7050.75pt;width:108pt;height:59.25pt;z-index:1;
  visibility:hidden' fillcolor="infoBackground [80]" o:insetmode="auto">
  <v:fill color2="infoBackground [80]"/>
  <v:shadow on="t" color="black" obscured="t"/>
  <v:path o:connecttype="none"/>
  <v:textbox style='mso-direction-alt:auto'/>
  <x:ClientData ObjectType="Note">
   <x:MoveWithCells/>
   <x:SizeWithCells/>
   <x:AutoFill>False</x:AutoFill>
   <x:Row>2</x:Row>
   <x:Column>23</x:Column>
   <x:Author>Ashok kumar</x:Author>
  </x:ClientData>
 </v:shape></xml><![endif]--><![if !vml]><span style='mso-ignore:vglayout'><![endif]>

<div v:shape="_x0000_s14343" style='padding:.75pt 0pt 0pt .75pt;text-align:
left' class=shape><font class="font43">as on 13/09/08 less 24 weak birds</font></div>

<![if !vml]></span><![endif]></div>

<![if !supportAnnotations]></div>

<![endif]></div>

</div>

</body>
<?php } ?>

</html>

