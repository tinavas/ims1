<?php include "jquery.php"; ?>



<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" enctype="multipart/form-data" id="complex_form" method="post" action="common_savediseases.php" >
	  <h1 id="title1">Diseases Details</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>




<fieldset style="width:600px">
<legend>Details</legend>
<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>

     <tr>
 
        <th style="" style="text-align:left"><strong>Disease Code</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><input type="text" name="code" /></th>
        <th width="10px"></th>

     </tr>
     <tr style="height:10px"></tr>
     <tr>
 
        <th style="" style="text-align:left"><strong>Disease Name</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><input type="text" name="name" size="30" /></th>
        <th width="10px"></th>

     </tr>
     <tr style="height:10px"></tr>

     <tr>
 
        <th style="" style="text-align:left"><strong>Symptoms</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><textarea cols="40" rows="5" name="symptoms" ></textarea></th>
        <th width="10px"></th>

     </tr>
     <tr style="height:10px"></tr>

     <tr>
 
        <th style="" style="text-align:left"><strong>Diagnosis</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><textarea cols="40" rows="5" name="diagnosis"></textarea></th>
        <th width="10px"></th>

     </tr>
     <tr style="height:10px"></tr>

     <tr>
 
        <th style="" style="text-align:left"><strong>Treatment</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><textarea cols="40" rows="5" name="treatment" ></textarea></th>
        <th width="10px"></th>

     </tr>
     <tr style="height:10px"></tr>

      <tr>
 
        <th style="" style="text-align:left"><strong>Images</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><input type="hidden" name="MAX_FILE_SIZE" value="100000000000" /><input name="uploadedfile" type="file" /></th>
        <th width="10px"></th>

     </tr>
     <tr style="height:20px"></tr>

</table>
</fieldset>








<table>
<tr height="30px"><td></td></tr>
<tr><td>
 <input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=common_diseases';">
</td></tr>
</table>


              </center>
     </form>
  </div>
</section>
		


<div class="clear"></div>
<br />



<script type="text/javascript">
function script1() {
window.open('FeedHelp/help_addnutrientstandards.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="">Help</a>
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
