<center>
<br/>
<h1>Marketing Employee</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="oc_saveemployee.php" onSubmit="return checkform(this);">
<table>

<tr>
<td align="right" style="vertical-align:middle;"><strong>Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="vertical-align:middle;"><input type="text" id="name" name="name" size="30" onkeyup="validatecode(this.id,this.value);" /></td>

<td id="usercheck"></td>
<td style="display:none" id="loading" ><img  title="Verifying the Customer Name" src="images\mask-loader.gif" ></td>

<td align="right" style="vertical-align:middle;"><strong>Address</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="30" name="address"></textarea></td>
</tr>

<tr style="height:10px"></tr>
<tr>
<td align="right"><strong>Place</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="place" size="30" /></td>
<td width="10px"></td>
<td align="right"><strong>Phone</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="phone" size="30" /></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Mobile</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mobile" size="30" /></td>
<td width="10px"></td>
<td align="right"><strong>PAN/TIN</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="pan" name="pan" size="30" onkeyup="validatecode(this.id,this.value);"/></td></tr>
<tr style="height:10px"></tr>
<tr>
<td align="left">&nbsp;&nbsp;<strong>Customer Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="ctype" id="ctype" style="width:200px">
 <option value="">-Select-</option>
<option  value="Walkable Customer">Walkable Customer</option>
<option  value="Mew Marketing Customer">Mew Marketing Customer</option>
<option  value="Broker Customer">Broker Customer</option>
</select></td>
<td>
</td><td></td><td></td>
</tr>
<tr style="height:10px"></tr>
<tr style="height:10px"></tr>
<tr style="height:10px"></tr>

<tr>
<td align="right" colspan="2" style="vertical-align:middle;"><strong>Note</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left" colspan="3"><textarea rows="4" cols="35" name="note" ></textarea></td>
</tr>

</table>
<table>
<br />
<br />
<br />
<td>
<input type="submit" value="Save" id="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_employee';">

</form>
</center>
</td></tr>
</table>

</center>
<script language="JavaScript" type="text/javascript">
 
function validatecode(a,b)
{
 var expr=/^[A-Za-z0-9 ]*$/;
 if(! b.match(expr))
 {
  alert("Special Characters are not allowed");
  document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
}

function validatenumber(a,b)
{
 var expr=/^[0-9]*$/;
 if(! b.match(expr))
 {
  alert("It should be a Number");
  document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
}

 $(document).ready(function()
{  	
	$("#name").blur(function()
	{  
	   
	   if($("#name").val()) {
	   document.getElementById("usercheck").innerHTML='';
	   document.getElementById("usercheck").style.display='none';
	   document.getElementById("loading").style.display='';
		$.post("getcontactdetails_ajax1.php",{ name:$("#name").val() },function(data)
        { 
		document.getElementById("loading").style.display='none';
		if(data>0)
		 {		  
		  document.getElementById("name").value='';
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("usercheck").innerHTML='*Customer Name Exists';
		  document.getElementById("usercheck").style.color='#FF0000';
		  document.getElementById("submit").disabled='disabled';
		  alert('Customer Name already exists');
		 }
		 else
		 {
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("submit").disabled='';
		 }
		});
		
	} // end of if
});

$("#vpcode").blur(function()
	{  
	   if($("#vpcode").val()) {
	   document.getElementById("codecheck").innerHTML='';
	   document.getElementById("codecheck").style.display='none';
	   document.getElementById("codeloading").style.display='';
		$.post("getcontactdetails_code_ajax.php",{ code:$("#vpcode").val() },function(data)
        { 
		document.getElementById("codeloading").style.display='none';
		if(data>0)
		 {		  
		  document.getElementById("vpcode").value='';
		  document.getElementById("codecheck").style.display='';
		  document.getElementById("codecheck").innerHTML='*Customer code Exists';
		  document.getElementById("codecheck").style.color='#FF0000';
		  document.getElementById("submit").disabled='disabled';
		  alert('Customer code already exists');
		 }
		 else
		 {
		  document.getElementById("codecheck").style.display='';
		  document.getElementById("submit").disabled='';
		 }
		});
		
	} // end of if
});

});

function checkform ( form )
{
var numericExpression = /^[0-9]+$/;
    if (form.name.value == "") {
    alert( "Please enter Name." );
    form.name.focus();
    return false ;
  }

   else if (form.address.value == "") {
    alert( "Please enter Address." );
    form.address.focus();
    return false ;
  }
  
    else if (form.phone.value == "") {
    alert( "Please enter Phone no." );
    form.phone.focus();
    return false ;
  }
    else if (!(form.phone.value.match(numericExpression))) {
    alert( "Phone Number Should be Numeric only." );
    form.phone.focus();
    return false ;
  }
    else if (form.phone.value.length < 10 ) {
    alert( "Phone Number Should be atleast 10 digits." );
    form.phone.focus();
    return false ;
  }
     else if (form.mobile.value == "") {
    alert( "Please enter Mobile number." );
    form.mobile.focus();
    return false ;
  }
    else if (!(form.mobile.value.match(numericExpression))) {
    alert( "Mobile Number Should be Numeric only." );
    form.mobile.focus();
    return false ;
  }
    else if (form.mobile.value.length < 5 ) {
    alert( "Mobile Number Should be atleast 5 digits." );
    form.mobile.focus();
    return false ;
  }

else if (form.ctype.value == "") {
    alert( "Please select customer type." );
    form.customer.focus();
    return false ;
  }


  return true ;
}

</script>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_m_addcustomer.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
