<?php include "jquery.php"; ?>


<?php 

  $date1 = date("d.m.o");
   $strdot1 = explode('.',$date1);
   $ignore = $strdot1[0];
   $m = $strdot1[1];
   $y = substr($strdot1[2],2,4);
    
  include "config.php"; 
   $query1 = "SELECT MAX(piincr) as piincr FROM pp_purchaseindent  where m = '$m' AND y = '$y' ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $piincr = 0;
   while($row1 = mysql_fetch_assoc($result1))
   {
	 $piincr = $row1['piincr'];
   }
   $piincr = $piincr + 1;

if ($piincr < 10)
    $pi = 'PR-'.$m.$y.'-000'.$piincr;
else if($piincr < 100 && $piincr >= 10)
    $pi = 'PR-'.$m.$y.'-00'.$piincr;
else
   $pi = 'PR-'.$m.$y.'-0'.$piincr;
   
   ?>
   
   
   
   
<?php   include "config.php";

$q1=mysql_query("SET group_concat_max_len=10000000");

$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);


$query="select sector,group_concat(distinct(name)) as name from hr_employee group by sector";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$sec[$i]=array("sector"=>"$r[sector]","name"=>"$r[name]");
$i++;
} 
$sectors=json_encode($sec);





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
//while($rows1 = mysql_fetch_assoc($res1))
$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);

 ?>
<script type="text/javascript">
var items=<?php if(empty($item)){ echo "0";} else{ echo $item;}?>;
var sectors=<?php if(empty($sectors)){echo "0";} else{ echo $sectors;}?>;

var sectors1=<?php if(empty($sector)){ echo "0";} else{ echo $sector;}?>;


</script>


<br/>
<body>
<center>


<section class="grid_8">
  <div class="block-border">

<form action="pp_savepurchaseindent.php" method="post" onSubmit="return validate()" class="block-content form">

<h1>Purchase Request</h1>

<br />

<b>Purchase Request</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />



<input type="hidden" name="m" id="m" value="<?php echo $m; ?>" />
<input type="hidden" name="y" id="y" value="<?php echo $y; ?>" />
<input type="hidden" name="piincr" id="piincr" value="<?php echo $piincr; ?>" />

<table border="0">
<tr>
<td><strong>Requisition No&nbsp;&nbsp;&nbsp;</strong></td>
<td>



<input type="text" name="rno" id="rno" value="<?php echo $pi; ?>" readonly style="border:0px;background:none"   />
</td>
<td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td>
<input type="text" size="15" id="ddate" class="datepicker" name="ddate" value="<?php echo date("d.m.o"); ?>" readonly="true" onChange="pi();">
</td>
</tr>
<tr style="height:20px"></tr>
</table>

<br />
<br />

<table id="test" border="0">
<tr>
<th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Units</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th title="Requesting Delivery Date"><strong>Req. Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Delivery Office</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Receiver</strong></th>
<th width="10px"></th>

</tr>

<tr style="height:20px"></tr>

<tr>
<td>
<select name="type[]" id="type-1" onChange="fun(this.id);" style="width:90px;">
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
<td>
<select name="code[]" id="code-1" onChange="description(this.id,this.value);" style="width:80px;">
<option value="">-Select-</option>
 </select>
</td>
<td width="10px"></td>
<td>
<input type="text" name="ing[]" id="ing-1" readonly size="25"  />
</td>
<td width="10px"></td>
<td>
<input type="text" name="ingweight[]" id="ingweight-1"  size="8" onKeyPress="return num(event.keyCode)" onfocus = "makeForm()" />
</td>
<td width="10px"></td>
<td width="30px">
<input type="text" name="unit[]" id="unit-1" readonly size="8"  style="background:none; border:0px;" />
</td>
<td width="10px"></td>

<td width="70px">
<input type="text" size="15" id="rdate-1" name="rdate[]" class="datepicker" value="<?php echo date("d.m.o"); ?>">
</td>
<td width="10px"></td>
<td>
<select name="doffice[]" id="doffice-1" onchange = "getemp(this.id);" style="width:150px;">
<option value="">-Select-</option>

 <?php
          
          
		   for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>" title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php } ?>
</select>
</td>
<td width="10px"></td>
<td>
<select name="demp[]" id="demp-1"  style="width:150px;">
<option value="">-Select-</option>
 </select>
</td>
<td width="10px"></td>

</tr>

</table>

<br />
<table>
<td style="vertical-align:middle;"><strong>Remarks&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br /><br />

<center>
<input type="submit" id="save" value="Save" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseindent';">
<br />

</center>
</form>
</div>
</section>
</center>
</body>

<br /><br /><br /><br />
<script type="text/javascript">

var index = -1;


function validate()
{

var cat= document.getElementById("type-1").value;
var code=document.getElementById("code-1").value;
var dloc=document.getElementById("doffice-1").value;


if(cat=="" || code=="" || dloc=="")
return false;


for(var j=-1;j<index;j++)
{

var cat= document.getElementById("type"+j).value;
var code=document.getElementById("code"+j).value;

if(cat=="" || code=="")
return false;

if(j<index)
{
var qty=document.getElementById("ingweight"+j).value;

if(qty=="" || qty==0)
	return false;

var dloc=document.getElementById("doffice"+j).value;

if(dloc=="")
	return false;


}

}



document.getElementById("save").disabled=true;

}

function num(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}


function makeForm() {

var cat= document.getElementById("type-1").value;
var code=document.getElementById("code-1").vaue;

if(cat=="" || code=="")
return false;


for(var j=0;j<=index;j++)
{

var cat= document.getElementById("type"+j).value;
var code=document.getElementById("code"+j).vaue;

if(cat=="" || code=="")
return false;

if(j<index)
{
var qty=document.getElementById("ingweight"+j).value;

if(qty=="" || qty==0)
	return false;
	var qty=document.getElementById("ingweight-1").value;

if(qty=="" || qty==0)
	return false;


}

}


index = index + 1;
var i,b;
var t1  = document.getElementById('test');
var r  = document.createElement('tr');

///////////Select Item types/////////////
myselect1 = document.createElement("select");
myselect1.style.width = "90px";

myselect1.name = "type[]";
myselect1.id = "type" +  index;
myselect1.onchange = function ()  {  fun(this.id); };

var op1=new Option("-Select-","");
myselect1.options.add(op1);

  for(i=0;i<items.length;i++)
{

 var theOption=new Option(items[i].cat,items[i].cat);
		
		
myselect1.options.add(theOption);

} 
var ca = document.createElement('td');
ca.appendChild(myselect1);
/////////end of item types//////////

///////////////itemcodes///////////
myselect1 = document.createElement("select");
myselect1.style.width = "80px";
myselect1.name = "code[]";
myselect1.id = "code" + index;

var op1=new Option("-Select-","");
myselect1.options.add(op1);


myselect1.onchange = function ()  {  description(this.id,this.value); };

var ca1 = document.createElement('td');
ca1.appendChild(myselect1);
///////////end of itemcodes//////

/////////////////////ing////////////
mybox1=document.createElement("input");
mybox1.size="25";
mybox1.type="text";
mybox1.name="ing[]";
mybox1.id = "ing" + index;
mybox1.setAttribute("readonly","true");
var ca2 = document.createElement('td');
ca2.appendChild(mybox1);
////////////end of ing//////////////

/////////////ingweight//////////
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="ingweight[]";
mybox1.id = "ingweight" + index;
mybox1.onfocus = function ()  {  makeForm(); };
mybox1.onkeypress=function (){ return num(event.keyCode)};
var ca3 = document.createElement('td');
ca3.appendChild(mybox1);
/////////end of ingweight///////////

//////////////////units////////////////
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="unit[]";
mybox1.id = "unit" + index;
mybox1.style.background="none";
mybox1.style.border="0px";
mybox1.setAttribute("readonly", "true");
var ca4 = document.createElement('td');
ca4.appendChild(mybox1);
///////////////end of units/////////

////////////////delivery date///////////
mybox=document.createElement("input");
mybox.type="text";
mybox.name="rdate[]";
mybox.id = "rdate" + index;
var c = "datepicker" + index;
mybox.value="<?php echo date("d.m.o"); ?>";
mybox.size="15";
mybox.setAttribute("class",c);
var ca5 = document.createElement('td');
ca5.appendChild(mybox);
//////////////end of delivery date////////////

/////////////delivery office/////////////
myselect1 = document.createElement("select");
myselect1.style.width = "150px";

var op1=new Option("-Select-","");
myselect1.options.add(op1);

myselect1.name = "doffice[]";
myselect1.id = "doffice" + index;
myselect1.onchange = function ()  {  getemp(this.id); };



          
            for(j=0;j<sectors1.length;j++)
		   {
		 
		   
		   	var theOption=new Option(sectors1[j],sectors1[j]);
			myselect1.options.add(theOption);
		
} 



var ca6 = document.createElement('td');
ca6.appendChild(myselect1);
///////////////end of delivery office/////////

/////////////employee/////////////
myselect1 = document.createElement("select");
myselect1.style.width = "150px";

var op1=new Option("-Select-","");
myselect1.options.add(op1);

myselect1.name = "demp[]";
myselect1.id = "demp" + index;
var ca7 = document.createElement('td');
ca7.appendChild(myselect1);
//////////////end of employee//////////////




////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et1 = document.createElement('td');
et1.appendChild(myspace2);
///////////////////////////////

////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et2 = document.createElement('td');
et2.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et3 = document.createElement('td');
et3.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et4 = document.createElement('td');
et4.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et5 = document.createElement('td');
et5.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et6 = document.createElement('td');
et6.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et7 = document.createElement('td');
et7.appendChild(myspace2);
///////////////////////////////
////////////empty td/////////
myspace2 = document.createTextNode('\u00a0');
var et8 = document.createElement('td');
et8.appendChild(myspace2);
///////////////////////////////
     r.appendChild(ca);
	 r.appendChild(et1);
     r.appendChild(ca1);
  	 r.appendChild(et2);
 	 r.appendChild(ca2);
   	 r.appendChild(et3);
	 r.appendChild(ca3);
   	 r.appendChild(et4);
	 r.appendChild(ca4);
	 r.appendChild(et5);
	 r.appendChild(ca5);
	 r.appendChild(et6);
	 r.appendChild(ca6);
	 r.appendChild(et7);
	 r.appendChild(ca7);
	 r.appendChild(et8);
	
	 t1.appendChild(r);
	
	$(function() {
	$( "." + c ).datepicker();
  });  

}



/////////////////// end of ingredient js /////////////////

///Loading Codes 
function fun(b) {
var a=b.substr(4,b.length);

document.getElementById("code" + a).options.length=1;
document.getElementById('ing' +a).value="";
	 

var x= document.getElementById('type'+ a).value; 
 myselect1 = document.getElementById("code" + a);

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
document.getElementById("code" + a).options.add(op1);
}
}
}
			  



}
///End of Loading Codes

function getemp(b)
{
var a = b.substring(7,b.length);

document.getElementById("demp" + a).options.length=1;
			 myselect1 = document.getElementById("demp" + a);
              
		
			  
			    var p=sectors.length;
			  var x=document.getElementById('doffice'+a).value;
 			  for(n=0;n<p;n++)
			  {
				  if(sectors[n].sector==x)
				  {	var name1=sectors[n].name;
					 var name=name1.split(',');
					  for(k=0;k<name.length;k++)
					  {
 					 theOption1=new Option(name[k],name[k]);
   					  myselect1.options.add(theOption1);
					  }
				  }
			  }
} 









///Filling Description from code ///////
function description(a,b)
{

var id=a.substr(4,a.length);

if(b=="")
{

	document.getElementById('ing' + id).value="";
 document.getElementById('unit' +id).value="";
 return false;

}

for(var i1 = -1;i<=index;i++)
{
	for(var j1 = -1;j<=index;j++)
	{
		
		
		if( i != j)
		{
			if(document.getElementById('code' + i1).value == document.getElementById('code' + j1).value)
			{
				
				
				alert("Please select different combination");
				document.getElementById('code' + j1).value = "";
				document.getElementById('ing' +j1).value="";
				return false;
			}
		}
	}
}

	var a= document.getElementById('code' + id).value;
	codedesc=a.split("@");
	code=codedesc[0];
	document.getElementById('ing' + id).value=codedesc[1];
 document.getElementById('unit' +id).value=codedesc[2];



	
}
///End Of Description from code /////

//Requesition Starts ///
function pi()
{
  var date1 = document.getElementById('ddate').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var piincr = new Array();
    var pr = "";
  <?php 
   include "config.php"; 
   $query1 = "SELECT MAX(piincr) as piincr,m,y FROM pp_purchaseindent GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     piincr[<?php echo $k; ?>] = <?php echo $row1['piincr']; ?>;

<?php $k++; } ?>

for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(piincr[l] < 10)
     pr = 'PR'+'-'+m+y+'-000'+parseInt(piincr[l]+1);
   else if(piincr[1] < 100 && piincr[1] >= 10)
     pr = 'PR'+'-'+m+y+'-00'+parseInt(piincr[l]+1);
   else
     pr = 'PR'+'-'+m+y+'-0'+parseInt(piincr[l]+1);
  document.getElementById('piincr').value = parseInt(piincr[l] + 1);
  break;
  }
 else
  {
   pr = 'PR'+'-'+m+y+'-000'+parseInt(1);
     document.getElementById('piincr').value = 1;
  }
}
  document.getElementById('rno').value = pr;
document.getElementById('m').value = m;
document.getElementById('y').value =y;

}

///Requisition Ends ///



</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_addpurreq.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
