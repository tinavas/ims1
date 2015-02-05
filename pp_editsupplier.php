<?php
include "config.php";

$id=$_GET['id'];
$get_Details="SELECT * FROM contactdetails WHERE id = '$id'";
$result_Details=mysql_query($get_Details,$conn);
$details=mysql_fetch_array($result_Details);
$name=$details['name'];
$address=$details['address'];
$place=$details['place'];
$phone=$details['phone'];
$mobile=$details['mobile'];
$contact_type=$details['type'];
$pan=$details['pan'];
$supplier_group=$details['vgroup'];
$note=$note['note'];
$currencyflag = $details['currencyflag'];
$currency = $details['currency'];
$customer_group = $details['cgroup'];
$cterm=$details['cterm'];
$code=$details['code'];
$vendor = $name;
$custom=$details['custom'];
              
			$cnt = 0; $cnt2 = 0;
		   $query1 = "SELECT count(*) as c1 FROM pp_payment where vendor = '$vendor' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt = $row1a['c1'];
		   }
		   if($cnt == 0)
		   {
		    $query1 = "SELECT count(*) as c1 FROM pp_sobi where vendor = '$vendor' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt = $cnt + $row1a['c1'];
		   }
		   }
		   
		   $query1 = "SELECT count(*) as c1 FROM oc_receipt where party = '$vendor' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt2 = $row1a['c1'];
		   }
		   if($cnt2 == 0)
		   {
		    $query1 = "SELECT count(*) as c1 FROM oc_cobi where paty = '$vendor' ";
           $result1 = mysql_query($query1,$conn); 
           while($row1a = mysql_fetch_assoc($result1))
           {	
		   $cnt2 += $row1a['c1'];
		   }
		   }

		   ?>
<center>
<br/>
<h1>Supplier Details</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="pp_updatesupplier.php" onSubmit="return checkform(this);">
<table border="0">

<tr>
<td align="right" style="vertical-align:middle;"><strong>Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="vertical-align:middle;"><input <?php if(($cnt+$cnt2) >0){?> style="border:none;background:none;" readonly <?php }?> type="text" name="name" size="30" value="<?php echo $name; ?>"/></td>
<td width="10px"></td>
<td align="right" style="vertical-align:middle;"><strong>Address</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="30" name="address"><?php echo $address; ?></textarea></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Place</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="place" size="30" value="<?php echo $place; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Phone</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="phone" size="30" value="<?php echo $phone; ?>"/></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Mobile</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mobile" size="30" value="<?php echo $mobile; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Contact Type</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="type" style="width:200px"  onchange="loadfun(this.value)" >
<?php
$select_vendor="";
$select_vendor_party="";
$select_broker="";
 if($contact_type=="vendor")
  $select_vendor="selected='selected'";
 else if($contact_type=="vendor and party")
  $select_vendor_party="selected='selected'";
 else if($contact_type=="broker")
  $select_broker="selected='selected'";
 if($cnt2 >0){ ?>
<option value="vendor and party" <?php echo $select_vendor_party; ?>>Supplier &amp; Customer</option>
<?php } else { ?>
<option value="vendor" <?php echo $select_vendor; ?>>Supplier</option>
<option value="vendor and party" <?php echo $select_vendor_party; ?>>Supplier &amp; Customer</option>
<option value="broker" <?php echo $select_broker; ?>>Broker</option>
<?php } ?>
</select></td></tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>PAN/TIN</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pan" size="30" value="<?php echo $pan; ?>"/></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;<strong>Supplier Group</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="vgroup" style="width:200px">
<option value="Select">-Select-</option>
<?php 
$cond = "";
 if($cnt >0){ 
  $cond = " AND vgroup = '$supplier_group'";
 } 
 else  { ?>
 <option value="">-Select-</option> 
<?php }
if($supplier_group == "")  {
  $cond="";
 }  
	    echo $q = "select * from ac_vgrmap where flag = 'V' $cond";
		echo $qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		?>
		<option title="<?php echo $qr['vdesc']; ?>" value="<?php echo $qr['vgroup'].'@'.$qr['vca'].'@'.$qr['vppac']; ?>" <?php if($supplier_group==$qr['vgroup']) { ?> selected="selected" <?php  } ?>><?php echo $qr['vgroup']; ?></option>
<?php }  ?>
</select></td>
</tr>

<tr style="height:10px"></tr>


<tr id = "trcgroup" <?php if($contact_type <> "vendor and party") { ?> style="display:none" <?php } ?>>
<td align="right"><strong></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;<strong>Customer Group</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="cgroup" style="width:200px" >
<?php 
 $cond = "";
 if($cnt2 >0){ 
  $cond = " AND vgroup = '$customer_group'";  
  } 
   else { ?>
 <option value="">-Select-</option> 
<?php }   
if($customer_group == "")  {
  $cond="";
 }    
		$q = "select * from ac_vgrmap where flag = 'C' $cond";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{ 
		?>
<option title="<?php echo $qr['vdesc']; ?>" value="<?php echo $qr['vgroup'].'@'.$qr['vca'].'@'.$qr['vppac']; ?>" <?php if($customer_group == $qr['vgroup']) { ?>  selected="selected" <?php } ?> ><?php echo $qr['vgroup']; ?></option>
<?php } ?>
</select></td>
</tr>

<tr style="height:10px"></tr>
<tr>
 <td><strong>Credit&nbsp;Term &nbsp; &nbsp; &nbsp; </strong></td>
                <td align="left">
					<select id="cterm" name="cterm">
					<option value="0">-Select-</option>
					<?php
					$query = "SELECT * FROM ims_creditterm ORDER BY value";
					$result = mysql_query($query,$conn) or die(mysql_error());
					while($rows = mysql_fetch_assoc($result))
					{
					 ?>
					 <option title="<?php echo $rows['description'] ?>" <?php if($rows['value']==$cterm) echo 'selected="selected"'; ?> value="<?php echo $rows['value']; ?>"><?php echo $rows['code'];?></option>
					 <?php
					}
					?>
					</select>
					</td>
					<td width="10px"></td>
					
					</tr>
<tr style="height:10px"></tr>
<tr>
<td colspan="2" align="right" style="vertical-align:middle;"><strong>Note</strong>&nbsp;&nbsp;&nbsp;</td>
<td colspan="3" align="left"><textarea rows="4" cols="35" name="note" ><?php echo $note; ?></textarea></td>
</tr> 
<tr><td><input type="hidden" id="id" name="id" value="<?php echo $id; ?>"></td></tr>
</table>
<br />

<table border="0">
<td>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_supplier';">

</form>
</center>
</td></tr>
</table>
</center>
<script language="JavaScript" type="text/javascript">
function loadfun(a)
{
 if(a=='vendor and party')
  document.getElementById('trcgroup').style.display="block";
 else 
  document.getElementById('trcgroup').style.display="none";
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
    alert( "Phone Number Should be atleast 5 digits." );
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
 
  else if ((form.vgroup.value == "") || (form.vgroup.value == "-Select-")) {
    alert( "Please select Supplier Group" );
    form.vgroup.focus();
    return false ;
  }
   else if (form.type.value == "vendor and party") {
	if ((form.cgroup.value == "") || (form.cgroup.value == "-Select-")) {
    alert( "Please select Customer Group" );
    form.cgroup.focus();
    return false ;
	}
  }
  
  var lfckv = document.getElementById("check").checked;
if(lfckv=='on')
{
	document.getElementById('currency').value='checked';
}

  return true ;
}



</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_m_addsupplier.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
