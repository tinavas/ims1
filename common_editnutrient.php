<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$query1 = "SELECT * FROM common_nutrient where id = '$id'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
	$name = $row1['nutrient'];

}
?>

<center>
<br />
<h1>Edit Nutrient</h1>

<br /><br />
<form id="form1" name="form1" method="post" action="common_savenutrient.php" >
<table align="center">
<tr>
<input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>
 <input type="hidden" id="saed" name="saed" value="1" />
<td><strong>Nutrient&nbsp;&nbsp;</strong></td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="nutrient" value = "<?php echo $name;?>" name="nutrient"/>
</td>

 </tr>
   </table>
   <br /> 
 </center>		

<center>	


   <br />
   <input type="submit" value="update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=common_nutrient';">
</center>


						
</form>
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
