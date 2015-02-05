<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$query1 = "SELECT * FROM vehicle_servicemaster where id = '$id'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
$vtype= $row1['vehicletype'];
$scode = $row1['servicecode'];
$sdesc = $row1['servicedescription'];
$narration = $row1['narration'];
$ip = $row1['includedparts'];
$ip1 = explode(',',$ip);
$vtype1 = explode(',',$vtype);
$n = count($ip1);
for($i = 0;$i<$n;$i++)
{
 $vehtype = $vtype1[$i];
$parts = $ip1[$i];
}



}
?>

<center>
<br />
<h1>Edit Vehicle Service Master</h1>

<br /><br />
<form id="form1" name="form1" method="post" action="vehicle_updateservice.php" >

<table border="0">
<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />

<tr>
<td align="right"><strong>Service Code</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="scode" id="scode" size="18" value="<?php echo $scode;?>"/></td>


<td width="10px"></td>
<td align="right" ><strong>Service Description</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"  ><input type="text" name="sdesc" id="sdesc" size="18" value="<?php echo $sdesc;?>"/></td>




</tr>

<tr style="height:10px"></tr>

<tr>



<td align="right" style="vertical-align:middle">&nbsp;&nbsp;<strong>Vehicle Type</strong>&nbsp;&nbsp;&nbsp;</td>



<td align="left"><select name="vt[]" id="vt" multiple="multiple" style="width:130px" >
<option value="" disabled="disabled">-Select-</option>
<?php include "config.php"; 
     
$q12 = "select * FROM vehicle_servicemaster where id = '$id'";
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


<td width="10px"></td>
<td align="right" style="vertical-align:middle"><strong>Included Parts</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="ip[]" id="ip" multiple="multiple" style="width:130px" >
<option value="" disabled="disabled">-Select-</option>
<?php include "config.php"; 
      $q12 = "select * FROM vehicle_servicemaster where id = '$id'";
$res1 = mysql_query($q12,$conn); 
while($qr = mysql_fetch_assoc($res1))
{
	  $sp = $qr['includedparts'];
	 $sp1 = explode(',',$sp);
}
$query = "SELECT distinct(spareparts) from vehicle_spareparts where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['spareparts']; ?>" <?php if(in_array($row1['spareparts'], $sp1)) { ?>selected="selected"<?php } ?>><?php echo $row1['spareparts']; ?></option>
<?php } ?>

</select>
</td>
</tr>


</table>
<br /><br />

<table border="0">
<td>
<tr>
<td colspan="2" align="right" style="vertical-align:middle;"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td colspan="3" align="left"><textarea rows="3" cols="40" name="remarks" id="remarks" ></textarea></td>
</tr>
</table>




<br />
<br />
   
<center>	


   <br />
   <input type="submit" value="update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_service';">
</center>


						
</form>
<script type="text/javascript">
function script1() {
window.open('vehiclehelp/help_m_edit_vehicleservice.php','BIMS',
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
