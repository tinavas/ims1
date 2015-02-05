<?php include "jquery.php";
      include "getemployee.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Brooder Weekly Report</h1> 
<br /><br /><br />
<form target="_new" action="#">
<table align="center">
<tr>
<td align="right"><strong>Flock&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select name="flock" id="flock">
<option value="">-Select-</option>
<?php 
             include "config.php";
             $q = "select distinct(flkmain) as flockcode from layer_flock where flockcode In (select distinct(flock) from layer_consumption) and client = '$client' order by flkmain ASC "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
?>
<option value="<?php echo $qr['flockcode']; ?>"><?php echo $qr['flockcode']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px"></td>
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
var flock = document.getElementById('flock').value;

window.open('production/growerrep.php?flock=' + flock); 

}

</script>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
	

