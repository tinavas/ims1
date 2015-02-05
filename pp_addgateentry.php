<?php 
include "jquery.php";
include "config.php"; 
$query2 = "SELECT * FROM pp_gateentry ORDER BY date ASC"; $result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2)) { $lastdate = $row2['date'];  }
$strdot2 = explode('-',$lastdate); $lasty = substr($strdot2[0],2,4); $lastm = $strdot2[1];

$date1 = date("d.m.o"); $strdot1 = explode('.',$date1); $ignore = $strdot1[0]; $m = $strdot1[1]; $y = substr($strdot1[2],2,4);

$query1 = "SELECT MAX(geincr) as geincr FROM pp_gateentry WHERE m = '$m' AND y = '$y'";
$result1 = mysql_query($query1,$conn); while($row1 = mysql_fetch_assoc($result1)) { $geincr = $row1['geincr']; }
$geincr = $geincr + 1;

if ($geincr < 10) { $ge = 'GE-'.$m.$y.'-000'.$geincr; }
else if($geincr < 100 && $geincr >= 10) { $ge = 'GE-'.$m.$y.'-00'.$geincr; }
else { $ge = 'GE-'.$m.$y.'-0'.$geincr; }
?>

<center>
<br />
<h1>Gate Entry</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
</center>
<br /><br />

<form id="form1" name="form1" method="post" action="pp_savegateentry.php" onsubmit="return checkform();">
              <input type="hidden" name="geincr" id="geincr" value="<?php echo $geincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>

<center>
<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;
<input type="text" size="15" readonly="readonly" id="date" readonly="readonly" name="date" class="datepicker" onchange="getge()" value="<?php echo date("d.m.Y"); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Warehouse</strong>&nbsp;&nbsp;
<select id="warehouse" name="warehouse" style="width:150px" onchange="getitems(this.id);">
<option value="">-Select-</option>
<?php 
$query = "select distinct(deliverylocation) from pp_purchaseorder where geflag = '0' and deliverylocation <> ''   order by deliverylocation";
$resultl = mysql_query($query,$conn) or die(mysql_error());
while($loc = mysql_fetch_assoc($resultl))
{
?>
<option value="<?php echo $loc['deliverylocation']; ?>" title="<?php echo $loc['deliverylocation']; ?>"><?php echo $loc['deliverylocation']; ?></option>
<?php } ?>
</select>
<br />
</center>
<br /><br />

<table align="center">


<tr>
 
 <td align="right"><strong>Gate Entry #</strong>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" style="background:none; border:none;" id="ge" name="ge" value="<?php echo $ge; ?>" size="14" readonly/>&nbsp;&nbsp;&nbsp;</td>
  <td align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><select name="type" id="type"  onchange="gettype(this.value);">
 <option value="">-Select-</option>
<option value="vendor">Vendor</option>
<option value="broker">Broker</option>
</select>&nbsp;&nbsp;&nbsp;
</td>
 <td align="right"><strong>Vendor/Broker</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><select name="vendor" id="vendor" style="width:130px" onchange=" <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?> document.getElementById('vendorcode').value=this.value; <?php } ?> getitems(this.id);">
 <option value="">-Select-</option>

</select>&nbsp;&nbsp;
</td>
<?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?>
<td align="right"><strong>Vendor/Broker Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><select name="vendorcode" id="vendorcode" style="width:130px" onchange=" document.getElementById('vendor').value=this.value; getitems(this.id);">
 <option value="">-Select-</option>

</select>&nbsp;&nbsp;
</td>
<?php } ?>
<td align="right"><strong>Vehicle #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="vehicleno" name="vehicleno" value="" size="14"/></td>
</tr>
<tr style="height:20px"></tr>
</table>

<table id="test" border="0" align="center">
<tr>
<th><strong>Item code</strong></th>
<th width="10px"></th>
<th><strong>Description</strong></th>
<th width="10px"></th>
<th><strong>PO #</strong></th>

<?php if($_SESSION['db']=="vista"){ ?>
<th width="10px"></th>
<th><strong title="Balance Quantity">Bal Birds.</strong></th>
<?php } ?>
<th width="10px"></th>
<th><strong title="Balance Quantity">Balance <?php if($_SESSION['db']=="vista"){ ?>Weight.<?php } else {?> Qty <?php } ?></strong></th>

<?php if($_SESSION['db']=="vista"){ ?>


<th width="10px"></th>
<th align="left"><strong title="Bird">Bird.</strong></th>
<?php } ?>

<th width="10px"></th>
<th><strong><?php if($_SESSION['db']=="vista"){ ?>Weight<?php } else {?> Quantity <?php } ?></strong></th>
<th width="10px"></th>
<?php if($_SESSION['db'] == "feedatives") { ?>
<th><strong>Price</strong></th>
<th width="10px"></th>
<?php } ?>
<th title="Quality Control/Lab Required"><strong>QC</strong></th>
<th width="10px"></th>
</tr>

<tr style="height:20px"></tr>

<tr>
<td style="vertical-align:middle;"><select style="width:90px;" name="itemcode[]" id="itemcode/0" onchange="getdescription(this.id)"><option value="">-Select-</option></select></td>
<td width="10px"></td>
<td style="vertical-align:middle;">
<select id="description/0" name="description[]" style="width:100px" onchange="getcode(this.id);">
<option>-Select-</option>
</select>

<!--<input type="text" id="description/0" name="description[]" value="" size="15" readonly/>--></td>
<td width="10px"></td>
<td ><select id="po/0" name="po[]" onchange="compare(this.id,this.value);" style="width:150px"><option disabled="disabled" value="">-Select-</option></select></td>

<?php if($_SESSION['db']=="vista")
{?><td width="10px"></td>

<td style="vertical-align:left;"><input type="text" id="bird/0" name="bird[]" value="0" size="10" readonly style="background:none; border:none;  text-align:left"  /></td>
<?php } ?>

<td width="10px">
<input type="hidden" id="hpo/0" name="hpo[]" value="" size="10"  /></td>
<td style="vertical-align:middle;"><input type="text" id="balqty/0" name="bquantity[]" value="0" size="10" readonly style="background:none; border:none; text-align:right"  /></td>

<?php  if($_SESSION['db']=="vista") {?>

<td width="10px"></td>
<td style="vertical-align:middle;"><input type="text" id="balbird/0" onkeypress="return num(this.id,event.keyCode);" name="balbird[]" value="" size="10" style="text-align:right" onkeyup="validate1(this.id,this.value)"  /></td>

<?php } ?>
<td width="10px"></td>
<td style="vertical-align:middle;"><input type="text" onkeypress="return num1(this.id,event.keyCode);" id="quantity/0" name="quantity[]" value="" size="10" style="text-align:right" onkeyup="validate(this.id,this.value)" /></td>
<td width="10px"></td>
<?php
if($_SESSION['db'] == "feedatives") { ?>
<td style="vertical-align:middle;"><input type="text" id="price/0" name="price[]" value="" size="10" style="text-align:right" /></td>
<td width="10px"></td>
<?php } ?>
<td style="vertical-align:middle;"><select id="qc/0" name="qc[]" onchange="makeForm()">
<?php
if($_SESSION['db'] == "vista") { ?>

<option value="">-Select-</option>
<option value="No">No</option>
<?php } else {?>
<option value="">-Select-</option>
<option value="No">No</option>
<?php } ?>
</select></td>
<td width="10px"></td>
</tr>
</table>
<br/>

<table align="center">
<tr>
<td colspan="5" align="center">
<center>
<input type="submit" id="Save" value="Save"  />&nbsp;&nbsp;&nbsp;<input type="button" id="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_gateentry';"/>
</center>
</td>
</tr>
</table>
</form>

<script type="text/javascript">
function validate(a,b)
{
var temp = a.split('/');
var index1 = temp[1];
if(Number(document.getElementById('balqty/'+index1).value)<Number(document.getElementById('quantity/'+index1).value))
{
 document.getElementById(a).value = 0; //Math.round(Number(document.getElementById('quantity/'+index1).value)/10,0);
 alert("Quantity cannot be greater than Balance Quantity");
 return;
}
}

function validate1(a,b)
{
var temp = a.split('/');
var index1 = temp[1];
if(Number(document.getElementById('bird/'+index1).value)<Number(document.getElementById('balbird/'+index1).value))
{
 document.getElementById(a).value = 0; //Math.round(Number(document.getElementById('quantity/'+index1).value)/10,0);
 alert("Bird cannot be greater than Balance Bird");
 return;
}
}



function getvalue(a)
{
 var size = document.getElementById(a).length;
 var z = "";
 for(var i = 1;i < size;i++)
 {
   if(document.getElementById(a).options[i].selected)
   {
     z = z + document.getElementById(a).options[i].value + ",";
   }
 }
 z = z.substr(0,z.length-1);
 document.getElementById("h" + a).value = z;
}
function getge()
{
  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var geincr = new Array();
    var ge = "";
  <?php $query1 = "SELECT MAX(geincr) as geincr,m,y FROM pp_gateentry GROUP BY m,y ORDER BY date DESC"; $result1 = mysql_query($query1,$conn);
   $k = 0; while($row1 = mysql_fetch_assoc($result1)) { ?>
    mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
    yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
    geincr[<?php echo $k; ?>] = <?php if($row1['geincr'] < 0) { echo 0; } else { echo $row1['geincr']; } ?>;
<?php $k++; } ?>
for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(geincr[l] < 10)
     ge = 'GE'+'-'+m+y+'-000'+parseInt(geincr[l]+1);
   else if(geincr[l] < 100 && geincr[l] >= 10)
     ge = 'GE'+'-'+m+y+'-00'+parseInt(geincr[l]+1);
   else
     ge = 'GE'+'-'+m+y+'-0'+parseInt(geincr[l]+1);
     document.getElementById('geincr').value = parseInt(geincr[l] + 1);
  break;
  }
 else
  {
   ge = 'GE'+'-'+m+y+'-000'+parseInt(1);
   document.getElementById('geincr').value = 1;
  }
}
document.getElementById('ge').value = ge;
document.getElementById('m').value = m;
document.getElementById('y').value =y;

}

function num(a,b)
{

	if(b<48 || b>57)
	{
	 	event.keyCode=false;
		return false;
	
		
	}
	
	

}

function num1(a,b)
{

	if((b<48 || b>57) &&(b!=46))
	{
	 	event.keyCode=false;
		return false;
	
		
	}
	
	

}


///////////////makeform//////////////
var index = 0;
function makeForm() {
index = index + 1;
var i,b;
var t1  = document.getElementById('test');
var r  = document.createElement('tr');

///////////Select Item code/////////////
myselect1 = document.createElement("select");
myselect1.style.width = "90px";
myselect1.name = "itemcode[]";
myselect1.id = "itemcode/" +  index;
myselect1.onchange = function ()  {  getdescription(this.id); };

   //removeAllOptions(document.getElementById("itemcode/" +  index));
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);

  
<?php 
echo "if(document.getElementById('type').value == 'vendor'){ ";
$query1 = "SELECT distinct(vendor) FROM pp_purchaseorder ORDER BY vendor ASC"; 
	  $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) 
	  { 
        echo "if(document.getElementById('vendor').value == '$row1[vendor]') { ";
        $query2 = "select distinct(code),deliverylocation from pp_purchaseorder where vendor = '$row1[vendor]' AND flag = '1' AND geflag <> '1' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) ORDER BY code";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
	    while($row2 = mysql_fetch_assoc($result2)) { ?> 
		         if(document.getElementById("warehouse").value == "<?php echo $row2['deliverylocation']; ?>")
				 {
                     theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['code'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['code'];?>";
                     myselect1.appendChild(theOption1);
				}	 

   <?php  } echo "}"; } 
echo "}";

echo "if(document.getElementById('type').value == 'broker'){ ";
$query1 = "SELECT distinct(broker) FROM pp_purchaseorder ORDER BY vendor ASC"; 
	  $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) 
	  { 
        echo "if(document.getElementById('vendor').value == '$row1[broker]') { ";
        $query2 = "select distinct(code),deliverylocation from pp_purchaseorder where broker = '$row1[broker]' AND flag = '1' AND geflag <> '1' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) ORDER BY code";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
	    while($row2 = mysql_fetch_assoc($result2)) { ?> 
		         if(document.getElementById("warehouse").value == "<?php echo $row2['deliverylocation']; ?>")
				 {
                     theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['code'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['code'];?>";
                     myselect1.appendChild(theOption1);
					} 

   <?php  } echo "}"; } 
echo "}";

   ?>





var ca = document.createElement('td');
ca.style.verticalAlign= "middle";
ca.appendChild(myselect1);
/////////end of item codes//////////


/////////////////////item descriptions////////////
myselect1 = document.createElement("select");
myselect1.style.width = "100px";
myselect1.name = "description[]";
myselect1.id = "description/" +  index;
myselect1.onchange = function ()  {  getcode(this.id); };

   //removeAllOptions(document.getElementById("itemcode/" +  index));
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);

  
<?php 
echo "if(document.getElementById('type').value == 'vendor'){ ";
$query1 = "SELECT distinct(vendor) FROM pp_purchaseorder ORDER BY vendor ASC"; 
	  $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) 
	  { 
        echo "if(document.getElementById('vendor').value == '$row1[vendor]') { ";
        $query2 = "select distinct(description),deliverylocation from pp_purchaseorder where vendor = '$row1[vendor]' AND flag = '1' AND geflag <> '1' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) ORDER BY code";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
	    while($row2 = mysql_fetch_assoc($result2)) { ?> 
		          if(document.getElementById("warehouse").value =="<?php echo $row2['deliverylocation']; ?>")
				  {
                     theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['description'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['description'];?>";
					  theOption1.title = "<?php echo $row2['description'];?>";
                      myselect1.appendChild(theOption1);
					}  

   <?php  } echo "}"; } 
echo "}";

echo "if(document.getElementById('type').value == 'broker'){ ";
$query1 = "SELECT distinct(broker) FROM pp_purchaseorder ORDER BY vendor ASC"; 
	  $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) 
	  { 
        echo "if(document.getElementById('vendor').value == '$row1[broker]') { ";
        $query2 = "select distinct(description),deliverylocation from pp_purchaseorder where broker = '$row1[broker]' AND flag = '1' AND geflag <> '1' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) ORDER BY code";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
	    while($row2 = mysql_fetch_assoc($result2)) { ?> 
		         if(document.getElementById("warehouse").value == "<?php echo $row2['deliverylocation']; ?>")
				 {
                     theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['description'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['description'];?>";
					 theOption1.title = "<?php echo $row2['description'];?>";
                     myselect1.appendChild(theOption1);
				} 

   <?php  } echo "}"; } 
echo "}";
   ?>





var ca3 = document.createElement('td');
ca3.style.verticalAlign= "middle";
ca3.appendChild(myselect1);



////////////po/////////////
myselect1 = document.createElement("select");
myselect1.style.width = "150px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode('-Select-');
theOption1.appendChild(theText1);
theOption1.value="";
theOption1.disabled = "true";
myselect1.appendChild(theOption1);
myselect1.name = "po[]";
myselect1.onchange = function() { compare(this.id,this.value); };
myselect1.id = "po/" + index;
var ca6 = document.createElement('td');
ca6.appendChild(myselect1);


mybox1=document.createElement("input");
mybox1.type="hidden";
mybox1.name="hpo[]";
mybox1.id = "hpo/" + index;
mybox1.size="15";
mybox1.setAttribute("readonly","true");
ca6.appendChild(mybox1);

///////////////end of delivery office/////////
////////////////bird//////////////////



mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="bird[]";
mybox1.id = "bird/" + index;
mybox1.setAttribute("readonly","true");
mybox1.style.background = "none";
mybox1.style.border = "none";
mybox1.style.textAlign = "left";
var ca14 = document.createElement('td');
ca14.style.verticalAlign= "middle";
ca14.appendChild(mybox1);
////////////end of bird//////////////

//bird
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="balbird[]";
mybox1.id = "balbird/" + index;
mybox1.onkeypress=function(){return num(this.id,event.keyCode)};
mybox1.onkeyup = function() {return validate1(this.id,this.value); }
//mybox1.setAttribute("readonly","true");
//mybox1.style.background = "none";
//mybox1.style.border = "none";
mybox1.style.textAlign = "right";
var ca15 = document.createElement('td');
ca15.style.verticalAlign= "middle";
ca15.appendChild(mybox1);





/////////////////////Balance qunatity////////////
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="balqty[]";
mybox1.id = "balqty/" + index;
mybox1.setAttribute("readonly","true");
mybox1.style.background = "none";
mybox1.style.border = "none";
mybox1.style.textAlign = "right";

var ca10 = document.createElement('td');
ca10.style.verticalAlign= "middle";
ca10.appendChild(mybox1);
////////////end of balance quantity//////////////

/////////////////////qunatity////////////
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="quantity[]";
mybox1.id = "quantity/" + index;
mybox1.style.textAlign = "right";
mybox1.onkeypress=function(){return num1(this.id,event.keyCode) };
mybox1.onkeyup = function() { validate(this.id,this.value); }
var ca2 = document.createElement('td');
ca2.style.verticalAlign= "middle";
ca2.appendChild(mybox1);
////////////end of quantity//////////////

/////////////////////qunatity////////////
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="price[]";
mybox1.id = "price/" + index;
mybox1.style.textAlign = "right";
var ca9 = document.createElement('td');
ca9.style.verticalAlign= "middle";
ca9.appendChild(mybox1);
////////////end of quantity//////////////

/////////////////////qc/////
myselect1 = document.createElement("select");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode('-Select-');
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode('No');
theOption1.value = "No";
myselect1.onchange = function () { makeForm(); };
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);



myselect1.name = "qc[]";
myselect1.id = "qc/" + index;

var ca7 = document.createElement('td');
ca7.style.verticalAlign= "middle";
ca7.appendChild(myselect1);
///////////qc

//warehouse///
/*myselect1 = document.createElement("select");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode('-Select-');
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.style.width = "100px";
myselect1.name = "warehouse[]";
myselect1.id = "warehouse/" + index;

var ca8 = document.createElement('td');
ca8.style.verticalAlign= "middle";
ca8.appendChild(myselect1);
*/

////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et1 = document.createElement('td');
et1.appendChild(myspace2);
///////////////////////////////

////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et2 = document.createElement('td');
et2.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et3 = document.createElement('td');
et3.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et4 = document.createElement('td');
et4.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et5 = document.createElement('td');
et5.appendChild(myspace2);

myspace2 = document.createTextNode('\u00a0');
var et14 = document.createElement('td');
et14.appendChild(myspace2);


myspace2 = document.createTextNode('\u00a0');
var et15 = document.createElement('td');
et15.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et6 = document.createElement('td');
et6.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et7 = document.createElement('td');
et7.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et8 = document.createElement('td');
et8.appendChild(myspace2);
///////////////////////////////
myspace2 = document.createTextNode('\u00a0');
var et9 = document.createElement('td');
et9.appendChild(myspace2);
///////////////////////////////
myspace2 = document.createTextNode('\u00a0');
var et10 = document.createElement('td');
et10.appendChild(myspace2);


      r.appendChild(ca);
	 r.appendChild(et1);
     	 r.appendChild(ca3);
   	 r.appendChild(et3);
	 //r.appendChild(et6);
	 r.appendChild(ca6);
	 r.appendChild(et7);
	
	 <?php  if($_SESSION['db']=="vista") {?>
	 r.appendChild(ca14);
	 r.appendChild(et14);
	  r.appendChild(ca10);
	 r.appendChild(et10);
	 
	 r.appendChild(ca15);
	 r.appendChild(et15);
	 
	 
	 <?php } ?>
	 
	 r.appendChild(ca2);
	 r.appendChild(et8);
	 <?php if($_SESSION['db'] == "feedatives") { ?>
	 r.appendChild(ca9);
	 r.appendChild(et9);
	 <?php } ?>
     r.appendChild(ca7);
	 r.appendChild(et6);
	
	// r.appendChild(ca8);
	 t1.appendChild(r);
	
	
}


///////////////end of make form////////////////
function gettype(z)
{
if(z == "vendor")
{
gettypeven();
}
else if(z == "broker")
{
gettypebro();
}
}

function gettypeven()
{
removeAllOptions(document.getElementById("vendor"));
   myselect1 = document.getElementById("vendor");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
      <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?>
   removeAllOptions(document.getElementById("vendorcode"));
   myselect2 = document.getElementById("vendorcode");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect2.appendChild(theOption1);
    <?php } ?>

<?php $query1 = "SELECT distinct(vendor),vendorcode FROM pp_purchaseorder WHERE flag = '1' AND geflag <> '1' ORDER BY vendor"; 
$result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) { ?>
	  	       theOption1=document.createElement("OPTION");
               theText1=document.createTextNode("<?php echo $row1['vendor'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['vendor'];?>";
               myselect1.appendChild(theOption1);
			   <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?> 
			   theOption1=document.createElement("OPTION");
               theText1=document.createTextNode("<?php echo $row1['vendorcode'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['vendor'];?>";
               myselect2.appendChild(theOption1); <?php } ?>
<?php } ?>
}
function gettypebro()
{
   removeAllOptions(document.getElementById("vendor"));
   myselect1 = document.getElementById("vendor");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
   <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?>
   removeAllOptions(document.getElementById("vendorcode"));
   myselect2 = document.getElementById("vendorcode");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect2.appendChild(theOption1);
    <?php } ?>

<?php $query1 = "SELECT distinct(broker) FROM pp_purchaseorder WHERE flag = '1' AND geflag <> '1' and ( broker <> 'NULL' and broker <> '' ) ORDER BY vendor"; $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) { ?>
	   
	   		   theOption1=document.createElement("OPTION");
               theText1=document.createTextNode("<?php echo $row1['broker'];?>");
			   theOption1.appendChild(theText1);
			   theOption1.value = "<?php echo $row1['broker'];?>";
               myselect1.appendChild(theOption1);
			  
<?php } ?>
}
function getitems(id)
{
if(document.getElementById("type").value =="vendor")
{
getitemsven(id);
}
else if(document.getElementById("type").value =="broker")
{
getitemsbro(id);
}
}


function getitemsven(id)
{
   if(document.getElementById("warehouse").value == "")
   	{ 
	alert('please select warehouse');
	return;
	}

   removeAllOptions(document.getElementById("itemcode/0"));
   myselect1 = document.getElementById("itemcode/0");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
   removeAllOptions(document.getElementById("description/0"));
   myselect2 = document.getElementById("description/0");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect2.appendChild(theOption1);


  
<?php $query1 = "SELECT distinct(vendor) FROM pp_purchaseorder ORDER BY vendor ASC"; 
	  $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) 
	  { 
        echo "if(document.getElementById('vendor').value == '$row1[vendor]') { ";
        $query2 = "select distinct(code),description,deliverylocation from pp_purchaseorder where vendor = '$row1[vendor]' AND flag = '1' AND geflag <> '1'  ORDER BY code";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
	    while($row2 = mysql_fetch_assoc($result2)) { ?> 
                     
					if(document.getElementById("warehouse").value == "<?php echo $row2['deliverylocation']; ?>")
					{ 
					 theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['code'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['code'];?>";
                     myselect1.appendChild(theOption1);
					 
					  theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['description'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['description'];?>";
					 theOption1.title = "<?php echo $row2['description'];?>";
                     myselect2.appendChild(theOption1);
					 }

   <?php  } echo "}"; } ?>

}
function getitemsbro(id)
{

   if(document.getElementById("warehouse").value == "")
   	{ 
	alert('please select warehouse');
	return;
	}
   removeAllOptions(document.getElementById("itemcode/0"));
   myselect1 = document.getElementById("itemcode/0");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);

   removeAllOptions(document.getElementById("description/0"));
   myselect2 = document.getElementById("description/0");			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect2.appendChild(theOption1);

<?php $query1 = "SELECT distinct(broker) FROM pp_purchaseorder ORDER BY vendor ASC"; 
	  $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) 
	  { 
        echo "if(document.getElementById('vendor').value == '$row1[broker]') { ";
        $query2 = "select distinct(code),description,deliverylocation from pp_purchaseorder where broker = '$row1[broker]' AND flag = '1' AND geflag <> '1'  ORDER BY code";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
	    while($row2 = mysql_fetch_assoc($result2)) { ?> 
		if(document.getElementById("warehouse").value == "<?php echo $row2['deliverylocation']; ?>")
					{ 
                     theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['code'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['code'];?>";
                     myselect1.appendChild(theOption1);
					 
					  theOption1=document.createElement("OPTION");
                     theText1=document.createTextNode("<?php echo $row2['description'];?>");
			         theOption1.appendChild(theText1);
			         theOption1.value = "<?php echo $row2['description'];?>";
					 theOption1.title = "<?php echo $row2['description'];?>";
                     myselect2.appendChild(theOption1);
					} 

   <?php  } echo "}"; } ?>

}

function getdescription(a)
{
if(document.getElementById('type').value == "vendor")
{
getdescriptionven(a);
}
else if(document.getElementById('type').value == "broker")
{
getdescriptionbro(a);
}

}

function getcode(a)
{
if(document.getElementById('type').value == "vendor")
{
getcodeven(a);
}
else if(document.getElementById('type').value == "broker")
{
getcodebro(a);
}

}

function getdescriptionven(a)
{
var id1 = a.split("/");
var index1 = id1[1]; 

document.getElementById('description/' + index1).value = "";

 removeAllOptions(document.getElementById('po/' + index1));
  myselect1 = document.getElementById("po/" + index1);			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
    
<?php $query1 = "select distinct(code),vendor from pp_purchaseorder WHERE flag = '1' AND geflag = '0' order by code ASC"; $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) {
	    echo "if((document.getElementById('itemcode/' + index1).value == '$row1[code]') && (document.getElementById('vendor').value == '$row1[vendor]')) { ";
  	      
		  if($_SESSION['db']=="vista") {
		  
		  $query2 = "select distinct(description),po,(weight - receivedquantity) as balqty,rateperunit,(quantity-recbird) as balbird from pp_purchaseorder where code = '$row1[code]' and vendor ='$row1[vendor]' AND flag = '1' AND geflag = '0'  ORDER BY code  ";
		  }
		  else
		  $query2 = "select distinct(description),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where code = '$row1[code]' and vendor ='$row1[vendor]' AND flag = '1' AND geflag = '0'  ORDER BY code  ";
		  
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>
   document.getElementById('description/' + index1).value = "<?php echo $row2['description']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   
   <?php if($_SESSION['db']=="vista") { ?>
   
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']."@".$row2['balbird']; ?>";
   <?php } else {?>
   
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
   <?php } ?>
   
   theOption1.appendChild(theText1);
   myselect1.appendChild(theOption1);

  
<?php }  echo "}"; } ?>


}

function getcodeven(a)
{
var id1 = a.split("/");
var index1 = id1[1];

document.getElementById('itemcode/' + index1).value = "";

 removeAllOptions(document.getElementById('po/' + index1));
  myselect1 = document.getElementById("po/" + index1);			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);

 
<?php $query1 = "select distinct(description),vendor from pp_purchaseorder WHERE flag = '1' AND geflag = '0' order by code ASC"; $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) {
	    echo "if((document.getElementById('description/' + index1).value == '$row1[description]') && (document.getElementById('vendor').value == '$row1[vendor]')) { ";
  	      
		  
		   if($_SESSION['db']=="vista"){
		  $query2 = "select distinct(code),po,(weight - receivedquantity) as balqty,rateperunit,(quantity-recbird) as balbird from pp_purchaseorder where description = '$row1[description]' and vendor ='$row1[vendor]' AND flag = '1' AND geflag = '0' order by code  ";
		  }
		  else
		  $query2 = "select distinct(code),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where description = '$row1[description]' and vendor ='$row1[vendor]' AND flag = '1' AND geflag = '0' order by code  ";
		  
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>
    document.getElementById('itemcode/' + index1).value = "<?php echo $row2['code']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   
   <?php if($_SESSION['db']=="vista"){?>
   
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']."@".$row2['balbird']; ?>";
   <?php } else {?>
   
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
   <?php } ?>
   
   
   theOption1.appendChild(theText1);
   myselect1.appendChild(theOption1);
   
   
<?php }  echo "}"; } ?>

}


function getdescriptionbro(a)
{
var id1 = a.split("/");
var index1 = id1[1];

document.getElementById('description/' + index1).value = "";

 removeAllOptions(document.getElementById('po/' + index1));
  myselect1 = document.getElementById("po/" + index1);			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
 
<?php $query1 = "select distinct(code),broker from pp_purchaseorder WHERE flag = '1' AND geflag = '0' order by code ASC"; 
      $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) {
	    echo "if((document.getElementById('itemcode/' + index1).value == '$row1[code]') && (document.getElementById('vendor').value == '$row1[broker]')) { ";
  	     
		  if($_SESSION['db']=="vista") {
		   $query2 = "select distinct(description),po,(weight - receivedquantity) as balqty,rateperunit,(quantity-recbird) as balbird from pp_purchaseorder where code = '$row1[code]' and broker ='$row1[broker]' AND flag = '1' AND geflag = '0' ";
		  }
		  
		  else
		   $query2 = "select distinct(description),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where code = '$row1[code]' and broker ='$row1[broker]' AND flag = '1' AND geflag = '0' ";
		  
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>
    document.getElementById('description/' + index1).value = "<?php echo $row2['description']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
   
   
  <?php if($_SESSION['db']=="vista") {?>
   
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']."@".$row2['balbird']; ?>";
   <?php } else { ?>
    theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
	<?php } ?>
   
   theOption1.appendChild(theText1);
   myselect1.appendChild(theOption1);
   
 

<?php }  echo "}"; } ?>

}

function getcodebro(a)
{
var id1 = a.split("/");
var index1 = id1[1];

document.getElementById('itemcode/' + index1).value = "";

 removeAllOptions(document.getElementById('po/' + index1));
  myselect1 = document.getElementById("po/" + index1);			 
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("-Select-");
   theOption1.value = "";
   theOption1.appendChild(theText1);
   theOption1.disabled = true;
   myselect1.appendChild(theOption1);
   
   
<?php $query1 = "select distinct(description),broker from pp_purchaseorder WHERE flag = '1' AND geflag = '0' order by code ASC"; $result1 = mysql_query($query1,$conn);
      while($row1 = mysql_fetch_assoc($result1)) {
	    echo "if((document.getElementById('description/' + index1).value == '$row1[description]') && (document.getElementById('vendor').value == '$row1[broker]')) { ";
  	      
		  
		  if($_SESSION['db']=="vista")
		  $query2 = "select distinct(code),po,(weight - receivedquantity) as balqty,rateperunit,(quantity-recbird) as balbird from pp_purchaseorder where description = '$row1[description]' and broker ='$row1[broker]' AND flag = '1' AND geflag = '0' ";
		  else
		  $query2 = "select distinct(code),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where description = '$row1[description]' and broker ='$row1[broker]' AND flag = '1' AND geflag = '0' ";
		  
		  
		  
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>
    document.getElementById('itemcode/' + index1).value = "<?php echo $row2['code']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   
   
   <?php if($_SESSION['db']=="vista") { ?>
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']."@".$row2['balbird']; ?>";
   
   <?php } else { ?>
   
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
   <?php } ?>
   theOption1.appendChild(theText1);
   myselect1.appendChild(theOption1);

 
<?php }  echo "}"; } ?>

}

function compare(a,b)
{

var id1 = a.split("/");
var index1 = id1[1];

for(var i = 0; i <=index;i++)
{
	for(var j = 0; j <=index;j++)
	{
		if( i != j )
		{ 
			if((document.getElementById('description/' + i).value == document.getElementById('description/' + j).value) && (document.getElementById('po/'+i).value == document.getElementById('po/'+j).value))
			{
			document.getElementById('itemcode/' + j).value = "";
			document.getElementById('description/' + j).value = "";
			document.getElementById('po/' + j).value = "";
			alert("Please select different combination");
			return;
			}
		}
	}
}
var temp = b.split('@');
document.getElementById('balqty/'+index1).value = temp[1];
<?php if($_SESSION['db']=="vista") { ?>
document.getElementById('bird/'+index1).value = temp[3];
<?php } ?>
<?php if($_SESSION['db'] == "feedatives") { ?>
document.getElementById('price/'+index1).value = temp[2];
<?php } ?>
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}

function checkform( )
{
if(document.getElementById("vehicleno").value=="")
{
	alert("Enter vehicle number");
	return false;

}

if(document.getElementById('vendor').selectedIndex == 0)
{
    document.getElementById("code1").innerHTML = "";
    document.getElementById("itemcode").setAttribute("class","");
    document.getElementById("vendor1").innerHTML = "Please select the Vendor";
    document.getElementById("vendor").setAttribute("class","error relative");
	document.getElementById('vendor').focus();
	return false;
}
return true;
}

</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_addgateentry.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
