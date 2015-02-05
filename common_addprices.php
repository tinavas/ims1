<?php include "jquery.php"; ?>



<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:500px" id="complex_form" method="post" action="common_saveprices.php" >
	  <h1 id="title1">Hatch Egg / Bird Prices</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>




<fieldset style="width:600px">
<legend>Details</legend>
<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>
     <tr>
 
        <th style="" style="text-align:left"><strong>Date</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><strong>Type</strong></th>
        <th width="10px"></th>
 
        <th style="" style="text-align:left"><strong>Location</strong></th>
        <th width="10px"></th>

        <th style="" style="text-align:left"><strong>Rate</strong></th>
        <th width="10px"></th>

        <th style="" style="text-align:left"><strong>Unit</strong></th>
        <th width="10px"></th>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
       <td style="text-align:left;" id="unittd0">
         <input type="text" readonly style="background:none;border:0px" name="date[]" id="date0" value="<?php echo date("d.m.o"); ?>" size="12" /> 
       </td>
       <td width="10px"></td>


       <td style="text-align:left;">
         <select name="type[]" id="type0" style="width:140px;">
           <option>-Select-</option>
           <option value="Hatch Egg">Hatch Egg</option>
           <option value="Breeder Female Birds">Breeder Female Birds</option>
           <option value="Breeder Male Birds">Breeder Male Birds</option>
           <option value="Breeder Chick">Breeder Chick</option>
           <option value="Broiler Chick">Broiler Chick</option>
           <option value="Broiler Birds">Broiler Birds</option>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;" id="nut0">
         <select name="location[]" id="location0" style="width:108px;" onchange="makeform();">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM common_locations ORDER BY location ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['location']; ?>" ><?php echo $row1['location']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;" id="unittd0">
         <input type="text" name="price[]" id="price0" value="" size="3" /> 
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <select name="unit[]" id="unit0" style="width:108px;">
           <option>-Select-</option>
           <option value="100 Eggs">100 Eggs</option>
           <option value="Per Bird">Per Bird</option>
           <option value="Per Kg">Per Kg</option>
         </select>
       </td>
       <td width="10px"></td>
    </tr>

 
</table>
</fieldset>








<table>
<tr height="30px"><td></td></tr>
<tr><td>
 <input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=common_prices';">
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
  mybox1.name="date[]";
  mybox1.style.border="0px";
  mybox1.style.background="none";
  mybox1.readonly="true";
  mybox1.value = "<?php echo date("d.m.o"); ?>";
  mybox1.id="date" +  index;
  var ba1 = document.createElement('td');
  ba1.id = "date" + index;
  ba1.appendChild(mybox1);

  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);
 


  myselect1 = document.createElement("select");
  myselect1.style.width = "140px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "type[]";
  myselect1.id = "type" + index;

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("Hatch Egg");
		theOption.appendChild(theText);
		theOption.value = "Hatch Egg";
		myselect1.appendChild(theOption);
		
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("Breeder Female Birds");
		theOption.appendChild(theText);
		theOption.value = "Breeder Female Birds";
		myselect1.appendChild(theOption);

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("Breeder Male Birds");
		theOption.appendChild(theText);
		theOption.value = "Breeder Male Birds";
		myselect1.appendChild(theOption);

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("Broiler Birds");
		theOption.appendChild(theText);
		theOption.value = "Broiler Birds";
		myselect1.appendChild(theOption);


  var ba2 = document.createElement('td');
  ba2.appendChild(myselect1);
  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);





  myselect1 = document.createElement("select");
  myselect1.style.width = "108px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "location[]";
  myselect1.onchange=function() { makeform(); };
  myselect1.id = "location" + index;
  <?php
           include "config.php"; 
           $query = "SELECT * FROM common_locations ORDER BY location ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['location']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['location']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba3 = document.createElement('td');
  ba3.id = "location" + index;
  ba3.appendChild(myselect1);
  var b3 = document.createElement('td');
  myspace3= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="price[]";
  mybox1.id="price" +  index;
  var ba4 = document.createElement('td');
  ba4.id = "date" + index;
  ba4.appendChild(mybox1);

  var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);

  

  myselect1 = document.createElement("select");
  myselect1.style.width = "108px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "unit[]";
  myselect1.id = "unit" + index;

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("100 Eggs");
		theOption.appendChild(theText);
		theOption.value = "100 Eggs";
		myselect1.appendChild(theOption);
		
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("Per Bird");
		theOption.appendChild(theText);
		theOption.value = "Per Bird";
		myselect1.appendChild(theOption);

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("Per Kg");
		theOption.appendChild(theText);
		theOption.value = "Per Kg";
		myselect1.appendChild(theOption);


  var ba5 = document.createElement('td');
  ba5.appendChild(myselect1);
  var b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b5.appendChild(myspace2);


      r1.appendChild(ba1);
      r1.appendChild(b1);
      r1.appendChild(ba2);
      r1.appendChild(b2);
      r1.appendChild(ba3);
      r1.appendChild(b3);
      r1.appendChild(ba4);
      r1.appendChild(b4);
      r1.appendChild(ba5);
      r1.appendChild(b5);

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
