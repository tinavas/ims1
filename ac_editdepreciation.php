<?php include "config.php"; 
$id = $_GET['id'];
$query = "SELECT * FROM ac_depreciation WHERE id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$fromdate = date("d.m.Y",strtotime($rows['fromdate']));
$todate = date("d.m.Y",strtotime($rows['todate']));
$todate = date("d.m.Y",strtotime($rows['todate']));
$code = $rows['code'];
$code1 = explode('@',$code);
$code = $code1[0];
$desc = $code1[1];
$ecode = $rows['ecode'];
$type = $rows['type'];
$amount = $rows['amount'];
$mode = $rows['mode'];
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
   <form class="block-content form" name="form" style="min-height:600px" id="complex_form" method="post" onsubmit="return checkform(this)" action="ac_savedepreciation.php" >
	  <h1 id="title1">Depreciation</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
<input type = "hidden" id = "saed" name="saed" value="1" />
<input type = "hidden" id = "oldid" name="oldid" value="<?php echo $id; ?>" />
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/>
<table align="center">
<tr>
<td><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<input type="text" name="from" id="from" class="datepicker" value="<?php echo $fromdate; ?>" size="10"  /> &nbsp;&nbsp;
<strong>To Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<input type="text" name="to" id="to" class="datepicker" value="<?php echo $todate; ?>" size="10"  /> &nbsp;&nbsp;
</td>
<td width="10px"></td>
<td><strong>Mode Of Depreciation</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>
<td><select name="mode" id="mode" style="width:100px;">
    <option value="<?php echo $mode; ?>"><?php echo $mode; ?></option>
	</select></td>
</tr>
</table><br />
<br />
<table id="tab1" align="center">
<tr>
 <td colspan="3" align="center"><strong>Fixed Assets</strong></td>
 <td width="10px"></td>
 <td colspan="3" align="center"><strong>Expenses</strong></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td><strong>Code&nbsp;<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td><strong>Description&nbsp;<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td><strong>Code&nbsp;<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td><strong>Description&nbsp;<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td><strong>Type&nbsp;<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td><strong>Amount&nbsp;/<br />Percentage<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
</tr>
<tr height="10px"></tr>

<tr>
 <td>
  <select id="code@1" name="code[]" onchange="selectdesc(this.id,this.value);">
  <option value="">-Select-</option>
  <?php
  $totalrows = 0;
  $query1 = "select distinct(schedule) from ac_schedule where pschedule = 'Fixed Assets' and ptype = 'InDirect' order by schedule";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($rows1 = mysql_fetch_assoc($result1))
  {
  $schedule = $rows1['schedule'];
  $query = "SELECT code,description FROM ac_coa WHERE schedule = '$schedule' ORDER BY code";
  $result = mysql_query($query,$conn) or die(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  { $totalrows++;
  ?>
  <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>" title="<?php echo $rows['description']; ?>" <?php if($rows['code'] == $code) { ?> selected="selected" <?php } ?>><?php echo $rows['code']; ?></option>
  <?php } } ?>
  </select>
  <td width="10px"></td>
 <td>
  <select id="desc@1" name="desc[]" onchange="selectcode(this.id,this.value);">
  <option value="">-Select-</option>
  <?php
  $query1 = "select distinct(schedule) from ac_schedule where pschedule = 'Fixed Assets' and ptype = 'InDirect' order by schedule";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($rows1 = mysql_fetch_assoc($result1))
  {
  $schedule = $rows1['schedule'];
  $query = "SELECT code,description FROM ac_coa WHERE schedule = '$schedule' ORDER BY description";
  $result = mysql_query($query,$conn) or die(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>" title="<?php echo $rows['description']; ?>" <?php if($rows['code'] == $code) { ?> selected="selected" <?php } ?>><?php echo $rows['description']; ?></option>
  <?php } } ?>
  </select>
  <td width="10px"></td>
 <td>
  <select id="ecode@1" name="ecode[]" onchange="selectdesc2(this.id,this.value);">
  <option value="">-Select-</option>
  <?php
  $totalrows = 0;
  $query1 = "select distinct(schedule) from ac_schedule where type = 'Expense' and pschedule <> '' order by schedule";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($rows1 = mysql_fetch_assoc($result1))
  {
  $schedule = $rows1['schedule'];
  $query = "SELECT code,description FROM ac_coa WHERE schedule = '$schedule' ORDER BY code";
  $result = mysql_query($query,$conn) or die(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  { $totalrows++;
  ?>
  <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>" title="<?php echo $rows['description']; ?>" <?php if($rows['code'] == $ecode) { ?> selected="selected" <?php } ?>><?php echo $rows['code']; ?></option>
  <?php } } ?>
  </select>
  <td width="10px"></td>
 <td>
  <select id="edesc@1" name="edesc[]" onchange="selectcode2(this.id,this.value);">
  <option value="">-Select-</option>
  <?php
  $query1 = "select distinct(schedule) from ac_schedule where type = 'Expense' and pschedule <> '' order by schedule";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  while($rows1 = mysql_fetch_assoc($result1))
  {
  $schedule = $rows1['schedule'];
  $query = "SELECT code,description FROM ac_coa WHERE schedule = '$schedule' ORDER BY description";
  $result = mysql_query($query,$conn) or die(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>" title="<?php echo $rows['description']; ?>" <?php if($rows['code'] == $ecode) { ?> selected="selected" <?php } ?>><?php echo $rows['description']; ?></option>
  <?php } } ?>
  </select>
  <td width="10px"></td>
  <td>
    <input type="radio" id="type1@1" name="type1" value="Percent" <?php if($type == "Percent") { ?> checked="checked" <?php } ?>>&nbsp;<strong>%</strong>&nbsp;&nbsp;
    <input type="radio" id="type2@1" name="type1" value="Amount" <?php if($type == "Amount") { ?> checked="checked" <?php } ?>>&nbsp;<strong>Amt</strong>&nbsp;&nbsp;
  </td>	
  <td width="10px"></td>
  <td>
    <input type="text" id="amount1" name="amount[]" value="<?php echo $amount; ?>" size="8" style="text-align:right" onkeyup="validate(this.id,this.value)">
  </td>
 </tr>

</table>
<br><br>
<input type="submit" value="Update" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=ac_depreciation'" />
</form>
<script type="text/javascript">
var index = 1;
var totalrows = <?php echo $totalrows; ?>;

function selectdesc(a,b)
{
 
for(var i = 1;i<=index;i++)
{
	for(var j = 1;j<=index;j++)
	{ 
		if( i != j)
		{ 
		
			if(document.getElementById('code@' + i).value == document.getElementById('code@' + j).value)
			{
				alert("Please select different combination");
				document.getElementById('code@' + j).value = "";
				document.getElementById('desc@' + j).value = "";
				return;
			}
		}
	}
} 
 var temp = a.split("@");
 var tindex = temp[1];
 document.getElementById('desc@'+tindex).value=b;
}

function selectcode(a,b)
{
for(var i = 1;i<=index;i++)
{
	for(var j = 1;j<=index;j++)
	{ 
		if( i != j)
		{ 
		
			if(document.getElementById('desc@' + i).value == document.getElementById('desc@' + j).value)
			{   
				alert("Please select different combination");
				document.getElementById('desc@' + j).value = "";
				document.getElementById('code@' + j).value = "";				
				return;
			}
		}
	}
} 
 var temp = a.split("@");
 var tindex = temp[1];
 document.getElementById('code@'+tindex).value=b;
}

function selectdesc2(a,b)
{
 var temp = a.split("@");
 var tindex = temp[1];
 document.getElementById('edesc@'+tindex).value=b;
}

function selectcode2(a,b)
{
 var temp = a.split("@");
 var tindex = temp[1];
 document.getElementById('ecode@'+tindex).value=b;
}

function validate(a,b)
{
 var expr=/^[0-9. ]*$/;
 if(! b.match(expr))
 {
  alert("It should be a number");
  document.getElementById(a).value = b.substr(0,(b.length-1));
  document.getElementById(a).focus();
 }
}

function checkform()
{
 return true;
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
