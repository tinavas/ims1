<?php include "jquery.php";
      include "getemployee.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Item Ledger</h1> 
<br /><br /><br />
<form target="_new">
<table align="center">

<tr>
<td align="right">Warehouse
</td>
<td>&nbsp;
<select id="warehouse" name="warehouse" style="width:160px">
<option value="">-All-</option>
<?php
$q = "select distinct(sector) from tbl_sector WHERE type1 = 'Warehouse' order by sector";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$n1 = mysql_num_rows($qrs);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['sector']; ?>" <?php if($n1 == 1) { ?> selected="selected"<?php } ?> ><?php echo $qr['sector']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="20px"></tr>

<tr>
<td align="center">Item Code</td>
<td>
&nbsp;&nbsp;<select id="code" name="code" onchange="getDescription();" style="width:160px">
<option value="">Select</option>
<option value="All">All</option>
<?php 
if($_SESSION['db'] == 'central') {
$q = "select code,description from ims_itemcodes where client = '$client' and cat NOT IN (select cat from chicken_category where client = '$client') order by code  ";
}
else
{
		$q = "select code,description from ims_itemcodes where client = '$client' order by code  ";
}
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['description']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="20px"></tr>
<tr>
<td align="center">Description</td>
<td>
&nbsp;&nbsp;<select id="description" name="description" onchange="getCode();" style="width:160px">
<option value="">Select</option>
<option value="All">All</option>
<?php 
if($_SESSION['db'] == 'central') {
$q = "select code,description from ims_itemcodes where client = '$client' and cat NOT IN (select cat from chicken_category where client = '$client') order by code  ";
}
else
{
		$q = "select code,description from ims_itemcodes where client = '$client' order by description ";
}
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['code'];?>"value="<?php echo $qr['description']; ?>"><?php echo $qr['description']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="20px"></tr>
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
var w = document.getElementById('code').selectedIndex; 
var code = document.getElementById('code').options[w].text;
var v = document.getElementById('description').selectedIndex; 
var desc = document.getElementById('description').options[v].text;
var warehouse = document.getElementById('warehouse').value;
if(code == "All")
{
 window.open('production/itemledgerallgolden.php?fromdate=' + fromdate + '&todate=' + todate + '&code=' + code + '&description=' + desc + '&warehouse=' + warehouse);
}
else
{
 window.open('production/itemledgergolden.php?fromdate=' + fromdate + '&todate=' + todate + '&code=' + code + '&description=' + desc + '&warehouse=' + warehouse); 
}
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

function getDescription()
{
  document.getElementById("description").value = document.getElementById("code").value;
}
function getCode()
{
  document.getElementById("code").value = document.getElementById("description").value;
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

	
