<?php   include "getemployee.php"; 
include "jquery.php"; 
include "config.php";
		
		$type = $_GET['type'];

 if($type == 'Credit') { $mode = 'Vendor Credit'; $mode1 = 'VCN'; }
 else if($type == 'Debit') { $mode = 'Vendor Debit'; $mode1 = 'VDN'; }

$get_Details="select * from ac_crdrnote where crnum='".$_GET['id']."' and mode='".$mode1."'";
$result=mysql_query($get_Details,$conn) or die(mysql_error());
$rows1=mysql_fetch_array($result);
$date=date("d.m.Y",strtotime($rows1['date']));
$vcode=$rows1['vcode'];
$totalamount=$rows1['totalamount'];
$coa=$rows1['coa'];
$desc=$rows1['description'];
$crdr=$rows1['crdr'];
$dramount=$rows1['dramount'];
$cramount=$rows1['cramount'];
$narration=$rows1['remarks'];
$crtotal = $rows1['crtotal'];
$drtotal = $rows1['drtotal'];
$conversion = $rows1['camount'];
?>
<body onLoad="total();">
<center>
<br />
<h1><?php echo $mode;?> Note</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
</center>
<br /><br />
<form id="form1" name="form1" method="post" onsubmit="return checkform(this);" action="pp_updatecreditnotedetails.php" >
															<!-- For CENTRAL DB THE ACTION WILL BE PP_SAVECREDITNOTE2.PHP -->
<input type="hidden" name="type" id="type" value="<?php echo $_GET['type']; ?>" />
<input type="hidden" name="mode1" id="mode1" value="<?php echo $mode1; ?>" />
<input type="hidden" name="saed" value="1">
<div style="height:auto">
<table border="0"	align="center">
<tr align="center">
<td align="right"><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="tno" name="tno" value="<?php echo $_GET['id'] ?>" readonly style="border:0px;background:none" />&nbsp;&nbsp;</td>
<td align="right"><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="15" id="date" class="datepicker" name="date" value="<?php echo $date; ?>" onchange="fvalidatecurrency();" /></td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Vendor</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select style="width: 170px"  name="vendor" id="vendor" onchange="fvalidatecurrency();" >
                <option value="">-Select-</option>
<?php $query = "SELECT distinct(name) FROM contactdetails where type = 'vendor' and client = '$client'  ORDER BY name ASC"; $result = mysql_query($query,$conn);
     while($row = mysql_fetch_assoc($result)) { 
	 if($vcode==$row['name']) 
	  $selected="selected='selected'"; 
	 else 
	  $selected=""; ?>
  <option title="<?php echo $row['name'];?>" value="<?php echo $row['name'];?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
<?php } ?></select>&nbsp;&nbsp;</td>
<td align="right"><strong><?php if($type == "Credit") { ?><?php }?>Amount&nbsp;&nbsp;&nbsp;</strong></td>
<td align="left"><input type="text" style="text-align:right;" size="15" id="vendamount" name="vendamount" value="<?php echo $totalamount / $conversion; ?>" onKeyUp="total();"  /></td>
</tr>
</table>

<br />
<table border="0" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead>
<th><strong>S.No.</strong></th>
<th width="10px"></th>
<th><strong>Code</strong></th>
<th width="10px"></th>
<th><strong>Description</strong></th>
<th width="10px"></th>
<th><strong>Dr/Cr</strong></th>
<th width="10px"></th>
<th><strong>Dr</strong></th>
<th width="10px"></th>
<th><strong>Cr</strong></th>
</thead>
</tr>
<tr style="height:20px"></tr>
<!--Displaying Multiple rows-Begin-->
<script type="text/javascript">
var index = 0;
</script>
	<?php
	$i=1;
	$get_Details="select * from ac_crdrnote where crnum='".$_GET['id']."' and mode='".$mode1."'";
	$result=mysql_query($get_Details,$conn) or die(mysql_error());
	while($rows1=mysql_fetch_array($result))
	{
	$coa=$rows1['coa'];
	$desc=$rows1['description'];
	$crdr=$rows1['crdr'];
	$dramount=$rows1['dramount'];
	$cramount=$rows1['cramount'];
	?>
<script type="text/javascript">
index++;
</script>

<tr>
<td><label id="sno" style="text-align:center;"><?php echo $i; ?></label></td>
<td width="10px"></td>

<td><select id="code<?php echo $i; ?>" name="code[]" onChange="description(this.id);" style="width:80px">
    <option value="">-Select-</option>
    <?php 
	$q = "select code,description from ac_coa WHERE type = 'Expense' or type = 'Revenue' and client = '$client'  order by code ";    $qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs)) {
	 if($coa==$qr['code']) 
	  $selected="selected='selected'"; 
	 else 
	  $selected="";		 ?>
    <option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>" <?php echo $selected; ?>><?php echo $qr['code']; ?></option>
    <?php } ?></select></td>
<td width="10px"></td>

<td><select id="desc<?php echo $i; ?>" name="desc[]"  onchange="code(this.id);" style="width:170px"><option value="">-Select-</option>
    <?php $q = "select code,description from ac_coa WHERE type = 'Expense' or type = 'Revenue' and client = '$client'  order by description "; 
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs)) {
		if($desc==$qr['description']) 
	   $selected="selected='selected'";  
	    else 
	   $selected="";	
		 ?>
    <option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['description']; ?>" <?php echo $selected; ?>><?php echo $qr['description']; ?> </option>
    <?php } ?></select></td>
<td width="10px"></td>
<td><select id="drcr<?php echo $i; ?>" name="drcr[]" onChange="enabledrcr(this.id);"><option value="">-Select-</option><option value="Cr" <?php if($crdr=='Cr') echo "selected='selected'"; ?>>Cr</option><option value="Dr" <?php if($crdr=='Dr') echo "selected='selected'"; ?>>Dr</option></select></td>
<td width="10px"></td>
<td><input type="text" id="dramount<?php echo $i; ?>" name="dramount[]" value="<?php echo $dramount / $conversion; ?>" style="text-align:right" size="8" onKeyUp="total();" <?php if($crdr == 'Cr') { ?> readonly <?php }?> /></td>
<td width="10px"></td>
<td><input type="text" id="cramount<?php echo $i; ?>" name="cramount[]" value="<?php echo $cramount / $conversion; ?>" style="text-align:right" size="8" onKeyUp="total();" onFocus="makeForm();"  <?php if($crdr == 'Dr') { ?> readonly <?php }?> /></td>
</tr>
<?php

 $i++;
 ?>

 <?php
 }
?>
<tr><td><input type="hidden" id="model" name="model" value="<?php echo $model; ?>" /></td>
    <td><input type="hidden" id="type" name="type" value="<?php echo $type; ?>" /></td></tr>
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
<td align="right"><input type="text" id="drtotal" style="text-align:right;background:none;border:none;" name="drtotal" value="<?php echo $drtotal / $conversion;?>" size="8" align="right" readonly  /></td>
<td width="10px"></td>
<td align="right"><input type="text" id="crtotal" style="text-align:right;background:none;border:none;" name="crtotal" value="<?php echo $crtotal / $conversion;?>" size="8" align="right" readonly /></td>
<td><input type="text" style="visibility:hidden" size="8"/></td>
</tr>
</table>
<center>
</br>
<table border="0">
<td style="vertical-align:middle"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea id="remarks" name="remarks" rows="3" cols="50"><?php echo $narration; ?></textarea></td>
</table>
</center>

</div>
<br />
<div id="validatecurrency"></div><br>
<br />

<center>
<input type="submit" value="Update" id="Save" name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_creditnote&type=<?php echo $type; ?>';">
</center>
<br />


<br />
</form>
<script type="text/javascript">
var flag = 0;
function fvalidatecurrency(a)
{
 flag = 1;
 var date = document.getElementById('date').value;
 var vendor = document.getElementById('vendor').value;
 var tdata = date + "@" + vendor + "@vendor";
 getdiv('validatecurrency',tdata,'pp_currencyframe.php?data=');
}

function checkform()
{ 
	if(flag == 1)
	if(document.getElementById('validate').value == 0)
	{
	 alert("Enter Currency conversion for this date");
	 return false;
	}
	document.form1.action = "pp_savecreditnote2.php";
	return true;
}

function description(index)
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
//document.getElementById('Save').disabled = false;
document.getElementById('cramount' + a).onfocus = function ()  { makeForm(); };

	<?php
		$q = "select * from ac_coa where client = '$client' ";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code' + a).value == '$qr[code]') { ";
		$q1 = "select code,description from ac_coa where code = '$qr[code]' and client = '$client'  AND (type = 'Expense' or type = 'Revenue')";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc' + a).value = "<?php echo $q1r['description']; ?>";
		<?php 
		}
		echo " } "; 
		}
		?>
		
}

function code(index)
{
index=index.substr(4);
//alert(index);
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
document.getElementById('cramount' + a).onfocus = function ()  {  makeForm(); };

	<?php
		$q = "select * from ac_coa where client = '$client' ";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('desc' + a).value == '$qr[description]') { ";
		$q1 = "select code,description from ac_coa where description = '$qr[description]' and client = '$client'  AND (type = 'Expense' or type = 'Revenue')";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('code' + a).value = "<?php echo $q1r['code']; ?>";
		<?php 
		}
		echo " } "; 
		}
		?>
		
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
function fun(b) 
{
var a = index;

if(document.getElementById('farm' + a ).value == "")
{
document.getElementById('flock' + a).value = "";
document.getElementById('Save').disabled = true;
document.getElementById('rate' + a).onfocus = "";
alert("Please select Farm");
return;
}
var i1,j1;
for(var i = 1;i<=index;i++)
{
	for(var j = 1;j<=index;j++)
	{
		i1=i;
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('farm' + i1).value == document.getElementById('farm' + j1).value)
			{
				document.getElementById('Save').disabled = true;
				alert("Please select differen combination");
				document.getElementById('rate' + a).onfocus = "";
				return;
			}
		}
	}
}
document.getElementById('Save').disabled = false;
document.getElementById('rate' + a).onfocus = function ()  {  makeForm(); };

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
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
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
	if( diff == vamt )
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
var a = index
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
	
}



function makeForm() {
if(document.getElementById("desc"+index).value!="")
{
index = index + 1;

///////////para element//////////

var mytable=document.getElementById("mytable");

var myrow = document.createElement("tr");

var mytd = document.createElement("td");

var mybox1=document.createElement("label");

//mybox1.type="text";

//mybox1.name="sno[]";

//mybox1.size = "8";

mytd.align="center";

theText1=document.createTextNode(index);

mybox1.appendChild(theText1);

//mybox1.value = index + 2;

//mybox1.setAttribute("readonly",true);

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

theOption1.value = "";

myselect1.appendChild(theOption1);

myselect1.onchange = function ()  {  description(myselect1.id); };


<?php
           include "config.php"; 
           $query = "SELECT * FROM ac_coa WHERE type = 'Expense' or type = 'Revenue' and client = '$client'  order by code ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");

theText1=document.createTextNode("<?php echo $row1['code']; ?>");

theOption1.appendChild(theText1);

theOption1.value = "<?php echo $row1['code']; ?>";

theOption1.title = "<?php echo $row1['description']; ?>";

myselect1.appendChild(theOption1);

<?php } ?>
mytd1.appendChild(myselect1);

myrow.appendChild(mytd1);

mytable.appendChild(myrow);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);

/*
var mytd = document.createElement("td");
var mybox1=document.createElement("input");
mybox1.type="text";
mybox1.name="desc[]";
mybox1.size = "25";
mybox1.setAttribute("readonly",true);
mybox1.id = "desc" + index;
mytd.appendChild(mybox1);
myrow.appendChild(mytd); */


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
myselect1.onchange = function ()  {  code(myselect1.id); };
<?php
           include "config.php"; 
           $query = "SELECT * FROM ac_coa WHERE type = 'Expense' or type = 'Revenue' and client = '$client'  order by description";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['description']; ?>";
theOption1.title = "<?php echo $row1['code']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
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


//var mytd = document.createElement("td");

/*var mybox1=document.createElement("input");

mybox1.type="text";

mybox1.name="remarks[]";

mybox1.size = "12";

mybox1.id = "remarks" + index;

//mybox1.onfocus = function ()  {  makeForm(); };
*/

//var mytextarea = document.createElement("textarea");

//mytextarea.name="remarks[]";

//mytextarea.id = "remarks" + index;

//mytd.appendChild(mytextarea);
//mytd.appendChild(mybox1);

//myrow.appendChild(mytd);


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




