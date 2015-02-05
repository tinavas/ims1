<?php include "jquery.php"; ?>



<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:500px" id="complex_form" method="post" action="common_savebagcapacity.php" >
	  <h1 id="title1">Feed Standards</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>




<fieldset style="width:600px">
<legend>Standard Value's</legend>
<table border="0px">
	<tr height="20px"><td></td></tr>
	<tr> 
        <th style="text-align:left"><strong>From Date</strong></th>
        <th width="10px"></th>
  
        <th style="text-align:left"><input type="text" size="15" id="date1" class="datepicker" name="date1" value="<?php echo date("d.m.Y"); ?>" onChange="datecomp();"></th>
        <th width="10px"></th>
 		<th width="10px"></th>
		<th width="10px"></th>
        <th style="text-align:left"><strong>To Date</strong></th>
        <th width="10px"></th>
        <th style="text-align:left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo date("d.m.Y"); ?>" onChange="datecomp();"></th>
        <th width="10px"></th>
     </tr>
</table>
<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>
     <tr>
 
        <th style="text-align:left"><strong>Bag Code</strong></th>
        <th width="10px"></th>
  
        <th style="text-align:left"><strong>Bag Description</strong></th>
        <th width="10px"></th>
 
        <th style="text-align:left"><strong>Weight</strong></th>
        <th width="10px"></th>
        <!--<th width="10px"></th>
        <th width="10px"></th>-->

        <th style="text-align:left"><strong>Capacity</strong></th>
        <th width="10px"></th>
        <th style="text-align:left"><strong>Units</strong></th>
        <th width="10px"></th>

     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       <td style="text-align:left;">
         <select name="bagcode[]" id="bagcode0" style="width:108px;" onchange="getDescription(this.id);" >
           <option id="select" value="select">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat LIKE '%Consumables%' ORDER BY code ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['description']; ?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['code']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;" id="nut0">
         <select name="bagdesc[]" id="bagdesc0" style="width:115px;" onchange="getCode(this.id);" >
           <option id="select" value="select">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat LIKE '%Consumables%' ORDER BY code ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option title="<?php echo $row1['code']; ?>" value="<?php echo $row1['description']; ?>"><?php echo $row1['description']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;" id="unittd0">
         <input type="text" name="weight[]" id="weight0" size="8" /> 
       </td>
<!--       <td width="10px"></td>
       <td width="10px"><img src="plus.png" title="Add New Nutrient" id="add0" alt="Add new Nutrient" onclick="newnut(this.id);" /></td>
-->       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="capacity[]" id="capacity0" size="8" onfocus="makeform();" /> 
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="units[]" id="units0" size="8" /> 
       </td>
       <td width="10px"></td>

    </tr>

 
</table>
</fieldset>








<table>
<tr height="30px"><td></td></tr>
<tr><td>
 <input type="submit" value="Save" id="save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="cancel();">
</td></tr>
</table>


              </center>
     </form>
  </div>
</section>
		


<div class="clear"></div>
<br />


<script type="text/javascript">
function cancel()
{
document.location = "dashboardsub.php?page=common_bagcapacity";
}
function datecomp()
{
var dd = document.getElementById('date1').value;
var temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
var temp1 = new Date(temp);

var dd1 = document.getElementById('date2').value;
var temp3 =  dd1.split('.');
temp3 = temp3[1] + '/' + temp3[0] + '/' + temp3[2];
var temp4 = new Date(temp3);

 

if(temp1 > temp4)
{
 alert('To date must be greater than or equal to From date');
 document.getElementById('save').disabled = true;
}
 

}
var index = 0;

function getDescription(c)
{
 var index1 = c.substr(7);


var a = index;
var i1,j1;
for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		
		i1=i;
		j1=j;
		
		if( i != j)
		{ 
			if(document.getElementById('bagcode' + i1).value == document.getElementById('bagcode' + j1).value)
			{
				
				document.getElementById('bagcode' + a).value = "select";
				document.getElementById('bagdesc' + a).value = "select";				
				alert("Please select different combination");
				return;
			}
		}
	}
}



 
 var codesel = document.getElementById(c).value; 
 document.getElementById("bagdesc"+index1).value = document.getElementById("bagcode"+index1).value;
<?php
           include "config.php"; 
           $query = "SELECT description,sunits FROM ims_itemcodes where cat = 'Consumables' ORDER BY code ASC ";
           $result = mysql_query($query,$conn) or die(mysql_error()); 
           while($row1 = mysql_fetch_assoc($result))
           {   
		    $desc = $row1['description'];
		    echo "if(codesel == '$desc') {";
			?>
			var temp = "units" + index1; 
			document.getElementById(temp).value = "<?php echo $row1['sunits']; ?>";
			<?php
			echo "}";
		   }
?>  

}
function getCode(c)
{


var a = index;
var i1,j1;
for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		i1=i;
		j1=j;
		if( i != j)
		{ 
			if(document.getElementById('bagdesc' + i1).value == document.getElementById('bagdesc' + j1).value)
			{
				
				document.getElementById('bagcode' + a).value = "select";
				document.getElementById('bagdesc' + a).value = "select";				
				alert("Please select different combination");
				return;
			}
		}
	}
}

 var index1 = c.substr(7);
  document.getElementById("bagcode"+index1).value = document.getElementById("bagdesc"+index1).value;
 var codesel = document.getElementById(c).value;
<?php
           include "config.php"; 
           $query = "SELECT description,sunits FROM ims_itemcodes where cat = 'Consumables' ORDER BY code ASC ";
           $result = mysql_query($query,$conn) or die(mysql_error()); 
           while($row1 = mysql_fetch_assoc($result))
           {   
		    $desc = $row1['description'];
		    echo "if(codesel == '$desc') {";
			?>
			var temp = "units" + index1;
			document.getElementById(temp).value = "<?php echo $row1['sunits']; ?>";
			<?php
			echo "}";
		   }
?> 
}

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
  myselect1.name = "bagcode[]";
  myselect1.onchange=function() { getDescription(this.id); };  
  myselect1.id = "bagcode" + index;
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat = 'Consumables' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['description']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba1 = document.createElement('td');
  ba1.appendChild(myselect1);
  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);



  myselect1 = document.createElement("select");
  myselect1.style.width = "115px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "bagdesc[]";
  myselect1.onchange=function() { getCode(this.id); };
  myselect1.id = "bagdesc" + index;
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat = 'Consumables' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['description']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['description']; ?>";
		theOption.title = "<?php echo $row1['code']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba2 = document.createElement('td');
  ba2.id = "nut" + index;
  ba2.appendChild(myselect1);
  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);




  mybox1=document.createElement("input");
  mybox1.size="8";
  mybox1.type="text";
  mybox1.name="weight[]";
  mybox1.id="weight" +  index;
  var ba3 = document.createElement('td');
  ba3.id = "weight" + index;
  ba3.appendChild(mybox1);

  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);

/*
  mybox1=document.createElement("img");
  mybox1.src = "plus.png";
  mybox1.onclick = function() { newnut(this.id); };
  mybox1.title = "Add New Nutrient";
  mybox1.alt = "Add New Nutrient";
  mybox1.id = "add" + index;
  var ba5 = document.createElement('td');
  ba5.appendChild(mybox1);

  var b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b5.appendChild(myspace2);
*/
  mybox1=document.createElement("input");
  mybox1.size="8";
  mybox1.type="text";
  mybox1.name="capacity[]";
  mybox1.id="capacity" +  index;
  mybox1.onfocus=function() { makeform(); };
  var ba4 = document.createElement('td');
  ba4.style.setAttribute('textAlign',"left");
  ba4.appendChild(mybox1);

  var b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b6.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="8";
  mybox1.type="text";
  mybox1.name="units[]";
  mybox1.id="units" +  index;
  var ba6 = document.createElement('td');
  ba6.style.setAttribute('textAlign',"left");
  ba6.appendChild(mybox1);


  var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);

  


      r1.appendChild(ba1);
      r1.appendChild(b1);
      r1.appendChild(ba2);
      r1.appendChild(b2);
      r1.appendChild(ba3);
      r1.appendChild(b3);
      r1.appendChild(ba4);
      r1.appendChild(b6);
      r1.appendChild(ba6);
      r1.appendChild(b4);
	  t1.appendChild(r1);

}


function newnut(a)
{
  var c = a.substr(3);
  document.getElementById("nut" + c).innerHTML = "<input type='text' size='15' id='newnutrient' name='nutrient[]' />";
  document.getElementById("unittd" + c).innerHTML = "<input type='text' size='8' id='newunit' name='unit[]' />";
}

function getunitdetails(a,b)
{
  var c = a.substr(8);
  var val = b.split("@");
  val = val[1];
  document.getElementById("unit" + c).value = val;
}
</script>

<script type="text/javascript">
function script1() {
window.open('FeedmillHelp/help_m_addfeedstandards.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
