<?php 
include "jquery.php"; 
include "config.php";



?>


<center>
<br />
<h1>Vehicle Types</h1>

              <center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> <br />

<br /><br />
<form id="form1" name="form1" method="post" action="vehicle_savetype.php" onsubmit="return checktype(this);">
<table border="0">

<tr>
<td><strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="vt" name="vt" onkeyup="checkty(this.id);"/>

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
   <input type="button" value="cancel" onclick="document.location='dashboardsub.php?page=vehicle_type';">
</center>


						
</form>
<script type="text/javascript">
function checkty(type)
{
	var type = document.getElementById(type).value;
	<?php 
	$qury = "select * from vehicle_type";
	$res = mysql_query($qury,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($res))
	{
		$vtype = $qr['vtype'];
	?>
	if(type == "<?php echo $vtype;?>")
	{
		alert("Vehicletype already exits");
		document.getElementById("vt").value = "";
		}
	<?php } ?>
}
function checktype(form)
{
if(form.vt.value == "")
{
alert("Please Enter Type");
 form.vt.focus();
return false;
}
return true;
	
}
</script>
<script type="text/javascript">

function script1() {
window.open('vehiclehelp/helptype.php','BIMS',
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
