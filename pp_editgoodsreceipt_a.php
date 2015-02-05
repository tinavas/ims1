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

$query = "select * from pp_goodsreceipt where gr='$_GET[id]'";
$gresult = mysql_query($query,$conn);
$gres = mysql_fetch_assoc($gresult); 
$remarks = $gres['remarks'];
$aflag = $gres['aflag'];
?>

<br />
<center>
<h1>Goods Receipt</h1>&nbsp;&nbsp;&nbsp;&nbsp;
</center>

<form id="form1" name="form1" method="post" action="<?php if($aflag == 0) { ?> pp_updategoodsreceipt_a1.php <?php } else { ?> pp_updategoodsreceipt_a.php <?php } ?>"> 

<br />
<br />
<table align="center" border="0">
<tr>
<td><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y",strtotime($gres['date'])); ?>" size="15"/>&nbsp;</td>
<td align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><select name="type" id="type"  onchange="gettype(this.value);">
<?php if($gres['vendor']!='') { ?> 
 <option value="vendor" selected="selected">Vendor</option>
 <?php } else { ?>
<option value="broker"  selected="selected" >Broker</option>
<?php }?>
</select>&nbsp;&nbsp;&nbsp;
</td>
<td align="right"><strong>Vendor/Broker</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select id="vendor" name="vendor" onChange="getges(this.value);">
<?php if($gres['vendor']!='') {?>
<option value="<?php echo $gres['vendor']; ?>"><?php echo $gres['vendor']; ?></option>
<?php } else {?>
<option value="<?php echo $gres['broker']; ?>"><?php echo $gres['broker']; ?></option>
<?php } ?>
</select>&nbsp;
<input type="hidden" id="vid" name="vid" value="<?php if($gres['vendorid'] > 0) echo $gres['vendorid']; else if($gres['vendorid']== 0 && $gres['brokerid'] == 0) echo 0; else echo $gres['brokerid'];?>" /> 
</td>
<td align="right"><strong>Gate Entry #</strong>&nbsp;&nbsp;&nbsp;</td>
<td><select name="ge" id="ge" style="width:140px" onChange="fun1();">
<option value="<?php echo $gres['ge']; ?>"selected="selected"><?php echo $gres['ge']; ?></option>
</select>&nbsp;
<input type="hidden" id="brokerid" name="brokerid" value="<?php echo brokerid; ?>" />
<input type="hidden" id="broker" name="broker" value="<?php echo $broker; ?>" />
</td>
</tr>
</table>

<br /><br />
<table border="0" align="center">
<tr>
<th><strong>Puchase Order #</strong></th>
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

$query1 = "select * from pp_goodsreceipt where gr = '$_GET[id]'";

$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($gres = mysql_fetch_assoc($result1))
	{ 

?>

<tr>


<td><input readonly size="15" style="background:none; border:none;text-align:center;" type="text" name="po[]" id="po<?php echo $i; ?>" value="<?php echo $gres['po'];?>" /></td>
<td width="10px"></td>
<td><input readonly size="8" style="background:none; border:none;text-align:center;" type="text" name="itemcode[]" id="itemcode<?php echo $i; ?>" value="<?php echo $gres['code'];?>" /></td>
<td width="10px"></td>
<td><input readonly size="15" style="background:none; border:none;text-align:left;" type="text" name="description[]" id="description<?php echo $i; ?>" value="<?php echo $gres['description'];?>" /></td>
<td width="10px"></td>
<td align="center"><input readonly size="10" type="text" style="background:none; border:none;text-align:right;" name="aquantity[]" id="aquantity<?php echo $i; ?>" value="<?php echo $gres['acceptedquantity'];?>" /></td>
<td width="10px"></td>
<td align="center"><input size="10" type="text" style="text-align:right" name="rquantity[]" id="rquantity<?php echo $i; ?>" value="<?php echo $gres['receivedquantity']; ?>" onKeyUp="calc(<?php echo $i; ?>);" /></td>
<td width="10px"></td>
<td align="center"><input  readonly size="5" type="text" style="background:none; border:none;text-align:right;" name="shrinkage[]" id="shrinkage<?php echo $i; ?>" value="<?php echo $gres['shrinkage'];?>"  /></td>
<td width="10px"></td>
<td><input readonly size="5" style="background:none; border:none;text-align:center;" type="text" name="units[]" id="units<?php echo $i; ?>" value="<?php echo $gres['units'];?>" /></td>
<td width="10px"></td>
<td><select id="bagtype<?php echo $i; ?>" name="bagtype[]"><option value="">-Select-</option>
<?php $query2 = "SELECT code,description,sunits FROM ims_itemcodes WHERE type =  'Packing Material' ORDER BY code";
      $result2 = mysql_query($query2,$conn);
      while($row2 = mysql_fetch_assoc($result2)) { ?>
<option title="<?php echo $row2['description']; ?>" value="<?php echo $row2['code'].'@'.$row2['description'].'@'.$row2['sunits']; ?>" <?php if($gres['bagtypecode']==$row2['code']){ ?> selected="selected" <?php } ?>><?php echo $row2['code']; ?></option>
<?php } ?>
            </select></td>
<td width="10px"></td>
<td><input size="10" type="text" name="bags[]" style="text-align:right" id="bags<?php echo $i; ?>" value="<?php echo $gres['bags'];?>"  /></td>
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
<td><input size="10" type="text" name="batch[<?php echo $i; ?>]" style="text-align:right" id="batch<?php echo $i; ?>" value="<?php echo $gres['batchno'];?>" /></td>
<td width="10px"></td>
<td><input type="text" id="expdate<?php echo $i; ?>" name="expdate[<?php echo $i; ?>]" class="datepicker" value="<?php echo date("d.m.Y",strtotime($gres['expirydate'])); ?>" size="15"/></td>
<td width="10px"></td>
<?php
}
}
?>
</tr>

<!-- hiddden variables ---->

<input value="<?php echo $gres['rateperunit']; ?>" type="hidden" id="rateperunit<?php echo $i; ?>" name="rateperunit[]" />
<!--<input value="<?php echo $gres['units']; ?>" type="hidden" id="units<?php echo $i; ?>" name="units[]" />-->
<input value="<?php echo $gres['tandccode']; ?>" type="hidden" id="tandccode<?php echo $i; ?>" name="tandccode[]" />
<input value="<?php echo $gres['tandc']; ?>" type="hidden" id="tandc<?php echo $i; ?>" name="tandc[]" />

<input value="<?php echo $gres['credittermcode']; ?>" type="hidden" id="credittermcode<?php echo $i; ?>" name="credittermcode[]" />
<input value="<?php echo $gres['credittermdescription']; ?>" type="hidden" id="credittermdescription<?php echo $i; ?>" name="credittermdescription[]" />
<input value="<?php echo $gres['credittermvalue']; ?>" type="hidden" id="credittermvalue<?php echo $i; ?>" name="credittermvalue[]" />


<input type="hidden" id="taxcode<?php echo $i;?>" name="taxcode[]" value="<?php echo $gres['taxcode'];?>" />
<input type="hidden" id="taxvalue<?php echo $i;?>" name="taxvalue[]" value="<?php echo $gres1['taxvalue'];?>" />
<input type="hidden" id="taxamount<?php echo $i;?>" name="taxamount[]" value="<?php echo $gres['taxamount']; ?>" />
<input type="hidden" id="taxformula<?php echo $i;?>" name="taxformula[]" value="<?php echo $gres['taxformula'];?>" />
<input type="hidden" id="taxie<?php echo $i;?>" name="taxie[]" value="<?php echo $gres['taxie'];?>" />

<input type="hidden" id="freightcode<?php echo $i;?>" name="freightcode[]" value="<?php echo $gres['freightcode'];?>" />
<input type="hidden" id="freightvalue<?php echo $i;?>" name="freightvalue[]" value="<?php echo $gres['freightvalue'];?>" />
<input type="hidden" id="freightamount<?php echo $i;?>" name="freightamount[]" value="<?php echo $gres['freightamount']; ?>" />
<input type="hidden" id="freightformula<?php echo $i;?>" name="freightformula[]" value="<?php echo $gres['freightformula'];?>" />
<input type="hidden" id="freightie<?php echo $i;?>" name="freightie[]" value="<?php echo $gres1['freightie'];?>" />

<input type="hidden" id="brokeragecode<?php echo $i;?>" name="brokeragecode[]" value="<?php echo $gres['brokeragecode'];?>" />
<input type="hidden" id="brokeragevalue<?php echo $i;?>" name="brokeragevalue[]" value="<?php echo $gres['brokeragevalue'];?>" />
<input type="hidden" id="brokerageamount<?php echo $i;?>" name="brokerageamount[]" value="<?php echo $gres['brokerageamount']; ?>" />
<input type="hidden" id="brokerageformula<?php echo $i;?>" name="brokerageformula[]" value="<?php echo $gres['brokerageformula'];?>" />
<input type="hidden" id="brokerageie<?php echo $i;?>" name="brokerageie[]" value="<?php echo $gres['brokerageie'];?>" />

<input type="hidden" id="discountcode<?php echo $i;?>" name="discountcode[]" value="<?php echo $gres['discountcode'];?>" />
<input type="hidden" id="discountvalue<?php echo $i;?>" name="discountvalue[]" value="<?php echo $gres['discountvalue'];?>" />
<input type="hidden" id="discountamount<?php echo $i;?>" name="discountamount[]" value="<?php echo $gres['discountamount']; ?>" />
<input type="hidden" id="discountformula<?php echo $i;?>" name="discountformula[]" value="<?php echo $gres['discountformula'];?>" />
<input type="hidden" id="discountie<?php echo $i;?>" name="discountie[]" value="<?php echo $gres['discountie'];?>" />

<input type="hidden" id="finalcost<?php echo $i;?>" name="finalcost[]" value="<?php echo $gres['totalamount'];?>" />

<input type="hidden" id="pocost<?php echo $i;?>" name="pocost[]" value="<?php echo $gres['pocost'];?>" />
<input type="hidden" id="warehouse<?php echo $i; ?>" name="warehouse[]" value="<?php echo $gres['warehouse']; ?>" />

<?php $i++; } ?>
<tr style="height:20px"></tr>
</table>
<br>
<center>
<table>
<td style="vertical-align:middle;"><strong>Remarks&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $remarks; ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br>



<input type="submit" id="save" value="Update" />&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_goodsreceipt_a'"/>

</center>
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>" />
<input type="hidden" id="saed" name="saed" value="1" />

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
	calculate(i);
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
   
<?php $query = "SELECT distinct(vendor) FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0' order by vendor";
 $result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row1['vendor'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['vendor'];?>";
                     myselect1.appendChild(theOption1);
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

<?php $query = "SELECT distinct(broker) FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0' order by broker"; 
      $result = mysql_query($query,$conn) or die(mysql_error());
      while($row1 = mysql_fetch_assoc($result)) { ?>
	  
	                 theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row1['broker'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row1['broker'];?>";
                     myselect1.appendChild(theOption1);
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
   
 

<?php $query = "SELECT distinct(ge),vendor,vendorid FROM pp_gateentry WHERE qcaflag = '1' AND grflag = '0'";
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
