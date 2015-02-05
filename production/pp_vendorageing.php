<?php include "jquery.php";
      include "config.php"; 
	  $type = $_GET['type'];
?>
<center>
<br />
<h1>Ageing Analysis</h1> 
<br /><br /><br />
<form method="post" target="_new" action="production/agingled1.php">
<table align="center">
<tr>
<td align="right"><strong><?php if($type == "vendor"){?> Supplier<?php } else {?> Customer<?php } ?> Name &nbsp;</strong></td>
<td align="left">
<select <?php if($_SESSION[db]=='albustan' || $_SESSION[db]=='albustanlayer') { ?> onchange="document.getElementById('vendorcode').value=this.value" <?php } ?> id="code" name="code">
<option value="">Select</option>
<option value="All">All</option>
<?php 
		$q = "select name from contactdetails where type = '$type' or type = 'vendor and party' order by name  ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['name']; ?>"><?php echo $qr['name']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="15px"></tr>
<?php if($_SESSION[db]=='albustan' || $_SESSION[db]=='albustanlayer') { ?>
<tr>
<td align="right"><strong><?php if($type == "vendor"){?> Supplier<?php } else {?> Customer<?php } ?> Code &nbsp;</strong></td>
<td align="left">
<select onchange="document.getElementById('code').value=this.value" id="vendorcode" name="vendorcode">
<option value="">Select</option>
<option value="All">All</option>
<?php 
		$q = "select name,code from contactdetails where type = '$type' or type = 'vendor and party' order by code  ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['name']; ?>" value="<?php echo $qr['name']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<?php } ?>

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
 window.open('production/vendorageingall.php?fromdate=' + fromdate + '&todate=' + todate + '&vendor=' + vendor + "&type=<?php echo $type; ?>");
}
else
{
 window.open('production/vendorageingall.php?fromdate=' + fromdate + '&todate=' + todate + '&vendor=' + vendor + "&type=<?php echo $type; ?>"); 
}

}

function reloadpur()
{
 
 date3 = document.getElementById('date3').value;
 date3 = temp =  date3.split('.');
 var tdate =(date3[2] + '-' + date3[1] + '-' + date3[0]).toString();
}

</script>

	


