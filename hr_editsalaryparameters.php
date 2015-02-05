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
		$hrafix = $qr['hrafix'];
		$mafix = $qr['mafix'];
		$ccafix = $qr['ccafix'];
		$tafix = $qr['tafix'];
		$sallowancefix = $qr['sallowancefix'];
		$conveyancefix = $qr['conveyancefix'];
		$eallowancefix = $qr['eallowancefix'];
		$oallowancefix = $qr['oallowancefix'];
		$pffix = $qr['pffix'];
		$ptaxfix = $qr['ptaxfix'];
		$incometaxfix = $qr['incometaxfix'];
		$loanfix = $qr['loanfix'];
		$otherfix = $qr['otherfix'];
		}
$date = date("d.m.o");



?>
<center>
<br />

<h1>Salary Parameters</h1>
<br />
<form method="post" action="hr_updatesalaryparameters.php">
<table>
<tr>
<input type="hidden" value="<?php echo $eid;?>" id="eid" name="eid"/>
<input type="hidden" value="<?php echo $salary;?>" id="sal" name="sal"/>
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
<td align="right"><strong>Basic Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"> <input type="radio" id="bper1" name="bfix1" checked="true" onClick="calnet();" /><strong>%</strong>&nbsp;<input type="radio" id="bper2" name="bfix1" onClick="calnet();"/> <strong>Amt</strong>
          <input type="text" size="10" id="bfix2" name="bfix2" onKeyUp="calnet();" value="<?php echo  (($bfix*100)/$salary);?>" style="text-align:right"  />
		  <input type="hidden" name="bfix" id="bfix" value="<?php echo $bfix;?>"/> </td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>HRA</strong>&nbsp;&nbsp;&nbsp;</td><td><input type="text" name="hrafix" size="10" value="<?php echo (($hrafix*100)/$salary);?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>
<tr>
<td align="right"><strong>Medicial Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mafix" size="10" value="<?php echo (($mafix*100)/$salary);?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>City Compensation Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ccafix" size="10" value="<?php echo (($ccafix*100)/$salary);?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>
<tr>
<td align="right"><strong>Travelling Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="tafix" size="10" value="<?php echo (($tafix*100)/$salary);?>"  /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Special Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="sallowancefix" size="10" value="<?php echo (($sallowancefix*100)/$salary);?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>
<tr>
<td align="right"><strong>Conveyance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="conveyancefix" size="10" value="<?php echo (($conveyancefix*100)/$salary);?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Education Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eallowancefix" size="10" value="<?php echo (($eallowancefix*100)/$salary);?>" /><strong>%</strong></td>
</tr>

<tr height="10px"><td></td></tr>
<tr>
<td align="right"><strong>Other Allowance</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="oallowancefix" size="10" value="<?php echo (($oallowancefix*100)/$salary);?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Provident Fund</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pffix" size="10" value="<?php echo $pffix;?>" /></td>
</tr>

<tr height="10px"><td></td></tr>
<tr>
<td align="right"><strong>Professional Tax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ptaxfix" size="10" value="<?php echo $ptaxfix;?>" /></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Income Tax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="incometaxfix" size="10" value="<?php echo (($incometaxfix*100)/$salary);?>" /><strong>%</strong></td></tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Loan Repayments</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="loanfix" size="10" value="<?php echo (($loanfix*100)/$salary);?>" /><strong>%</strong></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Other Deductions</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="otherfix" size="10" value="<?php echo (($otherfix*100)/$salary);?>" /><strong>%</strong></td>
</tr>

</table>
<br>
<br>
<input type="submit" id="update" name="update" value="Update" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_salaryparameters';">



</form>
</center>


<script type="text/javascript">
function calnet()
{
var sal=document.getElementById("sal").value;
if(document.getElementById("bper1").checked)
{
 var basic = (parseFloat(document.getElementById("bfix2").value) / 100) * sal;
}
else
{
 var basic = parseFloat(document.getElementById("bfix2").value);
}
document.getElementById("bfix").value = basic;

}
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