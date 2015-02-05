<html>
<body>
<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>
</head>
<body>
<center>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br /><br />");
</script>
<?php include "getemployee.php"; ?>
<table align="center">
<tr>
<td style="width:70px;" align="center"><strong>Date</strong></td>
<td style="width:70px;" align="center"><strong>Customer</strong></td>
<td style="width:100px;" align="center"><strong>Birds</strong></td>
<td style="width:100px;" align="center"><strong>Weight</strong></td>
<td style="width:100px;" align="center"><strong>Rate/Kg</strong></td>
<td style="width:100px;" align="center"><strong>Amount</strong></td>
</tr>
<?php
           include "config.php";
		   if($_SESSION['db'] == 'souza')
			{
		  $query = "SELECT * FROM broiler_shopreceipt where farm = '$_GET[farmer]' and date between '$_GET[flockstartdate]' and '$_GET[nextflockstartdate]' ORDER BY date ASC "; 
			}
		   else
		   {
		  $query = "SELECT * FROM oc_cobi where farm = '$_GET[farmer]' and date between '$_GET[flockstartdate]' and '$_GET[nextflockstartdate]' ORDER BY date ASC ";     
		   }
           $result = mysql_query($query,$conn);
           while($row1 = mysql_fetch_assoc($result))
               {
			  if($_SESSION['db'] == 'souza')
			{
			$customer = $row1['shop'];
			}
			else
			{
			$customer = $row1['party'];
			}
			$birds = $row1['birds'];
			$weight = $row1['weight'];
			$price = $row1['price'];
			$amount = $weight * $price;
			
?>

<tr>
 <td align="center">&nbsp;<?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
 <td align="center">&nbsp;<?php echo $customer; ?></td>
 <td align="center">&nbsp;<?php echo changequantity($birds); $totbirds = $totbirds + $birds;?></td>
 <td align="center" >&nbsp;<?php echo changeprice($weight); ?></td>
 <td align="center" >&nbsp;<?php echo changeprice($price); ?></td>
  <td align="center">&nbsp;<?php echo changeprice($amount); $totamount = $totamount + $amount;?></td>

</tr>

<?php } ?>
<tr>
<td colspan="5"><hr /></td>
</tr>

<tr>
<td style="width:70px;" align="center"></td>
<td style="width:150px;" align="right"><strong>Total Quantity</strong></td>
<td style="width:40px;" align="right"><?php echo changequantity($totbirds); ?></td>
<td style="width:50px;" align="right"><strong>Amount</strong></td>
<td style="width:70px;" align="right"><?php echo changeprice($totamount); ?></td>
</tr>

</table>

