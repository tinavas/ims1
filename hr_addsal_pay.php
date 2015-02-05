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


<script type="text/javascript">
<?php 

 $query = "select * from hr_salary_generation where sector $sc '$sector' and designation $dc '$desig' and eid not in (select distinct(eid) from hr_salary_payment where month1 = '$monthq' and year1 = '$yearq') order by name ASC limit 0,20 ";

$rquery = mysql_query($query,$conn) or die(mysql_error());
$n1 = mysql_num_rows($rquery);

for($k=0;$k<$n1;$k++) {
?>
$(document).ready(function()//When the dom is ready 
{
$("#cddno<?php echo $k;?>").change(function() 
{ //if theres a change in the username textbox

var cddno = $("#cddno<?php echo $k;?>").val();//Get the value in the username textbox
var cno = $("#code<?php echo $k;?>").val();
if(cddno.length > 3)//if the lenght greater than 3 characters
{
$("#availability_status").html('<img src="loader.gif" align="absmiddle">&nbsp;Checking availability...');
//Add a loading image in the span id="availability_status"

$.ajax({  //Make the Ajax Request
    type: "POST",  
    url: "ajax_check_username4.php",  //file name
    data: "cddno="+ cddno +"&cno="+cno,  //data
    success: function(server_response){  
   
   $("#availability_status<?php echo $k;?>").ajaxComplete(function(event, request){ 

	if(server_response == '0')//if ajax_check_username.php return value "0"
	{ 
	$("#availability_status<?php echo $k;?>").html('<img src="available.png" align="absmiddle"> <font color="Green">Cheque Number is Available </font>  ');
	//add this image to the span with id "availability_status"
	}  
	else  if(server_response == '1')//if it returns "1"
	{  
	 $("#availability_status<?php echo $k;?>").html('<img src="not_available.png" align="absmiddle"> <font color="red">Cheque Number is Already Used </font>');
	 
	}  
   
   });
   } 
   
  }); 

}
else
{

$("#availability_status<?php echo $k;?>").html('<font color="#cc0000">Cheque Number is too  short</font>');
//if in case the username is less than or equal 3 characters only 
}



return false;
});

});
<?php } ?>
</script>

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
<center> <h1>Salary Payment </h1>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)</center>
<br /><br />
<center> <font color="#CC3399">( First 20 Employees are displayed as per the Alphabetical Order whose Salary is not processed )</font> </center>
<br/><br/>
<form method="post" action="hr_savesal_pay.php" id="salform" name="salform" onsubmit="return check()">
<center> 
<strong>Sector</strong>&nbsp;&nbsp;
<select name="sector" id="sector" onchange="funmnth();">
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



</select>

&nbsp;&nbsp;&nbsp;

<strong>Designation</strong>&nbsp;&nbsp;

<select name="desig" id="desig" onchange="funmnth();">

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

<input type="text" id="date" name="date" size="15" value="<?php echo $date;?>" class="datepicker" onchange="funmnth()" />



&nbsp;&nbsp;&nbsp;

<strong>Month </strong>

&nbsp;&nbsp;



<select id="month" onChange="funmnth();" name="month">

<option value="0"> Select </option>

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
<strong>Year </strong>

&nbsp;&nbsp;
<select name="year" id="year" onChange="funmnth();">
<option value="">--Select--</option>
<option value="2013" <?php if("2013" == $year) { ?> selected="selected" <?php } ?>>2013</option>
<option value="2014" <?php if("2014" == $year) { ?> selected="selected" <?php } ?>>2014</option>
<option value="2015" <?php if("2015" == $year) { ?> selected="selected" <?php } ?>>2015</option>
<option value="2016" <?php if("2016" == $year) { ?> selected="selected" <?php } ?>>2016</option>
<option value="2017" <?php if("2017" == $year) { ?> selected="selected" <?php } ?>>2017</option>
</select>
</center>

<br />

<?php

$date100 = explode(".",$date);

$month1 = $date100[1];

$monthq = $_GET['month'];


$yearq = $_GET['year'];

$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

$dateq = $days_in_month[$monthq-1] ."." . $monthq . "." . $yearq;
 $query = "select * from hr_salary_generation where sector $sc '$sector' and designation $dc '$desig' and eid not in (select distinct(eid) from hr_salary_payment where month1 = '$monthq' and year1 = '$yearq') and  month1 = '$monthq' and year1 = '$yearq' order by name ASC limit 0,20 ";

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

<table align="center" width="1203" <?php if(mysql_num_rows($rquery) == 0) {?> style="visibility:hidden" <?php } ?>> 
<tr align="center">
<td width="50" rowspan="2">&nbsp; &nbsp;</td>

<td width="50" rowspan="2"><strong>Emp ID</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="100" rowspan="2"><strong>Name</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="70" rowspan="2"><strong>Gross Salary</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="75" rowspan="2"><strong>Allowances</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td colspan="<?php echo $n;?>"><strong>Deductions</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td title="Salary Paid" width="50" rowspan="2">
<strong>Net Sal. Paid<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td title="Payment Mode" width="62" rowspan="2">
<strong>Payment Mode<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td title="Code" width="50" rowspan="2">
<strong>Code</strong></td>
<td width="1" rowspan="2">&nbsp;</td>
<td width="63" rowspan="2" id="cdd" >
<strong>Cheque&nbsp;#</strong></td>
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


?>
<tr align="center">

<td><input type="hidden" id="salparamid<?php echo $i;?>" name="salparamid[]" value="<?php echo $r['salparamid'];?>"/>
<input type="checkbox" id="c<?php echo $i ?>" name="c[]" onclick="cal_checkbox(this.id)" value="<?php echo $r['eid']; ?>" />
</td>
<td>
<input type="text" style="width: 50px; color:#0000FF; background:none; border:none;" id="employeeid<?php echo $i; ?>" name="employeeid[]"  readonly value="<?php echo $r['eid']; ?>" />
</td>
<td width="1">&nbsp;</td>
<td>
<input type="hidden" name="leavesded[]" id="leavesded<?php echo $i;?>" value="<?php echo $r['leavesded']; ?>"/>
<input type="text" style="width: 100px; color:#0000FF;  background:none; border:none;" id="employeename<?php echo $i; ?>" name="employeename[]"  readonly value="<?php echo $r['name']; ?>" />
</td>
<td width="1">&nbsp;</td>
<td>
<input type="text" style="width: 70px;text-align:right;color:#0000FF;  background:none; border:none;" id="totalsalary<?php echo $i; ?>" name="totalsalary[]"  readonly value="<?php echo $r['totalsal']; ?>" />
</td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right;color:#0000FF;background:none; border:none;" id="allowances<?php echo $i; ?>" name="allowances[]" value="<?php echo $r['allowances']; ?>" readonly="readonly"/>
</td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  readonly="readonly"  style="width: 50px;text-align:right;color:#0000FF;background:none; border:none;" id="addpbal<?php echo $i; ?>" name="addpbal[]" value="<?php echo $r['pbaladd']; ?>"  />
</td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  readonly="readonly"  style="width: 50px;text-align:right;color:#0000FF; background:none; border:none;" id="advdeduction<?php echo $i; ?>" name="advdeduction[]" value="<?php echo $r['advded']; ?>"/>
</td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right;color:#0000FF; background:none; border:none;" id="deduction<?php echo $i; ?>" name="deduction[]" value="<?php echo $r['oded']; ?>" readonly="readonly"/></td>
<td width="1">&nbsp;</td>
<?php
for($m=0;$m<$j;$m++)
{
?> <td>
<input type="text"  style="width: 50px;text-align:right; background:none; border:none;color:#0000FF;" id="<?php echo "ewf".$m.$i; ?>" name="<?php  echo "ewf".$m; ?>[]" value="<?php echo $r[$des[$m]]; ?>" readonly="readonly"/>
</td>
<td width="1">&nbsp;</td>
<?php } ?>


<td>
<input type="text"  style="width: 50px;text-align:right; background:none; border:none;color:#0000FF;" id="pf<?php echo $i; ?>" name="pf[]" value="<?php echo $r['pf']; ?>" readonly="readonly"/>
</td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  style="width: 50px;text-align:right; background:none; border:none;color:#0000FF;" id="incometax<?php echo $i; ?>" name="incometax[]" value="<?php echo $r['incometax']; ?>" readonly="readonly" />
</td>
<td width="1">&nbsp;</td>
<td>
<input type="text"  readonly="readonly"  style="width: 70px;text-align:right;color:#0000FF; background:none; border:none" id="paid<?php echo $i; ?>" name="paid[]" value="<?php echo $r['paid']; ?>" /></td>  
<td width="1">&nbsp;</td> 
<td>
<select name="paymode[]" id="paymode<?php echo $i; ?>" style="width:80px;color:#0000FF;" onchange="cashcheque(<?php echo $i; ?>)" >
<option value="">-Select-</option>
<option value="Cash">Cash</option>
<option value="Cheque">Cheque</option>
<option value="Other">Other</option>
</select></td>
<td width="1">&nbsp;</td>
<td>
<select  name="code[]" id="code<?php echo $i; ?>" style="width:80px;color:#0000FF;" onchange="getcoacode(<?php echo $i; ?>);" >
<option value="">-Select-</option>
</select></td>
<input type="hidden" id="coacode<?php echo $i; ?>" name="coacode[]" />
<td width="1">&nbsp;</td>
<td style="vertical-align:top">
<input type="text" style="position:absolute;width:50px;visibility:hidden " id="cddno<?php echo $i;
 ?>" class="form_element"  name="cddno[]" value=""/>
<input type="text" style="position:absolute;width:50px;visibility:visible" readonly id="cddno1<?php echo $i; ?>" name="cddno1[]" value=""/></td>

<td><span id="availability_status<?php echo $i; ?>"></span> </td>

</tr>
<tr height="10px"><td></td></tr>
<?php $i++; } ?>
</table>
<table align="center">
<tr>
<td colspan="4" align="center"  <?php if(mysql_num_rows($rquery) == 0) { ?> style="visibility:hidden" <?php } ?>>
<input type="submit" value = "Pay" />
</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input name="button" type="button" onclick="document.location = 'dashboardsub.php?page=hr_salary_pay';" value = "Cancel"/>
</td>
<td>&nbsp;</td>
</tr>
</table><br />

<table id="tab1">
</table>
</form>

<script type="text/javascript">

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
			var no=document.getElementById('cddno'+k ).value ;
			if(no!="")
{
var k2=k;
k2=k2+1;
for(j1=k2;j1<j;j1++)
{


if(document.getElementById('cddno'+k).value==document.getElementById('cddno'+j1).value)
{
alert("Same  cheque number Should not Entered");
document.getElementById("cddno" +j1).value="";
document.getElementById('cddno'+j1).focus();
$("#availability_status"+j1).html(' ');
return false;

}
}
}
			
			}
	
	
		for(var k=0;k<j;k++)
			{
				if(document.getElementById('c'+k).checked)
				{
					flag=1;
					
					
					var no=document.getElementById('cddno'+k ).value ;
	
				

if(no!="")
{




<?php
$q="SELECT distinct(cddno)  from hr_salary_payment ";
$res=mysql_query($q,$conn);
while($row=mysql_fetch_array($res))
{

?>
if(no=="<?php echo $row[0];?>"   )
{
alert("Already cheque number  exists");
document.getElementById("cddno" +k).value="";
document.getElementById("cddno"+k).focus();
return false;

}


<?php } ?>
}
						
						
					
					
					
					
					if(document.getElementById('paymode' + k ).value=="")
					{ 
						alert("Please Select the Payment mode");
					//alert(document.getElementById('paid' + k ).value);
						document.getElementById('paymode' + k ).focus();
						
						
						return false;
						
					}
					if(document.getElementById('code' + k ).value=="" || document.getElementById('code' + k ).value=="-Select-")
					{ 
						alert("Please Enter the Code");
						document.getElementById('code' + k ).focus();
						return false;
					}
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
			return true;
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


var j=Number("<?php echo $j-1;?>");

function removeAllOptions(selectbox)
{	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
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
		var sector = document.getElementById('sector').value;	
		var desig = document.getElementById('desig').value;	
		var date = document.getElementById('date').value;
		document.location = "dashboardsub.php?page=hr_addsal_pay&sector=" + sector + "&desig=" + desig + "&date=" + date;
		
	
	}
	
	else
	
	{
	
		var sector = document.getElementById('sector').value;	
		var desig = document.getElementById('desig').value;	
		var date = document.getElementById('date').value;	
		var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
		document.location = "dashboardsub.php?page=hr_addsal_pay&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month+ "&year=" + year;
	
	}
	
}

else if(year<mnth2arr[2])

{


	var sector = document.getElementById('sector').value;
	var desig = document.getElementById('desig').value;
	var date = document.getElementById('date').value;
	var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
	document.location = "dashboardsub.php?page=hr_addsal_pay&sector=" + sector + "&desig=" + desig + "&date=" + date+ "&month=" + month+ "&year=" + year;

}

else

{

	alert("Month & Year should be less than paying date");
		document.getElementById('month').focus();
		document.getElementById('month').value=0;
		document.getElementById('year').value="";
		var sector = document.getElementById('sector').value;	
		var desig = document.getElementById('desig').value;	
		var date = document.getElementById('date').value;
		document.location = "dashboardsub.php?page=hr_addsal_pay&sector=" + sector + "&desig=" + desig + "&date=" + date;
		

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
		document.getElementById("allowances"+str).style.color="#FF0000";
		document.getElementById("addpbal"+str).style.color="#FF0000";
		document.getElementById("advdeduction"+str).style.color="#FF0000";
		document.getElementById("deduction"+str).style.color="#FF0000";
		document.getElementById("pf"+str).style.color="#FF0000";
		document.getElementById("incometax"+str).style.color="#FF0000";
		document.getElementById("paid"+str).style.color="#FF0000";
		document.getElementById("paymode"+str).style.color="#FF0000";
		document.getElementById("code"+str).style.color="#FF0000";
		document.getElementById("cddno1"+str).style.color="#FF0000";
		<?php
		for($m=0;$m<$j;$m++)
		{
			?>
			document.getElementById("ewf"+<?php echo $m;?>+str).style.color="#FF0000";
		<?php } ?>
		
	}
	else
	{
		
		document.getElementById("allowances"+str).readOnly=true;
		document.getElementById("deduction"+str).readOnly=true;
		document.getElementById("employeeid"+str).style.color="#0000FF";
		document.getElementById("employeename"+str).style.color="#0000FF";
		document.getElementById("totalsalary"+str).style.color="#0000FF";
		document.getElementById("allowances"+str).style.color="#0000FF";
		document.getElementById("addpbal"+str).style.color="#0000FF";
		document.getElementById("advdeduction"+str).style.color="#0000FF";
		document.getElementById("deduction"+str).style.color="#0000FF";
		document.getElementById("pf"+str).style.color="#0000FF";
		document.getElementById("incometax"+str).style.color="#0000FF";
		document.getElementById("paid"+str).style.color="#0000FF";
		document.getElementById("paymode"+str).style.color="#0000FF";
		document.getElementById("code"+str).style.color="#0000FF";
		document.getElementById("cddno1"+str).style.color="#0000FF";
		<?php
		for($m=0;$m<$j;$m++)
		{
			?>
		document.getElementById("ewf"+<?php echo $m;?>+str).style.color="#0000FF";
		<?php } ?>
		
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

