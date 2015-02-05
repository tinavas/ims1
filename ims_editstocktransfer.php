<?php 
include "jquery.php";
include "config.php"; 




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



//getting warehouses

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
</script>
<?php  $q1 = "SELECT * FROM ims_stocktransfer WHERE id = '$_GET[id]' AND client = '$client'"; $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1))
      {
        $fromwarehouse = $row1['fromwarehouse'];
        $cat = $row1['cat'];
        $itemcode = $row1['code'];
        $date = $row1['date'];
        $towarehouse = $row1['towarehouse'];
        
        $quantity = $row1['quantity'];
		
        $tmno = $row1['tmno'];
      
        $vno = $row1['vehicleno'];
       
        $remarks = $row1['remarks'];
		$units=$row1['tounits'];
		$empname=$row1['empname'];
		
      }
?>

<script type="text/javascript">
var items=<?php if(empty($item)){echo 0;}else{ echo $item; } ?>;
var sectors=<?php if(empty($sector)){echo 0;}else{ echo $sector; } ?>;
</script>
<body onLoad="getcode('cat@-1');">



<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form" method="post" onSubmit="return checkform()" action="ims_savestocktransfer.php" >
	  <h1 id="title1">Stock Transfer</h1>
		
  
<br />
<b>Stock Transfer</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
  
<input type="hidden" name="saed" id="saed" value="edit" />
<input type="hidden" name="otid" id="otid" value="<?php echo $_GET['tid']; ?>" />
<input type="hidden" name="oid" id="oid" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" name="cuser" id="cuser" value="<?php echo $empname;?>" />
<input type="hidden" name="odate" id="odate" value="<?php echo $_GET['date']; ?>" />
<input type="hidden" name="otype" id="otype" value="<?php echo $_GET['type']; ?>" />

<table align="center">
<tr>
 <td align="right"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="15" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y",strtotime($date)); ?>" readonly="readonly" />&nbsp;&nbsp;&nbsp;</td>
 <td align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="warehouse" name="warehouse" >
         <option value="">-Select-</option>
		 
		 
        <?php
		
		
		
		
		 for($j=0;$j<count($sec);$j++)
		   {

 ?><option value="<?php echo $sec[$j]; ?>" <?php  if ($fromwarehouse == $sec[$j]) {?> selected="selected" <?php } ?>  title="<?php echo $sec[$j]; ?>"><?php echo $sec[$j]; ?></option>
<?php }
   
?>    

   
       </select>
 </td>
  <th title="Transfer Memo/Delivery Challan"><strong>DC #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
 <td> <input type="text" size="7" id="tmno" name="tmno" value="<?php echo $tmno; ?>" /></td>

 
</tr>
<tr style="height:20px"></tr>
</table>

<table id="paraID" align="center">
<tr align="center">
  <th width="10px">&nbsp;</th>
  <th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Units</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>To Warehouse</strong></th>

   <th width="10px">&nbsp;</th>
  <th><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
  
 
 

</tr>

<tr style="height:10px"></tr>

<tr align="center">
<td width="10px">&nbsp;</td>
 <td><select id="cat@-1" name="cat[]" onChange="getcode(this.id);"><option value="">-Select-</option>
        <?php 
for($j=0;$j<count($items);$j++)
{
?>
<option value="<?php echo $items[$j]["cat"]; ?>"  <?php if($cat == $items[$j]["cat"]) { ?> selected=selected <?php } ?> ><?php echo $items[$j]["cat"]; ?></option>
<?php } ?>
		</select>
 </td>

 <td width="10px"></td>

<td><select style="Width:75px" name="code[]" id="code@-1" onChange="getdesc(this.id,this.value);">
<option value="">-Select-</option>

<?php
for($j=0;$j<count($items);$j++)
{
if($items[$j]["cat"] == $cat) {	
	$cd1=explode(",",$items[$j]["cd"]);
	for($k=0;$k<count($cd1);$k++)
	
	{
	 $code1=explode("@",$cd1[$k]);
?>
<option value="<?php echo $cd1[$k]; ?>"  <?php if($code1[0]==$itemcode){ echo 'selected="selected"' ; $description=$code1[1];}?>  ><?php echo $code1[0]; ?></option>
<?php } } } ?>

  </select>
</td>

<td width="10px">&nbsp;</td>

<td><input type="text" size="15" id="description@-1" name="description[]" value="<?php echo $description; ?>" readonly /></td>

<td width="10px">&nbsp;</td>

<td><input type="text" size="8" id="units@-1" name="units[]" value="<?php echo $units; ?>" readonly /></td>

<td width="10px">&nbsp;</td>

<td><select style="Width:140px" id="towarehouse@-1" name="towarehouse[]" ><option value="">-Select-</option>



	

<?php



		 for($j=0;$j<count($sec1);$j++)
		   {
 ?><option value="<?php echo $sec1[$j]; ?>" <?php  if ( $towarehouse == $sec1[$j] ) {?> selected="selected" <?php } ?>  title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php }

?>

</select>
</td>


<td width="10px">&nbsp;</td>

<td><input type="text" size="8" id="squantity@-1" name="squantity[]" value="<?php echo $quantity; ?>" onKeyPress="return num1(this.id,event.keyCode)" onBlur="makeForm(this.id);" /></td>



</tr>
</table>

<br/>

<table align="center">
<tr>
<td colspan="5" align="center">
<center>
<input type="submit" id="Save" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" id="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=ims_stocktransfer';"/>
</center>
</td>
</tr>
</table>
</form>
</div>
</section>
</center>
<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_editstocktransfer.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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



function getdesc(codeid,value)
{
	
	
		
	 var temp = codeid.split("@");
     var tempindex = temp[1];
	 var temp2 = value.split("@");

if(value=="")

{

document.getElementById('code@' + tempindex).value = "";
document.getElementById('description@' +tempindex).value="";
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
				document.getElementById('description@' +tempindex).value="";
				document.getElementById("units@"+tempindex).value="";
				return false;
			}
		}
	}
}


	 document.getElementById("units@"+tempindex).value = temp2[2];
     document.getElementById("description@" + tempindex).value = temp2[1];
	
	

	


}



	function checkform()
	{
	
	var warehouse=document.getElementById("warehouse").value;
	if(warehouse=="")
	  {
	  	alert("select warehouse");
		return false;
	  
	  }
	  var warehouse=warehouse.split("@");
	  warehouse=warehouse[0];
	
	
	  var cat =document.getElementById("cat@-1").value;
	  var code=document.getElementById("code@-1").value;
	 
	var towarehouse= document.getElementById("towarehouse@-1").value;
	
	if(warehouse==towarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for 1st row");
		return false;
	
	}
	 
	  var quantity=document.getElementById("squantity@-1").value;
	  if(cat=="" ||code==""|| quantity=="" ||quantity==0 || towarehouse=="")
	  return false;
	  
	  
	for(j=-1;j<index;j++)
	{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	
	var towarehouse= document.getElementById("towarehouse@"+j).value;
	var qty=document.getElementById("squantity@"+j).value;
	if(warehouse==towarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for"+j+"row");
		return false;
	
	}
	
	if(cat=="" || code== "" || towarehouse=="" ||qty=="")
	
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


function getcode(cat)
{
	
	temp = cat.split("@");
	var a = temp[1];
	
	
	
	removeAllOptions(document.getElementById("code@" + a));
	 
	document.getElementById('description@' + a).value=""; 

var x= document.getElementById(cat).value; 
 myselect1 = document.getElementById("code@" + a);

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


document.getElementById("code@" + a).options.add(op1);

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

	var towarehouse= document.getElementById("towarehouse@"+j).value;
	var qty=document.getElementById("squantity@"+j).value;
	
	if(cat=="" || code== ""  || towarehouse=="" ||qty=="")
	
		return false;
	

}


var id= a.substr(10,a.length);


if(id!=index)
return false;


index = index + 1;
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
myselect1.onchange = function () { getdesc(this.id,this.value); };

td.appendChild(myselect1);
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
mybox1.type="text";
mybox1.name="description[]";
mybox1.id = "description@" + index;
td.appendChild(mybox1);
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
mybox1.onkeypress=function(){ return num1(this.id,event.keyCode);};
mybox1.onblur = function () { makeForm(this.id); };
td.appendChild(mybox1);
//////////squantity td//////

tr.appendChild(b6);
tr.appendChild(td);



table.appendChild(tr);


}

///////////////end of make form////////////////





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

