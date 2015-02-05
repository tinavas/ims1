<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$client = $_SESSION['client'];
$dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];

$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $sobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sobiincr = $row1['sobiincr']; 
$sobiincr = $sobiincr + 1;
if ($sobiincr < 10) 
$sobi = "SOBI-$dbcode-$empcode-".$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = "SOBI-$dbcode-$empcode-".$m.$y.'-00'.$sobiincr; 
else $sobi = "SOBI-$dbcode-$empcode-".$m.$y.'-0'.$sobiincr;
//------------------Vendor Name & Code-----------------------
$q1=mysql_query("SET group_concat_max_len=10000000");
$query="select group_concat(distinct(name),'@',code order by name) as name from contactdetails where type = 'vendor' OR type = 'vendor and party' order by name";
$result=mysql_query($query,$conn);
while($rows=mysql_fetch_assoc($result))
{
	$name=explode(",",$rows['name']);
}
$vname=json_encode($name);
//------------------Cat &Item COdes----------------------
$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes where (source = 'Purchased' or source = 'Produced or Purchased') group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);
 //---------------------------Broiler--------------------
 
if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
	$q1 = "SELECT group_concat(distinct(sector),'@',sectorname order by sector) as sector FROM tbl_sector WHERE type1='Warehouse' or type1='Chicken Center' or type1='Egg Center' order by sector";
	$query1 = "SELECT group_concat(distinct(farm) order by farm) as 'farm' FROM broiler_farm ";
}
else
{
	$sectorlist = $_SESSION['sectorlist'];
	$q1 = "SELECT group_concat(distinct(sector),'@',sectorname order by sector) as sector FROM tbl_sector WHERE (type1='Warehouse' or type1='Chicken Center' or type1='Egg Center') and sector In ($sectorlist) order by sector";
	 $query1 = "SELECT group_concat(distinct(farm) order by farm) as 'farm' FROM broiler_farm where place IN ($sectorlist) ORDER BY farm ASC";
}
$result=mysql_query($q1,$conn);
while($rows=mysql_fetch_assoc($result))
{ 
$bsect=explode(",",$rows['sector']);	
}
$bsects=json_encode($bsect);
$result=mysql_query($query1,$conn);
while($rows=mysql_fetch_assoc($result))
{ 
$bfarm=explode(",",$rows['farm']);	
}
$bfarms=json_encode($bfarm);
//-----------------For Layer Birs-----------------
$q1 = "SELECT group_concat(distinct(sector),'@',sectorname order by sector) as sector FROM tbl_sector WHERE type1='Warehouse' order by sector";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
 $lsect=explode(",",$row1['sector']);	
}
$lsects=json_encode($lsect);
$query1 = "SELECT group_concat(distinct(flockcode) order by flockcode) as 'flock' FROM layer_flock ORDER BY flockcode ASC";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
 {
	 $lflock=explode(",",$row1['flock']);
  }
  $lflocks=json_encode($lflock);
//--------------Dimakis Female & Male Birds------------
$query1 = "SELECT group_concat(distinct(flockcode) order by flockcode) as flock  FROM breeder_flock WHERE client = '$client' and cullflag='0' ";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
	 $dflock=explode(",",$row1['flock']);
  }
  $dflocks=json_encode($dflock);
//---------------------Female & Male Birds---------------------
 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
	$q1 = "SELECT  group_concat(distinct(sector),'@',sectorname order by sector) as sector FROM tbl_sector WHERE type1='Warehouse' order by sector";
}
else
{
	$sectorlist = $_SESSION['sectorlist'];
$q1 = "SELECT  group_concat(distinct(sector),'@',sectorname order by sector) as sector FROM tbl_sector WHERE type1='Warehouse' and sector In ($sectorlist) order by sector";
}
$r1 = mysql_query($q1,$conn);
 while($row1 = mysql_fetch_assoc($r1))
 {
 $fmsect=explode(",",$row1['sector']);	
}
$fmsects=json_encode($fmsect);
//----------------------Packing Material--------
$query1 = "SELECT group_concat(distinct(code),'@',description,'@',sunits order by code) as cd FROM ims_itemcodes WHERE type = 'Packing Material' ORDER BY code ASC";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
	$cd=explode(",",$row1["cd"]);
}
$cd1=json_encode($cd);
//---------------------------Cash codes----
$q = "select group_concat(distinct(code),'@',name order by code) as code from ac_bankmasters where mode = 'Cash' order by code";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
				$cashcode=explode(",",$qr["code"]);
		}
$cashcodes1=json_encode($cashcode);
//---------------------------Bank codes-------------
$q = "select group_concat(distinct(acno),'@',name,'@',code order by acno) as acno from ac_bankmasters where mode = 'Bank' order by acno";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
			$acno=explode(",",$qr[acno]);
		}
$acno1=json_encode($acno);
?>
<script type="text/javascript">
var vname=<?php if(empty($vname)){echo 0;} else{ echo $vname; }?>;
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;
var bsect=<?php if(empty($bsects)){echo 0;} else{ echo $bsects;}?>;
var bfarm=<?php if(empty($bfarms)){echo 0;} else{ echo $bfarms;}?>;
var lsect=<?php if(empty($lsects)){echo 0;} else{ echo $lsects;}?>;
var lflock=<?php if(empty($lflocks)){echo 0;} else{ echo $lflocks;}?>;
var dflock=<?php if(empty($dflocks)){echo 0;} else{ echo $dflocks;}?>;
var fmsect=<?php if(empty($fmsects)){echo 0;} else{ echo $fmsects;}?>;
var cd=<?php if(empty($cd1)){echo 0;} else{ echo $cd1;}?>;
var cashcode=<?php if(empty($cashcode1)){ echo 0;} else{ echo $cashcode1;}?>;
var acno=<?php if(empty($acno1)){echo 0;} else{ echo $acno1;}?>;

</script>

<section class="grid_8">
  <div class="block-border">
  														<!-- For CENTRAL DB THE ACTION WILL BE PP_SAVEDIRECTPURCHASEC.PHP -->
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savedirectpurchasec.php" onsubmit="return checkcoa();">
		<input type="hidden" name="sobiincr" id="sobiincr" value="<?php echo $sobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		
		<input type="hidden" name="discountamount" id="discountamount" value="0"/>
	 
	  <h1>Direct Purchase</h1> 
		<br /><br />
            <table align="center">
              <tr>
             
                <td><strong>Date</strong></td>
                <td>&nbsp;<input class="datepickerSOBIT" type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" onchange="getsobi();"></td>
                <td width="5px"></td>

                <td><strong>Vendor</strong></td>
                <td>&nbsp;
					<select id="vendor" name="vendor" style="width:175px"  onchange="changecode();">
					<option>-Select-</option>
					<?php
					for($i=0;$i<count($name);$i++)
							{ $name1=explode("@",$name[$i]);
					?>
					<option title="<?php echo $name1[0];?>" value="<?php echo $name1[0];?>"><?php echo $name1[0]; ?></option>
					<?php   }   ?>
					</select>
				</td>
                <td width="5px"></td>
				<td><strong>Vendor Code</strong></td>
                <td>&nbsp;
					<select id="vendorcode" name="vendorcode" style="width:100px"  onchange="changename();">
					<option>-Select-</option>
					<?php
					for($i=0;$i<count($name);$i++)
							{ $name1=explode("@",$name[$i]);
					?>
					<option title="<?php echo $name1[1];?>" value="<?php echo $name1[1];?>"><?php echo $name1[1]; ?></option>
					<?php   }   ?>
					</select>
				</td>
                <td width="5px"></td>

                <td><strong>Invoice</strong></td>
                <td width="15px"></td>
                <td>&nbsp;<input type="text" size="24" style="background:none;border:none;" id="invoice" name="invoice" value="<?php echo $sobi; ?>" readonly /></td>
				
				<td width="5px"></td>
				
                <td><strong>Book&nbsp;Invoice</strong></td>
				<td width="5px"></td>
                <td>&nbsp;
					<input type="text" size="12" id="bookinvoice" name="bookinvoice" value=""><br/><span id="usercheck"></span></td>                
				<td style="display:none" id="loading" ><img  title="Verifying the Book Invoice" src="images\mask-loader.gif" ></td>				
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
<th><strong>Qty Sent</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty Received</strong></th><td width="10px">&nbsp;</td>
<th><strong>Type</strong></th><td width="10px">&nbsp;</td>
<th><strong>Bags</strong></th><td width="10px">&nbsp;</td>
<th><strong>Price<br />/Unit</strong></th><td width="10px">&nbsp;</td>

<th>&nbsp;&nbsp;&nbsp;<strong>VAT</strong></th><td width="10px">&nbsp;</td>
<th>&nbsp;&nbsp;&nbsp;<strong>Warehouse</strong></th><td width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:100px" name="cat[]" id="cat@-1" onchange="getcode(this.id);">
     <option value="">-Select-</option>
<?php
for($i=0;$i<count($items);$i++)
{
?>
<option value="<?php echo $items[$i]["cat"]; ?>"><?php echo $items[$i]["cat"]; ?></option>
<?php } ?>
</select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
       
		<select style="Width:75px" name="code[]" id="code@-1" onchange="selectdesc(this.id);">
     	<option value="">-Select-</option>
		</select>
       </td>
<td width="10px">&nbsp;</td><td>
	<select style="Width:140px" name="desc[]" id="desc@-1" onchange="selectcode(this.id);">
     		<option value="">-Select-</option>
	</select>
	<input type="hidden" size="15" id="description@-1" name="description[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" style="text-align:right;" id="qtys@-1" name="qtys[]" value="" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" id="qtyr@-1" style="text-align:right;" name="qtyr[]" value="" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td><td>
<select style="Width:80px" name="bagtype[]" id="bagtype@-1"   >
	<option value="">-Select-</option>

     <?php 
	    for($i=0;$i<count($cd);$i++)
           {
			   $code=explode("@",$cd[$i]);
     ?>
             <option title="<?php echo $code[1] ; ?>" value="<?php echo $code[0];?>"><?php echo $code[0]; ?></option>
     <?php } ?>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="3" id="bags@-1" style="text-align:right;" name="bags[]" value="0"  />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="price@-1" style="text-align:right;" name="price[]" value="" onfocus="makeForm();" onkeyup="calnet('');" onblur="calnet('');"/>
</td>
<td width="10px">&nbsp;</td><td>
<select style="width:60px" name="vat[]" id="vat@-1" onchange="vatfunction('-1'); calnet(''); ">
     <option value="0">None</option>
     <?php 
	     $query = "SELECT distinct(code),codevalue,description,rule,formula FROM ims_taxcodes where type = 'Tax' AND taxflag = 'P' ORDER BY codevalue ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <option value="<?php echo $row['codevalue'];?>" title="<?php echo $row['description']."@".$row['rule']."@".$row['formula']; ?>"><?php echo $row['code']; ?></option>
     <?php } ?>
</select>
<input type="hidden" id="taxformula@-1" name="taxformula[]" value="" />
<input type="hidden" id="taxie@-1" name="taxie[]" value="" />
<input type="hidden" id="taxcode@-1" name="taxcode[]" value="" />
</td>
<td width="10px">&nbsp;</td><td>
<select id="flock@-1" name="flock[]" style="width:120px">
<option value="">-Select-</option>
</select>
<input type="hidden" id="taxamount@-1" name="taxamount[]" value="0" />
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
           <?php $query = "SELECT group_concat(distinct(name) order by name) as name FROM contactdetails where type = 'broker'"; 
		   $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
		   {
				$bname=explode(",",$row["name"]);
		   }
		   for($i=0;$i<count($bname);$i++)
		   { ?>
           <option value="<?php echo $bname[$i];?>" > <?php echo $bname[$i]; ?></option>
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
       <td align="left">
	   <select name="freighttype" id="freighttype" onchange="calnet('dcreate')" style="width:100px">
	   <option value="Included">Included</option>
	   <option value="Excluded">Excluded</option>
	   <option value="Amount in Bill" title="Freight Amount in Bill">Amount in Bill</option>
	   </select>
	   </td>

       <td align="right"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><input type="text" size="8" name="cfamount" id="cfamount" onkeyup="calnet('dcreate')" value="0" style="text-align:right"/>
	   &nbsp;&nbsp;
	   <select id="coa" name="coa" style="width:80px">
	   <option value="">-Select-</option>
	   <?php 
	   		$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSES' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}
			for($i=0;$i<count($coacode);$i++)
			{ $coacode1=explode("@",$coacode[$i]);
				
	   ?>
	   <option title="<?php echo $coacode1[1]; ?>" value="<?php echo $coacode1[0]; ?>"><?php echo $coacode1[0]; ?></option>
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
<div id="validatecurrency"></div><br>	
<center>	
<br />
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />

   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_directpurchase';">
</center>


						
</form>
</div>
</section>
<div class="clear">
</div>
<br />

<script type="text/javascript">
function vatfunction(a)
{
//alert(a);
var i = document.getElementById('vat@'+a).selectedIndex;

var temp = document.getElementById('vat@'+a).options[i].title;

var temp1 = temp.split('@');

if(temp1.length == 3)
{
 document.getElementById('taxformula@'+a).value=temp1[2];
 document.getElementById('taxie@'+a).value=temp1[1];
 document.getElementById('taxcode@'+a).value = document.getElementById('vat@'+a).options[i].text;
}
else
  document.getElementById('taxformula@'+a).value = document.getElementById('taxie@'+a).value = document.getElementById('taxcode@'+a).value = "";
}

 $(document).ready(function()
{  	
	$("#bookinvoice").blur(function()
	{  
	   
	   if($("#bookinvoice").val()) {
	   document.getElementById("usercheck").innerHTML='';
	   document.getElementById("usercheck").style.display='none';
	   document.getElementById("loading").style.display='';
		$.post("check_bookinvoice.php",{ bi:$("#bookinvoice").val(),table:"pp_sobi",col:"invoice"  },function(data)
        { 
		document.getElementById("loading").style.display='none';
		if(data>0)
		 {		  
		  document.getElementById("bookinvoice").value='';
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("usercheck").innerHTML='*Book Invoice Exists';
		  document.getElementById("usercheck").style.color='#FF0000';
		  document.getElementById("save").disabled='disabled';
		  alert('Book Invoice Number already exists');
		 }
		 else
		 {
		  document.getElementById("usercheck").style.display='';
		  document.getElementById("save").disabled='';
		 }
		});
		
	} // end of if
});
});

function fvalidatecurrency(a)
{
 var date = document.getElementById('date').value;
 var vendor = document.getElementById('vendor').value;
 var tdata = date + "@" + vendor + "@vendor";
 getdiv('validatecurrency',tdata,'pp_currencyframe.php?data=');
}

function getsobi()
{

  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var sobiincr = new Array();
    var sobi = "";
	var code = "<?php echo $code; ?>";
  <?php 
       $dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];
$prefix = "SOBI-$dbcode-$empcode";

   $query1 = "SELECT MAX(sobiincr) as sobiincr,m,y FROM pp_sobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1) or die(mysql_error());
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     sobiincr[<?php echo $k; ?>] = <?php if($row1['sobiincr'] < 0) { echo 0; } else { echo $row1['sobiincr']; } ?>;

<?php $k++; } ?>
for(var l = 0; l <= <?php echo $k; ?>;l++)
{

 if((yea[l] == y) && (mon[l] == m))
  { 
   if(sobiincr[l] < 10)
     sobi = '<?php echo $prefix; ?>'+'-'+m+y+'-000'+parseInt(sobiincr[l]+1)+code;
   else if(sobiincr[l] < 100 && sobiincr[l] >= 10)
     sobi = '<?php echo $prefix; ?>'+'-'+m+y+'-00'+parseInt(sobiincr[l]+1)+code;
   else
     sobi = '<?php echo $prefix; ?>'+'-'+m+y+'-0'+parseInt(sobiincr[l]+1)+code;
     document.getElementById('sobiincr').value = parseInt(sobiincr[l] + 1);
  break;
  }
 else
  {
   sobi = '<?php echo $prefix; ?>' + '-' + m + y + '-000' + parseInt(1)+code;
   document.getElementById('sobiincr').value = 1;
  }
}
document.getElementById('invoice').value = sobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;
fvalidatecurrency();
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
for(var k=0;k<cashcode.length;k++)
	{
		var cashcode1=cashcode[k];
		var cashcode2=cashcode1.split('@');
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode(cashcode2[0]);
		theOption1.value = cashcode2[0];
		theOption1.title = cashcode2[1];
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	}

}
else if(via == "Cheque"  || via == "Others")
{
document.getElementById('codespan').innerHTML = "Bank A/C No. ";
document.getElementById('cashbankcodetd1').style.display = "";
document.getElementById('cashbankcodetd2').style.display = "";
document.getElementById('datedtd1').style.display = "";
document.getElementById('datedtd2').style.display = "";
document.getElementById('chequetd1').style.visibility = "visible";
document.getElementById('chequetd2').style.visibility = "visible";
for(var k=0;k<acno.length;k++)
	{
		var accno=acno[k];
		var acno1=accno.split('@');
		
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode(acno1[0]);
		theOption1.value = acno1[2];
		theOption1.title =acno1[1];
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	}
}
}

function selectdesc(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("desc@" + tempindex).value = document.getElementById("code@" + tempindex).value;
     var w = document.getElementById("desc@" + tempindex).selectedIndex; 
     var description = document.getElementById("desc@" + tempindex).options[w].text;
     document.getElementById("description@" + tempindex).value = description;
	var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];
}
function selectcode(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("code@" + tempindex).value = document.getElementById("desc@" + tempindex).value;
     var w = document.getElementById("desc@" + tempindex).selectedIndex; 
     var description = document.getElementById("desc@" + tempindex).options[w].text;
     document.getElementById("description@" + tempindex).value = description;

   var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];
}



function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;
	removeAllOptions(document.getElementById('flock@' + index1));
	var opt= new Option("-Select-","");
	document.getElementById('flock@' + index1).options.add(opt);
if((cat1 == "Broiler Birds") || (cat1 == "Broiler Chicks") || (cat1 == "Broiler Day Old Chicks"))
{
	for(var m=0;m<bsect.length;m++)
	{
		var sec1=bsect[m];
		var sec=sec1.split('@');
		var opt= new Option(sec[0],sec[0]);
		opt.title=sec[1];
		document.getElementById('flock@' + index1).options.add(opt);
	}
	for(var m=0;m<bfarm.length;m++)
	{
		var opt= new Option(bfarm[m],bfarm[m]);
		opt.title=bfarm[m];
		document.getElementById('flock@' + index1).options.add(opt);
	}
}
else if(cat1 == "Layer Birds")
{
	for(var m=0;m<lsect.length;m++)
		{
			var sec1=lsect[m];
			var sec=sec1.split('@');
			var opt= new Option(sec[0],sec[0]);
			opt.title=sec[1];
			document.getElementById('flock@' + index1).options.add(opt);
		}
	for(var m=0;m<lflock.length;m++)
		{
			var opt= new Option(lflock[m],lflock[m]);
			opt.title=lflock[m];
			document.getElementById('flock@' + index1).options.add(opt);
		}
}
else if((cat1 == "Female Birds") || (cat1 == "Male Birds"))
	{

<?php if($_SESSION['db'] != "dimakis") {?>
for(var m=0;m<dflock.length;m++)
		{
			var opt= new Option(dflock[m],dflock[m]);
			opt.title=dflock[m];
			document.getElementById('flock@' + index1).options.add(opt);
		}
<?php   } else {?>
for(var m=0;m<fmsect.length;m++)
		{
			var sec1=fmsect[m];
			var sec=sec1.split('@');
			var opt= new Option(sec[0],sec[0]);
			opt.title=sec[1];
			document.getElementById('flock@' + index1).options.add(opt);
		}
<?php }?>

}
else 
{	
	for(var m=0;m<lsect.length;m++)
		{
			var sec1=lsect[m];
			var sec=sec1.split('@');
			var opt= new Option(sec[0],sec[0]);
			opt.title=sec[1];
			document.getElementById('flock@' + index1).options.add(opt);
		}
	for(var m=0;m<bfarm.length;m++)
		{
			var opt= new Option(bfarm[m],bfarm[m]);
			opt.title=bfarm[m];
			document.getElementById('flock@' + index1).options.add(opt);
		}
}	


	removeAllOptions(document.getElementById("code@" + index1));
	removeAllOptions(document.getElementById("desc@" + index1));	 
	var op1=new Option("-Select-","");
	var op2=new Option("-Select-","");
	document.getElementById("desc@" + index1).options.add(op2);
	document.getElementById("code@" + index1).options.add(op1);
	var l=items.length;
var x=document.getElementById("cat@" + index1).value;
 for(i=0;i<l;i++)
{
if(items[i].cat == x)
{
var ll=items[i].cd.split(",");
for(j=0;j<ll.length;j++)
{ 
var expp=ll[j].split("@");
var op1=new Option(expp[0],ll[j]);
op1.title=expp[0];
var op2=new Option(expp[1],ll[j]);
op2.title=expp[1];
document.getElementById("desc@" + index1).options.add(op2);
document.getElementById("code@" + index1).options.add(op1);
}
}
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

var index = -1;
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
var m=index;

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

var etd10 = document.createElement('td');
etd10.width = "10px";
theText1=document.createTextNode('\u00a0');
etd10.appendChild(theText1);

var etd11 = document.createElement('td');
etd11.width = "10px";
theText1=document.createTextNode('\u00a0');
etd11.appendChild(theText1);

var t  = document.getElementById('table-po');

var r  = document.createElement('tr');
r.setAttribute ("align","center");

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "100px";
theOption1=document.createElement("OPTION");
theOption1.value="";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { getcode(this.id); };
<?php  for($i=0;$i<count($items);$i++)
{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $items[$i]["cat"]; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $items[$i]["cat"]; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
var type = document.createElement('td');
type.appendChild(myselect1);

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";
theOption1=document.createElement("OPTION");
theOption1.value="";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectdesc(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);




myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "140px";
theOption1=document.createElement("OPTION");
theOption1.value="";
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectcode(this.id); };



mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="hidden";
mybox1.name="description[]";
mybox1.id = "description@" + index;
mybox1.setAttribute("readonly");

var desc = document.createElement('td');
desc.appendChild(myselect1); 
desc.appendChild(mybox1);




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


mybox1=document.createElement("input");
mybox1.size="7";
mybox1.type="text";
mybox1.id="qtyr@" + index;
mybox1.name="qtyr[]";
mybox1.style.textAlign = "right";
mybox1.onkeyup = function () { (''); };
mybox1.onblur = function () { calnet(''); };
var qrs = document.createElement('td');
qrs.appendChild(mybox1);

////////// Fourth TD ////////////


mybox1=document.createElement("input");
mybox1.size="3";
mybox1.type="text";
mybox1.name="bags[]";
mybox1.value="0";
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
	     for($i=0;$i<count($cd);$i++)
           {
			   $code=explode("@",$cd[$i]);
     ?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $code[0]; ?>");
theOption1.value = "<?php echo $code[0]; ?>";
theOption1.title = "<?php echo $code[1]; ?>";
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


////////// Seventh TD ////////////

myselect2 = document.createElement("select");
myselect2.id="vat@" + index;
myselect2.name = "vat[]";
myselect2.onchange = function () { vatfunction(m); calnet(''); };
myselect2.style.width = "60px";

theOption2=document.createElement("OPTION");
theText2=document.createTextNode("None");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);

<?php 
   $query = "SELECT distinct(code),codevalue,description,rule,formula FROM ims_taxcodes where type = 'Tax' AND taxflag = 'P' ORDER BY codevalue ASC";
   $result = mysql_query($query,$conn); 
   while($row1 = mysql_fetch_assoc($result))
   {
?>


var op=new Option("<?php echo $row1['code']; ?>","<?php echo $row1['codevalue']; ?>");
op.title="<?php echo $row1['description']."@".$row1['rule']."@".$row1['formula']; ?>";
myselect2.add(op);


<?php } ?>

var vat = document.createElement('td');
vat.appendChild(myselect2);

input = document.createElement("input");
input.type = "hidden";
input.id = "taxamount@" + index;
input.name = "taxamount[]";
input1 = document.createElement("input");
input1.type = "hidden";
input1.id = "taxformula@" + index;
input1.name = "taxformula[]";
input2 = document.createElement("input");
input2.type = "hidden";
input2.id = "taxcode@" + index;
input2.name = "taxcode[]";
input3 = document.createElement("input");
input3.type = "hidden";
input3.id = "taxie@" + index;
input3.name = "taxie[]";


myselect2 = document.createElement("select");
myselect2.id="doffice@" + index;
myselect2.name = "doffice[]";
myselect2.style.width = "150px";

theOption2=document.createElement("OPTION");
theOption1.value="";
theText2=document.createTextNode("-Select-");
theOption2.appendChild(theText2);
theOption2.value = 0;
myselect2.appendChild(theOption2);


var dlocation = document.createElement('td');
dlocation.appendChild(myselect2);

myselect1 = document.createElement("select");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "flock[]";
//myselect1.style.display = "none";

myselect1.id = "flock@" + index;
myselect1.style.width = "120px";
var flock = document.createElement('td');
flock.appendChild(myselect1);
	   
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
	  r.appendChild(qrs);
	  r.appendChild(etd4);
	  r.appendChild(bagtype);
	  r.appendChild(etd5);
	  r.appendChild(bags);
	  r.appendChild(etd6);
	  r.appendChild(price);
	  r.appendChild(etd7);
	  r.appendChild(vat);
	  r.appendChild(etd9);
	  r.appendChild(flock);
	  r.appendChild(etd10);
	  //r.appendChild(dlocation); 
	  r.appendChild(input);
	  r.appendChild(input1);
	  r.appendChild(input2);
	  r.appendChild(input3);
      t.appendChild(r);
	  
 
}

function calnet(a)
{
 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
  var tot2 = 0; var qty112 = 0; var price112 = 0; var temp112 = 0;
 for(k = -1;k < index;k++)
 {
 tot = 0;
  var vat = parseFloat(document.getElementById("vat@" + k).value);
  var vatie = document.getElementById("taxie@" + k).value;
  //alert("vat@"+k);
  //alert(vat);
  if(document.getElementById("qtys@" + k).value != "" && document.getElementById("price@" + k).value != "")
  tot = parseFloat((document.getElementById("qtys@" + k).value) *parseFloat(document.getElementById("price@" + k).value));
  if(vat != '0' && vat != "" && vatie == "Exclude")
   tot = tot + (tot * parseFloat(vat)/100 ); 
  tot2 = tot2 + tot;
 qty112 = document.getElementById("qtys@" + k).value;
 price112 = document.getElementById("price@" + k).value;
 temp112 = document.getElementById("vat@" + k).value;
  document.getElementById('taxamount@' + k).value = round_decimals(parseFloat(parseFloat(parseFloat(qty112) * parseFloat(price112))* parseFloat(temp112))/100,2);
 }
 tot = tot2;
 document.getElementById('basic').value = round_decimals(tot,2);
 
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
 
document.getElementById('totalprice').value = round_decimals(tot1,2);

if(document.getElementById("freighttype").value == "Included")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 - freight;
}
if(document.getElementById("freighttype").value == "Amount in Bill")
{
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 + freight;
}
document.getElementById("tpayment").value = round_decimals(tot1,2);

}


function checkcoa()
{	
if(document.getElementById('vendor').selectedIndex == 0)
{
 alert("Please select Vendor");
 document.getElementById('vendor').focus();
 return false;
}

for(var i=-1;i<=index;i++)
{
if(document.getElementById('code@'+i).selectedIndex != 0 && document.getElementById('flock@'+i).selectedIndex == 0)
{
//flk =document.getElementById('flock'+i).value; 
//alert("Test");
	  if(i == -1) 
	   t = "st"; 
	  else if(i == 0) 
	   t = "nd"; 
	  else if (i == 1) 
	   t = "rd"; 
	  else 
	   t = "th";

alert("Please select Warehouse for "+(i+2)+""+t+" row");
document.getElementById('flock@'+i).focus();
return false;
}
}


	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0" && document.getElementById('freighttype').value != "Amount in Bill" )
	{
		if(document.getElementById('coa').selectedIndex == 0 && document.getElementById('freighttype').value != "Included")
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
	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0" && document.getElementById('freighttype').value == "Amount in Bill" )
	{
		if(document.getElementById('coa').selectedIndex == 0)
		{
			alert("Please select Chart of Account");
			document.getElementById('coa').focus();
			return false;
		}	
	}
	
	if(document.getElementById('validate').value == 0)
	{
	 alert("Enter Currency conversion for this date");
	 return false;
	}
	document.getElementById('save').disabled=true;
	return true;
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
function changecode()
{
	document.getElementById("vendorcode").selectedIndex=document.getElementById("vendor").selectedIndex;

fvalidatecurrency();
}

function changename()
{
	document.getElementById("vendor").selectedIndex=document.getElementById("vendorcode").selectedIndex;

fvalidatecurrency();
}


</script>

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_t_adddirectpurchase.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

