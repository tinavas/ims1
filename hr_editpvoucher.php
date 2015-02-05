<body >

<?php  

		include "config.php";

		include "jquery.php";

		$client = $_SESSION['client'];

		$sdb = $_SESSION['db'];

		

$mode = "";

            $voucher = 'EPV';

		$tnum = $_GET['id'];

		$q = "select * from ac_gl where transactioncode = '$tnum' AND voucher = '$voucher' order by id ";

		$qrs = mysql_query($q,$conn) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		  if($mode == "")

		  {

		  $mode = $qr['mode'];

		  }

		 
		  $tid=$qr['transactioncode'];
		  $transactioncode=$qr['transactioncode'];
		  $code = $qr['bccodeno'];

		  $crtotal = $qr['crtotal'];

		  $drtotal = $qr['drtotal'];

		  $pname = $qr['name'];

		  $pmode = $qr['pmode'];

		  $cheque = $qr['chequeno'];

		  //$stdate = $qr['date'];

		  $vstatus = $qr['vstatus'];

		  $stdate = date("d-m-Y",strtotime($qr['date']));

		  $remarks = $qr['remarks'];

		  //$unitc = $qr['costcenter'];

		   $unitc = $qr['warehouse'];

		   $vno = $qr['vouchernumber'];
		   $empname=$qr['empname'];
		}
//$query = "SELECT advance FROM hr_employee WHERE name = '$empname'";
//$result = mysql_query($query,$conn) or die(mysql_error());
//$rows = mysql_fetch_assoc($result);
//$codes = "'$rows[advance]'";
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
		if($_SESSION['db'] <> "central" && $_SESSION['db'] <> "alwadi") 

		{

		$q = "select warehouse from ac_financialpostings where trnum = '$tnum' AND type = 'EPV' LIMIT 1";

		$qrs = mysql_query($q,$conn) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		$unitc  = $qr['warehouse'];

		}

		}

?>



<center>

<br />

<h1>Payment Voucher</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/>

<br/><br />

<form id="form1" name="form1" method="post" action="hr_savepvoucher.php" onSubmit="return checkform1(this)">

<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />

<input type="hidden" id="saed" name="saed" value="1">
<input type="hidden" id="tid" name="transactioncode" value="<?php echo $tid;?>" >
<table border="0" align="center">

 <tr>
<td><strong>Emp. Name</strong></td>
		<td width="10px"></td>
		<td>
<select id="empname" name="empname" style="width:150px">
<option value="<?php echo $empname; ?>" title="<?php echo $empname; ?>" ><?php echo $empname; ?></option>

</select>
</td>

 <td><input type="radio" id="cash" name="cb" value="Cash" <?php if ( $mode == 'Cash') {?> checked <?php } ?> onClick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp; </td>

 <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="bank" name="cb" value="Bank" <?php if ( $mode == 'Bank') {?> checked <?php } ?> onClick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

 <td width="30px"></td>

 <td>&nbsp;&nbsp;&nbsp;<strong>Date</strong></td>

 <td width="10px"></td>

 <td><input type="text" size="15" id="date" class="datepicker" name="date" value="<?php echo $stdate; ?>" /></td>

  <td style="width:20px "></td>

  <?php $sdb = $_SESSION['db'];



 ?>

   <td>&nbsp;&nbsp;&nbsp;<strong>Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

 <td width="10px"></td>



 <td>

 <select id="unitc" name="unitc" >

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

<option value="<?php echo $qr['sector']; ?>"  <?php if($unitc== $qr['sector']) { ?> selected="selected" <?php }?>><?php echo $qr['sector']; ?></option>

<?php } ?>

</select>

 

 </td>

 <td width="10px"></td>



 </tr>

<tr height="10px"><td></td></tr>

</table>



<table align="center">

<tr>

<td><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" id="tno" name="tid" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  /></td>


<td width="40px"></td>

<td >

<strong id="codename"><?php echo $_GET['mode'];

 ?> Code No.</strong></td>

<td><select id="cno" name="cno" onChange="codecoa();">
<option value="">--Select--</option>

  <?php

  if($mode == "Cash")

  {

	  

		    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))

		   {

		   	$q = "select distinct(code) from ac_bankmasters where mode = '$mode' and client = '$client' order by code";

		   }

		   else

		   {

		  $sectorlist = $_SESSION['sectorlist'];

		  $q = "select distinct(code) from ac_bankmasters where mode = '$mode' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) order by code";

		   }



	$qrs = mysql_query($q) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs))

	{

		if ( $qr['code'] == $code) 

		{ ?>

		<option value="<?php echo $code; ?>"  selected="selected"><?php echo $code; ?></option>

		<?php 

		}

		else

		{ ?>

		<option value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>

		<?php  }

		}

   } 

    else

	{

	if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))

		   {

		   	 $q = "select distinct(acno) from ac_bankmasters where mode = '$mode' and client = '$client' order by acno";

		   }

		   else

		   {

		  $sectorlist = $_SESSION['sectorlist'];

		   $q = "select distinct(acno) from ac_bankmasters where mode = '$mode'  and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC))  order by acno";

		   }

	$qrs = mysql_query($q) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs))

	{

   if ( $qr['acno'] == $code) 

   { ?>

  <option value="<?php echo $code; ?>"  selected="selected"><?php echo $code; ?></option>

  <?php 

   }

   else

   { ?>

  <option value="<?php echo $qr['acno']; ?>"><?php echo $qr['acno']; ?></option>

  <?php  }

  } 

  }

  

  ?>

</select></td>

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

</tr>



<tr height="10px"><td></td></tr>



<script type="text/javascript">

var index = 0;

</script>

<?php 

	$i = 1;

	

	 $q = "select * from ac_gl where transactioncode = '$transactioncode' AND voucher = '$voucher' order by id ";

	$qrs = mysql_query($q,$conn) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs))

	{

	$empname = $qr['empname'];

?>

<script type="text/javascript">

index = index + 1;
//alert("in");

</script>

<tr>



<td style="text-align:left">

<input type="text"  id="sno<?php echo $i; ?>" name="sno" value="<?php echo $i; ?>" readonly style="border:0px;background:none" size="2"/></td>

<td width="10px"></td>

<td><select id="code<?php echo $i; ?>" name="code[]" onChange="check(<?php echo $i; ?>,this.value);description(<?php echo $i; ?>); total();"  style="width:70px">

  <option value="">Select</option>

  <?php

if($i==1)

{

?>

  <option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['code'] ?></option>

  <?php 

}

else

{
		$query = "SELECT salaryac,loanac FROM hr_employee WHERE name = '$empname'";
			$result = mysql_query($query,$conn) or die(mysql_error());
			$rows = mysql_fetch_assoc($result);
			
			$codes = "'$rows[salaryac]','$rows[loanac]'";
	
     	$q1 ="SELECT code,description FROM ac_coa WHERE code IN ($codes) ORDER BY code";

		$qrs1 = mysql_query($q1,$conn) or die(mysql_error());

		while($qr1 = mysql_fetch_assoc($qrs1))

		{
		
		?>
		<script type="text/javascript">
		//alert("<?php echo $query ?>");
		//alert("Selected code <?php echo $qr['code'] ?>");
		//alert("database code <?php echo $qr1['code'] ?>");
		</script>
		<?php

		if ( $qr1['code'] == $qr['code'] )

		 { 

?>

  <option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['code'] ?></option>

  <?php } else { ?>

  <option value="<?php echo $qr1['code']; ?>"><?php echo $qr1['code']; ?></option>

  <?php } } }?>

</select></td>

<td width="10px"></td>

<td>



<select id="desc<?php echo $i; ?>" name="desc[]" onChange="check(<?php echo $i; ?>,this.value); code(<?php echo $i; ?>); total();"  style="width:170px" >

<option value="">Select</option>

<?php

if($i==1)

{

?>

<option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['description'] ?></option>



<?php 

}

else

{

     $q1 = "SELECT code,description FROM ac_coa WHERE code IN ($codes) ORDER BY code";

		$qrs10 = mysql_query($q1,$conn) or die(mysql_error());

		while($qr1 = mysql_fetch_assoc($qrs10))

		{

		if ( $qr1['description'] == $qr['description'] )

		 { 

?>

<option value="<?php echo $qr['code'];?>" selected="selected"><?php echo $qr['description']; ?></option>

<?php } else { ?>

<option value="<?php echo $qr1['code']; ?>"><?php echo $qr1['description']; ?></option>

<?php } } }?>



</select>



</td>

<td width="10px"></td>

<td><select id="crdr<?php echo $i; ?>" name="drcr[]"  onchange="enabledrcr('<?php echo $i; ?>'); " style="width:50px">

  <option value="">Select</option>

  <?php

  if($i == 1)

  {

  ?>

    <option value="Cr" selected="selected">Cr</option>

  <?php }

  else

  {

  if ( $qr['crdr'] == "Cr" ) { ?>

  <option value="Cr" selected="selected">Cr</option>

  <?php } else { ?>

  <option value="Cr">Cr</option>

  <?php } ?>

  <?php if ( $qr['crdr'] == "Dr" ) { ?>

  <option value="Dr" selected="selected">Dr</option>

  <?php } else { ?>

  <option value="Dr" >Dr</option>

  <?php } 

  }?>

</select></td>

<td width="10px"></td>

<td>

<input type="text"  align="right" id="dramount<?php echo $i; ?>"  name="dramount[]" <?php if ( $qr['crdr'] == "Cr" ) { ?> readonly="" <?php  } ?> value="<?php echo $qr['dramount']; ?>" onKeyUp="total();" size="8" style="text-align:right" /></td>

<td width="10px"></td>

<td>

<input type="text" align="right" id="cramount<?php echo $i; ?>"  name="cramount[]" <?php if ( $qr['crdr'] == "Dr" ) {?> readonly <?php  } ?> value="<?php echo $qr['cramount']; ?>" onFocus="makeForm();"  onKeyUp="total();" size="8" style="text-align:right" /></td>



<td width="10px"></td>

<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"><?php echo $qr['rremarks'];?></textarea></td>

</tr>

<?php $i++; } ?>

</table>

</div>

<br />

<br />

<table cellpadding="5" cellspacing="5" align="center" border="0">

<tr>

<!--<td>

<input type="text" style="visibility:hidden" size="8" />

</td>

<td>

<input type="text" style="visibility:hidden" size="12"/>

</td>-->

<!--<td>

<input type="text" style="visibility:hidden" size="12"/>

</td>

<td>

<input type="text" style="visibility:hidden" size="10"/>

</td>-->



<td width="60px" align="right">

<strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

</td>

<td align="right">

<input type="text" id="drtotal" name="drtotal" value="<?php echo $drtotal; ?>" size="8" readonly style="border:0px;background:none; text-align:right;" />

</td>

<td align="right">

<input type="text" id="crtotal" name="crtotal" value="<?php echo $crtotal; ?>" size="8" readonly style="border:0px;background:none; text-align:right;"/>

</td>

<!--<td>

<input type="text" style="visibility:hidden" size="8"/>

</td>

--></tr>

</table>



<br />



<table align="center">

<tr>

<td width="250px"></td>

<td>

<strong>Payee Name</strong></td>

<td width="10px"></td>

<td><input type="text" name="pname" id="pname" value="<?php echo $pname; ?>" /></td>

<td width="10px"></td>

<td>

<strong>Payment Mode</strong></td>

<td width="10px"></td>

<td>

<select id="pmode" name="pmode" onChange="chequeenable();">

<option value="">Select</option>

<option value="Cheque"<?php if( $pmode == "Cheque" ) { ?>selected="selected" <?php } ?>>Cheque</option>

<option value="Others"<?php if( $pmode == "Others" ) { ?>selected="selected" <?php } ?>>Others</option>

</select></td>

<td width="10px"></td>

<td  id="chtd" <?php if($pmode != "Cheque") { ?> style="visibility:hidden;" <?php } ?> >

<strong>Cheque No.</strong></td>

<td width="10px"></td>

<td  <?php if($pmode != "Cheque") { ?> style="visibility:hidden;" <?php } ?>>

<input type="text" id="chno" name="chno" value="<?php echo $cheque; ?>" <?php if($cheque == "") { ?>  style="visibility:hidden" <?php } ?>/></td>



</tr>

</table>



<table align="center" style="visibility:hidden">
    <tr><td colspan="4" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b> Total</b></td>
    	<td><input type="text" id="gtotal" name="gtotal" readonly="readonly"  /></td>
        </tr>
	
</table>   

</div>



<center>

<input type="submit" value="Update" id="Update" name="Update" />&nbsp;&nbsp;&nbsp;

<input name="button" type="button" onClick="document.location='dashboardsub.php?page=hr_pvoucher';" value="Cancel" >

</center>

<br />

<!-- </center> -->

</form>

<br />


<script type="text/javascript">
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
	for(i=2;i<=index;i++)
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
function  checkamt(a,val)
{
	if(val!="")
	{
	valu=a.split("@");
	if(Number(document.getElementById("amount1@"+valu[1]).value)<Number(val))
	{
	alert("Amount Shoul be less then or equal to Bal amount");
	document.getElementById("amount2@"+valu[1]).value=0;
	}
	}
}
index1="<?php echo $j;?>";


function descriptionf()

{
	removeAllOptions(document.getElementById("desc"+1));

   myselect1 = document.getElementById("desc"+1);

             
	<?php

		$q = "select * from ac_coa";

		$qrs = mysql_query($q) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		echo "if(document.getElementById('code'+1).value == '$qr[code]') { ";

		$q1 = "select code,description from ac_coa where code = '$qr[code]'";

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

		document.getElementById('dramount' + 1).setAttribute('readonly',true);

		<?php 

		}

		echo " } "; 

		}

		?>

		

}







function description(z)

{
	
	
	
if(document.getElementById('code' + z).value=="")
{ 
   document.getElementById('desc' + z).value="";

	return false;
}
	
	
	<?php

		$q = "select * from ac_coa";

		$qrs = mysql_query($q) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		echo "if(document.getElementById('code' + z).value == '$qr[code]') { ";

		$q1 = "select code,description from ac_coa where code = '$qr[code]'";

		$q1rs = mysql_query($q1) or die(mysql_error());

		if($q1r = mysql_fetch_assoc($q1rs))

		{

	?>

	    document.getElementById('desc' + z).value = "<?php echo $q1r['code']; ?>";

		

		<?php 

		}

		echo " } "; 

		}

		?>

		
		

}





function code(z)

{


if(document.getElementById('desc' + z).value=="")
{ 
   document.getElementById('code' + z).value="";

	return false;
}

	<?php

		$q = "select * from ac_coa";

		$qrs = mysql_query($q) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		echo "if(document.getElementById('desc' + z).value == '$qr[code]') { ";

		$q1 = "select code,description from ac_coa where description = '$qr[description]'";

		$q1rs = mysql_query($q1) or die(mysql_error());

		if($q1r = mysql_fetch_assoc($q1rs))

		{

	?>

	    document.getElementById('code' + z).value = "<?php echo $q1r['code']; ?>";

		

		<?php 

		}

		echo " } "; 

		}

		?>

		

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


for(j=1;j<=index;j++)
{


k=j;

if(Number(document.getElementById('cramount' + k).value >0)  ||Number(document.getElementById('dramount' + k).value >0))
{
if(document.getElementById('code'+k).value=="" || document.getElementById('crdr'+k).value=="" || document.getElementById('desc'+k).value=="")
{


	alert("Select code")
	return false;

}


}




}

document.getElementById('Update').disabled=true;	
}





function codecoa()

{

removeAllOptions(document.getElementById("code"+1));
removeAllOptions(document.getElementById("crdr"+1));
removeAllOptions(document.getElementById("desc"+1));

 var code = document.getElementById('cno').value;
  myselect1=document.getElementById("code"+1);





 <?php 

 include "config.php";

     $q2=mysql_query("select code,coacode,acno from ac_bankmasters order by code ASC");

     while($nt2=mysql_fetch_array($q2))

	 {

	 ?>

	if ( document.getElementById('mode').value == "Cash" )

	 {

	

	 <?php

	 echo "if(document.getElementById('cno').value == '$nt2[code]'){";

	 ?>

	 theOption1=document.createElement("OPTION");

			  theText1=document.createTextNode("<?php echo $nt2['coacode']; ?>");

			  theOption1.value = "<?php echo $nt2['coacode']; ?>";

 			  theOption1.selected = "true";

			  

			  theOption1.appendChild(theText1);

			  myselect1.appendChild(theOption1);

			  <?php

			  echo "}"; 

			  ?>

	 }

	 else

	 {

	 

	 <?php

	 echo "if(document.getElementById('cno').value == '$nt2[acno]'){";

	 

	?>

	theOption1=document.createElement("OPTION");

			  theText1=document.createTextNode("<?php echo $nt2['coacode']; ?>");

			  theOption1.value = "<?php echo $nt2['coacode']; ?>";

 			  theOption1.selected = "true";

			  theOption1.appendChild(theText1);

			  myselect1.appendChild(theOption1);

			  <?php

			  echo "}"; 

			  ?>

	}

	<?php 

  

     }

		?>

			

		descriptionf();     

         myselect2 = document.getElementById("crdr"+1);



		 theOption1=document.createElement("OPTION");

	     theText1=document.createTextNode("<?php echo "Cr"; ?>");

         theOption1.value = "<?php echo "Cr"; ?>";

 	     theOption1.selected = "true";

	     theOption1.appendChild(theText1);

	     myselect2.appendChild(theOption1);

	
	document.getElementById('cramount1').readOnly=false;
	document.getElementById('dramount1').readOnly=true;	 
		if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Update').disabled=true;

}



function loadframe(a)

{
removeAllOptions(document.getElementById('code1'));
removeAllOptions(document.getElementById('desc1'));
removeAllOptions(document.getElementById('cno'));
removeAllOptions(document.getElementById('crdr1'));
var code = document.getElementById('cno');

if(a == "Cash")

{

document.getElementById('codename').innerHTML = "Cash Code";

document.getElementById('mode').value = "Cash";

<?php 

$modenew = "Cash";



	   $q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' order by code";




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

document.getElementById('mode').value = "Bank";



<?php 

$modenew = "Bank";



//$modenew = "Bank";

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
	document.getElementById('Update').disabled=true;


}

function cheque()

{



  removeAllOptions(document.getElementById("pmode"));

   myselect1 = document.getElementById("pmode");

  <?php 

 include "config.php";

     $q2=mysql_query("select code,acno,flag from ac_bankmasters order by code ASC");

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

          <?php $q = "select * from ac_chequeseries order by id desc"; $qrs = mysql_query($q) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs)) { ?>

		 <?php  echo "if(document.getElementById('cno').value == '$qr[acno]') { ";

		         $chkno = $qr['start'] + $qr['chls'] - $qr['rchls']; ?>

	   document.getElementById('chno').value = "<?php echo $chkno; ?>"; <?php

		  echo "}";

		}	?>



	}

	else

	{

	document.getElementById('chno').value = "<?php echo $cheque;?>";

	document.getElementById('chtd').style.visibility = "hidden";

	document.getElementById('chno').style.visibility = "hidden";

	}

	

}



function total()

{

    var ctot = 0;

	var dtot = 0;
	var tot=0;
	a1=0;
	for (var i = 1;i<=index;i++)

	{

		if(document.getElementById('cramount' + i).value=="")
		document.getElementById('cramount' + i).value=0;
		if(document.getElementById('dramount' + i).value=="")
		document.getElementById('dramount' + i).value=0;

	    ctot+=parseFloat(document.getElementById('cramount' + i).value);

		dtot+=parseFloat(document.getElementById('dramount' + i).value);
		<?php /*?>if(document.getElementById('code' + i).value=="<?php echo $adv;?>" && document.getElementById('code' + i).value=="<?php echo $loa;?>")<?php */?>
		if(document.getElementById('code' + i).value=="<?php echo $loa;?>")
		{
			a1=1;
		}
	}

	

	document.getElementById('crtotal').value = ctot;

	document.getElementById('drtotal').value = dtot;
   if(a1==0)
	{
	for (var i = 1;i<=index1;i++)
	{
		tot+=Number(document.getElementById('amount2@' + i).value);
	}
	document.getElementById('gtotal').value=tot;
	if( (document.getElementById('crtotal').value == document.getElementById('drtotal').value  ) )

	{

		document.getElementById('Update').disabled = false;

	}

	else

	{

			document.getElementById('Update').disabled = true;

	}
	}
	 if(a1==1)
	{
	if( document.getElementById('crtotal').value == document.getElementById('drtotal').value  )

	{

		document.getElementById('Update').disabled = false;

	}

	else

	{

			document.getElementById('Update').disabled = true;

	}
	}
	
	if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Update').disabled=true;

}



function enabledrcr(x)

{


document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount' + x).value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount' + x).value;


document.getElementById('cramount' + x).value = 0;

document.getElementById('dramount' + x).value = 0;

//document.getElementById('crtotal').value = 0;

//document.getElementById('drtotal').value = 0;

	if(document.getElementById('crdr' + x).value == "Cr")

	{

	document.getElementById('cramount' + x).removeAttribute('readonly','readonly');

	document.getElementById('dramount' + x).setAttribute('readonly',true);

	}

	else if(document.getElementById('crdr' + x).value == "Dr")

	{

	document.getElementById('dramount' + x).removeAttribute('readonly','readonly');

	document.getElementById('cramount' + x).setAttribute('readonly',true);

	}

	else

	{

	document.getElementById('dramount' +x).setAttribute('readonly',true);

	document.getElementById('cramount' +x).setAttribute('readonly',true);

	}

	
	
	if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Update').disabled=true;
	

}

</script>







<script type="text/javascript">

function makeForm() {



var prrr =document.getElementById('desc' + index).value;

<?php /*?>if( prrr != "" && document.getElementById('desc' + index).value!="<?php echo $adv;?>")
<?php */?>
if( prrr != "")
{

index = index + 1;
var m=index;
///////////para element//////////



var mytable=document.getElementById("mytable");

var myrow = document.createElement("tr");

var mytd = document.createElement("td");

    mytd.style.textAlign = "left";

var mybox1=document.createElement("label");



//mybox1.type="text";



//mybox1.name="sno[]";



//mybox1.size = "8";



theText1=document.createTextNode(index);

mybox1.appendChild(theText1);



mybox1.id = "sno" + parseFloat(index);

mybox1.size="2";

mytd.appendChild(mybox1);

myrow.appendChild(mytd);



myspace2= document.createTextNode('\u00a0');

var cca2 = document.createElement('td');

cca2.appendChild(myspace2);

myrow.appendChild(cca2);

mytable.appendChild(myrow);



var mytd1 = document.createElement("td");

myselect1 = document.createElement("select");

myselect1.id = "code" + index;

myselect1.name = "code[]";

myselect1.style.width = "70px";

theOption1=document.createElement("OPTION");

theText1=document.createTextNode("-Select-");



theOption1.appendChild(theText1);

theOption1.value = "";

myselect1.appendChild(theOption1);

myselect1.onchange = function ()  { check(m,this.value); description(index); total(); };





<?php

           include "config.php"; 
           $query  = "SELECT code,description FROM ac_coa WHERE code IN ($codes) ORDER BY code";

           $result = mysql_query($query,$conn); 

           while($row1 = mysql_fetch_assoc($result))

           {

?>

theOption1=document.createElement("OPTION");

theText1=document.createTextNode("<?php echo $row1['code']; ?>");

theOption1.appendChild(theText1);

theOption1.value = "<?php echo $row1['code']; ?>";

theOption1.title = "<?php echo $row1['description']; ?>";

myselect1.appendChild(theOption1);



<?php } ?>

mytd1.appendChild(myselect1);

myrow.appendChild(mytd1);

mytable.appendChild(myrow);



myspace2= document.createTextNode('\u00a0');

var cca2 = document.createElement('td');

cca2.appendChild(myspace2);

myrow.appendChild(cca2);

mytable.appendChild(myrow);



var mytd = document.createElement("td");



myselect1 = document.createElement("select");

myselect1.name = "desc[]";

myselect1.id = "desc" + index;

myselect1.style.width = "170px";

theOption1=document.createElement("OPTION");

theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);

myselect1.appendChild(theOption1);

myselect1.onchange = function ()  { check(m,this.value); code(index); total(); };



<?php 

                       $query= "SELECT code,description FROM ac_coa WHERE code IN ($codes) ORDER BY code";

                       $result = mysql_query($query); 

                       while($row1 = mysql_fetch_assoc($result))

                       {

?>

theOption1=document.createElement("OPTION");

theText1=document.createTextNode("<?php echo $row1['description']; ?>");

theOption1.appendChild(theText1);

theOption1.value = "<?php echo $row1['code']; ?>";

myselect1.appendChild(theOption1);



<?php } ?>



mytd.appendChild(myselect1);



myrow.appendChild(mytd);





myspace2= document.createTextNode('\u00a0');

var cca2 = document.createElement('td');

cca2.appendChild(myspace2);

myrow.appendChild(cca2);

mytable.appendChild(myrow);





var mytd1 = document.createElement("td");

var myselect1 = document.createElement("select");
myselect1.name = "drcr[]";

myselect1.id = "crdr" + index;

myselect1.style.width = "50px";

theOption1=document.createElement("OPTION");

theText1=document.createTextNode('Select');

theOption1.appendChild(theText1);

theOption1.value = "";

myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");

theText1=document.createTextNode('Cr');

theOption1.appendChild(theText1);

theOption1.value = "Cr";

myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");

theText1=document.createTextNode('Dr');

theOption1.appendChild(theText1);

theOption1.value = "Dr";

myselect1.appendChild(theOption1);
myselect1.width="50px";

myselect1.onchange = function ()  {  enabledrcr(index); };

mytd1.appendChild(myselect1);

myrow.appendChild(mytd1);

mytable.appendChild(myrow);



myspace2= document.createTextNode('\u00a0');

var cca2 = document.createElement('td');

cca2.appendChild(myspace2);

myrow.appendChild(cca2);

mytable.appendChild(myrow);





var mytd = document.createElement("td");

var mybox1=document.createElement("input");

mybox1.type="text";

mybox1.name="dramount[]";

mybox1.style.textAlign = "right";

mybox1.setAttribute('readonly',true);



mybox1.value = 0;

mybox1.size = "8";

mybox1.id = "dramount" + index;

mybox1.onkeyup = function ()  {  total(); };

mytd.appendChild(mybox1);

myrow.appendChild(mytd);



myspace2= document.createTextNode('\u00a0');

var cca2 = document.createElement('td');

cca2.appendChild(myspace2);

myrow.appendChild(cca2);

mytable.appendChild(myrow);





var mytd = document.createElement("td");

var mybox1=document.createElement("input");

mybox1.type="text";

mybox1.name="cramount[]";

mybox1.setAttribute('readonly',true);

mybox1.size = "8";

mybox1.value = 0;

mybox1.id = "cramount" + index;

mybox1.style.textAlign = "right";

mybox1.onfocus = function() { makeForm(); };

mybox1.onkeyup = function ()  {  total(); };



mytd.appendChild(mybox1);

myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);


var mytd = document.createElement("td");
var mybox1=document.createElement("textarea");
mybox1.name="remarks[]";
mybox1.rows = "2";
mybox1.cols = "30";
mybox1.id = "remarks" + index;
mytd.appendChild(mybox1);
myrow.appendChild(mytd);
mytable.appendChild(myrow);

mytable.appendChild(myrow);



var mytd = document.createElement("td");

var mybox1=document.createElement("select");







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



