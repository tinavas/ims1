<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$query1 = "SELECT * FROM vehicle_chargemaster where id = '$id'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
$id =  $row1['id'];

$ccode = $row1['chargecode'];
$cdesc = $row1['chargedescription'];
$narration = $row1['narration'];

$vtype1 = explode(',',$vtype);
$n = count($ip1);
for($i = 0;$i<$n;$i++)
{
 $vehtype = $vtype1[$i];

}
}
?>

<center>
<br />
<h1>Edit Vehicle Charge Master</h1>

<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> <br />


<br /><br />
<form id="form1" name="form1" method="post" action="vehicle_updatechargemaster.php" >
<table border="0">
<input type="hidden" id="idnum" name="idnum" value="<?php echo $id;?>" />
<tr>
<td align="right"><strong>Charge Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ccode" id="ccode" size="18" value="<?php echo $ccode;?>" /></td>


<td width="10px"></td>

<td align="right"  style="vertical-align:middle"><strong>Charge Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"  style="vertical-align:middle"><input type="text" name="cdesc" id="cdesc" size="18" value="<?php echo $cdesc;?>" /></td>


</tr>

<tr style="height:10px"></tr>

<tr>


<td align="right">&nbsp;&nbsp;<strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>



<td align="left"><select name="vt[]" id="vt" multiple="multiple" style="width:130px" >
<option value="" disabled="disabled">-Select-</option>
<?php
$q12 = "select * FROM vehicle_chargemaster where id = '$id'";
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
<br /><br />


<table border="0">
<td>
<tr>
<td colspan="2" align="right" style="vertical-align:middle;"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td colspan="3" align="left"><textarea rows="3" cols="40" name="remarks" id="remarks" ><?php echo $narration;?></textarea></td>
</tr>
</table>
<br /><br />

   
<center>	


   <br />
   <input type="submit" value="update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_chargemaster';">
</center>


						
</form>
<script type="text/javascript">
function script1() {
window.open('vehiclehelp/help_m_editchargemasters.php','BIMS',
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
