<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
include "config.php";

include "jquery.php";

 $cflag=0;
 
 $trnum=$_GET[trnum];
$q0= "select distinct(date),location from packing_dailypacking where trnum='$trnum' group by trnum";
 $q0=mysql_query($q0,$conn) or die(mysql_error());
while( $r0=mysql_fetch_array($q0))
{
 $d=$r0['date'];
 $loc=$r0[location]; 
}

if($_GET['dt']<>"")
{
$d=date("Y-m-d",strtotime($_GET['dt']));
}

$qry1="SELECT code  FROM `ims_itemcodes` where iusage like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula` where warehouse='$loc') ";
	$qr=mysql_query($qry1) or die(mysql_error());
	while($rr=mysql_fetch_array($qr))
	{
	
	$q=mysql_query("select distinct(contractor) as contractor from packing_packingcost where contractor is not null and location='$loc' and '$d' between fromdate and todate ",$conn) or die(mysql_error());
	
	$num=mysql_num_rows($q);
	
	while($r=mysql_fetch_assoc($q))
	{
	
	
	   $q1="select count(*) as count from packing_packingcost where location='$loc' and ('$d' between fromdate and todate) and  contractor='$r[contractor]' and code='$rr[code]'";
	
	   
	   $q1=mysql_query($q1) or die(mysql_error());
	   
	   $r1=mysql_fetch_assoc($q1);
	   
	   if($r1['count']>0)
	   
	   {
	   $f=0;
		   $cflag=1;

	   }
	
	}
	
	}
	if($_GET['dt']<>"" && $_GET[loc]<>"")
if($cflag==0)
{
		   
		   echo "<script type='text/javascript'>";
		   
		   echo "alert('Packing Cost not Entered');";
		   
		   echo "</script>";
}





$s=0;
$qry1="SELECT distinct(code) as code,description  FROM `ims_itemcodes` where iusage like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula` where warehouse='$loc') order by code";
	$qr=mysql_query($qry1) or die(mysql_error());
	while($res=mysql_fetch_assoc($qr))
	{
	$codes[$s]=$res['code'];
	$des[$s]=$res[description];
	$s++;
	}
	$s1=0;
	$d1=date("Y-m-d",strtotime($d)) ;
$q1="select distinct contractor,group_concat(distinct(code)) as code from packing_packingcost where location='$loc' and '$d1' between fromdate and todate and contractor is not null group by contractor";
$q1=mysql_query($q1,$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$cc=$r1[contractor]."@".$r1[code];
$contractors[$s1]=$cc;
$s1++;
}

?>
<section class="grid_8">
  <div class="block-border">
<center>
<form class="block-content form" method="post" action="savepacking.php"  onSubmit="return checkform()" >
  <h1>Daily Packing</h1>
  
  <br/><br/>
<b>Edit Daily Packing Details</b></br></br>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br/><br/><br/>
<input type="hidden" value="1" name="edit" />
<input type="hidden" value="<?php echo $trnum;?>" name="trnum" />

<strong> Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" class="datepickerPR" style="width:100px" value="<?php echo date("d.m.Y",strtotime($d));?>" onChange="reloadpage()">&nbsp;&nbsp;&nbsp;

<strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="location" id="location" onchange="reloadpage()">
<option value="">-Select-</option>
<?php
$q1="SELECT distinct(sector) FROM tbl_sector where type1='Warehouse'  ORDER BY sector ASC";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['sector'];?>" title="<?php echo $r1['sector'];?>" <?php if($r1['sector']==$loc) {?> selected="selected" <?php }?>><?php echo $r1['sector'];?></option>

<?php }?>

</select>

</br></br></br></br></br></br>
<table align="center">
<tr>
<th><strong>Contractors</strong></th>
<?php for($i=0;$i<count($codes);$i++)
{?>
<th style="width:40px"></th>

<th style="width:30px"><strong><?php echo $des[$i];?></strong><strong> <?php echo "(".$codes[$i].")";?></strong></th>
<?php }?>
</tr>
<tr height="15px"></tr>
<tr>
<td> Labour </td>
<?php for($m=0;$m<count($codes);$m++)
{
$que="select * from packing_dailypacking where trnum='$trnum' and labour='YES' and code='$codes[$m]'";
$que=mysql_query($que,$conn) or die(mysql_error());
$re1=mysql_fetch_array($que);
?>
<td style="width:10px"></td>

<td><input type="text" name="lab[]" id="lab@<?php echo $m;?>" size="5px"  value="<?php echo $re1['packets'];?>" onkeyup="checknum(this.id,this.value)" style="text-align:right; width:55px"/></td>
<?php }?>

</tr>
<?php 
for($j=0;$j<count($contractors);$j++)
{$c=explode('@',$contractors[$j]);?>
<tr height="10px"></tr>
<tr><td>
<input type="hidden" name="contractor[]" value="<?php echo $c[0];?>" />
<?php echo $c[0];?></td>

<?php
$c1=explode(',',$c[1]);
 for($k=0;$k<count($codes);$k++){
 $f1=0;?>
<td style="width:10px"></td>

<?php 
for( $l=0;$l<count($c1);$l++)
{

?>
<?php 
if($c1[$l]==$codes[$k]){ 

$que1="select * from packing_dailypacking where trnum='$trnum' and contractor='$c[0]' and code='$codes[$k]'";
$que1=mysql_query($que1,$conn) or die(mysql_error());
$re2=mysql_fetch_array($que1);
$f1=1;?>

<td><input type="text" name="packs<?php echo $j;?>[]" id="pkts@<?php echo $j.$k;?>" value="<?php echo $re2[packets];?>" onkeyup="checknum(this.id,this.value)" style="text-align:right; width:55px"  /></td>
<?php }
}
if($f1==0)
{?>
<td><input style="visibility:hidden; width:55px" type="text" name="packs<?php echo $j;?>[]" id="pkts@<?php echo $j.$k;?>" value="0" size="5px" /></td>
<?php 
}}?>
</tr>
<?php }?>
</table>
<br/><br/><br/>



<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=dailypacking'"  id="cancel"/>
</form>
</center>
</div>
</section>
<script type="text/javascript">
function reloadpage()
{
var d= document.getElementById("date").value;
var loc=document.getElementById("location").value;

document.location="dashboardsub.php?page=editpacking&dt="+d+"&loc="+loc;
}

function checkform()
{
var m="<?php echo $m;?>";
var k="<?php echo $k;?>";
var j="<?php echo $j;?>";
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
for(var i=0;i<m;i++)
{
	var cur_pack=document.getElementById("lab@"+i).value;
	if(cur_pack=='')
	{
		alert('Please Enter No of  Packets here');
		document.getElementById("lab@"+i).focus();
		return false;
	}
	
}
for(var l=0;l<j;l++)
{
		for(var n=0;n<k;n++)
		{
	var pack=document.getElementById("pkts@"+l+n).value;
	if(pack=='')
	{
		alert('Please Enter No of  Packets here');
		document.getElementById("pkts@"+l+n).focus();
		return false;
	}
		}
}


document.getElementById("save").disabled=true;
document.getElementById("cancel").disabled=true;
return true
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