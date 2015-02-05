<?php include "config.php"; ?>
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

<center><br /><br />
<h1> Revenue Graph </h1>
</center>

<br /><br /><br />
<form action="#">
<table align="center">
<tr>

<td><strong>From Date  &nbsp;&nbsp;</strong></td>
<td>
<input class="datepicker" type="text" size="12" id="from" name="from" value="<?php echo date("d.m.Y"); ?>" ></td>
</td>
<td width = "10px"></td>
<td><strong>To Date  &nbsp;&nbsp;</strong></td>
<td>
<input class="datepicker" type="text" size="12" id="to" name="to" value="<?php echo date("d.m.Y"); ?>" onchange = "checkmonth(this.id);" ></td>

</td>


</tr>

</table>

<br/><br/>
<center>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onClick="openreport();" />
</form>
</center>




<script type="text/javascript">
function checkmonth(a)
{
var h = document.getElementById('from').value;
var r = h.split(".");
var p = r[1];

var t = document.getElementById(a).value;
var y = t.split(".");
var g = y[1];

var dif = g-p;

if(dif <3 )
{
alert("Select atleast 3 months");
}
}

function openreport()
{
var fdate = document.getElementById('from').value;
var tdate = document.getElementById('to').value;
window.open('flot/examples/comparesales.php?fdate='+fdate+'&tdate='+tdate); 
}


</script>

	</body>
	 </html>



