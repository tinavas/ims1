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
<td style="width:70px;" align="center"><strong>From Warehouse</strong></td>
<td style="width:100px;" align="center"><strong>To Warehouse</strong></td>
<td style="width:100px;" align="center"><strong>Quantity Sent</strong></td>
</tr>

<?php
           include "config.php";
		   
		   if($_SESSION['db']=="maharashtra")
		    $query = "SELECT * FROM ims_stocktransfer WHERE towarehouse = '$_GET[farmer]' and cat = 'Broiler Feed' and client = '$client' and aflock='$_GET[flock]'" ;
		   
     else   $query = "SELECT * FROM ims_stocktransfer WHERE towarehouse = '$_GET[farmer]' and cat = 'Broiler Feed' and date > '$_GET[pvflockculldate]' and date <= '$_GET[culldate]' and client = '$client' and aflock='$_GET[flock]'" ;
           $result = mysql_query($query,$conn);
           while($row1 = mysql_fetch_assoc($result))
               {
			  
                
 $fromwh = $row1['fromwarehouse'];
 $twh = $row1['towarehouse'];
 $quant = $row1['quantity'];
?>

<tr>
 <td align="center">&nbsp;<?php echo date("d.m.Y",strtotime($row1['date'])); ?></td>
 <td align="center">&nbsp;<?php echo $fromwh; ?></td>
 <td align="center">&nbsp;<?php echo $twh;?></td>
 <td align="center" >&nbsp;<?php echo changeprice($quant); $totquant = $totquant + $quant; ?></td>


</tr>

<?php } ?>
<tr>
<td colspan="5"><hr /></td>
</tr>

<tr>
<td style="width:70px;" align="center"></td>
<td style="width:50px;" align="right">&nbsp;</strong></td>

<td style="width:50px;" align="right"><strong>Total Quantity</strong></td>
<td style="width:70px;" align="right"><?php echo changeprice($totquant); ?></td>
</tr>
</table>