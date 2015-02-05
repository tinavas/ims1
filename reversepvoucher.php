
<?php   include "paymentdisplay1.php"; 
		include "config.php";
?>
<?php 
		$tnum = $_GET['id'];
		$type = $_GET['type'];
		if ( $type == 'P')
		{
		$type = "Payment";
		}
		else {
		$type = "Receipt";
		}
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
<h1>Payment Voucher Reversal</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
			</center><form id="form1" name="form1" method="post" action="reversepaymentdisplay.php" >
<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
<input type="hidden" id="date" name="date" value="<?php echo $_GET['date']; ?>" />
<input type="hidden" id="ttype" name="ttype" value="<?php echo $type; ?>" />
<table align="right">
<td style="width:20px "></td>
 <td style="color:red;font-weight:bold;padding-top:10px">Status-Authorised</td>
 <td>
</table>
<center>
<table border="0" align="center">
 <tr>
 <td>
 <input type="radio" id="cash" name="cb" value="cash" readonly <?php if ( $mode == "Cash" ) { ?> checked <?php } ?> onclick=""/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong>
 </td>
 <td>
 &nbsp;&nbsp;&nbsp;<input type="radio" id="bank" name="cb" value="bank" readonly <?php if ( $mode == "Bank" ) { ?> checked <?php } ?> onclick=""/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong>
 </td>
 <td width="30px"></td>
 <td>
 &nbsp;&nbsp;&nbsp;<strong>Date</strong>
 </td>
 <td>
 <input type="text" size="10" class="datepicker" id="date" name="date" readonly value="<?php echo $stdate; ?>" />
 
 </td>
 <td width="30px"></td>
 <td>
  &nbsp;&nbsp;&nbsp;<strong>Reversal Date</strong>
 </td>
 <td>
 <input type="text" size="10" class="datepicker"  id="rdate" name="rdate"  value="<?php echo date("d.m.o"); ?>" />

 </td>
 
 </tr>
</table>
</center>

<table align="center">
<tr>
<td>
<strong>Transaction No.</strong>
</td>
<td>
<input type="text" id="tno" name="tno" size="5" readonly value="<?php echo $tnum; ?>"  style="border:0px;background:none"  />
</td>
<td width="30px"></td>
<td>
<strong>Reversal No.</strong>
</td>
<td>
<input type="text" id="rno" name="rno" size="5" readonly value="<?php echo $tnum; ?>-R"  style="border:0px;background:none"  />
</td>
<td width="30px"></td>
<td>
<strong><?php echo $_GET['mode'];
 ?> Code No.</strong>
</td>
<td>
<input type="text" id="cno" name="cno" size="15" readonly value="<?php echo $code; ?>" />
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
<?php 
		$q1 = "select code,controltype from ac_coa  ";
		$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		while($qr1 = mysql_fetch_assoc($qrs1))
		{
		if ( $qr1['code'] == $qr['code'] ) { 
?>
<option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['code'] ?></option>
<?php } else { ?>
<option value="<?php echo $qr1['code']; ?>"><?php echo $qr1['code']; ?></option>
<?php } ?>
<?php } ?>
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
<input type="text" align="right" id="dramount<?php echo $i; ?>"  name="dramount[]"  readonly  value="<?php echo $qr['dramount']; ?>"  onchange="total();" size="8"/>
</td>
<td width="10px"></td>
<td>
<input type="text" align="right" id="cramount<?php echo $i; ?>"  name="cramount[]"  readonly  value="<?php echo $qr['cramount']; ?>"   onchange="total();" size="8"/>
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

<td width="150px" align="right">
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
<?php if ( $type == "Payment") { ?>
<b>Payee Name</b>
<?php } else { ?>
<b>Payers' Name</b>
<?php } ?>
</td>
<td width="10px"></td>
<td>
<input type="text" name="pname" id="pname" readonly value="<?php echo $pname; ?>" />
</td>
<td width="30px"></td>
<td>
<b>Payment Mode</b>
</td>
<td width="10px"></td>
<td>
<select id="pmode" name="pmode" disabled onchange="chequeenable();">
<option value="">Select</option>
<option value="Cheque"<?php if( $pmode == "Cheque" ) { ?>selected="selected"><?php } ?>Cheque</option>
<option value="Other"<?php if( $pmode == "Other" ) { ?>selected="selected"><?php } ?>Other</option>
</select>
</td>
<td width="30px"></td>
<?php if ($pmode == "Cheque") { ?>
<td  id="chtd">
<b>Cheque No.</b>
</td>
<td width="10px"></td>
<td >
<input type="text" id="chno" name="chno" readonly value="<?php echo $cheque; ?>"/>
</td>
<?php } else { ?>
<?php } ?>
</tr>
</table>
<table align="center">
<tr>
<td>
<b>Narration</b>
</td>
<td>
<!--<input type="text" id="remarks" name="remarks[]" value="" size="12" />-->
<textarea id="remarks" rows="3" cols="50" name="remarks"  readonly  ><?php echo $remarks; ?></textarea>

</td>
</tr>
<tr height="10px"></tr>
<tr>
<td align="left">
<b>Remarks during Reversal</b>
</td>
<td>
<!--<input type="text" id="remarks" name="remarks[]" value="" size="12" />-->
<textarea id="rremarks" rows="3" cols="50" name="rremarks"   ></textarea>

</td>
</tr>
</table>
<center>
<br/>
<input type="submit" value="Reverse" id="Save"  name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=<?php if ($type == "Payment") { ?>ac_pvoucher<?php } else { ?>ac_rvoucher<?php } ?>';">
</center>
<br />
<!-- </center> -->
</form>
</div>
</section>
<br />

<script type="text/javascript">
function description()
{
if(index == -1)
var a = "";
else
var a = index;
var i1,j1;
for(var i = 1;i<=index;i++)
{
	for(var j = 1;j<=index;j++)
	{
				
		if( i != j)
		{
		  if(document.getElementById('code' + i).value == document.getElementById('code' + j).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('desc' + i).value = "";
				//document.getElementById('remarks' + i).onfocus = "";
				alert("Please select different combination");
				return;
			}
			else
			{
			  <?php
		$q = "select * from ac_coa";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code' + i).value == '$qr[code]') { ";
		$q1 = "select code,description from ac_coa where code = '$qr[code]'";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc' + i).value = "<?php echo $q1r['description']; ?>";
		<?php 
		}
		echo " } "; 
		}
		?>
			}
		}
		else
		{
		 <?php
		$q = "select * from ac_coa";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code' + i).value == '$qr[code]') { ";
		$q1 = "select code,description from ac_coa where code = '$qr[code]'";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc' + i).value = "<?php echo $q1r['description']; ?>";
		<?php 
		}
		echo " } "; 
		}
		?>
		}
	}
}
//document.getElementById('Save').disabled = false;
//document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };
 
	
		
}
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
function fun(b) 
{
if(index == -1)
var a = "";
else
var a = index;

if(document.getElementById('farm' + a ).value == "")
{
document.getElementById('flock' + a).value = "";
document.getElementById('Save').disabled = true;
document.getElementById('rate' + a).onfocus = "";
alert("Please select Farm");
return;
}
var i1,j1;
for(var i = 1;i<=index;i++)
{
	for(var j = 1;j<=index;j++)
	{
		
		if( i != j)
		{
			if(document.getElementById('farm' + i).value == document.getElementById('farm' + j).value)
			{
				document.getElementById('Save').disabled = true;
				alert("Please select differen combination");
				document.getElementById('rate' + a).onfocus = "";
				return;
			}
		}
	}
}
document.getElementById('Save').disabled = false;
document.getElementById('rate' + a).onfocus = function ()  {  makeForm(); };

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
window.open('GLHelp/help_t_reverseprvoucher.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
