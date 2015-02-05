<?php include "jquery.php";
      include "getemployee.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Purchase Order Report</h1> 
<br /><br /><br />
<form target="_new">
<table align="center">
<tr>
<td align="center"><strong>Supplier</strong></td>
<td>
&nbsp;&nbsp;<select id="sup" name="sup" style="width:160px">
<option value="">Select</option>
<option value="All">All</option>
<?php 
     
		$q = "SELECT distinct(vendor) FROM pp_purchaseorder ORDER BY vendor ASC";

		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['vendor']; ?>" value="<?php echo $qr['vendor']; ?>"><?php echo $qr['vendor']; ?></option>
<?php } ?>
</select>
</td>
</tr>

</table>
<br>
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

<input type="button" id="report" value="Report" onClick="openreport();" />

</form>
</center>




<script type="text/javascript">
function openreport()
{
var fromdate = document.getElementById('date2').value;
var todate = document.getElementById('date3').value;
var vendor = document.getElementById('sup').value;
window.open('production/purchaseorderreport.php?fromdate=' + fromdate + '&todate=' + todate + '&vendor=' + vendor); 

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

</script>

	
