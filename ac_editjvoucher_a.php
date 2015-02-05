<body >
<?php  
		include "config.php";
		include "jquery.php";
		

            $voucher = 'J';
			$sdb = $_SESSION['db'];
		$tnum = $_GET['id'];
		$q = "select * from ac_gl where transactioncode = '$tnum' AND voucher = '$voucher' order by id ";
		
		 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	  {
           $q = "SELECT * FROM ac_gl where  transactioncode = '$tnum' AND voucher = '$voucher' ";
		   }
	   else
	   {
	    $sectorlist = $_SESSION['sectorlist'];
	   $q = "SELECT * FROM ac_gl where  transactioncode = '$tnum' AND voucher = '$voucher' AND code IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector in ($sectorlist )  ";
	   }
		
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		  $crtotal = $qr['crtotal'];
		  $drtotal = $qr['drtotal'];
		  $stdate = date("d-m-Y",strtotime($qr['date']));
		  $remarks = $qr['rremarks'];
		  $vstatus = $qr['vstatus'];
		  $unitc = $qr['warehouse'];
		}
		if($_SESSION['db'] <> "central" && $_SESSION['db'] <> "alwadi") 
		{
		$q = "select warehouse from ac_financialpostings where trnum = '$tnum' AND type = 'JV' LIMIT 1";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		$unitc  = $qr['warehouse'];
		}
		}
?>

<center>
<br />
<h1>Journal Voucher</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action=<?php if($vstatus=="A"){?>"ac_updatejvoucher_a.php"<?php } else {?>"ac_savejvoucher_a.php" <?php } if(($sdb == "mallikarjunkld") || ($sdb == "central") or $_SESSION['db'] == "alwadi") {?> onSubmit="return checkform(this);" <?php } ?>>
<input type="hidden" id="saed" name="saed" value="1">
<table align="center">
<tr>
<td><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
 <td width="10px"></td>
<td><input type="text" id="tno" name="tno" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  /></td>
<td width="40px"></td>
<td >
<td>&nbsp;&nbsp;&nbsp;<strong>Date</strong></td>
 <td width="10px"></td>
 <td><input type="text" size="15" id="date" class="datepicker" name="date" value="<?php echo $stdate; ?>" /></td>
 <?php $sdb = $_SESSION['db'];
 //if(($sdb == "mallikarjunkld") || ($sdb == "central"))
 //{
 ?>
   <td>&nbsp;&nbsp;&nbsp;<strong>Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <?php //} ?>
 <?php //if(($sdb == "mallikarjunkld") || ($sdb == "central")) {?>
 <td>
 <select id="unitc" name="unitc">
<option value="">-Select-</option>
<?php 
       
		  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
       if($sdb == "central" or $_SESSION['db'] == "alwadi")
	   {
	   $q = "SELECT * FROM tbl_sector WHERE costeffect = 1 order by sector";		
	   }
	   else
	   {
		$q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse' order by sector";
	   }
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	  if($sdb == "central" or $_SESSION['db'] == "alwadi")
	   {
	   $q = "SELECT * FROM tbl_sector WHERE costeffect = 1 and sector in ($sectorlist) order by sector";		
	   }
	   else
	   {
		$q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse'  and sector in ($sectorlist) order by sector";
	   }
	 }
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['sector']; ?>"  <?php if($unitc== $qr['sector']) { ?> selected="selected" <?php }?>><?php echo $qr['sector']; ?></option>
<?php } ?>
</select>
 <?php //} ?>
 </td>
</tr>
<tr height="10px"><td></td></tr>
</table>
<br />
<div style="height:auto">
<table border="0" cellpadding="2" cellspacing="2" id="mytable" align="center">
<thead>
<th><strong>S.No.</strong></td>
<th></th>
<th><strong>Code</strong></th>
<th></th>
<th><strong>Description</strong></th>
<th></th>
<th><strong>Dr/Cr</strong></th>
<th></th>
<th><strong>Dr</strong></th>
<th></th>
<th><strong>Cr</strong></th>
<td></td>
<td><strong>Narration</strong></td>

</thead>
</tr>

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
     	$q1 = "select code,controltype from ac_coa where controltype = ''  and client = '$client'  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code ";
		$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		while($qr1 = mysql_fetch_assoc($qrs1))
		{
		if ( $qr1['code'] == $qr['code'] )
		 { 
?>
<option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['code'] ?></option>
<?php } else { ?>
<option value="<?php echo $qr1['code']; ?>"><?php echo $qr1['code']; ?></option>
<?php } }?>
</select></td>
<td width="10px"></td>
<td>

<select id="desc<?php echo $i; ?>" name="desc[]" style="width:170px" onChange="getcode(this.id);">
<option>-Select-</option>
<?php
     	$q1 = "select description,controltype from ac_coa where controltype = ''  and client = '$client'  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by description  ";
		$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		while($qr1 = mysql_fetch_assoc($qrs1))
		{
		if ( $qr1['description'] == $qr['description'] )
		 { 
?>
<option title="<?php echo $qr1['description']; ?>" value="<?php echo $qr['description']?>" selected="selected"><?php echo $qr['description'] ?></option>
<?php } else { ?>
<option title="<?php echo $qr1['description']; ?>" value="<?php echo $qr1['description']; ?>"><?php echo $qr1['description']; ?></option>
<?php } }?>
</select>

<!--<input type="text" id="desc<?php echo $i; ?>" name="desc[]" value="<?php echo $qr['description']; ?>" size="25" readonly />--></td>
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
<!--<td>
<input type="text" style="visibility:hidden" size="12"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="12"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="10"/>
</td>-->

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
</div>
<br />


<br />
<table align="center">
<tr>
<td>
<!--<strong>Narration</strong>-->
</td>
<td>
<!--<input type="text" id="remarks" name="remarks[]" value="" size="12" />-->
<!--<textarea id="remarks" rows="3" cols="50" name="remarks" value="" ><?php echo $remarks; ?></textarea>-->

</td>
</tr>
</table>
<br />
<center>
<input type="submit" value="Update" id="Update" name="Update"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=ac_jvoucher_a';">
</center>
<br />
<!-- </center> -->
</form>
<br />
<script type="text/javascript">



function description(z)
{

//if(index == -1)
for(var i = 1;i<=index;i++)
{
		if( i != z)
		{
			if(document.getElementById('code' + z).value == document.getElementById('code' + i).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('desc' + z).value = "";
				//document.getElementById('remarks' + a).onfocus = "";
				alert("Please select different combination");
				return;
			}
		}
}
//document.getElementById('Save').disabled = false;
//document.getElementById('cramount' + z).onfocus = function ()  {  makeForm(); };

	<?php
		$q = "select * from ac_coa";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('code' + z).value == '$qr[code]') { ";
		$q1 = "select code,description from ac_coa where code = '$qr[code]'";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('desc' + z).value = "<?php echo $q1r['description']; ?>";
		
		<?php 
		}
		echo " } "; 
		}
		?>
		
}


function getcode(a)
{
var id=a.substr(4);

/*for(var i = -1;i<=index;i++)
{
	for(var j = -1;j<=index;j++)
	{
		if(i == -1)
		i1 = "";
		else
		i1=i;
		
		if(j == -1)
		j1 = "";
		else
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('desc' + i1).value == document.getElementById('desc' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('code' + id).value = "";
				//document.getElementById('remarks' + a).onfocus = "";
				alert("Please select different combination");
				return;
			}
		}
	}
}*/
//document.getElementById('Save').disabled = false;
if(document.getElementById('crdr' + id).value == "Cr")
	{
	document.getElementById('cramount' + id).onfocus = function ()  {  makeForm(); };

	}
	else 
{
document.getElementById('dramount' + id).onfocus = function ()  {  makeForm(); };
}	

 
	

	<?php
		$q = "select * from ac_coa where client = '$client' ";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(document.getElementById('desc' + id).value == '$qr[description]') { ";
		$q1 = "select code,description from ac_coa where description = '$qr[description]' and client = '$client' ";
		$q1rs = mysql_query($q1) or die(mysql_error());
		if($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('code' + id).value = "<?php echo $q1r['code']; ?>";

		<?php 
		}
		echo " } "; 
		}
		?>
		
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
{
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

//mybox1.type="text";

//mybox1.name="sno[]";

//mybox1.size = "8";

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


<?php
           include "config.php"; 
           $query = "SELECT * FROM ac_coa where controltype = ''  and client = '$client'  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code ";
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

/*var mytd = document.createElement("td");
var mybox1=document.createElement("input");
mybox1.type="text";
mybox1.name="desc[]";
mybox1.size = "25";
mybox1.setAttribute("readonly",true);
mybox1.id = "desc" + index;
mytd.appendChild(mybox1);
myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);
mytable.appendChild(myrow);*/

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
myselect1.onchange = function ()  {  getcode(this.id); };


<?php
           include "config.php"; 
           $query = "SELECT * FROM ac_coa where controltype = ''  and client = '$client'  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by description  ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['description']; ?>";
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
function checkform(form)
{
if(form.unitc.value == "")
{
alert("Please Select Unit");
 form.unitc.focus();
return false;
}
<?php if(($_SESSION['db'] == "central" or $_SESSION['db'] == "alwadi") && $vstatus == "U") { ?>
document.form1.action = "ac_savejvoucherc.php";
<?php } ?>

return true;
	
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

