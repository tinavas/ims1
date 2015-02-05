<center>
<br/>
<h1>Customer Details</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="oc_savecustomer.php" onSubmit="return checkform(this);">
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
<td align="right"><strong>Contact Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select id="type" name="type" style="width:200px" onchange="loadfun(this.value)">
<option value="party">Customer</option>
<option value="vendor and party">Supplier &amp; Customer</option>
<option value="broker">Broker</option>
</select></td></tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>PAN/TIN</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="pan" name="pan" size="30" onkeyup="validatecode(this.id,this.value);"/></td>
<td width="10px"></td>
<td align="right"><strong>Customer Group</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="cgroup" style="width:200px">
  <option value="">-Select-</option>
<?php 
       
		$q = "select * from ac_vgrmap where flag = 'C'   ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['vdesc']; ?>" value="<?php echo $qr['vgroup'].'@'.$qr['vca'].'@'.$qr['vppac']; ?>"><?php echo $qr['vgroup']; ?></option>
<?php } ?>

</select>	
</td></tr>

<tr style="height:10px"></tr>



<tr id="trvgroup" style="display:none">
<td align="right"><strong></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;<strong>Supplier Group</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="vgroup" style="width:200px">
 <option value="">-Select-</option>
<?php 
       include "config.php";
		$q = "select * from ac_vgrmap where flag = 'V'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['vdesc']; ?>" value="<?php echo $qr['vgroup'].'@'.$qr['vca'].'@'.$qr['vppac']; ?>"><?php echo $qr['vgroup']; ?></option>
<?php } ?>
</select></td>
</tr>
<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Credit Limit</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="climit" name="climit" size="30" onkeyup="validatenumber(this.id,this.value);" value="0"/></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;<strong>Credit Term</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="cterm" style="width:200px">
 <option value="0">-Select-</option>
<?php  
		$q = "select * from ims_creditterm";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['value']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select></td></tr>

<?php

if($_SESSION['db']=="singhsatrang")
{
?>
<tr style="height:10px"></tr>
<tr>
<td align="right"><strong>CNF/Super Stockist</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="checkbox" id="stockist" name="stockist" size="30"  value="YES" onclick="getstatevalue(this.checked)"/></td>
<td width="10px"></td>
<td align="right" id="stateid" style="visibility:hidden">&nbsp;&nbsp;<strong>State</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" id="statevalueid" style="visibility:hidden"><select name="state" id="state" style="width:200px;">
 <option value="">-Select-</option>
<?php
$q1="select distinct state from state_districts where state not in (select distinct state from contactdetails where state!='' and state is not null)";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['state'];?>"><?php echo $r1['state'];?></option>


<?php

}

?>




</select></td></tr>

<?php }?>


<tr style="height:10px"></tr>
<tr style="height:10px"></tr>
<tr style="height:10px"></tr>
<tr>
<td align="right"><strong></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td>
<td width="10px"></td>

</tr>
<tr style="height:10px"></tr>
<tr>
<td align="right" colspan="2" style="vertical-align:middle;"><strong>Note</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left" colspan="3"><textarea rows="4" cols="35" name="note" ></textarea></td>
</tr>



</table>
<table>
<br />
<td>
<input type="submit" value="Save" id="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_customer';">

</form>
</center>
</td></tr>
</table>

</center>
<script language="JavaScript" type="text/javascript">
function loadfun(a)
{
 if(a=='vendor and party')
  document.getElementById('trvgroup').style.display="block";
 else 
  document.getElementById('trvgroup').style.display="none";
}

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
		$.post("getcontactdetails_ajax.php",{ name:$("#name").val() },function(data)
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
  else if (form.type.value == "") {
    alert( "Please select Contact Type" );
    form.type.focus();
    return false ;
  }
  else if ((form.cgroup.value == "") || (form.cgroup.value == "-Select-")) {
    alert( "Please select Customer Group" );
    form.cgroup.focus();
    return false ;
  }
   else if (form.type.value == "vendor and party") {
	if ((form.vgroup.value == "") || (form.vgroup.value == "-Select-")) {
    alert( "Please select Suppplier Group" );
    form.vgroup.focus();
    return false ;
	}
  }
  
   if(document.getElementById("stockist").checked)
   {
   if(document.getElementById("state").value=="")
   {
   alert("Please Select state Value");
   document.getElementById("state").focus();
   return false;
   }
   }
   
   
   
   
  
 return true ;
}

function getstatevalue(status)
{

document.getElementById("stateid").style.visibility="hidden";
document.getElementById("statevalueid").style.visibility="hidden";

if(status)
{

document.getElementById("stateid").style.visibility="visible";
document.getElementById("statevalueid").style.visibility="visible";

}
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
