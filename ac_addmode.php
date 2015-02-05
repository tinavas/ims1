<?php include "config.php";
$q1 = "SELECT max(fdate) as fdate,max(tdate) as tdate from ac_definefy ";
$result = mysql_query($q1,$conn);
while($row1 = mysql_fetch_assoc($result))
 {
 $fromdate = $row1['fdate'];
 $fromdate = date("d.m.Y",strtotime($fromdate));
 $todate = $row1['tdate'];
 $todate = date("d.m.Y",strtotime($todate));
 }
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

<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="height:600px" id="complex_form" name="form1" method="post" action="ac_savemode.php" >
	  <h1 id="title1">Mode Of Depreciation</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
<b>Mode Of Depreciation</b>
<br>
<br>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br><br>
<table align="center">

<tr>
<td><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<input type="text" name="from" id="from" class="datepicker" value="<?php echo $fromdate; ?>" size="10"  /> &nbsp;&nbsp;</td>
<td><strong>To Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<input type="text" name="to" id="to" class="datepicker" value="<?php echo $todate; ?>" size="10"  /> &nbsp;&nbsp;
</td>
</tr>
<tr height="10px"></tr>
<tr>
<td><strong>Mode Of Depreciation</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td><select name="mode" id="mode" style="width:100px;">
    <option value="">-Select-</option>
	<option value="Monthly">Monthly</option>
	<option value="Quarterly">Quarterly</option>
	<option value="Yearly">Yearly</option>
	</select></td>
</tr>	
</table>
<table>
<tr height="20px"></tr>
<tr>
<td><input type="submit" value="Save"></td>
<td width="10px"></td>
<td><input type="button" name="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=ac_mode';"></td>
</tr>
</table>

</center>
</form>
</div>
</section>


<script type="text/javascript">
function script1() {
window.open('BREEDERHELP/ac_addmodehelp.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<br><br>





<body>
</body>
</html>
