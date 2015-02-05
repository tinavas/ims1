<?php
include "config.php";
?>
<center>
<br/>
<h1>Future Planning</h1>
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
$query = "select * from breeder_unit where client = '$client'";
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
<td align="left"><input type="text" id="cull" name="cull" value="" size="5" onblur="checkcull(this.id);"/></td>
</table>
<br/>
<br/>
<center>
<td>
<input type="button" id="report" value="Report" onClick="openreport();"></td>
</center>
</center>
</form>
<script type="text/javascript">
function checkcull(age)
{
var age = document.getElementById(age).value;
<?php 
$q = "select max(age) as mage from breeder_standards where client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r))
{$age = $qr['mage'];
?>
if(age > "<?php echo $age;?>")
{
alert("Cull Age is greater than maximum week in standards");
document.getElementById("cull").value = "";
}
<?php } ?>
}
function openreport()
{
var uni = document.getElementById("unit").value;
var cull = document.getElementById("cull").value;
window.open('production/futureplanning.php?unit=' + uni + '&cull=' + cull); 
}
</script>
