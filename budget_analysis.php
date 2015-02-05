<?php include "jquery.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Abattoir Stock Summary Report</h1> 
<br /><br /><br />
<form target="_new" action="#">
<table>
<tr>
<td align="right"><strong>Cost Centre&nbsp;</strong></td>
                <td><select id="cc" name="cc" style="width:120px">
<option value="All">All</option>
<?php
 $q1 = "SELECT distinct(sector) FROM tbl_sector WHERE (type1 = 'Processing Unit' || type1 = 'Chicken Center') order by sector";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>

</select></td>

</tr>


</table>
<br/><br/>
<table align="center">
<tr>
<td align="right"><strong>Month : </strong></td>
<td width="10px">&nbsp;</td>
<td align="left"><select id="month" onChange="" name="month" ><option value="Select"> Select </option><option value="01">JAN</option><option value="02">FEB</option><option value="03">MAR</option><option value="04">APR</option><option value="05">MAY</option><option value="06">JUN</option><option value="07">JUL</option><option value="08">AUG</option><option value="09">SEP</option><option value="10">OCT</option><option value="11">NOV</option><option value="12">DEC</option></select></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Year : </strong></td>
<td width="10px">&nbsp;</td>
<td align="left"><select id="year" onChange="" name="year"><option value="Select"> Select </option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option></select></td>
</tr>
</table>
<br/>
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>


<script type="text/javascript">
function openreport()
{

var cc = document.getElementById('cc').value;
var month = document.getElementById('month').value;
var year = document.getElementById('year').value

window.open('production/budgetanalysis.php?costcentre=' + cc + '&month=' + month + '&year=' + year); 


}

</script>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
	

