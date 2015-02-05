<?php 

include "config.php";

include "jquery.php";



	

if(!(isset($_GET['sector'])))

$sector = "";

else

$sector = $_GET['sector'];



if(!(isset($_GET['desig'])))

$desig = "";

else

$desig = $_GET['desig'];



if(!(isset($_GET['month'])))

$month = "";

else

$month = $_GET['month'];



if(!(isset($_GET['year'])))

$year = "";

else

$year = $_GET['year'];



if($sector == "All")

$sc = "<>";

else

$sc = "=";



if($desig == "All")

$dc = "<>";

else

$dc = "=";



?>



<br /><br />

<center> <h1>Monthly Attendance</h1>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)</center>

<br /><br />

<form method="post" action="hr_savemnth_attandance.php" id="salform" name="salform" onsubmit="return validate()">

<center>



<strong>Sector</strong>&nbsp;&nbsp;

<select name="sector" id="sector" onchange="fun3();">

<option value="">-Select-</option>

 <?php

           include "config.php"; 

           $query121 = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC";

           $result121 = mysql_query($query121,$conn); 

           while($row121 = mysql_fetch_assoc($result121))

           {

           ?>

<option value="<?php echo $row121['sector']; ?>" <?php if($sector == $row121['sector']) { ?> selected="selected" <?php } ?>><?php echo $row121['sector']; ?></option>

<?php } ?>

<option value="All" <?php if($sector == "All") { ?> selected="selected" <?php } ?>>All</option>

</select>

&nbsp;&nbsp;&nbsp;

<strong>Designation</strong>&nbsp;&nbsp;

<select name="desig" id="desig" onchange="fun3();">

<option value="">-Select-</option>

 <?php

           include "config.php"; 

           $query121 = "SELECT distinct(designation) FROM hr_employee where sector $sc '$sector' ORDER BY designation ASC ";

           $result121 = mysql_query($query121,$conn); 

           while($row121 = mysql_fetch_assoc($result121))

           {

           ?>

<option value="<?php echo $row121['designation']; ?>" <?php if($desig == $row121['designation']) { ?> selected="selected" <?php } ?>><?php echo $row121['designation']; ?></option>

<?php } ?>

<option value="All" <?php if($desig == "All") { ?> selected="selected" <?php } ?>>All</option>



</select>

&nbsp;&nbsp;&nbsp;

<strong>Month </strong>&nbsp;&nbsp;

<select id="month" onchange="fun3();" name="month" style="width:60px">

<option value="Select"> Select </option>

<option value="01" <?php if($month == "01") {?> selected="selected" <?php }?>>JAN</option>

<option value="02" <?php if($month == "02") {?> selected="selected" <?php }?>>FEB</option>

<option value="03" <?php if($month == "03") {?> selected="selected" <?php }?>>MAR</option>

<option value="04" <?php if($month == "04") {?> selected="selected" <?php }?>>APR</option>

<option value="05" <?php if($month == "05") {?> selected="selected" <?php }?>>MAY</option>

<option value="06" <?php if($month == "06") {?> selected="selected" <?php }?>>JUN</option>

<option value="07" <?php if($month == "07") {?> selected="selected" <?php }?>>JUL</option>

<option value="08" <?php if($month == "08") {?> selected="selected" <?php }?>>AUG</option>

<option value="09" <?php if($month == "09") {?> selected="selected" <?php }?>>SEP</option>

<option value="10" <?php if($month == "10") {?> selected="selected" <?php }?>>OCT</option>

<option value="11" <?php if($month == "11") {?> selected="selected" <?php }?>>NOV</option>

<option value="12" <?php if($month == "12") {?> selected="selected" <?php }?>>DEC</option>

</select>





&nbsp;&nbsp;&nbsp;

<strong>Year </strong>&nbsp;&nbsp;

<select id="year" onChange="fun3();" name="year" style="width:70px">

<option value="Select"> Select </option>

<?php $date = date(Y)-1; for($a = $date;$a<($date+5);$a++) { ?>

<option value="<?php echo $a; ?>" <?Php if($year == $a) {?> selected="selected" <?php }?>><?php echo $a; ?></option>

<?php } ?>

</select>

<?php if($month != "")

{

$query1="select noofdays from hr_working_days where month = '$month' AND year = '$year'";

$result1 = mysql_query($query1,$conn); 

while($row1 = mysql_fetch_assoc($result1))

{

 $no = $row1['noofdays'];

}

?>

&nbsp;&nbsp;&nbsp;

<strong>Working Days </strong>&nbsp;&nbsp;

<input type="text" style="width: 20px;text-align:right" id="wdays" name="wdays"  value="<?php echo $no;?>"  readonly />

<?Php } ?>

</center>

<br />

<?php

$query = "select * from hr_employee where sector $sc '$sector' and designation $dc '$desig' and employeeid not in (select distinct(eid) from hr_mnth_attendance where month = '$month' and year = '$year') order by name";

$rquery = mysql_query($query,$conn) or die(mysql_error());

?>

<table align="center" id="tab" width="750px" <?php if(mysql_num_rows($rquery) == 0) {?> style="visibility:hidden" <?php } ?>> 

<tr align="center">



<td>

<strong>ID</strong>

</td>

<td width="10px">&nbsp;</td>

<td>

<strong>Name</strong>

</td>

<td width="10px">&nbsp;</td>

<td>

<strong>Sector</strong>

</td>

<td width="10px">&nbsp;</td>

<td>

<strong>Designation</strong>

</td>

<td width="10px">&nbsp;</td>

<td>

<strong>Days Present<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>

</td>

<td width="10px">&nbsp;</td>

<td>

<strong>Extra </strong></td>

<td width="10px">&nbsp;</td>

<td>

<strong>Leaves </strong></td>

<td width="10px">&nbsp;</td>

<td>

<strong>Paid Leaves </strong></td>

</tr>

<tr height="10px"><td></td></tr>



<?php 

$i = 0;
$len=mysql_num_rows($rquery);

while($r = mysql_fetch_assoc($rquery))

{ ?>

<tr align="center">

<td>

<input type="text" style="width: 30px; color:#FF0000; background:none; border:none" id="employeeid<?php echo $i; ?>" name="employeeid[]"  readonly value="<?php echo $r['employeeid']; ?>" />

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" style="width: 100px; color:#FF0000; background:none; border:none" id="employeename<?php echo $i; ?>" name="employeename[]"  readonly value="<?php echo $r['name']; ?>" />

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" style="width: 100px; color:#FF0000; background:none; border:none" id="sect<?php echo $i; ?>" name="sect[]"  readonly value="<?php echo $r['sector']; ?>" />

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" style="width: 100px; color:#FF0000; background:none; border:none" id="designation<?php echo $i; ?>" name="designation[]"  readonly value="<?php echo $r['designation']; ?>" />

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" style="width: 70px;text-align:right" id="days<?php echo $i; ?>" name="days[]"  value="0" onclick="return monyear()" onfocus="return monyear()" onkeypress="num(event.keyCode)" onkeyup="return workingdays(this.id)" />

</td>

<td width="10px">&nbsp;</td>

<td><input type="text" style="width: 70px;text-align:right" id="exta<?php echo $i; ?>" name="ext[]"  value="0"  onkeyup="return workingdays(this.id)" onkeypress="num(event.keyCode)" /></td>



<td width="10px">&nbsp;</td>

<td>

<input type="text" style="width: 70px;text-align:right" id="leav<?php echo $i; ?>" name="leav[]"  value="0"  onkeyup="return workingdays(this.id)" onkeypress="num(event.keyCode)" /></td>


<td width="10px">&nbsp;</td>

<td>

<input type="text" style="width: 70px;text-align:right" id="pleav<?php echo $i; ?>" name="pleav[]"  value="0"  onkeyup="return workingdays(this.id)" onkeypress="num(event.keyCode)" /></td>



</tr>

<tr height="10px"><td></td></tr>

<?php $i++; 

}

 ?>



</table>

<table align="center" <?php if(mysql_num_rows($rquery) == 0) { ?> style="visibility:hidden" <?php } ?>>

<tr>

<td colspan="4" align="center">

<input type="submit" value = "Save"  />

</td>

<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>

<td>

<input type="button" value = "Cancel" onclick="document.location = 'dashboardsub.php?page=hr_mnth_attendance';"/>

</td>

</tr>

</table>

</form>

<script type="text/javascript">
function num(b)
{

	if((b<48|| b>57) && b!=13)
		{
			event.keyCode=false;
			return false;
		
		}

}
function validate()
{

		var b=monyear();
		if(b!=false)
		{
		var index="<?php echo $len;?>";
		
			
	for(var index=0;index<="<?php echo $len;?>"-1;index++)
		{
		
				var days= document.getElementById("days"+index).value;
				
				if(days=="0"|| days=="")
			
				{	alert("Enter Number of days present");
					document.getElementById("days"+index).focus();
					return false;
					
					}
		
		
		}
		
		
		}
		


}	


function workingdays(a)
{	
	var index=a.substr(4,a.length);
	
	var days= document.getElementById("days"+index).value;
	var ext= document.getElementById("exta"+index).value;
	var leav= document.getElementById("leav"+index).value;
	var workingdays=document.getElementById("wdays").value;
	var pleav= document.getElementById("pleav"+index).value;
	var wdays=(Number(days)+Number(ext)+Number(leav)+Number(pleav));
	
	if(Number(workingdays)<wdays)
		{
		
		event.keyCode=false;
		
		document.getElementById(a).value="0";
		alert("No.of days present less than or equal to working days");
		
		return false;
		
		}

}


function monyear()
{

	var month = document.getElementById('month').value;

	var year = document.getElementById('year').value;
	if(month=="Select")
	{
		alert("Select month");
		document.getElementById('month').focus();
		return false;
	}

	if(year=="Select")
	{
		alert("Select year");
		document.getElementById('year').focus();
		return false;
	}


}
function removeAllOptions(selectbox)

{

	var i;

	for(i=selectbox.options.length-1;i>=0;i--)

	{

		selectbox.remove(i);

	}

}





function fun3()

{

	var sector = document.getElementById('sector').value;

	var desig = document.getElementById('desig').value;

	var month = document.getElementById('month').value;

	var year = document.getElementById('year').value;

	document.location = "dashboardsub.php?page=hr_addmnth_attendance&sector=" + sector + "&desig=" + desig + "&month=" + month + "&year=" + year ;

}



</script>

<script type="text/javascript">

function script1() {

window.open('HRHELP/hr_t_monthlyattendance.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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

</body>

</html>

