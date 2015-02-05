<?php 
include "mainconfig.php";
$query = "SELECT country FROM tbl_users WHERE dbase = '".$_SESSION['db']."' LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
?>

<center>
<br />
<h1 align="center">COUNTRY</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br /><br />
<?php
if($_GET['status'] == 1)
{ ?>
<font style="color:#FF0000">To update your country, Please Logout and Login</font><br />
<br />
<br />
<?php
}
?>
<form id="form1" name="form1" method="post" action="home_savecountry.php" >
<table border="0"  align="center">
<tr>   
<td><strong>Select your Country<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;</td>
<td>
	<select id="country" name="country">
	<?php
	 $query1 = "select country from countries order by country";
	 $result1 = mysql_query($query1,$conn) or die(mysql_error());
	 while($rows1 = mysql_fetch_assoc($result1))
	 { ?>
	 <option value="<?php echo $rows1['country']; ?>" <?php if($rows['country'] == $rows1['country']) { ?> selected="selected"<?php } ?>><?php echo $rows1['country']; ?></option>
	 <?php } ?>
	 </select>
	 </td>
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
function script1() {
window.open('AdminHelp/help_a_country.html','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
