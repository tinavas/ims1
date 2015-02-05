<?php
include "jquery.php";

include "distribution_getsuperstockist_singh.php";

include "get_allcategoriesjson_singh.php";






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

$allnamesd=json_encode($allnames);

//--------------------




?>

<script type="text/javascript">


var allnames=<?php echo $allnamesd;?>;

</script>

<center>
<section class="grid_8">
  <div class="block-border">
<br/><br/>


<br/><br/><br/>


<form class="block-content form"  method="post" action="distributor_saveob.php"  onSubmit="return checkform()">


<h1>Distributor Opening Balence</h1>

<b>Add Distributor Opening Balence</b><br/><br/>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/><br/>

<strong>Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" style="width:100px" value="<?php echo $fromdate;?>" class="datepicker" />&nbsp;&nbsp;&nbsp;

<strong>CNF/Super Stockist<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="superstockist" id="superstockist"  onchange="reloadpage()">
<option value="">-Select-</option>
<?php

for($i=0;$i<count($authorizedsuperstockist);$i++)
{

?>

<option value="<?php echo $authorizedsuperstockist[$i];?>" <?php if($superstockist==$authorizedsuperstockist[$i]){?> selected="selected" <?php }?>><?php echo $authorizedsuperstockist[$i];?></option>

<?php


 }?>



</select>&nbsp;&nbsp;&nbsp;

<br /><br />

<table id="tab">
<tr>
<td><strong>Distributor<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>

<td style="width:20px"></td>

<td><strong>Opening Balence<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td style="width:20px"></td>

 
</tr>

<tr style="height:20px"></tr>

<tr>

<td align="right">
<select name="distributor[]" id="distributor@0"  style="width:150px"  onchange="chktrdate(this.id)">
<option value="">-Select-</option>
<?php
for($i=0;$i<count($allnames);$i++)
{
?>
<option value="<?php echo $allnames[$i];?>"><?php echo $allnames[$i];?></option>
<?php }?>


</select>&nbsp;&nbsp;&nbsp;

</br></br>

</td>


<td style="height:20px"></td><br />
<td>
<input type="text" name="ob[]" id="ob@0" onfocus="return dynamic(this.id)" "checknum(this.id,this.value)"/>
</td>

 

</tr>

</table>
<br/><br/><br/>

<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=distributorob'" id="cancel"/>
</form>
</div>
</section></center>
<script type="text/javascript">

function chktrdate(id)
{
//var id1=id.split('@');
var distributor=document.getElementById(id).value;
var fromdate=document.getElementById("date").value;
<?php 
$q="SELECT distinct(warehouse) as warehouse,min(date) as date  FROM distribution_financialpostings group by warehouse";
$res=mysql_query($q,$conn) or die(mysql_error());
while($r=mysql_fetch_assoc($res))
{
?>
var todate="<?php echo $r['date'];?>";
if(distributor=="<?php echo $r['warehouse'];?>")
{
 var fdate=fromdate.split(".");
   
   var formfdate=fdate[2]+"/"+fdate[1]+"/"+fdate[0];
   
   var tdate=todate.split("-");
   
   var formtdate=tdate[0]+"/"+tdate[1]+"/"+tdate[2];

  var ff=new Date(formfdate);
  
  var tt=new Date(formtdate);
  
  if(ff.getTime()>=tt.getTime())
  {
  
 // alert(fromdate+" and todate"+todate);
    
    alert("date Should be less Than"+formtdate);
   
    document.getElementById("date").value="";
   
     document.getElementById("date").focus();
	
	return false;
   }
}
<?php  }?>
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
 
 //for distributor
 
 var cat=tr.insertCell(j++);
 
 var select1=document.createElement("select");
 
 select1.name="distributor[]";
 
 select1.id="distributor@"+index;
 
 select1.style.width="150px";
 
 select1.setAttribute("onchange","chktrdate(this.id)");
 
 var op=new Option("-Select-","");
 
  select1.add(op);
 
 
 for(i=0;i<allnames.length;i++)
 
 {
  
 var op=new Option(allnames[i],allnames[i]);
 
 op.title=allnames[i];
 
 select1.add(op);
 
 }
 
 
cat.appendChild(select1);
 //----------------
 
 var tt=tr.insertCell(j++);
 
 tt.style.width="20px";
 
 
  
//Opening Balence------------

var ob=tr.insertCell(j++);

var input=document.createElement("input");
 
 input.type="text";
 
input.name="ob[]";

 input.id="ob@"+index;

 input.setAttribute("onfocus","return dynamic(this.id)");
 
input.setAttribute("onkeyup","checknum(this.id,this.value)");

ob.appendChild(input);

//-------------

 
//stock.appendChild(input);

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

if(document.getElementById("distributor@"+i).value=="")
{
alert("Select distributor");
document.getElementById("distributor@"+i).value="";
document.getElementById("distributor@"+i).focus();
return false;
}

if(document.getElementById("ob@"+i).value=="")
{
alert("Enter Opening Balence");
document.getElementById("ob@"+i).value="";
document.getElementById("ob@"+i).focus();
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

document.location="dashboardsub.php?page=distributor_ob&date="+date+"&superstockist="+superstockist;

}


</script>