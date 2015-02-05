<?php include "jquery.php";
      include "getemployee.php";
      include "config.php";
	  $id = $_GET['id'];
	  $query = "select * from home_logo where id = '$id'";
	  $result = mysql_query($query,$conn);
	  $res = mysql_fetch_assoc($result); 
?>

	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<center>
<br />
<h1>Report Header(Logo &amp; Address)</h1>
<br/>
<br/><br />
<form id="form1" name="form1" method="post" enctype="multipart/form-data" action="home_savelogo.php">
<table align="center">

<tr>
<td style="vertical-align:middle" align="right"><strong>Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="6" cols="30" name="address" class="ckeditor"><?php echo $res['address']; ?></textarea></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Logo</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="hidden" name="MAX_FILE_SIZE" value="100000000000" /><input name="uploadedfile" type="file" width="15px" size="15" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=home_logo';">
</center>
</td>
</tr>
</table>
</center>
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
<br /><br /><br />
</form>
<script type="text/javascript">
function script1() {
window.open('AdminHelp/help_m_addlogo.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

