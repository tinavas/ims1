<?php session_start(); $flock = $_SESSION['flockcode']; ?>
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
<![if !supportTabStrip]><script language="JavaScript">
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
 
 $query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate";
$result1 = mysql_query($query1,$conn); 
$tcount = mysql_num_rows($result1);

if($tcount > 1)
{
 $query1fd = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' order by startdate asc limit 1";
 $result1fd = mysql_query($query1fd,$conn); 
  while($row2fd = mysql_fetch_assoc($result1fd))  
  {
     /* $startdate1 = $row11['startdate'];
      $age1 = $row11['age'];
      $startfemale = $row11['femaleopening'];
      $startmale = $row11['maleopening'];*/
	   $startdate1 = $row2fd['startdate'];
      $age1 = $row2fd['age'];
      $startfemale = $row2fd['femaleopening'];
      $startmale = $row2fd['maleopening'];
  }
}
else
{
  $query1fd = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget'";
  $result1fd = mysql_query($query1fd,$conn); 
  while($row2fd = mysql_fetch_assoc($result1fd))  
  {
    /*  $startdate1 = $row11['startdate'];
      $age1 = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      $startmale = $startmale + $row11['maleopening'];*/
	    $startdate1 = $row2fd['startdate'];
      $age1 = $row2fd['age'];
      $startfemale = $startfemale + $row2fd['femaleopening'];
      $startmale = $startmale + $row2fd['maleopening'];
  }
}


 $query1 = "SELECT distinct(age) as 'age' FROM breeder_vacschedule where flock is null or flock = '' or flock like '%$flock'  ORDER BY age ASC ";
 $result1 = mysql_query($query1,$conn);
 while($row2 = mysql_fetch_assoc($result1))
 {
       $vaccode = "";
       $query1w = "SELECT * FROM breeder_vacschedule where age = '$row2[age]' and (flock is null or flock = '' or flock like '%$flock') ORDER BY age ASC ";
       $result1w = mysql_query($query1w,$conn);
       while($row2w = mysql_fetch_assoc($result1w))
       {
          $vaccode = $vaccode . '+' . $row2w['vaccode'];
       }
       $vaccode = substr($vaccode,1);

       $vacdesc = "";
       $query1w = "SELECT * FROM breeder_vacschedule where age = '$row2[age]' and (flock is null or flock = '' or flock like '%$flock') ORDER BY age ASC ";
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

</body>

</html>
