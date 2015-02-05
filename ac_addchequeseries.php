<?php include "config.php"; ?>

<center>
<br />
<h1>Cheque Series</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="ac_savechequeseries.php"  onsubmit="return checkform(this);">
<table align="center" border="1">

<tr>
<td align="right"><strong>Bank A/c #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select style="Width:120px" name="acno" id="acno"><option value="">-Select-</option>
<?php  $q = "select * from ac_bankmasters where mode = 'Bank' and (flag = '0' OR rflag = '1') order by code ASC";
	 $qrs = mysql_query($q,$conn) or die(mysql_error()); while($qr = mysql_fetch_assoc($qrs))	{ ?>
<option value="<?php echo $qr['acno']; ?>"><?php echo $qr['acno']; ?></option>
<?php } ?></select></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>No. Of Digits</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="clen" size="3" id="clen" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>No. Of Cheque Leaves</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="chls" size="6" id="chls" onblur="cal();" onkeyup="cal();" onchange="cal();" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Starting No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="schls" size="12" id="schls" onblur="cal();" onkeyup="cal();" onchange="cal();" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Ending No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="echls" size="12" id="echls" readonly /></td>
</tr>

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
 var clen = document.getElementById("clen").value;

var numericExpression = /^[0-9].+$/;
    if (form.acno.value == "") { 
    alert( "Please select account number." );
    form.acno.focus();
    return false ;
  }
   else if (form.clen.value == "") {
     alert( "Please enter the number of digits in a cheque." );
    form.clen.focus();
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
  else if (form.schls.value.length != clen) { 
    alert( "Please enter the starting number correctly." );
    form.schls.focus();
    return false ;
  }
 
  return true ;
}
</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_m_addchequeseries.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
 
