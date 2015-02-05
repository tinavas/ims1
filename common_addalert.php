<?php include "jquery.php"; ?>



<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:500px" id="complex_form" method="post" action="common_savealert.php" >
	  <h1 id="title1">Alerts</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>




<fieldset style="width:600px">
<legend>Details</legend>
<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>
     <tr>
  <th style="" style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Type</strong></th>
        <th width="10px"></th>
		
        <th style="" style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item</strong></th>
        <th width="10px"></th>
	 
<th style="" style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Description</strong></th>
        <th width="10px"></th>

		
		 <th style="" style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Units</strong></th>
        <th width="10px"></th>
  
        <th style="" style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Min Qty.</strong></th>
        <th width="10px"></th>

        <th style="" style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;Max Qty.</strong></th>
        <th width="10px"></th>



     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       <td style="text-align:left;">
         <select name="cat[]" id="cat@0" style="width:108px;" onchange="getcode(this.id);">
           <option>-Select-</option>
           <?php
              include "config.php"; 
           $query = "SELECT distinct(type) FROM ims_itemtypes ORDER BY type ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <option value="<?php echo $row['type'];?>"><?php echo $row['type']; ?></option>
     <?php } ?>
       </td>
       <td width="10px">&nbsp;</td>
	   
	   <td style="text-align:left;">
         <select name="item[]" id="item@0" style="width:108px;" onchange="getdesc(this.id);">
           <option>-Select-</option>
          
         </select>
       </td>
<td width="10px">&nbsp;</td>
	   
	   <td style="text-align:left;">
         <select name="desc[]" id="desc@0" style="width:108px;" onchange="getitem(this.id);">
           <option>-Select-</option>
          
         </select>
       </td>


       <td width="10px">&nbsp;</td>
	   
	   <td style="text-align:left;" id="unittd0">
         <input type="text" name="unit[]" id="unit0" value="" size="12" /> 
       </td>
       <td width="10px">&nbsp;</td>

       <td style="text-align:left;" id="unittd0">
         <input type="text" name="minqty[]" id="minqty0" value="" size="12" onfocus="makeform();"/> 
       </td>
       <td width="10px">&nbsp;</td>

       <td style="text-align:left;" id="unittd0">
         <input type="text" name="maxqty[]" id="maxqty0" value="" size="12" /> 
       </td>
       <td width="10px"></td>


    </tr>

 
</table>
</fieldset>








<table>
<tr height="30px"><td></td></tr>
<tr><td>
 <input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=common_alert';">
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


 myselect1 = document.createElement("select");
  myselect1.style.width = "108px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "cat[]";
  myselect1.id = "cat@" + index;
  myselect1.onchange = function () { getcode(this.id); };
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['type']; ?>");
		theOption.appendChild(theText);
            
		theOption.value = "<?php echo $row1['type']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba0 = document.createElement('td');
  ba0.style.textAlign = "left";
  ba0.appendChild(myselect1);
  var b0 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b0.appendChild(myspace2);


 
  myselect1 = document.createElement("select");
  myselect1.style.width = "108px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "item[]";
  myselect1.id = "item@" + index;
   myselect1.onchange = function () { getdesc(this.id); };
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['code']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba1 = document.createElement('td');
  ba1.style.textAlign = "left";
  ba1.appendChild(myselect1);
  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);
  myselect2 = document.createElement("select");
  myselect2.style.width = "108px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect2.appendChild(theOption1);
  myselect2.name = "desc[]";
  myselect2.id = "desc@" + index;
   myselect2.onchange = function () { getitem(this.id); };
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes ORDER BY description ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['description']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['code']; ?>";
		theOption.value = "<?php echo $row1['description']; ?>";
		myselect2.appendChild(theOption);
		
  <?php } ?>
  var ba6 = document.createElement('td');
  ba6.style.textAlign = "left";
  ba6.appendChild(myselect2);
  var b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b6.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="12";
  mybox1.type="text";
  mybox1.name="unit[]";
  mybox1.id="unit" +  index;
  var ba4 = document.createElement('td');
  ba4.style.textAlign = "left";
  //ba4.id = "unit" + index;
  ba4.appendChild(mybox1);

  var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="12";
  mybox1.type="text";
  mybox1.name="minqty[]";
  mybox1.onfocus = function() { makeform(); };
  mybox1.id="minqty" +  index;
  var ba2 = document.createElement('td');
  ba2.style.textAlign = "left";
  ba2.id = "minqty" + index;
  ba2.appendChild(mybox1);

  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="12";
  mybox1.type="text";
  mybox1.name="maxqty[]";
  mybox1.id="maxqty" +  index;
  var ba3 = document.createElement('td');
  ba3.style.textAlign = "left";
  ba3.id = "maxqty" + index;
  ba3.appendChild(mybox1);

  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);



  

      r1.appendChild(ba0);
	  r1.appendChild(b0);
      r1.appendChild(ba1);
      r1.appendChild(b1);
r1.appendChild(ba6);
      
r1.appendChild(b6);

	  r1.appendChild(ba4);
	  r1.appendChild(b4);
      r1.appendChild(ba2);
      r1.appendChild(b2);
      r1.appendChild(ba3);
      r1.appendChild(b3);
      t1.appendChild(r1);

}
function getdesc(code)
{
	var code1 = document.getElementById(code).value;
	temp = code.split("@");
	var index1 = temp[1];
	  var type = document.getElementById("cat@" + index1).value;
	  //alert(type);
     /* if(type == "Ingredients")
	  {
	  //alert('unit' + index1);
	  document.getElementById('unit' + index1).value = "Tonnes";
	  }
	  else*/
	  {
	<?php 
			$q = "select distinct(code) from ims_itemcodes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
								document.getElementById('desc@' + index1).value = "<?php echo $q1r['description'];?>";

				document.getElementById('unit' + index1).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}
	?>
	}
	//alert(index);
/*works if you dnt want to repeat the itemcode
	for(var i = -1; i <= index; i++)
		for(var j = -1; j <= index; j++)
			if( i != j )
				if(document.getElementById('code@' + i).value == document.getElementById('code@' + j).value)
				{
				alert("Please select distinct codes");
				document.getElementById('description@' + j).value = "";
				document.getElementById('units@' + j).value = "";
				return;
				}
*/
}


function getitem(code)
{
	var code1 = document.getElementById(code).value;
	temp = code.split("@");
	var index1 = temp[1];
	  var type = document.getElementById("cat@" + index1).value;
    /*  if(type == "Ingredients")
	  {
	  //alert('unit' + index1);
	  document.getElementById('unit' + index1).value = "Tonnes";
	  }
	  else */
	  {
	<?php 
			$q = "select distinct(description) from ims_itemcodes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[description]') {";
			$q1 = "select distinct(code),sunits from ims_itemcodes where description = '$qr[description]' order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('item@' + index1).value = "<?php echo $q1r['code'];?>";

				document.getElementById('unit' + index1).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}
	?>
	}
	//alert(index);
/*works if you dnt want to repeat the itemcode/////////
	for(var i = -1; i <= index1; i++)
{
		for(var j = -1; j <= index1; j++)
{
			if( i != j )
{
				if(document.getElementById('desc@' + i).value == document.getElementById('desc@' + j).value)
				{
				alert("Please select distinct codes");
				document.getElementById('item@' + j).value = "";
				document.getElementById('units@' + j).value = "";
				return;
				}
}
}
}*/

}


function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;
	
	<!--document.getElementById('flock@' + index1).style.display = "none";-->

	
	removeAllOptions(document.getElementById('item@' + index1));
			  var code = document.getElementById('item@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              code.appendChild(theOption1);
	removeAllOptions(document.getElementById('desc@' + index1));
			  var description = document.getElementById('desc@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);


	<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";
			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
            theOption1=document.createElement("OPTION");
            theText1=document.createTextNode("<?php echo $q1r['code'];?>");
            theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['code'];?>";
	        theOption1.title = "<?php echo $q1r['description'];?>";
            code.appendChild(theOption1);
	<?php
			}
			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
			
	?>
			theOption1=document.createElement("OPTION");
            theText1=document.createTextNode("<?php echo $q1r['description'];?>");
            theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['description'];?>";
	        theOption1.title = "<?php echo $q1r['code'];?>";
            description.appendChild(theOption1);


	<?php
			}
			echo "}";
			}
	?>

}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


</script>
<div class="clear"></div>
<br />
<script type="text/javascript">
function script1() {
window.open('Management Help/help_m_addalert.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
