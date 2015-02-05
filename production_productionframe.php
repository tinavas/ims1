
<?php 
include "getemployee.php";   
$sflag=0;
 $l = explode("?",$_GET['data']); 
 $producttype=$l[0]; 
 $formula = $l[1]; 
  $date = $l[2]; 
$warehouse=$l[3];

$batches=$l[4];

     $totalconsumed = 0;$totalcost= 0;
   
     $queryq1 = "SELECT * FROM product_formula where name = '$formula' AND producttype = '$producttype'  ORDER BY name ASC ";
     $resultq1 = mysql_query($queryq1,$conn); 
     while($r1 = mysql_fetch_assoc($resultq1))
     {
         #$bagweight = round($r1['quantity']);
     }  
           
     $query = "SELECT * FROM product_fformula where sid = '$formula' AND producttype = '$producttype'  ORDER BY ingredient ASC ";
     $result = mysql_query($query,$conn); 
     while($row1 = mysql_fetch_assoc($result))
     {
       $totalcon = $row1['quantity']*$batches;
       $totalconsumed = $totalconsumed + $totalcon;
     }
?>



<?php
    $date1 = $date; 
    $date1 = date("Y-m-j", strtotime($date1));

   $query5 = "SELECT * FROM product_fformula where sid = '$formula' and producttype = '$producttype'  ORDER BY ingredient ASC ";
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
			$iac = $row['iac'];
          }
		  
$qi="select code,cunits,sunits from ims_itemcodes where code='$code'";

   $qi=mysql_query($qi) or die(mysql_error());
   
   $ri=mysql_fetch_assoc($qi);
   
   $sunits=$ri['sunits'];
   
   $cunits=$ri['cunits'];
   
   if($sunits!=$cunits)
  {
  
  $qc="select * from ims_convunits where fromunits='$sunits' and tounits='$cunits'";
  
  $qc=mysql_query($qc) or die(mysql_error());
  
  $rc=mysql_fetch_assoc($qc);
  
  $qc=mysql_num_rows($qc);
  
  if($qc=="" || $qc==0)
  {
  echo "<script type='text/javascript'>";
  echo "alert('No Coversion units for $row5[ingredient]');";
  echo "</script>";
  $cflag=1;
  }
  else
  {
  
  $conunits=$rc['conunits'];
  
  $sprice=round(calculatenew($warehouse,$mode,$code,$date1),5);

  
  $amount=($sprice/$conunits);
  
  $squantity=$cquantity/$conunits;
  // echo "$code+    $amount*$squantity<br>";
  
 }
  
  
  } 
  else
  {
  $conunits=1;
  
  $squantity=$cquantity;
  
  $amount=$sprice=round(calculatenew($warehouse,$mode,$code,$date1),5);
  //echo "$code+    $sprice<br>";
  
  }
         // $amount = round(calculatenew($warehouse,$mode,$code,$date1),3);
		  $costing = ($row5['quantity']*$batches) * $amount;
          $totalmatcost = round($totalmatcost + $costing,5);
		  //echo $code."/".
		 // echo $row5['quantity']."/".$amount."/".$costing."/".$totalmatcost;
		 // echo "</br>";
		 
		 $allcodescprice[$code]=$amount;
		 
      }
   } 
?>


<?php
 $query = "SELECT * FROM product_productionunit WHERE date = '$date1' AND producttype = '$producttype' AND formula = '$formula' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_num_rows($result);
if($rows == 0)
{
?>



<?php // $totalmatcost = 1000; ?>

<div style="float:left">
<fieldset style="width:410px">
<legend>Statistics</legend>

<table border="0px">
<tr height="10px"></tr>

<tr>
 <td width="250px" style="text-align:left"><strong>Input Item</strong></td>
 <td width="10px"></td>
 
 <td><strong>Units</strong></td>
 
 <td width="10px"></td>
 
 <td><strong>Required<br />Quantity </strong></td>
 
 
 <td width="10px"></td>
 
 <td <?php if($_SESSION[db]=='singhsatrang' && $_SESSION[admin]!='1') {  ?> style="visibility:hidden" <?php }?>><strong>Price</strong></td>
 
</tr>
<tr height="10px"><td></td></tr>
<!--<tr>
 <td><strong></strong></td>
 <td></td>
 
 <td style="text-align:left"><strong>Available</strong></td>
 <td width="30px"></td>

 <td style="text-align:left"><strong>Required</strong></td>
 <td></td>

</tr>-->


<tr height="10px"><td></td></tr>


<?php
 $query6 = "SELECT * FROM product_fformula where sid = '$formula' and producttype = '$producttype'  ORDER BY ingredient ASC ";
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
  $q = "select type from tbl_sector where sector = '$warehouse'";
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
 <td style="text-align:left"><strong><?php echo $row6['ingredient']; ?> (<?php echo $desc; ?>)</strong></td>
 
  <td></td>
 
 <td style="text-align:right;"><?php echo ($row6['unit']); ?></td>
 
 <td></td>
 
 <td style="text-align:right;"><?php echo ($row6['quantity']*$batches); ?></td>
 
 <td></td>
 <td <?php if($_SESSION[db]=='singhsatrang' && $_SESSION[admin]!='1') {  ?> style="visibility:hidden" <?php }?>><?php echo $allcodescprice[$row6['ingredient']]; ?></td>
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
<td width="150" style="text-align:left"><strong>Mat.Consumed </strong></strong></td><td width="40"><input type="text" name="matconsumed" id="matconsumed"  value="<?php echo $totalconsumed; ?>" readonly style="background:#D4D0C8" size="7" /></td>

<td width="10"></td>

<td width="150" style="text-align:left"><strong>Output<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></td><td width="40"><input type="text" name="pproduction" tabindex="1" id="pproduction" size="7"  value="0" onkeyup="calculatevalues()" /></td>
</tr>





<tr height="10px"><td></td></tr>

<tr>
<td width="150" style="text-align:left"><strong>Shrinkage </strong></td><td width="40"><input type="text" name="shrinkage" id="shrinkage"   size="7" onkeyup="calculatevalues()"  value="0"/></td>

<td width="10"></td>

<td width="150" style="text-align:left"><strong>Actual Output</strong></td><td width="40"><input type="text" name="production" id="production"  style="background:#D4D0C8" size="7" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" style="text-align:left"><strong>Shrinkage [%]</strong></td><td width="40"><input type="text" name="shrinkageper" id="shrinkageper" readonly style="background:#D4D0C8" size="7" /></td>

<td width="10"></td>

<td width="150" style="text-align:left" <?php if($_SESSION[db]=='singhsatrang' && $_SESSION[admin]!='1') {  ?> style="visibility:hidden" <?php }?>><strong>Material Cost</strong></td><td width="40"><input type="text"  <?php if($_SESSION[db]=='singhsatrang' && $_SESSION[admin]!='1') {  ?> style="visibility:hidden" <?php }?> name="materialcost" id="materialcost" readonly style="background:#D4D0C8" value="<?php echo $totalmatcost; ?>" size="7"   /></td>
</tr>

<tr height="10px"><td></td></tr>





<tr height="15px"><td></td></tr>

<tr>
<td style="text-align:left"><strong></strong></td><td width="20"></td>
<td width="10"></td>
<td style="text-align:left" <?php if($_SESSION[db]=='singhsatrang' && $_SESSION[admin]!='1') {  ?> style="visibility:hidden" <?php }?>><strong>Cost/unit</strong></td><td width="20"><input type="text" <?php if($_SESSION[db]=='singhsatrang' && $_SESSION[admin]!='1') {  ?> style="visibility:hidden" <?php }?> name="costperunit" id="costperunit" readonly style="background:#D4D0C8" size="7" /></td>
</tr>
</table>






</fieldset>
</div>
<?php } // End of if(rows == 0) 
else {
 $submitflag = 1;
 $sflag=1;
?>
<table>
<tr><td style="color:red;text-align:right;">The production already entered for this formula to this date</td></tr>
<tr height="10px"></tr>
</table>
<?php
}	// end of else
?>
<table>
<?php if($rows == 0) { ?><tr height="500px"><td></td></tr> <?php } ?>
<tr><td>
<input type="submit" value="Save" id="save" <?php if($sflag==1){ ?> disabled="disabled" <?php }?> />&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=product_productionunit';" id="cancel">
</td></tr>
</table>