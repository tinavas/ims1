<?php 
include "mainconfig.php";
$q1=mysql_query("select password from tbl_users where username='$_SESSION[valid_user]'",$conn) or die(mysql_error());
$r1=mysql_fetch_array($q1);
$currentpassword=$r1[password];

include "config.php";

?>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {

 
	var changeTooltipPosition = function(event) {
	  var tooltipX = event.pageX - 8;
	  var tooltipY = event.pageY + 8;
	  $('div.tooltip').css({top: tooltipY, left: tooltipX});
	};
 
	var showTooltip = function(event) {
	  $('div.tooltip').remove();
	  $('<div class="tooltip"><font color="red">1.Password Should Not Contain Username.<br/>2.Password Should Contain Atleast 8 Characters.<br/>3.Password Should Contain One Uppercase Letter and One Lowercase Letter and One Digit between 0 to 9.<br/>4.Password Should Contain One Special Character like !@#$&*</font></div>')
            .appendTo('body');
	  changeTooltipPosition(event);
	};
 
	var hideTooltip = function() {
	   $('div.tooltip').remove();
	};
 
	$("span#hint,label#username").bind({
	   mousemove : changeTooltipPosition,
	   mouseenter : showTooltip,
	   mouseleave: hideTooltip
	});
});
	</script>
<style>
th {
	color: #3399cc;
}
form input[type=password]
{
   padding:0.2em;
}
#hint{
		cursor:pointer;
	}
	.tooltip{
		margin:8px;
		padding:8px;
		border:1px solid black;
		background-color:white;
		position: absolute;
		z-index: 2;
	}

</style>
<center>
<br />
<h1>   CHANGING  &nbsp; PASSWORD</h1>

<br /><br />
<form id="form1" name="form1" method="post" onSubmit="return validate();"  action="savechangepassword.php" >
<div>
<table border="0"  align="center">
   

<tr align="center">

<input type = "hidden" name = " username" id = "username" value = "<?php echo $_SESSION['valid_user'];?>" />

<td width="10px">&nbsp;</td>
<td><strong>Current Password</strong>&nbsp;&nbsp;</td>
<td>
<input type="Password"  name="ppassword" id="ppassword" size="15"  /></td>

</tr>
 <tr style="height:10px"></tr>    
<tr>
<td width="10px">&nbsp;</td>
<td><strong>New Password</strong>&nbsp;&nbsp;</td>
<td>
<input type="password"  name="npassword" id="npassword" size="15"   />&nbsp;<span id="hint" ><a href="#">Hint</a></span></td>

</tr>
 <tr style="height:10px"></tr>    
<tr>


<td width="10px">&nbsp;</td>
<td><strong>Retype Password</strong>&nbsp;&nbsp;</td>
<td>
<input type="Password"  name="rpassword" id="rpassword" size="15" onchange = "validuser(this.id);" /></td>

</tr>
</table>
<br/>
</div>
<br/>
<table align="center">

<tr>
<td colspan="5" align="center">
<center>
<input type="submit" value="Save" id="Save"  name="Save"/>&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=';">

</center>
</td>
</tr>
</table>

</form>
<script type="text/javascript">
 function validate()
 {
 var val=document.getElementById('ppassword').value;
 if(val=="<?php echo $currentpassword;?>")
{}
else
{
alert("Current Password Entered is Wrong");
 document.getElementById('ppassword').focus();
 return false;
}
   if(document.getElementById('npassword').value=='')
  {
  alert('Enter user password'); return false;
  }
  
   //validation for password starts here------
  
  var uname="<?php echo $_SESSION[valid_user];?>";

  var password=document.getElementById('npassword').value;
  
  if(password.match(uname))
  {
    alert("Password Should Not Contain Username");
    document.getElementById('npassword').focus();
    return false;
  }
   
   if(!validatepassword("npassword",password))
  {
   document.getElementById('npassword').focus();
   return false;
  }
  
  //validation of password end here-----------
 }
  function validatepassword(id,value)
 {
 
 if(value!="")
 {
 
 var strongRegex = new RegExp("^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$", "g");
 
 if(!strongRegex.test(value))
 {
 
 alert("Please Set Strong Password");
  document.getElementById(id).focus();
  
  return 0;
 }
 }
 return 1;
 }
 
 function validuser(a)
{

if(form1.rpassword.value != form1.npassword.value)
{
alert("please enter same passwords");
document.getElementById('npassword').value = "";
document.getElementById('rpassword').value = "";
}
}
</script>





















































