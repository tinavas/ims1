<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);


$q1=mysql_query("SET group_concat_max_len=10000000");

$i=0;

					
					

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
 $sector=json_encode($qr['sector']);
 
//------------------Cat &Item COdes----------------------


$query="select distinct(cat),group_concat(concat(code,'@',description,'@',cunits)) as cd from ims_itemcodes where  iusage LIKE '%Sale%'  group by cat";

$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{

$items[$i]=array("cat"=>"$row[cat]","cd"=>"$row[cd]");

$i++;

}

$item=json_encode($items);

$qdb=mysql_query("select fromdate,todate,warehouse,cat,code,`desc` from oc_pricemaster");
while($rdb=mysql_fetch_array($qdb))
{
$f=$rdb[fromdate];
$t=$rdb[todate];
$dbs[]=array("fromdate"=>$f,"todate"=>$t,"warehouse"=>$rdb[warehouse],"category"=>$rdb[cat],"code"=>$rdb[code],"desc"=>$rdb[desc]);
}
$db=json_encode($dbs);


$q = "select group_concat(distinct(name),'@',cterm order by name) as nameterm  from contactdetails where type = 'vendor' OR type = 'vendor and party' ";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
					 $names=explode(",",$qr["nameterm"]);	
					}
					$name1=json_encode($names);
					
					
					
				$c_q="select fromdate,todate,supplier,warehouse,code from pp_pricemaster";
				
				$c_qr = mysql_query($c_q,$conn) or die(mysql_error());
				$k=0;
					while($qrc = mysql_fetch_assoc($c_qr))
					{
						$price_list[$k]=array("fromdate"=>"$qrc[fromdate]","todate"=>"$qrc[todate]","supplier"=>"$qrc[supplier]","warehouse"=>"$qrc[warehouse]","code"=>"$qrc[code]");
						$k++;
					}
					$price_data=json_encode($price_list);
?>

 
<script type="text/javascript">
var items=<?php if(empty($item)){echo "0";} else{ echo $item; }?>;
var dbs=<?php if(empty($db)){echo "0";} else{ echo $db; }?>;
var nameterm=<?php if(empty($name1)){echo "0";} else{ echo $name1; }?>;
var sector=<?php if(empty($sector)){ echo "0"; }else { echo $sector; }?>;
var price_data=<?php if(empty($price_data)){ echo "0"; }else { echo $price_data; }?>;

</script>
<section class="grid_8">
  <div class="block-border">
  
  <center>

	 <form class="block-content form" id="complex_form" method="post" action="pp_savepricemasters.php"> 
	<input type="hidden" name="edit" value="0">
	  <h1>Price Masters</h1>
	  
	<br />  
	  <b>Price Masters</b>
<br />

	 (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
		<br /><br />
            <table align="center">
          
<tr>
                <td><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="10" id="fdate" name="fdate" value="<?php echo date("d.m.Y"); ?>" ></td>
                <td width="5px"></td>
                
                <td><strong>To Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="10" id="tdate" name="tdate" value="<?php echo date("d.m.Y"); ?>" ></td>
                <td width="5px"></td>

				 <td><strong>&nbsp;Supplier<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;</strong></td>
				<td>
				
				<select id="aaa" name="aaa" style="width:120px">
<option value="">-Select-</option>
					<?php 
 for($j=0;$j<count($names);$j++)
		   {
			$na=explode("@",$names[$j]);
           ?>
<option value="<?php echo $names[$j];?>" title="<?php echo $na[0]; ?>" ><?php echo $na[0]; ?></option>
<?php } ?>
</select>

</td>
			
			 	<td width="5px"></td>
				<td><strong>&nbsp;Warehouse<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;</strong></td>
                <td>
				<?php 
					$sec_arr=explode('"',$sector);				
					?>
				<select id="warehouse" name="warehouse" style="width:120px">
<option value="">-Select-</option>
					<?php 
					$sec_arr=explode(',',$sec_arr[1]);
					
 for($j=0;$j<count($sec_arr);$j++)
		   {
           ?>
<option value="<?php echo $sec_arr[$j]; ?>" title="<?php echo $sec_arr[$j]; ?>" ><?php echo $sec_arr[$j]; ?></option>
<?php } ?>
</select>

</td>
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
<select style="Width:100px" name="cat[]" id="cat@-1" onchange="getcode(this.id);">
     <option value="">-Select-</option>
     <?php
for($i=0;$i<count($items);$i++)
{
?>
<option value="<?php echo $items[$i]["cat"]; ?>"><?php echo $items[$i]["cat"]; ?></option>
<?php } ?>

</select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<select style="Width:75px" name="code[]" id="code@-1" onchange="selectdesc(this.id),checkdb(this.id);checkitem(this.id,this.value);">
     		<option value="">-Select-</option>

</select>
       </td>
<td width="10px">&nbsp;</td><td>
<select style="Width:170px" name="description[]" id="description@-1" onchange="selectcode(this.id),checkdb(this.id);">
     		<option value="">-Select-</option>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units[]" value="" readonly style="background:none; border:0px;" />
</td>


<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="price@-1" style="text-align:right;" name="price[]" value="" onkeyup="decimalrestrict(this.id,this.value)" onfocus="makeForm(this.id);"  onkeypress="return num(this.id,event.keyCode)"    />
</td>

    </tr>
   </table>
   <br /> 
 </center>



   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_pricemaster';">
</center>


						
</form>
</div>
</section>

<br />

<script type="text/javascript">
function decimalrestrict(a,b)
{
var a1=b.split(".");
var a2=a1[1];
if(a1.length>1)
if(a2.length>5)
{
var b2=a2.length-5;
document.getElementById(a).value=b.substr(0,b.length-b2);
}
}
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
     document.getElementById("description@" + tempindex).value = document.getElementById("code@" + tempindex).value;
     var w = document.getElementById("description@" + tempindex).selectedIndex; 
     var description = document.getElementById("description@" + tempindex).options[w].text;
     //document.getElementById("description@" + tempindex).value = description;
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
	
	for(var i=-1;i<=index;i++)
for(var j=-1;j<=index;j++)
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

function checkitem(i,v)
{
	var id_arr=i.split("@");
	var item_a=v.split("@");
	var fromdate=document.getElementById('fdate').value;
	fromdate_arr=fromdate.split(".");
	var fr_date=new Date(fromdate_arr[2]+"-"+fromdate_arr[1]+"-"+fromdate_arr[0]);
	var todate=document.getElementById('tdate').value;
	todate_arr=todate.split(".");
	var tr_date=new Date(todate_arr[2]+"-"+todate_arr[1]+"-"+todate_arr[0]);
	var supplier=document.getElementById('aaa').value;
	var supp=supplier.split("@");
	var warehouse=document.getElementById('warehouse').value;
	for(var i=0;i<price_data.length;i++)
	{
		if(item_a[0]==price_data[i].code && warehouse==price_data[i].warehouse && supp[0]==price_data[i].supplier)
		{
			var from_date_j=new Date(price_data[i].fromdate);
			var to_date_j=new Date(price_data[i].todate);
			if(fr_date<=from_date_j || tr_date<=to_date_j || to_date_j>=fr_date)
			{
				alert('Already we entered this between date for rate');
				document.getElementById("code@"+id_arr[1]).value="";
				document.getElementById("description@"+id_arr[1]).value="";
				return false;
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



function makeForm(id) 
{

var id=id.substr(6,id.length);

if(id!=index)
return false;


index = index + 1 ;

///////////para element//////////
var etd = document.createElement('td');
etd.width = "10px";
theText1=document.createTextNode('\u00a0');
etd.appendChild(theText1);

var etd1 = document.createElement('td');
etd1.width = "10px";
theText1=document.createTextNode('\u00a0');
etd1.appendChild(theText1);

var etd2 = document.createElement('td');
etd2.width = "10px";
theText1=document.createTextNode('\u00a0');
etd2.appendChild(theText1);

var etd7 = document.createElement('td');
etd7.width = "10px";
theText1=document.createTextNode('\u00a0');
etd7.appendChild(theText1);

var etd8 = document.createElement('td');
etd8.width = "10px";
theText1=document.createTextNode('\u00a0');
etd8.appendChild(theText1);

var t  = document.getElementById('table-po');

var r  = document.createElement('tr');
r.setAttribute ("align","center");

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "100px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { getcode(this.id); };
  for(i=0;i<items.length;i++)
{
 var theOption=new Option(items[i].cat,items[i].cat);
myselect1.options.add(theOption);
}
var type = document.createElement('td');
type.appendChild(myselect1);

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectdesc(this.id),checkdb(this.id),checkitem(this.id,this.value) };
var code = document.createElement('td');
code.appendChild(myselect1);
// for description start

myselect1 = document.createElement("select");
myselect1.name = "description[]";
myselect1.id = "description@" + index;
myselect1.style.width = "170px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);myselect1.onchange = function () { selectcode(this.id),checkdb(this.id); };
var desc = document.createElement('td');
desc.appendChild(myselect1);//for description


mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="units[]";
mybox1.id = "units@" + index;
mybox1.style.background="none";
mybox1.style.border="0px";
mybox1.setAttribute("readonly",true);
var units = document.createElement('td');
units.appendChild(mybox1);

mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="price@" + index;
mybox1.name="price[]";
mybox1.style.textAlign = "right";
mybox1.onkeyup=function () {decimalrestrict(this.id,this.value);};
mybox1.onfocus = function () { makeForm(this.id); };
var price = document.createElement('td');
price.appendChild(mybox1);

///////////eighth td///
      r.appendChild(type);
	  r.appendChild(etd8);
      r.appendChild(code);
	  r.appendChild(etd);
      r.appendChild(desc);
	  r.appendChild(etd1);
	  r.appendChild(units);
	  r.appendChild(etd2);
	  r.appendChild(price);
	  r.appendChild(etd7);
      t.appendChild(r);
}
function num1(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}
}


function round_decimals(original_number, decimals) {
    var result1 = original_number * Math.pow(10, decimals)
    var result2 = Math.round(result1)
    var result3 = result2 / Math.pow(10, decimals)
    return pad_with_zeros(result3, decimals)
}

function pad_with_zeros(rounded_value, decimal_places) {

   var value_string = rounded_value.toString()
    
   var decimal_location = value_string.indexOf(".")

   if (decimal_location == -1) {
        
      decimal_part_length = 0
        
      value_string += decimal_places > 0 ? "." : ""
    }
    else {
        decimal_part_length = value_string.length - decimal_location - 1
    }
    var pad_total = decimal_places - decimal_part_length
    if (pad_total > 0) {
        for (var counter = 1; counter <= pad_total; counter++) 
            value_string += "0"
        }
    return value_string
}



</script>
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

