<?php
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$id= $_GET['id'];
$query1 = "SELECT * FROM vehicle_master where id = '$id'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
	
  
	$vtype = $row1['vtype'];
	$vnumber = $row1['vnumber'];
	
	$unit = $row1['unit'];
	$rcnumber = $row1['rcnumber'];
	$inumber = $row1['insurancenumber'];
	 $pdate = date("d.m.Y", strtotime($row1['purchasedate']));
	 $pcost = $row1['purchasecost'];
	$capacity = $row1['capacity'];
	$remarks = $row1['remarks'];
	$idate = date("d.m.Y", strtotime($row1['iexpirydate']));
  
}
?>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="vehicle_updatemaster.php" >
		
		
<center>
<br />
<h1>Edit Vehicle Master</h1>
<br/>
<br/>
<table align="center">
<tr>
<td><input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/></td>
<table border="0">

<tr>
<td align="right">&nbsp;&nbsp;<strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>



<td align="left"><select name="vt" id="vt" style="width:130px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT * from vehicle_type  ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
if($row1['vtype'] == $vtype)
 {
?>
<option value="<?php echo $row1['vtype']; ?>" selected="selected"><?php echo $row1['vtype']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['vtype']; ?>" ><?php echo $row1['vtype']; ?></option>

<?php }}?>
</select>
</td>

<td width="10px"></td>
<td align="right"><strong>Vehicle No:<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="vno" id="vno" size="18" value="<?php echo $vnumber;?>" /></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right">&nbsp;&nbsp;<strong>Purchase Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;<input class="datepicker" type="text" size="18" id="pdate" name="pdate" value="<?php echo $pdate; ?>" ></td>

<td width="10px"></td>
<td align="right"><strong>Purchase Cost<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pc" id="pc" size="18" value="<?php echo $pcost;?>"/></td>

</tr>
<tr style="height:10px"></tr>
<tr>
<td align="right"><strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="unit" id="unit" style="width:130px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(sector) from tbl_sector where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
if($row1['sector'] == $unit)
 {
?>
<option value="<?php echo $row1['sector']; ?>" selected="selected"><?php echo $row1['sector']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>

<?php }}?>
</select>
</td>



<td width="10px"></td>
<td align="right"><strong>RC Number<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="rc" id = "rc" size="18" value="<?php echo $rcnumber;?>"/></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Insurance Number<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ino" id = "ino" size="18" value="<?php echo $inumber;?>" /></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;<strong>Insurance Expiry Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;<input class="datepicker" type="text" size="18" id="idate" name="idate" value="<?php echo $idate; ?>" ></td>

</tr>
<tr style="height:10px"></tr>

<tr>

<td align="right"><strong>Capacity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="cap" id = "cap" size="18" value="<?php echo $capacity;?>" /></td></tr>

</table>
<br /><br />

<table border="0">
<td>
<tr>
<td colspan="2" align="right" style="vertical-align:middle;"><strong>Remarks</strong>&nbsp;&nbsp;&nbsp;</td>
<td colspan="3" align="left"><textarea rows="3" cols="40" name="remarks" id="remarks" ><?php echo $remarks;?></textarea></td>
</tr>
</table>
<br /><br />
<table border="0">

<tr>
<td align="right"><strong>Image</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="hidden" name="MAX_FILE_SIZE" value="100000000000" /><input name="uploadedfile" type="file" width="15px" size="15"/></td>
</tr>

</table>
<br />

<table border="0">
<td>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=vehicle_master';">

</form>
</center>
</td></tr>
</table>
</center>

<script type="text/javascript">
function script1() {
window.open('vehiclehelp/help_m_edit_vehiclemaster.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
