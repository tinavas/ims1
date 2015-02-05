<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";

$cnt = 1;
$invoice = $_GET['id'];
$query1 = "SELECT * FROM pp_sobi where so = '$invoice' order by id";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
 $datemain = date("d.m.Y",strtotime($row1['date']));
 $billdate = date("d.m.Y",strtotime($row1['billdate']));
 $vendor = $row1['vendor'];
 $bkinvoice = $row1['invoice'];
  $basicamt = $row1['totalamount'];
  $freightamount = $row1['freightamount'];
  $discountamount = $row1['discountamount'];
  $freighttype = $row1['freighttype'];
  $cashbankcode = $row1['cashbankcode'];
  $coa = $row1['coa'];
  $brokerageamount = $row1['brokerageamount'];
  $totalprice = $basicamt - $discountamount - $brokerageamount;
  $grandtotal = $row1['grandtotal'];
  $viaf = $row1['viaf'];
  $broker = $row1['broker'];
  $vehicle = $row1['vno'];
  $driver = $row1['driver'];
  $m = $row1['m'];
  $y = $row1['y'];
  $sobiincr = $row1['sobiincr'];
  $remarks=$row1['remarks'];
  $flag = $row1['flag'];
  $conversion = 1;
  $cterm = $row1['credittermvalue'];
 if($_SESSION['db'] == 'central') { $conversion = $row1['camount']; }  
}

if($_SESSION['db'] == "mlcf" or $_SESSION['db'] == 'mbcf' or $_SESSION['db'] == 'ncf')
{
$result=mysql_query("select code,description,capacity from ims_bagdetails",$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$bagscapacity[$res['code']] = $res['capacity'];

}
?>
 
<link href="editor/sample.css" rel="stylesheet" type="text/css"/>

<section class="grid_8">
  <div class="block-border">

 <form class="block-content form" id="complex_form" method="post" onSubmit="return checkcoa();" action="<?php if($flag == 0) { ?>pp_updatedirectpurchase_a.php <?php } else { ?> pp_updatedirectpurchase_a1.php <?php } ?>">

  
		<input type="hidden" name="sobiincr" id="sobiincr" value="<?php echo $sobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		<input type="hidden" name="discountamount" id="discountamount" value="0"/>
		<input type="hidden" name="saed" id="saed" value="1" />
	 
	  <h1>Direct Purchase</h1>
		<br /><br />
            <table align="center">
<?php if($_SESSION['db'] == "suriya") { ?>
			<tr>
				<td colspan="16" align="center"><strong>Bill Date</strong>&nbsp;&nbsp;
				<input type="text" id="billdate" name="billdate" class="datepicker" value="<?php echo $billdate; ?>" size="10" /></td>
			</tr>
			<tr height="10px"></tr>
			<?php } ?>	  	
			<?php if($_SESSION['db'] == "albustan" || $_SESSION['db'] == "albustanlayer") { ?>
			<tr>
				<td colspan="16" align="center"><strong>Vendor</strong>&nbsp;&nbsp; <select  id="vendor"  name="vendor" style="width:175px" onchange=<?php if($_SESSION['db'] == 'central') { ?> "fvalidatecurrency();"  <?php } else{?>"getcterm(this.value);  document.getElementById('vendorcode').value=this.value;" <?php } ?>>
					<option value="">-Select-</option>
					<?php
							$q = "select distinct(name),cterm,code from contactdetails where type = 'vendor' OR type = 'vendor and party' order by name";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
					?>
					<option <?php if ($qr['name'] == $vendor) echo 'selected="selected"'; ?> title="<?php echo $qr['name']; ?>" value="<?php echo $qr['name'].'@'.$qr['cterm'].'@'.$qr['code'];?>"><?php echo $qr['name']; ?></option>
					<?php   }   ?>
					</select>  &nbsp;&nbsp; <strong>Vendor Code </strong> &nbsp;&nbsp; <select id="vendorcode" name="vendorcode" style="width:175px" onchange= <?php if($_SESSION['db'] == 'central') { ?> "fvalidatecurrency();" <?php } else{ ?> "getcterm(this.value);  document.getElementById('vendor').value=this.value;" <?php } ?>>
					<option value="" >-Select-</option>
					<?php
							$q = "select distinct(name),cterm,code from contactdetails where type = 'vendor' OR type = 'vendor and party' order by name";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
					?>
					<option <?php if ($qr['name'] == $vendor) echo 'selected="selected"'; ?> title="<?php echo $qr['name']; ?>" value="<?php echo $qr['name'].'@'.$qr['cterm'].'@'.$qr['code'];?>"><?php echo $qr['code']; ?></option>
					<?php   }   ?>
					</select></td>
			</tr>
			<tr height="10px"></tr>
			<?php } ?> 			
              <tr>
             
                <td><strong>Date</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="date" name="date" value="<?php echo $datemain; ?>" <?php if($_SESSION['db'] == 'central') { ?> onChange="fvalidatecurrency();" <?php } ?>></td>
                <td width="5px"></td>
<?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") {} else  { ?>
                <td><strong>Vendor</strong></td>
                <td>&nbsp;
					<select id="vendor" name="vendor" style="width:175px" <?php if($_SESSION['db'] == 'central') { ?> onChange="fvalidatecurrency();" <?php } ?>>
					<option>-Select-</option>
					<?php
							$q = "select distinct(name),cterm from contactdetails where type = 'vendor' OR type = 'vendor and party' order by name";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
							if ( $qr['name'] == $vendor)
							{
					?>
					<option  value="<?php echo $qr['name'].'@'.$qr['cterm'];?>"selected="selected"><?php echo $qr['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $qr['name'].'@'.$qr['cterm'];?>"><?php echo $qr['name']; ?></option>
					<?php   }   }?>
					</select>
				</td>
                <td width="5px"></td>
<?php } ?>
                <td><strong>Invoice</strong></td>
                <td width="15px"></td>
                <td>&nbsp;<input type="text" size="19" style="background:none;border:none;" id="invoice" name="invoice" value="<?php echo $invoice; ?>" readonly /></td>
				
				<td width="5px"></td>
				
                <td><strong>Book&nbsp;Invoice</strong></td>
				<td width="5px"></td>
                <td>&nbsp;
					<input type="text" size="12" id="bookinvoice" name="bookinvoice" value="<?php echo $bkinvoice; ?>"></td>
                <td width="5px"></td>
                <td><strong>Credit&nbsp;Term</strong></td>
				<td width="5px"></td>
                <td>
					<select id="cterm" name="cterm">
					<option value="0">-Select-</option>
					<?php
					$query = "SELECT * FROM ims_creditterm ORDER BY value";
					$result = mysql_query($query,$conn) or die(mysql_error());
					while($rows = mysql_fetch_assoc($result))
					{
					 ?>
					 <option value="<?php echo $rows['value']; ?>" <?php if($cterm == $rows['value']) { ?> selected = "selected" <?php } ?>><?php echo $rows['code']; ?></option>
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
<?php if($_SESSION['db'] == 'albustanlayer'){ ?>
<th title="Free Quantity" ><strong>Qty Free</strong></th><td width="10px">&nbsp;</td>
<?php } ?>
<th><strong>Type</strong></th><td width="10px">&nbsp;</td>
<th><strong>Bags<?php if($_SESSION['db'] == 'golden' || $_SESSION['db'] == 'mlcf' || $_SESSION['db'] == 'mbcf' or $_SESSION['db'] == 'ncf') { ?>/ <br />Numbers<?php } else {?> / <br/> Boxes <?php }?></strong></th><td width="10px">&nbsp;</td>
<th><strong>Price<br />/Unit</strong></th><td width="10px">&nbsp;</td>
<th <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?>>&nbsp;&nbsp;&nbsp;<strong>VAT</strong></th><td <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?> width="10px">&nbsp;</td>
<th><strong>Deliver Location</strong></th>
     </tr>

     <tr style="height:20px"></tr>
<?php $i=1;

$q = "select * from pp_sobi where so = '$invoice' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	  $q1 = "select cat from ims_itemcodes where code = '$qr[code]' order by id ";
	$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	while($qr1 = mysql_fetch_assoc($qrs1))
	{
	  $cat1 = $qr1['cat'];
	}
	 ?>
     <tr>
 
       <td style="text-align:left;"><select style="Width:75px" name="cat[]" id="cat@<?php echo $i; ?>" onChange="getcode(this.id);">
         <option value="">-Select-</option>
         <?php 
	     $query = "SELECT distinct(type) FROM ims_itemtypes ORDER BY type ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           { 
		   if ($row['type'] == $cat1){
     ?>
         <option value="<?php echo $row['type'];?>" selected="selected"><?php echo $row['type']; ?></option>
         <?php } else { ?>
         <option value="<?php echo $row['type'];?>"><?php echo $row['type']; ?></option>
         <?php } } ?>
       </select></td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<select style="Width:75px" name="code[]" id="code@<?php echo $i; ?>" onChange="getdesc(this.id);">
     		<option value="">-Select-</option>
     <?php 
	     
	     $query = "SELECT distinct(code) FROM ims_itemcodes where cat='$cat1' ORDER BY code ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
		   if ($row['code'] == $qr['code'])
		   {
     ?>
	   <option value="<?php echo $row['code'];?>" selected="selected"><?php echo $row['code']; ?></option>
	   <?php } else { ?>
             <option value="<?php echo $row['code'];?>"><?php echo $row['code']; ?></option>
     <?php } } ?>
</select>       </td>
<td width="10px">&nbsp;</td><td>
<?php /*?><input type="text" size="15" id="description@<?php echo $i; ?>" name="description[]" value="<?php echo $qr['description']; ?>" readonly/><?php */?>
<select id="description@<?php echo $i;?>" name="description[]" style="width:170px" onChange="getcodec(this.id);">
<option>-Select-</option>

 <?php 
	     
	      $query = "SELECT distinct(description) FROM ims_itemcodes where cat='$cat1' ORDER BY description ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
		   if ($row['description'] == $qr['description'])
		   {
     ?>
	   <option value="<?php echo $row['description'];?>" selected="selected"><?php echo $row['description']; ?></option>
	   <?php } else { ?>
             <option value="<?php echo $row['description'];?>"><?php echo $row['description']; ?></option>
     <?php } } ?>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@<?php echo $i; ?>" name="units[]" value="<?php echo $qr['itemunits']; ?>" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" style="text-align:right;" id="qtys@<?php echo $i; ?>" name="qtys[]" value="<?php  if(($_SESSION['db'] == "mlcf" && strlen(strstr($qr['code'],'LFD'))>0) or ($_SESSION['db'] == "mbcf" && strlen(strstr($qr['code'],'BFD'))>0) or ($_SESSION['db'] == "ncf" && strlen(strstr($qr['code'],'NFD'))>0) or ($_SESSION['db'] == "ncf" && strlen(strstr($qr['code'],'LFD'))>0)) echo $qr['sentquantity']/$bagscapacity[$qr['bagtype']]; else echo $qr['sentquantity']; ?>" onKeyUp="calnet('');" onBlur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" id="qtyr@<?php echo $i; ?>" style="text-align:right;" name="qtyr[]" value="<?php if(($_SESSION['db'] == "mlcf" && strlen(strstr($qr['code'],'LFD'))>0) or ($_SESSION['db'] == "mbcf" && strlen(strstr($qr['code'],'BFD'))>0) or ($_SESSION['db'] == "ncf" && strlen(strstr($qr['code'],'NFD'))>0) or ($_SESSION['db'] == "ncf" && strlen(strstr($qr['code'],'LFD'))>0)) echo $qr['receivedquantity']/$bagscapacity[$qr['bagtype']]; else echo $qr['receivedquantity']; ?>" onKeyUp="calnet('');" onBlur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td>

<?php if($_SESSION[db]=='albustanlayer'){ ?>
<td>
<input type="text" size="5" id="qtyf@<?php echo $i; ?>" style="text-align:right;" name="fqty[]" value="<?php echo $qr['fqty']; ?>" onKeyUp="calnet('');" onBlur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td>
<?php } ?>
<td>
<select style="Width:80px" name="bagtype[]" id="bagtype@<?php echo $i; ?>" <?php if($_SESSION['db'] == 'golden' || $_SESSION['db'] == 'mlcf' || $_SESSION['db'] == 'mbcf' || $_SESSION['db'] == 'ncf' ) { ?> onChange="calnet('');" <?php } ?>>
	<option value="">-Select-</option>


     <?php 
	 if($_SESSION['db'] == 'golden' && ($cat1 == 'Medicines' OR $cat1 == 'Vaccines'))
	 {
	 ?>
	 <option value="numbers" <?php if($qr['bagtype'] == "numbers") { ?> selected="selected" <?php } ?>>Numbers</option>
	 <option value="kgs" <?php if($qr['bagtype'] == "kgs") { ?> selected="selected" <?php } ?>>Bags</option>
	 <?php
	 }
	 else
	 {
	     $query1 = "SELECT * FROM ims_itemcodes WHERE type = 'Packing Material' ORDER BY code ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   $a = "";
		    $query11 = "SELECT * FROM ims_bagdetails WHERE code = '$row1[code]'";
           $result11 = mysql_query($query11,$conn);
           while($row11 = mysql_fetch_assoc($result11))
           {
		   $a .= "@".$row11['capacity'];
		    $a .= " ".$row11['units'];
		     $bagwt = $row11['weight'];
		   }
		    if ($row1['code'] == $qr['bagtype'])
			{
     ?>
	         <option title="<?php echo $row1['description'] . $a; ?>" value="<?php echo $row1['code']."@".$bagwt;?>" selected = "selected"><?php echo $row1['code']; ?></option>
	 <?php } else { ?>
             <option title="<?php echo $row1['description'] . $a; ?>" value="<?php echo $row1['code']."@".$bagwt;?>"><?php echo $row1['code']; ?></option>
     <?php } } } ?>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="3" id="bags@<?php echo $i; ?>" style="text-align:right;" name="bags[]" value="<?php echo $qr['bags']; ?>"  />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="price@<?php echo $i; ?>" style="text-align:right;" name="price[]" value="<?php if(($_SESSION['db'] == "mlcf" && strlen(strstr($qr['code'],'LFD'))>0) or ($_SESSION['db'] == "mbcf" && strlen(strstr($qr['code'],'BFD'))>0) or ($_SESSION['db'] == "ncf" && strlen(strstr($qr['code'],'NFD'))>0) or ($_SESSION['db'] == "ncf" && strlen(strstr($qr['code'],'LFD'))>0) ) echo $qr['rateperunit']*$bagscapacity[$qr['bagtype']]; else echo ($qr['rateperunit'] / $conversion); ?>"  onkeyup="calnet('');" onBlur="calnet('');"  onfocus="makeForm();"/>
</td>
<td width="10px">&nbsp;</td><td <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?>>
<select style="width:60px" name="vat[]" id="vat@<?php echo $i; ?>" onChange="calnet('');">
     <option value="0">None</option>
     <?php 
	     $query = "SELECT distinct(code),codevalue FROM ims_taxcodes where type = 'Tax' ORDER BY code ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
		   if ($row['code'] == $qr['taxcode'])
		   {
     ?>
	         <option value="<?php echo $row['codevalue'];?>" selected= "selected"><?php echo $row['code']; ?></option>
	 <?php } else { ?>
             <option value="<?php echo $row['codevalue'];?>"><?php echo $row['code']; ?></option>
     <?php } } ?>
</select>

</td>
<td <?php if($_SESSION['tax']==0) { ?> style="display:none" <?php } ?> width="10px"></td><td>
<input type="hidden" name="olddooffice[]" id="olddoffice@<?php echo $i; ?>"  value="<?php echo $qr['warehouse'];?>"/>
<input type="hidden" name="oldflock[]" id="oldflock@<?php echo $i; ?>"  value="<?php echo $qr['flock'];?>"/>
<select name="doffice[]" id="doffice@<?php echo $i; ?>"  style="width:150px;">
<option value="">-Select-</option>
 <?php
           
		   include "config.php"; 
		   
	if (($cat1 == "Broiler Birds") || ($cat1 == "Broiler Chicks") || ($cat1 == "Broiler Day Old Chicks"))
	{
		/*if($_SESSION['db'] == "feedatives")
		{

			if($_SESSION['sectorr'] == "all")
		   {
		  $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and place = '$sectorr' order by sector";
		   }
		   
		}
	  else
		{
		$query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center' order by sector";
		}*/
		if($_SESSION['db'] == "feedatives")
		{

			 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		  $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   $sectorlist = $_SESSION['sectorlist'];
		   $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
		   
		}
	  else
	  {
		 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center' order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
	      
		  }
		  
		  // $query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' ORDER BY sector ASC";
		   
           //$query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' ORDER BY sector ASC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		    if ($row1['sector'] == $qr['warehouse']) { 
           ?>
		   <option value="<?php echo $row1['sector']; ?>" selected = "selected" title="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
<?php } }

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
		    $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm where place In ($sectorlist) ORDER BY farm ASC";
		   }
		
		$result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		    if ($row11['farm'] == $qr['warehouse']) { 
           ?>
		   <option value="<?php echo $row11['farm']; ?>" selected = "selected" title="<?php echo $row11['farm']; ?>" ><?php echo $row11['farm']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row11['farm']; ?>" title="<?php echo $row11['farm']; ?>" ><?php echo $row11['farm']; ?></option>
<?php } }

}	   
	else  if (($cat1 == "Layer Birds"))
	{
		   
		  $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		    $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		    if ($row1['sector'] == $qr['flock']) { 
           ?>
		   <option value="<?php echo $row1['sector']; ?>" selected = "selected" title="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
<?php } }


		  $query1 = "SELECT distinct(flockcode) as 'flock' FROM layer_flock ORDER BY flockcode ASC";
		   $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		    if ($row11['flock'] == $qr['flock']) { 
           ?>
		   <option value="<?php echo $row11['flock']; ?>" selected = "selected" title="<?php echo $row11['flock']; ?>" ><?php echo $row11['flock']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row11['flock']; ?>" title="<?php echo $row11['flock']; ?>" ><?php echo $row11['flock']; ?></option>
<?php } }

} 
	else if (($cat1 == "Female Birds") || ($cat1 == "Male Birds"))
	{
			   $query1 = "SELECT distinct(flockcode)  FROM breeder_flock WHERE client = '$client' ORDER BY flockcode ASC";
		  $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		    if ($row11['flockcode'] == $qr['flock']) { 
           ?>
		   <option value="<?php echo $row11['flockcode']; ?>" selected = "selected" title="<?php echo $row11['flockcode']; ?>" ><?php echo $row11['flockcode']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row11['flockcode']; ?>" title="<?php echo $row11['flockcode']; ?>" ><?php echo $row11['flockcode']; ?></option>
<?php } }

} 


	else if ($_SESSION['client'] == 'KEHINDE')
	{
	if ($cat1 == 'Turkey Female Birds' || $cat1 == 'Turkey Male Birds'|| $cat1 == 'Turkey Female Feed'|| $cat1 == 'Turkey Male Feed'|| $cat1 == 'Turkey Hatch Eggs'|| $cat1 == 'Turkey Eggs')
		{

		    $query1 = "SELECT distinct(flockcode)  FROM turkey_flock WHERE client = '$client' and cullflag='0' ORDER BY flockcode ASC";
		  $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		    if ($row11['flockcode'] == $qr['flock']) { 
           ?>
		   <option value="<?php echo $row11['flockcode']; ?>" selected = "selected" title="<?php echo $row11['flockcode']; ?>" ><?php echo $row11['flockcode']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row11['flockcode']; ?>" title="<?php echo $row11['flockcode']; ?>" ><?php echo $row11['flockcode']; ?></option>
<?php } }
}

} 



else
{
		
		if($_SESSION['db'] == "feedatives")
		{

		 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		  $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   $sectorlist = $_SESSION['sectorlist'];
		   $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
		   
		}
	  else
	  {
		   if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center' order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $query = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
	      
		  }
	      
		  // $query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' ORDER BY sector ASC";
		   
           //$query = "SELECT * FROM tbl_sector where type1 = 'Warehouse' ORDER BY sector ASC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		    if ($row1['sector'] == $qr['warehouse']) { 
           ?>
		   <option value="<?php echo $row1['sector']; ?>" selected = "selected" title="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
<?php } }

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
		     $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm where place In ($sectorlist) ORDER BY farm ASC";
		   }
		
		$result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		    if ($row11['farm'] == $qr['warehouse']) { 
           ?>
		   <option value="<?php echo $row11['farm']; ?>" selected = "selected" title="<?php echo $row11['farm']; ?>" ><?php echo $row11['farm']; ?></option>
		   <?php } else { ?>
<option value="<?php echo $row11['farm']; ?>" title="<?php echo $row11['farm']; ?>" ><?php echo $row11['farm']; ?></option>
<?php } }

 
}?> 
</select>
<input type="hidden" id="taxamount@<?php echo $i; ?>" name="taxamount[]" value="0" />
</td>
    </tr>
	<?php $i++;;  
	
	?>
	 <script> globalindex="<?php echo $i;?>";
	          index = parseInt(<?php echo $i; ?>) - 1;
	  </script>
	 <?php }
	?>
   </table>
   <br /> 
 </center>

<br />	
<?php
$expindex = 0;
if($_SESSION['client'] == 'FEEDATIVES' or $_SESSION['db'] == 'albustanlayer')
{
?>
<table id="batchexp" align="center">
 <tr>
   <td align="center"><strong>Code</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Description</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Batch No.</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Expiry Date</strong></td><td width="10px">&nbsp;</td>
   <?php if($_SESSION['db'] == 'feedatives') { ?>
   <td align="center"><strong>Type</strong></td><td width="10px">&nbsp;</td>
   <td align="center"><strong>Flock</strong></td>
	<?php } ?>
 </tr>
 <?php
if($_SESSION['db'] == "feedatives")
 $q1 = "SELECT code,description,batchno,expirydate FROM pp_sobi WHERE so = '$invoice' ORDER BY id";
else
 $q1 = "SELECT code,description,batchno,expdate FROM pp_sobi WHERE so = '$invoice' ORDER BY id";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
while($rr1 = mysql_fetch_assoc($r1))
{ $expindex++;
 $code = $rr1['code'];
 $desc = $rr1['description'];
 $batch = $rr1['batchno'];
 $expdate = date("d.m.Y",strtotime($rr1['expdate']));
 $q2 = "SELECT cat FROM ims_itemcodes WHERE code='$code'";
 $r2 = mysql_query($q2,$conn) or die(mysql_error());
 $rr2 = mysql_fetch_assoc($r2);
 $cat = $rr2['cat'];
?> 
 <tr id="batchexprow@<?php echo $expindex; ?>" <?php if($cat <> 'Medicines' and $cat <> 'Vaccines') { ?> style="display:none" <?php } ?>>
  <td><input type="text" id="code2@<?php echo $expindex; ?>" size="8" value="<?php echo $code; ?>" readonly /></td><td width="10px">&nbsp;</td>
  <td><input type="text" id="desc2@<?php echo $expindex; ?>" size="15" value="<?php echo $desc; ?>" readonly /></td><td width="10px">&nbsp;</td>
  <td><input type="text" id="batch@<?php echo $expindex; ?>" name="batch[]" size="10" value="<?php echo $batch; ?>" /></td><td width="10px">&nbsp;</td>
  <td><input class="datepicker" type="text" size="15" id="expdate@<?php echo $expindex; ?>" name="expdate[]" value="<?php echo $expdate; ?>"></td><td width="10px">&nbsp;</td>
  <?php if($_SESSION['db'] == 'feedatives') { ?>
<td><select id="type@-1" name="type[]" style="width:100px"  onChange="changetype(this.id,this.value)">
<option value="Existing">Existing</option>
<option value="New">New</option>
</select></td>
<td width="10px">&nbsp;</td>
<td><input type="text" name="aflock[]" id="aflock@<?php echo $expindex; ?>" size="14"  style="display:none" onBlur="checkFlock(this.value,this.id);" />
<select name="existflock[]" id="existflock@<?php echo $expindex; ?>" style="width:100px">
<option value="">-Select-</option></select></td>

<?php $expindex++; } ?>
  </tr>
<?php } //End of while $rr1 ?>  
</table>
<?php
}
?>
		<center>

<table border="1">
   <tr style="height:20px"></tr>
   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;&nbsp;&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="<?php echo ($basicamt/$conversion); ?>" style="text-align:right" readonly /></td>
      <td align="right"><strong>Discount &nbsp;&nbsp;&nbsp;</strong></td>
          <td align="left"> <input type="radio" id="disper" name="discount"  onclick="calnet('dcreate')" /><strong>%</strong>&nbsp;<input type="radio" id="disper1" name="discount" checked="true" onClick="calnet('dcreate')" /> <strong>Amt</strong>
      <input type="text" size="6" id="disamount" name="disamount" value="<?php echo ($discountamount/$conversion); ?>" style="text-align:right" onKeyUp="calnet('dcreate')" /></td>
      <td align="right"><strong>&nbsp;Broker&nbsp;Name</strong>&nbsp;&nbsp;</td>
      <td align="left"><select style="Width:120px" name="broker" id="broker"><option value="">-Select-</option>
           <?php $query = "SELECT distinct(name) FROM contactdetails where type = 'broker' ORDER BY name ASC"; $result = mysql_query($query,$conn);
                 while($row = mysql_fetch_assoc($result)){
				 if ($row['name'] == $broker ) { ?>
				 <option value="<?php echo $row['name'];?>" selected = "selected" > <?php echo $row['name']; ?></option>
				 <?php } else { ?>
           <option value="<?php echo $row['name'];?>" > <?php echo $row['name']; ?></option>
                <?php } } ?></select></td>
      <td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" value="<?php echo $vehicle; ?>" /></td>
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Price</strong>&nbsp;&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:right" value="<?php echo ($totalprice/$conversion); ?>" readonly/></td>
   <td></td><td></td><td></td><td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>
   <td align="left"><input type="text" size="15" name="driver" value = "<?php echo $driver; ?>" /></td>

  </tr>
  <tr style="height:20px"></tr>
  <tr style="height:20px"></tr>
   <tr>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select name="freighttype" id="freighttype" style="width:100px" onChange="calnet('dcreate')"><option value="Included" <?php if($freighttype == "Included") { ?> selected="selected" <?php } ?>>Included</option>
	   <option value="Excluded"  <?php if($freighttype == "Excluded") { ?> selected="selected" <?php } ?>>Excluded</option>
	   <option value="Freight Amount in Bill"  <?php if($freighttype == "Freight Amount in Bill") { ?> selected="selected" <?php } ?>  title = "Freight Amount in Bill">Freight Amount in Bill</option>
	   </select></td>

       <td align="right"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><input type="text" size="8" name="cfamount" id="cfamount" onKeyUp="calnet('dcreate')" value="<?php echo ($freightamount/$conversion); ?>" style="text-align:right"/>
	   &nbsp;&nbsp;
	   <select id="coa" name="coa" style="width:80px">
	   <option value="">-Select-</option>
	   <?php 
	   		$q = "select distinct(code),description from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			  if ($qr['code'] == $coa )
			  {
	   ?>
	   <option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" selected = "selected"><?php echo $qr['code']; ?></option>
	   <?php } else { ?>
	   <option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
	   <?php } } ?>
	   </select>
	   </td>
       <td align="right"><strong>Via</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select style="Width:80px" name="cvia" id="cvia" onChange="loadcodes(this.value);"><option value="">-Select-</option><option value="Cash" <?php if ($viaf == "Cash") { ?> selected = "selected"<?php } ?>>Cash</option><option value="Cheque" <?php if ($viaf == "Cheque") { ?> selected = "selected"<?php } ?>>Cheque</option><option value="Others">Others</option></select></td>
	  <td align="right" id="cashbankcodetd1" ><strong><span id="codespan">Code</span></strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="cashbankcodetd2" >
		<select name="cashbankcode" id="cashbankcode" style="width:125px">
		<option value="<?php echo $cashbankcode; ?>"><?php echo $cashbankcode; ?></option>
		</select>
		</td>

</tr>
<tr style="height:20px"></tr>
<tr>
<td></td><td></td><td></td><td></td>
	  <td align="right" id="chequetd1" ><strong>Cheque</strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="chequetd2" >
		<input type="text" name="cheque" id="cheque" size="15">
		</td>

       <td align="right" id="datedtd1" ><strong>Dated</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left" id="datedtd2" ><input type="text" size="15" id="cdate" class="datepicker" name="cdate" value="<?php echo date("d.m.Y"); ?>" /></td>


</tr>
  <tr style="height:20px"></tr>
<tr>
	  <td align="right"><strong>&nbsp;Grand&nbsp;Total</strong>&nbsp;&nbsp;</td>
        <td align="left"><input type="text" size="12" name="tpayment" id="tpayment" value="<?php echo ($grandtotal/$conversion); ?>" readonly style="text-align:right"/></td>
</tr>
</table>
<div id="validatecurrency"></div><br>	
<center>	
<br />
<table>
<tr>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $remarks; ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</tr>
</table>
</center>
<br />

   <br />
   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_directpurchase_a';">
</center>


						
</form>
</div>
</section>
<div class="clear">
</div>
<br />

<script type="text/javascript">
function fvalidatecurrency(a)
{
 var date = document.getElementById('date').value;
 var vendor = document.getElementById('vendor').value;
 var tdata = date + "@" + vendor + "@vendor";
 getdiv('validatecurrency',tdata,'pp_currencyframe.php?data=');
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
else if(via == "Cheque" || via == "Others")
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

function getcterm(value)
{
value=value.split('@'); 
if(value[1]!='')
document.getElementById('cterm').value=value[1];
else
document.getElementById('cterm').value=0;
}
/*var index = -1;*/
function getdesc(code)
{
	var code1 = document.getElementById(code).value;
	temp = code.split("@");
	var index1 = temp[1];
<?php if($_SESSION['db'] == 'albustanlayer') { ?>
document.getElementById("code2@" + index1).value = code1;
<?php } ?>

	<?php 
			$q = "select distinct(code) from ims_itemcodes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('description@' + index1).value = "<?php echo $q1r['description'];?>";
				document.getElementById('units@' + index1).value = "<?php echo $q1r['sunits'];?>";
<?php if($_SESSION['db'] == 'albustanlayer') { ?>
document.getElementById("desc2@" + index1).value = "<?php echo $q1r['description'];?>";
<?php } ?>
				
	<?php
			}
			echo "}";
			}
	?>
}

function getcodec(descid)
{

	var desc11 = document.getElementById(descid).value;
	var tempdesc = descid.split("@");
	var index11 = tempdesc[1];
	
<?php if($_SESSION['db'] == 'albustanlayer') { ?>
document.getElementById("desc2@" + index11).value = desc11;
<?php } ?>

	<?php 
			$q = "select distinct(description) from ims_itemcodes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(desc11 == '$qr[description]') {";
			$q1 = "select distinct(code),sunits from ims_itemcodes where description = '$qr[description]' order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('code@' + index11).value = "<?php echo $q1r['code'];?>";
				document.getElementById('units@' + index11).value = "<?php echo $q1r['sunits'];?>";
<?php if($_SESSION['db'] == 'albustanlayer') { ?>
document.getElementById("code2@" + index11).value = "<?php echo $q1r['code'];?>";
<?php } ?>
				
	<?php
			}
			echo "}";
			}
	?>

}


function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;

<?php
if($_SESSION['db'] == 'albustanlayer')
{
?>
if(cat1 == 'Medicines' || cat1 == 'Vaccines' || cat1 == 'VIT and MIN')
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
	<!--document.getElementById('flock@' + index1).style.display = "none";-->
	if((cat1 == "Broiler Birds") || (cat1 == "Broiler Chicks") || (cat1 == "Broiler Day Old Chicks") || (cat1 == "Broiler Feed") || (cat1 == "Native Feed") || (cat1 == "Native Chicks") || (cat1 == "Native Birds"))
	{
	//document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('doffice@' + index1));
	myselect1 = document.getElementById('doffice@' + index1);
	
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "doffice[]";


myselect1.id = "doffice@" + index;
//myselect1.style.width = "120px";

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
}*/

if($_SESSION['db'] == "feedatives")
		{

			 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		  $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   $sectorlist = $_SESSION['sectorlist'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
		   
		}
	  else
	  {
		 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center' order by sector";
		   }
		   else
		   {
		  $sectorlist = $_SESSION['sectorlist'];
		     $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
		   }
	      
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
		    $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm where place In ($sectorlist) ORDER BY farm ASC";
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

else	if(cat1 == "Layer Birds")
	{
	//document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('doffice@' + index1));
	myselect1 = document.getElementById('doffice@' + index1);
	//myselect1.style.width = "150px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "doffice[]";


myselect1.id = "doffice@" + index;
//myselect1.style.width = "120px";

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
theText1=document.createTextNode("<?php echo $row1['doffice']; ?>");
theOption1.value = "<?php echo $row1['doffice']; ?>";
theOption1.title = "<?php echo $row1['doffice']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>
}




else if((cat1 == "Female Birds") || (cat1 == "Male Birds"))
	{
	//document.getElementById('flock@' + index1).style.display = "";
	
	removeAllOptions(document.getElementById('doffice@' + index1));
	myselect1 = document.getElementById('doffice@' + index1);
	//myselect1.style.width = "150px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "doffice[]";


myselect1.id = "doffice@" + index;
//myselect1.style.width = "120px";

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
<?php }*/ ?>
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

removeAllOptions(document.getElementById('doffice@' + index1));
	myselect1 = document.getElementById('doffice@' + index1);
	
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "doffice[]";


myselect1.id = "doffice@" + index;
//myselect1.style.width = "120px";


<?php 

if($_SESSION['db'] == "feedatives")
{

 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		  $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' order by sector";
		   }
		   else
		   {
		   //$sectorr = $_SESSION['sectorr'];
		    $sectorlist = $_SESSION['sectorlist'];
		   $q1 = "SELECT * FROM tbl_sector WHERE type1='Warehouse' and sector in ('$sectorr') order by sector";
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
<?php }


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
		    $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm where place In ($sectorlist) ORDER BY farm ASC";
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
	

	
	removeAllOptions(document.getElementById('code@' + index1));
			  var code = document.getElementById('code@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              code.appendChild(theOption1);
	/*removeAllOptions(document.getElementById('desc@' + index1));  
			var description = document.getElementById('desc@' + index1); 
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);*/

	<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";
			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
        theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['code'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['code'];?>";
	          theOption1.title = "<?php echo $q1r['description'];?>";
              code.appendChild(theOption1);
			  
			  <?php } ?>
			  <?php
			 /* $q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{*/
	?>
			  
		/*theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['description'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['code'];?>";
	          theOption1.title = "<?php echo $q1r['description'];?>";
              description.appendChild(theOption1);*/
	<?php
			//}
			echo "}";
			}
	?>


<?php
if($_SESSION['client'] == 'KEHINDE')
{
?>
if(cat1 == 'Turkey Female Birds' || cat1 == 'Turkey Male Birds'|| cat1 == 'Turkey Female Feed'|| cat1 == 'Turkey Male Feed'|| cat1 == 'Turkey Hatch Eggs'|| cat1 == 'Turkey Eggs')
{
removeAllOptions(document.getElementById('doffice@' + index1));
myselect1 = document.getElementById('doffice@' + index1);
//myselect1.style.width = "150px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "doffice[]";

myselect1.id = "doffice@" + index;
//myselect1.style.width = "120px";
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


removeAllOptions(document.getElementById('code@' + index1));
			  var code = document.getElementById('code@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              code.appendChild(theOption1);
			  
			   
	removeAllOptions(document.getElementById('description@' + index1));  
			 var description = document.getElementById('description@' + index1); 
              // for description starts
 
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);
	
            // for description ends
			 
	

	<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";
			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['code'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['code'];?>";
	        theOption1.title = "<?php echo $q1r['description'];?>";
              code.appendChild(theOption1);
			  
			    
			// for description starts
  
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['description'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['description']; ?>";
	        theOption1.title = "<?php echo $q1r['code'];?>";
              description.appendChild(theOption1);
 
           // for description ends 
	<?php
			}
			echo "}";
			}
	?>


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


function selectcode(codeid)
{

var temp = codeid.split("@");
var tempindex = temp[1];
var item2 = document.getElementById("cat@" + tempindex).value;
var item1 = document.getElementById(codeid).value;
removeAllOptions(document.getElementById("code@" + tempindex));
myselect1 = document.getElementById("code@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "code[]";
myselect1.style.width = "75px";
<?php 
	     $query1 = "SELECT code,description,cat,sunits FROM ims_itemcodes where iusage = 'Sale' or iusage = 'Produced or Sale' ORDER BY code ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   ?>
		   <?php echo "if(item2 == '$row1[cat]') {"; ?>
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";


     	<?php echo "if(item1 == '$row1[description]') {"; ?>
			
theOption1.selected = true;
var units = document.getElementById("units@" + tempindex);
<?php

			
			$q1 = "select distinct(description),sunits from ims_itemcodes where description = '$row1[description]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
	document.getElementById('units@' + tempindex).value = "<?php echo $q1r['sunits'];?>";

<?php
			}
			
	?>
<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php echo "}"; ?>


<?php }  ?>
}
function getcodeold(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;
	removeAllOptions(document.getElementById('code@' + index1));
			  var code = document.getElementById('code@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              code.appendChild(theOption1);
	

	<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";
			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['code'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['code'];?>";
	        theOption1.title = "<?php echo $q1r['description'];?>";
              code.appendChild(theOption1);
	<?php
			}
			echo "}";
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
var globalflag=0;

function setindex()
{

if(globalflag==0)
{
index =parseInt(globalindex) -1;
 globalflag=1;
 }

}

function makeForm() 
{
if(index == 1)
 temp = 1;
else
 temp = index-1;
 if(document.getElementById('price@'+temp).value != "")
  makeForm1();
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

var t  = document.getElementById('table-po');

var r  = document.createElement('tr');
r.setAttribute ("align","center");

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "75px";
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
myselect1.appendChild(theOption1);
myselect1.onchange = function () { getdesc(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);


myselect1 = document.createElement("select");
myselect1.name = "description[]";
myselect1.id = "description@" + index;
myselect1.style.width = "170px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { getcodec(this.id); };
var desc = document.createElement('td');
desc.appendChild(myselect1);

/*mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="text";
mybox1.name="description[]";
mybox1.id = "description@" + index;
mybox1.setAttribute("readonly");

var desc = document.createElement('td');
desc.appendChild(mybox1);*/


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
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var qrs = document.createElement('td');
qrs.appendChild(mybox1);

<?php if($_SESSION['db'] == 'albustanlayer'){ ?>
mybox1=document.createElement("input");
mybox1.size="5";
mybox1.type="text";
mybox1.id="qtyf@" + index;
mybox1.name="fqty[]";
mybox1.style.textAlign = "right";
mybox1.onkeyup = function () { (''); };
mybox1.onblur = function () { calnet(''); };
var qrf = document.createElement('td');
qrf.appendChild(mybox1);

var etdf = document.createElement('td');
etdf.width = "10px";
theText1=document.createTextNode('\u00a0');
etdf.appendChild(theText1);

<?php } ?>


////////// Fourth TD ////////////


mybox1=document.createElement("input");
mybox1.size="3";
mybox1.type="text";
mybox1.name="bags[]";
mybox1.value="0";
mybox1.style.textAlign = "right";
mybox1.id = "bags@" + index;
mybox1.onchange = function () { bagwt(this.id); };
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
<?php if($_SESSION['db'] == 'golden' || $_SESSION['db'] == 'mlcf' || $_SESSION['db'] == 'mbcf' || $_SESSION['db'] == 'ncf') { ?> 
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
                       $query = "SELECT distinct(code),codevalue FROM ims_taxcodes where type = 'Tax' ORDER BY code ASC";
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
input.value=0;
input.id = "taxamount@" + index;
input.name = "taxamount[]";


myselect2 = document.createElement("select");
myselect2.id="doffice@" + index;
myselect2.name = "doffice[]";
myselect2.style.width = "152px";

theOption2=document.createElement("OPTION");
theText2=document.createTextNode("-Select-");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);

<?php include "config.php";
                       include "config.php"; 
					   
		      if ($sectortype == "Administration Office") {
		   $query = "SELECT * FROM tbl_sector where type1 = 'Administration Office' or type1 = 'Warehouse' ORDER BY sector ASC";
		   }
		   else {
		   $query = "SELECT * FROM tbl_sector where sector = '$sector' ORDER BY sector ASC";
		   }
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
	  <?php if($_SESSION['db'] == 'albustanlayer'){ ?>
      r.appendChild(qrf);
	  r.appendChild(etdf);
<?php } ?>
	  r.appendChild(bagtype);
	  r.appendChild(etd5);
	  r.appendChild(bags);
	  r.appendChild(etd6);
	  r.appendChild(price);
	  r.appendChild(etd7);
	  r.appendChild(vat);
	  r.appendChild(etd9);
	  r.appendChild(dlocation); 
	  r.appendChild(input);
      t.appendChild(r);
	  
<?php
if($_SESSION['client'] == 'FEEDATIVES' or $_SESSION['db'] == 'albustanlayer')
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

  var c = "datepicker" + index;
  mybox1.setAttribute("class",c);
  mybox1.value = "<?php echo date("d.m.Y"); ?>";
td4.appendChild(mybox1);
 
<?php if($_SESSION['db'] == 'feedatives') { ?>
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

<?php } ?>


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
<?php if($_SESSION['db'] == 'feedatives') { ?>
tr1.appendChild(td5);
tr1.appendChild(etd4);
tr1.appendChild(td6);
<?php } ?>

tab1.appendChild(tr1);
 $(function() {
	$( "." + c ).datepicker();
  });

<?php
}
?>	
 	  
}
function bagwt(b)
{
  var bags = document.getElementById(b).value;
  b = b.substr(5,6); var a = parseInt(b);
  var bagtype = document.getElementById("bagtype@" + a).value;
  bagtype = bagtype.split("@");
  bagtype = parseFloat(bagtype[1]);
  document.getElementById("qtyr@" + a).value = document.getElementById("qtys@" + a).value - ( bagtype * bags );
}
var initialcall=0;
function calnet(a)
{
   
 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;

 
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
  var tot2 = 0; var qty112 = 0; var price112 = 0; var temp112 = 0;
  
 for(k = 1;k <= index;k++)
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
elseif($_SESSION['db'] == 'golden' || $_SESSION['db'] == 'mlcf' || $_SESSION['db'] == 'mbcf' || $_SESSION['db'] == 'ncf')
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
  document.getElementById('taxamount@' + k).value = round_decimals(parseFloat(parseFloat(parseFloat(qty112) * parseFloat(price112))* parseFloat(temp112))/100,3); <?php } ?>
 }
 tot = tot2;
 document.getElementById('basic').value = round_decimals(tot,3);
 
if(document.getElementById("disper1").checked)
{

 var disamount = parseFloat(document.getElementById("disamount").value);

}
else
{
  var disamount = (parseFloat(document.getElementById("disamount").value) / 100) * tot;
}

document.getElementById('discountamount').value = disamount;

 tot1 = tot - disamount;
 
document.getElementById('totalprice').value = round_decimals(tot1,3);

if(document.getElementById("freighttype").value == "Included")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 - freight;
}
if(document.getElementById("freighttype").value == "Freight Amount in Bill")
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
if(index== -1)
{
var cmpindex=globalindex;
}
else
{
var  cmpindex=index;
}

for(var i=1;i<=cmpindex;i++)
{
if(document.getElementById('code@'+i).selectedIndex != 0 && document.getElementById('doffice@'+i).selectedIndex == 0)
{
	  if(i == 1) 
	   t = "st"; 
	  else if(i == 2) 
	   t = "nd"; 
	  else if (i == 3) 
	   t = "rd"; 
	  else 
	   t = "th";
alert("Please select Delivery Office for "+i+""+t+" row");
document.getElementById('doffice@'+i).focus();
return false;
}
}
	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0")
	{
		if(document.getElementById('coa').value == "-Select-")
		{
			alert("Please select Chart of Account");
			document.getElementById('coa').focus();
			return false;
		}		
		else if (document.getElementById('cvia').value == "-Select-")
		{
		   alert("Please select Mode");
			document.getElementById('cvia').focus();
			return false;
		}	
		else if (document.getElementById('cashbankcode').value == "-Select-")
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
	<?php } ?>
	//return false;
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
window.open('P2PHelp/help_t_editdirectpurchase.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

