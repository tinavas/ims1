<?php 
include "config.php"; 
include "jquery.php";

if(!isset($_GET['date']))
$date = date("d.m.Y");
else
$date = $_GET['date'];

if(!isset($_GET['vendor']))
$vendor = "";
else
$vendor = $_GET['vendor'];

if(!isset($_GET['brok']))
$brok = "";
else
$brok = $_GET['brok'];


if(!isset($_GET['type']))
$type = "";
else
$type = $_GET['type'];

if($type == "")
{
$vb1d = "Vendor";
$vb2d = "Broker";
}
else if($type == "vendor")
{
$vb1d = "Vendor";
$vb2d = "Broker";
}
else if($type == "broker")
{
$vb1d = "Broker";
$vb2d = "Vendor";
}


if(!isset($_GET['gr']))
$gr = "''";
else
{
$gr = $_GET['gr'];
$gr = "'".str_replace(',',"','",$gr) . "'";
}

if(!isset($_GET['inv']))
$inv = "";
else
$inv = $_GET['inv'];


  $date1 = date("d.m.o");
   $strdot1 = explode('.',$date1);
   $ignore = $strdot1[0];
   $m = $strdot1[1];
   $y = substr($strdot1[2],2,4);
    
  include "config.php"; 
   $query1 = "SELECT MAX(sobiincr) as piincr FROM pp_sobi  where m = '$m' AND y = '$y' ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $piincr = 0;
   while($row1 = mysql_fetch_assoc($result1))
   {
	 $piincr = $row1['piincr'];
   }
   $piincr = $piincr + 1;

if ($piincr < 10)
    $pi = 'SOBI-'.$m.$y.'-000'.$piincr;
else if($piincr < 100 && $piincr >= 10)
    $pi = 'SOBI-'.$m.$y.'-00'.$piincr;
else
   $pi = 'SOBI-'.$m.$y.'-0'.$piincr;
   
   ?>


<br />
<center>
<h1>SOBI Invoice</h1>
<?php if($_SESSION['db'] == "alwadi") { ?>
 <form id="form1" name="form1" method="post" action="pp_savesobic.php">
 <?php } else { ?>
 <form id="form1" name="form1" method="post" action="pp_savesobi.php">
 <?php } ?>

<form id="form1" name="form1" method="post" action="pp_savesobi.php">
<br />
<input type="hidden" name="m" id="m" value="<?php echo $m; ?>" />
<input type="hidden" name="y" id="y" value="<?php echo $y; ?>" />
<input type="hidden" name="piincr" id="piincr" value="<?php echo $piincr; ?>" />
<table align="center" border="0">
<tr>
<td><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="date" name="date" value="<?php echo $date; ?>" onchange="getsobi();" size="11" class="datepicker"/>&nbsp;</td>
<td><strong>SOBI</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" style="background:none;border:none" size="16"  id="so" name="so" value="<?php echo $pi; ?>" readonly/>&nbsp;</td>
<td><strong>Book Invoice</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="17"  id="invoice" name="invoice" value="<?php echo $inv;?>" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td></td>
</tr>
<tr>
<td align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td align="left">&nbsp;<select name="type" id="type"  onchange="gettype(this.value);"  style="width:85px">
 <option value="">-Select-</option>
<option value="vendor" <?php if($type == "vendor") { ?> selected="selected"<?php } ?>>Vendor</option>
<option value="broker" <?php if($type == "broker") { ?> selected="selected"<?php } ?> >Broker</option>
</select>&nbsp;&nbsp;&nbsp;
</td>
<td><span id="vb1"><strong><?php echo $vb1d; ?></strong></span>&nbsp;&nbsp;&nbsp;</td>
<td><select id="vendor" name="vendor" onchange="<?php if($_SESSION[db]=='albustan') {?> document.getElementById('vendorcode').value=this.value; <?php } ?> getgoods(this.value);" style="width:150px"><option value="">-Select-</option>
<?php 
if($type == "vendor")
{
$q = "select distinct(vendor) from pp_goodsreceipt order by vendor"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
<option value="<?php echo $qr['vendor'];?>" <?php if($qr['vendor'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $qr['vendor'];?></option>
<?php }  }
else if($type == "broker")
{
$q = "select distinct(broker) from pp_goodsreceipt order by vendor"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
<option value="<?php echo $qr['broker'];?>" <?php if($qr['broker'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $qr['broker'];?></option>
<?php }  } ?>

</select>&nbsp;
</td>

<?php if($_SESSION[db]=='albustan') {?>
<td id="spanv1" style="display:none"><span ><strong><?php echo $vb1d; ?> Code</strong></span>&nbsp;&nbsp;&nbsp;</td>
<td id="spanv2" style="display:none"><select id="vendorcode" name="vendorcode" onchange="document.getElementById('vendor').value=this.value; getgoods(this.value);" style="width:150px"><option value="">-Select-</option>
<?php 
if($type == "vendor")
{
$q = "select distinct(vendor),vendorcode from pp_goodsreceipt order by vendor"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
<option value="<?php echo $qr['vendor'];?>" <?php if($qr['vendor'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $qr['vendorcode'];?></option>
<?php }  }
else if($type == "broker")
{
$q = "select distinct(broker) from pp_goodsreceipt order by vendor"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
<option value="<?php echo $qr['broker'];?>" <?php if($qr['broker'] == $vendor) { ?> selected="selected" <?php } ?> ><?php echo $qr['broker'];?></option>
<?php }  } ?>

</select>&nbsp;
</td>
<?php } ?>

<td><strong>Goods Receipt #</strong>&nbsp;&nbsp;&nbsp;</td>
<td><select id="gr" name="gr" onchange="fun();" style="width:120px" multiple="multiple"><option value="" disabled="disabled">-Select-</option>
<?php	
if($type == "vendor")
{
$q = "select distinct(gr),vendor from pp_goodsreceipt where vendor = '$vendor' and aflag = '1' and sobiflag = '0'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		if($vendor == $qr['vendor']) { ?>

<option value="<?php echo $qr['gr']; ?>" <?php if ( strlen(strstr($gr,$qr['gr'] ))>0 ) { ?> selected="selected" <?php } ?>><?php echo $qr['gr']; ?></option>
<?php } }}

if($type == "broker")
{
$q = "select distinct(gr),broker from pp_goodsreceipt where broker = '$vendor' and aflag = '1' and sobiflag = '0'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		if($vendor == $qr['broker']) { ?>

<option value="<?php echo $qr['gr']; ?>" <?php if($gr == $qr['gr']) { ?> selected="selected" <?php } ?>><?php echo $qr['gr']; ?></option>
<?php } }}?>

</select>&nbsp;
</td>
<td><label id="vb2"><strong><?php echo $vb2d; ?></strong></label>&nbsp;&nbsp;&nbsp;</td>
<td><select id="broker" name="broker" style="width:150px"><option value="">-Select-</option>
<?php
if($type == "vendor")
{
$q = "SELECT distinct(name) as  broker FROM contactdetails where type = 'broker' ORDER BY name ASC"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		 ?>
<option value="<?php echo $qr['broker']; ?>" <?php if($brok == $qr['broker']) { ?> selected="selected" <?php } ?>><?php echo $qr['broker']; ?></option>
<?php } }

if($type == "broker")
{
$q = "SELECT distinct(name) as  vendor FROM contactdetails where type = 'vendor' ORDER BY name ASC"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		 ?>
<option value="<?php echo $qr['vendor']; ?>" <?php if($brok == $qr['vendor']) { ?> selected="selected" <?php } ?>><?php echo $qr['vendor']; ?></option>
<?php } } 
?>



</select>&nbsp;
</td>

</tr>
</table>

<?php $q = "select vendorid,brokerid,broker from pp_goodsreceipt where gr IN ($gr) ORDER BY gr"; $qrs = mysql_query($q,$conn) or die(mysql_error());
   if($qr = mysql_fetch_assoc($qrs)) { $vendorid = $qr['vendorid']; $brokerid = $qr['brokerid']; $broker = $qr['broker']; }
?>
<input type="hidden" id="vendorid" name="vendorid" value="<?php echo $vendorid; ?>" />
<input type="hidden" id="brokerid" name="brokerid" value="<?php echo $brokerid; ?>" />

<br />
<br />
<?php if($gr != "" && $vendor != "") { ?>
<table align="center" border="0">
<tr>
<th><strong>S.No</strong></th>
<th width="10px"></th>
<th><strong>GR No.</strong></th>
<th width="10px"></th>
<th><strong>Code</strong></th>
<th width="10px"></th>
<th><strong>Description</strong></th>
<th width="10px"></th>
<th><strong>Quantity</strong></th>


<?php  if($_SESSION['db']=="vista") {?>
<th width="10px"></th>
<th><strong>Bird</strong></th>

<?php } ?>

<th width="10px"></th>
<th><strong>Price</strong></th>
<th width="10px"></th>
<th><strong>Amount</strong></th>
<th width="10px"></th>
<th><strong>Tax</strong></th>
<th width="10px"></th>
<th><strong>Freight</strong></th>
<th width="10px"></th>
<th><strong>Discount</strong></th>
<th width="10px"></th>
<th><strong>Total</strong></th>
<th width="10px"></th>
</tr>
<tr style="height:20px"></tr>
<?php 	$i = 1;
		$sum = 0;
		if($type == "vendor")
		{
		$q = "select * from pp_goodsreceipt where gr IN ($gr) and vendor ='$vendor'  and aflag = '1' and sobiflag = '0' order by code";
		}
		else if($type == "broker")
		{
		$q = "select * from pp_goodsreceipt where gr IN ($gr) and broker = '$broker'  and aflag = '1' and sobiflag = '0' order by code";
		}
		else
		{
		$q = "select * from pp_goodsreceipt where gr IN ($gr)  and aflag = '1' and sobiflag = '0' order by code";
		}
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<tr>
<td><input style="background:none;border:none;text-align:right"type="text" id="sno<?php echo $i; ?>" size="4" name="sno[]" value="<?php echo " ".$i; ?>" readonly/></td>
<td width="10px"></td>
<td><input style="background:none;border:none;text-align:right"type="text" id="grs<?php echo $i; ?>" size="13" name="grs[]" value="<?php echo $qr['gr']; ?>" readonly/></td>
<td width="10px"></td>
<td><input style="background:none;border:none;text-align:center" type="text" id="code<?php echo $i; ?>" size="13" name="code[]" value="<?php echo $qr['code']; ?>" readonly/></td>
<td width="10px"></td>
<td><input style="background:none;border:none;text-align:center" type="text" id="description<?php echo $i; ?>" size="13" name="description[]" value="<?php echo $qr['description']; ?>" readonly/></td>

<td width="10px"></td>
<td><input style="border:none;background:none;text-align:right" type="text" id="receivedquantity<?php echo $i; ?>" size="8" name="receivedquantity[]" <?php if($_SESSION['db']=="vista"){ ?> value="<?php echo $qr['receivedquantity']; ?>" <?php } else {?> value="<?php echo $qr['acceptedquantity']; ?>" <?php } ?> readonly/></td>

<?php  if($_SESSION['db']=="vista") {?>
<td width="10px"></td>
<td><input style="border:none;background:none;text-align:right" type="text" id="bird<?php echo $i; ?>" size="8" name="bird[]" value="<?php echo $qr['bird']; ?>" readonly/></td>
<?php } ?>

<td width="10px"></td>
<td><input style="border:none;background:none;text-align:right" type="text" id="rateperunit<?php echo $i; ?>" size="8" name="rateperunit[]" value="<?php echo $qr['rateperunit']; ?>" readonly/></td>
<td width="10px"></td>
<td><input type="text" style="background:none;border:none;text-align:right"id="tot<?php echo $i; ?>" size="10" name="tot[]" value="<?php echo $qr['acceptedquantity'] * $qr['rateperunit']; ?>" readonly /></td>
<td width="10px"></td>
<td><input type="text" style="background:none;border:none;text-align:right"id="taxamount<?php echo $i; ?>" size="6" name="taxamount[]" value="<?php echo $qr['taxamount']; ?>" readonly/></td>
<td width="10px"></td>
<td><input type="text" style="background:none;border:none;text-align:right"id="freightamount<?php echo $i; ?>" size="6" name="freightamount[]" value="<?php echo $qr['freightamount']; ?>" readonly/></td>
<td width="10px"></td>
<td><input type="text" style="background:none;border:none;text-align:right"id="discountamount<?php echo $i; ?>" size="6" name="discountamount[]" value="<?php echo $qr['discountamount']; ?>" readonly/></td>
<td width="10px"></td>
<td><input style="border:none;background:none;text-align:right" type="text" id="totalamount<?php echo $i; ?>" size="10" name="totalamount[]" value="<?php $tot = ($qr['acceptedquantity'] * $qr['rateperunit']) + $qr['taxamount'] + $qr['freightamount'] - $qr['discountamount']; echo round($tot,0); $sum+=$tot;  ?>" readonly/></td>
<td width="10px"></td>
</tr>

<input type="hidden" id="po<?php echo $i; ?>" name="po[]" value="<?php echo $qr['po']; ?>" />
<input type="hidden" id="ge<?php echo $i; ?>" name="ge[]" value="<?php echo $qr['ge']; ?>" />

<input type="hidden" id="tandccode<?php echo $i; ?>" name="tandccode[]" value="<?php echo $qr['tandccode']; ?>" />
<input type="hidden" id="tandc<?php echo $i; ?>" name="tandc[]" value="<?php echo $qr['tandc']; ?>"  />

<input type="hidden" id="credittermcode<?php echo $i; ?>" name="credittermcode[]" value="<?php echo $qr['credittermcode']; ?>" />
<input type="hidden" id="credittermdescription<?php echo $i; ?>" name="credittermdescription[]" value="<?php echo $qr['credittermdescription']; ?>" />
<input type="hidden" id="credittermvalue<?php echo $i; ?>" name="credittermvalue[]" value="<?php echo $qr['credittermvalue']; ?>" />

<input type="hidden" id="taxcode<?php echo $i; ?>" name="taxcode[]" value="<?php echo $qr['taxcode']; ?>" />
<input type="hidden" id="taxvalue<?php echo $i; ?>" name="taxvalue[]" value="<?php echo $qr['taxvalue']; ?>" />
<input type="hidden" id="taxformula<?php echo $i; ?>" name="taxformula[]" value="<?php echo $qr['taxformula']; ?>" />
<input type="hidden" id="taxie<?php echo $i; ?>" name="taxie[]" value="<?php echo $qr['taxie']; ?>" />

<input type="hidden" id="freightcode<?php echo $i; ?>" name="freightcode[]" value="<?php echo $qr['freightcode']; ?>" />
<input type="hidden" id="freightvalue<?php echo $i; ?>" name="freightvalue[]" value="<?php echo $qr['freightvalue']; ?>" />
<input type="hidden" id="freightformula<?php echo $i; ?>" name="freightformula[]" value="<?php echo $qr['freightformula']; ?>" />
<input type="hidden" id="freightie<?php echo $i; ?>" name="freightie[]" value="<?php echo $qr['freightie']; ?>" />

<input type="hidden" id="brokeragecode<?php echo $i; ?>" name="brokeragecode[]" value="<?php echo $qr['brokeragecode']; ?>" />
<input type="hidden" id="brokeragevalue<?php echo $i; ?>" name="brokeragevalue[]" value="<?php echo $qr['brokeragevalue']; ?>" />
<input type="hidden" id="brokerageamount<?php echo $i; ?>" name="brokerageamount[]" value="<?php echo $qr['brokerageamount']; ?>" />
<input type="hidden" id="brokerageformula<?php echo $i; ?>" name="brokerageformula[]" value="<?php echo $qr['brokerageformula']; ?>" />
<input type="hidden" id="brokerageie<?php echo $i; ?>" name="brokerageie[]" value="<?php echo $qr['brokerageie']; ?>" />

<input type="hidden" id="discountcode<?php echo $i; ?>" name="discountcode[]" value="<?php echo $qr['discountcode']; ?>" />
<input type="hidden" id="discountvalue<?php echo $i; ?>" name="discountvalue[]" value="<?php echo $qr['discountvalue']; ?>" />
<input type="hidden" id="discountformula<?php echo $i; ?>" name="discountformula[]" value="<?php echo $qr['discountformula']; ?>" />
<input type="hidden" id="discountie<?php echo $i; ?>" name="discountie[]" value="<?php echo $qr['discountie']; ?>" />

<?php $i++; } ?>
<tr style="height:20px"></tr>
<tr>
<td colspan="20" align="right"><strong>Grand Total</strong></td>
<td><input style="border:none;background:none;text-align:right" type="text" id="grandtotal" size="10" name="grandtotal" value="<?php echo round($sum,0); ?>"readonly/></td>
</tr>
</table>
<br />
<table align="center">
<td style="vertical-align:middle;"><strong>Remarks&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>

<?php } ?>
<br/>
<input type="submit" value="Save" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_sobi';">
</center>
</form>
</center>
<script language="JavaScript" type="text/javascript">
function fun()
{
	var grs = "";
	var date = document.getElementById('date').value;
	var vendor = document.getElementById('vendor').value;
	var gr = document.getElementById('gr');
	for(var i = 0; i<gr.options.length; i++)
	 if(gr.options[i].selected)
	   grs += gr.options[i].value + ",";	
	var brok = document.getElementById('broker').value;
	var type = document.getElementById('type').value;
	var inv = document.getElementById('invoice').value;
	
	document.location = "dashboardsub.php?page=pp_addsobi&gr=" + grs + "&vendor=" + vendor + "&type=" + type + "&brok=" + brok + "&inv=" + inv + "&date=" + date;
}

//Requesition Starts ///

function getsobi()
{
  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var piincr = new Array();
    var pr = "";
  <?php 
   include "config.php"; 
   $query1 = "SELECT MAX(sobiincr) as piincr,m,y FROM pp_sobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     piincr[<?php echo $k; ?>] = <?php echo $row1['piincr']; ?>;

<?php $k++; } ?>

for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(piincr[l] < 10)
     pr = 'SOBI'+'-'+m+y+'-000'+parseInt(piincr[l]+1);
   else if(piincr[1] < 100 && piincr[1] >= 10)
     pr = 'SOBI'+'-'+m+y+'-00'+parseInt(piincr[l]+1);
   else
     pr = 'SOBI'+'-'+m+y+'-0'+parseInt(piincr[l]+1);
  document.getElementById('piincr').value = parseInt(piincr[l] + 1);
  break;
  }
 else
  {
   pr = 'SOBI'+'-'+m+y+'-000'+parseInt(1);
     document.getElementById('piincr').value = 1;
  }
}
  document.getElementById('so').value = pr;
document.getElementById('m').value = m;
document.getElementById('y').value =y;
}

///Requisition Ends ///





function calc(i)
{
	if(document.getElementById('tax' + i) .value == "")
	document.getElementById('tax' + i) .value = 0;
	if(parseFloat(document.getElementById('tax' + i) .value) > parseFloat(parseFloat(document.getElementById('receivedquantity' + i).value) * parseFloat(document.getElementById('rateperunit' + i).value)))
	{
		alert("Tax should not exceed amount");
		document.getElementById('tax' + i) .value = 0;
	}
	
	document.getElementById('total' + i).value = parseFloat(parseFloat(document.getElementById('receivedquantity' + i).value) * parseFloat(document.getElementById('rateperunit' + i).value) - parseFloat(document.getElementById('tax' + i).value));
	var sumtax = 0;
	for(var j = 1;j<"<?php echo $i; ?>"; j++)
	{
		sumtax+= parseFloat(document.getElementById('tax' + j).value);
	}
	document.getElementById('finaltotal').value = "<?php echo $sum; ?>" - sumtax;
}

function gettype(z)
{
if(z == "vendor")
{
document.getElementById("vb1").innerHTML = "<strong>Vendor</strong>";
document.getElementById("vb2").innerHTML = "<strong>Broker</strong>";
<?php if($_SESSION[db]=='albustan') {?>
document.getElementById("spanv1").style.display='block';
document.getElementById("spanv2").style.display='block';
<?php } ?>
gettypeven();
}
else if(z == "broker")
{
document.getElementById("vb1").innerHTML = "<strong>Broker</strong>";
document.getElementById("vb2").innerHTML = "<strong>Vendor</strong>";
<?php if($_SESSION[db]=='albustan') {?>
document.getElementById("spanv1").style.display='none';
document.getElementById("spanv2").style.display='none';
<?php } ?>
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
   
   <?php if($_SESSION[db]=='albustan') {?>
   removeAllOptions(document.getElementById("vendorcode"));
   myselect2 = document.getElementById("vendorcode");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect2.appendChild(theOption1);
   <?php } ?>
   
<?php
if($_SESSION['db'] == "albustan")
$q = "select distinct(vendor),vendorcode from pp_goodsreceipt order by vendor"; 
else
$q = "select distinct(vendor) from pp_goodsreceipt order by vendor"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
	  	       theOption1=document.createElement("OPTION");
               theText1=document.createTextNode("<?php echo $qr['vendor'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $qr['vendor'];?>";
                myselect1.appendChild(theOption1);
					   <?php if($_SESSION[db]=='albustan') {?>
					   theOption1=document.createElement("OPTION");
              		   theText1=document.createTextNode("<?php echo $qr['vendorcode'];?>");
			 	  	   theOption1.appendChild(theText1);
			           theOption1.value = "<?php echo $qr['vendor'];?>";
                       myselect2.appendChild(theOption1);
					   <?php } ?>
<?php } ?>

removeAllOptions(document.getElementById("broker"));
   myselect1 = document.getElementById("broker");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
<?php $q = "SELECT distinct(name) as  broker FROM contactdetails where type = 'broker' ORDER BY name ASC"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $qr['broker'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $qr['broker'];?>";
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

<?php $q = "select distinct(broker) from pp_goodsreceipt order by broker"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $qr['broker'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $qr['broker'];?>";
                     myselect1.appendChild(theOption1);
<?php } ?>

removeAllOptions(document.getElementById("broker"));
   myselect1 = document.getElementById("broker");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
<?php $q = "SELECT distinct(name) as  vendor FROM contactdetails where type = 'vendor' ORDER BY name ASC"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $qr['vendor'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $qr['vendor'];?>";
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
function getgoods(vb)
{
if(document.getElementById("type").value == "vendor")
{
getgrven(vb);
}
else if(document.getElementById("type").value == "broker")
{
getgrbro(vb);
}
}
function getgrven(ve)
{
removeAllOptions(document.getElementById("gr"));
   myselect1 = document.getElementById("gr");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);

<?php $q = "select distinct(gr),vendor from pp_goodsreceipt where aflag = '1' and sobiflag = '0'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{ 
	 echo "if(ve == '$qr[vendor]') { ";
	 ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $qr['gr'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $qr['gr'];?>";
                     myselect1.appendChild(theOption1);
<?php echo "}"; } ?>
}

function getgrbro(ve)
{
removeAllOptions(document.getElementById("gr"));
   myselect1 = document.getElementById("gr");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);

<?php $q = "select distinct(gr),broker from pp_goodsreceipt where aflag = '1' and sobiflag = '0'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{ 
	 echo "if(ve == '$qr[broker]') { ";
	 ?>
	  	   theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $qr['gr'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $qr['gr'];?>";
                     myselect1.appendChild(theOption1);
<?php echo "}"; } ?>
}

</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_addSOinv.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
