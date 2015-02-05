
<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";
?>

<center>
<br />
<h1>Profit Centre</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br /><br />
<form target="_new" action="#">
<table align="center">
<tr>
 
 <td><strong>&nbsp;&nbsp;Profit Centre</strong></td>
                <td><select id="pc" name="pc" style="width:120px" >
<option value="">-Select-</option>
<?php
 $q1 = "SELECT * FROM tbl_sector WHERE type1='Hatchery' and profitcentre = '1' and client = '$client' order by sector";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>

</select></td>
   <td width="50px"></td>
 <td><strong>Date&nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="17" id="date" name="date" value="<?php echo date("d.m.Y");?>"></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td><strong>From Date&nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="17" id="fromdate" name="fromdate" value="<?php echo date("d.m.Y");?>"></td>
<td width="10px"></td>
 <td><strong>To Date&nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="17" id="todate" name="todate" value="<?php echo date("d.m.Y");?>"></td>


</table>
<br/>
<br/>
<table align="center">
<tr>
<td>
<input type="button" id="report" value="Report" onclick="openreport();"/></td>
</tr>
</table>
</form>

<script type="text/javascript">
function openreport()
{
var pc = document.getElementById('pc').value;
var date = document.getElementById('date').value;
var fdate = document.getElementById('fromdate').value;
var tdate = document.getElementById('todate').value;
window.open('profitcentrereport.php?pc=' + pc + '&date=' + date + '&fdate=' + fdate + '&tdate=' + tdate); 
}

</script>

</script>

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_chicken_addchickentransfer.php','BIMS',
'width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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


</body>
</html>

