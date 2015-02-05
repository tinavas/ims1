<?php include "config.php"; ?>
<?php include "jquery.php"; 
$proc = "";
$id =$_GET['id'];
  $query1 = "SELECT `procedure` FROM hr_salary_procedure limit 1";
  $result1 = mysql_query($query1,$conn); 
  while($row = mysql_fetch_assoc($result1))
  {
	
	 $proc = $row['procedure'];
  }
		  

?>
<br />
<center>
<h1>Salary Procedure</h1>
<br/>
<br/>
<br/>
<form id="form1" name="form1" method="post" action="hr_savesalary_procedure.php"  onsubmit="return checkform(this);">
<table align="center">



<tr>
<td align="right"><strong>Procedure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" ><select style="Width:120px" name="proc" id="proc" >
  <option value="" >-Select-</option>
  <option value="Attendance" <?php if($proc == "Attendance") { ?> selected="selected" <?php }?>>Attendance</option>
  <option value="Monthly Attendance" <?php if($proc == "Monthly Attendance") { ?> selected="selected" <?php }?>>Monthly Attendance</option>
</select></td> 
</tr>



<tr height="10px"><td></td></tr>

<tr><td colspan="4" align="center"><strong><span id="spanid1"></span></strong></td></tr>

<tr>
<td colspan="4" align="center">
<br />
<center>
  <input name="submit" type="submit" id="save" value="<?php if($id > 0) { echo "Update"; } else { echo "Save"; }?>" />
  &nbsp;&nbsp;&nbsp;
  <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salprocedure';">
</center></td>
</tr>
</table>
</center>
<br /><br /><br />
</form>



<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_m_addtaxmaster.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
