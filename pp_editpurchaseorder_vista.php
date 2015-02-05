
<?php include "jquery.php"; include "config.php"; ?>

<?php // *****************************************************************to get values
$q="select * from pp_purchaseorder where po='$_GET[po]'";
$r=mysql_query($q,$conn);
$a=mysql_fetch_array($r);
$vendor=$a['vendor'];
$vcode=$a['vendorcode'];
$broker=$a['broker'];
$d_date=$a['date'];
$credittermcode=$a['credittermcode'];
$poincr=$a['poincr'];
$m=$a[m];
$y=$a[y];
$po=$a[po];
$vendorid=$a[vendorid];
$vendor=$a[vendor];
$credittermdescription=$a[credittermdescription];
$credittermvalue=$a[credittermvalue];
$brokerid=$a[brokerid];
$broker=$a[broker];
$date=$a['date'];
$tandc = $a['tandc'];
$aflag = $a['flag'];	//Authorization Flag
do{
$category=$a[category];
$code=$a[code];
$description=$a[description];

if($_SESSION['db']=="vista"){
$bird=$a[quantity];
$quantity=$a[weight];
}
else
$quantity=$a[quantity];
$unit=$a[unit];
$rateperunit=$a[rateperunit];
$deliverydate=$a[deliverydate];
$deliverylocation=$a['deliverylocation'];

$receiver=$a[receiver];
$initiatorid=$a[initatoid];
$initiator=$a[initiator];
$initiatorsector=$a[initiatorsector];
$taxcode=$a[taxcode];
$taxvalue=$a[taxvalue];
$taxformula=$a[taxformula];
$taxie=$a[taxie];
$taxamount=$a[taxamount];
$totalwithtax=$a[totalwithtax];
$freightcode=$a[freightcode];
$freightvalue=$a[freightvalue];
$freightformula=$a[freightformula];
$freightie=$a[freightie];
$freightamount=$a[freightamount];
$totalwithfreight=$a[totalwithfreight];
$brokeragecode=$a[brokeragecode];
$brokeragevalue=$a[brokeragevalue];
$brokerageformula=$a[brokerageformula];
$brokerageie=$a[brokerageie];
$brokerageamount=$a[brokerageamount];
$totalwithbrokerage=$a[totalwithbrokerage];
$discountcode=$a[discountcode];
$discountvalue=$a[discountvalue];
$discountformula=$a[discountformula];
$discountie=$a[discountie];
$discountamount=$a[discountamount];
$totalwithdiscount=$a[totalwithdiscount];
$basic=$a[basic];
$finalcost=$a[finalcost];
$tandccode=$a[tandccode];
$flag=$a[flag];
$geflag=$a[geflag];
if($_SESSION['db']=="vista"){
$bird=$a[quantity];
}
$conversion = 1;
if($_SESSION['db'] == "central")
 $conversion = $a['camount'];
}while(mysql_num_rows($r)>1&&$a=mysql_fetch_array($r));

?>

<link href="editor/sample.css" rel="stylesheet" type="text/css"/>
<?php 
/*$date1 = date("d.m.Y"); $strdot1 = explode('.',$date1); $ignore = $strdot1[0]; $m = $strdot1[1];$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(poincr) as poincr FROM pp_purchaseorder  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $piincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $poincr = $row1['poincr']; }
$poincr = $poincr + 1;
if ($poincr < 10) { $po = 'PO-'.$m.$y.'-000'.$poincr; }
else if($poincr < 100 && $poincr >= 10) { $po = 'PO-'.$m.$y.'-00'.$poincr; }
else { $po = 'PO-'.$m.$y.'-0'.$poincr; } */ 
?>

<section class="grid_8">
  <div  class="block-border">
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_saveeditpurchaseorder.php" onSubmit="return calculate(this);">
	  <h1>Purchase Order</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
            <table>
				<?php if($_SESSION[db]=='albustan') { ?>
			 <tr>
			  <td align="center" colspan="14"><strong>Vendor</strong>&nbsp; &nbsp;
                <select onchange="document.getElementById('vendorcode').value=this.value" style="width: 180px" name="vendor" id="vendor" >
                       <option value="">-Select-</option>
						   <?php 
				include "config.php";
						 $query = "SELECT distinct(name),code FROM contactdetails where type like '%vendor%' ORDER BY name ASC";
						 $result = mysql_query($query,$conn);
						 while($row = mysql_fetch_assoc($result))
							  {
				  ?>
                       <option <?php if($row['name']==$vendor && $row['name']!="") echo 'selected="selected"' ?> title="<?php echo $row['code'];?>" value="<?php echo $row['name'];?>@<?php echo $row['code'];?>"><?php echo $row['name']; ?></option>
                <?php } ?>
                </select>
               &nbsp; &nbsp;<strong>Vendor Code</strong> &nbsp; &nbsp;
                <select onchange="document.getElementById('vendor').value=this.value" style="width: 180px" name="vendorcode" id="vendorcode" >
                  	   <?php 
				include "config.php";
						 $query = "SELECT distinct(name),code FROM contactdetails where type like '%vendor%' ORDER BY name ASC";
						 $result = mysql_query($query,$conn);
						 while($row = mysql_fetch_assoc($result))
							  {
				  ?>
                       <option <?php if($row['name']==$vendor && $row['name']!="") echo 'selected="selected"' ?> title="<?php echo $row['name'];?>" value="<?php echo $row['name'];?>@<?php echo $row['code'];?>"><?php echo $row['code']; ?></option>
                <?php } ?>
                </select>
                </td>
			 </tr>
			 <tr height="15"></tr>
			<?php } ?>
              <tr>

             <!-- hidden variables start -->

                <input type="hidden" name="poincr" id="poincr" value="<?php echo $poincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
				
                <input type="hidden" name="taxamount[]" id="taxamount" />
                <input type="hidden" name="freightamount[]" id="freightamount" />
                <input type="hidden" name="brokerageamount[]" id="brokerageamount" />
                <input type="hidden" name="aflag" value="<?php echo $flag; ?>" />
				<input type="hidden" name="saed" value="1" />

             <!-- hidden variables end -->
               
                <td><strong>P.O</strong></td>
                <td>&nbsp;<input type="text" size="14" id="po" name="po" value="<?php echo $_GET[po]; ?>" readonly style="border:0px;background:none" /></td> 
                <td width="20px"></td>
<?php if($_SESSION[db]!='albustan') { ?>
                <td><strong>Vendor</strong></td>
                <td>&nbsp;
                <select style="width: 180px" name="vendor" id="vendor" onchange="<?php if($_SESSION['db'] == 'central') { ?> fvalidatecurrency(); <?php } if($_SESSION[db] == 'albustanlayer') { ?>getcode();<?php }?>">
                                                       <option value="">-Select-</option>
                                                   <?php 
										include "config.php";
	                          $query = "SELECT distinct(name),code FROM contactdetails where type like '%vendor%' ORDER BY name ASC";
		                                         $result = mysql_query($query,$conn);
 		                                         while($row = mysql_fetch_assoc($result))
		                                              {
													  
                                          ?>     
                                                         <option value="<?php if($_SESSION[db] == 'albustanlayer') { echo $row['name']."@".$row['code']; } else{ echo $row['name']; }?>" <?php if($row['name']==$vendor && $row['name']!="") { ?> selected="selected" <?php } ?> ><?php echo $row['name']; ?></option>
                <?php } ?>
                </select>
                </td>
                <td width="20px"></td>
<?php } ?>
<?php if($_SESSION[db] == 'albustanlayer') { ?>
				<td> <strong>Vendor Code</strong>				</td>
				<td><select style="width: 70px" name="vcode" id="vcode" onchange="getvendor()" >
					<option value="">-Select-</option>
                  <?php 
				include "config.php";
						 $query = "SELECT distinct(name),code FROM contactdetails where type like '%vendor%' ORDER BY name ASC";
						 $result = mysql_query($query,$conn);
						 while($row = mysql_fetch_assoc($result))
							  {
				  ?>
                  <option title="<?php echo $row['name'];?>" value="<?php echo $row['name']."@".$row['code'];?>" <?php if($vcode==$row['code']) { ?> selected="selected" <?php } ?> ><?php echo $row['code']; ?></option>
                  <?php } ?>
                </select></td>
				 <td width="20px"></td>
				
<?php } ?>
                <td><strong>Broker</strong></td>
                <td>&nbsp;
                <select style="width: 160px" name="broker" id="broker">
                                   <option value="">-Select-</option>
							   <?php 
										include "config.php";
	                                             $query = "SELECT distinct(name) FROM contactdetails where type = 'broker' ORDER BY name ASC";
		                                         $result = mysql_query($query,$conn);
 		                                         while($row = mysql_fetch_assoc($result))
		                                              {
                                          ?>
                                                         <option value="<?php echo $row['name'];?>" <?php if($row['name']==$broker&& $row['name']!="" ) echo 'selected="selected"' ?> ><?php echo $row['name']; ?></option>
                <?php } ?>
               </select>                </td>
                <td width="20px"></td>
                <input type="hidden" name="vendorid" value="0" />
                <input type="hidden" name="brokerid" value="0" />

                <td><strong>Date</strong></td>
                <td>&nbsp;<input type="text" size="15" id="mdate" readonly="readonly" class="datepicker" name="mdate" value="<?php echo date("d.m.Y",strtotime($d_date)); ?>" <?php if($_SESSION['db'] == 'central') { ?> onchange="fvalidatecurrency();" <?php } ?>></td>
                <td width="20px"></td>
                <td><strong>Credit&nbsp;Term</strong></td>
                <td>&nbsp;
                <select style="width: 100px" name="creditterm" id="creditterm">
                                   <option value="">-Select-</option>
							   <?php 	include "config.php";
	                                             $query = "SELECT distinct(code),description,value FROM ims_creditterm ORDER BY value ASC";
		                                         $result = mysql_query($query,$conn);
 		                                         while($row = mysql_fetch_assoc($result))
		                                              {
                                          ?>
                                                         <option value="<?php echo $row['code'].'@'.$row['description'].'@'.$row['value'];?>"<?php if($row['code']==$credittermcode) echo 'selected="selected"'; ?>><?php echo $row['code']; ?></option>
                <?php } ?>
               </select>                </td>
              </tr>
            </table>







		<div class="columns">
			<div class="col200pxL-left">
				<h2>&nbsp;</h2><br /><br />
				<p class="one-line-input grey-bg small-margin">
					<label for="complex-switch-on" class="float-left" id="prtext">With Out Purchase Request</label><br /><br />
					<span class="float-left"><input type="checkbox" name="complex-switch-on" id="complex-switch-on" value="1" class="switch" onclick="change('withpr');"></span>
                               <br /><br />
				</p>

				<ul class="side-tabs js-tabs same-height">
					<li><a href="#tab-po" title="Item Details">Item Details</a></li>
					<li><a href="#tab-delivery" title="Delivery Details">Delivery Details</a></li>
					<li><a href="#tab-taxes" title="Taxes">Taxes</a></li>
     				      <li><a href="#tab-charges" title="Charges">Charges</a></li>
					<li><a href="#tab-discounts" title="Discounts">Discounts</a></li>
					<li><a href="#tab-tandc" title="Terms &amp; Conditions">Terms &amp; Conditions</a></li>
				</ul>				
						
			</div>




		<div class="col200pxL-right">

<br />





<!-- /////////////////////////////Purchase Order Starts/////////////////////////////////////////// -->

<div id="tab-po" class="tabs-content" style="height:450px">
<center>

<div id="div-pr" style="position:absolute; visibility:hidden">
 <table border="0" id="table-pr">
     <tr>
        <th style=""><strong>Category</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code</strong></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description</strong></th>
        <th width="10px"></th>

        <th style=""><strong>PR #</strong></th>
        <th width="10px"></th>

        <th style=""><strong><?php if($_SESSION['db']=="vista"){ ?>Weight<?php } else {?> Quantity <?php } ?></strong></th>

        <th width="10px"></th>
 
        <th style=""><strong>Units</strong></th>
        <th width="10px"></th>

        <th style=""><strong>Rate/Unit</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Delivery Date</strong></th>
        
     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
         <select name="prcategory[]" id="prtype" onchange="fun(this.id,'pr');" style="width:70px;">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
              $result = mysql_query($query,$conn); 
			  
              while($row1 = mysql_fetch_assoc($result))
              {
			  
           ?>
           <option value="<?php echo $row1['type']; ?>"><?php echo $row1['type']; ?></option>
           <?php } ?>
         </select>
       </td>
	   
       <td width="10px"></td>


       <td style="text-align:leftl;">
         <select name="prcode[]" id="prcode" onchange="description(this.id,'pr');" style="width:70px;">
           <option>-Select-</option>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="prdescription[]" id="pring" readonly size="8"  /> 
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <select name="prnum[]" id="prnum" onchange="prdetails(this.id);" style="width:70px;">
           <option>-Select-</option>
         </select>
       </td>
       <td width="10px"></td>


       <td style="text-align:left;">
         <input type="text" name="prquantity[]" id="pringweight"  size="7" onkeyup="getvalues(this.id)" onblur="getvalues(this.id)"  />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="prunits[]" id="prmunit"  size="7"  />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="prrate[]" id="prunit"  onfocus = "" size="7" />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" size="7" id="prrdate" name="prrdate[]" class="datepicker" value="<?php echo date("d.m.Y"); ?>">
       </td>
    </tr>
   </table>
   <br /> 
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseorder.php';">
</div>

<div id="div-po" style="position:absolute;">
 <table border="0" id="table-po">
       <tr>
        <th style=""><strong>Category</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code</strong></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description</strong></th>
        <th width="10px"></th>

        <th style=""><strong>Units</strong></th>
        <th width="10px"></th>
      
	   <?php if($_SESSION['db']=="vista")
		{ ?>
         <th width="4px"></th>
        <th id="no" style="visibility:visible"><strong>No of Birds</strong></th>
        <?php } ?>

        <th style=""><strong><?php if($_SESSION['db']=="vista"){ ?>Weight<?php } else {?> Quantity <?php } ?></strong></th>

        <th width="10px"></th>
 
        

        <th style=""><strong>Rate/Unit</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Delivery Date</strong></th>
       
        
     </tr>

     <tr style="height:20px"></tr>
<?php $i=-1;
$r=mysql_query($q,$conn);
while($a=mysql_fetch_array($r))
{
 ?>
     <tr>
 
       <td style="text-align:left;">
         <select name="category[]" id="type/<?php echo $i;?>" onchange="fun(this.id,'');" style="width:80px;">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['type']; ?>" <?php if($row1['type']==$a[category]) echo 'selected="selected"'; ?>><?php echo $row1['type']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>
	

       <td style="text-align:left;">
         <select name="code[]" id="code<?php echo $i;?>" onchange="description(this.id,'');" style="width:80px;">
           <option><?php echo $a[code] ?></option>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="description[]" id="ing<?php echo $i;?>" value="<?php echo $a[description]; ?>" readonly size="8"  /> 
       </td>
       <td width="10px"></td>
	   
	   <td style="text-align:left;">
         <input type="text" name="units[]" readonly="readonly" id="munit<?php echo $i;?>" value="<?php echo $a[unit]; ?>"  size="8"  />
       </td>
       <td width="10px"></td>
	   
	  
	   
       <?php if($_SESSION['db']=="vista"){?>
	    <td width="10px"></td>
       <td> <input type="text" style="background:none;border:0px;" readonly="readonly" size="8" id="bird<?php echo $i;?>" name="bird[]" value="<?php echo $a[quantity];?>" onKeyPress="return num(this.id,event.keyCode);" /></td>
       <?php } ?>
       



       <td style="text-align:left;">
         <input type="text" name="quantity[]" id="ingweight<?php echo $i;?>"  onKeyPress="return num1(this.id,event.keyCode);" size="8" <?php if($_SESSION['db']=="vista") { ?> value="<?php echo $a[weight];?>"<?php } else {?> value="<?php echo $a[quantity]; ?>"<?php } ?> onfocus = "" onkeyup="getvalues(this.id)" onblur="getvalues(this.id)"  />
       </td>
       <td width="10px"></td>

       

       <td style="text-align:left;">
         <input type="text" name="rate[]" onKeyPress="return num1(this.id,event.keyCode);" id="unit<?php echo $i;?>" value="<?php echo $a[rateperunit] / $conversion; ?>"  size="8" />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" size="8" id="rdate" name="rdate[]" class="datepicker" readonly="readonly" value="<?php echo  date("d.m.Y",strtotime($a[deliverydate])); ?>">
       </td>
       
      
       
    </tr><?php $i=$i+1; }?>
	</table>
   </table>
   <br /> 
<div id="validatecurrency"></div><br>
<br />
   
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseorder';">
</div>



 </center>
</div>

<!-- /////////////////////////////Purchase Order Ends/////////////////////////////////////////// -->

		



<!-- /////////////////////////////Purchase delivery Start/////////////////////////////////////////// -->

<div id="tab-delivery" class="tabs-content">
  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-delivery">
        <tr>
          <th style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong><?php if($_SESSION['db']=="vista"){ ?>Weight<?php } else {?> Quantity <?php } ?></strong></th>

          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>D.Location</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong>Receiver</strong></th>
        </tr>

        <tr style="height:20px"></tr>
<?php 
$i=-1;
$r=mysql_query($q,$conn);
while($a=mysql_fetch_array($r))
{
 ?> 
        <tr>
         <td style="text-align:left;">
           <input type="text" name="" id="delivery-type<?php echo $i;?>" readonly style="border:0px;background:none;cursor:hand"  value="<?php echo $a[category]; ?>" size="15"  />         </td>
         <td width="10px"></td>

         <td style="text-align:left;">&nbsp;</td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="Input" id="delivery-code<?php echo $i;?>" readonly style="border:0px;background:none;cursor:hand"  value="<?php echo $a[code]; ?>" size="10"  />
           <input type="text" name="Input2" id="delivery-ing<?php echo $i;?>" readonly style="border:0px;background:none;cursor:hand"  value="<?php echo $a[description]; ?>" size="25"  /></td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="delivery-ingweight<?php echo $i;?>"  value="<?php echo $a[weight]; ?>" readonly style="border:0px;background:none;cursor:hand"  size="8"  />         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="delivery-munit<?php echo $i;?>" readonly  value="<?php echo $a[unit]; ?>" style="border:0px;background:none;cursor:hand"  size="8"  />         </td>
         <td width="10px"></td>

          <td>
<select name="doffice[]" id="doffice<?php echo $i;?>" onchange = "getemp(this.id);" style="width:80px;">
<option value="">-Select-</option>
 <?php
           include "config.php"; 
    
		     $query = "SELECT * FROM tbl_sector  order by sector";
		
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		    
           ?>
<option  value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>" <?php if($row1['sector']==$a[deliverylocation]) echo 'selected="selected"';?> ><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>          </td>
          <td width="10px"></td>

          <td>
<select name="demp[]" id="demp"  style="width:80px;">
<option value="">-select-</option>
 </select>          </td>
       </tr><?php $i=$i+1; } ?>
     </table>
   <br />
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseorder'">
  </center>
</div>


<!-- /////////////////////////////Purchase Delivery Ends/////////////////////////////////////////// -->



				
	
<!-- /////////////////////////////Purchase Taxes Start/////////////////////////////////////////// -->

<div id="tab-taxes" class="tabs-content">
  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-taxes">
        <tr>
          <th style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong><?php if($_SESSION['db']=="vista"){ ?>Weight<?php } else {?> Quantity <?php } ?></strong></th>

          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Tax</strong></th>
        </tr>

        <tr style="height:20px"></tr>
 <?php 
 $i=-1;
$r=mysql_query($q,$conn);
while($a=mysql_fetch_array($r))
{
 ?>
        <tr>
         <td style="text-align:left;">
           <input type="text" name="" id="tax-type<?php echo $i;?>" value="<?php echo $a[category]; ?>" readonly style="border:0px;background:none;cursor:hand" size="20"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-code<?php echo $i;?>" value="<?php echo $a[code]; ?>" readonly style="border:0px;background:none;cursor:hand" size="15"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-ing<?php echo $i;?>" value="<?php echo $a[description]; ?>" readonly style="border:0px;background:none;cursor:hand" size="25"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-ingweight<?php echo $i;?>" value="<?php echo $a[weight]; ?>" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-munit<?php echo $i;?>" value="<?php echo $a[unit]; ?>" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td>
		 <?php  if($_SESSION['db']=='feedatives') { ?>   
		    <input type="text" name="taxamount1[]" size=8 id="taxamount" value="<?php echo $a[taxamount]; ?>" />
		   <?php } else { ?>
           <select name="tax[]" id="tax"  style="width:80px;">
             <option value="0@0@0@0">-Select-</option>
             <?php
                include "config.php"; 
                $query = "SELECT * FROM ims_taxcodes where type='Tax' and taxflag = 'P' ORDER BY code DESC ";
                $result = mysql_query($query,$conn); 
                while($row1 = mysql_fetch_assoc($result)) 
                {
             ?>
             <option <?php if($row1[code]==$a[taxcode]) echo 'selected="selected"' ?> title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
             <?php } ?>
           </select>
		   <?php } ?>
         </td>
       </tr><?php $i=$i+1;} ?>
     </table>
   <br />
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseorder'">
  </center>
</div>


<!-- /////////////////////////////Purchase Taxes Ends/////////////////////////////////////////// -->



<!-- /////////////////////////////Purchase Charges Starts/////////////////////////////////////////// -->


<div id="tab-charges" class="tabs-content">
  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-charges">
        <tr>
          <th style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong><?php if($_SESSION['db']=="vista"){ ?>Weight<?php } else {?> Quantity <?php } ?></strong></th>

          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
          <?php if($_SESSION['db'] == "feedatives") { ?> <th style="text-align:left"><strong></strong></th> <?php } ?>
          <th style="text-align:left"><strong>Freight</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong>Brokerage</strong></th>
        </tr>

        <tr style="height:20px"></tr>
 <?php $i=-1;
$r=mysql_query($q,$conn);
while($a=mysql_fetch_array($r))
{
 ?>
        <tr>
         <td style="text-align:left;"><input type="text" name="Input3" id="charges-type<?php echo $i;?>" value="<?php echo $a[category]; ?>" readonly style="border:0px;background:none;cursor:hand" size="15"  /></td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-code<?php echo $i;?>" value="<?php echo $a[code]; ?>" readonly style="border:0px;background:none;cursor:hand" size="10"  />         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-ing<?php echo $i;?>" value="<?php echo $a[description]; ?>" readonly style="border:0px;background:none;cursor:hand" size="25"  />         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-ingweight<?php echo $i;?>" value="<?php echo $a[weight]; ?>" readonly style="border:0px;background:none;cursor:hand"  size="8"  />         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-munit<?php echo $i;?>" value="<?php echo $a[unit]; ?>" readonly style="border:0px;background:none;cursor:hand"  size="8"  />         </td>
         <td width="10px"></td>
          <?php if($_SESSION['db'] == "feedatives") { ?>
		  <td>
		  <select name="freightie[]" id="frght"  style="width:80px;">
              <option <?php if($a[freightie]=='Include') echo 'selected="selected"'; ?> value="Include">Include</option>
		      <option <?php if($a[freightie]=='Exclude') echo 'selected="selected"'; ?> value="Exclude">Exclude</option>
		  </select>		   </td>
		  <?php } ?>
          <td>
		  <?php if($_SESSION['db'] == "feedatives") { ?>
			<input type="text" id="brok" name="freightamount1[]" size="8" value="<?php echo $a[freightamount] ?>" />
			<?php } else { ?> 
            <select name="freight[]" id="frght"  style="width:80px;">
              <option value="0@0@0@0">-Select-</option>
              <?php
                 include "config.php"; 
                $query = "SELECT * FROM ims_taxcodes where type='Charges' and ctype='Freight' and taxflag = 'P' ORDER BY code DESC ";
                 $result = mysql_query($query,$conn); 
                 while($row1 = mysql_fetch_assoc($result))
                 {
              ?>
              <option <?php if($row1[code]==$a[freightcode]) echo 'selected="selected"' ?> title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
              <?php } ?>
           </select>
		   <?php } ?>          </td>
          <td width="10px"></td>

          <td>
		  <?php  if($_SESSION['db'] == "feedatives") { ?>
			<input type="text" id="brok" name="brokerageamount1[]" size="8" value="<?php echo $a[brokerageamount] ?>" />
		  <?php } else if($_SESSION['db'] <> "maharashtra")
		  { ?>
            <select name="brokerage[]" id="brok"  style="width:80px;">
              <option value="0@0@0@0">-Select-</option>
              <?php
                 include "config.php"; 


                $query = "SELECT * FROM ims_taxcodes where type='Charges' and ctype='Brokerage' and taxflag = 'P' ORDER BY code DESC ";
                 $result = mysql_query($query,$conn); 
                 while($row1 = mysql_fetch_assoc($result))
                 {
              ?>
              <option <?php if($row1[code]==$a[brokeragecode]) echo 'selected="selected"' ?> title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
              <?php } ?>
            </select>
			<?php } else { ?>
			<input type="text" id="brok" name="brokerage[]" size="8" value="<?php echo $a['brokeragecode']; ?>" />
			<?php } ?>          </td>
       </tr><?php $i=$i+1; } ?>
     </table>
   <br />
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseorder'">
  </center>

</div>


<!-- /////////////////////////////Purchase Charges Ends/////////////////////////////////////////// -->


<!-- /////////////////////////////Purchase Discount Starts/////////////////////////////////////////// -->


						
<div id="tab-discounts" class="tabs-content">


  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-discounts">
        <tr>
          <th height="30" style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong><?php if($_SESSION['db']=="vista"){ ?>Weight<?php } else {?> Quantity <?php } ?></strong></th>

          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Discount</strong></th>
        </tr>

        <tr style="height:20px"></tr>
 <?php $i=-1;
$r=mysql_query($q,$conn);
while($a=mysql_fetch_array($r))
{
 ?>
        <tr>
         <td style="text-align:left;">
           <input type="text" name="" id="discounts-type<?php echo $i;?>" value="<?php echo $a[category]; ?>" readonly style="border:0px;background:none;cursor:hand" size="20"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-code<?php echo $i;?>" value="<?php echo $a[code]; ?>" readonly style="border:0px;background:none;cursor:hand" size="15"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-ing<?php echo $i;?>" value="<?php echo $a[description]; ?>" readonly style="border:0px;background:none;cursor:hand" size="25"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-ingweight<?php echo $i;?>" value="<?php echo $a[weight]; ?>" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-munit<?php echo $i;?>" value="<?php echo $a[unit]; ?>" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td>
		  
		 <?php  if($_SESSION['db'] == "feedatives") { ?>
			<input type="text" id="brok" name="discountamount1[]" size="8" value="<?php echo $a['discountamount'] ?>" />
		 <?php } else { ?>
		 
           <select name="discount[]" id="disc"  style="width:80px;">
             <option value="0@0@0@0">-Select-</option>
             <?php
                  include "config.php"; 
                $query = "SELECT * FROM ims_taxcodes where type='Discount' and taxflag = 'P' ORDER BY code DESC ";
                  $result = mysql_query($query,$conn); 
                  while($row1 = mysql_fetch_assoc($result))
                  {
            ?>
                  <option  <?php if($row1[code]==$a[discountcode]) echo 'selected="selected"' ?> title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
            <?php } ?>
          </select>
		  <?php } ?>
         </td>
       </tr><?php $i=$i+1; } ?>
     </table><input type="hidden" name="discountamount[]" id="discountamount" value="<?php echo $a[discountamount]; ?>" />
   <br />
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseorder'">
  </center>


</div>
						

<!-- /////////////////////////////Purchase Discount Ends/////////////////////////////////////////// -->





<!-- /////////////////////////////Purchase Terms & Conditions Starts/////////////////////////////////////////// -->


<div id="tab-tandc" class="tabs-content">

           <select name="disc[]" id="tandccode"  style="width:150px;" multiple onclick="getdescr(this.value)">
             <option disabled>-Select-</option>
             <?php
                  include "config.php"; 
                  $query = "SELECT * FROM ims_terms ORDER BY code DESC ";
                  $result = mysql_query($query,$conn); 
                  while($row1 = mysql_fetch_assoc($result))
                  {
				   if(strlen(strstr($tandc,$row1['description']))>0)
				    $selected = "selected='selected'";
				   else
				    $selected = "";	
            ?>
                  <option value="<?php echo $row1['code'].'@'.$row1['description']; ?>" <?php echo $selected; ?>><?php echo $row1['code']; ?></option>
            <?php } ?>
          </select><br /><br /><br />
<textarea rows="14" cols="110" id="tandcdesc" type="html" name="tandcdesc" ><?php echo $tandc; ?></textarea>

   <br />
  <center>
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_purchaseorder';">
  </center>

</div>
						
<!-- /////////////////////////////Purchase Terms & Conditions Ends/////////////////////////////////////////// -->


					</div>
					
					<!-- <div class="col200pxL-bottom">
						<p class="one-line-input grey-bg small-margin">
							<label for="complex-switch-on" class="float-left">Small switch on</label>
							<input type="checkbox" name="complex-switch-on" id="complex-switch-on" value="1" class="mini-switch" checked="checked">
						</p>
						<p class="one-line-input grey-bg clearfix">
							<label for="complex-switch-off" class="float-left">Small switch off</label>
							<input type="checkbox" name="complex-switch-off" id="complex-switch-off" value="1" class="mini-switch">
						</p>
					</div> -->
				</div>
				
			</form></div>
		</section>
		
		<div class="clear"></div>


<br />





<!-- Javascripts -->





<script type="text/javascript">


function num(a,b)
{

	if(b<48 || b>57)
	{
	 	event.keyCode=false;
		return false;
	
		
	}
	
	

}

function num1(a,b)
{

	if((b<48 || b>57) &&(b!=46))
	{
	 	event.keyCode=false;
		return false;
	
		
	}
	
	

}



function getcode()
{
	document.getElementById("vcode").value=document.getElementById("vendor").value;
}
function getvendor()
{
	document.getElementById("vendor").value=document.getElementById("vcode").value;
}
var flag = 0;
function fvalidatecurrency()
{
 flag = 1;
 var date = document.getElementById('mdate').value;
 var vendor = document.getElementById('vendor').value;
 var tdata = date + "@" + vendor + "@vendor";
 getdiv('validatecurrency',tdata,'pp_currencyframe.php?data=');
}

function getdescr(a)
{
  var out = "";
  document.getElementById("tandcdesc").innerHTML = "";
  for (var i = 0; i < document.getElementById("tandccode").options.length; i++) 
   {
      if( document.getElementById("tandccode").options[i].selected)
      {
        var test = document.getElementById("tandccode").options[i].value.split('@');
        out += test[1]+',\n';
        //out += document.getElementById("tandccode").options[i].value + '\n';
      }
   }

  document.getElementById("tandcdesc").value = out;
}


<!-- Change of Text Starts -->




function change(a)
{
 if(a == "withpr")
 {
   if(document.getElementById("complex-switch-on").checked)
   {
      document.getElementById("prtext").innerHTML="With Out Purchase Request"; 
      document.getElementById("div-pr").style.visibility="hidden";
      document.getElementById("div-po").style.visibility="visible";
      //document.getElementById("complex-switch-on").disabled = "true";
    
   }
   else
   {
      document.getElementById("prtext").innerHTML="With Purchase Request";
      document.getElementById("div-pr").style.visibility="visible";
      document.getElementById("div-po").style.visibility="hidden";
      
   }
 }
 if(a == "taxes")
 {
   if(document.getElementById("tax-switch-on").checked)
   {
      document.getElementById("taxtext").innerHTML="Same Tax for all items"; 
   }
   else
   {
      document.getElementById("taxtext").innerHTML="Different Tax for each item";
   }
 }
 if(a == "brokerage")
 {
   if(document.getElementById("brokerage-switch-on").checked)
   {
      document.getElementById("brokeragetext").innerHTML="Same Brokerage for all items"; 
   }
   else
   {
      document.getElementById("brokeragetext").innerHTML="Different Brokerage for each item";
   }
 }
 if(a == "freight")
 {
   if(document.getElementById("freight-switch-on").checked)
   {
      document.getElementById("freighttext").innerHTML="Same Freight for all items"; 
   }
   else
   {
      document.getElementById("freighttext").innerHTML="Different Freight for each item";
   }
 }
 if(a == "discounts")
 {
   if(document.getElementById("tax-switch-on").checked)
   {
      document.getElementById("taxtext").innerHTML="Same Tax for all items"; 
   }
   else
   {
      document.getElementById("taxtext").innerHTML="Different Tax for each item";
   }
 }

}




<!-- Change of Text Ends -->







var index = <?php echo $i-1;?>;





///Loading Codes 
function fun(b,f) {
  var second = b.split('/');
  var comp = second[1];
   var a = comp; 

 if(f == "pr")
  removeAllOptions(document.getElementById("prnum" + a));

  document.getElementById(f + 'ing'+ a).value = "";
  document.getElementById(f + 'ingweight'+ a).value = "";
  document.getElementById(f + 'munit'+ a).value = "";
  document.getElementById(f + 'unit'+ a).value = "";

  document.getElementById('tax-code'+ a).value = "";
  document.getElementById('tax-ing'+ a).value = "";
  document.getElementById('tax-ingweight'+ a).value = "";
  document.getElementById('tax-munit'+ a).value = "";

  document.getElementById('charges-code'+ a).value = "";
  document.getElementById('charges-ing'+ a).value = "";
  document.getElementById('charges-ingweight'+ a).value = "";
  document.getElementById('charges-munit'+ a).value = "";


  document.getElementById('delivery-code'+ a).value = "";
  document.getElementById('delivery-ing'+ a).value = "";
  document.getElementById('delivery-ingweight'+ a).value = "";
  document.getElementById('delivery-munit'+ a).value = "";

  document.getElementById('discounts-code'+ a).value = "";
  document.getElementById('discounts-ing'+ a).value = "";
  document.getElementById('discounts-ingweight'+ a).value = "";
  document.getElementById('discounts-munit'+ a).value = "";

  removeAllOptions(document.getElementById(f + "code" + a));
  myselect1 = document.getElementById(f + "code" + a);
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
			  




  if ( a == "")  {   }  else { a = "/" + a; }


   <?php

      $q2=mysql_query("select distinct(cat) from ims_itemcodes order by code ASC");
      while($nt2=mysql_fetch_array($q2)){
      echo mysql_num_rows($nt2);
      echo "if(document.getElementById(f + 'type'+ a).value == '$nt2[cat]'){";
      $q3=mysql_query("select distinct(code) from ims_itemcodes where cat ='$nt2[cat]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code ASC");
      while($nt3=mysql_fetch_array($q3))
	 { 
   ?>
 
       theOption1=document.createElement("OPTION");
       theText1=document.createTextNode("<?php echo $nt3['code']; ?>");
	 theOption1.value = "<?php echo $nt3['code']; ?>";
       theOption1.appendChild(theText1);
       myselect1.appendChild(theOption1);

			 
			 
   <?php   } echo "}"; }  ?>

 getvalues(b);
}
///End of Loading Codes










function getpo()
{
  var date1 = document.getElementById('mdate').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var poincr = new Array();
    var po = "";
  <?php 
   include "config.php"; 
   $query1 = "SELECT MAX(poincr) as poincr,m,y FROM pp_purchaseorder GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     poincr[<?php echo $k; ?>] = <?php if($row1['poincr'] < 0) { echo 0; } else { echo $row1['poincr']; } ?>;

<?php $k++; } ?>

for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(poincr[l] < 10)
     po = 'PO'+'-'+m+y+'-000'+parseInt(poincr[l]+1);
   else if(poincr[l] < 100 && poincr[l] >= 10)
     po = 'PO'+'-'+m+y+'-00'+parseInt(poincr[l]+1);
   else
     po = 'PO'+'-'+m+y+'-0'+parseInt(poincr[l]+1);
     document.getElementById('poincr').value = parseInt(poincr[l] + 1);
  break;
  }
 else
  {
   po = 'PO'+'-'+m+y+'-000'+parseInt(1);
   document.getElementById('poincr').value = 1;
  }
}
document.getElementById('po').value = po;
document.getElementById('m').value = m;
document.getElementById('y').value =y;

}













///Filling Description from code ///////
function description(b,f)
{



 var y = b.substr(0,6);
 var x = b.substr(0,4);
 if(y == "prcode" || x == "code")
 {
  if(f == "pr")
    a = b.substr(6);
  else
    a = b.substr(4);
	
 if(f == "pr")
  removeAllOptions(document.getElementById("prnum" + a));

  document.getElementById(f + 'ing'+ a).value = "";
  document.getElementById(f + 'ingweight'+ a).value = "";
  document.getElementById(f + 'munit'+ a).value = "";
  document.getElementById(f + 'unit'+ a).value = "";

  document.getElementById('tax-code'+ a).value = "";
  document.getElementById('tax-ing'+ a).value = "";
  document.getElementById('tax-ingweight'+ a).value = "";
  document.getElementById('tax-munit'+ a).value = "";

  document.getElementById('charges-code'+ a).value = "";
  document.getElementById('charges-ing'+ a).value = "";
  document.getElementById('charges-ingweight'+ a).value = "";
  document.getElementById('charges-munit'+ a).value = "";


  document.getElementById('delivery-code'+ a).value = "";
  document.getElementById('delivery-ing'+ a).value = "";
  document.getElementById('delivery-ingweight'+ a).value = "";
  document.getElementById('delivery-munit'+ a).value = "";

  document.getElementById('discounts-code'+ a).value = "";
  document.getElementById('discounts-ing'+ a).value = "";
  document.getElementById('discounts-ingweight'+ a).value = "";
  document.getElementById('discounts-munit'+ a).value = "";
}






    var a = index;  var j = index;  
   var i1,j1;
//alert(f);
if(f != "pr")
{
}
else
{
   for(var i = -1;i<=index;i++) 
   {
	for(var j = -1;j<=index;j++)
	{
		if(i == -1)
		i1 = "";
		else
		i1=i;
		
		if(j == -1)
		j1 = "";
		else
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById(f + 'code' + i1).value == document.getElementById(f + 'code' + j1).value)
			{
				document.getElementById(f + 'ing' + a).value = "";
				alert("Please select different combination");
				return;
			}
		}
	}
   }
}
 



  for ( var i = -1;i<=index;i++)
   {
     
     
	var j = i;
	






   <?php
 	 $q = "select * from ims_itemcodes order by code";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById(f + 'code' + j).value == '$qr[code]') { ";
   ?>
	
   

	
            document.getElementById(f + 'ing' + j).value = "<?php echo $qr['description']; ?>";
 	      document.getElementById(f + 'munit' + j).value = "<?php echo $qr['sunits']; ?>";
		
    <?php echo " } "; }?>








		

if(f == "pr")
{
 var y = b.substr(0,6);
 if(y == "prcode")
 {
  a = b.substr(6);
  //alert(a);



  removeAllOptions(document.getElementById("prnum" + a));
  myselect1 = document.getElementById("prnum" + a);
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);


   <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prcode' + a).value == '$qr[icode]') { ";
   ?>
	
   
	
       theOption1=document.createElement("OPTION");
       theText1=document.createTextNode("<?php echo $qr['pi']; ?>");
	 theOption1.value = "<?php echo $qr['pi']; ?>";
       theOption1.appendChild(theText1);
       myselect1.appendChild(theOption1);

		
    <?php echo " } "; }?>
  }

}


   }

getvalues(b);
}
///End Of Description from code /////






function getvalues(b)
{
 var f = b.substr(0,2);
 if(f == "pr") { b = b.substr(2); c = f + b; d = "pr"; } else { c = b; d = "";}
 var type = b.substr(0,4);
 var num = b.substr(4);
 /*document.getElementById("tax-" + b).value = document.getElementById(c).value;
 document.getElementById("charges-" + b).value = document.getElementById(c).value;
 document.getElementById("delivery-" + b).value = document.getElementById(c).value;
 document.getElementById("discounts-" + b).value = document.getElementById(c).value;
*/
 if(type == "code")
 {
  document.getElementById("tax-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("tax-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("charges-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("charges-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("delivery-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("delivery-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("discounts-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("discounts-munit" + num).value = document.getElementById(d + "munit" + num).value;


 if(f == "pr")
 {

   <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prcode' + num).value == '$qr[icode]') { ";
   ?>
	
    if(num == "")
     document.getElementById("doffice" + num).value = "<?php echo $qr['doffice']; ?>";
    else
     document.getElementById("doffice/" + num).value = "<?php echo $qr['doffice']; ?>";
   
     getemp("doffice/" + num)
     document.getElementById("demp" + num).value = "<?php echo $qr['receiver']; ?>";


		
    <?php echo " } "; }?>
  }
 }
}










function prdetails(b)
{
   if(index == -1) { var a = ""; var j = 0; } else { var a = index;  var j = index;   }
   var i1,j1;
   for ( var i = -1;i<=index;i++)
   {
     if ( i == -1)
      var j = "";
     else
	var j = i;
    <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prnum' + j).value == '$qr[pi]') { ";
    ?>
	
            document.getElementById('pringweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('prrdate' + j).value = "<?php echo $qr['rdate']; ?>";

            document.getElementById('tax-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('discounts-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('charges-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('delivery-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
		
    <?php echo " } "; }?>
   }
}








function getemp(b)
{
var second = b.split('/');
var comp = second[1];
if(comp >= 0){
var a = comp;
}
else {
var a = "";
}

removeAllOptions(document.getElementById("demp" + a));
			 myselect1 = document.getElementById("demp" + a);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
               myselect1.appendChild(theOption1);
			   
			   if ( a == "")
			  {
			  
			   }
			  else
			  {
			   a = "/" + a;
			  }
 <?php
     $q2=mysql_query("select distinct(sector) from employee ORDER BY sector ASC ");
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('doffice'+a).value == '$nt2[sector]'){";
     $q3=mysql_query("select distinct(name) from employee where sector='$nt2[sector]' ORDER BY name ASC ");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
             //echo "document.getElementById('place').value = '$nt3[place]';";
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['name']; ?>");
			  theOption1.value = "<?php echo $nt3['name']; ?>";
			  theOption1.title = "<?php echo $nt3['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);

    <?php   } // end of while loop
      echo "}"; // end of JS if condition
     }
  ?>
} 



function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function calculate(a)

{
if(document.getElementById("vendor").value == "")
{
alert("select vendor");
document.getElementById("vendor").focus();
return false;
}
/*if(document.getElementById("broker").value == "")
{
//alert("select vendor");
document.getElementById("broker").focus();
return false;
}*/
if(document.getElementById("mdate").value == "")
{
alert("select vendor");
document.getElementById("mdate").focus();
return false;
}






 if(index == -1)
 {
   if(document.getElementById("type").value != "")
   {

     <!-- Tax Start -->

       var a1 = document.getElementById("tax").value;
       a1 = a1.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
       var formula = a1[2];
       var A = parseFloat(document.getElementById("ingweight").value * document.getElementById("unit").value);
       var withtax = eval(formula);
       document.getElementById("taxamount").value = withtax;

     <!-- Freight Start -->

       var a2 = document.getElementById("frght").value;
       a2 = a2.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a2[1]);
       <?php } ?>
       var formula2 = a2[2];
       var withfreight = eval(formula2);
       document.getElementById("freightamount").value = withfreight;

     <!-- Brokerage Start -->

       var a3 = document.getElementById("brok").value;
       a3 = a3.split('@');
       <?php
           include "config.php";  

           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a3[1]);
       <?php } ?>
       var formula3 = a3[2];
       var withbrokerage = eval(formula3);
       document.getElementById("brokerageamount").value = withbrokerage;

     <!-- discount Start -->

       var a4 = document.getElementById("disc").value;
       a4 = a4.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a4[1]);
       <?php } ?>
       var formula4 = a4[2];
       var withdiscount = eval(formula4);
       document.getElementById("discountamount").value = withdiscount;

   }
 }
 else
 {
  for(var k = 0;k<=index;k++)
  { 

   if(document.getElementById("type").value != "")
   {

     <!-- Tax Start -->

       var a1 = document.getElementById("tax").value;
       a1 = a1.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
       var formula = a1[2];
       var A = parseFloat(document.getElementById("ingweight").value * document.getElementById("unit").value);
       var withtax = eval(formula);
       document.getElementById("taxamount").value = withtax;


     <!-- Freight Start -->

       var a2 = document.getElementById("frght").value;
       a2 = a2.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a2[1]);
       <?php } ?>
       var formula2 = a2[2];
       var withfreight = eval(formula2);
       document.getElementById("freightamount").value = withfreight;

     <!-- Brokerage Start -->

       var a3 = document.getElementById("brok").value;
       a3 = a3.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a3[1]);
       <?php } ?>
       var formula3 = a3[2];
       var withbrokerage = eval(formula3);
       document.getElementById("brokerageamount").value = withbrokerage;

     <!-- Discount Start -->

       var a4 = document.getElementById("disc").value;
       a4 = a4.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a4[1]);
       <?php } ?>
       var formula4 = a4[2];
       var withdiscount = eval(formula4);
       document.getElementById("discountamount").value = withdiscount;


   }

   if(document.getElementById("type/" + k).value != "")
   {

     <!-- Tax Start -->

       var a1 = document.getElementById("tax" + k).value;
       //alert(a1);
       a1 = a1.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
       var formula = a1[2];
       var A = parseFloat(document.getElementById("ingweight" + k).value * document.getElementById("unit" + k).value);
       var withtax = eval(formula);
       document.getElementById("taxamount" + k).value = withtax;


     <!-- Freight Start -->

       var a2 = document.getElementById("frght" + k).value;
       a2 = a2.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a2[1]);
       <?php } ?>
       var formula2 = a2[2];
       var withfreight = eval(formula2);
       document.getElementById("freightamount" + k).value = withfreight;

     <!-- Brokerage Start -->

       var a3 = document.getElementById("brok" + k).value;
       a3 = a3.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a3[1]);
       <?php } ?>
       var formula3 = a3[2];
       var withbrokerage = eval(formula3);
       document.getElementById("brokerageamount" + k).value = withbrokerage;

     <!-- Discount Start -->

       var a4 = document.getElementById("disc" + k).value;
       a4 = a4.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a4[1]);
       <?php } ?>
       var formula4 = a4[2];
       var withdiscount = eval(formula4);
       document.getElementById("discountamount" + k).value = withdiscount;


   }
  }
 }
if((document.getElementById("type").value != "") && (document.getElementById("doffice").value == ""))
 {
 alert("Please select appropriate Delivery Location in Delivery Details section");
 return false;
 }
 else
 {
  for(var k = 0;k<=index;k++)
  {
  if((document.getElementById("type/"+k).value != "") && (document.getElementById("doffice/"+k).value == ""))
  {
   alert("Please select appropriate Delivery Location in Delivery Details section");
   return false;
  }
  }
 }

	<?php if($_SESSION['db'] == 'central') { ?>
	if(flag == 1)
	if(document.getElementById('validate').value == 0)
	{
	 alert("Enter Currency conversion for this date");
	 return false;
	}
	alert("came");
	document.form1.action = "pp_savepurchaseorder2.php";
	<?php } ?>



if(confirm('Are u sure you want to Update the entry'))
{
  return true;
}
else
{
  return false; 
}
}

</script>

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_addpurchaseorder.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=no');
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


