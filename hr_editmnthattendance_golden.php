<?php include "jquery.php"; include "getemployee.php"; session_start(); ?>
<?php
$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");
$id = $_GET['id'];
$mnt  = $_GET['mon'];
$month = $montharr[$mnt-1];
$year = $_GET['year'];
		$q = "select * from hr_mnthattendance where id = '$id'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		$eid = $qr['eid'];
		$employeename = $qr['employeename'];
		$sector = $qr['sector'];
		$designation = $qr['designation'];
		$dayspresent = $qr['dayspresent'];
		$workingdays = $qr['workingdays'];
		$ext = $qr['extra'];
		$leav=$qr['leaves'];
		}
		  
?>

<section class="grid_8">
  <div class="block-border">

     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_updatemnthattandance_golden.php" >
		 <h1 id="title1">Working Days</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>  
			 
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
&nbsp;&nbsp;&nbsp;
<strong>Month </strong>&nbsp;&nbsp;
<input type="hidden" id="rid" name="rid" value="<?php echo $id;?>"/> 
<input type="text" style="width: 70px;text-align:left" id="month" name="month"  value="<?php echo $month;?>"  readonly />


&nbsp;&nbsp;&nbsp;
<strong>Year </strong>&nbsp;&nbsp;
<input type="text" style="width: 50px;text-align:left" id="year" name="year"  value="<?php echo $year;?>"  readonly />

&nbsp;&nbsp;&nbsp;
<strong>Working Days </strong>&nbsp;&nbsp;
<input type="text" style="width: 50px;text-align:right" id="wdays" name="wdays"  value="<?php echo $workingdays;?>"  readonly />
</center>
<br/>
<br/>
<table align="center" width="750px" > 
<tr align="center">

<td>
<strong>ID</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Name</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Sector</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Designation</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Days Present<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>    </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Extra </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Leaves </strong>
</td>
</tr>
<tr height="10px"><td></td></tr>

<tr align="center">
<td>
<input type="text" style="width: 30px;" id="employeeid" name="employeeid"  readonly value="<?php echo $eid; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 120px;" id="employeename" name="employeename"  readonly value="<?php echo $employeename; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 120px; " id="sect" name="sect"  readonly value="<?php echo $sector; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 120px;" id="designation" name="designation"  readonly value="<?php echo $designation; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 70px;text-align:right; color:#FF0000" id="days" name="days"  value="<?php echo $dayspresent;?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 70px;text-align:right; color:#FF0000" id="extra" name="extra"  value="<?php echo $ext;?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="width: 70px;text-align:right; color:#FF0000" id="leave" name="leave"  value="<?php echo $leav;?>" />
</td>

</tr>
<tr height="20px"><td></td></tr>
</table>
<br/>
<table align="center" >
<tr>
<td colspan="4" align="center">
<input type="submit" value = "Update" />
</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td>
<input type="button" value = "Cancel" onclick="document.location = 'dashboardsub.php?page=hr_mnthattendance';"/>
</td>
</tr>
</table>
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
