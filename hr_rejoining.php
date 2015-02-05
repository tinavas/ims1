<?php include "jquery.php"?>
<br /><br />
<center>
<h1>Employee Rejoining </h1>
</center>
<br /><br />
<form method ="POST" name="myform" id="myform" action="hr_rejoin.php?id=<?php echo $_GET['id']; ?>" >
<?php 
include "config.php";
$qdate = "select rdate from hr_releave where eid = '$_GET[id]' order by rdate ASC";
$rsdate = mysql_query($qdate,$conn);
while($rrdate = mysql_fetch_assoc($rsdate))
{

?>
<input type="hidden" id="oldrdate" name="oldrdate" value="<?php echo $rrdate['rdate'];?>" />

<?php } ?>

<table align="center">
<tr>
<td>
<strong>Rejoining Date</strong>&nbsp;&nbsp;
</td>
<td>
<input type="text" value="<?php echo date('d.m.o') ?>" readonly name="rdate" id="rdate" class="datepicker" size="12">
</td>
<tr height="10px"><td></td></tr>

<tr>
<td>
<strong>Reason</strong>&nbsp;&nbsp;
</td>
<td>
<textarea id="remark" name="remark" cols="25">
</textarea>
</td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td colspan="2" align="center">
<input type="button" value="Rejoin" onclick = "check();"/>&nbsp;&nbsp;
<input type="button" value = "Cancel" onclick="document.location='dashboardsub.php?page=hr_employee';"/>

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


var dd= document.getElementById('oldrdate').value;
var dd1 =dd.split('-');
var dd2 = dd1[1] + '/' + dd1[2] + '/' + dd1[0];
oldrdate = new Date(dd2);


if(edate >= oldrdate)
document.getElementById('myform').submit();
else if( edate < oldrdate)
alert('Entered date should not be less than your Relieved date and ur Relieved date is ' + dd);
}
</script>
