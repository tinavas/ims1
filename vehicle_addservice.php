<center>
<br/>
<h1>Vehicle Service Masters</h1>
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> <br />

<br/>
<br/><br />
<form method="post" action="vehicle_saveservice.php" onsubmit="return checkform(this);" >
<table border="0">

<tr>
<td align="right"><strong>Service Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="scode" id="scode" size="18" /></td>


<td width="10px"></td>
<td align="right" ><strong>Service Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"  ><input type="text" name="sdesc" id="sdesc" size="18" /></td>




</tr>

<tr style="height:10px"></tr>

<tr>



<td align="right" style="vertical-align:middle">&nbsp;&nbsp;<strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>



<td align="left"><select name="vt[]" id="vt" multiple="multiple" style="width:130px" >
<option value="" disabled="disabled">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT * from vehicle_type where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['vtype']; ?>"><?php echo $row1['vtype']; ?></option>
<?php } ?>
</select>
</td>


<td width="10px"></td>
<td align="right" style="vertical-align:middle"><strong>Included Parts<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="ip[]" id="ip" multiple="multiple" style="width:130px" >
<option value="" disabled="disabled">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(spareparts) from vehicle_spareparts where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['spareparts']; ?>"><?php echo $row1['spareparts']; ?></option>
<?php } ?>
</select>
</td>
</tr>


</table>
<br /><br />

<table border="0">
<td>
<tr>
<td colspan="2" align="right" style="vertical-align:middle;"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td colspan="3" align="left"><textarea rows="3" cols="40" name="remarks" id="remarks" ></textarea></td>
</tr>
</table>
<br /><br />


<table border="0">
<td>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=vehicle_service';">

</form>
</center>
</td></tr>
</table>
</center>

<script type="text/javascript">
function checkform(form)
{
	
	if(form.scode.value == "")
	{
		alert("Please Enter Service Code");
 form.scode.focus();
return false;
}
else if(form.sdesc.value == "")
{
	alert("Please Enter Service Description");
	form.sdesc.focus();
	return false;
}
if(form.vt.value == "")
	{
		alert("Please Enter Type");
 form.vt.focus();
return false;
}
else if(form.ip.value == "")
{
	alert("Please Enter Included Parts");
	form.ip.focus();
	return false;
}
return true;
}
function script1() {
window.open('vehiclehelp/help_m_add_vehicleservice.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
