<?php
include "config.php";
?>
<center>
<br/>
<h1>Layer Breeder Future Planning</h1>
<br/>
<br/><br />
<form target="_new">


<table border="0" align="center">
<tr>
<td align="right"><strong>Unit&nbsp;&nbsp;</strong></td>
<td align="left">
<select id="unit" name="unit" style="width:75px">
<option value="All">All</option>
<?php 
$query = "select * from layerbreeder_unit where client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $qr['unitcode'];?>"><?php echo $qr['unitcode'];?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="10px"></tr>
<td align="right"><strong>Cull Age &nbsp;&nbsp;</strong></td>
<td align="left"><input type="text" id="cull" name="cull" value="" size="5"/></td>
</table>
<br/>
<br/>
<center>
<td>
<input type="button" id="report" value="report" onClick="openreport();"></td>
</center>
</center>
</form>
<script type="text/javascript">
function openreport()
{
var uni = document.getElementById("unit").value;
var cull = document.getElementById("cull").value;
window.open('production/lbfutureplanning.php?unit=' + uni + '&cull=' + cull); 
}
</script>
