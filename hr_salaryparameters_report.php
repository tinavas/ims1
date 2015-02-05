<?php include "jquery.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Employee Salary Report</h1> 
<br /><br /><br />
<form>

<table align="center">
<tr>


<td align="right"><strong>Sector&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id ="sector" name="sector" onChange="fun1(this.value);">
<option>-Select-</option>
<?php
$query = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $row['sector'];?>" <?php if($sector == $row['sector']) {?> selected="selected" <?php } ?>><?php echo $row['sector']; ?></option>
<?php } ?>
<option value="All">All</option>
</select></td>

<td width="15px"></td>

<td align="right"><strong>Designation</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="10px"></td>
<td align="left">
<select id="desig" name="desig" onChange="fun2(this.value);">
<option> -Select- </option>
</select></td>

<td width="15px"></td>

<td align="right"><strong>Employee&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><select name="employee" id="employee">
  <option> -Select- </option>
</select></td>

<td width="15px"></td>

<td align="right"><strong>Month&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="month" name="month" onchange="func1(this.value);">
<option value="Select"> Select </option>
<option value="All">All</option>
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
</select></td>

<td width="15px"></td>

<td align="right"><strong>Year&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="year" name="year" onchange="func2(this.value);">
<option value="Select"> Select </option>
<option value="All">All</option>
<option value="2011">2011</option>
<option value="2012">2012</option>
<option value="2013">2013</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
</select></td>
</tr>

</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>
<script type="text/javascript">
function fun1(sec)
{
var desiga = document.getElementById("desig");
removeAllOptions(desiga);
 theOption1=document.createElement("OPTION");
 theText1=document.createTextNode("-Select-");
 theOption1.appendChild(theText1);
 theOption1.value = "";
 desiga.appendChild(theOption1);
 <?php
 $query121 = "SELECT distinct(designation),sector FROM hr_employee ORDER BY designation ASC ";
 $result121 = mysql_query($query121,$conn); 
 while($row121 = mysql_fetch_assoc($result121))
 {
 echo "if(sec == '$row121[sector]'){"; 
 $desig = $row121['designation'];
 ?>
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $desig; ?>");
			theOption1.appendChild(theText1);
			theOption1.value = "<?php echo $desig; ?>";
			desiga.appendChild(theOption1);
 <?php  echo "}"; 
 
 echo "if(sec == 'All'){"; 
 $desig = $row121['designation'];
 ?>
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $desig; ?>");
			theOption1.appendChild(theText1);
			theOption1.value = "<?php echo $desig; ?>";
			desiga.appendChild(theOption1);
 <?php  echo "}";
 
 }?>
 
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("All");
			theOption1.appendChild(theText1);
			theOption1.value = "All";
			desiga.appendChild(theOption1);			
}
function fun2(deg)
{
var employeea = document.getElementById("employee");
removeAllOptions(employeea);
var sect = document.getElementById("sector").value;
 theOption1=document.createElement("OPTION");
 theText1=document.createTextNode("-Select-");
 theOption1.appendChild(theText1);
 theOption1.value = "";
 employeea.appendChild(theOption1);
 <?php
 $query121 = "SELECT distinct(name),designation,sector FROM hr_employee ORDER BY designation ASC ";
 $result121 = mysql_query($query121,$conn); 
 while($row121 = mysql_fetch_assoc($result121))
 {
 echo "if(sect == '$row121[sector]' && deg=='$row121[designation]'){"; 
 $name = $row121['name'];
 ?>
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $name; ?>");
			theOption1.appendChild(theText1);
			theOption1.value = "<?php echo $name; ?>";
			employeea.appendChild(theOption1);
 <?php  echo "}";
 
  echo "if(sect == 'All' && deg=='$row121[designation]'){"; 
 $name = $row121['name'];
 ?>
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $name; ?>");
			theOption1.appendChild(theText1);
			theOption1.value = "<?php echo $name; ?>";
			employeea.appendChild(theOption1);
 <?php  echo "}";
 
 echo "if(sect == '$row121[sector]' && deg=='All'){"; 
 $name = $row121['name'];
 ?>
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $name; ?>");
			theOption1.appendChild(theText1);
			theOption1.value = "<?php echo $name; ?>";
			employeea.appendChild(theOption1);
 <?php  echo "}";
 
 echo "if(sect == 'All' && deg=='All'){"; 
 $name = $row121['name'];
 ?>
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $name; ?>");
			theOption1.appendChild(theText1);
			theOption1.value = "<?php echo $name; ?>";
			employeea.appendChild(theOption1);
 <?php  echo "}";
 
  }?>	
 
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("All");
			theOption1.appendChild(theText1);
			theOption1.value = "All";
			employeea.appendChild(theOption1);			
}

function func1(mnth)
{
if(mnth == "All")
{
document.getElementById("year").value="All";
document.getElementById("year").disabled=true;
}
else
{
document.getElementById("year").disabled=false;
}
}
function func2(yr)
{
if(yr == "All")
{
document.getElementById("month").value="All";
document.getElementById('month').disabled = true;
}
else
{
document.getElementById('month').disabled = false;
}
}
function removeAllOptions(selectbox)
{
      	var i;
       	for(i=selectbox.options.length-1;i>=0;i--)
        	{
        		//selectbox.options.remove(i); 
            	  selectbox.remove(i);
      	}
}

</script>


<script type="text/javascript">
function openreport()
{
var a = document.getElementById("sector").value;
var b = document.getElementById("desig").value;
var c = document.getElementById("employee").value;
var d = document.getElementById("month").value;
var e = document.getElementById("year").value;
window.open('production/SalaryParam_Reportsmry.php?sector=' + a + '&desig=' + b + '&employee=' + c + '&month=' + d + '&year=' +e); 
}
</script>
</body>
</html>
	

