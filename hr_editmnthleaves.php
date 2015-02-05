<?php include "jquery.php";  session_start(); ?>
<?php
$id = $_GET['id'];
		$q = "select * from hr_mnthleaves where id = '$id'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		  $sector = $qr['sector'];
		  $desig = $qr['designation'];
		   $leaves = $qr['allowedleaves'];
		   $mnths = $qr['forwardmnths'];
		  }
		  
?>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_updatemnthleaves.php" >
	  <h1 id="title1">Allowed Leaves</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
			  
			 
<br/>
<br/>

<table id="paraID" >
<tr>
<th style="width:150px"><strong>Sector</strong>&nbsp;&nbsp;&nbsp;</th>
<td width="10">&nbsp;</td>
<th style="width:150px"><strong>Designation</strong>&nbsp;&nbsp;&nbsp;</th>
<td width="10">&nbsp;</td>
<th style="width:40px" title="Leaves Allowed / Month"><strong>Leaves</strong>&nbsp;&nbsp;&nbsp;</th>
<td width="10">&nbsp;</td>
<th style="width:100px"><strong>Forwarded Till Months</strong>&nbsp;&nbsp;&nbsp;</th>
</tr>



</table>
<table id="inputs">
<tr>

<td>
<input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
<input style="color:#FF0000;width:150px" type="text" name="sector" id="sector" value="<?php echo $sector;?>"   readonly /></td>

<td width="10px"></td> 
		   
<td>
<input style="color:#FF0000;width:150px" type="text" name="desig" id="desig" value="<?php echo $desig;?>"   readonly /></td>
<td width="10px"></td>

<td>
<input style="width:40px"  type="text" name="leaves" id="leaves" value="<?php echo $leaves;?>"  /></td>
<td width="10px"></td>
<td >
<select id="month" name="month" style="width:100px">
<option value="Select"> Select </option>
<option value="01" <?php if($mnths == "01") {?> selected="selected"<?php }?>>01</option>
<option value="02" <?php if($mnths == "02") {?> selected="selected"<?php }?>>02</option>
<option value="03" <?php if($mnths == "03") {?> selected="selected"<?php }?>>03</option>
<option value="04" <?php if($mnths == "04") {?> selected="selected"<?php }?>>04</option>
<option value="05" <?php if($mnths == "05") {?> selected="selected"<?php }?>>05</option>
<option value="06" <?php if($mnths == "06") {?> selected="selected"<?php }?>>06</option>
<option value="07" <?php if($mnths == "07") {?> selected="selected"<?php }?>>07</option>
<option value="08" <?php if($mnths == "08") {?> selected="selected"<?php }?>>08</option>
<option value="09" <?php if($mnths == "09") {?> selected="selected"<?php }?>>09</option>
<option value="10" <?php if($mnths == "10") {?> selected="selected"<?php }?>>10</option>
<option value="11" <?php if($mnths == "11") {?> selected="selected"<?php }?>>11</option>
<option value="12" <?php if($mnths == "12") {?> selected="selected"<?php }?>>12</option>
</select>
</tr>
</table>
<br/>
<br/>
<input type="submit" value="Update" id="Save"/>&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_mnthleaves';">
</center>
</form>
 </div>
</section>

		

<br />



<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('BroilerHelp/help_t_finalization.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
