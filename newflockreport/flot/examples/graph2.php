<?php
$id = $_GET['id'];
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
<form name="graph2" id="graph2">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<input type="hidden" name="supervisor" id="supervisor" value="<?php echo $supervisor; ?>" />
<div align="center"  id="paraIDTop" style=" visibility:visible; overflow: auto;height: 45px;padding-left:3px" >
<br />

<b>Place</b> 
<select name="place" id="place" style="width:160px" onChange="setIframeSource1(this.value);">
<option> Select Place </option>
<?php 
           include "config.php"; 
		   $query1 = "SELECT distinct(place) FROM broiler_farmers WHERE rsupervisor = '$supervisor'";
		   $result1 = mysql_query($query1,$conn1);
		   while($row1 = mysql_fetch_assoc($result1))
		   { 
?>
<option value="<?php echo $row1['place']; ?>"><?php echo $row1['place']; ?></option>
<?php } ?>
</select>
</div>
</form>
<iframe id="myIframe2" name="myIframe2" allowtransparency="true" src="dummy.html" scrolling="no" width="100%" height="350" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</body>

<script type="text/javascript">
function setIframeSource1(s) {

             if(document.getElementById('place').selectedIndex == 0)
			 {
                 alert("please select a place");
				 document.getElementById('place').focus();
				 document.getElementById('place').selectedIndex = 0;
			  }
			  else
			   {
			    //document.getElementById('1').style.visibility = "visible";
                var theIframe = document.getElementById('myIframe2');
                var placeid = document.getElementById('place').value;
				var id = document.getElementById('id').value;
                var supervisor = document.getElementById('supervisor').value;
				var theUrl;
				theUrl = "graph3.php?id=";
                theIframe.src = theUrl + id +"&placeid=" + placeid + "&supervisor=" + supervisor;
			   }
			}
</script>

</html>
