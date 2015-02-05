 <?php  include "config.php"; 
       include "jquery.php";

if(!isset($_GET['vendor']))
$vendor = "";
else
$vendor = $_GET['vendor'];

if(!isset($_GET['type']))
$type = "";
else
$type = $_GET['type'];

if(!isset($_GET['ge']))
$ge = "";
else
$ge = $_GET['ge'];

?>

<br /> 
<center>
<h1>Goods Receipt</h1>&nbsp;&nbsp;&nbsp;&nbsp;
</center>

<form id="form1" name="form1" method="post" action="pp_savegoodsreceipt_a.php"> 


<br />
<br />

<table align="center" border="0">
<tr>
<td><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y"); ?>" size="15"/>&nbsp;</td>
<td align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><select name="type" id="type"  onchange="gettype(this.value);">
 <option value="">-Select-</option>
<option value="vendor" <?php if($type == "vendor") { ?> selected="selected"<?php } ?>>Vendor</option>
<option value="broker" <?php if($type == "broker") { ?> selected="selected"<?php } ?> >Broker</option>
</select>&nbsp;&nbsp;&nbsp;
</td>
<td align="right"><strong>Vendor/Broker</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select id="vendor" name="vendor" onChange=" <?php if($_SESSION['db']=='albustan' || $_SESSION['db'] == "albustanlayer"){ ?> document.getElementById('vendorcode').value=this.value ;<?php } ?> getges(this.value);"><option value="">-Select-</option>
<?php 
if($type == "vendor")
{
$query = "SELECT distinct(vendor) FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'"; $result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
<option value="<?php echo $row1['vendor'];?>" <?php if($row1['vendor'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $row1['vendor'];?></option>
<?php }  }
else if($type == "broker")
{
$query = "SELECT distinct(broker) FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'"; $result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
<option value="<?php echo $row1['broker'];?>" <?php if($row1['broker'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $row1['broker'];?></option>
<?php } }?>
</select>&nbsp;
</td>
<?php if($_SESSION['db']=='albustan' || $_SESSION['db'] == "albustanlayer"){ ?>
<td align="right"><strong>Vendor/Broker Code</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select  id="vendorcode" name="vendorcode" onChange=" document.getElementById('vendor').value=this.value; getges(this.value);"><option value="">-Select-</option>
<?php 
if($type == "vendor")
{
$query = "SELECT distinct(vendor),vendorcode FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'"; $result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
<option value="<?php echo $row1['vendor'];?>" <?php if($row1['vendor'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $row1['vendorcode'];?></option>
<?php }  }
else if($type == "broker")
{
$query = "SELECT distinct(broker) FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'"; $result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
<option value="<?php echo $row1['broker'];?>" <?php if($row1['broker'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $row1['broker'];?></option>
<?php } }?>
</select>&nbsp;
</td>
<?php } ?>
<td align="right"><strong>Gate Entry #</strong>&nbsp;&nbsp;&nbsp;</td>
<td><select name="ge" id="ge" style="width:140px" onChange="fun1();"><option value="">-Select-</option>
<?php 
if($type == "vendor")
{
$query = "SELECT distinct(ge),vendor,vendorid FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'"; $result = mysql_query($query,$conn) or die(mysql_error()); 
     while($row1 = mysql_fetch_assoc($result)) { 
	 if($vendor == $row1['vendor']) { ?>
<option value="<?php echo $row1['ge']; ?>" <?php if($ge == $row1['ge']) { ?> selected="selected" <?php } ?>><?php echo $row1['ge']; ?></option>
<?php }}}

if($type == "broker")
{
$query = "SELECT distinct(ge),broker FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'"; $result = mysql_query($query,$conn) or die(mysql_error()); 
     while($row1 = mysql_fetch_assoc($result)) { 
	 if($vendor == $row1['broker']) { ?>
<option value="<?php echo $row1['ge']; ?>" <?php if($ge == $row1['ge']) { ?> selected="selected" <?php } ?>><?php echo $row1['ge']; ?></option>
<?php }}}?>

</select>&nbsp;
<input type="hidden" id="brokerid" name="brokerid" value="<?php echo $brokerid; ?>" />
<input type="hidden" id="broker" name="broker" value="<?php echo $broker; ?>" />
</td>
</tr>
</table>

<br /><br />
<table border="0" align="center">
<tr>
<th><strong>PO #</strong></th>

<th><strong>Gate Entry #</strong></th>
<th width="10px"></th>
<th><strong>Item Code</strong></th>
<th width="10px"></th>
<th><strong>Item Description</strong></th>
<th width="10px"></th>
<th><strong>Accepted Quantity</strong></th>
<th width="10px"></th>
<th><strong>Receiving Quantity</strong></th>
<th width="10px"></th>
<th><strong>Shrinkage</strong></th>
<th width="10px"></th>
<th><strong>Units</strong></th>
<th width="10px"></th>
<th><strong>Bag Type</strong></th>
<th width="10px"></th>
<th><strong>Bags</strong></th>
<th width="10px"></th>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
<th width="10px"></th>
<th><strong>Batch No.</strong></th>
<th width="10px"></th>
<th><strong>Expiry Date</strong></th>
<th width="10px"></th>

<?php
}
?>
</tr>
<tr style="height:20px"></tr>
<?php $i = 0; 
if($type == "vendor")
{
$query1 = "select * from pp_gateentry where vendor = '$vendor' AND ge = '$ge' and qcaflag = '1' AND grflag = '0' order by combinedpo,desc1";
}
else if($type == "broker")
{
$query1 = "select * from pp_gateentry where broker = '$vendor' AND ge = '$ge' and qcaflag = '1' AND grflag = '0' order by combinedpo,desc1";
}
$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($row1 = mysql_fetch_assoc($result1))
	{ 

?>

<tr>
<input type="hidden" id="vid" name="vid[]" value="<?php echo $row1['id'];?>" />
<td><input readonly size="12" style="background:none; border:none;text-align:center;" type="text" name="po[]" id="po<?php echo $i; ?>" value="<?php echo $row1['combinedpo'];?>" /></td>

<td><input readonly size="15" style="background:none; border:none;text-align:center;" type="text" name="geno[]" id="geno<?php echo $i; ?>" value="<?php echo $row1['ge'];?>" /></td>
<td width="10px"></td>
<td><input readonly size="8" style="background:none; border:none;text-align:center;" type="text" name="itemcode[]" id="itemcode<?php echo $i; ?>" value="<?php echo $row1['code'];?>" /></td>
<td width="10px"></td>
<td><input readonly size="15" style="background:none; border:none;text-align:left;" type="text" name="description[]" id="description<?php echo $i; ?>" value="<?php echo $row1['desc1'];?>" /></td>
<td width="10px"></td>
<td align="center"><input readonly size="7" type="text" style="background:none; border:none;text-align:right;" name="aquantity[]" id="aquantity<?php echo $i; ?>" value="<?php echo $row1['receivedquantity'];?>" /></td>
<td width="10px"></td>
<td align="center"><?php if($ge != "" && $vendor != "") { ?><input size="7" type="text" style="text-align:right" name="rquantity[]" id="rquantity<?php echo $i; ?>" value="<?php echo 0; ?>" onKeyUp="calc(<?php echo $i; ?>);" /><?php } ?></td>
<td width="10px"></td>
<td align="center"><input  readonly size="5" type="text" style="background:none; border:none;text-align:right;" name="shrinkage[]" id="shrinkage<?php echo $i; ?>" value="<?php echo $row1['receivedquantity'];?>"  /></td>
<td width="10px"></td>
<td><input readonly size="5" style="background:none; border:none;text-align:center;" type="text" name="units[]" id="units<?php echo $i; ?>" value="<?php echo $row1['unit'];?>" /></td>
<td width="10px"></td>
<td><?php if($ge != "" && $vendor != "") { ?><select id="bagtype<?php echo $i; ?>" name="bagtype[]"><option value="">-Select-</option>
<?php $query2 = "SELECT code,description,sunits FROM ims_itemcodes WHERE type =  'Packing Material' ORDER BY code";
      $result2 = mysql_query($query2,$conn);
      while($row2 = mysql_fetch_assoc($result2)) { ?>
<option title="<?php echo $row2['description']; ?>" value="<?php echo $row2['code'].'@'.$row2['description'].'@'.$row2['sunits']; ?>"><?php echo $row2['code']; ?></option>
<?php } ?>
            </select><?php } ?></td>
<td width="10px"></td>
<td><?php if($ge != "" && $vendor != "") { ?><input size="5" type="text" name="bags[]" style="text-align:right" id="bags<?php echo $i; ?>" value="0"  /><?php } ?></td>
<td width="10px"></td>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
$query10 = "SELECT cat FROM ims_itemcodes WHERE code = '$row1[code]'";
$result10 = mysql_query($query10,$conn) or die(mysql_error());
$rows10 = mysql_fetch_assoc($result10);
$cat = $rows10['cat'];
if($cat == 'Medicines' || $cat == 'Vaccines')
{
?>
<td width="10px"></td>
<td><input size="10" type="text" name="batch[<?php echo $i; ?>]" style="text-align:right" id="batch<?php echo $i; ?>" /></td>
<td width="10px"></td>
<td><input type="text" id="expdate<?php echo $i; ?>" name="expdate[<?php echo $i; ?>]" class="datepicker" value="<?php echo date("d.m.Y"); ?>" size="15"/></td>
<td width="10px"></td>
<?php
}
}
?>
</tr>

<!-- hiddden variables ---->
<input value="<?php echo $row1['rateperunit']; ?>" type="hidden" id="rateperunit<?php echo $i; ?>" name="rateperunit[]" />
<!--<input value="<?php echo $row1['unit']; ?>" type="hidden" id="units<?php echo $i; ?>" name="units[]" />-->
<input value="<?php echo $row1['tandccode']; ?>" type="hidden" id="tandccode<?php echo $i; ?>" name="tandccode[]" />
<input value="<?php echo $row1['tandc']; ?>" type="hidden" id="tandc<?php echo $i; ?>" name="tandc[]" />

<input value="<?php echo $row1['credittermcode']; ?>" type="hidden" id="credittermcode<?php echo $i; ?>" name="credittermcode[]" />
<input value="<?php echo $row1['credittermdescription']; ?>" type="hidden" id="credittermdescription<?php echo $i; ?>" name="credittermdescription[]" />
<input value="<?php echo $row1['credittermvalue']; ?>" type="hidden" id="credittermvalue<?php echo $i; ?>" name="credittermvalue[]" />


<input type="hidden" id="taxcode<?php echo $i;?>" name="taxcode[]" value="<?php echo $row1['taxcode'];?>" />
<input type="hidden" id="taxvalue<?php echo $i;?>" name="taxvalue[]" value="<?php echo $row1['taxvalue'];?>" />
<input type="hidden" id="taxamount<?php echo $i;?>" name="taxamount[]" value="<?php echo $row1['taxamount']; ?>" />
<input type="hidden" id="taxformula<?php echo $i;?>" name="taxformula[]" value="<?php echo $row1['taxformula'];?>" />
<input type="hidden" id="taxie<?php echo $i;?>" name="taxie[]" value="<?php echo $row1['taxie'];?>" />

<input type="hidden" id="freightcode<?php echo $i;?>" name="freightcode[]" value="<?php echo $row1['freightcode'];?>" />
<input type="hidden" id="freightvalue<?php echo $i;?>" name="freightvalue[]" value="<?php echo $row1['freightvalue'];?>" />
<input type="hidden" id="freightamount<?php echo $i;?>" name="freightamount[]" value="<?php echo $row1['freightamount']; ?>" />
<input type="hidden" id="freightformula<?php echo $i;?>" name="freightformula[]" value="<?php echo $row1['freightformula'];?>" />
<input type="hidden" id="freightie<?php echo $i;?>" name="freightie[]" value="<?php echo $row1['freightie'];?>" />

<input type="hidden" id="brokeragecode<?php echo $i;?>" name="brokeragecode[]" value="<?php echo $row1['brokeragecode'];?>" />
<input type="hidden" id="brokeragevalue<?php echo $i;?>" name="brokeragevalue[]" value="<?php echo $row1['brokeragevalue'];?>" />
<input type="hidden" id="brokerageamount<?php echo $i;?>" name="brokerageamount[]" value="<?php echo $row1['brokerageamount']; ?>" />
<input type="hidden" id="brokerageformula<?php echo $i;?>" name="brokerageformula[]" value="<?php echo $row1['brokerageformula'];?>" />
<input type="hidden" id="brokerageie<?php echo $i;?>" name="brokerageie[]" value="<?php echo $row1['brokerageie'];?>" />

<input type="hidden" id="discountcode<?php echo $i;?>" name="discountcode[]" value="<?php echo $row1['discountcode'];?>" />
<input type="hidden" id="discountvalue<?php echo $i;?>" name="discountvalue[]" value="<?php echo $row1['discountvalue'];?>" />
<input type="hidden" id="discountamount<?php echo $i;?>" name="discountamount[]" value="<?php echo $row1['discountamount']; ?>" />
<input type="hidden" id="discountformula<?php echo $i;?>" name="discountformula[]" value="<?php echo $row1['discountformula'];?>" />
<input type="hidden" id="discountie<?php echo $i;?>" name="discountie[]" value="<?php echo $row1['discountie'];?>" />

<input type="hidden" id="finalcost<?php echo $i;?>" name="finalcost[]" value="<?php echo $row1['finalcost'];?>" />

<input type="hidden" id="pocost<?php echo $i;?>" name="pocost[]" value="<?php echo $row1['pocost'];?>" />
<input type="hidden" id="warehouse<?php echo $i; ?>" name="warehouse[]" value="<?php echo $row1['warehouse']; ?>" />
<?php $i++; } ?>
<tr style="height:20px"></tr>
</table>
<br>
<center>
<table>
<td style="vertical-align:middle;"><strong>Remarks&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br>



<input type="submit" id="save" value="Save" />&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_goodsreceipt_a'"/>

</center>
</form>

<script type="text/javascript">


function fun()
{
	var vendor = document.getElementById('vendor').value;
	document.location = "dashboardsub.php?page=pp_addgoodsreceipt_a&ge=" + "&vendor=" + vendor;
}

function fun1()
{
	var ge = document.getElementById('ge').value;
	var vendor = document.getElementById('vendor').value;
	var type = document.getElementById('type').value;
	document.location = "dashboardsub.php?page=pp_addgoodsreceipt_a&ge=" + ge + "&vendor=" + vendor + "&type=" +type;
}

function calc(i)
{ 
	if(document.getElementById("rquantity" + i).value == "")
	{
		document.getElementById("rquantity" + i).value = 0;
	}
	<?php if($_SESSION['client'] != 'FEEDATIVES')
{
?>
	if(parseFloat(document.getElementById("rquantity" + i).value) > parseFloat(document.getElementById("aquantity" + i).value))
	{
		<?php if($_SESSION['db'] != 'skdnew') 
			   {
			   ?>
			alert("Receiving Quantity should be less than or equal to Accepted Quantity");
			document.getElementById("rquantity" + i).value = 0;
		<?php } ?>
	}
<?php } ?>	
	document.getElementById("shrinkage" + i).value = parseFloat(parseFloat(document.getElementById("aquantity" + i).value) - parseFloat(document.getElementById("rquantity" + i).value));
}

function calculate(i)
{

	   var taxcode = document.getElementById('taxcode' + i).value;
	   var taxvalue = document.getElementById('taxvalue' + i).value;
	   var taxformula = document.getElementById('taxformula' + i).value;
	  
	   var freightcode = document.getElementById('freightcode' + i).value;
	   var freightvalue = document.getElementById('freightvalue' + i).value;
	   var freightformula = document.getElementById('freightformula' + i).value;
 	
	   var brokeragecode = document.getElementById('brokeragecode' + i).value;
	   var brokeragevalue = document.getElementById('brokeragevalue' + i).value;
	   var brokerageformula = document.getElementById('brokerageformula' + i).value;

	   var discountcode = document.getElementById('discountcode' + i).value;
	   var discountvalue = document.getElementById('discountvalue' + i).value;
	   var discountformula = document.getElementById('discountformula' + i).value;
	   
	   var taxamount = 0;
	   var freightamount = 0;
	   var brokerageamount = 0;
	   var discountamount = 0;
	   
       var A = parseFloat(document.getElementById("aquantity" + i).value * document.getElementById("rateperunit" + i).value);
//////////// With Tax, amount calculation /////////////////
       <?php
           include "config.php";  
		   $q = "select distinct(code) from ims_taxcodes where type = 'Tax' order by code DESC";
		   $qrs = mysql_query($q,$conn) or die(mysql_error());
		   while($qr = mysql_fetch_assoc($qrs))
		   {
		   echo " if(taxcode == '$qr[code]') {";
		   
           $query = "SELECT distinct(code) FROM ims_taxcodes where code = '$qr[code]' ORDER BY code DESC ";
           $result = mysql_query($query,$conn) or die(mysql_error());
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(taxvalue);
       <?php } echo "}"; } ?>
	   
       var withtax = eval(taxformula);
       document.getElementById("taxamount" + i).value = withtax - A;

//////////// With Freight, amount calculation /////////////////

       <?php
           include "config.php";  
		   $q = "select distinct(code) from ims_taxcodes where type = 'Charges' and ctype = 'Freight' order by code DESC";
		   $qrs = mysql_query($q,$conn) or die(mysql_error());
		   while($qr = mysql_fetch_assoc($qrs))
		   {
		   echo " if(freightcode == '$qr[code]') {";
		   
           $query = "SELECT distinct(code) FROM ims_taxcodes where code = '$qr[code]' ORDER BY code DESC ";
           $result = mysql_query($query,$conn) or die(mysql_error());
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(freightvalue);
       <?php } echo "}"; } ?>
       
       var withfreight = eval(freightformula);
       document.getElementById("freightamount" + i).value = withfreight - A;

//////////// With Brokerage, amount calculation /////////////////

       <?php
           include "config.php";  
		   $q = "select distinct(code) from ims_taxcodes where type = 'Charges' and ctype = 'Brokerage' order by code DESC";
		   $qrs = mysql_query($q,$conn) or die(mysql_error());
		   while($qr = mysql_fetch_assoc($qrs))
		   {
		   echo " if(brokeragecode == '$qr[code]') {";
		   
           $query = "SELECT distinct(code) FROM ims_taxcodes where code = '$qr[code]' ORDER BY code DESC ";
           $result = mysql_query($query,$conn) or die(mysql_error());
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(brokeragevalue);
       <?php } echo "}"; } ?>
       
       var withbrokerage = eval(brokerageformula);
       document.getElementById("brokerageamount" + i).value = withbrokerage - A;

//////////// With Discount, amount calculation /////////////////

       <?php
           include "config.php";  
		   $q = "select distinct(code) from ims_taxcodes where type = 'Discount' order by code DESC";
		   $qrs = mysql_query($q,$conn) or die(mysql_error());
		   while($qr = mysql_fetch_assoc($qrs))
		   {
		   echo " if(discountcode == '$qr[code]') {";
		   
           $query = "SELECT distinct(code) FROM ims_taxcodes where code = '$qr[code]' ORDER BY code DESC ";
           $result = mysql_query($query,$conn) or die(mysql_error());
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(discountvalue);
       <?php 
	   		} echo "}"; } 
	   ?>
       
       var withdiscount = eval(discountformula);
       document.getElementById("discountamount" + i).value = A - withdiscount;
       if(withtax == "" || withtax == 0) withtax = A;
       if(withfreight == "" || withfreight == 0) withfreight = A;
       if(withdiscount == "" || withdiscount == 0) withdiscount = A;
       if(withbrokerage == "" || withbrokerage == 0) withbrokerage = A;
}



function enable()
{
	if(document.getElementById('pocheck').checked == true)
	{
	document.getElementById('potd').style.visibility = "visible";
	document.getElementById('qctd').style.visibility = "hidden";
	}
	else if(document.getElementById('qccheck').checked == true)
	{
	document.getElementById('potd').style.visibility = "hidden";
	document.getElementById('qctd').style.visibility = "visible";
	}
}
function gettype(z)
{
if(z == "vendor")
{
gettypeven();
}
else if(z == "broker")
{
gettypebro();
}
}

function gettypeven()
{
removeAllOptions(document.getElementById("vendor"));
   myselect1 = document.getElementById("vendor");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
   <?php if($_SESSION['db']=='albustan' || $_SESSION['db'] == "albustanlayer"){ ?>
   removeAllOptions(document.getElementById("vendorcode"));
   myselect2 = document.getElementById("vendorcode");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect2.appendChild(theOption1);
   <?php } ?>
   
<?php $query = "SELECT distinct(vendor),vendorcode FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0' order by vendor"; 
$result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row1['vendor'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['vendor'];?>";
                     myselect1.appendChild(theOption1);
					 
					 <?php if($_SESSION['db']=='albustan' || $_SESSION['db'] == "albustanlayer"){ ?>
                      theOption1=document.createElement("OPTION");
                      theText1=document.createTextNode("<?php echo $row1['vendorcode'];?>");
			          theOption1.appendChild(theText1);
			          theOption1.value = "<?php echo $row1['vendor'];?>";
                      myselect2.appendChild(theOption1);
                      <?php } ?>
					 
<?php } ?>
}
function gettypebro()
{
removeAllOptions(document.getElementById("vendor"));
   myselect1 = document.getElementById("vendor");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
   <?php if($_SESSION['db']=='albustan' || $_SESSION['db'] == "albustanlayer"){ ?>
   removeAllOptions(document.getElementById("vendorcode"));
   myselect2 = document.getElementById("vendorcode");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect2.appendChild(theOption1);
   <?php } ?>

<?php $query = "SELECT distinct(broker) FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0' order by broker"; 
$result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
	  
	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row1['broker'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['broker'];?>";
                     myselect1.appendChild(theOption1);
					 <?php if($_SESSION['db']=='albustan' || $_SESSION['db'] == "albustanlayer"){ ?>
					 theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row1['broker'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['broker'];?>";
                     myselect2.appendChild(theOption1);
					 <?php } ?>
<?php } ?>
}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{

		selectbox.remove(i);
	}
}
function getges(ven)
{
if(document.getElementById("type").value == "vendor")
{
getgeven(ven);
}
else if(document.getElementById("type").value == "broker")
{
getgebro(ven);
}
}

function getgeven(ve)
{
removeAllOptions(document.getElementById("ge"));
   myselect1 = document.getElementById("ge");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
 

<?php $query = "SELECT distinct(ge),vendor,vendorid FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0' AND aflag='1'";
      $result = mysql_query($query,$conn) or die(mysql_error()); 
     while($row1 = mysql_fetch_assoc($result)) { 
	 echo "if(ve == '$row1[vendor]') { ";
	 ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row1['ge'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['ge'];?>";
                     myselect1.appendChild(theOption1);
<?php echo "}"; } ?>
}

function getgebro(ve)
{
removeAllOptions(document.getElementById("ge"));
   myselect1 = document.getElementById("ge");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
 

<?php $query = "SELECT distinct(ge),broker,brokerid FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'"; $result = mysql_query($query,$conn) or die(mysql_error()); 
     while($row1 = mysql_fetch_assoc($result)) { 
	 echo "if(ve == '$row1[broker]') { ";
	 ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row1['ge'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['ge'];?>";
                     myselect1.appendChild(theOption1);
<?php echo "}"; } ?>
}

</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_addgoodsreceipt.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
