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
$year = $_GET['year'];
?>
<br /><br />


<style type="text/css">

#availability_status {
	font-size:11px;
	margin-left:10px;
}
input.form_element {
	width: 70px;
	background: transparent url('bg.jpg') no-repeat;
	color : #747862;
	height:20px;
	border:0;
	padding:4px 8px;
	margin-bottom:0px;
}
label {
	width: 125px;
	float: left;
	text-align: left;
	margin-right: 0.5em;
	display: block;
}
.style_form {
	margin:3px;
}
#content {
	margin-left: auto;
	margin-right: auto;
	width: 600px;
	margin-top:200px;
}
#submit_btn {
	margin-left:133px;
	height:30px;
	width: 221px;
}
</style>
<center> <h1>Salary Generation </h1>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)</center>
<br /><br />
<center> <font color="#CC3399">( First 20 Employees are displayed as per the Alphabetical Order whose Salary is not processed )</font> </center>
<br/><br/>
<form method="post" action="hr_salary_savegen.php" id="salform" name="salform" onsubmit="return check()" >
<center>
<table>
<td><strong>Sector</strong>&nbsp;</td>
<td><select name="sector" id="sector" onchange="funmnth();" style="width: 100px" >
<option value="">-Select-</option>
 <?php
           include "config.php"; 

           $query121 = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC";

           $result121 = mysql_query($query121,$conn); 

           while($row121 = mysql_fetch_assoc($result121))

           {

           ?>

<option value="<?php echo $row121['sector']; ?>" <?php if($sector == $row121['sector']) { ?> selected="selected" <?php } ?> title="<?php echo $row121['sector']; ?>"><?php echo $row121['sector']; ?></option>

<?php } ?>



</select></td>

&nbsp;
<br />
<td>
<strong>Designation</strong>&nbsp;</td>
<td>

<select name="desig" id="desig" onchange="funmnth();" style="width: 100px">

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



</select></td>

&nbsp;
<td>
<strong>Generation Date </strong>&nbsp;</td>
<td>

<input type="text" id="date" name="date" size="15" value="<?php echo $date;?>" class="datepicker" onchange="funmnth()" />

</td>

&nbsp;
<td>

<strong>Month </strong>

&nbsp;
</td>
<td>


<select id="month" onChange="funmnth();" name="month">

<option value="0">-Select- </option>

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
</td>


&nbsp;
<td><strong>Year </strong></td>
<td>

<select name="year" id="year" onChange="funmnth();">
<option value="">-Select-</option>
<option value="2013" <?php if("2013" == $year) { ?> selected="selected" <?php } ?>>2013</option>
<option value="2014" <?php if("2014" == $year) { ?> selected="selected" <?php } ?>>2014</option>
<option value="2015" <?php if("2015" == $year) { ?> selected="selected" <?php } ?>>2015</option>
<option value="2016" <?php if("2016" == $year) { ?> selected="selected" <?php } ?>>2016</option>
<option value="2017" <?php if("2017" == $year) { ?> selected="selected" <?php } ?>>2017</option>
</select>
&nbsp;
</td>
<td>
<strong>CoaCode</strong>
</td>
<td>
<select name="coacode" id="coacode" style="width: 80px">
 <?php

           include "config.php"; 

           $query121 = "SELECT code,description FROM `ac_coa` where type='Expense' and (code not in (select distinct iac from ims_itemcodes) and code not in (SELECT vca FROM `ac_vgrmap`) and code not in (SELECT vppac FROM `ac_vgrmap`) and code not in (SELECT distinct salaryac FROM `hr_employee`) and code not in (SELECT distinct loanac FROM `hr_employee`)) order by code";

           $result121 = mysql_query($query121,$conn); 

           while($row121 = mysql_fetch_assoc($result121))

           {

           ?>

<option value="<?php echo $row121['code']; ?>" <?php if($row121['code']=="OXAE47"){?> selected="selected"<?php } ?> title="<?php echo $row121['description']; ?>" >
<?php echo $row121['code']; ?>
</option>

<?php } ?>





</select></td>
</table>
</center>

<br />

<?php

$date100 = explode(".",$date);

$month1 = $date100[1];

$monthq = $_GET['month'];


$yearq = $_GET['year'];

$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

$dateq = $days_in_month[$monthq-1] ."." . $monthq . "." . $yearq;
$query = "select * from hr_employee where sector $sc '$sector' and designation $dc '$desig' and employeeid not in (select distinct(eid) from hr_salary_payment where month1 = '$monthq' and year1 = '$yearq')  and employeeid not in (select distinct(eid) from hr_salary_generation where month1 = '$monthq' and year1 = '$yearq') order by name ASC limit 0,20 ";

$rquery = mysql_query($query,$conn) or die(mysql_error());
$desc="";
$q2="SELECT code,description FROM `hr_params` WHERE coa != '' order by code ";
$r2=mysql_query($q2,$conn);
$j=0;
while($row=mysql_fetch_assoc($r2))
{
	$desc=$desc.$row['code']."`,`";
	$des[$j]=$row['code'];
	$de1[$j]=$row['description'];
	$j=$j+1;
	}
	$desc="`".substr($desc,0,strlen($desc)-2);
	$n=11+(($j-1)*2);
?>

<table align="center" width="1000" <?php if(mysql_num_rows($rquery) == 0) {?> style="visibility:hidden" <?php } ?>> 
<tr align="center">
<td width="50" rowspan="2">&nbsp; &nbsp;</td>

<td width="50" rowspan="2"><strong>Emp ID</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="100" rowspan="2"><strong>Name</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="70" rowspan="2"><strong>Gross Salary</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="70" title="Advance Amount/Previous Balance" rowspan="2">
<strong>Adv./P. Bal.</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="75" rowspan="2"><strong>Allowances</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td colspan="<?php echo $n;?>"><strong>Deductions</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td title="Salary Paid" width="50" rowspan="2">
<strong>Net Sal. Paid<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
</tr>
<tr align="center">
<td title="Add Previous Balance" width="75">
<strong>P.Bal. Add.</strong></td>
<td width="1">&nbsp;</td>
<td title="Deduction From Advance/Loan taken" width="50">
<strong>Adv. Ded.</strong></td>
<td width="1">&nbsp;</td>
<td title="Other Deductions" width="50">
<strong>O. Ded.</strong></td>

<?php 

	for($m=0;$m<$j;$m++)
	{
?>
<td width="1">&nbsp;</td>
<td width="70">
<strong><?php echo $de1[$m]; ?></strong></td>
<?php } ?>
<td width="1">&nbsp;</td>
<td width="80">
<strong>PF</strong></td>
<td width="1">&nbsp;</td>
<td width="80">
<strong>Income Tax</strong></td>
<td width="1">&nbsp;</td>
<td title="Total Salary Per Month" width="65">
</tr>

<input type="hidden" id="dateq" name="dateq" value="<?php echo $dateq; ?>" />

<tr height="10px"><td></td></tr>



<?php 

$i = 0;

while($r = mysql_fetch_assoc($rquery))

{

$subquery = "select * from hr_salary_generation where eid = '$r[employeeid]'";

$rsubquery = mysql_query($subquery,$conn) or die(mysql_error());

$dateqcc = date("Y-m-d", strtotime($dateq));
$rsQuery=mysql_query("SELECT sector,designation FROM hr_employee WHERE employeeid='$r[employeeid]'");
$rsDataSector=mysql_fetch_assoc($rsQuery);
 $sector=$rsDataSector['sector'];
 $designation=$rsDataSector['designation'];
//echo 

$salparamid =0;
  $queryforsal = "select salary,id from hr_salary_parameters where  eid = '$r[employeeid]'  and fromdate<= '$dateqcc' and todate >= '$dateqcc' and sector='$sector' and designation='$designation' order by id DESC Limit 1 ";

$rsforsal = mysql_query($queryforsal,$conn) or die(mysql_error());

while($rforsal = mysql_fetch_assoc($rsforsal))

{

  $salsal = $rforsal['salary'];

 $salparamid =$rforsal['id'];

}


if($salsal == "")

$salsal = 0;

//echo $salsal;

if( $salsal != 0 )

{

?>

<tr align="center">

<input type="hidden" id="salparamid<?php echo $i;?>" name="salparamid[]" value="<?php echo $salparamid;?>"/>

<?php

 $qsalproc = "SELECT `procedure` FROM hr_salary_procedure limit 1";

  $ressalproc = mysql_query($qsalproc,$conn); 

  while($rowsalproc = mysql_fetch_assoc($ressalproc))

  {

	  $proc = $rowsalproc['procedure'];

  }



  if($proc == "Attendance")

  {

////////// Calculation of sal from attendance 

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

	  

if($r['salarytype'] == "Daily")

{	  

	  $salsal = $r['salary']* $totaldays;	  

}

else

{



	  $dateofjoin = $r['joiningdate'];

	  $qminattdate ="SELECT min(date) as mindate  FROM `hr_attendance` where eid='$r[employeeid]'";

 	  $qminattdater = mysql_query($qminattdate,$conn) or die(mysql_error());

	  if($qminattdaters = mysql_fetch_assoc($qminattdater))

	  {

	  $minattdate = $qminattdaters['mindate'];

	  }

	  

	  if($dateofjoin != "" && $minattdate == "")

	  {

	  $dateatt = $dateofjoin;

	  }

	  else if($dateofjoin != "" && $minattdate == "")

	  {

	  $dateatt = $minattdate;

	  }

	  else if(strtotime($dateofjoin) < strtotime($minattdate))

	  {

	  $dateatt = $minattdate;

	  }

	  else if(strtotime($dateofjoin) > strtotime($minattdate))

	  {

	  $dateatt = $dateofjoin;

	  } 



////////// counting total days present //////////////////	

if($monthq != 1)

{

$monthbef = $monthq-1;

$yearbef = $yearq;

}

else

{

$monthbef = 12;

$yearbef = $yearq-1;

}

$datebef =  $days_in_month[$monthbef-1] ."." . $monthbef . "." . $yearbef;

$datebef = date("Y-m-d", strtotime($datebef));  

	  //echo  

	  $qtt ="SELECT count(*) as noofdays FROM `hr_attendance` where eid='$r[employeeid]' and date >='$dateatt' and date <='$datebef' and daytype='Half' and client='$client'";

 $qttr = mysql_query($qtt,$conn) or die(mysql_error());

	  if($qttrs = mysql_fetch_assoc($qttr))

	  {

	//echo  

	 $tothalf = $qttrs['noofdays'];

	  }

	//echo  

	$qtt ="SELECT count(*) as noofdays FROM `hr_attendance` where eid='$r[employeeid]' and date >='$dateatt' and date <='$datebef' and daytype='Full' and client='$client'";

 $qttr = mysql_query($qtt,$conn) or die(mysql_error());

	  if($qttrs = mysql_fetch_assoc($qttr))

	  {

	//echo   

	$totfull = $qttrs['noofdays'];

	  }

	  $totpresent =  $tothalf + $totfull;

	 

///////////end of counting total days present /////////////

	 

	$datenow = date("Y-m-d", strtotime($dateq));

	 //echo $datenow.$dateatt;

	 $diff = abs(strtotime($datenow) - strtotime($dateatt)); 

	// echo $diff/(60*60*24);

	  //echo "years";echo 

	  $years = floor($diff / (365*60*60*24));

	   //echo "mnths";echo 

	   $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 

	  // echo "days";echo $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)) +$years*5; 

	  //echo "days";echo 

	  $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	  

	   $totalmnths =0;

	   if($days >5)

	   {

	   $totalmnths = ($years*12) + $months + 1;

	   }

	   else

	   {

	   $totalmnths = ($years*12) + $months;

	   }

	  // echo "total mnths"; echo $totalmnths;

	   

$leavespermnth = 0;	  $forwared =0; 

$queryforleaves = "select allowedleaves,forwardmnths from hr_mnthleaves where  designation = '$r[designation]'";

$rsforleaves= mysql_query($queryforleaves,$conn) or die(mysql_error());

while($rforleaves = mysql_fetch_assoc($rsforleaves))

{

 $leavespermnth = $rforleaves['allowedleaves'];

 $forwared = $rforleaves['forwardmnths'];

}

//echo "total leaves allowed "; echo 

$totleavesallow = $leavespermnth * $totalmnths;



$initialleaves = $r['leaves'];

if($initialleaves == "")

{

$initialleaves = 0;

}

$totleavesallow = $totleavesallow + $initialleaves;

//echo 

$dateattyr = substr($dateatt,0,4);

//echo 

$dateattmnth = substr($dateatt,5,2);



$totworking = 0;



//echo 

$query1fortotwork="select sum(noofdays) as  noofdays from hr_working_days where month >= '$dateattmnth' and month <= '$monthbef' AND year >= '$dateattyr' and year <= '$yearbef' ";

$result1fortotwork = mysql_query($query1fortotwork,$conn); 

while($row1fortotwork = mysql_fetch_assoc($result1fortotwork))

{

//echo  

$totworking = $row1fortotwork['noofdays'];

}

//echo "totalworking ";echo $totworking;

//echo "totpresent ";echo $totpresent;

//echo "totleaveshis "; echo 

$totleaveshis = $totworking - $totpresent;

$leaveremain = $totleavesallow - $totleaveshis;



$leavesdedbef =0;

$qleavesded="select sum(leavesded) as leavesded from hr_salary_generation where eid >= '$r[employeeid]'";

$resleavesded = mysql_query($qleavesded,$conn); 

while($rowleavesded = mysql_fetch_assoc($resleavesded))

{

$leavesdedbef = $rowleavesded['leavesded'];

}

//echo "leaveremain ";echo 

$leaveremain = $leaveremain + $leavesdedbef;





//echo "totforwardleaves ";echo 

$totforwardleaves = $forwared*$leavespermnth;



/*if($totleavesallow > $totforwardleaves)

{

$finalleavesremainhis = $totforwardleaves;

}

else

{

$finalleavesremainhis = $totleavesallow ;

}*/

if($leaveremain >$totforwardleaves)

{

$finalleavesremainhis = $totforwardleaves;

}

else if($leaveremain <$totforwardleaves)

{

$finalleavesremainhis = $leaveremain;

}

//echo "finakl leaveremain ";echo $finalleavesremainhis;

$query1="select noofdays from hr_working_days where month = '$monthq' AND year = '$yearq' '";

$result1 = mysql_query($query1,$conn); 

while($row1 = mysql_fetch_assoc($result1))

{

 $workingdaysofcurr = $row1['noofdays'];

}

//echo "dayspresent ";echo $totaldays;

if($totaldays >= ($workingdaysofcurr - $finalleavesremainhis))

{

$daysofsal = $workingdaysofcurr;

}

else

{

$daysofsal = $totaldays + $finalleavesremainhis;

}



//echo "days present for sal ";echo $daysofsal;

$leavesded =0;

//echo "leaves deducted for sal ";echo 

$leavesded = $workingdaysofcurr - $daysofsal;



$salsal = ($r['salary']* $daysofsal)/$workingdaysofcurr;

	

} 



//////////End of  Calculation of sal from attendance 

}

else  if($proc == "Monthly Attendance")

{


if(($yearq/4)==0)
$monthdays=array("01"=>31,"02"=>29,"03"=>31,"04"=>30,"05"=>31,"06"=>30,"07"=>31,"08"=>31,"09"=>30,"10"=>31,"11"=>30,"12"=>31);
else
$monthdays=array("01"=>31,"02"=>28,"03"=>31,"04"=>30,"05"=>31,"06"=>30,"07"=>31,"08"=>31,"09"=>30,"10"=>31,"11"=>30,"12"=>31);

//////////salary calc from mnthly attendance
$ds=0;
foreach($monthdays as $mnths=>$dys)
{

if($mnths==$monthq)
{
$ds=$dys;
//echo $mnths.$monthq;
}
}




$firstdate=$yearq."-".$monthq."-01";
$lastdate=$yearq."-".$monthq."-".$ds;

if(strtotime($r[joiningdate]) <strtotime($firstdate))
{
$ds1=explode('-',$r[joiningdate]);
$ds=$ds-$ds1[2];
}
$leavesded =0;
$workd=0;
$workedactual=ds;
 $qtt ="SELECT fromdate,todate,flag,leavestaken FROM `hr_newattendance` where employee='$r[name]' and fromdate between '$firstdate' and '$lastdate' and client='$client'";

 $qttr = mysql_query($qtt,$conn) ;

	  while($qttrs = mysql_fetch_assoc($qttr))

	  {
	  $fd=strtotime($qttrs[fromdate]);
	  $td=strtotime($qttrs[todate]);
	  $f1d=strtotime($firstdate);
	  $ld=strtotime($lastdate);
	 // echo $qttrs[flag];
	// echo  $qttrs[fromdate]."sec".$fd."<br>";
	// echo $qttrs[todate]."sec".$td."<br>";
	  //echo $lastdate."sec".$ld."<br>";
	  
	  
	  
	  
	  if($fd<=$ld && $td<=$ld && $qttrs[flag]==1)
	  {
	  $workdactual=$workdactual-$qttrs[leavestaken];
	  }
	  else if($fd<=$ld && ($td>$ld || $td==$fd))
	  {
	  $qt=mysql_query("select datediff('$lastdate','$qttrs[fromdate]') as dif",$conn) or die(mysql_error());
	  $rt=mysql_fetch_array($qt);
	  $workdactual=$workdactual-$rt[dif];
	  }
	  else
	  {
	  //echo $workdactual=$ds;
	  }
	  }


  $mnthtotaldays = $ds; 

//echo $workdactual;
//echo $workd;
//echo $r['salarytype'];
if($r['salarytype'] == "Daily")

{	  

  $salsal = $r['salary']* $workdactual;

}

else

{
 $salsal = ($r['salary']* $workdactual)/$mnthtotaldays; 

}

////////end of salary calc from mnthly attendance

}

if($salsal>0)
{

?>
<td>
<input type="checkbox" id="c<?php echo $i ?>" name="c[]" onclick="cal_checkbox(this.id)" value="<?php echo $r['employeeid']; ?>" />
</td>
<td>
<input type="text" style="width: 50px; color:#0000FF; background:none; border:none;" id="employeeid<?php echo $i; ?>" name="employeeid[]"  readonly value="<?php echo $r['employeeid']; ?>" /></td>
<td width="1">&nbsp;</td>
<td>
<input type="hidden" name="leavesded[]" id="leavesded<?php echo $i;?>" value="<?php echo $leavesded;?>"/>
<input type="text" style="width: 100px; color:#0000FF;  background:none; border:none;" id="employeename<?php echo $i; ?>" name="employeename[]"  readonly value="<?php echo $r['name']; ?>" /></td>
<td width="1">&nbsp;</td>
<td>
<input type="text" style="width: 70px;text-align:right;color:#0000FF;  background:none; border:none;" id="totalsalary<?php echo $i; ?>" name="totalsalary[]"  readonly value="<?php echo round($salsal,2); ?>" /></td>
<?php 
	
	$datecc = date("Y-m-d",strtotime($dateq));	
 $qb = "select sum(amount) as sumcramount from ac_financialpostings where venname='$r[name]' and crdr = 'Cr' and coacode ='$r[loanac]' and date < '$datecc'"; 
	$qbr = mysql_query($qb,$conn) or die(mysql_error());
	  if($qbrs = mysql_fetch_assoc($qbr))
	  {
	  //echo "cramt ";echo  
	  $sumcramount = $qbrs['sumcramount'];
	 }
//echo "<br>";		 
$qc = "select sum(amount) as sumdramount from ac_financialpostings where  venname='$r[name]' and  crdr = 'Dr' and coacode = '$r[loanac]' and date < '$datecc'"; 
	 $qcr = mysql_query($qc,$conn) or die(mysql_error());
	  if($qcrs = mysql_fetch_assoc($qcr))
	  {
	   //echo "dramt "; echo   
	   $sumdramount = $qcrs['sumdramount'];
	 }
	//echo "finaladv ";echo	  
	$finadv = $sumdramount - $sumcramount;
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
 
?>
<td width="1">&nbsp;</td>
<td>
<input type="text" readonly  style="width: 70px;text-align:right;color:#0000FF;  background:none; border:none;" id="bal<?php echo $i; ?>" name="bal[]" value="<?php if($finadv>0) { echo round($finadv,2)."(Adv)"; } else if($oldbal>0) {echo round($oldbal,2)."(P.Bal)"; } else { echo 0;} ?>"  /></td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right;color:#0000FF;" id="allowances<?php echo $i; ?>" name="allowances[]" value="0" onkeyup="bala(<?php echo $i; ?>);" onkeypress="validatekey(event.keyCode)" readonly="readonly"/></td>
<td width="1">&nbsp;</td>
<td>
<input type="text" <?php if($finadv>0 || $oldbal==0) {?> readonly="readonly" <?php } ?>  style="width: 50px;text-align:right;color:#0000FF;" id="addpbal<?php echo $i; ?>" name="addpbal[]" value="0" onkeyup="bala(<?php echo $i; ?>);" onkeypress="validatekey(event.keyCode)" /></td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  <?php if($oldbal>0 || $finadv==0) { ?> readonly="readonly" <?php } ?>  style="width: 50px;text-align:right;color:#0000FF;" id="advdeduction<?php echo $i; ?>" name="advdeduction[]" value="0" onkeyup="bala(<?php echo $i; ?>);" onkeypress="validatekey(event.keyCode)" />
<input type="hidden"  id="advcode<?php echo $i; ?>" name="advcode[]" value="<?php echo $r[loanac];?>" readonly="readonly"/></td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right;color:#0000FF;" id="deduction<?php echo $i; ?>" name="deduction[]" value="0" onkeyup="bala(<?php echo $i; ?>);" onkeypress="validatekey(event.keyCode)" readonly="readonly"/></td>
<td width="1">&nbsp;</td>

<?php $ewf=0;
$tot=0;
$rsQuery=mysql_query("SELECT sector,designation FROM hr_employee WHERE employeeid='$r[employeeid]'");
		$rsDataSector=mysql_fetch_assoc($rsQuery);
		$sector=$rsDataSector['sector'];
		$designation=$rsDataSector['designation'];
		
 $qu="SELECT $desc FROM `hr_salary_parameters`  where eid = '$r[employeeid]'  and fromdate<= '$dateqcc' and todate >= '$dateqcc' and sector='$sector' and designation='$designation' ";
$re=mysql_query($qu,$conn);
$num=mysql_num_rows($re);  
if($num>0)
{
while($ro=mysql_fetch_array($re))
{
	for($k=0;$k<$j;$k++)
	{  $ewf=$ro[$des[$k]];
		$tot+=$ewf;
 $qu1="SELECT  `coa` FROM hr_params where code='$des[$k]' ";

$re1=mysql_query($qu1,$conn);
$ro1=mysql_fetch_assoc($re1);	

?> <td>
<input type="text"  style="width: 50px;text-align:right; background:none; border:none;color:#0000FF;" id="<?php echo "ewf".$k.$i; ?>" name="<?php  echo "ewf".$k; ?>[]" value="<?php if($ewf!=""){echo $ewf;} else {echo 0;}?>" readonly="readonly"/>
<input type="hidden" value="<?php echo $ewf."@".$des[$k];?>" name="params[]" />
<input type="hidden"  id="<?php echo "ewfcode".$k.$i; ?>" name="<?php echo "ewfcode".$k; ?>[]" value="<?php if($ewf!=0){echo $ro1['coa']; } else {}?>" readonly="readonly"/>
</td>
<td width="1">&nbsp;</td>
<?php 
}
	} }
	else
	{
		for($k=0;$k<$j;$k++)
	{
?> <td>
<input type="text"  style="width: 50px;text-align:right; background:none; border:none;color:#0000FF;" id="<?php echo "ewf".$k.$i; ?>" name="<?php echo "ewf".$k; ?>[]" value="0" readonly="readonly"/>
<input type="hidden"  id="<?php echo "ewfcode".$k.$i; ?>" name="<?php echo "ewfcode".$k; ?>[]" value="0" readonly="readonly"/>
</td>
<td width="1">&nbsp;</td>
<?php 
} }
	?>
<td>
<?php ?>
<?php 
$salsal3=$salsal*12;
 $qu="SELECT `tax`,coa FROM `hr_pf` where `salfrom`<='$salsal3' and `salto`>='$salsal3'";
$re=mysql_query($qu,$conn);
$ro=mysql_fetch_assoc($re);


 //$pf=($salsal*$ro['tax'])/100;
 
 $pf=$ro['tax'];
 
 
 
?>
<input type="text"  style="width: 50px;text-align:right; background:none; border:none;color:#0000FF;" id="pf<?php echo $i; ?>" name="pf[]" value="<?php if($ro['tax']>0){ echo $ro['tax'];} else { echo 0;}?>" readonly="readonly"/>
<input type="hidden"  id="pfcode<?php echo $i; ?>" name="pfcode[]" value="<?php echo $ro['coa'];?>" readonly="readonly"/></td>
<td width="1">&nbsp;</td>
<td>
<?php 
$salsal2=$salsal*12;
 $qu="SELECT `fromsal`, `tosal`, `balamtded`, `amtexceeded`, `deductionper`, `coa` FROM `hr_incometax` where `fromdate`<='$datecc' and `todate`>='$datecc' and `fromsal`<='$salsal2' and `tosal`>='$salsal2' ";
$re=mysql_query($qu,$conn);
$ro=mysql_fetch_assoc($re);

$balamtded=$ro['balamtded'];
$amtexceeded=$ro['amtexceeded'];
$deductionper=$ro['deductionper'];
$tax=$salsal*12;
  $tax=$balamtded+(($tax-$amtexceeded)*($deductionper/100));
if($tax>0) {$tax=round(($tax/12),2);}
else { $tax=0; }
?>
<input type="text"  style="width: 50px;text-align:right; background:none; border:none;color:#0000FF;" id="incometax<?php echo $i; ?>" name="incometax[]" value="<?php echo $tax;?>" readonly="readonly" />
<input type="hidden"  id="itcode<?php echo $i; ?>" name="itcode[]" value="<?php echo $ro['coa'];?>"  /></td>
<td width="1">&nbsp;</td>
<td>
<?php //echo $salsal."-".$tot."-".$pf."-".$tax;?>

<input type="text"  readonly="readonly"  style="width: 70px;text-align:right;color:#0000FF; background:none; border:none" id="paid<?php echo $i; ?>" name="paid[]" value="<?php echo round(($salsal-$tot-$pf-$tax) ,2); ?>" /></td>  
<td><span id="availability_status<?php echo $i; ?>"></span> </td>

</tr>
<tr height="10px"><td></td></tr>
<?php $i++; } } 
} ?>
</table>
<table align="center" <?php if(mysql_num_rows($rquery) == 0) { ?> style="visibility:hidden" <?php } ?>>
<tr>
<td colspan="4" align="center">
<input type="submit" value = "Pay"  id="save"/>
</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input name="button" type="button" onclick="document.location = 'dashboardsub.php?page=hr_salary_gen';" value = "Cancel" id="cancel"/>
<input type="hidden" id="j" name="j" value="<?php echo $j;?>"  />
</td>
<td>&nbsp;</td>
</tr>
</table><br />

<table id="tab1">
</table>
</form>

<script type="text/javascript">
function checkbal(a)
{
var bala=document.getElementById('bal' + a ).value;
bal=bala.split("(");
	if( Number(bal[0])<  Number(document.getElementById('addpbal' + a ).value))	
	{
		alert("Enter the amount less then or equal to P.Bal");
		document.getElementById('addpbal' + a ).value=0;
		document.getElementById('addpbal' + a ).focus();
		}
	if(  Number(document.getElementById('totalsalary' + a ).value)<  Number(document.getElementById('addpbal' + a ).value))	
	{
		alert("Enter the amount less then or equal to Gross Salary");
		document.getElementById('addpbal' + a ).value=0;
		document.getElementById('addpbal' + a ).focus();
		}
}
function checkded(a)
{var bala=document.getElementById('bal' + a ).value;
bal=bala.split("(");
	if( Number(bal[0])< Number(document.getElementById('advdeduction' + a ).value))	
	{
		alert("Enter the amount less then or equal to Adv");
		document.getElementById('advdeduction' + a ).value=0;
		document.getElementById('advdeduction' + a ).focus();
		}
	if(  Number(document.getElementById('totalsalary' + a ).value)< Number(document.getElementById('advdeduction' + a ).value))	
	{
		alert("Enter the amount less then or equal to Gross Salary");
		document.getElementById('advdeduction' + a ).value=0;
		document.getElementById('advdeduction' + a ).focus();
		}
}
function validatekey(a)
{ 

 if((a<48 || a>57) && a!=46 && a!=13)	
   event.keyCode=false;
}
function check()
	{	
	var flag=0;
	var tab=document.getElementById("tab1");
var td=document.createElement("td");
var tr=document.createElement("tr");
var inp1=document.createElement("input");
inp1.type="hidden";
td.appendChild(inp1);
tr.appendChild(td);
tab.appendChild(tr);
inp1.id="asd";
inp1.name="vals";
var dat="";
var j=parseInt("<?php echo $i;?>");
for(var k=0;k<j;k++)
	{
		if(document.getElementById('c'+k).checked)
			{
				flag=1;
				dat=dat+document.getElementById('c'+k).value+"/";
				if(document.getElementById('paid' + k ).value=="" || document.getElementById('paid' + k ).value=="0")
					{ 
						alert("Please Enter the Salary");
						document.getElementById('paid' + k ).focus();
						return false;
					}	
				
				}
			}
			if(flag==0)
			{
				alert("Select Atleast One Employee");
				return false;
			}
			inp1.value=dat;
			//alert(dat);
			
			document.getElementById("save").disabled=true;
			document.getElementById("cancel").disabled=true;
			
			return true;
	}




var j=Number("<?php echo $j-1;?>");
function bala(i)
{

checkded(i);
checkbal(i);
if(document.getElementById('paid' + i).value == '') { document.getElementById('paid' + i).value = 0;}

if(document.getElementById('deduction' + i).value == '') { document.getElementById('deduction' + i).value = 0;}

if(document.getElementById('advdeduction' + i).value == '') { document.getElementById('advdeduction' + i).value = 0;}
if(document.getElementById('addpbal' + i).value == '') { document.getElementById('addpbal' + i).value = 0;}
if(document.getElementById('allowances' + i).value == '') { document.getElementById('allowances' + i).value = 0;}
var ewft=0;
for(var k=0;k<=j;k++)
{
if(document.getElementById('ewf'+ k+ i).value == '') { document.getElementById('ewf'+k + i).value = 0;}
else
{
	ewft=parseFloat(ewft)+parseFloat(document.getElementById('ewf'+k + i).value)
	}
}
if(document.getElementById('pf' + i).value == '') { document.getElementById('pf' + i).value = 0;}

if(document.getElementById('incometax' + i).value == '') { document.getElementById('incometax' + i).value = 0;}

var finpaid = parseFloat(document.getElementById('totalsalary' + i).value) - parseFloat(document.getElementById('deduction' + i).value) - parseFloat(document.getElementById('advdeduction' + i).value)- parseFloat(ewft)- parseFloat(document.getElementById('pf' + i).value)- parseFloat(document.getElementById('incometax' + i).value) + parseFloat(document.getElementById('allowances' + i).value)+ parseFloat(document.getElementById('addpbal' + i).value);
document.getElementById('paid' + i).value = finpaid;

}
function removeAllOptions(selectbox)
{	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}




function checknoofemps()

{



if(document.getElementsByName('paid').length == 0)

{

document.getElementById('headid').style.visibility = 'hidden';

document.getElementById('errormsg').style.visibility = 'visible';

}



}

function funmnth()

{

var mnth =  document.getElementById('month').value;
var mnth2 =  document.getElementById('date').value; 
var mnth2arr = new Array();
mnth2arr =  mnth2.split(".");
var year= document.getElementById('year').value;
var mnth22 = mnth2arr[1];

if(year==mnth2arr[2])
{
	if(mnth > mnth2arr[1])
	
	{
	
		alert("Month should be less than paying date");
		document.getElementById('month').focus();
		document.getElementById('month').value=0;
		return false;
		
	
	}
	
	else
	
	{
	
		var sector = document.getElementById('sector').value;	
		var desig = document.getElementById('desig').value;	
		var date = document.getElementById('date').value;	
		var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
		document.location = "dashboardsub.php?page=hr_salary_addgen&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month+ "&year=" + year;
	
	}
	
}

else if(year<mnth2arr[2])

{


	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
	document.location = "dashboardsub.php?page=hr_salary_addgen&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month+ "&year=" + year;

}

else

{

	alert("Month & Year should be less than paying date");
		document.getElementById('month').focus();
		document.getElementById('month').value=0;
		document.getElementById('year').value="";
		return false;
		

}

}
function cal_checkbox(ida)
{
	var str=ida.substring(1);
	if(document.getElementById(ida).checked)
	{
		document.getElementById("allowances"+str).readOnly=false;
		document.getElementById("deduction"+str).readOnly=false;
		document.getElementById("employeeid"+str).style.color="#FF0000";
		document.getElementById("employeename"+str).style.color="#FF0000";
		document.getElementById("totalsalary"+str).style.color="#FF0000";
		document.getElementById("bal"+str).style.color="#FF0000";
		document.getElementById("allowances"+str).style.color="#FF0000";
		document.getElementById("addpbal"+str).style.color="#FF0000";
		document.getElementById("advdeduction"+str).style.color="#FF0000";
		document.getElementById("deduction"+str).style.color="#FF0000";
		document.getElementById("pf"+str).style.color="#FF0000";
		document.getElementById("incometax"+str).style.color="#FF0000";
		document.getElementById("paid"+str).style.color="#FF0000";
		
	}
	else
	{
		
		document.getElementById("allowances"+str).readOnly=true;
		document.getElementById("deduction"+str).readOnly=true;
		document.getElementById("employeeid"+str).style.color="#0000FF";
		document.getElementById("employeename"+str).style.color="#0000FF";
		document.getElementById("totalsalary"+str).style.color="#0000FF";
		document.getElementById("bal"+str).style.color="#0000FF";
		document.getElementById("allowances"+str).style.color="#0000FF";
		document.getElementById("addpbal"+str).style.color="#0000FF";
		document.getElementById("advdeduction"+str).style.color="#0000FF";
		document.getElementById("deduction"+str).style.color="#0000FF";
		document.getElementById("pf"+str).style.color="#0000FF";
		document.getElementById("incometax"+str).style.color="#0000FF";
		document.getElementById("paid"+str).style.color="#0000FF";
		
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

