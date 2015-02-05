<?php
include "jquery.php";

// code to fetch all codes
$q1="SELECT cat,group_concat(code,'$',description,'$',sunits separator '*') as cd FROM `ims_itemcodes` where iusage like '%sale%' group by cat";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

$allcodes[]=array("cat"=>$r1['cat'],"cd"=>$r1['cd']);

}


$allcodesj=json_encode($allcodes);




//--------------------------------





if($_GET['date']<>"")
{
$fromdate=date("d.m.Y",strtotime($_GET['date']));
}
else
{
$fromdate=date("d.m.Y");
}


if($_GET['superstockist']<>"")
{
$superstockist=$_GET['superstockist'];
}




//Getting distributors names

 $q1="SELECT group_concat(name separator '*') as names FROM `distribution_distributor` where areacode in (SELECT areacode FROM `distribution_area` where superstockist='$superstockist')";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$allnames=explode("*",$r1['names']);

$allnamesj=json_encode($allnames);

//--------------------




?>

<script type="text/javascript">

var allcodesj=<?php echo $allcodesj;?>;

</script>

<div align="center">
<br/><br/>
<h1>Add Distributor Stock </h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br/>


<form  method="post" action="distribution_savedistributorstock.php"  onSubmit="return checkform()">


<strong>Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" style="width:100px" value="<?php echo $fromdate;?>" class="datepicker"  />&nbsp;&nbsp;&nbsp;

<strong>CNF/Super Stockist<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="superstockist" id="superstockist"  onchange="reloadpage()">
<option value="">-Select-</option>
<?php

$q1="SELECT name FROM `contactdetails` where superstockist='YES' and type like '%party%' ";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

?>

<option value="<?php echo $r1['name'];?>" <?php if($superstockist==$r1['name']){?> selected="selected" <?php }?>><?php echo $r1['name'];?></option>

<?php


 }?>



</select>&nbsp;&nbsp;&nbsp;



<strong>Distributor<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="distributor" id="distributor" >
<option value="">-Select-</option>
<?php
for($i=0;$i<count($allnames);$i++)
{
?>
<option value="<?php echo $allnames[$i];?>"><?php echo $allnames[$i];?></option>
<?php }?>


</select>&nbsp;&nbsp;&nbsp;

</br></br>

<table id="tab">
<tr>
<td><strong>Category<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

<td style="width:20px"></td>

<td><strong>Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Units<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Stock<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

</tr>

<tr style="height:20px"></tr>

<tr>

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

<td style="height:20px"></td><br />

<td>
<select name="code[]" id="code@0" style="width:150px" onChange="selectcode(this.id,this.value)">
<option value="">-Select-</option>


</select>

</td>

<td style="height:20px"></td><br />

<td>
<select name="description[]" id="description@0" style="width:150px" onChange="selectdesc(this.id,this.value)">
<option value="">-Select-</option>


</select>

</td>


<td style="height:20px"></td><br />

<td>
<input type="text" name="units[]" id="units@0" style="width:100px;border:none;background:none"  readonly="readonly"/>
</td>

<td style="height:20px"></td><br />

<td>
<input type="text" name="stock[]" id="stock@0" style="width:100px" onfocus="return dynamic(this.id)" onkeyup="checknum(this.id,this.value)" />
</td>


</tr>

</table>
<br/><br/><br/>

<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=distribution_distributorstock'" id="cancel"/>

</div>
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
 
input.name="units[]";

input.setAttribute("readonly","true");

input.id="units@"+index;

input.setAttribute("style","width:100px;border:none;background:none");

units.appendChild(input);

//-------------


var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 //------stock-------

var stock=tr.insertCell(j++);

var input=document.createElement("input");
 
input.name="stock[]";

input.id="stock@"+index;

input.setAttribute("style","width:100px;");

input.setAttribute("onfocus","return dynamic(this.id)");

input.setAttribute("onkeyup","checknum(this.id,this.value)");

stock.appendChild(input);

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



if(document.getElementById("superstockist").value=="")
{
alert("Select Superstockist");
document.getElementById("superstockist").value="";
document.getElementById("superstockist").focus();
return false;
}

if(document.getElementById("distributor").value=="")
{
alert("Select Distributor");
document.getElementById("distributor").value="";
document.getElementById("distributor").focus();
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

if(document.getElementById("stock@"+i).value=="")
{
alert("Enter Stock");
document.getElementById("stock@"+i).value="";
document.getElementById("stock@"+i).focus();
return false;
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

function reloadpage()
{
var date=document.getElementById("date").value;

var superstockist=document.getElementById("superstockist").value;

document.location="dashboardsub.php?page=distribution_adddistributorstock&date="+date+"&superstockist="+superstockist;

}


</script>