<?php include "jquery.php";
      include "config.php"; 
      include "getemployee.php";
?>
<center>
<br />
<h1>Supplier Statement Of Account</h1> 
<br /><br /><br />
<form target="_new" action="production/vendorstatement.php">
<table align="center">
<tr>
<td align="center"><strong>Supplier Name&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<select <?php if($_SESSION[db]=='albustan' || $_SESSION[db]=='albustanlayer') { ?> onchange="document.getElementById('vendorcode').value=this.value" <?php } ?> id="code" name="code">
<option value="">Select</option>
<?php 
		$q = "select * from contactdetails where type = 'vendor' or type = 'vendor and party' order by name  ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['name']; ?>"><?php echo $qr['name']; ?></option>
<?php } ?>
</select>
</td> 
<tr height="20px"></tr> 
<?php if($_SESSION[db]=='albustan' || $_SESSION[db]=='albustanlayer') { ?>
<td align="center"><strong>Supplier Code</strong></td>
<td>
<select onchange="document.getElementById('code').value=this.value" id="vendorcode" name="venodrcode">
<option value="">Select</option>
<?php 
		$q = "select name,code from contactdetails where type = 'vendor' or type = 'vendor and party' order by name  ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['name']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
<?php } ?>
</tr>
</table>
<table align="center">
<tr>
<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo date("d.m.o"); ?>" onChange="datecomp();" ></td>
<td width="10px"></td>
<td><strong align="right">To&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.o"); ?>" onChange="datecomp();" ></td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();" /> 
</form>
</center>




<script type="text/javascript">
function openreport()
{
var fromdate = document.getElementById('date2').value;
var todate = document.getElementById('date3').value;
var vendor = document.getElementById('code').value;

window.open('production/vendorstatement.php?fromdate=' + fromdate + '&todate=' + todate + '&vendor=' + vendor); 

}


function datecomp()
{
<?php echo "
dd = document.getElementById('date2').value;
temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
temp1 = new Date(temp);

dd1 = document.getElementById('date3').value;
temp3 =  dd1.split('.');
temp3 = temp3[1] + '/' + temp3[0] + '/' + temp3[2];
temp4 = new Date(temp3);

if(temp1 >=temp4)
{
 alert('To date must be greater than or equal to From date');
 document.getElementById('report').disabled = true;
}
else
{
 document.getElementById('report').disabled = false;
 reloadpurord();
}
 ";
?>
}


function reloadpur()
{
 date2 = document.getElementById('date2').value;
 date2 = temp =  date2.split('.');
 var fdate =(date1[2] + '-' + date2[1] + '-' + date2[0]).toString();
 
 date3 = document.getElementById('date3').value;
 date3 = temp =  date3.split('.');
 var tdate =(date3[2] + '-' + date3[1] + '-' + date3[0]).toString();
}

</script>

	

