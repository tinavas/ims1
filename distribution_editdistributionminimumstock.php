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


$trnum=$_GET['trnum'];

$q1="select fromdate,todate,areacode,areaname from  distribution_stocklevel where trnum='$trnum' limit 1";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$fromdate=date("d.m.Y",strtotime($r1['fromdate']));

$todate=date("d.m.Y",strtotime($r1['todate']));

$area=$r1['areacode'];

$areaname=$r1['areaname'];

?>

<script type="text/javascript">

var allcodesj=<?php echo $allcodesj;?>;

</script>

<div align="center">


<br/><br/>
<h1>Edit Distribution Minimum Stock Level</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br/>


<form  method="post" action="distribution_savedistributionminimumstock.php"  onSubmit="return checkform()">


<input type="hidden" name="edit" value="1" />

<input type="hidden" name="oldid" value="<?php echo $trnum;?>" />

<strong>From Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="fromdate" id="fromdate" style="width:100px" value="<?php echo $fromdate;?>" class="datepicker"  onChange="comparedate('fromdate')" />&nbsp;&nbsp;&nbsp;

<strong>To Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="todate" id="todate" style="width:100px" value="<?php echo $todate;?>" class="datepicker" onChange="comparedate('todate')"/>&nbsp;&nbsp;&nbsp;


<strong>Area Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="area" id="area"  onchange="document.getElementById('areaname').options[document.getElementById('area').options.selectedIndex].selected='selected';" >
<option value="">-Select-</option>
<?php

$q1="SELECT areacode as name FROM `distribution_area`  where areacode not in (select distinct areacode from distribution_stocklevel where trnum!='$trnum') ";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

?>

<option value="<?php echo $r1['name'];?>" <?php if($area==$r1['name']) {?> selected="selected" <?php }?>><?php echo $r1['name'];?></option>

<?php }?>
</select>


<strong>Area Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="areaname" id="areaname" onchange="document.getElementById('area').options[document.getElementById('areaname').options.selectedIndex].selected='selected';" >
<option value="">-Select-</option>
<?php

$q1="SELECT areacode as name,areaname FROM `distribution_area`  where areacode not in (select distinct areacode from distribution_stocklevel where trnum!='$trnum') ";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

?>

<option value="<?php echo $r1['areaname'];?>" <?php if($areaname==$r1['areaname']) {?> selected="selected" <?php }?>><?php echo $r1['areaname'];?></option>

<?php }?>
</select>



</br></br></br></br>
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


<?php

$k=-1;

 $q1="select *  from  distribution_stocklevel where trnum='$trnum'";

$q1=mysql_query($q1) or die(mysql_error());

while($result=mysql_fetch_assoc($q1))
{

$k++;

?>
<tr style="height:20px"></tr>

<tr>

<td>
<select name="category[]" id="cat@<?php echo $k;?>" style="width:150px" onchange="getcodes(this.id,this.value)">
<option value="">-Select-</option>
<?php

for($i=0;$i<count($allcodes);$i++)
{
?>


<option value="<?php echo $allcodes[$i]['cat'];?>" title="<?php echo $allcodes[$i]['cat'];?>" <?php if($allcodes[$i]['cat']==$result['category']) {?> selected="selected" <?php }?> ><?php echo $allcodes[$i]['cat'];?></option>

<?php }?>

</select>

</td>

<td style="height:20px"></td>

<td>
<select name="code[]" id="code@<?php echo $k;?>" style="width:150px" onChange="selectcode(this.id,this.value)">
<option value="">-Select-</option>
<?php
for($i=0;$i<count($allcodes);$i++)
{
if($allcodes[$i]['cat']==$result['category'])
{
$all=explode("*",$allcodes[$i]['cd']);

for($c=0;$c<count($all);$c++)
{
$codes=explode("$",$all[$c]);

$code=$codes[0];
?>

<option value="<?php echo $code;?>" <?php if($code==$result['code']){?> selected="selected" <?php }?> title="<?php echo $code;?>"><?php echo $code;?></option>

<?php }} }?>

</select>

</td>

<td style="height:20px"></td>

<td>
<select name="description[]" id="description@<?php echo $k;?>" style="width:150px" onChange="selectdesc(this.id,this.value)">
<option value="">-Select-</option>
<?php
for($i=0;$i<count($allcodes);$i++)
{
if($allcodes[$i]['cat']==$result['category'])
{
$all=explode("*",$allcodes[$i]['cd']);

for($c=0;$c<count($all);$c++)
{
$codes=explode("$",$all[$c]);

$desc=$codes[1];
?>

<option value="<?php echo $desc;?>" <?php if($desc==$result['description']){?> selected="selected" <?php }?> title="<?php echo $desc;?>"><?php echo $desc;?></option>

<?php }} }?>

</select>

</td>


<td style="height:20px"></td>

<td>

<?php
for($i=0;$i<count($allcodes);$i++)
{
if($allcodes[$i]['cat']==$result['category'])
{
$all=explode("*",$allcodes[$i]['cd']);

for($c=0;$c<count($all);$c++)
{
$codes=explode("$",$all[$c]);

$code=$codes[0];

if($code==$result['code'])
{
?>
<input type="text" name="units[]" id="units@<?php echo $k;?>" style="width:100px;border:none;background:none" value="<?php echo $codes[2];?>" readonly="readonly" />
<?php }}} }?>


</td>

<td style="height:20px"></td>

<td>
<input type="text" name="stock[]" id="stock@<?php echo $k;?>" style="width:100px" onfocus="return dynamic(this.id)" onkeyup="checknum(this.id,this.value)" value="<?php echo $result['stock'];?>" />
</td>


</tr>

<?php 


}?>
</table>
<br/><br/><br/>

<input type="submit"  value="Update" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=distribution_distributionminimumstock'"id="cancel" />

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
 
 index=<?php echo $k;?>;
 
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

input.id="units@"+index;

input.setAttribute("readonly","true");

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
//alert(id1);

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

//alert(id1);

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


if(document.getElementById("area").value=="")
{
alert("Select area");
document.getElementById("area").value="";
document.getElementById("area").focus();
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




</script>