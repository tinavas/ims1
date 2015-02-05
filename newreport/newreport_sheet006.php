<?php 
$start_process = (float) array_sum(explode(' ',microtime()));
session_start(); $flock = $_SESSION['flock']; ?>
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
   parent.fnSetActiveSheet(4);
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

<body link=blue vlink=purple class=xl184>
<center><div id="loadingimg" >
<table>
<tr >
<td valign="bottom"><img src="../images/mask-loader.gif" align="bottom"/></td><td valign="top" align="center" style="text-align:center">(Please wait report is loading)</td>
</tr>
</table>
</div></center>
<center>
<table border=1 cellpadding=0 cellspacing=0 width="803px">

 <tr height=21 style='height:15.75pt'>
  <td colspan=5 height=21 style='border:.5pt solid black;
  height:15.75pt'><center><b>VACCINE SCHEDULE ---BREEDER FLOCK</b></center></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td colspan=5 height=21 style='border:.5pt solid black;
  height:15.75pt'><center><b>FLOCK : <?php echo $flock; ?></b></center></td>
 </tr>

 <tr height=32>
  <td style='border:.5pt solid black;'><center><b>Sl. No.</b></center></td>
  <td style='border:.5pt solid black;'><center><b>Age (Days)</b></center></td>
  <td style='border:.5pt solid black;'><center><b>Schedule Date</b></center></td>
  <td style='border:.5pt solid black;'><center><b>V.Code</b></center></td>
  <td style='border:.5pt solid black;'><center><b>Vaccine</b></center></td>
 </tr>
<?php
 $i = 1;
 include "../config.php";

$query1fd = "SELECT * FROM breeder_flock where flockcode = '$flock'";
$result1fd = mysql_query($query1fd,$conn);
while($row2fd = mysql_fetch_assoc($result1fd))
{
          $age1 = $row2fd['age'];
          $startdate1 = $row2fd['startdate'];
}

 $query1 = "SELECT distinct(age) as 'age' FROM breeder_vacschedule where flock is null or flock = '' or flock = '$flock' ORDER BY age ASC ";
 $result1 = mysql_query($query1,$conn);
 while($row2 = mysql_fetch_assoc($result1))
 {
       $vaccode = "";
       $query1w = "SELECT * FROM breeder_vacschedule where age = '$row2[age]' and (flock is null or flock = '' or flock = '$flock') ORDER BY age ASC ";
       $result1w = mysql_query($query1w,$conn);
       while($row2w = mysql_fetch_assoc($result1w))
       {
          $vaccode = $vaccode . '+' . $row2w['vaccode'];
       }
       $vaccode = substr($vaccode,1);

       $vacdesc = "";
       $query1w = "SELECT * FROM breeder_vacschedule where age = '$row2[age]' and (flock is null or flock = '' or flock = '$flock') ORDER BY age ASC ";
       $result1w = mysql_query($query1w,$conn);
       while($row2w = mysql_fetch_assoc($result1w))
       {
         $query11 = "SELECT * FROM ims_itemcodes where code = '$row2w[vaccode]'";
         $result11 = mysql_query($query11,$conn);
         while($row21 = mysql_fetch_assoc($result11))
         {
           $vacdesc = $vacdesc . '+' . $row21['description'] . ' ';
         }
       }
       $vacdesc = substr($vacdesc,1);


       $d = strtotime($startdate1);
       $e = $age1 * 24 * 60 * 60;
       $d = $d - $e;
       $date = date('j-m-Y',$d);
       $f = $row2['age'] * 24 * 60 * 60;
       $d = $d + $f; 
       $date = date('d-m-Y',$d);
?>
  <tr height=24>
  <td style='border:.5pt solid black;'> &nbsp;<?php echo $i; ?></td>
  <td style='border:.5pt solid black;'> &nbsp;<?php echo $row2['age']; ?></td>
  <td style='border:.5pt solid black;'> &nbsp;<?php echo $date; ?></td>
  <td style='border:.5pt solid black;'> &nbsp;<?php echo $vaccode; ?></td>
  <td style='border:.5pt solid black;'> &nbsp;<?php echo $vacdesc; ?></td>
 </tr>
<?php $i = $i + 1; } ?>
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