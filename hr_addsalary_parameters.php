<?php 
	include "jquery.php";
	include "config.php";

if(!isset($_GET['sector']))
$sector = "";
else
$sector = $_GET['sector'];

if(!isset($_GET['designation']))
$designation = "";
else
$designation = $_GET['designation'];

$date = date("d.m.o");

if(!isset($_GET['fdate']))
$fdate = date("d.m.o");
else
$fdate = $_GET['fdate'];

if(!isset($_GET['tdate']))
$tdate = date("d.m.o");
else
$tdate = $_GET['tdate'];



$countpf = 0;
$query33 = "SELECT count(*) as c1 FROM hr_pf";
$result33 = mysql_query($query33,$conn);
while($row33 = mysql_fetch_assoc($result33))
{ 
$countpf = $row33['c1'];
}

?>
<center>
<br />

<h1>Salary Parameters</h1>
<br />
<form method="post" action="hr_savesalary_parameters.php" onsubmit="return checkpf();">
<table>
<input type="hidden" name="countpf" id="countpf" value="<?php echo $countpf;?>"/>
<tr>
<td width="80" align="right"><strong>From Date</strong>&nbsp;&nbsp;</td>
<td width="72" align="left">
<input type="text" value="<?php echo $fdate; ?>" size="12" readonly  class="datepicker" name="fdate" id="fdate">
</td>
<td width="10">&nbsp;</td>
<td width="63" align="right"><strong>To Date</strong>&nbsp;&nbsp;</td>
<td width="10">&nbsp;</td>
<td width="74" align="left">
<input type="text" value="<?php echo $tdate; ?>" size="12" readonly  class="datepicker" name="tdate" id="tdate">
</td>

<td width="10">&nbsp;</td>

<td width="51" align="right"><strong>Sector</strong>&nbsp;&nbsp;</td>
<td width="83" align="left">
<select id ="sector" name="sector" onChange="fun1();">
<option>-Select-</option>
<?php
$query = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $row['sector'];?>" <?php if($sector == $row['sector']) {?> selected="selected" <?php } ?>><?php echo $row['sector']; ?></option>
<?php } ?>
</select>
</td>

<td width="10">&nbsp;</td>

<td width="88" align="right"><strong>Designation</strong>&nbsp;&nbsp;</td>
<td width="83" align="left">
<select id ="desig" name="desig" onChange="">
<option>-Select-</option>
<?php
$query = "SELECT distinct(designation) FROM hr_employee where sector = '$sector' ORDER BY designation ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $row['designation'];?>" <?php if($designation == $row['designation']) {?> selected="selected" <?php } ?>><?php echo $row['designation']; ?></option>
<?php } ?>

</select>
</td>
</tr>
</table>
<br>
<br>
<table>

<?php 
$inc = 0;
  include "config.php";
  $query1 = "SELECT * FROM hr_params order by description";
  $result1 = mysql_query($query1,$conn);
  while($row1 = mysql_fetch_assoc($result1))
  {
if($inc%2 == 0)
{ ?>
<tr>
<?php } ?>
<td align="right"><strong><?php echo $row1['description']; ?></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="<?php echo $row1['code']; ?>" id="<?php echo $row1['code']; ?>" size="10" value="<?php echo $row1['defaultval']; ?>" /><strong><?php if($row1['unit'] == "Per") { ?>%<?php } ?></strong></td>
<?php 
$inc = $inc + 1;
if($inc%2 == 0)
{?>
</tr>
<tr height="10px"><td></td></tr>
<?php
}
else
{
?>
<td width="10px">&nbsp;</td>
<?php } ?>
<?php } ?>
</table>
<br>
<br>
<input type="submit" id="update" name="update" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salary_parameters';">


</form>
</center>

<script type="text/javascript">


function fun1()
{
	var sector = document.getElementById('sector').value;
	var designation = "";
	var fdate = document.getElementById('fdate').value;
	var tdate = document.getElementById('tdate').value;
	document.location = "dashboardsub.php?page=hr_addsalary_parameters&sector=" + sector + "&designation=" + designation + "&fdate=" + fdate + "&tdate=" + tdate;
}

function fun2()
{
	var sector = document.getElementById('sector').value;
	var designation = document.getElementById('desig').value;
	var fdate = document.getElementById('fdate').value;
	var tdate = document.getElementById('tdate').value;
	document.location = "dashboardsub.php?page=hr_addsalary_parameters&sector=" + sector + "&designation=" + designation + "&fdate=" + fdate  + "&tdate=" + tdate;
}

function checkpf()
{

var frmdate = document.getElementById('fdate').value;
var tdate = document.getElementById('tdate').value;
var dt1  = parseInt(frmdate.substring(0,2),10); 
var mon1 = parseInt(frmdate.substring(3,5),10);
var yr1  = parseInt(frmdate.substring(6,10),10); 
var dt2  = parseInt(tdate.substring(0,2),10); 
var mon2 = parseInt(tdate.substring(3,5),10); 
var yr2  = parseInt(tdate.substring(6,10),10); 
var date1 = new Date(yr1, mon1, dt1); 
var date2 = new Date(yr2, mon2, dt2); 

var cntpf = document.getElementById('countpf').value;
if(frmdate == tdate)
{
alert("To Date should be greater than From Date.");
document.getElementById('fdate').focus();
return false;
}
else if(date2 < date1)
{
alert("To Date should be greater than From Date.");
document.getElementById('tdate').focus();
return false;
}
else if(cntpf == 0)
{
alert("You have not entered any values for Professional Tax. If you do not enter values for Professional Tax automatically it will be taken as 0 .");
if(confirm('Do you want to add values for Professional Tax.'))
{
document.location='dashboardsub.php?page=hr_addpf';
return false;
}
else
{
return true;
}
}
else
{
return true;
}
}

</script>
<script type="text/javascript">
function script1() {
window.open('HRHELP/hr_m_addsalaryparamerts.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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