<?php 
	include "jquery.php";
	include "config.php";


$sector = $_GET['sector'];
$name = $_GET['name'];
$id = $_GET['id'];
$eid = $_GET['eid'];

$salquery = "select salary from hr_employee where employeeid = '$eid'";
$salrs = mysql_query($salquery);
while($r = mysql_fetch_assoc($salrs))
{
$salary = $r['salary'];
}
		$q = "select * from hr_salaryparameters where id = '$id'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		$bfix = $qr['bfix'];
		$compallowance = $qr['compallowance'];
		$hrafix = $qr['hrafix'];
		$tafix = $qr['tafix'];
		$kitallowance  = $qr['kitallowance'];
		$dressmaintain = $qr['dressmaintain'];
		$travelexpense = $qr['travelexpense'];
		$pffix = $qr['pffix'];
		$ptaxfix = $qr['ptaxfix'];
		$esic = $qr['esic'];
		$fdate = $qr['fromdate'];
		$tdate = $qr['todate'];
		}
$date = date("d.m.o");



?>
<center>
<br />

<h1>Salary Parameters</h1>
<br />
<form method="post" action="hr_updatesalaryparameters_feedatives.php">
<table>
<tr>
<td align="right"><strong>From Date</strong>&nbsp;&nbsp;</td>
<td align="left">
<input type="hidden" id="id" name="id" value="<?php echo $id ; ?>" />
<input type="hidden" id="eid" name="eid" value="<?php echo $eid ; ?>" />
<input type="hidden" id="salary" name="salary" value="<?php echo $salary ; ?>" />
<input type="text" value="<?php echo $fdate; ?>" size="12" readonly  class="datepicker" name="fdate" id="fdate">
</td>
<td align="right"><strong>To Date</strong>&nbsp;&nbsp;</td>
<td width="10px">&nbsp;</td>
<td align="left">
<input type="text" value="<?php echo $tdate; ?>" size="12" readonly  class="datepicker" name="tdate" id="tdate">
</td>

<td width="10px">&nbsp;</td>

<td align="right"><strong>Sector</strong>&nbsp;&nbsp;</td>
<td align="left">
<input type="text" id ="sector" name="sector"  value="<?php echo $sector; ?>" size="25" readonly />

</td>

<td width="10px">&nbsp;</td>

<td align="right"><strong>Employee Name</strong>&nbsp;&nbsp;</td>
<td align="left">
<input type="text" id ="ename" name="ename"  value="<?php echo $name; ?>" size="25" readonly />
</td>
</tr>
</table>
<br>
<br>



<table>
<tr>
<td align="right"><strong>Basic Allowance (Incl. D.A.)</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="bfix" size="10" value="<?php echo  (($bfix*100)/$salary);?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Company Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="cmpfix" size="10" value="<?php echo (($compallowance*100)/$salary);?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>HRA</strong>&nbsp;&nbsp;&nbsp;</td><td align="left"><input type="text" name="hrafix" size="10" value="<?php echo (($hrafix*100)/$salary);?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Transportation Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="tafix" size="10" value="<?php echo (($tafix*100)/$salary);?>"  /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Kit Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="kitfix" size="10" value="<?php echo (($kitallowance*100)/$salary);?>"  /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Dress Main/Wash  Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="dresfix" size="10" value="<?php echo (($dressmaintain*100)/$salary);?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Travel Expenses</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="travexp" size="10" value="<?php echo (($travelexpense*100)/$salary);?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Provident Fund</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pffix" size="10" value="<?php echo (($pffix*100)/$bfix);?>" /><strong>%</strong></td>
</tr>
 <?php /*?>(($pffix*100)/$basic)<?php */?>
<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Professional Tax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ptaxfix" size="10" value="<?php echo $ptaxfix;?>" /></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>ESIC</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="esicfix" size="10" value="<?php echo (($esic*100)/$salary);?>" /><strong>%</strong></td></tr>

<tr height="10px"><td></td></tr>


</table>
<br>
<br>
<input type="submit" id="update" name="update" value="Update" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salaryparameters_feedatives';">



</form>
</center>


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