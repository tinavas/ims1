<center>
<br/>
<h1>Location</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="admin_saveoffice.php" onSubmit="return checkform(this);">
<table>
<tr>
<td>
<strong>
Location Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="sector" name="name" size="30" onkeyup="validatesector(this.value);" /></td>
</tr>
<tr height="10px"><td></td></tr>
<tr>   

<td align="right"><strong>Location Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="type" id="type" style="width:200px;">
<option value="">-Select-</option>

		<option value="Administration Office">Administration Office</option>
		<option value="Dispatch Location">Dispatch Location</option>
		
		<option value="Head Office">Head Office</option>
		<option value="Sales Office">Sales Office</option>
		<option value="Warehouse">Warehouse</option>
		

      </select> </td>
	  	  </tr>
<tr height="10px"><td></td></tr>
		
</table>
<br /><br />
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=admin_office';">

</form>
</center>
</td></tr>
</table>
</fieldset>
</center>
</body>
<script language="JavaScript" type="text/javascript">
function validatesector(a)
{
 var expr=/^[A-Za-z0-9 ]*$/;
 if(! a.match(expr))
 {
  alert("Sector name should not contain Special Character");
  document.getElementById("sector").value = "";
  document.getElementById("sector").focus();
 }
}


function checkform ( form )
{
<?php 

$query = "select sector from tbl_sector";

$result = mysql_query($query,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($result))
{
$x = $qr['sector'];
?>
var noalpha = /^[a-zA-Z0-9.\s]*$/;

    if (form.name.value == "") {
    alert( "Please enter Sector Name" );
    form.name.focus();
    return false ;
  }
  else if(form.name.value == "<?php echo $x;?>")
  {
  alert("Sector Name already Exists");
 form.name.value = "";
  form.name.focus();
  return false;
  }
   else if ((!(form.name.value.match(noalpha))))
 {
    alert( "Sector Name cannot have special charaters." );
    form.name.focus();
    return false ;
  }
  else if(form.type.value == "")
  {
  	alert("Please select Sector Type" );
	form.type.focus();
	return false;
  }
 
 
  return true ;
   <?php } ?>
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

</script>
<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_m_addoffice.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
