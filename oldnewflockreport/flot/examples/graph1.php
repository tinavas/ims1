<?php
$id = $_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>B.I.M.S</title>
   <link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

<script src="sorttable.js" type="text/javascript"></script>
<style type="text/css">
body{font-family:"Lucida Sans Unicode", "Lucida Grande", Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#555555;}
div.main{margin:30px auto; overflow:auto; width:700px;height:175px}
table.sortable{border:0; padding:0; margin:0;}
table.sortable td{padding:4px; width:120px; border-bottom:solid 1px #DEDEDE;}
table.sortable th{padding:4px;}
table.sortable thead{background:#e3edef; color:#333333; text-align:left;}
table.sortable tfoot{font-weight:bold; }
table.sortable tfoot td{border:none;}
</style>
</head>

<body>
<center>
<?php if($id == "fcrbodyweightgraph") { ?>
<h3>F.C.R & Body Weight</h3>
<?php } if($id == "mortalityaverageweightgraph") { ?>
<h3>Mortality & Average Weight </h3>
<?php } if($id == "mortalityperaverageweightgraph") { ?>
<h3>Broiler Daily Entry for </h3>
<?php } ?>
</center>
<br /><br />

<center>
<form name="graph1" id="graph1">
<input type="hidden" name="id" id="id" value=<?php echo $id; ?> />
<b>Supervisor</b> &nbsp;&nbsp;
<select name="supervisor" id="supervisor" onchange="setIframeSource(this.value);">
<option> Select Supervisor </option>
<?php      echo "TEST";
           include "config.php"; 
           $query = "SELECT distinct(rsupervisor) FROM broiler_farmers ORDER BY rsupervisor ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['rsupervisor']; ?>"><?php echo $row1['rsupervisor']; ?></option>
<?php } ?>
</select>
</form>
 </center>
<iframe id="myIframe1" name="myIframe1" allowtransparency="true" src="dummy.html" scrolling="no" width="100%" height="350" frameborder="0" marginheight="0" marginwidth="0"></iframe>

</body>

<script type="text/javascript">
function setIframeSource(p) {
             if(document.getElementById('supervisor').selectedIndex == 0)
			 {
                 alert("please select a supervisor");
				 document.getElementById('supervisor').focus();
				 document.getElementById('supervisor').selectedIndex = 0;
			  }
			  else
			   {
                var theIframe = document.getElementById('myIframe1');
                var supervisor = document.getElementById('supervisor').value;
				var id = document.getElementById('id').value;
				var theUrl;
				theUrl = "graph2.php?id=";
                theIframe.src = theUrl + id + "&supervisor=" + supervisor;
			   }
			}
</script>
</script>









&nbsp;&nbsp;
<!--
<b>Supervisor</b> &nbsp;&nbsp;
<select name="supervisor" id="supervisor" tabindex="1" onchange="test();">
<option> Select Supervisor </option>
<?php
           include "../config.php"; 
           $query = "SELECT * FROM tbl_supervisiors ORDER BY UserName ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php #echo $row1['UserId']; ?>"><?php #echo $row1['UserName']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;
<b>Farmer</b> &nbsp;&nbsp;
<select name="farmer" id="farmer" tabindex="1">
<option> Select Farmer </option>
<?php
           include "../config.php"; 
           $query = "SELECT * FROM broiler_farmers ORDER BY Farm_Name ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php #echo $row1['Farm_Id']; ?>"><?php #echo $row1['Farm_Name']; ?></option>
<?php } ?>
</select>
<br />
<br />
<br />
&nbsp;&nbsp;
<input type="submit" value="Graph" onclick="return validate();"/>
</form>
-->
&nbsp;&nbsp; 

</html>


