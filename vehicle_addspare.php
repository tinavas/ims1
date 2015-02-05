<?php 
include "jquery.php"; 
include "config.php";
?>


<center>
<br />
<h1>Vehicle Spare Parts</h1>
  <center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> 

<br /><br />
<form id="form1" name="form1" method="post" action="vehicle_savespare.php" onsubmit="return checkform(this);" >
<table border="0">



<tr>
<td width="10px"></td>
<td colspan="2" align="right" style="vertical-align:middle"><strong><span id="certi"></span> Vehicle Types<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>


<td ><select  name="vt[]" id="vt" multiple="multiple" style="width:100px;height:80px">
<option value="-Select-" disabled="disabled">-Select-</option>
<?php
$query = "SELECT * from vehicle_type where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['vtype']; ?>"><?php echo $row1['vtype']; ?></option>
<?php } ?>
</select>
</td>
</tr>
</table>
    <br/>
<table border="0">



<tr>	

<tr>
<td width="25">
<td align="right"><strong>Spare Parts<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="parts" id = "parts" size="18" /></td>
</tr>
   </table>
    <br/>
   
  
   <br /> 
 </center>		

<center>	


   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onclick="document.location='dashboardsub.php?page=vehicle_spareparts';">
</center>


						
</form>
<script type="text/javascript">
function checkform(form)
{
	if(form.vt.value == "")
	{
		alert("Please Enter Type");
 form.vt.focus();
return false;
}
else if(form.parts.value == "")
{
	alert("Please Enter Spareparts");
	form.parts.focus();
	return false;
}
return true;
}
function script1() {
window.open('vehiclehelp/help_m_add_vehiclespare.php','BIMS',
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
