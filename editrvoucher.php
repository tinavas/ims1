
<?php   include "paymentdisplay1.php"; 
		include "config.php";
		include "jquery.php";
?>
<?php 
		$tnum = $_GET['id'];
		$q = "select * from ac_gl where transactioncode = '$tnum' order by id ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		  $mode = $qr['mode'];
		  $code = $qr['bccodeno'];
		  $crtotal = $qr['crtotal'];
		  $drtotal = $qr['drtotal'];
		  $pname = $qr['name'];
		  $pmode = $qr['pmode'];
		  $cheque = $qr['chequeno'];
		  //$stdate = $qr['date'];
		  $stdate = date("d-m-Y",strtotime($qr['date']));
		  $remarks = $qr['remarks'];
		}
		
?>
<section class="grid_12">
			<div class="block-border">
			<center>
			<br />
<h1>Receipt Voucher</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="updatereceiptdisplay.php" >
<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
<input type="hidden" id="date" name="date" value="<?php echo $_GET['date']; ?>" />
<center>
<table border="0" align="center">
 <tr>
 <td>
 <input type="radio" id="cash" name="cb" value="cash" <?php if ( $mode == "Cash" ) { ?> checked <?php } ?> onclick=""/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong>
 </td>
 <td>
 &nbsp;&nbsp;&nbsp;<input type="radio" id="bank" name="cb" value="bank" <?php if ( $mode == "Bank" ) { ?> checked <?php } ?> onclick=""/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong>
 </td>
 <td width="50px"></td>
 <td>
 &nbsp;&nbsp;&nbsp;<strong>Date</strong>
 </td>
 <td>
 <input type="text" size="10" id="date" class="datepicker" name="date" value="<?php echo $stdate; ?>" />
 
 </td>
 
  </tr>
</table>
<table align="right">
<tr><td style="color:red;font-weight:bold;padding-top:10px">Status-Not Authorised</td></tr>
</table>
</center>

<table align="center">
<tr>
<td>
<strong>Transaction No.</strong>
</td>
<td>
<input type="text" id="tno" name="tno" size="5" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  />
</td>
<td width="100px"></td>
<td>
<strong><?php echo $_GET['mode'];
 ?> Code No.</strong>
</td>
<td>
<select id="cno" name="cno"  disabled onchange="codecoa();">
<option value="<?php echo $code; ?>"><?php echo $code; ?></option>
</select>
</td>
</tr>
</table>
<br />
<div style="height:auto">
<table border="1" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead align="center">
<td>
<b>S.No.</b>
</td>
<td></td>
<td>
<b>Code</b>
</td>
<td></td>
<td>
<b>Description</b>
</td>
<td></td>
<td>
<b>Dr/Cr</b>
</td>
<td></td>
<td>
<b>Dr</b>
</td>
<td></td>
<td>
<b>Cr</b>
</td>

</thead>
</tr>
<script type="text/javascript">
var index = 0;
</script>
<?php 
	$i = 1;
	
	$q = "select * from ac_gl where transactioncode = '$tnum' ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	
?>
<script type="text/javascript">
index = index + 1;
</script>
<tr>
<td>
<input type="text"  id="sno" name="sno" value="<?php echo $i; ?>" readonly style="border:0px;background:none" size="2"/>
</td>
<td width="10px"></td>
<td>
<select id="code<?php echo $i; ?>" name="code[]" disabled onchange="description();">
<option value="">Select</option>
<option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['code'] ?></option>
</select>
</td>
<td width="10px"></td>
<td>
<input type="text" id="desc<?php echo $i; ?>" name="desc[]" value="<?php echo $qr['description']; ?>" size="25" readonly />
</td>
<td width="10px"></td>
<td>
<select id="crdr<?php echo $i; ?>" name="crdr[]" disabled  onchange="enabledrcr();">
<option value="">Select</option>
<?php if ( $qr['crdr'] == "Cr" ) { ?>
<option value="Cr" selected="selected">Cr</option>
<?php } else { ?>
<option value="Cr">Cr</option>
<?php } ?>
<?php if ( $qr['crdr'] == "Dr" ) { ?>
<option value="Dr" selected="selected">Dr</option>
<?php } else { ?>
<option value="Dr" >Dr</option>
<?php } ?>
</select>
</td>
<td width="10px"></td>
<td>
<input type="text" align="right" id="dramount<?php echo $i; ?>"  name="dramount[]" <?php if ( $qr['crdr'] == "Cr" ) {  ?> readonly <?php } ?> value="<?php echo $qr['dramount']; ?>"  onkeyup="total();" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" align="right" id="cramount<?php echo $i; ?>"  name="cramount[]" <?php if ( $qr['crdr'] == "Dr" ) {  ?> readonly <?php } ?> value="<?php echo $qr['cramount']; ?>"   onkeyup="total();" size="8"/>
</td>

</tr>
<?php $i++; } ?>

</table>
<br />
<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="12"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="12"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="10"/>
</td>

<td align="right" width="150px">
<b>Total</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td>
<input type="text" id="drtotal" name="drtotal" value="<?php echo $drtotal; ?>" size="8" readonly style="border:0px;background:none" />
</td>
<td>
<input type="text" id="crtotal" name="crtotal" value="<?php echo $crtotal; ?>" size="8" readonly style="border:0px;background:none"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>
</tr>
</table>
</div>
<br />

<table align="center">
<tr>
<td>
<b>Payers' Name</b>
</td>
<td width="10px"></td>
<td>
<input type="text" name="pname" id="pname" value="<?php echo $pname; ?>" />
</td>

<td>
<b>Payment Mode</b>
</td>
<td width="10px"></td>
<td>
<select id="pmode" name="pmode" onchange="chequeenable();">
<option value="">Select</option>
<option value="Cheque"<?php if( $pmode == "Cheque" ) { ?>selected="selected"><?php } ?>Cheque</option>
<option value="Other"<?php if( $pmode == "Other" ) { ?>selected="selected"><?php } ?>Other</option>
</select>
</td>
<?php if ($pmode == "Cheque") { ?>
<td  id="chtd">
<b>Cheque No.</b>
</td>
<td width="10px"></td>
<td >
<input type="text" id="chno" name="chno" value="<?php echo $cheque; ?>"/>
</td>
<?php } else { ?>
<?php } ?>
</tr>
</table>
<table align="center">
<tr>
<td valign="middle">
<b>Narration</b>
</td>
<td>
<!--<input type="text" id="remarks" name="remarks[]" value="" size="12" />-->
<textarea id="remarks" rows="3" cols="50" name="remarks[]" value="" ><?php echo $remarks; ?></textarea>

</td>
</tr>
</table>
<br />
<center>
<input type="submit" value="Update" id="Save"  name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_rvoucher';">
</center>
<br />
<!-- </center> -->
</form>
<br />

<script type="text/javascript">

function chequeenable()
{		
	if(document.getElementById('pmode').value == "Cheque")
	{
	document.getElementById('chno').style.visibility = "visible";
	document.getElementById('chtd').style.visibility = "visible";
	}
	else
	{
	document.getElementById('chno').value = "";
	document.getElementById('chtd').style.visibility = "hidden";
	document.getElementById('chno').style.visibility = "hidden";
	}
	
	
}


function total()
{
if(index == -1)
var a = "";
else 
var a = index;
	var ctot = 0;
	var dtot = 0;
	var i1;
	for (var i = 1;i<=index;i++)
	{
		
		ctot+=parseFloat(document.getElementById('cramount' + i).value);
		dtot+=parseFloat(document.getElementById('dramount' + i).value);
	}
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
	if( document.getElementById('crtotal').value == document.getElementById('drtotal').value && document.getElementById('code' + a).selectedIndex!= 0)
	{
	document.getElementById('Save').disabled = false;
	}
	else
	document.getElementById('Save').disabled = true;
}

function enabledrcr()
{
if(index == -1)
var a = "";
else
var a = index
document.getElementById('cramount' + a).value = 0;
document.getElementById('dramount' + a).value = 0;
//document.getElementById('crtotal').value = 0;
//document.getElementById('drtotal').value = 0;
	if(document.getElementById('drcr' + a).value == "Cr")
	{
	document.getElementById('cramount' + a).removeAttribute('readonly','readonly');
	document.getElementById('dramount' +a).setAttribute('readonly',true);
	}
	else if(document.getElementById('drcr' + a).value == "Dr")
	{
	document.getElementById('dramount' + a).removeAttribute('readonly','readonly');
	document.getElementById('cramount' +a).setAttribute('readonly',true);
	}
	else
	{
	document.getElementById('dramount' +a).setAttribute('readonly',true);
	document.getElementById('cramount' +a).setAttribute('readonly',true);
	}
	
}
</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_t_editreceiptvoucher.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

