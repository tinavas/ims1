<?php include "jquery.php";
     
?>
<center>
<br />
<h1><strong>Schedule</strong> </h1> 
<br /><br /><br />
<form method="post" target="_new">
<table align="center">
<tr>
<td align="right"><strong>Month&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="month" name="month" style="width:90px" >
					<option>-Select-</option>
					<option value="1">JAN</option>
					<option value="2">FEB</option>
					<option value="3">MAR</option>
					<option value="4">APR</option>
					<option value="5">MAY</option>
					<option value="6">JUNE</option>
					<option value="7">JULY</option>
					<option value="8">AUG</option>
					<option value="9">SEP</option>
					<option value="10">OCT</option>
					<option value="11">NOV</option>
					<option value="12">DEC</option>
					</select>
</td>
<td width="10px"></td>
<td><strong align="right">Year&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="year" name="year" style="width:90px"/>
					<option>-Select-</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
					</select>
</td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onClick="openreport();" />
</form>
</center>




<script type="text/javascript">
function openreport()
{
var month = document.getElementById("month").value;
var year = document.getElementById("year").value;
window.open('production/check.php?month=' + month + '&year=' + year); 
}



</script>
<script type="text/javascript">
function script1() {
window.open('LayerHelp/help_r_eggcost.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
	
