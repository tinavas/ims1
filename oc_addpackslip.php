<?php  
include "config.php";
include "timepicker.php";
include "getemployee.php";  

if(!isset($_GET['warehouse']))
$warehouse = "";
else
$warehouse = $_GET['warehouse'];

if(!isset($_GET['party']))
$party = "";
else
$party = $_GET['party'];

//echo $_SESSION['db'];

if(!isset($_GET['so']))
$so = "";
else
$so = $_GET['so'];


$q1=mysql_query("SET group_concat_max_len=10000000");
   

   
   
   
   
   
   //sectors

	    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	
		if($sectorlist=="")  
 $q1 = "SELECT group_concat(distinct(warehouse) ORDER By warehouse) as sector FROM oc_salesorder WHERE flag = 1   AND (quantity <> sentquantity) ";
else

 $q1 = "SELECT  group_concat(distinct(warehouse) ORDER By warehouse) as sector  FROM oc_salesorder WHERE flag = 1   AND (quantity <> sentquantity) and warehouse in ($sectorlist)";
	 
	  $res1 = mysql_query($q1,$conn); 

$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);



   //party name

 $query = " SELECT group_concat(distinct(vendor)ORDER BY vendor ASC ) as name  FROM oc_salesorder WHERE flag = 1  AND (quantity <> sentquantity) AND warehouse = '$warehouse'  ";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
	 $names=explode(",",$row["name"]);
}
$name=json_encode($names);
   


	   		$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSE' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}

$coacode1=json_encode($coacode);



?>


<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="packslipinsert" name="packslipinsert" method="post" action="oc_savepackslipc.php" onsubmit="return amtcalculate(this);">
	  <h1 id="title1">Pack Slip</h1>
		
  
<br />
<b>Pack Slip</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />








<br />
<br />
<!-- table for date,party,and sales order-->
<table align="center" >
<tr>
<td align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
			   <td>
			    <select id="warehouse" name="warehouse" style="width:120px;" onchange="loadparty(this.value);">
				<option value="">-Select-</option>
				
				<?php
          
          
		   for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>"  <?php if($warehouse == $sec1[$j]) { ?> selected="selected" <?php } ?> title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php } ?>


				</select>
				</td>
<td width="20px"></td>
<td align="right"><strong>Party&nbsp;&nbsp;&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td><select name="party" id="party" style="width:180px" onchange="fun();">
             <option value="">-Select-</option>
			 
			 <?php 
				for($i=0;$i<count($names);$i++)
				{ 
				?>
				
                <option value="<?php echo $names[$i];?>" <?php if($party == $names[$i]) { ?> selected="selected" <?php } ?> title="<?php echo $names[$i];?>"><?php echo $names[$i]; ?></option>
                <?php } ?>
			 
</select>&nbsp;&nbsp;&nbsp;</td>



<td align="right"><strong>Sales Order #&nbsp;&nbsp;&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td>
<select name="so" id="so" onchange="fun1();" style="width:160px"  >
<option>-Select-</option>
<?php
           $query = "SELECT distinct(po) FROM oc_salesorder where vendor = '$party' and warehouse='$warehouse'  and flag = '1' and (quantity <> sentquantity ) order by po";
           $result = mysql_query($query,$conn) or die(mysql_error()); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['po']; ?>" <?php if($so == $row1['po']) { ?> selected="selected" <?php } ?>><?php echo $row1['po']; ?></option>
<?php } ?>
</select>&nbsp;&nbsp;&nbsp;
</td>
<td align="right"><strong>Date&nbsp;&nbsp;&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td><input type="text" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y"); ?>" size="10"/>&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
<!-- end of the table for date,party,and sales order-->
<br/>
<br/>
<table align="center" border="0">
 <tr>

  <td width="20px"></td>
  <td style="vertical-align:top ">
   <table border="0">
	   <tr height="30px">
 	    <th align="center"><strong>S.No</strong></td>
		<th width="10px"></th>
	    <th  align="center"><strong>Items</strong></td>
		<th width="10px"></th>
		<th  align="center"><strong>Description</strong></td>
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
		
	   </tr>
	   <tr style="height:10px"></tr>
 <?php   $query1 = "select * from oc_salesorder where po = '$so' and vendor = '$party' and (quantity > sentquantity ) ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());

		$i = 1;	$gi = 0;
		while($row1 = mysql_fetch_assoc($result1))	
		{
		
		?> 
		
<input type="hidden" id="taxcode<?php echo $i;?>" name="taxcode[]" value="<?php echo $row1['taxcode']; ?>" />
<input type="hidden" id="taxie<?php echo $i;?>" name="taxie[]" value="<?php echo $row1['taxie']; ?>" />
<input type="hidden" id="freightcode<?php echo $i;?>" name="freightcode[]" value="<?php echo $row1['freightcode']; ?>" />

<input type="hidden" id="taxvalue<?php echo $i;?>" name="taxvalue[]" value="<?php echo $row1['taxvalue']; ?>" />
<input type="hidden" id="freightvalue<?php echo $i;?>" name="freightvalue[]" value="<?php echo $row1['freightvalue']; ?>" />
<input type="hidden" id="discountvalue<?php echo $i;?>" name="discountvalue[]" value="<?php echo $row1['discountvalue']; ?>" />

<input type="hidden" id="taxamount<?php echo $i;?>" name="taxamount[]" value="<?php echo $row1['taxamount'];?>" />
<input type="hidden" id="freightamount<?php echo $i;?>" name="freightamount[]" value="<?php echo $row1['freightamount'];?>" />
<input type="hidden" id="discountamount<?php echo $i;?>" name="discountamount[]" value="<?php echo $row1['discountamount'];?>" />



<input type="hidden" id="taxformula<?php echo $i;?>" name="taxformula[]" value="<?php echo $row1['taxformula']; ?>" />

		<tr style="height:30px">
		<td><input type="text" name="sno[]" id="sno<?php echo $i;?>" size="3" style="background:none; text-align:center; border:0" value="<?php echo $i; ?>" readonly="true"/></td>
		<td width="10px"></td>
	    <td><input type="text" name="itemcode[]" id="itemcode<?php echo $i;?>" size="8" style="background:none; text-align:center; border:0" value="<?php echo $row1['code']; ?>" readonly="true"/></td>
		<td width="10px"></td>
	<td><input type="text" name="description[]" id="description<?php echo $i;?>" style="background:none;text-align:center;border:0" value="<?php echo $row1['description']; ?>" readonly="true"/></td>
		<td width="10px"></td>
	<td align="right"><input type="text" name="units[]" id="units<?php echo $i;?>" size="8" style="background:none; border:0" value="<?php echo $row1['unit']; ?>" readonly="true"/></td>
		<td width="10px"></td>

		<td><input type="text" name="balquantity[]" id="balquantity<?php echo $i;?>" size="8"  style="text-align:center;background:none;border:none;" readonly value="<?php echo $row1['quantity']-$row1['sentquantity']; ?>" /></td>
		<td width="10px"></td>
		
		<td><input type="text" name="quantity[]" id="quantity<?php echo $i;?>" size="8"  style="text-align:right;" value="<?php if($row1['quantity']-$row1['sentquantity']>0) { echo $row1['quantity']-$row1['sentquantity']; } else { echo "0"; }?>" onkeyup="validate(this.id,this.value);"  onblur="checknum(this.value,this.id)"  /></td>
		<td width="10px"></td>
		
		
		<td><input type="text" id="rateperunit<?php echo $i;?>" name="rateperunit[]" size="8" value="<?php echo $row1['rateperunit']; ?>" style="background:none; border:0px;text-align:center;" readonly="true" />

		<td width="10px"></td>
	
<td><input type="text" name="freightie[]" id="freightie<?php echo $i;?>" value="<?php echo $row1['freightie'];?>" size="25" style="background:none; border:0px;text-align:center;" title="<?php echo $row1['freightie'];?>" /> </td>

<td width="10px"></td>
<td><input type="text" name="freightamt[]" id="freightamt<?php echo $i;?>" value="0"  <?php if($row1['freightie']==""){?> readonly="true" <?php } ?> size="8" /> </td>

<td width="10px"></td>
<td  >

<select name="fricode[]" id="fricode<?php echo $i;?>"<?php if($row1['freightie']=="Exclude" || $row1['freightie']=="") {?>  style="visibility:hidden;" <?php }  ?> >
<option value="">--Select--</option>

 <?php 
	   	for($j=0;$j<count($coacode);$j++)
			{ $coacode1=explode("@",$coacode[$j]);
				
	   ?>
	   <option title="<?php echo $coacode1[1]; ?>" value="<?php echo $coacode1[0]; ?>"><?php echo $coacode1[0]; ?></option>
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

<option value="<?php echo $row2['coacode'];?>"><?php echo $row2['coacode'];?></option>
<?php

}


}


?>

</select> 

</td>

<td width="10px"></td>

		
		
		
		
		
		
		
		
		<td>
		<input type="hidden" id="category<?php echo $i; ?>" name="category[]" value="<?php echo $row1['category']; ?>" />


		</td>
		<td></td>
		
<?php 
		   $i++; } ?>
<script> globalindex="<?php echo $i;?>"; </script>
          
   </table>
  </td>
 </tr>
</table>



<br>
<br>
<center>
<input type="submit" id="save" value="Save" />&nbsp;&nbsp;
<input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_packslip'"/>
</center>
</form>

<script type="text/javascript">
function checknum(value,id)
{
var p=new RegExp("^[0-9\.]+$");
if(value != "")
{
if(!p.test(value))
{
alert("Enter Numbers Only");
document.getElementById(id).value="";

document.getElementById(id).focus();
}
}
}
function validate(a,b)
{
var index1 = a.substr(8);

if((Number(document.getElementById('balquantity'+index1).value))<Number(document.getElementById('quantity'+index1).value))
{
 document.getElementById(a).value = document.getElementById('balquantity'+index1).value; 
 alert("Quantity cannot be greater than Balance Quantity");
 return;
}


}



function loadparty(a)
{
 document.location = "dashboardsub.php?page=oc_addpackslip&so=" + "&warehouse=" + a;
}

function fun()
{
	var party = document.getElementById('party').value;
	var warehouse = document.getElementById('warehouse').value;
	document.location = "dashboardsub.php?page=oc_addpackslip&so=" + "&party=" + party + "&warehouse=" + warehouse;
}

function fun1()
{
	var so = document.getElementById('so').value;
	var party = document.getElementById('party').value;
	var warehouse = document.getElementById('warehouse').value;
	document.location = "dashboardsub.php?page=oc_addpackslip&so=" + so + "&party=" + party + "&warehouse=" + warehouse;
}





function amtcalculate(a)
{

var ind = globalindex; 






  for(var k = 1;k<ind;k++)
  { 
  



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

  for(var k = 1;k<ind;k++)
  { 
  

 
  if(document.getElementById("quantity"+k).value=='0' || document.getElementById("quantity"+k).value == "")
  {
  alert("Please Enter Quantity");
  document.getElementById("quantity"+k).focus();
  return false;
  }
  

 
  }
  
 document.getElementById('save').disabled=true;
 return true;
}

function script1() {
window.open('O2CHELP/help_addpackslip.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
</body>
