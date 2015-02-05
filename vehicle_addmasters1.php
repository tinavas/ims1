<center>
<br/>
<h1>Vehicle Master</h1>

<br/>
<br/><br />
<form enctype="multipart/form-data" method="post" action="vehicle_savemaster1.php">
<table border="0">

<tr>
<td align="right">&nbsp;&nbsp;<strong>Vehicle Type</strong>&nbsp;&nbsp;&nbsp;</td>



<td align="left"><select name="vt" id="vt" style="width:130px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT * from vehicle_type where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['vtype']; ?>"><?php echo $row1['vtype']; ?></option>
<?php } ?>
</select>
</td>

<td width="10px"></td>
<td align="right"><strong>Vehicle No:</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="vno" id="vno" size="18" /></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right">&nbsp;&nbsp;<strong>Purchase Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;<input class="datepicker" type="text" size="18" id="pdate" name="pdate" value="<?php echo date("d.m.Y"); ?>" ></td>



<td width="10px"></td>
<td align="right"><strong>Unit</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="unit" id="unit" style="width:130px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(sector) from tbl_sector where type1 <> 'Warehouse' and client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>
</td>
</tr>

<tr style="height:10px"></tr>

<tr>

<td align="right"><strong>RC Number</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="rc" id = "rc" size="18" /></td><td width="10px"></td>
<td align="right"><strong>Insurance Number</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ino" id = "ino" size="18" /></td></tr>

<tr style="height:10px"></tr>

<tr>

<td align="right">&nbsp;&nbsp;<strong>Insurance Expiry Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;<input class="datepicker" type="text" size="18" id="idate" name="idate" value="<?php echo date("d.m.Y"); ?>" ></td>

<td width="10px"></td>
<td align="right"><strong>Capacity</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="cap" id = "cap" size="18" /></td></tr>

</table>
<br /><br />

<table border="0">
<td>
<tr>
<td colspan="2" align="right" style="vertical-align:middle;"><strong>Remarks</strong>&nbsp;&nbsp;&nbsp;</td>
<td colspan="3" align="left"><textarea rows="3" cols="40" name="remarks" id="remarks" ></textarea></td>
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
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=vehicle_master';">

</form>
</center>
</td></tr>
</table>
</center>

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_m_addsupplier.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
