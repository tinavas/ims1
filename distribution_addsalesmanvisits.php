<?php


include "timepicker.php";

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

if($_GET['area']<>"")
{
$area=$_GET['area'];
}

if($_GET['areaname']<>"")
{
$areaname=$_GET['areaname'];
}

if($_GET['distributor']<>"")
{
$distributor=$_GET['distributor'];
}





//Getting distributors names

 $q1="SELECT group_concat(name separator '*') as names FROM `distribution_distributor` where areacode in (SELECT areacode FROM `distribution_area` where superstockist='$superstockist' and areacode='$area')";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$allnames=explode("*",$r1['names']);

$allnamesj=json_encode($allnames);

//----------------------------------------------




?>

<script type="text/javascript">

var allcodesj=<?php echo $allcodesj;?>;

</script>

<div align="center">
<br/><br/>
<h1>Add Sales Man Visits</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br/>


<form  method="post" action="distribution_savesalesmanvisits.php"  onSubmit="return checkform()">


<strong>Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" style="width:100px" value="<?php echo $fromdate;?>" class="datepicker"  />&nbsp;&nbsp;&nbsp;

<strong>CNF/Super Stockist<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="superstockist" id="superstockist"  onchange="reloadpage('superstockist')">
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



<strong>Area Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="area" id="area"  onchange="document.getElementById('areaname').options[this.selectedIndex].selected='selected';reloadpage('areacode')" >
<option value="">-Select-</option>
<?php
$q1="SELECT areacode,areaname FROM `distribution_area` where superstockist='$superstockist'";

$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['areacode'];?>" <?php if($area==$r1['areacode']){?> selected="selected" <?php }?>><?php echo $r1['areacode'];?></option>
<?php }?>


</select>&nbsp;&nbsp;&nbsp;


<strong>Area Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="areaname" id="areaname"  onchange="document.getElementById('area').options[this.selectedIndex].selected='selected';reloadpage('areaname')" >
<option value="">-Select-</option>
<?php
$q1="SELECT areacode,areaname FROM `distribution_area` where superstockist='$superstockist'";

$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['areaname'];?>" <?php if($areaname==$r1['areaname']){?> selected="selected" <?php }?>><?php echo $r1['areaname'];?></option>
<?php }?>


</select>&nbsp;&nbsp;&nbsp;




<strong>Distributor<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="distributor" id="distributor" onchange="reloadpage('distributor')" >
<option value="">-Select-</option>
<?php
for($i=0;$i<count($allnames);$i++)
{
?>
<option value="<?php echo $allnames[$i];?>" <?php if($distributor==$allnames[$i]){?> selected="selected" <?php }?>><?php echo $allnames[$i];?></option>
<?php }?>


</select>&nbsp;&nbsp;&nbsp;



<strong>Shop<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="shop" id="shop" >
<option value="">-Select-</option>
<?php
$q1="select name from distribution_shop where superstockist='$superstockist' and distributor='$distributor' and areacode='$area'";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{

?>
<option value="<?php echo $r1['name'];?>" title="<?php echo $r1['name'];?>"><?php echo $r1['name'];?></option>
<?php }?>

</select>&nbsp;&nbsp;&nbsp;


<br/><br/><br/><br/>



<strong>Sales Man<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="salesman" id="salesman" >
<option value="">-Select-</option>
<?php
$q1="SELECT salesman FROM `distribution_salesman` where superstockist='$superstockist' and areacode='$area'";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['salesman'];?>"><?php echo $r1['salesman'];?></option>

<?php }?>





</select>&nbsp;&nbsp;&nbsp;

<input type="radio" name="order" value="YES" id="order1" onclick="displaytable('1')"  />&nbsp;&nbsp;<strong>Order</strong>

<input type="radio" name="order" value="NO" id="order2" onclick="displaytable('0')" />&nbsp;&nbsp;<strong>No Order</strong>


&nbsp;&nbsp;&nbsp;

<strong>Time<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="time" id="time" style="width:100px;" class="timepicker"/>


</br>

<table id="tab" style="display:none">
<tr>
<td><strong>Category<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

<td style="width:20px"></td>

<td><strong>Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Units<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

<td><strong>Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

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
<input type="text" name="units[]" id="units@0" style="width:100px;border:none;background:none" readonly="readonly" />
</td>

<td style="height:20px"></td><br />

<td>
<input type="text" name="stock[]" id="stock@0" style="width:100px" onfocus="return dynamic(this.id)" onkeyup="checknum(this.id,this.value)" />
</td>


</tr>

</table>
<br/><br/><br/>

<strong>Narration:&nbsp;&nbsp;</strong><textarea name="narration" id="narration"></textarea>

<br/><br/><br/>
<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=distribution_salesmanvisits'" id="cancel" />

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

input.id="units@"+index;

input.setAttribute("style","width:100px;border:none;background:none");

input.setAttribute("readonly","true");

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



if(document.getElementById("area").value=="")
{
alert("Select Area");
document.getElementById("area").value="";
document.getElementById("area").focus();
return false;
}

if(document.getElementById("distributor").value=="")
{
alert("Select Distributor");
document.getElementById("distributor").value="";
document.getElementById("distributor").focus();
return false;
}


if(document.getElementById("shop").value=="")
{
alert("Select Shop");
document.getElementById("shop").value="";
document.getElementById("shop").focus();
return false;
}


if(document.getElementById("salesman").value=="")
{
alert("Select Sales Man");
document.getElementById("salesman").value="";
document.getElementById("salesman").focus();
return false;
}



if(!document.getElementById("order1").checked && !document.getElementById("order2").checked)
{
alert("Select Order or No Order");
return false;
}

if(document.getElementById("time").value=="")
{
alert("Enter Time");
document.getElementById("time").value="";
document.getElementById("time").focus();
return false;
}


if(document.getElementById("order1").checked)
{

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

function reloadpage(val)
{




var date=document.getElementById("date").value;

var superstockist=document.getElementById("superstockist").value;

var area=document.getElementById("area").value;

var areaname=document.getElementById("areaname").value;

var distributor=document.getElementById("distributor").value;


document.location="dashboardsub.php?page=distribution_addsalesmanvisits&date="+date+"&superstockist="+superstockist+"&area="+area+"&areaname="+encodeURIComponent(areaname)+"&distributor="+distributor;

}

function displaytable(status)
{

document.getElementById("tab").style.display="none";

if(status=="1")
{
document.getElementById("tab").style.display="";
}
if(status=="0")
{
document.getElementById("tab").style.display="none";
}



}


</script>