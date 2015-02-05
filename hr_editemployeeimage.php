 <?php
       include "config.php";
       $query1 = "SELECT * from hr_employee where employeeid = '$_GET[id]' ORDER BY id ASC ";
       $result1 = mysql_query($query1,$conn);
       while($row1 = mysql_fetch_assoc($result1))
       {
          $image = $row1['image'];
       }
 ?> 

<html>
<head>
<title></title>
	<style type="text/css">
	
	#ad{
		padding-top:220px;
		padding-left:10px;
	}
    body{	margin-left: 0px;
	margin-top: 0px;
      margin-bottom: 0px; }
	</style>
<style type="text/css">
fieldset { -moz-border-radius: 8px; width : 500px; border-radius: px; }
</style>
      <link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

</head>
<body bgcolor="#ECF1F5" >
<center>
<br />
<form method="post" enctype="multipart/form-data" action="hr_updateemployeeimage.php">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
<h1>Employee Image<?php echo $image; ?></h1>
<br />
<img src="employeeimages/reduced/<?php echo $image; ?>" />
<br />
<h4>Upload New Image</h4>
<td colspan="2"><input type="hidden" name="MAX_FILE_SIZE" value="100000000000" /> Image to upload&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input name="uploadedfile" type="file" width="15px" size="10"/></td>
<br /><br />
<br /><input type="submit" value="Update" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_employee';">
</form>
</center>
<script type="text/javascript">
function script1() {
window.open('HRHELP/help_m_editimage.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>
</body>
</html>
