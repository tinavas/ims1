<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Schedule</title>
<style type="text/css">
.but1
{
background-color: #CCCCCC;
border-color:#FFFAE1;

}
.input1 
{
font-weight:bold;
font-size:30px;
cursor:hand;
} 
.weks
{
font-weight:bold;
font-size:15px;
color: #009999;
font-style:oblique;
} 
.fonts
{
font-weight:bold;
font-size:15px;
font-style:italic;
cursor:hand;

} 

.empty{
    width:350px;
    border-collapse:separate;
    empty-cells:hide;
}
.tdempty{
    padding:5px;
    border-style:solid;
    border-width:1px;
    border-color:#999999;
}

</style>
<body>
<center>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br /><br />");
</script>

<?php
include "config.php";
$month = $_GET['month'];
$year = $_GET['year'];
$day = date("l", mktime(0, 0, 0, $month, 01, $year));
$fromdate = $year."-".$month."-01";
$start = "1";
$end = date("t",strtotime($fromdate));	
$todate = $year."-".$month."-".$monthenddate;
$cnt = 1;
$c = 5;?>
<table align="center" width="56%" border="0"  >
<tr>
<?php 
for($f = 0;$f<=7;$f++){
if($f == "1") {$wek = "Sun";}
else if($f == "2") {$wek = "Mon";}
else if($f == "3") {$wek = "Tues";}
else if($f == "4") {$wek = "Wed";}
else if($f == "5") {$wek = "Thurs";}
else if($f == "6") {$wek = "Fri";}
else if($f == "7") {$wek = "Sat";}
?><td width="150px"></td>
<td style="border:0; width:5px;" align="left"><a href="#"><input type="button" align="left" name="id" class="weks" id="id" value="<?php echo $wek;?>" style="background:none;border:0;"  /></a></td><td></td><?php } ?>
</tr>
</table>

<table align="center" border="0" cols="7" height="600" >
<?php
if($day == "Sunday") {$gap == "0";} 
else if($day == "Monday") {$gap = "1";}
else if($day == "Tuesday") {$gap = "2";}
else if($day == "Wednesday") {$gap = "3";}
else if($day == "Thursday") {$gap = "4";}
else if($day == "Friday") {$gap = "5";}
else if($day == "Saturday") {$gap = "6";}
for ($i = $start; $i<= $c ; $i++)
{ ?>
<tr>
<td>
<table align="left">
<tr>
<td class="weks"><?php echo $i; if($i == "1") { ?><sup>st</sup>Week
<?php } else if($i == "2") { ?><sup>nd</sup>Week
<?php } else if($i == "3") { ?><sup>rd</sup>Week
<?php } else { ?><sup>th</sup>Week <?php } ?>
</td>
</tr>
</table>
</td>
<td>

<?php 

$x = 1;
for($y = $x; $y<= $x+6; $y++) { if($cnt <= $end) {?>
<table align="left" cellpadding="0" cellspacing="0" >
<tr>
<?php if(($i== "1") && ($gap > 0)){ ?>
<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php }  else { ?></tr></table>
<table align="left" width="5" border="5" height="75" cols="7" height="600" cellpadding="0" cellspacing="0" style="background-color:  #D6F7B5;">
<tr>
<td style="border:0"><input type="button" class="input1" name="id" id="id" value="<?php if($cnt < "10") { echo "0".$cnt; } else { echo $cnt;}?>" style="background:none;border:0; color: #009999"  /></td>

<?php $cnt = $cnt + 1; } ?>
</tr>
<tr>
<?php 
$fromdate = $year."-".$month."-".$cnt;
$q = "select * from hr_scheduling where scheduleddate = '$fromdate' and client = '$client'";
$r = mysql_query($q,$conn1);
$qr = mysql_fetch_assoc($r);
?>
<?php if(($i== "1") && ($gap > 0)){ ?>
<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?php $gap--;}  else { ?>
   <td style="border:0"><a href="#"><textarea rows="3" cols="5" style="border: 0; overflow: auto; color:#999999;" class="fonts" name="remarks[]" readonly="readonly"><?php echo $qr['subject'];?></textarea></a></td><?php } ?>
</tr>

</table><?php } }?>
</td>
</tr>
<?php } ?>
</table>
	
	

