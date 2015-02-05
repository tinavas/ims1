<?php 
include "config.php";
include "jquery.php";

$query = "select * from pp_payment where tid = '$_GET[id]' limit 0,1";
$result = mysql_query($query,$conn) or die(mysql_error());
$gres = mysql_fetch_assoc($result);

if(!isset($_GET['party']))
$party = $gres['vendor'];
else
 $party = $_GET['party'];

if(!isset($_GET['partycode']))
$partycode = $gres['vendorcode'];
else
$partycode = $_GET['partycode'];

if(!isset($_GET['date']))
$date = date("d.m.Y",strtotime($gres['date']));
else
$date = date("d.m.Y",strtotime($_GET['date']));
?>
<script type="text/javascript">
var index = -1;
var invoices = [<?php
           $query = "SELECT distinct(so),invoice,balance FROM pp_sobi where vendor = '$party' AND flag = 1 AND balance > 0 group by so order by date";
           $result = mysql_query($query,$conn) or die(mysql_error()); 
           while($row1 = mysql_fetch_assoc($result))
		    $invoices .= "\"".$row1['so']."@".$row1['balance']."@".$row1['invoice']."\",";
		   echo $invoices = substr($invoices,0,-1);
?>];
</script>
<center>
<br>
<h1>Payment</h1>
<br>

<form method="post" id="form1" action = "oc_savepayment_new.php" onSubmit="return checkform(this)" >
<input type="hidden" id="deltid" name="deltid" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" id="saed" name="saed" value="1" />
<table>
<tr>
<td>
<strong>Date</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="date" name="date" size="10" value="<?php echo $date;?>" class="datepicker"/>
</td>
<td width="10px">&nbsp;</td>
<td title="Document Number">
<strong>Doc No.</strong>
</td>
<td width="5px"></td>
<td>
<input type="text" id="doc_no" name="doc_no" size="8" value="<?php if($gres['doc_no']) echo $gres['doc_no']; else echo $_GET['docno']; ?>"/>
</td>
<td width="5px"></td>
<td>
<strong>Supplier</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="party" name="party" onChange="changecode(this.id); reloadpage()" style="width:250px">
<option value="">-Select-</option>
<?php 
	$q = "select distinct(name),code from contactdetails where type = 'vendor' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['name']; ?>" title="<?php echo $qr['name']; ?>" <?php if($party == $qr['name']) { ?> selected="selected" <?php } ?> ><?php echo $qr['name']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Supplier Code</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="partycode" name="partycode"  onchange="changename(this.id); reloadpage();">
<option value="">-Select-</option>
<?php 
	$q = "select distinct(name),code from contactdetails where type = 'vendor' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['code']; ?>" title="<?php echo $qr['name']; ?>" <?php if($partycode == $qr['code']) { ?> selected="selected" <?php } ?> ><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>



</tr>
</table>
<br /><br />
<table>
<tr>
<td>
<strong>Payment Method</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="paymentmethod" name="paymentmethod" onChange="paymentmethodfun(this.value);">
<option value="">-Select-</option>
<option value="Payment" selected="selected">Payment</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Choice</strong></td>
<td width="10px">&nbsp;</td>
<td>
<select id="choice" name="choice" style="width:100px" onChange="socobi(this.value);">
<option value="">-Select-</option>
<option value="On A/C" <?php if($gres['choice'] == "On A/C"){?> selected="selected" <?php } ?>>On A/C</option>
<option value="SOBIs" <?php if($gres['choice'] == "SOBIs"){?> selected="selected" <?php } ?>>SOBIs</option>
</select></td>
<td width="10px">&nbsp;</td>
<td>
<strong>Payment Mode</strong></td>
<td width="10px">&nbsp;</td>
<td>
<select id="paymentmode" name="paymentmode" style="width:100px" onChange="cashcheque(this.value);">
<option value="">-Select-</option>
<option value="Cash" <?php if($gres['paymentmode'] == "Cash"){ $codename = "Cash Code"; $mode = "Cash"; $acno = "code"; ?> selected="selected" <?php } ?>>Cash</option>
<option value="Cheque" <?php if($gres['paymentmode'] == "Cheque"){ $codename = "Bank A/C No."; $mode = "Bank"; $acno = "acno"; ?> selected="selected" <?php } ?>>Cheque</option>
<option value="Others" <?php if($gres['paymentmode'] == "Others"){ $codename = "Others"; $mode = "Bank"; $acno = "acno";  ?> selected="selected" <?php } ?>>Others</option>
</select></td>
<td width="10px">&nbsp;</td>
<td>
<strong id="codename"><?php echo $codename; ?></strong></td>
<td width="10px">&nbsp;</td>
<td>
<select id="code" name="code" onChange="loadcodedesc(this.value)" style="width:120px">
<option value="">-Select-</option>
<?php 
$q = "select distinct($acno) as code from ac_bankmasters where mode = '$mode' order by $acno";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['code']; ?>" <?php if($qr['code']==$gres['code']){?> selected="selected"<?php } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select></td>
</tr>
</table>
<br />
<br />
<table id="TDStable">
<tr>
<td>
<strong>Code</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Description</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Cr</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Amount</strong>
</td>
<td width="10px">&nbsp;</td><td id="cheq_name_td" <?php if($gres['paymentmode'] == "Cash"){?> style="display:none" <?php } ?>>
<strong>Cheque #</strong>
</td>
<td width="10px">&nbsp;</td><td id="cheq_date_td" <?php if($gres['paymentmode'] == "Cash"){?> style="display:none" <?php } ?>>
<strong>Cheque Date</strong>
</td>
</tr>
<tr height="20px"><td>&nbsp;</td></tr>
<tr>
<td>
<input type="text" id="code1" size="14" name="code1" value="<?php echo $gres['code1']; ?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="description" size="20" name="description" value="<?php echo $gres['description']; ?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="dr" name="dr" size="6" value="Cr" value="<?php echo $gres['totalamount']; ?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="amount" name="amount" size="10" value="<?php echo $gres['totalamount']; ?>" style="text-align:right"onkeyup="checkamount('amount@-1');"/>
</td>
<td width="10px">&nbsp;</td>

<td id="cheq_name_text" <?php if($gres['paymentmode'] == "Cash"){?> style="display:none" <?php } ?> >
<input type="text" id="cheque" name="cheque" size="16" value="<?php echo $gres['cheque']; ?>" />
<span style="display:none" id="loading" ><img  title="Verifying the Cheque Number" src="images\mask-loader.gif" ></span>
</td>
 
<td width="10px">&nbsp;</td>
<td id="cheq_date_text" <?php if($gres['paymentmode'] == "Cash"){?> style="display:none" <?php } ?>>
<input type="text" id="cdate" name="cdate" size="15" class="datepicker" value="<?php echo date("d.m.Y",strtotime($gres['cdate']));?>" />
</td>
</tr>
</table>
<br id="cobibr1" <?php if($gres['choice']<>"SOBIs"){?> style="display:none" <?php } ?> />
<br id="cobibr2" <?php if($gres['choice']<>"SOBIs"){?> style="display:none" <?php } ?> />
<table id="cobitable" style="width:325px;<?php if($gres['choice']<>"SOBIs"){?> display:none <?php } ?>">
<tr>
<td>
<strong>Book Invoice</strong>
</td>
<td>
<strong>SOBI</strong>
</td>
<td>
<strong>Actual Amount</strong>
</td>
<td>
<strong>Amount Received</strong>
</td>
</tr>

<tr height="10px"><td></td></tr>
<?php 
if($gres['choice']=="SOBIs")
{
$tamount = 0;
$query = "select so,invoice from pp_sobi where so in (select posobi from pp_payment where tid = '$_GET[id]') group by so";
$result = mysql_query($query,$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$book[$res['so']] = $res['invoice'];
$i = 0;
$query = "select * from pp_payment where tid = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
$tamount += $res['amountpaid'];
?>

<tr>
<td>
<select name="book[]" id="book@<?php echo $i; ?>" onChange="loadamounts(this.id);">
<option value="">-Select-</option>
<option value="<?php echo $res['posobi']."@".$res['amountpaid']."@".$book[$res['posobi']]; ?>" selected="selected"><?php echo $book[$res['posobi']]; ?></option>
</select>
</td>
<td>
<select name="cobi[]" id="cobi@<?php echo $i; ?>" onChange="loadamounts(this.id);" style=" width:200px;">
<option value="">-Select-</option>
<option value="<?php echo $res['posobi']."@".$res['amountpaid']."@".$book[$res['posobi']]; ?>" selected="selected"><?php echo $res['posobi']; ?></option>
</select>
</td>
<td align="right">
<input type="text" style="border:none;background:none" size="10" id="actualamount@<?php echo $i; ?>" name="actualamount[]" value="<?php echo $res['actualamount']; ?>" />
</td>
<td align="center">
<input type="text" id="amountreceived@<?php echo $i; ?>" size="10" value="<?php echo $res['amountpaid']; ?>" name="amountreceived[]" onFocus="makeRow();" onKeyUp="checkamount(this.id);"/>
</td>
</tr>
<tr height="10px"><td></td></tr>
<?php $i++; } }?>
</table>

<br />
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $gres['remarks']; ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />
<center><span id="usercheck"></span></center>
<br />
<input type="submit" id="save" <?php if($gres['choice']=="SOBIs" && $gres['totalamount'] <> $tamount){?>disabled="disabled" <?php } ?> name="save" value="Pay" /> &nbsp;&nbsp;&nbsp;
<input type="button" id="cancel" name="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_payment';"/>
</form>
</center>

<script type="text/javascript">
function socobi(choice)
{
	document.getElementById('save').disabled = true;
	
	if(choice == "SOBIs")
	{
	document.getElementById('cobitable').style.display = "";
	document.getElementById('cobibr1').style.display = "";
	document.getElementById('cobibr2').style.display = "";
	loadcobi(0);
	//checkamount('amountreceived@0');
	}
	else if(choice == "On A/C")
	{
	document.getElementById('cobitable').style.display = "none";
	document.getElementById('cobibr1').style.display = "none";
	document.getElementById('cobibr2').style.display = "none";
	document.getElementById('save').disabled = false;
	}
}
function loadcobi(i)
{

var party = document.getElementById('party').value;

var myselect = document.getElementById('cobi@' + i);

for(var k = 0; k< invoices.length; k++) {
var temp = invoices[k].split('@');
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode(temp[0]);
		theOption1.value = invoices[k];
		theOption1.appendChild(theText1);
		myselect.appendChild(theOption1);
}	
var myselect = document.getElementById('book@' + i);

for(var k = 0; k< invoices.length; k++) {
var temp = invoices[k].split('@');
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode(temp[2]);
		theOption1.value = invoices[k];
		theOption1.appendChild(theText1);
		myselect.appendChild(theOption1);
}	
}

function loadamounts(id)
{
var changevalue = document.getElementById(id).value;

var id1 = id.split("@");
var index1 = id1[1];
document.getElementById('cobi@'+index1).value = changevalue;
document.getElementById('book@'+index1).value = changevalue;

if( document.getElementById(id).selectedIndex == 0 )
{
	document.getElementById("actualamount@" + index1).value = "0";
	document.getElementById(id).focus();
	alert("Please select SOBI");
	document.getElementById("amountreceived@" + index1).value = "0";
	checkamount(id);
	return;
}
for(var i = 0; i <=index;i++)
{
	for(var j = 0; j <=index;j++)
	{
		if( i != j )
		{
			if(document.getElementById('cobi@' + i).value == document.getElementById('cobi@' + j).value)
			{
			document.getElementById('actualamount@' + j).value = "0";
			document.getElementById('cobi@' + j).options[0].selected = true;
			document.getElementById('book@' + j).options[0].selected = true;
			alert("Please select different combinations");
			document.getElementById("amountreceived@" + j).value = "0";
			checkamount("amountreceived@" + j);
			return;
			}
		}
	}
}
document.getElementById('actualamount@' + index1).value = "";
var invoice = document.getElementById(id).value;
var temp = invoice.split('@');
document.getElementById('actualamount@' + index1).value = temp[1];
}


var index = <?php echo $i-1; ?>;
function makeRow()
{
if(document.getElementById('cobi@' + index).value == "" || document.getElementById('amountreceived@' + index).value == "")
return;

var TDSsum = 0;
var sum = 0;
for(var i = 0; i <= index; i++)
	sum+= parseFloat(document.getElementById('amountreceived@' + i).value);
if(sum == parseFloat(document.getElementById('amount').value) + TDSsum)
return;

index = index + 1;
var table = document.getElementById('cobitable');

var tr = document.createElement("tr");

var td = document.createElement("td");
var selectbox = document.createElement('select');
selectbox.id = "book@" + index;
selectbox.name = "book[]";
selectbox.onchange = function () { loadamounts(this.id); };

var option  = document.createElement('option');
var text=document.createTextNode("-Select-");
option.appendChild(text);
option.value = "";
selectbox.appendChild(option);

td.appendChild(selectbox);
tr.appendChild(td);

var td = document.createElement("td");
var selectbox = document.createElement('select');
selectbox.id = "cobi@" + index;
selectbox.style.width = "200px";
selectbox.name = "cobi[]";
selectbox.onchange = function () { loadamounts(this.id); };

var option  = document.createElement('option');
var text=document.createTextNode("-Select-");
option.appendChild(text);
option.value = "";
selectbox.appendChild(option);

td.appendChild(selectbox);
tr.appendChild(td);

td = document.createElement("td");
td.align = "right";
var input = document.createElement('input');
input.type = "text";
input.id = "actualamount@" + index;
input.name = "actualamount[]";
input.size = "10";
input.value = "0";
input.style.border = "none";
input.style.background = "none";
input.setAttribute("readonly",true);
td.appendChild(input);
tr.appendChild(td);

td = document.createElement("td");
td.align = "center";
var input = document.createElement('input');
input.type = "text";
input.id = "amountreceived@" + index;
input.name = "amountreceived[]";
input.size = "10";
input.value = "0";
input.onfocus = function () { makeRow(); };
input.onkeyup = function () { checkamount(this.id); };
td.appendChild(input);
tr.appendChild(td);
table.appendChild(tr);
loadcobi(index);
}



function checkform()
{

 if(document.getElementById('code1').value == "")
 {
  alert("Please select Cash Code/Bank Ac No.")
  document.getElementById('code').focus();
  return false;
 }
 if(document.getElementById('amount').value == "" || document.getElementById('amount').value == 0)
 {
  alert("Please enter Amount")
  document.getElementById('amount').focus();
  return false;
 }
 if(document.getElementById('paymentmode').value=='Cheque')
 {
	if(document.getElementById('cheque').value == '')
	{
	 alert("Please Enter Cheque Number");
	 document.getElementById('cheque').focus();
	 return false;
	}
 }
 document.getElementById('save').disabled=true; 
}

 $(document).ready(function()
{  	
	$("#cheque").blur(function()
	{  
	   
	   if($("#cheque").val()) {
	   document.getElementById("usercheck").innerHTML='';
	   document.getElementById("usercheck").style.display='none';
	   document.getElementById("loading").style.display='';
		$.post("check_cheque.php",{ cheque:$("#cheque").val() },function(data)
        { 
		document.getElementById("loading").style.display='none';
		var temp = data.split('@');
		if(temp[0] > 0)
		 {		  
		  document.getElementById("cheque").value='';
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("usercheck").innerHTML='*'+temp[1];
		  document.getElementById("usercheck").style.color='#FF0000';
		  document.getElementById("save").disabled='disabled';
		  alert('Cheque Number already exists');
		 }
		 else
		 {
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("save").disabled='';
		 }
		});
		
	} // end of if
});
});

function loadcodedesc(a)
{

var mode = document.getElementById('paymentmode').value;
document.getElementById('code1').value = "";
document.getElementById('description').value = "";
if(a== "")
return;
<?php 
$q = "select code,acno,coacode,name from ac_bankmasters order by coacode";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo " if( mode == 'Cash') { ";
echo " if(a == '$qr[code]') { ";
?>
document.getElementById('code1').value = "<?php echo $qr['coacode']; ?>";
document.getElementById('description').value = "<?php echo $qr['name']; ?>";
<?php 
echo " } } else if( mode == 'Cheque') { ";
echo " if(a == '$qr[acno]') { ";
?>
document.getElementById('code1').value = "<?php echo $qr['coacode']; ?>";
document.getElementById('description').value = "<?php echo $qr['name']; ?>";
<?php 
echo " } } ";
}
?>

<?php 
$q1 = "select distinct(code) from ac_coa WHERE controltype IN ('Cash','Bank') ORDER by code";
$q1rs = mysql_query($q1) or die(mysql_error());
while($q1r = mysql_fetch_assoc($q1rs))
{
echo "if(document.getElementById('code1').value == '$q1r[code]') { ";

$q = "select distinct(description) from ac_coa where code = '$q1r[code]' order by description";
$qrs = mysql_query($q) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
?>
document.getElementById('description').value = "<?php echo $qr['description']; ?>";
<?php
}
echo " } ";
}
?>
}

function cashcheque(a)
{
document.getElementById('code1').value = "";
document.getElementById('description').value = "";

removeAllOptions(document.getElementById('code'));
var code = document.getElementById('code');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
code.appendChild(theOption1);
/*document.getElementById("bankname").style.display="block";
document.getElementById("bank").style.display="block";
document.getElementById("branchname").style.display="block";
document.getElementById("branch").style.display="block";*/
document.getElementById("cheq_name_td").style.display="block";
document.getElementById("cheq_name_text").style.display="block";
document.getElementById("cheq_date_td").style.display="block";
document.getElementById("cheq_date_text").style.display="block";

if(a == "Cash")
{
document.getElementById('codename').innerHTML = "Cash Code";
<?php 
	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' order by code";
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
/*document.getElementById("bankname").style.display="none";
document.getElementById("bank").style.display="none";
document.getElementById("branchname").style.display="none";
document.getElementById("branch").style.display="none";*/
document.getElementById("cheq_name_td").style.display="none";
document.getElementById("cheq_name_text").style.display="none";
document.getElementById("cheq_date_td").style.display="none";
document.getElementById("cheq_date_text").style.display="none";
}
else if(a == "Cheque")
{
document.getElementById('codename').innerHTML = "Bank A/C No.";

<?php 
	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' order by acno";
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

function paymentmethodfun(paymentmethod)
{
document.getElementById('cobitable').style.display = "none";
removeAllOptions(document.getElementById('choice'));
var choice = document.getElementById('choice');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
choice.appendChild(theOption1);

	if(paymentmethod == "Advance")
	{
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("On A/C");
		theOption1.appendChild(theText1);
		theOption1.value = "On A/C";
		choice.appendChild(theOption1);
	}
	else if(paymentmethod == "Payment")
	{
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("On A/C");
		theOption1.appendChild(theText1);
		theOption1.value = "On A/C";
		choice.appendChild(theOption1);
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("SOBIs");
		theOption1.appendChild(theText1);
		theOption1.value = "SOBIs";
		choice.appendChild(theOption1);
	}
}

function changecode(cnameid)
{
var cname=document.getElementById(cnameid).value;
if(cname == '')
{
document.getElementById("partycode").selectedIndex = 0;
}
else
{
<?php 
	     $query1 = "SELECT name,code FROM contactdetails where  type = 'vendor' OR type = 'vendor and party' ORDER BY name ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		    echo "if(cname == '$row1[name]') {"; ?>
        document.getElementById("partycode").value = "<?php echo $row1['code'];?>";
<?php echo "}"; ?>

<?php }  ?>

}

}

function changename(ccodeid)
{
var ccode=document.getElementById("partycode").value;
if( ccode == "")
{
document.getElementById("party").selectedIndex = 0;
}
else
{
<?php 
	     $query1 = "SELECT name,code FROM contactdetails where  type = 'vendor' OR type = 'vendor and party' ORDER BY name ";
		 //SELECT distinct(vendor),vendorcode FROM oc_salesorder WHERE flag = 1 AND psflag = 0 AND warehouse = '$warehouse' ORDER BY vendor ASC
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   echo "if(ccode == '$row1[code]') {"; ?>
		 
        document.getElementById("party").value = "<?php echo $row1['name'];?>";
<?php echo "}"; ?>

<?php }  ?>

}
}
function reloadpage()
{
	var date = document.getElementById('date').value;
	var docno = document.getElementById('doc_no').value;
	var party = document.getElementById('party').value;
	var partycode = document.getElementById('partycode').value;
	var id = document.getElementById('deltid').value;
	document.location = "dashboardsub.php?page=pp_addpayment_new&party=" + party + "&partycode=" + partycode + "&date=" + date + "&docno=" + docno + "&id=" + id;
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
function socheckamount(id)
{
var id1 = id.split("@");
var index1 = id1[1];

document.getElementById('save').disabled = true;
if(document.getElementById('amount').value == '0')
{
document.getElementById('soamountreceived@' + index1).onchange = function () {  }
document.getElementById('amount').focus();
document.getElementById('soamountreceived@' + index1).value = "0";
alert("Please enter amount");
return;
}
document.getElementById('soamountreceived@' + index1).onchange = function () { somakeRow(); }
var sum = 0;
for(var i = 0; i <= soindex; i++)
	sum+= parseFloat(document.getElementById('soamountreceived@' + i).value);
//alert(sum);
var TDSsum = 0;
if(document.getElementById('tds').value == "With TDS")
{
for(var j = 0; j <= TDSindex; j++)
	TDSsum+= parseFloat(document.getElementById('tdsamount@' + j).value);
}

if(sum > parseFloat(document.getElementById('amount').value) + TDSsum)
{
document.getElementById('soamountreceived@' + index1).value = "0";
alert("Please enter less amount");
}

if(sum == parseFloat(document.getElementById('amount').value) + TDSsum)
document.getElementById('save').disabled = false;
}

function checkamount(id)
{
var id1 = id.split("@");
var index1 = id1[1];

document.getElementById('save').disabled = true;
if(document.getElementById('amount').value == '0')
  if(document.getElementById('choice').value == "SOBIs")
{
document.getElementById('amount').focus();
document.getElementById('amountreceived@' + index1).value = "0";
alert("Please enter amount");
return;
}

if(index1 != -1)	//if index = -1 means that is amount
{
	if(parseFloat(document.getElementById('actualamount@' + index1).value) < parseFloat(document.getElementById('amountreceived@' + index1).value))
	{
		document.getElementById('amountreceived@' + index1).focus();
		alert("Amount Paid should be less than or equal to Actual Amount");
		document.getElementById('amountreceived@' + index1).value = "0";
		return;
	}
}
var TDSsum = 0;
var sum = 0;
for(var i = 0; i <= index; i++)
	sum+= parseFloat(document.getElementById('amountreceived@' + i).value);

if(sum > parseFloat(document.getElementById('amount').value) +TDSsum && index1 != "-1")
{
document.getElementById('amountreceived@' + index1).value = "0";
alert("Please enter less amount");
checkamount(id);
}

if((sum == parseFloat(document.getElementById('amount').value) + TDSsum) ||  (document.getElementById('choice').value == "On A/C"))
  document.getElementById('save').disabled = false;
}



</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_p_addpayment.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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