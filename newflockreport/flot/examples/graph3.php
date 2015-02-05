<?php
$id = $_GET['id'];
$placeid = $_GET['placeid'];
$supervisor = $_GET['supervisor'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Purchase Of Ingredients</title>
<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
<script type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

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
<body bgcolor="#ECF1F5">

<div align="right">
</div>
<form name="graph3" id="graph3">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<input type="hidden" name="placeid" id="placeid" value="<?php echo $placeid; ?>" />
<input type="hidden" name="supervisor" id="supervisor" value="<?php echo $supervisor; ?>" />
<div align="center"  id="paraIDTop" style=" visibility:visible; overflow: auto;height: 55px;padding-left:3px" >
<br />

<b>&nbsp;&nbsp;&nbsp;&nbsp;Farmer</b> 
<select name="farmer" id="farmer" onChange="setIframeSource2(this.value);">
<option> Select Farmer </option>
<?php 
           include "config.php"; 
		   $query1 = "SELECT distinct(name) FROM broiler_farmers WHERE place = '$placeid' AND rsupervisor = '$supervisor' ORDER BY name ASC";
		   $result1 = mysql_query($query1,$conn1);
		   while($row1 = mysql_fetch_assoc($result1))
		   { 
?>
<option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
</select>
</div>
</form>
<iframe id="myIframe3" name="myIframe3" allowtransparency="true" src="dummy.html" width="100%" height="350" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</body>

<script type="text/javascript">
function setIframeSource2(s) {

             if(document.getElementById('farmer').selectedIndex == 0)
			 {
                 alert("please select a farmer");
				 document.getElementById('farmer').focus();
				 document.getElementById('farmer').selectedIndex = 0;
			  }
			  else
			   {
			    //document.getElementById('1').style.visibility = "visible";
                var theIframe = document.getElementById('myIframe3');
                var placeid = document.getElementById('placeid').value;
				var id = document.getElementById('id').value;
                var supervisor = document.getElementById('supervisor').value;
				var farmer = document.getElementById('farmer').value;
				var theUrl;
				theUrl = "graph4.php?id=";
                theIframe.src = theUrl + id +"&placeid=" + placeid + "&supervisor=" + supervisor + "&farmer=" + farmer;
			   }
			}
</script>

</html>

