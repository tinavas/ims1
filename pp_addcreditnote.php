<?php   include "getemployee.php"; 
include "jquery.php"; 
include "config.php";
		include "config.php";
		$type = $_GET['type'];

 if($type == 'Credit') { $mode = 'Vendor Credit'; $mode1 = 'VCN'; }
 else if($type == 'Debit') { $mode = 'Vendor Debit'; $mode1 = 'VDN'; }

$q = "select max(crnum) as cnum from ac_crdrnote WHERE mode = '$mode1' and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['cnum']; }
$tnum = $tnum + 1;

$tid=$mode1."-".$tnum;



$q1=mysql_query("SET group_concat_max_len=10000000");
	//for unit
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
		 
		 
//vendor		 
		 $query = "SELECT group_concat(distinct(name) ORDER BY name ASC) as codename FROM contactdetails where (type = 'vendor' OR type = 'vendor and party') and client = '$client'  "; 
      $result = mysql_query($query,$conn);
     $row = mysql_fetch_assoc($result);
	 $codename=explode(",",$row['codename']);

$codenames=json_encode($codename);





 $q = "SELECT GROUP_CONCAT(code,'@',description ORDER BY code asc ) AS codedesc from ac_coa where controltype = '' and schedule not in('Inventories','Inventories Work In Progress','Trade Payable','Trade Receivable','Price Variance','Production Variance','Cost Of Sales /Services','Revenue from operations')";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$r=mysql_fetch_array($qrs);
{
$items=explode(",",$r['codedesc']);

} 
$item=json_encode($items);


?>

<script type="text/javascript">

var codenames= <?php if(empty($codenames)) { echo "0";} else {echo $codenames;}?> 

var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;
</script>




<center>
<section class="grid_8">
  <div class="block-border">
  								
						
								
								
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savecreditnote.php" onsubmit="return checkform(this);">
		


<br />

<h1><?php echo $mode;?> Note</h1>
<br />


<b><?php echo $mode;?> Note</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br />
<br />
<br />



 
<input type="hidden" name="type" id="type" value="<?php echo $_GET['type']; ?>" />
<input type="hidden" name="mode1" id="mode1" value="<?php echo $mode1; ?>" />
<input type="hidden" name="tno" id="tno" value="<?php echo $tnum;?>" />

<table border="0"	align="center">
<tr align="center">
<td align="right"><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="tid" name="tid" value="<?php echo $tid; ?>" readonly style="border:0px;background:none" />&nbsp;&nbsp;</td>
<td align="right"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="15" id="date" class="datepicker" name="date" value="<?php echo date("d.m.Y"); ?>"/></td>
<td align="right"><strong>Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left">

 <select id="unitc" name="unitc"  >
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

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select  style="width: 170px" name="vendor" id="vendor">
                <option value="">-Select-</option>
				
				
				<?php 
       
 for($j=0;$j<count($codename);$j++)
		   {
			
           ?>
<option value="<?php echo $codename[$j];?>" title="<?php echo $codename[$j]; ?>"><?php echo $codename[$j]; ?></option>

<?php } ?>



</select></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong><?php if($type == "Credit") { ?><?php }?>Amount&nbsp;&nbsp;&nbsp;</strong></td>
<td align="left"><input type="text" style="text-align:right;" size="15" id="vendamount" name="vendamount" value="" onchange="total();"  /></td>
</tr>
</table>
<br />
<table border="0" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead>
<th><strong>S.No.</strong></th>
<th width="10px"></th>
<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Dr/Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Dr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
</thead>
</tr>
<tr style="height:20px"></tr>
<tr>
<td><label id="sno" style="text-align:center;">1</label></td>
<td width="10px"></td>
<td><select id="code1" name="code[]" onchange="getdesc(this.id);" style="width:80px">
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
<td><select id="desc1" name="desc[]"  onchange="getcode(this.id);" style="width:170px">
    <option value="">-Select-</option>
<?php 
for($i=0;$i<count($items);$i++)
							{ $desc1=explode("@",$items[$i]);
					?>
	
					<option title="<?php echo $desc1[1];?>" value="<?php echo $items[$i];?>"><?php echo $desc1[1]; ?></option>
					<?php   }   ?> </select></td>
<td width="10px"></td>
<td><select id="drcr1" name="drcr[]" onchange="enabledrcr(this.id);"><option value="">-Select-</option><option value="Cr">Cr</option><option value="Dr">Dr</option></select></td>
<td width="10px"></td>
<td><input type="text" id="dramount1" name="dramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" readonly /></td>
<td width="10px"></td>
<td><input type="text" id="cramount1" name="cramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" readonly /></td>
</tr>
</table>
<br />


<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td><input type="text" style="visibility:hidden" size="8"/></td>
<td><input type="text" style="visibility:hidden" size="12"/></td>
<td><input type="text" style="visibility:hidden" size="12"/></td>
<td><input type="text" style="visibility:hidden" size="10"/></td>
<td><input type="text" style="visibility:hidden" size="8"/></td>
<td align="right"><strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="10px"></td>
<td align="right"><input type="text" id="drtotal" style="text-align:right;background:none;border:none;" name="drtotal" value="0" size="8" align="right" readonly  /></td>
<td width="10px"></td>
<td align="right"><input type="text" id="crtotal" style="text-align:right;background:none;border:none;" name="crtotal" value="0" size="8" align="right" readonly /></td>
<td><input type="text" style="visibility:hidden" size="8"/></td>
</tr>
</table>

<table border="0" align="center">
<td style="vertical-align:middle"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea id="remarks" name="remarks" rows="3" cols="50"></textarea></td>
</table>


<center>
<input type="submit" value="Save" id="Save" disabled="disabled" name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_creditnote&type=<?php echo $type; ?>';">
</center>

</form>
</div>
</section>
</center>
<br />
<!-- </center> -->

<br />
</form>
<script type="text/javascript">

function checkform()
{ 
var ctot=0;
var dtot=0;
	if(document.getElementById('unitc').value == "")
	{
	 alert("Select unit");
	 return false;
	}

	if(document.getElementById('vendor').value == "")
	{
	 alert("Select vendor");
	 return false;
	}
	
	
	for (var i = 1;i<=index;i++)
	{
		i1 = i;
		
		if(Number(document.getElementById('cramount' + i1).value)>0 ||Number(document.getElementById('dramount' + i1).value)>0)
		
		{
		
		if(document.getElementById('code' + i1).value=="" || document.getElementById('desc' + i1).value=="")
		{
		
		alert("Please select code");
		return false;
		}
		
		}



		ctot=ctot+Number(document.getElementById('cramount' + i1).value);
		dtot=dtot+Number(document.getElementById('dramount' + i1).value);
	}
	
	
	var type = document.getElementById('type').value;
	if ( type == "Credit")
	{
	var diff = dtot - ctot;
	}
	else
	{
	var diff = ctot - dtot;
	}
	var vamt = parseFloat(document.getElementById('vendamount').value);
	if( diff.toFixed(2) == vamt.toFixed(2) )
	{
	document.getElementById('Save').disabled = false;
	}
	else
	{
	document.getElementById('Save').disabled = true;
	}

	document.getElementById('Save').disabled = true;
	
	}

function getdesc(cid)
{


var a=cid.substr(4,cid.length);

if(document.getElementById('code' + a).value=="")
{
		document.getElementById('desc' + a).value = "";
		return false;
}

for(i=1;i<=index;i++)
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

for(i=1;i<=index;i++)
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




function total()
{
var a = index;
	var ctot = 0;
	var dtot = 0;
	var i1;
	for (var i = 1;i<=index;i++)
	{
		i1 = i;
	
		ctot+=parseFloat(document.getElementById('cramount' + i1).value);
		dtot+=parseFloat(document.getElementById('dramount' + i1).value);
	}
	document.getElementById('crtotal').value = ctot.toFixed(2);
	document.getElementById('drtotal').value = dtot.toFixed(2);
	var type = document.getElementById('type').value;
	if ( type == "Credit")
	{
	var diff = dtot - ctot;
	}
	else
	{
	var diff = ctot - dtot;
	}
	var vamt = parseFloat(document.getElementById('vendamount').value);
	if( diff.toFixed(2) == vamt.toFixed(2) )
	{
	document.getElementById('Save').disabled = false;
	}
	else
	{
	document.getElementById('Save').disabled = true;
	}
}

function enabledrcr(index)
{
index=index.substr(4);
var a = index;
document.getElementById('cramount' + a).value = 0;
document.getElementById('dramount' + a).value = 0;
//document.getElementById('crtotal').value = 0;
//document.getElementById('drtotal').value = 0;
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
	
total();
}


var index = 1;
function makeForm() {
if(document.getElementById("desc"+index).value!="")
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

myselect1.style.width = "80";

theOption1=document.createElement("OPTION");

theText1=document.createTextNode("-Select-");

theOption1.value = "";

theOption1.appendChild(theText1);


myselect1.appendChild(theOption1);
myselect1.onchange = function ()  {  getdesc(this.id); };

 for(j=0;j<(items.length);j++)
 
		   {
		   
		   var code1=items[j].split("@");
		  
		   
		   	var theOption=new Option(code1[0],items[j]);
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




var mytd1 = document.createElement("td");
myselect1 = document.createElement("select");
myselect1.id = "desc" + index;
myselect1.name = "desc[]";
myselect1.style.width = "170";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);

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


var mytd1 = document.createElement("td");

var myselect1 = document.createElement("select");

theOption1=document.createElement("OPTION");

theText1=document.createTextNode('-Select-');

theOption1.value = "";

theOption1.appendChild(theText1);

theOption1.value = "Select";

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

myselect1.id = "drcr" + index;

myselect1.onchange = function ()  {  enabledrcr(myselect1.id); };

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

mybox1.onfocus = function ()  {  makeForm(); };

mybox1.onchange = function ()  {  total(); };

mytd.appendChild(mybox1);

myrow.appendChild(mytd);




mytable.appendChild(myrow);
}
}

</script>

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_t_addcdnote.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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




