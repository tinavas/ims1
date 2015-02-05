<?php include "getemployee.php"; session_start(); include "jquery.php"; ?>
<?php
$po = $_GET['po'];
$query = "SELECT * FROM pp_purchaseorder WHERE po = '$po' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$pdate = $rows['date'];
$vendor = $rows['vendor'];
$broker = $rows['broker'];
?>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="height:600px" id="complex_form" method="post" action="pp_saveclosurepurchaseorder.php" >
	  <h1 id="title1">Purchase Order</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

<table id="tab1" align="center">
<tr>
 <td><strong>Purchase Order&nbsp;</strong></td>
 <td><input type="text" id="po" name="po" value="<?php echo $po; ?>" style="background:none;border:none;" readonly size="15" /></td>
 <td width="15px"></td>
 <td title="Closure Date"><strong>Closure Date&nbsp;<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;</td>
 <td><input type="text" id="cldate" name="cldate" class="datepicker" value="<?php echo date("d.m.Y"); ?>" size="15" /></td>
 <!--<td width="15px"></td>-->
 <td><strong>Purchase Date&nbsp;</strong></td>
 <td><?php echo date("d.m.Y",strtotime($pdate)); ?></td>
 <td width="15px"></td>
 <td><strong>Vendor&nbsp;</strong></td>
 <td><?php echo $vendor; ?></td>
 <td width="15px"></td>
 <?php if($broker <> "") { ?>
 <td><strong>Broker&nbsp;</strong></td>
 <td><?php echo $broker; ?></td>
 <?php } ?>
</tr>
</table>
<br><br>
<table id="tab2" align="center">
<tr>
 <td><strong>Item</strong></td>
 <td width="15px"></td>
 <td><strong>Description</strong></td>
 <td width="15px"></td>
 <td><strong>Order Quantity</strong></td>
 <td width="15px"></td>
 <td><strong>Received Quantity</strong></td>
 <td width="15px"></td>
 <td><strong>Delivery Location</strong></td>
</tr>
<tr height="10px"></tr>
<?php
$query = "SELECT * FROM pp_purchaseorder WHERE po = '$po' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
?>
<tr>
 <td align="left"><?php echo $rows['code']; ?></td>
 <td width="15px"></td>
 <td align="left"><?php echo $rows['description']; ?></td>
 <td width="15px"></td>
 <td><?php echo $rows['quantity']; ?></td>
 <td width="15px"></td>
 <td>
 <?php
 $query2 = "SELECT receivedquantity FROM pp_sobi WHERE po = '$po' AND code = '$rows[code]' AND client = '$client'";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 echo $rows2['receivedquantity'];
 ?>
 </td>
 <td width="15px"></td>
 <td align="left"><?php echo $rows['deliverylocation']; ?></td> 
</tr>
<tr height="10px"></tr>
<?php
}
?>
</table>
<br><br>
<table>
<td style="vertical-align:middle;"><strong>Narration<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>
<td>
<textarea id="narration" cols="40"  rows="3" name="narration"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br /><br />
<input type="submit" value="Save" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';" />
</form>

	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->


</body>
</html>
