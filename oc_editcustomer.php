<?php
include "config.php";
$id=$_GET['id'];
$get_Details="SELECT * FROM contactdetails WHERE id = '$id'";
$result_Details=mysql_query($get_Details,$conn);
$rows=mysql_num_rows($result_Details);
$details=mysql_fetch_array($result_Details);
$name=$details['name'];
$address=$details['address'];
$place=$details['place'];
$phone=$details['phone'];
$mobile=$details['mobile'];
$contact_type=$details['type'];
$pan=$details['pan'];
$customer_group=$details['cgroup'];
$note=$note['note'];
$supplier_group = $details['vgroup'];
$cterm = $details['cterm'];
$climit = $details['climit'];
$code=$details['code'];
$category = $details['customercategory'];
 $state=$details['state'];
$superstockist=$details['superstockist'];
if($state!="")
{
$sflag=1;
}




              $party = $name;
			  $cnt = $cnt2 = 0;
		   $query1 = "SELECT count(*) as c1 FROM oc_receipt where party = '$party' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt = $row1a['c1'];
		   }
		   if($cnt == 0)
		   {
		    $query1 = "SELECT count(*) as c1 FROM oc_cobi where party = '$party' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt = $cnt + $row1a['c1'];
		   }
		   }
		   
		   $query1 = "SELECT count(*) as c1 FROM pp_payment where vendor = '$party' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt2 = $row1a['c1'];
		   }
		   if($cnt2 == 0)
		   {
		    $query1 = "SELECT count(*) as c1 FROM pp_sobi where vendor = '$party' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt2 = $cnt2 + $row1a['c1'];
		   }
		   }
		   
?>
<center>
<br/>
<h1>Customer Details</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="oc_updatecustomer.php" onSubmit="return checkform(this);">
<input type="hidden" id="oldid" name="oldid" value="<?php echo $id; ?>" />
<table>

<tr>
<td align="right" style="vertical-align:middle;"><strong>Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="vertical-align:middle;  "><input  <?php if($cnt >0){?> style="border:none;background:none;" readonly <?php }?>type="text" id="name" name="name" size="30" value="<?php echo $name; ?>" /></td>

<td id="usercheck"></td>
<td style="display:none" id="loading" ><img  title="Verifying the Customer Name" src="images\mask-loader.gif" ></td>

<td align="right" style="vertical-align:middle;"><strong>Address</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="30" name="address"><?php echo $address; ?></textarea></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Place</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="place" size="30" value="<?php echo $place; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Phone</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="phone" size="30" value="<?php echo $phone; ?>"></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Mobile </strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mobile" size="30" value="<?php echo $mobile; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Contact Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select id="type" name="type" style="width:200px" onchange="loadfun(this.value)">

<?php
$select_party="";
$select_vendor_party="";
$select_broker="";
 if($contact_type=="party")
  $select_party="selected='selected'";
 else if($contact_type=="vendor and party")
  $select_vendor_party="selected='selected'";
 else if($contact_type=="broker")
  $select_broker="selected='selected'";
 if($cnt2 >0){ ?>
<option value="vendor and party" <?php echo $select_party; ?>>Supplier &amp; Customer</option>
<?php } else { ?>
<option value="party" <?php echo $select_vendor; ?>>Customer</option>
<option value="vendor and party" <?php echo $select_vendor_party; ?>>Supplier &amp; Customer</option>
<option value="broker" <?php echo $select_broker; ?>>Broker</option>
<?php } ?>
</select></td></tr>


<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>PAN/TIN</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pan" size="30" value="<?php echo $pan; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Customer Group</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="cgroup" style="width:200px" >

<?php 
 if($cnt >0){ 
  $cond = " AND vgroup = '$customer_group'";
 } else { ?>
 <option value="">-Select-</option> 
<?php }
if($customer_group == "")  {
  $cond="";
 } 
		$q = "select * from ac_vgrmap where flag = 'C' $cond  ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		?>
<option title="<?php echo $qr['vdesc']; ?>" value="<?php echo $qr['vgroup'].'@'.$qr['vca'].'@'.$qr['vppac']; ?>"  <?php if($customer_group=$qr['vgroup']) { ?> selected="selected" <?php } ?>><?php echo $qr['vgroup']; ?></option>
<?php } ?>

</select>	
</td></tr>

<tr style="height:10px"></tr>


<tr id = "trvgroup" <?php if($contact_type <> "vendor and party") { ?> style="display:none" <?php } ?>>
<td align="right"><strong></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;<strong>Supplier Group</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="vgroup" style="width:200px" >
<?php 
$cond = "";
 if($cnt2 >0){ 
  $cond = " AND vgroup = '$supplier_group'";
 } else { ?>
 <option value="">-Select-</option> 
<?php }
if($supplier_group == "")  {
  $cond="";
 }       
		$q = "select * from ac_vgrmap where flag = 'V' $cond";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{ 
		?>
<option title="<?php echo $qr['vdesc']; ?>" value="<?php echo $qr['vgroup'].'@'.$qr['vca'].'@'.$qr['vppac']; ?>" <?php if($supplier_group == $qr['vgroup']) { ?> selected="selected" <?php }  ?>><?php echo $qr['vgroup']; ?></option>
<?php } ?>
</select></td>
</tr>

<tr style="height:10px"></tr>


<tr>
<td align="right"><strong>Credit Limit</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="climit" name="climit" size="30" onkeyup="validatenumber(this.id,this.value);" value="<?php echo $climit; ?>"/></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;<strong>Credit Term</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="cterm" style="width:200px">
 <option value="0">-Select-</option>
<?php 
       
		$q = "select * from ims_creditterm";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['value']; ?>" <?php if($cterm == $qr['value']) { ?> selected="selected" <?php } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select></td>
</tr>



<?php

if($_SESSION['db']=="singhsatrang")
{
?>
<tr style="height:10px"></tr>
<tr>
<td align="right"><strong>CNF/Super Stockist</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="checkbox" id="stockist" name="stockist" size="30"  value="YES" onclick="getstatevalue(this.checked)" <?php if($superstockist=="YES"){?> checked="checked" <?php }?>/></td>
<td width="10px"></td>
<td align="right" id="stateid" <?php if($sflag!=1){?> style="visibility:hidden" <?php }?>>&nbsp;&nbsp;<strong>State</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" id="statevalueid" <?php if($sflag!=1){?> style="visibility:hidden" <?php }?>><select name="state" id="state" style="width:200px;">
 <option value="">-Select-</option>
<?php
$q1="select distinct state from state_districts where state not in (select distinct state from contactdetails where state!='' and state is not null and id!='$id')";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['state'];?>" <?php if($state==$r1['state']) {?> selected="selected" <?php }?>><?php echo $r1['state'];?></option>


<?php

}

?>




</select></td></tr>

<?php }?>


<tr style="height:10px"></tr>
<tr>
<td align="right"><strong></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td>
<td width="10px"></td>

</tr>
<tr style="height:10px"></tr>

<tr>
<td align="right" colspan="2" style="vertical-align:middle;"><strong>Note</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left" colspan="3"><textarea rows="4" cols="35" name="note" ><?php echo $note; ?></textarea></td>
</tr>
<tr><td><input type="hidden" id="id" name="id" value="<?php echo $id; ?>"></td></tr>


</table>

<table>
<br />
<td>
<input type="submit" value="Update" id="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_customer';">

</form>
</center>
</td></tr>
</table>

</center>
<script language="JavaScript" type="text/javascript">
function loadfun(a)
{
 if(a=='vendor and party')
  document.getElementById('trvgroup').style.display="block";
 else 
  document.getElementById('trvgroup').style.display="none";
}


function validatenumber(a,b)
{
 var expr=/^[0-9]*$/;
 if(! b.match(expr))
 {
  alert("It should be a Number");
  document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
}

function checkform ( form )
{
var numericExpression = /^[0-9]+$/;
    if (form.name.value == "") {
    alert( "Please enter Name." );
    form.name.focus();
    return false ;
  }
   else if (form.address.value == "") {
    alert( "Please enter Address." );
    form.address.focus();
    return false ;
  }
    else if (form.phone.value == "") {
    alert( "Please enter Phone no." );
    form.phone.focus();
    return false ;
  }
    else if (!(form.phone.value.match(numericExpression))) {
    alert( "Phone Number Should be Numeric only." );
    form.phone.focus();
    return false ;
  }
    else if (form.phone.value.length < 5 ) {
    alert( "Phone Number Should be atleast 05 digits." );
    form.phone.focus();
    return false ;
  }
     else if (form.mobile.value == "") {
    alert( "Please enter Mobile number." );
    form.mobile.focus();
    return false ;
  }
    else if (!(form.mobile.value.match(numericExpression))) {
    alert( "Mobile Number Should be Numeric only." );
    form.mobile.focus();
    return false ;
  }
    else if (form.mobile.value.length < 10 ) {
    alert( "Mobile Number Should be atleast 10 digits." );
    form.mobile.focus();
    return false ;
  }
  else if (form.type.value == "") {
    alert( "Please select Contact Type" );
    form.type.focus();
    return false ;
  }
  else if ((form.cgroup.value == "") || (form.cgroup.value == "-Select-")) {
    alert( "Please select Customer Group" );
    form.cgroup.focus();
    return false ;
  }
  else if (form.type.value == "vendor and party") {
	if ((form.vgroup.value == "") || (form.vgroup.value == "-Select-")) {
    alert( "Please select Suppplier Group" );
    form.vgroup.focus();
    return false ;
	}
  }

  return true ;
}


 $(document).ready(function()
{  	
	$("#name").blur(function()
	{  
	   
	   if($("#name").val()) {
	   document.getElementById("usercheck").innerHTML='';
	   document.getElementById("usercheck").style.display='none';
	   document.getElementById("loading").style.display='';
		$.post("getcontactdetailsedit_ajax.php",{ name:$("#name").val(),oldid:$("#oldid").val() },function(data)
        { 
		document.getElementById("loading").style.display='none';
		if(data>0)
		 {		  
		  document.getElementById("name").value='';
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("usercheck").innerHTML='*Customer Name Exists';
		  document.getElementById("usercheck").style.color='#FF0000';
		  document.getElementById("submit").disabled='disabled';
		  alert('Customer Name already exists');
		 }
		 else
		 {
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("submit").disabled='';
		 }
		});
		
	} // end of if
});
});

function getstatevalue(status)
{

document.getElementById("stateid").style.visibility="hidden";
document.getElementById("statevalueid").style.visibility="hidden";

if(status)
{

document.getElementById("stateid").style.visibility="visible";
document.getElementById("statevalueid").style.visibility="visible";

}
}


</script>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_m_addcustomer.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
