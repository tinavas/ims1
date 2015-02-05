<?php 
include "config.php";
include "jquery.php";

session_start();
$client = $_SESSION['client'];
$tid = $_GET['id'];

 $query1 = "select * from ims_intermediatereceipt WHERE riflag = 'R' and tid = '$tid' and client = '$client' ";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
 $datemain = date("d.m.Y",strtotime($row1['date']));
 $empname=$row1['empname'];
 $docno=$row1['docno'];
 }

$i=0;

$q1=mysql_query("SET group_concat_max_len=10000000");

//getting cat,itemcodes
$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes  group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);




//getting warehouses

	    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 $i=0;
		if($sectorlist=="")  
$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse'";
else

$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse' and sector in ($sectorlist)";


 $res1 = mysql_query($q1,$conn); 

$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);



		 	$q = "select group_concat(code,'@',description order by code) as coacd from ac_coa where type like 'Expense'  and description not like '%Cost of Good%' and  description not like '%Sales%' or code='OP001'";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			$qr = mysql_fetch_assoc($qrs);
			$coacd=explode(",",$qr['coacd']);
			$codedesc1=json_encode($coacd);
			

?>
<script type="text/javascript">
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;

var sectors1=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;

var codedesc=<?php if(empty($codedesc1)){echo 0;} else{ echo $codedesc1; }?>;

</script>

<br>
<br>


<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" method="post" action="ims_updateintermediatereceipt.php" onsubmit="return warehousechecking()" >	
	 <input type="hidden" name="cuser" id="cuser" value="<?php echo $globalrow['empname'];?>"  />	
	 
	  <h1>Intermediate Receipt</h1>
		
		
		<br />
<b>Intermediate Receipt</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
  


<br /><br />

<table>
<tr>
<td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td width="10px"></td>

<td><input type="text" size="15" id="date" name="date" value="<?php echo $datemain; ?>" class="datepicker" />
<input type="hidden" name="cuser" id="cuser" value="<?php echo $empname;?>" />
</td>
<td width="10px"></td>

				<td><strong>Doc No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td><input type="text" id="doc" name="doc" value="<?php echo $docno; ?>"/></td>
         
</tr>
</table>

<br>
<br>
 <table border="0" id="maintable">
     <tr>
        <th style=""><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>

		<th style=""><strong>Units</strong></th>
        <th width="10px"></th>

		
        <th style=""><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
 
 
        <th style=""><strong>Rate/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>

        <th style=""><strong>COA</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>

      
		<th style=""><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
		</tr>

     <tr style="height:20px"></tr>
	 <input type="hidden" name="tid" id="tid" value="<?php echo $tid;?>"/>
	 <?php 
 $i=-1;
	$catSelected="";
	$q =  "select * from ims_intermediatereceipt WHERE riflag = 'R' and tid = '$tid' and client = '$client' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$cat1 = $qr['cat'];
	$i++;
 
?>
    <tr>
 
       <td style="text-align:left;">
         <select name="cat[]" id="cat@<?php echo $i; ?>" onchange="loadcodes(this.id);" style="width:90px;">
           <option value="">-Select-</option>
		  <?php 
		   for($j=0;$j<count($items);$j++)
{
?>
<option value="<?php echo $items[$j]["cat"]; ?>"  <?php if($cat1 == $items[$j]["cat"]) { ?> selected=selected <?php } ?> ><?php echo $items[$j]["cat"]; ?></option>
<?php } ?>
		   

         </select>    </td>
       <td width="10px"></td>

       <td >
         <select name="code[]" id="code@<?php echo $i; ?>" onchange="loaddescription(this.id,this.value);" style="width:80px;">
           <option value="">-Select-</option>
		 
		 <?php
for($j=0;$j<count($items);$j++)
{
if($items[$j]["cat"] == $cat1) {	
	$cd1=explode(",",$items[$j]["cd"]);
	for($k=0;$k<count($cd1);$k++)
	
	{
	 $code1=explode("@",$cd1[$k]);
?>
<option value="<?php echo $cd1[$k]; ?>"  <?php if($code1[0]==$qr['code']){ ?> selected="selected"<?php }?>  ><?php echo $code1[0]; ?></option>
<?php } } } ?>
		 
	   
         </select>       </td>
       <td width="10px"></td>

       <td >

		 <select name="description[]" id="description@<?php echo $i; ?>" style="width:100px" onchange="getcode(this.id,this.value);">
	   <option value="">-Select-</option>
	   		 
		 <?php
for($j=0;$j<count($items);$j++)
{
if($items[$j]["cat"] == $cat1) {	
	$cd1=explode(",",$items[$j]["cd"]);
	for($k=0;$k<count($cd1);$k++)
	
	{
	 $code1=explode("@",$cd1[$k]);
?>
<option value="<?php echo $cd1[$k]; ?>"  <?php if($code1[1]==$qr['description']){ ?> selected="selected"<?php }?>  ><?php echo $code1[1]; ?></option>
<?php } } } ?>

	   </select>       </td>
	   
       <td width="10px"></td>
	   
	     <td >
         <input type="text" name="units[]" id="units@<?php echo $i; ?>" value="<?php echo $qr['units']; ?>"  size="8" readonly style="background:none; border=0px;" />       </td>
       <td width="10px"></td>


       <td >
         <input type="text" name="quantity[]" id="quantity@<?php echo $i; ?>"  onkeyup="decimalrestrict(this.id,this.value)" value="<?php echo $qr['quantity']; ?>" size="8"  />       </td>
       <td width="10px"></td>

     
       <td >
         <input type="text" name="rateperunit[]" id="rateperunit@<?php echo $i; ?>" onkeyup="decimalrestrict(this.id,this.value)"  value="<?php echo $qr['rateperunit']; ?>" size="6" onfocus = "makeRow(this.id)" />       </td>
       <td width="10px"></td>

       <td >
         <select name="coa[]" id="coa@<?php echo $i; ?>">
		 <option value="">-Select-</option>
		 
		 
		  <?php 
		
		 for($l=0;$l<count($coacd);$l++)
		   {
			$coacd1=explode("@",$coacd[$l]);
           ?><option value="<?php echo $coacd1[0]; ?>" <?php  if ( $qr['coa'] == $coacd1[0]) {?> selected="selected" <?php } ?>  title="<?php echo $coacd1[1]; ?>"><?php echo $coacd1[0]; ?></option>
<?php } ?>

		 </select>       </td>
       <td width="10px"></td>

   <td>
         <select name="warehouse[]" id="warehouse@<?php echo $i; ?>">
		 <option value="" >-Select-</option>
		 <?php 
		
		 for($j=0;$j<count($sec1);$j++)
		   {
 ?><option value="<?php echo $sec1[$j]; ?>" <?php  if ( $qr['warehouse'] == $sec1[$j] ) {?> selected="selected" <?php } ?>  title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php }

?>

         </select>       </td>
<td width="10px">&nbsp;</td>
	  
<td>&nbsp;</td>
    </tr>
	 <?php
	  } ?>
   </table>
<br>
<br>

   <input type="submit" value="Update" id="save" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_intermediatereceipt';">

</form>
</div>
</section>
</center>

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addintermediatereceipt.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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


<script type="text/javascript">

function decimalrestrict(a,b)
{
/*var expr=/^[0-9][.]*/;
/*if(!b.match(expr)){
alert("enter only numbers");
document.getElementById(a).value==0;}*/
var a1=b.split(".");
var a2=a1[1];
if(a1.length>1)
if(a2.length>5)
{
var b2=a2.length-5;
document.getElementById(a).value=b.substr(0,b.length-b2);
}
return true;
}
function warehousechecking()
{
  
  if(document.getElementById('date').value=="")
{

	alert("Select date");
	return false;

}
if(document.getElementById('doc').value=="")
  {
  
  	alert("Enter document number");
	return false;
  
  }



	  var cat =document.getElementById("cat@0").value;
	  var code=document.getElementById("code@0").value;
	  var desc=document.getElementById("description@0").value;
	
var quantity=document.getElementById("quantity@0").value;
	  var rate=document.getElementById("rateperunit@0").value;
	   var coa=document.getElementById("coa@0").value;
	     var warehouse=document.getElementById("warehouse@0").value;
	  if(cat=="" ||code=="" || desc=="" || quantity=="" ||quantity==0 || coa=="" || rate=="" || rate==0 || warehouse=="")
	  {alert("select all the fields of 1st row");
	  return false;
	  }
	  
	for(j=0;j<index;j++)
	{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("description@"+j).value;
	
	var qty=document.getElementById("quantity@"+j).value;
	var rate=document.getElementById("rateperunit@"+j).value;
	   var coa=document.getElementById("coa@"+j).value;
    var warehouse=document.getElementById("warehouse@"+j).value;
	
	if(cat=="" || code== "" || desc==""  ||qty=="" || qty=="" || coa=="" || rate=="" || rate==0 || warehouse=="" )
	{
	
	alert("Please fill the all fields of row "+(j+1));
	
		return false;
		}
	

}
	
document.getElementById("save").disabled=true;	



}

function loadcodes(id)
{


	var index1;
	var id1 = id.split("@");
	index1 = id1[1];
	var cat = document.getElementById(id).value;

	
	document.getElementById('units@' + index1).value = "";
	
	
	removeAllOptions(document.getElementById("code@" + index1));
	myselect1 = document.getElementById("code@" + index1);
   
	removeAllOptions(document.getElementById('description@' + index1));
	myselect2 = document.getElementById('description@' + index1);
    
	
	
	
var l=items.length;		  
for(i=0;i<l;i++)
{
if(items[i].cat == cat)
{
var ll=items[i].cd.split(",");
for(j=0;j<ll.length;j++)
{ 
var expp=ll[j].split("@");
var op1=new Option(expp[0],ll[j]);

op1.title=expp[0];

var op2=new Option(expp[1],ll[j]);

op2.title=expp[1];

document.getElementById("code@" + index1).options.add(op1);
document.getElementById("description@" + index1).options.add(op2);
}
}
}
	
	
	
}

function getcode(codeid,value)
{


	  var temp = codeid.split("@");
     var tempindex = temp[1];
	 var temp2 = value.split("@");

if(value=="")

{

document.getElementById('code@' + tempindex).value = "";
document.getElementById('description@' +tempindex).value="";
document.getElementById("units@"+tempindex).value="";
				return false;

}

for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		
		if( i != j)
		{
			if(document.getElementById('description@' + i).value == document.getElementById('description@' + j).value)
			{
				
				
				alert("Please select different combination");
				document.getElementById('code@' + tempindex).value = "";
				document.getElementById('description@' +tempindex).value="";
				document.getElementById("units@"+tempindex).value="";
				return false;
			}
		}
	}
}

 document.getElementById("units@"+tempindex).value = temp2[2];
     document.getElementById("code@" + tempindex).value = document.getElementById("description@" + tempindex).value;
	


}
function loaddescription(codeid,value)
{


	 var temp = codeid.split("@");
     var tempindex = temp[1];
	 var temp2 = value.split("@");

if(value=="")

{

document.getElementById('code@' + tempindex).value = "";
document.getElementById('description@' +tempindex).value="";
document.getElementById("units@"+tempindex).value="";
				return false;

}

for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		
		if( i != j)
		{
			if(document.getElementById('code@' + i).value == document.getElementById('code@' + j).value)
			{
				
				
				alert("Please select different combination");
				document.getElementById('code@' + tempindex).value = "";
				document.getElementById('description@' +tempindex).value="";
				document.getElementById("units@"+tempindex).value="";
				return false;
			}
		}
	}
}


	 document.getElementById("units@"+tempindex).value = temp2[2];
     document.getElementById("description@" + tempindex).value = document.getElementById("code@" + tempindex).value;


		
}


function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length;i>0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


var index=<?php echo $i;?>;

function makeRow(a)
{


for(j=0;j<=index;j++)
{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("description@"+j).value;
	
	var qty=document.getElementById("quantity@"+j).value;
	
	if(cat=="" || code== "" || desc==""  ||qty=="" || qty==0)
	
		return false;
	

}

 var temp=a.split('@');
 var id=temp[1];

if(id!=index)
return false;

var temp=id.split('@');
id=temp[1];

index=index+1;
	var mytable = document.getElementById('maintable');
	var myrow = document.createElement('tr');
	var mytd = document.createElement('td');
	
	/////// Category /////////
	
	var myselect1 = document.createElement("select");
	myselect1.id = "cat@" + index;
	myselect1.name = "cat[]";
	myselect1.onchange = function () { loadcodes(this.id); };
	myselect1.style.width = "90px";
	
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	
	for(i=0;i<items.length;i++)
{

 var theOption=new Option(items[i].cat,items[i].cat);
		
		
myselect1.options.add(theOption);

} 
	
	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	/////// Codes /////////
	mytd = document.createElement('td');
	
	myselect1 = document.createElement("select");
	myselect1.id = "code@" + index;
	myselect1.name = "code[]";
	myselect1.onchange = function () { loaddescription(this.id,this.value); };
	myselect1.style.width = "80px";
	
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	/////// Description /////////

	mytd = document.createElement('td');
	var input = document.createElement("select");
	input.id = "description@" + index;
	input.name = "description[]";
	//input.setAttribute ("width","100px");
	input.style.width = "100px";
	input.onchange = function (){ getcode(this.id,this.value);};
	option1 = document.createElement("option");
	data = document.createTextNode("-Select-");
	option1.value="";
	option1.appendChild(data);
	input.appendChild(option1);
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	
	
	/////////////// Units /////////////
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "units@" + index;
	input.name = "units[]";
	input.size = "8";
	input.setAttribute("readonly");
	input.style.background="none";
	input.style.border="0px";
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	
	
	//////////// Quantity //////////////
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "quantity@" + index;
	input.name = "quantity[]";
	
	input.size = "8";
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);

	
	
	
	
	
	
	/////////// Rate/Unit ////////
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "rateperunit@" + index;
	input.name = "rateperunit[]";
	input.size = "6";
	input.onfocus = function () { makeRow(this.id); };
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	/////// COA /////////
	mytd = document.createElement('td');
	
	myselect1 = document.createElement("select");
	myselect1.id = "coa@" + index;
	myselect1.name = "coa[]";
			
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	
for(i=0;i<codedesc.length;i++)
{
var codedesc1=codedesc[i].split("@");
 var theOption=new Option(codedesc1[0],codedesc1[0]);
		
		
myselect1.options.add(theOption);

} 
	

	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	




/////// Warehouse /////////
	mytd = document.createElement('td');
	
	myselect1 = document.createElement("select");
	myselect1.id = "warehouse@" + index;
	myselect1.name = "warehouse[]";
	//myselect1.style.width = "80px";
	
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);


for(i=0;i<sectors1.length;i++)
{

 var theOption=new Option(sectors1[i],sectors1[i]);
		
		
myselect1.options.add(theOption);

} 
	

	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);


	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	


	mytable.appendChild(myrow);

}

</script>
</script>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>