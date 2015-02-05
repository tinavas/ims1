

<?php
include "config.php";
include "jquery.php";

?>
<center>
<br/>
<h1>Task Scheduling</h1>

			  <br /> <br />

<br/>
<br/><br />
<form method="post" action="hr_savetaskschedule.php" >



 <table align="center">
<tr>

<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>" />
<input type="hidden" id="emp" name="emp" value="<?php echo $_GET['emp'];?>" />
<input type="hidden" id="title" name="title" value="<?php echo $_GET['title'];?>"/>
 <td align="right"><strong>Date&nbsp;&nbsp;</strong></td>
                <td align="left">&nbsp;<input class="datepicker" type="text" size="15" id="compdate" name="compdate" value="<?php echo date("d.m.Y"); ?>" ></td>
              
<td width="20px"></td>

 <td align="right"><strong>Scheduled Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>

                <td align="left">&nbsp;<input type="text" size="15" id="sdate" name="sdate" value="<?php echo $_GET['sdate']; ?>" readonly=""></td>
              
</tr>

</table>
<br /><br />


<table align="center">
<tr>

<td width="10px"></td>
<td style=" vertical-align:middle"><strong>Task<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>

<td><textarea rows="8" cols="70" id="task" name="task" readonly="readonly"><?php echo $_GET['task'];?></textarea></td>


</td>
</tr>
<tr height="10px"></tr>
<tr>

<td width="10px"></td>
<td style=" vertical-align:middle"><strong>Remarks<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>

<td><textarea rows="3" cols="70" id="remarks" name="remarks"></textarea></td>


</td>
</tr>

</table>
<br/>
<br/>

<center>
<input type="submit" value="Task Completed" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_taskschedule';">

</form>
</center>
</td></tr>
</table>
</center>

<script type="text/javascript">
function script1() {
window.open('Management Help/taskcompletion.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="../../PMS/PMS/production/images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
