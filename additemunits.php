<?php include "config.php"; ?>



<center>

<br />

<h1>Add Units Of Measure</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br />

<form id="form1" name="form1" method="post" action="saveitemunits.php" onsubmit="return validate()">

<table align="center" >

<tr> 

<td width="200" align="right"><strong>Units</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td width="240" align="left"><input type="text" id="units" name="units" size="25" onkeyup="validatecode(this.id,this.value);"/></td>

</tr>

<tr height="10px"></tr>

<tr align="center">

<td colspan="2" align="center">

<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_additemcodes';">

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


function validate()
{
b=document.getElementById("units").value;
  
 <?php
 
 
 $query="select distinct(sunits) from ims_itemunits";
 $result=mysql_query($query,$conn);
 while($row=mysql_fetch_array($result))
 {?>
 var units=b.toUpperCase();
 if("<?php echo $row[0];?>"==units)
 {
 	alert("Unit Of measure already exists");
	return false;
 
 
 }
 
 <?php } ?>
 

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