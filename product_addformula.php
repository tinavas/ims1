<script type="text/javascript">
function decimalrestrict(a,b)
{
var a1=b.split(".");
var a2=a1[1];
if(a1.length>1)
if(a2.length>5)
{
var b2=a2.length-5;
document.getElementById(a).value=b.substr(0,b.length-b2);
}
}
var index = 0;
function makeForm() 
{
if((document.getElementById('quantity' + index).value >0) && (document.getElementById('quantity' +index).value != ""))
{
  index = index + 1;
  var t1  = document.getElementById('paraID');
  var r1 = document.createElement('tr'); 
  myselect1 = document.createElement("select");
  myselect1.style.width = "150px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  theOption1.value = "Select";
  myselect1.appendChild(theOption1);
  myselect1.name = "item[]";      
  myselect1.id = "item" + index;
  myselect1.onchange = function() { selectdesc(this.id); };
  <?php
           include "config.php"; 
		
		    $query = "SELECT * FROM ims_itemcodes WHERE iusage like '%produced%' ORDER BY code ASC";
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
  ba1.appendChild(myselect1);
  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);
 myselect2 = document.createElement("select");
  myselect2.style.width = "150px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  theOption1.value = "Select";
  myselect2.appendChild(theOption1);
  myselect2.name = "desc[]";
  myselect2.id = "desc" + index;
  myselect2.onchange = function() { selectcode(this.id); };
  <?php
        
		    $query = "SELECT * FROM ims_itemcodes WHERE iusage like '%produced%' ORDER BY code ASC ";

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
  
  
  var ba2 = document.createElement('td');
  ba2.appendChild(myselect2);

  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);



  mybox2=document.createElement("input");
  mybox2.size="12";
  mybox2.type="text";
  mybox2.name="quantity[]";
  mybox2.id="quantity" +  index;
   mybox2.onkeyup= function() { decimalrestrict(this.id,this.value);makeForm(); updateqty();  };

  var ba3 = document.createElement('td');
  ba3.appendChild(mybox2);
  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);

  mybox2=document.createElement("input");
  mybox2.size="12";
  mybox2.type="text";
  mybox2.name="units[]";
  mybox2.id="units" +  index;
  mybox2.setAttribute("readonly",true);
  mybox2.style.border = 0;
  mybox2.style.background = "none";
  mybox2.style.cursor = "hand";
  var ba4 = document.createElement('td');
  ba4.appendChild(mybox2);

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
      r1.appendChild(b4);
      t1.appendChild(r1);
}

}
/*function getdetails(a,b)
{
 var d = b.substr(4);
 for(var i = 0; i <= d; i++)
 {
 	for(var j = 0; j <= d; j++)
	{
		if(i!= j)
		{
			if(document.getElementById('item' + i).value  == document.getElementById('item' + j).value)
			{
				alert("This item has already been selected");
				document.getElementById('item' + j).selectedIndex = 0;
				return;
			}
		}
	}
 }

 if(a != "")
 {
  var d = b.substr(4);
  var c = a.split("@");
  document.getElementById("quantity" + d).disabled = false;
  document.getElementById("desc" + d).value = c[1];
  document.getElementById("units" + d).value = c[2];
 }
 else
 {
  var d = b.substr(4);
  document.getElementById("quantity" + d).value = "";
  document.getElementById("desc" + d).value = "";
  document.getElementById("units" + d).value = "";
  document.getElementById("quantity" + d).disabled = true;
 }
 updateqty();
}
*/
function updateqty()
{
  var tot = 0;
  for(var i = 0;i < index;i++)
  {
    var t = parseFloat(document.getElementById("quantity" + i).value);
   /* var unit1 = document.getElementById("units" + i).value;
    if(isNaN(t)) 
	{ 
		t = 0; 
	} 
	else if( document.getElementById("units" + i).value != "" )
	{ 
		t = convert(unit1,t); 
	}
	else
	{
	t = 0;
	}*/
    tot = tot +Number(t);
	
	
  }
  //document.getElementById("tweight").value =round_decimals(tot,2);
  
}

function convert(a,b)
{
  document.getElementById("savebtt").style.visibility = "visible";
  var flag = 0;
  var fromunit = a;
  var tounit = "Kgs";
  var value = b;
  var cvalue = new Array();
  var sunits = new Array();
  var cunits = new Array();
  var rvalue;
//alert(value);
<?php
  $i = 0;
 
  $query2 = "SELECT * FROM ims_itemunits";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  {
?>
    cvalue[<?php echo $i; ?>] = <?php echo $row2['cvalue']; ?>;
    sunits[<?php echo $i; ?>] = '<?php echo $row2['sunits']; ?>';
    cunits[<?php echo $i; ?>] = '<?php echo $row2['cunits']; ?>';

<?php $i = $i + 1; } ?>

 for(var j = 0;j<cvalue.length;j++)
 {
 
 //alert(sunits[j].toUpperCase()+'+'+fromunit.toUpperCase()+'+'+cunits[j].toUpperCase()+'+'+tounit.toUpperCase());
 
  if(sunits[j].toUpperCase() == fromunit.toUpperCase() && cunits[j].toUpperCase() == tounit.toUpperCase())
  {
    rvalue = value * cvalue[j];
    flag = 1;
  } 
 }
//if(flag) { return rvalue; } else { alert("Error in Unit Conversion"); document.getElementById("savebtt").focus(); document.getElementById("savebtt").style.visibility = "hidden"; return 0; } */

return rvalue;
} 
function getdesc(h)
{

 
  var code = document.getElementById(h).value;
 
<?php
session_start();


$query = "SELECT cat,description,code FROM ims_itemcodes WHERE client = '$client' ORDER BY code ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 echo "if(code == '$rows[code]') { "; 
 ?>
  document.getElementById("productdesc").value = "<?php echo $rows['description'];?>";

 <?php
 echo " } ";
}


?>
   
}
function getcode(r)
{


  var description = document.getElementById("productdesc").value;
<?php
session_start();



{
$query = "SELECT cat,description,code FROM ims_itemcodes WHERE client = '$client' ORDER BY code ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 echo "if(description == '$rows[description]') { "; 
 ?>
  document.getElementById("producttype").value = "<?php echo $rows['code'];?>";

 <?php
 echo " } ";
}

}
?>


  
 
}
function selectdesc(codeid)
{

temp = codeid.split("m");
var index1 = temp[1];

var code1=document.getElementById("item" + index1).value;
if(code1=='Select')
{document.getElementById("desc" + index1).value='Select';}
var d = codeid.substr(4);

 for(var i = 0; i <= d; i++)
 {
 	for(var j = 0; j <= d; j++)
	{
		if(i!= j)
		{
			if(document.getElementById('item' + i).value  == document.getElementById('item' + j).value)
			{
				alert("This item has already been selected");
				document.getElementById('item' + j).selectedIndex = 0;
				return;
			}
		}
	}
 }

<?php 
$q = "select distinct(code) from ims_itemcodes";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo "if(code1 == '$qr[code]') {";
$q1 = "select distinct(description),cunits from ims_itemcodes where code = '$qr[code]' order by description";
$q1rs = mysql_query($q1) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
{
?>
document.getElementById('desc' + index1).value = "<?php echo $q1r['description'];?>";
//alert("<?php echo $q1r['sunits'];?>");
//alert(document.getElementById('units' + index1).value);
document.getElementById('units' + index1).value = "<?php echo $q1r['cunits'];?>";
<?php
}
echo "}";
}
?>
updateqty();
}

function selectcode(codeid)
{

temp = codeid.split("c");
var index1 = temp[1];

var code1 = document.getElementById("desc" + index1).value;

if(code1=='Select')
{document.getElementById("item" + index1).value='Select';}
var d = codeid.substr(4);

 for(var i = 0; i <= d; i++)
 {
 	for(var j = 0; j <= d; j++)
	{
		if(i!= j)
		{
			if(document.getElementById('desc' + i).value  == document.getElementById('desc' + j).value)
			{
				alert("This item has already been selected");
				document.getElementById('desc' + j).selectedIndex = 0;
				return;
			}
		}
	}
 }

<?php
$q = "select distinct(description) from ims_itemcodes";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo "if(code1 == '$qr[description]') {";
$q1 = "select distinct(code),cunits from ims_itemcodes where description = '$qr[description]' order by code";
$q1rs = mysql_query($q1) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
{
?>
document.getElementById("item" + index1).value = "<?php echo $q1r['code'];?>";
//alert("<?php echo $q1r['sunits'];?>");
//alert(document.getElementById("units" + index1).value);
document.getElementById("units" + index1).value = "<?php echo $q1r['cunits'];?>";
<?php
}
echo "}";
}
?>
updateqty();
}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}
function round_decimals(original_number,decimals) {
    var result1 = original_number * Math.pow(10, decimals)
    var result2 = Math.round(result1)
    var result3 = result2 / Math.pow(10, decimals)
    return pad_with_zeros(result3, decimals)
}
function pad_with_zeros(rounded_value, decimal_places) {

   var value_string = rounded_value.toString()
    
   var decimal_location = value_string.indexOf(".")

   if (decimal_location == -1) {
        
      decimal_part_length = 0
        
      value_string += decimal_places > 0 ? "." : ""
    }
    else {
        decimal_part_length = value_string.length - decimal_location - 1
    }
    var pad_total = decimal_places - decimal_part_length
    if (pad_total > 0) {
        for (var counter = 1; counter <= pad_total; counter++) 
            value_string += "0"
        }
    return value_string
}

function validatecode(a,b)
{
 var expr=/^[A-Za-z0-9-()./ ]*$/;
 if(! b.match(expr))
 {
  alert("Special Characters are not allowed");
  document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
 
 <?php
 $q1="select distinct name from product_formula";
 $q1=mysql_query($q1) or die(mysql_error());
 while($r1=mysql_fetch_assoc($q1))
 {
 ?>
 if("<?php echo $r1['name'];?>"==b)
 {
 alert("Formula already existed");
 document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
 <?php }?>
 
}
</script>



<?php include "jquery.php"; ?>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:700px" id="complex_form" method="post" action="product_saveproductformula.php" >
	  <h1 id="title1">Product Formula</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br /><br />
<div style="width: 650px">
<fieldset>
<br />
<table>
<tr>
<td width="120" style="text-align:left"><strong>Warehouse</strong></td>
<td width="120" style="text-align:left">
<select name="warehouse" id="warehouse" style="width:128px;" >
           <option>-Select-</option>
           <?php
           
                 $query = "SELECT distinct(sector) FROM tbl_sector where type1='Warehouse'  ORDER BY sector ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
           <?php } ?>
         </select></td>
         <td width="30"></td>
</tr>
<tr height="10px"></tr>
<tr>
<td width="120" style="text-align:left"><strong>Formula Name</strong></td>
<td width="120" style="text-align:left">
 <input type="text" name="formula" id='formula' onkeyup="validatecode(this.id,this.value);" />
</td>
<td width="30"></td>
<td width="120" style="text-align:left"><strong>Date</strong></td>
<td width="120" style="text-align:left">
<input type="text" name="date" id="date" class="datepicker" />
</td>
</tr>

<tr height="10px"></tr>

<tr>
<td width="120" style="text-align:left"><strong>Output Product code</strong></td>
<td width="120" style="text-align:left">
<select name="producttype" id="producttype" style="width: 175px" onchange = "getdesc(this.id);">
<option>-Select-</option>
  <?php
         
            $query = "SELECT * FROM ims_itemcodes where source like '%produced%'  ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>"><?php echo $row1['code']; ?></option>


<?php } ?>
</select></td>
<td width= "10"></td>
<td width="120" style="text-align:left"><strong>Output Product Description</strong></td>
<td width="120" style="text-align:left">
<select name="productdesc" id="productdesc" style="width: 140px" onchange = "getcode(this.id);">
<option>-Select-</option>
  <?php
           
			$query = "SELECT * FROM ims_itemcodes where source like '%produced%' ORDER BY description ASC ";           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
<option title="<?php echo $row1['code'];?>"value="<?php echo $row1['description']; ?>"><?php echo $row1['description']; ?></option>

<?php } ?>
</select></td>

</tr>



<tr height="10px"></tr>
<tr>
<td width="120" style="text-align:left"><strong></strong></td>
<td width="120" style="text-align:left">


</td>
<td width="30"></td>
<td width="120" style="text-align:left"><strong>Total Units</strong></td>
<td width="120" style="text-align:left">
<!--<input type="text" name="tweight" id="tweight" value="0" readonly style="border:0px;background:none;cursor:hand" />-->
<input type="text" name="tweight" id="tweight" value="1" style="text-align:right" />
</td>
</tr>
</table>
</fieldset>
<br /><br />
<fieldset>
<legend>Item Details</legend>
<br />
<center>

<table id="paraID">
 <tr>
<td style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item Code <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
  
  <td width="15px"><strong></strong></td>
  <td style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Description <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
  <td width="15px"><strong></strong></td>
  <td style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Quantity <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
  <td width="15px"><strong></strong></td>

  <td style="text-align:left"><strong>&nbsp;&nbsp;Units</strong></td>
</tr>

<tr height="20px"><td></td></tr>

<tr>
<td>
<select name="item[]" id="item0" style="width:150px" onchange = "selectdesc(this.id);">
<option value="Select">-Select-</option>
  <?php
        
		            $query = "SELECT * FROM ims_itemcodes WHERE iusage like '%produced%' ORDER BY code ASC ";
   
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
<option value = "<?php echo $row1['code'];?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['code'];?></option>
<?php } ?>
</select>
</td>
<td></td>

<td>
<select name="desc[]" id="desc0" style="width:150px;"  onchange="selectcode(this.id);">
<option value="Select">-Select-</option>
  <?php 
  $query = "SELECT * FROM ims_itemcodes WHERE iusage like '%produced%' ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
<option value="<?php echo $row1['description'];?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['description']; ?></option>
<?php } ?>
</select>
</td>
<td></td>

<td><input type="text"  name="quantity[]" id="quantity0" size="12" onkeyup = "decimalrestrict(this.id,this.value);updateqty();makeForm()" /></td>
<td></td>
<td><input type="text" name="units[]" id="units0" size="12" readonly style="border:0px;background:none;cursor:hand"  /></td>
<td></td>
</tr>
</table>
</center>
</fieldset>
<br /><br />
<center>
<input type="submit" value="Save" id="savebtt" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=product_productformula';">
</center>
</div>

              </center>
     </form>
  </div>
</section>

<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('FeedmillHelp/help_t_addfeedformula.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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