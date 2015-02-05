<?php 

	include "jquery.php";

	include "config.php";





$sector = $_GET['sector'];

$desig = $_GET['desig'];

$fdate = $_GET['fdate'];

$tdate = $_GET['tdate'];

$name = $_GET['name'];

$id = $_GET['id'];

$eid = $_GET['eid'];



$salquery = "select salary from hr_employee where employeeid = '$eid'";

$salrs = mysql_query($salquery,$conn);

while($r = mysql_fetch_assoc($salrs))

{

$salary = $r['salary'];

}

		

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

<form method="post" action="hr_updatesalary_parameters.php"  onsubmit="return checkpf();">

<table>

<tr>

<input type="hidden" id="id" name="id" value="<?php echo $id ; ?>" />

<input type="hidden" id="eid" name="eid" value="<?php echo $eid ; ?>" />

<input type="hidden" id="salary" name="salary" value="<?php echo $salary ; ?>" />

<input type="hidden" name="countpf" id="countpf" value="<?php echo $countpf;?>"/>

<td align="right"><strong>From Date</strong>&nbsp;&nbsp;</td>

<td align="left">

<input type="text" value="<?php echo date("d.m.o",strtotime($fdate)); ?>" size="10" readonly  class="datepicker" name="fdate" id="fdate">

</td>

&nbsp;

<td align="right"><strong>To Date</strong>&nbsp;&nbsp;</td>

<td align="left">

<input type="text" value="<?php echo date("d.m.o",strtotime($tdate)); ?>" size="10" readonly  class="datepicker" name="tdate" id="tdate">

</td>



&nbsp;



<td align="right"><strong>Sector</strong>&nbsp;&nbsp;</td>

<td align="left">

<input type="text" id ="sector" name="sector"  value="<?php echo $sector; ?>" size="20" readonly />



</td>



&nbsp;



<td align="right"><strong>Designation</strong>&nbsp;&nbsp;</td>

<td align="left">

<input type="text" id ="desig" name="desig"  value="<?php echo $desig; ?>" size="20" readonly />



</td>



&nbsp;



<td align="right"><strong>Employee Name</strong>&nbsp;&nbsp;</td>

<td align="left">

<input type="text" id ="ename" name="ename"  value="<?php echo $name; ?>" size="20" readonly />

</td>

</tr>

</table>

<br>

<br>







<table>

<?php 

  $inc = 0;

  include "config.php";

  $query1 = "SELECT * FROM hr_params order by code";

  $result1 = mysql_query($query1,$conn);

  while($row1 = mysql_fetch_assoc($result1))

  {

  $currval = 0;

  $par = $row1['code'];
  $query2="desc hr_salary_parameters";
  $result2=mysql_query($query2,$conn);
  
  while($row2=mysql_fetch_array($result2))
  {
  
  if($par==$row2[0])
  {

  $q = "select `$par` as parval from hr_salary_parameters where id = '$id'";

  $qrs = mysql_query($q,$conn) or die(mysql_error());

  while($qr = mysql_fetch_assoc($qrs))

  {
$qr['parval'].",".$salary."<br/>";
  if($row1['basis'] == "Salary" && $row1['unit'] == "Per")

  {

  $currval = (($qr['parval']*100)/$salary);

  }

  else if($row1['basis'] == "Salary" && $row1['unit'] == "Flat")

  {

 $currval = $qr['parval'];

  }
  }
  
  }

  }

  

if($inc%2 == 0)

{ ?>

<tr>

<?php } ?>

<td align="right"><strong><?php echo $row1['description']; ?></strong>&nbsp;&nbsp;&nbsp;</td>

<td align="left"><input type="text" name="<?php echo $row1['code']; ?>" id="<?php echo $row1['code']; ?>" size="10" value="<?php echo $currval; ?>" /><strong><?php if($row1['unit'] == "Per") { ?>%<?php } ?></strong></td>

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

<input type="submit" id="update" name="update" value="Update" />&nbsp;&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salary_parameters';">





</form>

</center>





<script type="text/javascript">

function script1() {

window.open('HRHELP/hr_m_addsalaryparamerts.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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





	<footer>

		<div class="float-left">

			<a href="#" class="button" onClick="script1()">Help</a>

			<a href="javascript:void(0)" class="button">About</a>

		</div>





		

		<div class="float-right">

			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>

		</div>

		

	</footer>