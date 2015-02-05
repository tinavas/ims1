<?php
include "jquery.php";

// code to fetch all codes
if($_GET[dt]<>"")
$d=date($datephp,strtotime($_GET[dt]));
else
$d=date($datephp);

if($_GET[loc]<>"")
$loc=$_GET[loc];

$q1=mysql_query("set group_concat_max_len=1000000");

$q1="SELECT cat,group_concat(code,'$',description,'$',sunits separator '*') as cd FROM `ims_itemcodes` where iusage like '%Produced%' group by cat";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

$allcodes[]=array("cat"=>$r1['cat'],"cd"=>$r1['cd']);

}


$allcodesj=json_encode($allcodes);

//------------------------------------

qry1="SELECT code  FROM `ims_itemcodes` where iusage like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula` where warehouse='$loc') ";
	$qr=mysql_query($qry1) or die(mysql_error());
	while($rr=mysql_fetch_array($qr))
	{
	$code="
	}
$q=mysql_query("select fromdate,todate,group_concat(code) as code,location from packing_packingcost where location='$loc' and '$d1'  between fromdate and todate and codes in ($codes)",$conn) or die(mysql_error());
while($r=mysql_fetch_array($q))
{
}
$conj=json_encode($con);


$q=mysql_query("select fromdate,todate,group_concat(code) as code,location from packing_packingcost where contractor is not null group by fromdate,todate,location,contractor",$conn) or die(mysql_error());
while($r=mysql_fetch_array($q))
{
$con[]=array("fdt"=>$r[fromdate],"tdt"=>$r[todate],"codes"=>$r[code],"location"=>$r[location]);
}
$conj=json_encode($con);

$q=mysql_query("select group_concat(producttype) as code,warehouse from product_formula group by warehouse",$conn) or die(mysql_error());
while($r=mysql_fetch_array($q))
{
$prod[]=array("code"=>$r[code],"warehouse"=>$r[warehouse]);
}
$prodj=json_encode($prod);

$q=mysql_query("select distinct(contractor) as contractor from packing_packingcost where contractor is not null and location='$loc' ",$conn) or die(mysql_error());
while($r=mysql_fetch_array($q))
{
$contractor[]=array("cont"=>$r[contractor]);
}
$contractorj=json_encode($contractor);

?>

<script type="text/javascript">

var allcodesj=<?php echo $allcodesj;?>;
var cont=<?php echo $conj;?>;
var contractor=<?php echo $contractorj;?>;
var prod=<?php echo $prodj;?>;
</script>
<section class="grid_8">
  <div class="block-border">
<center>
<form class="block-content form" method="post" action="packing_savedailypacking1.php"  onSubmit="return checkform()">
  <h1>Daily Packing</h1>
  
  <br/><br/>
<b>Add Daily Packing Details</b></br></br>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br/><br/><br/>

<strong> Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="date" id="date" class="datepicker" style="width:100px" value="<?php echo $d;?>" onChange="comparedate('fromdate')">&nbsp;&nbsp;&nbsp;

<strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="location" id="location" onchange="reloadpage(),chkpcost()">
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
if(isset($cn))
{
unset($cn);
}
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

<td></td>
</tr>
<?php 
if(isset($c))
unset($c);
	$qry1="SELECT cat,code,description,sunits  FROM `ims_itemcodes` where iusage like '%Produced%' and code in (SELECT distinct producttype FROM `product_formula` where warehouse='$loc') order by cat";
	$qr=mysql_query($qry1) or die(mysql_error());
	$prev_cat="";
	$i=0;
	while($datas=mysql_fetch_assoc($qr))
	{
	$c[]=$datas[code];
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

<td>
<input type="text" name="packets[]" id="packets@<?php echo $i; ?>" style="width:100px;" onkeyup="checknum(this.id,this.value)" />
</td>

<td style="width:20px"></td>
<?php
$k=0;
$d1=date("Y-m-d",strtotime($d)) ;
$q1=mysql_query("select distinct contractor from packing_packingcost where location='$loc' and '$d1' between fromdate and todate and contractor is not null",$conn) or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
?>


<td><input type="text" name="contractor[]" id="lpack@<?php echo $i.$k; ?>" style="width:100px;" onkeyup="checknum(this.id,this.value)" />
&nbsp;&nbsp;&nbsp;</td>
<?php 
$k++;
}
 
?>
<input type="hidden" name="j" value="<?php echo $k;?>" />

</tr>
<?php
$i++;
$prev_cat=$datas['cat'];
 } ?>
</table>
<br/><br/><br/>



<input type="submit"  value="Save" id="save" />&nbsp;&nbsp;&nbsp;

<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=packing_dailypacking'"  id="cancel"/>
</form>
</center>
</div>
</section>
<script type="text/javascript">
function chkpcost( )
{
var d= document.getElementById("date").value;

var loc=document.getElementById("location").value;

for(i=0;i<prod.length;i++)
{
if(loc==prod[i].warehouse)
{
	for(j=0;j<cont.length;j++)
	{
	if(loc==cont[j].location)
	{
    for(k=0;k<contractor.length;k++)
	{	
	if(in_array(contractor[k].cont,cont[j].codes)
	{
	var fdate=d.split(".");
   
   var thisdate=fdate[2]+"/"+fdate[1]+"/"+fdate[0];
   
   var fdate=cont[j][fromdate].split("-");
   
   var formfdate=fdate[0]+"/"+fdate[1]+"/"+fdate[2];
   
   var tdate=cont[j][todate].split("-");
   
   var formtdate=tdate[0]+"/"+tdate[1]+"/"+tdate[2];

  var td=new Date(thisdate);

  var ff=new Date(formfdate);
  
  var tt=new Date(formtdate);
  
    	if(td.getTime()>=ff.getTime() && tt.getTime()<=tt.getTime()) 
  		{
  			if(in_array(prod[i].code,cont[j].codes))
  			{
  
  			}
  			else
  			{
  				alert("No Packing Cost is Entered");
  			}			
 		}
  		else
 		{
  				alert("No Packing Cost is Entered");
  		}
	}
	}
	}
	}
}
}
<?php /*?><?php
$flag=0;
for($n=0;$n<count($cn);$n++)
{ 
$f1=1;
//echo "alert('Packing Cost Not enteredxdghdfh $f1');";
$co="";
$co= $cn[$n];
for($l=0;$l<count($c);$l++)
{
$n1=0;
$qq="select * from packing_packingcost where '$d1' between fromdate and todate and code='$c[$l]' and contractor='$co'";
$q=mysql_query($qq,$conn) or die(mysql_error());
if(mysql_fetch_array($q))
 $n1=mysql_num_rows($q);
?>
<?php 
if($n1<=0 || $n1==" ")
{
$flag=1;
 break;
}
}
if($flag==1)
{
echo "alert('Packing Cost Not entered');";
echo "document.location='dashboardsub.php?page=packing_adddailypacking1';";
}
}

if($f1==1 && $flag==0)
{
?>
reloadpage();
<?php }

?><?php */?>

}
function in_array(a1, array)
{
for (i = 0; i < a1.length; i++)
{
var temp=0;
for (j = 0; j < array.length; j++)
{
if(array[i] ==a1[j] )
{
temp=0;
break;
}
else
{
 temp=1;
}}
if(temp==1)
return false;
}
return true;
}
function reloadpage()
{
var d= document.getElementById("date").value;
var loc=document.getElementById("location").value;

document.location="dashboardsub.php?page=packing_adddailypacking1&dt="+d+"&loc="+loc;
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