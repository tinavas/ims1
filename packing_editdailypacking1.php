<?php
include "jquery.php";

$trnum=$_GET[trnum];
$q=mysql_query("select * from packing_dailypacking  where trnum='$trnum'",$conn) or die(mysql_error());
while($r=mysql_fetch_array($q))
{
$date=$r[date];
$location=$r[location];
}


 $cflag=0;

if($_GET['dt']<>"")
{

$d=date("Y-m-d",strtotime($_GET['dt']));

}
else
{
$d=$date;
}

if($_GET['loc']<>"")
{

$loc=$_GET['loc'];

}
else
{

$loc=$location;

}


$qry1="SELECT code  FROM `ims_itemcodes` where iusage like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula` where warehouse='$loc') ";
	$qr=mysql_query($qry1) or die(mysql_error());
	while($rr=mysql_fetch_array($qr))
	{
	
	$q=mysql_query("select distinct(contractor) as contractor from packing_packingcost where contractor is not null and location='$loc' and '$d' between fromdate and todate ",$conn) or die(mysql_error());
	
	$num=mysql_num_rows($q);
	
/*	if($num=="" || $num==0)
	{
	
	
		   $cflag=0;
		   
		   echo "<script type='text/javascript'>";
		   
		   echo "alert('Packing Cost not Entered');";
		   
		   echo "</script>";
		   
		   break;
	
	
	}*/
	
	
	while($r=mysql_fetch_assoc($q))
	{
	
	
	   $q1="select count(*) as count from packing_packingcost where location='$loc' and ('$d' between fromdate and todate) and  contractor='$r[contractor]' and code='$rr[code]'";
	
	   
	   $q1=mysql_query($q1) or die(mysql_error());
	   
	   $r1=mysql_fetch_assoc($q1);
	   
	   if($r1['count']>0 )
	   
	   {
	   
		   $cflag=1;
	   
	   }
	
	}
	
	}


if($cflag==0)
{
			echo "<script type='text/javascript'>";
		   
		   echo "alert(' Packing Cost Not Entered');";
		   
		   echo "</script>";
}

/*$qu="select count(*) as c  from packing_dailypacking where date='$d' and location='$loc'";
$query=mysql_query($qu,$conn) or die(mysql_error());
$rq=mysql_fetch_array($query);
if($rq[c]>0)
{
		   $cflag=0;
		   
		   echo "<script type='text/javascript'>";
		   
		   echo "alert('Already Packing Is Done For this Day for the Selected Warehouse ');";
		   
		   echo "</script>";
		   
}*/
//get coa codes

$q2="select group_concat(code,'$',description separator '*') as codes from ac_coa where schedule='Staff Expense'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$expensecoa=explode("*",$r2['codes']);

$expensecoaj=json_encode($expensecoa);

?>

<script type="text/javascript">

var expensecoaj=<?php echo $expensecoaj;?>;

</script>
<section class="grid_8">
  <div class="block-border">
<center>
<form class="block-content form" method="post" action="packing_savedailypacking1.php"  onSubmit="return checkform()">
  <h1>Daily Packing</h1>
  
  <br/><br/>
<b>Edit Daily Packing Details</b></br></br>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<input type="hidden"  name="edit" value="1" />
<input type="hidden"  name="trnum" value="<?php echo $trnum;?>" />
<br/><br/><br/><br/><br/>
<strong><?php echo $trnum; ?></strong>
&nbsp;&nbsp;&nbsp;
<strong> Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" class="datepicker" style="width:100px" value="<?php echo date("d.m.Y",strtotime($d));?>" onChange="reloadpage()">&nbsp;&nbsp;&nbsp;

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

<table id="tab">
<tr>

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

<?php

if($cflag==1)
{
?>

<?php
$d1=date("Y-m-d",strtotime($d)) ;
$q1=mysql_query("select distinct contractor from packing_packingcost where location='$loc' and '$d1' between fromdate and todate",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$cn[]=$r1[contractor];
?>
<input type="hidden" name="contract[]" value="<?php echo $r1[contractor];?>" />
<td><strong><?php echo $r1[contractor];?></strong>&nbsp;&nbsp;&nbsp;</td>
<?php 
}

?>


<td><strong>Coa Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
</td>
<td></td>
</tr>
<?php 
    $qry1="SELECT concat(code,'@',packets,'@',contractor,'@',location,'@',coacode) as pack FROM `packing_dailypacking` where trnum='$trnum' or (location='$loc' and date='$d1')";
	$qr=mysql_query($qry1) or die(mysql_error());
	while($data=mysql_fetch_assoc($qr))
{
$pack[]=$data['pack'];
}
	$qry1="SELECT cat,code,description,sunits  FROM `ims_itemcodes` where iusage like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula` where warehouse='$loc') order by cat";
	$qr=mysql_query($qry1) or die(mysql_error());
	$prev_cat="";
	$i=0;
	while($datas=mysql_fetch_assoc($qr))
	{
?>
<tr style="height:30px;">
<td style="width:20px"></td>

<td>
<?php if($prev_cat!=$datas['cat']) { ?>
<input type="text"  name="category[]" id="cat@<?php echo $i; ?>" style="width:150px;border:none;background:none;" value="<?php echo $datas['cat']; ?>" readonly onchange="getcodes(this.id,this.value)">
<?php } else { ?>
<input type="hidden"  name="category[]" id="cat@<?php echo $i; ?>" style="width:150px;border:none;background:none;" value="<?php echo $datas['cat']; ?>" readonly onchange="getcodes(this.id,this.value)">
<?php } ?>
</td>

<td style="width:20px"></td>

<td>
<input type="text" name="code[]" id="code@<?php echo $i; ?>" style="width:150px;border:none;background:none;"  value="<?php echo $datas['code']; ?>" readonly onChange="selectcode(this.id,this.value)">

</td>

<td style="width:20px"></td>

<td>
<input type="text" name="description[]" id="description@<?php echo $i; ?>" style="width:150px;border:none;background:none;" value="<?php echo $datas['description']; ?>" readonly onChange="selectdesc(this.id,this.value)">
</td>


<td style="width:20px"></td>

<td>
<input type="text" name="units[]" id="units@<?php echo $i; ?>" style="width:100px;border:none;background:none" value="<?php echo $datas['sunits']; ?>" readonly="readonly" />
</td>



<td style="width:20px"></td>
<?php
$pa=0;
for($s=0;$s<count($pack);$s++)
{
$p=explode('@',$pack[$s]);
if($p[0]==$datas['code'] && $p[3]==$loc && $p[2]=="Labour")
{
$pa=$p[1];
}
$coa=$p[4];
}
?>
<td>
<input type="text" name="packets[]" id="packets@<?php echo $i; ?>" value="<?php echo $pa;?>" style="width:100px;"  onkeyup="checknum(this.id,this.value)" />
</td>

<td style="width:20px"></td>
<?php
$k=0;
$d1=date("Y-m-d",strtotime($d)) ;
$q1="select distinct contractor, group_concat(distinct(code)) as code from packing_packingcost where location='$loc' and '$d1' between fromdate and todate and contractor is not null group by contractor";
$q1=mysql_query($q1,$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$pa1=0;
for($t=0;$t<count($pack);$t++)
{
//echo $p1[0].$p1[1].$p1[2].$p1[3];
$p1=explode('@',$pack[$t]);
if($p1[0]==$datas['code'] && $p1[3]==$loc && $p1[2]==$r1[contractor] )
{
$con=$r1[contractor];
$pa1=$p1[1];
}
}

$f=0;
$co=explode(',',$r1[code]);
for($c=0;$c<count($co);$c++)
if($datas[code] ==$co[$c])
$f=1;
if($f==1 && $con==$r1[contractor])
{
?>


<td><input type="text" name="contractor[]" id="lpack@<?php echo $i.$k; ?>" value="<?php echo $pa1;?>"  style="width:100px;" onkeyup="checknum(this.id,this.value)" />
&nbsp;&nbsp;&nbsp;</td>
<?php 
$k++;
}
else
{?>
<td><input type="hidden" name="contractor[]" id="lpack@<?php echo $i.$k; ?>" value="0"  style="width:100px;"  />
&nbsp;&nbsp;&nbsp;</td>
<?php $k++; }
}
 
$q1="select distinct contractor, group_concat(distinct(code)) as code from packing_packingcost where location='$loc' and '$d1' between fromdate and todate and contractor is not null group by contractor";
$q1=mysql_query($q1,$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
$pa1=0;
for($t=0;$t<count($pack);$t++)
{
//echo $p1[0].$p1[1].$p1[2].$p1[3];
$p1=explode('@',$pack[$t]);
if($p1[0]==$datas['code'] && $p1[3]==$loc && $p1[2]==$r1[contractor] )
{
$con=$r1[contractor];
$pa1=$p1[1];
}
}

$f=0;
$co=explode(',',$r1[code]);
for($c=0;$c<count($co);$c++)
if($datas[code] ==$co[$c])
$f=1;
if($f==1 && $con==$r1[contractor])
{?>
<td><select name="coacode[]" id="coacode@<?php echo $i; ?>" style="width:150px">
<option value="">-Select-</option>
<?php
for($a=0;$a<count($expensecoa);$a++)
{
$codedesc=explode("$",$expensecoa[$a]);

?>

<option value="<?php echo $codedesc[0];?>" title="<?php echo $codedesc[1];?>" <?php if($coa==$codedesc[0]) {?> selected="selected" <?php }?>><?php echo $codedesc[0];?></option>

<?php }?>


</select></td><?php } else
 {?><td><select name="coacode[]" id="coacode@<?php echo $i; ?>" style="width:150px; visibility:hidden">
<option value="">-Select-</option></select>
 </td><?php }}?>
</tr>
<?php
$i++;
$prev_cat=$datas['cat'];
 } 
 
 
 }
 ?>
</table>
<br/><br/><br/>



<input type="submit"  value="Update" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=packing_dailypacking'"  id="cancel"/>
</form>
</center>
</div>
</section>
<script type="text/javascript">
function reloadpage()
{
var d= document.getElementById("date").value;
var loc=document.getElementById("location").value;

document.location="dashboardsub.php?page=packing_editdailypacking1&dt="+d+"&loc="+loc;
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
 
 index=0;
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

var table=document.getElementById('tab');
var rowCount=table.rows.length;
var tot_cnt=rowCount-1;

for(var i=0;i<tot_cnt;i++)
{
	var cur_pack=document.getElementById("packets@"+i).value;
	if(cur_pack=='')
	{
		alert('Please Enter No of  Packets here');
		document.getElementById("packets@"+i).focus();
		return false;
	}
	else if(document.getElementById("coacode@"+i).value=="")
	{
		alert('Please Select Coacode');
		document.getElementById("coacode@"+i).focus();
		return false;
	}
}
var k="<?php echo $k;?>";
for(var i=0;i<tot_cnt;i++)
{
		for(var j=0;j<k;j++)
		{
	var pack=document.getElementById("lpack@"+i+j).value;
	if(pack=='')
	{
		alert('Please Enter No of  Packets here');
		document.getElementById("lpack@"+i+j).focus();
		return false;
	}
		}
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

if(document.getElementById("packets@"+i).value=="")
{
alert("Enter Packets");
document.getElementById("packets@"+i).value="";
document.getElementById("packets@"+i).focus();
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

function removeAllOptions(selectbox)
{
	for(var i=selectbox.options.length;i>0;i--)
		selectbox.remove(i);
}
</script>