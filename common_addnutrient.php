<?php 
include "config.php";
?>


<center>
<br />
<h1>Nutrient</h1>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br /><br />
<form id="form1" name="form1" method="post" action="common_savenutrient.php" >
<table align="center">
<tr>
<td width="10px">&nbsp;</td>
<td><strong>Nutrient&nbsp;&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" value="Nutrient" style="color:#999; font-style:italic;" onfocus="mouseIn(this.id);" onblur="mouseOut(this.id);" id="nutrient" name="nutrient"/>
</td>


 </tr>

   </table>
   <br/>
   <br /> 
 </center>		

<center>	


   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onclick="document.location='dashboardsub.php?page=common_nutrient';">
</center>


						
</form>
<script type="text/javascript">
function mouseIn(a)
{
if(document.getElementById(a).value == "Nutrient")
{
	document.getElementById(a).value = "";
	document.getElementById(a).style.color = "#000000";	
	document.getElementById(a).style.fontStyle = "normal";
}
}
function mouseOut(a)
{
if(!document.getElementById(a).value)
{
	document.getElementById(a).value = "Nutrient";
	document.getElementById(a).style.color = "#999";

}
}
</script>
<script type="text/javascript">
function script1() {
window.open('Management Help/designation.php','BIMS',
'width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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
