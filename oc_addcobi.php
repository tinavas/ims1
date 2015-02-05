<?php 
include "jquery.php"; 
include "config.php"; 
include "getemployee.php";

if(!isset($_GET['warehouse']))
$warehouse = "";
else
$warehouse = $_GET['warehouse'];

if(!isset($_GET['party']))
$party = "";
else
$party = $_GET['party']; 

if(!isset($_GET['partycode']))
$partycode = "";
else
$partycode = $_GET['partycode'];

if(!isset($_GET['ps']))
$ps = "";
else
{
$ps = $_GET['ps'];
}
$dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];

$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(cobiincr) as cobiincr FROM oc_cobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $cobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$cobiincr = $row1['cobiincr']; 
$cobiincr = $cobiincr + 1;
if ($cobiincr < 10) 
$cobi = "COBI-".$m.$y.'-000'.$cobiincr.$code; 
else if($cobiincr < 100 && $cobiincr >= 10) 
$cobi = "COBI-".$m.$y.'-00'.$cobiincr.$code; 
else if($cobiincr < 1000 && $cobiincr >= 100) 
$cobi = "COBI-".$m.$y.'-0'.$cobiincr.$code; 
else $cobi = "COBI-".$m.$y.'-'.$cobiincr.$code;
?>

<br />

<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="form1" name="form1" method="post" action="oc_savecobic.php" onsubmit="return checkform(this);">
	  <h1 id="title1">Customer Order Based Invoice</h1>
		
  
<br />
<b>Customer Order Based Invoice</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />




<input type="hidden" name="cobiincr" id="cobiincr" value="<?php echo $cobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
<table>
<tr>
<td width="76" align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
			   <td width="162">
			    <select id="warehouse" name="warehouse" style="width:120px;" onchange="loadparty(this.value);">
				<option value="">-Select-</option>
				<?php
				    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")   
				
				$query = "SELECT distinct(warehouse) FROM oc_packslip WHERE flag = 1 AND cobiflag = 0 ORDER By warehouse";
				
				else
				
				$query = "SELECT distinct(warehouse) FROM oc_packslip WHERE flag = 1 AND cobiflag = 0 and warehouse in ($sectorlist) ORDER By warehouse";
				$result = mysql_query($query,$conn) or die(mysql_error());
				while($rows = mysql_fetch_assoc($result))
				{
				 ?>
				 <option value="<?php echo $rows['warehouse']; ?>" title="<?php echo $rows['warehouse']; ?>" <?php if($warehouse == $rows['warehouse']) { ?> selected="selected" <?php } ?>><?php echo $rows['warehouse']; ?></option>
				 <?php
				}
				?>
				</select>		</td>
<td width="10"></td>

<td ><strong>Party</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td ><select id="party" name="party" style="width:170px"  onchange="fun1()">
             <option value="">-Select-</option>
           <?php  $q = "select distinct(party) from oc_packslip WHERE flag = 1 AND cobiflag = 0 and warehouse='$warehouse' order by party";
		   
		    $qrs = mysql_query($q,$conn) or die(mysql_error());
			
  		         while($qr = mysql_fetch_assoc($qrs)) { ?>
				 
        <option value="<?php echo $qr['party']; ?>" title="<?php echo $qr['party'];?>" <?php if($party == $qr['party']) { ?> selected="selected" <?php } ?>><?php echo $qr['party']; ?></option>
		
       <?php } ?>
     </select></td>

<td width="10"></td>

<td ><strong>Pack Slip #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td ><select id="ps" name="ps" style="width:150px" onchange="fun(this.value);">
             <option value="">-Select-</option>
           <?php  $q = "select distinct(ps) from oc_packslip WHERE party = '$party' and flag = '1' AND cobiflag <> '1' and warehouse='$warehouse' order by ps"; 
		   
		   $qrs = mysql_query($q,$conn) or die(mysql_error());
		   
  		         while($qr = mysql_fetch_assoc($qrs)) { ?>
				 
        <option value="<?php echo $qr['ps']; ?>" <?php if($ps == $qr['ps']) { ?> selected="selected" <?php } ?>><?php echo $qr['ps']; ?></option>
		
       <?php } ?>
     </select></td>
	 </tr>
	

	</table>
	 <br />
<br />
	<table>
<td><strong>Invoice#</strong>&nbsp;&nbsp;&nbsp;</td>
<td><?php if($ps != "") { ?><input type="text" style="background:none; border:none;" size="24"  id="invoice" name="invoice" value="<?php echo $cobi; ?>" title="<?php echo $cobi; ?>" readonly /><?php } ?></td>

<td width="10"></td>
<td align="right"><strong>Date&nbsp;&nbsp;&nbsp;</strong></td>
<td><input type="text" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y"); ?>" size="10" onchange="getsobi();"/></td>
<td >&nbsp;</td>
<td><strong>Book Invoice#</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="8"  id="invoice1" name="invoice1" value="" />
<span id="usercheck"></span>
<span style="display:none" id="loading"align="left"><img  title="Verifying the Customer Name" src="images\mask-loader.gif" ></span></td>
<td width="10"></td>

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
<th><strong>Units</strong></th>

<th width="10px"></th>
<th><strong>Quantity </strong></th>
        


<th width="10px"></th>
<th><strong>Price</strong></th>
<th width="10px"></th>


<th><strong>Tax Type</strong></th>

<th width="10px"></th>

<th><strong>Tax Amount</strong></th>

<th width="10px"></th>

<th><strong>Freight<br/>Type</strong></th>

<th width="10px"></th>

<th><strong>Freight Amount</strong></th>

<th width="10px"></th>

<th><strong>Discount</strong></th>

<th width="10px"></th>

<th><strong>Total</strong></th>
</tr>



<tr style="height:20px"></tr>
<?php $i = 1; $sum = 0; $query1 = "select * from oc_packslip where ps = '$ps' and cobiflag <> '1' order by itemcode"; $result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($row1 = mysql_fetch_assoc($result1)) { 
      $freight = $row1['freightamount'];
	   $pocost = $row1['pocost']; ?>
  
<input type="hidden" id="taxcode<?php echo $i; ?>" name="taxcode[]" value="<?php echo $row1['taxcode']; ?>" />
<input type="hidden" id="taxvalue<?php echo $i; ?>" name="taxvalue[]" value="<?php echo $row1['taxvalue']; ?>" />
<input type="hidden" id="taxformula<?php echo $i; ?>" name="taxformula[]" value="<?php echo $row1['taxformula']; ?>" />
<input type="hidden" id="taxie<?php echo $i; ?>" name="taxie[]" value="<?php echo $row1['taxie']; ?>" />

<input type="hidden" id="freightcode<?php echo $i; ?>" name="freightcode[]" value="<?php echo $row1['freightcode']; ?>" />
<input type="hidden" id="freightvalue<?php echo $i; ?>" name="freightvalue[]" value="<?php echo $row1['freightvalue']; ?>" />
<input type="hidden" id="freightformula<?php echo $i; ?>" name="freightformula[]" value="<?php echo $row1['freightformula']; ?>" />
<input type="hidden" id="freightie<?php echo $i; ?>" name="freightie[]" value="<?php echo $row1['freightie']; ?>" />
<input type="hidden" id="cashcodee<?php echo $i; ?>" name="cashcode[]" value="<?php echo $row1['cashcode']; ?>" />

<input type="hidden" id="discountcode<?php echo $i; ?>" name="discountcode[]" value="<?php echo $row1['discountcode']; ?>" />
<input type="hidden" id="discountvalue<?php echo $i; ?>" name="discountvalue[]" value="<?php echo $row1['discountvalue']; ?>" />
<input type="hidden" id="discountformula<?php echo $i; ?>" name="discountformula[]" value="<?php echo $row1['discountformula']; ?>" />

<tr>
<td><input type="text" id="sno<?php echo $i; ?>" size="4" name="sno[]" value="<?php echo " ".$i; ?>" style="text-align:right;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="itemcode<?php echo $i; ?>" size="6" name="itemcode[]" value="<?php echo $row1['itemcode']; ?>" style="text-align:center;background:none; border:none" readonly/></td>
<td width="10px"></td>
<td><input type="text" id="description<?php echo $i; ?>" size="15" name="description[]" value="<?php echo $row1['description']; ?>" style="text-align:center;background:none; border:none" readonly/></td>

<td width="10px"></td>

<td><input type="text" id="units<?php echo $i; ?>" size="10" name="units[]" value="<?php echo $row1['units']; ?>" style="text-align:center;background:none; border:none" readonly /></td>
<td width="10px"></td>

<td>
<input type="text" id="sentquantity<?php echo $i; ?>" size="10" name="sentquantity[]" value="<?php echo $row1['quantity']; ?>" style="text-align:center;background:none;border:none" readonly /></td>


<td width="10px"></td>



<td>
<input type="text" id="price<?php echo $i; ?>" size="8" name="price[]" value="<?php echo $row1['rateperunit']; ?>" style="text-align:right;background:none;border:none" readonly />
</td>
<td width="10px"></td>



<td><input type="text" id="taxtype<?php echo $i;?>" title="<?php echo $row1['taxie'];?>" style="background:none;border:none;text-align:center" name="taxtype[]" size="6" <?php if($row1['taxie']!="") {?>value="<?php echo $row1['taxie'];?>" <?php } else {?> None value="" <?php   }?> readonly="true" /></td>
<td width="10px"></td>


<td align="center">
<input type="text" size="6" name="taxamount[]" id="taxamount<?php echo $i; ?>" value="<?php echo $row1['taxamount']; ?>" style="text-align:right;background:none;border:none" readonly /></td>

<td width="10px"></td>

<td><input type="text" id="fritype<?php echo $i;?>" title="<?php echo $row1['freightie'];?>" style="background:none;border:none;text-align:center" name="fritype[]" size="15" <?php if($row1['freightie']!="") {?>value="<?php echo $row1['freightie'];?>" <?php } else {?> None value="" <?php   }?> readonly="true" /></td>
<td width="10px"></td>


<td align="center">
<input type="text" size="6" name="freightamount[]" id="freightamount<?php echo $i; ?>" value="<?php echo $row1['freightamount']; ?>" style="text-align:right;background:none;border:none" readonly /></td>
<td width="10px"></td>

<td align="center">
<input type="text" name="discountamount[]" size="6" id="discountamount<?php echo $i; ?>" value="<?php echo $row1['discountamount']; ?>" style="text-align:right;background:none;border:none" readonly /></td>
<td width="10px"></td>
<td>
<input type="text" id="total<?php echo $i; ?>" size="15" name="total[]" value="<?php echo $row1['totalcost']; ?>" style="text-align:right;background:none; border:none" readonly /></td>
</tr>
<tr style="height:10px"></tr>


<?php $i++; } ?>
<input type="hidden" name="i" id="i" value="<?php echo $i; ?>" />
<tr style="height:10px"></tr>


<tr style="height:20px"></tr>
<tr align="center">
<td colspan="22" align="right">
<strong>Grand Total</strong></td>
<td>
<input style="text-align:right;background:none; border:none" type="text" id="finaltotal" size="15" name="finaltotal" value="<?php echo $pocost; ?>" readonly />
<input type="hidden" id="finaltotal1" size="15" name="finaltotal1" value="<?php echo $pocost; ?>"/></td>
</tr>
<tr>

<td style="vertical-align:middle;" valign="middle" colspan="20" align="center"><strong>Narration&nbsp;&nbsp;&nbsp;</strong>

<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>

<font style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</font></tr>
<tr style="height:20px"></tr>
<tr>
<td colspan="18" align="center">
<input type="submit" id="save" value="Save" /> <input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_cobi'"/></td>
</tr>
<?php } ?>
</table>
</form>
</div>
</section>
</center>
<script language="JavaScript" type="text/javascript">
var totalrows = <?php echo $i-1; ?>;
function checkform()
{


if(document.getElementById("invoice1").value=="")
{


		alert("please enter bookinvoice");
		return false;
		

}

if(document.getElementById("warehouse").value=="")
{


		alert("please select warehouse");
		return false;
		

}

if(document.getElementById("party").value=="")
{


		alert("please select Party");
		return false;
		

}
if(document.getElementById("ps").value=="")
{


		alert("please select pack slip");
		return false;
		

}


 document.getElementById('save').disabled=true;
}



 $(document).ready(function()
{  	
	$("#invoice1").blur(function()
	{  
	   
	   if($("#invoice1").val()) {
	   document.getElementById("usercheck").innerHTML='';
	   document.getElementById("usercheck").style.display='none';
	   document.getElementById("loading").style.display='';
		$.post("check_bookinvoice.php",{ bi:$("#invoice1").val(),table:"oc_cobi",col:"bookinvoice"  },function(data)
        {
		document.getElementById("loading").style.display='none';
		if(data>0)
		 {		  
		  document.getElementById("invoice1").value='';
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("usercheck").innerHTML='*Book Invoice Exists';
		  document.getElementById("usercheck").style.color='#FF0000';
		  document.getElementById("save").disabled='disabled';
		  alert('Book Invoice Number already exists');
		 }
		 else
		 {
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("save").disabled='';
		 }
		});
		
	} // end of if
});
});

function getsobi()
{
  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var cobiincr = new Array();
    var cobi = "";
	var code = "<?php echo $code; ?>";
  <?php 
$dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];
$prefix = "COBI-$dbcode-$empcode";   
   $query1 = "SELECT MAX(cobiincr) as cobiincr,m,y FROM oc_cobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1) or die(mysql_error());
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     cobiincr[<?php echo $k; ?>] = <?php if($row1['cobiincr'] < 0) { echo 0; } else { echo $row1['cobiincr']; } ?>;

<?php $k++; } ?>
for(var l = 0; l <= <?php echo $k; ?>;l++)
{

 if((yea[l] == y) && (mon[l] == m))
  { 
   if(cobiincr[l] < 10)
     cobi = '<?php echo $prefix; ?>'+'-'+'<?php echo strtoupper($_SESSION['valid_user'])?>'+'-'+m+y+'-000'+parseInt(cobiincr[l]+1);
   else if(cobiincr[l] < 100 && cobiincr[l] >= 10)
     cobi = '<?php echo $prefix; ?>'+'-'+'<?php echo strtoupper($_SESSION['valid_user'])?>'+'-'+m+y+'-00'+parseInt(cobiincr[l]+1);
   else
     cobi = '<?php echo $prefix; ?>'+'-'+'<?php echo strtoupper($_SESSION['valid_user'])?>'+'-'+m+y+'-0'+parseInt(cobiincr[l]+1);
     document.getElementById('cobiincr').value = parseInt(cobiincr[l] + 1);
  break;
  }
 else
  {
   cobi = '<?php echo $prefix; ?>' +'-'+'<?php echo strtoupper($_SESSION['valid_user'])?>'+'-' + m + y + '-000' + parseInt(1);
   document.getElementById('cobiincr').value = 1;
  }
}
document.getElementById('invoice').value = cobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;
}

function loadparty(a)
{
 document.location = "dashboardsub.php?page=oc_addcobi&warehouse=" + a;
}

function fun1()
{
	var warehouse = document.getElementById('warehouse').value;
	var party = document.getElementById('party').value;
	
	document.location = "dashboardsub.php?page=oc_addcobi&party=" + party + "&warehouse=" + warehouse;
	
}
function fun(ps)
{
    var party = document.getElementById("party").value;
	var warehouse = document.getElementById('warehouse').value;

	document.location = "dashboardsub.php?page=oc_addcobi&party=" + party +  "&ps=" + ps + "&warehouse=" + warehouse;
	
	
}



</script>
