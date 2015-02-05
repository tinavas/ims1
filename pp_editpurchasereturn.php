<?php  
include "config.php"; 
include "jquery.php";
if(!isset($_GET['vendor']))
$vendor = "";
else
$vendor = $_GET['vendor'];

if(!isset($_GET['sobi']))
$sobi = "";
else
$sobi = $_GET['sobi'];

$id = $_GET['id'];

$query = "SELECT * FROM pp_purchasereturn where trid = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error()); 
while($row1 = mysql_fetch_assoc($result))
{
$mid = $row1['trid'];
$vendor = $row1['vendor'];
$vendorcode = $row1['vendorcode'];
$so = $row1['sobi'];
$date = date("d.m.Y",strtotime($row1['date']));
$narration = $row1['narration'];
}
		  
?>

<br />
<center>
<h1>Purchase Return</h1>&nbsp;&nbsp;&nbsp;&nbsp;
</center>
<form id="form1" name="form1" method="post" action="pp_updatepurchasereturn.php" >
<br />
<br />
<table id="paraID" align="center" cellpadding="5" cellspacing="5">
<tr>
<td colspan="2"><strong>PRE</strong>&nbsp;
<input size="5" type="text"  name="pre" id="pre" value="<?php echo $mid; ?>" readonly style="border:0px;background:none" />
</td>

<td  colspan="2"><strong>Vendor Name</strong>&nbsp;
<select name="vendor" id="vendor" style="width:140px">
<option value="<?php echo $vendor; ?>"><?php echo $vendor; ?></option>
</select>
</td>

<td  colspan="2"><strong>Vendor Code</strong>&nbsp;
<select name="vendorcode" id="vendorcode" style="width:140px">
<option value="<?php echo $vendorcode; ?>"><?php echo $vendorcode; ?></option>
</select>
</td>


<td>&nbsp;&nbsp; <strong>SOBI</strong>&nbsp;
<select name="sobi" id="sobi" style="width:140px" onChange="loadpage();">
<option value="<?php echo $so; ?>"><?php echo $so; ?></option>
</select>
</td>

<td>&nbsp;&nbsp; <strong>Date</strong>&nbsp;
<input type="text" id="date" name="date" value="<?php echo $date; ?>" size="12" />
</td>
</tr>
</table>
<br /><br />

<?php 

$q = "select * from pp_purchasereturn where vendor = '$vendor' and sobi = '$so' order by code";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if(mysql_num_rows($qrs) != 0)
{
 
?>
<table align="center" cellpadding="10" cellspacing="10" width="700px">
<tr align="center">
<td><strong>Item Code</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Description</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Purchased<br />Quantity</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Returned<br />Quantity</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Amount</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Ware House</strong></td>
<!--<td><strong>Goods Status</strong></td>-->
</tr>
<?php } ?>
<tr height="10px"><td>&nbsp;</td></tr>
<?php 
$i = 0;
while($qr = mysql_fetch_assoc($qrs))
{
$warehouse = $qr['warehouse'];
?>
<tr>

<td>

<input readonly size="10" type="text" style="background:none;border:none" name="code[]" id="code<?php echo $i; ?>" value="<?php echo $qr['code']; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input readonly size="10" type="text" style="background:none;border:none" name="description[]" id="description<?php echo $i; ?>" value="<?php echo $qr['description']; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input readonly size="10" type="text" style="background:none;border:none;text-align:right" name="purchasedquantity[]" id="purchasedquantity<?php echo $i; ?>" value="<?php echo $qr['purchasedquantity']; ?>" />&nbsp;&nbsp;&nbsp;
</td>
<td width="10px">&nbsp;</td>
<td>

<input size="10" type="text" name="returnquantity[]" id="returnquantity<?php echo $i; ?>" value="<?php echo $qr['returnquantity']; ?>" onKeyUp="checkquantity(<?php echo $i; ?>);" style="text-align:right"/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input size="10" type="text" name="amount[]" style="background:none;border:none;text-align:right" id="amount<?php echo $i; ?>" value="<?php echo $qr['purchasedquantity'] * $qr['rateperunit']; ?>"/>&nbsp;&nbsp;&nbsp;
<input type="hidden" id="totalamount" value="<?php echo $qr['purchasedquantity'] * $qr['rateperunit']; ?>" />
</td>
<input type="hidden" id="rateperunit<?php echo $i; ?>" name="rateperunit[]" value="<?php echo $qr['rateperunit']; ?>" />
<td width="10px">&nbsp;</td>
<td>
<input readonly size="10" type="text" style="background:none;border:none;text-align:right" name="warehouse[]" id="warehouse<?php echo $i; ?>" value="<?php echo $warehouse ?>" /></td>

<!--<td>
<select id="wastage<?php echo $i; ?>" name="wastage[]">
<option value="">-Select-</option>
<option value="removefromstock">Remove From Stock</option>
<option value="ignore">Ignore</option>
</select>

</td>-->
</tr>

<tr height="5px"></tr>
<?php $i++; } ?>
</table>
<table align="center" cellpadding="10" cellspacing="10">
<tr>
<td><strong>Narration&nbsp;</strong></td>
<td><textarea name="narr" id="narr" rows="3" cols="40"><?php echo $narration; ?></textarea></td>
</tr>
</table>
<br>
<br>
<center>

<input type="submit" id="save" value="Update" />&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchasereturn';"/>
<input type="hidden" name="warehouse1111" id="warehouse" value="<?php echo $warehouse; ?>" />
</center>
</form>

<script type="text/javascript">

function checkstatus()
{
	<?php for($j = 0; $j < $i; $j++) {?>
	if(document.getElementById('returnquantity<?php echo $j; ?>').value == "" || document.getElementById('returnquantity<?php echo $j; ?>').value == "0")
	{
		alert("Please Enter Return Quantity");
		document.getElementById('returnquantity<?php echo $j; ?>').focus();
		return false;
	}
	<?php } ?>

	<?php for($j = 0; $j < $i; $j++) {?>
	if(document.getElementById('wastage<?php echo $j; ?>').value == "")
	{
		alert("Please select Goods Status");
		document.getElementById('wastage<?php echo $j; ?>').focus();
		return false;
	}
	<?php } ?>

	
return true;
}
function checkquantity(i)
{
	if(document.getElementById("returnquantity" + i).value == "")
	{
		document.getElementById("returnquantity" + i).value = 0;
	}
	
	if(parseFloat(document.getElementById("returnquantity" + i).value) > parseFloat(document.getElementById("purchasedquantity" + i).value))
	{
		alert("Return Quantity should be less than or equal to Purchased Quantity");
		document.getElementById("returnquantity" + i).value = 0;
	}
	
}


function loadpage()
{
	var vendor = document.getElementById('vendor').value;
	var sobi = document.getElementById('sobi').value;
	document.location = "dashboardsub.php?page=pp_editpurchasereturn&vendor=" + vendor + "&sobi=" + sobi;
}

</script>


<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_p_addpurchasereturn.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>