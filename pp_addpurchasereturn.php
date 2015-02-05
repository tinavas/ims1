<?php  
include "config.php"; 
include "jquery.php";


$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(preincr) as preincr FROM pp_purchasereturn where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $preincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$preincr = $row1['preincr']; 
$preincr = $preincr + 1;
if ($preincr < 10) 
$pre = 'PRE-'.$m.$y.'-000'.$preincr; 
else if($preincr < 100 && $preincr >= 10) 
$pre = 'PRE-'.$m.$y.'-00'.$preincr; 
else $pre = 'PRE-'.$m.$y.'-0'.$preincr;


if(!isset($_GET['vendor']))
$vendor = "";
else
$vendor = $_GET['vendor'];

if(!isset($_GET['sobi']))
$sobi = "";
else
$sobi = $_GET['sobi'];
		    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 $i=0;
		if($sectorlist=="")
	
	$query="select vendor,group_concat(distinct(so)) as so from pp_sobi where flag = 1 and so not in(select distinct(sobi) from pp_purchasereturn order by sobi) group by vendor"; 
	
	else
	$query="select vendor,group_concat(distinct(so)) as so from pp_sobi where flag = 1 and so not in(select distinct(sobi) from pp_purchasereturn order by sobi) and warehouse in ($sectorlist) group by vendor"; 
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$venso[$i]=array("vendor"=>"$r[vendor]","so"=>"$r[so]");
$i++;
} 
$venso1=json_encode($venso);

	
		  
?>
<script type="text/javascript">
var venso=<?php echo $venso1;?>;

</script>

<center>
<section class="grid_8">
  <div class="block-border">
  								
				
								
								
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savepurchasereturn.php" >					
<h1>Purchase Return</h1>&nbsp;&nbsp;&nbsp;&nbsp;

<br />


<b>Purchase Return</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br />
<br />
<br />

<input type="hidden" name="preincr" id="preincr" value="<?php echo $preincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>

<table id="paraID" align="center" cellpadding="5" cellspacing="5">
<tr>
<td>&nbsp;&nbsp; <strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<input type="text" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" onchange="getpre()" size="15" class="datepicker"/>
</td>
<td width="10px"></td>
<td colspan="2"><strong>PRE</strong>&nbsp;
<input size="14" type="text"  name="pre" id="pre" value="<?php echo $pre; ?>" readonly style="border:0px;background:none" />
</td>
<td width="10px"></td>
<td  colspan="2"><strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<select name="vendor" id="vendor" onchange="loadpage();" style="width:140px">
<option value="">-Select-</option>


<?php
for($j=0;$j<count($venso);$j++)
{
?>
<option value="<?php echo $venso[$j]["vendor"]; ?>" <?php if($vendor==$venso[$j]["vendor"]){?> selected="selected" <?php }?> ><?php echo $venso[$j]["vendor"]; ?></option>
<?php } ?>

</select>
</td>

<td width="10px"></td>
<td>&nbsp;&nbsp; <strong>SOBI</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
<select name="sobi" id="sobi" style="width:140px" onchange="loadpage();">
<option value="">-Select-</option>

<?php
for($j=0;$j<count($venso);$j++)
{if($venso[$j]["vendor"]==$vendor){ 
$so=explode(",",$venso[$j]["so"]);
for($k=0;$k<count($so);$k++){
?>
<option value="<?php echo $so[$k]; ?>" <?php if($sobi==$so[$k]){?> selected="selected" <?php }?> ><?php echo $so[$k]; ?></option>
<?php } } } ?>

</select>
</td>


</tr>
</table>
<br /><br />

<?php 
  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 }

if($sectorlist=="")
$q = "select * from pp_sobi where vendor = '$vendor' and so = '$sobi'  order by code";

else
$q = "select * from pp_sobi where vendor = '$vendor' and so = '$sobi' and warehouse in ($sectorlist)  order by code";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if(mysql_num_rows($qrs) != 0)
{
 
?>
<table align="center" cellpadding="10" cellspacing="10" width="700px">
<tr align="center">
<td><strong>Item Code</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Description</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Purchased<br />Quantity</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Returned<br />Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td width="10px">&nbsp;</td>
<td><strong>Rate</td>
<td width="10px">&nbsp;</td>

<td><strong>Tax Amount</strong></td>
<td width="10px"></td>
<td><strong>Freight Amount</strong></td>
<td width="10px"></td>
<td><strong>Discount Amount</strong></td>
<td width="10px"></td>


<td><strong>Amount</strong></td>
<td width="10px">&nbsp;</td>
<td><strong>Warehouse</strong></td>
<!--<td><strong>Goods Status</strong></td>-->
</tr>
<?php } ?>
<tr height="10px"><td>&nbsp;</td></tr>
<?php 
$i = 0;
while($qr = mysql_fetch_assoc($qrs))
{
$warehouse = $qr['warehouse'];
$i++;
?>
<tr>

<td>

<input readonly size="10" type="text" style="background:none;border:none" name="code[]" id="code<?php echo $i; ?>" value="<?php echo $qr['code']; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input readonly size="10" type="text" style="background:none;border:none" name="description[]" id="description<?php echo $i; ?>" value="<?php echo $qr['description']; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input readonly size="10" type="text" style="background:none;border:none;text-align:right" name="purchasedquantity[]" id="purchasedquantity<?php echo $i; ?>" value="<?php echo $qr['receivedquantity']; ?>" />&nbsp;&nbsp;&nbsp;
</td>
<td width="10px">&nbsp;</td>
<td>

<input size="10" type="text" name="returnquantity[]" id="returnquantity<?php echo $i; ?>" value="0" onkeyup="checkquantity(<?php echo $i; ?>);" style="text-align:right"/>
</td>
<td width="10px">&nbsp;</td>

<td>
<input size="10" type="text" name="price[]" id="price<?php echo $i; ?>" value="<?php echo $qr['rateperunit'];?>"  readonly=true; style="text-align:center; background:none; border:0px"/>
</td>
<td width="10px">&nbsp;</td>



<td>

<input size="8" type="text" name="taxamount[]" id="taxamount<?php echo $i; ?>" value="<?php echo $qr['taxamount']; ?><?php if($qr['taxie']=="Include"){ echo "(-)"; }?>"  style="text-align:center; background:none; border:0px;" readonly="true"/>
</td>
<td width="10px">&nbsp;</td>


<td>

<input size="6" type="text" name="freightamount[]" id="freightamount<?php echo $i; ?>" value="<?php echo $qr['freightamount']; ?>"  style="text-align:center;background:none; border:0px;" readonly="true"/>
</td>
<td width="10px">&nbsp;</td>

<td>

<input size="6" type="text" name="discountamount[]" id="discountamount<?php echo $i; ?>" value="<?php echo $qr['discountamount']; ?><?php if($qr['discountamount']!=""){ echo "(-)";   }?>"   style="text-align:right;background:none; border:0px;" readonly="true"/>
</td>
<td width="10px">&nbsp;</td>


<td>
<input size="10" type="text" name="amount[]" style="background:none;border:none;text-align:right" id="amount<?php echo $i; ?>" value="<?php echo $qr['receivedquantity'] * $qr['rateperunit']; ?>"/>&nbsp;&nbsp;&nbsp;
<input type="hidden" id="totalamount" value="<?php echo $qr['receivedquantity'] * $qr['rateperunit']; ?>" />
</td>
<input type="hidden" id="rateperunit<?php echo $i; ?>" name="rateperunit[]" value="<?php echo $qr['rateperunit']; ?>" />
<td width="10px">&nbsp;</td>
<td>
<input readonly size="12" type="text" style="background:none;border:none;text-align:right" name="warehouse[]" id="warehouse<?php echo $i; ?>" value="<?php echo $warehouse ?>" /></td>

</tr>

<tr height="5px"></tr>
<?php } ?>
</table>
<br />
<br />
<br />

<table align="center" cellpadding="10" cellspacing="10">
<tr>
<td><strong>Narration&nbsp;</strong></td>
<td><textarea name="narr" id="narr" rows="3" cols="40"></textarea></td>
</tr>
</table>
<br>
<br>
<center>

<input type="submit" id="save" value="Save" />&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchasereturn';"/>
<input type="hidden" name="warehouse1111" id="warehouse" value="<?php echo $warehouse; ?>" />
</center>
</form>

<script type="text/javascript">

var index="<?php echo $index;?>";


function getpre()
{
  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var preincr = new Array();
    var pre = ""; 
  <?php 
    
   $query1 = "SELECT MAX(preincr) as preincr,m,y FROM pp_purchasereturn GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     preincr[<?php echo $k; ?>] = <?php if($row1['preincr'] < 0) { echo 0; } else { echo $row1['preincr']; } ?>;

<?php $k++; } ?>

for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(preincr[l] < 10)
     pre = 'PRE'+'-'+m+y+'-000'+parseInt(preincr[l]+1);
   else if(preincr[l] < 100 && preincr[l] >= 10)
     pre = 'PRE'+'-'+m+y+'-00'+parseInt(preincr[l]+1);
   else
     pre = 'PRE'+'-'+m+y+'-0'+parseInt(preincr[l]+1);
     document.getElementById('preincr').value = parseInt(preincr[l] + 1);
  break;
  }
 else
  {
   pre = 'PRE'+'-'+m+y+'-000'+parseInt(1);
   document.getElementById('preincr').value = 1;
  }
}
document.getElementById('pre').value = pre;
document.getElementById('m').value = m;
document.getElementById('y').value =y;

}




function checkstatus()
{
	for($j = 0; j < index; j++) {
	if(document.getElementById('returnquantity'+j).value == "" || document.getElementById('returnquantity'+j).value == "0")
	{
		alert("Please Enter Return Quantity");
		document.getElementById('returnquantity'+j).focus();
		return false;
	}
	 } 

 for(j = 0; j < index;j++) {
	if(document.getElementById('wastage'+j).value == "")
	{
		alert("Please select Goods Status");
		document.getElementById('wastage'+j).focus();
		return false;
	}
 }

	
return true;
}
function checkquantity(i)
{
	if(document.getElementById("returnquantity" + i).value == "")
	{
		document.getElementById("returnquantity" + i).value = 0;
	}
	
	if(parseFloat(document.getElementById("returnquantity" + i).value) > parseFloat(document.getElementById("purchasedquantity" + i).value))
	{
		alert("Return Quantity should be less than or equal to Purchased Quantity");
		document.getElementById("returnquantity" + i).value = 0;
	}
	
}


function loadpage()
{
	var vendor = document.getElementById('vendor').value;
	var sobi = document.getElementById('sobi').value;
	document.location = "dashboardsub.php?page=pp_addpurchasereturn&vendor="+vendor + "&sobi=" + sobi;
}

</script>


<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_p_addpurchasereturn.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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