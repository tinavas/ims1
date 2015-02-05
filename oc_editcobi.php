<?php 
include "jquery.php"; 
include "config.php"; 
include "getemployee.php";

if(!isset($_GET['party']))
$party = "";
else
$party = $_GET['party'];

if(!isset($_GET['ps']))
$ps = "";
else
{
$ps = $_GET['ps'];
}

if(!isset($_GET['date']))
$date = "";
else
{
$date = $_GET['date'];
}

?>

<br />
<center>


<h1>Customer Order Based Invoice</h1>
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="oc_savecobi.php" onsubmit = "return checkform(this)"; >
<input type="hidden" name="cobiincr" id="cobiincr" value="<?php echo $cobiincr; ?>"/>
<input type="hidden" name="saed" id="saed" value="edit"/>
		
<table>
<tr>
<td align="right"><strong>Warehouse</strong></td>
			   <td>
			    <select id="warehouse" name="warehouse" style="width:120px;" onchange="loadparty(this.value);">
				 <option value="<?php echo $_GET['warehouse']; ?>" title="<?php echo $rows['warehouse']; ?>"><?php echo $_GET['warehouse']; ?></option>
				</select>
				</td>
<td width="5px"></td>

<td><strong>Party</strong>&nbsp;&nbsp;&nbsp;</td>
<td><select id="party" name="party" style="width:180px" onchange="fun1(this.value);">
        <option value="<?php echo $_GET['party']; ?>"  selected="selected" ><?php echo $_GET['party']; ?></option>  
     </select></td>
<td width="5px"></td>
<td title="Pack Slip No."><strong>PS #</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select id="ps" name="ps" style="width:120px" onchange="fun(this.value);">
        <option value="<?php echo $_GET['ps']; ?>"  selected="selected" ><?php echo $_GET['ps']; ?></option>
     </select></td>
<td width="5px"></td>
</tr>
<tr height="10px"></tr>

<tr>
<td><strong>Invoice #</strong></td>
<?php if($ps != "") { ?>
<td><input type="text" style="background:none; border:none;" size="18"  id="invoice" name="invoice" value="<?php echo $_GET[invoice]; ?>" readonly/></td>
<?php } ?>
<td width="5px"></td>
<td align="right"><strong>Date&nbsp;&nbsp;&nbsp;</strong></td>
<td align="left"><input type="text" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y",strtotime($_GET['date'])); ?>" size="10"/></td>
<td width="5px"></td>
<td title = "Book Invoice No."><strong>Book #</strong></td>
<td align="left"><input type="text" size="5"  id="invoice1" name="invoice1" value="<?php echo $_GET[bookinvoice]; ?>" /></td>
<td width="5px"></td>
<?php if($_SESSION['db'] == "albustanlayer") { ?>
<td><strong>Sales Person</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select id="salesperson" name="salesperson" style="width:150px">
<?php
$query1 = "select salesperson from oc_packslip where ps = '$ps' and party = '$party'";
				  $result1 = mysql_query($query1,$conn) or die(mysql_error());
				  $rows1 = mysql_fetch_assoc($result1);
				  $salesperson = $rows1['salesperson'];
				  ?><option value="<?php echo $rows1['salesperson'];?>"><?php echo $rows1['salesperson'];?></option>
				
</select>				
</td>
<?php } ?>

</tr>
</table>
<br />
<br />
<?php if($ps != "") { ?>
<table align="center">
<tr>
<th><strong>S.No</strong></th>
<th width="10px"></th>
<th><strong>Item</strong></th>
<th width="10px"></th>
<th><strong>Description</strong></th>
<th width="10px"></th>
<th><strong>Sent Quantity</strong></th>
<th width="10px"></th>
<th><strong>Units</strong></th>
<th width="10px"></th>
<th><strong>Price/Unit</strong></th>
<th width="10px"></th>
<th><strong>Tax Amount</strong></th>
<th width="10px"></th>
<th><strong>Freight Amount</strong></th>
<th width="10px"></th>
<th><strong>Discount Amount</strong></th>
<th width="10px"></th>
<th><strong>Total Amount</strong></th>
<th width="10px"></th>
<th><strong>CoA Code</strong></th>
<th width="10px"></th>
</tr>
<tr style="height:20px"></tr>
<?php $count=1; $i = 1; $sum = 0; $query1 = "select * from oc_cobi where ps = '$ps' order by code"; $result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($row1 = mysql_fetch_assoc($result1)) { 
	
	$remarks=$row1['remarks'];
	
	$flag = $row1['flag'];
	 if($count==1) { ?>
<input type="hidden" name="m" id="m" value="<?php echo $row1[m]; ?>"/>
<input type="hidden" name="y" id="y" value="<?php echo $row1[y]; ?>"/>
<input type="hidden" name="cobiincr" id="cobiincr" value="<?php echo $row1[cobiincr]; ?>"/>
<?php } 
	if($row1[so]!='withoutso') {
      $freight = $row1['freightamount']; $brokerage = $row1['brokerageamount']; $pocost = $row1['pocost']; ?>
	  
<input type="hidden" id="taxcode" name="taxcode[]" value="<?php echo $row1['taxcode']; ?>" />
<input type="hidden" id="taxvalue" name="taxvalue[]" value="<?php echo $row1['taxvalue']; ?>" />
<input type="hidden" id="taxformula" name="taxformula[]" value="<?php echo $row1['taxformula']; ?>" />


<input type="hidden" id="freightcode" name="freightcode[]" value="<?php echo $row1['freightcode']; ?>" />
<input type="hidden" id="freightvalue" name="freightvalue[]" value="<?php echo $row1['freightvalue']; ?>" />
<input type="hidden" id="freightformula" name="freightformula[]" value="<?php echo $row1['freightformula']; ?>" />

<input type="hidden" id="brokeragecode" name="brokeragecode[]" value="<?php echo $row1['brokeragecode']; ?>" />
<input type="hidden" id="brokeragevalue" name="brokeragevalue[]" value="<?php echo $row1['brokeragevalue']; ?>" />
<input type="hidden" id="brokerageamount" name="brokerageamount[]" value="<?php echo $row1['brokerageamount']; ?>" />
<input type="hidden" id="brokerageformula" name="brokerageformula[]" value="<?php echo $row1['brokerageformula']; ?>" />

<input type="hidden" id="discountcode" name="discountcode[]" value="<?php echo $row1['discountcode']; ?>" />
<input type="hidden" id="discountvalue" name="discountvalue[]" value="<?php echo $row1['discountvalue']; ?>" />
<input type="hidden" id="discountformula" name="discountformula[]" value="<?php echo $row1['discountformula']; ?>" />

<tr>
<td><input type="text" id="sno<?php echo $i; ?>" size="4" name="sno[]" value="<?php echo " ".$i; ?>" style="text-align:right;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="itemcode<?php echo $i; ?>" size="6" name="itemcode[]" value="<?php echo $row1['code']; ?>" style="text-align:center;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="description<?php echo $i; ?>" size="15" name="description[]" value="<?php echo $row1['description']; ?>" style="text-align:center;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="sentquantity1<?php echo $i; ?>" size="10" name="sentquantity1[]" value="<?php echo changeprice1($row1['quantity']); ?>" style="text-align:right;background:none;border:none" readonly /></td>

<input type="hidden" id="sentquantity<?php echo $i; ?>" size="10" name="sentquantity[]" value="<?php echo $row1['quantity']; ?>" />

<td width="10px"></td>
<td><input type="text" id="units<?php echo $i; ?>" size="10" name="units[]" value="<?php echo $row1['units']; ?>" style="text-align:center;background:none; border:none" readonly /></td>
<td width="10px"></td>
<td>
<input type="text" id="price1<?php echo $i; ?>" size="8" name="price1[]" value="<?php echo changeprice($row1['price']); ?>" style="text-align:right;background:none;border:none" readonly />

<input type="hidden" id="price<?php echo $i; ?>" size="8" name="price[]" value="<?php echo $row1['price']; ?>" />
</td>
<td width="10px"></td>
<td align="center">
<input type="text" size="6" name="taxamount1[]" id="taxamount1<?php echo $i; ?>" value="<?php echo changeprice($row1['taxamount']); ?>" style="text-align:right;background:none;border:none" readonly /></td>
<input type="hidden" size="6" name="taxamount[]" id="taxamount<?php echo $i; ?>" value="<?php echo $row1['taxamount']; ?>" />
<td width="10px"></td>
<td align="center">
<input type="text" size="6" name="freightamount1[]" id="freightamount1<?php echo $i; ?>" value="<?php echo changeprice($row1['freightamount']); ?>" style="text-align:right;background:none;border:none" readonly /></td>
<input type="hidden" size="6" name="freightamount[]" id="freightamount<?php echo $i; ?>" value="<?php echo $row1['freightamount']; ?>" />
<td width="10px"></td>
<td align="center">
<input type="text" name="discountvalue1[]" size="6" id="discountvalue1<?php echo $i; ?>" value="<?php echo changeprice($row1['discountamount']); ?>" style="text-align:right;background:none;border:none" readonly />
<input type="hidden" name="discountamount[]" size="6" id="discountamount<?php echo $i; ?>" value="<?php echo $row1['discountamount']; ?>" />
</td>
<td width="10px"></td>
<td>
<input type="text" id="total1<?php echo $i; ?>" size="15" name="total1[]" value="<?php echo changeprice($row1['total']); ?>" style="text-align:right;background:none; border:none" readonly/>
<input type="hidden" id="total<?php echo $i; ?>" size="15" name="total[]" value="<?php echo $row1['total']; $finaltotal+=$row1['total']; ?>" />
</td>
<td width="10px"></td>
<td><select id="coacode<?php echo $i; ?>" name="coacode[]" style="width:70px">
             <option value="T">-Select-</option>
           <?php  $query5 = "select * from ac_coa WHERE controltype = 'Customer A/c' order by code"; 
		   		  $result5 = mysql_query($query5,$conn) or die(mysql_error());
				  $i = 0;
  		         while($row5 = mysql_fetch_assoc($result5)) { $i++; ?>
        <option title="<?php echo $row5['description']; ?>" value="<?php echo $row5['code']; ?>" <?php if($i == 1) { echo "selected='selected'"; } ?>><?php echo $row5['code']; ?></option>
       <?php } ?>
     </select></td>
</tr>
<tr style="height:10px"></tr>


<?php }
else
{
?>
<tr>
<td><input type="text" id="sno<?php echo $i; ?>" size="4" name="sno[]" value="<?php echo " ".$i; ?>" style="text-align:right;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="itemcode<?php echo $i; ?>" size="6" name="itemcode[]" value="<?php echo $row1['code']; ?>" style="text-align:center;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="description<?php echo $i; ?>" size="15" name="description[]" value="<?php echo $row1['description']; ?>" style="text-align:center;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="sentquantity1<?php echo $i; ?>" size="10" name="sentquantity1[]" value="<?php echo changeprice1($row1['quantity']); ?>" style="text-align:right;background:none;border:none" readonly /></td>

<input type="hidden" id="sentquantity@<?php echo $i; ?>" size="10" name="sentquantity[]" value="<?php echo $row1['quantity']; ?>" />

<td width="10px"></td>
<td><input type="text" id="units<?php echo $i; ?>" size="10" name="units[]" value="<?php echo $row1['units']; ?>" style="text-align:center;background:none; border:none" readonly /></td>
<td width="10px"></td>
<td align="right">
<input style="text-align:right;"  onkeyup="calculate(this.id)" id="price@<?php echo $i; ?>" size="8" name="price[]" value="<?php echo $row1['price']; ?>" />
</td>
<td width="10px"></td>
<td align="right">
<input style="text-align:right;" onkeyup="calculate(this.id)"  size="6" name="taxamount[]" id="taxamount@<?php echo $i; ?>" value="<?php echo $row1['taxamount']; ?>" /> </td>
<td width="10px"></td>
<td align="right">
<input style="text-align:right;"  onkeyup="calculate(this.id)"  size="6" name="freightamount[]" id="freightamount@<?php echo $i; ?>" value="<?php echo $row1['freightamount']; ?>" /></td>
<td width="10px"></td>
<td align="right">
<input style="text-align:right;"  onkeyup="calculate(this.id)"  name="discountamount[]" size="6" id="discountamount@<?php echo $i; ?>" value="<?php echo $row1['discountamount']; ?>" />
</td>
<td width="10px"></td>
<td align="right">
<input style="text-align:right;"  id="total@<?php echo $i; ?>" size="15" name="total[]" value="<?php echo $row1['total']; $finaltotal+=$row1['total']; ?>" />
</td>
<td width="10px"></td>
<td><select id="coacode<?php echo $i; ?>" name="coacode[]" style="width:70px">
             <option value="T">-Select-</option>
           <?php  $query5 = "select * from ac_coa WHERE controltype = 'Customer A/c' order by code"; 
		   		  $result5 = mysql_query($query5,$conn) or die(mysql_error());
				  $i = 0;
  		         while($row5 = mysql_fetch_assoc($result5)) { $i++; ?>
        <option title="<?php echo $row5['description']; ?>" value="<?php echo $row5['code']; ?>" <?php if($i == 1) { echo "selected='selected'"; } ?>><?php echo $row5['code']; ?></option>
       <?php } ?>
     </select></td>
</tr>
<tr style="height:10px"></tr>
<?php
} 
  $count++;
  $i++;} ?>
<input type="hidden" name="i" id="i" value="<?php echo $i; ?>" />
<tr style="height:10px"></tr>

<tr style="height:20px"></tr>
<tr align="center">
<td colspan="18" align="right">
<strong>Grand Total</strong>
</td>
<td>
<input style="text-align:right;background:none; border:none" type="text" id="finaltotal" size="15" name="finaltotal" value="<?php echo changeprice($finaltotal); ?>" readonly/>
<input type="hidden" id="finaltotal1" size="15" name="finaltotal1" value="<?php echo $finaltotal; ?>"/>
</td>
</tr>
<tr><td align="center" colspan="18" ><strong>Narration</strong> <textarea cols="40" name="remarks"><?php echo $remarks; ?></textarea></td><tr>
<tr>
<td colspan="18" align="center">
<input type="submit" id="save" value="Update" /> <input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_cobi'"/>
</td>
</tr>
<?php } ?>
</table>
</form>
</center>
<script language="JavaScript" type="text/javascript">

function calculate(id)
{
id=id.split('@');
index=id[1];
var total=0;
var alltotal=0;
total+=parseFloat(document.getElementById('sentquantity@'+index).value*document.getElementById('price@'+index).value);
total+=parseFloat(document.getElementById('freightamount@'+index).value);
total+=parseFloat(document.getElementById('taxamount@'+index).value);
total-=parseFloat(document.getElementById('discountamount@'+index).value);
document.getElementById('total@'+index).value=parseFloat(total);

for(var i=<?php echo $count-1; ?>;i>0;i--) 
  alltotal+=parseFloat(document.getElementById('total@'+i).value); 
 

document.getElementById('finaltotal').value=parseFloat(alltotal);
document.getElementById('finaltotal1').value=parseFloat(alltotal);
}

function fun1(party)
{

	
}
function fun(ps)
{
    
}

function checkform()
{
 <?php if(($_SESSION['db'] == "central" or $_SESSION['db'] == "alwadi") && $flag == 0) { ?>
 document.form1.action = "oc_savecobic.php";
 <?php } ?>
}
</script>
