<?php
include "jquery.php";

$submitflag=0;

$trnum=$_GET[trnum];
 $invoice=$cobi=$_GET['cobi'];

//warehouse

if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
 $q1 ="SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector WHERE type1='Warehouse'";
}
 else
 {
  $sectorlist = $_SESSION['sectorlist'];
  $q1 ="SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 = 'Warehouse'  and sector in ($sectorlist)";
 }
 $qrs = mysql_query($q1,$conn) or die(mysql_error());
 $qr = mysql_fetch_assoc($qrs);
 $sec1=explode(",",$qr["sector"]);	
 
 //--------------------------------------

 $query1 = "SELECT * FROM distribution_salesreceipt where invoice = '$invoice'";
$q1=mysql_query($query1);
while($r1=mysql_fetch_array($q1))
{
$date =$r1['date'];
$warehouse=$r1[warehouse];
$party=$r1[party];
$cobi=$r1[invoice];
$code[]=array("code"=>$r1[code],"qty"=>$r1[squantity]);
}

$codej=json_encode($code);

$finaldiscountamount=0;

$query1 = "SELECT * FROM oc_cobi where invoice = '$invoice' order by id";

$result1 = mysql_query($query1,$conn); 

while($row1 = mysql_fetch_assoc($result1))
{
   $datemain = date("d.m.Y",strtotime($row1['date']));
   
   $bkinvoice = $row1['bookinvoice'];
   
   $basicamount = $row1['total'];
   
   $freightamount = $row1['freightamount'];
   
   $finaldiscountamount = $finaldiscountamount+$row1['discountamount'];

   $freighttype = $row1['freighttype'];
   
   $cashbankcode = $row1['cashbankcode'];
   
   $coa = $row1['coacode'];
   
   $cno=$row1['cno'];
 
   $totalprice = $totalprice - $discountamount ;
   
   $grandtotal = $row1['finaltotal'];
   
   $viaf = $row1['viaf'];
 
   $vehicle = $row1['vno'];
   
   $driver = $row1['driver'];
   
   $m = $row1['m'];
   
   $y = $row1['y'];
   
   $cobiincr = $row1['cobiincr'];
   
   $remarks=$row1['remarks'];
   
   $flag = $row1['flag'];
   
   
   $empname=$row1['empname'];
  
  
} 

$totalprice =$basicamount - $finaldiscountamount ;
?>
<script  type="text/javascript">
var codes=<?php if(empty($codej)){echo "0";} else{ echo $codej; }?>;
</script>
<section class="grid_8">
  <div class="block-border">
  <center>
     <form class="block-content form" id="complex_form" name="form1" method="post"   action="distribution_savesalesreceipt.php" >
     <h1>Sales Receipt</h1>
     
     <b>Add Sales Receipt</b>
     
     <br /><br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/>
<input type="hidden" name="edit" value="1" />
<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
<input class="datepicker" type="text" size="15" id="date" name="date" value="<?php echo $date; ?>" onChange="reloadpage()" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



<strong>Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
<select name="warehouse" id="warehouse" style="width:150px" onChange="reloadpage()">
<option value="">-Select-</option>
<?php
$dt=date('Y-m-d',strtotime($date));


if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{

 $q1="select distinct warehouse from oc_cobi where srflag=0 and dflag=0";
  
}
 else
 {
  $sectorlist = $_SESSION['sectorlist'];

 $q1="select distinct warehouse from oc_cobi where  dflag=0 and warehouse in ($sectorlist)";
 }



$q1="select distinct warehouse from oc_cobi where  dflag=0";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
if(in_array($r1['warehouse'],$sec1))
{
?>

<option value="<?php echo $r1['warehouse'];?>" title="<?php echo $r1['warehouse'];?>" <?php if($r1['warehouse']==$warehouse){?> selected="selected"<?php }?>><?php echo $r1['warehouse'];?></option>

<?php }} ?>

</select>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<strong>Party/Customer</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

<select name="party" id="party" style="width:150px" onChange="reloadpage()">
<option value="">-Select-</option>
<?php
$q1="select distinct party from oc_cobi where warehouse='$warehouse'";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{

?>

<option value="<?php echo $r1['party'];?>" title="<?php echo $r1['party'];?>"<?php if($r1['party']==$party){?> selected="selected"<?php }?>><?php echo $r1['party'];?></option>

<?php } ?>

</select>
     
     
     
     
     <strong>COBI</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

<select name="cobi" id="cobi" style="width:150px" onChange="reloadpage()">
<option value="">-Select-</option>
<?php
$q1="select distinct invoice from oc_cobi where warehouse='$warehouse' and date ='$dt' and party='$party' and dflag=0";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{

?>

<option value="<?php echo $r1['invoice'];?>" title="<?php echo $r1['invoice'];?>" <?php if($r1['invoice']==$cobi){?> selected="selected"<?php }?>><?php echo $r1['invoice'];?></option>

<?php } ?>

</select>
     
     
     <br/><br/> <br/><br/> <br/><br/>
     
     <?php
	 if($warehouse!="" && $party!="" && $cobi!="")
	 {
	 
	 $submitflag=1;
	 
	 ?>
     
     <table border="0" id="table-po">
     <tr>
     <th><strong>Free</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
     
<th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th><strong>Units</strong></th><td width="10px">&nbsp;</td>

<th><strong>Qty</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th><strong>Price<br />/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th >&nbsp;&nbsp;&nbsp;<strong>Tax</strong></th><td width="10px">&nbsp;</td>

<th >&nbsp;&nbsp;&nbsp;<strong>Discount</strong></th><td  width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>
     
	 <?php 
	 $i=0;

$q = "select * from oc_cobi where invoice = '$invoice' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	
	$i++;
	
	
	$q1 = "select cat from ims_itemcodes where code = '$qr[code]' order by id ";
	
	$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	
	if($qr1 = mysql_fetch_assoc($qrs1))
	{
	  $cat1 = $qr1['cat'];
	}
	 ?>
	 <tr>
      <td >
      <input type="text" id="free@<?php echo $i;?>" name="free[]"  <?php if($qr[freequantity]=="Yes") {?> value="YES" <?php }else{?>value="NO"  <?php }?>  readonly="readonly" style="width:50px;border:none;background:none"/>
	 </td>
       <td width="10px"></td>
	  <td style="text-align:left;">
<input type="text" name="cat[]" id="cat@<?php echo $i; ?>" value="<?php echo $cat1; ?>" title="<?php echo $cat1; ?>" style="width:150px;border:none;background:none" readonly="readonly">
 
	  </td>
       <td width="10px"></td>
	   <td style="text-align:left;">
			<input type="text" name="code[]" id="code@<?php echo $i; ?>"  value="<?php echo $qr['code']; ?>" style="width:70px;border:none;background:none" readonly="readonly" title="<?php echo $qr['code']; ?>">
     		
       </td>
       
       
<td width="10px">&nbsp;</td><td>
<input type="text" name="description[]" id="description@<?php echo $i;?>"  value="<?php echo $qr['description']; ?>" style="width:150px;border:none;background:none" readonly="readonly" title="<?php echo $qr['description']; ?>">



</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@<?php echo $i; ?>" name="units[]" value="<?php echo $qr['units']; ?>" readonly style="background:none; border:0px;" />
</td>
<td width="10px">&nbsp;</td><td>

<input type="text" size="7"  id="qtys@<?php echo $i; ?>" name="qtys[]" value="<?php   echo $qr['cquantity'];  ?>" onkeyup="return calnet(this.id);"  />

</td>

<td width="10px">&nbsp;</td>
<td>
<input type="text" size="6" id="price@<?php echo $i; ?>" style="text-align:right;background:none;border:none;" name="price[]" value="<?php echo $qr['pricec']; ?>"  readonly="readonly"  />


<td width="10px">&nbsp;</td><td >
<input type="text" size="6" id="vat@<?php echo $i; ?>" style="text-align:right;background:none;border:none;" name="vat[]" value="<?php echo $qr['taxcode']; ?>"  title="<?php echo $qr['taxcode']; ?>" readonly="readonly" />


</td>

 <td  width="10px">&nbsp;</td><td> 
 <input type="text" name="disc[]"  id="disc@<?php echo $i; ?>" value="<?php echo $qr['discountamount'];?>" size="8"  style="text-align:right;background:none;border:none;"  readonly="readonly">

		
		 

		  </td>

 <td  width="10px">&nbsp;</td><td>

	

	 </tr>
	
	 <?php
	  } ?>
	 
</table>
</br>

<table border="1">
   <tr style="height:20px"></tr>
   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;&nbsp;&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="<?php echo $basicamount; ?>" style="text-align:left; border:0px; background:none;" readonly /></td>
	  <td></td>
	  <td></td>
	  <td></td>
	  
  

      <td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" value="<?php echo $vehicle; ?>" readonly="readonly" style="background:none;border:none;" /></td>
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Price</strong>&nbsp;&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:left; border:0px; background:none;" value="<?php echo $totalprice; ?>" readonly/></td>
<td></td><td></td>
	 <td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>
 
   <td align="left"><input type="text" size="15" name="driver" value = "<?php echo $driver; ?>" readonly="readonly" style="background:none;border:none;" /></td>

  </tr>
  <tr style="height:20px"></tr>
  <tr style="height:20px"></tr>
  
  
  
  
      <tr>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><input type="text" name="freighttype" id="freighttype"  value="<?php echo $freighttype; ?>" readonly="readonly" style="background:none;border:none;">
	  </td>

       <td align="right"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
	   
       <td align="left">
	   <input type="text" size="8" name="cfamount"  id="cfamount"  value="<?php echo ($freightamount); ?>"  style="text-align:right;background:none;border:none;" readonly="readonly"/>
	   
	   &nbsp;&nbsp;</td>
	   
	    <td id="coavisible"<?php if($freighttype == "Exclude"){?> style="visibility:hidden" <?php  } ?> >
		
	   <input  type="text" id="coa" name="coa" style="width:80px;background:none;border:none;" value="<?php echo $coa; ?>" readonly="readonly" >
	   
		 
	     </td>
	   
	   
       <td align="right" id="vvisible" <?php if($freighttype =="Include Paid By Customer") { ?>  style="visibility:hidden;" <?php } ?>><strong>Via</strong>&nbsp;&nbsp;&nbsp;</td>
	   
       <td align="left"  id="viavisible" <?php if($freighttype == "Include Paid By Customer") { ?>  style="visibility:hidden;" <?php } ?> >
	   
	   <input type="text" name="cvia" id="cvia" value="<?php echo $viaf; ?>" readonly="readonly" style="background:none;border:none;"></td>
	   
	   
	  <td align="right" id="cashbankcodetd1"  <?php if($freighttype == "Include Paid By Customer" || $freighttype=="" ) { ?>  style=" display:none" <?php } ?>><strong><span id="codespan">Code</span></strong>&nbsp;&nbsp;&nbsp;</td>
	  
        <td align="left" id="cashbankcodetd2" <?php if($freighttype == "Include Paid By Customer" || $freighttype=="") { ?>  style=" display:none" <?php } ?>>
		
		<input type="text" name="cashbankcode" id="cashbankcode" style="width:125px;background:none;border:none;" value="<?php echo $cashbankcode; ?>" readonly="readonly">
		
		
		
		</td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td></td><td></td><td></td>
	  <td align="right" id="chequetd1" ><strong>Cheque</strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="chequetd2" >
		<input type="text" name="cheque" id="cheque" size="12" value="<?php echo $cno; ?>"  readonly="readonly" style="background:none;border:none;" />		</td>

       <td align="right" id="datedtd1" ><strong>Dated</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left" id="datedtd2" ><input type="text" size="15" id="cdate" name="cdate" readonly="readonly" value="<?php echo date("d.m.Y"); ?>" style="background:none;border:none;" /></td>
</tr>

  

  <tr style="height:20px"></tr>
<tr>
	  <td align="right"><strong>&nbsp;Grand&nbsp;Total</strong>&nbsp;&nbsp;</td>
        <td align="left"><input type="text" size="12" name="tpayment" id="tpayment" value="<?php echo $grandtotal; ?>" readonly style="text-align:left; background:none; border:0px;"/></td>
</tr>
</table>	
	
<br />
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />

   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" <?php if($submitflag==0){?> disabled="disabled" <?php }?> /><?php }?>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=distribution_salesreceipt';">

     
     
 </form>
</center>
</div>			
</section>
<script type="text/javascript">
function decimalrestrict(a,b)
{
var a1=b.split(".");
var a2=a1[1];
if(a1.length>1)
if(a2.length>5)
{
var b2=a2.length-5;
document.getElementById(a).value=b.substr(0,b.length-b2);
}
}
function calnet(a)
{
var id=a.split('@');
var c=document.getElementById("code@"+id[1]).value;
var qty=document.getElementById(a).value;
for(i=0;i<codes.length;i++)
{
if(codes[i].code==c)
{
if(Number(codes[i].qty)<Number(qty))
{
alert("received Quantity Shoud Not be greater than  invoice Quantity");
document.getElementById(a).value=codes[i].qty;
return false;
}
}
}
var price=document.getElementById("price@"+id[1]).value;
var discount=document.getElementById("disc@"+id[1]).value;
var tot=(qty*price)-discount;
document.getElementById("basic").value=qty*price;
document.getElementById("totalprice").value=tot;
return true;
}

function reloadpage()
{

 var date=document.getElementById("date").value;
 
 var warehouse=document.getElementById("warehouse").value;
 
 var party=document.getElementById("party").value;
 
 var cobi=document.getElementById("cobi").value;
 
 document.location='dashboardsub.php?page=distribution_editsalesreceipt&date='+date+'&warehouse='+warehouse+'&party='+party+'&cobi='+cobi;



}





</script>