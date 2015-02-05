<?php include "jquery.php"; include "getemployee.php"; ?>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="oc_savereceiptmultiple.php" >
	  <h1 id="title1">COBI Receipt Multiple</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
<script type="text/javascript">
var index = 0;
</script>			  

<table align="center" id="inputs">
<tr>
        <th style="text-align:center"><strong>Date</strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>Customer</strong></th>
        <th width="10px"></th>
        <!--<th style="text-align:center"><strong>Doc. No</strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>Warehouse</strong></th>
        <th width="10px"></th>-->
        <th style="text-align:center"><strong>Mode</strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>Code</strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>Amount</strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>Cheque No.</strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>Cheque Date</strong></th>
        <th width="10px"></th>
</tr>

<tr height="10px"></tr>
<tr>
 <td>
 <input type="text" name="date[]" id="date@0" class="datepicker" value="<?php echo date("d.m.Y"); ?>"  size="12"  /> 
 </td>
 <td width="10px"></td>
 <td>
<select id="party@0" name="party[]" style="width:150px">
<option value="select">-Select-</option>
<?php
		$q = "select distinct(name) from contactdetails where (type = 'party' OR type = 'vendor and party') and client = '$client' order by name";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option value="<?php echo $qr['name'];?>" title="<?php echo $qr['name']; ?>"><?php echo $qr['name']; ?></option>
<?php   }   ?>
</select>

 </td>
 <!--<td width="10px"></td>
 <td><input type="text" size="8" id="bookinvoice@0" name="bookinvoice[]" value=""></td>
 <td width="10px"></td>
 <td>
<select id="warehouse@0" name="warehouse[]" style="width:120px">
<option>-Select-</option>
<?php
$q1 = "SELECT distinct(sector) FROM tbl_sector WHERE type1 <> 'Warehouse' and client = '$client' order by sector";
$r1 = mysql_query($q1,$conn);
$n1 = mysql_num_rows($r1);
while($row1 = mysql_fetch_assoc($r1))
{ ?>
<option value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>
 </td>-->
 <td width="10px"></td>
 <td>
<select id="paymentmode@0" name="paymentmode[]" style="width:100px" onchange="cashcheque(this.id,this.value);">
<option value="select">-Select-</option>
<option value="Cash">Cash</option>
<option value="Cheque">Cheque</option>
<option value="Others">Others</option>
</select>
 </td>
 <td width="10px"></td>
 <td>
<select id="code@0" name="code[]" style="width:120px">
<option value="">-Select-</option>
</select>
 </td>
 <td width="10px"></td>
 <td>
<input type="text" id="amount@0" name="amount[]" size="10" value="0" style="text-align:right"/> </td>
 <td width="10px"></td>
 <td>
<input type="text" id="cheque@0" name="cheque[]" size="10" onfocus="makeForm();" />
 </td>
 <td width="10px"></td>
 <td>
<input type="text" id="cdate@0" name="cdate[]" size="12" class="datepicker" value="<?php echo date("d.m.Y");?>"/>
 </td>
</tr>
</table>
<table align="center">
<tr height="30px"></tr>
<tr>
 <td><input type="submit" value="Save" name="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" name="cancel" onclick="document.location='dashboardsub.php?page=oc_receipt'" />
 </td>
 </tr>
 </table>
<div id="getdata">
</div>

             </center>
     </form>
  </div>
</section>

		


<div class="clear"></div>
<br />

<?php 

$q = "select distinct(code) from ims_bagdetails";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$count = mysql_num_rows($qrs);
?>
<script type="text/javascript">
function cashcheque(b,a)
{
var tindex = b.substr(12);

removeAllOptions(document.getElementById('code@' + tindex));
var code = document.getElementById('code@' + tindex);
theOption1=document.createElement("OPTION");
theOption1.value = "select";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
code.appendChild(theOption1);

if(a == "Cash")
{
<?php 
	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' and client = '$client' order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['code']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
else if(a == "Cheque")
{
<?php 
	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' and client = '$client' order by acno";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['acno']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


function makeForm()
{
if(document.getElementById('party@'+index).value != "select" && document.getElementById('code@'+index).value != "select" && document.getElementById('amount@'+index).value > 0)
{
index = index + 1;
var tab1 = document.getElementById("inputs");
var tr = document.createElement('tr');

input1 = document.createElement('input');
input1.id = "date@"+index;
input1.name = "date[]";
input1.size = "12";
input1.value = document.getElementById("date@" + (index-1)).value;
var c = "datepicker" + index;
input1.setAttribute("class",c);
var date = document.createElement('td');
date.appendChild(input1);

var tds0 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds0.appendChild(myspace2);

var pvendor = document.getElementById('party@'+(index-1)).value;
myselect1 = document.createElement('select');
myselect1.id = "party@"+index;
myselect1.name = "party[]";
myselect1.style.width = "150px";
theOption1=document.createElement("OPTION");
theOption1.value = "select";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php
$query = "select distinct(name) from contactdetails where (type = 'party' OR type = 'vendor and party') and client = '$client' order by name";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['name']; ?>");
theOption1.value = "<?php echo $row1['name']; ?>";
theOption1.title = "<?php echo $row1['name']; ?>";
 <?php echo "if(pvendor == '$row1[name]') { "; ?>
 theOption1.selected = "selected";
 <?php echo " } ";?>

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php } ?>

var party = document.createElement('td');
party.appendChild(myselect1);

var tds1 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds1.appendChild(myspace2);

input1 = document.createElement('input');
input1.id = "bookinvoice@"+index;
input1.name = "bookinvoice[]";
input1.size = "8";
var bookinvoice = document.createElement('td');
bookinvoice.appendChild(input1);


var tds2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds2.appendChild(myspace2);

myselect1 = document.createElement('select');
myselect1.id = "warehouse@"+index;
myselect1.name = "warehouse[]";
myselect1.style.width = "120px";
theOption1=document.createElement("OPTION");
theOption1.value = "select";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php
$query = "SELECT distinct(sector) FROM tbl_sector WHERE type1 <> 'Warehouse' and client = '$client' order by sector";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.title = "<?php echo $row1['sector']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php } ?>

var warehouse = document.createElement('td');
warehouse.appendChild(myselect1);

var tds3 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds3.appendChild(myspace2);

myselect1 = document.createElement('select');
myselect1.id = "paymentmode@"+index;
myselect1.name = "paymentmode[]";
myselect1.style.width = "100px";
myselect1.onchange = function() { cashcheque(this.id,this.value); }
theOption1=document.createElement("OPTION");
theOption1.value = "select";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Cash");
theOption1.value = "Cash";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Cheque");
theOption1.value = "Cheque";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Others");
theOption1.value = "Others";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

var mode = document.createElement('td');
mode.appendChild(myselect1);

var tds4 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds4.appendChild(myspace2);

myselect1 = document.createElement('select');
myselect1.id = "code@"+index;
myselect1.name = "code[]";
myselect1.style.width = "120px";
theOption1=document.createElement("OPTION");
theOption1.value = "select";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
var code = document.createElement('td');
code.appendChild(myselect1);

var tds5 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds5.appendChild(myspace2);

input1 = document.createElement('input');
input1.id = "amount@"+index;
input1.name = "amount[]";
input1.value = "0";
input1.size = "10";
input1.style.textAlign = "right";
input1.value = "0";
var amount = document.createElement('td');
amount.appendChild(input1);

var tds6 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds6.appendChild(myspace2);

input1 = document.createElement('input');
input1.id = "cheque@"+index;
input1.name = "cheque[]";
input1.size = "10";
input1.onfocus = function() { makeForm(); }
var cheque = document.createElement('td');
cheque.appendChild(input1);

var tds7 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds7.appendChild(myspace2);

input1 = document.createElement('input');
input1.id = "cdate@"+index;
input1.name = "cdate[]";
input1.size = "12";
input1.value = "<?php echo date("d.m.Y"); ?>";
var c1 = "datepicker" + index;
input1.setAttribute("class",c1);
var cdate = document.createElement('td');
cdate.appendChild(input1);

tr.appendChild(date);
tr.appendChild(tds0);
tr.appendChild(party);
tr.appendChild(tds1);
/*tr.appendChild(bookinvoice);
tr.appendChild(tds2);
tr.appendChild(warehouse);
tr.appendChild(tds3);*/
tr.appendChild(mode);
tr.appendChild(tds4);
tr.appendChild(code);
tr.appendChild(tds5);
tr.appendChild(amount);
tr.appendChild(tds6);
tr.appendChild(cheque);
tr.appendChild(tds7);
tr.appendChild(cdate);
//tr.appendChild(tds8);
//tr.appendChild(total);

tab1.appendChild(tr);
}
  $(function() {
	$( "." + c ).datepicker();
  });

}


function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function checkcodes()
{

	for(var i = 0; i <= index; i++)
	{
		for(var j = 0; j <= index; j++)
		{
			if( i!= j && document.getElementById('formula@' + i).value == document.getElementById('formula@' + j).value)
			{
				alert("Please select different combination");
				document.getElementById('formula@' + j).selectedIndex = 0;
				return;
			}
		}
	}

}

</script>

<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('FeedmillHelp/help_p_addproduction.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
