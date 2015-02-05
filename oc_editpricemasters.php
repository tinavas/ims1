<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 


$q1=mysql_query("SET group_concat_max_len=10000000");

$i=0;
//echo $_GET[id];

$q="select * from oc_pricemaster where id=$_GET[id]";
$r=mysql_query($q);
while($res=mysql_fetch_array($r))
{
$fdate=date("d.m.Y",strtotime($res[fromdate]));
$tdate=date("d.m.Y",strtotime($res[todate]));
$wh=$res[warehouse];
$cat=$res[cat];
$code=$res[code];
$desc=$res[desc];
$units=$res[units];
$price=$res[price];
}

//warehouse

if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{

 $q1 ="SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector WHERE type1='Warehouse'";
  
 }
 else
 {
  $sectorlist = $_SESSION['sectorlist'];

 $q1 ="SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 = 'Warehouse'  and sector in ($sectorlist)";

 }
 $qrs = mysql_query($q1,$conn) or die(mysql_error());
 $qr = mysql_fetch_assoc($qrs);
 $sec1=explode(",",$qr["sector"]);	
 $sector=json_encode($sec1);
 
//------------------Cat &Item COdes----------------------


$query="select distinct(cat),group_concat(concat(code,'@',description,'@',cunits)) as cd from ims_itemcodes where  iusage LIKE '%Sale%'  group by cat";

$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{

$items[$i]=array("cat"=>"$row[cat]","cd"=>"$row[cd]");

$i++;

}

$item=json_encode($items);

$qdb=mysql_query("select fromdate,todate,customer,cat,code,`desc` from oc_pricemaster");
while($rdb=mysql_fetch_array($qdb))
{
$f=date("d.m.Y",strtotime($rdb[fromdate]));
$t=date("d.m.Y",strtotime($rdb[todate]));
$dbs[]=array("fromdate"=>$f,"todate"=>$t,"warehouse"=>$rdb[customer],"category"=>$rdb[cat],"code"=>$rdb[code],"desc"=>$rdb[desc]);
}
$db=json_encode($dbs);
$q = "select group_concat(distinct(name),'@',cterm order by name) as nameterm  from contactdetails where type = 'party' OR type = 'vendor and party' ";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
					 $names=explode(",",$qr["nameterm"]);	
					}
					$name1=json_encode($names);
?>

 
<script type="text/javascript">
var items=<?php if(empty($item)){echo "0";} else{ echo $item; }?>;
var dbs=<?php if(empty($db)){echo "0";} else{ echo $db; }?>;
</script>
<section class="grid_8">
  <div class="block-border">
  
  <center>

	 <form class="block-content form" id="complex_form" method="post" action="oc_savepricemasters.php" > 
	<input type="hidden" name="edit" value="1"/>
    <input type="hidden" name="oldid" value="<?php echo $_GET[id];?>"/>
	  <h1>Price Masters</h1>
	  
	<br />  
	  <b>Edit Price Masters</b>
<br />

	 (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
		<br /><br />
            <table align="center">
          
<tr>
                <td><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="10" id="fdate" name="fdate" value="<?php echo $fdate; ?>" ></td>
                <td width="5px"></td>
                
                <td><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="10" id="tdate" name="tdate" value="<?php echo $tdate; ?>" ></td>
                <td width="5px"></td>

				 <td><strong>&nbsp;Customer<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;</strong></td>
				<td>
				
				<select id="aaa" name="aaa" style="width:120px">
<option value="">-Select-</option>
<?php 
 for($j=0;$j<count($names);$j++)
		   {
			$na=explode("@",$names[$j]);
           ?>
<option value="<?php echo $names[$j];?>" title="<?php echo $na[0]; ?>" <?php if($na[0]==$party) {?> selected="selected" <?php  } ?>><?php echo $na[0]; ?></option>
<?php } ?>
</select>

</td>
			
			 	<td width="5px"></td>

              </tr>
            </table>
<br /><br />			

<center>
 <table border="0" id="table-po">
     <tr>
<th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Units</strong></th><td width="10px">&nbsp;</td>

<th><strong>Price<br />/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>




     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:100px" name="cat" id="cat@-1" onChange="getcode(this.id);">
     <option value="">-Select-</option>
     <?php
for($i=0;$i<count($items);$i++)
{
?>
<option value="<?php echo $items[$i]["cat"]; ?>" <?php if($cat== $items[$i]["cat"]) {?> selected="selected" <?php }?>><?php echo $items[$i]["cat"]; ?></option>
<?php } ?>

</select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<select style="Width:75px" name="code" id="code@-1" onChange="selectdesc(this.id);">
     		<option value="">-Select-</option>
            <?php $q=mysql_query("select code,description,cunits from ims_itemcodes where cat='$cat'");
			while($r=mysql_fetch_array($q)){
			?>
            <option value="<?php echo $r[code].'@'.$r[description].'@'.$r[cunits]?>" <?php if($code==$r[code]) { ?> selected="selected" <?php }?>><?php  echo $r[code];?></option>
			
			<?php }?>
			
</select>
       </td>
<td width="10px">&nbsp;</td><td>
<select style="Width:170px" name="description" id="description@-1" onChange="selectcode(this.id);">
     		<option value="">-Select-</option>
            <?php $q=mysql_query("select code,description from ims_itemcodes where cat='$cat'");
			while($r=mysql_fetch_array($q)){
			?>
            <option value="<?php echo $r[descripton];?>" <?php if($desc==$r[description]) { ?> selected="selected" <?php }?>><?php  echo $r[description];?></option>
			
			<?php }?>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units" value="<?php echo $units;?>" readonly style="background:none; border:0px;" />
</td>


<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="price@-1" style="text-align:right;" name="price" value="<?php echo $price;?>"  onkeypress="return num(this.id,event.keyCode)"    />
</td>

    </tr>
   </table>
   <br /> 
 </center>



   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=oc_pricemaster';">
</center>


						
</form>
</div>
</section>

<br />

<script type="text/javascript">
function checkdb(id)
{
var ind=id.split("@");
var fdate=document.getElementById('fdate').value;
var tdate=document.getElementById('tdate').value;
var aaa=document.getElementById('aaa').value;
var c=document.getElementById('code@'+ind[1]).value;
c=c.split('@');
var code=c[0];
var fd=fdate.split(".");
var td=tdate.split(".");
var fd1=fd[2]+"/"+fd[1]+"/"+fd[0];
var td1=td[2]+"/"+td[1]+"/"+td[0];
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
var tdate1=new Date(td1);
if((dbfdate.getTime()<=fdate1.getTime()  &&  dbs[k].warehouse==aaa &&   dbs[k].code==code )|| ( dbtdate.getTime()>=tdate1.getTime() &&  dbs[k].warehouse==aaa &&   dbs[k].code==code )){
alert("Price of this item is already entered");
document.getElementById('code@-'+ind[1]).focus();
document.getElementById('code@-'+ind[1]).options[1].selected="selected";
document.getElementById('desc@-'+ind[1]).options[1].selected="selected";
} 
else
{
}
}
}
var index = -1;

function selectdesc(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
	 alert(document.getElementById("code@" + tempindex).value);
document.getElementById("description@" + tempindex).selectedIndex = document.getElementById("code@" + tempindex).selectedIndex;
	var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];  
	
	for(i=-1;i<=index;i++)
for(j=-1;j<=index;j++)
 {
 
 if((document.getElementById('code@' + i).value==document.getElementById('code@' + j).value)&&(i!=j))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('description@' + tempindex).value="";
  document.getElementById("units@" + tempindex).value="";
 return false;
 
 }
 }
	
}



function selectcode(codeid)
{     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("code@" + tempindex).value = document.getElementById("description@" + tempindex).value;
     var w = document.getElementById("description@" + tempindex).selectedIndex; 
     var description = document.getElementById("description@" + tempindex).options[w].text;
    // document.getElementById("description@" + tempindex).value = description;

   var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];
	
	for(i=-1;i<=index;i++)
for(j=-1;j<=index;j++)
 {
 
 if((document.getElementById('description@' + i).value==document.getElementById('description@' + j).value)&&(i!=j))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('description@' + tempindex).value="";
  document.getElementById("units@" + tempindex).value="";
 return false;
 
 }
 }
}



function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;

	
	
document.getElementById("code@" + index1).options.length=1;
	document.getElementById("description@" + index1).options.length=1;	 

document.getElementById("units@" + index1).value="";
	var l=items.length;
var x=document.getElementById("cat@" + index1).value;
 for(i=0;i<l;i++)
{
if(items[i].cat == x)
{
var ll=items[i].cd.split(",");
for(j=0;j<ll.length;j++)
{ 
var expp=ll[j].split("@");
var op1=new Option(expp[0],ll[j]);
op1.title=expp[0];
var op2=new Option(expp[1],ll[j]);
op2.title=expp[1];
document.getElementById("description@" + index1).options.add(op2);
document.getElementById("code@" + index1).options.add(op1);
}
 
}
}		

}


function num(a,b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}

function num1(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}
}

</script>

<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_t_adddirectsale.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

