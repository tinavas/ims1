<!DOCTYPE html>
	<link rel="stylesheet" href="../js/base/jquery-ui-1.8.6.custom.css">
	<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script src="../js/jquery.ui.core.js"></script>
	<script src="../js/jquery.ui.datepicker.js"></script>
	<script  type="text/javascript" src="../js/jquery.datepick/jquery.datepick.min.js"></script>
	
<script type="text/javascript">
		$(document).ready(function()
		{
	            $(function() {
		           $( ".datepicker" ).datepicker();
	            });
		});
</script>

<input type="text" class="datepicker" id="date1" name="date1" value="<?php echo date("d.m.Y"); ?>" />