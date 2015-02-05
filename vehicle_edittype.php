<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$query1 = "SELECT * FROM vehicle_type where id = '$id'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
$vt= $row1['vtype'];
}
?>

<center>
<br />
<h1>Edit Vehicle Type</h1>
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> <br />

<br /><br />
<form id="form1" name="form1" method="post" action="vehicle_updatetype.php" >
<table align="center">
<tr>
<td><input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>
<td><strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="vt" value = "<?php echo $vt;?>" name="vt"/>
</td>

 </tr>
   </table>
   <br /> 
 </center>		

<center>	


   <br />
   <input type="submit" value="update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_type';">
</center>


						
</form>
<script type="text/javascript">
function script1() {
window.open('vehiclehelp/edithelptype.php','BIMS',
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
