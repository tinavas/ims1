<?php include "jquery.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Breeder Combined Report</h1> 
<br /><br /><br />
<form target="_new" action="production/balancesheet.php">
<table align="center">
<tr>
<td align="right"><strong>Select Flock&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="flock">
<option> -Select- </option>
<?php
include "config.php"; 
$query2 = "SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = '0' order by flockcode ASC"; $result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
{
?>
<option value="<?php echo $row2['flockcode']; ?>"><?php echo $row2['flockcode']; ?></option>
<?php } ?>
</select>
</td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>


<script type="text/javascript">
function openreport()
{
var a = document.getElementById("flock").value;
window.open('newreport/index.php?flock=' + a); 
}
</script>
</body>
</html>
	

