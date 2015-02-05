<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";
$client = $_SESSION['client'];

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
$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;

$q1=mysql_query("SET group_concat_max_len=10000000");
$i=0;

//------------------Vendor Name & Code-----------------------
$q1=mysql_query("SET group_concat_max_len=10000000");
$query="select group_concat(distinct(name) order by name) as name from contactdetails where type = 'vendor' OR type = 'vendor and party' order by name";
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



 //---------------------------Sectors--------------------
 
if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
	$q1 = "SELECT group_concat(distinct(sector) order by sector) as sector FROM tbl_sector WHERE type1='Warehouse' ";
	
}
else
{
	$sectorlist = $_SESSION['sectorlist'];
	$q1 = "SELECT group_concat(distinct(sector) order by sector) as sector FROM tbl_sector WHERE (type1='Warehouse') and sector In ($sectorlist)";
	
}
$result=mysql_query($q1,$conn);
while($rows=mysql_fetch_assoc($result))
{ 
$sect=explode(",",$rows['sector']);	
}
$sects=json_encode($sect);
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

	   		$q = "select group_concat(distinct(code),'@',description) as code  from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSE' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
				$coacode=explode(",",$qr["code"]);
			}

$coacode1=json_encode($coacode);



?>
<script type="text/javascript">
var vname=<?php if(empty($vname)){echo 0;} else{ echo $vname; }?>;
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;
var sect=<?php if(empty($sects)){echo 0;} else{ echo $sects;}?>;
var cashcode=<?php if(empty($cashcodes1)){ echo 0;} else{ echo $cashcodes1;}?>;
var acno=<?php if(empty($acno1)){echo 0;} else{ echo $acno1;}?>;
var coacode=<?php if(empty($coacode1)){echo 0;} else{ echo $coacode1;}?>;
</script>
<center>
<section class="grid_8">
  <div class="block-border">
  								
						
								
								
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savedirectpurchase.php" onsubmit="return checkcoa();">
		<input type="hidden" name="sobiincr" id="sobiincr" value="<?php echo $sobiincr; ?>"/>
		<input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
		<input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
		


<br />

<h1>Direct Purchase</h1>
<br />


<b>Direct Purchase</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br />
<br />
<br />


		
            <table align="center">
              <tr>
             
                <td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" readonly="readonly" onchange="getsobi();"></td>
                <td width="5px"></td>

                <td><strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
					<select id="vendor"   name="vendor" style="width:175px" >
					<option>-Select-</option>
					
							<?php
					for($i=0;$i<count($name);$i++)
							{ 
					?>
					<option title="<?php echo $name[$i];?>" value="<?php echo $name[$i];?>"><?php echo $name[$i]; ?></option>
					<?php   }   ?>
					

					</select>
				</td>
                <td width="5px"></td>

                <td><strong>Invoice</strong></td>
                <td width="15px"></td>
                <td>&nbsp;<input type="text" size="19" style="background:none;border:none;" id="invoice" name="invoice" value="<?php echo $sobi; ?>" readonly /></td>
				
				<td width="5px"></td>
				
                <td><strong>Book&nbsp;Invoice</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td width="5px"></td>
                <td>&nbsp;
					<input type="text" size="12" id="bookinvoice" name="bookinvoice" value="" onkeypress="return num(event.keyCode)"></td>
                <td width="5px"></td>
                
				
              </tr>
            </table>
<br /><br />			

<center>
 <table border="0" id="table-po">
     <tr>
<th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Units</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Qty Sent</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Qty Received</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th><strong>Price<br />/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

<th >&nbsp;&nbsp;&nbsp;<strong>Tax</strong></th><td  width="10px">&nbsp;</td>

<th >&nbsp;&nbsp;&nbsp;<strong>Discount</strong></th><td  width="10px">&nbsp;</td>
<th>&nbsp;&nbsp;&nbsp;<strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
     </tr>

     <tr style="height:10px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:100px" name="cat[]" id="cat@-1" onchange="getcode(this.id);">
     <option>-Select-</option>
<?php
for($i=0;$i<count($items);$i++)
{
?>
<option value="<?php echo $items[$i]["cat"]; ?>"><?php echo $items[$i]["cat"]; ?></option>
<?php } ?>
</select>       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<select style="Width:75px" name="code[]" id="code@-1" onchange="selectdesc(this.id);">
     		<option value="">-Select-</option>
			</select>       </td>
<td width="10px">&nbsp;</td><td>
<select style="Width:140px" name="desc[]" id="desc@-1" onchange="selectcode(this.id);">
     		<option>-Select-</option>
</select>
<input type="hidden" size="15" id="description@-1" name="description[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="8" id="units@-1" name="units[]" value="" readonly style="background:none; border:0px;"/>
</td>
<td width="10px">&nbsp;</td><td><input type="text" size="7" style="text-align:right;" id="qtys@-1" name="qtys[]" value="0" onkeypress="return num1(this.id,event.keyCode)" onkeyup="decimalrestrict(this.id,this.value),calnet('');"  onblur="return checkrcvqty(this.id,this.value),calnet('');" /></td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="7" id="qtyr@-1" style="text-align:right;" name="qtyr[]" value="0" onkeyup="decimalrestrict(this.id,this.value),checkqty(this.id,this.value),calnet('');" onblur="calnet('');" onkeypress="return num1(this.id,event.keyCode)"  />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" size="6" id="price@-1" style="text-align:right;" name="price[]" value="0" onfocus="makeForm(this.id);"   onkeyup="decimalrestrict(this.id,this.value),calnet('');" onblur="calnet('');" onkeypress="return num1(event.keyCode)"/>
</td>


<td width="10px">&nbsp;</td><td >
<select style="width:60px" name="vat[]" id="vat@-1" onchange="calnet('');">
     <option value="0@0@0@0">None</option>
     <?php 
	     $query = "SELECT * FROM ims_taxcodes where  (taxflag = 'P' ) ORDER BY code DESC ";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <option title="<?php echo $row['description']; ?>" value="<?php echo $row['code']."@".$row['codevalue']."@".$row['mode']."@".$row['rule']; ?>"><?php echo $row['code']; ?></option>
     <?php } ?>
</select>

</td>
 <td  width="10px">&nbsp;</td><td> 
 <input type="text" name="disc[]"  id="disc@-1" value="0" size="8"  style="text-align:right;" onkeypress="return num1(this.id,event.keyCode);" onchange="calnet('');">


</td>
 <td  width="10px">&nbsp;</td><td> 
<select id="flock@-1" name="flock[]" style="width:120px" >
<option value="">-Select-</option>



							<?php
					for($i=0;$i<count($sect);$i++)
							{ 
					?>
					<option title="<?php echo $sect[$i];?>" value="<?php echo $sect[$i];?>"><?php echo $sect[$i]; ?></option>
					<?php   }   ?>
					

</select>
<input type="hidden" id="taxamount@-1" name="taxamount[]" value="0" />
    <input type="hidden" name="discountamount[]" id="discountamount@-1" value="0" />
</td>
    </tr>
   </table>
  
 </center>
		

<center>
<table border="1">
   <tr style="height:20px"></tr>

   <tr>
      <td align="right"><strong>Basic&nbsp;Amount</strong>&nbsp;&nbsp;</td>
      <td align="left"><input type="text" size="12" id="basic" name="basic" value="0.00" style="text-align:right; background:none; border:0px;" readonly  /></td>
        <td></td><td></td><td></td><td></td
      ><td align="right" ><strong>Vehicle No.&nbsp;&nbsp;&nbsp;</strong></td>
      <td align="left"><input type="text" size="15" name="vno" /></td>
 </tr>
  <tr style="height:20px"></tr>
  <tr>
   <td align="right"><strong>Total&nbsp;Amount</strong>&nbsp;&nbsp;</td>
   <td align="left"><input type="text" size="12" name="totalprice" id="totalprice" style="text-align:right;background:none; border:0px;" value="0.00" readonly/></td>
   <td></td><td></td><td></td><td></td>
   <td align="right"><strong>Driver&nbsp;Name &nbsp;&nbsp;</strong></td>
   <td align="left"><input type="text" size="15" name="driver" onkeypress="return checkname(this.id,event.keyCode)" /></td>
  </tr>
  <tr style="height:20px"></tr>
  <tr style="height:20px"></tr>
   <tr>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><select name="freighttype" id="freighttype" onchange="calnet('dcreate')">
	   <option value="">--Select--</option>
	   <option value="Included">Included</option>
	   <option value="Excluded">Excluded</option>
	   <option value="Excludepaidbysupplier">Excluded Paid By supplier</option>
	   </select></td>

       <td align="right" style="width:150px"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><input type="text" size="8" name="cfamount" id="cfamount" onkeyup="calnet('dcreate'),checkcfamount(this.value)" value="0" style="text-align:right" onkeypress="return num1(event.keyCode)" onblur="checkcfamount(this.value)" />
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
        <td align="left"><input type="text" size="12" name="tpayment" id="tpayment" value="0.00" readonly style="text-align:right; background:none; border:0px;"/></td>
</tr>
</table>
<br>	
<center>	
<br />
<table>

<tr>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</tr>
</table>
</center>
<br />

   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_directpurchase';">
</center>
</form>

</div>
</section>
</center>
<br />


<script type="text/javascript">
function decimalrestrict(a,b)
{
var a1=b.split(".");
var a2=a1[1];
if(a1.length>1)
if(a2.length>5)
{
var b2=a2.length-5;
document.getElementById(a).value=b.substr(0,b.length-b2);
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
var index = -1;

function checkcfamount(b)
{
if(b=="")
document.getElementById('cfamount').value=0;
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
     sobi = 'SOBI'+'-'+m+y+'-000'+parseInt(sobiincr[l]+1)+code;
   else if(sobiincr[l] < 100 && sobiincr[l] >= 10)
     sobi = 'SOBI'+'-'+m+y+'-00'+parseInt(sobiincr[l]+1)+code;
   else
     sobi = 'SOBI'+'-'+m+y+'-0'+parseInt(sobiincr[l]+1)+code;
     document.getElementById('sobiincr').value = parseInt(sobiincr[l] + 1);
  break;
  }
 else
  {
   sobi = 'SOBI' + '-' + m + y + '-000' + parseInt(1)+code;
   document.getElementById('sobiincr').value = 1;
  }
}
document.getElementById('invoice').value = sobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;
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

function selectdesc(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
	 
	 
	 	 
	      var code1 = document.getElementById("code@" + tempindex).value;
		 if(code1=="")
		 {
		 document.getElementById('units@' + tempindex).value="";
		  document.getElementById('desc@' + tempindex).value="";
 		  document.getElementById('code@' + tempindex).value="";
		  return false;
		 
		 }
	 

 
 for(j=-1;j<=index;j++)
 {
 
 if((document.getElementById('code@' + tempindex).value==document.getElementById('code@' + j).value)&&(tempindex!=j) &&(document.getElementById('code@' + tempindex).value!=""))
 {
 alert("Select different combination");
 document.getElementById('code@' + tempindex).value="";
  document.getElementById('desc@' + tempindex).value="";
 return false;
 
 }
 }

	 
     document.getElementById("desc@" + tempindex).value = document.getElementById("code@" + tempindex).value;
 var t = code1.split("@");
	 document.getElementById('units@' + tempindex).value = t[2];
	

}
function selectcode(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
	 
	 
	 	 
	      var code1 = document.getElementById("desc@" + tempindex).value;
		 if(code1=="")
		 {
		 document.getElementById('units@' + tempindex).value="";
		  document.getElementById('desc@' + tempindex).value="";
 		  document.getElementById('code@' + tempindex).value="";
		  return false;
		 
		 }
	 
	
	 
	  for(j=-1;j<=index;j++)
 {
 
 if((document.getElementById('desc@' + tempindex).value==document.getElementById('desc@' + j).value)&&(tempindex!=j) &&(document.getElementById('desc@' + tempindex).value!=""))
 {
 alert("Select different combination");
 document.getElementById('desc@' + tempindex).value="";
  document.getElementById('code@' + tempindex).value="";
 return false;
 
 }
 }
 
	 
	 
     document.getElementById("code@" + tempindex).value = document.getElementById("desc@" + tempindex).value;
     
	 var t = code1.split("@");
	 document.getElementById('units@' + tempindex).value = t[2];
	

}



function getcode(cat)
{
	
	
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;
	
	
	document.getElementById('flock@' + index1).options.length=1;;
	
	for(var m=0;m<sect.length;m++)
		{
			var sec1=sect[m];
			var sec=sec1.split('@');
			var opt= new Option(sec[0],sec[0]);
			opt.title=sec[1];
			document.getElementById('flock@' + index1).options.add(opt);
		}



	document.getElementById("code@" + index1).options.length=1;
	document.getElementById("desc@" + index1).options.length=1; 
	
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


function num1(a,b)
{

if((b<48 || b>57)&&(b!=46))
{
event.keyCode=false;
return false;
}


}
function checkname(a,b)
{

if((b<65 || b>90) &&(b<97 || b>122))
{
event.keyCode=false;
return false;
}


}

function checkqty(a,b)
{

var index1=a.substr(5,a.length);

var qtys=document.getElementById("qtys@"+index1).value;

var qtyr=document.getElementById("qtyr@"+index1).value;

if(Number(qtyr)>Number(qtys))
{
document.getElementById(a).value="";
return false;

}
}




function makeForm(id) 
{

var id=id.substr(6,id.length);
//alert(id);
//alert(index);

for(k=-1;k<=index;k++)
{

	if(k==-1)
	{
	
	var type= document.getElementById("cat@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qtys=document.getElementById("qtys@"+k).value;
	var qtyr=document.getElementById("qtyr@"+k).value;
	
	if(type=="" || code=="" || Number(qtys)==0 || Number(qtyr)==0)
	{
		return false;
	
	
	}

	
	}
else if(k<index)
{
	
	var type= document.getElementById("cat@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qtys=document.getElementById("qtys@"+k).value;
	var qtyr=document.getElementById("qtyr@"+k).value;
	var rate= document.getElementById("price@"+k).value;
	if(type=="" || code=="" || Number(qtys)==0 || Number(qtyr)==0 || Number(rate)==0)
	{
		return false;
	
	
	}
	

	 }
  }
if(id!=index)
return false;

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

var etd10 = document.createElement('td');
etd10.width = "10px";
theText1=document.createTextNode('\u00a0');
etd10.appendChild(theText1);

var etd12 = document.createElement('td');
etd12.width = "10px";
theText1=document.createTextNode('\u00a0');
etd12.appendChild(theText1);

var etd16 = document.createElement('td');
etd16.width = "10px";
theText1=document.createTextNode('\u00a0');
etd16.appendChild(theText1);


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
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
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
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectdesc(this.id); };
var code = document.createElement('td');
code.appendChild(myselect1);




myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "140px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
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
mybox1.value=0;
mybox1.onkeypress=function(){return num1(this.id,event.keyCode)};
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur=function(){return checkrcvqty(this.id,this.value),calnet('');};
var qst = document.createElement('td');
qst.appendChild(mybox1);


mybox1=document.createElement("input");
mybox1.size="7";
mybox1.type="text";
mybox1.id="qtyr@" + index;
mybox1.name="qtyr[]";
mybox1.style.textAlign = "right";
mybox1.value=0;
mybox1.onkeypress=function(){return num1(this.id,event.keyCode)};

mybox1.onkeyup = function () {checkqty(this.id,this.value); calnet(''); };
mybox1.onblur = function () { calnet(''); };
var qrs = document.createElement('td');
qrs.appendChild(mybox1);






////////// Sixth TD ////////////


mybox1=document.createElement("input");
mybox1.size="6";
mybox1.type="text";
mybox1.id="price@" + index;
mybox1.name="price[]";
mybox1.value=0;
mybox1.style.textAlign = "right";
mybox1.onkeypress=function(){return num1(event.keyCode)};
mybox1.onfocus = function () { makeForm(this.id); };
mybox1.onkeyup = function () { calnet(''); };
mybox1.onblur = function () { calnet(''); };
var price = document.createElement('td');
price.appendChild(mybox1);



////////// Seventh TD ////////////

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

<?php include "config.php";
                       include "config.php"; 
                       $query = "SELECT * FROM ims_taxcodes where (taxflag = 'P') ORDER BY codevalue ASC";
                       $result = mysql_query($query,$conn); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule']; ?>";
myselect2.appendChild(theOption1);
<?php } ?>

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

mybox1.onkeyup = function () {return num1(this.id,event.keyCode);  };
mybox1.onblur = function () { calnet(''); };

td12.appendChild(mybox1);




  
  

  input1 = document.createElement('input');
  input1.type = "hidden";
  input1.id = "discountamount@"+index;
  input1.name="discountamount[]";
  input1.value = "0";





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


          
            for(j=0;j<sect.length;j++)
		   {
		 
		   
		   	var theOption=new Option(sect[j],sect[j]);
			myselect1.options.add(theOption);
		
} 





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


	  r.appendChild(price);
	  r.appendChild(etd7);
  
	  r.appendChild(vat);
      r.appendChild(etd9); 
	  
	  r.appendChild(td12);
      r.appendChild(etd12); 
	  
	  r.appendChild(flock);
	  r.appendChild(etd10);
	  //r.appendChild(dlocation); 
	  r.appendChild(input);
	   r.appendChild(input1);
      t.appendChild(r);
	  

 
}



function checkrcvqty(a,b)
{

var index1=a.substr(5,a.length);

var qtys=document.getElementById("qtys@"+index1).value;

var qtyr=document.getElementById("qtyr@"+index1).value;
if(Number(qtyr)>Number(qtys))
document.getElementById("qtyr@"+index1).value=0;



}
function calnet(a)
{

 var tot = 0; 
 var tot1 = 0; 
 var tpayment = 0;
 var withtax=0;
 var tax7=0;
 var total=0;
 document.getElementById('basic').value = 0;
 document.getElementById('totalprice').value = 0;
  var tot2 = 0; var qty112 = 0; var price112 = 0; var temp112 = 0;
  if(index==-1)
  var index1=index+1;
  else
  index1=index;

 for(k = -1;(k < index1);k++)
 {

 tot = 0;
  var vat = document.getElementById("vat@" + k).value;
var discount = Number(document.getElementById("disc@" + k).value);
 
  if(document.getElementById("qtys@" + k).value != "" && document.getElementById("price@" + k).value != "")
  tot1= tot1+ (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);

   total= total+ (document.getElementById("qtys@" + k).value * document.getElementById("price@" + k).value);

var  tax=0;
  
  if(vat != '0' && vat != "")
{ 
   var a1 = document.getElementById("vat@" + k).value;
       //alert(a1);
      a1 = a1.split('@');
       <?php
             
           $query = "SELECT * FROM ims_taxcodes where type='Tax' and (taxflag = 'P' or taxflag='A') ORDER BY code DESC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
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
  document.getElementById('taxamount@' + k).value=round_decimals(tax,2);

 tot1 = tot1 + tot;
 total=total+tot;

 disc=0;
 
if(discount != '0' && discount != "")
{
disc=discount;

} 
  document.getElementById('discountamount@' + k).value=round_decimals(disc,2);
  tot1 = tot1 -disc;


 var tot2=tot1;
 }
  
   tot = tot2;
 document.getElementById('basic').value = round_decimals(total,2);
 

 
document.getElementById('totalprice').value = round_decimals(tot1,2);
if(document.getElementById("cfamount").value=="")
document.getElementById("cfamount").value=0;

if(document.getElementById("freighttype").value == "Included")
{
document.getElementById("coavisible").style.visibility="hidden";

document.getElementById("viavisible").style.visibility="visible";

document.getElementById("vvisible").style.visibility="visible";

document.getElementById('cashbankcodetd1').style.display = "inline";

document.getElementById('cashbankcodetd2').style.display = "inline";

document.getElementById('coa').value = "";

  var freight = parseFloat(document.getElementById("cfamount").value);
 
  tot1 = tot1 - freight;
}

if(document.getElementById("freighttype").value == "Excluded")
{

document.getElementById("coavisible").style.visibility="visible";

document.getElementById("viavisible").style.visibility="visible";

document.getElementById("vvisible").style.visibility="visible";

document.getElementById('cashbankcodetd1').style.display = "inline";

document.getElementById('cashbankcodetd2').style.display = "inline";



  var freight = parseFloat(document.getElementById("cfamount").value);
  //tot1 = tot1 + freight;
}
if(document.getElementById("freighttype").value == "Excludepaidbysupplier")
{

document.getElementById("coavisible").style.visibility="visible";

document.getElementById("viavisible").style.visibility="hidden";

document.getElementById("vvisible").style.visibility="hidden";

document.getElementById('cashbankcodetd1').style.display = "none";

document.getElementById('cashbankcodetd2').style.display = "none";

document.getElementById('cashbankcode').value = "";

document.getElementById('cvia').value = "";


  var freight = parseFloat(document.getElementById("cfamount").value);
  
  tot1 = tot1 + freight;
}

document.getElementById("tpayment").value = round_decimals(tot1,2);



}



function checkcoa()
{
var bookinvoice=document.getElementById('bookinvoice').value;

if(bookinvoice=="")
{
	alert("Enter book invoice");
	return false;

}


<?php
	$query="SELECT distinct(`invoice`) FROM `pp_sobi`";
	
	$result=mysql_query($query,$conn) or die(mysql_error());
	
	while($row=mysql_fetch_array($result))
	{


?>
	
	if(bookinvoice=="<?php echo $row['invoice'];?>")
	{
	
		alert("Book invoice already exists");
		return false;
	
	}
	<?php } ?>
if(document.getElementById('vendor').value =="")
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
if(document.getElementById('cfamount').value=="")
document.getElementById('cfamount').value=0;


	if(document.getElementById('cfamount').value != "" && document.getElementById('cfamount').value != "0"  &&  document.getElementById('freighttype').value!="" )
	{
		
		if(document.getElementById('freighttype').value != "Included")
		{
		
		if(document.getElementById('coa').selectedIndex == 0)
		{
			alert("Please select Chart of Account");
			document.getElementById('coa').focus();
			return false;
		}	
		
		
		}	
		if(document.getElementById('freighttype').value != "Excludepaidbysupplier")
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
	
	
document.getElementById("save").disabled=true;



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
			<a href="#top" class="button"><img src="../../../Documents and Settings/Administrator/Desktop/aug5th downloads/images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

