<?php
include "jquery.php";

// code to fetch all codes
$q1="SELECT cat,group_concat(code,'$',description,'$',sunits separator '*') as cd FROM `ims_itemcodes` where source like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula`) group by cat";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

$allcodes[]=array("cat"=>$r1['cat'],"cd"=>$r1['cd']);

}


$allcodesj=json_encode($allcodes);


//--------------------------------

$id=$_GET['id'];

$q2="select * from packing_packingcost where id='$id'";

$q2=mysql_query($q2) or die(mysql_error());

$details=mysql_fetch_assoc($q2);

//--------------------------------

$q1="SELECT name as cont FROM `contactdetails` where contractor='YES'";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

$allconts[]=array("cont"=>$r1['cont']);

}


$allcontsj=json_encode($allconts);



?>

<script type="text/javascript">

var allcodesj=<?php echo $allcodesj;?>;

var allconts=<?php echo $allcontsj;?>;

</script>
<section class="grid_8">
  <div class="block-border">
<center>



<form  method="post" action="packing_savepackingcost.php"  onSubmit="return checkform()" class="block-content form">

<h1>Packing Cost</h1>

<b>Edit Packing Cost Details</b></br/></br/>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br/><br/><br/>

<input type="hidden" name="edit" value="1">

<input type="hidden" name="oldid" value="<?php echo $id;?>">

<strong>From Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="fromdate" id="fromdate" class="datepicker" style="width:100px" onChange="comparedate('fromdate')" value="<?php echo date("d.m.Y",strtotime($details['fromdate']));?>">


<strong>To Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="todate" id="todate" class="datepicker" style="width:100px" onChange="comparedate('todate')" value="<?php echo date("d.m.Y",strtotime($details['todate']));?>">



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

<option value="<?php echo $r1['sector'];?>" title="<?php echo $r1['sector'];?>" <?php if($details['location']==$r1['sector']){?> selected="selected"<?php }?>><?php echo $r1['sector'];?></option>

<?php }?>



</select>




</br></br></br></br></br></br>

<table id="tab">
<tr>
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

<td><strong>Cost<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

</tr>
<?php

$k=0;

?>

<tr style="height:20px"></tr>

<tr>
<td>
<select name="contractor[]" id="cont@0" style="width:150px">
<option value="">-Select-</option>
<?php

for($j=0;$j<count($allconts);$j++)
{
?>
<option value="<?php echo $allconts[$j]['cont'];?>" title="<?php echo $allconts[$j]['cont'];?>"  <?php if($details['contractor']==$allconts[$j]['cont']){?> selected="selected"<?php }?>><?php echo $allconts[$j]['cont'];?></option>
<?php }?>

</select>

</td>

<td style="width:20px"></td>
<td>


<select name="category[]" id="cat@<?php echo $k;?>" style="width:150px" onchange="getcodes(this.id,this.value)">
<option value="">-Select-</option>
<?php

for($i=0;$i<count($allcodes);$i++)
{
?>


<option value="<?php echo $allcodes[$i]['cat'];?>" title="<?php echo $allcodes[$i]['cat'];?>" <?php if($details['category']==$allcodes[$i]['cat']){?> selected="selected"<?php }?> ><?php echo $allcodes[$i]['cat'];?></option>

<?php }?>

</select>

</td>

<td style="width:20px"></td>

<td>
<select name="code[]" id="code@<?php echo $k;?>" style="width:150px" onChange="selectcode(this.id,this.value)">
<option value="">-Select-</option>
<?php
for($i=0;$i<count($allcodes);$i++)
{
if($allcodes[$i]['cat']==$details['category'])
{
$all=explode("*",$allcodes[$i]['cd']);

for($c=0;$c<count($all);$c++)
{
$codes=explode("$",$all[$c]);

$code=$codes[0];
?>

<option value="<?php echo $code;?>" <?php if($code==$details['code']){?> selected="selected" <?php }?> title="<?php echo $code;?>"><?php echo $code;?></option>

<?php }} }?>

</select>

</td>

<td style="width:20px"></td>

<td>
<select name="description[]" id="description@<?php echo $k;?>" style="width:150px" onChange="selectdesc(this.id,this.value)">
<option value="">-Select-</option>
<?php
for($i=0;$i<count($allcodes);$i++)
{
if($allcodes[$i]['cat']==$details['category'])
{
$all=explode("*",$allcodes[$i]['cd']);

for($c=0;$c<count($all);$c++)
{
$codes=explode("$",$all[$c]);

$desc=$codes[1];
?>

<option value="<?php echo $desc;?>" <?php if($desc==$details['description']){?> selected="selected" <?php }?> title="<?php echo $desc;?>"><?php echo $desc;?></option>

<?php }} }?>

</select>

</td>


<td style="width:20px"></td>

<td>

<?php
for($i=0;$i<count($allcodes);$i++)
{
if($allcodes[$i]['cat']==$details['category'])
{
$all=explode("*",$allcodes[$i]['cd']);

for($c=0;$c<count($all);$c++)
{
$codes=explode("$",$all[$c]);

$code=$codes[0];

if($code==$details['code'])
{
?>
<input type="text" name="units[]" id="units@<?php echo $k;?>" style="width:100px;border:none;background:none" value="<?php echo $codes[2];?>" readonly="readonly" />
<?php }}} }?>


</td>


<td style="width:20px"></td>

<td>
<!-- Enable below if you want add dynamic rows in edit page
<input type="text" name="cost[]" id="cost@0" style="width:100px;" onfocus="return dynamic(this.id)" />-->


<input type="text" name="cost[]" id="cost@<?php echo $k;?>" style="width:100px;" value="<?php echo $details['cost'];?>"  />

</td>

</tr>

</table>

<br/><br/><br/>

<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=packing_packingcost'"  id="cancel"/>
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
 
 //for Contractor
 
  var cont=tr.insertCell(j++);
 
 var select1=document.createElement("select");
 
 select1.name="contractor[]";
 
 select1.id="cont@"+index;
 
 select1.style.width="150px";
 
 var op=new Option("-Select-","");
 
  select1.add(op);
 
 for(i=0;i<allconts.length;i++)
 
 {
 
 var op=new Option(allconts[i].cont,allconts[i].cont);
 
 op.title=allconts[i].cont;
 
 select1.add(op);
 
 }
 
 
cont.appendChild(select1);
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
 
input.name="units[]";

input.setAttribute("readonly","true");

input.id="units@"+index;

input.setAttribute("style","width:100px;border:none;background:none");

units.appendChild(input);

//-------------


var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 //------stock-------

var cost=tr.insertCell(j++);

var input=document.createElement("input");
 
input.name="cost[]";

input.id="cost@"+index;

input.setAttribute("style","width:100px;");

input.setAttribute("onfocus","return dynamic(this.id)");

cost.appendChild(input);





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

if(document.getElementById("fromdate").value=="")
{
alert("Enter From Date");
document.getElementById("fromdate").value="";
document.getElementById("fromdate").focus();
return false;
}
if(document.getElementById("todate").value=="")
{
alert("Enter To Date");
document.getElementById("todate").value="";
document.getElementById("todate").focus();
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





if(document.getElementById("cost@"+i).value=="")
{
alert("Enter Cost");
document.getElementById("cost@"+i).value="";
document.getElementById("cost@"+i).focus();
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




</script>