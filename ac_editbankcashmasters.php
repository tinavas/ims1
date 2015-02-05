<?php include "config.php"; ?>
<?php include "config.php";       
      include "jquery.php"; 
      include "getemployee.php";
	  
	  $query = "SELECT * FROm ac_bankcashcodes where id = '$_GET[id]'";
	   $result = mysql_query($query,$conn);
       while($row1 = mysql_fetch_assoc($result)) { 
	   $mode = $row1['mode'];
	   }
	    $query = "SELECT * FROm ac_bankcashcodes where id = '$_GET[id]'"; $result = mysql_query($query,$conn);
       while($row1 = mysql_fetch_assoc($result)) {
	   
	   $code=$row1['code'];
	   }
	   
	   $query = "SELECT * FROm `ac_bankmasters` where code = '$code'"; $result = mysql_query($query,$conn);
       while($row1 = mysql_fetch_assoc($result)) {
	   
	   $coacode=$row1['coacode'];
	   $acno=$row1['acno'];
	   }
	   
	   
?>
<center>
<br />
<h1>Bank/Cash Codes( Edit )</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>
<br/>
<form id="form1" name="form1" method="post" action="ac_updatebankcashmasters.php"  onsubmit="return checkform(this);">
<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" id="flag" name="flag" value="<?php echo $_GET['flag']; ?>" />
<table align="center" border="0">
<?php  $query = "SELECT * FROm ac_bankcashcodes where id = '$_GET[id]'"; $result = mysql_query($query,$conn);
       while($row1 = mysql_fetch_assoc($result)) {?>

<tr>
<td align="right"><strong><?php echo $row1['mode']; ?> Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="code" size="10" id="code" value="<?php echo $row1['code']; ?>" <?php if($_GET['flag'] == "1") { ?> readonly <?php } ?> /></td>
<td width="10px"></td>
<td  align="right"><strong><?php if($row1['mode'] == "Bank") echo "Bank Name"; else echo "Cash Book Name"; ?></strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="name" size="25" id="name" value="<?php echo $row1['name']; ?>"/></td>
<td width="10px"></td>
<?php
session_start();

$sector = $row1['sector'];
?>

 <td align="right"><strong>Sector </strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>
 <td align="left">&nbsp;&nbsp;
   <select name="sector" id="sector" style="width:150px;">
           <option>-Select-</option>
	<?php
              include "config.php"; 
              $query = "SELECT sector FROM tbl_sector WHERE type1 <> 'Warehouse' AND client = '$client' ORDER BY sector ASC ";
              $result = mysql_query($query,$conn); 
              while($row = mysql_fetch_assoc($result))
              {
			   if($sector == $row['sector'])
			    $selected = "selected = 'selected'";
				else
				 $selected = "";			  			  
           ?>
           <option value="<?php echo $row['sector']; ?>" <?php echo $selected; ?>><?php echo $row['sector']; ?></option>
           <?php } ?>
         </select>
 </td>


<td><strong>Coacode</strong></td>
<td>
<select id="coa" name="coa" style="width:120px">
<option value="">Select</option>
<option value="<?php echo $coacode;?>" selected="selected"><?php echo $coacode;?></option>

</select>
</td>

</tr>


<tr height="10px"><td></td></tr>

<?php if($row1['mode'] == "Bank") { ?>
<tr>
<td align="right"><strong>Bank&nbsp;A/C No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="acno" size="25" id="acno" value="<?php echo $acno;?>" /></td>
<td width="10px"></td>

<td  align="right"><strong>MICR</strong></td>
<td  align="left"><input type="text" name="micr" size="25" id="micr" value="<?php echo $row1['micr']; ?>"/></td>

</tr>

<tr height="10px"><td></td></tr>

<tr>
<td  align="right"><strong>Email</strong></td>
<td  align="left"><input type="text" name="email" size="25" id="email" value="<?php echo $row1['email']; ?>"/></td>
<td  width="10px"></td>
<td  align="right"><strong>Phone</strong></td>
<td  align="left"><input type="text" name="phone" size="25" id="phone" value="<?php echo $row1['phone']; ?>" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Fax</strong></td>
<td align="left"><input type="text" name="fax" size="25" id="fax" value="<?php echo $row1['fax']; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Contact Person</strong></td>
<td align="left"><input type="text" name="person" size="25" id="person" value="<?php echo $row1['person']; ?>"/></td>
</tr>

<tr height="10px"><td></td></tr>
<tr>


<td align="right"><strong>Address<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td  align="left"><textarea id="address" name="address"><?php echo $row1['address']; ?></textarea></td>
</tr>
<?php } ?>
<?php } ?>

<tr>
<td colspan="8" align="center">
<br />
<center>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_bankcashmasters';">
</center>
</td>
</tr>

</table>
</center>
<br /><br /><br />
</form>
<script type="text/javascript">
function script1() {
window.open('GLHelp/help_m_editbankcashmasters.php','SMOC','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<script language="JavaScript" type="text/javascript">
function checkform ( form )
{
   var numericExpression = /^[0-9].+$/;
   	
if(document.getElementById('mode').value == "Cash")
   {
	if (form.code.value == "") 
   {
   alert( "Please enter Code." );
   form.code.focus();
   return false ;
   }
   if (form.name.value == "") 
   {
   alert( "Please enter Cash Book Name");
   form.name.focus();
   return false ;
   }
    if (form.sector.value == "") 
   {
   alert( "Please select sector");
   form.sector.focus();
   return false ;
   }
   
   
    if (form.coa.value == "") 
   {
   alert( "Please enter coa");
   form.coa.focus();
   return false ;
   }
   
   }
   else
   {
   
 
   
   if (form.code.value == "") 
   {
   alert( "Please enter Code." );
   form.bankcode.focus();
   return false ;
   }
   if (form.name.value == "") 
   {
   alert( "Please enter bank name");
   form.bankname.focus();
   return false ;
   }
   
   if (form.coa.value == "") 
   {
   alert( "Please enter coa");
   form.coa.focus();
   return false ;
   }
    
   if (form.acno.value == "") 
   {
   alert( "Please Enter Bank Account No ");
   form.acno.focus();
   return false ;
   }
    if (form.address.value == "") 
   {
   alert( "Please Enter Address ");
   form.sector.focus();
   return false ;
   }   
    
   }
  return true ;
}
</script>
</html>
