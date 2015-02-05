<!DOCTYPE html>
<html lang="en" style="background:none;">
<head>
	<meta charset="utf-8">
	<link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/common1.css" rel="stylesheet" type="text/css">
	<link href="css/form.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
	<link href="css/960.gs.fluid.css" rel="stylesheet" type="text/css">
	<link href="css/simple-lists.css" rel="stylesheet" type="text/css">
	<link href="css/block-lists.css" rel="stylesheet" type="text/css">
	<link href="css/planning.css" rel="stylesheet" type="text/css">
	<link href="css/table.css" rel="stylesheet" type="text/css">
	<link href="css/calendars.css" rel="stylesheet" type="text/css">
	<link href="css/wizard.css" rel="stylesheet" type="text/css">
	<link href="css/gallery.css" rel="stylesheet" type="text/css">


	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="icon" type="image/png" href="favicon-large.png">
	
	<script type="text/javascript" src="js/html5.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/old-browsers.js"></script>
	<script type="text/javascript" src="js/jquery.accessibleList.js"></script>
	<script type="text/javascript" src="js/searchField.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/standard.js"></script>
	<script type="text/javascript" src="js/jquery.tip.js"></script>
	<script type="text/javascript" src="js/jquery.hashchange.js"></script>
	<script type="text/javascript" src="js/jquery.contextMenu.js"></script>
	<script type="text/javascript" src="js/jquery.modal.js"></script>
	<script type="text/javascript" src="js/list.js"></script>


	<!--[if lte IE 8]><script type="text/javascript" src="js/standard.ie.js"></script><![endif]-->
	
	<script  type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script  type="text/javascript" src="js/jquery.datepick/jquery.datepick.min.js"></script>

</head>
<body style="background:none;">
<br/>
<br/>
<form style="background:none;" id="form1" name="form1" method="post" action="ac_savebankcashmasters.php"  onsubmit="return checkform(this);">
<input type="hidden" id="mode" name="mode" value="<?php echo $_GET['mode']; ?>" />

<table align="center" border="0" >

<tr>
<td align="right"><strong><?php echo $_GET['mode']; ?> Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="code" size="10" id="code" /></td>
<td width="10px"></td>
<td align="right"><strong><?php if($_GET['mode'] == "Bank") echo "Bank Name"; else echo "Cash Book Name"; ?></strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="name" size="25" id="name" /></td>
<td width="10px"></td>

<td align="right"><strong>Sector</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select id="sector" name="sector" style="width:120px">
<option value="">-Select-</option>
<?php
include "config.php";
 $q1 = "SELECT * FROM tbl_sector WHERE type1 != 'Warehouse' order by sector";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>
</td>



<td align="right"><strong>Coa</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select id="coa" name="coa" style="width:120px">
<option>Select</option>
<?php  $q = "select * from ac_coa where controltype = '$_GET[mode]' and flag= '0' order by code ASC";
	 $qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['code']; ?>" title="<?php echo $qr['description']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>


</tr>

<tr height="10px"><td></td></tr>
</table>

<?php if($_GET['mode'] == "Bank") { ?>
<table align="center">


<tr >
<td align="right"><strong>Bank&nbsp;A/C No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="acno" size="25" id="acno" /></td>
<td width="10px"></td>
<td align="right"><strong>MICR</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="micr" size="25" id="micr" /></td>

</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Email</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="email" size="25" id="email" /></td>
<td width="10px"></td>
<td align="right"><strong>Phone</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="phone" size="25" id="phone" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Fax</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="fax" size="25" id="fax" /></td>
<td width="10px"></td>
<td align="right"><strong>Contact Person</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="person" size="25" id="person" /></td>
</tr>

<tr height="10px"><td></td><td></td><td></td><td></td><td></td></tr>

<tr height="10px">
<td align="right"><strong>Address</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea id="address" name="address"></textarea></td></tr>
<tr height="10px"><td></td><td></td><td></td><td></td><td></td></tr>
</table>
<?php } ?>
<br/>
<br/>
<center>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="parent.location='dashboardsub.php?page=ac_bankcashmasters';">
</center>


<br /><br /><br />
</form>
</body>
<script type="text/javascript">
function checkform(form)
{
var numericExpression = /^[0-9].+$/;
if(document.getElementById('mode').value == "Cash")
var name = "Cash Book Name";
else
var name = "Bank Name";



   if (form.code.value == "") 
   {
   alert( "Please enter Code." );
   form.code.focus();
   return false ;
   }
   var code=form.code.value;
   code=code.toUpperCase();
   
  <?php
  
  $q = "select * from ac_bankcashcodes where mode = '$_GET[mode]'";
  $r=mysql_query($q,$conn);
  while($r1=mysql_fetch_array($r))
  {
  
  
  ?>
  if(code=="<?php echo $r1['code'];?>")
  {
  
  
	alert("Code already exists");
	form.code.value="";
	form.code.focus();
	return false;
  
  }
  
  <?php  } ?>
   
    if (form.coa.value == "") 
   {
   alert( "Please enter coa");
   form.coa.focus();
   return false ;
   }
   
   
   if (form.name.value == "") 
   {
   alert( "Please enter " + name);
   form.name.focus();
   return false ;
   }
    if (form.sector.value == "") 
   {
   alert( "Please select sector");
   form.sector.focus();
   return false ;
   }
   <?php if($_GET['mode']=="Bank"){?>
   if (form.address.value == "") 
   {
   alert( "Please Enter Address ");
   form.address.focus();
   return false ;
   }
   
   if (form.acno.value == "") 
   {
   alert( "Please Enter Bank Account No ");
   form.acno.focus();
   return false ;
   }
   
   <?php } ?>
  return true ;
}
</script>


<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>