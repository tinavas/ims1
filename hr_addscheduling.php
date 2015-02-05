
<?php
include "config.php";
include "jquery.php";
$sectorr = $_SESSION['sectorlist'];
?>
<center>
<br/>
<h1>Task Assigning</h1>
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br /> <br />

<br/>
<br/><br />
<form method="post" action="hr_savescheduling.php" >



 <table align="center">
<tr>



 <td align="right"><strong>Date&nbsp;&nbsp;</strong></td>
                <td align="left">&nbsp;<input class="datepicker" type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" ></td>
              
<td width="20px"></td>

 <td align="right"><strong>Employee</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>
                <td align="left"><select id="emp" name="emp" style="width:120px">
<option value="">-Select-</option>
<?php
$sectorr = $_SESSION['sectorlist'];
$r = explode(',',$sectorr);
$n = count($r);

 $q1 = "SELECT * FROM hr_employee WHERE sector In ($sectorr) and client = '$client' order by sector";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
<option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>

</select></td>
  <td width="20px"></td>

 <td align="right"><strong>Scheduled Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>

                <td align="left">&nbsp;<input class="datepicker" type="text" size="15" id="sdate" name="sdate" value="<?php echo date("d.m.Y"); ?>"></td>
              
</tr>

</table>
<br /><br />


<table align="center">
<tr>

<td width="10px"></td>
<td style=" vertical-align:middle"><strong>Subject<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>

<td><textarea rows="1" cols="70" id="subject" name="subject"></textarea></td>


</td>
</tr>
<tr height="10px"></tr>
<tr>

<td width="10px"></td>
<td style=" vertical-align:middle"><strong>Task<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>

<td><textarea rows="3" cols="70" id="task" name="task" onkeyup="limiter(this.id);"></textarea></td>


</td>
</tr>

</table>
<table>
<tr>
<td width="50px"></td>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td ><p><b>Characters Left :&nbsp;&nbsp;</b></p></td>
<td align="right"><input type="text" name="limit" id="limit" size="4" value="250" readonly  style="background:none; border:0" onkeyup="limiter(this.id)" /></td>
</tr>
</table>

<br/>
<br/>

<center>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_scheduling';">

</form>
</center>
</td></tr>
</table>
</center>
<script type="text/javascript">
var count = "250";  
function limiter(task){
var tex = document.getElementById(task).value;
var len = tex.length;
if(len > count){
        tex = tex.substring(0,count);
        document.myform.comment.value =tex;
        return false;
}
document.getElementById("limit").value = count-len;
}
</script>
<script type="text/javascript">
function script1() {
window.open('Management Help/help_scheduling.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
