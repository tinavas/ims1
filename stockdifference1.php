<html>
<body>
<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php";
include "getemployee.php"; 
$fdatedump = $_GET['fromdate'];

$tdatedump = $_GET['todate'];
$warehouse=$_GET['warehouse'];

$fdate = date("Y-m-j", strtotime($fdatedump));


$tdate = date("Y-m-j", strtotime($tdatedump));

  
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
 <form method="get" >
<?php

?>
<table align="center" border="0">

<tr>

<td colspan="2" align="center"><strong><font color="#3e3276">Stock Difference Report</font></strong></td>

</tr>

<tr>

<td colspan="2" align="center"><strong><font color="#3e3276">Item Code&nbsp;<?php echo $_GET['code']; ?></font></strong></td>

</tr>

<tr>

<td colspan="2" align="center"><strong><font color="#3e3276">Description&nbsp;<?php echo $_GET['description']; ?></font></strong></td>

</tr>
<tr>
<?php
$qu="select distinct(sunits) from ims_itemcodes where code='$_GET[code]' and description='$_GET[description]'";
$res=mysql_query($qu);
$r=mysql_fetch_assoc($res);
?>
<td colspan="2" align="center"><strong><font color="#3e3276">Unit&nbsp;<?php  echo $r['sunits']; ?></font></strong></td>
</tr>
<tr>

<td colspan="2" align="center"><strong><font color="#3e3276">Warehouse&nbsp;<?php echo $_GET['warehouse']; ?></font></strong></td>

</tr>

<tr>

<td colspan="2" align="center"><font size="2">From Date&nbsp;<?php echo $fdatedump; ?>

                To Date &nbsp;<?php echo $tdatedump;?></font></td>

</tr>

</table>
<?php
 

?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {
	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;
<a href="salesidentification.php?export=html&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Printer Friendly</a>
&nbsp;&nbsp;
<a href="salesidentification.php?export=excel&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Export to Excel</a>
&nbsp;&nbsp;
<a href="salesidentification.php?export=word&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="salesidentification.php?cmd=reset&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Reset All Filters</a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">

<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
 
<table align="center">
  
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">

<table class="ewTable ewTableSeparate" cellspacing="0" align="center" border="2" >

<thead>

	<tr>
 

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewRptGrpHeader2">

		Item Code

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Item Code</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		I.Quantity

		</td>

<?php } else { ?>

		<td class="ewTableHeader" >

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td colspan="3">I.Quantity</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		S.Quantity

		</td>

<?php } else { ?>

		<td class="ewTableHeader" >

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td colspan="3">S.Quantity</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Q.Difference

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td >Q.Difference</td>

			</tr></table>

		</td>

<?php } ?>


<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewRptGrpHeader3">

		Item Ledger Closing

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Item Ledger Closing</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Stock Report Closing

		</td>

<?php } else { ?>

		<td class="ewTableHeader" >

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td colspan="3">Stock Report Closing</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" colspan="3">

		Difference

		</td>

<?php } else { ?>

		<td class="ewTableHeader" colspan="3">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td colspan="3">Difference</td>

			</tr></table>

		</td>

<?php } ?>
       </tr>
       </thead>
	   <tbody>
	 
<?php
{ 
  
  $q11 = "select code,description,sunits from ims_itemcodes order by code  ";
$qrs11 = mysql_query($q11,$conn1) or die(mysql_error());

	 $num = mysql_num_rows($qrs11);

	while($qr11 = mysql_fetch_assoc($qrs11))

	{

	 $code = $qr11['code'];
  $preissueqty = 0;

$prercvqty = 0;

$preissueval = 0;

$prercvval = 0;

$obqty = 0;

$obqty1 = 0;

$obval = 0;

$oflag = "Dr";

$obal = 0;

include "config.php";



$itemcode = "";



$q = "select * from ims_itemcodes where code  = '$code'  ";

	$qrs = mysql_query($q,$conn1) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs))

	{

	   $itemcode = $qr['iac'];

	}

 $getop = "SELECT * FROM tbl_sector WHERE type = '$warehouse'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $feedmill = $rowop['sector'];

  }

	//Issues

$q = "select sum(quantity) as quantity,sum(amount) as amount from ac_financialpostings where crdr = 'Cr' and itemcode  = '$code' and coacode = '$itemcode' and date < '$fdate' and (warehouse='$warehouse' or warehouse = '$feedmill') order by date,id ";

	$qrs = mysql_query($q,$conn1) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs))

	{
		
		 $preissueval = $preissueval + $qr['amount'];
		 $preissueqty = $preissueqty + $qr['quantity'];
	}


    // Receipts 

  $q = "select sum(amount) as amount,sum(quantity) as quantity from ac_financialpostings where itemcode  = '$code' and crdr = 'Dr' and coacode = '$itemcode' and date < '$fdate' and (warehouse='$warehouse' or warehouse = '$feedmill') order by date,id ";

	$qrs = mysql_query($q,$conn1) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs))

	{

	 

	     $prercvqty = $prercvqty + $qr['quantity'];

		 $prercvval = $prercvval + $qr['amount'];

	  

	}



    // echo $prercvqty."/".$prercvval;



	$obqty = $prercvqty -  $preissueqty;
	
		$obval = $prercvval-$preissueval ;
		
	
	$obqty1 = $prercvqty;

	

	 ?>

	
 

 

	<?php

	$rcvqty = 0;

	$rcvval = 0;

	$isqty = 0;

	$isval = 0;
	
	$dis=0;

	 include "config.php";

    $query1 = "SELECT type,trnum,date,quantity,amount,crdr from ac_financialpostings where itemcode = '$code' and coacode = '$itemcode'  and date >= '$fdate' and date <= '$tdate' and (warehouse='$warehouse' or warehouse = '$feedmill')  order by date,id ";

      $result1 = mysql_query($query1,$conn1);

	   while($row2 = mysql_fetch_assoc($result1))

      {

	  

	  $dumfrmdate = $row2['date'];

	  if($row2['type'] == 'STA')

	   $type = 'Stock Adjustment';

	  elseif($row2['type'] == 'IR')

	   $type = 'Intermediate Receipt';

	  elseif($row2['type'] == 'II')

	   $type = 'Intermediate Issue';

	  elseif($row2['type'] == 'TR')

	   $type = 'Stock Transfer';

	  elseif($row2['type'] == 'GR')

	   $type = 'Goods-Receipt'; 

	  else

	   $type = $row2['type'];
	   
	    if ( $row2['crdr'] == "Dr"    ) { $rcvval = $rcvval + $row2['amount']; }
if ( $row2['crdr'] == "Dr"    ) { $rcvqty = $rcvqty + $row2['quantity']; }
		    

  if ( $row2['crdr'] == "Cr"  ) { $isqty = $isqty + $row2['quantity']; }  

 
  if ( $row2['crdr'] == "Cr"   ) {$isval = $isval + $row2['amount']; } 

  $r1=0;$clb1=0; 

    

	   
	   } 
	   
	$clb1=$obqty + $rcvqty - $isqty;   
	 
	  $getop = "SELECT SUM(receivedquantity) as quantity FROM pp_sobi WHERE code = '$code' and flag = 1 AND date < '$fdate' and (warehouse='$warehouse' or warehouse = '$feedmill') AND dflag = '0'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $purchasedop = $rowop['quantity'];

  }

  if($purchasedop == "") $purchasedop = 0;

  

  $getop = "SELECT SUM(receivedquantity) as quantity FROM pp_goodsreceipt WHERE code = '$code' and aflag = 1 AND date < '$fdate' and po in (select distinct(po) from pp_purchaseorder where deliverylocation='$warehouse') and warehouse='$warehouse'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $grop = $rowop['quantity'];


  }

  if($grop == "") $grop = 0;
 $getop = "SELECT SUM(quantity) as quantity FROM oc_cobi WHERE code = '$code' and flag = 1 AND date < '$fdate' AND (warehouse='$warehouse')";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $salesop = $rowop['quantity'];

  }

  if($salesop == "") $salesop = 0;

  

   $salesreturnop = 0;

   $getop = "SELECT SUM(quantity) as quantity FROM oc_salesreturn WHERE code = '$code' AND type ='addtostock' and cobi in (select distinct(invoice) from oc_cobi where warehouse='$warehouse') AND date < '$fdate'";

  $result = mysql_query($get,$conn1);

  while($row = mysql_fetch_assoc($result))

  {

   $salesreturnop= $row['quantity'];

  }

  if($salesreturnop == "") $salesreturnop = 0;

  

   $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$code' AND date < '$fdate' AND warehouse ='$warehouse'  and riflag = 'R'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

    $irecop = $rowop['quantity'];

  }

  if($irecop == "") $irecop = 0;



$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date < '$fdate' AND unit ='$warehouse'  and type = 'Add'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $staadd = $rowop['quantity'];

  }

  if($staadd == "") $staadd = 0;



$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date < '$fdate' AND unit ='$warehouse'  and type = 'Deduct'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $staded = $rowop['quantity'];

  }

  if($staded == "") $staded = 0;

 

   $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$code' AND date < '$fdate' AND warehouse='$warehouse' and riflag = 'I'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $iiscop = $rowop['quantity'];

  }

  if($iiscop == "") $iiscop = 0;
  
 

  

  
$preturn=0;
$getop = "SELECT SUM(returnquantity) as quantity FROM pp_purchasereturn WHERE code = '$code' AND date < '$fdate' and warehouse='$warehouse' and flag =1";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

  

   $preturn = $preturn + $rowop['quantity'];

  }

    $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date < '$fdate' and towarehouse= '$warehouse'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $stockto = $stockto + $rowop['quantity'];

  }

  //echo "stock to". $stockto;

  $stockfrom = 0;

 
   $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date < '$fdate' and fromwarehouse='$warehouse'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

  $stockfrom = $stockfrom + $rowop['quantity'];

  }
   $prod = 0;
/////////end of getting the OPENING////////

 $opening = $firstopening + $purchasedop  + $irecop + $staadd + $grop  + $stockto - ($consumedop + $preturn + $fuel1 + $opm + $opb + $salesop + $iiscop + $staded + $bcop + $bdeop + $stockfrom) + $salesreturnop + $prod;
 
 $fuel2=0;
 $get = "SELECT SUM(receivedquantity) as quantity FROM pp_sobi WHERE code = '$code' AND date >= '$fdate' and flag = 1 AND date <= '$tdate' AND warehouse='$warehouse' AND dflag = '0'";

  $result = mysql_query($get,$conn1);

  while($row = mysql_fetch_assoc($result))

  {

    $purchased = $row['quantity'];

  }
  
  
 
 $getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date >= '$fdate' AND  date <= '$tdate' and unit='$warehouse' and type = 'Add'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $purchased  =  $purchased + $rowop['quantity'];

  }



  $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$code' AND date >= '$fdate' AND  date <= '$tdate' and warehouse='$warehouse' and riflag = 'R'";

  

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   $purchased  =  $purchased + $rowop['quantity'];

  }

 $getop = "SELECT SUM(receivedquantity) as quantity FROM pp_goodsreceipt WHERE code = '$code' and aflag = 1 AND date >= '$fdate' AND date <= '$tdate' and po in (select distinct(po) from pp_purchaseorder where deliverylocation='$warehouse') and 
 warehouse ='$warehouse'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

    $purchased = $purchased + $rowop['quantity'];

  }
  $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date >= '$fdate' AND date <= '$tdate' and towarehouse='$warehouse'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

      $purchased = $purchased + $rowop['quantity'];

  }

  
  if($purchased == "") $purchased = 0;



//echo $purchased."<br>";
  
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date >= '$fdate' AND  date <= '$tdate' and unit='$warehouse' and type = 'Deduct'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

  $consumed  =  $consumed + $rowop['quantity'];

  }
  
  
 
 



   $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$code' AND date >= '$fdate' AND  date <= '$tdate' and warehouse='$warehouse' and riflag = 'I'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {


  

   $consumed = $consumed + $rowop['quantity'];

  }

  $getop = "SELECT SUM(returnquantity) as quantity FROM  pp_purchasereturn WHERE code = '$code' AND date >= '$fdate' AND  date <= '$tdate' and warehouse='$warehouse' and flag =1";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

  

   $consumed = $consumed + $rowop['quantity'];

  }


 $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date >= '$fdate' AND date <= '$tdate' and fromwarehouse='$warehouse'";

  $resultop = mysql_query($getop,$conn1);

  while($rowop = mysql_fetch_assoc($resultop))

  {

   
   $consumed = $consumed + $rowop['quantity'];

  }

$get = "SELECT SUM(quantity) as quantity FROM oc_cobi WHERE code = '$code' AND flag =1 and date >= '$fdate' AND date <= '$tdate' AND warehouse='$warehouse'";

  $result = mysql_query($get,$conn1);

  while($row = mysql_fetch_assoc($result))

  {

  $sales = $row['quantity'];

  }

  if($sales == "") $sales = 0;

  

  $salesreturn = 0;

   $get = "SELECT SUM(quantity) as quantity FROM oc_salesreturn WHERE code = '$code' AND type ='addtostock' and cobi in (select distinct(invoice) from oc_cobi where warehouse='$warehouse') AND date >= '$fdate' AND date <= '$tdate'";

  $result = mysql_query($get,$conn1);

  while($row = mysql_fetch_assoc($result))

  {

   $salesreturn= $row['quantity'];

  }

  if($salesreturn == "") $salesreturn = 0;


 $closing = $opening + $purchased - ($consumed + $sales) + $salesreturn;

if(( $opening  == 0) && ( $closing == 0) && ( $purchased== 0) && ($consumed == 0) )

{


}

else {

if($_GET['warehouse']<>"")
{
	$cond3=" and (warehouse = '$_GET[warehouse]' or warehouse = '$feedmill')";
	}
else
{ $cond3="";}
$qu1="SELECT `iac` FROM `ims_itemcodes` where `code`='$code' ";
$re1=mysql_query($qu1,$conn1);
$ro1=mysql_fetch_assoc($re1);
$cramt=0;
$dramt=0;
$drqty=0;

 
/*$qu="SELECT sum(amount) as amount,crdr FROM `ac_financialpostings` where `itemcode`= '$x_code' and `coacode`='$ro1[iac]' and date <= '$todate' $cond3 group by crdr ";
$re=mysql_query($qu,$conn1);
while($ro=mysql_fetch_assoc($re))
{
	if($ro['crdr']=="Cr")
	{
		$cramt=round($ro['amount'],2);
		
	}
	else
	{
		$dramt=round($ro['amount'],2);
		
	}
}*/
$cramt=0;
$dramt=0;
$qu="SELECT sum(amount) as amount,crdr FROM `ac_financialpostings` where `itemcode`= '$code' and `coacode`='$ro1[iac]' and date <= '$tdate' $cond3 group by crdr ";
$re=mysql_query($qu,$conn1);
while($ro=mysql_fetch_assoc($re))
{
	if($ro['crdr']=="Cr")
	{
		$cramt=round($ro['amount'],2);
		
	}
	else
	{
		$dramt=round($ro['amount'],2);
		
	}
}$crdramt=0;

$crdramt=$dramt-$cramt;

$rateperunit=round( ($crdramt/$closing) ,2);

}
$iquant=$rcvqty + $obqty - $isqty;
$r1=round((($obval + $rcvval - $isval)/($rcvqty + $obqty - $isqty)),2);
$itc=$obval + $rcvval - $isval; 
$stc=round(($closing*$rateperunit),2);  
$finalbal=$itc-$stc;
$qdiff=$clb1-$closing;
$finalbal1=changeprice($finalbal);

if($finalbal1!=0){

?>

	<tr>

		  
		
		 <td class="ewRptGrpField3">

		<?php echo $code; ?>

		</td>
	<td align="right"><?php echo ewrpt_ViewValue(changeprice($clb1));?></td>	
	<td align="right"><?php echo ewrpt_ViewValue(changeprice($closing));?></td>
	<td align="right"><?php echo ewrpt_ViewValue(changeprice($qdiff));?></td>	
<td align="right"><?php echo ewrpt_ViewValue(changeprice($obval + $rcvval - $isval));?></td>

<td style="text-align:right;">

			<?php echo changeprice(round(($closing*$rateperunit),2)); ?>

		</td>
		
	<td align="right" class="ewRptGrpField4">	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php   echo ewrpt_ViewValue(changeprice($itc-$stc));?></td>

	</tr>

<?php
	

	  // End detail records loop

$rate=0;$clb=0;
}
}


}
?>
</tbody>
<tfoot>
</tfoot>
</table>
</div>
</table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>

</form>
<?php //include "phprptinc/footer.php"; ?>
<?php } ?>
</body>
</html>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript">
//function reloadpage()
//{
//	var fdate = document.getElementById('fromdate').value;
//	var tdate = document.getElementById('todate').value;
//	document.location = "cstaff_list.php?fromdate=" + fdate + "&todate=" + tdate;
//}
$(function(){

    $('.datepicker').datepicker({
	     inline:true,
		 changeYear:true,
		 changeMonth:true,
		 numberofMonths:1,
		 dateFormat:'yy-mm-dd'
     
     });
});
function filter(a)
{
  var clas=document.getElementById(a).value;
    //alert(clas);
  document.location="examschedule_list.php?clas="+clas;

}
function send()
{
  var fdate=document.getElementById("fdate").value;
  var tdate=document.getElementById("tdate").value;
 // var wh1=document.getElementById("wh").value;
  var cat1=document.getElementById("cat").value;
 // var coa1=document.getElementById("coa").value;
  var code=document.getElementById("code").value;
  var desc=document.getElementById("desc").value;
  document.location="salesidentification.php?fdate="+fdate+"&tdate="+tdate+"&cat="+cat1+"&code="+code+"&desc="+desc;

}

 

function loadcodes(cat)
{
  var c=document.getElementById("code").options.length;
   
    for(var i=c;i>=0;i--)
    {
        document.getElementById("code").remove(i);
    }
 
    myselect1 = document.getElementById("code");
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	 

	<?php 
		$q = "SELECT distinct(code) from `pig_farm` order by code";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(cat == '$qr[code]') { ";
		$q1 = "select distinct(housecode) from pig_house where farmcode='$qr[code]' order by housecode";
		$q1rs = mysql_query($q1) or die(mysql_error());
		while($q1r = mysql_fetch_assoc($q1rs))
		{
		?>
	    theOption1=document.createElement("OPTION");
   	 	theText1=document.createTextNode("<?php echo $q1r['housecode']; ?>");
   		theOption1.appendChild(theText1);
		theOption1.value = "<?php echo $q1r['housecode']; ?>";
    	myselect1.appendChild(theOption1);
		<?php } 
		echo " } "; } ?>

}
 
 
</script>