<?php include "getemployee.php"; include "config.php"; session_start();
 $cashbank = $_GET['cashbank'];
 if($cashbank == "")
  $cashbank = 'Cash';
 if($cashbank == 'Cash') $cond = "'%Cash%'";
 else $cond = "'%Bank%'"; 
?>
	<script>
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
	</script>

<?php include "config.php"; 
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
<h1><?php if($cashbank == 'Cash') echo "Cash"; else echo "Bank"; ?> Flow Statement</h1> 
<br /><br /><br />
<form target="_new">
<table align="center">
<tr>
<td align="right"><?php if($cashbank == 'Cash') echo "Cash"; else echo "Bank"; ?> Code&nbsp;&nbsp;</td>
<td align="left">
<select id="code" name="code" onchange="description();">
<option value="">Select</option>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	 $q = "select code,controltype,description from ac_coa WHERE controltype LIKE $cond order by code ";
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];

	 	$query = "select code,controltype,description from ac_coa WHERE code IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector = '$sectortype' ORDER BY code ASC)) WHERE controltype LIKE $cond order by code";
	  	$result = mysql_query($query,$conn) or die(mysql_error());
		while($rows = mysql_fetch_assoc($result))
		{
		?>
	<option title="<?php echo $rows['description']; ?>" value="<?php echo $rows['code']; ?>"><?php echo $rows['code']; ?></option>
		<?php
		}
	}
}
else
 	 $q = "select code,controltype,description from ac_coa WHERE controltype LIKE $cond order by code ";
 
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{

?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
</tr>
<tr height="10px"></tr>
<tr>
<td align="right">Description&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<input type="text" id="desc" name="desc" value="" size="25" readonly />
</td>
</tr>
<tr height="10px"></tr>
</table>
<table align="center">
<tr>
<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="from" class="datepicker" name="from" value="<?php echo  $fromdate; ?>" onChange="datecomp();"></td>
<td width="10px"></td>
<td><strong align="right">To&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="to" class="datepicker" name="to" value="<?php echo date("d.m.o"); ?>" onChange="datecomp();" ></td>
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
var fromdate = document.getElementById('from').value;
var todate = document.getElementById('to').value;
var code = document.getElementById('code').value;
var desc = document.getElementById('desc').value;

window.open('production/cashflowstmt.php?fromdate=' + fromdate + '&todate=' + todate + '&code=' + code + '&desc=' + desc+ '&cashbank=<?php echo $cashbank; ?>'); 

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

if(temp1 >temp4)
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
function description()
{

	<?php
		$q = "select * from ac_coa";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code').value == '$qr[code]') { ";
		$q1 = "select code,description from ac_coa where code = '$qr[code]'";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc').value = "<?php echo $q1r['description']; ?>";
		
		<?php 
		}
		echo " } "; 
		}
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
window.open('GLHelp/help_coaledger.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
	