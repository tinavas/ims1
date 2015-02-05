<?php include "jquery.php"; include "getemployee.php"; session_start(); ?>
<?php
$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");
$id = $_GET['id'];
$mnt  = $_GET['mon'];
$month = $montharr[$mnt-1];
$year = $_GET['year'];
		$q = "select * from hr_workingdays where id = '$id'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		  $date1 = $qr['date'];
		  $date = date("d.m.o",strtotime($date1));
		   $noofdays = $qr['noofdays'];
		  }
		  
?>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_updateworkingdays.php" >
	  <h1 id="title1">Working Days</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
			  
			  <strong>Date</strong>
<input type="text" name="date1" id="date1" class="datepicker" value="<?php echo $date; ?>"  size="12"  /> 
<br/>
<br/>

<table id="paraID" >
<tr>

<th style="width:200px; text-align:left"><strong>Month&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Days</strong></th>
</tr>
</table>

<table id="inputs">
<tr>

<td>
<input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
<input type="hidden" name="monthno" id="monthno" value="<?php echo $mnt;?>"/>
<input style="color:#FF0000" type="text" name="month" id="month" value="<?php echo $month;?>" size="15"  readonly />
</td>

<td width="10px"></td>
<td>
<input style="color:#FF0000" type="text" name="year" id="year" value="<?php echo $year;?>" size="15"  readonly />
</td>
<td width="10px"></td>

<td >
<input type="text" name="nodays" id="nodays" value="<?php echo $noofdays;?>" size="4" />&nbsp;
</td>


</tr>
</table><br/>
<br/>
<input type="submit" value="Update" id="Save"/>&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_workingdays';">
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
