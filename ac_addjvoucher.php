
<?php   
		include "config.php";
		include "jquery.php";
		$client = $_SESSION['client'];
		$sdb = $_SESSION['db'];
	
		

	$q1=mysql_query("SET group_concat_max_len=10000000");

				  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
      
		$q = "SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector WHERE type1 <> 'Warehouse'";
	 
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
		$q = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 <> 'Warehouse'  and sector in ($sectorlist)";
	  
	 }
	 
	 
	 


		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		

		 $sec1=explode(",",$qr["sector"]);	
		 $sector=json_encode($sec1);
	

		
		
?>
<?php  $voucher = 'J';
			
	$tnum=0;
	$trnum1="";		
 $q = "select transactioncode as tid from  `ac_gl` where client = '$client' and voucher = '$voucher'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],3);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$tnum = "JV-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tnum="JV-1";

}

//code description


$q = "SELECT GROUP_CONCAT(distinct(code),'@',description ORDER BY code ) AS codedesc  FROM ac_coa WHERE controltype IN ('')";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$r=mysql_fetch_array($qrs);
{
$items=explode(",",$r['codedesc']);

} 
$item=json_encode($items);


?>

<script type="text/javascript">


var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;

var sectors=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;
</script>


<center>

<section class="grid_8">
  <div class="block-border">


<form id="form1" name="form1" method="post" action="ac_savejvoucher.php"  class="block-content form" onsubmit="return checkform1(this);" >


<h1>Journal Voucher</h1>
<br />
<b>Journal Voucher</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />

<table align="center">
<tr>
<td>
<strong>Transaction No.</strong>
</td>


<td>
<input type="text" id="tno" name="tno" size="6" value="<?php echo $tnum; ?>" readonly style=" border:0px;background:none" />
</td>

 <td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
 </td>
 <td>
 <input type="text" class="datepicker" size="10" id="date" name="date" readonly="true" value="<?php echo date("d.m.Y"); ?>" />
  </td>
   <?php $sdb = $_SESSION['db'];
 
 ?>
   <td>&nbsp;&nbsp;&nbsp;<strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>

 <td>
 <select id="unitc" name="unitc" style="width:150px;" >
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

<td><strong>Voucher No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="vno" name="vno" value="<?php echo $vno;?>"/></td>
 <td width="40px"></td>

</tr>
<tr height="10px"><td></td></tr>
</table>
<br />
<br />


<table border="1" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead align="center">
<td>
<strong>S.No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td></td>
<td>
<strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td></td>
<td>
<strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td></td>
<td>
<strong>Dr/Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td></td>
<td>
<strong>Dr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td></td>
<td>
<strong>Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td></td>
<td><strong>Narration</strong></td>

</thead>
</tr>
<tr>
<td>

<label id="sno">1</label>
</td>
<td width="10px"></td>
<td>
<select id="code0" name="code[]" onchange="description(this.id);" style="width:100px;">
<option value="">-Select-</option>
<?php 


	for($i=0;$i<count($items);$i++)
							{ 
							
							$code1=explode("@",$items[$i]);
							
					?>
					<option title="<?php echo $code1[1];?>" value="<?php echo $code1[0];?>"><?php echo $code1[0]; ?></option>
					<?php   }   ?>

</select>
</td>
<td width="10px"></td>
<td>
<select style="width:170px" id="desc0" name="desc[]" onchange="getcode(this.id);">
<option value= "">-select-</option>
<?php 
for($i=0;$i<count($items);$i++)
							{ $desc1=explode("@",$items[$i]);
					?>
	
					<option title="<?php echo $desc1[1];?>" value="<?php echo $desc1[1];?>"><?php echo $desc1[1]; ?></option>
					<?php   }   ?> ?>
</select>
</td>

<td width="10px"></td>
<td>
<select id="drcr0" name="drcr[]" onchange="enabledrcr(this.id);" style="width:50px;">
<option value="">Select</option>
<option value="Cr">Cr</option>
<option value="Dr">Dr</option>
</select>
</td>
<td width="10px"></td>
<td>
<input type="text" id="dramount0" name="dramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" onblur="newrow(this.value);" readonly />
</td>
<td width="10px"></td>
<td>
<input type="text" id="cramount0" name="cramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" onblur="newrow(this.value);" readonly />
</td>
<td width="10px"></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"></textarea></td>

</tr>
</table>
<br />
<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="12"/>
</td>



<td width="150px" align="right">
<strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td align="left">
<input type="text" id="drtotal" name="drtotal" value="0.00" size="8" readonly style="border:0px;background:none; text-align:right" />
</td>
<td align="left">
<input type="text" id="crtotal" name="crtotal" value="0.00" size="8" readonly style="border:0px;background:none; text-align:right"/>
</td>
<td >
<input type="text" style="visibility:hidden" size="14"/>
</td>
</tr>
</table>
<br />
<center>
<input type="submit" value="Save" id="Save" disabled="disabled" name="Save"/>&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_jvoucher';">
</center>
</form>
</div>
</section>
</center>
<br />


<script type="text/javascript">

function getcode(cid)
{


var a=cid.substr(4,cid.length);

if(document.getElementById('desc' + a).value=="")
{
		document.getElementById('code' + a).value = "";
		return false;
}




for(i=0;i<=index;i++)
{

if((document.getElementById('desc' + a).value==document.getElementById('desc' + i).value)&&(i!=a))

{

alert("Please select different description");
document.getElementById('desc' + a).value="";
return false;

}


}


document.getElementById("code"+a).selectedIndex=document.getElementById("desc"+a).selectedIndex;



		
}

function description(cid)
{

var a=cid.substr(4,cid.length);

if(document.getElementById('code' + a).value=="")
{
		document.getElementById('desc' + a).value = "";
		document.getElementById('code' + a).value="";
		return false;
}



for(i=0;i<=index;i++)
{

if((document.getElementById('code' + a).value==document.getElementById('code' + i).value)&&(i!=a))

{

alert("Please select different code");
document.getElementById('code' + a).value="";
document.getElementById('desc' + a).value="";
return false;

}

}
document.getElementById("desc"+a).selectedIndex=document.getElementById("code"+a).selectedIndex;



		
}
function chequeenable()
{
	if(document.getElementById('pmode').value == "Cheque")
	{
	document.getElementById('chno').style.visibility = "visible";
	document.getElementById('chtd').style.visibility = "visible";
	}
	else
	{
	document.getElementById('chno').value = "";
	document.getElementById('chtd').style.visibility = "hidden";
	document.getElementById('chno').style.visibility = "hidden";
	}
}

function total()
{


	var ctot = 0;
	var dtot = 0;
	var i1;
	for (var i = 0;i<=index;i++)
	{
		
		i1 = i;
		
		
		if(document.getElementById('cramount' + i1).value=="")
		document.getElementById('cramount' + i1).value=0;
		if(document.getElementById('dramount' + i1).value=="")
		document.getElementById('dramount' + i1).value=0;
		
		ctot+=parseFloat(document.getElementById('cramount' + i1).value);
		dtot+=parseFloat(document.getElementById('dramount' + i1).value);
	}
	document.getElementById('crtotal').value = ctot.toFixed(2);
	document.getElementById('drtotal').value = dtot.toFixed(2);
	
	if( document.getElementById('crtotal').value == document.getElementById('drtotal').value )
	{	
	document.getElementById('Save').disabled = false;
	}
	else
	document.getElementById('Save').disabled = true;
}

function enabledrcr(b)
{
temp = b.split("cr");
var z = temp[1];	
var a=z;
document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount' + z).value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount' + z).value;


document.getElementById('cramount' + a).value = 0;
document.getElementById('dramount' + a).value = 0;

	if(document.getElementById('drcr' + a).value == "Cr")
	{
	document.getElementById('cramount' + a).removeAttribute('readonly','readonly');
	document.getElementById('dramount' +a).setAttribute('readonly',true);
	}
	else if(document.getElementById('drcr' + a).value == "Dr")
	{
	document.getElementById('dramount' + a).removeAttribute('readonly','readonly');
	document.getElementById('cramount' +a).setAttribute('readonly',true);
	}
	else
	{
	document.getElementById('dramount' +a).setAttribute('readonly',true);
	document.getElementById('cramount' +a).setAttribute('readonly',true);
	}

if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Save').disabled=true;

	
}
function checkform(form)
{
if(form.unitc.value == "")
{
alert("Please Select Unit");
 form.unitc.focus();
return false;
}


return true;
	
}
var index2 = 0;
function newrow(amount)
{
if(index2 == 0)
{ 
 if(parseFloat(amount) > 0)
 {
  makeForm();
  index2 = 1;
 } 
}
else if(document.getElementById('code'+index).value != "" && parseFloat(amount) > 0 && index >= 0)
     makeForm();
}

function checkform1(form)
{
if(form.unitc.value == "")
{
alert("Please Select Unit");
 form.unitc.focus();
return false;
}


if(form.vno.value == "")
{
alert("Please enter voucher number");
 form.vno.focus();
return false;
}




for(j=0;j<=index;j++)
{

k=j;

if(Number(document.getElementById('cramount' + k).value >0)  ||Number(document.getElementById('dramount' + k).value >0))
{
if(document.getElementById('code'+k).value=="" || document.getElementById('drcr'+k).value=="" || document.getElementById('desc'+k).value=="")
{


	
	alert("Select code for the row"+(k+1))
	
	return false;

}


}




}

document.getElementById('Save').disabled=true;	
}




var index = 0;
function makeForm() {
var a = index;
if((document.getElementById('code' + a).value != "")&&(document.getElementById('code' + a).value != "-select-"))
{
index = index + 1;

///////////para element//////////

var mytable=document.getElementById("mytable");

var myrow = document.createElement("tr");

var mytd = document.createElement("td");

var mybox1=document.createElement("label");


theText1=document.createTextNode(index+1);

mybox1.appendChild(theText1);



mybox1.id = "sno" + index;



mytd.appendChild(mybox1);

myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd1 = document.createElement("td");

myselect1 = document.createElement("select");

myselect1.id = "code" + index;

myselect1.name = "code[]";
myselect1.style.width="100px"
 var op1=new Option("-Select-","");
myselect1.options.add(op1);

myselect1.onchange = function ()  {  description(this.id); };


          
		  
		   
            for(j=0;j<(items.length);j++)
		   {code1=items[j].split("@");
		  
		   	var theOption=new Option(code1[0],code1[0]);
			theOption.title = code1[1];
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

myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc" + index;
myselect1.style.width = "170px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function ()  {  getcode(this.id); };


 for(j=0;j<(items.length);j++)
		   {desc1=items[j].split("@");
		  
		   	var theOption=new Option(desc1[1],desc1[1]);
			theOption.title = desc1[1];
			myselect1.options.add(theOption);
		
 			} 

mytd.appendChild(myselect1);

myrow.appendChild(mytd);




myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd1 = document.createElement("td");

var myselect1 = document.createElement("select");

 var op1=new Option("-Select-","");
myselect1.options.add(op1);


theOption1=document.createElement("OPTION");

theText1=document.createTextNode('Cr');

theOption1.appendChild(theText1);

theOption1.value = "Cr";

myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");

theText1=document.createTextNode('Dr');

theOption1.appendChild(theText1);

theOption1.value = "Dr";

myselect1.appendChild(theOption1);

myselect1.name = "drcr[]";
myselect1.style.width="50px";
myselect1.id = "drcr" + index;

myselect1.onchange = function ()  {  enabledrcr(this.id); };

mytd1.appendChild(myselect1);

myrow.appendChild(mytd1);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd = document.createElement("td");

var mybox1=document.createElement("input");

mybox1.type="text";

mybox1.name="dramount[]";

mybox1.style.textAlign = "right";

//mybox1.setAttribute("style.text-align","right");

mybox1.setAttribute('readonly',true);

mybox1.value = 0;

mybox1.size = "8";

mybox1.id = "dramount" + index;


mybox1.onkeyup = function ()  {  total(); };
mybox1.onblur = function ()  {  newrow(this.value); };

mytd.appendChild(mybox1);

myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd = document.createElement("td");

var mybox1=document.createElement("input");

mybox1.type="text";

mybox1.name="cramount[]";

mybox1.setAttribute('readonly',true);

mybox1.size = "8";

mybox1.value = 0;

mybox1.id = "cramount" + index;

mybox1.style.textAlign = "right";

mybox1.onchange = function ()  {  total(); };
mybox1.onblur = function ()  {  newrow(this.value); };
mytd.appendChild(mybox1);

myrow.appendChild(mytd);





mytable.appendChild(myrow);


myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

var mytd = document.createElement("td");

var mybox1=document.createElement("textarea");

mybox1.name="remarks[]";

mybox1.rows = "2";

mybox1.cols = "30";

mybox1.id = "remarks" + index;

mytd.appendChild(mybox1);

myrow.appendChild(mytd);

mytable.appendChild(myrow);
}

}





</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_t_addregvoucher.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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



