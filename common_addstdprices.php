<?php include "jquery.php"; ?>



<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:500px" id="complex_form" method="post" action="common_savestdprices.php" >
	  <h1 id="title1">Standard Prices</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>




<fieldset style="width:600px">
<legend>Details</legend>
<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>
     <tr>
 
        <th  style="text-align:left"><strong>Type</strong></th>
        <th width="10px"></th>
  
        <th  style="text-align:left"><strong>Code</strong></th>
        <th width="10px"></th>
 
        <th  style="text-align:left"><strong>Description</strong></th>
        <th width="10px"></th>
		
		<th  style="text-align:left"><strong>From Week</strong></th>
        <th width="10px"></th>

        <th  style="text-align:left"><strong>To Week</strong></th>
        <th width="10px"></th>

        <!--<th  style="text-align:left"><strong>From Date</strong></th>
        <th width="10px"></th>

        <th  style="text-align:left"><strong>To Date</strong></th>
        <th width="10px"></th>-->
		
		<th  style="text-align:left"><strong>Std Price</strong></th>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
       
     


       <td style="text-align:left;"><select name="type[]" id="type@0" style="width:108px;" onchange="getcode(this.id);">
         <option>-Select-</option>
              <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
         <option value="<?php echo $row1['type']; ?>" ><?php echo $row1['type']; ?></option>
         <?php } ?>
       </select></td>
       <td width="10px"></td>

       <td style="text-align:left;" id="nut0">
         <select name="code[]" id="code@0" style="width:108px;" onchange="selectdesc(this.id);">
           <option>-Select-</option>
           </select>       </td>
       <td width="10px"></td>

       <td style="text-align:left;" id="description0">
	      <select name="description[]" id="description@0" style="width:178px;" onchange="selectcode(this.id);">
           <option>-Select-</option>
           </select>    </td>
       
	   
	     <?php /*?><td width="10px"></td>
	   <td style="text-align:left;" id="unitmd0">
         <input type="text" readonly style="background:none;border:0px" name="date[]" id="date@0" value="<?php echo date("d.m.o"); ?>" size="12" />       </td>
	     <td width="10px"></td>
	   <td style="text-align:left;" id="unittd0">
         <input type="text" readonly style="background:none;border:0px" name="tdate[]" id="tdate@0" value="<?php echo date("d.m.o"); ?>" size="12" />       </td><?php */?>
		 
		 <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="fweek[]" id="fweek@0" value="0" size="5" onkeyup="checkgreat(this.id);" />       </td>
		 
		 <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="tweek[]" id="tweek@0" value="0" size="5" onkeyup="checkgreat(this.id);"/>       </td>
		 
		 
		 <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="price[]" id="price@0" value="" size="3" onfocus="makeform();"  />       </td>
		 
    </tr>
</table>
</fieldset>








<table>
<tr height="30px"><td></td></tr>
<tr><td>
 <input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=common_stdprice';">
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
var index1 = -1;
function makeform()
{
index1 = index-1;
  if((index == 0) || ((index>0) && (document.getElementById('price@'+index1).value != "")))
  {
  index = index + 1;
  var t1  = document.getElementById('inputs');
  var r1 = document.createElement('tr'); 


 

 /* mybox1=document.createElement("input");
  mybox1.size="12";
  mybox1.type="text";
  mybox1.name="date[]";
  mybox1.style.border="0px";
  mybox1.style.background="none";
  mybox1.readonly="true";
  mybox1.value = "<?php echo date("d.m.o"); ?>";
  mybox1.id="date@" +  index;
  var ba1 = document.createElement('td');
  //ba1.id = "date@" + index;
  ba1.appendChild(mybox1);

  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);
  
  mybox1=document.createElement("input");
  mybox1.size="12";
  mybox1.type="text";
  mybox1.name="tdate[]";
  mybox1.style.border="0px";
  mybox1.style.background="none";
  mybox1.readonly="true";
  mybox1.value = "<?php echo date("d.m.o"); ?>";
  mybox1.id="tdate@" +  index;
  var ba11 = document.createElement('td');
  //ba11.id = "tdate@" + index;
  ba11.appendChild(mybox1);

  var b11 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b11.appendChild(myspace2);*/
 


  myselect1 = document.createElement("select");
  myselect1.style.width = "108px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "type[]";
  myselect1.id = "type@" + index;
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
  myselect1.name = "code[]";
  myselect1.onchange=function() { selectdesc(this.id); };
  myselect1.id = "code@" + index;
  
  var ba3 = document.createElement('td');
  //ba3.id = "code@" + index;
  ba3.appendChild(myselect1);
  var b3 = document.createElement('td');
  myspace3= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);
  
  
    myselect1 = document.createElement("select");
  myselect1.style.width = "178px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "description[]";
  myselect1.onchange=function() { selectcode(this.id); };
  myselect1.id = "description@" + index;
  
  var ba4 = document.createElement('td');
  //ba4.id = "description@" + index;
  ba4.appendChild(myselect1);
  var b4 = document.createElement('td');
  myspace4= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);


 
  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="price[]";
  mybox1.id="price@" +  index;
  mybox1.onfocus = function () { makeform(); };
  var ba5 = document.createElement('td');
  //ba5.id = "price@" + index;
  ba5.appendChild(mybox1);

  var b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b5.appendChild(myspace2);
  
   mybox1=document.createElement("input");
  mybox1.size="5";
  mybox1.type="text";
  mybox1.name="fweek[]";
  mybox1.value = "0";
  mybox1.id="fweek@" +  index;
  mybox1.onkeyup = function () { checkgreat(this.id); };
  var ba6 = document.createElement('td');
  //ba5.id = "price@" + index;
  ba6.appendChild(mybox1);

  var b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b6.appendChild(myspace2);
  
   mybox1=document.createElement("input");
  mybox1.size="5";
  mybox1.type="text";
  mybox1.name="tweek[]";
  mybox1.value = "0";
  mybox1.id="tweek@" +  index;
  mybox1.onkeyup = function () { checkgreat(this.id); };
  var ba7 = document.createElement('td');
  //ba5.id = "price@" + index;
  ba7.appendChild(mybox1);

  var b7 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b7.appendChild(myspace2);

      r1.appendChild(ba2);
      r1.appendChild(b2);
      r1.appendChild(ba3);
      r1.appendChild(b3);
      r1.appendChild(ba4);
      r1.appendChild(b4);
      /*r1.appendChild(ba1);
      r1.appendChild(b1);
      r1.appendChild(ba11);
      r1.appendChild(b11);*/
	  r1.appendChild(ba6);
      r1.appendChild(b6);
      r1.appendChild(ba7);
      r1.appendChild(b7);
      r1.appendChild(ba5);
      r1.appendChild(b5);

      t1.appendChild(r1);
	  }

}

function checkgreat(wkid)
{
var twk = wkid.split("@");
var twkindex = twk[1];
var fwk=document.getElementById("fweek@" + twkindex).value;
var twk=document.getElementById("tweek@" + twkindex).value;
if((fwk > twk) && (twk >0))
{
alert("To Week should be greater than From Week");
document.getElementById("tweek@" + twkindex).focus()
}
}

function selectdesc(codeid)
{


var temp = codeid.split("@");
var tempindex = temp[1];
var item2=document.getElementById("type@" + tempindex).value;
var item1 = document.getElementById(codeid).value;
 //alert(t);
removeAllOptions(document.getElementById("description@" + tempindex));
myselect1 = document.getElementById("description@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "description[]";
//myselect1.style.width = "170px";
<?php 
	     $query1 = "SELECT code,description,cat FROM ims_itemcodes where iusage = 'Sale' or iusage = 'Produced or Sale' ORDER BY code ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   ?>
     	 <?php echo "if(item2 == '$row1[cat]') {"; ?>
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.value = "<?php echo $row1['description']; ?>";
theOption1.title = "<?php echo $row1['code']; ?>";


<?php echo "if(item1 == '$row1[code]') {"; ?>			
theOption1.selected = true;
<?php echo "}"; ?>

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>
}


function selectcode(codeid)
{

var temp = codeid.split("@");
var tempindex = temp[1];
var item2 = document.getElementById("type@" + tempindex).value;
var item1 = document.getElementById(codeid).value;
removeAllOptions(document.getElementById("code@" + tempindex));
myselect1 = document.getElementById("code@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "code[]";
//myselect1.style.width = "75px";
<?php 
	     $query1 = "SELECT code,description,cat,sunits FROM ims_itemcodes where iusage = 'Sale' or iusage = 'Produced or Sale' ORDER BY code ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   ?>
		   <?php echo "if(item2 == '$row1[cat]') {"; ?>
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";


     	<?php echo "if(item1 == '$row1[description]') {"; ?>		
theOption1.selected = true;
<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php echo "}"; ?>


<?php }  ?>
}


function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;

	removeAllOptions(document.getElementById('code@' + index1));
			  var code = document.getElementById('code@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              code.appendChild(theOption1);
			  
			   
	removeAllOptions(document.getElementById('description@' + index1));  
			 var description = document.getElementById('description@' + index1); 
              // for description starts
 
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);
	
            // for description ends
			 
	

	<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";
			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (iusage = 'Sale' or iusage = 'Produced or Sale') order by code";
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
			  
			   <?php } ?> 
			// for description starts
  <?php 
  $q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (iusage = 'Sale' or iusage = 'Produced or Sale') order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['description'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['description']; ?>";
	        theOption1.title = "<?php echo $q1r['code'];?>";
              description.appendChild(theOption1);
 
           // for description ends 
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
