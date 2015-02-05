<?php
include "config.php";
$id=$_GET['id'];
$get_Details="SELECT * FROM oc_employee WHERE id = '$id'";
$result_Details=mysql_query($get_Details,$conn);
$rows=mysql_num_rows($result_Details);
$details=mysql_fetch_array($result_Details);
$name=$details['name'];
$address=$details['address'];
$place=$details['place'];
$phone=$details['phone'];
$mobile=$details['mobile'];
$pan=$details['pan'];
$note=$note['note'];
$cnt = $cnt2 = 0;
 $ctype= $details['ctype'];
		    $query1 = "SELECT count(*) as c1 FROM oc_cobi where marketingemp = '$name' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt = $cnt + $row1a['c1'];
		   }
 
  
  
    
?>
<center>
<br/>
<h1>Marketing Employee</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="oc_updateemploye.php" onSubmit="return checkform(this);">
<input type="hidden" id="oldid" name="oldid" value="<?php echo $id; ?>" />
<table>

<tr>
<td align="right" style="vertical-align:middle;"><strong>Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="vertical-align:middle;  "><input  <?php if($cnt >0){?> style="border:none;background:none;" readonly <?php }?>type="text" id="name" name="name" size="30" value="<?php echo $name; ?>"/></td>

<td id="usercheck"></td>
<td style="display:none" id="loading" ><img  title="Verifying the Customer Name" src="images\mask-loader.gif" ></td>

<td align="right" style="vertical-align:middle;"><strong>Address</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="30" name="address"><?php echo $address; ?></textarea></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Place</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="place" size="30" value="<?php echo $place; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Phone</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="phone" size="30" value="<?php echo $phone; ?>"></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Mobile </strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mobile" size="30" value="<?php echo $mobile; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>PAN/TIN</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pan" size="30" value="<?php echo $pan; ?>" onkeyup="validatecode(this.id,this.value);"/></td>
</tr>
<tr style="height:10px"></tr>

<tr style="height:10px"></tr>
<tr>
<td align="left">&nbsp;&nbsp;<strong>Customer Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="ctype" id="ctype" style="width:200px">
 <option value="">-Select-</option>
<option  value="Walkable Customer" <?php if($ctype=="Walkable Customer"){?> selected="selected"<?php } ?>>Walkable Customer</option>
<option  value="Mew Marketing Customer" <?php if($ctype=="Mew Marketing Customer"){?> selected="selected"<?php } ?>>Mew Marketing Customer</option>
<option  value="Broker Customer" <?php if($ctype=="Broker Customer"){?> selected="selected"<?php } ?>>Broker Customer</option>
</select></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr style="height:10px"></tr>
<tr style="height:10px"></tr>

<tr>
<td align="right" colspan="2" style="vertical-align:middle;"><strong>Note</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left" colspan="3"><textarea rows="4" cols="35" name="note" ><?php echo $note; ?></textarea></td>
</tr>
<tr><td><input type="hidden" id="id" name="id" value="<?php echo $id; ?>"></td></tr>


</table>

<table>
<br />
<br />
<br />

<td>
<input type="submit" value="Update" id="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_employee';">

</form>
</center>
</td></tr>
</table>

</center>
<script language="JavaScript" type="text/javascript">
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
    alert( "Mobile Number Should be atleast 10 digits." );
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


 $(document).ready(function()
{  	
	$("#name").blur(function()
	{  
	   
	   if($("#name").val()) {
	   document.getElementById("usercheck").innerHTML='';
	   document.getElementById("usercheck").style.display='none';
	   document.getElementById("loading").style.display='';
		$.post("getcontactdetailsedit_ajax1.php",{ name:$("#name").val(),oldid:$("#oldid").val() },function(data)
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
});

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


</body>
</html>
