<?php   include "ac_addpvoucher1.php"; 
		include "config.php";
		include "jquery.php";
$voucher = 'P';
$q = "select max(transactioncode) as mid from ac_gl WHERE voucher = '$voucher'  and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['mid']; $tnum = $tnum + 1;	} 
$mode = $_GET['mode'];
$sdb = $_SESSION['db'];
?>

<center>
<br />
<h1>Payment Voucher</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="ac_savepvoucher_a.php" <?php if(($sdb == "mallikarjunkld") || ($sdb == "skdnew") || ($sdb == "alwadi")) {?> onsubmit="return checkform(this);" <?php } ?>> <!-- FOR CENTRAL DB ACTION IS AC_SAVEPVOUCHERC.PHP -->
<input type="hidden" id="mode" name="mode" value="<?php echo $_GET['mode']; ?>" />
<table border="0" align="center">
 <tr>
 <td><input type="radio" id="cash" name="cb" value="Cash" <?php if ( $mode == 'Cash') {?> checked <?php } ?> onclick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="ank" name="cb" value="Bank" <?php if ( $mode == 'Bank') {?> checked <?php } ?> onclick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td width="30px"></td>
 <td>&nbsp;&nbsp;&nbsp;<strong>Date</strong></td>
 <td width="10px"></td>
 <td><input type="text" size="15" id="date" class="datepicker"name="date" value="<?php echo date("d.m.o"); ?>" /></td>
  <?php $sdb = $_SESSION['db'];
 //if(($sdb == "mallikarjunkld") || ($sdb == "central") || ($sdb == "alwadi"))
 //{
 ?>
   <td>&nbsp;&nbsp;&nbsp;<strong>Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <?php //} ?>
 <?php //if(($sdb == "mallikarjunkld") || ($sdb == "central") || ($sdb == "alwadi")) {?>
 <td>
 <select id="unitc" name="unitc"  >
<option value="">-Select-</option>
<?php 
        if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
       if($sdb == "central" or $sdb == "alwadi")
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
	  if($sdb == "central" or $sdb == "alwadi")
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
<?php //}?>
 
 
 </td>
 </tr>
<tr height="10px"><td></td></tr>
</table>

<table align="center">
<tr>
<td><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="tno" name="tno" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  /></td>
<?php if($_SESSION['db'] == "feedatives" || $_SESSION['db'] == "alkhumasiyabrd"){ ?>
<td><strong>Voucher No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="vno" name="vno" size="10"/></td>
<?php } ?>
<td width="40px"></td>


<td width="40px"></td>

<td><strong id="codename">Code No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td>
<select id="cno" name="cno" onchange="codecoa();">
<option value="">-Select-</option>
</select>
</td>

</tr>
<tr height="10px"><td></td></tr>
</table>
<br />
<div style="height:auto">
<table border="0" cellpadding="2" cellspacing="2" id="mytable" align="center">
<thead>
<th><strong>S.No.</strong></td>
<th></th>
<th><strong>Code</strong></th>
<th></th>
<th><strong>Description</strong></th>
<th></th>
<th><strong>Dr/Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Dr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Narration</strong></th>
<th></th>
<th><strong>Employee</strong></th>

</thead>

<tr height="10px"><td></td></tr>

<tr>
<td><label id="sno">1</label></td>
<td width="10px"></td>
<td><select id="code" name="code[]" onchange="getdesc(this.id);">
        <option value="">-Select-</option>
<?php $q = "select code,description,controltype from ac_coa  where client = '$client' and code IN (select coacode from ac_bankmasters) order by code "; $qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) { ?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select></td>
<td width="10px"></td>
<td><select id="desc" name="desc[]" style="width:170px;" onchange="getcode();">
        <option value="">-Select-</option>
<?php  $q = "select code,description,controltype from ac_coa  where client = '$client' and code IN (select coacode from ac_bankmasters) order by description "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs)) 
	{ 
	?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['description']; ?></option>
<?php } ?>
</select></td>
<td width="10px"></td>
<td><select id="drcr" name="drcr[]" onchange="enabledrcr(this.id);">
      <option value="">-Select-</option><option value="Cr">Cr</option><option value="Dr">Dr</option>
</select></td>
<td width="10px"></td>
<td><input type="text" id="dramount" name="dramount[]" value="0" style="text-align:right" size="8" onchange="total();" readonly /></td>
<td width="10px"></td>
<td><input type="text" id="cramount" name="cramount[]" value="0" style="text-align:right" size="8" onchange="total();"  /></td>

<td width="10px"></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"></textarea></td>

<td width="10px"></td>
<td><select id="emp" name="emp[]" style=" visibility:hidden; width:220px" >
<option value="">-Select-</option>
</select></td>
</tr>
</table>
<br />

<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td width="20px" align="right"><strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>
<input type="text" id="drtotal" name="drtotal" value="0" size="8" readonly style="border:0px;background:none; text-align:right" /></td>
<td width="10px"></td>
<td>
<input type="text" id="crtotal" name="crtotal" value="0" size="8" readonly style="border:0px;background:none; text-align:right"/></td>
<td><input type="text" style="visibility:hidden" size="15"/></td>

</tr>
<tr height="10px"><td></td></tr>
</table>
</div>
<br />

<table align="center">
<tr>
<td width="250px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?>><strong>Payee Name</strong></td>
<td width="10px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?>><input type="text" name="pname" id="pname" value="" /></td>
<td width="30px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?>><strong>Payment Mode</strong></td>
<td width="10px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?> ><select id="pmode" name="pmode" onchange="chequeenable();">
<option value="">-Select-</option>
<option value="Cheque">Cheque</option>
<option value="Others">Others</option>
</select>
</td>
<td width="30px"></td>
<td style="visibility:hidden" id="chtd"><strong>Cheque No.</strong></td>
<td width="10px"></td>
<td style="visibility:hidden"><input type="text" id="chno" name="chno" value=""/></td>
</tr>
<tr height="10px"><td></td></tr>
</table>
<table align="center">
<tr>
<td></td>
</tr>
</table>
<br />
<center>
<input type="submit" value="Save" id="Save" disabled="disabled" name="Save"/>&nbsp;&nbsp;&nbsp;
<input name="button" type="button" onclick="document.location='dashboardsub.php?page=ac_pvoucher_a';" value="Cancel" />
</center>
<br />
<!-- </center> -->
</form>
<br />
<script type="text/javascript">
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
document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };
removeAllOptions(document.getElementById("desc"));
removeAllOptions(document.getElementById("drcr"));
   myselect1 = document.getElementById("desc");
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);
	<?php
		$q = "select coacode AS code from ac_bankmasters where client = '$client' ";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code' + a).value == '$qr[code]') { ";
		$q1 = "select code,description from ac_coa where code = '$qr[code]' and client = '$client' ";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
			  theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $q1r['description']; ?>");
			  theOption1.value = "<?php echo $q1r['code']; ?>";
 			  theOption1.selected = "true";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
		<?php 
		}
		echo " } "; 
		}
		?>
		
}
function loademp(loanac,loani)
{
 document.getElementById('emp'+loani).style.visibility='hidden';
 removeAllOptions(document.getElementById('emp'+loani));
 myselect1 = document.getElementById('emp'+loani);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
			  theOption1.value = "";
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);
			  myselect1.style.width = "220px";
			  //document.getElementById('desc').value = "";
<?php
     $q = "select * from hr_employee order by name";
		 $qrs = mysql_query($q) or die(mysql_error());
	 while($qr = mysql_fetch_assoc($qrs))
		{
			echo "if(loanac == '$qr[loanac]') { ";
?>
		 document.getElementById('emp'+loani).style.visibility='visible';
              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $qr['name']."@".$qr['sector']; ?>");
			  theOption1.value = "<?php echo $qr['name']."@".$qr['sector']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
	<?php echo "}";
	}	
		?>
}

function getdesc(cid)
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
}
*/
//document.getElementById('Save').disabled = false;
document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

		document.getElementById('desc' + a).value = document.getElementById('code' + a).value;
		var cidar = cid.split("code");
		if(index >= 0)
		{
		var codeemp = document.getElementById('code' + cidar[1]).value;
		loademp(codeemp,cidar[1]);
		}
		
		
}
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
}
*/
//document.getElementById('Save').disabled = false;
document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

		document.getElementById('code' + a).value = document.getElementById('desc' + a).value;
		
}


function codecoa()
{
 removeAllOptions(document.getElementById("code"));
removeAllOptions(document.getElementById("drcr"));
   myselect1 = document.getElementById("code");
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);
			  document.getElementById('desc').value = "";
			 
 var code = document.getElementById('cno').value;
 <?php 
     $q2=mysql_query("select code,coacode,acno from ac_bankmasters where client = '$client' order by code ASC");
     while($nt2=mysql_fetch_array($q2)){
	 if ( $mode == "Cash" )
	 {
	 echo "if(document.getElementById('cno').value == '$nt2[code]'){";
	 }
	 else
	 {
	 echo "if(document.getElementById('cno').value == '$nt2[acno]'){";
	 }
     
	
  ?>
              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt2['coacode']; ?>");
			  theOption1.value = "<?php echo $nt2['coacode']; ?>";
 			  theOption1.selected = "true";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
	<?php 
	
      echo "}"; 
     }
		?>
		
		description();     
         myselect2 = document.getElementById("drcr");

                    theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("-Select-");
			  theOption1.value = "";
			  theOption1.appendChild(theText1);
			  myselect2.appendChild(theOption1);

		 theOption1=document.createElement("OPTION");
	     theText1=document.createTextNode("<?php echo "Cr"; ?>");
         theOption1.value = "<?php echo "Cr"; ?>";
 	     theOption1.selected = "true";
	     theOption1.appendChild(theText1);
	     myselect2.appendChild(theOption1);
		//cheque(); 
		
}
function loadframe(a)
{
document.getElementById('desc').value = "";

removeAllOptions(document.getElementById('cno'));
var code = document.getElementById('cno');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
code.appendChild(theOption1);

if(a == "Cash")
{
document.getElementById('codename').innerHTML = "Cash Code";
<?php 
	  /* if($_SESSION['db'] == "feedatives")
		{*/
		   if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' order by code";
		   }
		   else
		   {
		    $sectorlist = $_SESSION['sectorlist'];
		  $q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) order by code";
		   }
		/* }
	   else
	   {
	   $q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' order by code";
	   }*/

	//$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' order by code";
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
}
else if(a == "Bank")
{
document.getElementById('codename').innerHTML = "Bank A/C No.";

<?php 
	
	
	  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' and client = '$client' order by acno";
		   }
		   else
		   {
		    $sectorlist = $_SESSION['sectorlist'];
			$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) order by acno";
		   }
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
function cheque()
{

  removeAllOptions(document.getElementById("pmode"));
   myselect1 = document.getElementById("pmode");
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);
  <?php 
 include "config.php";
     $q2=mysql_query("select code,acno,flag from ac_bankmasters where client = '$client' order by code ASC");
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('cno').value == '$nt2[acno]'){";
	
  ?>
			 
 	     <?php if ( $nt2['flag'] == 1) { ?>
			  theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("Cheque");
			  theOption1.value = "Cheque";
 			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			<?php } ?>

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("Others");
			  theOption1.value = "Other";
 			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			  
		
			  
			 
	<?php 
	
      echo "}"; 
     }
		?>

 chequeenable();
}


function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}

function chequeenable()
{
	if(document.getElementById('pmode').value == "Cheque")
	{
	document.getElementById('chno').style.visibility = "visible";
	document.getElementById('chtd').style.visibility = "visible";
          <?php $q = "select * from ac_chequeseries where client = '$client' order by id desc"; $qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs)) { ?>
		 <?php  echo "if(document.getElementById('cno').value == '$qr[acno]') { ";
		         $chkno = $qr['start'] + $qr['chls'] - $qr['rchls']; ?>
	   document.getElementById('chno').value = "<?php echo $chkno; ?>"; <?php
		  echo "}";
		}	?>

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
	if( document.getElementById('crtotal').value == document.getElementById('drtotal').value )
	{
	document.getElementById('Save').disabled = false;
	}
	else
	document.getElementById('Save').disabled = true;
}

function enabledrcr(b)
{
temp = b.split("cr");
var z = temp[1];	



document.getElementById('cramount' + z).value = 0;
document.getElementById('dramount' + z).value = 0;
//document.getElementById('crtotal').value = 0;
//document.getElementById('drtotal').value = 0;
	if(document.getElementById('drcr' + z).value == "Cr")
	{

	document.getElementById('cramount' + z).removeAttribute('readonly','readonly');
//document.getElementById('dramount' + z).value = 0;	
document.getElementById('dramount' +z).setAttribute('readonly',true);
      }
	else if(document.getElementById('drcr' + z).value == "Dr")
	{
document.getElementById('dramount' + z).onfocus = function ()  {  makeForm(); };
	document.getElementById('dramount' + z).removeAttribute('readonly','readonly');
	document.getElementById('cramount' +z).setAttribute('readonly',true);
	}
	else
	{
	document.getElementById('dramount' +z).setAttribute('readonly',true);
	document.getElementById('cramount' +z).setAttribute('readonly',true);
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
document.form1.action = "ac_savepvoucherc.php";
<?php } ?>

return true;
	
}
</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_t_addpaymentvoucher.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
