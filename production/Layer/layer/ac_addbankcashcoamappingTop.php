<?php include "config.php";       
      include "jquery.php"; 
      include "getemployee.php";
?>
<center>
<br />
<h1>Bank/Cash Code Mapping with <span title="Chart Of Accounts">CoA</span></h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>
<form name="abt" >
<table border="0" align="center">
 <tr>
 <td><input type="radio" id="cash" name="cb" value="cash" onclick="loadframe();"/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong> </td>
 <td> &nbsp;&nbsp;&nbsp;<input type="radio" id="bank" name="cb" value="bank" onclick="loadframe();"/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong>
 </td>
</tr>
</table>
</form>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_m_addbankcashmapping.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<iframe id="myIframe" allowtransparency="true" style="background:none;" src="dummy.html" width="100%" height="350" scrolling="no" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</body>
<script type="text/javascript">
function loadframe()
{
	if(document.getElementById('cash').checked == true)
	var mode = "Cash";
	else
	var mode = "Bank";
	document.getElementById('myIframe').src = "ac_addbankcashcoamappingInsert.php?mode=" + mode;
}
</script>
</html>
