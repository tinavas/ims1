<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$query1 = "SELECT * FROM vehicle_spareparts where id = '$id'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
$vtype= $row1['vehicletype'];
$parts = $row1['spareparts'];
$vtype1 = explode(',',$vtype);
$n = count($vtype1);
 for($i = 0;$i< $n-1; $i++)
{
$i;
$n1 = $vtype1[$i];

}
}
?>
<?php 

?>
<center>
<br />
<h1>Edit Vehicle Spare Parts</h1>
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br />

<br /><br />
<form id="form1" name="form1" method="post" action="vehicle_updatespare.php" >
<table align="center">
<tr>
<input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>
<td width="10px"></td>





<td colspan="2" align="right" style="vertical-align:middle"><strong><span id="certi"></span> Vehicle Types<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>


<td ><select  name="vt[]" id="vt" multiple="multiple" style="width:100px;height:80px">
<option value="" disabled="disabled">-Select-</option>
<?php
$q12 = "select * FROM vehicle_spareparts where id = '$id'";
$res1 = mysql_query($q12,$conn); 
while($qr = mysql_fetch_assoc($res1))
{
$type = $qr['vehicletype'];
$vtype1 = explode(',',$type);
}
$query = "SELECT * from vehicle_type where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['vtype']; ?>" <?php if(in_array($row1['vtype'], $vtype1)) { ?>selected="selected"<?php } ?>><?php echo $row1['vtype']; ?></option>
<?php } ?>

</select>
</td>
</tr>
</table>

    <br/>
<table border="0">



<tr>	

<tr>
<td width="25">
<td align="right"><strong>Spare Parts<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="parts" id = "parts" size="18" value = "<?php echo $parts;?>"/></td>
</tr>
   </table>
    <br/>
   
<center>	


   <br />
   <input type="submit" value="update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_spareparts';">
</center>


						
</form>
<script type="text/javascript">
function script1() {
window.open('vehiclehelp/help_m_edit_vehiclespare.php','BIMS',
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
