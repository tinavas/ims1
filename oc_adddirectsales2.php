<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";



$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(cobiincr) as cobiincr FROM oc_cobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $cobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$cobiincr = $row1['cobiincr']; 
$cobiincr = $cobiincr + 1;
if ($cobiincr < 10) 
$cobi = 'COBI-'.$m.$y.'-000'.$cobiincr; 
else if($cobiincr < 100 && $cobiincr >= 10) 
$cobi = 'COBI-'.$m.$y.'-00'.$cobiincr; 
else $cobi = 'COBI-'.$m.$y.'-0'.$cobiincr;

?>



<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" method="post" action="oc_savedirectsales1.php" onsubmit="return checkcoa();">
		<input type="hidden" name="cobiincr" id="cobiincr" value="<?php echo $cobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		
		<input type="hidden" name="discountamount" id="discountamount" value="0"/>
	 
	  <h1>Direct Sales</h1>
		<br /><br />
            <table align="center">
              <tr>
             
                <td><strong>Date</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" onchange="getsobi();"></td>
                <td width="5px"></td>

                <td><strong>Customer</strong></td>
                <td>&nbsp;
					<select id="party" name="party" style="width:175px">
					<option>-Select-</option>
					<?php
							$q = "select distinct(name) from contactdetails where type = 'party' order by name";
							$qrs = mysql_query($q,$conn) or die(mysql_error());
							while($qr = mysql_fetch_assoc($qrs))
							{
					?>
					<option value="<?php echo $qr['name'];?>" title="<?php echo $qr['name']; ?>"><?php echo $qr['name']; ?></option>
					<?php   }   ?>
					</select>
				</td>
				 <td width="5px"></td>

                
                <td><strong>Invoice</strong></td>
                <td width="15px"></td>
                <td><input type="text" size="19" style="background:none;border:none;" id="invoice" name="invoice" value="<?php echo $cobi; ?>" readonly /></td>
				
				<td width="5px"></td>
				
                <td><strong>Book&nbsp;Invoice</strong></td>
				<td width="5px"></td>
                <td>
					<input type="text" size="12" id="bookinvoice" name="bookinvoice" value=""></td>
                
				
              </tr>
            </table>
<br /><br />			

<center>
 <table border="0" id="table-po">
     <tr>
<th><strong>Category</strong></th><td width="10px">&nbsp;</td>
<th><strong>Code</strong></th><td width="10px">&nbsp;</td>
<th><strong>Description</strong></th><td width="10px">&nbsp;</td>
<th><strong>Units</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty</strong></th><td width="10px">&nbsp;</td>
<th><strong>Price<br />/Unit</strong></th><td width="10px">&nbsp;</td>
<th><strong>Weight</strong></th><td width="10px">&nbsp;</td>
<?php if($_SESSION['db'] == "golden") { ?><th><strong>Unit</strong><td width="10px">&nbsp;</td><?php } ?>
<th><strong>Flock</strong></th><td width="10px">&nbsp;</td>
<th><strong>Free Chicks</strong></th><td width="10px">&nbsp;</td>


     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:75px" name="cat[]" id="cat@-1" onchange="getcode(this.id);">
     <option>-Select-</option>
     <?php 
	     $query = "SELECT distinct(type) FROM ims_itemtypes where type <> 'Broiler Birds' ORDER BY type ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <option value="<?php echo $row['type'];?>"><?php echo $row['type']; ?></option>
     <?php } ?>
</select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<select style="Width:75px" name="code[]" id="code@-1" onchange="selectdesc(this.id);">
     		<option>-Select-</option>
     <?php 
	     $query = "SELECT distinct(code) FROM ims_itemcodes ORDER BY code ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <!--<option value="<?php #echo $row['code'];?>"><?php #echo $row['code']; ?></option>-->
     <?php } ?>
</select>
       </td>
<td width="10px">&nbsp;</td><td>
<select style="Width:120px" name="description[]" id="description@-1" onchange="selectcode(this.id);">
     		<option>-Select-</option>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" style="text-align:right;" id="qtys@-1" name="qtys[]" value="" onkeyup="calnet('');" onblur="calnet('');" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="price@-1" style="text-align:right;" name="price[]" value="" onfocus="makeForm();" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="weight@-1" style="text-align:right; display:none" name="weight[]" value="" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td>
<?php if($_SESSION['db'] == "golden") { ?>
<td>
<select id="unit@-1" name="unit[]" style="display:none">
<option value="">-Select Unit-</option>
<option value="All">All</option>

</select>
</td>
<td width="10px">&nbsp;</td>
<?php } ?>
<td>
<select id="flock@-1" name="flock[]" style="display:none">
<option value="">-Select Flock-</option>
<option value="All">All</option>

</select>
</td>
<td width="10px">&nbsp;</td>


<td>
<input type="text" size="6" id="free@-1" style="text-align:right;" name="free[]" value=""/> 
</td>


    </tr>
   </table>
   <br /> 
 </center>

<br />			

<table border="1">
   <tr style="height:20px"></tr>
   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;&nbsp;&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="0" style="text-align:right" readonly /></td>
      <td align="right"><strong>Discount &nbsp;&nbsp;&nbsp;</strong></td>
          <td align="left"> <input type="radio" id="disper" name="discount" checked="true" onclick="calnet('dcreate')" /><strong>%</strong>&nbsp;<input type="radio" id="disper1" name="discount" onclick="calnet('dcreate')" /> <strong>Amt</strong>
      <input type="text" size="6" id="disamount" name="disamount" value="0" style="text-align:right" onkeyup="calnet('dcreate')" /></td>
      <td align="right"><strong>&nbsp;Broker&nbsp;Name</strong>&nbsp;&nbsp;</td>
      <td align="left"><select style="Width:120px" name="broker" id="broker"><option value="">-Select-</option>
           <?php $query = "SELECT distinct(name) FROM contactdetails where type = 'broker' ORDER BY name ASC"; $result = mysql_query($query,$conn);
                 while($row = mysql_fetch_assoc($result)){ ?>
           <option value="<?php echo $row['name'];?>" > <?php echo $row['name']; ?></option>
                <?php } ?></select></td>
      <td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" /></td>
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Price</strong>&nbsp;&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:right" value="0" readonly/></td>
   <td></td><td></td><td></td><td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>
   <td align="left"><input type="text" size="15" name="driver" /></td>

  </tr>
  <tr style="height:20px"></tr>
  <tr style="height:20px"></tr>
   <tr>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select name="freighttype" id="freighttype" onchange="calnet('dcreate')"><option>-Select-</option> <option value="Included">Included</option><option value="Excluded">Excluded</option></select></td>

       <td align="right"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><input type="text" size="8" name="cfamount" id="cfamount" onkeyup="calnet('dcreate')" value="0" style="text-align:right"/>
	   &nbsp;&nbsp;
	   <select id="coa" name="coa" style="width:80px">
	   <option value="">-Select-</option>
	   <?php 
	   		$q = "select distinct(code),description from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSES' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
	   ?>
	   <option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
	   <?php } ?>
	   </select>
	   </td>
       <td align="right"><strong>Via</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select style="Width:80px" name="cvia" id="cvia" onchange="loadcodes(this.value);"><option value="">-Select-</option><option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="Others">Others</option></select></td>
	  <td align="right" id="cashbankcodetd1" style="display:none"><strong><span id="codespan">Code</span></strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="cashbankcodetd2" style="display:none">
		<select name="cashbankcode" id="cashbankcode" style="width:125px">
		<option value="">-Select-</option>
		</select>
		</td>

</tr>
<tr style="height:20px"></tr>
<tr>
<td></td><td></td><td></td><td></td>
	  <td align="right" id="chequetd1" style="visibility:hidden"><strong>Cheque</strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="chequetd2" style="visibility:hidden">
		<input type="text" name="cheque" id="cheque" size="15">
		</td>

       <td align="right" id="datedtd1" style="display:none"><strong>Dated</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left" id="datedtd2" style="display:none"><input type="text" size="15" id="cdate" class="datepicker" name="cdate" value="<?php echo date("d.m.Y"); ?>" /></td>


</tr>
  <tr style="height:20px"></tr>
<tr>
	  <td align="right"><strong>&nbsp;Grand&nbsp;Total</strong>&nbsp;&nbsp;</td>
        <td align="left"><input type="text" size="12" name="tpayment" id="tpayment" value="0" readonly style="text-align:right"/></td>
</tr>
</table>	
<center>	


   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=oc_directsales';">
</center>


						
</form>
</div>
</section>
<div class="clear">
</div>
<br />

<script type="text/javascript">

function getsobi()
{

  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var cobiincr = new Array();
    var cobi = "";
	var code = "<?php echo $code; ?>";
  <?php 
   
   $query1 = "SELECT MAX(cobiincr) as cobiincr,m,y FROM oc_cobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1) or die(mysql_error());
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     cobiincr[<?php echo $k; ?>] = <?php if($row1['cobiincr'] < 0) { echo 0; } else { echo $row1['cobiincr']; } ?>;

<?php $k++; } ?>
for(var l = 0; l <= <?php echo $k; ?>;l++)
{

 if((yea[l] == y) && (mon[l] == m))
  { 
   if(cobiincr[l] < 10)
     cobi = 'COBI'+'-'+m+y+'-000'+parseInt(cobiincr[l]+1);
   else if(cobiincr[l] < 100 && cobiincr[l] >= 10)
     cobi = 'COBI'+'-'+m+y+'-00'+parseInt(cobiincr[l]+1);
   else
     cobi = 'COBI'+'-'+m+y+'-0'+parseInt(cobiincr[l]+1);
     document.getElementById('cobiincr').value = parseInt(cobiincr[l] + 1);
  break;
  }
 else
  {
   cobi = 'COBI' + '-' + m + y + '-000' + parseInt(1);
   document.getElementById('cobiincr').value = 1;
  }
}
document.getElementById('invoice').value = cobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;
}

function loadcodes(via)
{
removeAllOptions(document.getElementById('cashbankcode'));
var code = document.getElementById('cashbankcode');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
code.appendChild(theOption1);
document.getElementById('codespan').innerHTML = "Code";
document.getElementById('cashbankcodetd1').style.display = "none";
document.getElementById('cashbankcodetd2').style.display = "none";
document.getElementById('datedtd1').style.display = "none";
document.getElementById('datedtd2').style.display = "none";
document.getElementById('chequetd1').style.visibility = "hidden";
document.getElementById('chequetd2').style.visibility = "hidden";

if(via == "Cash")
{
document.getElementById('codespan').innerHTML = "Cash Code ";
document.getElementById('cashbankcodetd1').style.display = "";
document.getElementById('cashbankcodetd2').style.display = "";
document.getElementById('datedtd1').style.display = "";
document.getElementById('datedtd2').style.display = "";

	<?php 
		$q = "select distinct(code),name from ac_bankmasters where mode = 'Cash' order by code";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
	?>
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("<?php echo $qr['code']; ?>");
		theOption1.value = "<?php echo $qr['code']; ?>";
		theOption1.title = "<?php echo $qr['name']; ?>";
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	<?php } ?>
}
else if(via == "Cheque")
{
document.getElementById('codespan').innerHTML = "Bank A/C No. ";
document.getElementById('cashbankcodetd1').style.display = "";
document.getElementById('cashbankcodetd2').style.display = "";
document.getElementById('datedtd1').style.display = "";
document.getElementById('datedtd2').style.display = "";
document.getElementById('chequetd1').style.visibility = "visible";
document.getElementById('chequetd2').style.visibility = "visible";


	<?php 
		$q = "select distinct(acno),name from ac_bankmasters where mode = 'Bank' order by acno";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
	?>
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
		theOption1.value = "<?php echo $qr['acno']; ?>";
		theOption1.title = "<?php echo $qr['name']; ?>";
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	<?php } ?>
}
}

var index = -1;
function getdesc(code)
{
	var code1 = document.getElementById(code).value;
	temp = code.split("@");
	var index1 = temp[1];
	

	<?php 
			$q = "select distinct(code) from ims_itemcodes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('description@' + index1).value = "<?php echo $q1r['description'];?>";
				document.getElementById('units@' + index1).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}
	?>
	//alert(index);
/* restrict the user to select same itemcode more than once
	for(var i = -1; i <= index; i++)
		for(var j = -1; j <= index; j++)
			if( i != j )
				if(document.getElementById('code@' + i).value == document.getElementById('code@' + j).value)
				{
				alert("Please select distinct codes");
				document.getElementById('description@' + j).value = "";
				document.getElementById('units@' + j).value = "";
				return;
				}
*/
}
var index = -1;
function selectdesc(codeid)
{


var temp = codeid.split("@");
var tempindex = temp[1];
var item2=document.getElementById("cat@" + tempindex).value;
var item1 = document.getElementById(codeid).value;
 //alert(t);
removeAllOptions(document.getElementById("description@" + tempindex));
myselect1 = document.getElementById("description@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "description[]";
myselect1.style.width = "120px";
<?php 
	     $query1 = "SELECT code,description,cat FROM ims_itemcodes where iusage = 'Sale' or iusage = 'Produced or Sale' ORDER BY code ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   ?>
     	 <?php echo "if(item2 == '$row1[cat]') {"; ?>
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.value = "<?php echo $row1['description']; ?>";
theOption1.title = "<?php echo $row1['code']; ?>";


<?php echo "if(item1 == '$row1[code]') {"; ?>			
theOption1.selected = true;
var units = document.getElementById("units@" + tempindex);
<?php
			$q1 = "select distinct(description),sunits from ims_itemcodes where description = '$row1[description]' order by 
			description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
	document.getElementById('units@' + tempindex).value = "<?php echo $q1r['sunits'];?>";

<?php
			}
			
	?>

<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>
}


function selectcode(codeid)
{

var temp = codeid.split("@");
var tempindex = temp[1];
var item2 = document.getElementById("cat@" + tempindex).value;
var item1 = document.getElementById(codeid).value;
removeAllOptions(document.getElementById("code@" + tempindex));
myselect1 = document.getElementById("code@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "code[]";
myselect1.style.width = "75px";
<?php 
	     $query1 = "SELECT code,description,cat,sunits FROM ims_itemcodes where iusage = 'Sale' or iusage = 'Produced or Sale' ORDER BY code ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   ?>
		   <?php echo "if(item2 == '$row1[cat]') {"; ?>
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";


     	<?php echo "if(item1 == '$row1[description]') {"; ?>
			
theOption1.selected = true;
var units = document.getElementById("units@" + tempindex);
<?php

			
			$q1 = "select distinct(description),sunits from ims_itemcodes where description = '$row1[description]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
	document.getElementById('units@' + tempindex).value = "<?php echo $q1r['sunits'];?>";

<?php
			}
			
	?>
<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php echo "}"; ?>


<?php }  ?>
}



function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;
	//document.getElementById('bagtype@' + index1).style.display = "none";
	document.getElementById('flock@' + index1).style.display = "none";
	document.getElementById('weight@' + index1).style.display = "none";
	if((cat1 == "Broiler Birds") || (cat1 == "Broiler Chicks"))
	{
if (cat1 == "Broiler Birds")
document.getElementById('weight@' + index1).style.display = "";
	document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select Farm-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


myselect1.name = "flock[]";


myselect1.id = "flock@" + index;
myselect1.style.width = "120px";

<?php 
	     $query1 = "SELECT distinct(farm) as 'farm' FROM broiler_farm ORDER BY farm ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['farm']; ?>");
theOption1.value = "<?php echo $row1['farm']; ?>";
theOption1.title = "<?php echo $row1['farm']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>
}

if((cat1 == "Female Birds") || (cat1 == "Male Birds"))
	{
	document.getElementById('flock@' + index1).style.display = "";
document.getElementById('weight@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select Flock-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";


myselect1.id = "flock@" + index;
myselect1.style.width = "120px";

<?php 
	     $query1 = "SELECT distinct(flockcode)  FROM breeder_flock WHERE client = '$client' and cullflag='0' ORDER BY flockcode ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['flockcode']; ?>");
theOption1.value = "<?php echo $row1['flockcode']; ?>";
theOption1.title = "<?php echo $row1['flockcode']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>
}
	

if((cat1 == "Hatch Eggs") || (cat1 == "Eggs"))
	{
	<?php if($_SESSION['db'] == "golden") { ?>
	document.getElementById('unit@' + index1).style.display = "";
	removeAllOptions(document.getElementById('unit@' + index1));
	myselect1 = document.getElementById('unit@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


myselect1.name = "unit[]";


myselect1.id = "unit@" + index;
myselect1.style.width = "120px";
myselect1.onchange = function () { getflock(this.id); };

<?php 
 $query1 = "SELECT distinct(unitcode)  FROM breeder_unit ORDER BY unitdescription ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
/*	     $query1 = "SELECT distinct(shedcode)  FROM breeder_shed ORDER BY shedcode ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))*/
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['unitcode']; ?>");
theOption1.value = "<?php echo $row1['unitcode']; ?>";
theOption1.title = "<?php echo $row1['unitcode']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }   ?>
document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	
<?php } else { ?>
	document.getElementById('flock@' + index1).style.display = "";
	removeAllOptions(document.getElementById('flock@' + index1));
	myselect1 = document.getElementById('flock@' + index1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("All");
theOption1.value = "All";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


myselect1.name = "flock[]";


myselect1.id = "flock@" + index;
myselect1.style.width = "120px";

<?php 
 $query1 = "SELECT distinct(flockcode)  FROM breeder_flock WHERE client = '$client' and cullflag='0' ORDER BY flockcode ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
/*	     $query1 = "SELECT distinct(shedcode)  FROM breeder_shed ORDER BY shedcode ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))*/
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['flockcode']; ?>");
theOption1.value = "<?php echo $row1['flockcode']; ?>";
theOption1.title = "<?php echo $row1['flockcode']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }   ?>
<?php } ?>
}
	removeAllOptions(document.getElementById('code@' + index1));
			  var code = document.getElementById('code@' + index1);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              code.appendChild(theOption1);
			  
			   
	removeAllOptions(document.getElementById('description@' + index1));  
			 var description = document.getElementById('description@' + index1); 
              // for description starts
 
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);
	
            // for description ends
			 
	

	<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";
			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (iusage = 'Sale' or iusage = 'Produced or Sale') order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['code'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['code'];?>";
	        theOption1.title = "<?php echo $q1r['description'];?>";
              code.appendChild(theOption1);
			  
			    
			// for description starts
  
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['description'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['description']; ?>";
	        theOption1.title = "<?php echo $q1r['code'];?>";
              description.appendChild(theOption1);
 
           // for description ends 
	<?php
			}
			echo "}";
			}
	?>

}
function getflock(unt)
{
 var ware1 = document.getElementById(unt).value;
  var ware = unt;
  temp = ware.split("@");
	var index11 = temp[1];
  removeAllOptions(document.getElementById('flock@' + index11));
	myselect1 = document.getElementById('flock@' + index11);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("All");
theOption1.value = "All";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


myselect1.name = "flock[]";


myselect1.id = "flock@" + index11;
myselect1.style.width = "120px";
  <?php 
			$q = "select distinct(unitcode) from breeder_unit";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(ware1 == '$qr[unitcode]') {";
			$q1 = "select distinct(flkmain) from breeder_flock where client = '$client' and cullflag='0' and unitcode = '$qr[unitcode]' order by flkmain ";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
			
	?>
	
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['flkmain'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['flkmain'];?>";
	        theOption1.title = "<?php echo $q1r['flkmain'];?>";
              myselect1.appendChild(theOption1);
	<?php
			}
			echo "}";
			}
	?>
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
if(index== -1)
{
makeForm1();
}
else 
{
var ind= index-1;
if(document.getElementById('price@'+ind).value != "")
{
makeForm1();
}
}
}

function makeForm1() 
{
index = index + 1 ;

///////////para element//////////
var etd = document.createElement('td');
etd.width = "10px";
theText1=document.createTextNode('\u00a0');
etd.appendChild(theText1);

var etd1 = document.createElement('td');
etd1.width = "10px";
theText1=document.createTextNode('\u00a0');
etd1.appendChild(theText1);

var etd2 = document.createElement('td');
etd2.width = "10px";
theText1=document.createTextNode('\u00a0');
etd2.appendChild(theText1);

var etd3 = document.createElement('td');
etd3.width = "10px";
theText1=document.createTextNode('\u00a0');
etd3.appendChild(theText1);

var etd4 = document.createElement('td');
etd4.width = "10px";
theText1=document.createTextNode('\u00a0');
etd4.appendChild(theText1);

var etd5 = document.createElement('td');
etd5.width = "10px";
theText1=document.createTextNode('\u00a0');
etd5.appendChild(theText1); 

var etd6 = document.createElement('td');
etd6.width = "10px";
theText1=document.createTextNode('\u00a0');
etd6.appendChild(theText1);

var etd7 = document.createElement('td');
etd7.width = "10px";
theText1=document.createTextNode('\u00a0');
etd7.appendChild(theText1);

var etd8 = document.createElement('td');
etd8.width = "10px";
theText1=document.createTextNode('\u00a0');
etd8.appendChild(theText1);

var etd9 = document.createElement('td');
etd9.width = "10px";
theText1=document.createTextNode('\u00a0');
etd9.appendChild(theText1);


var t  = document.getElementById('table-po');

var r  = document.createElement('tr');
r.setAttribute ("align","center");

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "75px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { getcode(this.id); };
<?php 
                       $query = "SELECT distinct(type) FROM ims_itemtypes where type <> 'Broiler Birds' ORDER BY type";
                       $result = mysql_query($query); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['type']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['type']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
var type = document.createElement('td');
type.appendChild(myselect1);

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectdesc(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);


// for description start

myselect1 = document.createElement("select");
myselect1.name = "description[]";
myselect1.id = "description@" + index;
myselect1.style.width = "120px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectcode(this.id); };

// for description end


var desc = document.createElement('td');
//desc.appendChild(mybox1);
desc.appendChild(myselect1);//for description


mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="units[]";
mybox1.id = "units@" + index;
mybox1.setAttribute("readonly");

var units = document.createElement('td');
units.appendChild(mybox1);


mybox1=document.createElement("input");
mybox1.size="7";
mybox1.type="text";
mybox1.id="qtys@" + index;
mybox1.style.textAlign = "right";
mybox1.name="qtys[]";
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var qst = document.createElement('td');
qst.appendChild(mybox1);


/*mybox1=document.createElement("input");
mybox1.size="7";
mybox1.type="text";
mybox1.id="qtyr@" + index;
mybox1.name="qtyr[]";
mybox1.style.textAlign = "right";
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var qrs = document.createElement('td');
qrs.appendChild(mybox1);*/

////////// Fourth TD ////////////


mybox1=document.createElement("input");
mybox1.size="3";
mybox1.type="text";
mybox1.name="bags[]";
mybox1.style.textAlign = "right";
mybox1.id = "bags@" + index;
var bags = document.createElement('td');
bags.appendChild(mybox1);

////////// Fifth TD /////////////

myselect1 = document.createElement("select");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "bagtype[]";


myselect1.id = "bagtype@" + index;
myselect1.style.width = "80px";

<?php 
	     $query1 = "SELECT * FROM ims_itemcodes WHERE type = 'Packing Material' ORDER BY code ASC";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php }  ?>

var bagtype = document.createElement('td');
bagtype.appendChild(myselect1);

////////// Sixth TD ////////////


mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="price@" + index;
mybox1.name="price[]";
mybox1.style.textAlign = "right";
mybox1.onfocus = function () { makeForm(); };
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var price = document.createElement('td');
price.appendChild(mybox1);


mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="weight@" + index;
mybox1.name="weight[]";
mybox1.style.textAlign = "right";
mybox1.style.display = "none";
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var weight = document.createElement('td');
weight.appendChild(mybox1);

////////// Seventh TD ////////////

myselect2 = document.createElement("select");
myselect2.id="vat@" + index;
myselect2.name = "vat[]";
myselect2.onchange = function () { calnet(''); };
myselect2.style.width = "60px";

theOption2=document.createElement("OPTION");
theText2=document.createTextNode("None");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);

<?php 
   $query = "SELECT distinct(code),codevalue FROM ims_taxcodes where type = 'Tax' ORDER BY code ASC";
   $result = mysql_query($query,$conn); 
   while($row1 = mysql_fetch_assoc($result))
   {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['codevalue']; ?>";
myselect2.appendChild(theOption1);
<?php } ?>

var vat = document.createElement('td');
vat.appendChild(myselect2);

myselect2 = document.createElement("select");
myselect2.id="flock@" + index;
myselect2.name = "flock[]";
myselect2.style.display = "none";
theOption2=document.createElement("OPTION");
theText2=document.createTextNode("-Select Flock-");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);

var bagtype = document.createElement('td');
bagtype.appendChild(myselect2);

myselect2 = document.createElement("select");
myselect2.id="unit@" + index;
myselect2.name = "unit[]";
myselect2.style.display = "none";
theOption2=document.createElement("OPTION");
theText2=document.createTextNode("-Select-");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);

var unitt = document.createElement('td');
unitt.appendChild(myselect2);

input = document.createElement("input");
input.type = "hidden";
input.id = "taxamount@" + index;
input.name = "taxamount[]";

///////////eighth td///

mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.name="free[]";
mybox1.style.textAlign = "right";
mybox1.id = "free@" + index;
var free = document.createElement('td');
free.appendChild(mybox1);
	   
      r.appendChild(type);
	  r.appendChild(etd8);
      r.appendChild(code);
	  r.appendChild(etd);
      r.appendChild(desc);
	  r.appendChild(etd1);
	  r.appendChild(units);
	  r.appendChild(etd2);
	  r.appendChild(qst);
	  r.appendChild(etd3);
	  //r.appendChild(qrs);
	 // r.appendChild(etd4);
	  //r.appendChild(bags);
	  //r.appendChild(etd5);
	  //r.appendChild(bagtype);
	 // r.appendChild(etd6);
	  r.appendChild(price);
	  r.appendChild(etd7);
	   r.appendChild(weight);
	  r.appendChild(etd6);
	  r.appendChild(unitt);
	   
	  r.appendChild(etd9);
r.appendChild(free);
	  r.appendChild(bagtype);

	  //r.appendChild(etd4);
	  
	  //r.appendChild(vat);
	
	  r.appendChild(input);
      t.appendChild(r);
}

function calnet(a)
{
 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
 
 for(k = -1;k < index;k++)
 {
  //var vat = document.getElementById("vat@" + k).value;
  var vat = 0;
if ((document.getElementById('cat@' + k).value == "Broiler Birds") || (document.getElementById('cat@' + k).value == "Female Birds") || (document.getElementById('cat@' + k).value == "Male Birds"))
{
  if(document.getElementById("weight@" + k).value != "" || document.getElementById("price@" + k).value != "")
  tot = tot + (document.getElementById("weight@" + k).value * document.getElementById("price@" + k).value);
  if(vat != '0' && vat != "")
  tot = tot + ((document.getElementById("weight@" + k).value * document.getElementById("price@" + k).value)/(document.getElementById("vat@" + k).value));
}
else
{
  if(document.getElementById("qtys@" + k).value != "" || document.getElementById("price@" + k).value != "")
  tot = tot + (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);
  if(vat != '0' && vat != "")
  tot = tot + ((document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value)/(document.getElementById("vat@" + k).value));
}
  
  
 // document.getElementById('taxamount@' + k).value = ((document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value)/(document.getElementById("vat@" + k).value));
 }
 
 document.getElementById('basic').value = round_decimals(tot,3);
 
if(document.getElementById("disper").checked)
{
 var disamount = (parseFloat(document.getElementById("disamount").value) / 100) * tot;
}
else
{
 var disamount = parseFloat(document.getElementById("disamount").value);
}

document.getElementById('discountamount').value = disamount;

 tot1 = tot - disamount;
 
document.getElementById('totalprice').value = round_decimals(tot1,3);

if(document.getElementById("freighttype").value == "Included")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1;
}
if(document.getElementById("freighttype").value == "Excluded")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 + freight;
}

document.getElementById("tpayment").value = round_decimals(tot1,3);

}




function checkcoa()
{
if(document.getElementById('party').selectedIndex == 0)
{
 alert("Please select Customer");
 document.getElementById('party').focus();
 return false;
}
//alert(index);
for(var i=-1;i<=index;i++)
{
//alert(i);
//alert(document.getElementById('flock@'+i).style.display);
//if(document.getElementById('code@'+i).selectedIndex != 0 && document.getElementById('flock@'+i).style.visibility != "hidden")
if(document.getElementById('flock@'+i).style.display != "none")
{
if(document.getElementById('code@'+i).selectedIndex != 0 && document.getElementById('flock@'+i).selectedIndex == 0)
{
alert("Please select Flock");
document.getElementById('flock@'+i).focus();
return false;
}
}
}

	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0")
	{
	   
		if(document.getElementById('coa').selectedIndex == 0)
		{
			alert("Please select Chart of Account");
			document.getElementById('coa').focus();
			return false;
		}
		else if (document.getElementById('cvia').selectedIndex == 0)
		{
		   alert("Please select Mode");
			document.getElementById('cvia').focus();
			return false;
		}	
		else if (document.getElementById('cashbankcode').selectedIndex == 0)
		{
		   alert("Please select Payment Code");
			document.getElementById('cashbankcode').focus();
			return false;
		}	
	}
	else
	{
	return true;
	}
}

function round_decimals(original_number, decimals) {
    var result1 = original_number * Math.pow(10, decimals)
    var result2 = Math.round(result1)
    var result3 = result2 / Math.pow(10, decimals)
    return pad_with_zeros(result3, decimals)
}

function pad_with_zeros(rounded_value, decimal_places) {

   var value_string = rounded_value.toString()
    
   var decimal_location = value_string.indexOf(".")

   if (decimal_location == -1) {
        
      decimal_part_length = 0
        
      value_string += decimal_places > 0 ? "." : ""
    }
    else {
        decimal_part_length = value_string.length - decimal_location - 1
    }
    var pad_total = decimal_places - decimal_part_length
    if (pad_total > 0) {
        for (var counter = 1; counter <= pad_total; counter++) 
            value_string += "0"
        }
    return value_string
}

</script>
</script>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_t_adddirectsale.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="../../../Documents and Settings/Administrator/Desktop/aug5th uploads/images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>


