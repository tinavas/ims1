<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
<link href="css/tp.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
		$(document).ready(function()
		{

	            $(function() {
		           $( ".datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true,
					numberOfMonths: 1,
				    dateFormat: 'dd.mm.yy'
				   });
				   $('.timepicker').timepicker({
					timeFormat: 'hh:mm'
				   });
	            });
		});
</script>
