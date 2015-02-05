<?php 

include "jquery.php";

include "config.php"; 


$id=$_GET['id'];
 $gquery = "select * from pp_goodsreceipt where gr = '$id' ";

$gresult = mysql_query($gquery,$conn) or die(mysql_error());

$gres = mysql_fetch_assoc($gresult);
 $warehouse=$gres['warehouse'];
 $gr=$gres['gr'];
 $grincr=$gres['grincr'];
 $m=$gres['m'];
 $y=$gres['y'];
	$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSE' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}

$coacode1=json_encode($coacode);

?>


<script>
var coacode=<?php if(empty($coacode1)){echo 0;} else{ echo $coacode1;}?>;
</script>





<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form1" method="post" action="pp_savegoodsreceipt.php" onsubmit="return checkform();">
	  <h1 id="title1">Goods Receipt</h1>
		
  
<br />
<b>Edit Goods Receipt</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />


                <input type="hidden" name="grincr" id="grincr" value="<?php echo $grincr; ?>"/>
				<input type="hidden" name="saed" value="1" />

                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>

                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
				<input type="hidden" name="oldgr" value="<?php echo $id;?>" />
				

<table align="center">
<tr>
<td>
<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td>

<input type="text" size="15" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y",strtotime($gres['date'])); ?>" readonly="true" onchange="getgr()" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>

<strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>
<td>

<select id="warehouse" name="warehouse" style="width:150px" >

<option value="<?php echo $gres['warehouse']; ?>" title="<?php echo $gres['warehouse']; ?>"><?php echo $gres['warehouse']; ?></option>

</select></td>
</tr>
</table>

<br />


<br /><br />

<table align="center">

<tr>



 <td align="right"><strong>Goods Receipt #</strong>&nbsp;&nbsp;&nbsp;</td>

 <td align="left"><input type="text" style="background:none; border:none;" id="gr" name="gr" value="<?php echo $gres['gr']; ?>" size="14" readonly/>&nbsp;&nbsp;&nbsp;</td>

  

  <td align="left">&nbsp;</td>

 <td align="right"><strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

  <td align="left"><select name="vendor" id="vendor" style="width:130px" onchange="getitems(this.id);">

<option value="<?php echo $gres['vendor']; ?>"  selected="selected"><?php echo $gres['vendor']; ?></option>



  </select>&nbsp;&nbsp;&nbsp;</td>



<td align="right"><strong>Vehicle #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left"><input type="text" id="vehicleno" name="vehicleno" value="<?php echo $gres['vehicleno']; ?>" size="14" /></td>
</tr>

<tr style="height:20px"></tr>
</table>



<table id="test" border="0" align="center">

<tr>

<th><strong>Item code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>

<th width="10px"></th>

<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>

<th width="10px"></th>

<th><strong>PO #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>

<th width="10px"></th>

<th><strong title="Balance Quantity">Balance Qty.</strong></th>

<th width="10px"></th>

<th><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>

<th width="10px"></th>

<th><strong>Freight Type</strong></th>

<th width="10px"></th>

<th><strong>Freight Amount</strong></th>

<th width="10px"></th>

<th><strong>Freight Code</strong></th>

<th width="10px"></th>


<th><strong>Cash&nbsp;Code</strong></th>
<th width="10px"></th>

</tr>



<tr style="height:20px"></tr>

<?php 

$i = 0;

 $gquery = "select * from pp_goodsreceipt where gr = '$id' and client = '$client'";

$gresult = mysql_query($gquery,$conn) or die(mysql_error());

while($gres = mysql_fetch_assoc($gresult))

{
?>

<tr>

<td style="vertical-align:middle;">

<select style="width:90px;" name="itemcode[]" id="itemcode/<?php echo $i; ?>" onchange="getdescriptionven(this.id)">

<option value="<?php echo $gres['code']; ?>"><?php echo $gres['code']; ?></option>
</select></td>

<td width="10px"></td>

<td style="vertical-align:middle;">

<select id="description/<?php echo $i; ?>" name="description[]" style="width:100px" onchange="getcodeven(this.id);">

<option value="<?php echo $gres['description']; ?>"><?php echo $gres['description']; ?></option>
</select>

</td>

<td width="10px"></td>

<?php

	      $query2 = "select distinct(po),sum(quantity) as qty, sum(receivedquantity) as recqty,rateperunit from pp_purchaseorder where code = '$gres[code]' and vendor ='$gres[vendor]' AND flag = '1' AND grflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and deliverylocation='$gres[warehouse]' group by po";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

		$row2 = mysql_fetch_assoc($result2);
 $balqty=$row2['qty']-$row2['recqty'];
?>
<td ><select id="po/<?php echo $i; ?>" name="po[]" onchange="compare(this.id,this.value);" style="width:120px"><option disabled="disabled" value="">-Select-</option>

<option value="<?php echo $gres['po']."@".$balqty; ?>" selected="selected"><?php echo $gres['po'];?></option>

</select></td>

<td width="10px"></td>



<td style="vertical-align:middle;"><input type="text" id="balqty/<?php echo $i; ?>" name="bquantity[]" value="<?php echo $balqty + $gres['acceptedquantity']; ?>" size="10" readonly style="background:none; border:none; text-align:right"  /></td>

<td width="10px"></td>



<td style="vertical-align:middle;"><input type="text" id="quantity/<?php echo $i; ?>" name="quantity[]" value="<?php echo $gres['acceptedquantity'];?>" size="10" onFocus="makeForm();" style="text-align:right"  onkeyup="validate(this.id,this.value)" onkeypress="return num(event.keyCode)"   /></td>
<td width="10px"></td>

<td><input type="text" name="freightie[]" id="freightie/<?php echo $i; ?>" value="<?php echo $gres['freightie'];?>" size="20" style="background:none; border:0px;" /> </td>

<td width="10px"></td>
<td><input type="text" name="freightamt[]" id="freightamt/<?php echo $i; ?>" value="<?php echo $gres['freightamount'];?>" size="8" <?php  if($gres['freightie']==""){ ?> readonly="true" <?php  } ?> /> </td>

<td width="10px"></td>
<td  >

<select name="fricode[]" id="fricode/<?php echo $i; ?>"  <?php  if($gres['freightie']=="Include" ||$gres['freightie']=="" ){ ?>  style="visibility:hidden;"  <?php } ?>  >
<option value="">--Select--</option>

 <?php 
	   	for($j=0;$j<count($coacode);$j++)
			{ $coacode1=explode("@",$coacode[$j]);
				
	   ?>
	   <option title="<?php echo $coacode1[1]; ?>" <?php if($gres['freightcode']==$coacode1[0]) { ?> selected="selected" <?php  } ?> value="<?php echo $coacode1[0]; ?>"><?php echo $coacode1[0]; ?></option>
	   <?php } ?>



</select> 


</td>


<td width="10px"></td>



<td  >
<select name="cash[]" id="cash/0"  <?php  if($gres['freightie']=="Exclude Paid By Supplier" || $gres['freightie']==""){ ?>  style="visibility:hidden;"  <?php } ?>>
<option value="">--Select--</option>

<?php 
$query="select distinct(code) from ac_bankmasters where mode = 'Cash' order by code";
$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{


$query1="select distinct(coacode) from ac_bankmasters where mode = 'Cash' and code='$row[code]' order by code";
$result1=mysql_query($query1,$conn);
while($row1=mysql_fetch_array($result1))
{
?>

<option value="<?php echo $row1['coacode'];?>" <?php if($gres['cashcode']==$row1['coacode']) {?> selected="selected" <?php } ?> ><?php echo $row1['coacode'];?></option>
<?php

}


}


?>

</select> 

</td>



<td width="10px"></td>
</tr>

<?php 

$i++;

}

?>
</table>


<br />
<br />



<table align="center">

<tr>

<td colspan="5" align="center">



<input type="submit" id="Save" value="Update"  />&nbsp;&nbsp;&nbsp;
<input name="button" type="button" id="Cancel" onclick="document.location='dashboardsub.php?page=pp_goodsreceipt';" value="Cancel"/>
<br/>



</td>

</tr>

</table>

<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />


</form>
</div>
</section>
</center>


<script type="text/javascript">

var index=<?php echo $i-1;?>;

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

function getgr()

{


  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var grincr = new Array();
    var po = ""; 
  <?php 
    
   $query1 = "SELECT MAX(grincr) as grincr,m,y FROM pp_goodsreceipt GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
	
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
    grincr[<?php echo $k; ?>] = <?php if($row1['grincr'] < 0) { echo 0; } else { echo $row1['grincr']; } ?>;

<?php $k++; } ?>

for(var l = 0; l <= <?php echo $k; ?>;l++)
{


 if((yea[l] == y) && (mon[l] == m))
  {
   if(grincr[l] < 10)
     gr = 'GR'+'-'+m+y+'-000'+parseInt(grincr[l]+1);
   else if(grincr[l] < 100 && grincr[l] >= 10)
     gr = 'GR'+'-'+m+y+'-00'+parseInt(grincr[l]+1);
   else
     gr = 'GR'+'-'+m+y+'-0'+parseInt(grincr[l]+1);
     document.getElementById('grincr').value = parseInt(grincr[l] + 1);
	
  break;
  }
 else
  {
   gr= 'GR'+'-'+m+y+'-000'+parseInt(1);
   document.getElementById('grincr').value = 1;
  }
}
document.getElementById('gr').value = gr;
document.getElementById('m').value = m;
document.getElementById('y').value =y;




}


function num(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}





///////////////makeform//////////////


function makeForm() {
for(j=0;j<=index;j++)
{

 if(document.getElementById('po/'+j).value=="")
 return false;
 
 
 if(j<index)

 if(document.getElementById('quantity/'+j).value=="")
 return false;

}

index = index + 1;

var i,b;

var t1  = document.getElementById('test');

var r  = document.createElement('tr');



///////////Select Item code/////////////

myselect1 = document.createElement("select");

myselect1.style.width = "90px";

myselect1.name = "itemcode[]";

myselect1.id = "itemcode/" +  index;

myselect1.onchange = function ()  {  getdescriptionven(this.id); };




  var op1=new Option("-Select-","");
  
  op1.disabled=true;
myselect1.options.add(op1);




  

<?php 



$query1 = "SELECT distinct(vendor),deliverylocation FROM pp_purchaseorder ORDER BY vendor ASC"; 

	  $result1 = mysql_query($query1,$conn);

      while($row1 = mysql_fetch_assoc($result1)) 

	  { 

        echo "if(document.getElementById('vendor').value == '$row1[vendor]' &&  document.getElementById('warehouse').value=='$row1[deliverylocation]') { ";

        $query2 = "select distinct(code),deliverylocation from pp_purchaseorder where vendor = '$row1[vendor]' AND flag = '1' AND grflag <> '1' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and deliverylocation='$row1[deliverylocation]'  ORDER BY code";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

	    while($row2 = mysql_fetch_assoc($result2)) { ?> 

		         if(document.getElementById("warehouse").value == "<?php echo $row2['deliverylocation']; ?>")

				 {

                     
					 var theOption=new Option("<?php echo $row2['code']; ?>","<?php echo $row2['code']; ?>");
		
		    theOption.title="<?php echo $row2['code']; ?>";
			
			
			myselect1.options.add(theOption);
					 
					 


				}	 



   <?php  } echo "}"; } 


   ?>











var tcode = document.createElement('td');

tcode.style.verticalAlign= "middle";

tcode.appendChild(myselect1);

/////////end of item codes//////////





/////////////////////item descriptions////////////

myselect1 = document.createElement("select");

myselect1.style.width = "100px";

myselect1.name = "description[]";

myselect1.id = "description/" +  index;

myselect1.onchange = function ()  {  getcodeven(this.id); };




  var op1=new Option("-Select-","");
  
  op1.disabled=true;
myselect1.options.add(op1);



  

<?php 


$query1 = "SELECT distinct(vendor),deliverylocation FROM pp_purchaseorder ORDER BY vendor ASC"; 

	  $result1 = mysql_query($query1,$conn);

      while($row1 = mysql_fetch_assoc($result1)) 

	  { 

        echo "if(document.getElementById('vendor').value == '$row1[vendor]'&&  document.getElementById('warehouse').value=='$row1[deliverylocation]') { ";

        $query2 = "select distinct(description),deliverylocation from pp_purchaseorder where vendor = '$row1[vendor]' AND flag = '1' AND grflag <> '1' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and  deliverylocation='$row1[deliverylocation]' ORDER BY code";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

	    while($row2 = mysql_fetch_assoc($result2)) { ?> 

		          if(document.getElementById("warehouse").value =="<?php echo $row2['deliverylocation']; ?>")

				  {

					 var theOption=new Option("<?php echo $row2['description']; ?>","<?php echo $row2['description']; ?>");
		
		    theOption.title="<?php echo $row2['description']; ?>";
			
			
			myselect1.options.add(theOption);


					}  



   <?php  } echo "}"; } 






   ?>











var tdesc = document.createElement('td');

tdesc.style.verticalAlign= "middle";

tdesc.appendChild(myselect1);







////////////po/////////////

myselect1 = document.createElement("select");

myselect1.style.width = "120px";


  var op1=new Option("-Select-","");
  
  op1.disabled=true;
myselect1.options.add(op1);


myselect1.name = "po[]";

myselect1.onchange = function() { compare(this.id,this.value); };

myselect1.id = "po/" + index;

var tpo = document.createElement('td');

tpo.appendChild(myselect1);






///////////////end of po/////////



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

var tbqty = document.createElement('td');

tbqty.style.verticalAlign= "middle";

tbqty.appendChild(mybox1);

////////////end of balance quantity//////////////



/////////////////////qunatity////////////

mybox1=document.createElement("input");

mybox1.size="10";

mybox1.type="text";

mybox1.name="quantity[]";

mybox1.id = "quantity/" + index;

mybox1.style.textAlign = "right";
mybox1.onkeypress=function() { return num(event.keyCode); };
mybox1.onkeyup = function() { validate(this.id,this.value); }
mybox1.onfocus = function () { makeForm(); };

var tqty = document.createElement('td');

tqty.style.verticalAlign= "middle";

tqty.appendChild(mybox1);

////////////end of quantity//////////////







/////////////////////freight type////////////

mybox1=document.createElement("input");

mybox1.size="10";

mybox1.type="text";

mybox1.name="freightie[]";

mybox1.id = "freightie/" + index;

mybox1.setAttribute("readonly","true");

mybox1.style.background = "none";

mybox1.style.border = "0px";

mybox1.size="20";
mybox1.style.textAlign = "right";

var tftype = document.createElement('td');

tftype.style.verticalAlign= "middle";

tftype.appendChild(mybox1);
////////////end of freight type//////////////



/////////////////////freight amount////////////

mybox1=document.createElement("input");

mybox1.size="8";

mybox1.type="text";

mybox1.name="freightamt[]";

mybox1.id = "freightamt/" + index;

mybox1.setAttribute("readonly","true");



mybox1.style.textAlign = "right";

var tfamt = document.createElement('td');

tfamt.style.verticalAlign= "middle";

tfamt.appendChild(mybox1);
////////////end of freight amount//////////////


//////cash///////





myselect1 = document.createElement("select");

myselect1.style.width = "90px";

myselect1.name = "fricode[]";

myselect1.id = "fricode/" +  index;

myselect1.style.visibility="hidden";




  var op1=new Option("-Select-","");

myselect1.options.add(op1);


for(i=0;i<coacode.length;i++)
{
var code1=coacode[i];
var coacode1=code1.split("@");

 var op1=new Option(coacode1[1],coacode1[0]);

myselect1.options.add(op1);

}




var tfricode = document.createElement('td');

tfricode.style.verticalAlign= "middle";

tfricode.appendChild(myselect1);



//// end of freight code///





//////cash///////





myselect1 = document.createElement("select");

myselect1.style.width = "90px";

myselect1.name = "cash[]";

myselect1.id = "cash/" +  index;

myselect1.style.visibility="hidden";




  var op1=new Option("-Select-","");

myselect1.options.add(op1);


  

<?php 

 
$query="select distinct(code) from ac_bankmasters where mode = 'Cash' order by code";
$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{


$query1="select distinct(coacode) from ac_bankmasters where mode = 'Cash' and code='$row[code]' order by code";
$result1=mysql_query($query1,$conn);
while($row1=mysql_fetch_array($result1))
{
?>



					 var theOption=new Option("<?php echo $row1['coacode']; ?>","<?php echo $row1['coacode']; ?>");
		
		    theOption.title="<?php echo $row1['coacode']; ?>";
			
			
			myselect1.options.add(theOption);



<?php

}
}

   ?>

var tcash = document.createElement('td');

tcash.style.verticalAlign= "middle";

tcash.appendChild(myselect1);



//// end of cash///




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








      r.appendChild(tcode);

	 r.appendChild(et1);

     	 r.appendChild(tdesc);

   	 r.appendChild(et2);

	 //r.appendChild(et6);

	

	 r.appendChild(tpo);

	 r.appendChild(et3);

	 r.appendChild(tbqty);

	 r.appendChild(et4);

	 r.appendChild(tqty);

	 r.appendChild(et5);
	 
	 
	  r.appendChild(tftype);

	 r.appendChild(et6);

	 r.appendChild(tfamt);

	 r.appendChild(et7);

	 r.appendChild(tfricode);

	 r.appendChild(et8);
	 
 	 r.appendChild(tcash);
    

	 r.appendChild(et9);

	 t1.appendChild(r);

	

	

}





///////////////end of make form////////////////











function getitemsven(id)

{

   if(document.getElementById("warehouse").value == "")

   	{ 

	alert('please select warehouse');

	return;

	}

var warehouse=document.getElementById("warehouse").value;

   document.getElementById("itemcode/0").options.length=1;

   myselect1 = document.getElementById("itemcode/0");			 


   

   document.getElementById("description/0").options.length=1;;

   myselect2 = document.getElementById("description/0");			 




<?php


$query="select distinct(deliverylocation) from pp_purchaseorder where grflag = '0' and deliverylocation <> '' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) order by deliverylocation";

$resultl = mysql_query($query,$conn) or die(mysql_error());

while($loc = mysql_fetch_assoc($resultl))

{

?>
if(warehouse=="<?php echo $loc['deliverylocation'];?>")
{
<?php

  
 $query1 = "SELECT distinct(vendor) FROM pp_purchaseorder where deliverylocation='$loc[deliverylocation]' ORDER BY vendor  ASC"; 

	  $result1 = mysql_query($query1,$conn);

      while($row1 = mysql_fetch_assoc($result1)) 

	  { 

        echo "if(document.getElementById('vendor').value == '$row1[vendor]') { ";

       $query2 = "select distinct(code),description,deliverylocation from pp_purchaseorder where vendor = '$row1[vendor]' AND flag = '1' AND grflag <> '1' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and deliverylocation='$loc[deliverylocation]' ORDER BY code";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

	    while($row2 = mysql_fetch_assoc($result2)) { ?> 

                    
					if(document.getElementById("warehouse").value == "<?php echo $row2['deliverylocation']; ?>")

					{ 

				
				
				  var theOption=new Option("<?php echo $row2['code'];?>","<?php echo $row2['code'];?>");
		
		    theOption.title="<?php echo $row2['code'];?>";
			myselect1.options.add(theOption);
  
				
	
				  var theOption1=new Option("<?php echo $row2['description'];?>","<?php echo $row2['description'];?>");
		
		    theOption1.title="<?php echo $row2['description'];?>";
			myselect2.options.add(theOption1);
  



					 }



   <?php  } echo "}"; } echo "}"; } ?>



}




function getdescriptionven(a)

{

var id1 = a.split("/");

var index1 = id1[1]; 

alert(index1);



document.getElementById('description/' + index1).value = "";


document.getElementById("cash/"+index1).value="";

document.getElementById("cash/"+index1).style.visibility="hidden";

 document.getElementById('po/' + index1).options.length=1;

  myselect1 = document.getElementById("po/" + index1);			 

  
   

document.getElementById('quantity/' + index1).value = "";

document.getElementById('balqty/' + index1).value = "";
    

<?php $query1 = "select distinct(code),vendor,deliverylocation from pp_purchaseorder WHERE flag = '1' AND grflag = '0' order by code ASC"; $result1 = mysql_query($query1,$conn);

      while($row1 = mysql_fetch_assoc($result1)) {

	    echo "if((document.getElementById('itemcode/' + index1).value == '$row1[code]') && (document.getElementById('vendor').value == '$row1[vendor]') && (document.getElementById('warehouse').value == '$row1[deliverylocation]')) { ";

  	      $query2 = "select distinct(description),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where code = '$row1[code]' and vendor ='$row1[vendor]' AND flag = '1' AND grflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and deliverylocation='$row1[deliverylocation]'";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

		while($row2 = mysql_fetch_assoc($result2)) { ?>

   document.getElementById('description/' + index1).value = "<?php echo $row2['description']; ?>";
<?php  }?>

  <?php $query2 = "select distinct(po),sum(quantity) as qty, sum(receivedquantity) as recqty,rateperunit from pp_purchaseorder where code = '$row1[code]' and vendor ='$row1[vendor]' AND flag = '1' AND grflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and deliverylocation='$row1[deliverylocation]' group by po";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

		while($row2 = mysql_fetch_assoc($result2)) { $balqty=$row2['qty']-$row2['recqty']; ?>
	
	
				  var theOption=new Option("<?php echo $row2['po']; ?>","<?php echo $row2['po']."@".$balqty; ?>");
		
		  
			myselect1.options.add(theOption);
	
	



  

<?php }  echo "}"; } ?>





}

function getvendor(a)
{

var vendor=document.getElementById("vendor");


 document.getElementById('vendor').options.length=1;
 
 
   document.getElementById("itemcode/0").options.length=1;

   myselect1 = document.getElementById("itemcode/0");			 

   

   

  document.getElementById("description/0").options.length=1;

   myselect2 = document.getElementById("description/0");			 

 
 

var warehouse=document.getElementById(a).value;


 myselect1 = document.getElementById("vendor");			 

  



<?php

$q="select distinct(deliverylocation) from pp_purchaseorder where grflag = '0' and deliverylocation <> '' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) order by deliverylocation";
$res=mysql_query($q,$conn);
while($row=mysql_fetch_array($res))
{
?>

if(warehouse=="<?php echo $row['deliverylocation'];?>")
{
<?php

$q1="select distinct(vendor) from pp_purchaseorder where grflag='0' and  deliverylocation='$row[deliverylocation]'";
$res1=mysql_query($q1,$conn);
while($row1=mysql_fetch_array($res1))
{

?>


				  var theOption=new Option("<?php echo $row1['vendor']; ?>","<?php echo $row1['vendor']; ?>");
		
		  
			myselect1.options.add(theOption);
	


<?php } ?>

}

<?php } ?>

}

function getcodeven(a)

{

var id1 = a.split("/");

var index1 = id1[1];



document.getElementById('itemcode/' + index1).value = "";

document.getElementById("cash/"+index1).value="";

document.getElementById("cash/"+index1).style.visibility="hidden";

 document.getElementById('po/' + index1).options.length=1;

  myselect1 = document.getElementById("po/" + index1);			 

  


 

<?php $query1 = "select distinct(description),vendor,deliverylocation from pp_purchaseorder WHERE flag = '1' AND grflag = '0' order by code ASC"; $result1 = mysql_query($query1,$conn);

      while($row1 = mysql_fetch_assoc($result1)) {

	    echo "if((document.getElementById('description/' + index1).value == '$row1[description]') && (document.getElementById('vendor').value == '$row1[vendor]') && (document.getElementById('warehouse').value == '$row1[deliverylocation]')) { ";

  	      $query2 = "select distinct(code),po,(quantity - receivedquantity) as balqty,rateperunit from pp_purchaseorder where description = '$row1[description]' and vendor ='$row1[vendor]' AND flag = '1' AND grflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and deliverylocation='$row1[deliverylocation]'";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

		while($row2 = mysql_fetch_assoc($result2)) { ?>

    document.getElementById('itemcode/' + index1).value = "<?php echo $row2['code']; ?>";
	
	
	
	<?php  } ?>
	
	  <?php $query2 = "select distinct(po),sum(quantity) as qty, sum(receivedquantity) as recqty,rateperunit from pp_purchaseorder where description = '$row1[description]' and vendor ='$row1[vendor]' AND flag = '1' AND grflag = '0' AND (quantity <> receivedquantity or receivedquantity = '' or receivedquantity = 0) and deliverylocation='$row1[deliverylocation]' group by po ";

		$result2 = mysql_query($query2,$conn) or die(mysql_error());

		while($row2 = mysql_fetch_assoc($result2)) { $balqty=$row2['qty']-$row2['recqty']; ?>
	
	


				  var theOption=new Option("<?php echo $row2['po']; ?>","<?php echo $row2['po']."@".$row2['balqty']; ?>");
		
		  
			myselect1.options.add(theOption);
	


   

   

<?php }  echo "}"; } ?>



}








function compare(a,b)

{

var id1 = a.split("/");

var index1 = id1[1];

document.getElementById("cash/"+index1).style.visibility="hidden";
document.getElementById("fricode/"+index1).style.visibility="hidden";
document.getElementById("freightamt/"+index1).value=0;
document.getElementById("freightie/"+index1).value="";
document.getElementById("freightamt/"+index1).setAttribute("readonly",true);
for(var i = 0; i <=index;i++)

{

	for(var j = 0; j <=index;j++)

	{

		if( i != j )

		{

			if((document.getElementById('description/' + i).value == document.getElementById('description/' + j).value) && (document.getElementById('po/'+i).value == document.getElementById('po/'+j).value))

			{
			
			
			alert(document.getElementById('itemcode/' + i).value);
			alert(document.getElementById('itemcode/' + j).value);
			alert(document.getElementById('po/' + i).value);
			alert(document.getElementById('po/' + i).value);
			
			document.getElementById('itemcode/' + index1).value = "";

			document.getElementById('description/' + index1).value = "";

			document.getElementById('po/' + index1).value = "";
			document.getElementById('balqty/' + index1).value = "";
			
			document.getElementById('quantity/' + index1).value = "";
			alert("Please select different combination");

			return false;

			}

		}

	}

}

var temp = b.split('@');

document.getElementById('balqty/'+index1).value = temp[1];


var po1=temp[0];
<?php
$query="select distinct(code),description,po,deliverylocation,vendor from pp_purchaseorder";
$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{?>


			if(	(document.getElementById('description/' +index1).value == "<?php echo $row['description'];?>") && (po1 == "<?php echo $row['po'];?>" ) &&(document.getElementById('warehouse').value=="<?php echo $row['deliverylocation'];?>") && (document.getElementById('vendor').value=="<?php echo $row['vendor'];?>") )
			
			{
			
		
			<?php
			
				$query1="select freightie from pp_purchaseorder where code='$row[code]'and  po='$row[po]' and deliverylocation='$row[deliverylocation]' and vendor='$row[vendor]'";
				
				$result1=mysql_query($query1,$conn);
				while($row1=mysql_fetch_array($result1))
				{
				
				?>
				document.getElementById("freightie/"+index1).value="<?php echo $row1['freightie'];?>";
				
				<?php
			if($row1['freightie']=="Include" || $row1['freightie']=="Exclude")
			{
			?>	var amt=document.getElementById("freightamt/"+index1);
				amt.removeAttribute('readonly','readonly');;
				
			document.getElementById("cash/"+index1).style.visibility="visible";
			<?php } 
			if($row1['freightie']=="Exclude" || $row1['freightie']=="Exclude Paid By Supplier")
			{
			?>
			var amt=document.getElementById("freightamt/"+index1);
				amt.removeAttribute('readonly','readonly');;
				
			document.getElementById("fricode/"+index1).style.visibility="visible";
			
				 <?php  }  ?>
				
				<?php } ?>
			}

<?php 
}

?>




}



function checkform( )

{

if(document.getElementById('vehicleno').value == "")

{

alert("Enter vehicle number");
return false;
}



for(var j=0;j<=index;j++)
{

if(document.getElementById("po/"+j).value!="")
if(Number(document.getElementById("quantity/"+j).value)==0)
{

alert("please enter quantity"+(j+1));
return false;
}


if(document.getElementById("freightie/"+j).value!="")
if(Number(document.getElementById("freightamt/"+j).value)==0)
{

alert("please enter freight amount"+(j+1));
return false;
}



if(document.getElementById("freightie/"+j).value=="Include" ||document.getElementById("freightie/"+j).value=="Exclude")
if(Number(document.getElementById("cash/"+j).value)==0)
{

alert("please select cash"+(j+1));
return false;
}

if(document.getElementById("freightie/"+j).value=="Exclude" ||document.getElementById("freightie/"+j).value=="Exclude Paid By Supplier")
if(Number(document.getElementById("fricode/"+j).value)==0)
{

alert("please select freight code"+(j+1));
return false;
}




}

document.getElementById('Save').disabled=true;
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

