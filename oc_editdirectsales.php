<?php
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$cilent = $_SESSION['client'];
$invoice = $_GET['id'];
$cobi = $invoice;
$finaldiscountamount=0;
$query1 = "SELECT * FROM oc_cobi where invoice = '$invoice' order by id";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
   $datemain = date("d.m.Y",strtotime($row1['date']));
   $party = $row1['party'];
   $bkinvoice = $row1['bookinvoice'];
   $warehouse = $row1['warehouse'];
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
  
  
} $totalprice =$basicamount - $finaldiscountamount ;
$q1=mysql_query("SET group_concat_max_len=10000000");

$i=0;


//party

$q = "select group_concat(distinct(name),'@',cterm order by name) as nameterm  from contactdetails where type = 'party' OR type = 'vendor and party' ";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
					 $names=explode(",",$qr["nameterm"]);	
					}
					
					$name1=json_encode($names);
					
					

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
 $sector=json_encode($sec1);
 
  //---------------Tax Codes-------------------------------
   $q="select group_concat(code,'@',description,'@',codevalue,'@',mode,'@',rule order by code) as tax FROM ims_taxcodes where  (taxflag = 'S'  )";
  $qrs=mysql_query($q,$conn) or die(mysql_error());
  $qr=mysql_fetch_assoc($qrs);
  $tax=explode(",",$qr['tax']);
  $tax1=json_encode($tax);
  
 
 


//------------------Cat &Item COdes----------------------


$query="select distinct(cat),group_concat(concat(code,'@',description,'@',sunits)) as cd from ims_itemcodes where  iusage LIKE '%Sale%'  group by cat";

$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{

$items[$i]=array("cat"=>"$row[cat]","cd"=>"$row[cd]");

$i++;

}

$item=json_encode($items);

//---------------------------Cash codes----
$q = "select group_concat(distinct(code),'@',name order by code) as code from ac_bankmasters where mode = 'Cash' order by code";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
				$cashcode=explode(",",$qr["code"]);
		}
$cashcodes1=json_encode($cashcode);
//---------------------------Bank codes-------------
$q = "select group_concat(distinct(acno),'@',name,'@',code order by acno) as acno from ac_bankmasters where mode = 'Bank' order by acno";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
			$acno=explode(",",$qr[acno]);
		}
$acno1=json_encode($acno);

	   		$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSE' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}

$coacode1=json_encode($coacode);

//...................................................Price Master Value...............................
$qdb=mysql_query("select fromdate,todate,customer,cat,code,price from oc_pricemaster");
while($rdb=mysql_fetch_array($qdb))
{
$f=$rdb[fromdate];
$t=$rdb[todate];
$dbs[]=array("fromdate"=>$f,"todate"=>$t,"warehouse"=>$rdb[customer],"category"=>$rdb[cat],"code"=>$rdb[code],"price"=>$rdb[price]);
}
$db=json_encode($dbs);
//...................................................Discount Master Values...............................
$qdb=mysql_query("select fromdate,todate,customer,cat,code,discount from oc_discounts");
while($rdb=mysql_fetch_array($qdb))
{
$f=$rdb[fromdate];
$t=$rdb[todate];
$dbd[]=array("fromdate"=>$f,"todate"=>$t,"warehouse"=>$rdb[customer],"category"=>$rdb[cat],"code"=>$rdb[code],"discount"=>$rdb[discount]);
}
$dis=json_encode($dbd);

?>

 
<script type="text/javascript">

var nameterm=<?php if(empty($name1)){echo "0";} else{ echo $name1; }?>;
var dbs=<?php if(empty($db)){echo "0";} else{ echo $db; }?>;
var dis=<?php if(empty($dis)){echo "0";} else{ echo $dis; }?>;
var items=<?php if(empty($item)){echo "0";} else{ echo $item; }?>;
var cashcode=<?php if(empty($cashcodes1)){ echo 0;} else{ echo $cashcodes1;}?>;
var acno=<?php if(empty($acno1)){echo "0";} else{ echo $acno1;}?>;
var taxs=<?php if(empty($tax1)){echo "0";}else{ echo $tax1;}?>;
var discs=<?php if(empty($dis1)){echo "0";}else{ echo $dis1;}?>;
var rcode=<?php if(empty($rcode1))echo "0";else{ echo $rcode1;}?>;
var coacode=<?php if(empty($coacode1)){echo 0;} else{ echo $coacode1;}?>;
</script>

<link href="editor/sample.css" rel="stylesheet" type="text/css"/>
<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" name="form1" method="post" onsubmit="return checkcoa();" <?php if($_SESSION[db]=="singhsatrang") {?>action="oc_updatedirectsalessingh.php" <?php } else
	 {?> action="oc_updatedirectsales.php"
     <?php 
	 }?> >
		<input type="hidden" name="cobiincr" id="cobiincr" value="<?php echo $cobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		<input type="hidden" name="saed" id="saed" value="1" />
		<input type="hidden" name="cuser" id="cuser" value="<?php echo $empname;?>" />
		<input type="hidden" name="oldinv" id="oldinv" value="<?php echo $cobi; ?>" />

	  <h1>Direct Sales</h1>
		<br /><br />
		
			<br />

		<b>Direct Sales</b>
		
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

		<br />
		
		<br />
		<table align="center">
		
		
		
              <tr>
             
                <td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepickerCOBI" type="text" size="15" id="date" name="date" value="<?php echo $datemain; ?>"  onchange="getsobi();"></td>
                <td width="5px"></td>
	
                <td><strong>Customer</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
					<select  id="party" name="party" style="width:175px">
					<option value="">-Select-</option>
					
					
					<?php 
 for($j=0;$j<count($names);$j++)
		   {
			$na=explode("@",$names[$j]);
           ?>
<option value="<?php echo $names[$j];?>" title="<?php echo $na[0]; ?>" <?php if($na[0]==$party) {?> selected="selected" <?php  } ?>><?php echo $na[0]; ?></option>
<?php } ?>
						
					

					</select>
				</td>
				 <td width="5px"></td>

                
                <td title = "Invoice"><strong>Inv.</strong></td>
                <td width="5px"></td>
                <td><input type="text" size="15" style="background:none;border:none;" id="invoice" name="invoice" value="<?php echo $cobi; ?>" readonly /></td>
				
				<td width="5px"></td>
				
                <td title = "Book Invoice"><strong>B&nbsp;Inv.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td width="5px"></td>
                <td>
					<input type="text" size="8" id="bookinvoice" name="bookinvoice" value="<?php echo $bkinvoice; ?>"></td>
					
					<td width="5px"></td>
				 <td><strong>&nbsp;Location&nbsp;</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td>
				<select id="aaa" name="aaa" style="width:120px">
<option value="">-Select-</option>
<?php 
 for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>" title="<?php echo $sec1[$j]; ?>" <?php if($sec1[$j]==$warehouse){?> selected="selected" <?php } ?>><?php echo $sec1[$j]; ?></option>
<?php } ?>


</select>
</td>

                <td width="5px"></td>

              </tr>
            </table>
<br /><br />
<center>
 <table border="0" id="table-po">
     <tr>
     <?php if($_SESSION[db]=="singhsatrang") {?>
     <th><strong>Free</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
     <?php }?>
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
     
	 <?php $i=0;

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
     <?php if($_SESSION[db]=="singhsatrang") {?>
      <td >
      <input type="checkbox" id="free@<?php echo $i;?>" name="free[]"  onclick="chk(this.id)" <?php if($qr[freequantity]=="Yes") {?> checked="checked" <?php }?>/>
      <input type="hidden" name="fre[]" value="<?php echo $qr[freequantity]; ?>" 
	 </td>
       <td width="10px"></td>
       <?php }?>
	  <td style="text-align:left;">
<select style="Width:100px" name="cat[]" id="cat@<?php echo $i; ?>" onchange="getcode(this.id);">
     <option value="">-Select-</option>
	 
	 
	      <?php 
	 
	  
for($c=0;$c<count($items);$c++)
{
?>
<option value="<?php echo $items[$c]["cat"]; ?>" <?php  if ($items[$c]["cat"] == $cat1){?> selected="selected"<?php } ?> ><?php echo $items[$c]["cat"]; ?></option>
<?php } ?>

</select>
       </td>
       <td width="10px"></td>
	   <td style="text-align:left;">
			<select style="Width:75px" name="code[]" id="code@<?php echo $i; ?>" onchange="selectdesc(this.id),getprice(this.id),getdiscount(this.id);">
     		<option value="">-Select-</option>
			
			
						  <?php 
for($c=0;$c<count($items);$c++)
{
if($items[$c]["cat"]==$cat1)
  {
  $cd=$items[$c]["cd"];
  $cd2=explode(',',$cd);
  for($j=0;$j<count($cd2);$j++)
  {
  $cd1=explode('@',$cd2[$j]);
?>
<option value="<?php echo $cd2[$j]; ?>" <?php  if ($cd1[0] == $qr['code']){?> selected="selected"<?php } ?> ><?php echo $cd1[0]; ?></option>
<?php }} }?>

</select>
       </td>
<td width="10px">&nbsp;</td><td>
<select id="description@<?php echo $i;?>" name="description[]" style="width:170px" onchange="selectcode(this.id),getprice(this.id),getdiscount(this.id);">
<option value="">-Select-</option>

 <?php 
for($c=0;$c<count($items);$c++)
{
if($items[$c]["cat"]==$cat1)
  {
  $cd=$items[$c]["cd"];
  $cd2=explode(',',$cd);
  for($j=0;$j<count($cd2);$j++)
  {
  $cd1=explode('@',$cd2[$j]);
?>
<option value="<?php echo $cd2[$j]; ?>" <?php  if ($cd1[1] == $qr['description']){?> selected="selected"<?php } ?> ><?php echo $cd1[1]; ?></option>
<?php }} }?>


</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@<?php echo $i; ?>" name="units[]" value="<?php echo $qr['units']; ?>" readonly style="background:none; border:0px;" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" style="text-align:right;" id="qtys@<?php echo $i; ?>" name="qtys[]" value="<?php   echo $qr['cquantity'];  ?>" onkeyup="decimalrestrict(this.id,this.value),calnet('');" onblur="calnet('');"   />

</td>

<td width="10px">&nbsp;</td>
<td>
<input type="text" size="6" id="price@<?php echo $i; ?>" style="text-align:right;background:none;border:none;" name="price[]" value="<?php echo $qr['pricec']; ?>"    />


<td width="10px">&nbsp;</td><td >
<select style="width:60px" name="vat[]" id="vat@<?php echo $i; ?>" onchange="calnet('');">
     <option value="0@0@0@0">None</option>
	 
	 	 <?php 
	     for($t=0;$t<count($tax);$t++)
           {
		     $tx=explode('@',$tax[$t]);
     ?>
             <option title="<?php echo $tx[1]; ?>" value="<?php echo $tx[0]."@".$tx[2]."@".$tx[3]."@".$tx[4]; ?>"<?php if($tx[0]==$qr['taxcode']){?> selected="selected"<?php } ?>><?php echo $tx[0]; ?></option>
     <?php } ?>
	 

</select>

</td>

 <td  width="10px">&nbsp;</td><td> 
 <input type="text" name="disc[]"  id="disc@<?php echo $i; ?>" value="<?php echo $qr['discountvalue'];?>" size="8"  style="text-align:right;" onfocus="makeForm(this.id);" onckeyup="calnet('');" readonly="readonly">

		
		  
		  <input type="hidden" id="taxamount@<?php echo $i; ?>" name="taxamount[]" value="<?php echo $qr['taxamount'];?>" />
    <input type="hidden" name="discountamount[]" id="discountamount@<?php echo $i; ?>" value="<?php echo $qr['discountamount'];?>" />

		  </td>

 <td  width="10px">&nbsp;</td><td>

	

	 </tr>
	
	 <?php
	  } ?>
	 
</table>
</br>
</center>
</br>
<center>
<table border="1">
   <tr style="height:20px"></tr>
   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;&nbsp;&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="<?php echo $basicamount; ?>" style="text-align:left; border:0px; background:none;" readonly /></td>
	  <td></td>
	  <td></td>
	  <td></td>
	  
  

      <td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" value="<?php echo $vehicle; ?>" /></td>
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Price</strong>&nbsp;&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:left; border:0px; background:none;" value="<?php echo $totalprice; ?>" readonly/></td>
<td></td><td></td>
	 <td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>
   <?php if($_SESSION['country'] == 'INDIA') { ?>
   <td align="left"><input type="text" size="15" name="driver" value = "<?php echo $driver; ?>" /></td>
<?php } else { ?>
<td align="left">
   <select name="driver" id="driver" style="width:120px">
<option value="">-Select-</option>
<?php
           include "config.php"; 
           $query = "SELECT * FROM hr_employee where designation='Driver' AND client = '$client' ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		    if ($row1['name'] == $driver ) { ?>
				 <option value="<?php echo $row1['name'];?>" selected = "selected" > <?php echo $row1['name']; ?></option>
				 <?php } else { ?>
           <option value="<?php echo $row1['name'];?>" > <?php echo $row1['name']; ?></option>
                <?php } } ?></select></td>

   <?php } ?>
  </tr>
  <tr style="height:20px"></tr>
  <tr style="height:20px"></tr>
  
  
  
  
   <tr>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select name="freighttype" id="freighttype"  onchange="calnet('dcreate')">
	   <option value="">--Select--</option>
	   
	   <option value="Include" <?php if($freighttype == "Include") { ?> selected="selected" <?php } ?>>Include</option>
	   <option value="Exclude"  <?php if($freighttype == "Exclude") { ?> selected="selected" <?php } ?>>Exclude</option>
	   <option value="Include Paid By Customer"  <?php if($freighttype == "Include Paid By Customer") { ?> selected="selected" <?php } ?>  title = "Include Paid By Customer">Include Paid By Customer</option>
	   </select></td>

       <td align="right"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
	   
       <td align="left">
	   <input type="text" size="8" name="cfamount" onkeypress="return num1(event.keyCode)" id="cfamount" onkeyup="calnet('dcreate')" value="<?php echo ($freightamount); ?>" onblur="checkcfamount(this.value)" style="text-align:right"/>
	   
	   &nbsp;&nbsp;</td>
	   
	    <td id="coavisible"<?php if($freighttype == "Exclude"){?> style="visibility:hidden" <?php  } ?> >
		
	   <select id="coa" name="coa" style="width:80px" >
	   
	   <option value="">-Select-</option>
	   
	    <?php
 for($m=0;$m<count($coacode);$m++) 
{
$coacode1=explode("@",$coacode[$m]);

	
?>
<option value="<?php echo $coacode1[0]; ?>" title="<?php echo $coacode1[1]; ?>" <?php if($coacode1[0] == $coa) { ?> selected="selected" <?php } ?>  ><?php echo $coacode1[0]; ?></option>
<?php } ?>
	   

	   </select>	 
	     </td>
	   
	   
       <td align="right" id="vvisible" <?php if($freighttype =="Include Paid By Customer") { ?>  style="visibility:hidden;" <?php } ?>><strong>Via</strong>&nbsp;&nbsp;&nbsp;</td>
	   
       <td align="left"  id="viavisible" <?php if($freighttype == "Include Paid By Customer") { ?>  style="visibility:hidden;" <?php } ?> >
	   
	   <select style="Width:80px" name="cvia" id="cvia" onchange="loadcodes(this.value);"><option value="">-Select-</option>
	   
	   <option value="Cash" <?php if ($viaf == "Cash") { ?> selected = "selected"<?php } ?> id="cash">Cash</option>
	   
	   <option value="Cheque" <?php if ($viaf == "Cheque") { ?> selected = "selected"<?php } ?>>Cheque</option>
	   
	   <option value="Others">Others</option></select></td>
	   
	   
	  <td align="right" id="cashbankcodetd1"  <?php if($freighttype == "Include Paid By Customer" || $freighttype=="" ) { ?>  style=" display:none" <?php } ?>><strong><span id="codespan">Code</span></strong>&nbsp;&nbsp;&nbsp;</td>
	  
        <td align="left" id="cashbankcodetd2" <?php if($freighttype == "Include Paid By Customer" || $freighttype=="") { ?>  style=" display:none" <?php } ?>>
		
		<select name="cashbankcode" id="cashbankcode" style="width:125px">
		
		<option value="">--Select--</option>
		
		<?php  if($cashbankcode<>"")
		{
	

		if ($viaf == "Cash"){?>
		
		
				    <?php
 for($m=0;$m<count($cashcode);$m++) 
{
$cashcode1=explode("@",$cashcode[$m]);

	
?>
<option value="<?php echo $cashcode1[0]; ?>" title="<?php echo $cashcode1[1]; ?>" <?php if($cashcode1[0] == $cashbankcode) { ?> selected="selected" <?php } else {  echo $cashbankcode."/".$accno1[2]; }?>  ><?php echo $cashcode1[0]; ?></option>
<?php } ?>
		
		
		
		<?php } else {?>
		
		
			   
	    <?php
 for($m=0;$m<count($acno);$m++) 
{
$accno1=explode("@",$acno[$m]);

	
?>
<option value="<?php echo $accno1[2]; ?>" title="<?php echo $accno1[1]; ?>" <?php if($accno1[2] == $cashbankcode) { ?> selected="selected" <?php } else {  echo $cashbankcode."/".$accno1[2]; }?>  ><?php echo $accno1[0]; ?></option>
<?php } ?>
	   

		
		<?php }  }?>
		</select>		</td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td></td><td></td><td></td>
	  <td align="right" id="chequetd1" ><strong>Cheque</strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="chequetd2" >
		<input type="text" name="cheque" id="cheque" size="12" value="<?php echo $cno; ?>" />		</td>

       <td align="right" id="datedtd1" ><strong>Dated</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left" id="datedtd2" ><input type="text" size="15" id="cdate" class="datepicker" name="cdate" readonly="readonly" value="<?php echo date("d.m.Y"); ?>" /></td>
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
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $remarks ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />

   <br />
   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=oc_directsales';">
</center>			
<script type="text/javascript">
function chk(id)
{
var ind=id.split('@');
if(document.getElementById(id).checked)
{
document.getElementById("price@"+ind[1]).value=0;
document.getElementById("disc@"+ind[1]).value=0;
calnet('');
}
else
{
getprice(id);
getdiscount(id);
calnet('');
}

}
function decimalrestrict(a,b)
{
var a1=b.split(".");
var a2=a1[1];
if(a1.length>1)
if(a2.length>3)
{
var b2=a2.length-3;
document.getElementById(a).value=b.substr(0,b.length-b2);
}
}
function getprice(id)
{
//alert(id);
<?php if($_SESSION[db]=="singhsatrang") {?>
var ind=id.split("@");
var fdate=document.getElementById('date').value;
var aaa=document.getElementById('party').value;
var cat=document.getElementById('cat@'+ind[1]).value;
var c=document.getElementById('code@'+ind[1]).value;
c=c.split('@');
var code=c[0];
var aa=aaa.split('@');
var fd=fdate.split(".");
var fd1=fd[2]+"/"+fd[1]+"/"+fd[0];
if(dbs!=null)
for(k=0;k<dbs.length;k++)
{
var dbf=dbs[k].fromdate.split("-");
var dbt=dbs[k].todate.split("-");
var dbf1=dbf[0]+"/"+dbf[1]+"/"+dbf[2];
var dbt1=dbt[0]+"/"+dbt[1]+"/"+dbt[2];
var dbfdate=new Date(dbf1);
var dbtdate=new Date(dbt1);
var fdate1=new Date(fd1);
//alert(aa[0]);
if((dbfdate.getTime()<=fdate1.getTime()  &&  dbs[k].warehouse==aa[0] &&   dbs[k].code==code )|| ( dbtdate.getTime()>=fdate1.getTime() &&  dbs[k].warehouse==aa[0] &&   dbs[k].code==code ))
{
document.getElementById('price@'+ind[1]).value=dbs[k].price;
if(document.getElementById("free@"+ind[1]).checked)
document.getElementById("price@"+ind[1]).value=0;
break;
} 
else
{
document.getElementById('price@'+ind[1]).value="";
}
}
if(document.getElementById('price@'+ind[1]).value=="")
{
alert("Enter the Price in Price Masters");
}
<?php }?>
}
function getdiscount(id)
{
//alert(id);
<?php if($_SESSION[db]=="singhsatrang") {?>
var ind=id.split("@");
var fdate=document.getElementById('date').value;
var aaa=document.getElementById('party').value;
var cat=document.getElementById('cat@'+ind[1]).value;
var c=document.getElementById('code@'+ind[1]).value;
c=c.split('@');
var code=c[0];
var aa=aaa.split('@');
var fd=fdate.split(".");
var fd1=fd[2]+"/"+fd[1]+"/"+fd[0];
if(dbs!=null)
for(k=0;k<dis.length;k++)
{
var dbf=dis[k].fromdate.split("-");
var dbt=dis[k].todate.split("-");
var dbf1=dbf[0]+"/"+dbf[1]+"/"+dbf[2];
var dbt1=dbt[0]+"/"+dbt[1]+"/"+dbt[2];
var dbfdate=new Date(dbf1);
var dbtdate=new Date(dbt1);
var fdate1=new Date(fd1);
//alert(aa[0]);
if((dbfdate.getTime()<=fdate1.getTime()  &&  dis[k].warehouse==aa[0] &&   dis[k].code==code )|| ( dbtdate.getTime()>=fdate1.getTime() &&  dis[k].warehouse==aa[0] &&   dis[k].code==code ))
{
document.getElementById('disc@'+ind[1]).value=dis[k].discount;
if(document.getElementById("free@"+ind[1]).checked)
document.getElementById("disc@"+ind[1]).value=0;
} 
else
{
}
}
if(document.getElementById('disc@'+ind[1]).value=="")
{
document.getElementById("disc@"+ind[1]).value=0;
}
<?php }?>
}
var index=<?php echo $i;?>;
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

var m1= Number(m);
var y1= Number(y);

if(m1!="<?php echo $m;?>" || y1!="<?php echo $y;?>")
{
for(var l = 0; l <= <?php echo $k; ?>;l++)
{

 if((yea[l] == y) && (mon[l] == m))
  { 
   if(cobiincr[l] < 10)
     cobi = 'COBI'+'-'+m+y+'-000'+parseInt(cobiincr[l]+1);
   else if(cobiincr[l] < 100 && cobiincr[l] >= 10)
     cobi = 'COBI'+'-'+m+y+'-00'+parseInt(cobiincr[l]+1);
   else
     cobi = 'COBI'+'-'+m+y+'-0'+parseInt(cobiincr[l]+1);
     document.getElementById('cobiincr').value = parseInt(cobiincr[l] + 1);
  break;
  }
 else
  {
   cobi = 'COBI' + '-' + m + y + '-000' + parseInt(1);
   document.getElementById('cobiincr').value = 1;
  }
}
document.getElementById('invoice').value = cobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;

}

else
{
document.getElementById('invoice').value="<?php echo $cobi;?>";

}


}



function makeForm(id) 
{


var id=id.substr(6,id.length);


for(k=1;k<=index;k++)
{

	if(k==1)
	{
	
	var type= document.getElementById("cat@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qtys=document.getElementById("qtys@"+k).value;
	
	var rate= document.getElementById("price@"+k).value;
	if(type=="" || code=="" || Number(qtys)==0  || Number(rate)==0)
	{
		return false;
	
	
	}

	
	}
else if(k<index)
{
	
	var type= document.getElementById("cat@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qtys=document.getElementById("qtys@"+k).value;
	
	var rate= document.getElementById("price@"+k).value;
	if(type=="" || code=="" || Number(qtys)==0  || Number(rate)==0)
	{
		return false;
	
	
	}
	

	 }
  }
if(id!=index)
return false;


index = index + 1 ;

///////////para element//////////

var et = document.createElement('td');
et.width = "10px";
theText1=document.createTextNode('\u00a0');
et.appendChild(theText1);

var etd = document.createElement('td');
etd.width = "10px";
theText1=document.createTextNode('\u00a0');
etd.appendChild(theText1);

var etd1 = document.createElement('td');
etd1.width = "10px";
theText1=document.createTextNode('\u00a0');
etd1.appendChild(theText1);

var etd2 = document.createElement('td');
etd2.width = "10px";
theText1=document.createTextNode('\u00a0');
etd2.appendChild(theText1);

var etd3 = document.createElement('td');
etd3.width = "10px";
theText1=document.createTextNode('\u00a0');
etd3.appendChild(theText1);

var etd4 = document.createElement('td');
etd4.width = "10px";
theText1=document.createTextNode('\u00a0');
etd4.appendChild(theText1);

var etd5 = document.createElement('td');
etd5.width = "10px";
theText1=document.createTextNode('\u00a0');
etd5.appendChild(theText1); 

var etd6 = document.createElement('td');
etd6.width = "10px";
theText1=document.createTextNode('\u00a0');
etd6.appendChild(theText1);

var etd7 = document.createElement('td');
etd7.width = "10px";
theText1=document.createTextNode('\u00a0');
etd7.appendChild(theText1);

var etd8 = document.createElement('td');
etd8.width = "10px";
theText1=document.createTextNode('\u00a0');
etd8.appendChild(theText1);

var etd9 = document.createElement('td');
etd9.width = "10px";
theText1=document.createTextNode('\u00a0');
etd9.appendChild(theText1);

var etd10 = document.createElement('td');
etd10.width = "10px";
theText1=document.createTextNode('\u00a0');
etd10.appendChild(theText1);

var etd12 = document.createElement('td');
etd12.width = "10px";
theText1=document.createTextNode('\u00a0');
etd12.appendChild(theText1);

var t  = document.getElementById('table-po');

var r  = document.createElement('tr');
r.setAttribute ("align","center");


mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="checkbox";
mybox1.name="free[]";
mybox1.id = "free@" + index;
mybox1.onclick=function() {chk(this.id)};

var chkbox = document.createElement('td');
chkbox.appendChild(mybox1); 

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "100px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { getcode(this.id); };

  for(i=0;i<items.length;i++)
{

 var theOption=new Option(items[i].cat,items[i].cat);
		
		
myselect1.options.add(theOption);

}
var type = document.createElement('td');
type.appendChild(myselect1);

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectdesc(this.id),getprice(this.id),getdiscount(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);


// for description start

myselect1 = document.createElement("select");
myselect1.name = "description[]";
myselect1.id = "description@" + index;
myselect1.style.width = "170px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectcode(this.id),getprice(this.id),getdiscount(this.id); };

// for description end


var desc = document.createElement('td');
//desc.appendChild(mybox1);
desc.appendChild(myselect1);//for description


mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="units[]";
mybox1.id = "units@" + index;
mybox1.setAttribute("readonly");
mybox1.style.background="none";
mybox1.style.border="0px";
var units = document.createElement('td');
units.appendChild(mybox1);


mybox1=document.createElement("input");
mybox1.size="7";
mybox1.type="text";
mybox1.id="qtys@" + index;
mybox1.style.textAlign = "right";
mybox1.name="qtys[]";
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var qst = document.createElement('td');
qst.appendChild(mybox1);
mybox1.onkeypress=function(){return num(this.id,event.keyCode);};






////////// Sixth TD ////////////


mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="price@" + index;
mybox1.name="price[]";
mybox1.style.textAlign = "right";
mybox1.style.background="none";
mybox1.style.border="0px";
mybox1.setAttribute("readonly");

var price = document.createElement('td');
price.appendChild(mybox1);



////////// Seventh TD ////////////

myselect2 = document.createElement("select");
myselect2.id="vat@" + index;
myselect2.name = "vat[]";
myselect2.onchange = function () { calnet(''); };
myselect2.style.width = "60px";

theOption2=document.createElement("OPTION");
theText2=document.createTextNode("None");
theOption2.appendChild(theText2);
theOption2.value = "0@0@0@0";
myselect2.appendChild(theOption2);

for(var j=0;j<taxs.length;j++)
{
tax1=taxs[j].split("@");
		   taxs1=tax1[0]+"@"+tax1[2]+"@"+tax1[3]+"@"+tax1[4];
	 
		  var theOption=new Option(tax1[0],taxs1);
			theOption.title = tax1[1];
			myselect2.options.add(theOption);
		  
}

var vat = document.createElement('td');

vat.appendChild(myselect2);

input = document.createElement("input");
input.type = "hidden";
input.value=0;
input.id = "taxamount@" + index;
input.name = "taxamount[]";



  var td12 = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.id="disc@" + index;
mybox1.name="disc[]";
mybox1.style.textAlign = "right";
mybox1.value=0;
mybox1.setAttribute("readonly","readonly");
mybox1.onkeyup = function () { calnet(''); };
mybox1.onfocus = function () { makeForm(this.id); };
mybox1.onblur = function () { calnet(''); };

td12.appendChild(mybox1);
  
  

  input1 = document.createElement('input');
  input1.type = "hidden";
  input1.id = "discountamount@"+index;
  input1.name="discountamount[]";
  input1.value = "0";




	   
      r.appendChild(type);
	  r.appendChild(etd8);
      r.appendChild(code);
	  r.appendChild(etd);
      r.appendChild(desc);
	  r.appendChild(etd1);
	  r.appendChild(units);
	  r.appendChild(etd2);
	  r.appendChild(qst);
	  r.appendChild(etd3);
 
	  
	  r.appendChild(price);
	  r.appendChild(etd7);
	
	  r.appendChild(vat);
	  r.appendChild(etd9);
	  
	  r.appendChild(td12);
      r.appendChild(etd12); 
	  
	
	  r.appendChild(input);
	   r.appendChild(input1);
      t.appendChild(r);
	
}

function selectdesc(codeid)
{



     var temp = codeid.split("@");
     var tempindex = temp[1];
	 
	 
	      var code1 = document.getElementById("code@" + tempindex).value;
		 if(code1=="")
		 {
		 document.getElementById('units@' + tempindex).value="";
		  document.getElementById('description@' + tempindex).value="";
 		  document.getElementById('code@' + tempindex).value="";
		  return false;
		 
		 }
	 

 
 for(j=1;j<=index;j++)
 {
 
 if((document.getElementById('code@' + tempindex).value==document.getElementById('code@' + j).value)&&(tempindex!=j) &&(document.getElementById('code@' + tempindex).value!=""))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('description@' + tempindex).value="";
 return false;
 
 }
 }


     document.getElementById("description@" + tempindex).value = document.getElementById("code@" + tempindex).value;
    

     var code1 = document.getElementById("code@" + tempindex).value;
	 var t = code1.split("@");
	 document.getElementById('units@' + tempindex).value = t[2];


	
}





function selectcode(codeid)
{
   
   
   
   
     var temp = codeid.split("@");
     var tempindex = temp[1];
	 
	 
	      var code1 = document.getElementById("description@" + tempindex).value;
		 if(code1=="")
		 {
		 document.getElementById('units@' + tempindex).value="";
		  document.getElementById('description@' + tempindex).value="";
 		  document.getElementById('code@' + tempindex).value="";
		  return false;
		 
		 }
	 
	
	 
	  for(j=1;j<=index;j++)
 {
 
 if((document.getElementById('description@' + tempindex).value==document.getElementById('description@' + j).value)&&(tempindex!=j) &&(document.getElementById('description@' + tempindex).value!=""))
 {
 alert("Select different combination");
 document.getElementById('description@' + tempindex).value="";
  document.getElementById('code@' + tempindex).value="";
 return false;
 
 }
 }
 
 
	 
	 
     document.getElementById("code@" + tempindex).value = document.getElementById("description@" + tempindex).value;
    
	 
	 
	 var t = code1.split("@");
	 document.getElementById('units@' + tempindex).value = t[2];
	


}

function getcode(cat)
{
 
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var k = temp[1];
	var i,j;
//var code=document.getElementById("code@" + index1).value
	//alert(k);
	 
document.getElementById("code@"+k).options.length=1;
document.getElementById("description@"+k).options.length=1;	 


	var l=items.length;
var x=document.getElementById("cat@"+k).value;
 for(i=0;i<l;i++)
{
if(items[i].cat == x)
{
var ll=items[i].cd.split(",");
for(j=0;j<ll.length;j++)
{ 
var expp=ll[j].split("@");
var op1=new Option(expp[0],ll[j]);
op1.title=expp[0];
var op2=new Option(expp[1],ll[j]);
op2.title=expp[1];
document.getElementById("description@"+k).options.add(op2);
document.getElementById("code@"+k).options.add(op1);
}
 
}
}
			

}



function calnet(a)
{



 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;
 var withtax=0;
 var total=0;
 var btotal=0;
 var tax7=0;
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
  var tot2 = 0; var qty112 = 0; var price112 = 0; var temp112 = 0;

  index1=index;


 for(k = 1;(k <=index1);k++)
 {
 	
 	 var tot=0;
 
  	var vat=0;
  	
 var vat = document.getElementById("vat@" + k).value;
var discount =Number(document.getElementById("disc@" + k).value);
 
	//alert(document.getElementById("price@" + k).value);
  if(document.getElementById("qtys@" + k).value != "" || document.getElementById("price@" + k).value != ""){
   tot1= tot1+ (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);
   t=(document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);
   }

   total= total+ (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);
 

 
  	 if(vat != '0' && vat != "")
{



 
   var a1 = document.getElementById("vat@" + k).value;
       //alert(a1);
      a1 = a1.split('@');
       var tax=0;

       var mode = a1[2];
	   var taxval=a1[1];
	  
	   var rule=a1[3];
	   var A=0;
       var A =(document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);

	   
	   if(mode=="Percent" &&rule=="Exclude" )
	   {
	   
	var tot=Number((A*taxval)/100);
	    withtax=Number(A)+Number((A*taxval)/100);
		tax=tot;
	   
	   }
	   else  if(rule=="Exclude"&&mode=="Flat" )
	   {
	 
	 
	   withtax =Number(A)+Number(taxval);
	   var tot=Number(taxval);
	   tax=tot;
	   }
	  else
	  if(rule=="Include")
	  {
		 if(mode=="Percent")
		   {
		   
			taxa=((Number(A)*100)/(100+Number(taxval)));
			tax7=Number(A)-Number(taxa);
		   withtax=Number(A);
		   tot=0;
		  
		   
		   tax=tax7;
		 
		   }
		   else
		   {
		tot=0;
			withtax=Number(A);
			tax=Number(taxval);
		   }
	  
	  } 
	  


 

}

 document.getElementById('taxamount@' + k).value=tax;

 tot1 = tot1 + tot;

 disc=0;

total=total+tot;

  if(discount != '0' && discount != "")
{

disc=discount;

} 
  document.getElementById('discountamount@' + k).value=(t*disc)/100;
  tot1 = tot1 -((t*disc)/100);


 var tot2=tot1;



 }
  
   tot = tot2;
 document.getElementById('basic').value = round_decimals(total,5);
 

 
document.getElementById('totalprice').value = round_decimals(tot1,5);


if(document.getElementById("cfamount").value=="")
document.getElementById("cfamount").value=0;



if(document.getElementById("freighttype").value == "Include")
{
document.getElementById("coavisible").style.visibility="visible";

document.getElementById("viavisible").style.visibility="visible";

document.getElementById("vvisible").style.visibility="visible";

document.getElementById('cashbankcodetd1').style.display = "inline";

document.getElementById('cashbankcodetd2').style.display = "inline";

  var freight = parseFloat(document.getElementById("cfamount").value);
  
}
if(document.getElementById("freighttype").value == "Exclude")
{document.getElementById("coavisible").style.visibility="hidden";

document.getElementById("viavisible").style.visibility="visible";

document.getElementById("vvisible").style.visibility="visible";

document.getElementById('cashbankcodetd1').style.display = "inline";

document.getElementById('cashbankcodetd2').style.display = "inline";

document.getElementById('coa').value = "";
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 + freight;
}
if(document.getElementById("freighttype").value == "Include Paid By Customer")
{document.getElementById("coavisible").style.visibility="visible";

document.getElementById("viavisible").style.visibility="hidden";

document.getElementById("vvisible").style.visibility="hidden";

document.getElementById('cashbankcodetd1').style.display = "none";

document.getElementById('cashbankcodetd2').style.display = "none";

document.getElementById('cashbankcode').value = "";

document.getElementById('cvia').value = "";

  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 - freight;
}


document.getElementById("tpayment").value = round_decimals(tot1,5);





}

function loadcodes(via)
{
document.getElementById('cashbankcode').options.length=1;
var code = document.getElementById('cashbankcode');

document.getElementById('codespan').innerHTML = "Code";
document.getElementById('cashbankcodetd1').style.display = "none";
document.getElementById('cashbankcodetd2').style.display = "none";
document.getElementById('datedtd1').style.display = "none";
document.getElementById('datedtd2').style.display = "none";
document.getElementById('chequetd1').style.visibility = "hidden";
document.getElementById('chequetd2').style.visibility = "hidden";

if(via == "Cash")
{
document.getElementById('codespan').innerHTML = "Cash Code ";
document.getElementById('cashbankcodetd1').style.display = "";
document.getElementById('cashbankcodetd2').style.display = "";
document.getElementById('datedtd1').style.display = "";
document.getElementById('datedtd2').style.display = "";


for(var k=0;k<cashcode.length;k++)
	{
		var cashcode1=cashcode[k];
		var cashcode2=cashcode1.split('@');

		var op1=new Option(cashcode2[0],cashcode2[0]);
		op1.title=cashcode2[1];
		code.options.add(op1);
		
		
	}

}
else if(via == "Cheque"  || via == "Others")
{
document.getElementById('codespan').innerHTML = "Bank A/C No. ";
document.getElementById('cashbankcodetd1').style.display = "";
document.getElementById('cashbankcodetd2').style.display = "";
document.getElementById('datedtd1').style.display = "";
document.getElementById('datedtd2').style.display = "";
document.getElementById('chequetd1').style.visibility = "visible";
document.getElementById('chequetd2').style.visibility = "visible";



for(var k=0;k<acno.length;k++)
	{
		var accno=acno[k];
		var acno1=accno.split('@');
		
		var op1=new Option(acno1[0],acno1[2]);
		op1.title=acno1[1];
		code.options.add(op1);
		
	}
}
}

function checkcoa()
{
  index1=index;
for(k = 1;(k <=index1);k++)
{
if(document.getElementById('price@'+k).value=="")
{
alert("Enter Price in Price masters");
return false;
}
}
if(document.getElementById('party').selectedIndex == 0)
{
 alert("Please select Customer");
 document.getElementById('party').focus();
 return false;
}
//alert(index);
if(index== -1)
{
var cmpindex=globalindex;
}
else
{
var  cmpindex=index;
}





if(document.getElementById('cfamount').value=="")
document.getElementById('cfamount').value=0;


	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0"  &&  document.getElementById('freighttype').value!="" )
	{
		
		if(document.getElementById('freighttype').value != "Exclude")
		{
		
		if(document.getElementById('coa').selectedIndex == 0)
		{
			alert("Please select Chart of Account");
			document.getElementById('coa').focus();
			return false;
		}	
		
		
		}	
		if(document.getElementById('freighttype').value != "Include Paid By Customer")
		{
		
		
		 if (document.getElementById('cvia').selectedIndex == 0)
		{
		   alert("Please select Mode");
			document.getElementById('cvia').focus();
			return false;
		}	
		 if (document.getElementById('cashbankcode').selectedIndex == 0)
		{
		   alert("Please select Payment Code");
			document.getElementById('cashbankcode').focus();
			return false;
		}	
		
		}
	}
	
	

	
document.getElementById("save").disabled=true;
	
	return true;
}

function round_decimals(original_number, decimals) {
    var result1 = original_number * Math.pow(10, decimals)
    var result2 = Math.round(result1)
    var result3 = result2 / Math.pow(10, decimals)
    return pad_with_zeros(result3, decimals)
}

function pad_with_zeros(rounded_value, decimal_places) {

   var value_string = rounded_value.toString()
    
   var decimal_location = value_string.indexOf(".")

   if (decimal_location == -1) {
        
      decimal_part_length = 0
        
      value_string += decimal_places > 0 ? "." : ""
    }
    else {
        decimal_part_length = value_string.length - decimal_location - 1
    }
    var pad_total = decimal_places - decimal_part_length
    if (pad_total > 0) {
        for (var counter = 1; counter <= pad_total; counter++) 
            value_string += "0"
        }
    return value_string
}


</script>

<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_t_editdirectsale.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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