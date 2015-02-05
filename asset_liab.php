<?php include "jquery.php";
      include "getemployee.php";
      include "config.php"; 
?>
<center>
<h1> Assets & Liability Graph </h1>
</center>

<br /><br /><br />
<form action="#">
<table align="center">
<tr>



<td><strong>From Date  &nbsp;&nbsp;</strong></td>
<td>
<input class="datepicker" type="text" size="12" id="fdate" name="fdate" value="<?php echo date("d.m.Y"); ?>" ></td>
</td>
<td width = "10px"></td>
<td><strong>To Date  &nbsp;&nbsp;</strong></td>
<td>
<input class="datepicker" type="text" size="12" id="tdate" name="tdate" value="<?php echo date("d.m.Y"); ?>" onchange = "checkmonth(this.id);" ></td>

</td>


</tr>

</table>

<br/><br/>
<center>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Graph" onClick="openreport();" />
</form>
</center>




<script type="text/javascript">
function checkmonth(a)
{
var h = document.getElementById('fdate').value;
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
var fdate = document.getElementById('fdate').value;
var tdate = document.getElementById('tdate').value;


window.open('Flot Pie Chart/link1.php?fdate='+fdate+'&tdate='+tdate); 

}



function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}



</script>

	</body>
	 </html>



