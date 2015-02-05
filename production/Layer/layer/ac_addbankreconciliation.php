
<?php   
		include "config.php";
		include "jquery.php";
		$bank = $_GET['bank'];
		$date = $_GET['date'];
?>
<center>
<br />
<h1>Bank Reconciliation</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="savebankreconciliation.php" >
<input type="hidden" name="bank" id="bank" value="<?php echo $_GET['bank']; ?>" />
<input type="hidden" name="date" id="date" value="<?php echo $_GET['date']; ?>" />
<table align="center" cellpadding="5" cellspacing="5">
<tr>
<td>
<strong>Bank</strong>
</td>
<td width="10px"></td>
<td>
<select id="ebank" name="ebank">
<option>Select</option>
<?php 
	$qrs = mysql_query("select acnos from ac_bankmasters where mode = 'Bank' and flag='1'  and client = '$client' order by acnos ",$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{ if ( $qr['acnos'] == $bank ) {
?>
<option value="<?php echo $qr['acnos']; ?>" selected="selected"><?php echo $qr['acnos']; ?></option>
<?php } else { ?>
<option value="<?php echo $qr['acnos']; ?>"><?php echo $qr['acnos']; ?></option>
<?php } } ?>
</select>
</td>
<td width="50px"></td>
<td>
<strong>Date</strong>
</td>
<td width="10px"></td>
<td>
<input type="text" size="10" class="datepicker" id="edate" name="edate" value="<?php echo date("d.m.o"); ?>" onblur="loadbr();">

</td>

</tr>
<tr height="10px"></tr>
</table>

<table align="center" cellpadding="5" cellspacing="5" border="1">
<tr align="center">
<td>
<b>Sr.No</b>
</td>
<td></td>
<td>
<b>Cheque No.</b>
</td>
<td></td>
<td>
<b>Date</b>
</td>
<td></td>
<td>
<b>Payee Name</b>
</td>
<td></td>
<td title="Reconciliation Date">
<b>R Date</b>
</td>
<td></td>
<td align="left">
<b>Dr</b>
</td>
<td></td>
<td align="left">
<b>Cr</b>
</td>

</tr>
<?php 
	$i = 1;
	$getdate = date("Y-m-d",strtotime($_GET['date']));
	$bank = $_GET['bank'];
	$mindate = "";
	$bankcode = "";
	$bankcoa = "";
	$q = "select * from ac_bankmasters where acnos = '$bank'  and client = '$client' ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	   $bankcode = $qr['code'];
	   $bankcoa = $qr['coacode'];
	}
	$q = "select * from ac_gl where date <= '$getdate' and pmode = 'Cheque' and status = 'U' and vstatus = 'A' and bccodeno = '$bankcode' and code = '$bankcoa'  and client = '$client' group by transactioncode order by chkdate ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$mode = $qr['voucher'];
	$chk = $qr['chequeno'];
?>
<tr>
<td>
<input type="text" readonly id="sno" name="sno" value="<?php echo $i; ?>"  style="border:0px;background:none" size="5"/>
</td>
<td width="10px"></td>
<td>
<input type="text" readonly id="chno<?php echo $i; ?>" name="chno[]" value="<?php echo $qr['chequeno']; ?>" style="border:0px;background:none" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" size="10" readonly id="cdate<?php echo $i; ?>" name="cdate[]" style="border:0px;background:none" value="<?php echo date("d.m.Y",strtotime($qr['date'])); ?>" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" readonly id="name<?php echo $i; ?>" name="name[]" style="border:0px;background:none" value="<?php echo $qr['name']; ?>" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" size="12" class="datepicker" id="date<?php echo $i; ?>" name="date[]" value="<?php ?>" onblur="caltot();" />
</td>
<td width="40px"></td>
<td align="right">
<?php if ( $qr['crdr'] == 'Dr') { ?>
<input type="text" align="right" id="dramount<?php echo $i; ?>" style="border:0px;background:none"  name="dramount[]" value="<?php echo $qr['dramount']; ?>"  size="8"/>
<?php } else {  ?>
<input type="text" align="right" id="dramount<?php echo $i; ?>" style="border:0px;background:none"  name="dramount[]" value="0"  size="8"/>
<?php } ?>
</td>
<td width="10px"></td>
<td align="right">
<?php if ( $qr['crdr'] == 'Cr') { ?>
<input type="text" align="right" id="cramount<?php echo $i; ?>" style="border:0px;background:none" name="cramount[]" value="<?php echo $qr['cramount']; ?>"  size="8"/>
<?php } else {  ?>
<input type="text" align="right" id="cramount<?php echo $i; ?>" style="border:0px;background:none"  name="cramount[]" value="0"  size="8"/>
<?php } ?>
</td>

</tr>
<?php $i++; } ?>

<?php
$q = "select * from pp_payment where paymentmode = 'Cheque' and cdate <= '$getdate' and code = '$bankcode' and code1 = '$bankcoa' and flag = 1  and client = '$client' order by cdate ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	
?>
<tr>
<td>
<input type="text" readonly id="sno" name="sno" value="<?php echo $i; ?>"  style="border:0px;background:none" size="5"/>
</td>
<td width="10px"></td>
<td>
<input type="text" readonly id="chno<?php echo $i; ?>" name="chno[]" value="<?php echo $qr['cheque']; ?>" style="border:0px;background:none" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" size="10" readonly id="cdate<?php echo $i; ?>" name="cdate[]" style="border:0px;background:none" value="<?php echo date("d.m.Y",strtotime($qr['cdate'])); ?>" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" readonly id="name<?php echo $i; ?>" name="name[]" style="border:0px;background:none" value="<?php echo $qr['vendor']; ?>" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" size="12" class="datepicker" id="date<?php echo $i; ?>" name="date[]" value="<?php ?>" onblur="caltot();" />
</td>
<td width="40px"></td>
<td align="right">
<?php if ( $qr['crdr'] == 'Dr') { ?>
<input type="text" align="right" id="dramount<?php echo $i; ?>" style="border:0px;background:none"  name="dramount[]" value="<?php echo $qr['amount']; ?>"  size="8"/>
<?php } else {  ?>
<input type="text" align="right" id="dramount<?php echo $i; ?>" style="border:0px;background:none"  name="dramount[]" value="0"  size="8"/>
<?php } ?>
</td>
<td width="10px"></td>
<td align="right">
<?php if ( $qr['crdr'] == 'Cr') { ?>
<input type="text" align="right" id="cramount<?php echo $i; ?>" style="border:0px;background:none" name="cramount[]" value="<?php echo $qr['amount']; ?>"  size="8"/>
<?php } else {  ?>
<input type="text" align="right" id="cramount<?php echo $i; ?>" style="border:0px;background:none"  name="cramount[]" value="0"  size="8"/>
<?php } ?>
</td>

</tr>
<?php $i++; } ?>

<?php
$q = "select * from oc_receipt where paymentmode = 'Cheque' and cdate <= '$getdate' and code = '$bankcode' and code1 = '$bankcoa' and flag = 1  and client = '$client' order by cdate ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	
?>
<tr>
<td>
<input type="text" readonly id="sno" name="sno" value="<?php echo $i; ?>"  style="border:0px;background:none" size="5"/>
</td>
<td width="10px"></td>
<td>
<input type="text" readonly id="chno<?php echo $i; ?>" name="chno[]" value="<?php echo $qr['cheque']; ?>" style="border:0px;background:none" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" size="10" readonly id="cdate<?php echo $i; ?>" name="cdate[]" style="border:0px;background:none" value="<?php echo date("d.m.Y",strtotime($qr['cdate'])); ?>" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" readonly id="name<?php echo $i; ?>" name="name[]" style="border:0px;background:none" value="<?php echo $qr['vendor']; ?>" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" size="12" class="datepicker" id="date<?php echo $i; ?>" name="date[]" value="<?php ?>" onblur="caltot();" />
</td>
<td width="40px"></td>
<td align="right">
<?php if ( $qr['crdr'] == 'Dr') { ?>
<input type="text" align="right" id="dramount<?php echo $i; ?>" style="border:0px;background:none"  name="dramount[]" value="<?php echo $qr['amount']; ?>"  size="8"/>
<?php } else {  ?>
<input type="text" align="right" id="dramount<?php echo $i; ?>" style="border:0px;background:none"  name="dramount[]" value="0"  size="8"/>
<?php } ?>
</td>
<td width="10px"></td>
<td align="right">
<?php if ( $qr['crdr'] == 'Cr') { ?>
<input type="text" align="right" id="cramount<?php echo $i; ?>" style="border:0px;background:none" name="cramount[]" value="<?php echo $qr['amount']; ?>"  size="8"/>
<?php } else {  ?>
<input type="text" align="right" id="cramount<?php echo $i; ?>" style="border:0px;background:none"  name="cramount[]" value="0"  size="8"/>
<?php } ?>
</td>

</tr>
<?php $i++; } ?>

<tr>

</tr>
</table>
<br />
<?php 
$dramount = 0;
$cramount = 0;
$q = "select sum(amount) as dramount from ac_financialpostings where coacode = '$bankcoa' and crdr = 'Dr'  and client = '$client'  ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	    $dramount = $qr['dramount'];
	}
	
	$q = "select sum(amount) as cramount from ac_financialpostings where coacode = '$bankcoa' and crdr = 'Cr'  and client = '$client'  ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	    $cramount = $qr['cramount'];
	}
	$totalcr = 0;
	$totaldr = 0;
	if ( $cramount > $dramount )
	{
	   $totalcr = $cramount - $dramount;
	   $totaldr = 0;
	}
	else
	{
	  $totalcr = 0;
	  $totaldr = $dramount - $cramount;
	}

?>
<table align="center" cellpadding="5" cellspacing="5" >
<tr height="20px"></tr>
<tr>
<td width="150px"></td>
<td><strong>Closing Balance As per Bank Books</strong></td>
<td width="50px"></td>
<td align="right"><input type="text" align="right" size="8" name="clbookdr" id="clbookdr" value="<?php echo $totaldr; ?>" readonly style="border:0px;background:none"  /></td>
<td align="right"><input type="text" align="right" size="8" name="clbookcr" id="clbookcr" value="<?php echo $totalcr; ?>" readonly style="border:0px;background:none"  /></td>
</tr>
<tr>
<td width="150px"></td>
<td><strong>Closing Balance As per Bank Statement</strong></td>
<td width="50px"></td>
<td align="right"><input type="text" align="right" size="8" name="clbankkdr" id="clbankdr" value="<?php echo $totaldr; ?>"  readonly style="border:0px;background:none" /></td>
<td align="right"><input type="text" align="right" size="8" name="clbankcr" id="clbankcr"  value="<?php echo $totalcr; ?>" readonly style="border:0px;background:none" /></td>
</tr>
</table>
<br />
<br/>
<br />
<br/>
<br />
<br/>
<center>
<input type="submit" value="Save" id="Save" /> &nbsp;&nbsp;&nbsp;
<input type="button" name="submit" class="button1" id="submit_btn1" value="Reversal" onclick="document.location = 'chequereversal.php?bank=<?php echo $bank; ?>&from=<?php echo $_GET['date']; ?>&dtto=<?php echo $_GET['date']; ?>';"  />
&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" id="Cancel" onclick="javascript: history.go(-1)"/>
</center>
</form>

<script type="text/javascript">
function loadbr()
{
  alert("Hi");
	document.location = "dashboard.php?page=bankreconciliation.php&date=" + document.getElementById('edate').value + "&bank=" + document.getElementById('ebank').value;
}
function caltot()
{
// var j = document.getElementById("sno").value ;
 var j = "<?php echo $i; ?>"
 j = j - 1;
 alert(j);
 var tot = 0;
 var tot1 = 0; var tpayment = 0;
  va