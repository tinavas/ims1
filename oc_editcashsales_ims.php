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
   $cno=$row1['cno'];
   $memp=$row1['marketingemp']; 
  
} $totalprice =$basicamount - $finaldiscountamount ;
$i=0;

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
   $q="select group_concat(code,'@',description,'@',codevalue,'@',mode,'@',rule order by code) as tax FROM ims_taxcodes where  (taxflag = 'S' )";
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


$q="select group_concat(distinct(code),'@',acno,'@',coacode) as code from ac_bankmasters order by coacode";
  $qrs=mysql_query($q) or die(mysql_error());
  while($qr = mysql_fetch_assoc($qrs))
		{
			$rcode=explode(",",$qr[code]);
		}
$rcode1=json_encode($rcode);


$q="select group_concat(distinct(code),'@',description order by code) as code  from ac_coa where client='$client'";
$qrs=mysql_query($q) or die(mysql_error());
  while($qr = mysql_fetch_assoc($qrs))
		{
			$cocode=explode(",",$qr['code']);
		}
$cocode1=json_encode($cocode);


//freight
	   		$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSE' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}

$coacode1=json_encode($coacode);




$pquery = "SELECT * FROM oc_receipt WHERE socobi = '$invoice' AND client = '$client' ORDER BY tid";
$presult = mysql_query($pquery,$conn) or die(mysql_error());
$prows = mysql_fetch_assoc($presult);


?>
<?php 
$fc=json_encode($ccd);
 ?>
 
<script type="text/javascript">
var fuc=<?php echo $fc;?>;
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;
var cashcode=<?php if(empty($cashcodes1)){ echo 0;} else{ echo $cashcodes1;}?>;
var acno=<?php if(empty($acno1)){echo 0;} else{ echo $acno1;}?>;
var taxs=<?php if(empty($tax1)){echo "0";}else{ echo $tax1;}?>;
var discs=<?php if(empty($dis1)){echo "0";}else{ echo $dis1;}?>;
var rcode=<?php if(empty($rcode1))echo 0;else{ echo $rcode1;}?>;
var cocode=<?php if(empty($cocode1))echo 0;else{ echo $cocode1;}?>;
</script>
<link href="editor/sample.css" rel="stylesheet" type="text/css"/>
<center>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" name="form1" method="post" onsubmit="return checkcoa();"  action="oc_updatedirectsales_ims.php" >
		<input type="hidden" name="cobiincr" id="cobiincr" value="<?php echo $cobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		<input type="hidden" name="saed" id="saed" value="1" />

	  <h1>Cash Sales</h1>
		<br /><br />
		
		<b>Cash Sales</b> <br/>
	  (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
	  <br/>	  <br/>	  <br/>        

		<table align="center">
		
		
		
              <tr>
             
                <td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="10" id="date" name="date" value="<?php echo $datemain; ?>" onchange="getsobi();" ></td>
                <td width="5px"></td>
				<?php if($_SESSION['db']=="mew"){?>
<td><strong>Marketing Emp.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
					<select  id="memp" name="memp">
					<option value="">-Select-</option>
<?php 
 $q="select distinct(name) from oc_employee order by name";
 $res=mysql_query($q);
 while($r=mysql_fetch_assoc($res))
 {
           ?>
<option value="<?php echo $r['name'];?>" title="<?php echo $r['name']; ?>" <?php if($r['name']==$memp){ ?> selected="selected"<?php } ?> ><?php echo $r['name']; ?></option>
<?php } ?>
					

					</select>
				</td>
<td width="5px"></td>
<?php } ?>
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

 <table border="0" id="table-po">
     <tr>
<th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Units</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th><strong>Price<br />/Unit</strong></th><td width="10px">&nbsp;</td>
<th >&nbsp;&nbsp;&nbsp;<strong>Tax</strong></th><td width="10px">&nbsp;</td>

<th >&nbsp;&nbsp;&nbsp;<strong>Discount</strong></th><td  width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>
	 
	 <?php $i=0;

$q = "select * from oc_cobi where invoice = '$invoice' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{$i++;
	  $q1 = "select cat from ims_itemcodes where code = '$qr[code]' order by id ";
	$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	if($qr1 = mysql_fetch_assoc($qrs1))
	{
	  $cat1 = $qr1['cat'];
	}
	 ?>
	 <tr>
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
			<select style="Width:75px" name="code[]" id="code@<?php echo $i; ?>" onchange="selectdesc(this.id);">
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
<select id="description@<?php echo $i;?>" name="description[]" style="width:170px" onchange="selectcode(this.id);">
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
<input type="text" size="7" style="text-align:right;" id="qtys@<?php echo $i; ?>" name="qtys[]" value="<?php 
  echo $qr['quantity'];  ?>
" onkeyup="calnet('');" onblur="calnet('');" />

</td>

<td width="10px">&nbsp;</td>
<td>
<input type="text" size="6" id="price@<?php echo $i; ?>" style="text-align:right;" name="price[]" value="<?php echo $qr['price']; ?>"  onkeyup="calnet('');" onblur="calnet('');"  onfocus="makeForm(this.id);" />

</td>
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
 <input type="text" name="disc[]"  id="disc@<?php echo $i; ?>" value="<?php echo $qr['discountamount'];?>" size="8"  style="text-align:right;" onkeypress="return num1(this.id,event.keyCode);" onchange="calnet('');">

		
	
		  
		  <input type="hidden" id="taxamount@<?php echo $i; ?>" name="taxamount[]" value="<?php echo $qr['taxamount'];?>" />
    <input type="hidden" name="discountamount[]" id="discountamount@<?php echo $i; ?>" value="<?php echo $qr['discountamount'];?>" />

		  </td>

 <td  width="10px">&nbsp;</td>

	

	 </tr>
	
	
	 <?php
	  } ?>
	 
</table>
</br>

</br>
<table border="1">
   <tr style="height:20px"></tr>
   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="<?php echo $basicamount; ?>" style="text-align:right; background:none; border:0px;" readonly /></td>
	  <td></td>
	  <td></td>
	  <td></td>
	<td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" value="<?php echo $vehicle; ?>" /></td>
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Amount</strong>&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:right; background:none; border:0px;" value="<?php echo $totalprice; ?>" readonly /></td>

	 <td></td><td></td><td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>

   <td align="left"><input type="text" size="15" name="driver" value = "<?php echo $driver; ?>" /></td>

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

       <td align="left"><strong>Freight Amount</strong></td>
	   
       <td align="left">
	   <input type="text" size="8" name="cfamount" onkeypress="return num1(event.keyCode)" id="cfamount" onkeyup="calnet('dcreate')"  onblur="calnet('dcreate')" value="<?php echo ($freightamount); ?>"  style="text-align:right"/>
	   
	 </td>
	   
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
<table align="center">
<tr>
 <td align="center"><strong>Pay. Mode</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td><td width="10px"></td>
 <td align="center"><strong>Code</strong></td><td width="10px"><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td align="center"><strong>COA Code</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Description</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Dr</strong></td>  
 <td width="10px"></td>
 <td align="center"><strong>Amount</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>  <td width="10px"></td>
 <td align="center"><strong>Cheque</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Cheque Date</strong></td>  
</tr>
 <tr style="height:20px"></tr>
<tr>
<td>
<select id="paymentmode1" name="paymentmode1"  onchange="cashcheque1(this.value);">
<option value="">-Select-</option>
<option value="Cash" <?php if($prows['paymentmode'] == 'Cash') { ?> selected="selected" <?php } ?>>Cash</option>
<option value="Cheque" <?php if($prows['paymentmode'] == 'Cheque') { ?> selected="selected" <?php } ?>>Cheque</option>
<option value="Others" <?php if($prows['paymentmode'] == 'Others') { ?> selected="selected" <?php } ?>>Others</option>
</select>
</td><td width="10px"></td>

<td>
<select id="pcode1" name="pcode1" onchange="loadcodedesc1(this.value)" style="width:120px">
<option value="select">-Select-</option>
<?php
if($prows['paymentmode'] == 'Cash')
{
for($c=0;$c<count($cashcode);$c++)
           {
		     $ccash=explode('@',$cashcode[$c]);
     ?>
	 <option title="<?php echo $ccash[1]; ?>" value="<?php echo $ccash[0];?>"
			 <?php if($ccash[0]==$prows['code']){?> selected="selected"<?php } ?>><?php echo $ccash[0]; ?></option>
     <?php } ?>


	<?php
}
elseif($prows['paymentmode'] == 'Cheque')
{

for($c=0;$c<count($acno);$c++)
           {
		     $acno1=explode('@',$acno[$c]);
     ?>
	 <option title="<?php echo $acno1[1]; ?>" value="<?php echo $acno1[0];?>"
			 <?php if($acno1[0]==$prows['code']){?> selected="selected"<?php } ?>><?php echo $acno1[0]; ?></option>
     <?php } 
	 
}
?>
</select>
</td><td width="10px"></td>
<td><input type="text" id="code11" size="6" name="code11" value="<?php echo $prows['code1']; ?>" readonly/></td><td width="10px"></td>
<td><input type="text" id="pdescription1" size="18" name="pdescription1" value="<?php echo $prows['description']; ?>" readonly/></td><td width="10px"></td>
<td><input type="text" id="dr" name="Dr" size="4" value="Dr" readonly style="background:none; border:0px;" /></td><td width="10px"></td>
<td><input type="text" id="pamount1" name="pamount1" size="10" value="<?php echo $prows['amount']; ?>" style="text-align:right" /></td><td width="10px"></td>
<td><input type="text" id="cheque1" name="cheque1" size="10" <?php if($prows['paymentmode'] == 'Cash') { ?> style="visibility:hidden" <?php } ?>  value="<?php echo $prows['cheque']; ?>" /></td><td width="10px"></td>
<td><input type="text" id="cdate1" name="cdate1" size="10" class="datepicker" <?php if($prows['paymentmode'] == 'Cash') { ?> style="visibility:hidden" <?php } ?>  value="<?php echo date("d.m.Y",strtotime($prows['cdate'])); ?>"/></td><td width="10px"><td><input type="hidden" id="tid1" name="tid1" value="<?php echo $prows['tid']; ?>" /></td></td>
</tr>
</table>	
<br />

<table>
<tr>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $remarks ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</tr></table>
<br />

   <br />
   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=oc_cashsales_ims';">
	
</form>
	</div>

</section>
</center>
	
<script type="text/javascript">


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
document.getElementById('invoice').value="<?php echo $invoice;?>";

}


}



function num1(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
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
myselect1.onchange = function () { selectdesc(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);


// for description start

myselect1 = document.createElement("select");
myselect1.name = "description[]";
myselect1.id = "description@" + index;
myselect1.style.width = "170px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectcode(this.id); };

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







////////// Sixth TD ////////////


mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="price@" + index;
mybox1.name="price[]";
mybox1.style.textAlign = "right";

mybox1.onfocus = function () { makeForm(this.id); };
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
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
mybox1.onchange = function () { calnet(''); };

mybox1.onkeyup = function () {return num1(event.keyCode);  };
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



//var index = -1;
function selectdesc(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("description@" + tempindex).value = document.getElementById("code@" + tempindex).value;
     var w = document.getElementById("description@" + tempindex).selectedIndex; 
     var description = document.getElementById("description@" + tempindex).options[w].text;
     //document.getElementById("description@" + tempindex).value = description;
	var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];  
	
	for(i=1;i<=index;i++)
for(j=1;j<=index;j++)
 {
 
 if((document.getElementById('code@' + i).value==document.getElementById('code@' + j).value)&&(i!=j))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('description@' + tempindex).value="";
 return false;
 
 }
 }
	
	
}

function selectcode(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("code@" + tempindex).value = document.getElementById("description@" + tempindex).value;
     var w = document.getElementById("description@" + tempindex).selectedIndex; 
     var description = document.getElementById("description@" + tempindex).options[w].text;
    // document.getElementById("description@" + tempindex).value = description;

   var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];
	
	for(i=1;i<=index;i++)
for(j=1;j<=index;j++)
 {
 
 if((document.getElementById('description@' + i).value==document.getElementById('description@' + j).value)&&(i!=j))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('description@' + tempindex).value="";
 return false;
 
 }
 }

}


function getcode(cat)
{
 
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var k = temp[1];
	var i,j;
//var code=document.getElementById("code@" + index1).value
	//alert(k);
	 
removeAllOptions(document.getElementById("code@"+k));
	removeAllOptions(document.getElementById("description@"+k));	 


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



function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length;i>0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
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
 if(index==<?php echo $i;?>)
  var index1=index+1;
  else
  index1=index;
 


 for(k = 1;(k <index1);k++)
 {
 	
 	 var tot=0;
 
  	var vat=0;
  	
 var vat = document.getElementById("vat@" + k).value;
var discount =Number(document.getElementById("disc@" + k).value);
 
	
  if(document.getElementById("qtys@" + k).value != "" || document.getElementById("price@" + k).value != "")
   tot1= tot1+ (Number(document.getElementById("qtys@" + k).value) * Number(document.getElementById("price@" + k).value));

   total= total+ (Number(document.getElementById("qtys@" + k).value) * Number(document.getElementById("price@" + k).value));
 

 
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
       var A =(Number(document.getElementById("qtys@" + k).value) * Number(document.getElementById("price@" + k).value));

	   
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
  document.getElementById('discountamount@' + k).value=disc;
  tot1 = tot1 -disc;


 var tot2=tot1;



 }
  
   tot = tot2;
 document.getElementById('basic').value = round_decimals(total,2);
 

 
document.getElementById('totalprice').value = round_decimals(tot1,2);



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



document.getElementById("tpayment").value = round_decimals(tot1,2);





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
function cashcheque1(a)
{
document.getElementById('code11').value = "";
document.getElementById('pdescription1').value = "";

document.getElementById('pcode1').options.length=1;
var code = document.getElementById('pcode1');
document.getElementById('cheque1').style.visibility="hidden";
document.getElementById('cdate1').style.visibility="hidden";

if(a == "Cash")
{

for(var k=0;k<cashcode.length;k++)
	{
		var cashcode1=cashcode[k];
		var cashcode2=cashcode1.split('@');
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode(cashcode2[0]);
		theOption1.value = cashcode2[0];
		theOption1.title = cashcode2[1];
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	}
}
else if(a == "Cheque")
{
document.getElementById('cheque1').style.visibility="visible";
document.getElementById('cdate1').style.visibility="visible";

for(var k=0;k<acno.length;k++)
	{
		var accno=acno[k];
		var acno1=accno.split('@');
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode(acno1[0]);
		theOption1.value = acno1[0];
		theOption1.title =acno1[1];
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	}
}
}


function loadcodedesc1(a)
{
var mode = document.getElementById('paymentmode1').value;
document.getElementById('code11').value = "";
document.getElementById('pdescription1').value = "";
if(a== "")
return;

 
for(var i=0;i<rcode.length;i++)
{
  var rcode2=rcode[i];
  rcode1=rcode2.split('@');
  if(mode=="Cash")
  {
    if(a==rcode1[0])
	{
	  document.getElementById('code11').value =rcode1[2];
	 }
  }
  else if(mode=='Cheque')
  {
    if(a==rcode1[1])
	{
	  document.getElementById('code11').value =rcode1[2];
	 }
  }
  
 } 
 


for(var d=0;d<cocode.length;d++)
{
   var cocode2=cocode[d];
   coa=cocode2.split('@');
   if(document.getElementById('code11').value == coa[0]) 
   {
   document.getElementById('pdescription1').value = coa[1];
   }
     
}




}
function checkcoa()
{


<?php if($_SESSION['db']=="mew")
	{?>	
var memp=document.getElementById('memp').value;

if(memp=="")
{
	alert("Select Marketing Employee");
	return false;

}
<?php } ?>


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
	
	
	
	
	
	

var a=Number(document.getElementById('pamount1').value);

if(a==0)
{

alert("Please enter the amount");
			document.getElementById('pamount1').focus();
			return false;


}

var b=Number(document.getElementById('tpayment').value);

if(a!=b)
		{
		   alert("Please enter the appropriate amount");
			document.getElementById('pamount1').focus();
			return false;
		}	
document.getElementById('save').disabled=true;
	
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