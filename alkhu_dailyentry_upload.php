<html>
<title>B.I.M.S</title>
<body bgcolor="#ECF1F5" >
<br>
<br>
<center>
<fieldset>
<h4>Daily Entry Import Section</h4>
<br /><br />
<table border="0" valign="top" width="600" height="200" align="center">
<tr>
<!--<td>
Type:
</td>
<td>
<select style="Width:100px" name="cat" id="cat" >
     <option>-Select-</option>
      <option value="Purchases">Purchases</option>
	  <option value="Sales">Sales</option>
      
</select>
</td>-->
<td>


<form action="alkhu_dailyentry_display.php" method="post" enctype="multipart/form-data">

Excel file: <input type=file name="excel_file">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
<input type=submit value="Upload">&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
<!-- <input type=button value="Empty Database" onclick="document.location='delete.php';" > 
&nbsp;&nbsp;<input type=button value="View Report" onclick="window.open('reportsmry.php');" /> -->


</form> 

</td></tr>
</table>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_t_importsection.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>
	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
			<a href="./O2CHelp/Chicks Sales Import Format.xls" class="button" >Chick Sales Sample Format</a>
			<a href="./O2CHelp/Feed Sales Import Format.xls" class="button" >Feed Sales Sample Format</a>
		</div>
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>
</fieldset>
</center>
</body>
</html>