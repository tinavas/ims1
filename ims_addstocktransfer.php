
<?php 
include "jquery.php";
include "config.php"; 
$client = $_SESSION['client'];
$i=0;

$q1=mysql_query("SET group_concat_max_len=10000000");

//getting cat,itemcodes
$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes where (source = 'Purchased' or source = 'Produced or Purchased' or source = 'Produced')  group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);

$tmno=mysql_query("select group_concat(distinct(tmno)) as tmno from ims_stocktransfer",$conn) or die(mysql_error());
while($rtmno=mysql_fetch_array($tmno))
{
$tmno=explode(",",$rtmno['tmno']);	
}

	 $tmno1=json_encode($tmno);

//getting from warehouses

	    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 $i=0;
		if($sectorlist=="")  
$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse'";
else

$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse' and sector in ($sectorlist)";


 $res1 = mysql_query($q1,$conn); 

$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector1=json_encode($sec);






//getting to warehouses
 
$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse'";

 $res1 = mysql_query($q1,$conn); 

$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);



?>
<script type="text/javascript">
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;

var sectors1=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;


var sectors=<?php if(empty($sector1)){echo 0;} else{ echo $sector1; }?>;


var tmno=<?php if(empty($tmno1)){echo 0;} else{ echo $tmno1; }?>;
</script>


	<?php	
	$tnum=0;
	$trnum1="";		
 $q = "select tid from ims_stocktransfer where client = '$client'"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],4);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$tnum = "STR-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tnum="STR-1";

}

?>




<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form" method="post" onSubmit="return checkform(this)" action="ims_savestocktransfer.php" >
	  <h1 id="title1">Stock Transfer</h1>
		
  
<br />
<b>Stock Transfer</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
  


<br /><br />

<input type="hidden" name="saed" id="saed" value="save" />
<table align="center">
<tr>
 <td align="right"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="15" id="date" name="date" class="datepickerinv" value="<?php echo date("d.m.Y"); ?>" />&nbsp;&nbsp;&nbsp;</td>
 <td align="right"><strong>From Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="warehouse" name="warehouse" style="width:180px;">
         <option value="">-Select-</option>
 <?php
          
          
		   for($j=0;$j<count($sec);$j++)
		   {
			
           ?>
<option value="<?php echo $sec[$j];?>" title="<?php echo $sec[$j]; ?>"><?php echo $sec[$j]; ?></option>
<?php } ?>


       </select>
 </td>

 <td align="right"><strong>Tr.No</strong>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="8" id="trno" name="trno"  value="<?php echo $tnum; ?>" readonly="true" style="background:none; border:0px;" />&nbsp;&nbsp;&nbsp;</td>
 
 <td title="Transfer Memo/Delivery Challan"><strong>DC #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>



<td> <input type="text"  size="7" id="tmno"  name="tmno" onkeyup="chkval(this.id,this.value)"   onblur="chk1(this.value)"/></td>
 
</tr>
<tr style="height:20px"></tr>
</table>

<table id="paraID" align="center">
<tr align="center">
  <th width="10px">&nbsp;</th>
  <th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Units</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>To Warehouse<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
 

   <th width="10px">&nbsp;</th>
  <th style="text-align:left"><strong>Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  


</tr>

<tr style="height:10px"></tr>

<tr align="center">
<td width="10px">&nbsp;</td>
 <td><select id="cat@-1" name="cat[]" onChange="getcode(this.id);" style="width:120px"><option value="">-Select-</option>
<?php
for($i=0;$i<count($items);$i++)
{
?>
<option value="<?php echo $items[$i]["cat"]; ?>"><?php echo $items[$i]["cat"]; ?></option>
<?php } ?>
</select>
 </td>

 <td width="10px"></td>

<td>
<select style="Width:75px" name="code[]" id="code@-1" onChange="selectdesc(this.id,this.value);">
	<option value="">-Select-</option>
	</select>
</td>

 <td width="10px">&nbsp;</td>

<td>
<select style="Width:130px" name="desc[]" id="desc@-1" onChange="selectcode(this.id,this.value);">
     		<option value="">-Select-</option>
</select>
<input type="hidden" size="15" id="description@-1" name="description[]" value="" readonly/>
</td>

<td width="10px">&nbsp;</td>

<td><input type="text" size="8" id="units@-1" name="units[]" value="" readonly style="background:none; border:0px" /></td>

<td width="10px">&nbsp;</td>

<td><select style="Width:140px" id="towarehouse@-1" name="towarehouse[]"  ><option value="">-Select-</option>

 <?php
          
          
		   for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>" title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php } ?>  
</select>
</td>



<td width="10px">&nbsp;</td>

<td><input type="text"  size="8" id="squantity@-1" name="squantity[]" value="" onKeyPress="return num1(this.id,event.keyCode);" onBlur="makeForm(this.id);" /></td>





</tr>
</table>

<br/>



<table align="center">
<tr>
<td colspan="5" align="center">
<center>
<input type="submit" id="Save" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" id="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=ims_stocktransfer';"/>
</center>
</td>
</tr>
</table>
</form>
</div>
</section>
</center>
	<script type="text/javascript">
function chk1(a)
{
for(i=0;i<tmno.length;i++)
{
//alert(tmno[i]);
if(a==tmno[i])
{
alert("This Document No Alredy Exists");
document.getElementById("tmno").value="";
}
}
}
function chkval(id,val)
{
var regx=/^[0-9]*$/;
if(!val.match(regx))
{
alert("Enter Only Numbers");
document.getElementById(id).value="";
}
}


	function checkform()
	{
	var warehouse=document.getElementById("warehouse").value;
	if(warehouse=="")
	  {
	  	alert("select warehouse");
		return false;
	  }
	  var dcno=document.getElementById("tmno").value;
	if(dcno=="")
	  {
	  	alert("Enter dc. number");
		return false;
	  
	  }
	  var warehouse=warehouse.split("@");
	  warehouse=warehouse[0];
	
	
	  var cat =document.getElementById("cat@-1").value;
	  var code=document.getElementById("code@-1").value;
	  var desc=document.getElementById("desc@-1").value;
	var towarehouse= document.getElementById("towarehouse@-1").value;
	
	if(warehouse==towarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for 1st row");
		return false;
	
	}
	 
	  var quantity=document.getElementById("squantity@-1").value;
	  if(cat=="" ||code=="" || desc=="" || quantity=="" ||quantity==0 || towarehouse=="")
	  return false;
	  
	  
	for(j=-1;j<index;j++)
	{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("desc@"+j).value;
	var towarehouse= document.getElementById("towarehouse@"+j).value;
	var qty=document.getElementById("squantity@"+j).value;
	if(warehouse==towarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for"+j+"row");
		return false;
	
	}
	
	if(cat=="" || code== "" || desc=="" || towarehouse=="" ||qty=="")
	
		return false;
	

}
	  
	document.getElementById('Save').disabled=true;
	
	}
	


function num1(a,b)
{

	if((b<48 || b>57) &&(b!=46))
	{
	 	event.keyCode=false;
		return false;
	
		
	}
	
	

}
	
	
function script1() {
window.open('IMSHelp/help_t_addstocktransfer.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
</body>
<script type="text/javascript">


///////////////makeform//////////////
var index = -1;


function selectdesc(codeid,value)
{
    
	
	 var temp = codeid.split("@");
     var tempindex = temp[1];
	 var temp2 = value.split("@");

if(value=="")

{

document.getElementById('code@' + tempindex).value = "";
document.getElementById('desc@' +tempindex).value="";
document.getElementById("units@"+tempindex).value="";
				return false;

}

for(var i = -1;i<=index;i++)
{
	for(var j = -1;j<=index;j++)
	{
		
		if( i != j)
		{
			if(document.getElementById('code@' + i).value == document.getElementById('code@' + j).value)
			{
				
				
				alert("Please select different combination");
				document.getElementById('code@' + tempindex).value = "";
				document.getElementById('desc@' +tempindex).value="";
				document.getElementById("units@"+tempindex).value="";
				return false;
			}
		}
	}
}


	 document.getElementById("units@"+tempindex).value = temp2[2];
     document.getElementById("desc@" + tempindex).value = document.getElementById("code@" + tempindex).value;
	
	
    
	

	
}
function selectcode(codeid,value)
{
   var temp = codeid.split("@");
     var tempindex = temp[1];
	 var temp2 = value.split("@");

if(value=="")

{

document.getElementById('code@' + tempindex).value = "";
document.getElementById('desc@' +tempindex).value="";
document.getElementById("units@"+tempindex).value="";
				return false;

}

for(var i = -1;i<=index;i++)
{
	for(var j = -1;j<=index;j++)
	{
		
		if( i != j)
		{
			if(document.getElementById('desc@' + i).value == document.getElementById('desc@' + j).value)
			{
				
				
				alert("Please select different combination");
				document.getElementById('code@' + tempindex).value = "";
				document.getElementById('desc@' +tempindex).value="";
				document.getElementById("units@"+tempindex).value="";
				return false;
			}
		}
	}
}




 document.getElementById("units@"+tempindex).value = temp2[2];
     document.getElementById("code@" + tempindex).value = document.getElementById("desc@" + tempindex).value;
	


}







function getcode(cat)
{
	
	temp = cat.split("@");
	var a = temp[1];
	
	
	
	removeAllOptions(document.getElementById("code@" + a));
	 
	removeAllOptions(document.getElementById('desc@' + a)); 

var x= document.getElementById(cat).value; 
 myselect1 = document.getElementById("code@" + a);
 myselect2 = document.getElementById("desc@" + a);
 document.getElementById("units@" + a).value="";
	var l=items.length;		  
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

document.getElementById("code@" + a).options.add(op1);
document.getElementById("desc@" + a).options.add(op2);
}
}
}
			  

}






function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length;i>0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


function makeForm(a) {
for(j=-1;j<=index;j++)
{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("desc@"+j).value;
	var towarehouse= document.getElementById("towarehouse@"+j).value;
	var qty=document.getElementById("squantity@"+j).value;
	
	if(cat=="" || code== "" || desc=="" || towarehouse=="" ||qty=="")
	
		return false;
	

}




var temp=a.split('@');
 var id=temp[1];

if(id!=index)
return false;
index = index + 1 ;

var i,b;

table=document.getElementById("paraID");
tr = document.createElement('tr');
tr.align = "center";

////////space td//////////////
var b1 = document.createElement('td');
myspace1= document.createTextNode('\u00a0');
b1.appendChild(myspace1);
////////space td//////////////

////////category td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "120px";
var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { getcode(this.id); };
  for(i=0;i<items.length;i++)
{

 var theOption=new Option(items[i].cat,items[i].cat);
		
		
myselect1.options.add(theOption);

} 
td.appendChild(myselect1);
//////////category td/////////

tr.appendChild(b1);
tr.appendChild(td);


////////space td//////////////
var b2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
b2.appendChild(myspace2);
////////space td//////////////

////////item code td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";

var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectdesc(this.id,this.value); };

td.appendChild(myselect1);

// for description start

myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "130px";
var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectcode(this.id,this.value); };

// for description end


//////////item code td/////////

tr.appendChild(b2);
tr.appendChild(td);

////////space td///////////
var b3 = document.createElement('td');
myspace3= document.createTextNode('\u00a0');
b3.appendChild(myspace3);
/////////////space td//////

/////////////description////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="hidden";
mybox1.name="description[]";
mybox1.id = "description@" + index;

td.appendChild(mybox1);

td.appendChild(myselect1); // for description
//////////fdescription td//////

tr.appendChild(b3);
tr.appendChild(td);

////////space td///////////
var b4 = document.createElement('td');
myspace4= document.createTextNode('\u00a0');
b4.appendChild(myspace4);
/////////////space td//////

/////////////units////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="units[]";
mybox1.id = "units@" + index;
mybox1.style.background="none";
mybox1.style.border="0px";
td.appendChild(mybox1);
//////////units td//////

tr.appendChild(b4);
tr.appendChild(td);


////////space td//////////////
var b5 = document.createElement('td');
myspace5= document.createTextNode('\u00a0');
b5.appendChild(myspace5);
////////space td//////////////

////////towarehouse td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "towarehouse[]";
myselect1.id = "towarehouse@" + index;
myselect1.style.width = "140px";

var op1=new Option("-Select-","");
myselect1.options.add(op1);



          
            for(j=0;j<sectors1.length;j++)
		   {
		 
		   
		   	var theOption=new Option(sectors1[j],sectors1[j]);
			myselect1.options.add(theOption);
		
} 

    



td.appendChild(myselect1);
//////////towarehouse td/////////

tr.appendChild(b5);
tr.appendChild(td);






////////space td///////////
var b6 = document.createElement('td');
myspace6= document.createTextNode('\u00a0');
b6.appendChild(myspace6);
/////////////space td//////

/////////////squantity////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="squantity[]";
mybox1.id = "squantity@" + index;
mybox1.onkeypress=function(){return num1(this.id,event.keyCode);};
mybox1.onblur= function () { makeForm(this.id); };
td.appendChild(mybox1);
//////////squantity td//////

tr.appendChild(b6);
tr.appendChild(td);





table.appendChild(tr);


}

///////////////end of make form////////////////



</script>




<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

