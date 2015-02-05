<?php include "config.php"; 
if($_GET['id'] <> '')
{
 $id = $_GET['id'];
 $saed = 1;
 $cond = "id = '$id'";
}
else
{
 $saed = 0;
 $cond = "(tally_name = '' or tally_name IS NULL)";
}
?>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="min-height:600px" id="complex_form" method="post" action="pp_savecontacts_mapping.php" >
	  <h1 id="title1">Software - Tally Contacts Mapping</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br/>
<?php if($saed == 0) { ?>
(<font style="color:red;font-weight:bold;padding-top:10px">The first 50 Names for which mapping is not done are only displayed</font> )
<?php } ?>

<br><br>
<input type="hidden" id="oldid" name="oldid" value="<?php echo $id; ?>" />
<input type="hidden" id="saed" name="saed" value="<?php echo $saed; ?>" />
<table id="tab2" align="center">
<tr>
 <td align="center"><strong>Software Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</strong></td>
 <td width="10px"></td>
  <td align="center"><strong>Tally Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</strong></td>
</tr>
<?php
$i = 0;
$query = "SELECT name,tally_name FROM contactdetails WHERE $cond ORDER BY name LIMIT 50";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ $i++;
?>
<tr height="10px"></tr>
<td><input type = "text" name="software[]" value="<?php echo $rows['name']; ?>" readonly size="50"/></td>
<td width="10px"></td>
<td><input type = "text" name="tally[]" value="<?php echo $rows['tally_name']; ?>" size="25" tabindex="<?php echo $i; ?>"/></td>
</tr>
<?php } ?>
</table>
<br><br>
<input type="submit" value="<?php if($saed == 0) echo "Save"; else echo "Update"; ?>" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_contacts_mapping'" />
</form>
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
