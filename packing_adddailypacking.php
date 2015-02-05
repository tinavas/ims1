<?php
include "jquery.php";

// code to fetch all codes

$q1=mysql_query("set group_concat_max_len=1000000");

$q1="SELECT cat,group_concat(code,'$',description,'$',sunits separator '*') as cd FROM `ims_itemcodes` where source like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula`) group by cat";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

$allcodes[]=array("cat"=>$r1['cat'],"cd"=>$r1['cd']);

}


$allcodesj=json_encode($allcodes);


//--------------------------------

//get coa codes

$q2="select group_concat(code,'$',description separator '*') as codes from ac_coa where type='Expense'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$expensecoa=explode("*",$r2['codes']);

$expensecoaj=json_encode($expensecoa);

//---------------

//get the contractors-------

$q2="select group_concat(name,'$',contractor_coacode separator '*') as contractor from contactdetails where contractor='YES'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$contractor=explode("*",$r2['contractor']);

$contractorj=json_encode($contractor);


//------------------------------------

?>

<script type="text/javascript">

var allcodesj=<?php echo $allcodesj;?>;

var expensecoaj=<?php echo $expensecoaj;?>;

var contractorj=<?php echo $contractorj;?>;


</script>
<section class="grid_8">
  <div class="block-border">
<center>
<form class="block-content form" method="post" action="packing_savedailypacking.php"  onSubmit="return checkform()">
  <h1>Daily Packing</h1>
  
  <br/><br/>
<b>Add Daily Packing Details</b></br></br>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br/><br/><br/>

<strong> Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" class="datepicker" style="width:100px" onChange="comparedate('fromdate')">&nbsp;&nbsp;&nbsp;

<strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="location" id="location">
<option value="">-Select-</option>
<?php
if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 
	 if($sectorlist=="")   
				
				$query = "SELECT distinct(sector) FROM tbl_sector where type1='Warehouse'  ORDER BY sector ASC";
				
				else
				
				$query = "SELECT distinct(sector) FROM tbl_sector where type1='Warehouse' and sector in ($sectorlist) ORDER BY sector ASC";
           

$q1=mysql_query($query) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['sector'];?>" title="<?php echo $r1['sector'];?>"><?php echo $r1['sector'];?></option>

<?php }?>



</select>




</br></br></br></br></br></br>

<table id="tab">
<tr>
<td><strong>Labour</strong></td>
<td><strong>Contractor<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

<td style="width:20px"></td>


<td><strong>Category<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

<td style="width:20px"></td>

<td><strong>Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Units<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>



<td style="width:20px"></td>

<td><strong>Packets<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>



<td style="width:20px"></td>

<td><strong>Coa Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>



</tr>

<tr style="height:20px"></tr>

<tr>

<td><input type="checkbox" name="" id="checkcb@0" value="YES" onclick="hidecandc(this.id,this.checked)" />

<input type="hidden" name="checkcb[]" id="checkcbd@0" value="NO"/>

&nbsp;&nbsp;</td>


<td id="contractortid@0">



<select name="contractor[]" id="contractor@0" style="width:150px" onChange="loadcoacode(this.id);">
<option value="">-Select-</option>
<?php

for($i=0;$i<count($contractor);$i++)
{


$contract_arr=explode('$',$contractor[$i]);
?>


<option value="<?php echo $contract_arr[0];?>" title="<?php echo $contract_arr[1];?>" ><?php echo $contract_arr[0];?></option>

<?php }?>

</select>

</td>

<td style="width:20px"></td>



<td>
<select name="category[]" id="cat@0" style="width:150px" onchange="getcodes(this.id,this.value)">
<option value="">-Select-</option>
<?php

for($i=0;$i<count($allcodes);$i++)
{



?>


<option value="<?php echo $allcodes[$i]['cat'];?>" title="<?php echo $allcodes[$i]['cat'];?>" ><?php echo $allcodes[$i]['cat'];?></option>

<?php }?>

</select>

</td>

<td style="width:20px"></td>

<td>
<select name="code[]" id="code@0" style="width:150px" onChange="selectcode(this.id,this.value)">
<option value="">-Select-</option>


</select>

</td>

<td style="width:20px"></td>

<td>
<select name="description[]" id="description@0" style="width:150px" onChange="selectdesc(this.id,this.value)">
<option value="">-Select-</option>


</select>

</td>


<td style="width:20px"></td>

<td>
<input type="text" name="units[]" id="units@0" style="width:100px;border:none;background:none" readonly="readonly" />
</td>



<td style="width:20px"></td>

<td>
<input type="text" name="packets[]" id="packets@0" style="width:100px;" onfocus="return dynamic(this.id)" onkeyup="checknum(this.id,this.value)" />
</td>

<td style="width:20px"></td>

<td id="coacodetid@0">
<select name="coacode[]" id="coacode@0" style="width:150px">
<option value="">-Select-</option>
<?php
for($i=0;$i<count($expensecoa);$i++)
{
$codedesc=explode("$",$expensecoa[$i]);

?>

<option value="<?php echo $codedesc[0];?>" title="<?php echo $codedesc[1];?>"><?php echo $codedesc[0];?></option>

<?php }?>


</select>

</td>

</tr>

</table>
<br/><br/><br/>



<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=packing_dailypacking'"  id="cancel"/>
</form>
</center>
</div>
</section>
<script type="text/javascript">

function comparedate(value)
{

var fromdate=document.getElementById("fromdate").value;

var todate=document.getElementById("todate").value;

if(fromdate!="" && todate!="")
 {
 
   var fdate=fromdate.split(".");
   
   var formfdate=fdate[2]+"/"+fdate[1]+"/"+fdate[0];
   
   var tdate=todate.split(".");
   
   var formtdate=tdate[2]+"/"+tdate[1]+"/"+tdate[0];

  var ff=new Date(formfdate);
  
  var tt=new Date(formtdate);
  
  if(ff.getTime()>tt.getTime() || tt.getTime()<ff.getTime() )
  {
   if(value=="fromdate")
    {
    alert("Todate Should be greater Than fromdate");
   
    document.getElementById("fromdate").value="";
   
     document.getElementById("fromdate").focus();
	
	return false;
	}
	
	if(value=="todate")
   {
    alert("Todate Should be greater Than fromdate");
	
   document.getElementById("todate").value="";
   
    document.getElementById("todate").focus();
	
	return false;
	}
   
   
   }
  }
 }
 
 index=0;
 
 function dynamic(id)
{
 
 var id1=id.split("@");
 
 var id2=id1[1];
 
 if(Number(id2)!=index)
 {
 return false;
 }
 
 
 index=index+1;
 
 var tab=document.getElementById("tab");
 
  var tr=tab.insertRow(tab.rows.length);
  
  tr.style.height="15px";
 
 var tr=tab.insertRow(tab.rows.length);
 
 var j=0;
 
 //for checkboxes
 
 var checkcb=tr.insertCell(j++);
 
 checkcb.style.textAlign="left";
 
 var checkbox=document.createElement("input");
 
 checkbox.type="checkbox";
 
 checkbox.name="";
 
 checkbox.id="checkcb@"+index;
 
 checkbox.value="YES";
 
 checkbox.setAttribute("onclick","hidecandc(this.id,this.checked)");
 
 checkcb.appendChild(checkbox);
 
 
 //for hiden checkbox
 
 var checkbox=document.createElement("input");
 
 checkbox.type="hidden";
 
checkbox.name="checkcb[]";
 
 checkbox.id="checkcbd@"+index;
 
 checkbox.value="NO";
 

  checkcb.appendChild(checkbox);
  //------------------
 
 
 
 //--------------
 
 //for contractor
  var contractor=tr.insertCell(j++);
  
  contractor.id="contractortid@"+index;
 
 var select1=document.createElement("select");
 
 select1.name="contractor[]";
 
 select1.id="contractor@"+index;
 
 select1.style.width="150px";
  select1.setAttribute("onchange","loadcoacode(this.id)");

var op=new Option("-Select-","");
 
  select1.add(op);
 
 for(i=0;i<contractorj.length;i++)
 
 {
 var contract_arr=contractorj[i].split('$');
 var op=new Option(contract_arr[0],contract_arr[0]);
 
 op.title=contract_arr[0];
 
 select1.add(op);
 
 }
 
 contractor.appendChild(select1);
 //----------------
 
 var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 
 
 //for category
 
 var cat=tr.insertCell(j++);
 
 var select1=document.createElement("select");
 
 select1.name="category[]";
 
 select1.id="cat@"+index;
 
 select1.style.width="150px";
 
 select1.setAttribute("onchange","getcodes(this.id,this.value)");
 
 var op=new Option("-Select-","");
 
  select1.add(op);
 
 for(i=0;i<allcodesj.length;i++)
 
 {
 
 var op=new Option(allcodesj[i].cat,allcodesj[i].cat);
 
 op.title=allcodesj[i].cat;
 
 select1.add(op);
 
 }
 
 
cat.appendChild(select1);
 //----------------
 
 var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 
 //code-------------------
 
  var code=tr.insertCell(j++);
 
 var select1=document.createElement("select");
 
 select1.name="code[]";
 
 select1.id="code@"+index;
 
 select1.setAttribute("onchange","selectcode(this.id,this.value)");
 
 select1.style.width="150px";
 
 var op=new Option("-Select-","");
 
  select1.add(op);
 
 
code.appendChild(select1);
 
 //--------------------------
 
 var tt=tr.insertCell(j++);
 
 tt.style.width="20px";

//description----

var desc=tr.insertCell(j++);
 
 var select1=document.createElement("select");
 
 select1.name="description[]";
 
 select1.id="description@"+index;
 
 select1.setAttribute("onchange","selectdesc(this.id,this.value)");
 
 select1.style.width="150px";
 
 var op=new Option("-Select-","");
 
  select1.add(op);
 
 
desc.appendChild(select1);

//-----------------

var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
//units------------

var units=tr.insertCell(j++);

var input=document.createElement("input");

input.type="text";
 
input.name="units[]";

input.setAttribute("readonly","true");

input.id="units@"+index;

input.setAttribute("style","width:100px;border:none;background:none");

units.appendChild(input);

//-------------


var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 //------packets-------

var packets=tr.insertCell(j++);

var input=document.createElement("input");

input.type="text";
 
input.name="packets[]";

input.id="packets@"+index;

input.setAttribute("style","width:100px;");

input.setAttribute("onfocus","return dynamic(this.id)");

packets.appendChild(input);

//---------------


var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 


 //for contractor
  var coacode=tr.insertCell(j++);
  
  coacode.id="coacodetid@"+index;
 
 var select1=document.createElement("select");
 
 select1.name="coacode[]";
 
 select1.id="coacode@"+index;
 
 select1.style.width="150px";
 

var op=new Option("-Select-","");
 
  select1.add(op);
 
 for(i=0;i<expensecoaj.length;i++)
 
 {
 
 expcd=expensecoaj[i].split('$');
 
 var op=new Option(expcd[0],expcd[0]);
 
 op.title=expcd[1];
 
 select1.add(op);
 
 }
 
 coacode.appendChild(select1);
 //----------------



}

function getcodes(id,value)
{

var id=id.split("@");

var id1=id[1];

document.getElementById("code@"+id1).options.length=1;

document.getElementById("description@"+id1).options.length=1;

for(i=0;i<allcodesj.length;i++)
{
if(allcodesj[i].cat==value)
{

var codes=allcodesj[i].cd.split("*");

for(j=0;j<codes.length;j++)
{

var codes2=codes[j].split("$");

var op1=new Option(codes2[0],codes2[0]);

op1.title=codes2[1];

var op2=new Option(codes2[1],codes2[1]);

op2.title=codes2[1];

document.getElementById("code@"+id1).options.add(op1);

document.getElementById("description@"+id1).options.add(op2);


}

}
}

}


function selectcode(id,value)
{

var id=id.split("@");

var id1=id[1];

//alert(index);

for(i=0;i<=index;i++)
{
if(i!=Number(id1))
{
if(document.getElementById("code@"+i).value==value)
{
alert("Same code should not be selected");
document.getElementById("code@"+id1).options[0].selected="selected";
document.getElementById("description@"+id1).options[0].selected="selected";
document.getElementById("units@"+id1).value="";
return false;
}
}
}

var l=document.getElementById("code@"+id1).options.selectedIndex;


document.getElementById("description@"+id1).options[l].selected="selected";


for(i=0;i<allcodesj.length;i++)
{
var codes=allcodesj[i].cd.split("*");
for(j=0;j<codes.length;j++)
{
var codes2=codes[j].split("$");

if(codes2[0]==value)
{

document.getElementById("units@"+id1).value=codes2[2];
}
}

}

}

function selectdesc(id,value)
{

var id=id.split("@");

var id1=id[1];

//alert(index);


var l=document.getElementById("description@"+id1).options.selectedIndex;


document.getElementById("code@"+id1).options[l].selected="selected";

var value=document.getElementById("code@"+id1).value;

for(i=0;i<=index;i++)
{
if(i!=Number(id1))
{
if(document.getElementById("code@"+i).value==value)
{
alert("Same code should not be selected");
document.getElementById("code@"+id1).options[0].selected="selected";
document.getElementById("description@"+id1).options[0].selected="selected";
document.getElementById("units@"+id1).value="";
return false;
}
}
}

for(i=0;i<allcodesj.length;i++)
{
var codes=allcodesj[i].cd.split("*");
for(j=0;j<codes.length;j++)
{
var codes2=codes[j].split("$");

if(codes2[0]==value)
{

document.getElementById("units@"+id1).value=codes2[2];
}
}

}

}

function checkform()
{


if(document.getElementById("date").value=="")
{
alert("Enter  Date");
document.getElementById("date").value="";
document.getElementById("date").focus();
return false;
}
if(document.getElementById("location").value=="")
{
alert("Select Location");
document.getElementById("location").value="";
document.getElementById("location").focus();
return false;
}


if(index==0)
{
loop=0;
}
else
{
loop=index-1;
}


for(i=0;i<=loop;i++)
{

if(!document.getElementById("checkcb@"+i).checked)

 {
  if(document.getElementById("contractor@"+i).value=="")
   {
     alert("Select Contractor");
     document.getElementById("contractor@"+i).value="";
     document.getElementById("contractor@"+i).focus();
     return false;
    }
 
 
 }





if(document.getElementById("cat@"+i).value=="")
{
alert("Select Category");
document.getElementById("cat@"+i).value="";
document.getElementById("cat@"+i).focus();
return false;
}

if(document.getElementById("code@"+i).value=="")
{
alert("Select Code");
document.getElementById("code@"+i).value="";
document.getElementById("code@"+i).focus();
return false;
}

if(document.getElementById("description@"+i).value=="")
{
alert("Select Description");
document.getElementById("description@"+i).value="";
document.getElementById("description@"+i).focus();
return false;
}





if(document.getElementById("packets@"+i).value=="")
{
alert("Enter Packets");
document.getElementById("packets@"+i).value="";
document.getElementById("packets@"+i).focus();
return false;
}

if(!document.getElementById("checkcb@"+i).checked)

 {
  if(document.getElementById("coacode@"+i).value=="")
   {
     alert("Select Coacode");
     document.getElementById("coacode@"+i).value="";
     document.getElementById("coacode@"+i).focus();
     return false;
    }
 
 
 }



}

document.getElementById("save").disabled="true";
document.getElementById("cancel").disabled="true";

}

function checknum(id,value)
{
var reg=new RegExp("^[0-9\.]+$");
if(value!="")
{
if(!reg.test(value))
{
alert("Enter Numbers Only");

document.getElementById(id).value="";
document.getElementById(id).focus();

return false;
}
}
}


function hidecandc(id,check)
{

 id1=id.split('@');
 
 ind=id1[1];
 
 
 document.getElementById("checkcbd@"+ind).value="NO";
 
 document.getElementById("coacodetid@"+ind).style.visibility="visible";
 
 document.getElementById("contractortid@"+ind).style.visibility="visible";

 if(check)
 {
 
  document.getElementById("checkcbd@"+ind).value="YES";
  
  document.getElementById("coacode@"+ind).options[0].selected="selected";
  
  document.getElementById("contractor@"+ind).options[0].selected="selected";
 
  document.getElementById("coacodetid@"+ind).style.visibility="hidden";
 
  document.getElementById("contractortid@"+ind).style.visibility="hidden";

 }

}

function loadcoacode(id_r)
{
	var id=id_r.split("@");
	check_contractor=document.getElementById("contractor@"+id[1]).value;
	removeAllOptions(document.getElementById('coacode@' + id[1]));
	for(var i=0;i<contractorj.length;i++)
	{	
		var name_arr=contractorj[i].split('$');
		if(name_arr[0]==check_contractor)
		{
			var op1=new Option(name_arr[1],name_arr[1]);

			op1.title=name_arr[0];
			op1.setAttribute("selected","selected");
			
			document.getElementById("coacode@"+id[1]).options.add(op1);
		}
	}
}
function removeAllOptions(selectbox)
{
	for(var i=selectbox.options.length;i>0;i--)
		selectbox.remove(i);
}
</script>