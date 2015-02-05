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

$date = date("d.m.o");

if(!isset($_GET['fdate']))
$fdate = date("d.m.o");
else
$fdate = $_GET['fdate'];

if(!isset($_GET['tdate']))
$tdate = date("d.m.o");
else
$tdate = $_GET['tdate'];

?>
<center>
<br />

<h1>Salary Parameters</h1>
<br />
<form method="post" action="hr_savesalaryparameters_feedatives.php">
<table>
<tr>
<td align="right"><strong>From Date</strong>&nbsp;&nbsp;</td>
<td align="left">
<input type="text" value="<?php echo $fdate; ?>" size="12" readonly  class="datepicker" name="fdate" id="fdate">
</td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>To Date</strong>&nbsp;&nbsp;</td>
<td width="10px">&nbsp;</td>
<td align="left">
<input type="text" value="<?php echo $tdate; ?>" size="12" readonly  class="datepicker" name="tdate" id="tdate">
</td>

<td width="10px">&nbsp;</td>

<td align="right"><strong>Sector</strong>&nbsp;&nbsp;</td>
<td align="left">
<select id ="sector" name="sector" onChange="">
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
<?php /*?>
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
</td><?php */?>
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
<td align="right"><strong>Basic Allowance (Incl. D.A.)</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="bfix" size="10" value="55" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Company Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="cmpfix" size="10" value="12.5" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>HRA</strong>&nbsp;&nbsp;&nbsp;</td><td align="left"><input type="text" name="hrafix" size="10" value="17.5" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Transportation Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="tafix" size="10" value="7.5"  /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Kit Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="kitfix" size="10" value="0"  /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Dress Main/Wash  Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="dresfix" size="10" value="7.5" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>ESIC</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="esicfix" size="10" value="1.75" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Provident Fund</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pffix" size="10" value="12" /><strong>%</strong></td>
</tr>


<tr height="10px"><td></td></tr>


</table>
<br>
<br>
<input type="submit" id="update" name="update" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salaryparameters_feedatives';">
<?php }
else
{
?>


<table>

<tr>
<td align="right"><strong>Basic Allowance (Incl. D.A.)</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="bfix" size="10" value="55" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Company Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="cmpfix" size="10" value="12.5" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>HRA</strong>&nbsp;&nbsp;&nbsp;</td><td align="left"><input type="text" name="hrafix" size="10" value="17.5" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Transportation Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="tafix" size="10" value="7.5"  /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Kit Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="kitfix" size="10" value="0"  /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Dress Main/Wash  Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="dresfix" size="10" value="7.5" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>ESIC</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="esicfix" size="10" value="1.75" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Provident Fund</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pffix" size="10" value="12" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>



</table>
<br>
<br>
<input type="submit" id="update" name="update" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salaryparameters_feedatives';">
<?php } ?>

</form>
</center>

<script type="text/javascript">
function fun1()
{
	var sector = document.getElementById('sector').value;
	var name = "";
	var fdate = document.getElementById('fdate').value;
	var tdate = document.getElementById('tdate').value;
	document.location = "dashboardsub.php?page=hr_addsalaryparameters_feedatives&sector=" + sector + "&name=" + name + "&fdate=" + fdate + "&tdate=" + tdate;
}

function fun2()
{
	var sector = document.getElementById('sector').value;
	var name = document.getElementById('ename').value;
	var fdate = document.getElementById('fdate').value;
	var tdate = document.getElementById('tdate').value;
	document.location = "dashboardsub.php?page=hr_addsalaryparameters_feedatives&sector=" + sector + "&name=" + name + "&fdate=" + fdate  + "&tdate=" + tdate;
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