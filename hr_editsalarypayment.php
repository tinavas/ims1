<?php 
include "config.php";
include "jquery.php";

$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");
$id = $_GET['id'];
$mnt  = $_GET['mon'];
$month = $montharr[$mnt-1];
$year = $_GET['year'];

		$q = "select * from hr_payment where id = '$id'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		$eid = $qr['eid'];
		$name = $qr['name'];
		$paiddate= $qr['date'];
		$month1 = $qr['month1'];
		$year1=$qr['year1'];
		$paid=$qr['paid'];
		$ded=$qr['deduction'];
		$paymode = $qr['paymode'];
		$code = $qr['code'];
		$coacode=$qr['coacode'];
		$ot = $qr['ot'];
		$cddno=$qr['cddno'];
		}
		   
           $query121 = "SELECT sector,designation FROM hr_employee where employeeid='$eid'";
           $result121 = mysql_query($query121,$conn); 
           while($row121 = mysql_fetch_assoc($result121))
           {
			 $sector = $row121['sector'];
			 $designation = $row121['designation'];
			}



	function leapYear($year)
	{ 
		if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) 
		return TRUE; 
		return FALSE; 
	} 
	
	function daysInMonth($month = 0, $year = '')
	{ 
		$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		$d = array("Jan" => 31, "Feb" => 28, "Mar" => 31, "Apr" => 30, "May" => 31, "Jun" => 30, "Jul" => 31, "Aug" => 31, "Sept" =>30, "Oct" => 31, "Nov" => 30, "Dec" => 31); 
		if(!is_numeric($year) || strlen($year) != 4) 
			$year = date('Y'); 
		
		if($month == 2 || $month == 'Feb')
		{ 
			if(leapYear($year)) 
			return 29; 
		} 
		if(is_numeric($month))
		{ 
			if($month < 1 || $month > 12) 
			return 0; 
			else 
			return $days_in_month[$month - 1]; 
		} 
		else
		{ 
			if(in_array($month, array_keys($d))) 
			return $d[$month]; 
			else return 0; 
		} 
	} 


?>

<br /><br />
<center> <h1>Salary Payment </h1>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)</center>
<br /><br />
<form method="post" action="hr_updatesalpayment.php" id="salform" name="salform">
<center>

<strong>Sector</strong>&nbsp;&nbsp;<input name="sector" id="sector" style="color:#0000FF" value="<?php echo $sector;?>" readonly/>
&nbsp;&nbsp;&nbsp;
<strong>Designation</strong>&nbsp;&nbsp;<input  style="color:#0000FF" value="<?php echo $designation;?>" name="desig" id="desig" readonly/>
&nbsp;&nbsp;&nbsp;
<strong>Payment Date </strong>&nbsp;&nbsp;
<input type="text" id="date" name="date" size="11" value="<?php echo date("d.m.Y",strtotime($paiddate));?>" class="datepicker"  onChange="funmnth();"/>

&nbsp;&nbsp;&nbsp;
<strong>Month </strong>
&nbsp;&nbsp;

<select id="month"  name="month" disabled="disabled" style="color:#0000FF">
<option value="Select"> Select </option>
<option value="01" <?php if($month1 == "01") { ?> selected="selected" <?php } ?> >JAN</option>
<option value="02" <?php if($month1 == "02") { ?> selected="selected" <?php } ?>>FEB</option>
<option value="03" <?php if($month1 == "03") { ?> selected="selected" <?php } ?>>MAR</option>
<option value="04" <?php if($month1 == "04") { ?> selected="selected" <?php } ?>>APR</option>
<option value="05" <?php if($month1 == "05") { ?> selected="selected" <?php } ?>>MAY</option>
<option value="06" <?php if($month1 == "06") { ?> selected="selected" <?php } ?>>JUN</option>
<option value="07" <?php if($month1 == "07") { ?> selected="selected" <?php } ?>>JUL</option>
<option value="08" <?php if($month1 == "08") { ?> selected="selected" <?php } ?>>AUG</option>
<option value="09" <?php if($month1 == "09") { ?> selected="selected" <?php } ?>>SEP</option>
<option value="10" <?php if($month1 == "10") { ?> selected="selected" <?php } ?>>OCT</option>
<option value="11" <?php if($month1 == "11") { ?> selected="selected" <?php } ?>>NOV</option>
<option value="12" <?php if($month1 == "12") { ?> selected="selected" <?php } ?>>DEC</option>
</select>
&nbsp;&nbsp;&nbsp;
<strong>Year</strong>&nbsp;&nbsp;<input size="5"  style="color:#0000FF" value="<?php echo $year1;?>" name="desig" id="desig" readonly/>
&nbsp;&nbsp;&nbsp;
</center>
<br />
<?php
if($month1>=1 && $month1<=9)
{
$month1="0".$month1;
}
$monthq = $month1;
$yearq = $year1;
$days_in_month = array(31,28,31,30,31,30,31,31,30,31,30,31);
$dateq = $days_in_month[$month1-1] ."." . $month1 . "." . $year1;
$query = "select * from hr_employee where employeeid ='$eid'";
$rquery = mysql_query($query,$conn) or die(mysql_error());
?>
<table align="center" width="750px" <?php if(mysql_num_rows($rquery) == 0) {?> style="visibility:hidden" <?php } ?>> 
<tr align="center">

<!--<td>
<strong>ID</strong>
</td>
<td width="10px">&nbsp;</td>-->
<td width="50px">
<strong>Name</strong></td>
<td width="10px">&nbsp;</td>
<td  title="Days Present" width="50px"><strong>Days</strong></td>

<td width="10px">&nbsp;</td>
<td title="Actual Salary Per Month" width="50px">
<strong>Act. Sal</strong></td>
<td width="10px">&nbsp;</td>
<td title="Total Salary based on attandance" width="50px">
<strong>Att. Sal</strong></td>
<td width="10px">&nbsp;</td>
<td title="Over Time Salary" width="50px">
<strong>O.T.</strong></td>
<td width="10px">&nbsp;</td>

<td title="Salary Paid" width="50px">
<strong>Saly Paid<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td width="10px">&nbsp;</td>
<td title="Payment Mode" width="50px">
<strong>Payment Mode<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td width="10px">&nbsp;</td>
<td title="Code" width="50px">
<strong>Code</strong></td>
<td width="10px">&nbsp;</td>

<td id="cdd" width="50px">
<strong>Cheque&nbsp;#</strong></td>
</tr>
<tr height="10px"><td></td></tr>
<input type="hidden" id="oldpdate" name="oldpdate" value="<?php echo $paiddate;?>"/>
<input type="hidden" id="oldid" name="oldid" value="<?php echo $id;?>"/>
<input type="hidden" id="dateq" name="dateq" value="<?php echo $dateq;?>"/>
<?php 
$i = 0;
while($r = mysql_fetch_assoc($rquery))
{
$subquery = "select * from hr_payment where eid = '$eid'";
$rsubquery = mysql_query($subquery,$conn) or die(mysql_error());

$dateqcc = date("Y-m-j", strtotime($dateq));
 $queryforsal = "select finalsal from hr_salaryparameters where eid = '$eid' order by id desc Limit 1 ";
$rsforsal = mysql_query($queryforsal,$conn) or die(mysql_error());
while($rforsal = mysql_fetch_assoc($rsforsal))
{
 $salsal = $rforsal['finalsal'];
}
if($salsal == "")
$salsal = 0;
$actsalorg =0;
$actsalorg = $salsal;

if( $salsal != 0 )
{
?>
<tr align="center">

<input type="hidden" id="employeeid<?php echo $i; ?>" name="employeeid" value="<?php echo $eid; ?>" />
<?php


/*$totaldays =0;$nooffull=0;$noofhalf=0;
$qtt ="SELECT count(*) as noofdays FROM `hr_attendance` where eid='$r[employeeid]' and month1='$monthq' and year1='$yearq' and daytype='Full' and client='$client'";
 $qttr = mysql_query($qtt,$conn) or die(mysql_error());
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $nooffull = $qttrs['noofdays'];
	  }
	  $qtt ="SELECT count(*) as noofdays FROM `hr_attendance` where eid='$r[employeeid]' and month1='$monthq' and year1='$yearq' and daytype='Half' and client='$client'";
 $qttr = mysql_query($qtt,$conn) or die(mysql_error());
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $noofhalf = $qttrs['noofdays'];
	  }
	   $totaldays = $nooffull + ($noofhalf/2);
if($r['salarytype'] == "Daily")
{	  
	 
	  $salsal = $r['salary']* $totaldays;

}
else
{
	$workd = $days_in_month[$monthq-1];
	  $salsal = ($r['salary']* $totaldays)/$workd;

}*/

$totaldays =0;$nooffull=0;$noofhalf=0;
$qtt ="SELECT dayspresent as noofdays,workingdays as workd FROM `hr_mnthattendance` where eid='$eid' and month='$month1' and year='$year1' and client='$client'";
 $qttr = mysql_query($qtt,$conn) ;
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $totaldays = $qttrs['noofdays'];
	  $workd = $qttrs['workd'];
	  }
	    
	  
if($r['salarytype'] == "Daily")
{	  
	 
	  $salsal = $r['salary']* $totaldays;

}
else
{
	$salsal = ($r['salary']* $totaldays)/$workd;
}
?>

<td>
<input type="text" style="width: 100px; color:#0000FF" id="employeename<?php echo $i; ?>" name="employeename"  readonly value="<?php echo $name; ?>" /></td>


<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 50px;text-align:right;color:#0000FF" id="pdays<?php echo $i; ?>" name="pdays"  readonly value="<?php echo $totaldays; ?>" /></td>


<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 50px;text-align:right;color:#0000FF" id="actorgsalary<?php echo $i; ?>" name="actorgsalary"  readonly value="<?php echo round($actsalorg,2); ?>" /></td>

<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 50px;text-align:right;color:#0000FF" id="totalsalary<?php echo $i; ?>" name="totalsalary"  readonly value="<?php echo round($salsal,2); ?>" /></td>

<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 50px;text-align:right;" id="ot<?php echo $i; ?>" name="ot"   value="<?php echo $ot;?>"  onkeyup="calsalot(this.id);" /></td>

<td width="10px">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right;" id="paid<?php echo $i; ?>" name="paid" value="<?php echo $paid; ?>"/></td>
<td width="10px">&nbsp;</td>
<td>
<select name="paymode" id="paymode<?php echo $i; ?>" style="width:80px" onchange="cashcheque(<?php echo $i; ?>)">
<option value="">-Select-</option>
<option <?php if($paymode == "Cash"){ ?> selected="selected" <?Php }?> value="Cash">Cash</option>
<option <?php if($paymode == "Cheque"){ ?> selected="selected" <?Php }?> value="Cheque">Cheque</option>
<option <?php if($paymode == "Other"){ ?> selected="selected" <?Php }?> value="Other">Other</option>
</select></td>
<td width="10px">&nbsp;</td>
<td>
<select name="code" id="code<?php echo $i; ?>" style="width:80px" onchange="getcoacode(<?php echo $i; ?>);">
<option value="">-Select-</option>
<?Php if($code!="")
{?>
<option  value="<?php echo $code;?>" selected="selected"><?php echo $code;?></option>
<?php }?>
</select></td>
<input type="hidden" id="coacode<?php echo $i; ?>" name="coacode" />
<td width="10px">&nbsp;</td>

<td style="vertical-align:top">
<input type="text" <?php if($cddno == ""){?> style="position:absolute;width:50px;visibility:hidden" <?php }else {?> style="position:absolute;width:50px;"<?php }?> id="cddno<?php echo $i; ?>" name="cddno" value=""/>
<input type="text" style="position:absolute;width:50px;visibility:visible"  id="cddno1<?php echo $i; ?>" name="cddno1" value="<?php echo $cddno;?>"/></td>
</tr>
<tr height="10px"><td></td></tr>
<?php $i++; } 
} ?>
</table>

<table align="center" <?php if(mysql_num_rows($rquery) == 0) { ?> style="visibility:hidden" <?php } ?>>
<tr>
<td colspan="4" align="center">
<input type="submit" value = "Pay" />
</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input name="button" type="button" onclick="document.location = 'dashboardsub.php?page=hr_salpayment';" value = "Cancel"/></td>
<td>&nbsp;</td>
</tr>
</table>
</form>
<script type="text/javascript">
function cashcheque(i)
{
var a = document.getElementById('paymode' + i).value;
document.getElementById('code' + i).value = "";
removeAllOptions(document.getElementById('code' + i));
var code = document.getElementById('code' + i);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
code.appendChild(theOption1);
document.getElementById('cddno1' + i).style.visibility = "hidden";
document.getElementById('cddno' + i).style.visibility = "hidden";
if(a == "Cash")
{
document.getElementById('cddno1' + i).style.visibility = "visible";

<?php 
	$q = "select distinct(code),coacode from ac_bankmasters where mode = 'Cash' order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['code']; ?>";
code.appendChild(theOption1);
<?php
	}
?>

}
else if(a == "Cheque")
{
document.getElementById('cddno' + i).style.visibility = "visible";

<?php 
	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' order by acno";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['acno']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
}
function getcoacode(i)
{
document.getElementById('coacode' + i).value = "";

	if(document.getElementById('paymode' + i ).value == "Cash")
	{
		<?php 
		$q = "select distinct(code) as code from ac_bankmasters";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
			echo "if(document.getElementById('code' + i).value == '$qr[code]') {";
			$q1 = "select distinct(coacode) from ac_bankmasters where code = '$qr[code]' order by coacode";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
		?>
			document.getElementById('coacode' + i).value = "<?php echo $q1r['coacode']; ?>";
		<?php } echo "}"; } ?>


	}
	else if(document.getElementById('paymode' + i ).value == "Cheque")
	{
		<?php 
		$q = "select distinct(acno) as code from ac_bankmasters";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
			echo "if(document.getElementById('code' + i).value == '$qr[code]') {";
			$q1 = "select distinct(coacode) from ac_bankmasters where acno = '$qr[code]' order by coacode";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
		?>
			document.getElementById('coacode' + i).value = "<?php echo $q1r['coacode']; ?>";
		<?php } echo "}"; } ?>

		
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

function reloademployees()
{

var sector  = document.getElementById('sector').value;
var desig = document.getElementById('desig').value;
window.location = 'salpayment.php?sector=' + sector + '&desig=' + desig;

}

function calsalot(otid)
{
var tid = otid.substr(2);
var otsal = parseFloat(parseFloat(document.getElementById('ot'+tid).value) + parseFloat(document.getElementById('paid'+tid).value));
document.getElementById('paid'+tid).value=otsal;

}

function totalamt()
{

var scash = 0;
var sother = 0;
var idcash = '';
var idother = '';
for(i=0;i<document.getElementsByName('paid').length;i++)
{
if(document.getElementsByName('paymode')[i].value == 'Cash')
{
scash = parseFloat(parseFloat(scash) + parseFloat(document.getElementsByName('paid')[i].value));
idcash = idcash + document.getElementsByName('employeeid')[i].value + ',';
}
else if((document.getElementsByName('paymode')[i].value == 'Cheque') || (document.getElementsByName('paymode')[i].value == 'D.D'))
{
sother = parseFloat(parseFloat(sother) + parseFloat(document.getElementsByName('paid')[i].value));
idother = idother + document.getElementsByName('employeeid')[i].value + ',';
}
}
document.getElementById('totalvaluecash').value = scash;
document.getElementById('totalvalueother').value = sother;
document.getElementById('idcash').value = idcash;
document.getElementById('idother').value = idother;
document.getElementById('salform').submit();

}

function checknoofemps()
{

if(document.getElementsByName('paid').length == 0)
{
document.getElementById('headid').style.visibility = 'hidden';
document.getElementById('errormsg').style.visibility = 'visible';
}

}

function fun1()
{
var sector = document.getElementById('sector').value;
	var desig = "";
	//var date = document.getElementById('date').value;
	//var month = document.getElementById('month').value;
	document.location = "dashboardsub.php?page=hr_addsalpayment&sector=" + sector + "&desig=" + desig ;
}

function fun2()
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	//var date = document.getElementById('date').value;
	//var month = document.getElementById('month').value;
	document.location = "dashboardsub.php?page=hr_addsalpayment&sector=" + sector + "&desig=" + desig ;
}

function fun3()
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	var month = document.getElementById('month').value;
	document.location = "dashboardsub.php?page=hr_addsalpayment&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month;
}
function funmnth()
{

var frmdate = document.getElementById('date').value;
var tdate = document.getElementById('dateq').value;
var dt1  = parseInt(frmdate.substring(0,2),10); 
var mon1 = parseInt(frmdate.substring(3,5),10);
var yr1  = parseInt(frmdate.substring(6,10),10); 
var dt2  = parseInt(tdate.substring(0,2),10); 
var mon2 = parseInt(tdate.substring(3,5),10); 
var yr2  = parseInt(tdate.substring(6,10),10); 
var date1 = new Date(yr1, mon1, dt1); 
var date2 = new Date(yr2, mon2, dt2); 

if(date2 > date1)
{
alert("Paying Date should be greater than Month.");
document.getElementById('date').focus();
return false;
}
else
{
return true;
}
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
