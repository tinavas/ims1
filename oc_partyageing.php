<?php include "jquery.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Ageing Analysis</h1> 
<br /><br /><br />
<form method="post" target="_new" action="production/agingled1.php">
<table align="center">
<tr>
<td align="center">Customer Name</td>
<td>
<select id="code" name="code">
<option value="">Select</option>
<option value="All">All</option>
<?php 
		$q = "select * from contactdetails where type like '%party%' order by name";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['name']; ?>"><?php echo $qr['name']; ?></option>
<?php } ?>
</select>
</td>
</tr>
</table>
<table align="center">
<tr>
<td><strong align="right">Date&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.o"); ?>" onChange="datecomp();" ></td>
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
var fromdate = document.getElementById('date3').value;
var todate = document.getElementById('date3').value;
var vendor = document.getElementById('code').value;
if(vendor == "All")
{
 window.open('production/customerageingall.php?fromdate=' + fromdate + '&todate=' + todate + '&vendor=' + vendor);
}
else
{
 window.open('production/vendorageing.php?fromdate=' + fromdate + '&todate=' + todate + '&vendor=' + vendor); 
}

}

function reloadpur()
{
 
 date3 = document.getElementById('date3').value;
 date3 = temp =  date3.split('.');
 var tdate =(date3[2] + '-' + date3[1] + '-' + date3[0]).toString();
}

</script>

	


