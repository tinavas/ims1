<?php include "config.php"; ?>



<center>

<br />

<h1>Edit Item Category</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br />



<form id="form1" name="form1" method="post" action="ims_updatecategory.php"  onsubmit="return checkform(this);">

<input type="hidden" id="oldid" name="oldid" value="<?php echo $_GET['id']; ?>" />

<table align="center" >

<tr> 

<td width="200" align="right"><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td width="240" align="left"><input type="text" id="cat" name="cat" size="25" value="<?php echo $_GET['category']; ?>" onkeyup="validatecode(this.id,this.value);"/></td>

</tr>

<tr height="10px"></tr>

<tr align="center">

<td colspan="2" align="center">

<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_category';">

</td>

</tr>

</table>

<script type="text/javascript">

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
function script1() {
window.open('IMSHelp/help_m_addcategory.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=YES,resizable=yes');
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