<?php


$q1=mysql_query("set group_concat_max_len=10000000000");

$q1="select group_concat(name separator '$') as names from distribution_distributor";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$allnames=explode('$',$r1['names']);

$allnamesj=json_encode($allnames);


?>
<script type="text/javascript">

var allnamesj=<?php echo $allnamesj;?>;


</script>

<center>
<br/>
<h1>Distributor Details</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="distribution_savedistributor.php" onSubmit="return checkform(this);">
<table>

<tr>
<td align="right" style="vertical-align:middle;"><strong>Distributor Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="vertical-align:middle;"><input type="text" id="name" name="name" size="30" onkeyup="validatecode(this.id,this.value);" onblur="checkforname(this.id,this.value)" /></td>

<td id="usercheck"></td>
<td style="display:none" id="loading" ><img  title="Verifying the Customer Name" src="images\mask-loader.gif" ></td>

<td align="right" style="vertical-align:middle;"><strong>Address</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="30" name="address"></textarea></td>
</tr>

<tr style="height:10px"></tr>
<tr>
<td align="right"><strong>Place</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="place" size="30"  onkeyup="validatecode(this.id,this.value);"/></td>
<td width="10px"></td>
<td align="right"><strong>Phone</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="phone" size="30" /></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Mobile</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mobile" size="30" /></td>
<td width="10px"></td>
<td align="right"><strong>PAN/TIN</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="pan" name="pan" size="30" onkeyup="validatecode(this.id,this.value);"/></td></tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Area Code</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="areacode" id="areacode" style="width:200px" onchange="getname()">
  <option value="">-Select-</option>
<?php

$q1="select areacode from distribution_area ";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['areacode'];?>"><?php echo $r1['areacode'];?></option>
<?php }?>


</select></td>
<td width="10px"></td>
<td align="right"><strong>&nbsp;&nbsp;&nbsp;Area Name</strong></td>
<td align="left"><select name="areaname" id="areaname" style="width:200px" onchange="getcode()">
  <option value="">-Select-</option>
<?php

$q1="select areacode,areaname from distribution_area order by areacode";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['areaname'];?>" title="<?php echo $r1['areaname'];?>"><?php echo $r1['areaname'];?></option>
<?php }?>


</select>
</td></tr>


<tr style="height:10px"></tr>

<tr>
<td align="right"><strong></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td></tr>




<tr style="height:10px"></tr>
<tr>
<td align="right" colspan="2" style="vertical-align:middle;"><strong>Note</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left" colspan="3"><textarea rows="4" cols="35" name="note" ></textarea></td>
</tr>



</table>
<table>
<br />
<tr>
<td>
<input type="submit" value="Save" id="save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=distribution_distributor';" id="cancel">

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
 
  else if ((form.areacode.value == "") || (form.areacode.value == "-Select-")) {
    alert( "Please Enter Area Code" );
    form.areacode.focus();
    return false ;
  }
   
  
   document.getElementById("save").disabled="true";
   document.getElementById("cancel").disabled="true";

   
    return true ;
}


function checkforname(id,name)
{

for(i=0;i<allnamesj.length;i++)
{
if(name==allnamesj[i])
{
alert("This Name Already Exists");
document.getElementById(id).value="";
document.getElementById(id).focus();
return false;
}
}

}


function checkstring(id,value)
{

var reg=new RegExp("^[0-9a-zA-z\ ]*$");

if(!reg.test(value))
 {

 alert("Enter Correct String (No Special Characters)");
 
 document.getElementById(id).value="";

 document.getElementById(id).focus();
 
	return false;
 
 
 }



}


function getname()
{

  document.getElementById("areaname").options[document.getElementById("areacode").options.selectedIndex].selected="selected";

}


function getcode()
{

document.getElementById("areacode").options[document.getElementById("areaname").options.selectedIndex].selected="selected";


 
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
