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
<form method="post" action="hr_savemnthattandance_golden.php" id="salform" name="salform">
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
$query1="select noofdays from hr_workingdays where month = '$month' AND year = '$year'";
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
$query = "select * from hr_employee where sector $sc '$sector' and designation $dc '$desig' and employeeid not in (select distinct(eid) from hr_mnthattendance where month = '$month' and year = '$year') ";
$rquery = mysql_query($query,$conn) or die(mysql_error());
?>
<table align="center" width="750px" <?php if(mysql_num_rows($rquery) == 0) {?> style="visibility:hidden" <?php } ?>> 
<tr align="center">

<td>
<strong>ID</strong></td>
<td width="10px">&nbsp;</td>
<td>
<strong>Name</strong></td>
<td width="10px">&nbsp;</td>
<td>
<strong>Sector</strong></td>
<td width="10px">&nbsp;</td>
<td>
<strong>Designation</strong></td>
<td width="10px">&nbsp;</td>
<td>
<strong>Days Present<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>    </strong></td>
<td width="10px">&nbsp;</td>
<td>
<strong>Extra </strong></td>
<td width="10px">&nbsp;</td>
<td>
<strong>Leaves </strong></td>
</tr>
<tr height="10px"><td></td></tr>

<?php 
$i = 0;
while($r = mysql_fetch_assoc($rquery))
{ ?>
<tr align="center">
<td>
<input type="text" style="width: 30px; color:#FF0000" id="employeeid<?php echo $i; ?>" name="employeeid[]"  readonly value="<?php echo $r['employeeid']; ?>" /></td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 100px; color:#FF0000" id="employeename<?php echo $i; ?>" name="employeename[]"  readonly value="<?php echo $r['name']; ?>" /></td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 100px; color:#FF0000" id="sect<?php echo $i; ?>" name="sect[]"  readonly value="<?php echo $r['sector']; ?>" /></td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 100px; color:#FF0000" id="designation<?php echo $i; ?>" name="designation[]"  readonly value="<?php echo $r['designation']; ?>" /></td>
<td width="10px">&nbsp;</td>
<td><input type="text" style="width: 70px;text-align:right" id="days<?php echo $i; ?>" name="days[]"  value="0" /></td>

<td width="10px">&nbsp;</td>
<td><input type="text" style="width: 70px;text-align:right" id="ext<?php echo $i; ?>" name="ext[]"  value="0" /></td>

<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 70px;text-align:right" id="leav<?php echo $i; ?>" name="leav[]"  value="0" /></td>
</tr>
<tr height="10px"><td></td></tr>
<?php $i++; 
}
 ?>
</table>
<table align="center" <?php if(mysql_num_rows($rquery) == 0) { ?> style="visibility:hidden" <?php } ?>>
<tr>
<td colspan="4" align="center">
<input type="submit" value = "Save" />
</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td>
<input type="button" value = "Cancel" onclick="document.location = 'dashboardsub.php?page=hr_mnthattendance';"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">

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
	document.location = "dashboardsub.php?page=hr_addmnthattendance_golden&sector=" + sector + "&desig=" + desig + "&month=" + month + "&year=" + year ;
}

</script>
<script type="text/javascript">
function script1() {
window.open('HRHELP/help_p_addsalpayment.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
