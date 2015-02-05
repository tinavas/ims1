<?php include "jquery.php";
     // include "getemployee.php";
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
<h1>Trial Balance</h1> 
<br /><br /><br />
<form method="post" target="_new">
<table align="center">
<tr>
<td><strong align="right">Date&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text"id="date3" class="datepickerreport" name="date3" value="<?php echo date("d.m.Y"); ?>" size="10" ></td>
</tr>
<tr height="15px">&nbsp;</tr>
<tr>
<td colspan="3" align="center">
<input type="radio" id="type" name="type" checked="checked" /><strong>Type</strong>&nbsp;&nbsp;
<input type="radio" id="pschedule" name="type" /><strong>Parent Schedule</strong>&nbsp;&nbsp;
<input type="radio" id="schedule" name="type" /><strong>Schedule</strong>
</td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();" />
</form>
</center>




<script type="text/javascript">
function openreport()
{
//var fromdate = document.getElementById('date2').value;
var todate = document.getElementById('date3').value;
var type;
if(document.getElementById('type').checked == true)
 type = "Type";
else if(document.getElementById('pschedule').checked == true)
 type = "Parent";
else if(document.getElementById('schedule').checked == true)
 type = "Schedule";
 

window.open('production/trialbalance.php?todate=' + todate + '&type=' + type); 

}


function datecomp()
{
<?php echo "
dd = document.getElementById('date2').value;
temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
temp1 = new Date(temp);

dd1 = document.getElementById('date3').value;
temp3 =  dd1.split('.');
temp3 = temp3[1] + '/' + temp3[0] + '/' + temp3[2];
temp4 = new Date(temp3);

if(temp1 >=temp4)
{
 alert('To date must be greater than or equal to From date');
 document.getElementById('report').disabled = true;
}
else
{
 document.getElementById('report').disabled = false;
 reloadpurord();
}
 ";
?>
}

function reloadpur()
{
 date2 = document.getElementById('date2').value;
 date2 = temp =  date2.split('.');
 var fdate =(date1[2] + '-' + date2[1] + '-' + date2[0]).toString();
 
 date3 = document.getElementById('date3').value;
 date3 = temp =  date3.split('.');
 var tdate =(date3[2] + '-' + date3[1] + '-' + date3[0]).toString();
}

</script>
<script type="text/javascript">
function script1() {
window.open('GLHelp/help_Trialbalance.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
	
