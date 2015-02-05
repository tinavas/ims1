<?php
 $id = $_GET['id'];
 $placeid = $_GET['placeid'];
 $supervisor = $_GET['supervisor'];
 $farmer = $_GET['farmer'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>B.I.M.S</title>
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
<form name="graph4" id="graph4" method="get" >
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<input type="hidden" name="placeid" id="placeid" value="<?php echo $placeid; ?>" />
<input type="hidden" name="supervisor" id="supervisor" value="<?php echo $supervisor; ?>" />
<input type="hidden" name="farmer" id="farmer" value="<?php echo $farmer; ?>" />
<div align="center"  id="paraIDTop" style=" visibility:visible; overflow: auto;height: 75px;padding-left:3px" >
<br />

<b>&nbsp;&nbsp;&nbsp;&nbsp;Flock</b> 
<select name="flock" id="flock" >
<option> Select Flock </option>
<?php 
           include "config.php"; 
              $query2 = "SELECT distinct(flock) FROM broiler_daily_entry WHERE place = '$placeid' AND supervisior = '$supervisor' AND farm = '$farmer' ORDER BY flock ASC ";
              $result2 = mysql_query($query2,$conn1); 
              while($row2 = mysql_fetch_assoc($result2))
               {
?>
<option value="<?php echo $row2['flock']; ?>"><?php echo $row2['flock']; ?></option>
<?php }  ?>
</select>
<input type="submit" value="Report" onclick="return validate();" />
</div>
</form>
</body>
<script type="text/javascript">
function validate()
{
 if(document.getElementById('flock').selectedIndex == 0)
 {
  alert("please select a flock");
  document.getElementById('flock').focus();
  return false;
 }
 else
 {
  var placeid = document.getElementById('placeid').value;
  var supervisor = document.getElementById('supervisor').value;
  var farmer = document.getElementById('farmer').value;
  var flock = document.getElementById('flock').value;
  //top.location='<?php echo $_GET['id'].".php"; ?>?flock='+ document.getElementById('flock').value;
  window.open('<?php echo $_GET['id'].".php"; ?>?flock=' + flock + "&placeid=" + placeid + "&supervisor=" + supervisor + "&farmer=" + farmer);
   return true;
 }
}
</script>


</html>

