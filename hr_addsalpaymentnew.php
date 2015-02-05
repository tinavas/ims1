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
<strong>Payment Date </strong>&nbsp;&nbsp;
<input type="text" id="date" name="date" size="15" value="<?php echo $date;?>" class="datepicker" onchange="fun3();"/>

&nbsp;&nbsp;&nbsp;
<strong>Month </strong>
&nbsp;&nbsp;

<select id="month" onChange="funmnth();" name="month">
<option value="Select"> Select </option>
<option value="01" <?php if($_GET['month'] == "01") { ?> selected="selected" <?php } ?> >JAN</option>
<option value="02" <?php if($_GET['month'] == "02") { ?> selected="selected" <?php } ?>>FEB</option>
<option value="03" <?php if($_GET['month'] == "03") { ?> selected="selected" <?php } ?>>MAR</option>
<option value="04" <?php if($_GET['month'] == "04") { ?> selected="selected" <?php } ?>>APR</option>
<option value="05" <?php if($_GET['month'] == "05") { ?> selected="selected" <?php } ?>>MAY</option>
<option value="06" <?php if($_GET['month'] == "06") { ?> selected="selected" <?php } ?>>JUN</option>
<option value="07" <?php if($_GET['month'] == "07") { ?> selected="selected" <?php } ?>>JUL</option>
<option value="08" <?php if($_GET['month'] == "08") { ?> selected="selected" <?php } ?>>AUG</option>
<option value="09" <?php if($_GET['month'] == "09") { ?> selected="selected" <?php } ?>>SEP</option>
<option value="10" <?php if($_GET['month'] == "10") { ?> selected="selected" <?php } ?>>OCT</option>
<option value="11" <?php if($_GET['month'] == "11") { ?> selected="selected" <?php } ?>>NOV</option>
<option value="12" <?php if($_GET['month'] == "12") { ?> selected="selected" <?php } ?>>DEC</option>
</select>
&nbsp;&nbsp;&nbsp;
</center>
<br />
<?php
$date100 = explode(".",$date);
$month1 = $date100[1];
$year1 = $date100[2];

$monthq = $_GET['month'];
if($month1 == "01" && $monthq=="12")
{
$yearq = $year1-1;
}
else
{
$yearq = $year1;
}
$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
$dateq = $days_in_month[$monthq] ."." . $monthq . "." . $yearq;
$query = "select * from hr_employee where sector $sc '$sector' and designation $dc '$desig' and employeeid not in (select distinct(eid) from hr_payment where month1 = '$monthq' and year1 = '$yearq') ";
$rquery = mysql_query($query,$conn) or die(mysql_error());
?>
<table align="center" width="750px" <?php if(mysql_num_rows($rquery) == 0) {?> style="visibility:hidden" <?php } ?>> 
<tr align="center">

<!--<td>
<strong>ID</strong>
</td>
<td width="10px">&nbsp;</td>-->
<td>
<strong>Name</strong></td>
<td width="10px">&nbsp;</td>
<td title="Total Salary Per Month" width="50px">
<strong>Tot. Sal</strong></td>
<td width="10px">&nbsp;</td>
<td width="50px" title="Advance Amount">
<strong>Adv.</strong></td>
<td width="10px">&nbsp;</td>
<td width="50px" title="Previous Balance">
<strong>P. Bal.</strong></td>
<td width="10px">&nbsp;</td>
<td width="50px" title="Outstanding Balance">
<strong>Ou. Bal.</strong></td>
<td width="10px">&nbsp;</td>
<td title="Deduction From Advance/Loan taken" width="50px">
<strong>Adv. Ded.</strong></td>

<td width="10px">&nbsp;</td>
<td title="Other Deductions" width="50px">
<strong>O. Ded.</strong></td>
<td width="10px">&nbsp;</td>
<td title="Previous Balance Cleared/Advance Given" width="50px">
<strong>P.B. Cl.</strong></td>
<td width="10px">&nbsp;</td>
<td title="Other Bonus" width="50px">
<strong>O. Bon.</strong></td>


<td width="10px">&nbsp;</td>
<td title="Salary Paid" width="50px">
<strong>Saly Paid</strong></td>
<td width="10px">&nbsp;</td>
<td title="Payment Mode" width="50px">
<strong>Payment Mode</strong></td>
<td width="10px">&nbsp;</td>
<td title="Code" width="50px">
<strong>Code</strong></td>
<td width="10px">&nbsp;</td>

<td id="cdd" >
<strong>Cheque&nbsp;#</strong></td>
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

<input type="hidden" id="employeeid<?php echo $i; ?>" name="employeeid[]" value="<?php echo $r['employeeid']; ?>" />
<?php
$mnar = explode(".", $date);
$currmnth= $mnar[1];
$curryr = $mnar[2];
if($r['salarytype'] == "Daily")
{
$totaldays =0;$nooffull=0;$noofhalf=0;
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
	  $salsal = $r['salary']* $totaldays;
	  
}
?>

<td>
<input type="text" style="width: 100px; color:#0000FF" id="employeename<?php echo $i; ?>" name="employeename[]"  readonly value="<?php echo $r['name']; ?>" /></td>

<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 50px;text-align:right;color:#0000FF" id="totalsalary<?php echo $i; ?>" name="totalsalary[]"  readonly value="<?php echo $salsal; ?>" /></td>
<?php 


    $initialadv =0;	
	$initialadv = $r['advance'];	
		
	$sumsaltopay = 0;$sumsalpaid =0;$sumbonus = 0;$sumdeduction = 0;
	$datecc = date("Y-m-d",strtotime($dateq));
	  /*$qa = "select sum(totsal) as sumsaltopay,sum(paid) as sumsalpaid, sum(bonus) as sumbonus, sum(deduction) as sumdeduction from hr_payment where eid='$r[employeeid']'and client='$client'";*/ 
/*	  $qa = "select sum(totalsal) as sumsaltopay,sum(paid) as sumsalpaid, sum(bonus) as sumbonus, sum(deduction) as sumdeduction, sum(pbonus) as sumpbonus, sum(advdeduction) as sumadvdeduction from hr_payment where eid='$r[employeeid]' and date < '$datecc' and client='$client' ";*/ 
	  $qa = "select sum(totalsal) as sumsaltopay,sum(paid) as sumsalpaid, sum(bonus) as sumbonus, sum(deduction) as sumdeduction, sum(pbonus) as sumpbonus, sum(advdeduction) as sumadvdeduction from hr_payment where eid='$r[employeeid]' and month1 < '$monthq' and year1='$yearq' and client='$client' ";
	   $qar = mysql_query($qa,$conn) or die(mysql_error());
	  if($qars = mysql_fetch_assoc($qar))
	  {
	    $sumsaltopay = $qars['sumsaltopay'];
		$sumsalpaid = $qars['sumsalpaid'];
		$sumbonus = $qars['sumbonus'];
		$sumdeduction = $qars['sumdeduction'];
		$sumpbonus = $qars['sumpbonus'];
		$sumadvdeduction = $qars['sumadvdeduction'];
	}
			
  $qb = "select sum(amount) as sumcramount from ac_financialpostings where venname='$r[name]' and crdr = 'Cr' and coacode ='$r[loanac]' and date < '$datecc'"; 
	$qbr = mysql_query($qb,$conn) or die(mysql_error());
	  if($qbrs = mysql_fetch_assoc($qbr))
	  {
	     $sumcramount = $qbrs['sumcramount'];
	 }
		 
  $qc = "select sum(amount) as sumdramount from ac_financialpostings where venname='$r[name]' and crdr = 'Dr' and coacode = '$r[loanac]' and date < '$datecc'"; 
	 $qcr = mysql_query($qc,$conn) or die(mysql_error());
	  if($qcrs = mysql_fetch_assoc($qcr))
	  {
	     $sumdramount = $qcrs['sumdramount'];
		 }
		 
		  $finadv =( $initialadv + $sumdramount - $sumcramount + $sumpbonus - $sumadvdeduction );
		 
		// $finadv =( $initialadv + $sumsalpaid + $sumdeduction + $sumdramount ) - ($sumsaltopay + $sumbonus + $sumcramount);

if($finadv >0)
{
$oldbal = 0;
}
else
{
$oldbal = $finadv * (-1);
$finadv = 0;
}
   $osbal = $salsal - $finadv +  $oldbal;


	/*$dq1 = "select sum(leavesal) as leavesal from hr_leaves where empid = '$r[employeeid]' and flag = '0' ";
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
		$loanacamount = 0; */
	
?>
<td width="10px">&nbsp;</td>
<td>
<input type="text" readonly  style="width: 50px;text-align:right;color:#0000FF" id="bal<?php echo $i; ?>" name="bal[]" value="<?php echo $finadv; ?>" /></td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" readonly  style="width: 50px;text-align:right;color:#0000FF" id="oldbal<?php echo $i; ?>" name="oldbal[]" value="<?php echo $oldbal; ?>" /></td>
<td width="10px">&nbsp;</td>
<td>
<input type="text"  style="width: 70px;text-align:right;color:#0000FF" id="ospaid<?php echo $i; ?>" name="ospaid[]" value="<?php echo $osbal; ?>" readonly /></td>

<td width="10px">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right" id="advdeduction<?php echo $i; ?>" name="advdeduction[]" value="0" onkeyup="bala(<?php echo $i; ?>);"/></td>



<td width="10px">&nbsp;</td>
<td><input type="text"  style="width: 50px;text-align:right" id="deduction<?php echo $i; ?>" name="deduction[]" value="0" onkeyup="bala(<?php echo $i; ?>);"/>
  <?php /*?><input type="text"  style="width: 70px;text-align:right" id="deduction<?php echo $i; ?>" name="deduction[]" value="<?php echo $leavesal; ?>" onkeyup="bala(<?php echo $i; ?>);" /><?php */?></td>
  <td width="10px">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right" id="advbonus<?php echo $i; ?>" name="advbonus[]" value="0" onkeyup="bala(<?php echo $i; ?>);"/></td>

  <td width="10px">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right" id="bonus<?php echo $i; ?>" name="bonus[]" value="0" onkeyup="bala(<?php echo $i; ?>);"/></td>



<td width="10px">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right;color:#0000FF" id="paid<?php echo $i; ?>" name="paid[]" value="<?php echo $salsal; ?>" readonly /></td>
<td width="10px">&nbsp;</td>
<td>
<select name="paymode[]" id="paymode<?php echo $i; ?>" style="width:80px" onchange="cashcheque(<?php echo $i; ?>)">
<option value="">-Select-</option>
<option value="Cash">Cash</option>
<option value="Cheque">Cheque</option>
<option value="Other">Other</option>
</select></td>
<td width="10px">&nbsp;</td>
<td>
<select name="code[]" id="code<?php echo $i; ?>" style="width:80px" onchange="getcoacode(<?php echo $i; ?>);">
<option value="">-Select-</option>
</select></td>
<input type="hidden" id="coacode<?php echo $i; ?>" name="coacode[]" />
<td width="10px">&nbsp;</td>

<td style="vertical-align:top">
<input type="text" style="position:absolute;width:50px;visibility:hidden" id="cddno<?php echo $i; ?>" name="cddno[]" value=""/>
<input type="text" style="position:absolute;width:50px;visibility:visible" readonly id="cddno1<?php echo $i; ?>" name="cddno1[]" value=""/></td>
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
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input name="button" type="button" onclick="document.location = 'dashboardsub.php?page=hr_salpayment';" value = "Cancel"/></td>
<td>&nbsp;</td>
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
if(document.getElementById('paid' + i).value == '') { document.getElementById('paid' + i).value = 0;}
if(document.getElementById('deduction' + i).value == '') { document.getElementById('deduction' + i).value = 0;}
if(document.getElementById('advdeduction' + i).value == '') { document.getElementById('advdeduction' + i).value = 0;}
if(document.getElementById('bonus' + i).value == '') { document.getElementById('bonus' + i).value = 0;}
if(document.getElementById('advbonus' + i).value == '') { document.getElementById('advbonus' + i).value = 0;}
/*document.getElementById('bal' + i).value = (parseFloat(document.getElementById('paid' + i).value) + parseFloat(document.getElementById('deduction' + i).value) - parseFloat(document.getElementById('totalsalary' + i).value));*/
document.getElementById('paid' + i).value = parseFloat(document.getElementById('totalsalary' + i).value) - parseFloat(document.getElementById('deduction' + i).value) - parseFloat(document.getElementById('advdeduction' + i).value) + parseFloat(document.getElementById('bonus' + i).value) + parseFloat(document.getElementById('advbonus' + i).value) ;
//-  parseFloat(document.getElementById('bal' + i).value) +  parseFloat(document.getElementById('oldbal' + i).value);

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
	document.location = "dashboard.php?page=hr_addsalpaymentnew&sector=" + sector + "&desig=" + desig;
}

function fun2()
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	document.location = "dashboard.php?page=hr_addsalpaymentnew&sector=" + sector + "&desig=" + desig;
}

function fun3()
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	//var date = document.getElementById('date').value;
	document.location = "dashboard.php?page=hr_addsalpaymentnew&sector=" + sector + "&desig=" + desig + "&date=" + date;
}
function funmnth()
{
var days_in_month = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var mnth =  document.getElementById('month').value;
var mnth2 =  document.getElementById('date').value; 
var mnth2arr = new Array();
mnth2arr =  mnth2.split(".");
 
var mnth22 = mnth2arr[1];
//$days_in_month[mnth22] . "." . mnth22 . "." . mnth2arr[2];
if(mnth2arr[0] == days_in_month[mnth22-1])
{
if(mnth > mnth2arr[1])
{
alert("Month should be less than paying date");
document.getElementById('month').focus();
return false;
}
else
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	var month = document.getElementById('month').value;
	document.location = "dashboard.php?page=hr_addsalpaymentnew&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month;
}
}
else
{
if(mnth >= mnth2arr[1])
{
if((mnth2arr[1] == '01') && (mnth == '12') )
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	var month = document.getElementById('month').value;
	document.location = "dashboard.php?page=hr_addsalpaymentnew&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month;
}
else
{
alert("Month should be less than paying date");
document.getElementById('month').focus();
return false;
}
}
else
{
	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	var month = document.getElementById('month').value;
	document.location = "dashboard.php?page=hr_addsalpaymentnew&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month;
}
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
