<center>
<br/>
<h1>Vehicle Charge Masters</h1>
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> <br />


<br/>
<br/><br />
<form method="post" action="vehicle_savechargemaster.php" onsubmit="return checkform(this);">
<table border="0">

<tr>
<td align="right"><strong>Charge Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ccode" id="ccode" size="18" /></td>


<td width="10px"></td>

<td align="right"  style="vertical-align:middle"><strong>Charge Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"  style="vertical-align:middle"><input type="text" name="cdesc" id="cdesc" size="18" /></td>


</tr>

<tr style="height:10px"></tr>

<tr>


<td align="right">&nbsp;&nbsp;<strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>



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
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=vehicle_chargemaster';">

</form>
</center>
</td></tr>
</table>
</center>

<script type="text/javascript">
function checkform(form)
{
	if(form.ccode.value == "")
	{
		alert("Please Enter Charge Code");
 form.ccode.focus();
return false;
}
else if(form.cdesc.value == "")
{
	alert("Please Enter Charge Description");
	form.cdesc.focus();
	return false;
}
else if(form.vt.value == "")
{
	alert("Please Enter Vehicle Type");
	form.vt.focus();
	return false;
}
return true;
	}
function script1() {
window.open('vehiclehelp/help_vehiclecharge.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
