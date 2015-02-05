<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$q1=mysql_query("SET group_concat_max_len=10000000");
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

$i=0;

if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{

 $q1 ="SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector WHERE type1='Warehouse'";
  
 }
 else
 {
  $sectorlist = $_SESSION['sectorlist'];

 $q1 ="SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 = 'Warehouse'  and sector in ($sectorlist)";

 }
 $qrs = mysql_query($q1,$conn) or die(mysql_error());
 $qr = mysql_fetch_assoc($qrs);
 $sec1=explode(",",$qr["sector"]);	
 $sector=json_encode($sec1);
 //---------------Tax Codes-------------------------------
    $q="select group_concat(code,'@',description,'@',codevalue,'@',mode,'@',rule order by code) as tax FROM ims_taxcodes where (taxflag = 'S')";
  $qrs=mysql_query($q,$conn) or die(mysql_error());
  $qr=mysql_fetch_assoc($qrs);
  $tax=explode(",",$qr['tax']);
  $tax1=json_encode($tax);


//freight

$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSE' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}

$coacode1=json_encode($coacode);


//------------------Cat &Item COdes----------------------


$query="select distinct(cat),group_concat(concat(code,'@',description,'@',sunits)) as cd from ims_itemcodes where  iusage LIKE '%Sale%'  group by cat";

$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{

$items[$i]=array("cat"=>"$row[cat]","cd"=>"$row[cd]");

$i++;

}

$item=json_encode($items);

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


$q="select group_concat(distinct(code),'@',acno,'@',coacode) as code from ac_bankmasters order by coacode";
  $qrs=mysql_query($q) or die(mysql_error());
  while($qr = mysql_fetch_assoc($qrs))
		{
			$rcode=explode(",",$qr[code]);
		}
$rcode1=json_encode($rcode);

//---------------------------ac_coa---------------------
$q="select group_concat(distinct(code),'@',description order by code) as code  from ac_coa where client='$client'";
$qrs=mysql_query($q) or die(mysql_error());
  while($qr = mysql_fetch_assoc($qrs))
		{
			$cocode=explode(",",$qr[code]);
		}
$cocode1=json_encode($cocode);

?>

 
<script type="text/javascript">

var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;
var cashcode=<?php if(empty($cashcodes1)){ echo 0;} else{ echo $cashcodes1;}?>;
var acno=<?php if(empty($acno1)){echo 0;} else{ echo $acno1;}?>;
var taxs=<?php if(empty($tax1)){echo "0";}else{ echo $tax1;}?>;
var discs=<?php if(empty($dis1)){echo "0";}else{ echo $dis1;}?>;
var rcode=<?php if(empty($rcode1))echo 0;else{ echo $rcode1;}?>;
var cocode=<?php if(empty($cocode1))echo 0;else{ echo $cocode1;}?>;

<?php /*?> var cocode=<?php if(empty($cocode1))echo 0;}else{ echo $cocode1;}?>;<?php */?>

</script>
<center>
<section class="grid_8">
  <div class="block-border">

	 <form class="block-content form" id="complex_form" method="post" action="oc_savecashsales_ims.php" onsubmit="return checkcoa();"> 
	
		<input type="hidden" name="cobiincr" id="cobiincr" value="<?php echo $cobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		
		<input type="hidden" name="discountamt" id="discountamt" value="0"/>
		<input type="hidden" name="discountamount" id="discountamount" value="0"/>
		<input type="hidden" name="finaldiscount" id="finaldiscount" value="0"/>
	 
	  <h1>Cash Sales</h1>
	  
	  <br/>
	   <b>Cash Sales</b>
	  	  <br/>
	  (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
	  <br/>	  <br/>	  <br/>        


		<table align="center">
          
<tr>
                <td><strong>Date</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="10" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" onchange="getsobi();"></td>
                <td width="5px"></td>
<?php if($_SESSION['db']=="mew"){?>
<td><strong>Marketing Emp.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
					<select  id="memp" name="memp">
					<option value="">-Select-</option>
<?php 
 $q="select distinct(name) from oc_employee order by name";
 $res=mysql_query($q);
 while($r=mysql_fetch_assoc($res))
 {
           ?>
<option value="<?php echo $r['name'];?>" title="<?php echo $r['name']; ?>"><?php echo $r['name']; ?></option>
<?php } ?>
					

					</select>
				</td>
<td width="5px"></td>
<?php } ?>

                <td title = "Invoice"><strong>Inv.</strong></td>
                <td width="5px"></td>
                <td><input type="text" size="17" style="background:none;border:none;" id="invoice" name="invoice" value="<?php echo $cobi; ?>" readonly /></td>
				<td width="5px"></td>
				<td title = "Book Invoice"><strong>B&nbsp;Inv.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td width="5px"></td>
                <td>
					<input type="text" size="7" id="bookinvoice" name="bookinvoice" value=""></td>
             
			    <td width="5px"></td>
				 <td><strong>&nbsp;Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;</strong></td>
				<td>
				
				<select id="aaa" name="aaa" style="width:120px">
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
            </table>
<br /><br />			


 <table border="0" id="table-po">
     <tr>
<th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Units</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th><strong>Price<br />/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<td width="10px">&nbsp;</td>
<th >&nbsp;&nbsp;&nbsp;<strong>Tax</strong></th><td  width="10px">&nbsp;</td>

<th >&nbsp;&nbsp;&nbsp;<strong>Discount</strong></th><td  width="10px">&nbsp;</td>



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
<select style="Width:170px" name="description[]" id="description@-1" onchange="selectcode(this.id);">
     		<option value="">-Select-</option>
</select>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units[]" value="" readonly style="background:none; border:0px"/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" style="text-align:right;" id="qtys@-1" name="qtys[]" value="" onkeyup="calnet('');" onblur="calnet('');" onkeypress="return num(this.id,event.keyCode)" />
</td>

<td width="10px">&nbsp;</td><td>
<input type="text" size="6" id="price@-1" style="text-align:right;" name="price[]" value="" onfocus="makeForm(this.id);" onkeyup="calnet('dcreate')" onkeypress="return num(this.id,event.keyCode)"    />
</td>
<td width="10px">&nbsp;</td>
<td>
<select style="width:60px" name="vat[]" id="vat@-1" onchange="calnet('');">
     <option value="0@0@0@0">None</option>
	 
	 
	  <?php 
	     for($j=0;$j<count($tax);$j++)
           {
		     $tx=explode('@',$tax[$j]);
     ?>
             <option title="<?php echo $tx[1]; ?>" value="<?php echo $tx[0]."@".$tx[2]."@".$tx[3]."@".$tx[4]; ?>"><?php echo $tx[0]; ?></option>
     <?php } ?>
	 
     
</select>


</td>
<td  width="10px">&nbsp;</td><td> 
 <input type="text" name="disc[]"  id="disc@-1" value="0" size="8"  style="text-align:right;" onkeypress="return num1(event.keyCode);" onchange="calnet('');">


<input type="hidden" id="taxamount@-1" name="taxamount[]" value="0" />
    <input type="hidden" name="discountamount[]" id="discountamount@-1" value="0" />
</td> 
 <td  width="10px">&nbsp;</td>

    </tr>
   </table>


<br />			
<center>
<table border="1">
   <tr style="height:20px"></tr>

   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;&nbsp;&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="0.00" style="text-align:left; background:none; border:0px;" readonly /></td>
    <td></td>
	<td></td>
      <td></td>    
      <td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" /></td>
	 
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Amount</strong>&nbsp;&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:left; background:none; border:0px;" value="0" readonly/></td>
 
	<td></td><td></td><td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>
   
   <td align="left"><input type="text" size="15" name="driver" /></td> 

  </tr>
  <tr style="height:20px"></tr>
  <tr style="height:20px"></tr>
    <tr>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select name="freighttype" id="freighttype" onchange="calnet('dcreate')">
	   <option value="">--Select--</option>
	    <option value="Exclude">Exclude</option>
	    <option value="Include">Include</option>
		<option value="Include Paid By Customer">Include Paid By Customer</option>
	 	   </select></td>

       <td align="right" style="width:150px"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><input type="text" size="8" name="cfamount" id="cfamount" onkeypress="return num1(event.keyCode)" onkeyup="calnet('dcreate')" value="0" style="text-align:right"  onblur="calnet('dcreate')" />
	   &nbsp;&nbsp;</td>
	   
	   <td id="coavisible" style="visibility:visible">
	   <select id="coa" name="coa" style="width:80px" >
	   <option value="">-Select-</option>
	   <?php 
	   	for($i=0;$i<count($coacode);$i++)
			{ $coacode1=explode("@",$coacode[$i]);
				
	   ?>
	   <option title="<?php echo $coacode1[1]; ?>" value="<?php echo $coacode1[0]; ?>"><?php echo $coacode1[0]; ?></option>
	   <?php } ?>
	   </select>	   </td>
       <td align="right" id="vvisible" style="visibility:visible"><strong>Via</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left" id="viavisible" style="visibility:visible"><select style="Width:80px" name="cvia" id="cvia" onchange="loadcodes(this.value);"><option value="">-Select-</option><option value="Cash" id="cash">Cash</option><option value="Cheque">Cheque</option><option value="Others">Others</option></select></td>
	  <td align="right" id="cashbankcodetd1" style="display:none"><strong><span id="codespan">Code</span></strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="cashbankcodetd2" style="display:none">
		<select name="cashbankcode" id="cashbankcode" style="width:125px">
		<option value="">-Select-</option>
		</select>		</td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td></td><td></td><td></td>
	  <td align="right" id="chequetd1" style="visibility:hidden"><strong>Cheque</strong>&nbsp;&nbsp;&nbsp;</td>
        <td align="left" id="chequetd2" style="visibility:hidden">
		<input type="text" name="cheque" id="cheque" size="12"></td>

       <td align="right" id="datedtd1" style="display:none"><strong>Dated</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left" id="datedtd2" style="display:none"><input type="text" size="15" id="cdate" class="datepicker" readonly="readonly" name="cdate" value="<?php echo date("d.m.Y"); ?>" /></td>
</tr>
  

  <tr style="height:20px"></tr>
<tr>
	  <td align="right"><strong>&nbsp;Grand&nbsp;Total</strong>&nbsp;&nbsp;</td>
        <td align="left"><input type="text" size="12" name="tpayment" id="tpayment" value="0.00" readonly style="text-align:left; background:none; border:0px;"/></td>
</tr>
</table>	

<br />

<table align="center">  
<tr>
 <td align="center"><strong>Pay. Mode</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td><td width="10px"></td>
 <td align="center"><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td><td width="10px"></td>
 <td align="center"><strong>COA Code</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Description</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Dr</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Amount</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>  <td width="10px"></td>
 <td align="center"><strong>Cheque</strong></td>  <td width="10px"></td>
 <td align="center"><strong>Cheque Date</strong></td>  
</tr>
 <tr style="height:20px"></tr>
<tr>
  <td><select id="paymentmode1" name="paymentmode1"  onchange="cashcheque1(this.value);">
    <option value="">-Select-</option>
    <option value="Cash" selected="selected">Cash</option>
    <option value="Cheque">Cheque</option>
    <option value="Others">Others</option>
  </select></td>
  <td width="10px"></td>
<td>
<select id="pcode1" name="pcode1" onchange="loadcodedesc1(this.value)" style="width:120px">
<option value="select">-Select-</option>
<?php
	$i = 0;
	$code1 = $desc = "";

 ?>
 <?php 
 for($j=0;$j<count($cashcode);$j++)
	{
	   $ccode=explode('@',$cashcode[$j]);
	 if($i == 0)
	 {
		 for($r=0;$r<count($rcode);$r++)
		{
		 $rcode1=explode('@',$rcode[$r]);
		 if($rcode1[0]==$ccode[0])
		 {
		   $code1=$rcode1[2];
		    for($c=0;$c<count($cocode);$c++)
			{
			  $cocode2=explode('@',$cocode[$c]);
			  if($cocode2[0]==$code1)
		      $desc = $cocode2[1];	
		     }
		  }
		  
		}
	 }?>
	<option value="<?php echo $ccode[0]; ?>" title="<?php echo $ccode[1]; ?>" <?php if($i == 0) { ?> selected="selected" <?php } ?>><?php echo $ccode[0]; ?></option>
	<?php
	$i++;
	} 
	
 ?> 
 
 
</select>  </td><td width="10px"></td>
<td><input type="text" id="code11" size="6" name="code11" value="<?php echo $code1; ?>" readonly /></td><td width="10px"></td>
<td><input type="text" id="pdescription1" size="18" name="pdescription1" value="<?php echo $desc; ?>" readonly /></td><td width="10px"></td>
<td><input type="text" id="dr" name="dr" size="4" value="Dr" readonly style="background:none; border:0px;" /></td><td width="10px"></td>
<td><input type="text" id="pamount1" name="pamount1" size="10" value="0" style="text-align:right"/></td><td width="10px"></td>
<td><input type="text" id="cheque1" name="cheque1" size="10" style="visibility:hidden" /></td><td width="10px"></td>
<td><input type="text" id="cdate1" name="cdate1" size="10" class="datepicker" style="visibility:hidden" value="<?php echo date("d.m.Y");?>"/></td>
</tr> 
 <tr height="20px"></tr>
</table>
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
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=oc_cashsales_ims';">
</center>


						
</form>
</div>
</section>
</center>
		<br /><br />

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


function num1(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}



function loadcodes(via)
{
document.getElementById('cashbankcode').options.length=1;
var code = document.getElementById('cashbankcode');

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

		var op1=new Option(cashcode2[0],cashcode2[0]);
		op1.title=cashcode2[1];
		code.options.add(op1);
		
		
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
		
		var op1=new Option(acno1[0],acno1[2]);
		op1.title=acno1[1];
		code.options.add(op1);
		
	}
}
}

var index = -1;
 

function selectdesc(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("description@" + tempindex).value = document.getElementById("code@" + tempindex).value;
     var w = document.getElementById("description@" + tempindex).selectedIndex; 
     var description = document.getElementById("description@" + tempindex).options[w].text;
     //document.getElementById("description@" + tempindex).value = description;
	var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];  
	
	for(i=-1;i<=index;i++)
for(j=-1;j<=index;j++)
 {
 
 if((document.getElementById('code@' + i).value==document.getElementById('code@' + j).value)&&(i!=j))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('description@' + tempindex).value="";
 return false;
 
 }
 }
	
	
}

function selectcode(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("code@" + tempindex).value = document.getElementById("description@" + tempindex).value;
     var w = document.getElementById("description@" + tempindex).selectedIndex; 
     var description = document.getElementById("description@" + tempindex).options[w].text;
    // document.getElementById("description@" + tempindex).value = description;

   var temp = document.getElementById("code@" + tempindex).value;
	var temp1 = temp.split("@");
	document.getElementById('units@' + tempindex).value = temp1[2];
	
	for(i=-1;i<=index;i++)
for(j=-1;j<=index;j++)
 {
 
 if((document.getElementById('description@' + i).value==document.getElementById('description@' + j).value)&&(i!=j))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('description@' + tempindex).value="";
 return false;
 
 }
 }

}




function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;

	
	
removeAllOptions(document.getElementById("code@" + index1));
	removeAllOptions(document.getElementById("description@" + index1));	 


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
document.getElementById("description@" + index1).options.add(op2);
document.getElementById("code@" + index1).options.add(op1);
}
 
}
}
			

}

function cashcheque1(a)
{


document.getElementById('code11').value = "";
document.getElementById('pdescription1').value = "";
document.getElementById('cheque1').value="";
document.getElementById('pcode1').options.length=1;
document.getElementById('cheque1').style.visibility="hidden";
document.getElementById('cdate1').style.visibility="hidden";
var code = document.getElementById('pcode1');



if(a == "Cash")
{

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
else if(a == "Cheque")
{
document.getElementById('cheque1').style.visibility="visible";
document.getElementById('cdate1').style.visibility="visible";

for(var k=0;k<acno.length;k++)
	{
		var accno=acno[k];
		var acno1=accno.split('@');
		theOption1=document.createElement("OPTION");
		theText1=document.createTextNode(acno1[0]);
		theOption1.value = acno1[0];
		theOption1.title =acno1[1];
		theOption1.appendChild(theText1);
		code.appendChild(theOption1);
	}
}
}


function loadcodedesc1(a)
{
 
var mode = document.getElementById('paymentmode1').value;
document.getElementById('code11').value = "";
document.getElementById('pdescription1').value = "";
if(a== "")
return;

 
for(var i=0;i<rcode.length;i++)
{
  var rcode2=rcode[i];
  rcode1=rcode2.split('@');
  if(mode=="Cash")
  {
    if(a==rcode1[0])
	{
	  document.getElementById('code11').value =rcode1[2];
	 }
  }
  else if(mode=='Cheque')
  {
    if(a==rcode1[1])
	{
	  document.getElementById('code11').value =rcode1[2];
	 }
  }
  
 } 
 


for(var d=0;d<cocode.length;d++)
{
   var cocode2=cocode[d];
   coa=cocode2.split('@');
   if(document.getElementById('code11').value == coa[0]) 
   {
   document.getElementById('pdescription1').value = coa[1];
   }
     
}



}


function num(a,b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length;i>0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function makeForm(id) 
{


var id=id.substr(6,id.length);


for(k=-1;k<=index;k++)
{

	if(k==-1)
	{
	
	var type= document.getElementById("cat@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qtys=document.getElementById("qtys@"+k).value;

	
	if(type=="" || code=="" || Number(qtys)==0)
	{
		return false;
	
	
	}

	
	}
else if(k<index)
{
	
	var type= document.getElementById("cat@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qtys=document.getElementById("qtys@"+k).value;
	var rate= document.getElementById("price@"+k).value;
	if(type=="" || code=="" || Number(qtys)==0  || Number(rate)==0)
	{
		return false;
	
	
	}
	

	 }
  }
if(id!=index)
return false;



if(document.getElementById('qtys@'+ index).value != '')
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


var etd12 = document.createElement('td');
etd12.width = "10px";
theText1=document.createTextNode('\u00a0');
etd12.appendChild(theText1);



var t  = document.getElementById('table-po');

var r  = document.createElement('tr');
r.setAttribute ("align","center");

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "100px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { getcode(this.id); };

  for(i=0;i<items.length;i++)
{

 var theOption=new Option(items[i].cat,items[i].cat);
		
		
myselect1.options.add(theOption);

}


var type = document.createElement('td');
type.appendChild(myselect1);

myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
myselect1.onchange = function () { selectdesc(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);


// for description start

myselect1 = document.createElement("select");
myselect1.name = "description[]";
myselect1.id = "description@" + index;
myselect1.style.width = "170px";
 var op1=new Option("-Select-","");
myselect1.options.add(op1);myselect1.onchange = function () { selectcode(this.id); };

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
mybox1.style.background="none";
mybox1.style.border="0px";

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
mybox1.onkeypress=function(){return num(this.id,event.keyCode);};


mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="price@" + index;
mybox1.name="price[]";
mybox1.style.textAlign = "right";

mybox1.onfocus = function () { makeForm(this.id); };
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var price = document.createElement('td');
price.appendChild(mybox1);




myselect2 = document.createElement("select");
myselect2.id="vat@" + index;
myselect2.name = "vat[]";
myselect2.onchange = function () { calnet(''); };


myselect2.style.width = "60px";

theOption2=document.createElement("OPTION");
theText2=document.createTextNode("None");
theOption2.appendChild(theText2);
theOption2.value = "0@0@0@0";
myselect2.appendChild(theOption2);

for(var j=0;j<taxs.length;j++)
{
tax1=taxs[j].split("@");
		   taxs1=tax1[0]+"@"+tax1[2]+"@"+tax1[3]+"@"+tax1[4];
	 
		  var theOption=new Option(tax1[0],taxs1);
			theOption.title = tax1[1];
			myselect2.options.add(theOption);
		  
}		  
  
 

var vat = document.createElement('td');

vat.appendChild(myselect2);




input = document.createElement("input");
input.type = "hidden";
input.id = "taxamount@" + index;
input.value=0;
input.name = "taxamount[]";



  var td12 = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.id="disc@" + index;
mybox1.name="disc[]";
mybox1.style.textAlign = "right";
mybox1.value=0;
mybox1.onchange = function () { calnet(''); };

mybox1.onkeyup = function () {return num1(event.keyCode);  };
mybox1.onblur = function () { calnet(''); };

td12.appendChild(mybox1);

  
  

  input1 = document.createElement('input');
  input1.type = "hidden";
  input1.id = "discountamount@"+index;
  input1.name="discountamount[]";
  input1.value = "0";


///////////eighth td///







	   
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

	 
	  r.appendChild(price);
	  
	  r.appendChild(etd7);
	  
	 r.appendChild(vat);
      r.appendChild(etd9); 
	  
	  r.appendChild(td12);
      r.appendChild(etd12); 
	 
	 
	  r.appendChild(input);
	   r.appendChild(input1);
      t.appendChild(r);
}



}




function calnet(a)
{

 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;
 var btotal=0;
 var total=0; 
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
  var tot2 = 0; var qty112 = 0; var price112 = 0; var temp112 = 0;
 for(k = -1;k < index;k++)
 {
 	
 	 var tot=0;
 
  	var vat=0;
  	
 var vat = document.getElementById("vat@" + k).value;
var discount = Number(document.getElementById("disc@" + k).value);
 
	
  if(document.getElementById("qtys@" + k).value != "" || document.getElementById("price@" + k).value != "")
   tot1= tot1+ (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);

   total= total+ (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);

 
  	 if(vat != '0' && vat != "")
{



 
   var a1 = document.getElementById("vat@" + k).value;
       //alert(a1);
      a1 = a1.split('@');
       var tax=0;

       var mode = a1[2];
	   var taxval=a1[1];
	  
	   var rule=a1[3];
	   var A=0;
       var A =(document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);

	   
	   if(mode=="Percent" &&rule=="Exclude" )
	   {
	   
	var tot=Number((A*taxval)/100);
	    withtax=Number(A)+Number((A*taxval)/100);
		tax=tot;
	   
	   }
	   else  if(rule=="Exclude"&&mode=="Flat" )
	   {
	 
	 
	   withtax =Number(A)+Number(taxval);
	   var tot=Number(taxval);
	   tax=tot;
	   }
	  else
	  if(rule=="Include")
	  {
		 if(mode=="Percent")
		   {
		   
			taxa=((Number(A)*100)/(100+Number(taxval)));
			tax7=Number(A)-Number(taxa);
		   withtax=Number(A);
		   tot=0;
		  
		   
		   tax=tax7;
		 
		   }
		   else
		   {
		tot=0;
			withtax=Number(A);
			tax=Number(taxval);
		   }
	  
	  } 
	  


 

}

 document.getElementById('taxamount@' + k).value=tax;

 tot1 = tot1 + tot;

 disc=0;

btotal=total+tot;

  if(discount != '0' && discount != "")
{


  disc=discount;
	
	  

} 
  document.getElementById('discountamount@' + k).value=disc;
  tot1 = tot1 -disc;


 var tot2=tot1;



 }
 
 	
 tot=tot2;

 document.getElementById('basic').value = round_decimals(btotal,2);
 

document.getElementById('totalprice').value = round_decimals(tot1,2);



if(document.getElementById("cfamount").value=="")
document.getElementById("cfamount").value=0;



if(document.getElementById("freighttype").value == "Include")
{
document.getElementById("coavisible").style.visibility="visible";

document.getElementById("viavisible").style.visibility="visible";

document.getElementById("vvisible").style.visibility="visible";

document.getElementById('cashbankcodetd1').style.display = "inline";

document.getElementById('cashbankcodetd2').style.display = "inline";

  var freight = parseFloat(document.getElementById("cfamount").value);
  
}
if(document.getElementById("freighttype").value == "Exclude")
{document.getElementById("coavisible").style.visibility="hidden";

document.getElementById("viavisible").style.visibility="visible";

document.getElementById("vvisible").style.visibility="visible";

document.getElementById('cashbankcodetd1').style.display = "inline";

document.getElementById('cashbankcodetd2').style.display = "inline";

document.getElementById('coa').value = "";
  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 + freight;
}
if(document.getElementById("freighttype").value == "Include Paid By Customer")
{document.getElementById("coavisible").style.visibility="visible";

document.getElementById("viavisible").style.visibility="hidden";

document.getElementById("vvisible").style.visibility="hidden";

document.getElementById('cashbankcodetd1').style.display = "none";

document.getElementById('cashbankcodetd2').style.display = "none";

document.getElementById('cashbankcode').value = "";

document.getElementById('cvia').value = "";

  var freight = parseFloat(document.getElementById("cfamount").value);
  tot1 = tot1 - freight;
}





document.getElementById("tpayment").value = round_decimals(tot1,2);

}


function checkcoa()
{

<?php if($_SESSION['db']=="mew")
	{?>	
var memp=document.getElementById('memp').value;

if(memp=="")
{
	alert("Select Marketing Employee");
	return false;

}
<?php } ?>


var bookinvoice=document.getElementById('bookinvoice').value;

if(bookinvoice=="")
{
	alert("Enter book invoice");
	return false;

}


<?php
	$query="SELECT distinct(`bookinvoice`) FROM `oc_cobi`";
	$result=mysql_query($query,$conn) or die(mysql_error());
	while($row=mysql_fetch_array($result))
	{


?>
	
	if(bookinvoice=="<?php echo $row['bookinvoice'];?>")
	{
	
		alert("Book invoice already exists");
		return false;
	
	}
	<?php } ?>




var memp=document.getElementById('memp').value;

if(memp=="")
{
	alert("Select Marketing Employee");
	return false;

}





if(document.getElementById('cfamount').value=="")
document.getElementById('cfamount').value=0;


	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0"  &&  document.getElementById('freighttype').value!="" )
	{
		
		if(document.getElementById('freighttype').value != "Exclude")
		{
		
		if(document.getElementById('coa').selectedIndex == 0)
		{
			alert("Please select Chart of Account");
			document.getElementById('coa').focus();
			return false;
		}	
		
		
		}	
		if(document.getElementById('freighttype').value != "Include Paid By Customer")
		{
		
		
		 if (document.getElementById('cvia').selectedIndex == 0)
		{
		   alert("Please select Mode");
			document.getElementById('cvia').focus();
			return false;
		}	
		 if (document.getElementById('cashbankcode').selectedIndex == 0)
		{
		   alert("Please select Payment Code");
			document.getElementById('cashbankcode').focus();
			return false;
		}	
		
		}
	}
	
	




var a=Number(document.getElementById('pamount1').value);

if(a==0)
{

alert("Please enter the amount");
			document.getElementById('pamount1').focus();
			return false;


}

var b=Number(document.getElementById('tpayment').value);

if(a!=b)
		{
		   alert("Please enter the appropriate amount");
			document.getElementById('pamount1').focus();
			return false;
		}	
document.getElementById('save').disabled=true;


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
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

