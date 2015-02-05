<?php 
include "mainconfig.php";
$query = "SELECT currency,millionformate FROM tbl_users WHERE dbase = '".$_SESSION['db']."' LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$rows['millionformate'];
?>

<center>
<br />
<h1 align="center">CURRENCY</h1>

<br /><br />
<?php
if($_GET['status'] == 1)
{ ?>
<font style="color:#FF0000">Currency has been updated successfully</font><br />
<br />
<br />
<?php
}
?>
<form id="form1" name="form1" method="post" onsubmit="return checkform(this)" action="home_savecurrency.php" >
<table border="0"  align="center">
<tr>   
<td><strong>Currency</strong>&nbsp;&nbsp;</td>
<td>
<input type="text"  name="currency" id="currency" size="10" value="<?php echo $rows['currency']; ?>"  /></td>

</tr>
 <tr style="height:10px"></tr>    
<tr>

<td><strong>Million Format</strong>&nbsp;&nbsp;</td>
<td><input type="checkbox" value="1" <?php if($rows['millionformate'] == 1) { ?> checked="checked" <?php } ?> id="millionformat" name="millionformat" /></td>
</tr>

</tr>
</table>
<br/>

<br/>
<table align="center">

<tr>
<td colspan="5" align="center">
<center>
<input type="submit" value="Update" id="Save"  name="Save"/>&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=';">

</center>
</td>
</tr>
</table>
</form>
<script type="text/javascript">


function checkform(a)
{
 if(document.getElementById('currency').value == "")
 {
  alert("Please enter Currency");
  document.getElementById('currency').focus();
  return false;
 }
 return true;
}
</script>