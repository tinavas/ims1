<?php 
include "jquery.php"; 

include "getemployee.php";

$client = $_SESSION['client'];

$i=0;

$q1=mysql_query("SET group_concat_max_len=10000000");

//getting cat,itemcodes
$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes where iusage like '%sale%' group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);





?>
<script type="text/javascript">


var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;




</script>

<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" method="post" action="distribution_savestockadjust.php" onsubmit="return validate()" >		
	 
	  <h1>Stock Adjustment</h1>
			
  
<br />
<b>Stock Adjustment</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
  


<br /><br />

		
            <table align="center">
              <tr>
             
                <td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" ></td>
                <td width="5px"></td>

                <td><strong>Super Stockist</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
                
					<select id="superstockist" name="superstockist" style="width:175px">
                    <option value="">-Select-</option>
                    <?php
                    $q1="select name from contactdetails where superstockist='YES' and type like '%party%'";
					
					$q1=mysql_query($q1) or die(mysql_error());
					
					while($r1=mysql_fetch_assoc($q1))
					{
					?>
                   <option value="<?php echo $r1['name'];?>"><?php echo $r1['name'];?></option>
                    
                    <?php }?>
                    
                    
                   </select>
				</td>
               
				<td><strong>Doc No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td><input type="text" id="doc" name="doc"  size="7"/></td>
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
<th><strong>Add/Deduct</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th><td width="10px">&nbsp;
</td>

     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:100px" name="cat[]" id="cat@-1" onChange="getcode(this.id);">
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
			<select style="Width:75px" name="code[]" id="code@-1" onChange="selectdesc(this.id,this.value);">
     		<option value="">-Select-</option>
     
</select>
       </td>
<td width="10px">&nbsp;</td><td>
<select style="Width:140px" name="desc[]" id="desc@-1" onChange="selectcode(this.id,this.value);">
     		<option value="">-Select-</option>
</select>
<input type="hidden" size="15" id="description@-1" name="description[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units[]" value="" readonly style="background:none; border:0px;" />
</td>
<td width="10px">&nbsp;</td><td>
<select style="Width:75px" name="addded[]" id="addded@-1" >
     		<option value="Add">Add</option>
			<option value="Deduct">Deduct</option>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" style="text-align:right;" id="qtys@-1" name="qtys[]" value="" onfocus="makeform(this.id);"  onkeyup="checknum(this.id,this.value)"/>
</td>




    </tr>
	
   </table>
   <br /> 
 </center>

<br />			


<center>	
<table>
<tr height="80px"></tr>
</table>
<table border="0">
<td style="vertical-align:middle"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea id="remarks" name="remarks" rows="3" cols="50"></textarea></td>
</table>

   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Back" onClick="document.location='dashboardsub.php?page=distribution_stockadjust';" id="cancel">
</center>


						
</form>
</div>
</section>
</center>

<br />

<script type="text/javascript">

function validate()

{

if(document.getElementById('date').value=="")
{

	alert("Select date");
	return false;

}
  if(document.getElementById('superstockist').value=="")
  {
  
  	alert("select superstockist");
	return false;
  
  }
  
  if(document.getElementById('coa').value=="")
  {
  
  		alert("select coa");
		return false;
  
  }
  if(document.getElementById('doc').value=="")
  {
  
  	alert("Enter document number");
	return false;
  
  }


	
	
	  var cat =document.getElementById("cat@-1").value;
	  var code=document.getElementById("code@-1").value;
	  var desc=document.getElementById("desc@-1").value;
	

	  var quantity=document.getElementById("qtys@-1").value;
	  if(cat=="" ||code=="" || desc=="" || quantity=="" ||quantity==0)
	  return false;
	  
	  
	for(j=-1;j<index;j++)
	{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("desc@"+j).value;
	
	var qty=document.getElementById("qtys@"+j).value;

	
	if(cat=="" || code== "" || desc==""  ||qty=="")
	
		return false;
	

}
	
document.getElementById("save").disabled="true";
document.getElementById("cancel").disabled="true";



}



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

var index = -1;


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



function makeform(a) 
{


for(j=-1;j<=index;j++)
{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("desc@"+j).value;
	
	var qty=document.getElementById("qtys@"+j).value;
	
	if(cat=="" || code== "" || desc==""  ||qty=="" || qty==0)
	
		return false;
	

}

 var temp=a.split('@');
 var id=temp[1];

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

var etd3 = document.createElement('td');
etd3.width = "10px";
theText1=document.createTextNode('\u00a0');
etd3.appendChild(theText1);

var etd4 = document.createElement('td');
etd4.width = "10px";
theText1=document.createTextNode('\u00a0');
etd4.appendChild(theText1);

var etd5 = document.createElement('td');
etd5.width = "10px";
theText1=document.createTextNode('\u00a0');
etd5.appendChild(theText1);

var etd6 = document.createElement('td');
etd6.width = "10px";
theText1=document.createTextNode('\u00a0');
etd6.appendChild(theText1);

var etd7 = document.createElement('td');
etd7.width = "10px";
theText1=document.createTextNode('\u00a0');
etd7.appendChild(theText1);

var etd8 = document.createElement('td');
etd8.width = "10px";
theText1=document.createTextNode('\u00a0');
etd8.appendChild(theText1);

var etd9 = document.createElement('td');
etd9.width = "10px";
theText1=document.createTextNode('\u00a0');
etd9.appendChild(theText1);

var etd10 = document.createElement('td');
etd10.width = "10px";
theText1=document.createTextNode('\u00a0');
etd10.appendChild(theText1);

var etd11 = document.createElement('td');
etd11.width = "10px";
theText1=document.createTextNode('\u00a0');
etd11.appendChild(theText1);

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
myselect1.name = "addded[]";
myselect1.id = "added@" + index;
myselect1.style.width = "75px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Add");
theOption1.appendChild(theText1);
theOption1.value = "Add";
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Deduct");
theOption1.appendChild(theText1);
theOption1.value = "Deduct";
myselect1.appendChild(theOption1);
var added = document.createElement('td');
added.appendChild(myselect1);

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";
var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectdesc(this.id,this.value); };
var code = document.createElement('td');
code.appendChild(myselect1);




myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "140px";
var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectcode(this.id,this.value); };



mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="hidden";
mybox1.name="description[]";
mybox1.id = "description@" + index;
mybox1.setAttribute("readonly");

var desc = document.createElement('td');
desc.appendChild(myselect1); 
desc.appendChild(mybox1);




mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="units[]";
mybox1.id = "units@" + index;
mybox1.setAttribute("readonly");
mybox1.style.background="none";
mybox1.style.border="0px";

var units = document.createElement('td');
units.appendChild(mybox1);


mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.id="qtys@" + index;
mybox1.style.textAlign = "right";
mybox1.name="qtys[]";
mybox1.onfocus = function () { makeform(this.id); };
mybox1.onkeyup = function () { checknum(this.id,this.value); };
var qst = document.createElement('td');
qst.appendChild(mybox1);


	   
      r.appendChild(type);
	  r.appendChild(etd8);
      r.appendChild(code);
	  r.appendChild(etd);
      r.appendChild(desc);
	  r.appendChild(etd1);
	  r.appendChild(units);
	  r.appendChild(etd2);
	  r.appendChild(added);
	  r.appendChild(etd3);
	  r.appendChild(qst);
	  r.appendChild(etd4);
	

	  //r.appendChild(dlocation); 
	
      t.appendChild(r);
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

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addstockadjust.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

