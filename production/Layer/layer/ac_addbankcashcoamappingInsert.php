<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="en" style="background:none;">
<head>
	<title>Tulasi Technologies - BIMS</title>
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
<body style="background:none">
<center>
<br/>
<form id="form1" name="form1" method="post" action="ac_savebankcashcoamapping.php"  onsubmit="return checkform(this);">
<input type="hidden" id="mode" name="mode" value="<?php echo $_GET['mode']; ?>" />
<table align="center" border="0">

<tr>
<td width="150" align="right"><strong><?php echo $_GET['mode']; ?> Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><select id="code" name="code" style="width:100px">
<option>Select</option>
<?php  $q = "select * from ac_bankcashcodes where mode = '$_GET[mode]' and flag = '0' and client = '$client' order by code ASC";
  $qrs = mysql_query($q,$conn) or die(mysql_error()); while($qr = mysql_fetch_assoc($qrs)) { ?>
<option value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" align="right" title="Chart of Account Code"><strong>COA Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left">
<select id="coacode" name="coacode" style="width:100px">
<option>Select</option>
<?php  $q = "select * from ac_coa where controltype = '$_GET[mode]' and flag= '0'  and client = '$client' order by code ASC";
	 $qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?></td>
</select>
</td>
</tr>

<tr height="10px"><td></td></tr>

<?php if($_GET['mode'] == "Bank") 
{
?>
<tr>
<td width="150" align="right"><strong>Bank A/C No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left">
<input type="text" name="acno" size="25" id="acno" />
</td>
</tr>
<?php } ?>

<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="top.location='dashboard.php?page=bankmaster.php';">
</center>
</td>
</tr>

</table>
</center>
<br /><br /><br />
</form>
</body>
<script language="JavaScript" type="text/javascript">
function checkform ( form )
{
var numericExpression = /^[0-9].+$/;
if(document.getElementById('mode').value == "Cash")
var name = "Cash Book Name";
else
var name = "Bank Name";
   if (form.code.value == "") 
   {
   alert( "Please select Code." );
   form.code.focus();
   return false ;
   }
   if (form.coacode.value == "") 
   {
   alert( "Please select COA Code");
   form.coacode.focus();
   return false ;
   }
if(document.getElementById('mode').value == "Bank")
{
   if (form.acno.value == "") 
   {
   alert( "Please enter Bank A/C No");
   form.acno.focus();
   return false ;
   }
}   
  return true ;
}
</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_addbankcashmapping.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
