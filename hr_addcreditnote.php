<?php 
include "config.php";
include "jquery.php";
$type = $_GET['type'];
 if($type == 'Credit') { $mode = 'Employee Credit'; $mode1 = 'ECN'; }
 else if($type == 'Debit') { $mode = 'Employee Debit'; $mode1 = 'EDN'; }
$dbcode = $_SESSION['dbcode'];

$q = "select max(incr) as incr from hr_empcrdrnote WHERE mode = '$mode1' and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['incr']; }
$tnum = $tnum + 1;
$tnum = "$mode1-$tnum";

$date = $_GET['date'];
$docno = $_GET['docno'];
$empname = $_GET['empname'];
if($date == "")
$date = date("d.m.Y");
?>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="min-height:600px" id="complex_form" method="post" onsubmit="return checkform(this)" name="form" action="hr_savecreditnote.php" >
	  <h1 id="title1"><?php echo $mode;?> Note</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br><br>
<input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
<table align="center">
	<tr>
		<td><strong>Transaction Id:</strong></td>
		<td width="10px"></td>
		<td><input type = "text" id="tid" name="tid" value="<?php echo $tnum; ?>" size="15" style="background:none; border:none" readonly ></td>
		<td width="10px"></td>
		<td><strong>Date</strong></td>
		<td width="10px"></td>
		<td><input type = "text" id="date" name="date" value="<?php echo $date; ?>" size="10" class="datepicker"></td>
		<td width="10px"></td>
		<td><strong>Doc. No.</strong></td>
		<td width="10px"></td>
		<td><input type = "text" id="docno" name="docno" value="<?php echo $docno; ?>" size="8"></td>
		<td width="10px"></td>
		<td><strong>Emp. Name</strong></td>
		<td width="10px"></td>
		<td>
			<select id="empname" name="empname" onchange="reloadpage()" style="width:150px">
			<option value="">-Select-</option>
			<?php
			echo $query = "SELECT name FROM hr_employee order by name";
			 $result = mysql_query($query,$conn) or die(mysql_error());
			 while($rows = mysql_fetch_assoc($result))
			 {
				?>
				<option value="<?php echo $rows['name']; ?>" title="<?php echo $rows['name']; ?>" <?php if($empname == $rows['name']) { ?> selected="selected" <?php } ?>><?php echo $rows['name']; ?></option>
				<?php
			 }
			?>
			</select>
		</td>
	</tr>
</table>
<br>
<table id="tab1">
	<tr>
		<td><strong>S.No</strong></td>
		<td width="10px"></td>
		<td><strong>Code</strong></td>
		<td width="10px"></td>
		<td><strong>Description</strong></td>
		<td width="10px"></td>
		<td><strong>Cost Center</strong></td>
		<td width="10px"></td>
		<td><strong>Cr/Dr</strong></td>
		<td width="10px"></td>
		<td><strong>Dr Amount</strong></td>
		<td width="10px"></td>
		<td><strong>Cr Amount</strong></td>
	</tr>
	<tr height="10px"></tr>
	<tr>
		<td>1</td>
		<td width="10px"></td>
		<td>
			<select id="code@1" name="code[]" onchange="changedesc(this.id,this.value)" style="width:80px">
			<option value="">-Select-</option>
			<?php
			 $query = "SELECT salaryac,loanac FROM hr_employee WHERE name = '$empname'";
			$result = mysql_query($query,$conn) or die(mysql_error());
			$rows = mysql_fetch_assoc($result);
			$codes = "'$rows[salaryac]','$rows[loanac]'";
			
			$query = "SELECT code,description FROM ac_coa WHERE code IN ($codes) ORDER BY code";
			$result = mysql_query($query,$conn) or die(mysql_error());
			while($rows = mysql_fetch_assoc($result))
			{
			 ?>
			 <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>" title="<?php echo $rows['description']; ?>"><?php echo $rows['code']; ?></option>
			 <?php
			}
			?>
			</select>
		</td>
		<td width="10px"></td>
		<td>
			<select id="desc@1" name="desc[]" onchange="changecode(this.id,this.value);" style="width:200px">
			<option value="">-Select-</option>
			<?php
			$query = "SELECT code,description FROM ac_coa WHERE code IN ($codes) ORDER BY description";
			$result = mysql_query($query,$conn) or die(mysql_error());
			while($rows = mysql_fetch_assoc($result))
			{
			 ?>
			 <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>" title="<?php echo $rows['description']; ?>"><?php echo $rows['description']; ?></option>
			 <?php
			}
			?>
			</select>		
		</td>
		<td width="10px"></td>
		<td>
			<select id="unit@1" name="unit[]" style="width:80px" >
			<option value="">-Select-</option>
			<?php 
				$query = "SELECT sector FROM hr_employee where name = '$empname'";
				$result = mysql_query($query,$conn) or die(mysql_error());
				$rows = mysql_fetch_assoc($result);
				$sector = $rows['sector'];
				
				$q = "SELECT sector FROM tbl_sector order by sector";
				$qrs = mysql_query($q,$conn) or die(mysql_error());
				while($qr = mysql_fetch_assoc($qrs))
				{
			?>
			<option value="<?php echo $qr['sector']; ?>" <?php if($sector == $qr['sector']) { ?> selected="selected" <?php } ?>><?php echo $qr['sector']; ?></option>
			<?php } ?>
			</select>		
		</td>
		<td width="10px"></td>
		<td>
		<select id="drcr@1" name="drcr[]" onchange="enabledrcr(this.id);">
		<option value="">-Select-</option>
		<option value="Cr" <?php if($type=="Credit") { ?> selected="selected" <?php } ?>>Cr</option>
		<option value="Dr" <?php if($type=="Debit") { ?> selected="selected" <?php } ?>>Dr</option>
		</select>
		</td>
		<td width="10px"></td>
		<td><input type="text" id="dramount@1" name="dramount[]" value="0" style="text-align:right" size="8" onkeyup="total();"  <?php if($type=="Credit") { ?> readonly <?php } ?> onkeypress="validatekey(event.keyCode)" onfocus="makeForm()" /></td>
		<td width="10px"></td>
		<td><input type="text" id="cramount@1" name="cramount[]" value="0" style="text-align:right" size="8" onkeyup="total();" <?php if($type=="Debit") { ?> readonly <?php } ?> onkeypress="validatekey(event.keyCode)" onfocus="makeForm()" /></td>	
	</tr>
	<tr height="10px"></tr>
	<tr id="lastrow">
		<td colspan="9" align="right"><strong>Total</strong></td>
		<td width="10px"></td>
		<td><input type="text" id="drtotal" style="text-align:right;background:none;border:none;" name="drtotal" value="0" size="8" align="right" readonly  /></td>
		<td width="10px"></td>
		<td align="right"><input type="text" id="crtotal" style="text-align:right;background:none;border:none;" name="crtotal" value="0" size="8" align="right" readonly /></td>
	</tr>
</table>
<br  />

<br>
</br>
<table border="0">
<td style="vertical-align:middle"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea id="narration" name="narration" rows="3" onKeyPress="return p1(event.keyCode,this.id);" cols="50"></textarea></td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 125 Characters</td>


</table>
<br></br>
<input type="submit" id="Save" disabled="disabled" value="<?php echo "Save"; ?>" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_creditnote&type=<?php echo $type; ?>'" />
</form>
<script type="text/javascript">
var index = 1;
function makeForm()
{
 if(document.getElementById('code@'+index).value != '')
 {
	index++;
	var mytable=document.getElementById("tab1");
	var myrow = document.createElement("tr");
	var lastrow = document.getElementById("lastrow");
	
	var mytd = document.createElement("td");
	var mybox1=document.createElement("label");
	mytd.align="center";
	theText1=document.createTextNode(index);
	mybox1.appendChild(theText1);
	mytd.appendChild(mybox1);
	myrow.appendChild(mytd);
	
myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);

var mytd1 = document.createElement("td");
myselect1 = document.createElement("select");
myselect1.id = "code@" + index;
myselect1.name = "code[]";
myselect1.style.width = "80";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function ()  { changedesc(this.id,this.value); };
<?php
           
           $query = "select code,description from ac_coa WHERE description NOT LIKE 'COGS%' AND description NOT LIKE '%Stocks%' AND description NOT LIKE 'Purchases%' AND description NOT LIKE 'Price Variance%' AND description NOT LIKE 'Sales%' order by code ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']."@".$row1['description']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
mytd1.appendChild(myselect1);
myrow.appendChild(mytd1);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);	
	
var mytd1 = document.createElement("td");
myselect1 = document.createElement("select");
myselect1.id = "desc@" + index;
myselect1.name = "desc[]";
myselect1.style.width = "200";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function ()  { changecode(this.id,this.value); };
<?php
           $query = "select code,description from ac_coa WHERE description NOT LIKE 'COGS%' AND description NOT LIKE '%Stocks%' AND description NOT LIKE 'Purchases%' AND description NOT LIKE 'Price Variance%' AND description NOT LIKE 'Sales%' order by description ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']."@".$row1['description']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
mytd1.appendChild(myselect1);
myrow.appendChild(mytd1);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);	

var mytd1 = document.createElement("td");
myselect1 = document.createElement("select");
myselect1.id = "unit@" + index;
myselect1.name = "unit[]";
myselect1.style.width = "80";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
<?php
           $query = "SELECT sector FROM tbl_sector order by sector";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['sector']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
mytd1.appendChild(myselect1);
myrow.appendChild(mytd1);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);	

var mytd1 = document.createElement("td");
var myselect1 = document.createElement("select");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode('-Select-');
theOption1.value = "";
theOption1.appendChild(theText1);
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
myselect1.id = "drcr@" + index;
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
mybox1.id = "dramount@" + index;
mybox1.onkeyup = function ()  {  total(); };
mybox1.onkeypress = function ()  {  validatekey(event.keyCode); };
mybox1.onfocus = function ()  {  makeForm(); };
mytd.appendChild(mybox1);
myrow.appendChild(mytd);

myspace2= document.createTextNode('\u00a0');
var cca2 = document.createElement('td');
cca2.appendChild(myspace2);
myrow.appendChild(cca2);

var mytd = document.createElement("td");
var mybox1=document.createElement("input");
mybox1.type="text";
mybox1.name="cramount[]";
mybox1.setAttribute('readonly',true);
mybox1.size = "8";
mybox1.value = 0;
mybox1.id = "cramount@" + index;
mybox1.style.textAlign = "right";
mybox1.onkeyup = function ()  {  total(); };
mybox1.onkeypress = function ()  {  validatekey(event.keyCode); };
mybox1.onfocus = function ()  {  makeForm(); };
mytd.appendChild(mybox1);
myrow.appendChild(mytd);

lastrow.parentNode.insertBefore(myrow,lastrow);	//It inserts the row before total row

var tr = document.createElement("tr");
tr.height="10px";
lastrow.parentNode.insertBefore(tr,lastrow);	//It inserts the row before total row

	//mytable.appendChild(myrow);
 }
}
var index1 = 1;




function changecode(b,a)
{

var id=b.substr(5,b.length);
for(i=1;i<=index;i++)
{
for(j=1;j<=index;j++)
{
if((document.getElementById("desc@"+i).value==document.getElementById("desc@"+j).value)&&(i!=j) && (document.getElementById("desc@"+i).value!=""))
{

alert("Same description should not be selected");
document.getElementById("desc@"+id).value="";
document.getElementById("code@"+id).value="";
return false;
}
}


}


if(a == "")
{
document.getElementById("code@"+id).value="";
}
else
{
document.getElementById("code@"+id).value=a;
}
}

function changedesc(a,b)
{

var id=a.substr(5,a.length);


for(i=1;i<=index;i++)
{
for(j=1;j<=index;j++)
{
if((document.getElementById("code@"+i).value==document.getElementById("code@"+j).value)&&(i!=j) && (document.getElementById("code@"+i).value!=""))
{

alert("Same code should not be selected");
document.getElementById("desc@"+id).value="";
document.getElementById("code@"+id).value="";
return false;
}
}


}



if(b=="")
{
document.getElementById("desc@"+id).value="";
}
else
{
document.getElementById("desc@"+id).value=b;
}
}




function total()
{
var a = index;
	var ctot = 0;
	var dtot = 0;
	var tot=0;
	var i1;
	for (var i = 1;i<=index;i++)
	{
		i1 = i;
		ctot+=Number(document.getElementById('cramount@' + i1).value);
		dtot+=Number(document.getElementById('dramount@' + i1).value);
	}
	document.getElementById('crtotal').value = ctot.toFixed(2);
	document.getElementById('drtotal').value = dtot.toFixed(2);
	
	if((ctot.toFixed(2) == dtot.toFixed(2)))
	{
	document.getElementById('Save').disabled = false;
	}
	else
	{
	document.getElementById('Save').disabled = true;
	}
}

function enabledrcr(a)
{
var temp = a.split('@');
var a = temp[1];
document.getElementById('cramount@' + a).value = 0;
document.getElementById('dramount@' + a).value = 0;
	if(document.getElementById('drcr@' + a).value == "Cr")
	{
	document.getElementById('cramount@' + a).removeAttribute('readonly','readonly');
	document.getElementById('dramount@' +a).setAttribute('readonly',true);
	}
	else if(document.getElementById('drcr@' + a).value == "Dr")
	{
	document.getElementById('dramount@' + a).removeAttribute('readonly','readonly');
	document.getElementById('cramount@' +a).setAttribute('readonly',true);
	}
	else
	{
	document.getElementById('dramount@' +a).setAttribute('readonly',true);
	document.getElementById('cramount@' +a).setAttribute('readonly',true);
	}
	
}

function reloadpage()
{
 var date = document.getElementById("date").value;
 var empname = document.getElementById("empname").value;
 var docno = document.getElementById('docno').value;
 document.location = "dashboardsub.php?page=hr_addcreditnote&type=<?php echo $type; ?>&date="+date + "&docno="+docno + "&empname="+empname;
}

function validatekey(a)
{ 
 if((a<48 || a>57) && a!=46 && a!=13)	//48-57 are for0-9; 46 is for .(dot-decimal); 13 for Enter key 
  event.keyCode=false;
}

function checkform(form)
{ 
 return true;
}
<?php if($type=='Debit'){?>
function script1() {

window.open('HRHELP/hr_m_adddebitnote.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

}
<?php } else { ?>
function script1() {

window.open('HRHELP/hr_m_addcreditnote.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

}
<?php } ?>

function p1(b,a)
{
var ab=a;

var len14=document.getElementById(ab).value;
var len1=len14.length;
if(len1>120) 
{
alert('Max of 120 Characters');
event.keyCode=false;
		return false;

}

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
