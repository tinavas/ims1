<?php
include "jquery.php";

include "distribution_getsuperstockist_singh.php";

include "get_allcategoriesjson_singh.php";

$q1=mysql_query("SET group_concat_max_len=10000000");

$trnum=$_GET['trnum'];

$q1="select date,superstockist,docno,trnum,narration,distributor from distribution_stockissuetodistributor where trnum='$trnum' limit 1";

$q1=mysql_query($q1) or die(mysql_error());

$details=mysql_fetch_assoc($q1);

$qdb=mysql_query("select fromdate,todate,customer,cat,code,price from oc_pricemaster");
while($rdb=mysql_fetch_array($qdb))
{
$f=$rdb[fromdate];
$t=$rdb[todate];
$dbs[]=array("fromdate"=>$f,"todate"=>$t,"warehouse"=>$rdb[customer],"category"=>$rdb[cat],"code"=>$rdb[code],"price"=>$rdb[price]);
}
$db=json_encode($dbs);


//--------------------------------


if($_GET['date']<>"")
{
$date=date("d.m.Y",strtotime($_GET['date']));
}
else
{
$date=date("d.m.Y",strtotime($details['date']));
}

if($_GET['superstockist']<>"")
{
$superstockist=$_GET['superstockist'];
}
else
{
$superstockist=$details['superstockist'];
}


if($_GET['docno']<>"")
{
$docno=$_GET['docno'];
}
else
{

$docno=$details['docno'];
}



//grnrrate trnum



$trnum=$details['trnum'];


//

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

var allnamesj=<?php echo $allnamesj;?>;

var dbs=<?php if(empty($db)){echo "0";} else{ echo $db; }?>;

</script>

<center>
<section class="grid_8">
  <div class="block-border">




<form class="block-content form" method="post" action="distribution_savestockissuedistributor.php"  onSubmit="return checkform()">

<h1>Stock Issue To Distributor</h1>

<b>Edit Stock Issue To Distributor</b><br/><br/>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/><br/>

<input type="hidden"  name="edit" value="1" />

<input type="hidden" name="oldid" value="<?php echo $trnum;?>" />


<strong>Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" style="width:100px" value="<?php echo $date;?>" class="datepickerDIS"  />&nbsp;&nbsp;&nbsp;

<strong>CNF/Super Stockist<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="superstockist" id="superstockist" onChange="reloadpage()" >
<option value="">-Select-</option>
<?php

for($i=0;$i<count($authorizedsuperstockist);$i++)
{

?>

<option value="<?php echo $authorizedsuperstockist[$i];?>" <?php if($superstockist==$authorizedsuperstockist[$i]) {?> selected="selected" <?php }?>><?php echo $authorizedsuperstockist[$i];?></option>

<?php


 }?>



</select>&nbsp;&nbsp;&nbsp;



&nbsp;&nbsp;&nbsp;

<strong>Distributor<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="distributor" id="distributor" style="width:150px" >
<option value="">-Select-</option>

<?php
for($i=0;$i<count($allnames);$i++)
{
?>
<option value="<?php echo $allnames[$i];?>" title="<?php echo $allnames[$i];?>" <?php if($allnames[$i]==$details['distributor']) {?> selected="selected" <?php }?>><?php echo $allnames[$i];?></option>

<?php }?>


</select>&nbsp;&nbsp;&nbsp;


<strong>DOC.No<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="docno" id="docno" style="width:100px" value="<?php echo $docno;?>" />&nbsp;&nbsp;&nbsp;

<strong>Tr.No<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="trnum" id="trnum" style="width:100px;background:none;border:none" readonly="true" value="<?php echo $trnum;?>"  />&nbsp;&nbsp;&nbsp;


</br></br><br/><br/>

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

<td><strong>Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

<td style="width:20px"></td>

<td><strong>Price/Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

</tr>
<?php
$k=-1;

 $q1="select *  from  distribution_stockissuetodistributor where trnum='$trnum'";

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

<td style="width:20px"></td>

<td>
<select name="code[]" id="code@<?php echo $k;?>" style="width:150px" onChange="selectcode(this.id,this.value),getprice(this.id)">
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

<td style="width:20px"></td>

<td>
<select name="description[]" id="description@<?php echo $k;?>" style="width:150px" onChange="selectdesc(this.id,this.value),getprice(this.id)">
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


<td style="width:20px"></td>

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


<td style="width:20px"></td>

<td>
<input type="text" name="stock[]" id="stock@<?php echo $k;?>" style="width:100px" onfocus="return dynamic(this.id)" onkeyup="checknum(this.id,this.value)" value="<?php echo $result['quantity'];?>" />
</td>



<td style="width:20px"></td>

<td>
<input type="text" name="rateperunit[]" id="rateperunit@<?php echo $k;?>"  style="width:100px;border:none;background:none" readonly="readonly" value="<?php echo $result['rateperunit'];?>" />
</td>


</tr>
<?php }?>
</table>
<br/><br/><br/>

<strong>Narration:</strong><textarea name="narration" id="narration"><?php echo $details['narration'];?></textarea><br/><br/><br/>

<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=distribution_stockissuedistributor'" id="cancel" />
</form>
</div>
</section></center>
<script type="text/javascript">
function getprice(id)
{
//alert(id);
var ind=id.split("@");
var fdate=document.getElementById('date').value;
var aaa=document.getElementById('superstockist').value;
var cat=document.getElementById('cat@'+ind[1]).value;
var code=document.getElementById('code@'+ind[1]).value;

var fd=fdate.split(".");
var fd1=fd[2]+"/"+fd[1]+"/"+fd[0];
if(dbs!=null)
for(k=0;k<dbs.length;k++)
{
var dbf=dbs[k].fromdate.split("-");
var dbt=dbs[k].todate.split("-");
var dbf1=dbf[0]+"/"+dbf[1]+"/"+dbf[2];
var dbt1=dbt[0]+"/"+dbt[1]+"/"+dbt[2];
var dbfdate=new Date(dbf1);
var dbtdate=new Date(dbt1);
var fdate1=new Date(fd1);
//alert(aa[0]);
if((dbfdate.getTime()<=fdate1.getTime()  &&  dbs[k].warehouse==aaa &&   dbs[k].code==code )|| ( dbtdate.getTime()>=fdate1.getTime() &&  dbs[k].warehouse==aaa &&   dbs[k].code==code ))
{
document.getElementById('rateperunit@'+ind[1]).value=dbs[k].price;
} 
else
{
}
}
if(document.getElementById('rateperunit@'+ind[1]).value=="")
{
alert("No Price in Price Masters");
}
}
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
 
 select1.setAttribute("onchange","selectcode(this.id,this.value),getprice(this.id)");
 
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
 
 select1.setAttribute("onchange","selectdesc(this.id,this.value),getprice(this.id)");
 
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


//-------------




var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 //------stock-------

var rateperunit=tr.insertCell(j++);

var input=document.createElement("input");
 
input.name="rateperunit[]";

input.id="rateperunit@"+index;

input.setAttribute("readonly","true");

input.setAttribute("style","width:100px;border:none;background:none");

rateperunit.appendChild(input);





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


if(document.getElementById("docno").value=="")
{
alert("Enter Doc Number");
document.getElementById("docno").value="";
document.getElementById("docno").focus();
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
alert("Enter Quantity");
document.getElementById("stock@"+i).value="";
document.getElementById("stock@"+i).focus();
return false;
}



if(document.getElementById("rateperunit@"+i).value=="")
{
alert("Enter Price/Unit");
document.getElementById("rateperunit@"+i).value="";
document.getElementById("rateperunit@"+i).focus();
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

var superstockist=document.getElementById("superstockist").value;


var date=document.getElementById("date").value;

var docno=document.getElementById("docno").value

document.location="dashboardsub.php?page=distribution_editstockissuedistributor&superstockist="+superstockist+"&date="+date+"&docno="+docno+"&trnum=<?php echo $_GET['trnum'];?>";




}


</script>