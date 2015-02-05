<?php include "jquery.php";
      include "getemployee.php";
      include "config.php"; 
	  
$q1 = "SELECT max(fdate) as fdate from ac_definefy ";
$result = mysql_query($q1,$conn);
while($row1 = mysql_fetch_assoc($result))
 {
 $fromdate = $row1['fdate'];
 $fromdate = date("d.m.Y",strtotime($fromdate));
 }
  	  
?>
<center>
<br />
<h1>Cost Center Ledger</h1> 
<br /><br /><br />
<form target="_new" action="production/balancesheet.php">

<table align="center">
<tr>
 <td colspan="7"><strong>Cost Center</strong>&nbsp;&nbsp;&nbsp;
  <select id="costcenter" name="costcenter">
  <option value="">-Select-</option>
  <?php
  $query = "select sector from tbl_sector where costeffect = '1' and client = '$client'";
  $result = mysql_query($query,$conn) or dir(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
  <?php
  }
  ?>
  </select>
 </td>
</tr>
<tr height="10px"></tr> 
<tr>
<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo $fromdate; ?>"></td>
<td width="10px"></td>
<td><strong align="right">To&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.o"); ?>"></td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>


<script type="text/javascript">
function openreport()
{
var fromdate = document.getElementById('date2').value;
var todate = document.getElementById('date3').value;
var ccenter = document.getElementById('costcenter').value;
window.open('production/costcenterledger.php?fromdate=' + fromdate + '&todate=' + todate+ '&costcenter=' + ccenter); 
}


</script>
<script type="text/javascript">
function script1() {
window.open('GLHelp/help_balancesheet.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
	

