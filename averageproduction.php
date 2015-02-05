<?php include "config.php"; 
include "jquery.php";
?>

<center>
<br/>
<h1>Monthly Egg Production Summary</h1>
</center>
<br /><br /><br />
<form id="myform1" name="myform1" action="#" method="post" target="_NEW">

<table align="center">


<tr>
<td><strong>Month : </strong></td>
<td width="10px">&nbsp;</td>
<td><select id="month" onChange="" name="month" ><option value="Select"> Select </option><option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option><option value="07">JUL</option><option value="08">AUG</option><option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option><option value="12">DEC</option></select></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Year : </strong></td>
<td width="10px">&nbsp;</td>
<td><select id="year" onChange="" name="year"><option value="Select"> Select </option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select></td>
</tr>

<tr height="20"></tr>

</table>
<br />

<table align="center">
<tr height="30"><td></td></tr>
<tr><td><td colspan="15" style="text-align:center"><input type="button" value="Report" onClick="openreport();" /></td></tr>
</table>

</form>




<script type="text/javascript">


function openreport()
{

var month = document.getElementById('month').value;
var year = document.getElementById('year').value;

window.open('production/avgproduction.php?month=' + month + '&year=' + year);

	
	
	
}







</script>

