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


$id=$_GET['id'];
$gquery = "select * from pp_gateentry where ge = '$id' and client = '$client'";
$gresult = mysql_query($gquery,$conn) or die(mysql_error());
$gres = mysql_fetch_assoc($gresult);
?>

<center>
<br />
<h1>Edit Gate Entry</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
</center>
<br /><br />

<form id="form1" name="form1" method="post" action="pp_updategateentry_a.php" onSubmit="return checkform();">
                <input type="hidden" name="geincr" id="geincr" value="<?php echo $geincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
<center>
<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;
<input type="text" size="15" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y",strtotime($gres['date'])); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Warehouse</strong>&nbsp;&nbsp;
<select id="warehouse" name="warehouse" style="width:150px" >
<option value="<?php echo $gres['warehouse']; ?>" title="<?php echo $gres['warehouse']; ?>"><?php echo $gres['warehouse']; ?></option>
</select>
<br />
</center>
<br /><br />
<table align="center">
<tr>
 <!--<td align="right"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="15" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y",strtotime($gres['date'])); ?>" />&nbsp;&nbsp;&nbsp;</td>-->
 <td align="right"><strong>Gate Entry #</strong>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" style="background:none; border:none;" id="ge" name="ge" value="<?php echo $gres['ge']; ?>" size="14" readonly/>&nbsp;&nbsp;&nbsp;</td>
  <td align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><select name="type" id="type" >
<?php if($gres['vendor'] != ''){?><option value="vendor"  selected="selected">Vendor</option><?php }?>
<?php if($gres['broker'] != ''){?><option value="broker"  selected="selected">Broker</option><?php }?>
</select>&nbsp;&nbsp;&nbsp;
</td>
 <td align="right"><strong>Vendor/Broker</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><select name="vendor" id="vendor" style="width:130px" onChange="getitems(this.id);">
<?php if($gres['vendor'] != '')
{?>
<option value="<?php echo $gres['vendor']; ?>"  selected="selected"><?php echo $gres['vendor']; ?></option>
<?php } else {?>
<option value="<?php echo $gres['broker']; ?>"  selected="selected"><?php echo $gres['broker']; ?></option>
<?php } ?>
  </select>&nbsp;&nbsp;&nbsp; 
</td>
<?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?>
<td align="right"><strong>Vendor/Broker Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select name="vendorcode" id="vendorcode" style="width:130px" onChange="getitems(this.id);">
<?php if($gres['vendor'] != '')
{?>
<option value="<?php echo $gres['vendor']; ?>"  selected="selected"><?php echo $gres['vendorcode']; ?></option>
<?php } else {?>
<option value="<?php echo $gres['broker']; ?>"  selected="selected"><?php echo $gres['broker']; ?></option>
<?php } ?>
  </select>&nbsp; </td>
<?php } ?>

<td align="right"><strong>Vehicle #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="vehicleno" name="vehicleno" value="<?php echo $gres['vehicleno']; ?>" size="14" /></td>
</tr>
<tr style="height:20px"></tr>
</table>

<table id="test" border="0" align="center">
<tr>
<th><strong>Item code</strong></th>
<th width="10px"></th>
<th><strong>Description</strong></th>
<th width="10px"></th>
<th><strong>PO #s</strong></th>
<th width="10px"></th>
<th><strong title="Balance Quantity">Balance Qty.</strong></th>
<th width="10px"></th>
<th><strong>Quantity</strong></th>
<th width="10px"></th>
<?php if($_SESSION['db'] == "feedatives") { ?>
<th><strong>Price</strong></th>
<th width="10px"></th>
<?php } ?>
<th title="Quality Control/Lab Required"><strong>QC</strong></th>
<th width="10px"></th>

</tr>

<tr style="height:20px"></tr>
<?php 
$i = 0;
$gquery = "select * from pp_gateentry where ge = '$id' and client = '$client'";
$gresult = mysql_query($gquery,$conn) or die(mysql_error());
while($gres = mysql_fetch_assoc($gresult))
{
?>
<tr>
<td style="vertical-align:middle;">
<select style="width:90px;" name="itemcode[]" id="itemcode/<?php echo $i; ?>" onChange="getdescription(this.id)">
<option value="<?php echo $gres['code']; ?>"><?php echo $gres['code']; ?></option>
</select></td>
<td width="10px"></td>
<td style="vertical-align:middle;">
<select id="description/<?php echo $i; ?>" name="description[]" style="width:100px" onChange="getcode(this.id);">
<option value="<?php echo $gres['desc1']; ?>"><?php echo $gres['desc1']; ?></option>
</select>

<!--<input type="text" id="description/0" name="description[]" value="" size="15" readonly/>--></td>
<td width="10px"></td>
<?php
  	      $query2 = "select (quantity - receivedquantity) as balqty from pp_purchaseorder where description = '$gres[desc1]' AND po = '$gres[combinedpo]' AND flag = '1' AND geflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0)";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		$row2 = mysql_fetch_assoc($result2);?>

<td ><select id="po/<?php echo $i; ?>" name="po[]" onclick="getvalue(this.id);" style="width:150px"><option disabled="disabled" value="">-Select-</option>
<option value="<?php echo $gres['combinedpo']."@".$row2['balqty']; ?>" selected="selected"><?php echo $gres['combinedpo'];?></option>
</select></td>
<td width="10px">
<input type="hidden" id="hpo/<?php echo $i; ?>" name="hpo[]" value="<?php echo $gres['combinedpo'];?>" size="10"  />
</td>

<td style="vertical-align:middle;"><input type="text" id="balqty/0" name="bquantity[]" value="<?php echo $row2['balqty'] + $gres['acceptedquantity']; ?>" size="10" readonly style="background:none; border:none; text-align:right"  /></td>
<td width="10px"></td> 

<td style="vertical-align:middle;"><input type="text" id="quantity/<?php echo $i; ?>" name="quantity[]" value="<?php echo $gres['acceptedquantity'];?>" size="10" onFocus="makeForm();" style="text-align:right"  onkeyup="validate(this.id,this.value)"  /></td>
<td width="10px"></td>

<?php
if($_SESSION['db'] == "feedatives") { ?>
<td style="vertical-align:middle;"><input type="text" id="price/0" name="price[]" value="<?php echo $gres['rateperunit'];?>" size="10" style="text-align:right" /></td>
<td width="10px"></td>
<?php } ?>

<td style="vertical-align:middle;"><select id="qc/<?php echo $i; ?>" name="qc[]" style="width:70px" >

<option value="No" <?php if($gres['qc']=='No'){ ?>  selected="selected" <?php } ?> >No</option>
<option value="Yes" <?php if($gres['qc']=='Yes'){ ?> selected="selected" <?php } ?> >Yes</option>

</select>
</td>
<td width="10px"></td>

</tr>
<?php 
$i++;
}
?>



</table>
<br/>

<table align="center">
<tr>
<td colspan="5" align="center">
<center>
<input type="submit" id="Save" value="Update"  />&nbsp;&nbsp;&nbsp;<input type="button" id="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_gateentry_a';"/>
</center>
</td>
</tr>
</table>
<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

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

///////////////makeform//////////////
var index = 0;
function makeForm() {
if(index==0)
index = parseInt(<?php echo $i; ?>);
else
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
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode('Yes');
theOption1.value = "Yes";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { makeForm(); };
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
	 r.appendChild(ca10);
	 r.appendChild(et10);
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
  	      $query2 = "select distinct(description),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where code = '$row1[code]' and vendor ='$row1[vendor]' AND flag = '1' AND geflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0)";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>
   document.getElementById('description/' + index1).value = "<?php echo $row2['description']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
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
  	      $query2 = "select distinct(code),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where description = '$row1[description]' and vendor ='$row1[vendor]' AND flag = '1' AND geflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0)";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>
    document.getElementById('itemcode/' + index1).value = "<?php echo $row2['code']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
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
  	      $query2 = "select distinct(description),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where code = '$row1[code]' and broker ='$row1[broker]' AND flag = '1' AND geflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0)";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>
    document.getElementById('description/' + index1).value = "<?php echo $row2['description']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
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
  	      $query2 = "select distinct(code),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where description = '$row1[description]' and broker ='$row1[broker]' AND flag = '1' AND geflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0)";
		$result2 = mysql_query($query2,$conn) or die(mysql_error());
		while($row2 = mysql_fetch_assoc($result2)) { ?>

    document.getElementById('itemcode/' + index1).value = "<?php echo $row2['code']; ?>";
   theOption1=document.createElement("OPTION");
   theText1=document.createTextNode("<?php echo $row2['po']; ?>");
   theOption1.value = "<?php echo $row2['po']."@".$row2['balqty']."@".$row2['rateperunit']; ?>";
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
