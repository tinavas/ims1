 <html>
<head>
</head>
<body onLoad="loadfunctions();">
<?php
include "config.php";
$q = "select * from oc_receipt where tid = '$_GET[id]'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
  $edate = $qr['date'];
  $edate = date("d.m.Y",strtotime($edate));
  $evendor = $qr['party'];
  $epaymentmethod = $qr['paymentmethod'];
  $etds = $qr['tds'];
  $echoice = $qr['choice'];
  $epaymentmode = $qr['paymentmode'];
  $ecode = $qr['code'];
  $eamount = $qr['amount'];
  $echeque = $qr['cheque'];
  $ecdate = $qr['cdate'];
  $ecdate = date("d.m.Y",strtotime($ecdate));
  $code1 = $qr['code1'];
  $description = $qr['description'];
  $doc_no=$qr['doc_no'];
  $remarks=$qr['remarks'];
  $flag = $qr['flag'];
  $bank=$qr['bank'];
  $branch =$qr['branch'];
}
?>

<script type="text/javascript">
var customer = Array();
var i = 0;
<?php 
	$q = "select distinct(name) from contactdetails where type = 'party' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
customer[i++] = "<?php echo $qr['name']; ?>";
<?php } ?>
function loadfunctions()
{
   paymentmethodfun('<?php echo $epaymentmethod; ?>');
   displaytdstable('<?php echo $etds; ?>');
   socobi('<?php echo $echoice; ?>'); 
   cashcheque('<?php echo $epaymentmode; ?>');
   loadcodedesc('<?php echo $ecode; ?>');
}
function checkform()
{
<?php if($flag == 0) { ?>
 document.form1.action = "oc_savereceipt_a.php";
<?php } ?>
}
</script>
<?php 
include "config.php";
include "jquery.php";

if(!isset($_GET['party']))
$party = "";
else
$party = $_GET['party'];

if(!isset($_GET['date']))
$date = date("d.m.Y");
else
$date = date("d.m.Y",strtotime($_GET['date']));
?>
<center>
<br>
<h1>Receipt</h1>
<br>
<form method="post" id="form1" name="form1" <?php if($_SESSION['db'] == "skdnew" or $_SESSION['db'] == "alwadi") { ?> onSubmit="checkform(this);" <?php } ?> action="oc_editsavereceipt_a.php">
<input type="hidden" name="deltid" id="deltid" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" name="saed" id="saed" value="1">
<table>
<tr>
<td>
<strong>Date</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="date" name="date" size="15" value="<?php echo $edate;?>" class="datepicker"/>
</td>
<td width="10px">&nbsp;</td>
<td width="10px">&nbsp;</td>
<td title="Document Number">
<strong>Doc No</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="doc_no" name="doc_no" size="15" value="<?php echo $doc_no;?>" class="datepicker"/>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Customer</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") {  ?> onChange="document.getElementById('partycode').value=this.value" <?php } ?>  id="party" name="party" style="width:250px">
<option value="">-Select-</option>
<?php 
	$q = "select distinct(name),code from contactdetails where type = 'party' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['name']; ?>@<?php echo $qr['code']; ?>" <?php if($evendor == $qr['name']) { ?> selected="selected" <?php } ?> ><?php echo $qr['name']; ?></option>
<?php } ?>
</select>
</td>
<?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") {  ?> 
<td width="10px">&nbsp;</td>
<td>
<strong>Customer Code</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") {  ?> onChange="document.getElementById('party').value=this.value" <?php } ?> id="partycode" name="partycode">
<option value="">-Select-</option>
<?php 
	$q = "select distinct(name),code from contactdetails where type = 'party' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option title="<?php echo $qr['name']; ?>" value="<?php echo $qr['name']; ?>@<?php echo $qr['code']; ?>" <?php if($evendor== $qr['name']) { ?> selected="selected" <?php } ?> ><?php echo $qr['code']; ?></option>
<?php } ?>

</select>
</td>

 <?php } ?>
<td width="10px">&nbsp;</td>
<td>
<strong>Receipt Method</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="paymentmethod" name="paymentmethod" onChange="paymentmethodfun(this.value);">
<option value="">-Select-</option>
<option value="Advance" <?php if($epaymentmethod == "Advance") { ?>selected = "select"<?php } ?> >Advance</option>
<option value="Receipt" <?php if($epaymentmethod == "Receipt") { ?>selected = "select"<?php } ?> >Receipt</option>
</select>
</td>

</tr>
</table>
<br /><br />
<table>
<tr>

<!--<td>
<strong>Choice</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="choice" name="choice" style="width:100px" onChange="socobi(this.value);">
<option value="">-Select-</option>
<?php if($epaymentmethod == "Advance") { ?>
<option value="SOs" <?php if($echoice == 'SOs') { ?> selected="selected" <?php } ?>>SOs</option>
<option value="On A/C" <?php if($echoice == 'On A/C') { ?> selected="selected" <?php } ?>>On A/C</option>
<?php } else { ?>
<option value="COBIs" <?php if($echoice == 'COBIs') { ?> selected="selected" <?php } ?>>COBIs</option>
<option value="Debit Notes" <?php if($echoice == 'Debit Notes') { ?> selected="selected" <?php } ?>>Debit Notes</option>
<option value="On A/C" <?php if($echoice == 'On A/C') { ?> selected="selected" <?php } ?>>On A/C</option>
<?php } ?>
</select>
</td>-->
<input type="hidden" id="choice" name="choice" value="On A/C" />
<td width="10px">&nbsp;</td>
<td <?php if($_SESSION['tax']==0) { ?> style="visibility:hidden" <?php } ?>>
<strong>TDS</strong>
</td>
<td width="10px">&nbsp;</td>
<td <?php if($_SESSION['tax']==0) { ?> style="visibility:hidden" <?php } ?>>
<select id="tds" name="tds" onChange="displaytdstable(this.value);">
<option value="With TDS" <?php if($etds == "With TDS") { ?>selected = "select"<?php } ?> >With TDS</option>
<option value="Without TDS" <?php if($etds == "Without TDS") { ?>selected = "select"<?php } ?>>Without TDS</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Reception Mode</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="paymentmode" name="paymentmode" style="width:100px" onChange="cashcheque(this.value);">
<option value="">-Select-</option>
<option value="Cash" <?php if($epaymentmode == "Cash") { ?>selected = "select"<?php } ?>>Cash</option>
<option value="Cheque" <?php if($epaymentmode == "Cheque") { ?>selected = "select"<?php } ?>>Cheque</option>
<option value="Transfer" <?php if($epaymentmode == "Transfer") { ?>selected = "select"<?php } ?>>Transfer</option>
<option value="Others" <?php if($epaymentmode == "Others") { ?>selected = "select"<?php } ?>>Others</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<?php if($epaymentmode == "Cash") { ?>
<strong id="codename">Cash Code</strong>
<?php } else { ?>
<strong id="codename">Bank A/C No. </strong>
<?php } ?>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="code" name="code" onChange="loadcodedesc(this.value)" style="width:120px">
<option value="">-Select-</option>
<?php if($epaymentmode == "Cash") { ?>
<?php
$query1 = "SELECT DISTINCT (code) FROM ac_bankmasters WHERE MODE = 'Cash' ORDER BY code";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['code']; ?>" <?php if($ecode == $rows1['code']) { ?> selected="selected" <?php } ?>><?php echo $rows1['code']; ?></option>
<?php } ?>
<?php } elseif($epaymentmode == "Cheque" or $epaymentmode="Transfer" ) { ?>
<?php
$query1 = "SELECT DISTINCT (acno) FROM ac_bankmasters WHERE MODE = 'Bank' ORDER BY code";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['acno']; ?>" <?php if($ecode == $rows1['acno']) { ?> selected="selected" <?php } ?>><?php echo $rows1['acno']; ?></option>
<?php } ?>
<?php } ?>

</select>
</td>
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
<strong>Dr</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Amount</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Bank</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Branch</strong>
</td>
<td width="10px">&nbsp;</td><td <?php if($epaymentmode == "Cash") { ?> style="display:none" <?php } ?> id="cheq_name_td">
<strong>Cheque #</strong>
</td>
<td width="10px">&nbsp;</td><td <?php if($epaymentmode == "Cash") { ?> style="display:none" <?php } ?> id="cheq_date_td">
<strong>Cheque Date</strong>
</td>
</tr>
<tr height="20px"><td>&nbsp;</td></tr>
<tr>
<td>
<input type="text" id="code1" size="14" name="code1" value="<?php echo $code1; ?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="description" size="20" name="description" value="<?php echo $description; ?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="dr" name="dr" size="6" value="Dr" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="amount" name="amount" size="10" value="<?php echo $eamount; ?>" style="text-align:right"/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="bank" name="bank" <?php if($epaymentmode != "Cash") { ?> value="<?Php echo $bank; ?>"<?php } ?>  size="12" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="branch" name="branch" <?php if($epaymentmode != "Cash") { ?> value="<?Php echo $branch; ?>"<?php } ?> size="12" />
</td>
<td width="10px">&nbsp;</td>

<td <?php if($epaymentmode == "Cash" or $epaymentmode == "Transfer") { ?> style="display:none" <?php } ?> id="cheq_name_text">
<input type="text" id="cheque" name="cheque" value="<?php echo $echeque; ?>" size="16" />
</td>
<td width="10px">&nbsp;</td>
<td <?php if($epaymentmode == "Cash" or $epaymentmode == "Transfer") { ?> style="display:none" <?php } ?> id="cheq_date_text">
<input type="text" id="cdate" name="cdate" size="15" class="datepicker" value="<?php echo $ecdate;?>"/>
</td>
</tr>
<?php
$dum = 0;
include "config.php";
$q = "select tdscode,tdsdescription,tdsamount1 from oc_receipt where tid = '$_GET[id]' order by id";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$tdscarr = explode(',',$qr['tdscode']);
$tdsdarr = explode(',',$qr['tdsdescription']);
$tdsaarr = explode(',',$qr['tdsamount1']);
 $size = sizeof($tdscarr);
for($td = 0; $td <$size; $td++)
{
?>
<tr id="TDSrow" <?php if($size == 1) {?> style="Display:none" <?php } ?> >
<td>
<select id="tdscode@<?php echo $dum; ?>" name="tdscode[]" style="width:100px" onChange="loadtdsdesc(this.id);">
<option value="">-Select-</option>
<?php  $query = "SELECT code,description FROM ac_coa ORDER BY code ASC "; $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) { ?>
<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>" <?php if($tdscarr[$td] == $row1['code']) { ?>selected = "select"<?php } ?>><?php echo $row1['code']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="tdsdescription@<?php echo $dum; ?>" size="20" name="tdsdescription[]" value="<?php echo $tdsdarr[$td]; ?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="tdscr@<?php echo $dum; ?>" name="tdscr[]" size="6" value="Dr" readonly />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="text-align:right" id="tdsamount@<?php echo $dum; ?>" name="tdsamount[]" size="10" value="<?php echo $tdsaarr[$td]; ?>" onChange="makeTDSRow();"/>
</td>
</tr>

<?php $dum = $dum + 1; } ?>
<tr id="TDSrow" style="Display:none">
<td>
<select id="tdscode@<?php echo $dum; ?>" name="tdscode[]" style="width:100px" onChange="loadtdsdesc(this.id);">
<option value="">-Select-</option>
<?php  $query = "SELECT * FROM ac_coa ORDER BY code ASC "; $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) { ?>
<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>"><?php echo $row1['code']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="tdsdescription@<?php echo $dum; ?>" size="20" name="tdsdescription[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="tdscr@<?php echo $dum; ?>" name="tdscr[]" size="6" value="Cr" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="text-align:right" id="tdsamount@<?php echo $dum; ?>" name="tdsamount[]" size="10" value="0" onChange="makeTDSRow();"/>
</td>
</tr>

</table>
<br id="cobibr1" style="display:none"/>
<br id="cobibr2" style="display:none"/>
<table id="cobitable" style="width:325px;display:none">
<tr>
<td>
<strong>COBI</strong>
</td>
<!--<td width="10px">&nbsp;</td>-->
<td>
<strong>Actual Amount</strong>
</td>
<!--<td width="10px">&nbsp;</td>-->
<td>
<strong>Amount Received</strong>
</td>
<!--<td width="10px">&nbsp;</td>-->
</tr>
<tr height="10px"><td></td></tr>

<?php
$codum = 0;
include "config.php";
$q = "select * from oc_receipt where tid = '$_GET[id]' order by id";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
?>
<tr>
<td>
<select name="cobi[]" id="cobi@<?php echo $codum; ?>" onChange="loadamounts(this.id);">
<option value="">-Select-</option>
</select>
</td>
<td align="right">
<input type="text" style="border:none;background:none" size="10" id="actualamount@<?php echo $codum; ?>" value="<?php echo $qr['actualamount']; ?>" name="actualamount[]" />
</td>
<td align="center">
<input type="text" id="amountreceived@<?php echo $codum; ?>" size="10" value="<?php echo $qr['amountreceived']; ?>" name="amountreceived[]" onChange="makeRow();" onKeyUp="checkamount(this.id);"/>
</td>
</tr>
<?php } ?>

<tr>
<td>
<select name="cobi[]" id="cobi@<?php echo $codum; ?>" onChange="loadamounts(this.id);">
<option value="">-Select-</option>
</select>
</td>
<td align="right">
<input type="text" style="border:none;background:none" size="10" id="actualamount@<?php echo $codum; ?>" name="actualamount[]" />
</td>
<td align="center">
<input type="text" id="amountreceived@<?php echo $codum; ?>" size="10" value="0" name="amountreceived[]" onChange="makeRow();" onKeyUp="checkamount(this.id);"/>
</td>
</tr>

</table>
<br id="sobr1" style="display:none"/>
<br id="sobr2" style="display:none"/>
<table id="sotable" style="width:325px;display:none">
<tr>
<td>
<strong>SO</strong>
</td>
<!--<td width="10px">&nbsp;</td>-->
<td>
<strong>Actual Amount</strong>
</td>
<!--<td width="10px">&nbsp;</td>-->
<td>
<strong>Amount Received</strong>
</td>
<!--<td width="10px">&nbsp;</td>-->
</tr>
<tr height="10px"><td></td></tr>
<?php
$sodum = 0;
include "config.php";
$q = "select * from oc_receipt where tid = '$_GET[id]' order by id";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
?>
<tr>
<td>
<select name="po[]" id="so@<?php echo $sodum; ?>" onChange="soloadamounts(this.id);" style="width:120px">
<option value="">-Select-</option>
</select>
</td>
<td align="right">
<input type="text" style="border:none;background:none" value="<?php echo $qr['actualamount']; ?>" size="10" id="soactualamount@<?php echo $sodum; ?>" name="soactualamount[]" />
</td>
<td align="center">
<input type="text" id="soamountreceived@<?php echo $sodum; ?>" size="10" value="<?php echo $qr['amountreceived']; ?>" name="soamountreceived[]" onChange="somakeRow();" onKeyUp="socheckamount(this.id);"/>
</td>
</tr>

<?php $sodum = $sodum + 1; } ?>

<tr>
<td>
<select name="so[]" id="so@<?php echo $sodum; ?>" onChange="soloadamounts(this.id);" style="width:120px">
<option value="">-Select-</option>
</select>
</td>
<td align="right">
<input type="text" style="border:none;background:none" size="10" id="soactualamount@<?php echo $sodum; ?>" name="soactualamount[]" />
</td>
<td align="center">
<input type="text" id="soamountreceived@<?php echo $sodum; ?>" size="10" value="0" name="soamountreceived[]" onChange="somakeRow();" onKeyUp="socheckamount(this.id);"/>
</td>
</tr>

</table>
<br />
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $remarks ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />
<br />
<input type="submit" id="save" name="save" value="Update" /> &nbsp;&nbsp;&nbsp;
<input type="button" id="cancel" name="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_receipt_a';"/>
</form>
<script type="text/javascript">
function paymentmethodfun(paymentmethod)
{/*
//alert(paymentmethod);
document.getElementById('sotable').style.display = "none";
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
		theText1=document.createTextNode("SOs");
		theOption1.appendChild(theText1);
		theOption1.value = "SOs";
		if("<?php echo $echoice; ?>" == "SOs") { theOption1.selected = "select"; }
		choice.appendChild(theOption1);

		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("On A/C");
		theOption1.appendChild(theText1);
		theOption1.value = "On A/C";
		if("<?php echo $echoice; ?>" == "On A/C") { theOption1.selected = "select"; }
		choice.appendChild(theOption1);
	}
	else if(paymentmethod == "Receipt")
	{
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("COBIs");
		theOption1.appendChild(theText1);
		theOption1.value = "COBIs";
		if("<?php echo $echoice; ?>" == "COBIs") { theOption1.selected = "select"; }
		choice.appendChild(theOption1);

		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("Debit Notes");
		theOption1.appendChild(theText1);
		theOption1.value = "Debit Notes";
		if("<?php echo $echoice; ?>" == "Debit Notes") { theOption1.selected = "select"; }
		choice.appendChild(theOption1);

		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("On A/C");
		theOption1.appendChild(theText1);
		theOption1.value = "On A/C";
		if("<?php echo $echoice; ?>" == "On A/C") { theOption1.selected = "select"; }
		choice.appendChild(theOption1);
	}
*/}

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
if("<?php echo $ecode; ?>" == "<?php echo $qr['code']; ?>") { theOption1.selected = "select"; }
code.appendChild(theOption1);
<?php
	}
?>
document.getElementById("cheq_name_td").style.display="none";
document.getElementById("cheq_name_text").style.display="none";
document.getElementById("cheq_date_td").style.display="none";
document.getElementById("cheq_date_text").style.display="none";
}
else if(a == "Cheque" || a == "Transfer")
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
if("<?php echo $ecode; ?>" == "<?php echo $qr['acno']; ?>") { theOption1.selected = "select"; }
code.appendChild(theOption1);
<?php
	}
?>
}

if(a="Transfer")
{
document.getElementById("cheq_name_td").style.display="none";
document.getElementById("cheq_name_text").style.display="none";
document.getElementById("cheq_date_td").style.display="none";
document.getElementById("cheq_date_text").style.display="none";
}
}

function loadcodedesc(a)
{

var mode = document.getElementById('paymentmode').value;
document.getElementById('code1').value = "";
document.getElementById('description').value = "";
if(a== "")
return;
<?php 
$q = "select code,acno,coacode from ac_bankmasters order by coacode";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo " if( mode == 'Cash') { ";
echo " if(a == '$qr[code]') { ";
?>
document.getElementById('code1').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } else if( mode == 'Cheque' || mode == 'Transfer') { ";
echo " if(a == '$qr[acno]') { ";
?>
document.getElementById('code1').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } ";
}
?>

<?php 
$q1 = "select distinct(code) from ac_coa order by code";
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
var TDSindex = 0;
function makeTDSRow()
{
	TDSindex = TDSindex + 1;
var table = document.getElementById('TDStable');

var tr = document.createElement("tr");

var td = document.createElement("td");
var selectbox = document.createElement('select');
selectbox.style.width = "100px";
selectbox.id = "tdscode@" + TDSindex;
selectbox.name = "tdscode[]";
selectbox.onchange = function () { loadtdsdesc(this.id); };

var option  = document.createElement('option');
var text=document.createTextNode("-Select-");
option.appendChild(text);
option.value = "";
selectbox.appendChild(option);
<?php $query = "SELECT * FROM ac_coa ORDER BY code ASC "; $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result)) { ?>
var option  = document.createElement('option');
var text=document.createTextNode("<?php echo $row1['code']; ?>");
option.appendChild(text);
option.value = "<?php echo $row1['code']; ?>";
option.title = "<?php echo $row1['description']; ?>";
selectbox.appendChild(option);
<?php } ?>
td.appendChild(selectbox);
tr.appendChild(td);


var td = document.createElement("td");
td.width = "10px";
tr.appendChild(td);

td = document.createElement("td");
var input = document.createElement('input');
input.type = "text";
input.id = "tdsdescription@" + TDSindex;
input.name = "tdsdescription[]";
input.size = "20";
td.appendChild(input);
tr.appendChild(td);

var td = document.createElement("td");
td.width = "10px";
tr.appendChild(td);

td = document.createElement("td");
var input = document.createElement('input');
input.type = "text";
input.id = "tdsdr@" + TDSindex;
input.name = "tdsdr[]";
input.value = "Dr";
input.size = "6";
td.appendChild(input);
tr.appendChild(td);

var td = document.createElement("td");
td.width = "10px";
tr.appendChild(td);

td = document.createElement("td");
var input = document.createElement('input');
input.type = "text";
input.id = "tdsamount@" + TDSindex;
input.name = "tdsamount[]";
input.size = "10";
input.value = "0";
input.style.textAlign = "right";
input.onchange = function () { makeTDSRow(); };
td.appendChild(input);
tr.appendChild(td);
table.appendChild(tr);
}

function loadamounts(id)
{
var id1 = id.split("@");
var index1 = id1[1];

if( document.getElementById(id).selectedIndex == 0 )
{
	document.getElementById("actualamount@" + index1).value = "";
	document.getElementById(id).focus();
	alert("Please select COBI");
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
			document.getElementById('actualamount@' + j).value = "";
			document.getElementById('cobi@' + i).options[0].selected = true;
			alert("Please select different combinations");
			return;
			}
		}
	}
}
document.getElementById('actualamount@' + index1).value = "";
<?php 
	$q = "select distinct(invoice) from oc_cobi order by invoice";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	echo "if(document.getElementById('cobi@' + index1).value == '$qr[invoice]') { ";
	$q1 = "select balance from oc_cobi where invoice = '$qr[invoice]'";
	$q1rs = mysql_query($q1) or die(mysql_error());
	if($q1r = mysql_fetch_assoc($q1rs))
	{
?>
document.getElementById('actualamount@' + index1).value = "<?php echo $q1r['balance']; ?>";
<?php 
    }
	echo " } ";
	}
?>
}


var index = 0;
function makeRow()
{
if(document.getElementById('cobi@' + index).value == "" || document.getElementById('amountreceived@' + index).value == "")
return;

var TDSsum = 0;
if(document.getElementById('tds').value == "With TDS")
{
for(var j = 0; j <= TDSindex; j++)
	TDSsum+= parseFloat(document.getElementById('tdsamount@' + j).value);
}

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
selectbox.id = "cobi@" + index;
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
input.style.border = "none";
input.style.background = "none";
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
input.onchange = function () { makeRow(); };
input.onkeyup = function () { checkamount(this.id); };
td.appendChild(input);
tr.appendChild(td);
table.appendChild(tr);
loadcobi(index);
}


var soindex = 0;
function somakeRow()
{
if(document.getElementById('so@' + soindex).value == "" || document.getElementById('soamountreceived@' + soindex).value == "")
return;

var TDSsum = 0;
if(document.getElementById('tds').value == "With TDS")
{
for(var j = 0; j <= TDSindex; j++)
	TDSsum+= parseFloat(document.getElementById('tdsamount@' + j).value);
}

var sum = 0;
for(var i = 0; i <= soindex; i++)
	sum+= parseFloat(document.getElementById('soamountreceived@' + i).value);
if(sum == parseFloat(document.getElementById('amount').value) + TDSsum)
return;

soindex = soindex + 1;
var table = document.getElementById('sotable');

var tr = document.createElement("tr");
var td = document.createElement("td");
var selectbox = document.createElement('select');
selectbox.id = "so@" + soindex;
selectbox.style.width = "120px";
selectbox.name = "so[]";
selectbox.onchange = function () { soloadamounts(this.id); };

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
input.id = "soactualamount@" + soindex;
input.name = "soactualamount[]";
input.size = "10";
input.style.border = "none";
input.style.background = "none";
td.appendChild(input);
tr.appendChild(td);

td = document.createElement("td");
td.align = "center";
var input = document.createElement('input');
input.type = "text";
input.id = "soamountreceived@" + soindex;
input.name = "soamountreceived[]";
input.size = "10";
input.value = "0";
input.onchange = function () { somakeRow(); };
input.onkeyup = function () { socheckamount(this.id); };
td.appendChild(input);
tr.appendChild(td);
table.appendChild(tr);
loadso(soindex);
}


function checkamount(id)
{
var id1 = id.split("@");
var index1 = id1[1];

document.getElementById('save').disabled = true;
if(document.getElementById('amount').value == '0')
{
document.getElementById('amountreceived@' + index1).onchange = function () {  }
document.getElementById('amount').focus();
document.getElementById('amountreceived@' + index1).value = "0";
alert("Please enter amount");
return;
}
document.getElementById('amountreceived@' + index1).onchange = function () { makeRow(); }

/*if(parseFloat(document.getElementById('actualamount@' + index1).value) < parseFloat(document.getElementById('amountpaid@' + index1).value))
{
	document.getElementById('amountpaid@' + index1).focus();
	alert("Amount Paid should be less than or equal to Actual Amount");
	document.getElementById('amountpaid@' + index1).value = "0";
	return;
}*/

var sum = 0;
for(var i = 0; i <= index; i++)
	sum+= parseFloat(document.getElementById('amountreceived@' + i).value);
//alert(sum);
var TDSsum = 0;
if(document.getElementById('tds').value == "With TDS")
{
for(var j = 0; j <= TDSindex; j++)
	TDSsum+= parseFloat(document.getElementById('tdsamount@' + j).value);
}


if(sum > parseFloat(document.getElementById('amount').value) +TDSsum)
{
document.getElementById('amountreceived@' + index1).value = "0";
alert("Please enter less amount");
}

if(sum == parseFloat(document.getElementById('amount').value) + TDSsum)
document.getElementById('save').disabled = false;
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
/*if(parseFloat(document.getElementById('actualamount@' + index1).value) < parseFloat(document.getElementById('amountpaid@' + index1).value))
{
	document.getElementById('amountpaid@' + index1).focus();
	alert("Amount Paid should be less than or equal to Actual Amount");
	document.getElementById('amountpaid@' + index1).value = "0";
	return;
}*/

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


function soloadamounts(id)
{/*
var id1 = id.split("@");
var index1 = id1[1];

if( document.getElementById(id).selectedIndex == 0 )
{
	document.getElementById("soactualamount@" + index1).value = "";
	document.getElementById(id).focus();
	alert("Please select SO");
	return;
}
for(var i = 0; i <= soindex;i++)
{
	for(var j = 0; j <= soindex;j++)
	{
		if( i != j )
		{
			if(document.getElementById('so@' + i).value == document.getElementById('so@' + j).value)
			{
			document.getElementById('soactualamount@' + j).value = "";
			document.getElementById('so@' + j).options[0].selected = true;
			alert("Please select different combinations");
			return;
			}
		}
	}
}
document.getElementById('soactualamount@' + index1).value = "";
<?php 
	/*$q = "select distinct(po) from oc_salesorder order by po";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	echo "if(document.getElementById('so@' + index1).value == '$qr[po]') { ";
	$q1 = "select pocost from oc_salesorder where po = '$qr[po]'";
	$q1rs = mysql_query($q1) or die(mysql_error());
	if($q1r = mysql_fetch_assoc($q1rs))
	{*/
?>
document.getElementById('soactualamount@' + index1).value = "<?php echo $q1r['pocost']; ?>";
<?php 
    /*}
	echo " } ";
	}*/
?>
*/}


function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function displaytdstable(a)
{
	document.getElementById('TDSrow').style.display = "none";
	if(a == "With TDS")
	{
		document.getElementById('TDSrow').style.display = "";
	}
	
}

function socobi(choice)
{/*
	document.getElementById('save').disabled = true;
	
	document.getElementById('cobibr1').style.display = "none";
	document.getElementById('cobibr2').style.display = "none";
	document.getElementById('sobr1').style.display = "none";
	document.getElementById('sobr2').style.display = "none";
	document.getElementById('cobitable').style.display = "none";
	document.getElementById('sotable').style.display = "none";
	if(choice == "SOs")
	{
	document.getElementById('sotable').style.display = "";
	document.getElementById('sobr1').style.display = "";
	document.getElementById('sobr2').style.display = "";
	loadso(0)
	}
	else if(choice == "COBIs")
	{
	document.getElementById('cobitable').style.display = "";
	document.getElementById('cobibr1').style.display = "";
	document.getElementById('cobibr2').style.display = "";
	loadcobi(0);
	}
	else if(choice == "On A/C")
	{
		document.getElementById('save').disabled = false;
	}
*/}

function loadcobi(i)
{/*

var party = document.getElementById('party').value;
var myselect = document.getElementById('cobi@' + i);

	<?php 
	/*$q = "select distinct(name) from contactdetails where type = 'party' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	echo "if( party == '$qr[name]' ) { ";
	$q1 = "select distinct(invoice) from oc_cobi where flag = '1' and party = '$qr[name]' and balance > 0 order by invoice";
	$q1rs = mysql_query($q1) or die(mysql_error());
	while($q1r = mysql_fetch_assoc($q1rs))
	{*/
	?>
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("<?php //echo $q1r['invoice']; ?>");
		theOption1.value = "<?php //echo $q1r['invoice']; ?>";
		theOption1.appendChild(theText1);
		myselect.appendChild(theOption1);
	
	<?php 
	/*} 
	echo "}";
	}*/
	?>
	
*/}

function loadso(i)
{/*

var party = document.getElementById('party').value;
var myselect = document.getElementById('so@' + i);

	<?php 
	/*$q = "select distinct(name) from contactdetails where type = 'party' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	echo "if( party == '$qr[name]' ) { ";
	$q1 = "select distinct(po) from oc_salesorder where flag = '1' and vendor = '$qr[name]' order by po";
	$q1rs = mysql_query($q1) or die(mysql_error());
	while($q1r = mysql_fetch_assoc($q1rs))
	{*/
	?>
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("<?php //echo $q1r['po']; ?>");
		theOption1.value = "<?php //echo $q1r['po']; ?>";
		theOption1.appendChild(theText1);
		myselect.appendChild(theOption1);
	
	<?php 
	/*} 
	echo "}";
	}*/
	?>
	
*/}

function loadtdsdesc(id)
{
var id1 = id.split("@");
var index1 = id1[1];
document.getElementById('tdsdescription@' + index1).value = "";
if( document.getElementById(id).selectedIndex == 0 )
{
	document.getElementById("tdsdescription@" + index1).value = "";
	document.getElementById(id).focus();
	alert("Please select TDS Code");
	return;
}
for(var i = 0; i <=TDSindex;i++)
{
	for(var j = 0; j <=TDSindex;j++)
	{
		if( i != j )
		{
			if(document.getElementById('tdscode@' + i).value == document.getElementById('tdscode@' + j).value)
			{
			document.getElementById('tdsdescription@' + j).value = "";
			alert("Please select different combinations");
			return;
			}
		}
	}
}
var tdscode = document.getElementById('tdscode@' + index1).value
<?php 
	$q = "select distinct(code) from ac_coa order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	echo "if(tdscode == '$qr[code]') { ";
	$q1 = "select description from ac_coa where code = '$qr[code]' order by description";
	$q1rs = mysql_query($q1) or die(mysql_error());
	while($q1r = mysql_fetch_assoc($q1rs))
	{
?>
	document.getElementById('tdsdescription@' + index1).value = "<?php echo $q1r['description']; ?>";
	<?php } echo " } "; } ?>

}

function reloadpage(party)
{
	var date = document.getElementById('date').value;
	document.location = "dashboard.php?page=oc_addreceipt&party=" + party + "&date=" + date;
}
</script>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_p_editreceipt.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
</body>
</html>