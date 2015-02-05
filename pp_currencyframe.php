<?php
$temp = explode('@',$_GET['data']);
$ddate = $temp[0];
$date = date("Y-m-d",strtotime($ddate));
$vendor = $temp[1];
$type = $temp[2];
$conversion = $validate = 1;
include "config.php";
$query = "select currencyflag,currency from contactdetails where name = '$vendor' and type LIKE '%$type%'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$cflag = $rows['currencyflag'];
$currency = $rows['currency'];
if($cflag == 1)
{
 $query2 = "select id,rate from hr_conversion where '$date' between fromdate and todate and currency = '$currency'";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 $rows2 = mysql_num_rows($result2);
 $r2 = mysql_fetch_assoc($result2);
 $conversion = $r2['rate'];
 $id = $r2['id'];
 if($rows2 == 0)
 { $validate = 0;
?>
<center>
<table>
 <tr>
  <td><strong>Date</strong></td>
  <td width="10px"></td>
  <td><?php echo $ddate; ?></td>
  <td width="40px"></td>
  <td><strong>Name</strong></td>
  <td width="10px"></td>
  <td><?php echo $vendor; ?></td>
  <td width="40px"></td>
  <td><strong>Currency</strong></td>
  <td width="10px"></td>
  <td><?php echo $currency; ?></td>
 </tr>
</table>
<br>
 <tr>
  <td><font style='color:#FF0000'><?php echo "The Conversion rate for currency '$currency' for the date '$ddate' is not specified in the Currency Conversion section"; ?></font></td>
 </tr>
</center>
<?php
 }
}
?>
<input type="hidden" id="validate" value="<?php echo $validate; ?>" >
<input type="hidden" id="conversion" name="conversion" value="<?php echo $conversion; ?>">
<input type="hidden" id="edit" name="edit" value="yes">
<input type="hidden" id="currencyid" name="currencyid" value="<?php echo $id; ?>">