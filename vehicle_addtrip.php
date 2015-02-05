
<?php 
 
include "config.php";
include "timepicker.php";

?>

		
<center>
<br />
<h1>Vehicle Trip Sheet</h1>
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> <br />

<br/>
<br/>
<form id="form1" name="form1" method="post" action="vehicle_savetrip.php" onsubmit="return checkform(this);" >

<table align="center">
<tr>

<td style="vertical-align:middle"><strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td style="vertical-align:middle">

<span id="newb">
<select name="vt" id="vt" style="width:120px" onChange="getnum(this.value);" >
<option value="-Select-">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT * from vehicle_type where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['vtype']; ?>"><?php echo $row1['vtype']; ?></option>
<?php } ?>
</select>
</span>
&nbsp;&nbsp;

<img src="plus.png"  title = "Add New vehicletype" onclick="changetype();" />

</td>

<td width="10px"></td>
<td style="vertical-align:middle"><strong>Vehicle No:<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>

<td style="vertical-align:middle">
<span id="newb1">
<select name="vnum" id="vnum" style="width:120px" >
<option value="">-Select-</option>

</select>
</span>
</td>
				
<td width="10px"></td>


<td style="vertical-align:middle"><strong>Driver<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
<select name="driver[]" id="driver" multiple="multiple" style="width:120px">
<option value="" disabled="disabled">-Select-</option>
<?php
           include "config.php"; 
           $query = "SELECT * FROM hr_employee where designation='Driver' AND client = '$client' ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
</select>				
</td>
</tr>
</table>
<table align="center">
<tr height="20px"></tr>
<tr>
		
 <td><strong>Start Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
<input type="text" name="sdate" id="sdate" size="18" class="datepicker" value="<?php echo date("d.m.Y");?>" /></td>
</td>
 
  
<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;Start time<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input class="timepicker" type="text" size="18" id="stime" name="stime"></td>
<td width="10px"></td>


<td><strong>&nbsp;&nbsp;Start Place<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>
<select name="splace" id="splace" style="width:120px">
<option value="-Select-">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(sector) from tbl_sector where client = '$client' order by sector";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
<?php 
$query = "select distinct(location) from vehicle_location where client = '$client' order by location";
$result = mysql_query($query,$conn);
while($rows = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $rows['location']; ?>"><?php echo $rows['location']; ?></option>
<?php } ?>
</select>
</td>

				<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;Start Reading<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="sread" name="sread"></td>

 
 
</tr>
</table>
</br>
</br>
<table align="center">
<tr height="10px"></tr>
<tr>
		
 <td><strong>End Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
<input type="text" name="edate" id="edate" size="18" class="datepicker" value="<?php echo date("d.m.Y");?>" /></td>
</td>
 
  
<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;End time<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input class="timepicker" type="text" size="18" id="etime" name="etime"></td>
<td width="10px"></td>


<td><strong>&nbsp;&nbsp;End Place<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
              <select name="eplace" id="eplace" style="width:120px">
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(sector) from tbl_sector where client = '$client' order by sector";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
<?php 
$query = "select distinct(location) from vehicle_location where client = '$client' order by location";
$result = mysql_query($query,$conn);
while($rows = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $rows['location']; ?>"><?php echo $rows['location']; ?></option>
<?php } ?>
</select>
				<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;End Reading<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="eread" name="eread"></td>

 
 
</tr>
</table>
<br/>
<br/>
<table align="center">
<tr height="10px"></tr>
<td id="fuel1"><strong>&nbsp;&nbsp;Expenses Incurred</strong></td>
                <td>&nbsp;<input type="text" size="18" id="exp" name="exp"></td>
<td width="10px">

         <td>
		<input type="radio" name="load"  value="WithLoad" /> <strong>With Load</strong>
		&nbsp;&nbsp;
		<input type="radio" name="load" value="withoutload" /> <strong>Without Load</strong>
		</td>

</table>
</br>
</br>
<table align="center">
<tr>

<td width="10px"></td>
<td><strong>Remarks&nbsp;&nbsp;</strong></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks"></textarea></td>
</tr>
</table>

<center>	

   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_tripdetails';">
</center>


						
</form>
<script type="text/javascript">
function getfuel1(a)
{

var f = document.getElementById(a).value;

}
function checkform(form)
{
	if(form.vt.value == "-Select-")
	{
		alert("Please Enter Type");
 form.vt.focus();
return false;
}
else if(form.vnum.value == "")
{
	alert("Please Enter VehicleNumber");
	form.vnum.focus();
	return false;
}
else if(form.driver.value == "")
{
	alert("Please Select Driver");
	form.driver.focus();
	return false;
}
else if(form.stime.value == "")
{
	alert("Please Enter Start Time");
	form.stime.focus();
	return false;
}
else if(form.splace.value == "-Select-")
{
	alert("Please Enter Start Place");
	form.splace.focus();
	return false;
}	
else if(form.splace.value == form.eplace.value)
{
   alert("Please Select different Start Place");
   form.splace.focus();
   return false;
  
}
else if(form.sread.value == "")
{
	alert("Please Enter Start Reading");
	form.sread.focus();
	return false;
}

else if(form.etime.value == "")
{
	alert("Please Enter End Time");
	form.etime.focus();
	return false;
}
else if(form.eplace.value == "")
{
	alert("Please Enter End Place");
	form.eplace.focus();
	return false;
}
else if(form.eread.value == "")
{
	alert("Please Enter End Reading");
	form.eread.focus();
	return false;
}
return true;
	
}

function getnum(a)
{
var type = a;


removeAllOptions(document.getElementById("vnum"));
	myselect1 = document.getElementById("vnum");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "vnum";
myselect1.style.width = "120px";


<?php 
			$q = "select distinct(vtype) from vehicle_type";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(type == '$qr[vtype]') {";
			$q1 = "select distinct(vnumber) from vehicle_master where vtype = '$qr[vtype]'";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
        theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['vnumber'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['vnumber'];?>";
	          
              myselect1.appendChild(theOption1);
			  
			  <?php
			}
			echo "}";
			}
	?>


}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function changetype()
{
  document.getElementById("newb").innerHTML = "<input type='text' size='18' id='newvt' name='newvt' />";
 
  
}

</script>
<script type="text/javascript">
function script1() {
window.open('vehiclehelp/help_trip.php','BIMS',
'width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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

