<?php include "config.php";
include "jquery.php"; ?>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="height:600px" id="complex_form" method="post" onsubmit="return checkform(this)" action="ims_savestandardcosts.php" >
	  <h1 id="title1">Standard Costs</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br><br>
<table id="tab1" align="center">
	<tr>
		<td><strong>From Date</strong></td>
		<td width="10px"></td>
		<td><strong>To Date</strong></td>
		<td width="10px"></td>
		<td><strong>Category</strong></td>
		<td width="10px"></td>
		<td><strong>Code</strong></td>
		<td width="10px"></td>
		<td><strong>Description</strong></td>
		<td width="10px"></td>
		<td><strong>Standard Cost</strong></td>
	</tr>
	<tr height="10px"></tr>
	<tr>
		<td><input type="text" id="fromdate@1" name="fromdate[]" value="<?php echo date("d.m.Y"); ?>" class="datepicker" size="10" /></td>
		<td width="10px"></td>
		<td><input type="text" id="todate@1" name="todate[]" value="<?php echo date("d.m.Y"); ?>" class="datepicker" size="10" /></td>
		<td width="10px"></td>
		<td>
			<select id="cat@1" name="cat[]" onchange="loadcodes(this.id)" style="width:200px" />
			<option value="">-Select-</option>
			<?php 
			$query = "SELECT type AS cat FROM ims_itemtypes ORDER BY cat";
			$result = mysql_query($query,$conn) or die(mysql_error());
			while($rows = mysql_fetch_assoc($result))
			{
			 ?>
			 <option value="<?php echo $rows['cat']; ?>" title="<?php echo $rows['cat']; ?>"><?php echo $rows['cat']; ?></option>
			 <?php
			}
			?>
			</select>
		</td>
		<td width="10px"></td>
		<td>
			<select id="code@1" name="code[]" onchange="selectdesc(this.id)" style="width:100px" />
			<option value="">-Select-</option>
			</select>
		</td>
		<td width="10px"></td>
		<td>
			<select id="desc@1" name="desc[]" onchange="selectcode(this.id)" style="width:200px" />
			<option value="">-Select-</option>
			</select>
		</td>
		<td width="10px"></td>
		<td>
			<input type="text" id="stdcost@1" name="stdcost[]" value="0" size="10" style="text-align:right"  onfocus="makeForm()" />
		</td>
	</tr>
</table>
<br><br>
<input type="submit" value="Save" />&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=ims_standardcosts'" />
</form>
<script type="text/javascript">
function validate(a)
{
 var expr=/^[0-9]*$/;
 if(! a.match(expr))
 {
  alert("Value should be a Integer");
  document.getElementById("value1").value = "";
  document.getElementById("value1").focus();
 }
}

function checkform()
{
 for(var i = 1; i <= index; i++)
 {
 if(document.getElementById('stdcost@'+i).value > 0 && document.getElementById('code@' + i).value == "")
 {
	alert("Please Select Code");
	document.getElementById('code@' + i).focus();
	return false;
 }
 }
 return true;
}

function loadcodes(a)
{
 var temp = a.split('@');
 var tempindex = temp[1];
 var cat = document.getElementById("cat@"+tempindex).value;
 removeAllOptions(document.getElementById("code@"+tempindex));
 removeAllOptions(document.getElementById("desc@"+tempindex));
 var select1 = document.getElementById("code@"+tempindex);
 var select2 = document.getElementById("desc@"+tempindex);
 <?php 
 $query = "SELECT type AS cat FROM ims_itemtypes ORDER BY type";
 $result = mysql_query($query,$conn) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {
	echo "if(cat == '$rows[cat]') { ";
	$query1 = "SELECT code,description FROM ims_itemcodes WHERE cat = '$rows[cat]' ORDER BY code";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1 = mysql_fetch_assoc($result1))
	{
	 ?>
  theOption1 = document.createElement("OPTION");
  theText1 = document.createTextNode("<?php echo $rows1['code']; ?>");
  theOption1.value = "<?php echo $rows1['code']."@".$rows1['description']; ?>";
  theOption1.title = "<?php echo $rows1['description']; ?>";
  theOption1.appendChild(theText1);
  select1.appendChild(theOption1);	 
	 <?php 
	}
	$query1 = "SELECT code,description FROM ims_itemcodes WHERE cat = '$rows[cat]' ORDER BY description";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1 = mysql_fetch_assoc($result1))
	{
	 ?>
  theOption1 = document.createElement("OPTION");
  theText1 = document.createTextNode("<?php echo $rows1['description']; ?>");
  theOption1.value = "<?php echo $rows1['code']."@".$rows1['description']; ?>";
  theOption1.title = "<?php echo $rows1['description']; ?>";
  theOption1.appendChild(theText1);
  select2.appendChild(theOption1);	 
	 <?php 
	}
	echo " } ";
 }
 ?>
}

function selectdesc(a)
{
 var temp = a.split('@');
 var tempindex = temp[1];
 document.getElementById('desc@'+tempindex).value =  document.getElementById('code@'+tempindex).value
}

function selectcode(a)
{
 var temp = a.split('@');
 var tempindex = temp[1];
 document.getElementById('code@'+tempindex).value =  document.getElementById('desc@'+tempindex).value
}

function removeAllOptions(selectbox)
{
	for(var i=selectbox.options.length-1;i>0;i--)
		selectbox.remove(i);
}

var index = 1;
function makeForm()
{
if(document.getElementById('code@'+index).value != '')
{
index++;

var table = document.getElementById("tab1");

var tr0 = document.createElement('tr');
tr0.height = "10px";
table.appendChild(tr0);

var tr = document.createElement('tr');

var td0 = document.createElement("td");
var i1 = document.createElement("input");
i1.type = "text";
i1.id = "fromdate@" + index;
i1.name = "fromdate[]";
i1.size = "10";
var c = "datepicker" + index;
i1.setAttribute("class",c);
var prevfrom = document.getElementById("fromdate@"+ (index-1)).value;
i1.value = prevfrom;
td0.appendChild(i1);
tr.appendChild(td0);

var tds4 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds4.appendChild(myspace2);
tr.appendChild(tds4);

var td01 = document.createElement("td");
var i1 = document.createElement("input");
i1.type = "text";
i1.id = "todate@" + index;
i1.name = "todate[]";
i1.size = "10";
var c = "datepicker" + index;
i1.setAttribute("class",c);
var prevto = document.getElementById("todate@"+ (index-1)).value;
i1.value = prevto;
td01.appendChild(i1);
tr.appendChild(td01);

var tds41 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds41.appendChild(myspace2);
tr.appendChild(tds41);

var td01 = document.createElement("td");
var myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" +index;
myselect1.style.width = "200px";
myselect1.onchange = function() { loadcodes(this.id); };
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php 
$query = "SELECT type AS cat FROM ims_itemtypes ORDER BY type";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $rows['cat']; ?>");
theOption1.value = "<?php echo $rows['cat']; ?>";
theOption1.title = "<?php echo $rows['cat']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1); 
 <?php 
}
?>
td01.appendChild(myselect1);
tr.appendChild(td01);

var tds41 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds41.appendChild(myspace2);
tr.appendChild(tds41);

var td01 = document.createElement("td");
var myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" +index;
myselect1.style.width = "100px";
myselect1.onchange = function() { selectdesc(this.id); };
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
td01.appendChild(myselect1);
tr.appendChild(td01);

var tds41 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds41.appendChild(myspace2);
tr.appendChild(tds41);

var td01 = document.createElement("td");
var myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" +index;
myselect1.style.width = "200px";
myselect1.onchange = function() { selectcode(this.id); };
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
td01.appendChild(myselect1);
tr.appendChild(td01);

var tds3 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds3.appendChild(myspace2);
tr.appendChild(tds3);

var td2 = document.createElement("td");
var i1 = document.createElement("input");
i1.type = "text";
i1.id = "stdcost@" + index;
i1.name = "stdcost[]";
i1.size = "10";
i1.style.textAlign = "right";
i1.value="0";
i1.onfocus = function() { makeForm(); };
td2.appendChild(i1);
tr.appendChild(td2);

table.appendChild(tr);
}
  $(function() {
	$( "." + c ).datepicker();
  });

}
</script>

<script type="text/javascript">

function script1() {

window.open('IMSHelp/help_m_addstandardcost.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=YES,resizable=yes');

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
