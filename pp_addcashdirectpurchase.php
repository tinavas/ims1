<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$client = $_SESSION['client'];

$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $sobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sobiincr = $row1['sobiincr']; 
$sobiincr = $sobiincr + 1;
if ($sobiincr < 10) 
$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;
?>


<section class="grid_8">
  <div class="block-border">
  														<!-- For CENTRAL DB THE ACTION WILL BE PP_SAVEDIRECTPURCHASEC.PHP -->
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savecashdirectpurchase.php" onsubmit="return checkcoa();">
		<input type="hidden" name="sobiincr" id="sobiincr" value="<?php echo $sobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		
		<input type="hidden" name="discountamount" id="discountamount" value="0"/>
	 
	  <h1>Cash Purchase</h1>
		<br /><br />
            <table align="center">
              <tr>
             
                <td><strong>Date</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" onchange="getsobi();"></td>
                <td width="5px"></td>

                <td><strong>Vendor</strong></td>
                <td>&nbsp;
					<select id="vendor" name="vendor" style="width:175px" <?php if($_SESSION['db'] == 'central') { ?> onchange="fvalidatecurrency();" <?php } ?>>
					<option>-Select-</option>
					<?php
							$q = "select distinct(name) from contactdetails where type = 'vendor' OR type = 'vendor and party' order by name";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
					?>
					<option title="<?php echo $qr['name']; ?>" value="<?php echo $qr['name'];?>"><?php echo $qr['name']; ?></option>
					<?php   }   ?>
					</select>
				</td>
                <td width="5px"></td>

                <td><strong>Invoice</strong></td>
                <td width="15px"></td>
                <td>&nbsp;<input type="text" size="19" style="background:none;border:none;" id="invoice" name="invoice" value="<?php echo $sobi; ?>" readonly /></td>
				
				<td width="5px"></td>
				
                <td><strong>Book&nbsp;Invoice</strong></td>
				<td width="5px"></td>
                <td>&nbsp;
					<input type="text" size="12" id="bookinvoice" name="bookinvoice" value=""></td>
                <td width="5px"></td>
                <td><strong>Credit&nbsp;Term</strong></td>
				<td width="5px"></td>
                <td>
					<select id="cterm" name="cterm">
					<option value="0@0@0">-Select-</option>
					<?php
					$query = "SELECT * FROM ims_creditterm ORDER BY value";
					$result = mysql_query($query,$conn) or die(mysql_error());
					while($rows = mysql_fetch_assoc($result))
					{
					 ?>
					 <option value="<?php echo $rows['code']."@".$rows['description']."@".$rows['value']; ?>"><?php echo $rows['code']; ?></option>
					 <?php
					}
					?>
					</select>
					</td>
				
              </tr>
            </table>
<br /><br />			

<center>
 <table border="0" id="table-po">
     <tr>
<th><strong>Category</strong></th><td width="10px">&nbsp;</td>
<th><strong>Code</strong></th><td width="10px">&nbsp;</td>
<th><strong>Description</strong></th><td width="10px">&nbsp;</td>
<th><strong>Units</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty Sent</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty Received</strong></th><td width="10px">&nbsp;</td>
<th><strong>Type</strong></th><td width="10px">&nbsp;</td>
<th><strong>Bags<?php if($_SESSION['db'] == 'golden' || $_SESSION['db'] == 'mlcf' || $_SESSION['db'] == "mbcf" || $_SESSION['db']=='ncf') { ?>/ <br />Numbers<?php } else {?> / <br/> Boxes <?php }?></strong></th><td width="10px">&nbsp;</td>
<th><strong>Price<br />/Unit</strong></th><td width="10px">&nbsp;</td>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
<th><strong>M.R.P</strong></th><td width="10px">&nbsp;</td>
<?php
}
?>

<th <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?> >&nbsp;&nbsp;&nbsp;<strong>VAT</strong></th><td <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?> width="10px">&nbsp;</td>
<th>&nbsp;&nbsp;&nbsp;<strong>Warehouse</strong></th><td width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:100px" name="cat[]" id="cat@-1" onchange="getcode(this.id);">
     <option>-Select-</option>
     <?php 
	     $query = "SELECT distinct(type) FROM ims_itemtypes ORDER BY type ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <option value="<?php echo $row['type'];?>"><?php echo $row['type']; ?></option>
     <?php } ?>
</select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<select style="Width:75px" name="code[]" id="code@-1" onchange="selectdesc(this.id);">
     		<option value="">-Select-</option>
			</select>
       </td>
<td width="10px">&nbsp;</td><td>
<select style="Width:140px" name="desc[]" id="desc@-1" onchange="selectcode(this.id);">
     		<option>-Select-</option>
</select>
<input type="hidden" size="15" id="description@-1" name="description[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" style="text-align:right;" id="qtys@-1" name="qtys[]" value="" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" id="qtyr@-1" style="text-align:right;" name="qtyr[]" value="" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td><td>
<select style="Width:80px" name="bagtype[]" id="bagtype@-1" <?php if($_SESSION['db'] == 'golden' || $_SESSION['db']=='mlcf' || $_SESSION['db']=='mbcf' || $_SESSION['db']=='ncf') { ?> onchange="calnet('');" <?php } ?>  >
	<option value="">-Select-</option>

     <?php 
	     $query1 = "SELECT * FROM ims_itemcodes WHERE type = 'Packing Material' ORDER BY code ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
             <option title="<?php echo $row1['description'] . "@" . $row1['sunits']; ?>" value="<?php echo $row1['code'];?>"><?php echo $row1['code']; ?></option>
     <?php } ?>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="3" id="bags@-1" style="text-align:right;" name="bags[]" value="0"  />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="price@-1" style="text-align:right;" name="price[]" value="" onfocus="makeForm();" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="mrp@-1" style="text-align:right;" name="mrp[]" value="" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<?php
}
?>

<td width="10px">&nbsp;</td><td <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?>>
<select style="width:60px" name="vat[]" id="vat@-1" onchange="calnet('');">
     <option value="0">None</option>
     <?php 
	     $query = "SELECT distinct(code),codevalue FROM ims_taxcodes where (taxflag = 'P') ORDER BY codevalue ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <option value="<?php echo $row['codevalue'];?>"><?php echo $row['code']; ?></option>
     <?php } ?>
</select>

</td>
 <td <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?> width="10px">&nbsp;</td><td> 
<select id="flock@-1" name="flock[]" style="width:120px" <?php if($_SESSION['db'] == 'feedatives'){ ?> onchange="getfarm(this.id,this.value)" <?php } ?>>
<option value="">-Select-</option>
<?php

/*if($_SESSION['db'] == "feedatives")
{

if($_SESSION['sectorr'] == "all")
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and place = '$sectorr' order by sector";
		   }
}
else
{
$q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
}
*/

    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }

 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
<option value="<?php echo $row1['sector']; ?>" <?php if($n1 == 1) { ?>selected=selected<?php } ?>><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>
<input type="hidden" id="taxamount@-1" name="taxamount[]" value="0" />
</td>
    </tr>
   </table>
   <br /> 
 </center>

<br />			
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
<table id="batchexp" style="display:none" align="center">
 <tr>
   <td align="center"><strong>Code</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Description</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Batch No.</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Expiry Date</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Type</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Flock</strong></td> 
 </tr>
 <tr id="batchexprow@-1">
  <td><input type="text" id="code2@-1" size="8" readonly /></td><td width="10px">&nbsp;</td>
  <td><input type="text" id="desc2@-1" size="15" readonly /></td><td width="10px">&nbsp;</td>
  <td><input type="text" id="batch@-1" name="batch[]" size="10"/></td><td width="10px">&nbsp;</td>
  <td><input class="datepicker" type="text" size="15" id="expdate@-1" name="expdate[]"></td><td width="10px">&nbsp;</td>
  
<td><select id="type@-1" name="type[]" style="width:100px"  onChange="changetype(this.id,this.value)">
<option value="Existing">Existing</option>
<option value="New">New</option>
</select></td>
<td width="10px">&nbsp;</td>
<td><input type="text" name="aflock[]" id="aflock@-1" size="14"  style="display:none" onBlur="checkFlock(this.value,this.id);" />
<select name="existflock[]" id="existflock@-1" style="width:100px">
<option value="">-Select-</option>
</td>


  </tr>
</table>
<?php
}
?>
<center>
<table border="1">
   <tr style="height:20px"></tr>
   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="0" style="text-align:right" readonly /></td>
      <td align="right"><strong>Discount &nbsp;</strong>
           <input type="radio" id="disper" name="discount" checked="true" onclick="calnet('dcreate')" /><strong>%</strong>&nbsp;<input type="radio" id="disper1" name="discount" onclick="calnet('dcreate')" /> <strong>Amt</strong></td><td>
      <input type="text" size="6" id="disamount" name="disamount" value="0" style="text-align:right" onkeyup="calnet('dcreate')" /></td>
      <td align="right"><strong>&nbsp;Broker&nbsp;Name</strong>&nbsp;&nbsp;</td>
      <td align="left"><select style="Width:120px" name="broker" id="broker"><option value="">-Select-</option>
           <?php $query = "SELECT distinct(name) FROM contactdetails where type = 'broker' ORDER BY name ASC"; $result = mysql_query($query,$conn);
                 while($row = mysql_fetch_assoc($result)){ ?>
           <option value="<?php echo $row['name'];?>" > <?php echo $row['name']; ?></option>
                <?php } ?></select></td>
      <td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" /></td>
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Price</strong>&nbsp;&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:right" value="0" readonly/></td>
   <td></td><td></td><td></td><td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>
   <td align="left"><input type="text" size="15" name="driver" /></td>

  </tr>
  <tr style="height:20px"></tr>
  <tr style="height:20px"></tr>
   <tr>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select name="freighttype" id="freighttype" onchange="calnet('dcreate')"><option value="Included">Included</option><option value="Excluded">Excluded</option></select></td>

       <td align="right" style="width:150px"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><input type="text" size="8" name="cfamount" id="cfamount" onkeyup="calnet('dcreate')" value="0" style="text-align:right"/>
	   &nbsp;&nbsp;</td><td>
	   <select id="coa" name="coa" style="width:80px">
	   <option value="">-Select-</option>
	   <?php 
	   		$q = "select distinct(code),description from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSES' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
	   ?>
	   <option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
	   <?php } ?>
	   </select>
	   </td>
       <td align="right"><strong>Via</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select style="Width:80px" name="cvia" id="cvia" onchange="loadcodes(this.value);"><option value="">-Select-</option><option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="Others">Others</option></select></td>
	  <td align="right" id="cashbankcodetd1" style="display:none"><strong><span id="codespan">Code</span></strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="cashbankcodetd2" style="display:none">
		<select name="cashbankcode" id="cashbankcode" style="width:125px">
		<option value="">-Select-</option>
		</select>
		</td>

</tr>
<tr style="height:20px"></tr>
<tr>
<td></td><td></td><td></td><td></td>
	  <td align="right" id="chequetd1" style="visibility:hidden"><strong>Cheque</strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="chequetd2" style="visibility:hidden">
		<input type="text" name="cheque" id="cheque" size="15">
		</td>

       <td align="right" id="datedtd1" style="display:none"><strong>Dated</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left" id="datedtd2" style="display:none"><input type="text" size="15" id="cdate" class="datepicker" name="cdate" value="<?php echo date("d.m.Y"); ?>" /></td>


</tr>
  <tr style="height:20px"></tr>
<tr>
	  <td align="right"><strong>&nbsp;Grand&nbsp;Total</strong>&nbsp;&nbsp;</td>
        <td align="left"><input type="text" size="12" name="tpayment" id="tpayment" value="0" readonly style="text-align:right"/></td>
</tr>
<tr style="height:20px"></tr>
</table>


<table align="center">  
<tr>
 <td align="center"><strong>Pay. Mode</strong></td><td width="10px"></td>
 <td align="center"><strong>Code</strong></td><td width="10px"></td>
 <td align="center"><strong>COA Code</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Description</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Cr</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Amount</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Cheque</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Cheque Date</strong></td>  
</tr>
 <tr style="height:20px"></tr>
<tr>
<td>
<select id="paymentmode1" name="paymentmode1"  onchange="cashcheque1(this.value);">
<option value="">-Select-</option>
<option value="Cash" selected="selected">Cash</option>
<option value="Cheque">Cheque</option>
<option value="Others">Others</option>
</select>
</td><td width="10px"></td>
<td>
<select id="pcode1" name="pcode1" onchange="loadcodedesc1(this.value)" style="width:120px">
<option value="select">-Select-</option>
<?php
	$i = 0;
	$code1 = $desc = "";
	$q = "select distinct(code),name from ac_bankmasters where mode = 'Cash' and client = '$client'  order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	 if($i == 0)
	 {
		$q1 = "select code,acno,coacode from ac_bankmasters where code = '$qr[code]' AND client = '$client'  order by coacode";
		$qrs1 = mysql_query($q1) or die(mysql_error());
		$qr1 = mysql_fetch_assoc($qrs1);
		$code1 = $qr1['coacode'];
		$q1 = "select distinct(description) from ac_coa where code = '$code1' and client = '$client'  order by description";
		$qrs1 = mysql_query($q1) or die(mysql_error());
		$qr1 = mysql_fetch_assoc($qrs1);
		$desc = $qr1['description'];		
	 }
	?>
	<option value="<?php echo $qr['code']; ?>" title="<?php echo $qr['name']; ?>" <?php if($i == 0) { ?> selected="selected" <?php } ?>><?php echo $qr['code']; ?></option>
	<?php
	$i++;
	}	
?>
</select>
  </td><td width="10px"></td>
<td><input type="text" id="code11" size="6" name="code11" value="<?php echo $code1; ?>" readonly /></td><td width="10px"></td>
<td><input type="text" id="pdescription1" size="18" name="pdescription1" value="<?php echo $desc; ?>" readonly /></td><td width="10px"></td>
<td><input type="text" id="cr" name="cr" size="4" value="Cr" readonly/></td><td width="10px"></td>
<td><input type="text" id="pamount1" name="pamount1" size="10" value="0" style="text-align:right"/></td><td width="10px"></td>
<td><input type="text" id="cheque1" name="cheque1" size="10" /></td><td width="10px"></td>
<td><input type="text" id="cdate1" name="cdate1" size="10" class="datepicker" value="<?php echo date("d.m.Y");?>"/></td>
</tr> 
 
 <tr style="height:10px"></tr>

<tr>
<td>
<select id="paymentmode2" name="paymentmode2"  onchange="cashcheque2(this.value);">
<option value="">-Select-</option>
<option value="Cash">Cash</option>
<option value="Cheque" selected="selected">Cheque</option>
<option value="Others">Others</option>
</select>
</td><td width="10px"></td>
<td>
<select id="pcode2" name="pcode2" onchange="loadcodedesc2(this.value)" style="width:120px">
<option value="select">-Select-</option>
<?php
	$i = 0;
	$code1 = $desc = "";
	$q = "select distinct(acno),name from ac_bankmasters where mode = 'Bank' and client = '$client'  order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	 if($i == 0)
	 {
		$q1 = "select code,acno,coacode from ac_bankmasters where acno = '$qr[acno]' AND client = '$client'  order by coacode";
		$qrs1 = mysql_query($q1) or die(mysql_error());
		$qr1 = mysql_fetch_assoc($qrs1);
		$code2 = $qr1['coacode'];
		$q1 = "select distinct(description) from ac_coa where code = '$code2' and client = '$client'  order by description";
		$qrs1 = mysql_query($q1) or die(mysql_error());
		$qr1 = mysql_fetch_assoc($qrs1);
		$desc2 = $qr1['description'];		
	 }
	?>
	<option value="<?php echo $qr['acno']; ?>" title="<?php echo $qr['name']; ?>" <?php if($i == 0) { ?> selected="selected" <?php } ?>><?php echo $qr['acno']; ?></option>
	<?php
	$i++;
	}	
?>
</select>
  </td><td width="10px"></td>
<td><input type="text" id="code12" size="6" name="code12" value="<?php echo $code2; ?>" readonly/></td><td width="10px"></td>
<td><input type="text" id="pdescription2" size="18" name="pdescription2" value="<?php echo $desc2; ?>" readonly/></td><td width="10px"></td>
<td><input type="text" id="cr" name="cr" size="4" value="Cr" readonly/></td><td width="10px"></td>
<td><input type="text" id="pamount2" name="pamount2" size="10" value="0" style="text-align:right"/></td><td width="10px"></td>
<td><input type="text" id="cheque2" name="cheque2" size="10" /></td><td width="10px"></td>
<td><input type="text" id="cdate2" name="cdate2" size="10" class="datepicker" value="<?php echo date("d.m.Y");?>"/></td>
</tr> 
 <tr height="20px"></tr>
</table>



<div id="validatecurrency"></div><br>	
<center>	
<br />
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
</center>
<br />

   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_cashdirectpurchase';">
</center>


						
</form>
</div>
</section>
<div class="clear">
</div>
<br />

<script type="text/javascript">

function cashcheque1(a)
{
document.getElementById('code11').value = "";
document.getElementById('pdescription1').value = "";

removeAllOptions(document.getElementById('pcode1'));
var code = document.getElementById('pcode1');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "select";
theOption1.appendChild(theText1);
code.appendChild(theOption1);

if(a == "Cash")
{
//document.getElementById('codename').innerHTML = "Cash Code";
<?php 
	$q = "select distinct(code),name from ac_bankmasters where mode = 'Cash' and client = '$client'  order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['code']; ?>";
theOption1.title = "<?php echo $qr['name']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
else if(a == "Cheque")
{
//document.getElementById('codename').innerHTML = "Bank A/C No.";

<?php 
	$q = "select distinct(acno),name from ac_bankmasters where mode = 'Bank' and client = '$client'  order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['acno']; ?>";
theOption1.title = "<?php echo $qr['name']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
}


function loadcodedesc1(a)
{

var mode = document.getElementById('paymentmode1').value;
document.getElementById('code11').value = "";
document.getElementById('pdescription1').value = "";
if(a== "")
return;
<?php 
$q = "select code,acno,coacode from ac_bankmasters where client = '$client'  order by coacode";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo " if( mode == 'Cash') { ";
echo " if(a == '$qr[code]') { ";
?>
document.getElementById('code11').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } else if( mode == 'Cheque') { ";
echo " if(a == '$qr[acno]') { ";
?>
document.getElementById('code11').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } ";
}
?>

<?php 
$q1 = "select distinct(code) from ac_coa where client = '$client' order by code";
$q1rs = mysql_query($q1) or die(mysql_error());
while($q1r = mysql_fetch_assoc($q1rs))
{
echo "if(document.getElementById('code11').value == '$q1r[code]') { ";

$q = "select distinct(description) from ac_coa where code = '$q1r[code]' and client = '$client'  order by description";
$qrs = mysql_query($q) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
?>
document.getElementById('pdescription1').value = "<?php echo $qr['description']; ?>";
<?php
}
echo " } ";
}
?>
}


function cashcheque2(a)
{
document.getElementById('code12').value = "";
document.getElementById('pdescription2').value = "";

removeAllOptions(document.getElementById('pcode2'));
var code = document.getElementById('pcode2');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "select";
theOption1.appendChild(theText1);
code.appendChild(theOption1);

if(a == "Cash")
{
//document.getElementById('codename2').innerHTML = "Cash Code";
<?php 
	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client'  order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['code']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
else if(a == "Cheque")
{
//document.getElementById('codename2').innerHTML = "Bank A/C No.";

<?php 
	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' and client = '$client'  order by acno";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['acno']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
}


function loadcodedesc2(a)
{

var mode = document.getElementById('paymentmode2').value;
document.getElementById('code12').value = "";
document.getElementById('pdescription2').value = "";
if(a== "")
return;
<?php 
$q = "select code,acno,coacode from ac_bankmasters where client = '$client'  order by coacode";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo " if( mode == 'Cash') { ";
echo " if(a == '$qr[code]') { ";
?>
document.getElementById('code12').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } else if( mode == 'Cheque') { ";
echo " if(a == '$qr[acno]') { ";
?>
document.getElementById('code12').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } ";
}
?>

<?php 
$q1 = "select distinct(code) from ac_coa where client = '$client' order by code";
$q1rs = mysql_query($q1) or die(mysql_error());
while($q1r = mysql_fetch_assoc($q1rs))
{
echo "if(document.getElementById('code12').value == '$q1r[code]') { ";

$q = "select distinct(description) from ac_coa where code = '$q1r[code]' and client = '$client'  order by description";
$qrs = mysql_query($q) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
?>
document.getElementById('pdescription2').value = "<?php echo $qr['description']; ?>";
<?php
}
echo " } ";
}
?>
}


function fvalidatecurrency(a)
{
 var date = document.getElementById('date').value;
 var vendor = document.getElementById('vendor').value;
 var tdata = date + "@" + vendor + "@vendor";
 getdiv('validatecurrency',tdata,'pp_currencyframe.php?data=');
}

function getsobi()
{

  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var sobiincr = new Array();
    var sobi = "";
	var code = "<?php echo $code; ?>";
  <?php 
   
   $query1 = "SELECT MAX(sobiincr) as sobiincr,m,y FROM pp_sobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1) or die(mysql_error());
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     sobiincr[<?php echo $k; ?>] = <?php if($row1['sobiincr'] < 0) { echo 0; } else { echo $row1['sobiincr']; } ?>;

<?php $k++; } ?>
for(var l = 0; l <= <?php echo $k; ?>;l++)
{

 if((yea[l] == y) && (mon[l] == m))
  { 
   if(sobiincr[l] < 10)
     sobi = 'SOBI'+'-'+m+y+'-000'+parseInt(sobiincr[l]+1)+code;
   else if(sobiincr[l] < 100 && sobiincr[l] >= 10)
     sobi = 'SOBI'+'-'+m+y+'-00'+parseInt(sobiincr[l]+1)+code;
   else
     sobi = 'SOBI'+'-'+m+y+'-0'+parseInt(sobiincr[l]+1)+code;
     document.getElementById('sobiincr').value = parseInt(sobiincr[l] + 1);
  break;
  }
 else
  {
   sobi = 'SOBI' + '-' + m + y + '-000' + parseInt(1)+code;
   document.getElementById('sobiincr').value = 1;
  }
}
document.getElementById('invoice').value = sobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;
<?php if($_SESSION['db'] == 'central') { ?>
fvalidatecurrency();
<?php } ?>
}

function loadcodes(via)
{
removeAllOptions(document.getElementById('cashbankcode'));
var code = document.getElementById('cashbankcode');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
code.appendChild(theOption1);
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

	<?php 
		$q = "select distinct(code),name from ac_bankmasters where mode = 'Cash' order by code";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
	?>
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("<?php echo $qr['code']; ?>");
		theOption1.value = "<?php echo $qr['code']; ?>";
		theOption1.title = "<?php echo $qr['name']; ?>";
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	<?php } ?>
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


	<?php 
		$q = "select distinct(acno),name,code from ac_bankmasters where mode = 'Bank' order by acno";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
	?>
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
		theOption1.value = "<?php echo $qr['code']; ?>";
		theOption1.title = "<?php echo $qr['name']; ?>";
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	<?php } ?>
}
}
var index = -1;
function selectdesc(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("desc@" + tempindex).value = document.getElementById("code@" + tempindex).value;
     var w = document.getElementById("desc@" + tempindex).selectedIndex; 
     var description = document.getElementById("desc@" + tempindex).options[w].text;
     document.getElementById("description@" + tempindex).value = description;

     var code1 = document.getElementById("code@" + tempindex).value;
	 var t = code1.split("@");
	 document.getElementById('units@' + tempindex).value = t[1];
	<?php 
		/*	$q = "select distinct(code) from ims_itemcodes where source = 'Purchased' or source = 'Produced or Purchased' order by code";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				//document.getElementById('units@' + tempindex).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}*/
	?>

<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
document.getElementById("code2@" + tempindex).value = document.getElementById("code@" + tempindex).value;
document.getElementById("desc2@" + tempindex).value = document.getElementById("description@" + tempindex).value;
var c = document.getElementById("code@" + tempindex).value;
removeAllOptions(document.getElementById('flock@'+tempindex));
myselect1 = document.getElementById('flock@' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
//myselect1.name = "flock[]";

if(c == 'CON108' || c == 'CON110' || c == 'CON111' || c == 'CON112' || c == 'CON113' || c == 'CON114' || c == 'CON115' || c == 'CON116' || c == 'CON117')
{

	<?php
	/*if($_SESSION['sectorr'] == 'all')
	 $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC;";
	else
	 $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND place = '".$_SESSION['sectorr']."' ORDER BY FARM ASC"; */
	 
	 
	  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		    $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC;";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND place IN ($sectorlist) ORDER BY FARM ASC"; 
		   }
	 
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1= mysql_fetch_assoc($result1))
	{
	?>
	theOption1=document.createElement("OPTION");
	theText1=document.createTextNode("<?php echo $rows1['farm']; ?>");
	theOption1.value = "<?php echo $rows1['farm']; ?>";
	theOption1.title = "<?php echo $rows1['farm']; ?>";
	theOption1.appendChild(theText1);
	myselect1.appendChild(theOption1);
	<?php
	}
	?>
}
else
{
<?php
			/*if($_SESSION['sectorr'] == "all")
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and place = '$sectorr' order by sector";
		   }*/
		   
		    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		    $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
		   
		   
		   	$result1 = mysql_query($q1,$conn) or die(mysql_error());
			while($rows1= mysql_fetch_assoc($result1))
			{
			?>
			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $rows1['sector']; ?>");
			theOption1.value = "<?php echo $rows1['sector']; ?>";
			theOption1.title = "<?php echo $rows1['sector']; ?>";
			theOption1.appendChild(theText1);
			myselect1.appendChild(theOption1);

			<?php
			}


  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		    $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC;";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND place IN ($sectorlist) ORDER BY FARM ASC"; 
		   }
	 
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1= mysql_fetch_assoc($result1))
	{
	?>
	theOption1=document.createElement("OPTION");
	theText1=document.createTextNode("<?php echo $rows1['farm']; ?>");
	theOption1.value = "<?php echo $rows1['farm']; ?>";
	theOption1.title = "<?php echo $rows1['farm']; ?>";
	theOption1.appendChild(theText1);
	myselect1.appendChild(theOption1);
	<?php
	}
	?>
}
<?php
}
?>
}
function selectcode(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("code@" + tempindex).value = document.getElementById("desc@" + tempindex).value;
     var w = document.getElementById("desc@" + tempindex).selectedIndex; 
     var description = document.getElementById("desc@" + tempindex).options[w].text;
     document.getElementById("description@" + tempindex).value = description;

     var code1 = document.getElementById("code@" + tempindex).value;
	 var t = code1.split("@");
	 document.getElementById('units@' + tempindex).value = t[1];
	<?php /*
			$q = "select distinct(code) from ims_itemcodes where source = 'Purchased' or source = 'Produced or Purchased' order by code";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('units@' + tempindex).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}*/
	?>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
document.getElementById("code2@" + tempindex).value = document.getElementById("code@" + tempindex).value;
document.getElementById("desc2@" + tempindex).value = document.getElementById("description@" + tempindex).value;
var c = document.getElementById("code@" + tempindex).value;
removeAllOptions(document.getElementById('flock@'+tempindex));
myselect1 = document.getElementById('flock@' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
//myselect1.name = "flock[]";

if(c == 'CON108' || c == 'CON110' || c == 'CON111' || c == 'CON112' || c == 'CON113' || c == 'CON114' || c == 'CON115' || c == 'CON116' || c == 'CON117')
{

	<?php
	/*if($_SESSION['sectorr'] == 'all')
	 $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC;";
	else
	 $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND place = '".$_SESSION['sectorr']."' ORDER BY FARM ASC"; */
	 
	 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC;";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		      $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND place In ($sectorlist) ORDER BY FARM ASC"; 
	 
		   }
	 
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1= mysql_fetch_assoc($result1))
	{
	?>
	theOption1=document.createElement("OPTION");
	theText1=document.createTextNode("<?php echo $rows1['farm']; ?>");
	theOption1.value = "<?php echo $rows1['farm']; ?>";
	theOption1.title = "<?php echo $rows1['farm']; ?>";
	theOption1.appendChild(theText1);
	myselect1.appendChild(theOption1);
	<?php
	}
	?>
}
else
{
<?php
			/*if($_SESSION['sectorr'] == "all")
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and place = '$sectorr' order by sector";
		   }*/
		   
		    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
		   
		   	$result1 = mysql_query($q1,$conn) or die(mysql_error());
			while($rows1= mysql_fetch_assoc($result1))
			{
			?>
			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $rows1['sector']; ?>");
			theOption1.value = "<?php echo $rows1['sector']; ?>";
			theOption1.title = "<?php echo $rows1['sector']; ?>";
			theOption1.appendChild(theText1);
			myselect1.appendChild(theOption1);

			<?php
			}

  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		    $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC;";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $query1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND place IN ($sectorlist) ORDER BY FARM ASC"; 
		   }
	 
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1= mysql_fetch_assoc($result1))
	{
	?>
	theOption1=document.createElement("OPTION");
	theText1=document.createTextNode("<?php echo $rows1['farm']; ?>");
	theOption1.value = "<?php echo $rows1['farm']; ?>";
	theOption1.title = "<?php echo $rows1['farm']; ?>";
	theOption1.appendChild(theText1);
	myselect1.appendChild(theOption1);
	<?php
	}
	?>
}

<?php
}
?>	
}

var index = -1;

function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;
	
	
	<!--document.getElementById('flock@' + index1).style.display = "none";-->
	if((cat1 == "Broiler Birds") || (cat1 == "Broiler Chicks") || (cat1 == "Broiler Day Old Chicks") || (cat1 == "Broiler Feed") || (cat1 == "Native Feed") || (cat1 == "Native Chicks") || (cat1 == "Native Birds"))
	{
	//document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";


myselect1.id = "flock@" + index;
myselect1.style.width = "120px";

<?php 
/* if($_SESSION['db'] == "feedatives")
{

if($_SESSION['sectorr'] == "all")
		   {
		  $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and place = '$sectorr' order by sector";
		   }
}
else
{
$q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center' order by sector";
}
*/


  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.title = "<?php echo $row1['sector']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php } ?>
<?php 
/*if($_SESSION['db'] == "feedatives")
{

if($_SESSION['sectorr'] == "all")
		   {
		  $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm ORDER BY farm ASC";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		    $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm where place = '$sectorr' ORDER BY farm ASC";
		   }
}
else
{
 $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm ORDER BY farm ASC";
}*/


 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		  $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm ORDER BY farm ASC";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		    $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm where place IN ($sectorlist) ORDER BY farm ASC";
		   }
	    
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['farm']; ?>");
theOption1.value = "<?php echo $row1['farm']; ?>";
theOption1.title = "<?php echo $row1['farm']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>
}

	else if(cat1 == "Layer Birds")
	{
	//document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";


myselect1.id = "flock@" + index;
myselect1.style.width = "120px";

<?php 
 $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.title = "<?php echo $row1['sector']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php } ?>
<?php 
	     $query1 = "SELECT distinct(flockcode) as 'flock' FROM layer_flock ORDER BY flockcode ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['flock']; ?>");
theOption1.value = "<?php echo $row1['flock']; ?>";
theOption1.title = "<?php echo $row1['flock']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>
}




else if((cat1 == "Female Birds") || (cat1 == "Male Birds"))
	{
	//document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";


myselect1.id = "flock@" + index;
myselect1.style.width = "120px";

<?php 
/*?>if($_SESSION['db'] == "feedatives")
{

if($_SESSION['sectorr'] == "all")
		   {
		  $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and place = '$sectorr' order by sector";
		   }
}
else
{
$q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center' order by sector";
}

 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.title = "<?php echo $row1['sector']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php } <?php */?>
<?php 

	     $query1 = "SELECT distinct(flockcode)  FROM breeder_flock WHERE client = '$client' and cullflag='0' ORDER BY flockcode ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['flockcode']; ?>");
theOption1.value = "<?php echo $row1['flockcode']; ?>";
theOption1.title = "<?php echo $row1['flockcode']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>
}
else 
	{	
	
	//document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";


myselect1.id = "flock@" + index;
myselect1.style.width = "120px";

<?php 
/*if($_SESSION['db'] == "feedatives")
{

if($_SESSION['sectorr'] == "all")
		   {
		  $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and place = '$sectorr' order by sector";
		   }
}
else
{
$q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center' order by sector";
}*/

 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse'  order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }


 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.title = "<?php echo $row1['sector']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>
}	

	
	removeAllOptions(document.getElementById('code@' + index1));
			  var code = document.getElementById('code@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              code.appendChild(theOption1);
	removeAllOptions(document.getElementById('desc@' + index1));  
			var description = document.getElementById('desc@' + index1); 
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);

	<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";
			$q1 = "select distinct(code),description,sunits from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
        theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['code'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['code']."@".$q1r['sunits'];?>";
	          theOption1.title = "<?php echo $q1r['description'];?>";
              code.appendChild(theOption1);

		 	  theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['description'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['code']."@".$q1r['sunits'];?>";
	          theOption1.title = "<?php echo $q1r['description'];?>";
              description.appendChild(theOption1);
			  
			  <?php } 
			echo "}";
			}
	?>

<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
if(cat1 == 'Medicines' || cat1 == 'Vaccines' || cat1 == 'Broiler Chicks')
{
 document.getElementById("batchexp").style.display = "block";
 document.getElementById("batchexprow@" + index1).style.display = "block";
}
else
{
 document.getElementById("code2@"+index1).value = "";
 document.getElementById("desc2@"+index1).value = "";
 document.getElementById("batch@"+index1).value = "";
 document.getElementById("expdate@"+index1).value = "";
 document.getElementById("batchexprow@" + index1).style.display = "none";
}
<?php
}
?>

<?php
if($_SESSION['client'] == 'KEHINDE')
{
?>
if(cat1 == 'Turkey Female Birds' || cat1 == 'Turkey Male Birds'|| cat1 == 'Turkey Female Feed'|| cat1 == 'Turkey Male Feed'|| cat1 == 'Turkey Hatch Eggs'|| cat1 == 'Turkey Eggs')
{
removeAllOptions(document.getElementById('flock@' + index1));
myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";

myselect1.id = "flock@" + index;
myselect1.style.width = "120px";
<?php
$query1 = "SELECT distinct(flockcode)  FROM turkey_flock WHERE client = '$client' and cullflag='0' ORDER BY flockcode ASC";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $rows1['flockcode']; ?>");
theOption1.value = "<?php echo $rows1['flockcode']; ?>";
theOption1.title = "<?php echo $rows1['flockcode']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php
}
?>
}
<?php
}
?>


if(cat1 == 'Hatch Eggs')
{

removeAllOptions(document.getElementById('flock@' + index1));
myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";

myselect1.id = "flock@" + index;
myselect1.style.width = "120px";
<?php
$query1 = "SELECT * FROM tbl_sector WHERE type1='Hatchery' or type1='Cold Room' order by sector";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $rows1['sector']; ?>");
theOption1.value = "<?php echo $rows1['sector']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php
}
?>
}



<?php
if($_SESSION['db'] == 'golden')
{
?>

//var category = document.getElementById(category).value;
if(cat1 == 'Medicines' || cat1 == 'Vaccines')
{
 var myselect1 = document.getElementById("bagtype@"+index1);
 removeAllOptions(document.getElementById("bagtype@"+index1));
 
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "select";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
 
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Numbers");
theOption1.value = "numbers";
theOption1.title = "Numbers";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
 
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Kgs");
theOption1.value = "kgs";
theOption1.title = "Kgs";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
}
else
{
 var myselect1 = document.getElementById("bagtype@"+index1);
 removeAllOptions(document.getElementById("bagtype@"+index1));
 
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "select";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
	<?php
	$query = "SELECT * FROM ims_itemcodes WHERE type = 'Packing Material' ORDER BY code ASC";
	$result = mysql_query($query,$conn) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	?>	 
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("<?php echo $rows['code']; ?>");
		theOption1.value = "<?php echo $rows['code']; ?>";
		theOption1.title = "<?php echo $rows['description']."@".$rows['sunits']; ?>";
		theOption1.appendChild(theText1);
		myselect1.appendChild(theOption1);
	<?php
	}
	?>	
		
}
<?php
}
?>


}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


function makeForm() 
{
if(index== -1)
{
makeForm1();
}
else 
{
var ind= index-1;
if(document.getElementById('price@'+ind).value != "")
{
makeForm1();
}
}
}
function makeForm1() 
{

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
<?php if($_SESSION['tax']==0) { ?> etd9.style.display="none"; <?php } ?>
etd9.width = "10px";
theText1=document.createTextNode('\u00a0');
etd9.appendChild(theText1);

var etd10 = document.createElement('td');
etd10.width = "10px";
theText1=document.createTextNode('\u00a0');
etd10.appendChild(theText1);

var etd11 = document.createElement('td');
etd11.width = "10px";
theText1=document.createTextNode('\u00a0');
etd11.appendChild(theText1);

var t  = document.getElementById('table-po');

var r  = document.createElement('tr');
r.setAttribute ("align","center");

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "100px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { getcode(this.id); };
<?php 
                       $query = "SELECT distinct(type) FROM ims_itemtypes ORDER BY type";
                       $result = mysql_query($query); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['type']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['type']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
var type = document.createElement('td');
type.appendChild(myselect1);

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectdesc(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);




myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "140px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectcode(this.id); };



mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="hidden";
mybox1.name="description[]";
mybox1.id = "description@" + index;
mybox1.setAttribute("readonly");

var desc = document.createElement('td');
desc.appendChild(myselect1); 
desc.appendChild(mybox1);




mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="units[]";
mybox1.id = "units@" + index;
mybox1.setAttribute("readonly");

var units = document.createElement('td');
units.appendChild(mybox1);


mybox1=document.createElement("input");
mybox1.size="7";
mybox1.type="text";
mybox1.id="qtys@" + index;
mybox1.style.textAlign = "right";
mybox1.name="qtys[]";
var qst = document.createElement('td');
qst.appendChild(mybox1);


mybox1=document.createElement("input");
mybox1.size="7";
mybox1.type="text";
mybox1.id="qtyr@" + index;
mybox1.name="qtyr[]";
mybox1.style.textAlign = "right";
mybox1.onkeyup = function () { (''); };
mybox1.onblur = function () { calnet(''); };
var qrs = document.createElement('td');
qrs.appendChild(mybox1);

////////// Fourth TD ////////////


mybox1=document.createElement("input");
mybox1.size="3";
mybox1.type="text";
mybox1.name="bags[]";
mybox1.value="0";
mybox1.style.textAlign = "right";
mybox1.id = "bags@" + index;

var bags = document.createElement('td');
bags.appendChild(mybox1);

////////// Fifth TD /////////////

myselect1 = document.createElement("select");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "bagtype[]";
<?php if($_SESSION['db'] == 'golden' || $_SESSION['db'] == 'mlcf' || $_SESSION['db']=='mbcf' || $_SESSION['db']=='ncf') { ?> 
myselect1.onchange= function() { calnet(''); }; 
<?php } ?>


myselect1.id = "bagtype@" + index;
myselect1.style.width = "80px";

<?php 
	     $query1 = "SELECT * FROM ims_itemcodes WHERE type = 'Packing Material' ORDER BY code ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>

var bagtype = document.createElement('td');
bagtype.appendChild(myselect1);

////////// Sixth TD ////////////


mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="price@" + index;
mybox1.name="price[]";
mybox1.style.textAlign = "right";
mybox1.onfocus = function () { makeForm(); };
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var price = document.createElement('td');
price.appendChild(mybox1);


<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="mrp@" + index;
mybox1.name="mrp[]";
mybox1.style.textAlign = "right";
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var mrp = document.createElement('td');
mrp.appendChild(mybox1);

<?php
}
?>
////////// Seventh TD ////////////

myselect2 = document.createElement("select");
myselect2.id="vat@" + index;
myselect2.name = "vat[]";
myselect2.onchange = function () { calnet(''); };


myselect2.style.width = "60px";

theOption2=document.createElement("OPTION");
theText2=document.createTextNode("None");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);

<?php include "config.php";
                       include "config.php"; 
                       $query = "SELECT distinct(code),codevalue FROM ims_taxcodes where (taxflag = 'P') ORDER BY codevalue ASC";
                       $result = mysql_query($query,$conn); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['codevalue']; ?>";
myselect2.appendChild(theOption1);
<?php } ?>

var vat = document.createElement('td');
<?php if($_SESSION['tax']==0) { ?> vat.style.display="none"; <?php } ?>
vat.appendChild(myselect2);




input = document.createElement("input");
input.type = "hidden";
input.id = "taxamount@" + index;
input.value=0;
input.name = "taxamount[]";


myselect2 = document.createElement("select");
myselect2.id="doffice@" + index;
myselect2.name = "doffice[]";
myselect2.style.width = "150px";

theOption2=document.createElement("OPTION");
theText2=document.createTextNode("-Select-");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);

<?php include "config.php";
                       include "config.php"; 
				
	 $query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' or type1='Chicken Center' or type1='Egg Center' ORDER BY sector ASC";  
		   
                       //$query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' ORDER BY sector ASC";
                       $result = mysql_query($query,$conn); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['sector']; ?>";
myselect2.appendChild(theOption1);
<?php } ?>

var dlocation = document.createElement('td');
dlocation.appendChild(myselect2);

myselect1 = document.createElement("select");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";
<?php if($_SESSION['db'] == 'feedatives'){?>
myselect1.onchange = function () { getfarm(this.id,this.value); };
<?php } ?>
//myselect1.style.display = "none";

myselect1.id = "flock@" + index;
myselect1.style.width = "120px";
<?php include "config.php";
		if($_SESSION['db'] == "feedatives")
				{
			 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		  $query = "SELECT * FROM tbl_sector where  type1 = 'Warehouse' or type1='Chicken Center' or type1='Egg Center' ORDER BY sector ASC";
		   }
		   else
		   {
		   $sectorlist = $_SESSION['sectorlist'];
		   $query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' and sector In ($sectorlist) ORDER BY sector ASC";
		   }
				}
				else
				{
				 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
				{
				 $query = "SELECT * FROM tbl_sector where type1 = 'Administration Office' or type1 = 'Warehouse' or type1='Chicken Center' or type1='Egg Center' ORDER BY sector ASC";
				 }
				 else
				 {
				 $sectorlist = $_SESSION['sectorlist'];
				 $query = "SELECT * FROM tbl_sector where (type1 = 'Administration Office' or type1 = 'Warehouse' or type1='Chicken Center' or type1='Egg Center') and (place IN ($sectorlist))  ORDER BY sector ASC";
				 }
				}	
				
				
		      
				   
    
                       $result = mysql_query($query,$conn); 
                       $n1 = mysql_num_rows($result);
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.appendChild(theText1);
<?php if($n1 == 1) { ?>
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.selected = "true";
<?php } ?>
myselect1.appendChild(theOption1);
<?php } ?>





var flock = document.createElement('td');
flock.appendChild(myselect1);
	   
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
	  r.appendChild(qrs);
	  r.appendChild(etd4);
	  r.appendChild(bagtype);
	  r.appendChild(etd5);
	  r.appendChild(bags);
	  r.appendChild(etd6);
	  r.appendChild(price);
	  r.appendChild(etd7);
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
 r.appendChild(mrp); 
 r.appendChild(etd11);
<?php
}
?>	  
	  r.appendChild(vat);
      r.appendChild(etd9); 
	  r.appendChild(flock);
	  r.appendChild(etd10);
	  //r.appendChild(dlocation); 
	  r.appendChild(input);
      t.appendChild(r);
	  
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
var tab1 = document.getElementById("batchexp");
var tr1 = document.createElement("tr");
tr1.setAttribute ("align","center");
tr1.id = "batchexprow@" + index;
tr1.style.display = "none";

var td1 = document.createElement("td");
var mybox1 = document.createElement("input");
mybox1.type = "text";
mybox1.size = "8";
mybox1.id = "code2@" + index;
mybox1.setAttribute("readonly",true);
td1.appendChild(mybox1);

var td2 = document.createElement("td");
var mybox1 = document.createElement("input");
mybox1.type = "text";
mybox1.size = "15";
mybox1.id = "desc2@" + index;
mybox1.setAttribute("readonly",true);
td2.appendChild(mybox1);

var td3 = document.createElement("td");
var mybox1 = document.createElement("input");
mybox1.type = "text";
mybox1.size = "10";
mybox1.id = "batch@" + index;
mybox1.name = "batch[]";
td3.appendChild(mybox1);

var td4 = document.createElement("td");
var mybox1 = document.createElement("input");
mybox1.type = "text";
mybox1.id = "expdate@" + index;
mybox1.name = "expdate[]";
mybox1.size = "15";
mybox1.value = "";
mybox1.setAttribute("class","datepicker");
td4.appendChild(mybox1);


td5 = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "type[]";
myselect1.id = "type@" + index;
myselect1.style.width = "100px";

myselect1.onchange = function ()  {  changetype(this.id,this.value); };
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Existing");
theOption1.appendChild(theText1);
theOption1.value = "Existing";
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("New");
theOption1.appendChild(theText1);
theOption1.value = "New";
myselect1.appendChild(theOption1);
td5.appendChild(myselect1);


td6 = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="14";
mybox1.type="text";
mybox1.name="aflock[]";
mybox1.id = "aflock@" + index;
mybox1.onchange = function(){ checkFlock(this.value,this.id);} ;
mybox1.style.display = "none";
td6.appendChild(mybox1);

myselect1 = document.createElement("select");
myselect1.name = "existflock[]";
myselect1.id = "existflock@" + index;
myselect1.style.width = "100px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.appendChild(theOption1);
td6.appendChild(myselect1);




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



tr1.appendChild(td1);
tr1.appendChild(etd);
tr1.appendChild(td2);
tr1.appendChild(etd1);
tr1.appendChild(td3);
tr1.appendChild(etd2);
tr1.appendChild(td4);
tr1.appendChild(etd3);
tr1.appendChild(td5);
tr1.appendChild(etd4);
tr1.appendChild(td6);


tab1.appendChild(tr1);

<?php
}
?>	
 
}

function calnet(a)
{
 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
  var tot2 = 0; var qty112 = 0; var price112 = 0; var temp112 = 0;
 for(k = -1;k < index;k++)
 {
 tot = 0;
  var vat = document.getElementById("vat@" + k).value;



<?php
if($_SESSION['db'] <> 'golden')
{
?>  
  if(document.getElementById("qtys@" + k).value != "" && document.getElementById("price@" + k).value != "")
  tot = (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);
<?php
}
elseif($_SESSION['db'] == 'golden' || $_SESSION['db'] == 'mlcf' || $_SESSION['db']=='mbcf' || $_SESSION['db']=='ncf')
{
?>
  if(document.getElementById("qtys@" + k).value != "" && document.getElementById("price@" + k).value != "")
  {
   if(document.getElementById("bagtype@" + k).value == "numbers")
    tot = (document.getElementById("bags@" + k).value * document.getElementById("price@" + k).value);
   else 
    tot = (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);
  }
<?php
}
?>  

  
  if(vat != '0' && vat != "")
  tot = tot + (tot * vat/100 );
  tot2 = tot2 + tot;
 qty112 = document.getElementById("qtys@" + k).value;
 price112 = document.getElementById("price@" + k).value;
 temp112 = document.getElementById("vat@" + k).value;
 <?php if($_SESSION['tax']!=0) { ?>
  document.getElementById('taxamount@' + k).value = round_decimals(parseFloat(parseFloat(parseFloat(qty112) * parseFloat(price112))* parseFloat(temp112))/100,3);
  <?php } ?>
 }
 tot = tot2;
 document.getElementById('basic').value = round_decimals(tot,3);
 
if(document.getElementById("disper").checked)
{
 var disamount = (parseFloat(document.getElementById("disamount").value) / 100) * tot;
}
else
{
 var disamount = parseFloat(document.getElementById("disamount").value);
}

document.getElementById('discountamount').value = disamount;

 tot1 = tot - disamount;
 
document.getElementById('totalprice').value = round_decimals(tot1,3);

if(document.getElementById("freighttype").value == "Included")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 - freight;
}
if(document.getElementById("freighttype").value == "Excluded")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 + freight;
}
document.getElementById("pamount1").value = document.getElementById("tpayment").value = round_decimals(tot1,3);

<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
calnet2(a);
<?php
}
?>

}

function calnet2(a)
{
 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
  var tot2 = 0; var qty112 = 0; var price112 = 0; var temp112 = 0;
 for(k = -1;k < index;k++)
 {
 tot = 0;
  var vat = document.getElementById("vat@" + k).value;
  if(document.getElementById("qtys@" + k).value != "" && document.getElementById("price@" + k).value != "")
  tot = (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);
  if(document.getElementById("qtys@" + k).value != "" && document.getElementById("mrp@" + k).value != "")
  mrptot = (document.getElementById("qtys@" + k).value * document.getElementById("mrp@" + k).value);
  
  if(vat != '0' && vat != "")
  tot = tot + (mrptot * vat/100 );
  
  tot2 = tot2 + tot;
 qty112 = document.getElementById("qtys@" + k).value;
 price112 = document.getElementById("price@" + k).value;
 temp112 = document.getElementById("vat@" + k).value;
  document.getElementById('taxamount@' + k).value = round_decimals(parseFloat(parseFloat(parseFloat(qty112) * parseFloat(price112))* parseFloat(temp112))/100,3);
 }
 tot = tot2;
 document.getElementById('basic').value = round_decimals(tot,3);
 
if(document.getElementById("disper").checked)
{
 var disamount = (parseFloat(document.getElementById("disamount").value) / 100) * tot;
}
else
{
 var disamount = parseFloat(document.getElementById("disamount").value);
}

document.getElementById('discountamount').value = disamount;

 tot1 = tot - disamount;
 
document.getElementById('totalprice').value = round_decimals(tot1,3);

if(document.getElementById("freighttype").value == "Included")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 - freight;
}
if(document.getElementById("freighttype").value == "Excluded")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 + freight;
}
document.getElementById("tpayment").value = round_decimals(tot1,3);

}



function checkcoa()
{	
if(document.getElementById('vendor').selectedIndex == 0)
{
 alert("Please select Vendor");
 document.getElementById('vendor').focus();
 return false;
}

for(var i=-1;i<=index;i++)
{
if(document.getElementById('code@'+i).selectedIndex != 0 && document.getElementById('flock@'+i).selectedIndex == 0)
{
//flk =document.getElementById('flock'+i).value; 
//alert("Test");
	  if(i == -1) 
	   t = "st"; 
	  else if(i == 0) 
	   t = "nd"; 
	  else if (i == 1) 
	   t = "rd"; 
	  else 
	   t = "th";

alert("Please select Warehouse for "+(i+2)+""+t+" row");
document.getElementById('flock@'+i).focus();
return false;
}
}


	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0")
	{
		if(document.getElementById('coa').selectedIndex == 0)
		{
			alert("Please select Chart of Account");
			document.getElementById('coa').focus();
			return false;
		}		
		else if (document.getElementById('cvia').selectedIndex == 0)
		{
		   alert("Please select Mode");
			document.getElementById('cvia').focus();
			return false;
		}	
		else if (document.getElementById('cashbankcode').selectedIndex == 0)
		{
		   alert("Please select Payment Code");
			document.getElementById('cashbankcode').focus();
			return false;
		}	
	}
	<?php if($_SESSION['db'] == 'central') { ?>
	if(document.getElementById('validate').value == 0)
	{
	 alert("Enter Currency conversion for this date");
	 return false;
	}
	document.form1.action = "pp_savedirectpurchasec.php";
	<?php } elseif($_SESSION['db'] == 'alwadi') {?>
	document.form1.action = "pp_savedirectpurchasec.php";
	<?php } ?>
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

<?php if($_SESSION['db'] == 'feedatives')
{?>
function getfarm(a,b)
{
var typeindex = a.substr(6);
 var typeid = "existflock@"+typeindex;
 myselect1 = document.getElementById(typeid);
 
 for($i=myselect1.length;$i>0;$i--)
  myselect1.remove($i);

<?php
$query ="SELECT distinct(farm) FROM broiler_daily_entry WHERE client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_query());
while($rows = mysql_fetch_assoc($result))
{
 echo "if(b == '$rows[farm]') {";
 $query2 = "SELECT distinct(flock) FROM broiler_daily_entry WHERE farm = '$rows[farm]' AND flock NOT IN ( SELECT flock FROM broiler_transferrate WHERE client = '$client' AND farmer = '$rows[farm]') AND client = '$client'";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 ?>
 theOption1=document.createElement("OPTION");
 theText1=document.createTextNode("<?php echo $rows2['flock']; ?>");
 theOption1.appendChild(theText1);
 theOption1.value = "<?php echo $rows2['flock']; ?>";
 theOption1.title = "<?php echo $rows2['flock']; ?>";
 myselect1.appendChild(theOption1);
 
 <?php
 }
 echo " } ";
}
?>

}

<?php } ?>
function changetype(a,b)
{
var typeindex = a.substr(5);

if(b == "Existing")
{
document.getElementById("aflock@"+typeindex).style.display = "none";
document.getElementById("existflock@"+typeindex).style.display = "block";
}
else
{
document.getElementById("existflock@"+typeindex).style.display = "none";
document.getElementById("aflock@"+typeindex).style.display = "block";
document.getElementById("aflock@"+typeindex).value = "";
}
}
<?php if($_SESSION['db'] != "mlcf" || $_SESSION['db']=='ncf')
{
?>
function checkFlock(a,b)
{
var typeindex = b.substr(7);
<?php
$flag =0;
$query = "SELECT distinct(flock) FROM broiler_daily_entry WHERE client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $flock = $rows['flock'];
 echo "if(a == '$flock') {";
?>
alert("Flock name is already existing");
var typeid = "aflock@"+typeindex;
document.getElementById(typeid).value = "";
document.getElementById(typeid).focus();
<?php

 echo "}";
}
?>
}
<?php } ?>
</script>

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_t_adddirectpurchase.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="../../../Documents and Settings/Administrator/Desktop/aug5th downloads/images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

