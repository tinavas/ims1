<?php include "jquery.php";
      include "config.php"; 
      include "getemployee.php";
?>
<center>
<br />
<h1>Customer Debit Note</h1> 
<br /><br /><br />
<form target="_new">

<table align="center">
<tr align = "center">
<td align="right"><strong>Customer Name&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select <?php if($_SESSION[db]=='albustan' || $_SESSION[db]=='albustanlayer') { ?> onchange="document.getElementById('vpcode').value=this.value" <?php } ?> name = "vcode" id = "vcode" style = "width:180px">
<option value = "-select-">-select-</option>
<option value = "All">All</option>
<?php 
$q  = "select distinct(vcode) from ac_crdrnote where mode = 'CDN' order by vcode";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r))
{
?>
<option value = "<?php echo $qr['vcode'];?>"><?php echo $qr['vcode'];?></option>
<?php } ?>
</select>
</td>
</tr>

<?php if($_SESSION[db]=='albustan' || $_SESSION[db]=='albustanlayer') { ?>
<tr height="15px"></tr>
<tr align = "center">
<td align="right"><strong>Customer Code&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select onchange="document.getElementById('vcode').value=this.value" name = "vpcode" id = "vpcode" style = "width:180px">
<option value = "-select-">-select-</option>
<option value = "All">All</option>
<?php 
$q  = "select distinct(vcode),vpcode from ac_crdrnote where mode = 'CDN' order by vpcode";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r))
{
?>
<option value = "<?php echo $qr['vcode'];?>"><?php echo $qr['vpcode'];?></option>
<?php } ?>
</select>
</td>
</tr>
<?php } ?>
<tr height="15px"></tr>

</table>
<table align="center">
<tr height = "10px">
<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo date("d.m.Y"); ?>" onChange="datecomp();" ></td>
<td width="10px"></td>
<td><strong align="right">To&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.Y"); ?>" onChange="datecomp();" ></td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>




<script type="text/javascript">

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
function openreport()
{
var name1 = document.getElementById('vcode').value;

var fromdate = document.getElementById('date2').value;
var todate = document.getElementById('date3').value;
if((name1 == '-select-')||(name1 == ""))
{
alert("Please select vendor");
return false;
}
else
{
window.open('production/customerdebitnote.php?fromdate=' + fromdate + '&todate=' + todate + '&name=' + name1);


}
}
</script>

	
