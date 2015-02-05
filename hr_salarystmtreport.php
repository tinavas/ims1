
<center>
<h4 style="color:red;font-weight:bold;padding-top:10px"><u>Employee Reports</u></h2>
</center>
<br />
<table>
<tr>
<td>
<strong>Sector:</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="sector" name="sector"   style="width:150" onChange="fun()" tabindex="2">
<option> Select  </option>
<option value="All">All</option>
<?php
           include "config.php"; 
           $query = "SELECT distinct(sector) FROM hr_employee  ORDER BY sector ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Employee Name : </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select name="empname" id="empname" tabindex="2" onChange="" style="width:150">
<option value="Select">Select</option>
<option value="All">All</option>
</select>
</td>
</tr>
<tr>
<td>
<strong>Month : </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="month" onChange="" name="month">
<option value="Select"> Select </option>
<option value="01">JAN</option>
<option value="02">FEB</option>
<option value="03">MAR</option>
<option value="04">APR</option>
<option value="05">MAY</option>
<option value="06">JUN</option>
<option value="07">JUL</option>
<option value="08">AUG</option>
<option value="09">SEP</option>
<option value="10">OCT</option>
<option value="11">NOV</option>
<option value="12">DEC</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td align="right">
<strong>Year : </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="year" onChange="" name="year">
<option value="Select"> Select </option>
<?php $date = date(Y); for($a = $date;$a<($date+5);$a++) { ?>
<option value="<?php echo $a; ?>"><?php echo $a; ?></option>
<?php } ?>
</select>
</td>
</tr>
</table>
<span id="singledate" style="position:absolute;visibility:hidden">
Date &nbsp;&nbsp;
<input type="text" size="8" id="date1" name="date1" value="<?php echo date("d.m.o"); ?>"><img src="calender.gif" title="Calender" onClick="displayCalendar(document.getElementById('date1'),'dd.mm.yyyy',this)" />
</span>
<span id="doubledate" style="position:absolute;visibility:hidden">
From &nbsp;&nbsp;
<input type="text" size="8" id="date2" name="date2" value="<?php echo date("d.m.o"); ?>"><img src="calender.gif" title="Calender" onClick="displayCalendar(document.getElementById('date2'),'dd.mm.yyyy',this)" />
&nbsp;&nbsp;
To &nbsp;&nbsp;
<input type="text" size="8" id="date3" name="date3" value="<?php echo date("d.m.o"); ?>"><img src="calender.gif" title="Calender" onClick="displayCalendar(document.getElementById('date3'),'dd.mm.yyyy',this)" />
</span>

<table 
<br /><br />
<!-- Daily Entry Start -->

<table id="1" >
<form id="myform1" name="myform1" action="#" method="post" target="_NEW">
<tr>
  <td colspan="15">
   <img src="images/icons/fugue/tick-circle.png" title="Check All" name="CheckAll" onClick="checkAll()" />
&nbsp;&nbsp;<img src="images/icons/fugue/cross-octagon-frame.png" title="Uncheck all" name="UnCheckAll" onClick="uncheckAll()" />
  </td>
</tr>
<tr height="20"><td colspan="15"></td></tr>

<tr height="20"><td colspan="15">Common Fields</td></tr>

<tr height="10"><td colspan="15"></td></tr>

<tr>
 <td><input type="checkbox"  id="name" name="n[]"  title="Please check to include Employee Name in the Report" value="en"  /></td> <td width="5px"></td> <td width="150px"><strong>Employee Name</strong></td>
 <td><input type="checkbox"  id="date" name="n[]"   title="Please check to include Designation in the Report"  value="d"  /></td> <td width="5px"></td> <td width="180px"><strong>Designation</strong></td> 
 <td><input type="checkbox"  style="visibility:hidden"id="percentage" name="n[]"   title="Please check to include Percentage in the Report"  value="p"  /></td> <td width="5px"></td> <td width="150px " style="visibility:hidden">Corresponding Percentages ( % )</td>
</tr>
</table>


<table style="visibility:hidden;position:absolute" >
<tr height="20"><td colspan="15"></td></tr>

<tr height="20"><td colspan="15">Other Fields</td></tr>

<tr height="10"><td colspan="15"></td></tr>

<tr>
  <td><input type="checkbox" id="attendance"  name="m[]" value="attendance"   title="Please check to see Attendance Report"onClick="attendance1()" onChange=""  /></td>  
  <td width="5px"></td> <td width="150px">Attendance</td>
  <td><input type="checkbox"  id="ba" name="m[]" value="ba"  title="Please check to see Basic Allowance Report" onClick="attendance1()"/></td><td width="5px"></td><td width="150px"> Basic Allowance</td>
  <td><input type="checkbox"  id="hra" name="m[]" value="hra"  checked="checked"  title="Please check to see HRA Report"onClick="attendance1()"/></td> <td width="5px"></td><td width="150px">HRA</td>
  <td><input type="checkbox"  id="ma" name="m[]" value="ma" title="Please check to see Medical Allowance Report" onClick="attendance1()"/></td> <td width="5px"></td> <td width="150px">Medicial Allowance</td>
  <td><input type="checkbox"  id="cca" name="m[]" value="cca" title="Please check to see City Compensation Allowance Report" onClick="attendance1()"/></td> <td width="5px"></td> <td width="150px">City Compensation Allowance</td>
</tr>
<tr>
 <td><input type="checkbox"   id="ta" name="m[]" value="ta"  title="Please check to see Travelling Allowance Report" onClick="attendance1()" /></td> <td width="5px"></td> <td>Travelling Allowance</td>
 <td><input type="checkbox"   id="sa" name="m[]" value="sa"   title="Please check to see Special Allowance Report" onClick="attendance1()"/></td> <td width="5px"></td> <td>Special Allowance</td> 
 <td><input type="checkbox"   id="c" name="m[]" value="c"  title="Please check to see Conveuance Report" onClick="attendance1()" /></td> <td width="5px"></td> <td>Conveyance</td>
 <td><input type="checkbox"   id="ea" name="m[]" value="ea"  title="Please check to see Education Allowance Report" onClick="attendance1()"/></td> <td width="5px"></td> <td>Education Allowance</td> 
 <td><input type="checkbox"   id="oa" name="m[]" value="oa"  title="Please check to see Other Allowance Report" onClick="attendance1()"/></td> <td width="5px"></td> <td>Other Allowance</td>
</tr>
<tr>
 <td><input type="checkbox"   id="pf" name="m[]" value="pf"  title="Please check to see PF Report" onClick="attendance1()"/></td> <td width="5px"></td> <td>PF</td>
 <td><input type="checkbox"   id="pt" name="m[]" value="pt"  title="Please check to see Personal Tax Report" onClick="attendance1()" /></td> <td width="5px"></td> <td>Professional Tax</td>
 <td><input type="checkbox"   id="it" name="m[]" value="it"  title="Please check to see Income Tax Report"  onClick="attendance1()"/></td> <td width="5px"></td> <td>Income Tax</td>
 <td><input type="checkbox"   id="lr" name="m[]" value="lr"  title="Please check to see Loan Repayments Report" onClick="attendance1()" /></td> <td width="5px"></td> <td>Loan Repayments</td>
  <td><input type="checkbox"  id="od" name="m[]" value="od"   title="Please check to see Other Deductions Report" onClick="attendance1()"/></td> <td width="5px"></td> <td>Other Deductions</td>
</tr>
</table>


<table align="center" style="position:absolute;visibility:visible">
<tr height="30"><td></td></tr>
<tr><td></td>
<td colspan="15" style="text-align:center"><input type="button" value="Open Report" onClick="openreport(document.myform1.elements['m[]'],document.myform1.elements['n[]'],'<?php echo $_SESSION['client']; ?>');" /></td>
</tr>
</table>

<!-- Daily Entry End -->
</form>



<script type="text/javascript">
function checkAll()
{
<?php echo "
	document.getElementById('name').checked = true;
	document.getElementById('date').checked = true;
	document.getElementById('percentage').checked = true;
	"; ?>
}

function uncheckAll()
{
<?php echo "
	document.getElementById('name').checked = false;
	document.getElementById('date').checked = false;
	document.getElementById('percentage').checked = false;
		"; ?>
}

function attendance1()
{
<?php echo "
if( document.getElementById('attendance').checked == true)
{
document.getElementById('ba').disabled = true;
document.getElementById('hra').disabled = true ;
document.getElementById('ma').disabled = true;
document.getElementById('cca').disabled = true;
document.getElementById('ta').disabled = true;
document.getElementById('sa').disabled = true;
document.getElementById('c').disabled = true;
document.getElementById('ea').disabled = true;
document.getElementById('oa').disabled = true;
document.getElementById('pf').disabled = true;
document.getElementById('pt').disabled = true;
document.getElementById('it').disabled = true;
document.getElementById('lr').disabled = true;
document.getElementById('od').disabled = true;
}
else  if((document.getElementById('ba').checked == true)||(document.getElementById('hra').checked == true)||(document.getElementById('ma').checked == true)||(document.getElementById('cca').checked == true)||(document.getElementById('ta').checked == true)||(document.getElementById('sa').checked == true)||(document.getElementById('c').checked == true)||(document.getElementById('ea').checked == true)||(document.getElementById('oa').checked == true)||(document.getElementById('pf').checked == true)||(document.getElementById('pt').checked == true)||(document.getElementById('it').checked == true)||(document.getElementById('lr').checked == true)||(document.getElementById('od').checked == true))
{
document.getElementById('attendance').disabled = true;

}
else
{
document.getElementById('attendance').disabled =false;
document.getElementById('ba').disabled =false;
document.getElementById('hra').disabled = false ;
document.getElementById('ma').disabled = false;
document.getElementById('cca').disabled = false;
document.getElementById('ta').disabled = false;
document.getElementById('sa').disabled = false;
document.getElementById('c').disabled = false;
document.getElementById('ea').disabled = false;
document.getElementById('oa').disabled = false;
document.getElementById('pf').disabled = false;
document.getElementById('pt').disabled = false;
document.getElementById('it').disabled = false;
document.getElementById('lr').disabled = false;
document.getElementById('od').disabled = false;

}
"; ?>
}



function bodyload()
{

}

function openreport(field,field1,client)
{

var sector = document.getElementById('sector').value;

var fields = '';
for (i = 0; i < field.length; i++)
 if (field[i].checked)
  fields = fields + ',' + field[i].value;

 var fields1 = '';
for (i = 0; i < field1.length; i++)
 if (field1[i].checked)
  fields1 = fields1 + ',' + field1[i].value;
  
var empname = document.getElementById('empname').value;
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
var f = 0;
   
   if( (sector =='Select') || (empname =='Select') || (month =='Select') || (year =='Select') )
   {
   alert('You have not selected SECTOR or EMPLOYEE NAME or MONTH or YEAR, Please select all these');
   }
  
   else if( document.getElementById('attendance').checked == true)
   {
   f  = 1 ;
   
   if(client == 'SKPFNEW')
   {
       window.open('production/Salarysmry.php' + '?m=' + fields + '&n=' + fields1 + '&empname=' + empname + '&month=' + month+ '&year=' + year+ '&sector=' + sector); 
   }
   
   else if(client == 'FEEDATIVES')
   {
       window.open('production/Salarysmry.php' + '?m=' + fields + '&n=' + fields1 + '&empname=' + empname + '&month=' + month+ '&year=' + year+ '&sector=' + sector); 
   }
   else
   {
    window.open('production/Salarysmry.php' + '?m=' + fields + '&n=' + fields1 + '&empname=' + empname + '&month=' + month+ '&year=' + year+ '&sector=' + sector); 
	}
	}
	else if((document.getElementById('ba').checked == true)||(document.getElementById('hra').checked == true)||(document.getElementById('ma').checked == true)||(document.getElementById('cca').checked == true)||(document.getElementById('ta').checked == true)||(document.getElementById('sa').checked == true)||(document.getElementById('c').checked == true)||(document.getElementById('ea').checked == true)||(document.getElementById('oa').checked == true)||(document.getElementById('pf').checked == true)||(document.getElementById('pt').checked == true)||(document.getElementById('it').checked == true)||(document.getElementById('lr').checked == true)||(document.getElementById('od').checked == true))
	{
	f  = 1 ;
	if(client == 'SKPFNEW')
	{
	    window.open('production/Salarysmry.php' + '?m=' + fields + '&n=' + fields1  + '&empname=' + empname + '&month=' + month+ '&year=' + year+ '&sector=' + sector); 
	}
	else if(client == 'FEEDATIVES')
   {
       window.open('production/Salarysmry.php' + '?m=' + fields + '&n=' + fields1 + '&empname=' + empname + '&month=' + month+ '&year=' + year+ '&sector=' + sector); 
   }
	else
	{
    window.open('production/Salarysmry.php' + '?m=' + fields + '&n=' + fields1  + '&empname=' + empname + '&month=' + month+ '&year=' + year+ '&sector=' + sector); 
	}
	}
	if( f == 0 )
	{
	
	}

}


function fun()
{
			  removeAllOptions(document.getElementById("empname"));
			  
			  myselect1 = document.getElementById('empname');
			  theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("Select");
			  theOption1.value = "Select";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			  
			  myselect1 = document.getElementById('empname');
			  theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("All");
			  theOption1.value = "All";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			  if(document.getElementById("sector").value !="All")
			  {
<?php
	
     $q2=mysql_query("select distinct(sector) from hr_employee order by sector ASC");
	 
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('sector').value == '$nt2[sector]'){";
     $q3=mysql_query("select distinct(name) from hr_employee where sector ='$nt2[sector]' order by name ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['name']; ?>");
			  theOption1.value = "<?php echo $nt3['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
      echo "}"; 
     }
  ?>
  }
  else
  {
  	<?php
	     
     $q3=mysql_query("select distinct(name) from hr_employee order by name ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['name']; ?>");
			  theOption1.value = "<?php echo $nt3['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
     
   ?>
  }
  <?php echo "
if(document.getElementById('sector').selectedIndex == 0)
{
			  removeAllOptions(document.getElementById('empname'));
			  myselect1 = document.getElementById('empname');
			  theOption1=document.createElement('OPTION');
			  theText1=document.createTextNode('Select');
			  theOption1.value = 'Select';
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
}
"; ?>
}


function removeAllOptions(selectbox)
{
<?php echo "
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
	"; ?>
}

</script>
