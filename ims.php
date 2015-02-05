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
<td align="center">Item Code</td>
<td>
&nbsp;&nbsp;<select id="code" name="code" onchange="getdescription();" style="width:160px">
<option value="">Select</option>
<option value="All">All</option>
<?php 
		$q = "select code,description from ims_itemcodes order by code  ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['description']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr>
<td align="center">Description</td>
<td>
&nbsp;&nbsp;<select id="desc" name="desc" onchange="getcode();" style="width:160px">
<option value="">Select</option>
<option value="All">All</option>
<?php 
		$q = "select code,description from ims_itemcodes order by code  ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['description']; ?>"><?php echo $qr['description']; ?></option>
<?php } ?>
</select></td>
</tr>
</table>
<table align="center">
<tr>
<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo date("d.m.o"); ?>" ></td>
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
//var code = document.getElementById('code').value;
var e = document.getElementById("code");
var code = e.options[e.selectedIndex].text;
if(code == "All")
{
 window.open('production/itemledgerall.php?fromdate=' + fromdate + '&todate=' + todate + '&code=' + code);
}
else
{
 window.open('production/itemledger.php?fromdate=' + fromdate + '&todate=' + todate + '&code=' + code); 
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
function description()
{

	<?php
		$q = "select * from ims_itemcodes order by code";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code').value == '$qr[code]') { ";
		$q1 = "select code,description from ims_itemcodes where code = '$qr[code]'";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc').value = "<?php echo $q1r['description']; ?>";
		
		<?php 
		}
		echo " } "; 
		}
		?>
		
}

function getdescription()
{
  document.getElementById("desc").value = document.getElementById("code").value;
}
function getcode()
{
  document.getElementById("code").value = document.getElementById("desc").value;
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

	
