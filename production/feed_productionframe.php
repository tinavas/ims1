<?php $formtype = "Layer"; ?>
<?php include "getemployee.php"; ?>
<?php $l = explode("?",$_GET['batches']); $batches = $l[0]; $feedtype=$l[1]; $formula = $l[2]; $feedmill = $l[3]; $date = $l[4];  ?>


<?php
     $totalconsumed = 0;$totalcost= 0;
     include "config.php"; 
     $queryq1 = "SELECT * FROM feed_formula where name = '$formula' AND feedtype = '$feedtype' AND feedmill = '$feedmill' ORDER BY name ASC ";
     $resultq1 = mysql_query($queryq1,$conn); 
     while($r1 = mysql_fetch_assoc($resultq1))
     {
         #$bagweight = round($r1['quantity']);
     }  
           
     $query = "SELECT * FROM feed_fformula where sid = '$formula' AND feedtype = '$feedtype' AND feedmill = '$feedmill' ORDER BY ingredient ASC ";
     $result = mysql_query($query,$conn); 
     while($row1 = mysql_fetch_assoc($result))
     {
       $totalcon = $row1['quantity'] * $batches;
       $totalconsumed = $totalconsumed + $totalcon;
     }
?>














<?php
    $date1 = $date; 
    $date1 = date("Y-m-j", strtotime($date1));

   $query5 = "SELECT * FROM feed_fformula where sid = '$formula' and feedtype = '$feedtype' and feedmill = '$feedmill' ORDER BY ingredient ASC ";
    $result5 = mysql_query($query5,$conn); 
    $numrows5 = mysql_num_rows($result5);
    if( $numrows5 > 0 )
    {
       $totalmatcost = "0";
       while($row5 = mysql_fetch_assoc($result5))
       {

          $code = $row5['ingredient'];
          $query9 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
          $result9 = mysql_query($query9,$conn);
          while($row = mysql_fetch_assoc($result9))
          {
            $mode = $row['cm'];
          }
          $amount = changeprice(round(calculate($mode,$code,$date1,$row5['quantity']),3));
		  $costing = ($row5['quantity'] * $batches) * $amount;
          $totalmatcost = $totalmatcost + $costing;
		  //echo $code."/".$row5['quantity']."/".$amount."/".$costing."/".$totalmatcost;
		  //echo "</br>";
      }
   } 
?>









<?php // $totalmatcost = 1000; ?>

<div style="float:left">
<fieldset style="width:410px">
<legend>Statistics</legend>

<table border="0px">
<tr height="10px"></tr>

<tr>
 <td width="250px" style="text-align:left"><strong>Ingredient</strong></td>
 <td width="10px"></td>
 
 <td colspan="4"><strong>Quantity (Kg's)</strong></td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
 <td><strong></strong></td>
 <td></td>
 
 <td style="text-align:left"><strong>Available</strong></td>
 <td width="30px"></td>

 <td style="text-align:left"><strong>Required</strong></td>
 <td></td>

</tr>


<tr height="10px"><td></td></tr>


<?php
$query6 = "SELECT * FROM feed_fformula where sid = '$formula' and feedtype = '$feedtype' and feedmill = '$feedmill' ORDER BY ingredient ASC ";
$result6 = mysql_query($query6,$conn); 
while($row6 = mysql_fetch_assoc($result6))
{
  $query61 = "SELECT * FROM ims_itemcodes where code = '$row6[ingredient]'";
  $result61 = mysql_query($query61,$conn); 
  while($row61 = mysql_fetch_assoc($result61))
  {
    $desc = $row61['description'];
  }
  $warehouse = "";
  $stock = 0;
  $q = "select type from tbl_sector where sector = '$feedmill'";
  $qrs = mysql_query($q,$conn) or die(mysql_error());
  if($qr = mysql_fetch_assoc($qrs))
  $warehouse = $qr['type'];
  
   $query61 = "SELECT * FROM ims_stock where itemcode = '$row6[ingredient]' and warehouse = '$warehouse' ";
  $result61 = mysql_query($query61,$conn); 
  while($row61 = mysql_fetch_assoc($result61))
  {
    $stock = $row61['quantity'];
  }
  if($stock == "")
  $stock = 0;
?>
<?php 
if(($row6['quantity'] * $batches) > $stock) { 
 $submitflag = 1;
}
?>


<tr>
 <td style="text-align:left"><strong <?php if(($row6['quantity'] * $batches) > $stock) { ?>style="color:red;"<?php } ?>><?php echo $row6['ingredient']; ?> (<?php echo $desc; ?>)</strong></td>
 <td></td>
 
 <td <?php if(($row6['quantity'] * $batches) > $stock) { ?>style="color:red;text-align:right;"<?php } else { ?>style="text-align:right;"<?php } ?>><?php echo $stock; ?></td>
 <td width="30px"></td>

 <td <?php if(($row6['quantity'] * $batches) > $stock) { ?>style="color:red;text-align:right;"<?php } else { ?>style="text-align:right;"<?php } ?>><?php echo ($row6['quantity'] * $batches); ?></td>
 <td></td>
</tr>

<?php
}
?>

</table>
</fieldset>
</div>


<div style="float:right; position:absolute">
<fieldset style="width:430px;margin-left:460px;">
<legend>Details</legend>

<!-- hidden start -->
<input type="hidden" name="bagweightreal" id="bagweightreal" style="position:absolute" value="<?php echo $bagweight; ?>" />
<input type="hidden" name="submitflag" id="submitflag" style="position:absolute" value="<?php echo $submitflag; ?>" />
<!-- hidden end -->


<table border="0">

<tr>
<td width="150" style="text-align:left"><strong>Mat.Consumed [Kg.]</strong></strong></td><td width="40"><input type="text" name="matconsumed" id="matconsumed"  value="<?php echo $totalconsumed; ?>" readonly style="background:#D4D0C8" size="7" /></td>

<td width="10"></td>

<td width="150" style="text-align:left"><strong>Actual Production<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></td><td width="40"><input type="text" name="production" tabindex="1" id="production" size="7" onkeyup="getcapacity(this.value); calcsub('production','shrinkageper','matconsumed','shrinkage','shrinkagecost','materialcost','noofbags','feedcostperkg','feedcostperbag')"/></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" style="text-align:left"><strong>Bag Type</strong></td>
<td width="40">
<select id="bagtype" name="bagtype" onchange="getcapacity(this.value); calcsub('production','shrinkageper','matconsumed','shrinkage','shrinkagecost','materialcost','noofbags','feedcostperkg','feedcostperbag')">
<option value="">-Select-</option>
<?php 
	$q = "select distinct(code),description from ims_bagdetails order by code";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['code']; ?>" title="<?php echo $qr['description']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
<td width="10"></td>

<td width="150" style="text-align:left"><strong>No.of Bags</strong></td><td width="40"><input type="text" name="noofbags" id="noofbags" size="7"  tabindex="1"  style="" size="7"  /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" style="text-align:left"><strong>Shrinkage [Kg.]</strong></td><td width="40"><input type="text" name="shrinkage" id="shrinkage" readonly style="background:#D4D0C8" size="7" /></td>

<td width="10"></td>

<td width="150" style="text-align:left"><strong>Shrinkage Cost</strong></td><td width="40"><input type="text" name="shrinkagecost" id="shrinkagecost" readonly style="background:#D4D0C8" size="7" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" style="text-align:left"><strong>Shrinkage [%]</strong></td><td width="40"><input type="text" name="shrinkageper" id="shrinkageper" readonly style="background:#D4D0C8" size="7" /></td>

<td width="10"></td>

<td width="150" style="text-align:left"><strong>Material Cost</strong></td><td width="40"><input type="text" name="materialcost" id="materialcost" readonly style="background:#D4D0C8" value="<?php echo $totalmatcost; ?>" size="7"  "calc1(this.value,'shrinkageper','shrinkagecost','matconsumed','feedcostperkg','feedcostperbag','labourcharges')" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" style="text-align:left"><strong>Labour Charges</strong></td><td width="40"><input type="text" name="labourcharges"  value="0" tabindex="2" id="labourcharges" size="7" onkeyup="ca(this.value,'shrinkageper','shrinkagecost','matconsumed','feedcostperkg','feedcostperbag','materialcost')" /></td>
</tr>
<?php if($_SESSION['db'] == "feedatives") { ?>
<tr height="10px"><td></td></tr>

<tr>
<td width="150" style="text-align:left"><strong>Batch No:</strong></td><td width="40"><input type="text" name="batchno"  value="0" id="batchno" size="7" /></td>
<td width="10"></td>
<td width="150" style="text-align:left"><strong>Expiry Date:</strong></td>
<td width="40"><input type="text" name="edate1" id="edate1" class="datepicker" value="<?php echo date("d.m.Y"); ?>"  size="10"  /> 
</tr>
<?php } ?>
<tr height="15px"><td></td></tr>

<tr>
<td colspan="6"><strong style="color:red">Electricity Charges</strong></td>
</tr>

<tr height="15px"><td></td></tr>

<tr>
 <td colspan ="6">
 <table>

  <tr>
 <td style="text-align:left" width="70px"><strong>Units</strong></td><td ><input type="text" name="noofunits" tabindex="3"  value="0" id="noofunits" size="7" onkeyup="calc('noofunits','costperunit','elecharges','materialcost','shrinkagecost','labourcharges','matconsumed','feedcostperkg','feedcostperbag','packing','transport','other')" /></td>
 <td width="13"></td>
 <td style="text-align:left" width="80px"><strong>Cost/Unit</strong></td><td ><input type="text" name="costperunit"  value="0" tabindex="4" id="costperunit" size="7" onkeyup="calc('noofunits','costperunit','elecharges','materialcost','shrinkagecost','labourcharges','matconsumed','feedcostperkg','feedcostperbag','packing','transport','other')" /></td>
  <td width="12"></td>
<td style="text-align:left" width="55px"><strong>Total</td><td ><input type="text" name="elecharges"  value="0" id="elecharges" readonly style="background:#D4D0C8" size="7" /></td>
  </tr>

 <tr height="10px"><td></td></tr>

  <tr>
 <td style="text-align:left" width="70px"><strong>Packing</strong></td><td ><input type="text" name="packing" tabindex="5" id="packing" size="7"  value="0" onkeyup="calc('noofunits','costperunit','elecharges','materialcost','shrinkagecost','labourcharges','matconsumed','feedcostperkg','feedcostperbag','packing','transport','other')" /></td>
 <td width="13"></td>
 <td style="text-align:left" width="80px"><strong>Transport</strong></td><td ><input type="text" name="transport" tabindex="6" id="transport" size="7"  value="0" onkeyup="calc('noofunits','costperunit','elecharges','materialcost','shrinkagecost','labourcharges','matconsumed','feedcostperkg','feedcostperbag','packing','transport','other')" /></td>
  <td width="12"></td>
 <td style="text-align:left" width="55px"><strong>Other</strong></td><td ><input type="text" name="other" id="other" tabindex="7"  style="" size="7"  value="0" onkeyup="calc('noofunits','costperunit','elecharges','materialcost','shrinkagecost','labourcharges','matconsumed','feedcostperkg','feedcostperbag','packing','transport','other')" /></td>
  </tr>

<tr height="10px"><td></td></tr>

 </table>
 </td>
</tr>

<tr height="15px"><td></td></tr>

<tr>
<td style="text-align:left"><strong>Feed Cost/Bag</strong></td><td width="20"><input type="text" name="feedcostperbag" id="feedcostperbag" readonly style="background:#D4D0C8" size="7" /></td>
<td width="10"></td>
<td style="text-align:left"><strong>Feed Cost/Kg</strong></td><td width="20"><input type="text" name="feedcostperkg" id="feedcostperkg" readonly style="background:#D4D0C8" size="7" /></td>
</tr>
</table>

<br /><br />
<table align="center" id="tableid">
<tr>
<td style="text-align:center"><strong>Bag Type Emptied</strong></td>
<td width="10"></td>
<td style="text-align:center"><strong>No. of Bags</strong></td>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="20">
<select id="ebagtype@0" name="ebagtype[]" onchange="checkcodes()">
<option value="">-Select-</option>
<?php 
	$q = "select distinct(code),description from ims_bagdetails order by code";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['code']; ?>" title="<?php echo $qr['description']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>

</select>
</td>
<td width="10"></td>
<td width="20">
<input type="text" id="enoofbags@0" name="enoofbags[]" size="7" onchange="getRow();"/></td>
</tr>

</table>

</fieldset>
</div>

<table>
<tr height="500px"><td></td></tr>
<tr><td>
<?php if(!$submitflag) { ?>
 <input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;
<?php } ?>
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=feed_productionunit';">
</td></tr>
</table>