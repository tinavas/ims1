<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
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
   <form class="block-content form" style="height:600px" id="complex_form" name="form1" method="post" onsubmit="return checkform();" action="vehicle_savelocation.php" >
	  <h1 id="title1">Employee Allowances</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br><br>

<table>
<tr height="10px"></tr>
</table>
<table>
<tr>
<td><strong>Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;<input type="text" name="location" id="location" /></td>
</tr>
</table>
<table>
<tr height="10px"></tr>
<tr>
<td><input type="submit" value="Save" /></td>
<td width="20px"></td>
<td><input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=vehicle_location.php'"/></td></tr>
</table>
</center>

</form></div></section>


</body>
</html>
