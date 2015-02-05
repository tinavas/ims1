<body >
<?php  
		include "config.php";
		include "jquery.php";
		
		
		
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
		 
		 
		 
		 //code description


$q = "SELECT GROUP_CONCAT(distinct(code),'@',description ORDER BY code ) AS codedesc  FROM ac_coa WHERE controltype IN ('')";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$r=mysql_fetch_array($qrs);
{
$items=explode(",",$r['codedesc']);

} 
$item=json_encode($items);

		
		


            $voucher = 'J';
			$sdb = $_SESSION['db'];
		$tnum = $_GET['id'];
		$q = "select * from ac_gl where transactioncode = '$tnum' AND voucher = '$voucher' order by id ";
		
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		  $crtotal = $qr['crtotal'];
		  $drtotal = $qr['drtotal'];
		  $stdate = date("d-m-Y",strtotime($qr['date']));
		  $remarks = $qr['rremarks'];
		  $vstatus = $qr['vstatus'];
		  $unitc = $qr['warehouse'];
		  $vno=$qr['vouchernumber'];
		  $cuser=$qr['empname'];
		}
	

		
		
?>



<script type="text/javascript">


var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;

var sectors=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;
</script>


<section class="grid_8">
  <div class="block-border">


<form id="form1" name="form1" method="post" action="ac_updatejvoucher.php"  class="block-content form" onsubmit="return checkform1(this);" >
<center>
<br>
<h1>Journal Voucher</h1>
<br />
<b>Journal Voucher</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>

<input type="hidden" id="saed" name="saed" value="1">
<input type="hidden" id="cuser" name="cuser" value="<?php echo $cuser;?>" />
<table align="center">
<tr>


<td><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
 <td width="10px"></td>
<td><input type="text" id="tno" name="tno" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  /></td>

<td>&nbsp;&nbsp;&nbsp;<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><input type="text" size="15" readonly="true" id="date" class="datepicker" name="date" value="<?php echo $stdate; ?>" /></td>

   <td>&nbsp;&nbsp;&nbsp;<strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 
 <td>
 <select id="unitc" name="unitc">
<option value="">-Select-</option>
<?php 
       
	         
 for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>" <?php if($unitc==$sec1[$j]) { ?> selected="selected" <?php }?> title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php } ?>
	   

</select>

 </td>
 <td width="10px"></td>

<td><strong>Voucher No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="vno" name="vno" value="<?php echo $vno;?>"/></td>
 <td width="10px"></td>
 
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
<th><strong>Dr/Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th></th>
<th><strong>Dr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th></th>
<th><strong>Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<td></td>
<td><strong>Narration</strong></td>

</thead>

<tr height="10px"><td></td></tr>

<script type="text/javascript">
var index = 0;
</script>
<?php 
	$i = 1;
	
	$q = "select * from ac_gl where transactioncode = '$tnum' AND voucher = '$voucher' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	
?>
<script type="text/javascript">
index = index + 1;
</script>
<tr>

<td style="text-align:left">
<input type="text"  id="sno<?php echo $i; ?>" name="sno" value="<?php echo $i; ?>" readonly style="border:0px;background:none" size="2"/></td>
<td width="10px"></td>
<td>
<select id="code<?php echo $i; ?>" name="code[]" onChange="description(<?php echo $i; ?>);"  style="width:70px">
<option value="">Select</option>
<?php
     
	 
	for($j=0;$j<count($items);$j++)
							{ 
							
							$code1=explode("@",$items[$j]);
							
					?>
					<option title="<?php echo $code1[1];?>" <?php if($code1[0]==$qr['code']) { ?> selected="selected" <?php }?> value="<?php echo $code1[0];?>"><?php echo $code1[0]; ?></option>
					<?php   }   ?>
	 
	 
</select></td>
<td width="10px"></td>
<td>

<select id="desc<?php echo $i; ?>" name="desc[]" style="width:170px" onChange="getcode(<?php echo $i; ?>);">
<option value="">-Select-</option>
<?php


for($j=0;$j<count($items);$j++)
							{ $desc1=explode("@",$items[$j]);
					?>
	
					<option title="<?php echo $desc1[1];?>" <?php if($desc1[1]==$qr['description']) { ?> selected="selected" <?php }?>  value="<?php echo $desc1[1];?>"><?php echo $desc1[1]; ?></option>
					<?php   }   ?> 
</select>
</td>

<td width="10px"></td>
<td><select id="crdr<?php echo $i; ?>" name="crdr[]"  onchange="enabledrcr('<?php echo $i; ?>');" style="width:60px">
  <option value="">Select</option>
  <?php
   if ( $qr['crdr'] == "Cr" ) { ?>
  <option value="Cr" selected="selected">Cr</option>
  <?php } else { ?>
  <option value="Cr">Cr</option>
  <?php } ?>
  <?php if ( $qr['crdr'] == "Dr" ) { ?>
  <option value="Dr" selected="selected">Dr</option>
  <?php } else { ?>
  <option value="Dr" >Dr</option>
  <?php } 
  ?>
</select></td>
<td width="10px"></td>
<td>
<input type="text"  align="right" id="dramount<?php echo $i; ?>"  name="dramount[]" <?php if ( $qr['crdr'] == "Cr" ) { ?> readonly="" <?php  } ?> value="<?php echo $qr['dramount']; ?>"  onChange="total();"  size="8" style="text-align:right"/></td>
<td width="10px"></td>
<td>
<input type="text" align="right" id="cramount<?php echo $i; ?>"  name="cramount[]" <?php if ( $qr['crdr'] == "Dr" ) {?> readonly <?php  } ?> value="<?php echo $qr['cramount']; ?>" onFocus="makeForm();"  onChange="total();" size="8" style="text-align:right"/></td>
<td width="10px"></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"><?php echo $qr['rremarks']; ?></textarea></td>

</tr>
<?php $i++; } ?>
</table>
</div>
<br />
<br />
<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td>
<input type="text" style="visibility:hidden" size="8" />
</td>


<td width="160px" align="right">
<strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td align="right">
<input type="text" id="drtotal" name="drtotal" value="<?php echo $drtotal; ?>" size="8" readonly style="border:0px;background:none; text-align:right" />
</td>
<td align="right">
<input type="text" id="crtotal" name="crtotal" value="<?php echo $crtotal; ?>" size="8" readonly style="border:0px;background:none; text-align:right"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>

</tr>
</table>

<br />


<br />


<br />
<center>
<input type="submit" value="Update" id="Update" name="Update"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=ac_jvoucher';">
</center>
</form>
</div>
</section>
</center>
<br />

<script type="text/javascript">


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

for(j=1;j<=index;j++)
{


k=j;

if(Number(document.getElementById('cramount' + k).value >0)  ||Number(document.getElementById('dramount' + k).value >0))
{
if(document.getElementById('code'+k).value=="" || document.getElementById('crdr'+k).value=="" || document.getElementById('desc'+k).value=="")
{


	alert("Select code for row "+k)
	return false;

}


}




}

document.getElementById('Update').disabled=true;	
}



function description(z)
{
if(document.getElementById('code' + z).value=="")
{
		document.getElementById('desc' + z).value = "";
		return false;
}

for(var i = 1;i<=index;i++)
{
		if( i != z)
		{
			if(document.getElementById('code' + z).value == document.getElementById('code' + i).value && document.getElementById('code' + z).value!="" )
			{
				
				document.getElementById('desc' + z).value = "";
				document.getElementById('code' + z).value="";
				alert("Please select different combination");
				return;
			}
		}
}

document.getElementById("desc"+z).selectedIndex=document.getElementById("code"+z).selectedIndex;

		
		
}


function getcode(id)
{

if(document.getElementById('desc' + id).value=="")
{

		document.getElementById('desc' + id).value = "";
			
		document.getElementById('code' + id).value = "";
		return false;
}


if(document.getElementById('crdr' + id).value == "Cr")
	{
	document.getElementById('cramount' + id).onfocus = function ()  {  makeForm(); };

	}
	else 
{
document.getElementById('dramount' + id).onfocus = function ()  {  makeForm(); };
}	

 
	
document.getElementById("code" +id).selectedIndex=document.getElementById("desc" +id).selectedIndex;
		
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}

function total()
{
    var ctot = 0;
	var dtot = 0;
	for (var i = 1;i<=index;i++)
	{
		
	    ctot+=parseFloat(document.getElementById('cramount' + i).value);
		dtot+=parseFloat(document.getElementById('dramount' + i).value);
	}
	
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
	if( document.getElementById('crtotal').value != document.getElementById('drtotal').value )
	{
		document.getElementById('Update').disabled = true;
	}
	else
	{
			document.getElementById('Update').disabled = false;
	}
}

function enabledrcr(x)
{document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount' + x).value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount' + x).value;
document.getElementById('cramount' + x).value = 0;
document.getElementById('dramount' + x).value = 0;
//document.getElementById('crtotal').value = 0;
//document.getElementById('drtotal').value = 0;
	if(document.getElementById('crdr' + x).value == "Cr")
	{
	document.getElementById('cramount' + x).removeAttribute('readonly','readonly');
	document.getElementById('dramount' + x).setAttribute('readonly',true);
	}
	else if(document.getElementById('crdr' + x).value == "Dr")
	{
	document.getElementById('dramount' + x).removeAttribute('readonly','readonly');
	document.getElementById('cramount' + x).setAttribute('readonly',true);
	}
	else
	{
	document.getElementById('dramount' +x).setAttribute('readonly',true);
	document.getElementById('cramount' +x).setAttribute('readonly',true);
	}
	
	if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Update').disabled=true;
	
}
</script>



<script type="text/javascript">
function makeForm() {

var prrr =document.getElementById('desc' + index).value;
if( prrr != "")
{
index = index + 1;
///////////para element//////////

var mytable=document.getElementById("mytable");
var myrow = document.createElement("tr");
var mytd = document.createElement("td");
    mytd.style.textAlign = "left";
var mybox1=document.createElement("label");



theText1=document.createTextNode(index);
mybox1.appendChild(theText1);

mybox1.id = "sno" + parseFloat(index);
mybox1.size="2";
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
myselect1.style.width = "70px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");

theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function ()  {  description(index); };

		   
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



var mytd1 = document.createElement("td");
myselect1 = document.createElement("select");
myselect1.id = "desc" + index;
myselect1.name = "desc[]";
myselect1.style.width = "170px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");

theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function ()  {  getcode(index); };

 for(j=0;j<(items.length);j++)
		   {desc1=items[j].split("@");
		  
		   	var theOption=new Option(desc1[1],desc1[1]);
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
myselect1.style.width = "60px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode('Select');
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
myselect1.name = "crdr[]";
myselect1.id = "crdr" + index;
myselect1.width="50px";
myselect1.onchange = function ()  {  enabledrcr(index); };
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
mybox1.onkeyup = function ()  {  total(); };

mytd.appendChild(mybox1);
myrow.appendChild(mytd);


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

