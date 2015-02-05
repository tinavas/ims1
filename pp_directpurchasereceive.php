<?php 
include "jquery.php"; 
include "config.php";
include "getemployee.php";

$cnt = 1;
$invoice = $_GET['id'];
$query1 = "SELECT * FROM pp_sobi where so = '$invoice' order by id";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
 $datemain = date("d.m.Y",strtotime($row1['date']));
 $billdate = date("d.m.Y",strtotime($row1['billdate']));
 $vendor = $row1['vendor'];
 $bkinvoice = $row1['invoice'];
  $basicamt = $row1['totalamount'];
  $freightamount = $row1['freightamount'];
  $totaldiscountamount =$totaldiscountamount+ $row1['discountamount'];
  $freighttype = $row1['freighttype'];
  $cashbankcode = $row1['cashbankcode'];
  $coa = $row1['coa'];
  $brokerageamount = $row1['brokerageamount'];
  $cno=$row1['cno'];
  $grandtotal = $row1['grandtotal'];
  $viaf = $row1['viaf'];
  $broker = $row1['broker'];
  $vehicle = $row1['vno'];
  $driver = $row1['driver'];
  $m = $row1['m'];
  $y = $row1['y'];
  $sobiincr = $row1['sobiincr'];
  $remarks=$row1['remarks'];
  $flag = $row1['flag'];
  $conversion = 1;
  $cterm = $row1['credittermvalue'];
  $empname=$row1['empname'];
  
 
}

$totalprice = $basicamt -$totaldiscountamount;


$i=0;




?>

<link href="editor/sample.css" rel="stylesheet" type="text/css"/>
<center>

<section class="grid_8">
  <div class="block-border">

 <form class="block-content form" id="complex_form" method="post" onsubmit="return checkcoa();" action="pp_acceptdirectpurchase.php">

  
		<input type="hidden" name="sobi" id="sobi" value="<?php echo $invoice; ?>"/>
		

	  <h1>Direct Purchase Receive</h1>
		<br />

		<b>Direct Purchase Receive</b>

<br />


		<br />
		
		<br />

            <table align="center">
		
              <tr>
             
                <td><strong>Date</strong></td>
                <td>&nbsp;
               <input class="datepicker" type="text" size="15" id="date" readonly="readonly" name="date" value="<?php echo date('d.m.Y'); ?>"  onchange="chkdt(this.value)" /></td>
               <td width="5px"></td>

                <td><strong>Invoice Date</strong></td>
                <td>&nbsp;
					<?php  echo $datemain; ?>
			</td>
                <td width="5px"></td>

                <td><strong>Vendor</strong></td>
                <td>&nbsp;
					<?php  echo $vendor; ?>
			</td>
                <td width="5px"></td>

                <td><strong>Invoice</strong></td>
                <td width="15px"></td>
                <td>&nbsp;<?php echo $invoice; ?></td>
				
				<td width="5px"></td>
				
                <td><strong>Book&nbsp;Invoice</strong></td>
				<td width="5px"></td>
                <td>&nbsp;
					<?php echo $bkinvoice; ?>
                <td width="5px"></td>
           
              </tr>
            </table>
<br /><br />			

 <table border="0" id="table-po" align="center">
     <tr>
<th><strong>Category</strong></th><td width="10px">&nbsp;</td>
<th><strong>Code</strong></th><td width="10px">&nbsp;</td>
<th><strong>Description</strong></th><td width="10px">&nbsp;</td>
<th><strong>Units</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty Sent</strong></th><td width="10px">&nbsp;</td>
<th><strong>Qty Received</strong></th><td width="10px">&nbsp;</td>

<th><strong>Price<br />/Unit</strong></th><td width="10px">&nbsp;</td>
<th >&nbsp;&nbsp;&nbsp;<strong>Tax</strong></th><td width="10px">&nbsp;</td>

<th >&nbsp;&nbsp;&nbsp;<strong>Discount</strong></th><td  width="10px">&nbsp;</td>
<th><strong>Deliver Location</strong></th>
     </tr>

     <tr style="height:10px"></tr>
<?php $i=0;

$q = "select * from pp_sobi where so = '$invoice' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$i++;
	  $q1 = "select cat from ims_itemcodes where code = '$qr[code]' order by id ";
	$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	while($qr1 = mysql_fetch_assoc($qrs1))
	{
	  $cat1 = $qr1['cat'];
	}
	 ?>
     <tr>
 
       <td style="text-align:left;"><?php  echo $cat1;?> </td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<?php echo $qr['code']; ?>  </td>
<td width="10px">&nbsp;</td><td>

 <?php  echo $qr['code']; ?>
</td>
<td width="10px">&nbsp;</td><td>
<?php echo $qr['itemunits']; ?>
</td>
<td width="10px">&nbsp;</td><td>
<?php echo $qr['sentquantity']; ?>
</td>
<td width="10px">&nbsp;</td><td>
<?php  echo $qr['receivedquantity']; ?>
</td>





<td width="10px">&nbsp;</td><td>
<?php   echo ($qr['rateperunit'] / $conversion); ?>
</td>
<td width="10px">&nbsp;</td><td >

     <?php 
	    echo $qr['taxcode'];
		 
     ?>
	        

</td>


 <td  width="10px">&nbsp;</td><td> 
<?php echo $qr['discountamount'];?>

		  </td>

 <td  width="10px">&nbsp;</td><td>
 <?php echo $qr['warehouse']; ?> 
<input type="hidden" id="taxamount@<?php echo $i; ?>" name="taxamount[]" value="<?php echo $qr['taxamount'];?>" />
    <input type="hidden" name="discountamount[]" id="discountamount@<?php echo $i; ?>" value="<?php echo $qr['discountamount'];?>" />

</td>

    </tr>

	 <?php }
	?>
   </table>
   <br /> 
 
<br />	

		

<table border="1" align="center">
   
  <tr style="height:20px"></tr>
   <tr>
   <?php if($freightamount>0){?>
       <td align="right"><strong>Freight</strong>&nbsp;&nbsp;&nbsp;</td>
       <td align="left"><?php echo $freighttype; ?> </td>

       <td align="right"><strong>Freight Amount</strong>&nbsp;&nbsp;&nbsp;</td>
	   
       <td align="left">
	   <?php echo ($freightamount/$conversion); ?>
	   
	   &nbsp;&nbsp;</td>
	   
	    <td id="coavisible"<?php if($freighttype == "Included"){?> style="visibility:hidden" <?php  } ?> >
		
	   <?php echo $coa; ?> 
	 
	     </td>
	   <?php }?>
       </tr>
	   
       
  <tr style="height:20px"></tr>
<tr>
	  <td align="right"><strong>&nbsp;Grand&nbsp;Total</strong>&nbsp;&nbsp;</td>
        <td align="left"><input type="text" size="12" name="tpayment" id="tpayment" value="<?php echo ($grandtotal/$conversion); ?>" readonly style="text-align:right; background:none; border:0px;"/></td>
</tr>
</table>


<br>	
	
<br />
<?php if($remarks!='')
{?>
<table align="center">
<tr>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<?php echo $remarks; ?>
</td>
</tr>
</table><?php }?>

<br />

   <br /> 
   <center>
   <input type="submit" value="Accept" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_directpurchase';">

</center>
<br />
<br />

</form>
</div>
</section></center>



<script type="text/javascript">
function chkdt(val)
{
var cdt=val.split('.');
var rdt=cdt[2]+"/"+cdt[1]+"/"+cdt[0];
var dd1t="<?php echo $datemain;?>";
var ddt=ddt.split(".");
var ddt2=ddt[2]+"/"+ddt[1]+"/"+ddt[0];

if(rdt.getTime() < ddt2.getTime())
{
alert("Received date should be greater than or equal to Invoice Date");
document.getElementById().value="<?php echo date('d.m.Y');?>";
}

}
function script1() {
window.open('P2PHelp/help_t_editdirectpurchase.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

