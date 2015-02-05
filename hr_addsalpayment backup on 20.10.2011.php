<?php 
include "config.php";
include "jquery.php";

	function leapYear($year)
	{ 
		if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) 
		return TRUE; 
		return FALSE; 
	} 
	
	function daysInMonth($month = 0, $year = '')
	{ 
		$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		$d = array("Jan" => 31, "Feb" => 28, "Mar" => 31, "Apr" => 30, "May" => 31, "Jun" => 30, "Jul" => 31, "Aug" => 31, "Sept" =>                            30, "Oct" => 31, "Nov" => 30, "Dec" => 31); 
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

if(!(isset($_GET['sector'])))
$sector = "";
else
$sector = $_GET['sector'];

if(!(isset($_GET['desig'])))
$desig = "";
else
$desig = $_GET['desig'];

if(!(isset($_GET['date'])))
$date = date("d.m.Y");
else
$date = $_GET['date'];

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
<center> <h1>Salary Payment </h1></center>
<br /><br />
<form method="post" action="hr_savesalpayment.php" id="salform" name="salform">
<center>

<strong>Sector</strong>&nbsp;&nbsp;
<select name="sector" id="sector" onchange="fun1();">
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
<select name="desig" id="desig" onchange="fun2();">
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
<strong>Date </strong>&nbsp;&nbsp;
<input type="text" id="date" name="date" size="15" value="<?php echo $date;?>" class="datepicker" onchange="fun3();"/>
</center>
<br />
<?php
$date100 = explode(".",$date);
$month1 = $date100[1];
$year1 = $date100[2];
$query = "select * from hr_employee where sector $sc '$sector' and designation $dc '$desig' and employeeid not in (select distinct(eid) from hr_payment where month1 = '$month1' and year1 = '$year1') ";
$rquery = mysql_query($query,$conn) or die(mysql_error());
?>
<table align="center" width="750px" <?php if(mysql_num_rows($rquery) == 0) {?> style="visibility:hidden" <?php } ?>> 
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
<strong>Total Salary</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Deduction</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Actual Salary Paid</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Advance</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Payment Mode</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Code</strong>
</td>
<td width="10px">&nbsp;</td>

<td id="cdd">
<strong>Cheque&nbsp;#</strong>
</td>
</tr>
<tr height="10px"><td></td></tr>

<?php 
$i = 0;
while($r = mysql_fetch_assoc($rquery))
{

$subquery = "select * from hr_payment where eid = '$r[employeeid]'";
$rsubquery = mysql_query($subquery,$conn) or die(mysql_error());

$queryforsal = "select finalsal from hr_salaryparameters where eid = '$r[employeeid]'";
$rsforsal = mysql_query($queryforsal,$conn) or die(mysql_error());
while($rforsal = mysql_fetch_assoc($rsforsal))
{
$salsal = $rforsal['finalsal'];
}
if($salsal == "")
$salsal = 0;
if( $salsal != 0 )
{
?>
<tr align="center">
<td>
<input type="text" style="width: 30px" id="employeeid<?php echo $i; ?>" name="employeeid[]"  readonly value="<?php echo $r['employeeid']; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 100px" id="employeename<?php echo $i; ?>" name="employeename[]"  readonly value="<?php echo $r['name']; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 70px;text-align:right" id="totalsalary<?php echo $i; ?>" name="totalsalary[]"  readonly value="<?php echo $salsal;#$r['salary']; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<?php 
	$dq1 = "select sum(leavesal) as leavesal from hr_leaves where empid = '$r[employeeid]' and flag = '0' ";
	$dqr1 = mysql_query($dq1,$conn) or die(mysql_error());
	while($rdqr1 = mysql_fetch_assoc($dqr1))
		$leavesal = $rdqr1['leavesal'];
	if($leavesal == "")
	$leavesal = 0;
	
	$max  =  daysInMonth($date100[1],$date100[2]);
	
	$fromdate = $date100[2] . "-" . $date100[1] . "-01";
	$todate = $date100[2] . "-" . $date100[1] . "-" . $max;

	
	$loanac = $r['loanac'];
	
	$aq = "select sum(amount) as amount from ac_financialpostings where '$fromdate' <= date and date <='$todate' and crdr = 'Dr' and coacode = '$loanac'";
	$aqrs = mysql_query($aq,$conn) or die(mysql_error());
	if($aqr = mysql_fetch_assoc($aqrs))
	$loanacamount = $aqr['amount'];
	
	if($loanacamount == "")
		$loanacamount = 0;
	
	
?>
<input type="text"  style="width: 70px;text-align:right" id="deduction<?php echo $i; ?>" name="deduction[]" value="<?php echo $leavesal; ?>" onkeyup="bala(<?php echo $i; ?>);" readonly />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text"  style="width: 70px;text-align:right" id="paid<?php echo $i; ?>" name="paid[]" value="<?php echo $salsal-$leavesal- $loanacamount; ?>" readonly onkeyup="bala(<?php echo $i; ?>)"/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" readonly  style="width: 70px;text-align:right" id="bal<?php echo $i; ?>" name="bal[]" value="<?php echo $loanacamount; ?>" s/>
</td>
<td width="10px">&nbsp;</td>
<td>
<select name="paymode[]" id="paymode<?php echo $i; ?>" style="width:100px" onchange="cashcheque(<?php echo $i; ?>)">
<option value="">-Select-</option>
<option value="Cash">Cash</option>
<option value="Cheque">Cheque</option>
<option value="Other">Other</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<select name="code[]" id="code<?php echo $i; ?>" style="width:100px" onchange="getcoacode(<?php echo $i; ?>);">
<option value="">-Select-</option>
</select>
</td>
<input type="hidden" id="coacode<?php echo $i; ?>" name="coacode[]" />
<td width="10px">&nbsp;</td>

<td style="vertical-align:top">
<input type="text" style="position:absolute;width:80px;visibility:hidden" id="cddno<?php echo $i; ?>" name="cddno[]" value=""/>
<input type="text" style="position:absolute;width:80px;visibility:visible" readonly id="cddno1<?php echo $i; ?>" name="cddno1[]" value=""/>
</td>

</tr>
<tr height="10px"><td></td></tr>
<?php $i++; } 
} ?>

</table>
<table align="center" <?php if(mysql_num_rows($rquery) == 0) { ?> style="visibility:hidden" <?php } ?>>
<tr>
<td colspan="4" align="center">
<input type="submit" value = "Pay" onclick="totalamt();"/>
</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td>
<input type="button" value = "Cancel" onclick="document.location = 'dashboardsub.php?page=hr_salpayment';"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">

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

function bala(i)
{
if(document.getElementById('paid' + i).value == '')
document.getElementById('paid' + i).value = 0;
document.getElementById('bal' + i).value = (parseFloat(document.getElementById('paid' + i).value) + parseFloat(document.getElementById('deduction' + i).value) - parseFloat(document.getElementById('totalsalary' + i).value));
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
	document.location = "dashboardsub.php?page=hr_addsalpayment&sector=" + sector + "&desig=" + desig;
}

function fun2()
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	document.location = "dashboardsub.php?page=hr_addsalpayment&sector=" + sector + "&desig=" + desig;
}

function fun3()
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	document.location = "dashboardsub.php?page=hr_addsalpayment&sector=" + sector + "&desig=" + desig + "&date=" + date;
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
