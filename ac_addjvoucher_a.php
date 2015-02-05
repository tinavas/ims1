
<?php   include "ac_addjvoucher1.php"; 
		include "config.php";
		include "jquery.php";
		$client = $_SESSION['client'];
		$sdb = $_SESSION['db'];
?>
<?php  $voucher = 'J';
		$q = "select max(transactioncode) as mid from ac_gl WHERE voucher = '$voucher' ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		   $tnum = $qr['mid'];
		   $tnum = $tnum + 1;
		}
?>
<center>
<br />
<h1>Journal Voucher</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="ac_savejvoucher_a.php" <?php if(($sdb == "mallikarjunkld") || ($sdb == "skdnew") or $_SESSION['db'] == "alwadi") {?> onsubmit="return checkform(this);" <?php } ?> >
<table align="center">
<tr>
<td>
<strong>Transaction No.</strong></td>


<td><input type="text" id="tno" name="tno" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none" /></td>
<td><strong>Voucher No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="vno" name="vno"/></td>
<td width="40px"></td>
 <td><strong>Date</strong> </td>
 <td>
 <input type="text" class="datepicker" size="10" id="date" name="date" value="<?php echo date("d.m.o"); ?>" />  </td>
   <?php $sdb = $_SESSION['db'];
 //if(($sdb == "mallikarjunkld") || ($sdb == "central"))
 //{
 ?>
   <td>&nbsp;&nbsp;&nbsp;<strong>Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <?php //} ?>
 <?php //if(($sdb == "mallikarjunkld") || ($sdb == "central")) {?>
 <td>
 <select id="unitc" name="unitc" >
<option value="">-Select-</option>
<?php 
       
		  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
       if($sdb == "central" or $_SESSION['db'] == "alwadi")
	   {
	   $q = "SELECT * FROM tbl_sector WHERE costeffect = 1 order by sector";		
	   }
	   else
	   {
		$q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse' order by sector";
	   }
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	  if($sdb == "central" or $_SESSION['db'] == "alwadi")
	   {
	   $q = "SELECT * FROM tbl_sector WHERE costeffect = 1 and sector in ($sectorlist) order by sector";		
	   }
	   else
	   {
		$q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse'  and sector in ($sectorlist) order by sector";
	   }
	 }
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['sector']; ?>"><?php echo $qr['sector']; ?></option>
<?php } ?>
</select>
 <?php //} ?> </td>
</tr>
</table>
<br />
<table border="1" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead align="center">
<td>
<strong>S.No.</strong>
</td>
<td></td>
<td>
<strong>Code</strong>
</td>
<td></td>
<td>
<strong>Description</strong>
</td>
<td></td>
<td>
<strong>Dr/Cr</strong>
</td>
<td></td>
<td>
<strong>Dr</strong>
</td>
<td></td>
<td>
<strong>Cr</strong>
</td>
<td></td>
<td><strong>Narration</strong></td>

</thead>
</tr>
<tr>
<td>
<!--<input type="text" id="sno" name="sno[]" value="1" size="8" readonly />-->
<label id="sno">1</label>
</td>
<td width="10px"></td>
<td>
<select id="code" name="code[]" onchange="description();">
<option value="">-Select-</option>
<?php 
		$q = "select code,description from ac_coa where controltype = ''  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px"></td>
<td>
<select style="width:170px" id="desc" name="desc[]" onchange="getcode();">
<option value= "">-select-</option>
<?php 
$q = "select code,description from ac_coa where controltype = ''  and client = '$client'  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by description ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['description']; ?>"><?php echo $qr['description']; ?></option>
<?php } ?>
</select>
</td>

<td width="10px"></td>
<td>
<select id="drcr" name="drcr[]" onchange="enabledrcr();">
<option value="">Select</option>
<option value="Cr">Cr</option>
<option value="Dr">Dr</option>
</select>
</td>
<td width="10px"></td>
<td>
<input type="text" id="dramount" name="dramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" onblur="newrow(this.value);" readonly />
</td>
<td width="10px"></td>
<td>
<input type="text" id="cramount" name="cramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" onblur="newrow(this.value);" readonly />
</td>
<td width="10px"></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"></textarea></td>

</tr>
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
<strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td>
<input type="text" id="drtotal" name="drtotal" value="0" size="8" readonly style="border:0px;background:none" />
</td>
<td>
<input type="text" id="crtotal" name="crtotal" value="0" size="8" readonly style="border:0px;background:none"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>
</tr>
</table>
<br />
<center>
  <input type="submit" value="Save" id="Save" disabled="disabled" name="Save"/>
  &nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_jvoucher_a';">
</center>
<br />
<!-- </center> -->
</form>
<br />

<script type="text/javascript">

function getcode()
{

if(index == -1)
var a = "";
else
var a = index;
var i1,j1;
/*
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
			if(document.getElementById('desc' + i1).value == document.getElementById('desc' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('code' + a).value = "";
				//document.getElementById('remarks' + a).onfocus = "";
				alert("Please select different combination");
				return;
			}
		}
	}
} */
//document.getElementById('Save').disabled = false;
/*if(document.getElementById('drcr' + a).value == "Cr")
	{
	document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

	}
	else 
{
document.getElementById('dramount' + a).onfocus = function ()  {  makeForm(); };
}	
*/
 
	

	<?php
		$q = "select * from ac_coa where client = '$client' ";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('desc' + a).value == '$qr[description]') { ";
		$q1 = "select code,description from ac_coa where description = '$qr[description]' and client = '$client' ";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('code' + a).value = "<?php echo $q1r['code']; ?>";

		<?php 
		}
		echo " } "; 
		}
		?>
		
}

function description()
{
if(index == -1)
var a = "";
else
var a = index;
var i1,j1;
/*
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
			if(document.getElementById('code' + i1).value == document.getElementById('code' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('desc' + a).value = "";
				//document.getElementById('remarks' + a).onfocus = "";
				alert("Please select different combination");
				return;
			}
		}
	}
} */
//document.getElementById('Save').disabled = false;
//document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

	<?php
		$q = "select * from ac_coa";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code' + a).value == '$qr[code]') { ";
		$q1 = "select code,description from ac_coa where code = '$qr[code]'";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc' + a).value = "<?php echo $q1r['description']; ?>";
		<?php 
		}
		echo " } "; 
		}
		?>
		
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
var i1,j1;/*
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
			if(document.getElementById('farm' + i1).value == document.getElementById('farm' + j1).value)
			{
				document.getElementById('Save').disabled = true;
				alert("Please select differen combination");
				document.getElementById('rate' + a).onfocus = "";
				return;
			}
		}
	}
} */
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
	for (var i = -1;i<=index;i++)
	{
		if(i == -1)
		i1 = "";
		else
		i1 = i;
		ctot+=parseFloat(document.getElementById('cramount' + i1).value);
		dtot+=parseFloat(document.getElementById('dramount' + i1).value);
	}
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
	//alert (document.getElementById('crtotal').value);
	
	if( document.getElementById('crtotal').value == document.getElementById('drtotal').value )
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
function checkform(form)
{
if(form.unitc.value == "")
{
alert("Please Select Unit");
 form.unitc.focus();
return false;
}
<?php if($_SESSION['db'] == "central" or $_SESSION['db'] == "alwadi") { ?>
document.form1.action = "ac_savejvoucherc.php";
<?php } ?>

return true;
	
}
var index2 = 0;
function newrow(amount)
{
if(index2 == 0)
{ 
 if(parseFloat(amount) > 0)
 {
  makeForm();
  index2 = 1;
 } 
}
else if(document.getElementById('code'+index).value != "" && parseFloat(amount) > 0 && index >= 0)
     makeForm();
}
</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_t_addregvoucher.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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



