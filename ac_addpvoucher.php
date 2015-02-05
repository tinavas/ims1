<?php  
		include "config.php";
		include "jquery.php";
$voucher = 'P';
$tnum=0;
	$trnum1="";	
	
	$mode = $_GET['mode'];
$sdb = $_SESSION['db'];
	
	$q1=mysql_query("SET group_concat_max_len=10000000");
	//for unit
				  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
      
		$q = "SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector";
	 
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
		 $q = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE  sector in ($sectorlist)";
	  
	 }
	 


		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		

		 $sec1=explode(",",$qr["sector"]);	
		 $sector=json_encode($sec1);

	
	
	
	//coa code and descripton	 
	
	
	$q1="SELECT concat(\"'\",group_concat(loanac separator \"','\"),\"'\") as allcoa FROM `hr_employee` WHERE 1";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$restrictedcoas=$r1['allcoa'];

if($restrictedcoas=="")
{
$restrictedcoas="''";
}
	
		 
		  $q = "select group_concat(code,'@',DESCRIPTION order by code) as cd   FROM ac_coa where controltype in('Cash','Bank') and code not in ($restrictedcoas) ";
		  
		
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		
		
		 $codedesc=explode(",",$qr["cd"]);	
		 $codedesc1=json_encode($codedesc);
	
	
	
		
//iteams and codes


$q = "SELECT GROUP_CONCAT(code,'@',description ORDER BY code ) AS codedesc from ac_coa where controltype in('','Bank','Cash') and type <> 'Revenue' and schedule not in('Inventories','Inventories Work In Progress','Trade Receivable','Trade Payable','Cost Of Sales /Services','Price Variance','Production Variance') and code not in ($restrictedcoas)";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$r=mysql_fetch_array($qrs);
{
$items=explode(",",$r['codedesc']);

} 
$item=json_encode($items);


	
	
	
		
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
$tnum = "PV-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tnum="PV-1";

}




//cash code

	   
		  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select group_concat(code,'@',coacode order by code) as cashcode from ac_bankmasters where mode = 'Cash' and client = '$client'";
		   }
		   else
		   {
		   $sectorlist = $_SESSION['sectorlist'];
		 $q = "select group_concat(code,'@',coacode order by code)   as cashcode from ac_bankmasters where mode = 'Cash' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) ";
		   }
		
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);

		 $cashcodes=explode(",",$qr["cashcode"]);	
	 $cashcodes1=json_encode($cashcodes);

//bank code

	if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select group_concat(acno,'@',coacode  order by acno) as bankcode from ac_bankmasters where mode = 'Bank' and client = '$client' order by acno";
		   }
		   else
		   {
		    $sectorlist = $_SESSION['sectorlist'];
			$q = "select group_concat(acno,'@',coacode  order by acno) as bankcode from ac_bankmasters where mode = 'Bank' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) order by acno";
		   }

$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		
		 $bankcodes=explode(",",$qr["bankcode"]);	
		 $bankcodes1=json_encode($bankcodes);


		
	
?>



<script type="text/javascript">


var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;

var sectors=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;

var cashbankcodes=<?php if(empty($cashbankcodes)){echo 0;} else{ echo $cashbankcodes; }?>;
var bankcodes=<?php if(empty($bankcodes1)){echo 0;} else{ echo $bankcodes1; }?>;
var cashcodes=<?php if(empty($cashcodes1)){echo 0;} else{ echo $cashcodes1; }?>;
var codedesc=<?php if(empty($codedesc1)){echo 0;} else{ echo $codedesc1; }?>;
var chequeno=<?php if(empty($chequeno)){echo 0;} else{ echo $chequeno; }?>;


</script>


<center>

<section class="grid_8">
  <div class="block-border">


<form id="form1" name="form1" method="post"  class="block-content form"  action="ac_savepvoucher.php" onsubmit="return checkform1(this);" >
<input type="hidden" id="mode" name="mode" value="<?php echo $_GET['mode']; ?>" />
<h1>Payment Voucher</h1>
<br />
<b>Payment Voucher</b> 

<br />
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />

<table border="0" align="center">
 <tr>
 <td width="30px"></td>
<td><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="tno" name="tno" size="6" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  /></td>
 <td width="10px"></td>
 <td>&nbsp;&nbsp;&nbsp;<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><input type="text" size="15" id="date" class="datepickerPRJV" onchange="check_totamt(this);" name="date" value="<?php echo date("d.m.Y"); ?>" /></td>
  
   <td>&nbsp;&nbsp;&nbsp;<strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 
 <td>
 <select id="unitc" name="unitc" style="width:150px" >
<option value="">-Select-</option>
<?php 
       
 for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>" title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php } ?>
</select>

 
 
 </td>
 </tr>
<tr height="10px"><td></td></tr>
</table>
<br />
<br />


<table align="center">
<tr>


<td width="40px"></td>
<td><strong>Voucher No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="vno" name="vno" size="15"/></td>
<td width="40px"></td>

<td><strong id="codename">Cash/Bank Codes</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td>
<select id="cno" name="cno" onchange="codecoa();" style="width:150px">
<option value="">-Select-</option>

 <?php
  

 
       
 for($j=0;$j<count($cashcodes);$j++)
		   {
			$cashcodes1=explode('@',$cashcodes[$j]);
		if($cashcodes1[0]!=" ")
		{
           ?>
<option value="<?php echo $cashcodes1[0];?>"  title="<?php echo $cashcodes1[0]; ?>"><?php echo $cashcodes1[0]; ?></option>
<?php }} 


	for($j=0;$j<count($bankcodes);$j++)
		   {
			$bankcodes1=explode('@',$bankcodes[$j]);
			if($bankcodes1[0]!=" ")
		{
           ?>
<option value="<?php echo $bankcodes1[0];?>"  title="<?php echo $bankcodes1[0]; ?>"><?php echo $bankcodes1[0]; ?></option>
<?php } } 
	

  ?>
</select>
</td>

</tr>
<tr height="10px"><td></td></tr>
</table>
<br />
<div style="height:auto">
<table border="0" cellpadding="2" cellspacing="2" id="mytable" align="center">
<thead>
<th><strong>S.No.</strong></th>
<th></th>
<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th></th>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th></th>
<th><strong>Dr/Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Dr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Narration</strong></th>
<th></th>


</thead>

<tr height="10px"><td></td></tr>

<tr>
<td><label id="sno">1</label></td>
<td width="10px"></td>
<td><select id="code0" name="code[]" onchange="getdesc(this.id);" style="width:100px;">
        <option value="">-Select-</option>

</select></td>
<td width="10px"></td>
<td><select id="desc0" name="desc[]" style="width:170px;" onchange="getcode(this.id);">
        <option value="">-Select-</option>

</select></td>
<td width="10px"></td>
<td><select id="drcr0" name="drcr[]" onchange="enabledrcr(this.id);" style="width:50px;">
      <option value="">-Select-</option><option value="Cr">Cr</option><option value="Dr">Dr</option>
</select></td>
<td width="10px"></td>
<td><input type="text" id="dramount0" name="dramount[]" value="0" style="text-align:right" size="8" onkeyup="total();check_totamt(this);" onblur="total();check_totamt(this);" readonly /></td>
<td width="10px"></td>
<td><input type="text" id="cramount0" name="cramount[]" value="0" style="text-align:right" size="8" onkeyup="total();check_totamt(this);" onblur="total();check_totamt(this);" onfocus="makeForm()"  /></td>

<td width="10px"></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"></textarea></td>


</tr></table>
<br />
<br />


<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>
<td width="150px" align="right">
<strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>

<td align="left">
<input type="text" id="drtotal" name="drtotal" value="0.00" size="8" readonly style="border:0px;background:none; text-align:right" /></td>

<td align="left">
<input type="text" id="crtotal" name="crtotal" value="0.00" size="8" readonly style="border:0px;background:none; text-align:right"/></td>
<td>
<input type="text" style="visibility:hidden" size="14"/>
</td>
</tr>

</table>
<br />

</div>
<br />

<table align="center">
<tr>
<td width="250px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?>><strong>Payee Name</strong></td>
<td width="10px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?>><input type="text" name="pname" id="pname" value="" /></td>
<td width="30px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?>><strong>Payment Mode</strong></td>
<td width="10px"></td>
<td <?php if($_GET['mode'] == "Cash") { ?> style="visibility:hidden" <?php } ?> ><select id="pmode" name="pmode" onchange="chequeenable();">
<option value="">-Select-</option>
<option value="Cheque">Cheque</option>
<option value="Others">Others</option>
</select>
</td>
<td width="30px"></td>
<td style="visibility:hidden" id="chtd"><strong>Cheque No.</strong></td>
<td width="10px"></td>
<td style="visibility:hidden"><input type="text" id="chno" name="chno" value=""/></td>
</tr>
<tr height="10px"><td></td></tr>
</table>
<table align="center">
<tr>
<td></td>
</tr>
</table>


<input type="submit" value="Save" id="Save" disabled="disabled" name="Save"/>&nbsp;&nbsp;&nbsp;<input name="button" type="button" onclick="document.location='dashboardsub.php?page=ac_pvoucher';" value="Cancel" />

<br />
</form>
</div>
</section></center>
<script type="text/javascript">
function check_totamt(dis)
{
	var dt=document.getElementById("date").value;
	dt=dt.split(".");
	dt=dt[2]+"-"+dt[1]+"-"+dt[0];
	
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




if(form.cno.value == "")

{
alert("Please code ");

return false;
}




for(j=0;j<=index;j++)
{


k=j;

if(Number(document.getElementById('cramount' + k).value >0)  ||Number(document.getElementById('dramount' + k).value >0))
{
if(document.getElementById('code'+k).value=="" || document.getElementById('drcr'+k).value=="" || document.getElementById('desc'+k).value=="")
{


	alert("Select code for row"+(j+1));
	return false;

}


}



for(p=0;p<=index;p++)
{

if((document.getElementById('code'+k).value==document.getElementById('code'+p).value)&& (p!=k)&& (document.getElementById('code'+k).value=!""))
{
document.getElementById('code'+k).value=document.getElementById('code' +p).value
	document.getElementById('code' +p).value="";
	document.getElementById('desc' + p).value="";

	alert("Select different code for row "+(p+1));

	return false;
}



}




}

document.getElementById('Save').disabled=true;	
}


function getdesc(cid)
{


var a=cid.substr(4,cid.length);

if(document.getElementById('code' + a).value=="")
{
		document.getElementById('desc' + a).value = "";
		return false;
}

for(i=0;i<=index;i++)
{

if((document.getElementById('code' + a).value==document.getElementById('code' + i).value)&&(i!=a))

{

alert("Please select different code");
document.getElementById('code' + a).value="";
return false;

}


}


document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

		document.getElementById('desc' + a).value = document.getElementById('code' + a).value;
		
		
	
		
}
function getcode(cid)
{




var a=cid.substr(4,cid.length);

if(document.getElementById('desc' + a).value=="")
{		document.getElementById('code' + a).value = "";
		document.getElementById('desc' + a).value="";
		return false;
}

for(i=0;i<=index;i++)
{

if((document.getElementById('desc' + a).value==document.getElementById('desc' + i).value)&&(i!=a))

{

alert("Please select different description");
document.getElementById('desc' + a).value="";
document.getElementById('code' + a).value="";
return false;

}


}




document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

		document.getElementById('code' + a).value = document.getElementById('desc' + a).value;
		

		
		
		
}




function descriptionf()
{



 var myselect1=document.getElementById('desc0');
 var code=document.getElementById('code0').value;
 
 for(j=0;j<codedesc.length;j++)
 {
 
 	codedesc1=codedesc[j].split("@");
	
	if(codedesc1[0]==code)
	{
	  	var theOption=new Option(codedesc1[1],codedesc1[0]);
			
		theOption.title=codedesc1[1];
		theOption.selected=true;
			myselect1.options.add(theOption);
			
			}
 
 
 }


		
}





function codecoa()
{
 removeAllOptions(document.getElementById("code0"));
  removeAllOptions(document.getElementById("desc0"));
 removeAllOptions(document.getElementById("drcr0"));
   myselect1 = document.getElementById("code0");
   
      document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount0').value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount0').value;
document.getElementById('cramount0').value=0;
document.getElementById('dramount0').value=0;

 var code = document.getElementById('cno').value;
 

 
 for(i=0;i<cashcodes.length;i++)
 {

 	cashbank1=cashcodes[i].split("@");
	

	if(cashbank1[0]==code)
	
	{
	
	  var op1=new Option(cashbank1[1],cashbank1[1]);
		op1.selected = "true";
		
			myselect1.options.add(op1);
	}
 
 
 }
 


for(i=0;i<bankcodes.length;i++)
 {
 
 
 	cashbank1=bankcodes[i].split("@");
	
	
	
	
	
	if(cashbank1[0]==code)
	
	{
	
	  var op1=new Option(cashbank1[1],cashbank1[1]);
		op1.selected = "true";
		
			myselect1.options.add(op1);
	}
 
 
 }
 

		
		descriptionf();     
         myselect2 = document.getElementById("drcr0");

		var op1=new Option("Cr","Cr");
		op1.selected = "true";
		
			myselect2.options.add(op1);
	
	document.getElementById('cramount0').readOnly=false;
document.getElementById('dramount0').readOnly=true;
	if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Save').disabled=true;	
	
	
}


function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length;i>0;i--)
	{
		selectbox.remove(i);
	}
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
if(index == -1)
var a = "";
else 
var a = index;
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
	
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
	if( document.getElementById('crtotal').value == document.getElementById('drtotal').value && (ctot!=0) )
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
document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount' + z).value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount' + z).value;


document.getElementById('cramount' + z).value = 0;
document.getElementById('dramount' + z).value = 0;

	if(document.getElementById('drcr' + z).value == "Cr")
	{

	document.getElementById('cramount' + z).removeAttribute('readonly','readonly');
	
document.getElementById('dramount' +z).setAttribute('readonly',true);
      }
	else if(document.getElementById('drcr' + z).value == "Dr")
	{
document.getElementById('dramount' + z).onfocus = function ()  {  makeForm(); };
	document.getElementById('dramount' + z).removeAttribute('readonly','readonly');
	document.getElementById('cramount' +z).setAttribute('readonly',true);
	}
	else
	{
	document.getElementById('dramount' +z).setAttribute('readonly',true);
	document.getElementById('cramount' +z).setAttribute('readonly',true);
	}	
		if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Save').disabled=true;
}


</script>



<script type="text/javascript">
var index = 0;
function makeForm() 
{

var a = index;
if((document.getElementById('code' + a).value != "")&&(document.getElementById('code' + a).value != "-select-"))
{
index = index + 1;

///////////para element//////////

var mytable=document.getElementById("mytable");
var myrow = document.createElement("tr");
var mytd = document.createElement("td");
var mybox1=document.createElement("label");
theText1=document.createTextNode(index + 1);
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
myselect1.style.width="100px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function ()  {  getdesc(this.id); };


	   
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
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function ()  {  getcode(this.id); };

                     
            for(j=0;j<(items.length);j++)
		   {desc1=items[j].split("@");
		  
		   
		   	var theOption=new Option(desc1[1],desc1[0]);
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
theOption1=document.createElement("OPTION");
theText1=document.createTextNode('-Select-');
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
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

mybox1.setAttribute('readonly',true);
mybox1.value = 0;
mybox1.size = "8";
mybox1.id = "dramount" + index;
mybox1.onkeyup = function ()  {  total();check_totamt(this); };

mybox1.onblur = function ()  {  total();check_totamt(this); };
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
mybox1.onkeyup = function ()  {  total();check_totamt(this); };

mybox1.onblur = function ()  {  total();check_totamt(this); };
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

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);




}
}

</script>



<script type="text/javascript">
function script1() {
window.open('GLHelp/help_t_addpaymentvoucher.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
