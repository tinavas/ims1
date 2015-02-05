<?php  
$mode = $_GET['mode'];
$sdb = $_SESSION['db'];
$empname1 = $_GET['empname'];

		include "config.php";
		include "jquery.php";
$voucher = 'EPV';

//$query = "SELECT advanceac FROM hr_employee WHERE name = '$empname'";
//$result = mysql_query($query,$conn) or die(mysql_error());
//$rows = mysql_fetch_assoc($result);
//$codes = "'$rows[advanceac]'";
//$query = "SELECT code,description FROM ac_coa WHERE code IN ($codes) ORDER BY code";
//$result = mysql_query($query,$conn) or die(mysql_error());
//$row1 = mysql_fetch_assoc($result);
//$adv="$row1[code]";	
	
$query = "SELECT loanac FROM hr_employee WHERE name = '$empname'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$codes1 = "'$rows[loanac]'";
$query = "SELECT code,description FROM ac_coa WHERE code IN ($codes1) ORDER BY code";
$result = mysql_query($query,$conn) or die(mysql_error());
$row1 = mysql_fetch_assoc($result);
$loa="$row1[code]";
 include "hr_addpvoucher1.php"; 
 
 	$trnum1="";		
 $q = "select transactioncode as tid from  `ac_gl` where client = '$client' and voucher = '$voucher'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],4);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$tnum = "EPV-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tnum="EPV-1";

}


?>
<center>
<br />
<h1>Employee Payment Voucher</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="hr_savepvoucher.php" onsubmit="return checkform1(this)" > 
<input type="hidden" id="mode" name="mode" value="<?php echo $_GET['mode']; ?>" />
<table border="0" align="center">
 <tr>
 
		<td><strong>Emp. Name</strong></td>
		<td width="10px"></td>
		<td>
		
			<select id="empname" name="empname" onchange="reloadpage()" style="width:150px">
			<option value="">-Select-</option>
			<?php
			$query = "SELECT name FROM hr_employee order by name";
			 $result = mysql_query($query,$conn) or die(mysql_error());
			 while($rows = mysql_fetch_assoc($result))
			 {
			 
				?>
				
				<option value="<?php echo $rows['name']; ?>" title="<?php echo $rows['name']; ?>" <?php if($empname1 == $rows['name']) { ?> selected="selected" <?php } ?>><?php echo $rows['name']; ?></option>
				<?php
			 }
			?>
			</select>
		</td>
		<?php include "hr_addpvoucher1.php"; ?>
		 <td width="10px"></td>
 <td><input type="radio" id="cash" name="cb" value="Cash" <?php if ( $mode == 'Cash') {?> checked <?php } ?> onClick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="ank" name="cb" value="Bank" <?php if ( $mode == 'Bank') {?> checked <?php } ?> onClick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td width="30px"></td>
 <td>&nbsp;&nbsp;&nbsp;<strong>Date</strong></td>
 <td width="10px"></td>
 <td><input type="text" size="15" id="date" class="datepicker"name="date" value="<?php echo date("d.m.o"); ?>" /></td>
  <?php $sdb = $_SESSION['db'];
 ?>
   <td>&nbsp;&nbsp;&nbsp;<strong>Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>

 <td>

 <select id="unitc" name="unitc"  >

<option value="">-Select-</option>

<?php 

        if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))

	{

     

		$q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse' order by sector";

	  

	 }

	 else

	 {

	 $sectorlist = $_SESSION['sectorlist'];

	

		$q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse'  and sector in ($sectorlist) order by sector";

	  

	 }

		$qrs = mysql_query($q,$conn) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

?>

<option value="<?php echo $qr['sector']; ?>"><?php echo $qr['sector']; ?></option>

<?php } ?>

</select>


 

 

 </td>


 </tr>

<tr height="10px"><td></td></tr>

</table>



<table align="center">

<tr>

<td><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" id="tno" name="tid" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  /></td>



<td width="40px"></td>





<td width="40px"></td>



<td><strong id="codename">Code No.</strong>&nbsp;&nbsp;&nbsp;</td>

<td>

<select id="cno" name="cno" onChange="codecoa();">

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
</thead>



<tr height="10px"><td></td></tr>



<tr>

<td><label id="sno">1</label></td>

<td width="10px"></td>

<td><select id="code" name="code[]" onChange="getdesc(this.id); total();">

        <option value="">-Select-</option>

<?php $q = "select code,description,controltype from ac_coa  where client = '$client' and code IN (select coacode from ac_bankmasters) order by code "; $qrs = mysql_query($q,$conn) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs)) { ?>

<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>

<?php } ?>

</select></td>

<td width="10px"></td>

<td><select id="desc" name="desc[]" style="width:170px;" onChange="getcode(this.id); total();">

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

<td><select id="drcr" name="drcr[]" onChange="enabledrcr(this.id);">

      <option value="">-Select-</option><option value="Cr">Cr</option><option value="Dr">Dr</option>

</select></td>

<td width="10px"></td>

<td><input type="text" id="dramount" name="dramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" onblur="total();" readonly /></td>

<td width="10px"></td>

<td><input type="text" id="cramount" name="cramount[]" value="0" style="text-align:right" size="8" onkeyup="total();"  onblur="total();" /></td>
<td width="10px"></td>

<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"></textarea></td>





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

<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?> ><select id="pmode" name="pmode" onChange="chequeenable();">

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




    <table align="center" style="visibility:hidden">
    <tr><td colspan="4" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> Total</b></td>
    	<td><input type="text" id="gtotal" name="gtotal" readonly="readonly"  /></td>
        </tr>
	
</table>   
   

<center>

<input type="submit" value="Save" id="Save" disabled="disabled" name="Save" />&nbsp;&nbsp;&nbsp;

<input name="button" type="button" onClick="document.location='dashboardsub.php?page=hr_pvoucher';" value="Cancel" />

</center>

<br />

<!-- </center> -->

</form>

<br />

<script type="text/javascript">
function reloadpage()
{
 var empname = document.getElementById("empname").value;
 document.location = "dashboardsub.php?page=hr_addpvoucher&empname="+empname;
}
function check1(a)
{
	for(i=1;i<=index1;i++)
	{
		if(i != a)
		{
			if(document.getElementById("tecn@"+i).value != "")
			if(document.getElementById("tecn@"+i).value==document.getElementById("tecn@"+a).value)
				{
					alert("Select Different combination");
					document.getElementById("tecn@"+a).value="";
				}
		}
	}
}
function check(a,b)
{
	
	for(i=0;i<=index;i++)
	{
		if(i != a)
		{
			if(document.getElementById("code"+i).value != "" || document.getElementById("desc"+i).value != "")
			if(document.getElementById("code"+i).value==b)
				{
					alert("Select Different combination");
					document.getElementById("code"+a).value="";
					document.getElementById("desc"+a).value="";
				}
		}
	}
}
function getamount(a,val)
{
	if(val!="")
	{
	valu=val.split("@");
	document.getElementById("amount1@"+a).value=valu[1];
	}
}
function validatekey(a)
{ 
 if((a<48 || a>57) && a!=46 && a!=13)	//48-57 are for0-9; 46 is for .(dot-decimal); 13 for Enter key 
  event.keyCode=false;
}

index1=1;

function description()

{



if(index == -1)

var a = "";

else

var a = index;

var i1,j1;

document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

removeAllOptions(document.getElementById("desc"));

removeAllOptions(document.getElementById("drcr"));

   myselect1 = document.getElementById("desc");

            
	<?php

		$q = "select coacode AS code from ac_bankmasters where client = '$client' ";

?>
//alert("<?php echo $q ?>");
<?php
		$qrs = mysql_query($q) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		echo "if(document.getElementById('code' ).value == '$qr[code]') { ";

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



function getdesc(cid)

{



if(index == -1)

var a = "";

else

var a = index;

var i1,j1;

var a=cid.substr(4,cid.length);

if(document.getElementById('code' + a).value=="")
{
		document.getElementById('desc' + a).value = "";
		return false;
}


document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

for(i=-1;i<=index;i++)
{

for(j=-1;j<=index;j++)
{



if(i!=j)

{

if(i==-1)
i="";
if(j==-1)
j="";
if(document.getElementById('code' +i).value==document.getElementById('code' +j).value)


{document.getElementById('code' +a).value="";

document.getElementById('desc' +a).value="";
	alert("Please select different combination");
	
	return false;
	
}


}

}

}
		

		var cidar = cid.split("code");
		//alert(index);
		if(index >= 0)

		{
		

		var codeemp = document.getElementById('code' + cidar[1]).value;
		document.getElementById('desc' + cidar[1]).value = document.getElementById('code' +  cidar[1]).value;
	
		}
		
		else
		{
		document.getElementById('desc').value=document.getElementById('code').value;
		}

}

function getcode(cid)

{

if(index == -1)

var a = "";

else

var a = index;

var i1,j1;

document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };




var a=cid.substr(4,cid.length);

if(document.getElementById('desc' + a).value=="")
{
		document.getElementById('code' + a).value = "";
		return false;
}



for(i=-1;i<=index;i++)
{

for(j=-1;j<=index;j++)
{



if(i!=j)

{

if(i==-1)
i="";
if(j==-1)
j="";
if((document.getElementById('desc' +i).value==document.getElementById('desc' +j).value)&&(document.getElementById('desc' +i).value!="" && document.getElementById('desc' +j).value!=""))


{document.getElementById('desc' +a).value="";
	
	document.getElementById('code' +a).value="";
	alert("Please select different combination");
	
	return false;
	
}


}

}

}
		





		document.getElementById('code' + a).value = document.getElementById('desc' + a).value;

	  
		var cidar = cid.split("desc");
		//alert(index);
		if(index >= 0)

		{
		

		var codeemp = document.getElementById('desc' + cidar[1]).value;
		document.getElementById('code' + cidar[1]).value = document.getElementById('desc' +  cidar[1]).value;
	
		}
		
		else
		{
		document.getElementById('code'+ cidar[1]).value=document.getElementById('desc'+ cidar[1]).value;
		}	

}





function codecoa()

{

 removeAllOptions(document.getElementById("code"));

removeAllOptions(document.getElementById("drcr"));

   myselect1 = document.getElementById("code");

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

	     theText1=document.createTextNode("<?php echo "Cr"; ?>");

         theOption1.value = "<?php echo "Cr"; ?>";

 	     theOption1.selected = "true";

	     theOption1.appendChild(theText1);

	     myselect2.appendChild(theOption1);

	document.getElementById('cramount').readOnly=false;
	document.getElementById('dramount').readOnly=true;	 
		if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Save').disabled=true;

}

function loadframe(a)

{

removeAllOptions(document.getElementById('code'));
removeAllOptions(document.getElementById('desc'));
removeAllOptions(document.getElementById('cno'));
removeAllOptions(document.getElementById('drcr'));
var code = document.getElementById('cno');



document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount' ).value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount').value;
document.getElementById('cramount').value=0;
document.getElementById('dramount').value=0;

if(a == "Cash")
{
document.getElementById('codename').innerHTML = "Cash Code";
<?php 
	
		   if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' order by code";
		   }
		   else
		   {
		    $sectorlist = $_SESSION['sectorlist'];
		  $q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) order by code";
		   }


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

	if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Save').disabled=true;

}




function checkform1(form)
{


if(form.empname.value == "")
{
alert ('Please Select Employee');

return false;
}


if(form.unitc.value == "")
{
alert("Please Select Unit");
 form.unitc.focus();
return false;
}


if(form.cash.checked == false && form.bank.checked==false)
{
alert("Please select mode");

return false;
}


if(form.cno.value == "")

{
alert("Please code ");

return false;
}




for(j=-1;j<=index;j++)
{

if(j==-1)
 k= "";

else
k=j;

if(Number(document.getElementById('cramount' + k).value >0)  ||Number(document.getElementById('dramount' + k).value >0))
{
if(document.getElementById('code'+k).value=="" || document.getElementById('drcr'+k).value=="" || document.getElementById('desc'+k).value=="")
{


	alert("Select code")
	return false;

}


}




}

document.getElementById('Save').disabled=true;	
}



function cheque()

{



  removeAllOptions(document.getElementById("pmode"));

   myselect1 = document.getElementById("pmode");

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

	for(i=selectbox.options.length;i>0;i--)

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





function total()
{
if(index == -1)
var a = "";
else 
var a = index;
	var ctot = 0;
	var dtot = 0;
	var tot=0;
	var i1;
	a1=0;
	for (var i = -1;i<=index;i++)
	{
		if(i == -1)
		i1 = "";
		else
		i1 = i;
		if(document.getElementById('cramount' + i1).value=="")
		document.getElementById('cramount' + i1).value=0;
		if(document.getElementById('dramount' + i1).value=="")
		document.getElementById('dramount' + i1).value=0;
		
		ctot+=parseFloat(document.getElementById('cramount' + i1).value);
		dtot+=parseFloat(document.getElementById('dramount' + i1).value);
		if(document.getElementById('code' + i1).value=="<?php echo $loa;?>")
		{
			a1=1;
		}
		
	}
	
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
	if(a1==0)
	{
	
	document.getElementById('gtotal').value=tot;
	if(( document.getElementById('crtotal').value == document.getElementById('drtotal').value ) &&( document.getElementById('crtotal').value == tot ) && (tot!="0"))
	{
	document.getElementById('Save').disabled = false;
	}
	else
	document.getElementById('Save').disabled = true;
	}
	if(a1==1)
	{
	if( (document.getElementById('crtotal').value == document.getElementById('drtotal').value) &&  (document.getElementById('crtotal').value!="0") )
	{
	document.getElementById('Save').disabled = false;
	}
	else
	document.getElementById('Save').disabled = true;
	
	}
	
		if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Save').disabled=true;
	
}
function enabledrcr(b)

{

temp = b.split("cr");

var z = temp[1];	

document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount' + z).value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount' + z).value;






document.getElementById('cramount' + z).value = 0;

document.getElementById('dramount' + z).value = 0;

//document.getElementById('crtotal').value = 0;

//document.getElementById('drtotal').value = 0;

	if(document.getElementById('drcr' + z).value == "Cr")

	{



	document.getElementById('cramount' + z).removeAttribute('readonly','readonly');



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
if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Save').disabled=true;
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

