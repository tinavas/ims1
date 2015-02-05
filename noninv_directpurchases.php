 <?php   include "getemployee.php"; 
include "jquery.php"; 
include "config.php";
		include "config.php";
		$fdate = $_GET['date'];
		if($fdate!="")
echo $date1=date("d.m.Y",strtotime($fdate));
else
$date1 = date("d.m.Y"); 

$strdot1 = explode('.',$date1); 

$ignore = $strdot1[0]; 

$m = $strdot1[1];

$y = substr($strdot1[2],2,4);

$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";

$result1 = mysql_query($query1,$conn); $sobiincr = 0; 

while($row1 = mysql_fetch_assoc($result1)) 

$sobiincr = $row1['sobiincr']; 

$sobiincr = $sobiincr + 1;

if ($sobiincr < 10)  

$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 

else if($sobiincr < 100 && $sobiincr >= 10) 

$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 

else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;


$q1=mysql_query("SET group_concat_max_len=10000000");
$i=0;

//------------------Vendor Name & Code-----------------------
$q1=mysql_query("SET group_concat_max_len=10000000");
$query="select group_concat(distinct(name) order by name) as name from contactdetails where type = 'vendor' OR type = 'vendor and party' order by name";
$result=mysql_query($query,$conn);
while($rows=mysql_fetch_assoc($result))
{
	$name=explode(",",$rows['name']);
}
$vname=json_encode($name);
//code and description
		
		
		
		//iteams and codes

 $q = "SELECT GROUP_CONCAT(code,'@',description ORDER BY code ) AS codedesc from ac_coa   where controltype in ('') and schedule not in('Inventories','Inventories Work In Progress','Trade Payable','Trade Receivable','Variance Cost','Cost Of Sales /Services') order by code";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$r=mysql_fetch_array($qrs);
{
$items=explode(",",$r['codedesc']);

} 
$item=json_encode($items);
		


 //---------------------------Sectors--------------------
 
if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
	$q1 = "SELECT group_concat(distinct(sector) order by sector) as sector FROM tbl_sector WHERE type1<>'Warehouse' ";
	
}
else
{
	$sectorlist = $_SESSION['sectorlist'];
	$q1 = "SELECT group_concat(distinct(sector) order by sector) as sector FROM tbl_sector WHERE (type1<>'Warehouse') and sector In ($sectorlist)";
	
}
$result=mysql_query($q1,$conn);
while($rows=mysql_fetch_assoc($result))
{ 
$sect=explode(",",$rows['sector']);	
}
$sects=json_encode($sect);



?>
<script type="text/javascript">
var vname=<?php if(empty($vname)){echo 0;} else{ echo $vname; }?>;
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;
var sect=<?php if(empty($sects)){echo 0;} else{ echo $sects;}?>;

</script>



<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form1" method="post" onsubmit="return checkform(this);" action="pp_savenoninv_dp.php">
	  <h1 id="title1">Non Inventory Direct Purchases</h1>
		
  
<br />
<b>Non Inventory Direct Purchases</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />



	<input type="hidden" name="sobiincr" id="sobiincr" value="<?php echo $sobiincr; ?>"/>

		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>

		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>


<table border="0"	align="center">
<tr align="center">
<td align="right"><strong>Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="15" id="date" class="datepicker" name="date" value="<?php echo $date1; ?>" onchange="reloadpage(this.id);"/></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Invoice</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="invoice" name="invoice" value="<?php echo $sobi; ?>" readonly style="border:0px;background:none" size="15" />&nbsp;&nbsp;</td>
<td width="10px">&nbsp;</td>
<td align="left"><strong>Book Invoice<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="15" id="binvoice" name="binvoice" /></td>
<td width="10px">&nbsp;</td>
</tr>

<tr style="height:20px"></tr>
</table>
<br />
<br />

<table border="0" align="center">
<tr  align="center"><td colspan="2">&nbsp;</td>
 <td><strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>

                <td>&nbsp;

					<select id="vendor"  name="vendor" style="width:175px">

					<option value="">-Select-</option>

					<?php
					for($i=0;$i<count($name);$i++)
							{ 
					?>
					<option title="<?php echo $name[$i];?>" value="<?php echo $name[$i];?>"><?php echo $name[$i]; ?></option>
					<?php   }   ?>
					
</select>
</td>
<td width="10px">&nbsp;</td>

<th><strong>Warehouse<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th> 
        <td>&nbsp;
         <select name="warehouse" id="warehouse1" >
		 <option >-Select-</option>
		
							<?php
					for($i=0;$i<count($sect);$i++)
							{ 
					?>
					<option title="<?php echo $sect[$i];?>" value="<?php echo $sect[$i];?>"><?php echo $sect[$i]; ?></option>
					<?php   }   ?>
					
         </select>       </td>
</tr>
</table>


<br />
<br />

 <table border="0" id="mytable" align="center">


   <tr>
 <th><strong>Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th><td width="10px">&nbsp;</td>

<th><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th><td width="10px">&nbsp;</td>

<th><strong>Amount<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th><td width="10px">&nbsp;</td>

<th><strong>Discount<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th><td width="10px">&nbsp;</td>



</tr>

<tr style="height:20px"></tr>

<tr>

<td style="text-align:left;"><select id="code1" name="code[]" onchange="getdesc(this.id);" style="width:80px">
<option value="">-Select-</option>
   <?php 
for($i=0;$i<count($items);$i++)
							{ 
							
							$code1=explode("@",$items[$i]);
							
					?>
					<option title="<?php echo $code1[1];?>" value="<?php echo $items[$i];?>"><?php echo $code1[0]; ?></option>
					<?php   }   ?>
</select></td>
	
<td width="10px"></td>

<td><select id="desc1" name="desc[]"  onchange="getcode(this.id);" style="width:170px"><option value="">-Select-</option>
  <?php 
for($i=0;$i<count($items);$i++)
							{ $desc1=explode("@",$items[$i]);
					?>
	
					<option title="<?php echo $desc1[1];?>" value="<?php echo $items[$i];?>"><?php echo $desc1[1]; ?></option>
					<?php   }   ?> 
</select></td>
	
       <td width="10px"></td>

<td >
         <input type="text" name="amt[]" id="amt1"  size="8" onkeyup="calcu();" value="0" style="text-align:right;" />       </td>
       <td width="10px"></td>
 <td >
         <input type="text" name="dis[]" id="dis1" size="6" onfocus = "makeForm(this.id)" value="0" onkeyup="calcu();" style="text-align:right;"/>       </td>
       

</tr>
</table>


</br>
</br>
</br>
<table border="0" align="center">
<tr>
<td align="left"><strong>Grand Total</strong>
&nbsp;&nbsp;&nbsp;
<input type="text" size="15" id="gtot" name="gtot" readonly="true" value="0.00" style="text-align:left; background:none; border:0px" /></td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td style="vertical-align:middle"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea id="remarks" name="remarks" onKeyPress="return p1(event.keyCode,this.id);" rows="3" cols="50"></textarea></td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 125 Characters</td>
</tr>
</table>



<br />

<center>
<input type="submit" value="Save" id="Save" name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=noninv_directpurchasedisplay&type=<?php echo $type; ?>';" />
</center>
</form>
</div>
</section>
</center>

<script type="text/javascript">

function checkform()
{



 if(document.getElementById('date').value == "")
	{
   alert(" Please Enter date");
	 return false;
   }
   
   else if(document.getElementById('binvoice').value == "")
	{
	 alert(" Please Enter Book Invoice.");
	 return false;
	}
	
   
	else if(document.getElementById('vendor').value == "")
	{
	 alert(" Please Select Vendor.");
	 return false;
	}
	
	else if(document.getElementById('warehouse1').value == "")
	{
	 alert(" Please Select warehouse.");
	 document.getElementById('warehouse1').onfocus = "";
	 return false;
	}
	else 
	{
	
	var a= document.getElementById("binvoice").value;
	
	<?php

$query="SELECT DISTINCT (
invoice
)
FROM `pp_sobi` 
";
$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{
?>
if(a=="<?php echo $row['invoice'];?>")
{
alert("Book invoice already exists");
return false;
}

<?php
}


?>
	
	}
	
	 if(document.getElementById('code1').value == "")
	{
	alert(" Please Select code");
   
	document.getElementById('code1').onfocus = "";
   
	 return false;
   }
   
    else if(document.getElementById('desc1').value == "")
	{
	 
	 alert(" Please Select Description.");
	 document.getElementById('desc1').onfocus = "";
	 return false;
	}
   
	else if(document.getElementById('amt1').value == "")
	{
	 alert(" Please Enter amount.");
	 document.getElementById('amt1').onfocus = "";
	 return false;
	}
	else if(document.getElementById('dis1').value == "")
	{
	 alert(" Please Enter Discount.");
	 document.getElementById('dis1').onfocus = "";
	 return false;
	}
	

	
	for(var j=2;j<index;j++)
	{
	   
	 if(document.getElementById('code'+j).value == "")
	{
	alert(" Please Select code");
   
	document.getElementById('code'+j).onfocus = "";
   
	 return false;
   }
   
    else if(document.getElementById('desc'+j).value == "")
	{
	 
	 alert(" Please Select Description.");
	 document.getElementById('desc'+j).onfocus = "";
	 return false;
	}
   
	else if(document.getElementById('amt'+j).value == "")
	{
	 alert(" Please Enter amount.");
	 document.getElementById('amt'+j).onfocus = "";
	 return false;
	}
	else if(document.getElementById('dis'+j).value == "")
	{
	 alert(" Please Enter Discount.");
	 document.getElementById('dis'+j).onfocus = "";
	 return false;
	}
	
	
	
	}
	
	document.getElementById("Save").disabled=true;
	return true;
}

function getdesc(index)
{
index=index.substr(4);
var a = index;
var i1,j1;
for(var i = 1;i<=index;i++)
{
	for(var j = 1;j<=index;j++)
	{
		i1=i;
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('code' + i1).value == document.getElementById('code' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('desc' + a).value = "";
				//document.getElementById('remarks' + a).onfocus = "";
				alert("Please select different combination");
				return;
			}
		}
	}
}


document.getElementById('desc' + a).value = document.getElementById('code' + a).value;


		
}
function getcode(index)
{
index=index.substr(4);
 
var a = index;
var i1,j1;
for(var i = 1;i<=index;i++)
{
	for(var j = 1;j<=index;j++)
	{
		i1=i;
		j1=j;
		if( i != j)
		{
			if(document.getElementById('desc' + i1).value == document.getElementById('desc' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('code' + a).value = "";
				//document.getElementById('remarks' + a).onfocus = "";
				alert("Please select different combination");
				return;
			}
		}
	}
}
//document.getElementById('Save').disabled = false;
desc=document.getElementById('desc' + a).value;

	document.getElementById('code' + a).value = document.getElementById('desc' + a).value;
		
		
		
}




var index = 1;

function makeForm(id) {

var id=id.substr(3,id.length);


for(k=1;k<=index;k++)
{

	if(k==1)
	{
	
	var code= document.getElementById("code"+k).value;

	var rate= document.getElementById("amt"+k).value;
	
	if( code=="" ||  Number(rate)==0)
	{
		return false;
	
	
	}

	
	}
else if(k<index)
{
	

	var code= document.getElementById("code"+k).value;

	var rate= document.getElementById("amt"+k).value;
	if( code=="" ||  Number(rate)==0)
	{
		return false;
	
	
	}
	

	 }
  }
if(id!=index)
return false;





if(document.getElementById("amt"+index).value!="0")
{
index = index + 1;

///////////para element//////////

var mytable=document.getElementById("mytable");

var myrow = document.createElement("tr");

var mytd = document.createElement("td");

var mybox1=document.createElement("label");


mytd.align="center";

theText1=document.createTextNode(index);

mybox1.appendChild(theText1);


//

var mytd1 = document.createElement("td");

myselect1 = document.createElement("select");

myselect1.id = "code" + index;

myselect1.name = "code[]";

myselect1.style.width = "80";

theOption1=document.createElement("OPTION");

theText1=document.createTextNode("-Select-");

theOption1.value = "";

theOption1.appendChild(theText1);

theOption1.value = "";

myselect1.appendChild(theOption1);
myselect1.onchange = function ()  {  getdesc(this.id); };

	   
            for(j=0;j<(items.length);j++)
		   {code1=items[j].split("@");
		  
		   
		   	var theOption=new Option(code1[0],items[j]);
			theOption.title = code1[1];
			myselect1.options.add(theOption);
		
} mytd1.appendChild(myselect1);
myrow.appendChild(mytd1);
mytable.appendChild(myrow);
myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);



 

var mytd1 = document.createElement("td");
myselect1 = document.createElement("select");
myselect1.id = "desc" + index;
myselect1.name = "desc[]";
myselect1.style.width = "170";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function ()  {  getcode(this.id); };
                     
            for(j=0;j<(items.length);j++)
		   {desc1=items[j].split("@");
		  
		   
		   	var theOption=new Option(desc1[1],items[j]);
			theOption.title = desc1[1];
			myselect1.options.add(theOption);
 }
mytd1.appendChild(myselect1);
myrow.appendChild(mytd1);
mytable.appendChild(myrow);




myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd = document.createElement("td");
mybox1=document.createElement("input");

mybox1.size="8";

mybox1.type="text";

mybox1.id="amt" + index;

mybox1.name="amt[]";

mybox1.value="0";

mybox1.style.textAlign = "right";

//mybox1.onkeyup = function () { (''); };

mybox1.onkeyup = function () { calcu(); };

var qrs = document.createElement('td');

qrs.appendChild(mybox1);

mytd.appendChild(mybox1);
myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);


var mytd = document.createElement("td");

mybox1=document.createElement("input");

mybox1.size="6";

mybox1.type="text";

mybox1.id="dis" + index;

mybox1.name="dis[]";
mybox1.value="0";
mybox1.style.textAlign = "right";

mybox1.onfocus = function () { makeForm(this.id); };
//
mybox1.onkeyup = function () { calcu(''); };
//
//mybox1.onblur = function () { calnet(''); };

mytd.appendChild(mybox1);
myrow.appendChild(mytd);


myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

}
}


function p1(b,a)
{
var ab=a;

var len14=document.getElementById(ab).value;
var len1=len14.length;
if(len1>125) 
{
alert('Max of 125 Characters');
event.keyCode=false;
		return false;

}

}

function reloadpage(d)
{
var date=document.getElementById(d).value;
 document.location = 'dashboardsub.php?page=noninv_directpurchases&date=' + date;
}

function calcu()
{
 var total=0;
 var grandtotal=0;
 var amt=0;
 var dis=0;
 for(k =1;k <=index;k++)
 {
  
if(document.getElementById("amt" + k).value != "" || document.getElementById("dis" + k).value != "")
{
 if(document.getElementById("dis" + k).value=="")
 dis=0;
 else
 dis=Number(document.getElementById("dis" + k).value);
 
 if(document.getElementById("amt" + k).value == "")
 amt=0;
 else
  amt=Number(document.getElementById("amt" + k).value);
 total=amt-dis;
 grandtotal+=total;
}

 }
document.getElementById("gtot").value=Number(grandtotal);

}


</script>

<script type="text/javascript">
<?php if($type=='Debit'){ ?>

function script1() {
window.open('P2PHelp/help_t_adddnote.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
<?php }else {?>
function script1() {
window.open('P2PHelp/help_t_addcdnote.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
<?php } ?>
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




