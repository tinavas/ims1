<?php 
include "config.php";
include "jquery.php";
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
		 	$q = "select group_concat(code,'@',description order by code) as coacd from ac_coa  where type like 'Expense' ";
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
     <form class="block-content form" id="complex_form" method="post" action="ims_saveintermediatereceipt.php" onsubmit="return warehousechecking();" >		
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

<td><input type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" class="datepicker" />
</td>
<td width="10px"></td>
	<td><strong>Doc No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td><input type="text" id="doc" name="doc"  size="7"/></td>
				<td width="10px"></td>
</tr>
</table>

<br>
<br>
 <table border="0" id="maintable">
     <tr>
       <th style=""><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
 
    <th style=""><strong>Item Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
  
   <th style=""><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
        <th style=""><strong>Units</strong></th>
        <th width="10px"></th>

      <th style=""><strong>Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
 

     <th style=""><strong>Rate/Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>

        <th style=""><strong>COA<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>

       
		<th style=""><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
         <select name="cat[]" id="cat@0" onchange="loadcodes(this.id);" style="width:90px;">
           <option value="">-Select-</option>
<?php
for($i=0;$i<count($items);$i++)
{
?>
<option value="<?php echo $items[$i]["cat"]; ?>"><?php echo $items[$i]["cat"]; ?></option>
<?php } ?>
</select>   </td>
       <td width="10px"></td>

       <td >
         <select name="code[]" id="code@0" onchange="loaddescription(this.id,this.value);" style="width:80px;">
           <option value="">-Select-</option>
         </select>       </td>
       <td width="10px"></td>

       <td >
         <?php /*?><input type="text" name="description[]" id="description@0" readonly size="25"  /> <?php */?>
		 <select name="description[]" id="description@0" style="width:100px" onchange="getcode(this.id,this.value);">
	   <option value="">-Select-</option>
	   </select>       </td>
       <td width="10px"></td>

	          <td ><input type="text" name="units[]" id="units@0"  size="8" readonly style="background:none; border:0px;" /></td>
       <td width="10px"></td>

	   
       <td >
         <input type="text" name="quantity[]" id="quantity@0"  size="8" onkeyup="decimalrestrict(this.id,this.value)" onkeypress="return num(this.id,event.keyCode)"  />       </td>
       <td width="10px"></td>


       <td >
         <input type="text" name="rateperunit[]" id="rateperunit@0" size="6" onkeyup="decimalrestrict(this.id,this.value)" onkeypress="return num(this.id,event.keyCode)" onfocus = "makeRow(this.id)" />       </td>
       <td width="10px"></td>

       <td >
         <select name="coa[]" id="coa@0">
		 <option value="">-Select-</option>
		 
		 
		 
		 <?php
		 
		 		   for($j=0;$j<count($coacd);$j++)
		   {
			$coacd1=explode("@",$coacd[$j]);
           ?>
<option value="<?php echo $coacd1[0];?>" title="<?php echo $coacd1[1]; ?>"><?php echo $coacd1[0]; ?></option>
<?php } ?> 
		 
		 </select>       </td>
   
       <td width="10px"></td>
   <td>
         <select name="warehouse[]" id="warehouse@0">
		 <option  value="">-Select-</option>
		 <?php 
		   for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>" title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php } ?> 
         </select>       </td>

       <td width="10px"></td>

	<td>&nbsp;</td>
    </tr>
   </table>
<br>
<br>

   <input type="submit" value="Save" id="save" />
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
/*var regx=/\d{0,10}(\.\d{1,2})?/;
if(!b.match(regx))
{
alert("sdfds");
}*/
var a1=b.split(".");
var a2=a1[1];
if(a1.length>1)
if(a2.length>3)
{
var b2=a2.length-3;
document.getElementById(a).value=b.substr(0,b.length-b2);
}
}
function num(a,b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}
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
	  if(cat=="" ||code=="" || desc=="" || quantity=="" ||quantity==0 || coa=="" || rate=="" || rate==0 || warehouse==""){
	  alert("select all the fields of 1st row"); return false;
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
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length;i>0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}
var index = 0;
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

index = index + 1 ;

	var mytable = document.getElementById('maintable');
	var myrow = document.createElement('tr');
	var mytd = document.createElement('td');
	
	/////// Category /////////
	
	var myselect1 = document.createElement("select");
	myselect1.id = "cat@" + index;
	myselect1.name = "cat[]";
	myselect1.onchange = function () { loadcodes(this.id); };
	myselect1.style.width = "90px";
	 var op1=new Option("-Select-","");
myselect1.options.add(op1);
	
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
	 var op1=new Option("-Select-","");
myselect1.options.add(op1);
	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	

	mytd = document.createElement('td');
	var input = document.createElement("select");
	input.id = "description@" + index;
	input.name = "description[]";
	//input.setAttribute ("width","100px");
	input.style.width = "100px";
	input.onchange = function (){ getcode(this.id,this.value);};

	 var op1=new Option("-Select-","");
input.options.add(op1);
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
	input.style.background="none";
	input.style.border="0px";
	input.setAttribute("readonly");
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
	input.onkeypress=function(){return num(this.id,event.keyCode);};
	input.onkeyup=function(){return decimalrestrict(this.id,this.value);};
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
	input.onkeypress=function(){return num(this.id,event.keyCode);};
	input.onkeyup=function(){return decimalrestrict(this.id,this.value);};
	input.onfocus = function () {makeRow(this.id); };
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
 var op1=new Option("-Select-","");
myselect1.options.add(op1);

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