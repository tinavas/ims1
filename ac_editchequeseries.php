<?php include "config.php"; ?>
<center>
<br/>
<h1>Cheque Series</h4>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br/>
<form id="form1" name="form1" method="post" action="ac_updatechequeseries.php"  onsubmit="return checkform(this);">
<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
<table align="center" border="1">
<?php 	
 		$q = "select * from ac_chequeseries where id = '$_GET[id]' order by acno ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
            
?>
<tr>
<td align="right"><strong>Bank A/C #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select style="Width:120px" name="acno" id="acno" disabled>
                      <option value="SELECT">-Select-</option>
<option value="<?php echo $qr['acno']; ?>" selected><?php echo $qr['acno']; ?></option>
			</select></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>No. Of Cheque Leaves</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="chls" size="6" id="chls" value="<?php echo $qr['chls']; ?>" onblur="cal();" onkeyup="cal();" onchange="cal();"  /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Starting No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="schls" size="12" id="schls" value="<?php echo $qr['schls']; ?>" onblur="cal();" onkeyup="cal();" onchange="cal();" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Ending No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="echls" size="12" id="echls" value="<?php echo $qr['echls']; ?>" readonly /></td>
</tr>
<?php } ?>

<tr>
<td colspan="2" align="center">
<br />
<center>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_chequeseries';">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>
</body>
<script language="JavaScript" type="text/javascript">
function cal()
{
 document.getElementById("echls").value = (parseInt(document.getElementById("schls").value) + parseInt(document.getElementById("chls").value)) - 1;
}
function checkform ( form )
{
var numericExpression = /^[0-9].+$/;
    if (form.acno.value == "SELECT") {
    alert( "Please select account number." );
    form.acno.focus();
    return false ;
  }
   else if (form.chls.value == "") {
    alert( "Please enter the number of cheque leaves." );
    form.chls.focus();
    return false ;
  }
   else if (form.chls.value == "0") {
    alert( "The number of cheque leaves cannot be Zero." );
    form.chls.focus();
    return false ;
  }
  else if (form.schls.value == "") {
    alert( "Please enter the starting number." );
    form.schls.focus();
    return false ;
  }
   
  return true ;
}
</script>
</html>
 
