<?php 
include "config.php"; 
include "jquery.php";

if(!isset($_GET['date']))
$date = date("d.m.Y");
else
$date = $_GET['date'];

if(!isset($_GET['vendor']))
$vendor = "";
else
$vendor = $_GET['vendor'];




$vb1d = "Vendor";



if(!isset($_GET['gr']))
$gr = "''";
else
{
$gr = $_GET['gr'];
$gr = "'".str_replace(',',"','",$gr) . "'";
}

if(!isset($_GET['inv']))
$inv = "";
else
$inv = $_GET['inv'];


  $date1 = date("d.m.o");
   $strdot1 = explode('.',$date1);
   $ignore = $strdot1[0];
   $m = $strdot1[1];
   $y = substr($strdot1[2],2,4);
    
  include "config.php"; 
   $query1 = "SELECT MAX(sobiincr) as piincr FROM pp_sobi  where m = '$m' AND y = '$y' ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $piincr = 0;
   while($row1 = mysql_fetch_assoc($result1))
   {
	 $piincr = $row1['piincr'];
   }
   $piincr = $piincr + 1;

if ($piincr < 10)
    $pi = 'SOBI-'.$m.$y.'-000'.$piincr;
else if($piincr < 100 && $piincr >= 10)
    $pi = 'SOBI-'.$m.$y.'-00'.$piincr;
else
   $pi = 'SOBI-'.$m.$y.'-0'.$piincr;
   
   
   $i=0;
		       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")
$q = "select vendor,group_concat(distinct(gr)) as gr from pp_goodsreceipt where sobiflag=0 and aflag=1 group by vendor"; 

else
$q = "select vendor,group_concat(distinct(gr)) as gr from pp_goodsreceipt where sobiflag=0 and aflag=1 and warehouse in ($sectorlist)group by vendor";

$result=mysql_query($q,$conn);
while($row=mysql_fetch_array($result))
{
$vengr[$i]=array("vendor"=>"$row[vendor]","grs"=>"$row[gr]");
$i++;

}
   
   $vengr1=json_encode($vengr);
   
   ?>

<script type="text/javascript">

var vengr=<?php echo $vengr1;?>;
</script>


<br />



<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form1" method="post" action="pp_savesobi.php" onsubmit="return checkform();">
	  <h1 id="title1">SOBI Invoice</h1>
		
  
<br />
<b>SOBI Invoice</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />


<input type="hidden" name="m" id="m" value="<?php echo $m; ?>" />
<input type="hidden" name="y" id="y" value="<?php echo $y; ?>" />
<input type="hidden" name="piincr" id="piincr" value="<?php echo $piincr; ?>" />
<table align="center" border="0">
<tr>
<td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="date" name="date" value="<?php echo $date; ?>" onchange="getsobi();" size="11" class="datepicker"/>&nbsp;</td>
<td><strong>SOBI</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" style="background:none;border:none" size="16"  id="so" name="so" value="<?php echo $pi; ?>" readonly/>&nbsp;</td>
<td><strong>Book Invoice</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="17"  id="invoice" name="invoice" onkeypress="return num(this.id,event.keyCode)" value="<?php echo $inv;?>" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td></td>
</tr>
</table>
<table align="center">
<tr>

  <td align="left">&nbsp;</td>
<td><strong><?php echo Vendor; ?></strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><select id="vendor" name="vendor" onchange=" getgoods(this.value);" style="width:150px"><option value="">-Select-</option>
<?php
for($i=0;$i<count($vengr);$i++)
{
?>
<option value="<?php echo $vengr[$i]["vendor"]; ?>"  <?php if($vengr[$i]["vendor"]== $vendor) { ?> selected="selected" <?php } ?>><?php echo $vengr[$i]["vendor"]; ?></option>
<?php } ?>

</select>&nbsp;</td>



<td><strong>Goods Receipt #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td><select id="gr" name="gr" onchange="fun();" style="width:120px" multiple="multiple"><option value="" disabled="disabled">-Select-</option>
<?php
for($i=0;$i<count($vengr);$i++)
{
if($vengr[$i]["vendor"]==$vendor)
{
$gr1=explode(",",$vengr[$i]["grs"]);
for($k=0;$k<count($gr1);$k++)
{
?>
<option value="<?php echo $gr1[$k]; ?>"  <?php if ($gr1[$k]==$gr) { ?> selected="selected" <?php } ?>><?php echo $gr1[$k]; ?></option>
<?php  }} }?>



</select>&nbsp;</td>

</tr>
</table>




<br />
<br />
<?php if($gr != "" && $vendor != "") { ?>
<table align="center" border="0">

<tr>



<th><strong>GR No.</strong></th>

<th width="10px"></th>

<th><strong>Code</strong></th>

<th width="10px"></th>

<th><strong>Description</strong></th>


<th width="10px"></th>

<th><strong> Quantity</strong></th>

<th width="10px"></th>

<th><strong>Price</strong></th>

<th width="10px"></th>


<th><strong>Tax Type</strong></th>

<th width="10px"></th>

<th><strong>Tax Amount</strong></th>

<th width="10px"></th>

<th><strong>Freight Type</strong></th>

<th width="10px"></th>

<th><strong>Freight Amount</strong></th>

<th width="10px"></th>

<th><strong>Discount</strong></th>

<th width="10px"></th>

<th><strong>Total</strong></th>

<th width="10px"></th>

</tr>

<tr style="height:20px"></tr>
<?php 	$i = 1;
		$sum = 0;
		
		$q = "select * from pp_goodsreceipt where gr IN ($gr) and vendor ='$vendor'  and aflag = '1' and sobiflag = '0' order by gr,code";
		
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<tr>


<td><input style="background:none;border:none;text-align:right"type="text" id="grs<?php echo $i; ?>" size="13" name="grs[]" value="<?php echo $qr['gr']; ?>" readonly/></td>
<td width="10px"></td>

<td><input style="background:none;border:none;text-align:center" type="text" id="code<?php echo $i; ?>" size="8" name="code[]" value="<?php echo $qr['code']; ?>" readonly/></td>
<td width="10px"></td>

<td><input style="background:none;border:none;text-align:center" type="text" id="description<?php echo $i; ?>" size="13" name="description[]" value="<?php echo $qr['description']; ?>" readonly/></td>



<td width="10px"></td>

<td><input  style="border:none;background:none;text-align:center" type="text" id="receivedquantity<?php echo $i; ?>" size="8" name="receivedquantity[]"  value="<?php echo $qr['acceptedquantity']; ?>"  readonly/></td>



<td width="10px"></td>

<td><input style="border:none;background:none;text-align:center" type="text" id="rateperunit<?php echo $i; ?>" size="8" name="rateperunit[]" value="<?php echo $qr['rateperunit']; ?>" readonly/></td>

<td width="10px"></td>


<td><input type="text" id="taxtype<?php echo $i;?>" title="<?php echo $qr['taxie'];?>" style="background:none;border:none;text-align:center" name="taxtype[]" size="6" <?php if($qr['taxie']!="") {?>value="<?php echo $qr['taxie'];?>" <?php } else {?> None value="" <?php   }?> readonly="true" /></td>
<td width="10px"></td>

<td><input type="text" id="taxamount<?php echo $i; ?>" size="8" name="taxamount[]" <?php if($qr['taxamount'] <> ""){?> value="<?php echo round($qr['taxamount'],2); ?>" <?php } else {?> value="0" <?php  } ?> readonly="true"  style="background:none;border:none;text-align:center;" />   </td>

<td width="10px"></td>

<td><input type="text" id="fritype<?php echo $i;?>" title="<?php echo $qr['freightie'];?>" style="background:none;border:none;text-align:center" name="fritype[]" size="15" <?php if($qr['freightie']!="") {?>value="<?php echo $qr['freightie'];?>" <?php } else {?> None value="" <?php   }?> readonly="true" /></td>
<td width="10px"></td>

<td>

<input type="text" style="background:none;border:none;text-align:center;" id="freightamount<?php echo $i; ?>" size="8" name="freightamount[]"  <?php if($qr['freightamount'] <> ""){?> value="<?php echo round($qr['freightamount'],2); ?>" <?php } else {?> value="0" <?php  } ?>/></td>

<td width="10px"></td>
 
<td><input type="text" style="background:none;border:none;text-align:center"id="discountamount<?php echo $i; ?>" size="10" name="discountamount[]" value="<?php echo $qr['discountamount']; ?>" readonly/></td>

<td width="10px"></td>

<?php 
$tot = ($qr['receivedquantity'] * $qr['rateperunit'])-$qr['discountamount'];; ?>
<?php 


$qr['taxamount'] =round($qr['taxamount'],2); 

$qr['freightamount'] =round($qr['freightamount'],2);

 if($qr['taxie']=="Include")
{
$tot = $tot ;

}
else
{
$tot = $tot + $qr['taxamount'] ;

}


 if($qr['freightie']=="Exclude Paid By Supplier")
{
$tot = $tot+ $qr['freightamount'];

}

else

 if($qr['freightie']=="Exclude")
{
$tot = $tot;

}
else
{
$tot = $tot - $qr['freightamount'] ;

}

$tot=round($tot,2);

?>

<td><input style="border:none;background:none;text-align:center" type="text" id="totalamount<?php echo $i; ?>" size="10" name="totalamount[]" value="<?php echo round($tot,2); $sum+=$tot;  ?>" readonly/></td>

<td width="10px"></td>

</tr>

<input type="hidden" id="po<?php echo $i; ?>" name="po[]" value="<?php echo $qr['po']; ?>" />


<input type="hidden" id="ge<?php echo $i; ?>" name="ge[]" value="<?php echo $qr['ge']; ?>" />

<input type="hidden" id="tandccode<?php echo $i; ?>" name="tandccode[]" value="<?php echo $qr['tandccode']; ?>" />

<input type="hidden" id="tandc<?php echo $i; ?>" name="tandc[]" value="<?php echo $qr['tandc']; ?>"  />

<input type="hidden" id="credittermcode<?php echo $i; ?>" name="credittermcode[]" value="<?php echo $qr['credittermcode']; ?>" />

<input type="hidden" id="credittermdescription<?php echo $i; ?>" name=
"credittermdescription[]" value="<?php echo $qr['credittermdescription']; ?>" />

<input type="hidden" id="credittermvalue<?php echo $i; ?>" name="credittermvalue[]"
 value="<?php echo $qr['credittermvalue']; ?>" />

<input type="hidden" id="taxcode<?php echo $i; ?>" name="taxcode[]" value="<?php echo $qr['taxcode']; ?>" />

<input type="hidden" id="taxvalue<?php echo $i; ?>" name="taxvalue[]" value="<?php echo $qr['taxvalue']; ?>" />

<input type="hidden" id="taxformula<?php echo $i; ?>" name="taxformula[]" value="<?php echo $qr['taxformula']; ?>" />

<input type="hidden" id="taxie<?php echo $i; ?>" name="taxie[]" value="<?php echo $qr['taxie']; ?>" />

<input type="hidden" id="freightcode<?php echo $i; ?>" name="freightcode[]" value="<?php echo $qr['freightcode']; ?>" />

<input type="hidden" id="freightvalue<?php echo $i; ?>" name="freightvalue[]" value="<?php echo $qr['freightvalue']; ?>" />



<input type="hidden" id="freightie<?php echo $i; ?>" name="freightie[]" value="<?php echo $qr['freightie']; ?>" />



<input type="hidden" id="discountvalue<?php echo $i; ?>" name="discountvalue[]" value="<?php echo $qr['discountvalue']; ?>" />



<?php $i++; } ?>
<tr style="height:20px"></tr>
<tr>
<td colspan="20" align="right"><strong>Grand Total</strong></td>
<td><input style="border:none;background:none;text-align:right" type="text" id="grandtotal" size="10" name="grandtotal" value="<?php echo round($sum,2); ?>"readonly/></td>
</tr>
</table>
<br />
<table align="center">
<td style="vertical-align:middle;"><strong>Remarks&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>

<?php } ?>
<br/>
<input type="submit" value="Save" id="save" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_sobi';">
</form>
</div>
</section>
</center>

<script language="JavaScript" type="text/javascript">


function num(a,b)
{

	if(b<48 || b>57)
	{
	 	event.keyCode=false;
		return false;
	
		
	}
	
	

}



function fun()

{
	var grs = "";
	var date = document.getElementById('date').value;
	var vendor = document.getElementById('vendor').value;
	var gr = document.getElementById('gr');
	for(var i = 0; i<gr.options.length; i++)
	 if(gr.options[i].selected)
	   grs += gr.options[i].value + ",";	
	
	var inv = document.getElementById('invoice').value;
	
	document.location = "dashboardsub.php?page=pp_addsobi&gr=" + grs + "&vendor=" + vendor + "&inv=" + inv + "&date=" + date;
}

//Requesition Starts ///

function getsobi()
{
  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var piincr = new Array();
    var pr = "";
  <?php 
   include "config.php"; 
   $query1 = "SELECT MAX(sobiincr) as piincr,m,y FROM pp_sobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     piincr[<?php echo $k; ?>] = <?php echo $row1['piincr']; ?>;

<?php $k++; } ?>

for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(piincr[l] < 10)
     pr = 'SOBI'+'-'+m+y+'-000'+parseInt(piincr[l]+1);
   else if(piincr[1] < 100 && piincr[1] >= 10)
     pr = 'SOBI'+'-'+m+y+'-00'+parseInt(piincr[l]+1);
   else
     pr = 'SOBI'+'-'+m+y+'-0'+parseInt(piincr[l]+1);
  document.getElementById('piincr').value = parseInt(piincr[l] + 1);
  break;
  }
 else
  {
   pr = 'SOBI'+'-'+m+y+'-000'+parseInt(1);
     document.getElementById('piincr').value = 1;
  }
}
  document.getElementById('so').value = pr;
document.getElementById('m').value = m;
document.getElementById('y').value =y;
}

///Requisition Ends ///


function checkform()
{

var a= document.getElementById("invoice").value;
if(document.getElementById("invoice").value=="")
{
	alert("Enter invoice");
	return false;

}

<?php

$query="SELECT DISTINCT (
invoice
)
FROM `pp_sobi` 
";
$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{
?>
if(a=="<?php echo $row['invoice'];?>")
{
alert("Book invoice already exists");
return false;
}

<?php
}


?>
document.getElementById('save').disabled=true;


}



function getgoods(vb)
{

document.getElementById("gr").options.length=1;
   myselect1 = document.getElementById("gr");			 
  
  var x= document.getElementById('vendor').value; 
	  for(i=0;i<vengr.length;i++)
	  {
	  if(vengr[i].vendor == x)
		{
			var grno=vengr[i].grs.split(",");
					for(j=0;j<grno.length;j++)
					{ 
					
					var op1=new Option(grno[j],grno[j]);
					
					myselect1.options.add(op1);
					}
		}
	  }



}



</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_addSOinv.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
