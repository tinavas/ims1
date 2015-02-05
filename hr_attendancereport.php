<?php include "config.php"; ?>

<center>
<br/>
<h1>Employee Attendance Report</h1>
</center>
<br /><br /><br />
<form id="myform1" name="myform1" action="#" method="post" target="_NEW">

<table align="center">
<tr>
<td><strong>Sector:</strong></td>
<td width="10px">&nbsp;</td>
<td><select id="sector" name="sector"   style="width:150" tabindex="2"><option value="">-Select-</option>
         <option value="All">All</option><?php $query = "SELECT distinct(sector) FROM hr_employee  ORDER BY sector ASC ";         $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))  { ?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
</select></td>
<?php /*?><td width="10px">&nbsp;</td>
<td><strong>Employee Name:</strong></td>
<td width="10px">&nbsp;</td>
<td><select name="empname" id="empname" tabindex="2" onChange="" style="width:150"><option value="Select">Select</option><option value="All">All</option></select></td><?php */?>
</tr>
<tr height="20px"></tr>
<tr>
<td><strong>Month : </strong></td>
<td width="10px">&nbsp;</td>
<td><select id="month" onChange="" name="month" ><option value="Select"> Select </option><option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option><option value="07">JUL</option><option value="08">AUG</option><option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option><option value="12">DEC</option></select></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Year : </strong></td>
<td width="10px">&nbsp;</td>
<td><select id="year" onChange="" name="year"><option value="Select"> Select </option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select></td>
</tr>

<tr height="20"></tr>

<?php /*?><tr align="center">
  <td colspan="7"><img src="images/icons/fugue/tick-circle.png" title="Check All" name="CheckAll" onClick="checkAll()" />&nbsp;&nbsp;<img src="images/icons/fugue/cross-octagon-frame.png" title="Uncheck all" name="UnCheckAll" onClick="uncheckAll()" />  </td>
</tr><?php */?>

<tr height="20"></tr>
</table>
<?php /*?><table align="center">
<tr height="20"><td colspan="7"><strong>Common Fields</strong></td></tr>
<tr>
 <td><input type="checkbox"  id="name" name="n[]"  title="Please check to include Employee Name in the Report" value="en"  /></td>
 <td width="10px">&nbsp;</td>
 <td><strong>Employee Name</strong>&nbsp;</td>
 <td><input type="checkbox"  id="date" name="n[]"   title="Please check to include Designation in the Report"  value="d"  /></td>
 <td><strong>Designation</strong>&nbsp;</td> 
</tr>
</table><?php openreport(document.myform1.elements['n[]']) */?>


<table align="center">
<tr height="30"><td></td></tr>
<tr><td><td colspan="15" style="text-align:center"><input type="button" value="Report" onClick="openreport();" /></td></tr>
</table>

</form>




<script type="text/javascript">
<?php /*?>function checkAll()
{
<?php echo "
	document.getElementById('name').checked = true;
	document.getElementById('date').checked = true;
	"; ?>
}

function uncheckAll()
{
<?php echo "
	document.getElementById('name').checked = false;
	document.getElementById('date').checked = false;
		"; ?>
}<?php */?>

<?php /*?>function attendance1()
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
}<?php */?>



function openreport()
{

var sector = document.getElementById('sector').value;

//var fields = '';
//
// var fields1 = '';
//for (i = 0; i < field1.length; i++)
// if (field1[i].checked)
//  fields1 = fields1 + ',' + field1[i].value;
  
//var empname = document.getElementById('empname').value;
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;
var f = 0;

if( (sector =='Select') || (month =='Select') || (year =='Select') )
   {
   alert('You have not selected SECTOR or EMPLOYEE NAME or MONTH or YEAR, Please select all these');
   }
   
<?php 

$q="select `procedure` from hr_salary_procedure";
$res=mysql_query($q);
$r=mysql_fetch_assoc($res);
if($r['procedure']=="Monthly Attendance")
{
?>
    window.open('production/monthattendance.php' + '?month=' + month+ '&year=' + year+ '&sector=' + sector); 
	
<?php 
}
else
{
?>
 window.open('production/attendancesmry.php' + '?month=' + month+ '&year=' + year+ '&sector=' + sector); 
	
<?php } ?>	
	

}


<?php /*?>function fun()
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
<?php */?>
<?php /*?>
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
<?php */?>
</script>
