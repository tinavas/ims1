<?php 
include "config.php";

$id = $_GET['id'];

$gquery = "select * from vehicle_location where id = '$id' and client = '$client'";
$gresult = mysql_query($gquery,$conn) or die(mysql_error());
$gres = mysql_fetch_assoc($gresult);
?>


<script type="text/javascript">
function checkform()
{
fn = document.getElementById("location").value;
if(fn == "")
{
alert("Enter the Location");
document.getElementById("location").focus();
}
}
</script>
<body>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="height:600px" id="complex_form" name="form1" method="post" onsubmit="return checkform();" action="vehicle_updatelocation.php" >
	  <h1 id="title1">locations</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br><br>
<input type="hidden" name="id" id="id" value="<?php echo $gres['id']; ?>" />
<table>
<tr height="10px"></tr>
</table>
<table>
<tr>
<td><strong>Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;<input type="text" name="location" id="location"  value="<?php echo $gres['location']; ?>"/></td>
</tr>
</table>
<table>
<tr height="10px"></tr>
<tr>
<td><input type="submit" value="Update" /></td>
<td width="20px"></td>
<td><input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=vehicle_location.php'"/></td></tr>
</table>
</center>

</form></div></section>


</body>
</html>
