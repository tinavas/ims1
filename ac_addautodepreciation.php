<?php include "timepicker.php"; ?>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" name="form" style="min-height:600px" id="complex_form" method="post" action="ac_saveautodepreciation2.php" >
	  <h1 id="title1">Depreciation</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/>
<table align="center">
<tr>
<td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<input type="text" class="datepicker" value="<?php echo date("d.m.Y"); ?>" name="date" id="date" size="12">
</td>
</tr>
</table><br />
<br />

<br><br>
<input type="submit" value="Depreciate" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=ac_autodepreciation'" />
</form>

	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->


</body>
</html>
