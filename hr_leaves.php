<?php include "jquery.php"; ?>
<br /><br />
<form action="hr_saveleaves.php" method="POST" id="form1" name="form1">

<table align="center">
<tr>
<td>
<strong>Single Day&nbsp;&nbsp;</strong>
</td>
<td>
<input type="radio" name="day" id="singleday" onclick="daysselect()"/>&nbsp;&nbsp;&nbsp;
</td>

<td>
<strong>Multiple Days&nbsp;</strong>
</td>
<td>
<input type="radio" name="day" id="multipledays" onclick="daysselect()"/>
</td>
</tr>
</table>
<br /><br /><br /><br />
<!-- SINGLE DATE -->
<center>
<div id="single" name="single" style="visibility:hidden; position:absolute" align="center">
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
<table align="center" id="singletable">
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="center"> <strong>DATE</strong> </td><td></td>
<td align="center"> <strong>REASON </strong></td><td></td>
<td align="center"> <strong>Approved Date </strong></td><td></td>
<td align="center"> <strong>Approved By </strong></td>
</tr>
<tr height="2"></tr><tr></tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="10" value="<?php echo date('d.m.Y') ?>" name="date1" id="date1" class="datepicker"onchange="datecompsingle();" />
</td>
<td style="visibility:hidden">
<img src="calender.gif" title="Calender" onClick="displayCalendar(document.forms[0].date1,'dd.mm.yyyy',this)" />
</td>

<td>
<textarea id="reason1" name="reason1" value="" cols="25"></textarea>
</td>
<td></td>
<td>
<input type="text" size="10" value="<?php echo date('d.m.Y') ?>" name="date4" id="date4" class="datepicker"/></td>
<td style="visibility:hidden">
<img src="calender.gif" title="Calender" onClick="displayCalendar(document.forms[0].date4,'dd.mm.yyyy',this)" />
</td>
<td>
<select id="approver" name="approver">
<?php 
include "config.php";
$qa1 = "select * from hr_employee WHERE employeeid='$_GET[id]'";
$qars1 = mysql_query($qa1,$conn) or die(mysql_error());
if($qar1 = mysql_fetch_assoc($qars1)) { $designation = $qar1['designation']; }
if($designation <> 'Manager')
{
$qa = "select * from hr_employee WHERE employeeid='$_GET[id]'";
$qars = mysql_query($qa,$conn) or die(mysql_error());
while($qar = mysql_fetch_assoc($qars))
{
?>
<option value="<?php echo $qar['reportingto']; ?>"><?php echo $qar['reportingto']; ?></option>
<?php } }
else
{
$qa = "select * from hr_directors";
$qars = mysql_query($qa,$conn) or die(mysql_error());
while($qar = mysql_fetch_assoc($qars))
{
?>
<option value="<?php echo $qar['director']; ?>"><?php echo $qar['director']; ?></option>
<?php } } ?>
</select>
</td>

</tr>
</table>
</div>
</center>

<!-- MULTIPLE DATES -->
<div id="multiple" name="multiple" style="align:center;visibility:hidden; position:absolute" align="center">
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" id="sm" name="sm" value="" />
<table align="center" id="multipletable">
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td align="center"> <strong>FROM DATE</strong> </td><td></td>
<td align="center"> <strong>TO DATE </strong></td> 
<td align="center"> </td> 
<td align="center"> <strong>REASON </strong></td>
<td align="center"> <strong>Approved Date </strong></td><td></td>
<td align="center"> <strong>Approved By </strong></td>
</tr>
<tr height="2"></tr><tr></tr>
<tr>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

<td>
<input type="text"size="10"  value="<?php echo date('d.m.Y') ?>" name="date2" id="date2" class="datepicker" onchange="datecompmultiple1()">
</td>
<td style="visibility:hidden">
<img src="calender.gif" title="Calender" onClick="displayCalendar(document.forms[0].date2,'dd.mm.yyyy',this)" />
</td>
<td>
<input type="text" size="10" value="<?php echo date('d.m.Y') ?>" name="date3" id="date3" class="datepicker" onchange="datecompmultiple2()">
</td>
<td style="visibility:hidden">
<img src="calender.gif" title="Calender" onClick="displayCalendar(document.forms[0].date3,'dd.mm.yyyy',this)" />
</td>
<td>
<textarea id="reason2" name="reason2" value="" cols="20"></textarea>
</td>
<td>
<input type="text" size="10" value="<?php echo date('d.m.Y') ?>" name="date5" id="date5" class="datepicker"/>
</td>
<td style="visibility:hidden">
<img src="calender.gif" title="Calender" onClick="displayCalendar(document.forms[0].date5,'dd.mm.yyyy',this)" />
</td>
<td>
<select id="approver1" name="approver1">
<?php 
include "config.php";
include "config.php";
$qa1 = "select * from hr_employee WHERE employeeid='$_GET[id]'";
$qars1 = mysql_query($qa1,$conn) or die(mysql_error());
if($qar1 = mysql_fetch_assoc($qars1)) { $designation = $qar1['designation']; }
if($designation <> 'Manager')
{
$qa = "select * from hr_employee WHERE employeeid='$_GET[id]'";
$qars = mysql_query($qa,$conn) or die(mysql_error());
while($qar = mysql_fetch_assoc($qars))
{
?>
<option value="<?php echo $qar['reportingto']; ?>"><?php echo $qar['reportingto']; ?></option>
<?php } }
else
{
$qa = "select * from hr_directors";
$qars = mysql_query($qa,$conn) or die(mysql_error());
while($qar = mysql_fetch_assoc($qars))
{
?>
<option value="<?php echo $qar['director']; ?>"><?php echo $qar['director']; ?></option>
<?php } } ?>
</select>
</td>

</tr>
<tr>
</tr>
</table>
</div>
<br /><br /><br /><br /><br /><br />
<table align="center">
<tr>
<td>
<input type="submit" value="Submit" onclick="validate();"/>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_employee';">

</td>
</tr>
</table>
<input type="hidden" value="" id="diff" name="diff"/>
</form>


<script type="text/javascript">
function daysselect()
{
if(document.getElementById('singleday').checked == true)
{
document.getElementById('single').style.visibility = 'visible';
document.getElementById('multiple').style.visibility = 'hidden';
document.getElementById('sm').value = 's';
}
else if(document.getElementById('multipledays').checked == true)
{
document.getElementById('single').style.visibility = 'hidden';
document.getElementById('multiple').style.visibility = 'visible';
document.getElementById('sm').value = 'm';
}
}

function datecompsingle()
{
var i = 0;
t = document.getElementById('date1').value;
<?php
     include "config.php";
     $q2=mysql_query("select * from holidays ORDER BY date ASC ");
     while($nt2=mysql_fetch_array($q2)){
     echo "if(t == '$nt2[dumpdate]') {";
     echo "i = i + 1;"; 
      echo "}"; // end of JS if condition
     }
?>

if(i > 0)
{
alert("The day you have selected is holiday");
document.getElementById("date1").value = "";
}

dd = document.getElementById('date1').value;
temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
temp1 = new Date(temp);
temp10 = new Date();
newday = temp10.getDate();
newmonth = temp10.getMonth() + 1;
newyear = temp10.getYear();
temp12 = newmonth + '/' + newday + '/' + newyear;
temp2 = new Date(temp12);

if(temp1<temp2)
alert('You have entered wrong date');


}

function datecompmultiple1()
{
dd = document.getElementById('date2').value;
temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
temp1 = new Date(temp);
temp10 = new Date();
newday = temp10.getDate();
newmonth = temp10.getMonth() + 1;
newyear = temp10.getYear();
temp12 = newmonth + '/' + newday + '/' + newyear;
temp2 = new Date(temp12);

if(temp1<temp2)
alert('You have entered wrong date');


}

function datecompmultiple2()
{

dd = document.getElementById('date2').value;
temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
temp1 = new Date(temp);

dd1 = document.getElementById('date3').value;
temp3 =  dd1.split('.');
temp3 = temp3[1] + '/' + temp3[0] + '/' + temp3[2];
temp3 = new Date(temp3);
diff = temp3 - temp1;

document.getElementById('diff').value = ((diff/86400000) + 1);

if(temp1 >=temp3)
alert('You have entered wrong dates');

}

</script>

<script type="text/javascript">
function script1() {
window.open('HRHELP/help_m_addleave.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>