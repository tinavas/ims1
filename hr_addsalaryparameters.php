<?php 
	include "jquery.php";
	include "config.php";

if(!isset($_GET['sector']))
$sector = "";
else
$sector = $_GET['sector'];

if(!isset($_GET['name']))
$name = "";
else
$name = $_GET['name'];

if(!isset($_GET['date']))
$date = date("d.m.o");
else
$date = $_GET['date'];

?>
<center>
<br />

<h1>Salary Parameters</h1>
<br />
<form method="post" action="hr_savesalaryparameters.php">
<table>
<tr>
<td align="right"><strong>Date</strong>&nbsp;&nbsp;</td>
<td align="left">
<input type="text" value="<?php echo $date; ?>" size="12" readonly  class="datepicker" name="date1" id="date1">
</td>

<td width="10px">&nbsp;</td>

<td align="right"><strong>Sector</strong>&nbsp;&nbsp;</td>
<td align="left">
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

<td width="10px">&nbsp;</td>

<td align="right"><strong>Employee Name</strong>&nbsp;&nbsp;</td>
<td align="left">
<select id ="ename" name="ename" onChange="fun2();">
<option>-Select-</option>
<?php
$query = "SELECT distinct(name) FROM hr_employee where sector = '$sector' ORDER BY name ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $row['name'];?>" <?php if($name == $row['name']) {?> selected="selected" <?php } ?>><?php echo $row['name']; ?></option>
<?php } ?>

</select>
</td>
</tr>
</table>
<br>
<br>

<?php 
  include "config.php";
  $query1 = "SELECT * FROM hr_salaryparameters where sector = '$sector' and name = '$name'";
  $result1 = mysql_query($query1,$conn);
  if($row1 = mysql_fetch_assoc($result1))
  {
?>

<table>

<tr>
<td align="right"><strong>Basic Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="bfix" size="10" value="50" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>HRA</strong></td><td><input type="text" name="hrafix" size="10" value="15" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Medicial Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mafix" size="10" value="18" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>City Compensation Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ccafix" size="10" value="5" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Travelling Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="tafix" size="10" value="12"  /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Special Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="sallowancefix" size="10" value="<?php echo (($row1['sallowancefix']*100)/$row1['salary']); ?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Conveyance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="conveyancefix" size="10" value="<?php echo (($row1['conveyancefix']*100)/$row1['salary']); ?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Education Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eallowancefix" size="10" value="<?php echo (($row1['eallowancefix']*100)/$row1['salary']); ?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Other Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="oallowancefix" size="10" value="<?php echo (($row1['oallowancefix']*100)/$row1['salary']); ?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Provident Fund</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pffix" size="10" value="<?php echo $row1['pffix']; ?>" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Professional Tax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ptaxfix" size="10" value="
<?php
	if($row1['salary'] < 10000)
	echo 0;
	else 
	if(($row1['salary'] >10000) && ($row1['salary'] <15000)) 
	echo 150;
	else
	echo 200;
?>" /></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Income Tax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="incometaxfix" size="10" value="<?php echo (($row1['incometaxfix']*100)/$row1['salary']); ?>" /><strong>%</strong></td></tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Loan Repayments</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="loanfix" size="10" value="<?php echo (($row1['loanfix']*100)/$row1['salary']); ?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Other Deductions</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="otherfix" size="10" value="<?php echo (($row1['otherfix']*100)/$row1['salary']); ?>" /><strong>%</strong></td>
</tr>

</table>
<br>
<br>
<input type="submit" id="update" name="update" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salaryparameters';">
<?php }
else
{
?>

<table>

<tr>
<td align="right"><strong>Basic Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="bfix" size="10" value="50" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>HRA</strong></td><td><input type="text" name="hrafix" size="10" value="15" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Medicial Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mafix" size="10" value="18" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>City Compensation Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ccafix" size="10" value="5" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Travelling Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="tafix" size="10" value="12"  /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Special Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="sallowancefix" size="10" value="0" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Conveyance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="conveyancefix" size="10" value="0" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Education Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eallowancefix" size="10" value="0" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Other Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="oallowancefix" size="10" value="0" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Provident Fund</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pffix" size="10" value="0" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Professional Tax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ptaxfix" size="10" value="0" /></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Income Tax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="incometaxfix" size="10" value="0" /><strong>%</strong></td></tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Loan Repayments</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="loanfix" size="10" value="0" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Other Deductions</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="otherfix" size="10" value="0" /><strong>%</strong></td>
</tr>

</table>
<br>
<br>
<input type="submit" id="update" name="update" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salaryparameters';">
<?php } ?>

</form>
</center>

<script type="text/javascript">
function fun1()
{
	var sector = document.getElementById('sector').value;
	var name = "";
	var date = document.getElementById('date1').value;
	document.location = "dashboardsub.php?page=hr_addsalaryparameters&sector=" + sector + "&name=" + name + "&date=" + date;
}

function fun2()
{
	var sector = document.getElementById('sector').value;
	var name = document.getElementById('ename').value;
	var date = document.getElementById('date1').value;
	document.location = "dashboardsub.php?page=hr_addsalaryparameters&sector=" + sector + "&name=" + name + "&date=" + date;
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