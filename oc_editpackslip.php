
<?php  
include "config.php";
include "jquery.php"; 
include "getemployee.php"; 

$ps = $_GET['ps'];
$query = "SELECT date,party,partycode,so,transporter,transport,tme,vehicleno,driver,freight,flag,m,psincr,y,warehouse FROM oc_packslip WHERE ps = '$ps'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$date = $rows['date'];
$party = $rows['party'];
$partycode = $rows['partycode'];
$so = $rows['so'];

$flag = $rows['flag'];
$warehouse = $rows['warehouse'];
$m=$rows['m'];
$y=$rows['y'];
$psincr=$rows['psincr'];
$empname=$rows['empname'];

$co1=$rows['co1'];

	   		$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSE' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}

$coacode1=json_encode($coacode);



?>
<br />

<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="packslipinsert" name="packslipinsert" method="post" action="oc_savepackslipc.php" onsubmit="return amtcalculate(this);">
	  <h1 id="title1">Pack Slip</h1>
		
  
<br />
<b>Pack Slip</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
<br/>
<br/>



<input type="hidden" id="saed" name="saed" value="1" />
<input type="hidden" id="m" name="m" value="<?php echo $m; ?>" />
<input type="hidden" id="y" name="y" value="<?php echo $y; ?>" />
<input type="hidden" id="psincr" name="psincr" value="<?php echo $psincr; ?>" />
<input type="hidden" id="ps" name="ps" value="<?php echo $ps; ?>" />
<input type="hidden" id="cuser" name="cuser" value="<?php echo $empname;?>" />

<br />
<br />
<!-- table for date,party,and sales order-->
<table align="center" >
<tr>
<td align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
			   <td>
			    <select id="warehouse" name="warehouse" style="width:120px;" onchange="loadparty(this.value);">
				<option value="" disabled="disabled">-Select-</option>
				<option value="<?php echo $warehouse; ?>"><?php echo $warehouse; ?></option>
				</select>
				</td>

<td align="right"><strong>Party&nbsp;&nbsp;&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td><select name="party" id="party" onchange="fun()" style="width:200px">
             <option disabled="disabled">-Select-</option>
             <option value="<?php echo $party; ?>" ><?php echo $party; ?></option>
</select>&nbsp;&nbsp;&nbsp;</td>



<td align="right"><strong>Sales Order #&nbsp;&nbsp;&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td>
<select name="so" id="so" onchange="fun1();" style="width:160px"  >
<option disabled="disabled">-Select-</option>
<option value="<?php echo $so; ?>"><?php echo $so; ?></option>
</select>&nbsp;&nbsp;&nbsp;
</td>
<td align="right"><strong>Date&nbsp;&nbsp;&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td><input type="text" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y",strtotime($date)); ?>" size="10"/>&nbsp;&nbsp;&nbsp;</td>



</tr>
</table>
<!-- end of the table for date,party,and sales order-->
<br/>
<br/>
<table align="center" border="0">
 
 
 
 	   <tr height="30px">
 	    <th align="center"><strong>S.No</strong></td>
		<th width="10px"></th>
	    <th  align="center"><strong>Items</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
		<th width="10px"></th>
		<th  align="center"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
		<th width="10px"></th>
		<th align="center"><strong>Units</strong></td>
		<th width="10px"></th>
		
		<th id="rplace" width="30px" align="center" title="Balance Quantity from Sales Order"><strong>Bal. <br/>Qty</strong></td>
		
	
		<th width="10px"></th>
		<th  align="center" title="Quanity in Units"><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
		<th width="10px"></th>
		
		<th  align="center" title="Price"><strong>Price</strong></th>
		<th width="10px"></th>
		<th align="center"><strong>Freight Type</strong></th>

			<th width="10px"></th>

			<th align="center"><strong>Freight Amount</strong></th>

			<th width="10px"></th>

			<th align="center"><strong>Freight Code</strong></th>

			<th width="10px"></th>


			<th align="center"><strong>Cash&nbsp;Code</strong></th>
			<th width="10px"></th>

</tr>
		
 
 
 
	   <tr style="height:10px"></tr>
 <?php   $query1 = "select * from oc_packslip where ps = '$ps' and party = '$party' order by id"; 
 		$result1 = mysql_query($query1,$conn) or die(mysql_error());
		$i = 1;	
		while($row1 = mysql_fetch_assoc($result1))	{
 ?> 
<?php		
 $q = "select * from oc_salesorder where po = '$so' AND code = '$row1[itemcode]' AND client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
$rr = mysql_fetch_assoc($r);
$bal = $rr['quantity'] - $rr['sentquantity'];

?>

	<!-- Get details from salesorder -->	
<input type="hidden" id="taxcode<?php echo $i;?>" name="taxcode[]" value="<?php echo $rr['taxcode']; ?>" />
<input type="hidden" id="taxie<?php echo $i;?>" name="taxie[]" value="<?php echo $rr['taxie']; ?>" />
<input type="hidden" id="freightcode<?php echo $i;?>" name="freightcode[]" value="<?php echo $rr['freightcode']; ?>" />
<input type="hidden" id="freightie<?php echo $i;?>" name="freightie[]" value="<?php echo $row1['freightie']; ?>" />



<input type="hidden" id="taxvalue<?php echo $i;?>" name="taxvalue[]" value="<?php echo $rr['taxvalue']; ?>" />
<input type="hidden" id="freightvalue<?php echo $i;?>" name="freightvalue[]" value="<?php echo $rr['freightvalue']; ?>" />

<input type="hidden" id="discountvalue<?php echo $i;?>" name="discountvalue[]" value="<?php echo $rr['discountvalue']; ?>" />

<input type="hidden" id="taxformula<?php echo $i;?>" name="taxformula[]" value="<?php echo $rr['taxformula']; ?>" />

<input type="hidden" id="rateperunit<?php echo $i;?>" name="rateperunit[]" value="<?php echo $rr['rateperunit']; ?>" />
<!-- End of Getting details from salesorder -->
		
<input type="hidden" id="taxamount<?php echo $i;?>" name="taxamount[]" value="<?php echo $row1['taxamount']; ?>" />
<input type="hidden" id="freightamount<?php echo $i;?>" name="freightamount[]" value="<?php echo $row1['freightamount']; ?>" />

<input type="hidden" id="discountamount<?php echo $i;?>" name="discountamount[]" value="<?php echo $row1['discountamount']; ?>" />
<input type="hidden" id="discountper<?php echo $i;?>" name="discountper[]" value="<?php echo $rr['discountper']; ?>" />

		<tr style="height:30px">
		<td><input type="text" name="sno[]" id="sno<?php echo $i;?>" size="3" style="background:none; text-align:right; border:0" value="<?php echo $i; ?>" readonly /></td>
		<td></td>
	    <td><input type="text" name="itemcode[]" id="itemcode<?php echo $i;?>" size="6" style="background:none; text-align:center; border:0" value="<?php echo $row1['itemcode']; ?>" readonly /></td>
		<td></td>
	    <td><input type="text" name="description[]" id="description<?php echo $i;?>" style="background:none; text-align:center; border:0" value="<?php echo $row1['description']; ?>"/></td>
		
		
		<td width="10px"></td>
		
		
		<td align="right"><input type="text" name="units[]" id="units<?php echo $i;?>" size="7" style="background:none; border:0" value="<?php echo $row1['units']; ?>" readonly /></td>

		
		
		<td width="10px"></td>
		

		
		<td><input type="text" name="balquantity[]" id="balquantity<?php echo $i;?>" size="6"  style="text-align:right;background:none;border:none;" readonly  value = "<?php echo $bal+$row1['quantity'];?>"  /></td>
		
	
		<td width="10px"></td>
		
		
		
		<td><input type="text" name="quantity[]" id="quantity<?php echo $i;?>" size="6"  style="text-align:right;" value="<?php echo $row1['quantity']; ?>" onkeyup="validate(this.id,this.value);" /></td>
		
		
		<td width="10px"></td>
		
		
		
		
		
		
		
		<td><input type="text" id="rateperunit<?php echo $i;?>" name="rateperunit[]" size="8" value="<?php echo $rr['rateperunit']; ?>" style="background:none; border:0px;text-align:center;" readonly="true" />

		<td width="10px"></td>
	
<td><input type="text" name="freightie[]" id="freightie<?php echo $i;?>" value="<?php echo $rr['freightie'];?>" size="25" style="background:none; border:0px;text-align:center;" title="<?php echo $row1['freightie'];?>" /> </td>

<td width="10px"></td>
<td><input type="text" name="freightamt[]" id="freightamt<?php echo $i;?>" value="<?php echo $row1['freightamount'];?>"  <?php if($row1['freightie']==""){?> readonly="true" <?php } ?> size="8" /> </td>

<td width="10px"></td>
<td  >

<select name="fricode[]" id="fricode<?php echo $i;?>"<?php if($row1['freightie']=="Exclude" || $row1['freightie']=="") {?>  style="visibility:hidden;" <?php }  ?> >
<option value="">--Select--</option>

 <?php 
	   	for($j=0;$j<count($coacode);$j++)
			{ $coacode1=explode("@",$coacode[$j]);
				
	   ?>
	   <option title="<?php echo $coacode1[1]; ?>" value="<?php echo $coacode1[0]; ?>" <?php if($row1['freightcode']==$coacode1[0]) { ?> selected="selected" <?php } ?>><?php echo $coacode1[0]; ?></option>
	   <?php } ?>



</select> 


</td>


<td width="10px"></td>



<td   >
<select name="cash[]" id="cash<?php echo $i;?>" <?php if($row1['freightie']=="Include Paid By Customer" || $row1['freightie']=="") {?>  style="visibility:hidden;" <?php }  ?>  >
<option value="">--Select--</option>

<?php 
$querys="select distinct(code) from ac_bankmasters where mode = 'Cash' order by code";
$results=mysql_query($querys,$conn);
while($rows=mysql_fetch_array($results))
{


$query2="select distinct(coacode) from ac_bankmasters where mode = 'Cash' and code='$rows[code]' order by code";
$result2=mysql_query($query2,$conn);
while($row2=mysql_fetch_array($result2))
{
?>

<option value="<?php echo $row2['coacode'];?>" <?php if($row2['coacode']==$row1['cashcode']){?> selected="selected" <?php } ?> ><?php echo $row2['coacode'];?></option>
<?php

}


}


?>

</select> 

</td>

<td width="10px"></td>

		
		
	</tr>
<?php 

$i++; 		
		} ?>
      <script> globalindex="<?php echo $i;?>"; </script>    
   </table>
 


<br>
<br>
<center>
<input type="submit" id="save" value="Update" />&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_packslip'"/>
</center>
</form>
</div>
</section>
</center>

<script type="text/javascript">
function validate(a,b)
{
var index1 = a.substr(8);
if((Number(document.getElementById('balquantity'+index1).value) )<Number(document.getElementById('quantity'+index1).value))
{
 document.getElementById(a).value = document.getElementById('balquantity'+index1).value; //Math.round(Number(document.getElementById('quantity/'+index1).value)/10,0);
 alert("Quantity cannot be greater than " + (Number(document.getElementById('balquantity'+index1).value)));
 return false;
}
}




function amtcalculate()
{
var ind = globalindex; 

  for(var k = 1;k<ind;k++)
  {
  
  
  
    if(document.getElementById("quantity"+k).value=='0' || document.getElementById("quantity"+k).value == "")
  {
  alert("Please Enter Quantity");
  document.getElementById("quantity"+k).focus();
  return false;
  }
  

  
  
  if(document.getElementById("freightie"+k).value!="")
if(Number(document.getElementById("freightamt"+k).value)==0)
{

alert("please enter freight amount"+(k));
return false;
}



if(document.getElementById("freightie"+k).value=="Include" ||document.getElementById("freightie"+k).value=="Exclude")
if(Number(document.getElementById("cash"+k).value)==0)
{

alert("please select cash"+(k));
return false;
}

if(document.getElementById("freightie"+k).value=="Include" ||document.getElementById("freightie"+k).value=="Include Paid By Customer")
if(Number(document.getElementById("fricode"+k).value)==0)
{

alert("please select freight code"+(k));
return false;
}

  }

 return true;
}


function fun()
{
	var party = document.getElementById('party').value;
	document.location = "dashboardsub.php?page=oc_addpackslip&so=" + "&party=" + party;
}

function fun1()
{
	var so = document.getElementById('so').value;
	var party = document.getElementById('party').value;
	document.location = "dashboardsub.php?page=oc_addpackslip&so=" + so + "&party=" + party;
}



</script>
