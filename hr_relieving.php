<?php include "jquery.php"?>
<br /><br />
<center>
<h1>Employee Relieving </h1>
</center>
<br /><br />

<form  method="POST" name="myform" id="myform" action="hr_relieve.php?id=<?php echo $_GET['id']; ?>">
<?php 
include "config.php";
$qdate = "select joiningdate from hr_employee where employeeid = '$_GET[id]'";
$rsdate = mysql_query($qdate,$conn);
while($rrdate = mysql_fetch_assoc($rsdate))
{

?>
<input type="hidden" id="joiningdate" name="joiningdate" value="<?php echo $rrdate['joiningdate'];?>" />

<?php } ?>

<table align="center">
<tr>
<td>
<strong>Relieving Date</strong>&nbsp;&nbsp;
</td>
<td>
<input type="text"  size="12" onchange="" value="<?php echo date('d.m.o') ?>" readonly  class="datepicker" name="rdate" id="rdate">&nbsp;
</td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
<td>
<strong>Reason</strong>
</td>
<td>
<textarea id="remark" name="remark" cols="25">
</textarea>
</td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
<td colspan="2" align="center">
<input type="button" value="Relieve" onclick="check();"/>&nbsp;&nbsp;&nbsp;
<input type="button" value = "Cancel" onclick="document.location = 'dashboardsub.php?page=hr_employee';"/>

</td>
</tr>
</table>

</form>
<script type="text/javascript">

function check()
{

var d= document.getElementById('rdate').value;
var d1 =d.split('.');
var d2 = d1[1] + '/' + d1[0] + '/' + d1[2];

edate = new Date(d2);
var dd= document.getElementById('joiningdate').value;
var dd1 =dd.split('-');
var dd2 = dd1[1] + '/' + dd1[2] + '/' + dd1[0];
joiningdate = new Date(dd2);


if(edate >= joiningdate)
document.getElementById('myform').submit();
else if( edate < joiningdate)
alert('Entered date should not be less than your Joining date and ur Joining date is ' + dd);

}
</script>
<script type="text/javascript">
function script1() {
window.open('HRHELP/help_m_relievingemployee.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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