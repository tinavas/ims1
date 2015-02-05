<?php include "config.php"; ?>

<center>
<br />
<h1>Item Masters</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/><br />
<form id="form1" name="form1" method="post" action="ims_saveitemcodes.php"  onsubmit="return checkform(this);">
<table align="center" >
<tr> 
<td width="200" align="right"><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><input type="text" id="name" name="code" size="7" onkeyup="validatecode(this.id,this.value);" /></td>
<td width="200" align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><input type="text" id="description" name="description" size="25" onkeyup="validatecode(this.id,this.value);"/></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><select style="Width:120px" name="cat" id="cat">
<option value="">-Select-</option>
<?php $q = "select * from ims_itemtypes WHERE client = '$client' order by type ASC";	$qrs = mysql_query($q,$conn);
	while($qr = mysql_fetch_assoc($qrs)) { ?>
      <option value="<?php echo $qr['type']; ?>"<?php if($qr['type'] == 'Small Portions') { echo "selected='selected'"; } ?>><?php echo $qr['type']; ?></option>
<?php } ?>
</select>
<a href="dashboardsub.php?page=ims_addcategory"><img src="images/icons/fugue/plus.png" style="vertical-align:middle;" title="Add New Category" border="0px"  /></a>
</td> 

<td width="200" align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><select style="Width:120px" name="warehouse" id="warehouse">
<option value="">-Select-</option>
<?php $q = "select * from tbl_sector WHERE (type1 = 'Warehouse' or type1 = 'Chicken Center') AND client = '$client' order by sector ASC";	$qrs = mysql_query($q,$conn);
	while($qr = mysql_fetch_assoc($qrs)) { ?>
      <option value="<?php echo $qr['sector']; ?>"<?php if($qr['sector'] == 'Godown') { echo "selected='selected'"; } ?>><?php echo $qr['sector']; ?></option>
<?php } ?>
</select>
</td> 

</tr>
<tr height="10px"><td></td></tr>
<tr>
<td width="200" align="right"><strong>Valuation Method</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><select style="Width:120px" name="cm" id="cm" onchange="stdcostenable();">
<option value="">-Select-</option>
<option title="First In First Out" value="Fifo">FIFO</option>
<option title="Last In First Out" value="Lifo">LIFO</option>
<option value="Weighted Average">Weighted Average</option>
<option value="Standard Costing" selected="selected">Standard Costing</option>
</select>
</td> 
<td width="200" align="right" id="stdcostrow"><strong>Standard Cost/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" id="stdcostrow1">
<input type="text" id="stdcost" name="stdcost" value="10" />
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Storage Units Of Measure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><select style="Width:180px" name="sunits" id="sunits" onchange="loadcvalues();">
                      <option value="">-Select-</option>
<?php include "config.php"; $q2="select distinct(sunits) from ims_itemunits WHERE client = '$client' order by sunits ASC"; $r2 = mysql_query($q2,$conn);
     while($nt2=mysql_fetch_assoc($r2))
     { ?>
  <option value="<?php echo $nt2['sunits']; ?>" <?php if($nt2['sunits'] == 'Kgs') { echo "selected='selected'"; } ?>><?php echo $nt2['sunits']; ?></option>
<?php } ?>			</select>
<a href="dashboard.php?page=additemunits" onclick=""><img src="images/icons/fugue/plus.png" style="vertical-align:middle;" title="Add New Unit" border="0px"  /></a>
</td>
<td width="240" align="right"><strong>Consumption Units Of Measure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left">
<select style="Width:180px" name="cunits" id="cunits" >
<option value="">-Select-</option>
<option value="Kgs" selected="selected">Kgs</option>
</select>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Usage</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select style="Width:180px" name="usage" id="usage" onChange="getvendors();coas(this.value);" >
<option value="">-Select-</option>
<option value="Produced">Produced</option>
<option value="Sale" selected="selected">Sale</option>
<option value="Rejected">Rejected</option>
<option value="Produced or Sale">Produced or Sale</option>
<option value="Rejected or Sale">Rejected or Sale</option>
<option value="Produced or Rejected">Produced or Rejected</option>
<option value="Produced or Sale or Rejected">Produced or Sale or Rejected</option>
</select>
</td>

<td width="200" align="right"><strong>Source</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select style="Width:180px" name="source" id="source" onchange="getvendors();">
<option value="">-Select-</option>
<option value="Produced">Produced</option>
<option value="Purchased">Purchased</option>
<option value="Produced or Purchased" selected="selected">Produced or Purchased</option>
</select>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select style="Width:180px" name="type" id="type" >
<option value="">-Select-</option>
<option value="Consumed">Consumed</option>
<option value="Finished Goods" selected="selected">Finished Goods</option>
<option value="Packing Material">Packing Material</option>
<option value="Raw Material">Raw Material</option>
<option value="Others">Others</option>
<option value="Wastage">Wastage</option>
</select>
</td>

<td width="200" align="right"><strong>Item A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left">
<select style="Width:180px" name="iac" id="iac" >
<option value="">-Select-</option>
<?php 
		$q = "select code,description from ac_coa where client = '$client' AND type = 'Asset' and (controltype = '' or controltype IS NULL) order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" <?php if($qr['code'] == 'IT121') { echo "selected='selected'"; } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Lot/Serial Control</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select style="Width:180px" name="lscontrol" id="lscontrol" onchange="lotserial(this.value);">
<option value="None">None</option>
<option value="Lot">Lot</option>
<option value="Serial">Serial</option>
<option value="Lot and Serial">Lot and Serial</option>
</select>
</td>

<td width="200" align="right"><strong>Price Variance A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left">
<select style="Width:180px" name="pvac" id="pvac" >
<option value="">-Select-</option>
<?php 
		$q = "select code,description from ac_coa where (type = 'Expense' or type = 'Revenue') and (controltype = '' or controltype IS NULL) and client = '$client' order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" <?php if($qr['code'] == 'PV121') { echo "selected='selected'"; } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="am1td" style="visibility:hidden"><strong>Select</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" >
<select id="am1" name="am1" onchange="automanual1(this.value);" style="visibility:hidden">
<option value="">Select</option>
<option value="Auto">Auto</option>
<option value="Manual">Manual</option>
</select>
</td>

<td width="200" align="right" id="wpactd" style="visibility:hidden"><strong>W/P A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select style="Width:180px;visibility:hidden" name="wpac" id="wpac">
<option value="">-Select-</option>
<?php 
		$q = "select code,description from ac_coa where client = '$client' AND type = 'Asset' and (controltype = '' or controltype IS NULL) order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" <?php if($qr['code'] == 'WP121') { echo "selected='selected'"; } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="digits1td" style="visibility:hidden"><strong>Lot No. Limit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<input type="text" id="digits1" name="digits1" value="0" size="2" style="visibility:hidden"/>
</td>

<td width="200" align="right" id="cogsactd"><strong>COGS A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select name="cogsac" id="cogsac" >
<option value="">-Select-</option>
<?php 
		$q = "select code,description from ac_coa where client = '$client' AND type = 'Expense' and (controltype = '' or controltype IS NULL) order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" <?php if($qr['code'] == 'CG121') { echo "selected='selected'"; } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="startvalue1td" style="visibility:hidden"><strong>Lot No. Starting Value</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<input type="text" id="startvalue1" name="startvalue1" value="0" size="5" />
</td>

<td width="200" align="right" id="sactd" style="visibility:hidden"><strong>Sales A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select name="sac" id="sac" >
<option value="">-Select-</option>
<?php 
		$q = "select code,description from ac_coa where client = '$client' AND (type = 'Expense' or type = 'Revenue') and (controltype = '' or controltype IS NULL) order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" <?php if($qr['code'] == 'SA121') { echo "selected='selected'"; } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="digits2td" style="visibility:hidden"><strong>Serial No. Limit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" >
<input type="text" id="digits2" name="digits2" value="0" size="2"/>
</td>

<td width="200" align="right" id="sractd" style="visibility:hidden"><strong>Sales Return</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left">
<select name="srac" id="srac" >
<option value="">-Select-</option>
<?php 
		$q = "select code,description from ac_coa where client = '$client' AND (type = 'Expense' or type = 'Revenue') and (controltype = '' or controltype IS NULL) order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" <?php if($qr['code'] == 'SR121') { echo "selected='selected'"; } ?>><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right" id="startvalue2td" style="visibility:hidden"><strong>Serial No. Starting Value</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" id="amtd2" >
<input type="text" id="startvalue2" name="startvalue2" value="0" size="20" style="visibility:hidden"/>
</td>

<td width="200" align="right" >&nbsp;</td>
<td width="200" align="left">&nbsp;

</td>

</tr>

<tr height="10px"><td></td></tr>
<tr>
<td colspan="2" align="right" style="vertical-align:middle"><strong><span id="vendor1"></span> List</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select  name="vendor[]" id="vendor" multiple="multiple" style="width:200px;height:80px">
<option value="" disabled="disabled">-Select-</option>
</select>
</td>
</tr>

<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_itemcodes';">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>

<script language="JavaScript" type="text/javascript">

function validatecode(a,b)
{
 var expr=/^[A-Za-z0-9 ]*$/;
 if(! b.match(expr))
 {
  alert("Special Characters are not allowed");
  document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function getvendors()
{
 myselect1 = document.getElementById("vendor");
 removeAllOptions(myselect1);
 		theOption=document.createElement("OPTION");
		theText=document.createTextNode("-Select-");
		theOption.appendChild(theText);
		theOption.value = "";
            theOption.disabled = "true";
		myselect1.appendChild(theOption);

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("All");
		theOption.appendChild(theText);
		theOption.value = "All";
		myselect1.appendChild(theOption);
 if((document.getElementById("usage").value == "Sale") || (document.getElementById("usage").value == "Produced or Sale") || (document.getElementById("usage").value == "Produced or Sale or Rejected"))
 {
  document.getElementById("vendor1").innerHTML = "Partys";
  <?php
           include "config.php"; 
           $query = "SELECT * FROM contactdetails WHERE client = '$client' AND (type='party' or type = 'vendor and party') ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['name']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['name']; ?>";
		theOption.title = "<?php echo $row1['name']; ?>";
		myselect1.appendChild(theOption);
  <?php } ?>

  if((document.getElementById("usage").value == "Sale") && (document.getElementById("source").value == "Purchased")
     ||(document.getElementById("usage").value == "Sale") && (document.getElementById("source").value == "Produced or Purchased")
     ||(document.getElementById("usage").value == "Produced or Sale") && (document.getElementById("source").value == "Purchased")
     ||(document.getElementById("usage").value == "Produced or Sale") && (document.getElementById("source").value == "Produced or Purchased")
     ||(document.getElementById("usage").value == "Produced or Sale or Rejected") && (document.getElementById("source").value == "Purchased")
     ||(document.getElementById("usage").value == "Produced or Sale or Rejected") && (document.getElementById("source").value == "Produced or Purchased"))
  {
   document.getElementById("vendor1").innerHTML = "";
    myselect1 = document.getElementById("vendor");
   removeAllOptions(myselect1);
 		theOption=document.createElement("OPTION");
		theText=document.createTextNode("-Select-");
		theOption.appendChild(theText);
		theOption.value = "";
            theOption.disabled = "true";
		myselect1.appendChild(theOption);

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("All");
		theOption.appendChild(theText);
		theOption.value = "All";
		myselect1.appendChild(theOption);
   <?php
           include "config.php"; 
           $query = "SELECT * FROM contactdetails WHERE client = '$client' AND (type='party' or type = 'vendor' or type = 'vendor and party') ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['name']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['name']; ?>";
		theOption.title = "<?php echo $row1['name']; ?>";
		myselect1.appendChild(theOption);
  <?php } ?>

  }
 }
 else if((document.getElementById("source").value == "Purchased") || (document.getElementById("source").value == "Produced or Purchased"))
 {
  document.getElementById("vendor1").innerHTML = "Vendors";
  <?php
           include "config.php"; 
           $query = "SELECT * FROM contactdetails WHERE client = '$client' AND (type = 'vendor' or type = 'vendor and party') ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['name']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['name']; ?>";
		theOption.title = "<?php echo $row1['name']; ?>";
		myselect1.appendChild(theOption);
  <?php } ?>

  if((document.getElementById("usage").value == "Sale") && (document.getElementById("source").value == "Purchased")
     ||(document.getElementById("usage").value == "Sale") && (document.getElementById("source").value == "Produced or Purchased")
	 ||(document.getElementById("usage").value == "Produced or Sale") && (document.getElementById("source").value == "Purchased")
	 ||(document.getElementById("usage").value == "Produced or Sale") && (document.getElementById("source").value == "Produced or Purchased")
       ||(document.getElementById("usage").value == "Produced or Sale or Rejected") && (document.getElementById("source").value == "Purchased")
       ||(document.getElementById("usage").value == "Produced or Sale or Rejected") && (document.getElementById("source").value == "Produced or Purchased"))
  {
   document.getElementById("vendor1").innerHTML = "";
    myselect1 = document.getElementById("vendor");
   removeAllOptions(myselect1);
 		theOption=document.createElement("OPTION");
		theText=document.createTextNode("-Select-");
		theOption.appendChild(theText);
		theOption.value = "";
            theOption.disabled = "true";
		myselect1.appendChild(theOption);

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("All");
		theOption.appendChild(theText);
		theOption.value = "All";
		myselect1.appendChild(theOption);
   <?php
           include "config.php"; 
           $query = "SELECT * FROM contactdetails WHERE client='$client' AND (type='party' or type = 'vendor' or type = 'vendor and party') ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['name']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['name']; ?>";
		theOption.title = "<?php echo $row1['name']; ?>";
		myselect1.appendChild(theOption);
  <?php } ?>
  }
 }
else
 {
   document.getElementById("vendor1").innerHTML = "";
   myselect1 = document.getElementById("vendor");
   removeAllOptions(myselect1);
 		theOption=document.createElement("OPTION");
		theText=document.createTextNode("-Select-");
		theOption.appendChild(theText);
		theOption.value = "";
            theOption.disabled = "true";
		myselect1.appendChild(theOption);
 }

}

function fooforunits()
{
if (x=prompt("Unit","Please Enter Unit"))
 location.href="additemunits.php?input="+escape(x)
}

function foofortype()
{
if (x=prompt("Type","Please Enter Type"))
 location.href="additemtypes.php?input="+escape(x)
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}

function checkform ( form )
{
var noalpha = /^[a-zA-Z.0-9]*$/;
var noalpha1 = /^[a-zA-Z.0-9.\s]*$/;

if (form.code.value == "") 
   {
    alert( "Please enter Code." );
    form.code.focus();
    return false ;
   }
else if ( (!(form.code.value.match(noalpha)))) 
 {
    alert( "Code Number cannot have special charaters." );
    form.code.focus();
    return false ;
 }
else if (form.code.value.length < 5 ) {
    alert( "Code Number Should be atleast 5 characters." );
    form.code.focus();
    return false ;
  }

if (form.description.value == "") 
   {
    alert( "Please enter Description." );
    form.description.focus();
    return false ;
   }
else if ((!(form.description.value.match(noalpha1)))) 
  {
    alert( "Description cannot have special charaters." );
    form.description.focus();
    return false ;
  }
else if (form.description.value.length > 45 ) {
    alert( "Description should not have more than 45 characters" );
    form.code.focus();
    return false ;
  }

if (form.cat.value == "") 
   {
    alert( "Please select a Category." );
    form.cat.focus();
    return false ;
   }
if (form.warehouse.value == "") 
   {
    alert( "Please select a Warehouse." );
    form.warehouse.focus();
    return false ;
   }
   
if (form.cm.value == "") 
   {
    alert( "Please select a Valuation Methos." );
    form.cm.focus();
    return false ;
   }

if (form.sunits.value == "") {
    alert( "Please select Storage Units." );
    form.sunits.focus();
    return false ;
  }

if (form.cunits.value == "") {
    alert( "Please select Consumption Units." );
    form.cunits.focus();
    return false ;
  }

if (form.usage.value == "")
  {
  	alert( "Please select Usage.");
	form.usage.focus();
	return false;
  }


if (form.source.value == "")
  {
  	alert( "Please select Source.");
	form.source.focus();
	return false;
  }

/*if(form.source.value == "Produced")
  {
  	if(form.stdcost.value == "")
	{
		alert( "Please enter Standard Cost." );
		form.stdcost.focus();
		return false;
	}
  }*/

if (form.type.value == "")
  {
  	alert( "Please select Type.");
	form.type.focus();
	return false;
  }

if (form.iac.value == "")
  {
  	alert( "Please select Item A/C.");
	form.iac.focus();
	return false;
  }

if (form.pvac.value == "")
  {
  	alert( "Please select Price Variance A/C.");
	form.pvac.focus();
	return false;
  }

if(form.usage.value == "Sale" || form.usage.value == "Produced or Sale")
{
	if (form.cogsac.value == "")
	{
  		alert( "Please select COGS A/C.");
		form.cogsac.focus();
		return false;
  	}
	if (form.sac.value == "")
	{
  		alert( "Please select Sales A/C.");
		form.sac.focus();
		return false;
  	}
	if (form.srac.value == "")
	{
  		alert( "Please select Sales Return");
		form.srac.focus();
		return false;
  	}
}
else if(form.usage.value == "Produced")
{
	if (form.wpac.value == "")
	{
  		alert( "Please select W/P A/C");
		form.wpac.focus();
		return false;
  	}
}

if(form.lscontrol.value == "Lot")
{

	if(form.am1.value == "Auto")
	{
		if(form.digits1.value == "0" || form.digits1.value == "")
		{
			alert("Please enter digits limit");
			form.digits1.focus();
			return false;
		}
		else if(parseFloat(form.digits1.value) > 5)
		{
			alert("Digits limit should be less than or equal to 5");
			form.digits1.focus();
			return false;
		}
		
		if(form.startvalue1.value == "")
		{
			alert("Please enter Starting value");
			form.startvalue1.focus();
			return false;
		}
		else if(form.startvalue1.value.length != parseFloat(form.digits1.value))
		{
			alert("No. of digits in the starting value should be less than or equal to 5");
			form.startvalue1.focus();
			return false;
		}
	}
}
else if(form.lscontrol.value == "Serial")
{

	if(form.am1.value == "Auto")
	{
		if(form.digits2.value == "0" || form.digits2.value == "")
		{
			alert("Please enter digits limit");
			form.digits2.focus();
			return false;
		}
		else if(parseFloat(form.digits2.value) < 10 || parseFloat(form.digits2.value) > 15)
		{
			alert("Digits limit should be in between 10 and 15");
			form.digits2.focus();
			return false;
		}
		
		if(form.startvalue2.value == "")
		{
			alert("Please enter Starting value");
			form.startvalue2.focus();
			return false;
		}
		else if(form.startvalue2.value.length != parseFloat(form.digits2.value))
		{
			alert("No. of digits in the starting value should be in between 10 and 15");
			form.startvalue2.focus();
			return false;
		}
	}
}

else if(form.lscontrol.value == "Lot and Serial")
{
	if(form.am1.value == "Auto")
	{
		if(form.digits1.value == "0" || form.digits1.value == "")
		{
			alert("Please enter digits limit");
			form.digits1.focus();
			return false;
		}
		else if(parseFloat(form.digits1.value) > 5)
		{
			alert("Digits limit should be less than or equal to 5");
			form.digits1.focus();
			return false;
		}
		
		if(form.startvalue1.value == "")
		{
			alert("Please enter Starting value");
			form.startvalue1.focus();
			return false;
		}
		else if(form.startvalue1.value.length != parseFloat(form.digits1.value))
		{
			alert("No. of digits in the starting value should be less than or equal to 5");
			form.startvalue1.focus();
			return false;
		}
		
		if(form.digits2.value == "0" || form.digits2.value == "")
		{
			alert("Please enter digits limit");
			form.digits2.focus();
			return false;
		}
		else if(parseFloat(form.digits2.value) < 10 || parseFloat(form.digits2.value) > 15)
		{
			alert("Digits limit should be in between 10 and 15");
			form.digits2.focus();
			return false;
		}
		
		if(form.startvalue2.value == "")
		{
			alert("Please enter Starting value");
			form.startvalue2.focus();
			return false;
		}
		else if(form.startvalue2.value.length != parseFloat(form.digits2.value))
		{
			alert("No. of digits in the starting value should be in between 10 and 15");
			form.startvalue2.focus();
			return false;
		}

	}
}

/*
var j = 0;
for(i = 0;i< form.vendor.options.length;i++)
 	if(form.vendor.options[i].selected)
	j++;

if(j == 0)
{
	alert("Please select one or more in the List");
	form.vendor.focus();
	return false;
}
  else 
  {
 	for(var i = 0;i< form.vendors.options.length;i++)
 	if(form.vendors.options[i].selected)
 		if(form.vendors.options[i].value == "")
		{
		alert("Please select vendors correctly");
		return false;
		}
  }
 	document.getElementById('vendor1').value = "";
 	for(i = 0;i< form.vendors.options.length;i++)
 	if(form.vendors.options[i].selected)
 	document.getElementById('vendor1').value = document.getElementById('vendor1').value + form.vendors.options[i].value + ",";*/
	
    return true;
}

function loadcvalues()
{
	var opt,textnode,cunits;
	removeAllOptions(document.getElementById('cunits'));
	cunits = document.getElementById('cunits');
	
	opt = document.createElement('option');
	textnode = document.createTextNode("-Select-");
	opt.value = "";
	opt.appendChild(textnode);
	cunits.appendChild(opt);

	<?php 	include "config.php";
			$qrs = mysql_query("select distinct(sunits) from ims_itemunits WHERE client = '$client' order by sunits ASC") or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(document.getElementById('sunits').value == '$qr[sunits]') { ";
			
			$q1rs = mysql_query("select distinct(cunits) from ims_itemunits where client = '$client' AND sunits = '$qr[sunits]' order by cunits ASC") or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
			opt = document.createElement('option');
			textnode = document.createTextNode("<?php echo $q1r['cunits']; ?>");
			opt.value = "<?php echo $q1r['cunits']; ?>";
			opt.appendChild(textnode);
			cunits.appendChild(opt);
			<?php } echo "}"; } ?>
}

function stdcostenable()
{
	if((document.getElementById('cm').value == "Standard Costing"))
	{
	document.getElementById('stdcostrow').style.visibility = "visible";
	document.getElementById('stdcostrow1').style.visibility = "visible";
	}
	else
	{
	document.getElementById('stdcost').value = "";
	document.getElementById('stdcostrow').style.visibility = "hidden";
	document.getElementById('stdcostrow1').style.visibility = "hidden";
	}
}

function lotserial(value)
{
	document.getElementById('digits1td').style.visibility = "hidden";
	document.getElementById('digits2td').style.visibility = "hidden";
	document.getElementById('startvalue1td').style.visibility = "hidden";
	document.getElementById('startvalue2td').style.visibility = "hidden";
	document.getElementById('digits1').style.visibility = "hidden";
	document.getElementById('digits2').style.visibility = "hidden";
	document.getElementById('startvalue1').style.visibility = "hidden";
	document.getElementById('startvalue2').style.visibility = "hidden";

document.getElementById('am1td').style.visibility = "hidden";
document.getElementById('am1').style.visibility = "hidden";
document.getElementById('am1').options[0].selected = true;

if(value != "None")
{
document.getElementById('am1td').style.visibility = "visible";
document.getElementById('am1').style.visibility = "visible";
}

}

function automanual1(value1)
{
	document.getElementById('digits1td').style.visibility = "hidden";
	document.getElementById('digits2td').style.visibility = "hidden";
	document.getElementById('startvalue1td').style.visibility = "hidden";
	document.getElementById('startvalue2td').style.visibility = "hidden";
	document.getElementById('digits1').style.visibility = "hidden";
	document.getElementById('digits2').style.visibility = "hidden";
	document.getElementById('startvalue1').style.visibility = "hidden";
	document.getElementById('startvalue2').style.visibility = "hidden";
	var value = document.getElementById('lscontrol').value;
	
	
if(value1 == "Manual")
{
	if(value == "Lot")
	{
		document.getElementById('digits1td').style.visibility = "visible";
		document.getElementById('digits1').style.visibility = "visible";
		document.getElementById('startvalue1td').style.visibility = "visible";
		document.getElementById('startvalue1').style.visibility = "visible";
	}
	else if(value == "Serial")
	{
		document.getElementById('digits2td').style.visibility = "visible";
		document.getElementById('digits2').style.visibility = "visible";
		document.getElementById('startvalue2td').style.visibility = "visible";
		document.getElementById('startvalue2').style.visibility = "visible";
	}
	else if( value == "Lot and Serial" )
	{
		document.getElementById('digits1td').style.visibility = "visible";
		document.getElementById('digits1').style.visibility = "visible";
		document.getElementById('startvalue1td').style.visibility = "visible";
		document.getElementById('startvalue1').style.visibility = "visible";
		document.getElementById('digits2td').style.visibility = "visible";
		document.getElementById('digits2').style.visibility = "visible";
		document.getElementById('startvalue2td').style.visibility = "visible";
		document.getElementById('startvalue2').style.visibility = "visible";
	}

}
}

function coas(value)
{

	document.getElementById('cogsactd').style.visibility = "hidden";
	document.getElementById('sactd').style.visibility = "hidden";
	document.getElementById('sractd').style.visibility = "hidden";
	document.getElementById('wpactd').style.visibility = "hidden";
	document.getElementById('cogsac').style.visibility = "hidden";
	document.getElementById('sac').style.visibility = "hidden";
	document.getElementById('srac').style.visibility = "hidden";
	document.getElementById('wpac').style.visibility = "hidden";

	if(value == "Sale" || value == "Produced or Sale")
	{
		document.getElementById('cogsactd').style.visibility = "visible";
		document.getElementById('sactd').style.visibility = "visible";
		document.getElementById('sractd').style.visibility = "visible";
		document.getElementById('cogsac').style.visibility = "visible";
		document.getElementById('sac').style.visibility = "visible";
		document.getElementById('srac').style.visibility = "visible";

	}
	else if(value == "Produced")
	{
		document.getElementById('wpactd').style.visibility = "visible";
		document.getElementById('wpac').style.visibility = "visible";
	}

}
</script>
<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_m_additemmaster.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=YES,resizable=yes');
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