<?php include "jquery.php"; ?>



<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:500px" id="complex_form" method="post" action="common_savewaterstd.php" >
	  <h1 id="title1">Drinking Water Standards</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>




<fieldset style="width:600px">
<legend>Details</legend>
<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>
     <tr>
 
        <th style="" style="text-align:left"><strong>Parameters</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><strong>Units</strong></th>
        <th width="10px"></th>

        <th style="" style="text-align:left"><strong>Max. Permissible Limit</strong></th>
        <th width="10px"></th>

     </tr>

     <tr style="height:20px"></tr>

   <tr>
 

       <td style="text-align:left;" id="unittd0">
         <input type="text" name="parameters[]" id="parameter0" value="" size="12" onfocus="makeform();"/> 
       </td>
       <td width="10px"></td>

       <td style="text-align:left;" id="unittd0">
         <input type="text" name="units[]" id="units0" value="" size="4" /> 
       </td>
       <td width="10px"></td>

       <td style="text-align:left;" id="unittd0">
         <input type="text" name="limit[]" id="limit0" value="" size="4" /> 
       </td>
       <td width="10px"></td>

    </tr>

 
</table>
</fieldset>








<table>
<tr height="30px"><td></td></tr>
<tr><td>
 <input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=common_waterstd';">
</td></tr>
</table>


              </center>
     </form>
  </div>
</section>
		


<div class="clear"></div>
<br />


<script type="text/javascript">
var index = 0;
function makeform()
{
  index = index + 1;
  var t1  = document.getElementById('inputs');
  var r1 = document.createElement('tr'); 


 


 

  mybox1=document.createElement("input");
  mybox1.size="12";
  mybox1.type="text";
  mybox1.name="parameters[]";
  mybox1.onfocus = function() { makeform(); };
  mybox1.id="parameters" +  index;
  var ba2 = document.createElement('td');
  ba2.style.textAlign = "left";
  ba2.id = "parameters" + index;
  ba2.appendChild(mybox1);

  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="4";
  mybox1.type="text";
  mybox1.name="units[]";
  mybox1.id="units" +  index;
  var ba3 = document.createElement('td');
  ba3.style.textAlign = "left";
  ba3.id = "units" + index;
  ba3.appendChild(mybox1);

  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="4";
  mybox1.type="text";
  mybox1.name="limit[]";
  mybox1.id="limit" +  index;
  var ba4 = document.createElement('td');
  ba4.style.textAlign = "left";
  ba4.id = "limit" + index;
  ba4.appendChild(mybox1);

  var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);




      r1.appendChild(ba2);
      r1.appendChild(b2);
      r1.appendChild(ba3);
      r1.appendChild(b3);
      r1.appendChild(ba4);
      r1.appendChild(b4);
      t1.appendChild(r1);

}


</script>

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
