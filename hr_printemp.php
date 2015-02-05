<?php
include "config.php";
$query = "SELECT * FROM hr_employee WHERE employeeid = '$_GET[id]'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $dob = $row['dob'];
  $dob = date("d.m.Y", strtotime($dob));  
  $title = $row['title'];
  $name = $row['name'];
  $bloodgroup = $row['bloodgroup'];
  $designation = $row['designation'];
  $address = $row['address'];
  $sector = $row['sector'];
  if($row['image'] != "")
  $imgpath = "employeeimages/reduced/" . $row['image'] ;
  else
  $imgpath = "employeeimages/reduced/noimage.jpg" ;
  
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>B.I.M.S</title>
<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>
<style type="text/css">
body{font-family:"Lucida Sans Unicode", "Lucida Grande", Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#555555;}
div.main{margin:30px auto; overflow:auto; width:700px;}
table.sortable{border:0; padding:0; margin:0;}
table.sortable td{padding:4px; width:120px; border-bottom:solid 1px #DEDEDE;}
table.sortable th{padding:4px;}
table.sortable thead{background:#e3edef; color:#333333; text-align:left;}
table.sortable tfoot{font-weight:bold; }
table.sortable tfoot td{border:none;}
</style>
</head>
<body onload="IsImageOk();">
<center>
<script type="text/javascript">
function IsImageOk() 
{
img1 = document.getElementById('img');
if (!img1.complete) 
{
alert("Loading....");
document.getElementById('loadmsg').style.visibility = "visible";
}
else if (img1.complete)
document.getElementById("loadmsg").style.visibility = "hidden";
}


//window.onload = function () { document.getElementById("loadmsg").style.visibility = "hidden" }

</script>

<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br class='printbutton' /><br class='printbutton' />");
</script>

<fieldset style="width:500px">

<!-- Header -->
<center>

   <table width ="500px">
    <tr height ="100">
	<td width="45" valign = "top" style="text-align:left">
    <img id ="img" name ="img" src="<?php echo $imgpath; ?>" width="175" height= "150">    
	</td>

	<td>
	
	   <table align="center" width ="300px" border="0">
   
   <tr align="center">
   <td width="151" align="left">
   <b><font size="2">SECTOR</font></b></td>
   <td width="439" align="left">
   <font size="2"><?php echo $sector; ?></font>   </td>
   </tr>
   
   <tr align="center">
   <td width="151" align="left">
   <b><font size="2">Employee Name</font> </b>  </td>
   <td width="439" align="left">
    <font size="2"><?php echo $name; ?></font>   </td>
   </tr>
   
   <tr align="center">
   <td align="left">
  <b> <font size="2">DATE OF BIRTH</font></b>
   </td>
   <td align="left">
    <font size="2"><?php echo $dob; ?></font>
   </td>
   </tr>
   
   <tr align="center">
   <td align="left">
   <b><font size="2">BLOOD GROUP  </font></b>
   </td>
   <td align="left">
   <font size="2"><?php echo $bloodgroup; ?></font>
   </td>
   </tr>
   
   <tr align="center">
   <td align="left">
   <b><font size="2">DESIGNATION</font></b>
   </td>
   <td align="left">
   <font size="2"><?php echo $designation; ?></font>
   </td>
   </tr>
   
   <tr align="center">
   <td align="left" valign ="top">
   <b><font size="2">ADDRESS</font></b>
   </td>
   <td align="left">
   <?php $address1 = explode(',',$address); 
   $size = sizeof($address1); ?>
    <font size="2"><?php for ($i=0;$i<$size;$i++){echo $address1[$i]; ?><br> <?php }?> </font>
   </td>
   </tr>
   </table>
	
	
	</td>
    <tr>
   </table>
 
 

</center>
<!-- /Header -->

<br/>




<div id="loadmsg" align="left">
<font color="#FF0000">
Image is loading...
</font>
</div>
</fieldset>
</center>

</body>
</html>
