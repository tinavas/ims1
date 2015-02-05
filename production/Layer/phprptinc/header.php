<!DOCTYPE html>
<html>
<head>
	<title></title>
<?php if (@$sExport == "" || @$sExport == "html") { ?>
<link href="phprptcss/project9.css" rel="stylesheet" type="text/css">
<?php } ?>
<meta name="generator" content="PHP Report Maker v3.0.0.1" />
	<link rel="stylesheet" href="../../js/base/jquery-ui-1.8.6.custom.css">
	<script type="text/javascript" src="../../js/jquery-1.4.2.min.js"></script>
	<script src="../../js/jquery.ui.core.js"></script>
	<script src="../../js/jquery.ui.datepicker.js"></script>
	<script  type="text/javascript" src="../../js/jquery.datepick/jquery.datepick.min.js"></script>
	
<script type="text/javascript">
		$(document).ready(function()
		{
	            $(function() {
		           $( ".datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true,
					numberOfMonths: 1,
				    dateFormat: '<?php echo $_SESSION['datejava']; ?>'
				   });
	            });
		});
</script>
<script type="text/javascript">
	entree = new Date;
	entree = entree.getTime();
function calculateloadgingtime()
	{
	   if(sec==0&&msec==0) {document.getElementById("time").innerHTML=""; return; }
		fin = new Date;
		fin = fin.getTime();
		php_time=(msec*1000)+(sec*1000);
		var secondes = (fin-entree+php_time)/1000;
		secondes=Math.round(secondes*1000)/1000;
		<?php if(@$sExport == "") { ?>
		document.getElementById("loadingpage").innerHTML = "(Loaded in " + secondes + " second(s).)"; 
		document.getElementById("time").innerHTML="";
		<?php } else { ?>
		document.getElementById("time").innerHTML="";
		<?php } ?>
		window.status='Page Loaded in ' + secondes + ' second(s).';
	}
window.onload = calculateloadgingtime;
</script>

<style>
body { font-size:85%; }
</style>
</head>
<body>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_IMAGES_FOLDER = "phprptimages";
</script>
<script src="phprptjs/x.js" type="text/javascript"></script>
<div class="ewLayout">

	<table cellspacing="0" class="ewContentTable">
		<tr>	

			<td class="ewContentColumn">
<?php } ?>

